<?php

namespace Database\Seeders;

use App\Models\AreaParkir;
use Illuminate\Database\Seeder;

class AreaParkirSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['nama_area' => 'Area A', 'kapasitas' => 50, 'keterangan' => 'Dekat pintu masuk'],
            ['nama_area' => 'Area B', 'kapasitas' => 40, 'keterangan' => 'Dekat pintu keluar'],
            ['nama_area' => 'Basement', 'kapasitas' => 60, 'keterangan' => 'Khusus kendaraan roda 4'],
        ];

        foreach ($rows as $row) {
            AreaParkir::updateOrCreate(
                ['nama_area' => $row['nama_area']],
                ['kapasitas' => $row['kapasitas'], 'keterangan' => $row['keterangan']]
            );
        }
    }
}

