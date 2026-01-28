<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiDemoController extends Controller
{
    public function index(Request $request)
    {
        $items = Transaksi::with(['kendaraan', 'areaParkir', 'petugas'])
            ->orderBy('id', 'desc')
            ->paginate(15);

        return view('petugas.transaksi-demo', [
            'user' => $request->user(),
            'items' => $items,
        ]);
    }
}

