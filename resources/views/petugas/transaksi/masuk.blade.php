<x-layouts.petugas :title="'Kendaraan Masuk - Petugas'">
    <div class="space-y-6">
        @include('partials.flash')

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-slate-900">
                    <i class="fas fa-sign-in-alt text-blue-600 mr-2"></i>
                    Kendaraan Masuk
                </h2>
                <span class="text-xs text-slate-500">{{ now()->format('d F Y, H:i') }}</span>
            </div>
            <p class="text-sm text-slate-600 mb-6">Isi form saat kendaraan datang. Karcis akan digenerate untuk diberikan ke pengendara.</p>

            <form action="{{ route('petugas.transaksi.masuk.store') }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="plat_nomor" class="block text-sm font-medium text-slate-700">Plat Nomor</label>
                        <input type="text" name="plat_nomor" id="plat_nomor" required
                               value="{{ old('plat_nomor') }}"
                               placeholder="B 1234 XYZ"
                               class="mt-1 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm outline-none focus:border-slate-900 focus:ring-2 focus:ring-slate-900/10 uppercase tracking-wider" />
                        @error('plat_nomor')
                            <div class="mt-1 rounded-xl border border-red-200 bg-red-50 px-3 py-2 text-xs text-red-800">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label for="jenis_kendaraan" class="block text-sm font-medium text-slate-700">Jenis Kendaraan</label>
                        <select name="jenis_kendaraan" id="jenis_kendaraan" required
                                class="mt-1 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm outline-none focus:border-slate-900 focus:ring-2 focus:ring-slate-900/10">
                            <option value="">Pilih</option>
                            <option value="motor" {{ old('jenis_kendaraan') === 'motor' ? 'selected' : '' }}>Motor</option>
                            <option value="mobil" {{ old('jenis_kendaraan') === 'mobil' ? 'selected' : '' }}>Mobil</option>
                        </select>
                        @error('jenis_kendaraan')
                            <div class="mt-1 rounded-xl border border-red-200 bg-red-50 px-3 py-2 text-xs text-red-800">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label for="warna" class="block text-sm font-medium text-slate-700">Warna</label>
                        <input type="text" name="warna" id="warna"
                               value="{{ old('warna') }}"
                               placeholder="Hitam"
                               class="mt-1 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm outline-none focus:border-slate-900 focus:ring-2 focus:ring-slate-900/10" />
                    </div>
                    <div>
                        <label for="merk" class="block text-sm font-medium text-slate-700">Merk</label>
                        <input type="text" name="merk" id="merk"
                               value="{{ old('merk') }}"
                               placeholder="Honda, Toyota"
                               class="mt-1 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm outline-none focus:border-slate-900 focus:ring-2 focus:ring-slate-900/10" />
                    </div>
                    <div class="md:col-span-2">
                        <label for="area_parkir_id" class="block text-sm font-medium text-slate-700">Area Parkir</label>
                        <select name="area_parkir_id" id="area_parkir_id" required
                                class="mt-1 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm outline-none focus:border-slate-900 focus:ring-2 focus:ring-slate-900/10">
                            <option value="">Pilih area</option>
                            @foreach ($areas as $a)
                                <option value="{{ $a->id }}" {{ old('area_parkir_id') == $a->id ? 'selected' : '' }}>
                                    {{ $a->nama_area }} (Kapasitas: {{ $a->kapasitas }})
                                </option>
                            @endforeach
                        </select>
                        @error('area_parkir_id')
                            <div class="mt-1 rounded-xl border border-red-200 bg-red-50 px-3 py-2 text-xs text-red-800">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="flex items-center gap-2 justify-end pt-2">
                    <a href="{{ route('petugas.dashboard') }}"
                       class="rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm font-medium hover:bg-slate-50">
                        Batal
                    </a>
                    <button class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">
                        Generate Karcis
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.petugas>
