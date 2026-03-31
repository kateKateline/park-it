<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Tarif;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    private const GRATIS_MENIT = 5;

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

        $tarif = Tarif::where('jenis_kendaraan', $transaksi->kendaraan->jenis_kendaraan)->first();
        $tarifPerJam = $tarif ? $tarif->tarif_per_jam : 5000;
        $durasiMenit = (int) ($transaksi->durasi_menit ?? 0);
        $menitDitagih = max(0, $durasiMenit - self::GRATIS_MENIT);

        return view('petugas.transaksi.struk', [
            'transaksi' => $transaksi,
            'durasi_menit' => $durasiMenit,
            'gratis_menit' => self::GRATIS_MENIT,
            'menit_ditagih' => $menitDitagih,
            'tarif_per_jam' => $tarifPerJam,
            'tarif_per_menit' => $tarifPerJam / 60,
        ]);
    }
}
