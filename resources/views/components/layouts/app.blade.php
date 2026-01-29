<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="bg-gray-50 text-gray-900">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r border-gray-200 flex flex-col fixed inset-y-0 left-0 transform -translate-x-full md:relative md:translate-x-0 transition-all duration-300 z-50 sidebar-menu" id="sidebar">
            
            <!-- Logo -->
            <div class="flex items-center justify-between h-16 border-b border-gray-200 px-4 sidebar-logo-section">
                <div class="text-center logo-full transition-all duration-300">
                    <h2 class="text-lg font-bold text-gray-900">PARK-IT</h2>
                    <p class="text-xs text-gray-500">Parking System</p>
                </div>
                <div class="text-lg font-bold text-gray-900 logo-icon hidden">PI</div>
                <button id="sidebar-toggle" class="hidden text-gray-600 hover:text-gray-900 transition p-1" title="Toggle sidebar">
                    <i class="fas fa-chevron-left text-lg"></i>
                </button>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto sidebar-nav">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center px-4 py-3 text-gray-700 rounded-lg transition nav-item @if (Route::currentRouteName() === 'admin.dashboard') bg-blue-50 text-blue-700 border-l-4 border-blue-600 @else hover:bg-gray-100 @endif">
                    <i class="fas fa-chart-line w-5 flex-shrink-0 nav-icon"></i>
                    <span class="font-medium nav-label transition-all duration-300">Dashboard</span>
                </a>
                <a href="{{ route('admin.users.index') }}"
                    class="flex items-center px-4 py-3 text-gray-700 rounded-lg transition nav-item @if (Route::currentRouteName() === 'admin.users.index') bg-blue-50 text-blue-700 border-l-4 border-blue-600 @else hover:bg-gray-100 @endif">
                    <i class="fas fa-users w-5 flex-shrink-0 nav-icon"></i>
                    <span class="font-medium nav-label transition-all duration-300">Users</span>
                </a>
                <a href="{{ route('admin.area-parkir.index') }}"
                    class="flex items-center px-4 py-3 text-gray-700 rounded-lg transition nav-item @if (Route::currentRouteName() === 'admin.area-parkir.index') bg-blue-50 text-blue-700 border-l-4 border-blue-600 @else hover:bg-gray-100 @endif">
                    <i class="fas fa-map-location-dot w-5 flex-shrink-0 nav-icon"></i>
                    <span class="font-medium nav-label transition-all duration-300">Area Parkir</span>
                </a>
                <a href="{{ route('admin.kendaraan.index') }}"
                    class="flex items-center px-4 py-3 text-gray-700 rounded-lg transition nav-item @if (Route::currentRouteName() === 'admin.kendaraan.index') bg-blue-50 text-blue-700 border-l-4 border-blue-600 @else hover:bg-gray-100 @endif">
                    <i class="fas fa-car w-5 flex-shrink-0 nav-icon"></i>
                    <span class="font-medium nav-label transition-all duration-300">Kendaraan</span>
                </a>
                <a href="{{ route('admin.tarif.index') }}"
                    class="flex items-center px-4 py-3 text-gray-700 rounded-lg transition nav-item @if (Route::currentRouteName() === 'admin.tarif.index') bg-blue-50 text-blue-700 border-l-4 border-blue-600 @else hover:bg-gray-100 @endif">
                    <i class="fas fa-receipt w-5 flex-shrink-0 nav-icon"></i>
                    <span class="font-medium nav-label transition-all duration-300">Tarif</span>
                </a>
                <a href="{{ route('admin.log-aktivitas.index') }}"
                    class="flex items-center px-4 py-3 text-gray-700 rounded-lg transition nav-item @if (Route::currentRouteName() === 'admin.log-aktivitas.index') bg-blue-50 text-blue-700 border-l-4 border-blue-600 @else hover:bg-gray-100 @endif">
                    <i class="fas fa-history w-5 flex-shrink-0 nav-icon"></i>
                    <span class="font-medium nav-label transition-all duration-300">Log</span>
                </a>
            </nav>

            <!-- User Profile -->
            @auth
                <div class="border-t border-gray-200 p-4 sidebar-profile">
                    <div class="flex items-center gap-3 mb-4 p-3 bg-gray-50 rounded-lg profile-full transition-all duration-300">
                        <div class="w-10 h-10 rounded-full bg-blue-600 flex-shrink-0 flex items-center justify-center text-white font-semibold text-sm">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-900 truncate">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500 truncate">{{ Auth::user()->role }}</p>
                        </div>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full px-4 py-2 bg-red-50 text-red-700 text-sm font-medium rounded-lg hover:bg-red-100 transition flex items-center justify-center gap-2">
                            <i class="fas fa-sign-out-alt"></i>
                            Logout
                        </button>
                    </form>
                </div>
            @endauth
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-white border-b border-gray-200 px-6 py-4 sticky top-0 z-40 shadow-sm">
                <h1 class="text-2xl font-bold text-gray-900">
                    @auth
                        Welcome back, {{ Auth::user()->name }}
                    @else
                        Dashboard
                    @endauth
                </h1>
            </header>

            <!-- Content -->
            <main class="flex-1 overflow-y-auto">
                <div class="p-6 max-w-7xl mx-auto">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>

    <script src="{{ asset('js/admin/sidebar.js') }}"></script>
</body>

</html>

