<x-layouts.app :title="'Dashboard - Park-It'">
    <div class="mx-auto max-w-6xl p-6">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-semibold tracking-tight">Dashboard</h1>
                <p class="text-sm text-slate-600 mt-1">
                    Selamat datang, <span class="font-medium text-slate-900">{{ $user->name }}</span>
                    <span class="text-slate-400">({{ $user->role }})</span>
                </p>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm font-medium hover:bg-slate-50">
                    Logout
                </button>
            </form>
        </div>

        <div class="mt-8 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="text-sm text-slate-600">User</div>
                <div class="mt-1 text-lg font-semibold">{{ $user->username }}</div>
                <div class="mt-1 text-xs text-slate-500">Akses halaman lain akan dibuat sesuai PDF.</div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="text-sm text-slate-600">Status</div>
                <div class="mt-1 text-lg font-semibold">Logged in</div>
                <div class="mt-1 text-xs text-slate-500">Middleware `auth` aktif.</div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="text-sm text-slate-600">Next</div>
                <div class="mt-1 text-lg font-semibold">Halaman sesuai SPK</div>
                <div class="mt-1 text-xs text-slate-500">Transaksi/scan belum diimplement.</div>
            </div>
        </div>
    </div>
</x-layouts.app>

