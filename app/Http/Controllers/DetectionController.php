<?php

namespace App\Http\Controllers;

use App\Models\Detection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DetectionController extends Controller
{
    /**
     * Menerima data deteksi dari Python YOLO service.
     * POST /api/detection
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'vehicle_type' => ['required', 'string', 'in:car,motorcycle,truck,bus'],
            'color' => ['required', 'string', 'max:50'],
            'confidence' => ['required', 'numeric', 'min:0', 'max:1'],
            'timestamp' => ['required', 'date_format:Y-m-d H:i:s'],
        ]);

        $detection = Detection::create([
            'vehicle_type' => $validated['vehicle_type'],
            'color' => $validated['color'],
            'confidence' => (float) $validated['confidence'],
            'detected_at' => $validated['timestamp'],
        ]);

        $data = [
            'vehicle_type' => $detection->vehicle_type,
            'color' => $detection->color,
            'confidence' => $detection->confidence,
            'detected_at' => $detection->detected_at->format('Y-m-d H:i:s'),
        ];

        Cache::put('latest_detection', $data, 3600);

        return response()->json([
            'success' => true,
            'message' => 'Detection received',
        ], 201);
    }
}
