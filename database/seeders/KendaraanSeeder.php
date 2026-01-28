<?php

namespace Database\Seeders;

use App\Models\Kendaraan;
use Illuminate\Database\Seeder;

class KendaraanSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            [
                'plat_nomor' => 'B 1234 ABC',
                'warna' => 'Hitam',
                'jenis_kendaraan' => 'mobil',
                'merk' => 'Toyota',
                'pemilik' => 'Budi',
                'is_terdaftar' => true,
            ],
            [
                'plat_nomor' => 'D 9876 ZXY',
                'warna' => 'Putih',
                'jenis_kendaraan' => 'motor',
                'merk' => 'Honda',
                'pemilik' => 'Siti',
                'is_terdaftar' => true,
            ],
            [
                'plat_nomor' => 'F 4321 QWE',
                'warna' => 'Merah',
                'jenis_kendaraan' => 'motor',
                'merk' => 'Yamaha',
                'pemilik' => null,
                'is_terdaftar' => false,
            ],
            [
                'plat_nomor' => 'B 5555 PARK',
                'warna' => 'Silver',
                'jenis_kendaraan' => 'mobil',
                'merk' => 'Suzuki',
                'pemilik' => null,
                'is_terdaftar' => false,
            ],
        ];

        foreach ($rows as $row) {
            Kendaraan::updateOrCreate(
                ['plat_nomor' => $row['plat_nomor']],
                $row
            );
        }
    }
}

