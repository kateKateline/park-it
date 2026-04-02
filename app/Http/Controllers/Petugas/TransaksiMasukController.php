<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\AreaParkir;
use App\Models\Kendaraan;
use App\Models\LogAktivitas;
use App\Models\Tarif;
use App\Models\Transaksi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class TransaksiMasukController extends Controller
{
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

        return view('petugas.transaksi.masuk', [
            'areas' => $areas,
            'tarif' => $tarif,
            'latestDetection' => $latestDetection,
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
                'active' => $activeTransaksi ? [
                    'id' => $activeTransaksi->id,
                    'barcode' => $activeTransaksi->barcode,
                    'area' => $activeTransaksi->areaParkir?->nama_area,
                    'waktu_masuk' => $activeTransaksi->waktu_masuk?->toIso8601String(),
                ] : null,
            ],
        ]);
    }

    public function store(Request $request)
    {
        $valid = $request->validate([
            'plat_nomor' => 'required|string|min:3|max:10',
            'jenis_kendaraan' => 'required|in:motor,mobil',
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
