<x-layouts.app :title="'CRUD User - Admin'">
    <div class="mx-auto max-w-6xl p-6">
        @include('partials.topbar', [
            'title' => 'CRUD User',
            'subtitle' => 'Admin dapat mengelola user (admin/petugas/owner).',
        ])

        <div class="mt-6 space-y-4">
            @include('partials.flash')

            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <form class="flex gap-2" method="GET" action="{{ route('admin.users.index') }}">
                    <input name="q" value="{{ $q }}" placeholder="Cari nama/username/role..."
                           class="w-full sm:w-80 rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm outline-none focus:border-slate-900 focus:ring-2 focus:ring-slate-900/10" />
                    <button class="rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm font-medium hover:bg-slate-50">
                        Cari
                    </button>
                </form>

                <a href="{{ route('admin.users.create') }}"
                   class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">
                    + User
                </a>
            </div>

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="px-4 py-3 text-left">#</th>
                        <th class="px-4 py-3 text-left">Nama</th>
                        <th class="px-4 py-3 text-left">Username</th>
                        <th class="px-4 py-3 text-left">Role</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($users as $u)
                        <tr class="border-t border-slate-100">
                            <td class="px-4 py-3">{{ $u->id }}</td>
                            <td class="px-4 py-3 font-medium">{{ $u->name }}</td>
                            <td class="px-4 py-3">{{ $u->username }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex rounded-full bg-slate-100 px-2 py-1 text-xs font-medium text-slate-700">
                                    {{ $u->role }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a class="rounded-lg border border-slate-300 bg-white px-3 py-1.5 text-xs font-medium hover:bg-slate-50"
                                       href="{{ route('admin.users.edit', $u) }}">
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('admin.users.destroy', $u) }}"
                                          onsubmit="return confirm('Hapus user ini?');">
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

            <div>{{ $users->links() }}</div>
        </div>
    </div>
</x-layouts.app>

