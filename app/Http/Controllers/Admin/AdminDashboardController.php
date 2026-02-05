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
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $today = now()->toDateString();
        $yesterday = now()->subDay()->toDateString();

        // Batch all counts in minimal queries
        $counts = [
            'users' => User::count(),
            'tarif' => Tarif::count(),
            'area' => AreaParkir::count(),
            'kendaraan' => Kendaraan::count(),
        ];

        $kapasitasTotal = (int) AreaParkir::sum('kapasitas');

        // Single query for all transaksi KPIs + yesterday comparisons
        $transaksiStats = DB::table('tb_transaksi')
            ->selectRaw("
                SUM(CASE WHEN status = 'masuk' THEN 1 ELSE 0 END) as transaksi_aktif,
                SUM(CASE WHEN DATE(waktu_masuk) = ? THEN 1 ELSE 0 END) as transaksi_hari_ini,
                SUM(CASE WHEN status = 'selesai' AND DATE(waktu_keluar) = ? THEN total_bayar ELSE 0 END) as pendapatan_hari_ini,
                SUM(CASE WHEN status = 'masuk' AND DATE(waktu_masuk) = ? THEN 1 ELSE 0 END) as transaksi_aktif_kemarin,
                SUM(CASE WHEN DATE(waktu_masuk) = ? THEN 1 ELSE 0 END) as transaksi_hari_ini_kemarin,
                SUM(CASE WHEN status = 'selesai' AND DATE(waktu_keluar) = ? THEN total_bayar ELSE 0 END) as pendapatan_kemarin
            ", [$today, $today, $yesterday, $yesterday, $yesterday])
            ->first();

        $kpi = [
            'transaksi_aktif' => (int) ($transaksiStats->transaksi_aktif ?? 0),
            'transaksi_hari_ini' => (int) ($transaksiStats->transaksi_hari_ini ?? 0),
            'pendapatan_hari_ini' => (int) ($transaksiStats->pendapatan_hari_ini ?? 0),
            'kapasitas_total' => $kapasitasTotal,
            'transaksi_aktif_kemarin' => (int) ($transaksiStats->transaksi_aktif_kemarin ?? 0),
            'transaksi_hari_ini_kemarin' => (int) ($transaksiStats->transaksi_hari_ini_kemarin ?? 0),
            'pendapatan_kemarin' => (int) ($transaksiStats->pendapatan_kemarin ?? 0),
        ];

        $areas = $this->getAreaOccupancy();

        $recent = [
            'users' => User::latest('id')->limit(8)->get(),
            'tarif' => Tarif::latest('id')->limit(8)->get(),
            'area' => AreaParkir::latest('id')->limit(8)->get(),
            'kendaraan' => Kendaraan::latest('id')->limit(8)->get(),
            'logs' => LogAktivitas::with('user')->latest('id')->limit(5)->get(),
            'transaksi' => Transaksi::with(['kendaraan', 'areaParkir', 'petugas'])
                ->latest('id')
                ->limit(8)
                ->get(),
        ];

        return view('admin.dashboard', [
            'user' => $request->user(),
            'counts' => $counts,
            'kpi' => $kpi,
            'areas' => $areas,
            'recent' => $recent,
        ]);
    }

    private function getAreaOccupancy(): array
    {
        $areas = AreaParkir::select('id', 'nama_area', 'kapasitas')->get();
        $occupiedByArea = DB::table('tb_transaksi')
            ->where('status', 'masuk')
            ->selectRaw('area_parkir_id, COUNT(*) as occupied')
            ->groupBy('area_parkir_id')
            ->pluck('occupied', 'area_parkir_id');

        return $areas->map(function ($area) use ($occupiedByArea) {
            $occupied = (int) ($occupiedByArea[$area->id] ?? 0);
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
        })->all();
    }
}

