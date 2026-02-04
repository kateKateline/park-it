<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AreaParkir;
use App\Models\Kendaraan;
use App\Models\LogAktivitas;
use App\Models\Tarif;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $today = now()->toDateString();

        return view('admin.dashboard', [
            'user' => $request->user(),
            'counts' => [
                'users' => User::count(),
                'tarif' => Tarif::count(),
                'area' => AreaParkir::count(),
                'kendaraan' => Kendaraan::count(),
            ],
            'kpi' => [
                'transaksi_aktif' => Transaksi::where('status', 'masuk')->count(),
                'transaksi_hari_ini' => Transaksi::whereDate('waktu_masuk', $today)->count(),
                'pendapatan_hari_ini' => (int) Transaksi::where('status', 'selesai')
                    ->whereDate('waktu_keluar', $today)
                    ->sum('total_bayar'),
                'kapasitas_total' => (int) AreaParkir::sum('kapasitas'),
            ],
            'areas' => $this->getAreaOccupancy(),
            'recent' => [
                'users' => User::latest('id')->limit(8)->get(),
                'tarif' => Tarif::latest('id')->limit(8)->get(),
                'area' => AreaParkir::latest('id')->limit(8)->get(),
                'kendaraan' => Kendaraan::latest('id')->limit(8)->get(),
                'logs' => LogAktivitas::with('user')->latest('id')->limit(5)->get(),
                'transaksi' => Transaksi::with(['kendaraan', 'areaParkir', 'petugas'])
                    ->latest('id')
                    ->limit(8)
                    ->get(),
            ],
        ]);
    }

    private function getAreaOccupancy()
    {
        return AreaParkir::select('id', 'nama_area', 'kapasitas')
            ->get()
            ->map(function ($area) {
                $occupied = Transaksi::where('area_parkir_id', $area->id)
                    ->where('status', 'masuk')
                    ->count();
                
                $percentage = $area->kapasitas > 0 ? round(($occupied / $area->kapasitas) * 100) : 0;
                
                $barColor = match (true) {
                    $percentage >= 80 => 'bg-red-500',
                    $percentage >= 60 => 'bg-orange-500',
                    $percentage >= 40 => 'bg-yellow-500',
                    default => 'bg-emerald-500'
                };
                
                $statusText = match (true) {
                    $percentage >= 80 => 'Penuh',
                    $percentage >= 60 => 'Hampir Penuh',
                    $percentage >= 40 => 'Sedang',
                    default => 'Sepi'
                };
                
                return [
                    'id' => $area->id,
                    'nama_area' => $area->nama_area,
                    'kapasitas' => $area->kapasitas,
                    'occupied' => $occupied,
                    'percentage' => $percentage,
                    'bar_color' => $barColor,
                    'status_text' => $statusText,
                ];
            });
    }
}

