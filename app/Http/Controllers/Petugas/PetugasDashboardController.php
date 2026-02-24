<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PetugasDashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $today = now()->toDateString();

        return view('petugas.dashboard', [
            'user' => $request->user(),
            'counts' => [
                'hari_ini' => Transaksi::whereDate('waktu_masuk', $today)->count(),
                'sedang_parkir' => Transaksi::where('status', 'masuk')->count(),
                'selesai' => Transaksi::where('status', 'selesai')
                    ->whereDate('waktu_keluar', $today)
                    ->count(),
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

