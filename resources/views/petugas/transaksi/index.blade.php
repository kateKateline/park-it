<x-layouts.petugas :title="'Daftar Transaksi - Petugas'">
    <div class="space-y-6">
        @include('partials.flash')

        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-slate-900">Daftar Transaksi</h2>
        </div>

        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="px-4 py-3 text-left">Status</th>
                        <th class="px-4 py-3 text-left">Kode</th>
                        <th class="px-4 py-3 text-left">Waktu Masuk</th>
                        <th class="px-4 py-3 text-left">Waktu Keluar</th>
                        <th class="px-4 py-3 text-left">Kendaraan</th>
                        <th class="px-4 py-3 text-left">Area</th>
                        <th class="px-4 py-3 text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($items as $t)
                        <tr class="border-t border-slate-100">
                            <td class="px-4 py-3">
                                <span class="inline-flex rounded-full {{ $t->status === 'selesai' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }} px-2 py-1 text-xs font-medium">
                                    {{ $t->status }}
                                </span>
                            </td>
                            <td class="px-4 py-3 font-mono text-xs">{{ $t->qr_code }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ $t->waktu_masuk?->format('d/m/Y H:i') }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ $t->waktu_keluar?->format('d/m/Y H:i') ?? '-' }}</td>
                            <td class="px-4 py-3">
                                <div class="font-medium">{{ $t->kendaraan?->plat_nomor }}</div>
                                <div class="text-xs text-slate-500">{{ $t->kendaraan?->jenis_kendaraan }}</div>
                            </td>
                            <td class="px-4 py-3">{{ $t->areaParkir?->nama_area }}</td>
                            <td class="px-4 py-3 text-right font-medium">
                                Rp {{ number_format($t->total_bayar ?? 0, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-slate-500">Belum ada transaksi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-1">{{ $items->links('pagination::tailwind') }}</div>
    </div>
</x-layouts.petugas>
