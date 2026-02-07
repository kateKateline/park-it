<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\AreaParkir;
use App\Models\Kendaraan;
use App\Models\LogAktivitas;
use App\Models\Tarif;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TransaksiMasukController extends Controller
{
    public function create(Request $request)
    {
        $areas = AreaParkir::orderBy('nama_area')->get();
        $tarif = Tarif::pluck('tarif_per_jam', 'jenis_kendaraan');

        return view('petugas.transaksi.masuk', [
            'areas' => $areas,
            'tarif' => $tarif,
        ]);
    }

    public function store(Request $request)
    {
        $valid = $request->validate([
            'plat_nomor' => 'required|string|max:20',
            'jenis_kendaraan' => 'required|in:motor,mobil',
            'warna' => 'nullable|string|max:50',
            'merk' => 'nullable|string|max:100',
            'area_parkir_id' => 'required|exists:tb_area_parkir,id',
        ]);

        $kendaraan = Kendaraan::firstOrCreate(
            ['plat_nomor' => strtoupper(str_replace(' ', '', $valid['plat_nomor']))],
            [
                'jenis_kendaraan' => $valid['jenis_kendaraan'],
                'warna' => $valid['warna'] ?? null,
                'merk' => $valid['merk'] ?? null,
            ]
        );

        if (! $kendaraan->wasRecentlyCreated) {
            $kendaraan->update([
                'jenis_kendaraan' => $valid['jenis_kendaraan'],
                'warna' => $valid['warna'] ?? $kendaraan->warna,
                'merk' => $valid['merk'] ?? $kendaraan->merk,
            ]);
        }

        $qrCode = 'PARK-'.strtoupper(Str::random(10)).'-'.now()->format('His');

        $transaksi = Transaksi::create([
            'kendaraan_id' => $kendaraan->id,
            'area_parkir_id' => $valid['area_parkir_id'],
            'petugas_id' => $request->user()->id,
            'waktu_masuk' => now(),
            'status' => 'masuk',
            'qr_code' => $qrCode,
        ]);

        LogAktivitas::create([
            'user_id' => $request->user()->id,
            'aktivitas' => "Transaksi masuk: {$kendaraan->plat_nomor} - Karcis {$qrCode}",
        ]);

        return redirect()
            ->route('petugas.transaksi.karcis', $transaksi)
            ->with('success', 'Karcis berhasil digenerate. Berikan ke pengendara.');
    }
}
