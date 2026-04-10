<?php

namespace App\Support;

use App\Models\Tarif;
use Illuminate\Support\Collection;

final class VehicleTypeDisplay
{
    /**
     * Ikon Font Awesome (tanpa prefix "fas") berdasarkan nama jenis di tarif/kendaraan.
     */
    public static function iconClass(string $jenis): string
    {
        $k = mb_strtolower(trim($jenis));

        return match (true) {
            (str_contains($k, 'motor') && ! str_contains($k, 'mobil')) => 'fa-motorcycle',
            str_contains($k, 'truk') || str_contains($k, 'truck') => 'fa-truck',
            str_contains($k, 'bus') => 'fa-bus',
            str_contains($k, 'mobil') || str_contains($k, 'car') => 'fa-car-side',
            default => 'fa-car-side',
        };
    }

    public static function label(string $jenis): string
    {
        return mb_convert_case(mb_strtolower(trim($jenis)), MB_CASE_TITLE, 'UTF-8');
    }

    /**
     * Opsi untuk UI: value = string persis seperti di kolom tarif (untuk validasi & simpan DB).
     *
     * @return list<array{value: string, label: string, icon: string, tarif_per_jam: int, subtitle: string}>
     */
    public static function optionsFromTarifs(?Collection $tarifs = null): array
    {
        $tarifs = $tarifs ?? Tarif::query()->orderBy('id')->get(['jenis_kendaraan', 'tarif_per_jam']);

        return $tarifs->map(function ($t) {
            $jenis = (string) $t->jenis_kendaraan;
            $tarif = (int) $t->tarif_per_jam;

            return [
                'value' => $jenis,
                'label' => self::label($jenis),
                'icon' => self::iconClass($jenis),
                'tarif_per_jam' => $tarif,
                'subtitle' => 'Tarif Rp '.number_format($tarif, 0, ',', '.').' / jam',
            ];
        })->values()->all();
    }

    /**
     * @return list<string>
     */
    public static function allowedJenisFromTarif(): array
    {
        return Tarif::query()->orderBy('id')->pluck('jenis_kendaraan')->all();
    }

    /**
     * Map nilai vehicle_type dari YOLO/Python ke salah satu jenis_kendaraan yang ada di tarif.
     *
     * @param  list<string>  $allowed  nilai persis dari tb_tarif.jenis_kendaraan
     */
    public static function mapYoloToAllowedJenis(?string $vehicleType, array $allowed): ?string
    {
        if ($vehicleType === null || $vehicleType === '' || $allowed === []) {
            return null;
        }

        $norm = static fn (string $s): string => mb_strtolower(trim($s));

        $allowedNorm = [];
        foreach ($allowed as $a) {
            $allowedNorm[$norm((string) $a)] = $a;
        }

        $yolo = $norm($vehicleType);

        $toCanonical = [
            'car' => 'mobil',
            'sedan' => 'mobil',
            'suv' => 'mobil',
            'motorcycle' => 'motor',
            'motor' => 'motor',
            'truck' => 'truk',
            'truk' => 'truk',
            'bus' => 'bus',
        ];

        $candidates = [];
        if (isset($toCanonical[$yolo])) {
            $candidates[] = $toCanonical[$yolo];
        }
        $candidates[] = $yolo;

        foreach ($candidates as $c) {
            if ($c === '') {
                continue;
            }
            if (isset($allowedNorm[$norm($c)])) {
                return $allowedNorm[$norm($c)];
            }
        }

        foreach ($allowed as $jenis) {
            $j = $norm((string) $jenis);
            foreach ($candidates as $c) {
                if ($c === '') {
                    continue;
                }
                if (str_contains($j, $c) || str_contains($c, $j)) {
                    return $jenis;
                }
            }
        }

        return null;
    }

    /**
     * Map untuk JavaScript: key = vehicle_type dari API, value = jenis_kendaraan di DB.
     *
     * @return array<string, string>
     */
    public static function yoloVehicleTypeMapForJs(array $allowed): array
    {
        $keys = ['car', 'motorcycle', 'truck', 'bus', 'sedan', 'motor', 'truk', 'suv', 'van'];
        $out = [];
        foreach ($keys as $k) {
            $resolved = self::mapYoloToAllowedJenis($k, $allowed);
            if ($resolved !== null) {
                $out[$k] = $resolved;
            }
        }

        return $out;
    }
}
