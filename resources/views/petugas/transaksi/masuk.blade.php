<x-layouts.petugas :title="'Kendaraan Masuk - Petugas'">
    @php
        $vehicleTypeOptions = $vehicleTypeOptions ?? [];
        $jenisDefault = old('jenis_kendaraan', $jenisPrefill ?? '');
        $warnaDefault = old('warna');
        if (($warnaDefault === null || $warnaDefault === '') && ! empty($latestDetection ?? null)) {
            $warnaDefault = $latestDetection['color'] ?? null;
        }

        $nJenis = count($vehicleTypeOptions);
        $jenisGridClass = $nJenis <= 0
            ? 'grid grid-cols-1 gap-3'
            : ($nJenis === 1
                ? 'grid grid-cols-1 gap-3'
                : ($nJenis === 2
                    ? 'grid grid-cols-1 gap-3 sm:grid-cols-2'
                    : 'grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-3'));

        $areasInitial = collect($areas ?? [])->map(function ($a) {
            $kapasitas = (int) ($a->kapasitas ?? 0);
            $aktif = (int) ($a->aktif_count ?? 0);
            return [
                'id' => $a->id,
                'nama_area' => $a->nama_area,
                'kapasitas' => $kapasitas,
                'aktif' => $aktif,
                'tersedia' => max(0, $kapasitas - $aktif),
            ];
        })->values();
    @endphp

    <div class="space-y-6">
        @include('partials.flash')

        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h1 class="text-xl font-semibold tracking-tight text-slate-900 sm:text-2xl">Kendaraan Masuk</h1>
                <p class="mt-1 text-sm text-slate-600">Catat kedatangan, pilih area, lalu generate karcis.</p>
            </div>
            <div class="flex flex-wrap items-center gap-2 text-xs text-slate-500">
                <span class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-3 py-1">
                    <i class="fas fa-clock text-[11px]"></i>
                    <span id="nowClock">{{ now()->format('d/m/Y H:i') }}</span>
                </span>
            </div>
        </div>

        @if (!empty($latestDetection ?? null))
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-5 text-sm text-emerald-900">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <div class="font-semibold">Deteksi YOLO terbaru</div>
                        <div class="mt-1 text-xs text-emerald-900/80">
                            Jenis: <span class="font-semibold">{{ $latestDetection['vehicle_type'] ?? '-' }}</span>,
                            Warna: <span class="font-semibold">{{ $latestDetection['color'] ?? '-' }}</span>,
                            Confidence: <span class="font-semibold">{{ isset($latestDetection['confidence']) ? round($latestDetection['confidence'] * 100) . '%' : '-' }}</span>,
                            Waktu: <span class="font-semibold">{{ $latestDetection['timestamp'] ?? ($latestDetection['detected_at'] ?? '-') }}</span>
                        </div>
                    </div>
                    <div class="text-xs text-emerald-900/70">
                        Autofill aktif untuk 1x submit berikutnya
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">
            <div class="lg:col-span-12">
                <form action="{{ route('petugas.transaksi.masuk.store') }}" method="POST" class="space-y-6" id="masukForm">
                    @csrf

                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div class="text-sm font-semibold text-slate-900">Data Kendaraan</div>
                        </div>

                        <div class="mt-5 rounded-2xl border border-blue-200 bg-blue-50 p-4">
                            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                <div>
                                    <div class="text-sm font-semibold text-blue-900">Ambil gambar dari IP Webcam</div>
                                    <div class="mt-1 text-xs text-blue-900/80">Deteksi dari YOLO akan autofill plat, jenis kendaraan, dan warna.</div>
                                </div>
                                <div class="flex flex-wrap items-center gap-2">
                                    <select id="cameraSelect" class="rounded-xl border border-blue-200 bg-white px-3 py-2 text-xs font-medium text-slate-700">
                                        <option value="">Pilih kamera aktif</option>
                                    </select>
                                    <button type="button" id="btnCaptureAnalyze" class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2 text-xs font-semibold text-white hover:bg-blue-700 transition">
                                        <i class="fas fa-camera" id="btnCaptureAnalyzeIcon"></i>
                                        <span id="btnCaptureAnalyzeText">Ambil & Analisis</span>
                                    </button>
                                </div>
                            </div>
                            <div id="captureAnalyzeResult" class="mt-3 hidden rounded-xl border px-3 py-2 text-xs"></div>
                        </div>

                        <div class="mt-5">
                            <label for="plat_nomor" class="text-xs font-semibold uppercase tracking-wide text-slate-600">Plat Nomor</label>
                            <div class="mt-2 flex items-stretch gap-2">
                                <div class="relative flex-1">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                        <i class="fas fa-id-card text-sm"></i>
                                    </div>
                                    <input type="text" name="plat_nomor" id="plat_nomor" required
                                           value="{{ old('plat_nomor') }}"
                                           minlength="3"
                                           maxlength="10"
                                           placeholder="B 1234 XYZ"
                                           autocomplete="off"
                                           class="w-full rounded-2xl border border-slate-300 bg-white py-3 pl-12 pr-4 text-base font-semibold uppercase tracking-widest text-slate-900 outline-none focus:border-slate-900 focus:ring-2 focus:ring-slate-900/10" />
                                </div>
                                <button type="button" id="clearPlate" class="rounded-2xl border border-slate-200 bg-white px-4 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                                    Clear
                                </button>
                            </div>
                            @error('plat_nomor')
                                <div class="mt-2 rounded-xl border border-red-200 bg-red-50 px-3 py-2 text-xs text-red-800">{{ $message }}</div>
                            @enderror
                            <div id="plateRealtimeInfo" class="mt-2 hidden rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs text-slate-700"></div>
                            <div class="mt-2 text-xs text-slate-500">Tips: input cepat tanpa spasi juga bisa (contoh: B1234XYZ).</div>
                        </div>

                        <div class="mt-6">
                            <label class="text-xs font-semibold uppercase tracking-wide text-slate-600">Jenis Kendaraan</label>
                            <p class="mt-1 text-xs text-slate-500">Pilihan mengikuti jenis yang ada di master Tarif (beserta tarif per jam).</p>
                            <input type="hidden" name="jenis_kendaraan" id="jenis_kendaraan" value="{{ $jenisDefault }}" />
                            @if (empty($vehicleTypeOptions))
                                <div class="mt-2 rounded-2xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-900">
                                    Belum ada data Tarif jenis kendaraan. Admin harus menambahnya di menu Tarif terlebih dahulu.
                                </div>
                            @else
                                <div class="mt-2 {{ $jenisGridClass }}">
                                    @foreach ($vehicleTypeOptions as $opt)
                                        <button type="button"
                                                class="jenisBtn group rounded-2xl border border-slate-200 bg-white px-4 py-4 text-left hover:bg-slate-50"
                                                data-value="{{ $opt['value'] }}"
                                                aria-pressed="false">
                                            <div class="flex items-center gap-3">
                                                <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-slate-900/5 text-slate-900 ring-1 ring-slate-900/10">
                                                    <i class="fas {{ $opt['icon'] }}"></i>
                                                </div>
                                                <div>
                                                    <div class="text-sm font-semibold text-slate-900">{{ $opt['label'] }}</div>
                                                    <div class="mt-0.5 text-xs text-slate-500">{{ $opt['subtitle'] }}</div>
                                                </div>
                                            </div>
                                        </button>
                                    @endforeach
                                </div>
                            @endif
                            @error('jenis_kendaraan')
                                <div class="mt-2 rounded-xl border border-red-200 bg-red-50 px-3 py-2 text-xs text-red-800">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <label for="warna" class="text-xs font-semibold uppercase tracking-wide text-slate-600">Warna (opsional)</label>
                                <div class="relative mt-2">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                        <i class="fas fa-palette text-sm"></i>
                                    </div>
                                    <input type="text" name="warna" id="warna"
                                           value="{{ $warnaDefault }}"
                                           placeholder="Hitam"
                                           class="w-full rounded-2xl border border-slate-300 bg-white py-3 pl-12 pr-4 text-sm text-slate-900 outline-none focus:border-slate-900 focus:ring-2 focus:ring-slate-900/10" />
                                </div>
                            </div>
                            <div>
                                <label for="merk" class="text-xs font-semibold uppercase tracking-wide text-slate-600">Merk (opsional)</label>
                                <div class="relative mt-2">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                        <i class="fas fa-tag text-sm"></i>
                                    </div>
                                    <input type="text" name="merk" id="merk"
                                           value="{{ old('merk') }}"
                                           placeholder="Honda, Toyota"
                                           class="w-full rounded-2xl border border-slate-300 bg-white py-3 pl-12 pr-4 text-sm text-slate-900 outline-none focus:border-slate-900 focus:ring-2 focus:ring-slate-900/10" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div class="text-sm font-semibold text-slate-900">Area Parkir</div>
                            <span class="text-xs text-slate-500">Realtime tersedia</span>
                        </div>

                        <div class="mt-5">
                            <label class="text-xs font-semibold uppercase tracking-wide text-slate-600">Pilih Area</label>
                            <input type="hidden" name="area_parkir_id" id="area_parkir_id" value="{{ old('area_parkir_id') }}" />
                            <div class="mt-2 grid grid-cols-1 gap-3 sm:grid-cols-2">
                                @foreach ($areasInitial as $a)
                                    @php
                                        $cap = (int) ($a['kapasitas'] ?? 0);
                                        $aktif = (int) ($a['aktif'] ?? 0);
                                        $tersedia = (int) ($a['tersedia'] ?? 0);
                                        $pct = $cap > 0 ? (int) max(0, min(100, round(($aktif / $cap) * 100))) : 0;
                                        $isFull = $cap > 0 && $tersedia <= 0;
                                    @endphp
                                    <button type="button"
                                            class="areaBtn group rounded-2xl border border-slate-200 bg-white px-4 py-4 text-left hover:bg-slate-50 disabled:cursor-not-allowed disabled:bg-slate-50 disabled:text-slate-400"
                                            data-id="{{ $a['id'] }}"
                                            aria-pressed="false"
                                            @disabled($isFull)>
                                        <div class="flex items-start justify-between gap-3">
                                            <div>
                                                <div class="text-sm font-semibold text-slate-900" data-role="name">{{ $a['nama_area'] }}</div>
                                                <div class="mt-0.5 text-xs text-slate-500" data-role="meta">Terisi {{ $aktif }} dari {{ $cap }}</div>
                                            </div>
                                            <span class="{{ $isFull ? 'inline-flex items-center gap-2 rounded-full bg-amber-500/10 px-3 py-1 text-xs font-semibold text-amber-700 ring-1 ring-inset ring-amber-500/20' : 'inline-flex items-center gap-2 rounded-full bg-emerald-500/10 px-3 py-1 text-xs font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-500/20' }}"
                                                  data-role="badge">
                                                <span class="{{ $isFull ? 'h-1.5 w-1.5 rounded-full bg-amber-600' : 'h-1.5 w-1.5 rounded-full bg-emerald-600' }}"
                                                      data-role="badgeDot"></span>
                                                <span data-role="badgeText">{{ $isFull ? 'Penuh' : "{$tersedia} tersedia" }}</span>
                                            </span>
                                        </div>
                                        <div class="mt-3 h-2 w-full rounded-full bg-slate-100">
                                            <div class="h-2 rounded-full {{ $pct >= 90 ? 'bg-rose-500' : ($pct >= 70 ? 'bg-amber-500' : 'bg-emerald-500') }}"
                                                 data-role="bar"
                                                 style="width: {{ $pct }}%"></div>
                                        </div>
                                    </button>
                                @endforeach
                            </div>
                            <div id="areaClientError" class="mt-2 hidden rounded-xl border border-red-200 bg-red-50 px-3 py-2 text-xs text-red-800"></div>
                            <div class="mt-2 flex flex-wrap items-center gap-2 text-xs text-slate-500">
                                <span class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-3 py-1">
                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                    Tersedia: <span id="selectedAvailable" class="font-semibold text-slate-900">-</span>
                                </span>
                                <span class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-3 py-1">
                                    <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>
                                    Terisi: <span id="selectedActive" class="font-semibold text-slate-900">-</span>
                                </span>
                            </div>
                            @error('area_parkir_id')
                                <div class="mt-2 rounded-xl border border-red-200 bg-red-50 px-3 py-2 text-xs text-red-800">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="flex items-center justify-between gap-3">
                        <a href="{{ route('petugas.dashboard') }}"
                           class="rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                            Batal
                        </a>
                        <button id="submitBtn" class="rounded-2xl bg-slate-900 px-6 py-3 text-sm font-semibold text-white hover:bg-slate-800">
                            Generate Karcis
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        (function () {
            var availabilityUrl = @json(route('petugas.transaksi.masuk.availability'));
            var checkPlateUrl = @json(route('petugas.transaksi.masuk.check-plate'));
            var captureAnalyzeUrl = @json(route('petugas.transaksi.masuk.capture-analyze'));
            var cameraActiveUrl = @json(route('petugas.cameras.active'));
            var areas = @json($areasInitial);
            var csrfToken = @json(csrf_token());
            var vehicleTypeMap = @json($yoloVehicleTypeMap ?? []);
            var allowedJenisTarif = @json($allowedJenisTarif ?? []);

            var formEl = document.getElementById('masukForm');
            var plateEl = document.getElementById('plat_nomor');
            var warnaEl = document.getElementById('warna');
            var merkEl = document.getElementById('merk');
            var clearPlateEl = document.getElementById('clearPlate');
            var plateInfoEl = document.getElementById('plateRealtimeInfo');
            var jenisHiddenEl = document.getElementById('jenis_kendaraan');
            var jenisButtons = Array.prototype.slice.call(document.querySelectorAll('.jenisBtn'));
            var areaHiddenEl = document.getElementById('area_parkir_id');
            var areaButtons = Array.prototype.slice.call(document.querySelectorAll('.areaBtn'));
            var areaClientErrorEl = document.getElementById('areaClientError');
            var selectedAvailableEl = document.getElementById('selectedAvailable');
            var selectedActiveEl = document.getElementById('selectedActive');
            var submitBtnEl = document.getElementById('submitBtn');
            var cameraSelectEl = document.getElementById('cameraSelect');
            var btnCaptureAnalyzeEl = document.getElementById('btnCaptureAnalyze');
            var btnCaptureAnalyzeIconEl = document.getElementById('btnCaptureAnalyzeIcon');
            var btnCaptureAnalyzeTextEl = document.getElementById('btnCaptureAnalyzeText');
            var captureAnalyzeResultEl = document.getElementById('captureAnalyzeResult');
            var plateCheckTimer = null;
            var plateIsParked = false;

            function buildAreasMap(list) {
                var map = {};
                for (var i = 0; i < list.length; i++) {
                    map[String(list[i].id)] = list[i];
                }
                return map;
            }

            function getSelectedAreaId() {
                return areaHiddenEl ? String(areaHiddenEl.value || '') : '';
            }

            function updateJenisUI() {
                var v = String(jenisHiddenEl ? (jenisHiddenEl.value || '') : '');
                for (var i = 0; i < jenisButtons.length; i++) {
                    var btn = jenisButtons[i];
                    var active = btn.getAttribute('data-value') === v;
                    btn.setAttribute('aria-pressed', active ? 'true' : 'false');
                    btn.className = active
                        ? 'jenisBtn group rounded-2xl border border-slate-900 bg-slate-900 text-white px-4 py-4 text-left'
                        : 'jenisBtn group rounded-2xl border border-slate-200 bg-white px-4 py-4 text-left hover:bg-slate-50';
                    var iconWrap = btn.querySelector('div > div');
                    if (iconWrap) {
                        iconWrap.className = active
                            ? 'flex h-10 w-10 items-center justify-center rounded-2xl bg-white/10 text-white ring-1 ring-white/15'
                            : 'flex h-10 w-10 items-center justify-center rounded-2xl bg-slate-900/5 text-slate-900 ring-1 ring-slate-900/10';
                    }
                    var title = btn.querySelector('div > div + div > div');
                    if (title) {
                        title.className = active ? 'text-sm font-semibold text-white' : 'text-sm font-semibold text-slate-900';
                    }
                    var desc = btn.querySelector('div > div + div > div + div');
                    if (desc) {
                        desc.className = active ? 'mt-0.5 text-xs text-white/70' : 'mt-0.5 text-xs text-slate-500';
                    }
                }
            }

            function updateSelectedStats(map) {
                var id = getSelectedAreaId();
                var selectedArea = id && map[id] ? map[id] : null;

                if (selectedAvailableEl) selectedAvailableEl.textContent = selectedArea ? String(selectedArea.tersedia) : '-';
                if (selectedActiveEl) selectedActiveEl.textContent = selectedArea ? String(selectedArea.aktif) : '-';
            }

            function normalizePlate(v) {
                return String(v || '')
                    .trim()
                    .replace(/\s+/g, '')
                    .toUpperCase();
            }

            function hidePlateInfo() {
                if (!plateInfoEl) return;
                plateInfoEl.className = 'mt-2 hidden rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs text-slate-700';
                plateInfoEl.textContent = '';
            }

            function setPlateInfo(type, text) {
                if (!plateInfoEl) return;
                var base = 'mt-2 rounded-xl px-3 py-2 text-xs';
                if (type === 'error') {
                    plateInfoEl.className = base + ' border border-red-200 bg-red-50 text-red-800';
                } else if (type === 'success') {
                    plateInfoEl.className = base + ' border border-emerald-200 bg-emerald-50 text-emerald-800';
                } else {
                    plateInfoEl.className = base + ' border border-slate-200 bg-white text-slate-700';
                }
                plateInfoEl.textContent = text;
            }

            function setSubmitDisabled(disabled, text) {
                if (!submitBtnEl) return;
                if (disabled) {
                    submitBtnEl.disabled = true;
                    submitBtnEl.className = 'rounded-2xl bg-slate-900 px-6 py-3 text-sm font-semibold text-white opacity-70';
                    if (text) submitBtnEl.textContent = text;
                } else {
                    submitBtnEl.disabled = false;
                    submitBtnEl.className = 'rounded-2xl bg-slate-900 px-6 py-3 text-sm font-semibold text-white hover:bg-slate-800';
                    submitBtnEl.textContent = 'Generate Karcis';
                }
            }

            function setCaptureState(loading) {
                if (!btnCaptureAnalyzeEl) return;
                btnCaptureAnalyzeEl.disabled = !!loading;
                if (loading) {
                    btnCaptureAnalyzeEl.className = 'inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2 text-xs font-semibold text-white opacity-70';
                    if (btnCaptureAnalyzeIconEl) btnCaptureAnalyzeIconEl.className = 'fas fa-spinner fa-spin';
                    if (btnCaptureAnalyzeTextEl) btnCaptureAnalyzeTextEl.textContent = 'Menganalisis...';
                    return;
                }

                btnCaptureAnalyzeEl.className = 'inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2 text-xs font-semibold text-white hover:bg-blue-700 transition';
                if (btnCaptureAnalyzeIconEl) btnCaptureAnalyzeIconEl.className = 'fas fa-camera';
                if (btnCaptureAnalyzeTextEl) btnCaptureAnalyzeTextEl.textContent = 'Ambil & Analisis';
            }

            function setCaptureResult(type, text) {
                if (!captureAnalyzeResultEl) return;
                var base = 'mt-3 rounded-xl border px-3 py-2 text-xs';
                if (type === 'success') {
                    captureAnalyzeResultEl.className = base + ' border-emerald-200 bg-emerald-50 text-emerald-800';
                } else if (type === 'error') {
                    captureAnalyzeResultEl.className = base + ' border-red-200 bg-red-50 text-red-800';
                } else {
                    captureAnalyzeResultEl.className = base + ' border-blue-200 bg-blue-50 text-blue-900';
                }
                captureAnalyzeResultEl.textContent = text;
            }

            function fillFromDetection(payload) {
                if (!payload) return;

                var plate = payload.plate_number ? normalizePlate(payload.plate_number) : '';
                var jenis = '';
                if (payload.vehicle_type) {
                    var rawVt = String(payload.vehicle_type);
                    var key = rawVt.toLowerCase();
                    jenis = vehicleTypeMap[key] || vehicleTypeMap[rawVt] || '';
                    if (!jenis && allowedJenisTarif && allowedJenisTarif.length) {
                        for (var ai = 0; ai < allowedJenisTarif.length; ai++) {
                            var aj = String(allowedJenisTarif[ai]);
                            if (aj.toLowerCase() === key) {
                                jenis = aj;
                                break;
                            }
                        }
                    }
                }
                var warna = payload.color ? String(payload.color).trim() : '';

                if (plateEl && plate) {
                    plateEl.value = plate;
                    schedulePlateCheck();
                }
                if (jenisHiddenEl && jenis) {
                    jenisHiddenEl.value = jenis;
                    updateJenisUI();
                }
                if (warnaEl && warna) {
                    warnaEl.value = warna;
                }
            }

            function loadActiveCameras() {
                if (!cameraSelectEl) return;
                fetch(cameraActiveUrl, { headers: { 'Accept': 'application/json' }, credentials: 'same-origin' })
                    .then(function (r) { return r.json(); })
                    .then(function (list) {
                        if (!Array.isArray(list)) return;
                        cameraSelectEl.innerHTML = '<option value="">Pilih kamera aktif</option>';
                        for (var i = 0; i < list.length; i++) {
                            var c = list[i];
                            var opt = document.createElement('option');
                            opt.value = String(c.id);
                            opt.textContent = c.name || ('Kamera #' + c.id);
                            cameraSelectEl.appendChild(opt);
                        }
                        if (list.length > 0) {
                            cameraSelectEl.value = String(list[0].id);
                        }
                    })
                    .catch(function () {});
            }

            function schedulePlateCheck() {
                if (!plateEl) return;
                if (plateCheckTimer) clearTimeout(plateCheckTimer);

                plateCheckTimer = setTimeout(function () {
                    var plat = normalizePlate(plateEl.value);
                    plateIsParked = false;
                    setSubmitDisabled(false);

                    if (plat.length < 3 || plat.length > 10) {
                        hidePlateInfo();
                        return;
                    }

                    fetch(checkPlateUrl + '?plat=' + encodeURIComponent(plat), { headers: { 'Accept': 'application/json' } })
                        .then(function (r) { return r.json(); })
                        .then(function (json) {
                            if (!json || json.success !== true || !json.data) return;
                            var d = json.data;
                            if (d.parked) {
                                plateIsParked = true;
                                var msg = 'Kendaraan ' + (d.plat || plat) + ' sudah terparkir';
                                if (d.active && d.active.area) msg += ' di area ' + d.active.area;
                                if (d.active && d.active.barcode) msg += ' (Karcis ' + d.active.barcode + ')';
                                msg += '.';
                                setPlateInfo('error', msg);
                                setSubmitDisabled(true, 'Plat sedang parkir');
                                return;
                            }

                            if (d.exists && d.vehicle) {
                                if (jenisHiddenEl && d.vehicle.jenis_kendaraan) {
                                    jenisHiddenEl.value = d.vehicle.jenis_kendaraan;
                                    updateJenisUI();
                                }
                                if (warnaEl && d.vehicle.warna) {
                                    warnaEl.value = d.vehicle.warna;
                                }
                                if (merkEl && d.vehicle.merk) {
                                    merkEl.value = d.vehicle.merk;
                                }
                            }

                            if (d.is_terdaftar) {
                                setPlateInfo('success', 'Plat ' + (d.plat || plat) + ' terdaftar di sistem (Autofill aktif).');
                                return;
                            }

                            if (d.exists) {
                                setPlateInfo('info', 'Plat ' + (d.plat || plat) + ' pernah tercatat di sistem (Autofill aktif).');
                                return;
                            }

                            hidePlateInfo();
                        })
                        .catch(function () {});
                }, 350);
            }

            function updateAreaButtonsUI(map) {
                var selectedId = getSelectedAreaId();

                for (var i = 0; i < areaButtons.length; i++) {
                    var btn = areaButtons[i];
                    var id = btn.getAttribute('data-id') ? String(btn.getAttribute('data-id')) : '';
                    if (!id || !map[id]) continue;

                    var a = map[id];
                    var cap = Number(a.kapasitas || 0);
                    var aktif = Number(a.aktif || 0);
                    var tersedia = Number(a.tersedia || 0);
                    var pct = cap > 0 ? Math.max(0, Math.min(100, Math.round((aktif / cap) * 100))) : 0;
                    var full = cap > 0 && tersedia <= 0;
                    var active = id === selectedId;

                    btn.disabled = full;
                    btn.setAttribute('aria-pressed', active ? 'true' : 'false');

                    if (active) {
                        btn.className = 'areaBtn group rounded-2xl border border-slate-900 bg-slate-900 px-4 py-4 text-left text-white';
                    } else if (full) {
                        btn.className = 'areaBtn group rounded-2xl border border-slate-200 bg-slate-50 px-4 py-4 text-left text-slate-400 cursor-not-allowed';
                    } else {
                        btn.className = 'areaBtn group rounded-2xl border border-slate-200 bg-white px-4 py-4 text-left hover:bg-slate-50';
                    }

                    var nameEl = btn.querySelector('[data-role="name"]');
                    if (nameEl) {
                        nameEl.textContent = a.nama_area;
                        nameEl.className = active ? 'text-sm font-semibold text-white' : 'text-sm font-semibold text-slate-900';
                    }

                    var metaEl = btn.querySelector('[data-role="meta"]');
                    if (metaEl) {
                        metaEl.textContent = 'Terisi ' + aktif + ' dari ' + cap;
                        metaEl.className = active ? 'mt-0.5 text-xs text-white/70' : 'mt-0.5 text-xs text-slate-500';
                    }

                    var badgeEl = btn.querySelector('[data-role="badge"]');
                    var badgeDotEl = btn.querySelector('[data-role="badgeDot"]');
                    var badgeTextEl = btn.querySelector('[data-role="badgeText"]');

                    if (badgeEl) {
                        badgeEl.className = full
                            ? (active ? 'inline-flex items-center gap-2 rounded-full bg-white/10 px-3 py-1 text-xs font-semibold text-white ring-1 ring-inset ring-white/15' : 'inline-flex items-center gap-2 rounded-full bg-amber-500/10 px-3 py-1 text-xs font-semibold text-amber-700 ring-1 ring-inset ring-amber-500/20')
                            : (active ? 'inline-flex items-center gap-2 rounded-full bg-white/10 px-3 py-1 text-xs font-semibold text-white ring-1 ring-inset ring-white/15' : 'inline-flex items-center gap-2 rounded-full bg-emerald-500/10 px-3 py-1 text-xs font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-500/20');
                    }

                    if (badgeDotEl) {
                        badgeDotEl.className = full
                            ? (active ? 'h-1.5 w-1.5 rounded-full bg-white' : 'h-1.5 w-1.5 rounded-full bg-amber-600')
                            : (active ? 'h-1.5 w-1.5 rounded-full bg-white' : 'h-1.5 w-1.5 rounded-full bg-emerald-600');
                    }

                    if (badgeTextEl) {
                        badgeTextEl.textContent = full ? 'Penuh' : (tersedia + ' tersedia');
                    }

                    var barEl = btn.querySelector('[data-role="bar"]');
                    if (barEl) {
                        barEl.style.width = pct + '%';
                        // Jangan hilangkan warna okupansi saat dipilih.
                        barEl.className = 'h-2 rounded-full ' + (pct >= 90 ? 'bg-rose-500' : pct >= 70 ? 'bg-amber-500' : 'bg-emerald-500');
                    }
                }
            }

            function applyAreas(list) {
                areas = list;
                var map = buildAreasMap(areas);
                updateAreaButtonsUI(map);

                var selectedId = getSelectedAreaId();
                if (selectedId && map[selectedId]) {
                    var a = map[selectedId];
                    var cap = Number(a.kapasitas || 0);
                    var tersedia = Number(a.tersedia || 0);
                    var full = cap > 0 && tersedia <= 0;
                    if (full && areaHiddenEl) {
                        areaHiddenEl.value = '';
                        updateAreaButtonsUI(map);
                    }
                }

                updateSelectedStats(map);
            }

            function refreshAvailability() {
                fetch(availabilityUrl, { headers: { 'Accept': 'application/json' } })
                    .then(function (r) { return r.json(); })
                    .then(function (json) {
                        if (!json || json.success !== true || !Array.isArray(json.data)) return;
                        applyAreas(json.data);
                    })
                    .catch(function () {});
            }

            if (plateEl) {
                plateEl.focus();
                plateEl.addEventListener('input', function () {
                    plateEl.value = String(plateEl.value || '').toUpperCase();
                    schedulePlateCheck();
                });
                plateEl.addEventListener('blur', function () {
                    plateEl.value = String(plateEl.value || '')
                        .replace(/\s+/g, ' ')
                        .trim()
                        .toUpperCase();
                    schedulePlateCheck();
                });
            }

            if (clearPlateEl && plateEl) {
                clearPlateEl.addEventListener('click', function () {
                    plateEl.value = '';
                    plateEl.focus();
                    plateIsParked = false;
                    setSubmitDisabled(false);
                    hidePlateInfo();
                });
            }

            if (jenisHiddenEl) {
                updateJenisUI();
                for (var i = 0; i < jenisButtons.length; i++) {
                    jenisButtons[i].addEventListener('click', function (e) {
                        var v = e.currentTarget.getAttribute('data-value');
                        jenisHiddenEl.value = v || '';
                        updateJenisUI();
                    });
                }
                if (jenisButtons.length === 0) {
                    setSubmitDisabled(true, 'Tarif jenis belum diatur');
                }
            }

            if (areaHiddenEl) {
                for (var i = 0; i < areaButtons.length; i++) {
                    areaButtons[i].addEventListener('click', function (e) {
                        var btn = e.currentTarget;
                        if (btn.disabled) return;
                        var id = btn.getAttribute('data-id');
                        if (!id) return;
                        areaHiddenEl.value = String(id);
                        if (areaClientErrorEl) {
                            areaClientErrorEl.className = 'mt-2 hidden rounded-xl border border-red-200 bg-red-50 px-3 py-2 text-xs text-red-800';
                            areaClientErrorEl.textContent = '';
                        }
                        var map = buildAreasMap(areas);
                        updateAreaButtonsUI(map);
                        updateSelectedStats(map);
                    });
                }
            }

            if (formEl) {
                formEl.addEventListener('keydown', function (e) {
                    if (e.key === 'Enter') {
                        var target = e.target;
                        if (target.tagName.toLowerCase() === 'input') {
                            var plat = normalizePlate(plateEl.value);
                            var jenis = jenisHiddenEl.value;
                            var area = getSelectedAreaId();

                            if (plat && jenis && area && !plateIsParked) {
                                e.preventDefault();
                                formEl.dispatchEvent(new Event('submit', { cancelable: true }));
                                if (!e.defaultPrevented) {
                                    formEl.submit();
                                }
                            }
                        }
                    }
                });

                formEl.addEventListener('submit', function (e) {
                    if (plateIsParked) {
                        if (plateEl) plateEl.focus();
                        e.preventDefault();
                        return;
                    }

                    if (!jenisHiddenEl || !String(jenisHiddenEl.value || '').trim()) {
                        e.preventDefault();
                        return;
                    }

                    var areaId = getSelectedAreaId();
                    if (!areaId) {
                        if (areaClientErrorEl) {
                            areaClientErrorEl.textContent = 'Silakan pilih area parkir terlebih dahulu.';
                            areaClientErrorEl.className = 'mt-2 rounded-xl border border-red-200 bg-red-50 px-3 py-2 text-xs text-red-800';
                        }
                        e.preventDefault();
                        return;
                    }

                    if (submitBtnEl) {
                        submitBtnEl.disabled = true;
                        submitBtnEl.className = 'rounded-2xl bg-slate-900 px-6 py-3 text-sm font-semibold text-white opacity-70';
                        submitBtnEl.textContent = 'Memproses...';
                    }
                });
            }

            if (btnCaptureAnalyzeEl) {
                btnCaptureAnalyzeEl.addEventListener('click', function () {
                    setCaptureState(true);
                    setCaptureResult('info', 'Mengambil gambar dari IP webcam...');

                    var payload = {};
                    if (cameraSelectEl && cameraSelectEl.value) {
                        payload.camera_id = Number(cameraSelectEl.value);
                    }

                    fetch(captureAnalyzeUrl, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                        },
                        credentials: 'same-origin',
                        body: JSON.stringify(payload),
                    })
                    .then(function (r) {
                        return r.json().then(function (json) {
                            return { ok: r.ok, status: r.status, json: json };
                        }).catch(function () {
                            return { ok: r.ok, status: r.status, json: {} };
                        });
                    })
                    .then(function (res) {
                        if (!res.ok || !res.json || res.json.success !== true) {
                            setCaptureResult('error', (res.json && res.json.message) ? res.json.message : ('Gagal analisis (HTTP ' + res.status + ').'));
                            return;
                        }

                        var auto = res.json.autofill || res.json.data || {};
                        fillFromDetection(auto);
                        var vt = auto.vehicle_type ? String(auto.vehicle_type) : '-';
                        var clr = auto.color ? String(auto.color) : '-';
                        var plt = auto.plate_number ? String(auto.plate_number) : '-';
                        setCaptureResult('success', 'Autofill berhasil. Plat: ' + plt + ', Jenis: ' + vt + ', Warna: ' + clr + '.');
                    })
                    .catch(function (e) {
                        setCaptureResult('error', 'Terjadi kesalahan: ' + (e && e.message ? e.message : 'unknown'));
                    })
                    .finally(function () {
                        setCaptureState(false);
                    });
                });
            }

            applyAreas(areas);
            loadActiveCameras();
            refreshAvailability();
            setInterval(refreshAvailability, 5000);
            schedulePlateCheck();
        })();
    </script>
</x-layouts.petugas>
