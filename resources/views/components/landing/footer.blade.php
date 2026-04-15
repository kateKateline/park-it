<footer class="mt-auto border-t border-slate-800 bg-slate-900 text-slate-400">
    <div class="mx-auto max-w-7xl px-6 py-10">
        <div class="grid grid-cols-1 gap-10 lg:grid-cols-12">
            <div class="lg:col-span-6" data-aos="fade-up">
                <a href="{{ route('landing') }}" class="inline-flex items-center gap-2.5">
                    <div class="flex h-8 w-8 items-center justify-center border border-slate-700 bg-white/10">
                        <img src="{{ asset('favicon..png') }}" alt="P" class="h-5 w-5 object-contain grayscale invert" />
                    </div>
                    <div class="leading-none">
                        <div class="text-xs font-bold tracking-widest text-white uppercase">PARK-IT</div>
                        <div class="mt-0.5 text-[9px] font-medium tracking-tight text-slate-500 uppercase">Parking Management</div>
                    </div>
                </a>
                <p class="mt-4 max-w-sm text-[11px] leading-relaxed text-slate-500">
                    Sistem parkir dengan alur kerja yang jelas untuk operasional harian. Cepat saat transaksi, rapi saat rekap.
                </p>
                <div class="mt-6 flex items-center gap-2">
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-2 bg-white px-4 py-2 text-[9px] font-bold uppercase tracking-widest text-slate-900 hover:bg-slate-100 transition">
                        Login <i class="fas fa-arrow-right text-[8px]"></i>
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-8 lg:col-span-6 lg:justify-items-end" data-aos="fade-up" data-aos-delay="200">
                <div class="w-full lg:max-w-[140px]">
                    <h3 class="text-[9px] font-bold uppercase tracking-widest text-white">Fitur</h3>
                    <ul class="mt-4 space-y-2 text-[10px] font-medium uppercase tracking-wider text-slate-500">
                        <li><a href="{{ route('login') }}" class="hover:text-white transition">Transaksi</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-white transition">Tarif</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-white transition">Rekap</a></li>
                    </ul>
                </div>
                <div class="w-full lg:max-w-[140px]">
                    <h3 class="text-[9px] font-bold uppercase tracking-widest text-white">Kontak</h3>
                    <ul class="mt-4 space-y-2 text-[10px] font-medium uppercase tracking-wider text-slate-500">
                        <li class="flex items-center gap-2">
                            <i class="fas fa-envelope text-[9px] text-slate-600"></i>
                            support@park-it.id
                        </li>
                        <li class="mt-4 flex gap-2">
                            <a href="#" class="flex h-8 w-8 items-center justify-center border border-slate-800 bg-white/5 text-slate-500 hover:bg-white hover:text-slate-900 transition" aria-label="Github">
                                <i class="fab fa-github text-xs"></i>
                            </a>
                            <a href="#" class="flex h-8 w-8 items-center justify-center border border-slate-800 bg-white/5 text-slate-500 hover:bg-white hover:text-slate-900 transition" aria-label="LinkedIn">
                                <i class="fab fa-linkedin-in text-xs"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="mt-12 border-t border-slate-800 pt-6 flex items-center justify-between">
            <p class="text-[9px] font-bold uppercase tracking-widest text-slate-600">© {{ now()->format('Y') }} PARK-IT. All rights reserved.</p>
        </div>
    </div>
</footer>
