<x-layouts.petugas :title="'Kendaraan Keluar - Petugas'">
    <div class="space-y-6">
        @include('partials.flash')

        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h1 class="text-xl font-semibold tracking-tight text-slate-900 sm:text-2xl">Kendaraan Keluar</h1>
                <p class="mt-1 text-sm text-slate-600">Scan QR atau masukkan kode karcis untuk menghitung tarif.</p>
            </div>
            <div class="flex flex-wrap items-center gap-2 text-xs text-slate-500">
                <span class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-3 py-1">
                    <i class="fas fa-clock text-[11px]"></i>
                    <span>{{ now()->format('d/m/Y H:i') }}</span>
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">
            <div class="lg:col-span-12">
                <div class="space-y-6">
                    <!-- Bagian Atas: Scan QR (Otomatis) -->
                    <div class="rounded-2xl border border-blue-200 bg-blue-50 p-6 shadow-sm">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h2 class="text-sm font-semibold text-blue-900">Scan QR Karcis Otomatis</h2>
                                <p class="mt-1 text-xs text-blue-900/70">Arahkan QR karcis ke kamera untuk pemindaian langsung.</p>
                            </div>
                            <div id="qr-status" class="rounded-full bg-blue-100 px-3 py-1 text-[10px] font-bold uppercase tracking-wider text-blue-600 ring-1 ring-blue-200">Ready</div>
                        </div>

                        <div class="relative mx-auto max-w-md overflow-hidden rounded-2xl bg-white shadow-inner ring-1 ring-blue-100" style="min-height: 320px;">
                            <div id="reader" style="width: 100%; min-height: 320px;" class="bg-slate-50"></div>
                            <div id="reader-placeholder" class="absolute inset-0 flex flex-col items-center justify-center p-8 text-center text-slate-400">
                                <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-slate-100">
                                    <i class="fas fa-qrcode text-3xl"></i>
                                </div>
                                <p class="text-xs font-medium">Klik tombol di bawah untuk mengaktifkan kamera scanner.</p>
                                <button type="button" id="startScanBtn" class="mt-4 rounded-xl bg-blue-600 px-6 py-2.5 text-xs font-bold text-white shadow-lg shadow-blue-600/20 hover:bg-blue-700 transition active:scale-95">
                                    Aktifkan Kamera
                                </button>
                            </div>
                        </div>

                        <div class="mt-4 flex items-center justify-between gap-3">
                            <div class="flex items-center gap-2 text-[10px] text-blue-800/60 italic font-medium">
                                <i class="fas fa-info-circle"></i>
                                <span>Karcis akan diproses secara otomatis setelah terdeteksi.</span>
                            </div>
                            <div class="flex gap-2">
                                <button type="button" id="scanFileBtn" class="rounded-xl border border-blue-200 bg-white px-4 py-2 text-xs font-semibold text-blue-700 hover:bg-blue-100/50 transition">
                                    <i class="fas fa-file-upload mr-1.5"></i>
                                    Scan dari File
                                </button>
                                <input type="file" id="qr-input-file" accept="image/*" class="hidden" />
                                <button type="button" id="stopScanBtn" class="hidden rounded-xl border border-red-200 bg-red-50 px-4 py-2 text-xs font-semibold text-red-600 hover:bg-red-100 transition">
                                    Berhenti Scan
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Bagian Bawah: Input Manual (Kode Kecil) -->
                    <form action="{{ route('petugas.transaksi.keluar.scan') }}" method="POST" id="scanForm">
                        @csrf
                        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                            <div class="flex items-center gap-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-900/5 text-slate-600">
                                    <i class="fas fa-keyboard text-sm"></i>
                                </div>
                                <div class="flex-1">
                                    <label for="kode_karcis" class="block text-xs font-bold uppercase tracking-wider text-slate-500">Input Kode Karcis Manual</label>
                                    <div class="mt-2 flex items-stretch gap-2">
                                        <div class="relative flex-1">
                                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                                <i class="fas fa-id-card text-sm"></i>
                                            </div>
                                            <input type="text" name="kode_karcis" id="kode_karcis" required
                                                   value="{{ old('kode_karcis') }}"
                                                   placeholder="PARK-XXXXXXXXXX"
                                                   class="w-full rounded-xl border border-slate-300 bg-white py-3 pl-12 pr-4 text-sm font-mono font-semibold tracking-wider text-slate-900 outline-none focus:border-slate-900 focus:ring-2 focus:ring-slate-900/10 transition" />
                                        </div>
                                        <button type="submit" id="submitBtn" class="rounded-xl bg-slate-900 px-6 text-xs font-bold text-white hover:bg-slate-800 transition active:scale-95">
                                            Cari & Hitung
                                        </button>
                                    </div>
                                    @error('kode_karcis')
                                        <div class="mt-2 rounded-xl border border-red-200 bg-red-50 px-3 py-2 text-xs text-red-800">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="flex items-center justify-start">
                        <a href="{{ route('petugas.dashboard') }}"
                           class="rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-xs font-bold text-slate-700 hover:bg-slate-50 transition">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali ke Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var html5QrCode = null;
            var kodeKarcisInput = document.getElementById('kode_karcis');
            var scanForm = document.getElementById('scanForm');
            var qrStatus = document.getElementById('qr-status');
            var startBtn = document.getElementById('startScanBtn');
            var stopBtn = document.getElementById('stopScanBtn');
            var scanFileBtn = document.getElementById('scanFileBtn');
            var qrInputFile = document.getElementById('qr-input-file');
            var placeholder = document.getElementById('reader-placeholder');
            var submitBtn = document.getElementById('submitBtn');

            function onScanSuccess(decodedText, decodedResult) {
                // Berhenti scan setelah sukses
                stopScanning();

                // Isi input
                if (kodeKarcisInput) {
                    kodeKarcisInput.value = decodedText;
                }

                // Update status
                if (qrStatus) {
                    qrStatus.textContent = 'BERHASIL';
                    qrStatus.className = 'text-[10px] font-bold uppercase tracking-wider text-emerald-600';
                }

                // Auto submit
                if (scanForm) {
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        submitBtn.textContent = 'Memproses...';
                    }
                    setTimeout(function() {
                        scanForm.submit();
                    }, 500);
                }
            }

            function onScanFailure(error) {
                // Failure biasanya karena tidak ada QR di frame, abaikan saja agar terus scanning
            }

            function startScanning() {
                if (html5QrCode === null) {
                    html5QrCode = new Html5Qrcode("reader");
                }

                const config = { fps: 10, qrbox: { width: 250, height: 250 } };

                html5QrCode.start({ facingMode: "environment" }, config, onScanSuccess)
                    .then(() => {
                        placeholder.classList.add('hidden');
                        startBtn.classList.add('hidden');
                        stopBtn.classList.remove('hidden');
                        if (qrStatus) {
                            qrStatus.textContent = 'MEMINDAI...';
                            qrStatus.className = 'text-[10px] font-bold uppercase tracking-wider text-blue-600';
                        }
                    })
                    .catch((err) => {
                        console.error("Gagal start scan:", err);
                        alert("Gagal mengakses kamera. Pastikan izin diberikan.");
                    });
            }

            function stopScanning() {
                if (html5QrCode && html5QrCode.isScanning) {
                    html5QrCode.stop().then(() => {
                        placeholder.classList.remove('hidden');
                        startBtn.classList.remove('hidden');
                        stopBtn.classList.add('hidden');
                        if (qrStatus) {
                            qrStatus.textContent = 'STOPPED';
                            qrStatus.className = 'text-[10px] font-bold uppercase tracking-wider text-slate-400';
                        }
                    }).catch((err) => {
                        console.error("Gagal stop scan:", err);
                    });
                }
            }

            if (startBtn) startBtn.addEventListener('click', startScanning);
            if (stopBtn) stopBtn.addEventListener('click', stopScanning);

            if (scanFileBtn && qrInputFile) {
                scanFileBtn.addEventListener('click', function() {
                    qrInputFile.click();
                });

                qrInputFile.addEventListener('change', function(e) {
                    if (e.target.files.length === 0) return;

                    const imageFile = e.target.files[0];
                    if (html5QrCode === null) {
                        html5QrCode = new Html5Qrcode("reader");
                    }

                    if (qrStatus) {
                        qrStatus.textContent = 'MEMBACA FILE...';
                        qrStatus.className = 'text-[10px] font-bold uppercase tracking-wider text-blue-600';
                    }

                    html5QrCode.scanFile(imageFile, true)
                        .then(onScanSuccess)
                        .catch(err => {
                            console.error("Gagal baca QR dari file:", err);
                            alert("Gagal membaca QR code dari gambar ini.");
                            if (qrStatus) {
                                qrStatus.textContent = 'ERROR';
                                qrStatus.className = 'text-[10px] font-bold uppercase tracking-wider text-red-600';
                            }
                        })
                        .finally(() => {
                            qrInputFile.value = '';
                        });
                });
            }

            // Bersihkan scanner saat meninggalkan halaman
            window.addEventListener('beforeunload', function() {
                if (html5QrCode && html5QrCode.isScanning) {
                    html5QrCode.stop();
                }
            });
        });
    </script>
</x-layouts.petugas>
