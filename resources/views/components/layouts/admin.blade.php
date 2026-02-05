<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin' }}</title>
    <script>
        try {
            var k = 'parkitSidebarState';
            var collapsed = localStorage.getItem(k) === 'true';
            if (collapsed) {
                document.documentElement.classList.add('sidebar-collapsed');
            } else {
                document.documentElement.classList.remove('sidebar-collapsed');
            }
        } catch (e) {}
    </script>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="bg-gray-50 text-gray-900">
    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar Container -->
        <aside id="app-sidebar" class="bg-white border-gray-200 border-r flex-shrink-0 transition-all duration-300 ease-in-out fixed md:static inset-y-0 left-0 z-50" 
               data-state="expanded"
               data-ready="false"
               style="width: 256px; overflow: hidden;">
            
            <div class="h-full flex flex-col">
                
                <!-- Brand + Toggle Section -->
                <div class="h-16 border-b border-gray-200 px-4 flex items-center justify-between flex-shrink-0 gap-2" data-header="brand-toggle">
                    <div data-brand="full" class="transition-opacity duration-200">
                        <h2 class="text-sm font-bold text-gray-900 whitespace-nowrap">PARK-IT</h2>
                        <p class="text-[10px] text-gray-500 whitespace-nowrap">Parking System</p>
                    </div>
                    <button type="button" 
                            id="toggle-sidebar-btn" 
                            class="flex items-center justify-center w-10 h-10 rounded-lg text-gray-700 hover:bg-gray-100 hover:text-gray-900 transition-colors"
                            aria-label="Toggle sidebar">
                        <i class="fas fa-bars text-lg" data-icon="hamburger"></i>
                    </button>
                </div>

                <!-- Navigation Menu -->
                <nav class="flex-1 overflow-y-auto px-4 py-6">
                    <ul class="space-y-1">
                        <li>
                            <a href="{{ route('admin.dashboard') }}"
                               class="nav-link group flex items-center gap-2 px-3 py-2 rounded-md text-gray-700 text-sm transition-colors hover:bg-gray-100 @if(Route::currentRouteName() === 'admin.dashboard') bg-blue-50 border-l-4 border-blue-600 text-blue-700 @endif">
                                <i class="fas fa-chart-line w-5 text-center flex-shrink-0"></i>
                                <span data-nav="label" class="whitespace-nowrap overflow-hidden transition-opacity duration-200 text-xs">Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.users.index') }}"
                               class="nav-link group flex items-center gap-2 px-3 py-2 rounded-md text-gray-700 text-sm transition-colors hover:bg-gray-100 @if(Route::currentRouteName() === 'admin.users.index') bg-blue-50 border-l-4 border-blue-600 text-blue-700 @endif">
                                <i class="fas fa-users w-5 text-center flex-shrink-0"></i>
                                <span data-nav="label" class="whitespace-nowrap overflow-hidden transition-opacity duration-200 text-xs">Users</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.area-parkir.index') }}"
                               class="nav-link group flex items-center gap-2 px-3 py-2 rounded-md text-gray-700 text-sm transition-colors hover:bg-gray-100 @if(Route::currentRouteName() === 'admin.area-parkir.index') bg-blue-50 border-l-4 border-blue-600 text-blue-700 @endif">
                                <i class="fas fa-map-location-dot w-5 text-center flex-shrink-0"></i>
                                <span data-nav="label" class="whitespace-nowrap overflow-hidden transition-opacity duration-200 text-xs">Area Parkir</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.kendaraan.index') }}"
                               class="nav-link group flex items-center gap-2 px-3 py-2 rounded-md text-gray-700 text-sm transition-colors hover:bg-gray-100 @if(Route::currentRouteName() === 'admin.kendaraan.index') bg-blue-50 border-l-4 border-blue-600 text-blue-700 @endif">
                                <i class="fas fa-car w-5 text-center flex-shrink-0"></i>
                                <span data-nav="label" class="whitespace-nowrap overflow-hidden transition-opacity duration-200 text-xs">Kendaraan</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.tarif.index') }}"
                               class="nav-link group flex items-center gap-2 px-3 py-2 rounded-md text-gray-700 text-sm transition-colors hover:bg-gray-100 @if(Route::currentRouteName() === 'admin.tarif.index') bg-blue-50 border-l-4 border-blue-600 text-blue-700 @endif">
                                <i class="fas fa-receipt w-5 text-center flex-shrink-0"></i>
                                <span data-nav="label" class="whitespace-nowrap overflow-hidden transition-opacity duration-200 text-xs">Tarif</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.log-aktivitas.index') }}"
                               class="nav-link group flex items-center gap-2 px-3 py-2 rounded-md text-gray-700 text-sm transition-colors hover:bg-gray-100 @if(Route::currentRouteName() === 'admin.log-aktivitas.index') bg-blue-50 border-l-4 border-blue-600 text-blue-700 @endif">
                                <i class="fas fa-history w-5 text-center flex-shrink-0"></i>
                                <span data-nav="label" class="whitespace-nowrap overflow-hidden transition-opacity duration-200 text-xs">Log</span>
                            </a>
                        </li>
                    </ul>
                </nav>

                <!-- User Profile Section -->
                @auth
                <div class="border-t border-gray-200 p-3 shrink-0">
                    <div data-profile="card" class="mb-3 p-2.5 bg-gray-50 rounded-lg transition-all duration-200">
                        <div class="flex items-center gap-2.5 min-w-0" data-profile="container">
                            <div class="w-9 h-9 rounded-full bg-blue-600 flex items-center justify-center text-white font-semibold text-xs flex-shrink-0">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <div data-profile="info" class="flex-1 min-w-0 overflow-hidden transition-opacity duration-200">
                                <p class="text-xs font-semibold text-gray-900 truncate">{{ Auth::user()->name }}</p>
                                <p class="text-[10px] text-gray-500 truncate">{{ Auth::user()->role }}</p>
                            </div>
                        </div>
                    </div>
                    <form action="{{ route('logout') }}" method="POST" id="logout-form" class="block">
                        @csrf
                        <button type="submit" 
                                class="w-full py-3 bg-red-50 text-red-700 text-xs font-medium rounded-lg hover:bg-red-100 transition-colors flex items-center justify-center gap-2"
                                id="logout-button"
                                aria-label="Logout">
                            <i class="fas fa-sign-out-alt text-sm"></i>
                            <span data-profile="logout" class="ml-2 text-xs font-medium hidden">Logout</span>
                        </button>
                    </form>
                </div>
                @endauth

            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-w-0">

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto bg-gray-50">
                <div class="p-6 max-w-7xl mx-auto">
                    {{ $slot }}
                </div>
            </main>

        </div>
    </div>
</body>

</html>
