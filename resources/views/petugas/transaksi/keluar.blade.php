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
                    <input type="text" name="kode_karcis" id="kode_karcis" required
                           value="{{ old('kode_karcis') }}"
                           placeholder="PARK-XXXXXXXXXX"
                           autofocus
                           class="mt-1 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm outline-none focus:border-slate-900 focus:ring-2 focus:ring-slate-900/10 font-mono tracking-wider" />
                    @error('kode_karcis')
                        <div class="mt-1 rounded-xl border border-red-200 bg-red-50 px-3 py-2 text-xs text-red-800">{{ $message }}</div>
                    @enderror
                </div>

                <div class="rounded-xl border border-dashed border-slate-300 p-4 bg-slate-50">
                    <p class="text-xs text-slate-500 mb-2">
                        <i class="fas fa-info-circle mr-1"></i>
                        Alternatif: Upload gambar karcis untuk scan barcode.
                    </p>
                    <input type="file" name="karcis_file" accept="image/*" capture="environment"
                           class="block w-full text-sm text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
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
