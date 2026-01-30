<x-layouts.guest :title="'Rekap Transaksi - Owner'">
    <div class="mx-auto max-w-6xl p-6">
        @include('partials.topbar', [
            'title' => 'Rekap Transaksi',
            'subtitle' => 'Owner: rekap transaksi sesuai waktu yang diminta (SPK).',
        ])

        <div class="mt-6 space-y-4">
            @include('partials.flash')

            <form class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between"
                  method="GET" action="{{ route('owner.rekap.index') }}">
                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Dari</label>
                        <input type="date" name="from" value="{{ $from }}"
                               class="mt-1 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm outline-none focus:border-slate-900 focus:ring-2 focus:ring-slate-900/10" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Sampai</label>
                        <input type="date" name="to" value="{{ $to }}"
                               class="mt-1 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm outline-none focus:border-slate-900 focus:ring-2 focus:ring-slate-900/10" />
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <button class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">
                        Terapkan
                    </button>
                    <a href="{{ route('owner.rekap.index') }}"
                       class="rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm font-medium hover:bg-slate-50">
                        Reset
                    </a>
                </div>
            </form>

            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="text-sm text-slate-600">Total pemasukan (periode)</div>
                <div class="mt-1 text-2xl font-semibold">Rp {{ number_format($total ?? 0, 0, ',', '.') }}</div>
            </div>

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="px-4 py-3 text-left">Waktu Masuk</th>
                        <th class="px-4 py-3 text-left">Waktu Keluar</th>
                        <th class="px-4 py-3 text-left">Kendaraan</th>
                        <th class="px-4 py-3 text-left">Area</th>
                        <th class="px-4 py-3 text-left">Petugas</th>
                        <th class="px-4 py-3 text-right">Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($items as $t)
                        <tr class="border-t border-slate-100">
                            <td class="px-4 py-3 whitespace-nowrap">{{ $t->waktu_masuk?->format('d/m/Y H:i') }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ $t->waktu_keluar?->format('d/m/Y H:i') }}</td>
                            <td class="px-4 py-3">
                                <div class="font-medium">{{ $t->kendaraan?->plat_nomor }}</div>
                                <div class="text-xs text-slate-500">{{ $t->kendaraan?->jenis_kendaraan }}</div>
                            </td>
                            <td class="px-4 py-3">{{ $t->areaParkir?->nama_area }}</td>
                            <td class="px-4 py-3">{{ $t->petugas?->name }}</td>
                            <td class="px-4 py-3 text-right font-medium">
                                Rp {{ number_format($t->total_bayar ?? 0, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-slate-500">Belum ada transaksi di periode ini.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div>{{ $items->links() }}</div>
        </div>
    </div>
</x-layouts.guest>

