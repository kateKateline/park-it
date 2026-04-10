<?php

namespace Database\Seeders;

use App\Models\AreaParkir;
use App\Models\Kendaraan;
use App\Models\LogAktivitas;
use App\Models\Tarif;
use App\Models\Transaksi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ParkingSeeder extends Seeder
{
    public function run(): void
    {
        $petugas = User::where('role', 'petugas')->get();
        if ($petugas->isEmpty()) {
            $this->command->error('No petugas found. Please run UsersSeeder first.');
            return;
        }

        $areas = AreaParkir::all();
        if ($areas->isEmpty()) {
            $this->command->error('No area parkir found. Please run AreaParkirSeeder first.');
            return;
        }

        $tarifs = Tarif::all()->pluck('tarif_per_jam', 'jenis_kendaraan')->toArray();
        if (empty($tarifs)) {
            $this->command->error('No tarif found. Please run TarifSeeder first.');
            return;
        }

        $startDate = now()->subMonth();
        $endDate = now();

        $this->command->info('Generating busy parking data for the last month...');

        // Pre-generate some vehicles
        $vehicleTypes = ['mobil', 'motor'];
        $colors = ['Hitam', 'Putih', 'Silver', 'Merah', 'Biru', 'Abu-abu'];
        $merks = [
            'mobil' => ['Toyota', 'Honda', 'Suzuki', 'Daihatsu', 'Mitsubishi'],
            'motor' => ['Honda', 'Yamaha', 'Suzuki', 'Kawasaki'],
        ];

        $currentDate = $startDate->copy();
        while ($currentDate <= $endDate) {
            // "Sangat sibuk" - between 50 and 100 transactions per day
            $dailyTransactions = rand(50, 100);
            
            $this->command->info("Seeding date: " . $currentDate->toDateString() . " with $dailyTransactions transactions.");

            for ($i = 0; $i < $dailyTransactions; $i++) {
                $type = $vehicleTypes[array_rand($vehicleTypes)];
                $plate = $this->generatePlateNumber();
                
                $kendaraan = Kendaraan::firstOrCreate(
                    ['plat_nomor' => $plate],
                    [
                        'jenis_kendaraan' => $type,
                        'warna' => $colors[array_rand($colors)],
                        'merk' => $merks[$type][array_rand($merks[$type])],
                        'is_terdaftar' => rand(0, 10) > 8, // 20% registered
                    ]
                );

                $area = $areas->random();
                $p = $petugas->random();

                // Random entry time during the day
                $entryTime = $currentDate->copy()->addHours(rand(6, 22))->addMinutes(rand(0, 59));
                
                // For past days, almost all transactions are finished.
                // For today, some might still be "masuk".
                $isFinished = true;
                if ($currentDate->isToday()) {
                    $isFinished = rand(0, 1) == 1;
                    if ($entryTime > now()) {
                        continue; // skip future transactions
                    }
                }

                $barcode = 'PARK-' . strtoupper(Str::random(10)) . '-' . $entryTime->format('His');

                if ($isFinished) {
                    // Duration between 30 mins and 12 hours
                    $durationMinutes = rand(30, 720);
                    $exitTime = $entryTime->copy()->addMinutes($durationMinutes);

                    // Skip if exit time is in the future
                    if ($exitTime > now()) {
                        $exitTime = now();
                        $durationMinutes = (int) $entryTime->diffInMinutes($exitTime);
                    }

                    $tarifPerJam = $tarifs[$type] ?? 2000;
                    $menitDitagih = max(0, $durationMinutes - 5); // 5 minutes grace period like in controller
                    $totalBayar = $menitDitagih === 0 ? 0 : (int) ceil(($menitDitagih * $tarifPerJam) / 60);

                    $transaksi = Transaksi::create([
                        'kendaraan_id' => $kendaraan->id,
                        'area_parkir_id' => $area->id,
                        'petugas_id' => $p->id,
                        'waktu_masuk' => $entryTime,
                        'waktu_keluar' => $exitTime,
                        'durasi_menit' => $durationMinutes,
                        'total_bayar' => $totalBayar,
                        'status' => 'selesai',
                        'barcode' => $barcode,
                        'created_at' => $entryTime,
                        'updated_at' => $exitTime,
                    ]);

                    // Log activity for MASUK
                    LogAktivitas::create([
                        'user_id' => $p->id,
                        'aktivitas' => "Transaksi masuk: {$kendaraan->plat_nomor} - Karcis {$barcode}",
                        'created_at' => $entryTime,
                    ]);

                    // Log activity for KELUAR (finished)
                    LogAktivitas::create([
                        'user_id' => $p->id,
                        'aktivitas' => "Transaksi selesai: {$kendaraan->plat_nomor} - Rp " . number_format($totalBayar, 0, ',', '.'),
                        'created_at' => $exitTime,
                    ]);

                } else {
                    $transaksi = Transaksi::create([
                        'kendaraan_id' => $kendaraan->id,
                        'area_parkir_id' => $area->id,
                        'petugas_id' => $p->id,
                        'waktu_masuk' => $entryTime,
                        'status' => 'masuk',
                        'barcode' => $barcode,
                        'created_at' => $entryTime,
                        'updated_at' => $entryTime,
                    ]);

                    // Log activity for MASUK
                    LogAktivitas::create([
                        'user_id' => $p->id,
                        'aktivitas' => "Transaksi masuk: {$kendaraan->plat_nomor} - Karcis {$barcode}",
                        'created_at' => $entryTime,
                    ]);
                }
            }

            $currentDate->addDay();
        }
    }

    private function generatePlateNumber(): string
    {
        $regions = ['B', 'D', 'F', 'T', 'Z', 'E'];
        $region = $regions[array_rand($regions)];
        $number = rand(1000, 9999);
        $suffix = '';
        for ($i = 0; $i < rand(1, 3); $i++) {
            $suffix .= chr(rand(65, 90));
        }
        return $region . $number . $suffix;
    }
}
