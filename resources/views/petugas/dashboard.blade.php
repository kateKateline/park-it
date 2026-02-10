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
            <div class="flex items-center justify-between gap-4 mb-4">
                <div>
                    <h3 class="font-semibold text-gray-900">Monitoring Kamera</h3>
                    <p class="text-sm text-gray-600 mt-1">
                        Petugas hanya melihat stream kamera aktif. Status online/offline ditentukan dari browser.
                    </p>
                </div>
            </div>
            <div id="camera-container" class="grid grid-cols-1 md:grid-cols-2 gap-4"></div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const endpoint = '{{ url('/api/cameras/active') }}';
            const container = document.getElementById('camera-container');

            async function fetchCameras() {
                try {
                    const res = await fetch(endpoint, {
                        headers: {
                            'Accept': 'application/json',
                        },
                        credentials: 'same-origin',
                    });
                    if (!res.ok) {
                        throw new Error('Gagal mengambil data kamera');
                    }
                    const cameras = await res.json();
                    renderCameras(cameras);
                } catch (e) {
                    console.error(e);
                }
            }

            function renderCameras(cameras) {
                if (!container) return;
                container.innerHTML = '';

                if (!cameras || cameras.length === 0) {
                    const empty = document.createElement('p');
                    empty.className = 'text-sm text-gray-500';
                    empty.innerText = 'Belum ada kamera aktif yang dikonfigurasi admin.';
                    container.appendChild(empty);
                    return;
                }

                cameras.forEach(cam => {
                    const wrapper = document.createElement('div');
                    wrapper.className = 'border rounded-2xl p-3 bg-gray-50 shadow-sm space-y-2';

                    const header = document.createElement('div');
                    header.className = 'flex items-center justify-between gap-2';

                    const title = document.createElement('h3');
                    title.className = 'text-sm font-semibold text-gray-900';
                    title.innerText = cam.name;

                    const statusBadge = document.createElement('span');
                    statusBadge.className = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-700';
                    statusBadge.innerText = 'Memeriksa...';

                    header.appendChild(title);
                    header.appendChild(statusBadge);

                    const img = document.createElement('img');
                    img.src = cam.stream_url;
                    img.alt = cam.name || 'Stream kamera';
                    img.style.width = '100%';
                    img.className = 'rounded-lg border border-gray-200 bg-black';

                    let statusSet = false;

                    img.onload = () => {
                        statusSet = true;
                        statusBadge.innerText = 'Online';
                        statusBadge.className = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700';
                    };

                    img.onerror = () => {
                        statusSet = true;
                        statusBadge.innerText = 'Offline';
                        statusBadge.className = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700';
                    };

                    // Timeout fallback: jika tidak load/error dalam waktu tertentu
                    setTimeout(() => {
                        if (!statusSet) {
                            statusBadge.innerText = 'Offline';
                            statusBadge.className = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700';
                        }
                    }, 8000);

                    wrapper.appendChild(header);
                    wrapper.appendChild(img);
                    container.appendChild(wrapper);
                });
            }

            fetchCameras();
            setInterval(fetchCameras, 5000);
        });
    </script>
</x-layouts.petugas>
