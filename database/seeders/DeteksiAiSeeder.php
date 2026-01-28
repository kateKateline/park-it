<?php

namespace Database\Seeders;

use App\Models\DeteksiAi;
use App\Models\Transaksi;
use Illuminate\Database\Seeder;

class DeteksiAiSeeder extends Seeder
{
    public function run(): void
    {
        // Demo saja (petugas dashboard belum full integrasi deteksi).
        $t = Transaksi::orderBy('id')->first();
        if (!$t) {
            return;
        }

        DeteksiAi::create([
            'transaksi_id' => $t->id,
            'plat_terdeteksi' => 'B1234ABC',
            'warna_terdeteksi' => 'Hitam',
            'sumber' => 'yolo',
        ]);
    }
}

