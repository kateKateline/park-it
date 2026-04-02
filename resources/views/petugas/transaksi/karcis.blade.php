<x-layouts.petugas :title="'Karcis Parkir - ' . $transaksi->barcode">
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
                        {{ $transaksi->barcode }}
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
                    src="https://bwipjs-api.metafloor.com/?bcid=qrcode&text={{ urlencode($transaksi->barcode) }}&scale=5"
                    alt="QR Karcis"
                    class="mx-auto w-40"
                />
            </div>

            <!-- Footer -->
            <div class="text-[10px] text-slate-500">
                <p>JANGAN MENINGGALKAN KARCIS</p>
                <p>DAN BARANG BERHARGA</p>
                <p>DI DALAM KENDARAAN ANDA</p>
            </div>
        </div>

        <div class="flex flex-col items-center gap-3 sm:flex-row sm:justify-center">
            <a href="{{ route('petugas.transaksi.masuk') }}"
               class="rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm font-medium hover:bg-slate-50 inline-flex items-center gap-2">
                <i class="fas fa-arrow-left text-[12px]"></i>
                Kembali ke Masuk
            </a>
            <button
                type="button"
                onclick="window.print()"
                class="rounded-xl bg-blue-600 px-5 py-2 text-sm font-semibold text-white hover:bg-blue-700"
            >
                <i class="fas fa-print mr-2"></i>
                Cetak Karcis
            </button>
            <div class="text-xs text-slate-500">Tekan Enter untuk cetak</div>
        </div>
    </div>

    <script>
        (function () {
            var focusEl = document.getElementById('karcis-print');
            if (focusEl) focusEl.setAttribute('tabindex', '-1');
            if (focusEl) focusEl.focus();

            document.addEventListener('keydown', function (e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    window.print();
                }
            });
        })();
    </script>

    <style media="print">
        @page { size: 80mm auto; margin: 0; }
        html, body { width: 80mm; margin: 0; padding: 0; }
        body * { visibility: hidden; }
        #karcis-print, #karcis-print * { visibility: visible; }
        #karcis-print { position: absolute; left: 0; top: 0; width: 80mm; max-width: 80mm; border: 0; border-radius: 0; box-shadow: none; }
    </style>
</x-layouts.petugas>
