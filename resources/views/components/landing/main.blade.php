<main class="flex-1 mx-auto w-full max-w-7xl px-6 pb-12 pt-8">
    {{-- Hero Section --}}
    <section class="grid grid-cols-1 items-start gap-12 lg:grid-cols-2 lg:gap-16">
        {{-- Hero Left: Heading & Text --}}
        <div data-aos="fade-right" class="lg:pt-4">
            <div class="inline-flex items-center gap-2 border border-slate-200 bg-white/70 px-3 py-1 text-[9px] font-bold uppercase tracking-widest text-slate-500 backdrop-blur">
                <span class="h-1 w-1 bg-slate-900"></span>
                Sistem parkir yang rapi, cepat, dan akurat
            </div>
            <h1 class="mt-4 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl uppercase leading-tight">
                Kelola parkir lebih cepat, lebih tertib, dan minim salah hitung
            </h1>
            <p class="mt-4 max-w-lg text-[11px] leading-relaxed text-slate-500">
                Park-It menyederhanakan transaksi masuk/keluar, menghitung tarif otomatis, dan menyiapkan rekap yang siap dilaporkan harian.
            </p>

            <div class="mt-6 flex flex-col gap-2 sm:flex-row sm:items-center">
                <a href="{{ route('login') }}"
                   class="inline-flex items-center justify-center gap-2 bg-slate-900 px-6 py-3 text-[10px] font-bold uppercase tracking-widest text-white hover:bg-slate-800 transition">
                    Mulai sekarang
                    <i class="fas fa-arrow-right text-[9px]"></i>
                </a>
                <a href="{{ route('login') }}"
                   class="inline-flex items-center justify-center gap-2 border border-slate-200 bg-white/70 px-6 py-3 text-[10px] font-bold uppercase tracking-widest text-slate-900 backdrop-blur hover:bg-white transition">
                    Lihat role akses
                    <i class="fas fa-shield-halved text-[9px] text-slate-400"></i>
                </a>
            </div>
        </div>

        {{-- Hero Right: Feature Grid --}}
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:pt-4" data-aos="fade-left">
            <div class="flex items-start gap-3 border border-slate-200 bg-white/60 p-4 backdrop-blur transition hover:bg-white">
                <div class="flex h-8 w-8 shrink-0 items-center justify-center border border-slate-200 bg-slate-50 text-slate-900">
                    <i class="fas fa-bolt text-[10px]"></i>
                </div>
                <div>
                    <div class="text-[10px] font-bold uppercase tracking-wider text-slate-900">Transaksi 1 layar</div>
                    <div class="mt-0.5 text-[10px] leading-relaxed text-slate-500">Masuk, keluar, tarif, dan status langsung terlihat harian.</div>
                </div>
            </div>
            <div class="flex items-start gap-3 border border-slate-200 bg-white/60 p-4 backdrop-blur transition hover:bg-white">
                <div class="flex h-8 w-8 shrink-0 items-center justify-center border border-slate-200 bg-slate-50 text-slate-900">
                    <i class="fas fa-shield-halved text-[10px]"></i>
                </div>
                <div>
                    <div class="text-[10px] font-bold uppercase tracking-wider text-slate-900">Kontrol akses</div>
                    <div class="mt-0.5 text-[10px] leading-relaxed text-slate-500">Admin, petugas, owner dengan hak masing-masing.</div>
                </div>
            </div>
            <div class="flex items-start gap-3 border border-slate-200 bg-white/60 p-4 backdrop-blur transition hover:bg-white">
                <div class="flex h-8 w-8 shrink-0 items-center justify-center border border-slate-200 bg-slate-50 text-slate-900">
                    <i class="fas fa-receipt text-[10px]"></i>
                </div>
                <div>
                    <div class="text-[10px] font-bold uppercase tracking-wider text-slate-900">Rekap siap laporan</div>
                    <div class="mt-0.5 text-[10px] leading-relaxed text-slate-500">Ringkas, mudah dicek, dan konsisten laporannya.</div>
                </div>
            </div>
            <div class="flex items-start gap-3 border border-slate-200 bg-white/60 p-4 backdrop-blur transition hover:bg-white">
                <div class="flex h-8 w-8 shrink-0 items-center justify-center border border-slate-200 bg-slate-50 text-slate-900">
                    <i class="fas fa-clock text-[10px]"></i>
                </div>
                <div>
                    <div class="text-[10px] font-bold uppercase tracking-wider text-slate-900">Cepat dipakai harian</div>
                    <div class="mt-0.5 text-[10px] leading-relaxed text-slate-500">UI rapi, fokus ke tombol yang penting saja.</div>
                </div>
            </div>
        </div>
    </section>

    {{-- Workflow Section --}}
    <section data-aos="fade-up" class="mt-12 border border-slate-200 bg-white/60 p-6 backdrop-blur sm:p-8">
        <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
            <div class="max-w-xl">
                <h2 class="text-base font-bold tracking-tight text-slate-900 uppercase">Satu alur kerja yang jelas, dari gerbang sampai rekap</h2>
                <p class="mt-2 text-[11px] leading-relaxed text-slate-500">
                    Dirancang untuk operasional harian: cepat saat transaksi, rapi saat rekap, dan mudah dipantau kapan pun dibutuhkan.
                </p>
            </div>
            <div class="grid grid-cols-3 gap-3">
                <div class="border border-slate-200 bg-white/70 px-4 py-4 text-center">
                    <div class="text-lg font-bold text-slate-900">1</div>
                    <div class="mt-1 text-[9px] font-bold uppercase tracking-widest text-slate-400">Input</div>
                </div>
                <div class="border border-slate-200 bg-white/70 px-4 py-4 text-center">
                    <div class="text-lg font-bold text-slate-900">2</div>
                    <div class="mt-1 text-[9px] font-bold uppercase tracking-widest text-slate-400">Hitung</div>
                </div>
                <div class="border border-slate-200 bg-white/70 px-4 py-4 text-center">
                    <div class="text-lg font-bold text-slate-900">3</div>
                    <div class="mt-1 text-[9px] font-bold uppercase tracking-widest text-slate-400">Rekap</div>
                </div>
            </div>
        </div>

        <div class="mt-8 grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-6">
            <div data-aos="fade-up" data-aos-delay="100" class="border border-slate-200 bg-white/70 p-4 transition hover:bg-white">
                <div class="flex items-center gap-3">
                    <div class="flex h-8 w-8 shrink-0 items-center justify-center border border-slate-200 bg-slate-50 text-slate-900">
                        <i class="fas fa-ticket text-[10px]"></i>
                    </div>
                    <div class="text-[9px] font-bold uppercase tracking-wider text-slate-900">Tiket & identitas</div>
                </div>
                <p class="mt-2 text-[10px] leading-relaxed text-slate-500">Pencatatan konsisten, mudah dicari.</p>
            </div>
            <div data-aos="fade-up" data-aos-delay="200" class="border border-slate-200 bg-white/70 p-4 transition hover:bg-white">
                <div class="flex items-center gap-3">
                    <div class="flex h-8 w-8 shrink-0 items-center justify-center border border-slate-200 bg-slate-50 text-slate-900">
                        <i class="fas fa-calculator text-[10px]"></i>
                    </div>
                    <div class="text-[9px] font-bold uppercase tracking-wider text-slate-900">Tarif otomatis</div>
                </div>
                <p class="mt-2 text-[10px] leading-relaxed text-slate-500">Sistem menghitung berdasarkan aturan.</p>
            </div>
            <div data-aos="fade-up" data-aos-delay="300" class="border border-slate-200 bg-white/70 p-4 transition hover:bg-white">
                <div class="flex items-center gap-3">
                    <div class="flex h-8 w-8 shrink-0 items-center justify-center border border-slate-200 bg-slate-50 text-slate-900">
                        <i class="fas fa-chart-line text-[10px]"></i>
                    </div>
                    <div class="text-[9px] font-bold uppercase tracking-wider text-slate-900">Ringkasan cepat</div>
                </div>
                <p class="mt-2 text-[10px] leading-relaxed text-slate-500">Pantau kendaraan dan pendapatan.</p>
            </div>
            <div data-aos="fade-up" data-aos-delay="400" class="border border-slate-200 bg-white/70 p-4 transition hover:bg-white">
                <div class="flex items-center gap-3">
                    <div class="flex h-8 w-8 shrink-0 items-center justify-center border border-slate-200 bg-slate-50 text-slate-900">
                        <i class="fas fa-user-gear text-[10px]"></i>
                    </div>
                    <div class="text-[9px] font-bold uppercase tracking-wider text-slate-900">Role-based</div>
                </div>
                <p class="mt-2 text-[10px] leading-relaxed text-slate-500">Admin, petugas, owner.</p>
            </div>
            <div data-aos="fade-up" data-aos-delay="500" class="border border-slate-200 bg-white/70 p-4 transition hover:bg-white">
                <div class="flex items-center gap-3">
                    <div class="flex h-8 w-8 shrink-0 items-center justify-center border border-slate-200 bg-slate-50 text-slate-900">
                        <i class="fas fa-clipboard-check text-[10px]"></i>
                    </div>
                    <div class="text-[9px] font-bold uppercase tracking-wider text-slate-900">Audit & histori</div>
                </div>
                <p class="mt-2 text-[10px] leading-relaxed text-slate-500">Jejak aktivitas membantu pengecekan.</p>
            </div>
            <div data-aos="fade-up" data-aos-delay="600" class="border border-slate-200 bg-white/70 p-4 transition hover:bg-white">
                <div class="flex items-center gap-3">
                    <div class="flex h-8 w-8 shrink-0 items-center justify-center border border-slate-200 bg-slate-50 text-slate-900">
                        <i class="fas fa-wand-magic-sparkles text-[10px]"></i>
                    </div>
                    <div class="text-[9px] font-bold uppercase tracking-wider text-slate-900">UI minimal</div>
                </div>
                <p class="mt-2 text-[10px] leading-relaxed text-slate-500">Rapi dan fokus.</p>
            </div>
        </div>
    </section>
</main>
