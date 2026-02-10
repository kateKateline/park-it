<x-layouts.owner :title="'Rekap Transaksi - Owner'">
    <div class="space-y-4">
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
                        <th class="px-4 py-3 text-left">Tanggal</th>
                        <th class="px-4 py-3 text-left">Jumlah transaksi</th>
                        <th class="px-4 py-3 text-left">Rata-rata durasi (menit)</th>
                        <th class="px-4 py-3 text-right">Total pendapatan</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($rekap as $r)
                        <tr class="border-t border-slate-100">
                            <td class="px-4 py-3 whitespace-nowrap">{{ \Carbon\Carbon::parse($r->tanggal)->format('d/m/Y') }}</td>
                            <td class="px-4 py-3">{{ $r->jumlah }}</td>
                            <td class="px-4 py-3">{{ (int) round($r->rata_durasi ?? 0) }}</td>
                            <td class="px-4 py-3 text-right font-medium">
                                Rp {{ number_format($r->pendapatan ?? 0, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('owner.rekap.show', $r->tanggal) }}"
                                   class="rounded-lg border border-slate-300 px-3 py-1.5 text-xs font-medium hover:bg-slate-50">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-slate-500">Belum ada transaksi di periode ini.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.owner>
