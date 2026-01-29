<div class="flex items-center justify-between gap-4">
    <div>
        <h1 class="text-2xl font-semibold tracking-tight">{{ $title }}</h1>
        <p class="text-sm text-slate-600 mt-1">
            {{ $subtitle ?? '' }}
        </p>
    </div>

    @if (!($hideActions ?? false))
        <div class="flex items-center gap-2">
            <a href="{{ route('dashboard') }}"
               class="rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm font-medium hover:bg-slate-50">
                Dashboard
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm font-medium hover:bg-slate-50">
                    Logout
                </button>
            </form>
        </div>
    @endif
</div>

