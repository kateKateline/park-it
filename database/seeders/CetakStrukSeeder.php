<?php

namespace Database\Seeders;

use App\Models\CetakStruk;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CetakStrukSeeder extends Seeder
{
    public function run(): void
    {
        $transaksiSelesai = Transaksi::where('status', 'selesai')->orderBy('id')->get();

        foreach ($transaksiSelesai as $t) {
            CetakStruk::updateOrCreate(
                ['transaksi_id' => $t->id],
                ['waktu_cetak' => Carbon::parse($t->waktu_keluar ?? $t->waktu_masuk)->addMinutes(2)]
            );
        }
    }
}

