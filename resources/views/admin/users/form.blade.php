<x-layouts.app :title="$mode === 'create' ? 'Tambah User - Admin' : 'Edit User - Admin'">
    <div class="mx-auto max-w-3xl p-6">
        @include('partials.topbar', [
            'title' => $mode === 'create' ? 'Tambah User' : 'Edit User',
            'subtitle' => 'CRUD User (Admin). Password boleh dikosongkan saat edit untuk tidak berubah.',
        ])

        <div class="mt-6 space-y-4">
            @include('partials.flash')

            @if ($errors->any())
                <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                    <div class="font-medium">Validasi gagal</div>
                    <ul class="mt-1 list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST"
                  action="{{ $mode === 'create' ? route('admin.users.store') : route('admin.users.update', $model) }}"
                  class="space-y-4 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                @csrf
                @if ($mode === 'edit')
                    @method('PUT')
                @endif

                <div>
                    <label class="block text-sm font-medium text-slate-700">Nama</label>
                    <input name="name" value="{{ old('name', $model->name) }}"
                           class="mt-1 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm outline-none focus:border-slate-900 focus:ring-2 focus:ring-slate-900/10"
                           required />
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700">Username</label>
                    <input name="username" value="{{ old('username', $model->username) }}"
                           class="mt-1 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm outline-none focus:border-slate-900 focus:ring-2 focus:ring-slate-900/10"
                           required />
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700">Role</label>
                    <select name="role"
                            class="mt-1 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm outline-none focus:border-slate-900 focus:ring-2 focus:ring-slate-900/10"
                            required>
                        @foreach (['admin', 'petugas', 'owner'] as $role)
                            <option value="{{ $role }}" @selected(old('role', $model->role) === $role)>{{ $role }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700">
                        Password {{ $mode === 'edit' ? '(opsional)' : '' }}
                    </label>
                    <input type="password" name="password"
                           class="mt-1 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm outline-none focus:border-slate-900 focus:ring-2 focus:ring-slate-900/10"
                           {{ $mode === 'create' ? 'required' : '' }} />
                </div>

                <div class="flex items-center justify-end gap-2 pt-2">
                    <a href="{{ route('admin.users.index') }}"
                       class="rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm font-medium hover:bg-slate-50">
                        Batal
                    </a>
                    <button class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>

