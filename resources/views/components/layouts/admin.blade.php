<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin' }}</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="bg-gray-50 text-gray-900">
    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar Container -->
        <aside id="app-sidebar" class="bg-white border-r border-gray-200 flex-shrink-0 transition-all duration-300 ease-in-out fixed md:static inset-y-0 left-0 z-50 transform -translate-x-full md:translate-x-0" 
               data-state="expanded"
               style="width: 256px; overflow: hidden;">
            
            <div class="h-full flex flex-col">
                
                <!-- Brand Section -->
                <div class="h-16 border-b border-gray-200 px-4 flex items-center justify-between flex-shrink-0">
                    <div class="flex items-center gap-3 overflow-hidden flex-1">
                        <div class="flex-shrink-0 flex items-center justify-between w-full min-w-0">
                            <div data-brand="full" class="transition-opacity duration-200 flex-1 min-w-0">
                                <h2 class="text-lg font-bold text-gray-900 whitespace-nowrap">PARK-IT</h2>
                                <p class="text-xs text-gray-500 whitespace-nowrap">Parking System</p>
                            </div>
                            <div data-brand="mini" class="hidden transition-opacity duration-200 flex-shrink-0">
                                <span class="text-lg font-bold text-gray-900">PI</span>
                            </div>
                        </div>
                    </div>
                    <button type="button" 
                            id="toggle-sidebar-btn" 
                            class="hidden md:flex items-center justify-center w-8 h-8 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition-colors flex-shrink-0 ml-2"
                            aria-label="Toggle sidebar">
                        <i class="fas fa-chevron-left text-sm" data-icon="collapse"></i>
                        <i class="fas fa-chevron-right text-sm hidden" data-icon="expand"></i>
                    </button>
                </div>

                <!-- Navigation Menu -->
                <nav class="flex-1 overflow-y-auto px-4 py-6">
                    <ul class="space-y-1">
                        <li>
                            <a href="{{ route('admin.dashboard') }}"
                               class="nav-link group flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 font-medium transition-all duration-200 hover:bg-gray-100 @if(Route::currentRouteName() === 'admin.dashboard') bg-blue-50 border-l-4 border-blue-600 text-blue-700 @endif">
                                <i class="fas fa-chart-line w-5 text-center flex-shrink-0"></i>
                                <span data-nav="label" class="whitespace-nowrap overflow-hidden transition-opacity duration-200">Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.users.index') }}"
                               class="nav-link group flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 font-medium transition-all duration-200 hover:bg-gray-100 @if(Route::currentRouteName() === 'admin.users.index') bg-blue-50 border-l-4 border-blue-600 text-blue-700 @endif">
                                <i class="fas fa-users w-5 text-center flex-shrink-0"></i>
                                <span data-nav="label" class="whitespace-nowrap overflow-hidden transition-opacity duration-200">Users</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.area-parkir.index') }}"
                               class="nav-link group flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 font-medium transition-all duration-200 hover:bg-gray-100 @if(Route::currentRouteName() === 'admin.area-parkir.index') bg-blue-50 border-l-4 border-blue-600 text-blue-700 @endif">
                                <i class="fas fa-map-location-dot w-5 text-center flex-shrink-0"></i>
                                <span data-nav="label" class="whitespace-nowrap overflow-hidden transition-opacity duration-200">Area Parkir</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.kendaraan.index') }}"
                               class="nav-link group flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 font-medium transition-all duration-200 hover:bg-gray-100 @if(Route::currentRouteName() === 'admin.kendaraan.index') bg-blue-50 border-l-4 border-blue-600 text-blue-700 @endif">
                                <i class="fas fa-car w-5 text-center flex-shrink-0"></i>
                                <span data-nav="label" class="whitespace-nowrap overflow-hidden transition-opacity duration-200">Kendaraan</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.tarif.index') }}"
                               class="nav-link group flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 font-medium transition-all duration-200 hover:bg-gray-100 @if(Route::currentRouteName() === 'admin.tarif.index') bg-blue-50 border-l-4 border-blue-600 text-blue-700 @endif">
                                <i class="fas fa-receipt w-5 text-center flex-shrink-0"></i>
                                <span data-nav="label" class="whitespace-nowrap overflow-hidden transition-opacity duration-200">Tarif</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.log-aktivitas.index') }}"
                               class="nav-link group flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 font-medium transition-all duration-200 hover:bg-gray-100 @if(Route::currentRouteName() === 'admin.log-aktivitas.index') bg-blue-50 border-l-4 border-blue-600 text-blue-700 @endif">
                                <i class="fas fa-history w-5 text-center flex-shrink-0"></i>
                                <span data-nav="label" class="whitespace-nowrap overflow-hidden transition-opacity duration-200">Log</span>
                            </a>
                        </li>
                    </ul>
                </nav>

                <!-- User Profile Section -->
                @auth
                <div class="border-t border-gray-200 p-4 shrink-0">
                    <div data-profile="card" class="mb-4 p-3 bg-gray-50 rounded-lg transition-all duration-200">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-semibold text-sm flex-shrink-0">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <div data-profile="info" class="flex-1 min-w-0 overflow-hidden transition-opacity duration-200">
                                <p class="text-sm font-semibold text-gray-900 truncate">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ Auth::user()->role }}</p>
                            </div>
                        </div>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" 
                                class="w-full px-4 py-2 bg-red-50 text-red-700 text-sm font-medium rounded-lg hover:bg-red-100 transition-colors flex items-center justify-center gap-2">
                            <i class="fas fa-sign-out-alt"></i>
                            <span data-profile="logout" class="transition-opacity duration-200">Logout</span>
                        </button>
                    </form>
                </div>
                @endauth

            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-w-0">
            
            <!-- Top Header Bar -->
            <header class="bg-white border-b border-gray-200 px-6 py-4 flex-shrink-0 shadow-sm">
                <div class="flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-gray-900">
                        @auth
                            Welcome back, {{ Auth::user()->name }}
                        @else
                            Dashboard
                        @endauth
                    </h1>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto bg-gray-50">
                <div class="p-6 max-w-7xl mx-auto">
                    {{ $slot }}
                </div>
            </main>

        </div>
    </div>

    <script src="{{ asset('js/admin/sidebar.js') }}"></script>
</body>

</html>