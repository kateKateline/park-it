<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $items = Transaksi::with(['kendaraan', 'areaParkir', 'petugas'])
            ->orderBy('id', 'desc')
            ->paginate(15);

        return view('petugas.transaksi.index', [
            'items' => $items,
        ]);
    }

    public function karcis(Transaksi $transaksi)
    {
        $transaksi->load(['kendaraan', 'areaParkir', 'petugas']);

        if ($transaksi->status !== 'masuk') {
            return redirect()->route('petugas.dashboard')
                ->with('error', 'Transaksi sudah selesai.');
        }

        return view('petugas.transaksi.karcis', [
            'transaksi' => $transaksi,
        ]);
    }

    public function struk(Transaksi $transaksi)
    {
        $transaksi->load(['kendaraan', 'areaParkir', 'petugas']);

        if ($transaksi->status !== 'selesai') {
            return redirect()->route('petugas.dashboard')
                ->with('error', 'Transaksi belum selesai.');
        }

        return view('petugas.transaksi.struk', [
            'transaksi' => $transaksi,
        ]);
    }
}
