<x-layouts.app :title="'Petugas Dashboard - Park-It'">
    <div class="mx-auto max-w-6xl p-6">
        @include('partials.topbar', [
            'title' => 'Dashboard Petugas',
            'subtitle' => 'Demo dashboard (belum full integrasi deteksi AI).',
        ])

        <div class="mt-6 space-y-4">
            @include('partials.flash')

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="text-sm text-slate-600">Transaksi hari ini</div>
                    <div class="mt-1 text-2xl font-semibold">{{ $counts['hari_ini'] }}</div>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="text-sm text-slate-600">Sedang parkir</div>
                    <div class="mt-1 text-2xl font-semibold">{{ $counts['sedang_parkir'] }}</div>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="text-sm text-slate-600">Selesai</div>
                    <div class="mt-1 text-2xl font-semibold">{{ $counts['selesai'] }}</div>
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <div class="text-sm text-slate-600">Transaksi (demo)</div>
                        <div class="mt-1 text-lg font-semibold">Lihat list transaksi untuk presentasi</div>
                        <div class="mt-1 text-xs text-slate-500">Catatan: fitur transaksi & cetak struk akan diintegrasikan lebih lanjut.</div>
                    </div>
                    <a class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800"
                       href="{{ route('petugas.transaksi.demo') }}">
                        Buka
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>

