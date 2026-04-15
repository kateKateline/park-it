<?php

namespace Database\Seeders;

use App\Models\AreaParkir;
use App\Models\Kendaraan;
use App\Models\LogAktivitas;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;

class LiveParkingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $petugas = User::where('role', 'petugas')->first();
        $areas = AreaParkir::where('is_tangguhkan', false)->get();

        if (!$petugas || $areas->isEmpty()) {
            $this->command->error('Pastikan UsersSeeder dan AreaParkirSeeder sudah dijalankan.');
            return;
        }

        $this->command->info('Menambahkan data kendaraan yang sedang parkir saat ini...');

        $kendaraanData = [
            ['plat' => 'B 1234 ABC', 'jenis' => 'mobil', 'merk' => 'Toyota Avanza', 'warna' => 'Hitam', 'jam_lalu' => 2],
            ['plat' => 'D 5678 DEF', 'jenis' => 'motor', 'merk' => 'Honda Vario', 'warna' => 'Merah', 'jam_lalu' => 1],
            ['plat' => 'F 9101 GHI', 'jenis' => 'mobil', 'merk' => 'Honda Brio', 'warna' => 'Putih', 'jam_lalu' => 3],
            ['plat' => 'B 2468 JKL', 'jenis' => 'motor', 'merk' => 'Yamaha NMAX', 'warna' => 'Biru', 'jam_lalu' => 0.5],
            ['plat' => 'Z 1357 MNO', 'jenis' => 'truk', 'merk' => 'Hino Dutro', 'warna' => 'Hijau', 'jam_lalu' => 5],
        ];

        foreach ($kendaraanData as $data) {
            $kendaraan = Kendaraan::firstOrCreate(
                ['plat_nomor' => $data['plat']],
                [
                    'jenis_kendaraan' => $data['jenis'],
                    'merk' => $data['merk'],
                    'warna' => $data['warna'],
                ]
            );

            $entryTime = now()->subMinutes((int)($data['jam_lalu'] * 60));
            $barcode = 'PARK-' . strtoupper(Str::random(10)) . '-' . $entryTime->format('His');

            Transaksi::create([
                'kendaraan_id' => $kendaraan->id,
                'area_parkir_id' => $areas->random()->id,
                'petugas_id' => $petugas->id,
                'waktu_masuk' => $entryTime,
                'status' => 'masuk',
                'barcode' => $barcode,
                'created_at' => $entryTime,
                'updated_at' => $entryTime,
            ]);

            LogAktivitas::create([
                'user_id' => $petugas->id,
                'aktivitas' => "Transaksi masuk (Seeder): {$kendaraan->plat_nomor} - Karcis {$barcode}",
                'created_at' => $entryTime,
            ]);
        }

        $this->command->info('Berhasil menambahkan 5 kendaraan yang sedang parkir.');
    }
}
