<x-layouts.app :title="'Log Aktivitas - Admin'">
    <div class="mx-auto max-w-6xl p-6">
        @include('partials.topbar', [
            'title' => 'Log Aktivitas',
            'subtitle' => 'Admin dapat melihat log aktivitas.',
        ])

        <div class="mt-6 space-y-4">
            @include('partials.flash')

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="px-4 py-3 text-left">Waktu</th>
                        <th class="px-4 py-3 text-left">User</th>
                        <th class="px-4 py-3 text-left">Aktivitas</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($items as $log)
                        <tr class="border-t border-slate-100">
                            <td class="px-4 py-3 whitespace-nowrap">{{ $log->created_at?->format('d/m/Y H:i') }}</td>
                            <td class="px-4 py-3">
                                <div class="font-medium">{{ $log->user?->name }}</div>
                                <div class="text-xs text-slate-500">{{ $log->user?->username }} ({{ $log->user?->role }})</div>
                            </td>
                            <td class="px-4 py-3 text-slate-700">{{ $log->aktivitas }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-4 py-8 text-center text-slate-500">Belum ada data.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div>{{ $items->links() }}</div>
        </div>
    </div>
</x-layouts.app>

