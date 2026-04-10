<?php

namespace App\Support;

final class DurationDisplay
{
    /**
     * Tampilkan durasi dari nilai menit: di bawah 60 menit pakai "menit", 60 ke atas pakai "jam" (+ sisa menit bila ada).
     */
    public static function fromMinutes(int|float|null $menit): string
    {
        if ($menit === null) {
            return '-';
        }

        $m = (int) round((float) $menit);
        if ($m < 0) {
            $m = 0;
        }

        if ($m < 60) {
            return $m.' menit';
        }

        $h = intdiv($m, 60);
        $rem = $m % 60;

        return $rem === 0 ? $h.' jam' : $h.' jam '.$rem.' menit';
    }
}
