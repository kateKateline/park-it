<x-layouts.owner :title="'Dashboard - Owner'">
    <div class="space-y-6">
        @include('partials.flash')

        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <div class="text-xs text-gray-500">Owner Panel</div>
                <h2 class="mt-1 text-xl font-semibold text-gray-900">Dashboard</h2>
                <div class="mt-1 text-sm text-gray-600">{{ now()->format('d F Y, H:i') }}</div>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('owner.rekap.index') }}"
                   class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm shadow-blue-600/20 hover:bg-blue-700 transition">
                    <i class="fas fa-chart-column text-sm"></i>
                    Rekap
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-600">Transaksi hari ini</div>
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700">
                        <i class="fas fa-arrow-right-to-bracket text-sm"></i>
                    </div>
                </div>
                <div class="mt-3 text-3xl font-semibold tracking-tight text-gray-900">{{ $metrics['transaksi_hari_ini'] }}</div>
                <div class="mt-2 text-xs text-emerald-700/90">Transaksi selesai (hari ini)</div>
            </div>
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-600">Pendapatan hari ini</div>
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700">
                        <i class="fas fa-receipt text-sm"></i>
                    </div>
                </div>
                <div class="mt-3 text-2xl font-semibold tracking-tight text-gray-900">Rp {{ number_format($metrics['pendapatan_hari_ini'], 0, ',', '.') }}</div>
                <div class="mt-2 text-xs text-emerald-700/90">Total pendapatan</div>
            </div>
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-600">Transaksi bulan ini</div>
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gray-100 text-gray-700">
                        <i class="fas fa-calendar-days text-sm"></i>
                    </div>
                </div>
                <div class="mt-3 text-3xl font-semibold tracking-tight text-gray-900">{{ $metrics['transaksi_bulan_ini'] }}</div>
                <div class="mt-2 text-xs text-gray-500">Transaksi selesai</div>
            </div>
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-600">Pendapatan bulan ini</div>
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-700">
                        <i class="fas fa-wallet text-sm"></i>
                    </div>
                </div>
                <div class="mt-3 text-2xl font-semibold tracking-tight text-gray-900">Rp {{ number_format($metrics['pendapatan_bulan_ini'], 0, ',', '.') }}</div>
                <div class="mt-2 text-xs text-blue-700/90">Total pendapatan (bulan ini)</div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
            <div class="rounded-2xl border border-gray-200 bg-white shadow-sm">
                @php
                    $series = $rekap['series'] ?? [];
                    $maxPendapatan = 1;
                    foreach ($series as $r) {
                        $maxPendapatan = max($maxPendapatan, (int) ($r['pendapatan'] ?? 0));
                    }
                @endphp
                <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4">
                    <div>
                        <div class="text-sm font-semibold text-gray-900">Pendapatan 7 hari</div>
                        <div class="mt-1 text-xs text-gray-500">{{ $rekap['from'] ?? '' }} s/d {{ $rekap['to'] ?? '' }}</div>
                    </div>
                    <div class="text-right">
                        <div class="text-xs text-gray-500">Total</div>
                        <div class="text-sm font-semibold text-gray-900">Rp {{ number_format((int) ($rekap['total_7_hari'] ?? 0), 0, ',', '.') }}</div>
                    </div>
                </div>
                <div class="px-6 py-5">
                    <div class="grid grid-cols-7 items-end gap-2 h-44">
                        @foreach ($series as $r)
                            @php
                                $val = (int) ($r['pendapatan'] ?? 0);
                                $pct = (int) round(($val / $maxPendapatan) * 100);
                                $label = \Carbon\Carbon::parse($r['tanggal'])->format('d/m');
                            @endphp
                            <div class="flex flex-col items-center gap-2">
                                <div class="w-full flex-1 flex items-end">
                                    <div class="w-full rounded-xl bg-gray-100">
                                        <div class="w-full rounded-xl bg-blue-600" style="height: {{ $pct }}%"></div>
                                    </div>
                                </div>
                                <div class="text-[10px] text-gray-500">{{ $label }}</div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-5 flex items-center justify-between rounded-2xl bg-blue-700 px-5 py-4 text-white shadow-sm shadow-blue-700/25">
                        <div>
                            <div class="text-xs text-white/70">Transaksi 7 hari</div>
                            <div class="mt-1 text-sm font-semibold">{{ (int) ($rekap['jumlah_7_hari'] ?? 0) }} transaksi</div>
                        </div>
                        <a href="{{ route('owner.rekap.index') }}" class="inline-flex items-center gap-2 rounded-2xl bg-white px-4 py-2 text-xs font-semibold text-gray-900 hover:bg-gray-100 transition">
                            Buka rekap
                            <i class="fas fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white shadow-sm overflow-hidden">
                <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4">
                    <div>
                        <div class="text-sm font-semibold text-gray-900">Ringkasan harian</div>
                        <div class="mt-1 text-xs text-gray-500">7 hari terakhir</div>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700">Transaksi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700">Rata durasi</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-700">Pendapatan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse(($rekap['series'] ?? []) as $r)
                                <tr class="hover:bg-gray-50/80">
                                    <td class="px-6 py-4 text-gray-700">{{ \Carbon\Carbon::parse($r['tanggal'])->format('d M Y') }}</td>
                                    <td class="px-6 py-4 font-semibold text-gray-900">{{ (int) ($r['jumlah'] ?? 0) }}</td>
                                    <td class="px-6 py-4 text-gray-700">{{ (int) ($r['rata_durasi'] ?? 0) }} menit</td>
                                    <td class="px-6 py-4 text-right font-semibold text-gray-900">Rp {{ number_format((int) ($r['pendapatan'] ?? 0), 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-10 text-center text-gray-500">Belum ada data.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-gray-200 bg-white shadow-sm overflow-hidden">
            <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4">
                <div>
                    <div class="text-sm font-semibold text-gray-900">Transaksi terbaru</div>
                    <div class="mt-1 text-xs text-gray-500">Transaksi selesai</div>
                </div>
                <a href="{{ route('owner.rekap.index') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700 transition inline-flex items-center gap-2">
                    Rekap detail
                    <i class="fas fa-arrow-right text-[10px]"></i>
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700">Kode</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700">Kendaraan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700">Area</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700">Keluar</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-700">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse(($recent['transaksi'] ?? collect()) as $t)
                            <tr class="hover:bg-gray-50/80">
                                <td class="px-6 py-4 font-mono text-xs text-gray-700">{{ $t->barcode }}</td>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-900">{{ $t->kendaraan?->plat_nomor ?? '-' }}</div>
                                    <div class="text-xs text-gray-500">{{ $t->kendaraan?->jenis_kendaraan ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 text-gray-700">{{ $t->areaParkir?->nama_area ?? '-' }}</td>
                                <td class="px-6 py-4 text-gray-700 whitespace-nowrap text-xs">{{ $t->waktu_keluar?->format('d/m H:i') ?? '-' }}</td>
                                <td class="px-6 py-4 text-right font-semibold text-gray-900">Rp {{ number_format((int) ($t->total_bayar ?? 0), 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-500">Belum ada transaksi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.owner>
