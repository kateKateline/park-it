<x-layouts.owner :title="'Dashboard - Owner'">
    <div class="space-y-6">
        @include('partials.flash')

        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <div class="text-xs text-slate-500">Owner Panel</div>
                <h2 class="mt-1 text-xl font-semibold text-slate-900">Dashboard</h2>
                <div class="mt-1 text-sm text-slate-600">{{ now()->format('d F Y, H:i') }}</div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-slate-600">Transaksi hari ini</div>
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gray-100 text-gray-700">
                        <i class="fas fa-arrow-right-to-bracket text-sm"></i>
                    </div>
                </div>
                <div class="mt-3 text-3xl font-semibold tracking-tight text-slate-900">{{ $metrics['transaksi_hari_ini'] }}</div>
                <div class="mt-2 text-xs text-slate-500">Transaksi selesai</div>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-slate-600">Pendapatan hari ini</div>
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gray-100 text-gray-700">
                        <i class="fas fa-receipt text-sm"></i>
                    </div>
                </div>
                <div class="mt-3 text-2xl font-semibold tracking-tight text-slate-900">Rp {{ number_format($metrics['pendapatan_hari_ini'], 0, ',', '.') }}</div>
                <div class="mt-2 text-xs text-slate-500">Total pendapatan</div>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-slate-600">Transaksi bulan ini</div>
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-100 text-slate-700">
                        <i class="fas fa-calendar-days text-sm"></i>
                    </div>
                </div>
                <div class="mt-3 text-3xl font-semibold tracking-tight text-slate-900">{{ $metrics['transaksi_bulan_ini'] }}</div>
                <div class="mt-2 text-xs text-slate-500">Transaksi selesai</div>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-slate-600">Pendapatan bulan ini</div>
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gray-100 text-gray-700">
                        <i class="fas fa-wallet text-sm"></i>
                    </div>
                </div>
                <div class="mt-3 text-2xl font-semibold tracking-tight text-slate-900">Rp {{ number_format($metrics['pendapatan_bulan_ini'], 0, ',', '.') }}</div>
                <div class="mt-2 text-xs text-slate-500">Total pendapatan</div>
            </div>
        </div>

        @php
            $series = $rekap['series'] ?? [];
        @endphp

        <div class="space-y-6">
            <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
            <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">
                <div>
                    <div class="text-sm font-semibold text-slate-900">Transaksi terbaru</div>
                </div>
                <a href="{{ route('owner.rekap.index') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700 transition inline-flex items-center gap-2">
                    Rekap detail
                    <i class="fas fa-arrow-right text-[10px]"></i>
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-700">Kode</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-700">Kendaraan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-700">Area</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-700">Keluar</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-slate-700">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse(($recent['transaksi'] ?? collect()) as $t)
                            <tr class="hover:bg-slate-50">
                                <td class="px-6 py-4 font-mono text-xs text-slate-700">{{ $t->barcode }}</td>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-slate-900">{{ $t->kendaraan?->plat_nomor ?? '-' }}</div>
                                    <div class="text-xs text-slate-500">{{ $t->kendaraan?->jenis_kendaraan ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 text-slate-700">{{ $t->areaParkir?->nama_area ?? '-' }}</td>
                                <td class="px-6 py-4 text-slate-700 whitespace-nowrap text-xs">{{ $t->waktu_keluar?->format('d/m H:i') ?? '-' }}</td>
                                <td class="px-6 py-4 text-right font-semibold text-slate-900">Rp {{ number_format((int) ($t->total_bayar ?? 0), 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-slate-500">Belum ada transaksi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

            <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
                <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">
                    <div>
                        <div class="text-sm font-semibold text-slate-900">Ringkasan harian</div>
                        <div class="mt-1 text-xs text-slate-500">7 hari terakhir</div>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-700">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-700">Transaksi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-700">Rata-rata durasi</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-slate-700">Pendapatan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @forelse(array_reverse($series) as $r)
                                <tr class="hover:bg-slate-50">
                                    <td class="px-6 py-4 text-slate-700">{{ \Carbon\Carbon::parse($r['tanggal'])->format('d M Y') }}</td>
                                    <td class="px-6 py-4 font-semibold text-slate-900">{{ (int) ($r['jumlah'] ?? 0) }}</td>
                                    <td class="px-6 py-4 text-slate-700">{{ \App\Support\DurationDisplay::fromMinutes($r['rata_durasi'] ?? 0) }}</td>
                                    <td class="px-6 py-4 text-right font-semibold text-slate-900">Rp {{ number_format((int) ($r['pendapatan'] ?? 0), 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-10 text-center text-slate-500">Belum ada data.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-layouts.owner>

