<main class="flex-1 mx-auto w-full max-w-7xl px-6 pb-16 pt-10 sm:pt-14">
    <section class="grid grid-cols-1 items-center gap-10 lg:grid-cols-2 lg:gap-14">
        <div data-aos="fade-right">
            <div class="inline-flex items-center gap-2 rounded-none border border-slate-200 bg-white/70 px-4 py-1.5 text-[10px] font-bold uppercase tracking-widest text-slate-500 backdrop-blur">
                <span class="h-1.5 w-1.5 rounded-none bg-slate-900"></span>
                Sistem parkir yang rapi, cepat, dan akurat
            </div>
            <h1 class="mt-5 text-3xl font-bold tracking-tight text-slate-900 sm:text-5xl uppercase">
                Kelola parkir lebih cepat, lebih tertib, dan minim salah hitung
            </h1>
            <p class="mt-6 max-w-xl text-sm leading-relaxed text-slate-600 sm:text-base">
                Park-It menyederhanakan transaksi masuk/keluar, menghitung tarif otomatis, dan menyiapkan rekap yang siap dilaporkan. Fokus ke operasional, bukan ke catatan manual.
            </p>

            <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:items-center">
                <a href="{{ route('login') }}"
                   class="inline-flex items-center justify-center gap-3 rounded-none bg-slate-900 px-8 py-4 text-xs font-bold uppercase tracking-widest text-white shadow-sm hover:bg-slate-800 transition">
                    Mulai sekarang
                    <i class="fas fa-arrow-right text-[10px]"></i>
                </a>
                <a href="{{ route('login') }}"
                   class="inline-flex items-center justify-center gap-3 rounded-none border border-slate-200 bg-white/70 px-8 py-4 text-xs font-bold uppercase tracking-widest text-slate-900 backdrop-blur hover:bg-white transition">
                    Lihat role akses
                    <i class="fas fa-shield-halved text-[10px] text-slate-500 grayscale"></i>
                </a>
            </div>

            <div class="mt-10 grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div data-aos="fade-up" data-aos-delay="100" class="flex items-start gap-4 rounded-none border border-slate-200 bg-white/60 p-5 backdrop-blur">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-none bg-slate-100 text-slate-900 ring-1 ring-slate-200">
                        <i class="fas fa-bolt text-sm"></i>
                    </div>
                    <div>
                        <div class="text-xs font-bold uppercase tracking-wider text-slate-900">Transaksi 1 layar</div>
                        <div class="mt-1 text-xs leading-relaxed text-slate-600">Masuk, keluar, tarif, dan status langsung terlihat</div>
                    </div>
                </div>
                <div data-aos="fade-up" data-aos-delay="200" class="flex items-start gap-4 rounded-none border border-slate-200 bg-white/60 p-5 backdrop-blur">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-none bg-slate-100 text-slate-900 ring-1 ring-slate-200">
                        <i class="fas fa-shield-halved text-sm"></i>
                    </div>
                    <div>
                        <div class="text-xs font-bold uppercase tracking-wider text-slate-900">Kontrol akses</div>
                        <div class="mt-1 text-xs leading-relaxed text-slate-600">Admin, petugas, owner dengan hak masing-masing</div>
                    </div>
                </div>
                <div data-aos="fade-up" data-aos-delay="300" class="flex items-start gap-4 rounded-none border border-slate-200 bg-white/60 p-5 backdrop-blur">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-none bg-slate-100 text-slate-900 ring-1 ring-slate-200">
                        <i class="fas fa-receipt text-sm"></i>
                    </div>
                    <div>
                        <div class="text-xs font-bold uppercase tracking-wider text-slate-900">Rekap siap laporan</div>
                        <div class="mt-1 text-xs leading-relaxed text-slate-600">Ringkas, mudah dicek, dan konsisten</div>
                    </div>
                </div>
                <div data-aos="fade-up" data-aos-delay="400" class="flex items-start gap-4 rounded-none border border-slate-200 bg-white/60 p-5 backdrop-blur">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-none bg-slate-100 text-slate-900 ring-1 ring-slate-200">
                        <i class="fas fa-clock text-sm"></i>
                    </div>
                    <div>
                        <div class="text-xs font-bold uppercase tracking-wider text-slate-900">Cepat dipakai harian</div>
                        <div class="mt-1 text-xs leading-relaxed text-slate-600">UI rapi, fokus ke tombol yang penting</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="relative lg:pl-6" data-aos="fade-left">
            <div class="absolute -inset-6 rounded-none bg-slate-200/20 blur-2xl"></div>
            <div class="relative overflow-hidden rounded-none border border-slate-200 bg-white p-8 shadow-sm backdrop-blur flex flex-col items-center justify-center text-center min-h-[400px]">
                <div class="flex h-16 w-16 items-center justify-center rounded-none bg-slate-900 text-white mb-6">
                    <i class="fas fa-car-side text-2xl"></i>
                </div>
                <h2 class="text-2xl font-bold tracking-tight text-slate-900 uppercase">PARK-IT SYSTEM</h2>
                <p class="mt-4 max-w-xs text-sm leading-relaxed text-slate-600">
                    Solusi manajemen parkir modern yang mengedepankan ketegasan alur dan akurasi data.
                </p>
                <div class="mt-8 flex flex-col w-full gap-3">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-3 text-[10px] font-bold uppercase tracking-widest text-slate-400">
                        <span>Status Sistem</span>
                        <span class="text-slate-900">Online</span>
                    </div>
                    <div class="flex items-center justify-between border-b border-slate-100 pb-3 text-[10px] font-bold uppercase tracking-widest text-slate-400">
                        <span>Keamanan</span>
                        <span class="text-slate-900">Terjamin</span>
                    </div>
                    <div class="flex items-center justify-between text-[10px] font-bold uppercase tracking-widest text-slate-400">
                        <span>Efisiensi</span>
                        <span class="text-slate-900">Maksimal</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section data-aos="fade-up" class="mt-16 rounded-none border border-slate-200 bg-white/60 p-8 backdrop-blur sm:p-12">
        <div class="flex flex-col gap-10 lg:flex-row lg:items-center lg:justify-between">
            <div class="max-w-2xl">
                <h2 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl uppercase">Satu alur kerja yang jelas, dari gerbang sampai rekap</h2>
                <p class="mt-4 text-sm leading-relaxed text-slate-600">
                    Dirancang untuk operasional harian: cepat saat transaksi, rapi saat rekap, dan mudah dipantau kapan pun dibutuhkan.
                </p>
            </div>
            <div class="grid grid-cols-3 gap-4">
                <div class="rounded-none border border-slate-200 bg-white/70 px-6 py-6 text-center">
                    <div class="text-2xl font-bold text-slate-900">1</div>
                    <div class="mt-2 text-[10px] font-bold uppercase tracking-widest text-slate-500">Input</div>
                </div>
                <div class="rounded-none border border-slate-200 bg-white/70 px-6 py-6 text-center">
                    <div class="text-2xl font-bold text-slate-900">2</div>
                    <div class="mt-2 text-[10px] font-bold uppercase tracking-widest text-slate-500">Hitung</div>
                </div>
                <div class="rounded-none border border-slate-200 bg-white/70 px-6 py-6 text-center">
                    <div class="text-2xl font-bold text-slate-900">3</div>
                    <div class="mt-2 text-[10px] font-bold uppercase tracking-widest text-slate-500">Rekap</div>
                </div>
            </div>
        </div>

        <div class="mt-12 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <div data-aos="fade-up" data-aos-delay="100" class="rounded-none border border-slate-200 bg-white/70 p-6">
                <div class="flex items-center gap-4">
                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-none bg-slate-100 text-slate-900 ring-1 ring-slate-200">
                        <i class="fas fa-ticket text-sm"></i>
                    </div>
                    <div class="text-xs font-bold uppercase tracking-widest text-slate-900">Nomor tiket & identitas</div>
                </div>
                <p class="mt-4 text-[13px] leading-relaxed text-slate-600">Pencatatan konsisten, mudah dicari, dan siap dipertanggungjawabkan.</p>
            </div>
            <div data-aos="fade-up" data-aos-delay="200" class="rounded-none border border-slate-200 bg-white/70 p-6">
                <div class="flex items-center gap-4">
                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-none bg-slate-100 text-slate-900 ring-1 ring-slate-200">
                        <i class="fas fa-calculator text-sm"></i>
                    </div>
                    <div class="text-xs font-bold uppercase tracking-widest text-slate-900">Tarif otomatis</div>
                </div>
                <p class="mt-4 text-[13px] leading-relaxed text-slate-600">Kurangi salah hitung. Sistem menghitung berdasarkan aturan yang ditetapkan.</p>
            </div>
            <div data-aos="fade-up" data-aos-delay="300" class="rounded-none border border-slate-200 bg-white/70 p-6">
                <div class="flex items-center gap-4">
                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-none bg-slate-100 text-slate-900 ring-1 ring-slate-200">
                        <i class="fas fa-chart-line text-sm"></i>
                    </div>
                    <div class="text-xs font-bold uppercase tracking-widest text-slate-900">Ringkasan cepat</div>
                </div>
                <p class="mt-4 text-[13px] leading-relaxed text-slate-600">Pantau jumlah kendaraan dan pendapatan dengan tampilan yang jelas.</p>
            </div>
            <div data-aos="fade-up" data-aos-delay="400" class="rounded-none border border-slate-200 bg-white/70 p-6">
                <div class="flex items-center gap-4">
                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-none bg-slate-100 text-slate-900 ring-1 ring-slate-200">
                        <i class="fas fa-user-gear text-sm"></i>
                    </div>
                    <div class="text-xs font-bold uppercase tracking-widest text-slate-900">Role-based access</div>
                </div>
                <p class="mt-4 text-[13px] leading-relaxed text-slate-600">Admin mengatur, petugas menjalankan, owner memantau.</p>
            </div>
            <div data-aos="fade-up" data-aos-delay="500" class="rounded-none border border-slate-200 bg-white/70 p-6">
                <div class="flex items-center gap-4">
                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-none bg-slate-100 text-slate-900 ring-1 ring-slate-200">
                        <i class="fas fa-clipboard-check text-sm"></i>
                    </div>
                    <div class="text-xs font-bold uppercase tracking-widest text-slate-900">Audit & histori</div>
                </div>
                <p class="mt-4 text-[13px] leading-relaxed text-slate-600">Jejak aktivitas membantu pengecekan saat terjadi selisih.</p>
            </div>
            <div data-aos="fade-up" data-aos-delay="600" class="rounded-none border border-slate-200 bg-white/70 p-6">
                <div class="flex items-center gap-4">
                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-none bg-slate-100 text-slate-900 ring-1 ring-slate-200">
                        <i class="fas fa-wand-magic-sparkles text-sm"></i>
                    </div>
                    <div class="text-xs font-bold uppercase tracking-widest text-slate-900">UI minimal</div>
                </div>
                <p class="mt-4 text-[13px] leading-relaxed text-slate-600">Rapi dan fokus. Petugas cepat paham tanpa pelatihan panjang.</p>
            </div>
        </div>
    </section>
</main>

