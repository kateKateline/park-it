<?php

namespace Database\Seeders;

use App\Models\Tarif;
use Illuminate\Database\Seeder;

class TarifSeeder extends Seeder
{
    public function run(): void
    {
        // Minimal tarif sesuai kebutuhan demo (jenis kendaraan: mobil, motor)
        $rows = [
            ['jenis_kendaraan' => 'motor', 'tarif_per_jam' => 2000],
            ['jenis_kendaraan' => 'mobil', 'tarif_per_jam' => 5000],
        ];

        foreach ($rows as $row) {
            Tarif::updateOrCreate(
                ['jenis_kendaraan' => $row['jenis_kendaraan']],
                ['tarif_per_jam' => $row['tarif_per_jam']]
            );
        }
    }
}

