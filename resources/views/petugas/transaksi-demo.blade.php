<x-layouts.app :title="'Transaksi Demo - Petugas'">
    <div class="mx-auto max-w-6xl p-6">
        @include('partials.topbar', [
            'title' => 'Transaksi (Demo)',
            'subtitle' => 'Halaman demo untuk petugas (belum full integrasi deteksi AI).',
        ])

        <div class="mt-6 space-y-4">
            @include('partials.flash')

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="px-4 py-3 text-left">Status</th>
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
                            <td class="px-4 py-3">
                                <span class="inline-flex rounded-full {{ $t->status === 'selesai' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }} px-2 py-1 text-xs font-medium">
                                    {{ $t->status }}
                                </span>
                            </td>
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
                            <td colspan="7" class="px-4 py-8 text-center text-slate-500">Belum ada data.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div>{{ $items->links() }}</div>
        </div>
    </div>
</x-layouts.app>

