<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class OwnerDashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        return view('owner.dashboard', [
            'user' => $request->user(),
            'counts' => [
                'transaksi_selesai' => Transaksi::where('status', 'selesai')->count(),
                'transaksi_masuk' => Transaksi::where('status', 'masuk')->count(),
            ],
        ]);
    }
}

