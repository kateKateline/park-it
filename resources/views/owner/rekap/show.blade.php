<x-layouts.owner :title="'Detail Rekap - ' . \Carbon\Carbon::parse($tanggal)->format('d/m/Y')">
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold">Detail Rekap {{ \Carbon\Carbon::parse($tanggal)->format('d/m/Y') }}</h2>
            <div class="flex items-center gap-2">
                <a href="{{ route('owner.rekap.index') }}"
                   class="rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm font-medium hover:bg-slate-50">
                    Kembali
                </a>
                <a href="{{ route('owner.rekap.pdf', ['from' => $tanggal, 'to' => $tanggal]) }}"
                   target="_blank"
                   rel="noopener"
                   class="rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-900 hover:bg-slate-50">
                    PDF
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="text-sm text-slate-600">Jumlah transaksi</div>
                <div class="mt-1 text-2xl font-semibold">{{ $summary['jumlah'] }}</div>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="text-sm text-slate-600">Total pendapatan</div>
                <div class="mt-1 text-2xl font-semibold">Rp {{ number_format($summary['pendapatan'], 0, ',', '.') }}</div>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="text-sm text-slate-600">Rata-rata durasi</div>
                <div class="mt-1 text-2xl font-semibold">{{ \App\Support\DurationDisplay::fromMinutes($summary['rata_durasi'] ?? 0) }}</div>
            </div>
        </div>

        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-slate-600">
                <tr>
                    <th class="px-4 py-3 text-left">No. Transaksi</th>
                    <th class="px-4 py-3 text-left">Plat</th>
                    <th class="px-4 py-3 text-left">Jenis</th>
                    <th class="px-4 py-3 text-left">Masuk</th>
                    <th class="px-4 py-3 text-left">Keluar</th>
                    <th class="px-4 py-3 text-left">Durasi</th>
                    <th class="px-4 py-3 text-right">Biaya</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($items as $t)
                    <tr class="border-t border-slate-100">
                        <td class="px-4 py-3">{{ $t->id }}</td>
                        <td class="px-4 py-3">{{ $t->kendaraan?->plat_nomor }}</td>
                        <td class="px-4 py-3 capitalize">{{ $t->kendaraan?->jenis_kendaraan }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">{{ $t->waktu_masuk?->format('d/m/Y H:i') }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">{{ $t->waktu_keluar?->format('d/m/Y H:i') }}</td>
                        <td class="px-4 py-3">{{ \App\Support\DurationDisplay::fromMinutes($t->durasi_menit) }}</td>
                        <td class="px-4 py-3 text-right font-medium">Rp {{ number_format($t->total_bayar ?? 0, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-slate-500">Tidak ada transaksi pada tanggal ini.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.owner>
