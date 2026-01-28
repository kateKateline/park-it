<x-layouts.app :title="'CRUD Area Parkir - Admin'">
    <div class="mx-auto max-w-6xl p-6">
        @include('partials.topbar', [
            'title' => 'CRUD Area Parkir',
            'subtitle' => 'Admin dapat mengelola area parkir.',
        ])

        <div class="mt-6 space-y-4">
            @include('partials.flash')

            <div class="flex items-center justify-end">
                <a href="{{ route('admin.area-parkir.create') }}"
                   class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">
                    + Area
                </a>
            </div>

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="px-4 py-3 text-left">#</th>
                        <th class="px-4 py-3 text-left">Nama Area</th>
                        <th class="px-4 py-3 text-left">Kapasitas</th>
                        <th class="px-4 py-3 text-left">Keterangan</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($items as $a)
                        <tr class="border-t border-slate-100">
                            <td class="px-4 py-3">{{ $a->id }}</td>
                            <td class="px-4 py-3 font-medium">{{ $a->nama_area }}</td>
                            <td class="px-4 py-3">{{ $a->kapasitas }}</td>
                            <td class="px-4 py-3 text-slate-600">{{ $a->keterangan }}</td>
                            <td class="px-4 py-3 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a class="rounded-lg border border-slate-300 bg-white px-3 py-1.5 text-xs font-medium hover:bg-slate-50"
                                       href="{{ route('admin.area-parkir.edit', $a) }}">
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('admin.area-parkir.destroy', $a) }}"
                                          onsubmit="return confirm('Hapus area ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="rounded-lg border border-red-300 bg-white px-3 py-1.5 text-xs font-medium text-red-700 hover:bg-red-50">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-slate-500">Belum ada data.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div>{{ $items->links() }}</div>
        </div>
    </div>
</x-layouts.app>

