<x-layouts.petugas :title="'Kendaraan Masuk - Petugas'">
    <div class="space-y-6">
        @include('partials.flash')

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-slate-900">
                    <i class="fas fa-sign-in-alt text-blue-600 mr-2"></i>
                    Kendaraan Masuk
                </h2>
                <span class="text-xs text-slate-500">{{ now()->format('d F Y, H:i') }}</span>
            </div>
            <p class="text-sm text-slate-600 mb-6">Isi form saat kendaraan datang. Karcis akan digenerate untuk diberikan ke pengendara.</p>

            <form action="{{ route('petugas.transaksi.masuk.store') }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="plat_nomor" class="block text-sm font-medium text-slate-700">Plat Nomor</label>
                        <input type="text" name="plat_nomor" id="plat_nomor" required
                               value="{{ old('plat_nomor') }}"
                               placeholder="B 1234 XYZ"
                               class="mt-1 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm outline-none focus:border-slate-900 focus:ring-2 focus:ring-slate-900/10 uppercase tracking-wider" />
                        @error('plat_nomor')
                            <div class="mt-1 rounded-xl border border-red-200 bg-red-50 px-3 py-2 text-xs text-red-800">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label for="jenis_kendaraan" class="block text-sm font-medium text-slate-700">Jenis Kendaraan</label>
                        <select name="jenis_kendaraan" id="jenis_kendaraan" required
                                class="mt-1 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm outline-none focus:border-slate-900 focus:ring-2 focus:ring-slate-900/10">
                            <option value="">Pilih</option>
                            <option value="motor" {{ old('jenis_kendaraan') === 'motor' ? 'selected' : '' }}>Motor</option>
                            <option value="mobil" {{ old('jenis_kendaraan') === 'mobil' ? 'selected' : '' }}>Mobil</option>
                        </select>
                        @error('jenis_kendaraan')
                            <div class="mt-1 rounded-xl border border-red-200 bg-red-50 px-3 py-2 text-xs text-red-800">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label for="warna" class="block text-sm font-medium text-slate-700">Warna</label>
                        <input type="text" name="warna" id="warna"
                               value="{{ old('warna') }}"
                               placeholder="Hitam"
                               class="mt-1 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm outline-none focus:border-slate-900 focus:ring-2 focus:ring-slate-900/10" />
                    </div>
                    <div>
                        <label for="merk" class="block text-sm font-medium text-slate-700">Merk</label>
                        <input type="text" name="merk" id="merk"
                               value="{{ old('merk') }}"
                               placeholder="Honda, Toyota"
                               class="mt-1 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm outline-none focus:border-slate-900 focus:ring-2 focus:ring-slate-900/10" />
                    </div>
                    <div class="md:col-span-2">
                        <label for="area_parkir_id" class="block text-sm font-medium text-slate-700">Area Parkir</label>
                        <select name="area_parkir_id" id="area_parkir_id" required
                                class="mt-1 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm outline-none focus:border-slate-900 focus:ring-2 focus:ring-slate-900/10">
                            <option value="">Pilih area</option>
                            @foreach ($areas as $a)
                                <option value="{{ $a->id }}" {{ old('area_parkir_id') == $a->id ? 'selected' : '' }}>
                                    {{ $a->nama_area }} (Kapasitas: {{ $a->kapasitas }})
                                </option>
                            @endforeach
                        </select>
                        @error('area_parkir_id')
                            <div class="mt-1 rounded-xl border border-red-200 bg-red-50 px-3 py-2 text-xs text-red-800">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="flex items-center gap-2 justify-end pt-2">
                    <a href="{{ route('petugas.dashboard') }}"
                       class="rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm font-medium hover:bg-slate-50">
                        Batal
                    </a>
                    <button class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">
                        Generate Karcis
                    </button>
                </div>
            </form>
        </div>

        <!-- Test Car Detection API -->
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-slate-900">
                    <i class="fas fa-camera text-blue-600 mr-2"></i>
                    Test Car Detection API
                </h2>
                <button id="check-api-btn" class="text-xs px-3 py-1.5 rounded-lg border border-slate-300 bg-white hover:bg-slate-50 text-slate-700">
                    <i class="fas fa-heartbeat mr-1"></i>
                    Check API Status
                </button>
            </div>
            <p class="text-sm text-slate-600 mb-4">Upload gambar untuk mendeteksi mobil menggunakan Python API (YOLO).</p>

            <form id="detect-form" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label for="detect-image" class="block text-sm font-medium text-slate-700 mb-2">
                        Pilih Gambar
                    </label>
                    <div class="flex items-center gap-4">
                        <input type="file" 
                               name="image" 
                               id="detect-image" 
                               accept="image/*" 
                               required
                               class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                        <button type="submit" 
                                id="detect-btn"
                                class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2">
                            <i class="fas fa-search"></i>
                            <span>Detect Car</span>
                        </button>
                    </div>
                </div>
            </form>

            <!-- Loading Indicator -->
            <div id="loading-indicator" class="hidden mt-4 p-4 bg-blue-50 rounded-lg border border-blue-200">
                <div class="flex items-center gap-3">
                    <div class="animate-spin rounded-full h-5 w-5 border-b-2 border-blue-600"></div>
                    <span class="text-sm text-blue-700">Memproses gambar...</span>
                </div>
            </div>

            <!-- Error Message -->
            <div id="error-message" class="hidden mt-4 p-4 bg-red-50 rounded-lg border border-red-200">
                <div class="flex items-start gap-3">
                    <i class="fas fa-exclamation-circle text-red-600 mt-0.5"></i>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-red-800">Error</p>
                        <p id="error-text" class="text-sm text-red-700 mt-1"></p>
                    </div>
                </div>
            </div>

            <!-- Success Result -->
            <div id="result-container" class="hidden mt-4">
                <div class="p-4 bg-green-50 rounded-lg border border-green-200 mb-4">
                    <div class="flex items-center gap-2 mb-2">
                        <i class="fas fa-check-circle text-green-600"></i>
                        <span class="text-sm font-medium text-green-800">Deteksi Berhasil</span>
                    </div>
                    <div id="result-summary" class="text-sm text-green-700"></div>
                </div>

                <!-- Preview Image -->
                <div class="mb-4">
                    <img id="preview-image" src="" alt="Preview" class="max-w-full rounded-lg border border-slate-200 shadow-sm">
                </div>

                <!-- Detection Details -->
                <div class="space-y-3">
                    <h3 class="text-sm font-semibold text-slate-900">Detail Deteksi:</h3>
                    <div id="detection-details" class="space-y-2"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const detectForm = document.getElementById('detect-form');
        const detectBtn = document.getElementById('detect-btn');
        const detectImage = document.getElementById('detect-image');
        const loadingIndicator = document.getElementById('loading-indicator');
        const errorMessage = document.getElementById('error-message');
        const errorText = document.getElementById('error-text');
        const resultContainer = document.getElementById('result-container');
        const previewImage = document.getElementById('preview-image');
        const resultSummary = document.getElementById('result-summary');
        const detectionDetails = document.getElementById('detection-details');
        const checkApiBtn = document.getElementById('check-api-btn');

        // Preview image sebelum upload
        detectImage.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewImage.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        });

        // Check API Status
        checkApiBtn.addEventListener('click', async function() {
            checkApiBtn.disabled = true;
            checkApiBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Checking...';
            
            try {
                const response = await fetch('{{ route("petugas.api.health") }}');
                const data = await response.json();
                
                if (data.success) {
                    alert('✅ API Connected!\n\nPython API berjalan dengan baik di http://localhost:5000');
                } else {
                    alert('❌ API Tidak Tersedia\n\n' + data.message + '\n\nPastikan Python API berjalan:\npython api.py');
                }
            } catch (error) {
                alert('❌ Error\n\nTidak dapat terhubung ke API.\nPastikan Python API berjalan di http://localhost:5000');
            } finally {
                checkApiBtn.disabled = false;
                checkApiBtn.innerHTML = '<i class="fas fa-heartbeat mr-1"></i> Check API Status';
            }
        });

        // Handle form submission
        detectForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            // Reset UI
            loadingIndicator.classList.remove('hidden');
            errorMessage.classList.add('hidden');
            resultContainer.classList.add('hidden');
            detectBtn.disabled = true;
            
            const formData = new FormData(detectForm);
            
            try {
                const response = await fetch('{{ route("petugas.detect.car") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || 
                                       document.querySelector('input[name="_token"]')?.value
                    }
                });
                
                const data = await response.json();
                
                if (data.success) {
                    // Show success
                    displayResults(data);
                } else {
                    // Show error
                    showError(data.message || data.error || 'Terjadi kesalahan saat deteksi');
                }
                
            } catch (error) {
                showError('Tidak dapat terhubung ke server. Pastikan Python API berjalan di http://localhost:5000');
            } finally {
                loadingIndicator.classList.add('hidden');
                detectBtn.disabled = false;
            }
        });

        function displayResults(data) {
            const result = data.data;
            
            // Summary
            const carsDetected = result.cars_detected || 0;
            const totalDetections = result.total_detections || 0;
            
            resultSummary.innerHTML = `
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <span class="font-semibold">Mobil Terdeteksi:</span>
                        <span class="ml-2 text-lg font-bold text-green-700">${carsDetected}</span>
                    </div>
                    <div>
                        <span class="font-semibold">Total Deteksi:</span>
                        <span class="ml-2 text-lg font-bold text-blue-700">${totalDetections}</span>
                    </div>
                </div>
            `;
            
            // Preview image
            if (data.image_url) {
                previewImage.src = data.image_url;
            }
            
            // Detection details
            if (result.latest_cars && result.latest_cars.length > 0) {
                let detailsHTML = '';
                result.latest_cars.forEach((car, index) => {
                    const confidence = (car.confidence * 100).toFixed(1);
                    detailsHTML += `
                        <div class="p-3 bg-slate-50 rounded-lg border border-slate-200">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-semibold text-slate-900">Mobil #${index + 1}</span>
                                <span class="text-xs px-2 py-1 bg-blue-100 text-blue-700 rounded">${confidence}%</span>
                            </div>
                            <div class="grid grid-cols-2 gap-2 text-xs text-slate-600">
                                <div><span class="font-medium">Tipe:</span> ${car.type || 'N/A'}</div>
                                <div><span class="font-medium">Warna:</span> ${car.color || 'N/A'}</div>
                                <div><span class="font-medium">ID:</span> ${car.id || 'N/A'}</div>
                                <div><span class="font-medium">Detected:</span> ${car.detected_at ? new Date(car.detected_at).toLocaleString('id-ID') : 'N/A'}</div>
                            </div>
                            ${car.bbox ? `<div class="mt-2 text-xs text-slate-500">BBox: [${car.bbox.join(', ')}]</div>` : ''}
                        </div>
                    `;
                });
                detectionDetails.innerHTML = detailsHTML;
            } else {
                detectionDetails.innerHTML = `
                    <div class="p-3 bg-yellow-50 rounded-lg border border-yellow-200 text-sm text-yellow-800">
                        <i class="fas fa-info-circle mr-2"></i>
                        Tidak ada mobil yang terdeteksi dalam gambar ini.
                    </div>
                `;
            }
            
            resultContainer.classList.remove('hidden');
        }

        function showError(message) {
            errorText.textContent = message;
            errorMessage.classList.remove('hidden');
        }
    </script>
</x-layouts.petugas>
