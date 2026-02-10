<x-layouts.owner :title="'Dashboard - Owner'">
    <div class="space-y-4">
        @include('partials.flash')

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="text-sm text-slate-600">Transaksi hari ini</div>
                <div class="mt-1 text-2xl font-semibold">{{ $metrics['transaksi_hari_ini'] }}</div>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="text-sm text-slate-600">Pendapatan hari ini</div>
                <div class="mt-1 text-2xl font-semibold">Rp {{ number_format($metrics['pendapatan_hari_ini'], 0, ',', '.') }}</div>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="text-sm text-slate-600">Transaksi bulan ini</div>
                <div class="mt-1 text-2xl font-semibold">{{ $metrics['transaksi_bulan_ini'] }}</div>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="text-sm text-slate-600">Pendapatan bulan ini</div>
                <div class="mt-1 text-2xl font-semibold">Rp {{ number_format($metrics['pendapatan_bulan_ini'], 0, ',', '.') }}</div>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <div class="text-sm text-slate-600">Rekap transaksi</div>
                    <div class="mt-1 text-lg font-semibold">Filter berdasarkan tanggal</div>
                    <div class="mt-1 text-xs text-slate-500">Owner dapat melihat rekap sesuai periode.</div>
                </div>
                <a class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800"
                   href="{{ route('owner.rekap.index') }}">
                    Buka Rekap
                </a>
            </div>
        </div>
    </div>
</x-layouts.owner>
