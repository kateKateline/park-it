<x-layouts.petugas :title="'Monitoring Kamera - Petugas'">
    <div class="space-y-6">
        @include('partials.flash')

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-900">Monitoring Kamera</h2>
                <p class="mt-1 text-sm text-gray-600">
                    Stream kamera parkir aktif. Status online/offline ditentukan dari browser.
                </p>
            </div>
            <button id="refresh-cameras-btn"
                    type="button"
                    class="inline-flex items-center gap-2 rounded-xl bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-sm ring-1 ring-gray-200 hover:bg-gray-50 transition">
                <i class="fas fa-sync-alt text-gray-500"></i>
                Refresh Kamera
            </button>
        </div>

        <div id="camera-container" class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-3"></div>

        <div id="camera-empty" class="hidden rounded-2xl bg-white p-12 text-center shadow-sm ring-1 ring-gray-200/60">
            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-gray-100">
                <i class="fas fa-video-slash text-2xl text-gray-400"></i>
            </div>
            <h3 class="mt-4 text-sm font-semibold text-gray-900">Belum ada kamera</h3>
            <p class="mt-2 text-sm text-gray-500">Klik "Refresh Kamera" untuk memuat daftar kamera aktif.</p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const endpoint = '{{ url('/api/cameras/active') }}';
            const container = document.getElementById('camera-container');
            const emptyEl = document.getElementById('camera-empty');
            const refreshBtn = document.getElementById('refresh-cameras-btn');

            async function fetchCameras() {
                try {
                    const res = await fetch(endpoint, {
                        headers: { 'Accept': 'application/json' },
                        credentials: 'same-origin',
                    });
                    if (!res.ok) throw new Error('Gagal mengambil data kamera');
                    const cameras = await res.json();
                    renderCameras(cameras, { replaceMissing: true });
                    if (emptyEl) {
                        emptyEl.classList.toggle('hidden', (cameras && cameras.length) > 0);
                    }
                } catch (e) {
                    console.error(e);
                    if (emptyEl) emptyEl.classList.remove('hidden');
                }
            }

            function renderCameras(cameras, opts = { replaceMissing: false }) {
                if (!container) return;
                const existingMap = new Map();
                Array.from(container.querySelectorAll('[data-cam-id]')).forEach(el => {
                    existingMap.set(el.getAttribute('data-cam-id'), el);
                });
                const incomingIds = new Set((cameras || []).map(c => String(c.id)));

                (cameras || []).forEach(cam => {
                    const key = String(cam.id);
                    if (existingMap.has(key)) return;

                    const wrapper = document.createElement('div');
                    wrapper.className = 'overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-200/60 transition hover:ring-gray-300/80';
                    wrapper.setAttribute('data-cam-id', key);
                    try {
                        const cachedW = localStorage.getItem('camWidth:' + key);
                        wrapper.style.maxWidth = cachedW ? (parseInt(cachedW, 10) + 'px') : '100%';
                    } catch (e) {}

                    const header = document.createElement('div');
                    header.className = 'flex items-center justify-between gap-2 px-4 py-3 bg-gray-50/80 border-b border-gray-100';

                    const title = document.createElement('h3');
                    title.className = 'text-sm font-semibold text-gray-900 truncate';
                    title.innerText = cam.name;

                    const statusBadge = document.createElement('span');
                    statusBadge.className = 'inline-flex items-center gap-1.5 shrink-0 rounded-full px-2.5 py-1 text-xs font-medium bg-gray-200 text-gray-600';
                    statusBadge.innerHTML = '<i class="fas fa-circle-notch fa-spin text-[10px]"></i> Memeriksa...';

                    header.appendChild(title);
                    header.appendChild(statusBadge);

                    const frame = document.createElement('div');
                    frame.className = 'relative w-full overflow-hidden bg-gray-100';
                    frame.style.aspectRatio = '16/10';
                    frame.style.minHeight = '200px';

                    const placeholder = document.createElement('div');
                    placeholder.className = 'absolute inset-0 flex flex-col items-center justify-center gap-2 text-gray-500';
                    placeholder.innerHTML = '<i class="fas fa-spinner fa-spin text-2xl"></i><span class="text-sm font-medium">Memuat stream...</span>';

                    const img = document.createElement('img');
                    img.src = cam.stream_url;
                    img.alt = cam.name || 'Stream kamera';
                    img.className = 'absolute inset-0 h-full w-full object-contain hidden';

                    let statusSet = false;

                    img.onload = () => {
                        statusSet = true;
                        statusBadge.className = 'inline-flex items-center gap-1.5 shrink-0 rounded-full px-2.5 py-1 text-xs font-medium bg-emerald-100 text-emerald-700';
                        statusBadge.innerHTML = '<i class="fas fa-circle text-[6px]"></i> Online';
                        placeholder.classList.add('hidden');
                        img.classList.remove('hidden');
                        frame.classList.remove('bg-gray-100');
                        frame.classList.add('bg-gray-800');
                        try {
                            const nw = img.naturalWidth || frame.clientWidth;
                            if (nw && nw > 0) {
                                localStorage.setItem('camWidth:' + key, String(nw));
                                wrapper.style.maxWidth = nw + 'px';
                            }
                        } catch (e) {}
                    };

                    img.onerror = () => {
                        statusSet = true;
                        statusBadge.className = 'inline-flex items-center gap-1.5 shrink-0 rounded-full px-2.5 py-1 text-xs font-medium bg-red-100 text-red-700';
                        statusBadge.innerHTML = '<i class="fas fa-video-slash text-[10px]"></i> Offline';
                        placeholder.querySelector('i').className = 'fas fa-video-slash text-2xl';
                        placeholder.querySelector('span').innerText = 'Stream offline';
                        try {
                            const cachedW = localStorage.getItem('camWidth:' + key);
                            if (cachedW) wrapper.style.maxWidth = parseInt(cachedW, 10) + 'px';
                        } catch (e) {}
                    };

                    setTimeout(() => {
                        if (!statusSet) {
                            statusBadge.className = 'inline-flex items-center gap-1.5 shrink-0 rounded-full px-2.5 py-1 text-xs font-medium bg-red-100 text-red-700';
                            statusBadge.innerHTML = '<i class="fas fa-video-slash text-[10px]"></i> Offline';
                            placeholder.querySelector('i').className = 'fas fa-video-slash text-2xl';
                            placeholder.querySelector('span').innerText = 'Offline';
                        }
                    }, 8000);

                    frame.appendChild(placeholder);
                    frame.appendChild(img);
                    wrapper.appendChild(header);
                    wrapper.appendChild(frame);
                    container.appendChild(wrapper);
                });

                if (opts.replaceMissing) {
                    Array.from(container.querySelectorAll('[data-cam-id]')).forEach(el => {
                        if (!incomingIds.has(el.getAttribute('data-cam-id'))) el.remove();
                    });
                }
            }

            fetchCameras();
            if (refreshBtn) refreshBtn.addEventListener('click', () => fetchCameras());
        });
    </script>
</x-layouts.petugas>
