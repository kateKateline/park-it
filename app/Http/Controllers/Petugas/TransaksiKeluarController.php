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
    private const GRATIS_MENIT = 5;

    public function create(Request $request)
    {
        return view('petugas.transaksi.keluar');
    }

    private function hitungPembayaran($waktuMasuk, $waktuKeluar, int $tarifPerJam): array
    {
        $durasiMenit = max(0, (int) $waktuMasuk->diffInMinutes($waktuKeluar));
        $menitDitagih = max(0, $durasiMenit - self::GRATIS_MENIT);
        $totalBayar = $menitDitagih === 0 ? 0 : (int) ceil(($menitDitagih * $tarifPerJam) / 60);

        return [
            'durasi_menit' => $durasiMenit,
            'gratis_menit' => self::GRATIS_MENIT,
            'menit_ditagih' => $menitDitagih,
            'tarif_per_jam' => $tarifPerJam,
            'tarif_per_menit' => $tarifPerJam / 60,
            'total_bayar' => $totalBayar,
        ];
    }

    public function scan(Request $request)
    {
        $request->validate([
            'kode_karcis' => 'required|string|max:50',
        ]);

        $kode = trim($request->kode_karcis);

        $transaksi = Transaksi::with(['kendaraan', 'areaParkir'])
            ->where('barcode', $kode)
            ->where('status', 'masuk')
            ->first();

        if (! $transaksi) {
            return back()->withErrors(['kode_karcis' => 'Karcis tidak ditemukan atau transaksi sudah selesai.']);
        }

        $tarif = Tarif::where('jenis_kendaraan', $transaksi->kendaraan->jenis_kendaraan)->first();
        $tarifPerJam = $tarif ? $tarif->tarif_per_jam : 5000;

        $waktuMasuk = $transaksi->waktu_masuk;
        $waktuKeluar = now();
        $hasil = $this->hitungPembayaran($waktuMasuk, $waktuKeluar, $tarifPerJam);

        return view('petugas.transaksi.keluar-bayar', [
            'transaksi' => $transaksi,
            'waktu_masuk' => $waktuMasuk,
            'waktu_keluar' => $waktuKeluar,
            'durasi_menit' => $hasil['durasi_menit'],
            'gratis_menit' => $hasil['gratis_menit'],
            'menit_ditagih' => $hasil['menit_ditagih'],
            'tarif_per_jam' => $hasil['tarif_per_jam'],
            'tarif_per_menit' => $hasil['tarif_per_menit'],
            'total_bayar' => $hasil['total_bayar'],
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
        $hasil = $this->hitungPembayaran($transaksi->waktu_masuk, $waktuKeluar, $tarifPerJam);

        $transaksi->update([
            'waktu_keluar' => $waktuKeluar,
            'durasi_menit' => $hasil['durasi_menit'],
            'total_bayar' => $hasil['total_bayar'],
            'status' => 'selesai',
        ]);

        CetakStruk::create([
            'transaksi_id' => $transaksi->id,
            'waktu_cetak' => now(),
        ]);

        LogAktivitas::create([
            'user_id' => $request->user()->id,
            'aktivitas' => "Transaksi selesai: {$transaksi->kendaraan->plat_nomor} - Rp ".number_format($hasil['total_bayar'], 0, ',', '.'),
        ]);

        return redirect()
            ->route('petugas.transaksi.struk', $transaksi)
            ->with('success', 'Pembayaran berhasil. Cetak struk untuk pengendara.');
    }
}
