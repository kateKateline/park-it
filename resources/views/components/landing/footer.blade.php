<footer class="mt-auto border-t border-slate-200 bg-white text-slate-500">
    <div class="mx-auto max-w-7xl px-6 py-10">
        <div class="grid grid-cols-1 gap-10 lg:grid-cols-12">
            <div class="lg:col-span-6" data-aos="fade-up">
                <a href="{{ route('landing') }}" class="inline-flex items-center gap-2.5">
                    <div class="flex h-8 w-8 items-center justify-center bg-slate-900">
                        <img src="{{ asset('favicon..png') }}" alt="P" class="h-5 w-5 object-contain grayscale invert" />
                    </div>
                    <div class="leading-none">
                        <div class="text-xs font-bold tracking-widest text-slate-900 uppercase">PARK-IT</div>
                        <div class="mt-0.5 text-[9px] font-medium tracking-tight text-slate-400 uppercase">Parking Management</div>
                    </div>
                </a>
                <p class="mt-4 max-w-sm text-[11px] leading-relaxed text-slate-500">
                    Sistem parkir dengan alur kerja yang jelas untuk operasional harian. Cepat saat transaksi, rapi saat rekap.
                </p>
                <div class="mt-6 flex items-center gap-2">
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-2 bg-slate-900 px-4 py-2 text-[9px] font-bold uppercase tracking-widest text-white hover:bg-slate-800 transition">
                        Login <i class="fas fa-arrow-right text-[8px]"></i>
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-8 lg:col-span-6 lg:justify-items-end" data-aos="fade-up" data-aos-delay="200">
                <div class="w-full lg:max-w-[140px]">
                    <h3 class="text-[9px] font-bold uppercase tracking-widest text-slate-900">Navigasi</h3>
                    <ul class="mt-4 space-y-2 text-[10px] font-medium uppercase tracking-wider text-slate-500">
                        <li><a href="#top" class="hover:text-slate-900 transition">Top</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-slate-900 transition">Login</a></li>
                        <li><a href="#message" class="hover:text-slate-900 transition">Message</a></li>
                    </ul>
                </div>
                <div class="w-full lg:max-w-[140px]">
                    <h3 class="text-[9px] font-bold uppercase tracking-widest text-slate-900">Kontak</h3>
                    <ul class="mt-4 space-y-2 text-[10px] font-medium uppercase tracking-wider text-slate-500">
                        <li class="flex items-center gap-2">
                            <i class="fas fa-envelope text-[9px] text-slate-400"></i>
                            <a href="mailto:rizkyramadhan12098@gmail.com" class="hover:text-slate-900 transition">rizkyramadhan12098@gmail.com</a>
                        </li>
                        <li class="mt-4 flex gap-2">
                            <a href="https://github.com/KateKateline" target="_blank" class="flex h-8 w-8 items-center justify-center border border-slate-200 bg-slate-50 text-slate-400 hover:bg-slate-900 hover:text-white transition" aria-label="Github">
                                <i class="fab fa-github text-xs"></i>
                            </a>
                            <a href="#" class="flex h-8 w-8 items-center justify-center border border-slate-200 bg-slate-50 text-slate-400 hover:bg-slate-900 hover:text-white transition" aria-label="LinkedIn">
                                <i class="fab fa-linkedin-in text-xs"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="mt-12 border-t border-slate-100 pt-6 flex items-center justify-between">
            <p class="text-[9px] font-bold uppercase tracking-widest text-slate-400">© {{ now()->format('Y') }} PARK-IT. All rights reserved.</p>
        </div>
    </div>
</footer>
