<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class PetugasDashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $petugas = $request->user();

        return view('petugas.dashboard', [
            'user' => $petugas,
            'counts' => [
                'hari_ini' => Transaksi::whereDate('waktu_masuk', now()->toDateString())->count(),
                'sedang_parkir' => Transaksi::where('status', 'masuk')->count(),
                'selesai' => Transaksi::where('status', 'selesai')->count(),
            ],
        ]);
    }
}

