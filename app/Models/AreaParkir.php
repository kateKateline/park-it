<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Transaksi;

class AreaParkir extends Model
{
    use HasFactory;

    protected $table = 'tb_area_parkir';

    protected $fillable = [
        'nama_area',
        'kapasitas',
        'keterangan',
    ];

    public function transaksi(): HasMany
    {
        return $this->hasMany(Transaksi::class, 'area_parkir_id');
    }
}

