<x-layouts.petugas :title="'Struk Pembayaran - ' . $transaksi->qr_code">
    <div class="space-y-6">
        @include('partials.flash')

        <div
            id="struk-print"
            class="mx-auto max-w-xs rounded-xl border border-slate-300 bg-white p-4 font-mono text-xs shadow-sm"
        >
            <!-- Header -->
            <div class="mb-3 text-center">
                <div class="text-sm font-bold">PARK-IT</div>
                <div class="text-[10px] uppercase tracking-widest text-slate-600">
                    Payment Receipt
                </div>
            </div>

            <!-- Info -->
            <div class="space-y-1">
                <div class="flex justify-between">
                    <span>Ticket Code</span>
                    <span>{{ $transaksi->qr_code }}</span>
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
                    <span>Entry Time</span>
                    <span>{{ $transaksi->waktu_masuk->format('H:i') }}</span>
                </div>

                <div class="flex justify-between">
                    <span>Exit Time</span>
                    <span>{{ $transaksi->waktu_keluar->format('H:i') }}</span>
                </div>

                <div class="flex justify-between border-t border-dashed pt-1 mt-1">
                    <span>Duration</span>
                    <span>{{ $transaksi->durasi }} Jam</span>
                </div>

                <div class="flex justify-between">
                    <span>Tariff</span>
                    <span>Rp {{ number_format($transaksi->tarif_per_jam, 0, ',', '.') }}</span>
                </div>

                <div class="flex justify-between font-bold border-t border-dashed pt-1 mt-1">
                    <span>Total</span>
                    <span>Rp {{ number_format($transaksi->total_bayar, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Barcode -->
            <div class="my-4 pt-3 border-t border-dashed text-center">
                <img
                    src="https://bwipjs-api.metafloor.com/?bcid=code128&text={{ urlencode($transaksi->qr_code) }}&scale=2&height=10&includetext&textxalign=center"
                    alt="Barcode"
                    class="w-full"
                />
            </div>

            <!-- Footer -->
            <div class="text-center text-[10px] text-slate-500">
                <p>TRANSAKSI SELESAI</p>
                <p>TERIMA KASIH</p>
                <p>SALAM PARK-IT</p>
            </div>
        </div>

        <div class="flex justify-center gap-3">
            <button
                onclick="window.print()"
                class="rounded-xl bg-blue-600 px-4 py-2 text-sm text-white hover:bg-blue-700"
            >
                <i class="fas fa-print mr-2"></i>
                Cetak Struk
            </button>
        </div>
    </div>

    <style media="print">
        body * { visibility: hidden; }
        #struk-print, #struk-print * { visibility: visible; }
        #struk-print { position: absolute; left: 0; top: 0; width: 100%; }
    </style>
</x-layouts.petugas>
