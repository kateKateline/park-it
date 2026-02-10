<?php

namespace Database\Seeders;

use App\Models\AreaParkir;
use App\Models\Kendaraan;
use App\Models\Transaksi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TransaksiSeeder extends Seeder
{
    public function run(): void
    {
        $petugas = User::where('role', 'petugas')->orderBy('id')->first();
        $area = AreaParkir::orderBy('id')->first();
        $kendaraan = Kendaraan::orderBy('id')->get();

        if (!$petugas || !$area || $kendaraan->isEmpty()) {
            return;
        }

        // Buat beberapa transaksi selesai (untuk rekap owner) + beberapa masih "masuk" (demo petugas)
        $now = Carbon::now();

        $seedRows = [
            // selesai
            [
                'kendaraan_id' => $kendaraan[0]->id,
                'area_parkir_id' => $area->id,
                'petugas_id' => $petugas->id,
                'waktu_masuk' => $now->copy()->subDays(2)->setTime(9, 0),
                'waktu_keluar' => $now->copy()->subDays(2)->setTime(11, 15),
                'status' => 'selesai',
            ],
            [
                'kendaraan_id' => $kendaraan[1]->id,
                'area_parkir_id' => $area->id,
                'petugas_id' => $petugas->id,
                'waktu_masuk' => $now->copy()->subDays(1)->setTime(14, 30),
                'waktu_keluar' => $now->copy()->subDays(1)->setTime(16, 0),
                'status' => 'selesai',
            ],
            // masih masuk
            [
                'kendaraan_id' => $kendaraan[2]->id,
                'area_parkir_id' => $area->id,
                'petugas_id' => $petugas->id,
                'waktu_masuk' => $now->copy()->subMinutes(35),
                'waktu_keluar' => null,
                'status' => 'masuk',
            ],
        ];

        foreach ($seedRows as $row) {
            $durasiMenit = null;
            $totalBayar = null;

            if ($row['status'] === 'selesai' && $row['waktu_keluar']) {
                $durasiMenit = Carbon::parse($row['waktu_masuk'])->diffInMinutes(Carbon::parse($row['waktu_keluar']));
                // Total bayar demo: 2000 per jam dibulatkan ke atas per jam
                $jam = (int) ceil(max(1, $durasiMenit) / 60);
                $totalBayar = $jam * 2000;
            }

            Transaksi::create([
                'kendaraan_id' => $row['kendaraan_id'],
                'area_parkir_id' => $row['area_parkir_id'],
                'petugas_id' => $row['petugas_id'],
                'waktu_masuk' => $row['waktu_masuk'],
                'waktu_keluar' => $row['waktu_keluar'],
                'durasi_menit' => $durasiMenit,
                'total_bayar' => $totalBayar,
                'status' => $row['status'],
                'metode_pembayaran' => 'cash',
                'barcode' => (string) Str::uuid(),
            ]);
        }
    }
}

