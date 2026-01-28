<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kendaraan;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;

class KendaraanController extends Controller
{
    public function index(Request $request)
    {
        $q = (string) $request->query('q', '');

        $items = Kendaraan::query()
            ->when($q !== '', fn ($query) => $query
                ->where('plat_nomor', 'like', "%{$q}%")
                ->orWhere('jenis_kendaraan', 'like', "%{$q}%")
                ->orWhere('warna', 'like', "%{$q}%")
                ->orWhere('merk', 'like', "%{$q}%")
                ->orWhere('pemilik', 'like', "%{$q}%")
            )
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.kendaraan.index', [
            'user' => $request->user(),
            'items' => $items,
            'q' => $q,
        ]);
    }

    public function create(Request $request)
    {
        return view('admin.kendaraan.form', [
            'user' => $request->user(),
            'model' => new Kendaraan(),
            'mode' => 'create',
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'plat_nomor' => ['required', 'string', 'max:255', 'unique:tb_kendaraan,plat_nomor'],
            'warna' => ['nullable', 'string', 'max:255'],
            'jenis_kendaraan' => ['required', 'string', 'max:255'],
            'merk' => ['nullable', 'string', 'max:255'],
            'pemilik' => ['nullable', 'string', 'max:255'],
            'is_terdaftar' => ['nullable', 'boolean'],
        ]);

        $data['is_terdaftar'] = (bool) ($data['is_terdaftar'] ?? false);

        $created = Kendaraan::create($data);

        LogAktivitas::create([
            'user_id' => $request->user()->id,
            'aktivitas' => "CRUD Kendaraan: membuat kendaraan #{$created->id} ({$created->plat_nomor})",
        ]);

        return redirect()->route('admin.kendaraan.index')->with('success', 'Kendaraan berhasil dibuat.');
    }

    public function edit(Request $request, Kendaraan $kendaraan)
    {
        return view('admin.kendaraan.form', [
            'user' => $request->user(),
            'model' => $kendaraan,
            'mode' => 'edit',
        ]);
    }

    public function update(Request $request, Kendaraan $kendaraan)
    {
        $data = $request->validate([
            'plat_nomor' => ['required', 'string', 'max:255', 'unique:tb_kendaraan,plat_nomor,' . $kendaraan->id],
            'warna' => ['nullable', 'string', 'max:255'],
            'jenis_kendaraan' => ['required', 'string', 'max:255'],
            'merk' => ['nullable', 'string', 'max:255'],
            'pemilik' => ['nullable', 'string', 'max:255'],
            'is_terdaftar' => ['nullable', 'boolean'],
        ]);

        $data['is_terdaftar'] = (bool) ($data['is_terdaftar'] ?? false);

        $kendaraan->update($data);

        LogAktivitas::create([
            'user_id' => $request->user()->id,
            'aktivitas' => "CRUD Kendaraan: mengubah kendaraan #{$kendaraan->id} ({$kendaraan->plat_nomor})",
        ]);

        return redirect()->route('admin.kendaraan.index')->with('success', 'Kendaraan berhasil diperbarui.');
    }

    public function destroy(Request $request, Kendaraan $kendaraan)
    {
        $id = $kendaraan->id;
        $plat = $kendaraan->plat_nomor;
        $kendaraan->delete();

        LogAktivitas::create([
            'user_id' => $request->user()->id,
            'aktivitas' => "CRUD Kendaraan: menghapus kendaraan #{$id} ({$plat})",
        ]);

        return redirect()->route('admin.kendaraan.index')->with('success', 'Kendaraan berhasil dihapus.');
    }
}

