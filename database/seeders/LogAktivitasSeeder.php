<?php

namespace Database\Seeders;

use App\Models\LogAktivitas;
use App\Models\User;
use Illuminate\Database\Seeder;

class LogAktivitasSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();
        $petugas = User::where('role', 'petugas')->first();
        $owner = User::where('role', 'owner')->first();

        $rows = [
            [$admin, 'Login admin (seed)'],
            [$admin, 'Melihat daftar user (seed)'],
            [$petugas, 'Membuat transaksi masuk (seed)'],
            [$petugas, 'Menyelesaikan transaksi & cetak struk (seed)'],
            [$owner, 'Melihat rekap transaksi (seed)'],
        ];

        foreach ($rows as [$user, $aktivitas]) {
            if (!$user) {
                continue;
            }
            LogAktivitas::create([
                'user_id' => $user->id,
                'aktivitas' => $aktivitas,
            ]);
        }
    }
}

