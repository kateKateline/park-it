<x-layouts.petugas :title="'Karcis Parkir - ' . $transaksi->qr_code">
    <div class="space-y-6">
        @include('partials.flash')

        <div class="rounded-2xl border-2 border-dashed border-slate-300 bg-white p-6 shadow-sm max-w-md mx-auto" id="karcis-print">
            <div class="text-center mb-6">
                <h1 class="text-xl font-bold text-slate-900">PARK-IT</h1>
                <p class="text-xs text-slate-500">Karcis Parkir</p>
            </div>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-slate-600">Kode Karcis</span>
                    <span class="font-mono font-bold text-lg">{{ $transaksi->qr_code }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-600">Plat Nomor</span>
                    <span class="font-semibold">{{ $transaksi->kendaraan->plat_nomor }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-600">Jenis</span>
                    <span>{{ ucfirst($transaksi->kendaraan->jenis_kendaraan) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-600">Area</span>
                    <span>{{ $transaksi->areaParkir->nama_area }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-600">Waktu Masuk</span>
                    <span>{{ $transaksi->waktu_masuk->format('d/m/Y H:i') }}</span>
                </div>
            </div>
            <p class="mt-6 text-xs text-slate-500 text-center">
                Simpan karcis ini. Tunjukkan saat keluar untuk pembayaran.
            </p>
        </div>

        <div class="flex flex-wrap gap-3 justify-center">
            <button type="button" onclick="window.print()" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-xl hover:bg-blue-700 transition">
                <i class="fas fa-print mr-2"></i>Cetak Karcis
            </button>
            <a href="{{ route('petugas.transaksi.masuk') }}" class="px-4 py-2 bg-slate-100 text-slate-700 text-sm font-medium rounded-xl hover:bg-slate-200 transition">
                Transaksi Masuk Baru
            </a>
            <a href="{{ route('petugas.dashboard') }}" class="px-4 py-2 bg-slate-100 text-slate-700 text-sm font-medium rounded-xl hover:bg-slate-200 transition">
                Dashboard
            </a>
        </div>
    </div>

    <style media="print">
        body * { visibility: hidden; }
        #karcis-print, #karcis-print * { visibility: visible; }
        #karcis-print { position: absolute; left: 0; top: 0; width: 100%; }
    </style>
</x-layouts.petugas>
