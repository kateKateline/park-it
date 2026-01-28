<x-layouts.app :title="'CRUD Kendaraan - Admin'">
    <div class="mx-auto max-w-6xl p-6">
        @include('partials.topbar', [
            'title' => 'CRUD Kendaraan',
            'subtitle' => 'Admin dapat mengelola data kendaraan.',
        ])

        <div class="mt-6 space-y-4">
            @include('partials.flash')

            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <form class="flex gap-2" method="GET" action="{{ route('admin.kendaraan.index') }}">
                    <input name="q" value="{{ $q }}" placeholder="Cari plat/jenis/merk/pemilik..."
                           class="w-full sm:w-80 rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm outline-none focus:border-slate-900 focus:ring-2 focus:ring-slate-900/10" />
                    <button class="rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm font-medium hover:bg-slate-50">
                        Cari
                    </button>
                </form>

                <a href="{{ route('admin.kendaraan.create') }}"
                   class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">
                    + Kendaraan
                </a>
            </div>

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="px-4 py-3 text-left">Plat</th>
                        <th class="px-4 py-3 text-left">Jenis</th>
                        <th class="px-4 py-3 text-left">Warna</th>
                        <th class="px-4 py-3 text-left">Merk</th>
                        <th class="px-4 py-3 text-left">Terdaftar</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($items as $k)
                        <tr class="border-t border-slate-100">
                            <td class="px-4 py-3 font-medium">{{ $k->plat_nomor }}</td>
                            <td class="px-4 py-3">{{ $k->jenis_kendaraan }}</td>
                            <td class="px-4 py-3">{{ $k->warna }}</td>
                            <td class="px-4 py-3">{{ $k->merk }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex rounded-full {{ $k->is_terdaftar ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-700' }} px-2 py-1 text-xs font-medium">
                                    {{ $k->is_terdaftar ? 'Ya' : 'Tidak' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a class="rounded-lg border border-slate-300 bg-white px-3 py-1.5 text-xs font-medium hover:bg-slate-50"
                                       href="{{ route('admin.kendaraan.edit', $k) }}">
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('admin.kendaraan.destroy', $k) }}"
                                          onsubmit="return confirm('Hapus kendaraan ini?');">
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
                            <td colspan="6" class="px-4 py-8 text-center text-slate-500">Belum ada data.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div>{{ $items->links() }}</div>
        </div>
    </div>
</x-layouts.app>

