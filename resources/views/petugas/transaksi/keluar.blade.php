<x-layouts.petugas :title="'Kendaraan Keluar - Petugas'">
    <div class="space-y-6">
        @include('partials.flash')

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-slate-900">
                        <i class="fas fa-sign-out-alt text-gray-600 mr-2"></i>
                        Kendaraan Keluar
                    </h2>
                </div>
                <p class="text-sm text-slate-600 mb-6">Scan atau masukkan kode karcis saat pengendara mengembalikan karcis. Tarif akan dihitung otomatis.</p>

                <form action="{{ route('petugas.transaksi.keluar.scan') }}" method="POST" class="space-y-4" id="scanForm">
                    @csrf
                    <div>
                        <label for="kode_karcis" class="block text-sm font-medium text-slate-700">Kode Karcis</label>
                        <div class="relative mt-1">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                <i class="fas fa-qrcode text-sm"></i>
                            </div>
                            <input type="text" name="kode_karcis" id="kode_karcis" required
                                   value="{{ old('kode_karcis') }}"
                                   placeholder="PARK-XXXXXXXXXX"
                                   autofocus
                                   class="w-full rounded-xl border border-slate-300 bg-white py-2 pl-10 pr-3 text-sm outline-none focus:border-slate-900 focus:ring-2 focus:ring-slate-900/10 font-mono tracking-wider" />
                        </div>
                        @error('kode_karcis')
                            <div class="mt-1 rounded-xl border border-red-200 bg-red-50 px-3 py-2 text-xs text-red-800">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="flex items-center gap-2 justify-end pt-2">
                        <a href="{{ route('petugas.dashboard') }}"
                           class="rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm font-medium hover:bg-slate-50">
                            Batal
                        </a>
                        <button type="submit" id="submitBtn" class="rounded-xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">
                            Cari & Hitung Tarif
                        </button>
                    </div>
                </form>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm flex flex-col h-full">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-slate-900">
                        <i class="fas fa-camera text-gray-600 mr-2"></i>
                        Scan QR Karcis
                    </h2>
                    <div id="qr-status" class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Ready</div>
                </div>

                <div class="relative flex-1 flex flex-col min-h-[300px]">
                    <div id="reader" class="overflow-hidden rounded-xl bg-slate-100 border-2 border-dashed border-slate-200" style="width: 100%;"></div>
                    <div id="reader-placeholder" class="absolute inset-0 flex flex-col items-center justify-center text-slate-400 p-4 text-center">
                        <i class="fas fa-qrcode text-4xl mb-3"></i>
                        <p class="text-xs font-medium">Izinkan akses kamera untuk scan QR karcis secara langsung.</p>
                        <button type="button" id="startScanBtn" class="mt-4 rounded-xl bg-blue-600 px-4 py-2 text-xs font-semibold text-white hover:bg-blue-700">
                            Mulai Scan
                        </button>
                    </div>
                </div>

                <div class="mt-4 flex items-center justify-between">
                    <div class="text-[10px] text-slate-500 italic">* QR akan di-scan otomatis & langsung diproses.</div>
                    <div class="flex gap-2">
                        <button type="button" id="scanFileBtn" class="rounded-xl border border-blue-200 bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-600 hover:bg-blue-100">
                            Scan File / Foto
                        </button>
                        <input type="file" id="qr-input-file" accept="image/*" class="hidden" />
                        <button type="button" id="stopScanBtn" class="hidden rounded-xl border border-red-200 bg-red-50 px-3 py-1.5 text-xs font-semibold text-red-600 hover:bg-red-100">
                            Stop Scan
                        </button>
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
