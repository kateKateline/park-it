<x-layouts.admin :title="$mode === 'create' ? 'Tambah Sumber Kamera - Admin' : 'Edit Sumber Kamera - Admin'">
    <div class="mx-auto max-w-3xl p-6">
        @include('partials.topbar', [
            'title' => $mode === 'create' ? 'Tambah Sumber Kamera' : 'Edit Sumber Kamera',
            'subtitle' => 'CRUD sumber kamera (Admin). Admin hanya mengatur data, bukan preview video.',
        ])

        <div class="mt-6 space-y-4">
            @include('partials.flash')

            @if ($errors->any())
                <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                    <div class="font-medium">Validasi gagal</div>
                    <ul class="mt-1 list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST"
                  action="{{ $mode === 'create' ? route('admin.camera-sources.store') : route('admin.camera-sources.update', $model) }}"
                  class="space-y-4 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                @csrf
                @if ($mode === 'edit')
                    @method('PUT')
                @endif

                <div>
                    <label class="block text-sm font-medium text-slate-700">Nama Kamera</label>
                    <input name="name"
                           value="{{ old('name', $model->name) }}"
                           class="mt-1 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm outline-none focus:border-slate-900 focus:ring-2 focus:ring-slate-900/10"
                           required />
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700">Stream URL</label>
                    <input name="stream_url"
                           type="url"
                           value="{{ old('stream_url', $model->stream_url) }}"
                           placeholder="http://192.168.1.25:8080/video"
                           class="mt-1 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm outline-none focus:border-slate-900 focus:ring-2 focus:ring-slate-900/10 font-mono"
                           required />
                    <p class="mt-1 text-xs text-slate-500">
                        Pastikan URL dapat diakses dari server (mis: IP Webcam / HP di jaringan lokal).
                    </p>
                </div>

                <div class="flex items-center gap-2">
                    <input id="is_active"
                           name="is_active"
                           type="checkbox"
                           value="1"
                           @checked(old('is_active', $model->is_active ?? true))
                           class="h-4 w-4 rounded border-slate-300 text-slate-900 focus:ring-slate-900/20" />
                    <label for="is_active" class="text-sm font-medium text-slate-700">
                        Aktif (ditampilkan ke petugas)
                    </label>
                </div>

                <div class="flex items-center justify-end gap-2 pt-2">
                    <a href="{{ route('admin.camera-sources.index') }}"
                       class="rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm font-medium hover:bg-slate-50">
                        Batal
                    </a>
                    <button class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.admin>

