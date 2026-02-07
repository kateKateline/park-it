<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;

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
}

