<x-layouts.guest :title="'Park-It'">
    {{-- Menambahkan flex col dan min-h-screen agar footer bisa nempel di bawah --}}
    <div class="relative min-h-screen flex flex-col overflow-hidden">
        
        {{-- Background Blobs --}}
        <div class="absolute inset-0 bg-gradient-to-b from-slate-50 via-slate-50 to-white"></div>
        <div class="pointer-events-none absolute inset-0">
            <div class="absolute -top-24 -left-24 h-72 w-72 rounded-full bg-amber-500/10 blur-3xl animate-float-slow"></div>
            <div class="absolute top-24 -right-24 h-80 w-80 rounded-full bg-emerald-500/10 blur-3xl animate-float-slower"></div>
            <div class="absolute bottom-0 left-1/3 h-72 w-72 rounded-full bg-rose-500/10 blur-3xl animate-float-slowest"></div>
        </div>

        <div class="relative flex flex-col flex-1">
            {{-- Header --}}
            <header class="mx-auto w-full max-w-7xl px-6">
                <div class="flex items-center justify-between py-6">
                    <a href="{{ route('landing') }}" class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-white text-slate-900 ring-1 ring-slate-200 shadow-sm">
                            <span class="text-sm font-bold">P</span>
                        </div>
                        <div class="leading-tight">
                            <div class="text-sm font-semibold tracking-wide text-slate-900">PARK-IT</div>
                            <div class="text-[11px] text-slate-500">Parking Management</div>
                        </div>
                    </a>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('login') }}"
                           class="inline-flex items-center gap-2 rounded-2xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-slate-800 transition">
                            Masuk
                            <i class="fas fa-arrow-right text-xs"></i>
                        </a>
                    </div>
                </div>
            </header>

            {{-- Main Content: flex-1 memastikan bagian ini mengambil ruang sisa --}}
            <main class="flex-1 mx-auto w-full max-w-7xl px-6 pb-16 pt-10 sm:pt-14">
                <section class="grid grid-cols-1 items-center gap-10 lg:grid-cols-2 lg:gap-14">
                    <div class="animate-fade-up">
                        <div class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white/70 px-3 py-1 text-xs text-slate-600 backdrop-blur">
                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                            Sistem parkir yang rapi, cepat, dan akurat
                        </div>
                        <h1 class="mt-5 text-3xl font-semibold tracking-tight text-slate-900 sm:text-5xl">
                            Kelola parkir lebih cepat, lebih tertib, dan minim salah hitung
                        </h1>
                        <p class="mt-4 max-w-xl text-sm leading-relaxed text-slate-600 sm:text-base">
                            Park-It menyederhanakan transaksi masuk/keluar, menghitung tarif otomatis, dan menyiapkan rekap yang siap dilaporkan. Fokus ke operasional, bukan ke catatan manual.
                        </p>

                        <div class="mt-7 flex flex-col gap-3 sm:flex-row sm:items-center">
                            <a href="{{ route('login') }}"
                               class="inline-flex items-center justify-center gap-2 rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-slate-800 transition">
                                Mulai sekarang
                                <i class="fas fa-arrow-right text-xs"></i>
                            </a>
                            <a href="{{ route('login') }}"
                               class="inline-flex items-center justify-center gap-2 rounded-2xl border border-slate-200 bg-white/70 px-5 py-3 text-sm font-semibold text-slate-900 backdrop-blur hover:bg-white transition">
                                Lihat role akses
                                <i class="fas fa-shield-halved text-xs text-slate-500"></i>
                            </a>
                        </div>

                        <div class="mt-8 grid grid-cols-1 gap-3 sm:grid-cols-2">
                            <div class="flex items-start gap-3 rounded-2xl border border-slate-200 bg-white/60 p-4 backdrop-blur">
                                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-500/10 text-emerald-700 ring-1 ring-emerald-500/20">
                                    <i class="fas fa-bolt text-sm"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-semibold text-slate-900">Transaksi 1 layar</div>
                                    <div class="mt-0.5 text-xs text-slate-600">Masuk, keluar, tarif, dan status langsung terlihat</div>
                                </div>
                            </div>
                            <div class="flex items-start gap-3 rounded-2xl border border-slate-200 bg-white/60 p-4 backdrop-blur">
                                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-amber-500/10 text-amber-700 ring-1 ring-amber-500/20">
                                    <i class="fas fa-shield-halved text-sm"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-semibold text-slate-900">Kontrol akses</div>
                                    <div class="mt-0.5 text-xs text-slate-600">Admin, petugas, owner dengan hak masing-masing</div>
                                </div>
                            </div>
                            <div class="flex items-start gap-3 rounded-2xl border border-slate-200 bg-white/60 p-4 backdrop-blur">
                                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-rose-500/10 text-rose-700 ring-1 ring-rose-500/20">
                                    <i class="fas fa-receipt text-sm"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-semibold text-slate-900">Rekap siap laporan</div>
                                    <div class="mt-0.5 text-xs text-slate-600">Ringkas, mudah dicek, dan konsisten</div>
                                </div>
                            </div>
                            <div class="flex items-start gap-3 rounded-2xl border border-slate-200 bg-white/60 p-4 backdrop-blur">
                                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-slate-900/5 text-slate-900 ring-1 ring-slate-900/10">
                                    <i class="fas fa-clock text-sm"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-semibold text-slate-900">Cepat dipakai harian</div>
                                    <div class="mt-0.5 text-xs text-slate-600">UI rapi, fokus ke tombol yang penting</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="relative lg:pl-6">
                        <div class="absolute -inset-6 rounded-[2.5rem] bg-gradient-to-b from-white/80 to-white/40 blur-2xl"></div>
                        <div class="relative overflow-hidden rounded-[2.25rem] border border-slate-200 bg-white/70 shadow-sm backdrop-blur">
                            <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-slate-900 text-white">
                                        <i class="fas fa-car-side text-sm"></i>
                                    </div>
                                    <div>
                                        <div class="text-sm font-semibold text-slate-900">Ringkasan Operasional</div>
                                        <div class="text-xs text-slate-500">Hari ini • Realtime</div>
                                    </div>
                                </div>
                                <span class="inline-flex items-center gap-2 rounded-full bg-emerald-500/10 px-3 py-1 text-xs font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-500/20">
                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-600"></span>
                                    Aktif
                                </span>
                            </div>

                            <div class="p-6">
                                <div class="grid grid-cols-3 gap-3">
                                    <div class="rounded-2xl border border-slate-200 bg-white/60 p-4">
                                        <div class="text-xs text-slate-500">Masuk</div>
                                        <div class="mt-2 text-2xl font-semibold text-slate-900">128</div>
                                        <div class="mt-2 flex items-center gap-2 text-xs text-emerald-700">
                                            <i class="fas fa-arrow-trend-up"></i>
                                            Stabil
                                        </div>
                                    </div>
                                    <div class="rounded-2xl border border-slate-200 bg-white/60 p-4">
                                        <div class="text-xs text-slate-500">Keluar</div>
                                        <div class="mt-2 text-2xl font-semibold text-slate-900">113</div>
                                        <div class="mt-2 flex items-center gap-2 text-xs text-slate-600">
                                            <i class="fas fa-clock"></i>
                                            Rata-rata 4m
                                        </div>
                                    </div>
                                    <div class="rounded-2xl border border-slate-200 bg-white/60 p-4">
                                        <div class="text-xs text-slate-500">Pendapatan</div>
                                        <div class="mt-2 text-2xl font-semibold text-slate-900">Rp 2,7jt</div>
                                        <div class="mt-2 flex items-center gap-2 text-xs text-amber-700">
                                            <i class="fas fa-circle-check"></i>
                                            Tercatat
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-5 rounded-2xl border border-slate-200 bg-white/60 p-5">
                                    <div class="flex items-center justify-between">
                                        <div class="text-sm font-semibold text-slate-900">Antrian & Kapasitas</div>
                                        <div class="text-xs text-slate-500">Update 30 dtk</div>
                                    </div>
                                    <div class="mt-4 grid grid-cols-2 gap-4">
                                        <div class="rounded-2xl bg-slate-950 px-4 py-4 text-white">
                                            <div class="text-xs text-white/70">Slot tersedia</div>
                                            <div class="mt-2 text-2xl font-semibold">42</div>
                                            <div class="mt-3 h-2 w-full rounded-full bg-white/10">
                                                <div class="h-2 w-[58%] rounded-full bg-emerald-400"></div>
                                            </div>
                                        </div>
                                        <div class="rounded-2xl border border-slate-200 bg-white/70 px-4 py-4">
                                            <div class="text-xs text-slate-500">Antrian pintu masuk</div>
                                            <div class="mt-2 text-2xl font-semibold text-slate-900">3</div>
                                            <div class="mt-3 flex items-center gap-2 text-xs text-slate-600">
                                                <i class="fas fa-circle-info"></i>
                                                Normal
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-6 grid grid-cols-1 gap-3 sm:grid-cols-2">
                                    <div class="rounded-2xl border border-slate-200 bg-white/60 p-4">
                                        <div class="flex items-center justify-between">
                                            <div class="text-xs text-slate-500">Tarif otomatis</div>
                                            <i class="fas fa-calculator text-xs text-slate-700"></i>
                                        </div>
                                        <div class="mt-2 text-sm font-semibold text-slate-900">Aturan fleksibel</div>
                                        <div class="mt-1 text-xs text-slate-600">Motor, mobil, member, atau waktu khusus</div>
                                    </div>
                                    <div class="rounded-2xl border border-slate-200 bg-white/60 p-4">
                                        <div class="flex items-center justify-between">
                                            <div class="text-xs text-slate-500">Audit</div>
                                            <i class="fas fa-clipboard-check text-xs text-slate-700"></i>
                                        </div>
                                        <div class="mt-2 text-sm font-semibold text-slate-900">Jejak aktivitas</div>
                                        <div class="mt-1 text-xs text-slate-600">Mudah ditelusuri saat ada selisih</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="mt-14 rounded-[2.25rem] border border-slate-200 bg-white/60 p-6 backdrop-blur sm:p-10">
                    <div class="flex flex-col gap-8 lg:flex-row lg:items-center lg:justify-between">
                        <div class="max-w-2xl">
                            <h2 class="text-xl font-semibold tracking-tight text-slate-900 sm:text-2xl">Satu alur kerja yang jelas, dari gerbang sampai rekap</h2>
                            <p class="mt-3 text-sm leading-relaxed text-slate-600">
                                Dirancang untuk operasional harian: cepat saat transaksi, rapi saat rekap, dan mudah dipantau kapan pun dibutuhkan.
                            </p>
                        </div>
                        <div class="grid grid-cols-3 gap-3">
                            <div class="rounded-2xl border border-slate-200 bg-white/70 px-4 py-5 text-center">
                                <div class="text-2xl font-semibold text-slate-900">1</div>
                                <div class="mt-1 text-xs text-slate-600">Input</div>
                            </div>
                            <div class="rounded-2xl border border-slate-200 bg-white/70 px-4 py-5 text-center">
                                <div class="text-2xl font-semibold text-slate-900">2</div>
                                <div class="mt-1 text-xs text-slate-600">Hitung</div>
                            </div>
                            <div class="rounded-2xl border border-slate-200 bg-white/70 px-4 py-5 text-center">
                                <div class="text-2xl font-semibold text-slate-900">3</div>
                                <div class="mt-1 text-xs text-slate-600">Rekap</div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-10 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        <div class="rounded-2xl border border-slate-200 bg-white/70 p-5">
                            <div class="flex items-center gap-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-emerald-500/10 text-emerald-700 ring-1 ring-emerald-500/20">
                                    <i class="fas fa-ticket text-sm"></i>
                                </div>
                                <div class="text-sm font-semibold text-slate-900">Nomor tiket & identitas</div>
                            </div>
                            <p class="mt-3 text-sm text-slate-600">Pencatatan konsisten, mudah dicari, dan siap dipertanggungjawabkan.</p>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-white/70 p-5">
                            <div class="flex items-center gap-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-amber-500/10 text-amber-700 ring-1 ring-amber-500/20">
                                    <i class="fas fa-calculator text-sm"></i>
                                </div>
                                <div class="text-sm font-semibold text-slate-900">Tarif otomatis</div>
                            </div>
                            <p class="mt-3 text-sm text-slate-600">Kurangi salah hitung. Sistem menghitung berdasarkan aturan yang ditetapkan.</p>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-white/70 p-5">
                            <div class="flex items-center gap-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-rose-500/10 text-rose-700 ring-1 ring-rose-500/20">
                                    <i class="fas fa-chart-line text-sm"></i>
                                </div>
                                <div class="text-sm font-semibold text-slate-900">Ringkasan cepat</div>
                            </div>
                            <p class="mt-3 text-sm text-slate-600">Pantau jumlah kendaraan dan pendapatan dengan tampilan yang jelas.</p>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-white/70 p-5">
                            <div class="flex items-center gap-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-slate-900/5 text-slate-900 ring-1 ring-slate-900/10">
                                    <i class="fas fa-user-gear text-sm"></i>
                                </div>
                                <div class="text-sm font-semibold text-slate-900">Role-based access</div>
                            </div>
                            <p class="mt-3 text-sm text-slate-600">Admin mengatur, petugas menjalankan, owner memantau.</p>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-white/70 p-5">
                            <div class="flex items-center gap-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-emerald-500/10 text-emerald-700 ring-1 ring-emerald-500/20">
                                    <i class="fas fa-clipboard-check text-sm"></i>
                                </div>
                                <div class="text-sm font-semibold text-slate-900">Audit & histori</div>
                            </div>
                            <p class="mt-3 text-sm text-slate-600">Jejak aktivitas membantu pengecekan saat terjadi selisih.</p>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-white/70 p-5">
                            <div class="flex items-center gap-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-amber-500/10 text-amber-700 ring-1 ring-amber-500/20">
                                    <i class="fas fa-wand-magic-sparkles text-sm"></i>
                                </div>
                                <div class="text-sm font-semibold text-slate-900">UI minimal</div>
                            </div>
                            <p class="mt-3 text-sm text-slate-600">Rapi dan fokus. Petugas cepat paham tanpa pelatihan panjang.</p>
                        </div>
                    </div>
                </section>
            </main>

            {{-- Footer: Dikeluarkan dari <main> agar lebarnya full --}}
            <footer class="mt-auto border-t border-slate-200/70 bg-white/60 text-slate-700 backdrop-blur">
                <div class="mx-auto max-w-7xl px-6 py-12">
                    <div class="grid grid-cols-1 gap-10 lg:grid-cols-12">
                        <div class="lg:col-span-5">
                            <a href="{{ route('landing') }}" class="inline-flex items-center gap-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-slate-900 text-white shadow-sm">
                                    <span class="text-sm font-bold">P</span>
                                </div>
                                <div class="leading-tight">
                                    <div class="text-sm font-semibold tracking-wide text-slate-900">PARK-IT</div>
                                    <div class="text-[11px] text-slate-500">Parking Management</div>
                                </div>
                            </a>
                            <p class="mt-4 max-w-md text-sm leading-relaxed text-slate-600">
                                Sistem parkir dengan alur kerja yang jelas untuk operasional harian. Cepat saat transaksi, rapi saat rekap.
                            </p>
                            <div class="mt-6 flex items-center gap-3">
                                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 rounded-xl bg-slate-900 px-4 py-2 text-xs font-semibold text-white hover:bg-slate-800 transition">
                                    Login <i class="fas fa-arrow-right text-[10px]"></i>
                                </a>
                                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white/70 px-4 py-2 text-xs font-semibold text-slate-900 hover:bg-white transition">
                                    Role akses <i class="fas fa-shield-halved text-[10px] text-slate-600"></i>
                                </a>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-10 sm:grid-cols-3 lg:col-span-7 lg:justify-items-end">
                            <div class="w-full max-w-[220px]">
                                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-900">Fitur</h3>
                                <ul class="mt-4 space-y-2 text-sm text-slate-600">
                                    <li><a href="{{ route('login') }}" class="hover:text-slate-900 transition">Transaksi</a></li>
                                    <li><a href="{{ route('login') }}" class="hover:text-slate-900 transition">Tarif</a></li>
                                    <li><a href="{{ route('login') }}" class="hover:text-slate-900 transition">Rekap</a></li>
                                </ul>
                            </div>
                            <div class="w-full max-w-[220px]">
                                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-900">Akses</h3>
                                <ul class="mt-4 space-y-2 text-sm text-slate-600">
                                    <li><a href="{{ route('login') }}" class="hover:text-slate-900 transition">Admin</a></li>
                                    <li><a href="{{ route('login') }}" class="hover:text-slate-900 transition">Petugas</a></li>
                                    <li><a href="{{ route('login') }}" class="hover:text-slate-900 transition">Owner</a></li>
                                </ul>
                            </div>
                            <div class="w-full max-w-[220px]">
                                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-900">Kontak</h3>
                                <ul class="mt-4 space-y-2 text-sm text-slate-600">
                                    <li class="flex items-center gap-2">
                                        <i class="fas fa-envelope text-xs text-slate-500"></i>
                                        support@park-it.local
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <i class="fas fa-phone text-xs text-slate-500"></i>
                                        +62 000 0000 0000
                                    </li>
                                    <li class="mt-4 flex gap-3">
                                        <a href="#" class="flex h-9 w-9 items-center justify-center rounded-lg bg-slate-900/5 ring-1 ring-slate-900/10 hover:bg-slate-900/10 transition" aria-label="Github">
                                            <i class="fab fa-github text-sm"></i>
                                        </a>
                                        <a href="#" class="flex h-9 w-9 items-center justify-center rounded-lg bg-slate-900/5 ring-1 ring-slate-900/10 hover:bg-slate-900/10 transition" aria-label="LinkedIn">
                                            <i class="fab fa-linkedin-in text-sm"></i>
                                        </a>
                                        <a href="#" class="flex h-9 w-9 items-center justify-center rounded-lg bg-slate-900/5 ring-1 ring-slate-900/10 hover:bg-slate-900/10 transition" aria-label="X">
                                            <i class="fab fa-x-twitter text-sm"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="mt-12 flex flex-col gap-4 border-t border-slate-200/70 pt-8 sm:flex-row sm:items-center sm:justify-between">
                        <p class="text-xs text-slate-500">© {{ now()->format('Y') }} Park-It. All rights reserved.</p>
                        <div class="flex flex-wrap items-center gap-3">
                            <span class="inline-flex items-center gap-2 rounded-full bg-emerald-500/10 px-3 py-1 text-[10px] font-medium text-emerald-700 ring-1 ring-inset ring-emerald-500/20">
                                <span class="h-1 w-1 rounded-full bg-emerald-600"></span>
                                Operational-ready
                            </span>
                            <span class="inline-flex items-center gap-2 rounded-full bg-amber-500/10 px-3 py-1 text-[10px] font-medium text-amber-700 ring-1 ring-inset ring-amber-500/20">
                                <span class="h-1 w-1 rounded-full bg-amber-600"></span>
                                Clean UI
                            </span>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <style>
        @keyframes floatSlow { 0%,100% { transform: translate3d(0,0,0); } 50% { transform: translate3d(0,14px,0); } }
        @keyframes fadeUp { 0% { opacity: 0; transform: translate3d(0,12px,0); } 100% { opacity: 1; transform: translate3d(0,0,0); } }
        .animate-float-slow { animation: floatSlow 10s ease-in-out infinite; }
        .animate-float-slower { animation: floatSlow 14s ease-in-out infinite; }
        .animate-float-slowest { animation: floatSlow 18s ease-in-out infinite; }
        .animate-fade-up { animation: fadeUp 700ms ease-out both; }
    </style>
</x-layouts.guest>
