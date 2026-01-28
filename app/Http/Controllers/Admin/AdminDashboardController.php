<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AreaParkir;
use App\Models\Kendaraan;
use App\Models\Tarif;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        return view('admin.dashboard', [
            'user' => $request->user(),
            'counts' => [
                'users' => User::count(),
                'tarif' => Tarif::count(),
                'area' => AreaParkir::count(),
                'kendaraan' => Kendaraan::count(),
            ],
        ]);
    }
}

