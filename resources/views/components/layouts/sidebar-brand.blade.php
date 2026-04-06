@props([
    'role' => '',
])
<div class="flex min-w-0 flex-1 items-center gap-3">
    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-600 text-white shadow-sm shadow-blue-600/25"
         aria-hidden="true">
        <i class="fas fa-parking text-lg"></i>
    </div>
    <div data-brand="full" class="min-w-0 transition-opacity duration-200">
        <h2 class="whitespace-nowrap text-sm font-bold tracking-tight text-gray-900">PARK-IT</h2>
        <p class="whitespace-nowrap text-[10px] text-gray-500">Parking System</p>
        @if ($role !== '')
            <span class="mt-0.5 inline-flex rounded-full bg-blue-50 px-2 py-0.5 text-[9px] font-semibold uppercase tracking-wide text-blue-800 ring-1 ring-blue-100">{{ $role }}</span>
        @endif
    </div>
</div>
