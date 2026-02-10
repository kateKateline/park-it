<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\CameraSource;
use Illuminate\Http\Request;

class CameraApiController extends Controller
{
    /**
     * Mengembalikan daftar kamera aktif untuk petugas.
     *
     * GET /api/cameras/active
     */
    public function active(Request $request)
    {
        $cameras = CameraSource::query()
            ->where('is_active', true)
            ->orderBy('id')
            ->get(['id', 'name', 'stream_url']);

        return response()->json($cameras);
    }
}

