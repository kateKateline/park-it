<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeteksiAi extends Model
{
    use HasFactory;

    protected $table = 'tb_deteksi_ai';

    protected $fillable = [
        'transaksi_id',
        'plat_terdeteksi',
        'warna_terdeteksi',
        'sumber',
    ];

    public function transaksi(): BelongsTo
    {
        return $this->belongsTo(Transaksi::class, 'transaksi_id');
    }
}

