<x-layouts.petugas :title="'Konfirmasi Pembayaran - Petugas'">
    <div class="space-y-6">
        @include('partials.flash')

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-slate-900 mb-6">
                <i class="fas fa-calculator text-emerald-600 mr-2"></i>
                Rincian Pembayaran
            </h2>

            <div class="space-y-4 mb-6">
                <div class="flex items-center justify-between py-2 border-b border-slate-200">
                    <span class="text-slate-600">Plat Nomor</span>
                    <span class="font-semibold">{{ $transaksi->kendaraan->plat_nomor }}</span>
                </div>
                <div class="flex items-center justify-between py-2 border-b border-slate-200">
                    <span class="text-slate-600">Jenis</span>
                    <span class="font-medium">{{ ucfirst($transaksi->kendaraan->jenis_kendaraan) }}</span>
                </div>
                <div class="flex items-center justify-between py-2 border-b border-slate-200">
                    <span class="text-slate-600">Area</span>
                    <span>{{ $transaksi->areaParkir->nama_area }}</span>
                </div>
                <div class="flex items-center justify-between py-2 border-b border-slate-200">
                    <span class="text-slate-600">Waktu Masuk</span>
                    <span>{{ $waktu_masuk->format('d/m/Y H:i') }}</span>
                </div>
                <div class="flex items-center justify-between py-2 border-b border-slate-200">
                    <span class="text-slate-600">Waktu Keluar</span>
                    <span>{{ $waktu_keluar->format('d/m/Y H:i') }}</span>
                </div>
                <div class="flex items-center justify-between py-2 border-b border-slate-200">
                    <span class="text-slate-600">Durasi</span>
                    <span>{{ $durasi_menit }} menit ({{ $jam }} jam)</span>
                </div>
                <div class="flex items-center justify-between py-2 border-b border-slate-200">
                    <span class="text-slate-600">Tarif per jam</span>
                    <span>Rp {{ number_format($tarif_per_jam, 0, ',', '.') }}</span>
                </div>
                <div class="flex items-center justify-between py-4 bg-emerald-50 rounded-xl px-4">
                    <span class="text-emerald-800 font-semibold">Total Bayar</span>
                    <span class="text-xl font-bold text-emerald-700">Rp {{ number_format($total_bayar, 0, ',', '.') }}</span>
                </div>
            </div>

            <form action="{{ route('petugas.transaksi.keluar.bayar') }}" method="POST">
                @csrf
                <input type="hidden" name="transaksi_id" value="{{ $transaksi->id }}" />
                <div class="flex items-center gap-2 justify-end">
                    <a href="{{ route('petugas.transaksi.keluar') }}"
                       class="rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm font-medium hover:bg-slate-50">
                        Batal
                    </a>
                    <button class="rounded-xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700">
                        Konfirmasi Pembayaran
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.petugas>
