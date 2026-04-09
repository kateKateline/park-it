<x-layouts.admin :title="'Daftar Transaksi'">
    <div class="space-y-6">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <div class="text-xs text-gray-500">Admin Panel</div>
                <h2 class="mt-1 text-xl font-semibold text-gray-900">Transaksi</h2>
                <p class="mt-1 text-sm text-gray-600">Ringkasan semua transaksi parkir</p>
            </div>
        </div>

        @include('admin.partials.index-search', [
            'action' => route('admin.transaksi.index'),
            'placeholder' => 'Cari kode barcode, plat, area, petugas, atau status...',
            'q' => $q,
        ])

        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-gray-700">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium">Kode</th>
                        <th class="px-4 py-3 text-left text-xs font-medium">Waktu Masuk</th>
                        <th class="px-4 py-3 text-left text-xs font-medium">Waktu Keluar</th>
                        <th class="px-4 py-3 text-left text-xs font-medium">Kendaraan</th>
                        <th class="px-4 py-3 text-left text-xs font-medium">Area</th>
                        <th class="px-4 py-3 text-left text-xs font-medium">Petugas</th>
                        <th class="px-4 py-3 text-right text-xs font-medium">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($items as $t)
                        <tr class="hover:bg-gray-50/80">
                            <td class="px-4 py-3">
                                <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $t->status === 'selesai' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                    {{ $t->status }}
                                </span>
                            </td>
                            <td class="px-4 py-3 font-mono text-xs">{{ $t->barcode }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-gray-800">{{ $t->waktu_masuk?->format('d/m/Y H:i') }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-gray-700">{{ $t->waktu_keluar?->format('d/m/Y H:i') ?? '—' }}</td>
                            <td class="px-4 py-3">
                                <div class="font-medium text-gray-900">{{ $t->kendaraan?->plat_nomor ?? '—' }}</div>
                                <div class="text-xs text-gray-500">{{ $t->kendaraan?->jenis_kendaraan }}</div>
                            </td>
                            <td class="px-4 py-3 text-gray-800">{{ $t->areaParkir?->nama_area ?? '—' }}</td>
                            <td class="px-4 py-3 text-gray-700">{{ $t->petugas?->name ?? '—' }}</td>
                            <td class="px-4 py-3 text-right font-medium text-gray-900">
                                Rp {{ number_format($t->total_bayar ?? 0, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-10 text-center text-gray-500">Belum ada transaksi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-1">{{ $items->links('pagination::tailwind') }}</div>
    </div>
</x-layouts.admin>
