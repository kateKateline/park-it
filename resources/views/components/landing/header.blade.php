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

