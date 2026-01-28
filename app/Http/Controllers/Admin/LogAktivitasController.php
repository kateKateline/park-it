<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;

class LogAktivitasController extends Controller
{
    public function index(Request $request)
    {
        $items = LogAktivitas::with('user')
            ->orderBy('id', 'desc')
            ->paginate(15);

        return view('admin.log-aktivitas.index', [
            'user' => $request->user(),
            'items' => $items,
        ]);
    }
}

