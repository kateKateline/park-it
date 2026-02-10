<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RekapTransaksiController extends Controller
{
    public function index(Request $request)
    {
        $from = $request->query('from');
        $to = $request->query('to');

        $fromDate = $from ? Carbon::parse($from)->startOfDay() : Carbon::now()->subDays(7)->startOfDay();
        $toDate = $to ? Carbon::parse($to)->endOfDay() : Carbon::now()->endOfDay();

        $rekap = Transaksi::where('status', 'selesai')
            ->whereBetween('waktu_keluar', [$fromDate, $toDate])
            ->selectRaw('DATE(waktu_keluar) as tanggal')
            ->selectRaw('COUNT(*) as jumlah')
            ->selectRaw('COALESCE(SUM(total_bayar), 0) as pendapatan')
            ->selectRaw('AVG(durasi_menit) as rata_durasi')
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'desc')
            ->get();

        $total = Transaksi::where('status', 'selesai')
            ->whereBetween('waktu_keluar', [$fromDate, $toDate])
            ->sum('total_bayar');

        return view('owner.rekap.index', [
            'user' => $request->user(),
            'rekap' => $rekap,
            'from' => $fromDate->toDateString(),
            'to' => $toDate->toDateString(),
            'total' => $total,
        ]);
    }

    public function show(string $date, Request $request)
    {
        $tanggal = Carbon::parse($date)->toDateString();

        $items = Transaksi::with(['kendaraan', 'areaParkir', 'petugas'])
            ->where('status', 'selesai')
            ->whereDate('waktu_keluar', $tanggal)
            ->orderBy('waktu_keluar', 'desc')
            ->get();

        $summary = [
            'jumlah' => $items->count(),
            'pendapatan' => $items->sum('total_bayar'),
            'rata_durasi' => (int) round($items->avg('durasi_menit')),
        ];

        return view('owner.rekap.show', [
            'user' => $request->user(),
            'tanggal' => $tanggal,
            'items' => $items,
            'summary' => $summary,
        ]);
    }
}
