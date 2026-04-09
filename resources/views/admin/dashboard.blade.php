<x-layouts.admin :title="'Dashboard'">
    <div class="space-y-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <div class="text-xs text-gray-500">Admin Panel</div>
                <h2 class="mt-1 text-xl font-semibold text-gray-900">Dashboard</h2>
                <div class="mt-1 text-sm text-gray-600">{{ now()->format('d F Y, H:i') }}</div>
            </div>
        </div>

        @php
            $capacity = (int) ($kpi['kapasitas_total'] ?? 0);
            $active = (int) ($kpi['transaksi_aktif'] ?? 0);
            $rate = $capacity > 0 ? (int) round(($active / $capacity) * 100) : 0;
        @endphp

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-600">Transaksi aktif</div>
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-50 text-amber-700">
                        <i class="fas fa-bolt text-sm"></i>
                    </div>
                </div>
                <div class="mt-3 text-3xl font-semibold tracking-tight text-gray-900">{{ $kpi['transaksi_aktif'] ?? 0 }}</div>
                <div class="mt-2 text-xs text-amber-700/90">Status masuk · Okupansi: {{ $rate }}%</div>
            </div>
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-600">Transaksi hari ini</div>
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-700">
                        <i class="fas fa-arrow-right-to-bracket text-sm"></i>
                    </div>
                </div>
                <div class="mt-3 text-3xl font-semibold tracking-tight text-gray-900">{{ $kpi['transaksi_hari_ini'] ?? 0 }}</div>
                <div class="mt-2 text-xs text-blue-700/90">Masuk hari ini</div>
            </div>
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-600">Pendapatan hari ini</div>
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700">
                        <i class="fas fa-receipt text-sm"></i>
                    </div>
                </div>
                <div class="mt-3 text-2xl font-semibold tracking-tight text-gray-900">
                    Rp {{ number_format((int) ($kpi['pendapatan_hari_ini'] ?? 0), 0, ',', '.') }}
                </div>
                <div class="mt-2 text-xs text-emerald-700/90">Dari transaksi selesai</div>
            </div>
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-600">Data master</div>
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-50 text-slate-700">
                        <i class="fas fa-layer-group text-sm"></i>
                    </div>
                </div>
                <dl class="mt-3 grid grid-cols-2 gap-x-3 gap-y-2 text-sm">
                    <div class="flex justify-between gap-2 rounded-lg bg-gray-50 px-2.5 py-1.5">
                        <dt class="text-gray-500">Users</dt>
                        <dd class="font-semibold text-gray-900">{{ $counts['users'] ?? 0 }}</dd>
                    </div>
                    <div class="flex justify-between gap-2 rounded-lg bg-gray-50 px-2.5 py-1.5">
                        <dt class="text-gray-500">Area</dt>
                        <dd class="font-semibold text-gray-900">{{ $counts['area'] ?? 0 }}</dd>
                    </div>
                    <div class="flex justify-between gap-2 rounded-lg bg-gray-50 px-2.5 py-1.5">
                        <dt class="text-gray-500">Kendaraan</dt>
                        <dd class="font-semibold text-gray-900">{{ $counts['kendaraan'] ?? 0 }}</dd>
                    </div>
                    <div class="flex justify-between gap-2 rounded-lg bg-gray-50 px-2.5 py-1.5">
                        <dt class="text-gray-500">Tarif</dt>
                        <dd class="font-semibold text-gray-900">{{ $counts['tarif'] ?? 0 }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
            <div class="rounded-2xl border border-gray-200 bg-white shadow-sm">
                <div class="border-b border-gray-200 px-6 py-4">
                    <div class="text-sm font-semibold text-gray-900">Okupansi area</div>
                    <div class="mt-1 text-xs text-gray-500">Kendaraan aktif per area</div>
                </div>
                <div class="px-6 py-5 space-y-4">
                    @forelse ($areas as $area)
                        <div>
                            <div class="flex items-center justify-between text-sm">
                                <div class="font-medium text-gray-900">{{ $area['nama_area'] }}</div>
                                <div class="text-xs text-gray-600">{{ $area['occupied'] }}/{{ $area['kapasitas'] }} · {{ $area['status_text'] }}</div>
                            </div>
                            <div class="mt-2 h-2 w-full rounded-full bg-gray-100">
                                <div class="h-2 rounded-full {{ $area['bar_color'] }}" style="width: {{ $area['percentage'] }}%"></div>
                            </div>
                        </div>
                    @empty
                        <div class="text-sm text-gray-500">Belum ada area.</div>
                    @endforelse
                </div>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white shadow-sm overflow-hidden">
                <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4">
                    <div>
                        <div class="text-sm font-semibold text-gray-900">Transaksi terbaru</div>
                    </div>
                    <a href="{{ route('admin.transaksi.index') }}" class="text-xs font-semibold text-gray-700 hover:text-gray-900 transition inline-flex items-center gap-2">
                        Lihat semua
                        <i class="fas fa-arrow-right text-[10px]"></i>
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700">Plat</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700">Area</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700">Masuk</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($recent['transaksi'] ?? collect() as $t)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 font-medium text-gray-900">{{ $t->kendaraan?->plat_nomor ?? '-' }}</td>
                                    <td class="px-6 py-4 text-gray-700">{{ $t->areaParkir?->nama_area ?? '-' }}</td>
                                    <td class="px-6 py-4 text-gray-600 whitespace-nowrap text-xs">{{ $t->waktu_masuk?->format('d/m H:i') ?? '-' }}</td>
                                    <td class="px-6 py-4">
                                        @php
                                            $statusColor = match($t->status) {
                                                'masuk' => 'bg-amber-100 text-amber-800 ring-1 ring-amber-200/80',
                                                'selesai' => 'bg-emerald-100 text-emerald-800 ring-1 ring-emerald-200/80',
                                                default => 'bg-gray-100 text-gray-700 ring-1 ring-gray-200/80'
                                            };
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $statusColor }}">
                                            {{ ucfirst($t->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-10 text-center text-gray-500">Belum ada transaksi.</td>
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
                    <div class="text-sm font-semibold text-gray-900">Aktivitas terbaru</div>
                    <div class="mt-1 text-xs text-gray-500">Audit trail sistem</div>
                </div>
                <a href="{{ route('admin.log-aktivitas.index') }}" class="text-xs font-semibold text-gray-700 hover:text-gray-900 transition inline-flex items-center gap-2">
                    Lihat semua
                    <i class="fas fa-arrow-right text-[10px]"></i>
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700">Waktu</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700">Aktivitas</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse (($recent['logs'] ?? collect()) as $log)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-gray-600 whitespace-nowrap text-xs">{{ $log->created_at?->format('d/m H:i') }}</td>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-900">{{ $log->user?->name ?? '-' }}</div>
                                    <div class="text-xs text-gray-500">{{ $log->user?->username ?? '' }}</div>
                                </td>
                                <td class="px-6 py-4 text-gray-700">{{ $log->aktivitas }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-10 text-center text-gray-500">Belum ada aktivitas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.admin>
