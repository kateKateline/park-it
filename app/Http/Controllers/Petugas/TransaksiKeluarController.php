<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\CetakStruk;
use App\Models\LogAktivitas;
use App\Models\Tarif;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiKeluarController extends Controller
{
    public function create(Request $request)
    {
        return view('petugas.transaksi.keluar');
    }

    public function scan(Request $request)
    {
        $request->validate([
            'kode_karcis' => 'required|string|max:50',
        ]);

        $kode = trim($request->kode_karcis);

        $transaksi = Transaksi::with(['kendaraan', 'areaParkir'])
            ->where('qr_code', $kode)
            ->where('status', 'masuk')
            ->first();

        if (! $transaksi) {
            return back()->withErrors(['kode_karcis' => 'Karcis tidak ditemukan atau transaksi sudah selesai.']);
        }

        $tarif = Tarif::where('jenis_kendaraan', $transaksi->kendaraan->jenis_kendaraan)->first();
        $tarifPerJam = $tarif ? $tarif->tarif_per_jam : 5000;

        $waktuMasuk = $transaksi->waktu_masuk;
        $waktuKeluar = now();
        $durasiMenit = (int) $waktuMasuk->diffInMinutes($waktuKeluar);
        $jam = max(1, (int) ceil($durasiMenit / 60));
        $totalBayar = $jam * $tarifPerJam;

        return view('petugas.transaksi.keluar-bayar', [
            'transaksi' => $transaksi,
            'waktu_masuk' => $waktuMasuk,
            'waktu_keluar' => $waktuKeluar,
            'durasi_menit' => $durasiMenit,
            'jam' => $jam,
            'tarif_per_jam' => $tarifPerJam,
            'total_bayar' => $totalBayar,
        ]);
    }

    public function bayar(Request $request)
    {
        $request->validate([
            'transaksi_id' => 'required|exists:tb_transaksi,id',
        ]);

        $transaksi = Transaksi::with('kendaraan')
            ->where('id', $request->transaksi_id)
            ->where('status', 'masuk')
            ->firstOrFail();

        $tarif = Tarif::where('jenis_kendaraan', $transaksi->kendaraan->jenis_kendaraan)->first();
        $tarifPerJam = $tarif ? $tarif->tarif_per_jam : 5000;

        $waktuKeluar = now();
        $durasiMenit = (int) $transaksi->waktu_masuk->diffInMinutes($waktuKeluar);
        $jam = max(1, (int) ceil($durasiMenit / 60));
        $totalBayar = $jam * $tarifPerJam;

        $transaksi->update([
            'waktu_keluar' => $waktuKeluar,
            'durasi_menit' => $durasiMenit,
            'total_bayar' => $totalBayar,
            'status' => 'selesai',
        ]);

        CetakStruk::create([
            'transaksi_id' => $transaksi->id,
            'waktu_cetak' => now(),
        ]);

        LogAktivitas::create([
            'user_id' => $request->user()->id,
            'aktivitas' => "Transaksi selesai: {$transaksi->kendaraan->plat_nomor} - Rp ".number_format($totalBayar, 0, ',', '.'),
        ]);

        return redirect()
            ->route('petugas.transaksi.struk', $transaksi)
            ->with('success', 'Pembayaran berhasil. Cetak struk untuk pengendara.');
    }
}
