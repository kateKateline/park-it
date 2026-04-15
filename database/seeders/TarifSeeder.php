<?php

namespace Database\Seeders;

use App\Models\Tarif;
use Illuminate\Database\Seeder;

class TarifSeeder extends Seeder
{
    public function run(): void
    {
        $tarifs = [
            ['jenis_kendaraan' => 'mobil', 'tarif_per_jam' => 5000],
            ['jenis_kendaraan' => 'motor', 'tarif_per_jam' => 4000],
            ['jenis_kendaraan' => 'truk', 'tarif_per_jam' => 8000],
            ['jenis_kendaraan' => 'lainnya', 'tarif_per_jam' => 2000],
        ];

        foreach ($tarifs as $tarif) {
            Tarif::updateOrCreate(
                ['jenis_kendaraan' => $tarif['jenis_kendaraan']],
                ['tarif_per_jam' => $tarif['tarif_per_jam']]
            );
        }
    }
}
