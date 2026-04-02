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

