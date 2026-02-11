<x-layouts.petugas :title="'Dashboard - Petugas'">
    <div class="space-y-6">
        @include('partials.flash')

        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-900">Dashboard Petugas</h2>
            <span class="text-sm text-gray-600">{{ now()->format('d F Y, H:i') }}</span>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <div class="text-sm text-gray-600">Transaksi hari ini</div>
                <div class="mt-1 text-2xl font-semibold">{{ $counts['hari_ini'] }}</div>
            </div>
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <div class="text-sm text-gray-600">Sedang parkir</div>
                <div class="mt-1 text-2xl font-semibold">{{ $counts['sedang_parkir'] }}</div>
            </div>
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <div class="text-sm text-gray-600">Selesai hari ini</div>
                <div class="mt-1 text-2xl font-semibold">{{ $counts['selesai'] }}</div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <a href="{{ route('petugas.transaksi.masuk') }}"
               class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm hover:border-blue-300 hover:shadow-md transition flex items-center gap-4 group">
                <div class="w-14 h-14 rounded-xl bg-blue-100 flex items-center justify-center group-hover:bg-blue-200 transition">
                    <i class="fas fa-sign-in-alt text-2xl text-blue-600"></i>
                </div>
                <div class="flex-1">
                    <h3 class="font-semibold text-gray-900">Kendaraan Masuk</h3>
                    <p class="text-sm text-gray-600 mt-1">Isi form kendaraan, pilih area, generate karcis</p>
                </div>
                <i class="fas fa-chevron-right text-gray-400 group-hover:text-blue-600"></i>
            </a>
            <a href="{{ route('petugas.transaksi.keluar') }}"
               class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm hover:border-emerald-300 hover:shadow-md transition flex items-center gap-4 group">
                <div class="w-14 h-14 rounded-xl bg-emerald-100 flex items-center justify-center group-hover:bg-emerald-200 transition">
                    <i class="fas fa-sign-out-alt text-2xl text-emerald-600"></i>
                </div>
                <div class="flex-1">
                    <h3 class="font-semibold text-gray-900">Kendaraan Keluar</h3>
                    <p class="text-sm text-gray-600 mt-1">Scan karcis, hitung tarif, terima pembayaran</p>
                </div>
                <i class="fas fa-chevron-right text-gray-400 group-hover:text-emerald-600"></i>
            </a>
        </div>

        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <h3 class="font-semibold text-gray-900">Daftar Transaksi</h3>
                    <p class="text-sm text-gray-600 mt-1">Lihat semua transaksi masuk & keluar</p>
                </div>
                <a href="{{ route('petugas.transaksi.index') }}"
                   class="rounded-xl bg-gray-900 px-4 py-2 text-sm font-semibold text-white hover:bg-gray-800 transition">
                    Buka Daftar
                </a>
            </div>
        </div>

        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <h3 class="font-semibold text-gray-900">Monitoring Kamera</h3>
                    <p class="text-sm text-gray-600 mt-1">Pantau stream kamera parkir di halaman khusus.</p>
                </div>
                <a href="{{ route('petugas.kamera.index') }}"
                   class="rounded-xl bg-gray-900 px-4 py-2 text-sm font-semibold text-white hover:bg-gray-800 transition inline-flex items-center gap-2">
                    <i class="fas fa-video"></i>
                    Buka Kamera
                </a>
            </div>
        </div>
    </div>
</x-layouts.petugas>
