<x-layouts.app :title="$mode === 'create' ? 'Tambah Tarif - Admin' : 'Edit Tarif - Admin'">
    <div class="mx-auto max-w-3xl p-6">
        @include('partials.topbar', [
            'title' => $mode === 'create' ? 'Tambah Tarif' : 'Edit Tarif',
            'subtitle' => 'CRUD Tarif Parkir (Admin).',
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
                  action="{{ $mode === 'create' ? route('admin.tarif.store') : route('admin.tarif.update', $model) }}"
                  class="space-y-4 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                @csrf
                @if ($mode === 'edit')
                    @method('PUT')
                @endif

                <div>
                    <label class="block text-sm font-medium text-slate-700">Jenis Kendaraan</label>
                    <input name="jenis_kendaraan" value="{{ old('jenis_kendaraan', $model->jenis_kendaraan) }}"
                           class="mt-1 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm outline-none focus:border-slate-900 focus:ring-2 focus:ring-slate-900/10"
                           required />
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700">Tarif Per Jam</label>
                    <input name="tarif_per_jam" type="number" value="{{ old('tarif_per_jam', $model->tarif_per_jam) }}"
                           class="mt-1 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm outline-none focus:border-slate-900 focus:ring-2 focus:ring-slate-900/10"
                           required />
                </div>

                <div class="flex items-center justify-end gap-2 pt-2">
                    <a href="{{ route('admin.tarif.index') }}"
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
</x-layouts.app>

