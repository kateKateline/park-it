<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\AreaParkir;
use App\Models\Transaksi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PetugasDashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $today = now();
        $todayDate = $today->toDateString();

        $counts = [
            'hari_ini' => Transaksi::whereDate('waktu_masuk', $todayDate)->count(),
            'sedang_parkir' => Transaksi::where('status', 'masuk')->count(),
            'selesai' => Transaksi::where('status', 'selesai')
                ->whereDate('waktu_keluar', $todayDate)
                ->count(),
        ];

        $pendapatanHariIni = (int) Transaksi::where('status', 'selesai')
            ->whereDate('waktu_keluar', $todayDate)
            ->sum('total_bayar');

        $avgDurasiHariIni = (int) round((float) Transaksi::where('status', 'selesai')
            ->whereDate('waktu_keluar', $todayDate)
            ->avg('durasi_menit'));

        $areas = AreaParkir::query()
            ->withCount([
                'transaksi as aktif_count' => fn ($q) => $q->where('status', 'masuk'),
            ])
            ->orderBy('nama_area')
            ->get();

        $kendaraanAktif = Transaksi::query()
            ->join('tb_kendaraan', 'tb_transaksi.kendaraan_id', '=', 'tb_kendaraan.id')
            ->where('tb_transaksi.status', 'masuk')
            ->selectRaw('tb_kendaraan.jenis_kendaraan as jenis_kendaraan, COUNT(*) as jumlah')
            ->groupBy('tb_kendaraan.jenis_kendaraan')
            ->pluck('jumlah', 'jenis_kendaraan')
            ->all();

        $recentTransaksi = Transaksi::with(['kendaraan', 'areaParkir', 'petugas'])
            ->latest('id')
            ->limit(10)
            ->get();

        return view('petugas.dashboard', [
            'user' => $request->user(),
            'counts' => $counts,
            'kpi' => [
                'pendapatan_hari_ini' => $pendapatanHariIni,
                'rata_durasi_hari_ini' => $avgDurasiHariIni,
            ],
            'areas' => $areas,
            'kendaraan_aktif' => $kendaraanAktif,
            'recent' => [
                'transaksi' => $recentTransaksi,
            ],
        ]);
    }

    /**
     * Test koneksi ke Python YOLO service (GET /status).
     * Dipanggil dari tombol "Test Koneksi" di dashboard petugas.
     */
    public function pythonStatus(Request $request): JsonResponse
    {
        $baseUrl = rtrim(config('services.python_yolo.url', 'http://127.0.0.1:5000'), '/');
        $url = $baseUrl . '/status';

        try {
            $response = Http::timeout(5)->get($url);

            if ($response->successful()) {
                $data = $response->json();
                return response()->json([
                    'success' => true,
                    'message' => 'Python YOLO service berjalan',
                    'data' => $data,
                    'url' => $url,
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Python API merespon dengan status ' . $response->status(),
                'url' => $url,
            ], 502);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat terhubung ke Python YOLO: ' . $e->getMessage(),
                'url' => $url,
            ], 503);
        }
    }
}
