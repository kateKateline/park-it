<x-layouts.petugas :title="'Dashboard - Petugas'">
    <div class="space-y-6">
        @include('partials.flash')

        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-900">Dashboard Petugas</h2>
            <span class="text-sm text-gray-600">{{ now()->format('d F Y, H:i') }}</span>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <div class="text-sm text-gray-600">Transaksi hari ini</div>
                <div class="mt-1 text-2xl font-semibold">{{ $counts['hari_ini'] }}</div>
            </div>
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <div class="text-sm text-gray-600">Sedang parkir</div>
                <div class="mt-1 text-2xl font-semibold">{{ $counts['sedang_parkir'] }}</div>
            </div>
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                <div class="text-sm text-gray-600">Selesai hari ini</div>
                <div class="mt-1 text-2xl font-semibold">{{ $counts['selesai'] }}</div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <a href="{{ route('petugas.transaksi.masuk') }}"
               class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm hover:border-blue-300 hover:shadow-md transition flex items-center gap-4 group">
                <div class="w-14 h-14 rounded-xl bg-blue-100 flex items-center justify-center group-hover:bg-blue-200 transition">
                    <i class="fas fa-sign-in-alt text-2xl text-blue-600"></i>
                </div>
                <div class="flex-1">
                    <h3 class="font-semibold text-gray-900">Kendaraan Masuk</h3>
                    <p class="text-sm text-gray-600 mt-1">Isi form kendaraan, pilih area, generate karcis</p>
                </div>
                <i class="fas fa-chevron-right text-gray-400 group-hover:text-blue-600"></i>
            </a>
            <a href="{{ route('petugas.transaksi.keluar') }}"
               class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm hover:border-emerald-300 hover:shadow-md transition flex items-center gap-4 group">
                <div class="w-14 h-14 rounded-xl bg-emerald-100 flex items-center justify-center group-hover:bg-emerald-200 transition">
                    <i class="fas fa-sign-out-alt text-2xl text-emerald-600"></i>
                </div>
                <div class="flex-1">
                    <h3 class="font-semibold text-gray-900">Kendaraan Keluar</h3>
                    <p class="text-sm text-gray-600 mt-1">Scan karcis, hitung tarif, terima pembayaran</p>
                </div>
                <i class="fas fa-chevron-right text-gray-400 group-hover:text-emerald-600"></i>
            </a>
        </div>

        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <h3 class="font-semibold text-gray-900">Daftar Transaksi</h3>
                    <p class="text-sm text-gray-600 mt-1">Lihat semua transaksi masuk & keluar</p>
                </div>
                <a href="{{ route('petugas.transaksi.index') }}"
                   class="rounded-xl bg-gray-900 px-4 py-2 text-sm font-semibold text-white hover:bg-gray-800 transition">
                    Buka Daftar
                </a>
            </div>
        </div>

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
