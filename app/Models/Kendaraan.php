<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kendaraan extends Model
{
    use HasFactory;

    protected $table = 'tb_kendaraan';

    protected $fillable = [
        'plat_nomor',
        'warna',
        'jenis_kendaraan',
        'merk',
        'pemilik',
        'is_terdaftar',
    ];

    protected function casts(): array
    {
        return [
            'is_terdaftar' => 'boolean',
        ];
    }

    public function transaksi(): HasMany
    {
        return $this->hasMany(Transaksi::class, 'kendaraan_id');
    }
}

