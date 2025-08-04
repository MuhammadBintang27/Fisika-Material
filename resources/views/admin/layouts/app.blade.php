<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - Laboratorium Fisika</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50">
    <div x-data="{ sidebarOpen: false }" class="min-h-screen flex">
        <!-- Sidebar -->
        <aside 
            class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-lg transform transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-auto"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            @click.away="if (window.innerWidth < 1024) sidebarOpen = false">
            
            <!-- Logo -->
            <div class="flex items-center justify-between h-16 px-6 border-b border-gray-200">
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('images/logo-fisika.png') }}" alt="Logo" class="w-8 h-8">
                    <span class="text-lg font-semibold text-gray-800">Admin Panel</span>
                </div>
                <button @click="sidebarOpen = false" class="lg:hidden">
                    <i class="fas fa-times text-gray-500"></i>
                </button>
            </div>

            <!-- Navigation -->
            <nav class="px-4 py-6 space-y-2">
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 text-blue-600' : '' }}">
                    <i class="fas fa-tachometer-alt w-5 h-5 mr-3"></i>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('admin.about.index') }}" 
                   class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition-colors {{ request()->routeIs('admin.about.*') ? 'bg-blue-50 text-blue-600' : '' }}">
                    <i class="fas fa-info-circle w-5 h-5 mr-3"></i>
                    <span>Profil Laboratorium</span>
                </a>

                <a href="{{ route('admin.articles.index') }}" 
                   class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition-colors {{ request()->routeIs('admin.articles.*') ? 'bg-blue-50 text-blue-600' : '' }}">
                    <i class="fas fa-newspaper w-5 h-5 mr-3"></i>
                    <span>Artikel</span>
                </a>

                <a href="{{ route('admin.galeri.index') }}" 
                   class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition-colors {{ request()->routeIs('admin.galeri.*') ? 'bg-blue-50 text-blue-600' : '' }}">
                    <i class="fas fa-image w-5 h-5 mr-3"></i>
                    <span>Galeri Laboratorium</span>
                </a>

                <a href="{{ route('admin.equipment.index') }}" 
                   class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition-colors {{ request()->routeIs('admin.equipment.*') ? 'bg-blue-50 text-blue-600' : '' }}">
                    <i class="fas fa-tools w-5 h-5 mr-3"></i>
                    <span>Alat & Peralatan</span>
                </a>

                <a href="{{ route('admin.loans.index') }}" 
                   class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition-colors {{ request()->routeIs('admin.loans.*') ? 'bg-blue-50 text-blue-600' : '' }}">
                    <i class="fas fa-handshake w-5 h-5 mr-3"></i>
                    <span>Peminjaman Alat</span>
                </a>

                <a href="{{ route('admin.staff.index') }}" 
                   class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition-colors {{ request()->routeIs('admin.staff.*') ? 'bg-blue-50 text-blue-600' : '' }}">
                    <i class="fas fa-users w-5 h-5 mr-3"></i>
                    <span>Staf & Tenaga Ahli</span>
                </a>

                <a href="{{ route('admin.kunjungan.index') }}" 
                   class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition-colors {{ request()->routeIs('admin.kunjungan.*') ? 'bg-blue-50 text-blue-600' : '' }}">
                    <i class="fas fa-calendar-check w-5 h-5 mr-3"></i>
                    <span>Kunjungan</span>
                </a>

                <a href="{{ route('admin.pengujian.index') }}" 
                   class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition-colors {{ request()->routeIs('admin.pengujian.*') ? 'bg-blue-50 text-blue-600' : '' }}">
                    <i class="fas fa-vial w-5 h-5 mr-3"></i>
                    <span>Pengujian</span>
                </a>

                <a href="{{ route('admin.jenis-pengujian.index') }}" 
                   class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition-colors {{ request()->routeIs('admin.jenis-pengujian.*') ? 'bg-blue-50 text-blue-600' : '' }}">
                    <i class="fas fa-flask w-5 h-5 mr-3"></i>
                    <span>Jenis Pengujian</span>
                </a>
            </nav>

            <!-- User Info -->
            <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-gray-200">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-white text-sm"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-800">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500">Administrator</p>
                    </div>
                    <form method="POST" action="{{ route('admin.logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-400 hover:text-red-500 transition-colors">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Top Bar -->
            <div class="bg-white shadow-sm border-b border-gray-200">
                <div class="flex items-center justify-between h-16 px-6">
                    <div class="flex items-center space-x-4">
                        <button @click="sidebarOpen = true" class="lg:hidden">
                            <i class="fas fa-bars text-gray-500"></i>
                        </button>
                        <h1 class="text-xl font-semibold text-gray-800">@yield('title', 'Dashboard')</h1>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('home') }}" target="_blank" class="text-gray-500 hover:text-blue-600 transition-colors">
                            <i class="fas fa-external-link-alt mr-2"></i>
                            Lihat Website
                        </a>
                    </div>
                </div>
            </div>

            <!-- Page Content -->
            <main class="p-6">
                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-3"></i>
                            <span class="text-green-700">{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                            <span class="text-red-700">{{ session('error') }}</span>
                        </div>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.bg-green-50, .bg-red-50');
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 0.5s ease-out';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);
    </script>
</body>
</html> 
 