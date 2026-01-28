<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AreaParkir;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;

class AreaParkirController extends Controller
{
    public function index(Request $request)
    {
        $items = AreaParkir::orderBy('id', 'desc')->paginate(10);

        return view('admin.area-parkir.index', [
            'user' => $request->user(),
            'items' => $items,
        ]);
    }

    public function create(Request $request)
    {
        return view('admin.area-parkir.form', [
            'user' => $request->user(),
            'model' => new AreaParkir(),
            'mode' => 'create',
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_area' => ['required', 'string', 'max:255'],
            'kapasitas' => ['required', 'integer', 'min:0'],
            'keterangan' => ['nullable', 'string'],
        ]);

        $created = AreaParkir::create($data);

        LogAktivitas::create([
            'user_id' => $request->user()->id,
            'aktivitas' => "CRUD Area Parkir: membuat area #{$created->id} ({$created->nama_area})",
        ]);

        return redirect()->route('admin.area-parkir.index')->with('success', 'Area parkir berhasil dibuat.');
    }

    public function edit(Request $request, AreaParkir $area_parkir)
    {
        return view('admin.area-parkir.form', [
            'user' => $request->user(),
            'model' => $area_parkir,
            'mode' => 'edit',
        ]);
    }

    public function update(Request $request, AreaParkir $area_parkir)
    {
        $data = $request->validate([
            'nama_area' => ['required', 'string', 'max:255'],
            'kapasitas' => ['required', 'integer', 'min:0'],
            'keterangan' => ['nullable', 'string'],
        ]);

        $area_parkir->update($data);

        LogAktivitas::create([
            'user_id' => $request->user()->id,
            'aktivitas' => "CRUD Area Parkir: mengubah area #{$area_parkir->id} ({$area_parkir->nama_area})",
        ]);

        return redirect()->route('admin.area-parkir.index')->with('success', 'Area parkir berhasil diperbarui.');
    }

    public function destroy(Request $request, AreaParkir $area_parkir)
    {
        $id = $area_parkir->id;
        $nama = $area_parkir->nama_area;
        $area_parkir->delete();

        LogAktivitas::create([
            'user_id' => $request->user()->id,
            'aktivitas' => "CRUD Area Parkir: menghapus area #{$id} ({$nama})",
        ]);

        return redirect()->route('admin.area-parkir.index')->with('success', 'Area parkir berhasil dihapus.');
    }
}

