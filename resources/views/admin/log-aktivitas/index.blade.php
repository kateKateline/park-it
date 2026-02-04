<x-layouts.admin title="Log Aktivitas">
    <div class="space-y-6">
        <!-- Header -->
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Log Aktivitas</h1>
            <p class="text-gray-600 text-sm mt-1\">Total: {{ $items->total() }} aktivitas</p>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="px-6 py-3 text-left font-semibold text-gray-700">Waktu</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700">User</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700">Aktivitas</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($items as $log)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-3 text-gray-600 whitespace-nowrap">{{ $log->created_at?->format('d/m H:i') }}</td>
                                <td class="px-6 py-3">
                                    <div class="font-medium text-gray-900">{{ $log->user?->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $log->user?->username }} ({{ $log->user?->role }})</div>
                                </td>
                                <td class="px-6 py-3 text-gray-600">{{ $log->aktivitas }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-8 text-center text-gray-500">Tidak ada aktivitas ditemukan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="flex justify-center">
            {{ $items->links('pagination::tailwind') }}
        </div>
    </div>
</x-layouts.admin>