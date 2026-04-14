<x-layouts.petugas :title="'Struk Pembayaran - ' . $transaksi->barcode">
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
                    <span>{{ $transaksi->barcode }}</span>
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
                    <span>{{ $durasi_menit }} menit</span>
                </div>

                <div class="flex justify-between">
                    <span>Tariff</span>
                    <span>Rp {{ number_format($tarif_per_jam, 0, ',', '.') }}/jam</span>
                </div>
                <div class="flex justify-between">
                    <span>Free</span>
                    <span>{{ $gratis_menit }} minutes</span>
                </div>

                <div class="flex justify-between font-bold border-t border-dashed pt-1 mt-1">
                    <span>Total</span>
                    <span>Rp {{ number_format($transaksi->total_bayar, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Barcode -->
            <div class="my-4 pt-3 border-t border-dashed text-center">
                <img
                    src="https://bwipjs-api.metafloor.com/?bcid=qrcode&text={{ urlencode($transaksi->barcode) }}&scale=5"
                    alt="QR"
                    class="mx-auto w-40"
                />
            </div>

            <!-- Footer -->
            <div class="text-center text-[10px] text-slate-500">
                <p>TRANSAKSI SELESAI</p>
                <p>TERIMA KASIH</p>
                <p>SALAM PARK-IT</p>
            </div>
        </div>

        <div class="flex flex-col items-center gap-3 sm:flex-row sm:justify-center">
            <a href="{{ route('petugas.transaksi.keluar') }}"
               class="rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm font-medium hover:bg-slate-50 inline-flex items-center gap-2">
                <i class="fas fa-arrow-left text-[12px]"></i>
                Kembali ke Keluar
            </a>
            <button
                type="button"
                onclick="window.print()"
                class="rounded-xl bg-blue-600 px-5 py-2 text-sm font-semibold text-white hover:bg-blue-700"
            >
                <i class="fas fa-print mr-2"></i>
                Cetak Struk
            </button>
            <div class="text-xs text-slate-500">Tekan Enter untuk cetak</div>
        </div>
    </div>

    <script>
        (function () {
            var focusEl = document.getElementById('struk-print');
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
        #struk-print, #struk-print * { visibility: visible; }
        #struk-print { position: absolute; left: 0; top: 0; width: 80mm; max-width: 80mm; border: 0; border-radius: 0; box-shadow: none; }
    </style>
</x-layouts.petugas>
