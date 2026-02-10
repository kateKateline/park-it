<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OwnerDashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $todayStart = Carbon::now()->startOfDay();
        $todayEnd = Carbon::now()->endOfDay();
        $monthStart = Carbon::now()->startOfMonth();
        $monthEnd = Carbon::now()->endOfMonth();

        $transaksiHariIni = Transaksi::where('status', 'selesai')
            ->whereBetween('waktu_keluar', [$todayStart, $todayEnd])
            ->count();

        $pendapatanHariIni = Transaksi::where('status', 'selesai')
            ->whereBetween('waktu_keluar', [$todayStart, $todayEnd])
            ->sum('total_bayar');

        $transaksiBulanIni = Transaksi::where('status', 'selesai')
            ->whereBetween('waktu_keluar', [$monthStart, $monthEnd])
            ->count();

        $pendapatanBulanIni = Transaksi::where('status', 'selesai')
            ->whereBetween('waktu_keluar', [$monthStart, $monthEnd])
            ->sum('total_bayar');

        return view('owner.dashboard.index', [
            'user' => $request->user(),
            'metrics' => [
                'transaksi_hari_ini' => (int) $transaksiHariIni,
                'pendapatan_hari_ini' => (int) $pendapatanHariIni,
                'transaksi_bulan_ini' => (int) $transaksiBulanIni,
                'pendapatan_bulan_ini' => (int) $pendapatanBulanIni,
            ],
        ]);
    }
}
