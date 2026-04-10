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
        $now = Carbon::now();
        $todayStart = $now->copy()->startOfDay();
        $todayEnd = $now->copy()->endOfDay();
        $monthStart = $now->copy()->startOfMonth();
        $monthEnd = $now->copy()->endOfMonth();
        $from7 = $now->copy()->subDays(6)->startOfDay();
        $to7 = $now->copy()->endOfDay();

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

        $rekap7Hari = Transaksi::query()
            ->where('status', 'selesai')
            ->whereBetween('waktu_keluar', [$from7, $to7])
            ->selectRaw('DATE(waktu_keluar) as tanggal')
            ->selectRaw('COUNT(*) as jumlah')
            ->selectRaw('COALESCE(SUM(total_bayar), 0) as pendapatan')
            ->selectRaw('COALESCE(AVG(durasi_menit), 0) as rata_durasi')
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'asc')
            ->get();

        $rekapMap = $rekap7Hari->keyBy('tanggal');
        $rekapSeries = [];
        $rekapTable = [];
        for ($i = 0; $i < 7; $i++) {
            $date = $from7->copy()->addDays($i)->toDateString();
            $row = $rekapMap->get($date);
            $rekapSeries[] = [
                'tanggal' => $date,
                'jumlah' => (int) ($row->jumlah ?? 0),
                'pendapatan' => (int) ($row->pendapatan ?? 0),
                'rata_durasi' => (int) round((float) ($row->rata_durasi ?? 0)),
            ];
            $rekapTable[] = end($rekapSeries);
        }

        $total7 = array_reduce($rekapSeries, fn ($acc, $r) => $acc + (int) $r['pendapatan'], 0);
        $jumlah7 = array_reduce($rekapSeries, fn ($acc, $r) => $acc + (int) $r['jumlah'], 0);

        $recentTransaksi = Transaksi::with(['kendaraan', 'areaParkir', 'petugas'])
            ->where('status', 'selesai')
            ->latest('id')
            ->limit(10)
            ->get();

        return view('owner.dashboard', [
            'user' => $request->user(),
            'metrics' => [
                'transaksi_hari_ini' => (int) $transaksiHariIni,
                'pendapatan_hari_ini' => (int) $pendapatanHariIni,
                'transaksi_bulan_ini' => (int) $transaksiBulanIni,
                'pendapatan_bulan_ini' => (int) $pendapatanBulanIni,
            ],
            'rekap' => [
                'from' => $from7->toDateString(),
                'to' => $to7->toDateString(),
                'series' => $rekapSeries,
                'total_7_hari' => (int) $total7,
                'jumlah_7_hari' => (int) $jumlah7,
            ],
            'recent' => [
                'transaksi' => $recentTransaksi,
            ],
        ]);
    }
}
