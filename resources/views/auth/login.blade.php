<x-layouts.guest :title="'Login - Park-It'">
    <div class="min-h-screen flex items-center justify-center p-6">
        <div class="w-full max-w-md">
            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6">
                <div class="mb-6">
                    <h1 class="text-2xl font-semibold tracking-tight">Park-It</h1>
                    <p class="text-sm text-slate-600 mt-1">Silakan login untuk masuk dashboard.</p>
                </div>

                @if ($errors->any())
                    <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                        <div class="font-medium">Login gagal</div>
                        <ul class="mt-1 list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-slate-700">Username</label>
                        <input
                            name="username"
                            value="{{ old('username') }}"
                            class="mt-1 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm outline-none focus:border-slate-900 focus:ring-2 focus:ring-slate-900/10"
                            placeholder="Masukkan username"
                            autocomplete="username"
                            required
                        />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700">Password</label>
                        <input
                            type="password"
                            name="password"
                            class="mt-1 w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm outline-none focus:border-slate-900 focus:ring-2 focus:ring-slate-900/10"
                            placeholder="Masukkan password"
                            autocomplete="current-password"
                            required
                        />
                    </div>

                    <button
                        type="submit"
                        class="w-full rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-slate-800"
                    >
                        Login
                    </button>
                </form>

                <p class="mt-6 text-xs text-slate-500">
                    Role yang tersedia: admin, petugas, owner.
                </p>
            </div>
        </div>
    </div>
</x-layouts.guest>

