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

        $query = Transaksi::with(['kendaraan', 'areaParkir', 'petugas'])
            ->where('status', 'selesai')
            ->whereBetween('waktu_masuk', [$fromDate, $toDate])
            ->orderBy('waktu_masuk', 'desc');

        $items = $query->paginate(15)->withQueryString();

        $total = (clone $query)->sum('total_bayar');

        return view('owner.rekap.index', [
            'user' => $request->user(),
            'items' => $items,
            'from' => $fromDate->toDateString(),
            'to' => $toDate->toDateString(),
            'total' => $total,
        ]);
    }
}

