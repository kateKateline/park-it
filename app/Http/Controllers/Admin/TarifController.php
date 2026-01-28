<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LogAktivitas;
use App\Models\Tarif;
use Illuminate\Http\Request;

class TarifController extends Controller
{
    public function index(Request $request)
    {
        $tarif = Tarif::orderBy('id', 'desc')->paginate(10);

        return view('admin.tarif.index', [
            'user' => $request->user(),
            'tarif' => $tarif,
        ]);
    }

    public function create(Request $request)
    {
        return view('admin.tarif.form', [
            'user' => $request->user(),
            'model' => new Tarif(),
            'mode' => 'create',
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'jenis_kendaraan' => ['required', 'string', 'max:255'],
            'tarif_per_jam' => ['required', 'integer', 'min:0'],
        ]);

        $created = Tarif::create($data);

        LogAktivitas::create([
            'user_id' => $request->user()->id,
            'aktivitas' => "CRUD Tarif: membuat tarif #{$created->id} ({$created->jenis_kendaraan})",
        ]);

        return redirect()->route('admin.tarif.index')->with('success', 'Tarif berhasil dibuat.');
    }

    public function edit(Request $request, Tarif $tarif)
    {
        return view('admin.tarif.form', [
            'user' => $request->user(),
            'model' => $tarif,
            'mode' => 'edit',
        ]);
    }

    public function update(Request $request, Tarif $tarif)
    {
        $data = $request->validate([
            'jenis_kendaraan' => ['required', 'string', 'max:255'],
            'tarif_per_jam' => ['required', 'integer', 'min:0'],
        ]);

        $tarif->update($data);

        LogAktivitas::create([
            'user_id' => $request->user()->id,
            'aktivitas' => "CRUD Tarif: mengubah tarif #{$tarif->id} ({$tarif->jenis_kendaraan})",
        ]);

        return redirect()->route('admin.tarif.index')->with('success', 'Tarif berhasil diperbarui.');
    }

    public function destroy(Request $request, Tarif $tarif)
    {
        $id = $tarif->id;
        $jenis = $tarif->jenis_kendaraan;
        $tarif->delete();

        LogAktivitas::create([
            'user_id' => $request->user()->id,
            'aktivitas' => "CRUD Tarif: menghapus tarif #{$id} ({$jenis})",
        ]);

        return redirect()->route('admin.tarif.index')->with('success', 'Tarif berhasil dihapus.');
    }
}

