<x-layouts.app :title="$mode === 'create' ? 'Tambah Kendaraan - Admin' : 'Edit Kendaraan - Admin'">
    <div class="mx-auto max-w-3xl p-6">
        @include('partials.topbar', [
            'title' => $mode === 'create' ? 'Tambah Kendaraan' : 'Edit Kendaraan',
            'subtitle' => 'CRUD Kendaraan (Admin).',
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
                  action="{{ $mode === 'create' ? route('admin.kendaraan.store') : route('admin.kendaraan.update', $model) }}"
                  class="space-y-4 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                @csrf
                @if ($mode === 'edit')
                    @method('PUT')
                @endif

                <div>
                    <label class="block text-sm font-medium text-slate-700">Plat Nomor</label>
                    <input name="plat_nomor" value="{{ old('plat_nomor', $model->plat_nomor) }}"
                           class="mt-1 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm outline-none focus:border-slate-900 focus:ring-2 focus:ring-slate-900/10"
                           required />
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Jenis Kendaraan</label>
                        <input name="jenis_kendaraan" value="{{ old('jenis_kendaraan', $model->jenis_kendaraan) }}"
                               placeholder="mobil / motor"
                               class="mt-1 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm outline-none focus:border-slate-900 focus:ring-2 focus:ring-slate-900/10"
                               required />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Warna (opsional)</label>
                        <input name="warna" value="{{ old('warna', $model->warna) }}"
                               class="mt-1 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm outline-none focus:border-slate-900 focus:ring-2 focus:ring-slate-900/10" />
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Merk (opsional)</label>
                        <input name="merk" value="{{ old('merk', $model->merk) }}"
                               class="mt-1 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm outline-none focus:border-slate-900 focus:ring-2 focus:ring-slate-900/10" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Pemilik (opsional)</label>
                        <input name="pemilik" value="{{ old('pemilik', $model->pemilik) }}"
                               class="mt-1 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm outline-none focus:border-slate-900 focus:ring-2 focus:ring-slate-900/10" />
                    </div>
                </div>

                <label class="flex items-center gap-2 text-sm">
                    <input type="checkbox" name="is_terdaftar" value="1"
                           class="h-4 w-4 rounded border-slate-300"
                           @checked(old('is_terdaftar', (bool) $model->is_terdaftar)) />
                    <span class="text-slate-700">Kendaraan terdaftar</span>
                </label>

                <div class="flex items-center justify-end gap-2 pt-2">
                    <a href="{{ route('admin.kendaraan.index') }}"
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

