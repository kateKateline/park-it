<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detection extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_type',
        'color',
        'confidence',
        'detected_at',
    ];

    protected function casts(): array
    {
        return [
            'confidence' => 'float',
            'detected_at' => 'datetime',
        ];
    }
}
