<x-layouts.guest :title="'Login - Park-It'">
    <div class="relative min-h-screen overflow-hidden flex items-center justify-center bg-slate-50">
        <div class="absolute inset-0 opacity-[0.03]" style="background-image: radial-gradient(#000 1px, transparent 1px); background-size: 20px 20px;"></div>

        <div class="relative w-full max-w-md p-6">
            <div class="bg-white border border-slate-200 p-8 rounded-2xl shadow-sm">
                <div class="flex items-center justify-between mb-8">
                    <a href="{{ route('landing') }}" class="inline-flex items-center gap-2 text-xs text-slate-500 hover:text-slate-900 transition">
                        <i class="fas fa-arrow-left text-[10px]"></i>
                        Kembali
                    </a>
                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-white text-slate-900 ring-1 ring-slate-200 shadow-sm">
                        <img src="{{ asset('favicon..png') }}" alt="P" class="h-5 w-5 object-contain grayscale" />
                    </div>
                </div>

                <div class="mb-8">
                    <div class="mb-4">
                        <div class="text-base font-bold uppercase tracking-wider text-slate-900">Park-It</div>
                        <div class="text-[10px] text-slate-500 uppercase tracking-wider font-medium">Management System</div>
                    </div>
                    <h1 class="text-xl font-bold tracking-tight text-slate-900">Login</h1>
                    <p class="mt-1 text-sm text-slate-500">Masuk untuk mengakses dashboard.</p>
                </div>

                @if ($errors->any())
                    <div class="mb-4 border border-red-200 bg-red-50 p-4 text-sm text-red-800">
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
                            class="mt-1 w-full border border-slate-300 bg-white px-4 py-2.5 text-sm outline-none focus:border-slate-900 focus:ring-1 focus:ring-slate-900/10"
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
                            class="mt-1 w-full border border-slate-300 bg-white px-4 py-2.5 text-sm outline-none focus:border-slate-900 focus:ring-1 focus:ring-slate-900/10"
                            placeholder="Masukkan password"
                            autocomplete="current-password"
                            required
                        />
                    </div>

                    <button
                        type="submit"
                        class="w-full bg-slate-900 py-2.5 text-sm font-semibold text-white hover:bg-slate-800 transition"
                    >
                        Login
                    </button>
                </form>

                <div class="mt-6 flex items-center justify-between text-xs text-slate-500">
                    <div class="inline-flex items-center gap-2">
                        <i class="fas fa-shield-halved text-[11px]"></i>
                        Role: admin, petugas, owner
                    </div>
                    <div class="inline-flex items-center gap-2">
                        <i class="fas fa-lock text-[11px]"></i>
                        Secured
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.guest>
