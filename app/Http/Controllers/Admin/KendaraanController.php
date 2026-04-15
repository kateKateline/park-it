<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kendaraan;
use App\Models\LogAktivitas;
use App\Support\VehicleTypeDisplay;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rule;

class KendaraanController extends Controller
{
    public function index(Request $request)
    {
        $q = (string) $request->query('q', '');

        $items = Kendaraan::query()
            ->when($q !== '', fn ($query) => $query->where(function ($sub) use ($q) {
                $sub->where('plat_nomor', 'like', "%{$q}%")
                    ->orWhere('jenis_kendaraan', 'like', "%{$q}%")
                    ->orWhere('warna', 'like', "%{$q}%")
                    ->orWhere('merk', 'like', "%{$q}%")
                    ->orWhere('pemilik', 'like', "%{$q}%");
            }))
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
        $allowedJenis = VehicleTypeDisplay::allowedJenisFromTarif();
        $vehicleTypeOptions = VehicleTypeDisplay::optionsFromTarifs();
        $jenisPrefill = null;
        if (is_array($latestDetection) && ! empty($latestDetection['vehicle_type'] ?? null)) {
            $jenisPrefill = VehicleTypeDisplay::mapYoloToAllowedJenis((string) $latestDetection['vehicle_type'], $allowedJenis);
        }

        return view('admin.kendaraan.form', [
            'user' => $request->user(),
            'model' => new Kendaraan(),
            'mode' => 'create',
            'latestDetection' => $latestDetection,
            'vehicleTypeOptions' => $vehicleTypeOptions,
            'jenisPrefill' => $jenisPrefill,
        ]);
    }

    public function store(Request $request)
    {
        $allowedJenis = VehicleTypeDisplay::allowedJenisFromTarif();
        if ($allowedJenis === []) {
            return back()
                ->withInput()
                ->with('error', 'Belum ada tarif jenis kendaraan. Tambahkan data Tarif terlebih dahulu.');
        }

        $data = $request->validate([
            'plat_nomor' => ['required', 'string', 'min:3', 'max:10', 'unique:tb_kendaraan,plat_nomor'],
            'warna' => ['nullable', 'string', 'max:255'],
            'jenis_kendaraan' => ['required', 'string', 'max:255', Rule::in($allowedJenis)],
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
            'vehicleTypeOptions' => VehicleTypeDisplay::optionsFromTarifs(),
            'jenisPrefill' => null,
        ]);
    }

    public function update(Request $request, Kendaraan $kendaraan)
    {
        $allowedJenis = VehicleTypeDisplay::allowedJenisFromTarif();
        if ($allowedJenis === []) {
            return back()
                ->withInput()
                ->with('error', 'Belum ada tarif jenis kendaraan. Tambahkan data Tarif terlebih dahulu.');
        }

        $data = $request->validate([
            'plat_nomor' => ['required', 'string', 'min:3', 'max:10', 'unique:tb_kendaraan,plat_nomor,' . $kendaraan->id],
            'warna' => ['nullable', 'string', 'max:255'],
            'jenis_kendaraan' => ['required', 'string', 'max:255', Rule::in($allowedJenis)],
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
        $kendaraan->is_tangguhkan = !$kendaraan->is_tangguhkan;
        $kendaraan->save();

        $status = $kendaraan->is_tangguhkan ? 'ditangguhkan' : 'diaktifkan';

        LogAktivitas::create([
            'user_id' => $request->user()->id,
            'aktivitas' => "CRUD Kendaraan: {$status} kendaraan #{$kendaraan->id} ({$kendaraan->plat_nomor})",
        ]);

        return back()->with('success', "Kendaraan berhasil {$status}.");
    }

    public function bulkDestroy(Request $request)
    {
        $data = $request->validate([
            'selected_ids' => ['required', 'array', 'min:1'],
            'selected_ids.*' => ['integer', Rule::exists('tb_kendaraan', 'id')],
        ]);

        $ids = array_values(array_unique(array_map('intval', $data['selected_ids'])));
        $items = Kendaraan::whereIn('id', $ids)->get();

        if ($items->isEmpty()) {
            return back()->with('error', 'Data kendaraan yang dipilih tidak ditemukan.');
        }

        // Kita tangguhkan semuanya (set is_tangguhkan = true)
        Kendaraan::whereIn('id', $items->pluck('id'))->update(['is_tangguhkan' => true]);

        $plats = $items->pluck('plat_nomor')->all();
        $count = $items->count();

        LogAktivitas::create([
            'user_id' => $request->user()->id,
            'aktivitas' => 'CRUD Kendaraan: tangguhkan massal '.$count.' kendaraan ('.implode(', ', $plats).')',
        ]);

        return back()->with('success', $count.' kendaraan berhasil ditangguhkan.');
    }
}
