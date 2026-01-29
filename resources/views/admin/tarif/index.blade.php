<x-layouts.app title="Tarif Parkir">
    <div class="space-y-6">
        <!-- Header & Actions -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Tarif Parkir</h1>
                <p class="text-gray-600 text-sm mt-1">Total: {{ $tarif->total() }} tarif</p>
            </div>
            <a href="{{ route('admin.tarif.create') }}" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-plus mr-2"></i>Tambah Tarif
            </a>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="px-6 py-3 text-left font-semibold text-gray-700">Jenis Kendaraan</th>
                            <th class="px-6 py-3 text-right font-semibold text-gray-700">Tarif / Jam</th>
                            <th class="px-6 py-3 text-center font-semibold text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($tarif as $t)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-3 font-medium text-gray-900">{{ $t->jenis_kendaraan }}</td>
                                <td class="px-6 py-3 text-right text-gray-900 font-semibold">Rp {{ number_format($t->tarif_per_jam, 0, ',', '.') }}</td>
                                <td class="px-6 py-3 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('admin.tarif.edit', $t) }}" class="p-2 bg-blue-50 text-blue-600 rounded hover:bg-blue-100 transition">
                                            <i class="fas fa-pen-to-square"></i>
                                        </a>
                                        <form action="{{ route('admin.tarif.destroy', $t) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 bg-red-50 text-red-600 rounded hover:bg-red-100 transition">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-8 text-center text-gray-500">Tidak ada tarif ditemukan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="flex justify-center">
            {{ $tarif->links() }}
        </div>
    </div>
</x-layouts.app>