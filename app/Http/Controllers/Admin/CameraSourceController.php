<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CameraSource;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;

class CameraSourceController extends Controller
{
    public function index(Request $request)
    {
        $items = CameraSource::orderBy('id', 'desc')->paginate(10);

        return view('admin.camera-sources.index', [
            'user' => $request->user(),
            'items' => $items,
        ]);
    }

    public function create(Request $request)
    {
        return view('admin.camera-sources.form', [
            'user' => $request->user(),
            'model' => new CameraSource(),
            'mode' => 'create',
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'stream_url' => ['required', 'url', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['is_active'] = $request->boolean('is_active');

        $created = CameraSource::create($data);

        LogAktivitas::create([
            'user_id' => $request->user()->id,
            'aktivitas' => "CRUD Camera Source: membuat kamera #{$created->id} ({$created->name})",
        ]);

        return redirect()->route('admin.camera-sources.index')->with('success', 'Kamera berhasil ditambahkan.');
    }

    public function edit(Request $request, CameraSource $camera_source)
    {
        return view('admin.camera-sources.form', [
            'user' => $request->user(),
            'model' => $camera_source,
            'mode' => 'edit',
        ]);
    }

    public function update(Request $request, CameraSource $camera_source)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'stream_url' => ['required', 'url', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['is_active'] = $request->boolean('is_active');

        $camera_source->update($data);

        LogAktivitas::create([
            'user_id' => $request->user()->id,
            'aktivitas' => "CRUD Camera Source: mengubah kamera #{$camera_source->id} ({$camera_source->name})",
        ]);

        return redirect()->route('admin.camera-sources.index')->with('success', 'Kamera berhasil diperbarui.');
    }

    public function destroy(Request $request, CameraSource $camera_source)
    {
        $id = $camera_source->id;
        $name = $camera_source->name;

        $camera_source->delete();

        LogAktivitas::create([
            'user_id' => $request->user()->id,
            'aktivitas' => "CRUD Camera Source: menghapus kamera #{$id} ({$name})",
        ]);

        return redirect()->route('admin.camera-sources.index')->with('success', 'Kamera berhasil dihapus.');
    }
}

