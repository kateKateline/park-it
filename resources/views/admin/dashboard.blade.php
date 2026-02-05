<x-layouts.admin :title="'Dashboard'">
    <div class="space-y-6">
        <!-- Header Row -->
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-xl font-semibold text-gray-900">Dashboard</h2>
            <div class="text-sm text-gray-600">
                <span class="font-medium">{{ now()->format('F d, Y') }}</span>
            </div>
        </div>

        <!-- KPI Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Transaksi Aktif -->
            @php
                $transaksiAktifKemarin = $kpi['transaksi_aktif_kemarin'] ?? 0;
                $transaksiAktifNow = $kpi['transaksi_aktif'] ?? 0;
                $p1 = $transaksiAktifKemarin > 0 ? round((($transaksiAktifNow - $transaksiAktifKemarin) / $transaksiAktifKemarin) * 100) : ($transaksiAktifNow > 0 ? 100 : 0);
            @endphp
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <p class="text-gray-700 font-semibold text-sm">Transaksi Aktif</p>
                        <p class="text-4xl font-bold text-gray-900 mt-3">{{ $transaksiAktifNow }}</p>
                    </div>
                    <div class="flex flex-col items-end">
                        <span class="{{ $p1 >= 0 ? 'text-green-600' : 'text-red-600' }} text-sm font-semibold flex items-center">
                            <i class="fas {{ $p1 >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }} mr-1"></i>
                            {{ abs($p1) }}%
                        </span>
                    </div>
                </div>
                <p class="text-gray-500 text-xs">Dari {{ $kpi['kapasitas_total'] ?? 0 }} kapasitas total</p>
            </div>

            <!-- Transaksi Hari Ini -->
            @php
                $transaksiHariIniKemarin = $kpi['transaksi_hari_ini_kemarin'] ?? 0;
                $transaksiHariIniNow = $kpi['transaksi_hari_ini'] ?? 0;
                $p2 = $transaksiHariIniKemarin > 0 ? round((($transaksiHariIniNow - $transaksiHariIniKemarin) / $transaksiHariIniKemarin) * 100) : ($transaksiHariIniNow > 0 ? 100 : 0);
            @endphp
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <p class="text-gray-700 font-semibold text-sm">Transaksi Hari Ini</p>
                        <p class="text-4xl font-bold text-gray-900 mt-3">{{ $transaksiHariIniNow }}</p>
                    </div>
                    <div class="flex flex-col items-end">
                        <span class="{{ $p2 >= 0 ? 'text-green-600' : 'text-red-600' }} text-sm font-semibold flex items-center">
                            <i class="fas {{ $p2 >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }} mr-1"></i>
                            {{ abs($p2) }}%
                        </span>
                    </div>
                </div>
                <p class="text-gray-500 text-xs">Transaksi masuk hari ini</p>
            </div>

            <!-- Pendapatan Hari Ini -->
            @php
                $pendapatanKemarin = $kpi['pendapatan_kemarin'] ?? 0;
                $pendapatanSekarang = $kpi['pendapatan_hari_ini'] ?? 0;
                $p3 = $pendapatanKemarin > 0 ? round((($pendapatanSekarang - $pendapatanKemarin) / $pendapatanKemarin) * 100) : ($pendapatanSekarang > 0 ? 100 : 0);
            @endphp
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <p class="text-gray-700 font-semibold text-sm">Pendapatan Hari Ini</p>
                        <p class="text-3xl font-bold text-gray-900 mt-3">Rp {{ number_format($pendapatanSekarang, 0, ',', '.') }}</p>
                    </div>
                    <div class="flex flex-col items-end">
                        <span class="{{ $p3 >= 0 ? 'text-green-600' : 'text-red-600' }} text-sm font-semibold flex items-center">
                            <i class="fas {{ $p3 >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }} mr-1"></i>
                            {{ abs($p3) }}%
                        </span>
                    </div>
                </div>
                <p class="text-gray-500 text-xs">Total pendapatan</p>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Occupancy Levels -->
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Occupancy Levels</h3>
                <div class="space-y-4">
                    @forelse ($areas as $area)
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <p class="text-sm font-medium text-gray-700">{{ $area['nama_area'] }}</p>
                                <p class="text-sm font-semibold text-gray-900">{{ $area['occupied'] }}/{{ $area['kapasitas'] }}</p>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                                <div class="h-full {{ $area['bar_color'] }} rounded-full" style="width: {{ $area['percentage'] }}%"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-sm">Tidak ada data area parkir</p>
                    @endforelse
                </div>
            </div>

            <!-- Tingkat Okupansi Summary -->
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Occupancy Rate</h3>
                @php
                    $capacity = (int) ($kpi['kapasitas_total'] ?? 0);
                    $active = (int) ($kpi['transaksi_aktif'] ?? 0);
                    $rate = $capacity > 0 ? round(($active / $capacity) * 100) : 0;
                @endphp
                <div class="flex flex-col items-center justify-center py-8">
                    <div class="relative w-40 h-40 rounded-full flex items-center justify-center bg-gray-100">
                        <div class="text-center">
                            <p class="text-4xl font-bold text-gray-900">{{ $rate }}%</p>
                            <p class="text-xs text-gray-600 mt-1">{{ $active }}/{{ $capacity }} slots</p>
                        </div>
                    </div>
                    <div class="mt-6 w-full">
                        <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                            <div class="h-full bg-blue-600 rounded-full" style="width: {{ $rate }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Recent Transactions -->
            <div class="lg:col-span-2 bg-white rounded-lg border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Recent Transactions</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200">
                                <th class="px-6 py-3 text-left font-medium text-gray-700 text-xs">Plat Nomor</th>
                                <th class="px-6 py-3 text-left font-medium text-gray-700 text-xs">Area</th>
                                <th class="px-6 py-3 text-left font-medium text-gray-700 text-xs">Waktu Masuk</th>
                                <th class="px-6 py-3 text-left font-medium text-gray-700 text-xs">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($recent['transaksi'] ?? [] as $t)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 font-medium text-gray-900">{{ $t->kendaraan?->plat_nomor ?? '-' }}</td>
                                    <td class="px-6 py-4 text-gray-700">{{ $t->areaParkir?->nama_area ?? '-' }}</td>
                                    <td class="px-6 py-4 text-gray-600 whitespace-nowrap">{{ $t->waktu_masuk?->format('d/m H:i') ?? '-' }}</td>
                                    <td class="px-6 py-4">
                                        @php
                                            $statusColor = match($t->status) {
                                                'masuk' => 'bg-blue-100 text-blue-700',
                                                'selesai' => 'bg-emerald-100 text-emerald-700',
                                                default => 'bg-gray-100 text-gray-700'
                                            };
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColor }}">
                                            {{ ucfirst($t->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-gray-500">Tidak ada transaksi</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Summary Stats -->
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Data Master</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between py-3 border-b border-gray-200">
                        <span class="text-sm text-gray-700">Total Users</span>
                        <span class="font-bold text-gray-900 text-lg">{{ $counts['users'] ?? 0 }}</span>
                    </div>
                    <div class="flex items-center justify-between py-3 border-b border-gray-200">
                        <span class="text-sm text-gray-700">Total Area</span>
                        <span class="font-bold text-gray-900 text-lg">{{ $counts['area'] ?? 0 }}</span>
                    </div>
                    <div class="flex items-center justify-between py-3 border-b border-gray-200">
                        <span class="text-sm text-gray-700">Total Kendaraan</span>
                        <span class="font-bold text-gray-900 text-lg">{{ $counts['kendaraan'] ?? 0 }}</span>
                    </div>
                    <div class="flex items-center justify-between py-3">
                        <span class="text-sm text-gray-700">Total Tarif</span>
                        <span class="font-bold text-gray-900 text-lg">{{ $counts['tarif'] ?? 0 }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Recent Activities</h3>
                <a href="{{ route('admin.log-aktivitas.index') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium flex items-center gap-1">
                    View All
                    <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="px-6 py-3 text-left font-medium text-gray-700 text-xs">Waktu</th>
                            <th class="px-6 py-3 text-left font-medium text-gray-700 text-xs">User</th>
                            <th class="px-6 py-3 text-left font-medium text-gray-700 text-xs">Aktivitas</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse (($recent['logs'] ?? collect())->take(5) as $log)
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
                                <td colspan="3" class="px-6 py-8 text-center text-gray-500">Tidak ada aktivitas</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.admin>

