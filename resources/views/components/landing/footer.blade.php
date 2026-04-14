<footer class="mt-auto border-t border-slate-200 bg-white text-slate-700">
    <div class="mx-auto max-w-7xl px-6 py-12">
        <div class="grid grid-cols-1 gap-12 lg:grid-cols-12">
            <div class="lg:col-span-5" data-aos="fade-up">
                <a href="{{ route('landing') }}" class="inline-flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-none bg-slate-900 text-white shadow-sm">
                        <img src="{{ asset('favicon..png') }}" alt="P" class="h-6 w-6 object-contain invert grayscale" />
                    </div>
                    <div class="leading-tight">
                        <div class="text-sm font-bold tracking-widest text-slate-900 uppercase">PARK-IT</div>
                        <div class="text-[10px] text-slate-500 uppercase tracking-tighter font-medium">Parking Management</div>
                    </div>
                </a>
                <p class="mt-6 max-w-md text-sm leading-relaxed text-slate-600">
                    Sistem parkir dengan alur kerja yang jelas untuk operasional harian. Cepat saat transaksi, rapi saat rekap.
                </p>
                <div class="mt-8 flex items-center gap-3">
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-2 rounded-none bg-slate-900 px-6 py-2.5 text-[10px] font-bold uppercase tracking-widest text-white hover:bg-slate-800 transition">
                        Login <i class="fas fa-arrow-right text-[10px]"></i>
                    </a>
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-2 rounded-none border border-slate-200 bg-white px-6 py-2.5 text-[10px] font-bold uppercase tracking-widest text-slate-900 hover:bg-slate-50 transition">
                        Akses <i class="fas fa-shield-halved text-[10px] text-slate-400 grayscale"></i>
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-10 sm:grid-cols-3 lg:col-span-7 lg:justify-items-end" data-aos="fade-up" data-aos-delay="200">
                <div class="w-full max-w-[200px]">
                    <h3 class="text-[10px] font-bold uppercase tracking-widest text-slate-900">Fitur</h3>
                    <ul class="mt-6 space-y-3 text-xs font-medium text-slate-500 uppercase tracking-wider">
                        <li><a href="{{ route('login') }}" class="hover:text-slate-900 transition">Transaksi</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-slate-900 transition">Tarif</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-slate-900 transition">Rekap</a></li>
                    </ul>
                </div>
                <div class="w-full max-w-[200px]">
                    <h3 class="text-[10px] font-bold uppercase tracking-widest text-slate-900">Akses</h3>
                    <ul class="mt-6 space-y-3 text-xs font-medium text-slate-500 uppercase tracking-wider">
                        <li><a href="{{ route('login') }}" class="hover:text-slate-900 transition">Admin</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-slate-900 transition">Petugas</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-slate-900 transition">Owner</a></li>
                    </ul>
                </div>
                <div class="w-full max-w-[200px]">
                    <h3 class="text-[10px] font-bold uppercase tracking-widest text-slate-900">Kontak</h3>
                    <ul class="mt-6 space-y-3 text-xs font-medium text-slate-500 uppercase tracking-wider">
                        <li class="flex items-center gap-2">
                            <i class="fas fa-envelope text-[10px] text-slate-400"></i>
                            support@park-it.id
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fas fa-phone text-[10px] text-slate-400"></i>
                            +62 000 0000 0000
                        </li>
                        <li class="mt-6 flex gap-3">
                            <a href="#" class="flex h-10 w-10 items-center justify-center rounded-none bg-slate-50 border border-slate-200 text-slate-400 hover:bg-slate-900 hover:text-white transition" aria-label="Github">
                                <i class="fab fa-github text-sm"></i>
                            </a>
                            <a href="#" class="flex h-10 w-10 items-center justify-center rounded-none bg-slate-50 border border-slate-200 text-slate-400 hover:bg-slate-900 hover:text-white transition" aria-label="LinkedIn">
                                <i class="fab fa-linkedin-in text-sm"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="mt-16 border-t border-slate-100 pt-8 flex items-center justify-between">
            <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">© {{ now()->format('Y') }} PARK-IT. All rights reserved.</p>
        </div>
    </div>
</footer>

