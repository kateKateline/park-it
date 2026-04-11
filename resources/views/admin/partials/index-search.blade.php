{{-- Expects: $action (url), $placeholder, optional $q (falls back to request) --}}
@php
    $searchQ = (string) ($q ?? request('q', ''));
@endphp
<form method="GET" action="{{ $action }}" class="flex flex-wrap items-stretch gap-2">
    <div class="relative min-w-[200px] flex-1">
        <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-gray-400">
            <i class="fas fa-magnifying-glass text-sm"></i>
        </span>
        <input type="search"
               name="q"
               value="{{ $searchQ }}"
               placeholder="{{ $placeholder }}"
               class="w-full rounded-xl border border-gray-300 bg-white py-2.5 pl-10 pr-4 text-sm text-gray-900 placeholder:text-gray-400 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20"
               autocomplete="off">
    </div>
    <button type="submit"
            class="inline-flex shrink-0 items-center justify-center gap-2 rounded-xl bg-gray-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-gray-800 transition">
        <i class="fas fa-search text-xs"></i>
        Cari
    </button>
    @if($searchQ !== '')
        <a href="{{ $action }}"
           class="inline-flex shrink-0 items-center justify-center rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
            Reset
        </a>
    @endif
</form>
