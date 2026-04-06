<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class AdminTransaksiController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));

        $items = Transaksi::query()
            ->with(['kendaraan', 'areaParkir', 'petugas'])
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('barcode', 'like', "%{$q}%")
                        ->orWhere('status', 'like', "%{$q}%")
                        ->orWhereHas('kendaraan', fn ($k) => $k->where('plat_nomor', 'like', "%{$q}%"))
                        ->orWhereHas('areaParkir', fn ($a) => $a->where('nama_area', 'like', "%{$q}%"))
                        ->orWhereHas('petugas', function ($p) use ($q) {
                            $p->where('name', 'like', "%{$q}%")
                                ->orWhere('username', 'like', "%{$q}%");
                        });
                });
            })
            ->orderBy('id', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('admin.transaksi.index', [
            'items' => $items,
            'q' => $q,
        ]);
    }
}
