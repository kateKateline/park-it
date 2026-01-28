<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CetakStruk extends Model
{
    use HasFactory;

    protected $table = 'tb_cetak_struk';

    protected $fillable = [
        'transaksi_id',
        'waktu_cetak',
    ];

    protected function casts(): array
    {
        return [
            'waktu_cetak' => 'datetime',
        ];
    }

    public function transaksi(): BelongsTo
    {
        return $this->belongsTo(Transaksi::class, 'transaksi_id');
    }
}

