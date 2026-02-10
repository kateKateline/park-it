<x-layouts.petugas :title="'Karcis Parkir - ' . $transaksi->qr_code">
    <div class="space-y-6">
        @include('partials.flash')

        <div
            id="karcis-print"
            class="mx-auto max-w-xs rounded-xl border border-dashed border-slate-300 bg-white p-4 text-center shadow-sm"
        >
            <!-- Header -->
            <div class="mb-3">
                <h1 class="text-lg font-bold tracking-wide">PARK-IT</h1>
                <p class="text-[10px] uppercase tracking-widest text-slate-500">
                    Parking Ticket
                </p>
            </div>

            <!-- Info -->
            <div class="space-y-1 text-xs text-left">
                <div class="flex justify-between">
                    <span>Ticket Code</span>
                    <span class="font-mono font-semibold">
                        {{ $transaksi->qr_code }}
                    </span>
                </div>

                <div class="flex justify-between">
                    <span>Date</span>
                    <span>{{ $transaksi->waktu_masuk->format('d M Y') }}</span>
                </div>

                <div class="flex justify-between">
                    <span>Time</span>
                    <span>{{ $transaksi->waktu_masuk->format('H:i:s') }}</span>
                </div>

                <div class="flex justify-between">
                    <span>Vehicle</span>
                    <span>{{ ucfirst($transaksi->kendaraan->jenis_kendaraan) }}</span>
                </div>

                <div class="flex justify-between">
                    <span>Plate</span>
                    <span>{{ $transaksi->kendaraan->plat_nomor }}</span>
                </div>

                <div class="flex justify-between">
                    <span>Area</span>
                    <span>{{ $transaksi->areaParkir->nama_area }}</span>
                </div>

                <div class="flex justify-between">
                    <span>Officer</span>
                    <span>{{ $transaksi->petugas->name }}</span>
                </div>
            </div>

            <!-- Barcode (dipisah & aman) -->
            <div class="my-4 pt-3 border-t border-dashed">
                <img
                    src="https://bwipjs-api.metafloor.com/?bcid=code128&text={{ urlencode($transaksi->qr_code) }}&scale=2&height=10&includetext&textxalign=center"
                    alt="Barcode Karcis"
                    class="w-full"
                />
            </div>

            <!-- Footer -->
            <div class="text-[10px] text-slate-500">
                <p>JANGAN MENINGGALKAN KARCIS</p>
                <p>DAN BARANG BERHARGA</p>
                <p>DI DALAM KENDARAAN ANDA</p>
            </div>
        </div>

        <div class="flex flex-wrap justify-center gap-3">
            <button
                type="button"
                onclick="window.print()"
                class="rounded-xl bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700"
            >
                <i class="fas fa-print mr-2"></i>
                Cetak Karcis
            </button>
        </div>
    </div>

    <style media="print">
        body * { visibility: hidden; }
        #karcis-print, #karcis-print * { visibility: visible; }
        #karcis-print { position: absolute; left: 0; top: 0; width: 100%; }
    </style>
</x-layouts.petugas>
