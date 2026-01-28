<x-layouts.app :title="'Admin Dashboard - Park-It'">
    <div class="mx-auto max-w-6xl p-6">
        @include('partials.topbar', [
            'title' => 'Dashboard Admin',
            'subtitle' => 'CRUD master data & akses log aktivitas sesuai SPK.',
        ])

        <div class="mt-6 space-y-4">
            @include('partials.flash')

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="text-sm text-slate-600">User</div>
                    <div class="mt-1 text-2xl font-semibold">{{ $counts['users'] }}</div>
                    <a class="mt-3 inline-block text-sm font-medium text-slate-900 underline" href="{{ route('admin.users.index') }}">Kelola</a>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="text-sm text-slate-600">Tarif</div>
                    <div class="mt-1 text-2xl font-semibold">{{ $counts['tarif'] }}</div>
                    <a class="mt-3 inline-block text-sm font-medium text-slate-900 underline" href="{{ route('admin.tarif.index') }}">Kelola</a>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="text-sm text-slate-600">Area Parkir</div>
                    <div class="mt-1 text-2xl font-semibold">{{ $counts['area'] }}</div>
                    <a class="mt-3 inline-block text-sm font-medium text-slate-900 underline" href="{{ route('admin.area-parkir.index') }}">Kelola</a>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="text-sm text-slate-600">Kendaraan</div>
                    <div class="mt-1 text-2xl font-semibold">{{ $counts['kendaraan'] }}</div>
                    <a class="mt-3 inline-block text-sm font-medium text-slate-900 underline" href="{{ route('admin.kendaraan.index') }}">Kelola</a>
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <div class="text-sm text-slate-600">Log Aktivitas</div>
                        <div class="mt-1 text-lg font-semibold">Lihat audit trail</div>
                    </div>
                    <a class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800"
                       href="{{ route('admin.log-aktivitas.index') }}">
                        Buka Log
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>

