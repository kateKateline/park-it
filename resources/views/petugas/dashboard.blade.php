<x-layouts.petugas :title="'Dashboard - Petugas'">
    <div class="space-y-6">
        @include('partials.flash')

        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <div class="text-xs text-gray-500">Petugas Panel</div>
                <h2 class="mt-1 text-xl font-semibold text-gray-900">Dashboard</h2>
                <div class="mt-1 text-sm text-gray-600">
                    {{ now()->format('d F Y, H:i') }}
                </div>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('petugas.transaksi.masuk') }}"
                   class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-700 transition">
                    <i class="fas fa-sign-in-alt text-sm"></i>
                    Kendaraan Masuk
                </a>
                <a href="{{ route('petugas.transaksi.keluar') }}"
                   class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-emerald-700 transition">
                    <i class="fas fa-sign-out-alt text-sm"></i>
                    Kendaraan Keluar
                </a>
                <a href="{{ route('petugas.transaksi.index') }}"
                   class="inline-flex items-center gap-2 rounded-xl bg-white px-4 py-2.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-gray-200 hover:bg-gray-50 transition">
                    <i class="fas fa-list text-sm text-gray-500"></i>
                    Transaksi
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-600">Masuk hari ini</div>
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-700">
                        <i class="fas fa-arrow-right-to-bracket text-sm"></i>
                    </div>
                </div>
                <div class="mt-3 text-3xl font-semibold tracking-tight text-gray-900">{{ $counts['hari_ini'] ?? 0 }}</div>
                <div class="mt-2 text-xs text-blue-700/90">Total transaksi masuk</div>
            </div>
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-600">Sedang parkir</div>
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700">
                        <i class="fas fa-car-side text-sm"></i>
                    </div>
                </div>
                <div class="mt-3 text-3xl font-semibold tracking-tight text-gray-900">{{ $counts['sedang_parkir'] ?? 0 }}</div>
                <div class="mt-2 flex items-center gap-2 text-xs text-gray-500">
                    <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2 py-0.5 text-[11px] font-semibold text-emerald-700">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                        Live
                    </span>
                    <span>aktif sekarang</span>
                </div>
            </div>
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-600">Selesai hari ini</div>
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-50 text-slate-700">
                        <i class="fas fa-check text-sm"></i>
                    </div>
                </div>
                <div class="mt-3 text-3xl font-semibold tracking-tight text-gray-900">{{ $counts['selesai'] ?? 0 }}</div>
                <div class="mt-2 text-xs text-gray-500">Transaksi selesai</div>
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
                <div class="mt-2 text-xs text-emerald-700/90">
                    Rata-rata durasi: {{ (int) ($kpi['rata_durasi_hari_ini'] ?? 0) }} menit
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
            <div class="rounded-2xl border border-gray-200 bg-white shadow-sm">
                <div class="border-b border-gray-200 px-6 py-4">
                    <div class="text-sm font-semibold text-gray-900">Okupansi area</div>
                    <div class="mt-1 text-xs text-gray-500">Kendaraan aktif per area</div>
                </div>
                <div class="px-6 py-5 space-y-4">
                    @forelse(($areas ?? collect()) as $a)
                        @php
                            $cap = (int) ($a->kapasitas ?? 0);
                            $aktif = (int) ($a->aktif_count ?? 0);
                            $pct = $cap > 0 ? (int) min(100, round(($aktif / $cap) * 100)) : 0;
                        @endphp
                        <div>
                            <div class="flex items-center justify-between text-sm">
                                <div class="font-medium text-gray-900">{{ $a->nama_area }}</div>
                                <div class="text-xs text-gray-600">{{ $aktif }}/{{ $cap }}</div>
                            </div>
                            <div class="mt-2 h-2 w-full rounded-full bg-gray-100">
                                <div class="h-2 rounded-full bg-slate-900" style="width: {{ $pct }}%"></div>
                            </div>
                        </div>
                    @empty
                        <div class="text-sm text-gray-500">Belum ada area.</div>
                    @endforelse
                </div>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white shadow-sm">
                <div class="border-b border-gray-200 px-6 py-4">
                    <div class="text-sm font-semibold text-gray-900">Komposisi kendaraan</div>
                    <div class="mt-1 text-xs text-gray-500">Sedang parkir</div>
                </div>
                @php
                    $motor = (int) (($kendaraan_aktif['motor'] ?? 0));
                    $mobil = (int) (($kendaraan_aktif['mobil'] ?? 0));
                    $totalAktif = $motor + $mobil;
                    if ($totalAktif <= 0) {
                        $motorPct = 0;
                        $mobilPct = 0;
                    } else {
                        $motorPct = (int) round(($motor / $totalAktif) * 100);
                        $mobilPct = (int) round(($mobil / $totalAktif) * 100);
                    }
                @endphp
                <div class="px-6 py-5">
                    <div class="flex items-center justify-between text-sm">
                        <div class="font-medium text-gray-900">Motor</div>
                        <div class="text-xs text-gray-600">{{ $motor }}</div>
                    </div>
                    <div class="mt-2 h-2 w-full rounded-full bg-gray-100">
                        <div class="h-2 rounded-full bg-blue-600" style="width: {{ $motorPct }}%"></div>
                    </div>
                    <div class="mt-4 flex items-center justify-between text-sm">
                        <div class="font-medium text-gray-900">Mobil</div>
                        <div class="text-xs text-gray-600">{{ $mobil }}</div>
                    </div>
                    <div class="mt-2 h-2 w-full rounded-full bg-gray-100">
                        <div class="h-2 rounded-full bg-emerald-600" style="width: {{ $mobilPct }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-gray-200 bg-white shadow-sm overflow-hidden">
                <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4">
                <div>
                    <div class="text-sm font-semibold text-gray-900">Transaksi terbaru</div>
                    <div class="mt-1 text-xs text-gray-500">
                        Status:
                        <span class="font-medium text-amber-700">masuk</span>
                        ·
                        <span class="font-medium text-emerald-700">selesai</span>
                    </div>
                </div>
                <a href="{{ route('petugas.transaksi.index') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700 transition inline-flex items-center gap-2">
                    Lihat semua
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
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-700">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse(($recent['transaksi'] ?? collect()) as $t)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 font-mono text-xs text-gray-700">{{ $t->barcode }}</td>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-900">{{ $t->kendaraan?->plat_nomor ?? '-' }}</div>
                                    <div class="text-xs text-gray-500">{{ $t->kendaraan?->jenis_kendaraan ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 text-gray-700">{{ $t->areaParkir?->nama_area ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    @if ($t->status === 'mSasuk')
                                        <span class="inline-flex items-center gap-2 rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-800 ring-1 ring-amber-200/80">
                                            <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                            Masuk
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-2 rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-800 ring-1 ring-emerald-200/80">
                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                            Selesai
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right font-semibold text-gray-900">
                                    Rp {{ number_format((int) ($t->total_bayar ?? 0), 0, ',', '.') }}
                                </td>
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

        <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <h3 class="font-semibold text-gray-900">Monitoring Kamera</h3>
                        <p class="text-sm text-gray-600 mt-1">Pantau stream kamera parkir di halaman khusus.</p>
                    </div>
                    <a href="{{ route('petugas.kamera.index') }}"
                       class="rounded-xl bg-gray-900 px-4 py-2 text-sm font-semibold text-white hover:bg-gray-800 transition inline-flex items-center gap-2">
                        <i class="fas fa-video"></i>
                        Buka Kamera
                    </a>
                </div>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm" id="detection-test-card">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h3 class="font-semibold text-gray-900">Test Koneksi Python YOLO</h3>
                        <p class="text-sm text-gray-600 mt-1">Uji apakah layanan Python YOLO (Flask) berjalan di <code class="rounded bg-gray-100 px-1 py-0.5 text-xs">GET /status</code>. URL dikonfigurasi di <code class="rounded bg-gray-100 px-1 py-0.5 text-xs">PYTHON_YOLO_URL</code> (.env).</p>
                    </div>
                    <button type="button"
                            id="btn-test-detection"
                            class="inline-flex shrink-0 items-center justify-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-700 transition disabled:opacity-60 disabled:pointer-events-none">
                        <i class="fas fa-plug" id="btn-test-icon"></i>
                        <span id="btn-test-text">Test Koneksi</span>
                    </button>
                </div>
                <div id="detection-test-result" class="mt-4 hidden rounded-xl border p-4 text-sm"></div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const btn = document.getElementById('btn-test-detection');
            const resultEl = document.getElementById('detection-test-result');
            const btnIcon = document.getElementById('btn-test-icon');
            const btnText = document.getElementById('btn-test-text');
            const pythonStatusUrl = '{{ route("petugas.python.status") }}';

            if (!btn || !resultEl) return;

            btn.addEventListener('click', async () => {
                resultEl.classList.add('hidden');
                btn.disabled = true;
                btnIcon.className = 'fas fa-spinner fa-spin';
                btnText.textContent = 'Menguji...';

                try {
                    const res = await fetch(pythonStatusUrl, {
                        method: 'GET',
                        headers: { 'Accept': 'application/json' },
                        credentials: 'same-origin'
                    });
                    const data = await res.json().catch(() => ({}));

                    resultEl.classList.remove('hidden');
                    if (data.success) {
                        resultEl.className = 'mt-4 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800';
                        resultEl.innerHTML = '<strong class="flex items-center gap-2"><i class="fas fa-check-circle"></i> Python YOLO terhubung</strong><p class="mt-2">' + (data.message || '') + '</p><p class="mt-1 text-xs">URL: ' + (data.url || '') + '</p>';
                    } else {
                        resultEl.className = 'mt-4 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-800';
                        resultEl.innerHTML = '<strong class="flex items-center gap-2"><i class="fas fa-times-circle"></i> Tidak terhubung</strong><p class="mt-2">' + (data.message || '') + '</p><p class="mt-1 text-xs">URL: ' + (data.url || '') + '. Pastikan Python YOLO dijalankan (Flask /status).</p>';
                    }
                } catch (e) {
                    resultEl.classList.remove('hidden');
                    resultEl.className = 'mt-4 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-800';
                    resultEl.innerHTML = '<strong class="flex items-center gap-2"><i class="fas fa-times-circle"></i> Gagal koneksi</strong><p class="mt-2">' + (e.message || String(e)) + '</p>';
                } finally {
                    btn.disabled = false;
                    btnIcon.className = 'fas fa-plug';
                    btnText.textContent = 'Test Koneksi';
                }
            });
        });
    </script>
</x-layouts.petugas>
