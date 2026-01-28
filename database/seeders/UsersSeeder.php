<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        // Admin (CRUD master data & akses log)
        User::updateOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Admin',
                'password' => Hash::make('123'),
                'role' => 'admin',
            ]
        );

        // Owner (hanya rekap transaksi sesuai waktu)
        User::updateOrCreate(
            ['username' => 'owner'],
            [
                'name' => 'Owner',
                'password' => Hash::make('123'),
                'role' => 'owner',
            ]
        );

        // Petugas (transaksi + cetak struk; deteksi AI belum full integrasi)
        User::updateOrCreate(
            ['username' => 'petugas'],
            [
                'name' => 'Petugas',
                'password' => Hash::make('123'),
                'role' => 'petugas',
            ]
        );

        // Tambahan petugas demo
        User::updateOrCreate(
            ['username' => 'petugas2'],
            [
                'name' => 'Petugas 2',
                'password' => Hash::make('123'),
                'role' => 'petugas',
            ]
        );
    }
}

