<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class CarDetectionController extends Controller
{
    private $pythonApiUrl = 'http://localhost:5000';
    
    /**
     * Deteksi mobil dari gambar yang diupload
     */
    public function detectCar(Request $request)
    {
        // Validasi request
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:10240'
        ]);
        
        try {
            // Simpan gambar ke public/images
            $imagePath = $request->file('image')->store('images', 'public');
            $fullPath = storage_path('app/public/' . $imagePath);
            
            // Kirim gambar ke Python API
            $response = Http::timeout(30)->attach(
                'image', 
                file_get_contents($fullPath), 
                basename($fullPath)
            )->post($this->pythonApiUrl . '/detect', [
                'image_path' => 'public/' . $imagePath
            ]);
            
            if ($response->successful()) {
                $data = $response->json();
                
                return response()->json([
                    'success' => true,
                    'data' => $data,
                    'image_path' => $imagePath,
                    'image_url' => Storage::url($imagePath)
                ]);
            } else {
                // Jika API Python tidak tersedia atau error
                $statusCode = $response->status();
                $errorBody = $response->body();
                
                return response()->json([
                    'success' => false,
                    'error' => 'Detection failed',
                    'message' => $statusCode === 0 
                        ? 'Tidak dapat terhubung ke Python API. Pastikan API berjalan di http://localhost:5000'
                        : "API Error (Status: {$statusCode}): " . substr($errorBody, 0, 200)
                ], $statusCode === 0 ? 503 : $statusCode);
            }
            
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            return response()->json([
                'success' => false,
                'error' => 'Connection failed',
                'message' => 'Tidak dapat terhubung ke Python API. Pastikan API berjalan di http://localhost:5000'
            ], 503);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Server error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Mendapatkan daftar mobil terbaru yang terdeteksi
     */
    public function getLatestCars()
    {
        try {
            $response = Http::timeout(10)->get($this->pythonApiUrl . '/latest-cars');
            
            if ($response->successful()) {
                return response()->json($response->json());
            }
            
            return response()->json([
                'success' => false,
                'error' => 'Failed to fetch latest cars',
                'message' => 'Tidak dapat mengambil data dari Python API'
            ], 500);
            
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            return response()->json([
                'success' => false,
                'error' => 'Connection failed',
                'message' => 'Tidak dapat terhubung ke Python API. Pastikan API berjalan di http://localhost:5000'
            ], 503);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Server error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Health check untuk Python API
     */
    public function healthCheck()
    {
        try {
            $response = Http::timeout(5)->get($this->pythonApiUrl . '/health');
            
            if ($response->successful()) {
                return response()->json([
                    'success' => true,
                    'status' => 'connected',
                    'data' => $response->json()
                ]);
            }
            
            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => 'API tidak merespon dengan benar'
            ], 500);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status' => 'disconnected',
                'message' => 'Tidak dapat terhubung ke Python API'
            ], 503);
        }
    }
}
