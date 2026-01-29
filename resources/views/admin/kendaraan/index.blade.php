<x-layouts.app title="Kendaraan">
    <div class="space-y-6">
        <!-- Header & Actions -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Kendaraan</h1>
                <p class="text-gray-600 text-sm mt-1">Total: {{ $items->total() }} kendaraan</p>
            </div>
            <a href="{{ route('admin.kendaraan.create') }}" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-plus mr-2"></i>Tambah Kendaraan
            </a>
        </div>

        <!-- Search Form -->
        <form method="GET" action="{{ route('admin.kendaraan.index') }}" class="flex gap-2">
            <input type="text" name="q" value="{{ $q }}" placeholder="Cari plat nomor..."
                class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none">
            <button type="submit" class="px-4 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-300 transition">
                <i class="fas fa-search"></i>
            </button>
        </form>

        <!-- Table -->
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="px-6 py-3 text-left font-semibold text-gray-700">Plat Nomor</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700">Jenis</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700">Warna</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700">Merk</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700">Terdaftar</th>
                            <th class="px-6 py-3 text-center font-semibold text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($items as $k)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-3 font-medium text-gray-900">{{ $k->plat_nomor }}</td>
                                <td class="px-6 py-3 text-gray-600">{{ $k->jenis_kendaraan }}</td>
                                <td class="px-6 py-3 text-gray-600">{{ $k->warna }}</td>
                                <td class="px-6 py-3 text-gray-600">{{ $k->merk }}</td>
                                <td class="px-6 py-3">
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $k->is_terdaftar ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-700' }}">
                                        {{ $k->is_terdaftar ? 'Ya' : 'Tidak' }}
                                    </span>
                                </td>
                                <td class="px-6 py-3 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('admin.kendaraan.edit', $k) }}" class="p-2 bg-blue-50 text-blue-600 rounded hover:bg-blue-100 transition">
                                            <i class="fas fa-pen-to-square"></i>
                                        </a>
                                        <form action="{{ route('admin.kendaraan.destroy', $k) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus?');">
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
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500">Tidak ada kendaraan ditemukan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="flex justify-center">
            {{ $items->links() }}
        </div>
    </div>
</x-layouts.app>