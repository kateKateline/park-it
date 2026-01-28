<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\AreaParkir;
use App\Models\CetakStruk;
use App\Models\DeteksiAi;
use App\Models\Kendaraan;
use App\Models\User;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'tb_transaksi';

    protected $fillable = [
        'kendaraan_id',
        'area_parkir_id',
        'petugas_id',
        'waktu_masuk',
        'waktu_keluar',
        'durasi_menit',
        'total_bayar',
        'status',
        'metode_pembayaran',
        'qr_code',
    ];

    protected function casts(): array
    {
        return [
            'waktu_masuk' => 'datetime',
            'waktu_keluar' => 'datetime',
            'durasi_menit' => 'integer',
            'total_bayar' => 'integer',
        ];
    }

    public function kendaraan(): BelongsTo
    {
        return $this->belongsTo(Kendaraan::class, 'kendaraan_id');
    }

    public function areaParkir(): BelongsTo
    {
        return $this->belongsTo(AreaParkir::class, 'area_parkir_id');
    }

    public function petugas(): BelongsTo
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    public function struk(): HasOne
    {
        return $this->hasOne(CetakStruk::class, 'transaksi_id');
    }

    public function deteksiAi(): HasMany
    {
        return $this->hasMany(DeteksiAi::class, 'transaksi_id');
    }
}

