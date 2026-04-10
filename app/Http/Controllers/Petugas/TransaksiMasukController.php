<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\AreaParkir;
use App\Models\CameraSource;
use App\Models\Kendaraan;
use App\Models\LogAktivitas;
use App\Models\Tarif;
use App\Models\Transaksi;
use App\Support\VehicleTypeDisplay;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class TransaksiMasukController extends Controller
{
    private function tryFetchSingleJpegFromUrl(string $url): array
    {
        $startedAt = microtime(true);
        $maxBytes = 6 * 1024 * 1024; // 6MB
        $buffer = '';

        /** @var \Illuminate\Http\Client\Response $response */
        $response = Http::timeout(20)
            ->accept('image/*')
            ->withOptions(['stream' => true])
            ->get($url);

        if (! $response->successful()) {
            return ['ok' => false, 'error' => 'HTTP ' . $response->status(), 'bytes' => 0];
        }

        // If it's already an image response (snapshot endpoint), body() should be safe/finite.
        $contentType = strtolower((string) ($response->header('Content-Type') ?? ''));
        if (str_contains($contentType, 'image/')) {
            $bin = $response->body();
            if (is_string($bin) && $bin !== '') {
                return ['ok' => true, 'binary' => $bin, 'bytes' => strlen($bin), 'ms' => (int) round((microtime(true) - $startedAt) * 1000)];
            }
        }

        // For MJPEG streams, read until first JPEG frame found.
        $psr = $response->toPsrResponse();
        $stream = $psr->getBody();

        while (! $stream->eof() && strlen($buffer) < $maxBytes) {
            // keep total time bounded so we don't hang on slow streams
            if ((microtime(true) - $startedAt) > 8.0) break;

            $chunk = $stream->read(8192);
            if ($chunk === '' || $chunk === null) {
                usleep(15_000);
                continue;
            }

            $buffer .= $chunk;

            $start = strpos($buffer, "\xFF\xD8"); // SOI
            if ($start === false) continue;
            $end = strpos($buffer, "\xFF\xD9", $start); // EOI
            if ($end === false) continue;

            $jpeg = substr($buffer, $start, ($end - $start) + 2);
            if (is_string($jpeg) && $jpeg !== '') {
                return ['ok' => true, 'binary' => $jpeg, 'bytes' => strlen($jpeg), 'ms' => (int) round((microtime(true) - $startedAt) * 1000)];
            }
        }

        return ['ok' => false, 'error' => 'no_jpeg_frame', 'bytes' => strlen($buffer), 'ms' => (int) round((microtime(true) - $startedAt) * 1000)];
    }

    public function create(Request $request)
    {
        $areas = AreaParkir::query()
            ->withCount([
                'transaksi as aktif_count' => fn ($q) => $q->where('status', 'masuk'),
            ])
            ->orderBy('nama_area')
            ->get();
        $tarif = Tarif::pluck('tarif_per_jam', 'jenis_kendaraan');
        $latestDetection = Cache::get('latest_detection');
        $allowedJenis = VehicleTypeDisplay::allowedJenisFromTarif();
        $vehicleTypeOptions = VehicleTypeDisplay::optionsFromTarifs();
        $yoloVehicleTypeMap = VehicleTypeDisplay::yoloVehicleTypeMapForJs($allowedJenis);
        $jenisPrefill = null;
        if (is_array($latestDetection) && ! empty($latestDetection['vehicle_type'] ?? null)) {
            $jenisPrefill = VehicleTypeDisplay::mapYoloToAllowedJenis((string) $latestDetection['vehicle_type'], $allowedJenis);
        }

        return view('petugas.transaksi.masuk', [
            'areas' => $areas,
            'tarif' => $tarif,
            'latestDetection' => $latestDetection,
            'vehicleTypeOptions' => $vehicleTypeOptions,
            'yoloVehicleTypeMap' => $yoloVehicleTypeMap,
            'allowedJenisTarif' => $allowedJenis,
            'jenisPrefill' => $jenisPrefill,
        ]);
    }

    public function availability(Request $request): JsonResponse
    {
        $areas = AreaParkir::query()
            ->withCount([
                'transaksi as aktif_count' => fn ($q) => $q->where('status', 'masuk'),
            ])
            ->orderBy('nama_area')
            ->get(['id', 'nama_area', 'kapasitas']);

        $payload = $areas->map(function ($a) {
            $kapasitas = (int) ($a->kapasitas ?? 0);
            $aktif = (int) ($a->aktif_count ?? 0);

            return [
                'id' => $a->id,
                'nama_area' => $a->nama_area,
                'kapasitas' => $kapasitas,
                'aktif' => $aktif,
                'tersedia' => max(0, $kapasitas - $aktif),
            ];
        })->values();

        return response()->json([
            'success' => true,
            'data' => $payload,
            'timestamp' => now()->toIso8601String(),
        ]);
    }

    public function checkPlate(Request $request): JsonResponse
    {
        $raw = (string) $request->query('plat', '');
        $plat = strtoupper(preg_replace('/\s+/', '', trim($raw)));
        $len = strlen($plat);

        if ($plat === '' || $len < 3 || $len > 10) {
            return response()->json([
                'success' => true,
                'data' => [
                    'plat' => $plat,
                    'input_valid' => false,
                    'exists' => false,
                    'is_terdaftar' => false,
                    'parked' => false,
                    'active' => null,
                ],
            ]);
        }

        $kendaraan = Kendaraan::query()
            ->where('plat_nomor', $plat)
            ->first();

        $activeTransaksi = Transaksi::query()
            ->with('areaParkir')
            ->where('status', 'masuk')
            ->whereHas('kendaraan', fn ($q) => $q->where('plat_nomor', $plat))
            ->latest('id')
            ->first();

        return response()->json([
            'success' => true,
            'data' => [
                'plat' => $plat,
                'input_valid' => true,
                'exists' => (bool) $kendaraan,
                'is_terdaftar' => (bool) ($kendaraan?->is_terdaftar ?? false),
                'parked' => (bool) $activeTransaksi,
                'vehicle' => $kendaraan ? [
                    'jenis_kendaraan' => $kendaraan->jenis_kendaraan,
                    'warna' => $kendaraan->warna,
                    'merk' => $kendaraan->merk,
                ] : null,
                'active' => $activeTransaksi ? [
                    'id' => $activeTransaksi->id,
                    'barcode' => $activeTransaksi->barcode,
                    'area' => $activeTransaksi->areaParkir?->nama_area,
                    'waktu_masuk' => $activeTransaksi->waktu_masuk?->toIso8601String(),
                ] : null,
            ],
        ]);
    }

    public function captureAndAnalyze(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'camera_id' => ['nullable', 'integer', 'exists:camera_sources,id'],
        ]);

        $camera = CameraSource::query()
            ->where('is_active', true)
            ->when(isset($validated['camera_id']), fn ($q) => $q->where('id', (int) $validated['camera_id']))
            ->orderBy('id')
            ->first();

        if (! $camera) {
            return response()->json([
                'success' => false,
                'message' => 'Kamera aktif tidak ditemukan.',
            ], 404);
        }

        $streamUrl = (string) ($camera->stream_url ?? '');
        if ($streamUrl === '') {
            return response()->json([
                'success' => false,
                'message' => 'URL stream kamera tidak valid.',
            ], 422);
        }

        try {
            $candidates = [$streamUrl];
            if (preg_match('~(/video)(\\?.*)?$~i', $streamUrl)) {
                $candidates[] = preg_replace('~(/video)(\\?.*)?$~i', '/shot.jpg', $streamUrl);
                $candidates[] = preg_replace('~(/video)(\\?.*)?$~i', '/photo.jpg', $streamUrl);
            }

            $imageBinary = null;
            $fetchMeta = null;
            foreach (array_values(array_unique($candidates)) as $u) {
                $attempt = $this->tryFetchSingleJpegFromUrl($u);
                if (($attempt['ok'] ?? false) === true) {
                    $imageBinary = $attempt['binary'];
                    $fetchMeta = ['url' => $u, 'bytes' => $attempt['bytes'] ?? null, 'ms' => $attempt['ms'] ?? null];
                    break;
                }
                $fetchMeta = ['url' => $u, 'error' => $attempt['error'] ?? 'failed', 'bytes' => $attempt['bytes'] ?? null, 'ms' => $attempt['ms'] ?? null];
            }

            if (! is_string($imageBinary) || $imageBinary === '') {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengambil 1 frame JPEG dari kamera. Jika URL mengarah ke stream (contoh: /video), pastikan kamera mendukung snapshot (/shot.jpg).',
                    'debug' => $fetchMeta,
                ], 502);
            }

            $baseUrl = rtrim((string) config('services.python_yolo.url', 'http://127.0.0.1:5000'), '/');
            $analyzeUrl = $baseUrl . '/analyze';

            $http = Http::timeout(120)->acceptJson();

            /** @var \Illuminate\Http\Client\Response $analyzeResp */
            $analyzeResp = $http->attach(
                'image',
                $imageBinary,
                'capture-' . now()->format('Ymd-His') . '.jpg'
            )->post($analyzeUrl);

            if (! $analyzeResp->successful()) {
                return response()->json([
                    'success' => false,
                    'message' => 'YOLO service error (' . $analyzeResp->status() . ').',
                    'body' => $analyzeResp->json() ?? $analyzeResp->body(),
                ], 502);
            }

            $result = $analyzeResp->json() ?: [];

            $detectionForCache = [
                'vehicle_type' => $result['vehicle_type'] ?? null,
                'color' => $result['color'] ?? null,
                'confidence' => isset($result['confidence']) ? (float) $result['confidence'] : null,
                'plate_number' => $result['plate_number'] ?? null,
                'timestamp' => $result['timestamp'] ?? now()->format('Y-m-d H:i:s'),
            ];
            Cache::put('latest_detection', $detectionForCache, 3600);

            return response()->json([
                'success' => true,
                'message' => 'Gambar berhasil dianalisis.',
                'camera' => [
                    'id' => $camera->id,
                    'name' => $camera->name,
                ],
                'snapshot' => $fetchMeta,
                'data' => $result,
                'autofill' => $detectionForCache,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal koneksi ke kamera/Python YOLO: ' . $e->getMessage(),
            ], 503);
        }
    }

    public function store(Request $request)
    {
        $allowedJenis = VehicleTypeDisplay::allowedJenisFromTarif();
        if ($allowedJenis === []) {
            return back()
                ->withInput()
                ->with('error', 'Belum ada tarif jenis kendaraan. Admin harus menambah data Tarif terlebih dahulu.');
        }

        $valid = $request->validate([
            'plat_nomor' => 'required|string|min:3|max:10',
            'jenis_kendaraan' => ['required', 'string', 'max:255', Rule::in($allowedJenis)],
            'warna' => 'nullable|string|max:50',
            'merk' => 'nullable|string|max:100',
            'area_parkir_id' => 'required|exists:tb_area_parkir,id',
        ]);

        $plat = strtoupper(preg_replace('/\s+/', '', trim((string) $valid['plat_nomor'])));
        $activeTransaksi = Transaksi::query()
            ->with('areaParkir')
            ->where('status', 'masuk')
            ->whereHas('kendaraan', fn ($q) => $q->where('plat_nomor', $plat))
            ->latest('id')
            ->first();

        if ($activeTransaksi) {
            $areaName = $activeTransaksi->areaParkir?->nama_area ? " di area {$activeTransaksi->areaParkir->nama_area}" : '';
            return back()
                ->withErrors(['plat_nomor' => "Kendaraan {$plat} sudah terparkir{$areaName} (Karcis {$activeTransaksi->barcode})."])
                ->withInput();
        }

        $area = AreaParkir::query()->findOrFail($valid['area_parkir_id']);
        $kapasitas = (int) ($area->kapasitas ?? 0);
        $aktif = (int) Transaksi::query()
            ->where('area_parkir_id', $area->id)
            ->where('status', 'masuk')
            ->count();

        if ($kapasitas > 0 && $aktif >= $kapasitas) {
            return back()
                ->withErrors(['area_parkir_id' => "Area {$area->nama_area} penuh. Pilih area lain."])
                ->withInput();
        }

        $kendaraan = Kendaraan::firstOrCreate(
            ['plat_nomor' => $plat],
            [
                'jenis_kendaraan' => $valid['jenis_kendaraan'],
                'warna' => $valid['warna'] ?? null,
                'merk' => $valid['merk'] ?? null,
            ]
        );

        if (! $kendaraan->wasRecentlyCreated) {
            $kendaraan->update([
                'jenis_kendaraan' => $valid['jenis_kendaraan'],
                'warna' => $valid['warna'] ?? $kendaraan->warna,
                'merk' => $valid['merk'] ?? $kendaraan->merk,
            ]);
        }

        $barcode = 'PARK-'.strtoupper(Str::random(10)).'-'.now()->format('His');

        $transaksi = Transaksi::create([
            'kendaraan_id' => $kendaraan->id,
            'area_parkir_id' => $valid['area_parkir_id'],
            'petugas_id' => $request->user()->id,
            'waktu_masuk' => now(),
            'status' => 'masuk',
            'barcode' => $barcode,
        ]);

        LogAktivitas::create([
            'user_id' => $request->user()->id,
            'aktivitas' => "Transaksi masuk: {$kendaraan->plat_nomor} - Karcis {$barcode}",
        ]);

        // Detection dari Python hanya dipakai sekali untuk autofill.
        Cache::forget('latest_detection');

        return redirect()
            ->route('petugas.transaksi.karcis', $transaksi)
            ->with('success', 'Karcis berhasil digenerate. Berikan ke pengendara.');
    }
}
