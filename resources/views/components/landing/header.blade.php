<header class="sticky top-0 z-50 w-full border-b border-slate-100 bg-white/95 backdrop-blur-sm">
    <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
        <a href="{{ route('landing') }}" class="flex items-center gap-2.5">
            <div class="flex h-8 w-8 items-center justify-center border border-slate-200 bg-white">
                <img src="{{ asset('favicon..png') }}" alt="P" class="h-5 w-5 object-contain grayscale" />
            </div>
            <div class="leading-none">
                <div class="text-xs font-bold tracking-widest text-slate-900 uppercase">PARK-IT</div>
                <div class="mt-0.5 text-[9px] font-medium tracking-tight text-slate-400 uppercase">Parking Management</div>
            </div>
        </a>
        <div class="flex items-center gap-2">
            <a href="{{ route('login') }}"
               class="inline-flex items-center gap-2 bg-slate-900 px-5 py-2 text-[9px] font-bold uppercase tracking-widest text-white hover:bg-slate-800 transition">
                Masuk
                <i class="fas fa-arrow-right text-[8px]"></i>
            </a>
        </div>
    </div>
</header>
