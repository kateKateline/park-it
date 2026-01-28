<x-layouts.app :title="'Owner Dashboard - Park-It'">
    <div class="mx-auto max-w-6xl p-6">
        @include('partials.topbar', [
            'title' => 'Dashboard Owner',
            'subtitle' => 'Owner hanya bisa melihat rekap transaksi sesuai waktu (SPK).',
        ])

        <div class="mt-6 space-y-4">
            @include('partials.flash')

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="text-sm text-slate-600">Transaksi selesai</div>
                    <div class="mt-1 text-2xl font-semibold">{{ $counts['transaksi_selesai'] }}</div>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="text-sm text-slate-600">Transaksi masih masuk</div>
                    <div class="mt-1 text-2xl font-semibold">{{ $counts['transaksi_masuk'] }}</div>
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <div class="text-sm text-slate-600">Rekap transaksi</div>
                        <div class="mt-1 text-lg font-semibold">Filter berdasarkan tanggal</div>
                    </div>
                    <a class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800"
                       href="{{ route('owner.rekap.index') }}">
                        Buka Rekap
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>

