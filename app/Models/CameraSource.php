<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CameraSource extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'stream_url',
        'is_active',
    ];
}

