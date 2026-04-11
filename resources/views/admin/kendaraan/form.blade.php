<x-layouts.admin :title="$mode === 'create' ? 'Tambah Kendaraan - Admin' : 'Edit Kendaraan - Admin'">
    @php
        $vehicleTypeOptions = $vehicleTypeOptions ?? [];
        $defaultJenis = old('jenis_kendaraan', $model->jenis_kendaraan ?? $jenisPrefill ?? '');
        $defaultWarna = old('warna', $model->warna);

        if ($mode === 'create' && ! empty($latestDetection ?? null) && ($defaultWarna === null || $defaultWarna === '')) {
            $defaultWarna = $latestDetection['color'] ?? '';
        }

        $nJenis = count($vehicleTypeOptions);
        $jenisGridClass = $nJenis <= 0
            ? 'grid grid-cols-1 gap-3'
            : ($nJenis === 1
                ? 'grid grid-cols-1 gap-3'
                : ($nJenis === 2
                    ? 'grid grid-cols-1 gap-3 sm:grid-cols-2'
                    : 'grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-3'));
    @endphp

    <div class="mx-auto max-w-5xl p-6">
        @include('partials.topbar', [
            'title' => $mode === 'create' ? 'Tambah Kendaraan' : 'Edit Kendaraan',
            'subtitle' => 'Kelola data kendaraan dengan tampilan yang konsisten.',
        ])

        <div class="mt-6 space-y-4">
            @include('partials.flash')

            @if ($errors->any())
                <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                    <div class="font-medium">Validasi gagal</div>
                    <ul class="mt-1 list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if ($mode === 'create' && !empty($latestDetection ?? null))
                <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-900">
                    <div class="font-semibold">Data deteksi terbaru (YOLO)</div>
                    <div class="mt-1 text-xs text-emerald-900/80">
                        Jenis: <span class="font-semibold">{{ $latestDetection['vehicle_type'] ?? '-' }}</span>,
                        Warna: <span class="font-semibold">{{ $latestDetection['color'] ?? '-' }}</span>,
                        Confidence:
                        <span class="font-semibold">{{ isset($latestDetection['confidence']) ? round($latestDetection['confidence'] * 100) . '%' : '-' }}</span>
                    </div>
                </div>
            @endif

            <form method="POST"
                  action="{{ $mode === 'create' ? route('admin.kendaraan.store') : route('admin.kendaraan.update', $model) }}"
                  class="space-y-6 rounded-2xl border border-slate-200 bg-white p-8">
                @csrf
                @if ($mode === 'edit')
                    @method('PUT')
                @endif

                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label for="plat_nomor" class="block text-sm font-medium text-slate-700">Plat Nomor</label>
                        <div class="mt-1 flex items-stretch gap-2">
                            <input type="text" name="plat_nomor" id="plat_nomor" required
                                   value="{{ old('plat_nomor', $model->plat_nomor) }}"
                                   minlength="3"
                                   maxlength="10"
                                   placeholder="B 1234 XYZ"
                                   autocomplete="off"
                                   class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-base font-semibold uppercase tracking-widest text-slate-900 outline-none focus:border-slate-900 focus:ring-2 focus:ring-slate-900/10" />
                            <button type="button" id="clearPlate" class="rounded-xl border border-slate-200 bg-white px-4 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                                Clear
                            </button>
                        </div>
                        <p class="mt-1 text-xs text-slate-500">Tips: boleh input tanpa spasi, format akan dinormalisasi otomatis.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700">Jenis Kendaraan</label>
                        <p class="text-xs text-slate-500">Harus sama dengan salah satu jenis pada master Tarif.</p>
                        <input type="hidden" name="jenis_kendaraan" id="jenis_kendaraan" value="{{ $defaultJenis }}" />
                        @if (empty($vehicleTypeOptions))
                            <div class="mt-2 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-900">
                                Belum ada data Tarif jenis kendaraan. Tambahkan di menu Tarif terlebih dahulu.
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
                    </div>

                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <label for="warna" class="block text-sm font-medium text-slate-700">Warna (opsional)</label>
                            <input type="text" name="warna" id="warna"
                                   value="{{ $defaultWarna }}"
                                   placeholder="Hitam"
                                   class="mt-1 w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-base outline-none focus:border-slate-900 focus:ring-2 focus:ring-slate-900/10" />
                        </div>
                        <div>
                            <label for="merk" class="block text-sm font-medium text-slate-700">Merk (opsional)</label>
                            <input type="text" name="merk" id="merk"
                                   value="{{ old('merk', $model->merk) }}"
                                   placeholder="Honda, Toyota"
                                   class="mt-1 w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-base outline-none focus:border-slate-900 focus:ring-2 focus:ring-slate-900/10" />
                        </div>
                    </div>

                    <div>
                        <label for="pemilik" class="block text-sm font-medium text-slate-700">Pemilik (opsional)</label>
                        <input type="text" name="pemilik" id="pemilik"
                               value="{{ old('pemilik', $model->pemilik) }}"
                               class="mt-1 w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-base outline-none focus:border-slate-900 focus:ring-2 focus:ring-slate-900/10" />
                    </div>

                    <div class="flex items-center gap-2">
                        <input type="checkbox" id="is_terdaftar" name="is_terdaftar" value="1"
                               class="h-4 w-4 rounded border-slate-300 text-slate-900 focus:ring-slate-900/20"
                               @checked(old('is_terdaftar', (bool) $model->is_terdaftar)) />
                        <label for="is_terdaftar" class="text-sm font-medium text-slate-700">Kendaraan terdaftar</label>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-2 border-t border-gray-100 pt-4">
                    <a href="{{ route('admin.kendaraan.index') }}"
                       class="rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm font-medium hover:bg-slate-50">
                        Batal
                    </a>
                    <button type="submit"
                            class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800 disabled:cursor-not-allowed disabled:opacity-50"
                            @if (empty($vehicleTypeOptions)) disabled @endif>
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const plateInput = document.getElementById('plat_nomor');
            const clearBtn = document.getElementById('clearPlate');
            const jenisInput = document.getElementById('jenis_kendaraan');
            const jenisButtons = Array.from(document.querySelectorAll('.jenisBtn'));

            const normalizePlate = (v) => (v || '').toUpperCase().replace(/[^A-Z0-9 ]/g, '').replace(/\s+/g, ' ').trim();

            const setJenis = (value) => {
                if (!jenisInput) return;
                jenisInput.value = value;
                jenisButtons.forEach((btn) => {
                    const active = btn.dataset.value === value;
                    btn.setAttribute('aria-pressed', active ? 'true' : 'false');

                    // Match petugas/transaksi/masuk style (hitam jika dipilih)
                    btn.className = active
                        ? 'jenisBtn group rounded-2xl border border-slate-900 bg-slate-900 text-white px-4 py-4 text-left'
                        : 'jenisBtn group rounded-2xl border border-slate-200 bg-white px-4 py-4 text-left hover:bg-slate-50';

                    const iconWrap = btn.querySelector('div > div');
                    if (iconWrap) {
                        iconWrap.className = active
                            ? 'flex h-10 w-10 items-center justify-center rounded-2xl bg-white/10 text-white ring-1 ring-white/15'
                            : 'flex h-10 w-10 items-center justify-center rounded-2xl bg-slate-900/5 text-slate-900 ring-1 ring-slate-900/10';
                    }

                    const title = btn.querySelector('div > div + div > div');
                    if (title) {
                        title.className = active ? 'text-sm font-semibold text-white' : 'text-sm font-semibold text-slate-900';
                    }

                    const desc = btn.querySelector('div > div + div > div + div');
                    if (desc) {
                        desc.className = active ? 'mt-0.5 text-xs text-white/70' : 'mt-0.5 text-xs text-slate-500';
                    }
                });
            };

            if (plateInput) {
                plateInput.addEventListener('input', () => {
                    const cursor = plateInput.selectionStart;
                    plateInput.value = normalizePlate(plateInput.value);
                    if (cursor !== null) {
                        plateInput.setSelectionRange(plateInput.value.length, plateInput.value.length);
                    }
                });
            }

            clearBtn?.addEventListener('click', () => {
                if (!plateInput) return;
                plateInput.value = '';
                plateInput.focus();
            });

            jenisButtons.forEach((btn) => {
                btn.addEventListener('click', () => setJenis(btn.dataset.value || ''));
            });

            setJenis(jenisInput?.value || '');
        });
    </script>
</x-layouts.admin>