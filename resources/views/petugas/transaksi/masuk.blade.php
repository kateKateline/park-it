<x-layouts.petugas :title="'Kendaraan Masuk - Petugas'">
    @php
        $vehicleTypeMap = ['car' => 'mobil', 'motorcycle' => 'motor', 'truck' => 'truk', 'bus' => 'bus'];
        $jenisDefault = old('jenis_kendaraan');
        $warnaDefault = old('warna');
        if (($jenisDefault === null || $jenisDefault === '') && !empty($latestDetection ?? null)) {
            $jenisDefault = $vehicleTypeMap[$latestDetection['vehicle_type'] ?? ''] ?? null;
        }
        if (($warnaDefault === null || $warnaDefault === '') && !empty($latestDetection ?? null)) {
            $warnaDefault = $latestDetection['color'] ?? null;
        }

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
                            <div class="mt-2 text-xs text-slate-500">Tips: input cepat tanpa spasi juga bisa (contoh: B1234XYZ).</div>
                        </div>

                        <div class="mt-6">
                            <label class="text-xs font-semibold uppercase tracking-wide text-slate-600">Jenis Kendaraan</label>
                            <input type="hidden" name="jenis_kendaraan" id="jenis_kendaraan" value="{{ $jenisDefault ?? '' }}" />
                            <div class="mt-2 grid grid-cols-2 gap-3">
                                <button type="button" class="jenisBtn group rounded-2xl border border-slate-200 bg-white px-4 py-4 text-left hover:bg-slate-50" data-value="motor" aria-pressed="false">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-slate-900/5 text-slate-900 ring-1 ring-slate-900/10">
                                            <i class="fas fa-motorcycle"></i>
                                        </div>
                                        <div>
                                            <div class="text-sm font-semibold text-slate-900">Motor</div>
                                            <div class="mt-0.5 text-xs text-slate-500">Kendaraan roda dua</div>
                                        </div>
                                    </div>
                                </button>
                                <button type="button" class="jenisBtn group rounded-2xl border border-slate-200 bg-white px-4 py-4 text-left hover:bg-slate-50" data-value="mobil" aria-pressed="false">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-slate-900/5 text-slate-900 ring-1 ring-slate-900/10">
                                            <i class="fas fa-car-side"></i>
                                        </div>
                                        <div>
                                            <div class="text-sm font-semibold text-slate-900">Mobil</div>
                                            <div class="mt-0.5 text-xs text-slate-500">Kendaraan roda empat</div>
                                        </div>
                                    </div>
                                </button>
                            </div>
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
            var areas = @json($areasInitial);

            var formEl = document.getElementById('masukForm');
            var plateEl = document.getElementById('plat_nomor');
            var clearPlateEl = document.getElementById('clearPlate');
            var jenisHiddenEl = document.getElementById('jenis_kendaraan');
            var jenisButtons = Array.prototype.slice.call(document.querySelectorAll('.jenisBtn'));
            var areaHiddenEl = document.getElementById('area_parkir_id');
            var areaButtons = Array.prototype.slice.call(document.querySelectorAll('.areaBtn'));
            var areaClientErrorEl = document.getElementById('areaClientError');
            var selectedAvailableEl = document.getElementById('selectedAvailable');
            var selectedActiveEl = document.getElementById('selectedActive');
            var submitBtnEl = document.getElementById('submitBtn');

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
                        ? 'jenisBtn group rounded-2xl border border-blue-600 bg-blue-600 text-white px-4 py-4 text-left'
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
                        btn.className = 'areaBtn group rounded-2xl border border-blue-600 bg-blue-600 px-4 py-4 text-left text-white';
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
                        barEl.className = active
                            ? 'h-2 rounded-full bg-white/80'
                            : ('h-2 rounded-full ' + (pct >= 90 ? 'bg-rose-500' : pct >= 70 ? 'bg-amber-500' : 'bg-emerald-500'));
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
                });
                plateEl.addEventListener('blur', function () {
                    plateEl.value = String(plateEl.value || '')
                        .replace(/\s+/g, ' ')
                        .trim()
                        .toUpperCase();
                });
            }

            if (clearPlateEl && plateEl) {
                clearPlateEl.addEventListener('click', function () {
                    plateEl.value = '';
                    plateEl.focus();
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
                formEl.addEventListener('submit', function (e) {
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

            applyAreas(areas);
            refreshAvailability();
            setInterval(refreshAvailability, 5000);
        })();
    </script>
</x-layouts.petugas>
