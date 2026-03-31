<x-layouts.petugas :title="'Kendaraan Keluar - Petugas'">
    <div class="space-y-6">
        @include('partials.flash')

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-slate-900">
                    <i class="fas fa-sign-out-alt text-emerald-600 mr-2"></i>
                    Kendaraan Keluar
                </h2>
                <span class="text-xs text-slate-500">{{ now()->format('d F Y, H:i') }}</span>
            </div>
            <p class="text-sm text-slate-600 mb-6">Scan atau masukkan kode karcis saat pengendara mengembalikan karcis. Tarif akan dihitung otomatis.</p>

            <form action="{{ route('petugas.transaksi.keluar.scan') }}" method="POST" class="space-y-4" enctype="multipart/form-data">
                @csrf
                <div>
                    <label for="kode_karcis" class="block text-sm font-medium text-slate-700">Kode Karcis</label>
                    <div class="relative mt-1">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                            <i class="fas fa-qrcode text-sm"></i>
                        </div>
                        <input type="text" name="kode_karcis" id="kode_karcis" required
                               value="{{ old('kode_karcis') }}"
                               placeholder="PARK-XXXXXXXXXX"
                               autofocus
                               class="w-full rounded-xl border border-slate-300 bg-white py-2 pl-10 pr-3 text-sm outline-none focus:border-slate-900 focus:ring-2 focus:ring-slate-900/10 font-mono tracking-wider" />
                    </div>
                    @error('kode_karcis')
                        <div class="mt-1 rounded-xl border border-red-200 bg-red-50 px-3 py-2 text-xs text-red-800">{{ $message }}</div>
                    @enderror
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                    <div class="flex items-start gap-3">
                        <div class="mt-0.5 flex h-10 w-10 items-center justify-center rounded-xl bg-slate-900/5 text-slate-700">
                            <i class="fas fa-camera text-sm"></i>
                        </div>
                        <div class="flex-1">
                            <div class="text-sm font-semibold text-slate-900">Scan via gambar</div>
                            <div class="mt-1 text-xs text-slate-500">Alternatif: upload foto karcis untuk scan QR.</div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <input type="file" name="karcis_file" accept="image/*" capture="environment"
                               class="block w-full text-sm text-slate-600 file:mr-4 file:rounded-xl file:border-0 file:bg-slate-900 file:px-4 file:py-2 file:text-xs file:font-semibold file:text-white hover:file:bg-slate-800" />
                    </div>
                </div>

                <div class="flex items-center gap-2 justify-end pt-2">
                    <a href="{{ route('petugas.dashboard') }}"
                       class="rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm font-medium hover:bg-slate-50">
                        Batal
                    </a>
                    <button class="rounded-xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700">
                        Cari & Hitung Tarif
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.petugas>
