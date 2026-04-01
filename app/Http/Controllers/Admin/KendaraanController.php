<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kendaraan;
use App\Models\LogAktivitas;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

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
        $latestDetection = Cache::get('latest_detection');

        return view('admin.kendaraan.form', [
            'user' => $request->user(),
            'model' => new Kendaraan(),
            'mode' => 'create',
            'latestDetection' => $latestDetection,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'plat_nomor' => ['required', 'string', 'min:3', 'max:10', 'unique:tb_kendaraan,plat_nomor'],
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
            'latestDetection' => null,
        ]);
    }

    public function update(Request $request, Kendaraan $kendaraan)
    {
        $data = $request->validate([
            'plat_nomor' => ['required', 'string', 'min:3', 'max:10', 'unique:tb_kendaraan,plat_nomor,' . $kendaraan->id],
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

        try {
            $kendaraan->delete();
        } catch (QueryException $e) {
            $sqlState = (string) ($e->errorInfo[0] ?? '');

            if ($sqlState === '23000') {
                return back()->with('error', "Kendaraan {$plat} tidak bisa dihapus karena masih dipakai di data lain.");
            }

            throw $e;
        }

        LogAktivitas::create([
            'user_id' => $request->user()->id,
            'aktivitas' => "CRUD Kendaraan: menghapus kendaraan #{$id} ({$plat})",
        ]);

        return back()->with('success', 'Kendaraan berhasil dihapus.');
    }
}
