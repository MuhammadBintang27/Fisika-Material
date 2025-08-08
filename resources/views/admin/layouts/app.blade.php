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
        .sidebar-sticky {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            overflow-y: hidden;
            z-index: 50;
        }
        .main-content {
            margin-left: 16rem; /* 256px */
            height: 100vh;
            overflow: hidden;
        }
        @media (max-width: 1023px) {
            .main-content {
                margin-left: 0;
            }
        }
        /* Hide scrollbar for Chrome, Safari, Edge */
        .sidebar-sticky::-webkit-scrollbar {
            display: none;
        }
        /* Hide scrollbar for Firefox */
        .sidebar-sticky {
            scrollbar-width: none;
        }
        .sidebar-bg {
            background-color: #3261d5;
        }
        .main-bg {
            background-color: #3261d5;
        }
        .content-scroll {
            scrollbar-width: thin;
            scrollbar-color: #cbd5e0 #f7fafc;
        }
        .content-scroll::-webkit-scrollbar {
            width: 6px;
        }
        .content-scroll::-webkit-scrollbar-track {
            background: #f7fafc;
            border-radius: 3px;
        }
        .content-scroll::-webkit-scrollbar-thumb {
            background: #cbd5e0;
            border-radius: 3px;
        }
        .content-scroll::-webkit-scrollbar-thumb:hover {
            background: #a0aec0;
        }
    </style>
</head>
<body class="font-sans">
    <div x-data="{ 
        sidebarOpen: false,
        webManagementOpen: false 
    }" class="min-h-screen">
        <!-- Sidebar -->
        <aside 
            class="w-64 sidebar-bg shadow-lg sidebar-sticky transform transition-transform duration-300 ease-in-out lg:translate-x-0"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            @click.away="if (window.innerWidth < 1024) sidebarOpen = false">
            
            <!-- Logo -->
            <div class="flex items-center justify-between h-16 px-6">
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('images/logo-fisika.png') }}" alt="Logo" class="w-8 h-8">
                    <span class="text-lg font-semibold text-white">Admin Panel</span>
                </div>
                <button @click="sidebarOpen = false" class="lg:hidden text-white hover:text-gray-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Navigation -->
            <nav class="px-4 py-6 space-y-1 h-[calc(100vh-10rem)] overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center px-4 py-3 text-white rounded-lg hover:bg-white hover:bg-opacity-20 transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-orange-500 text-white' : '' }}">
                    <i class="fas fa-tachometer-alt w-5 h-5 mr-3"></i>
                    <span>Dashboard</span>
                </a>

                <!-- Kelola Tampilan Web -->
                <div x-data="{ open: {{ request()->routeIs('admin.about.*') || request()->routeIs('admin.articles.*') || request()->routeIs('admin.galeri.*') || request()->routeIs('admin.staff.*') ? 'true' : 'false' }} }">
                    <button @click="open = !open; webManagementOpen = open" 
                            class="w-full flex items-center justify-between px-4 py-3 text-white rounded-lg hover:bg-white hover:bg-opacity-20 transition-colors {{ request()->routeIs('admin.about.*') || request()->routeIs('admin.articles.*') || request()->routeIs('admin.galeri.*') || request()->routeIs('admin.staff.*') ? 'bg-orange-500' : '' }}">
                        <div class="flex items-center">
                            <i class="fas fa-globe w-5 h-5 mr-3"></i>
                            <span>Kelola Tampilan Web</span>
                        </div>
                        <i class="fas fa-chevron-down transition-transform" :class="open ? 'rotate-180' : ''"></i>
                    </button>
                    
                    <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-95" class="ml-6 mt-2 space-y-1">
                        <a href="{{ route('admin.about.index') }}" 
                           class="flex items-center px-4 py-2 text-sm text-white rounded-lg hover:bg-white hover:bg-opacity-20 transition-colors {{ request()->routeIs('admin.about.*') ? 'bg-orange-500' : '' }}">
                            <i class="fas fa-info-circle w-4 h-4 mr-3"></i>
                            <span>Profil Laboratorium</span>
                        </a>
                        
                        <a href="{{ route('admin.articles.index') }}" 
                           class="flex items-center px-4 py-2 text-sm text-white rounded-lg hover:bg-white hover:bg-opacity-20 transition-colors {{ request()->routeIs('admin.articles.*') ? 'bg-orange-500' : '' }}">
                            <i class="fas fa-newspaper w-4 h-4 mr-3"></i>
                            <span>Artikel</span>
                        </a>
                        
                        <a href="{{ route('admin.galeri.index') }}" 
                           class="flex items-center px-4 py-2 text-sm text-white rounded-lg hover:bg-white hover:bg-opacity-20 transition-colors {{ request()->routeIs('admin.galeri.*') ? 'bg-orange-500' : '' }}">
                            <i class="fas fa-image w-4 h-4 mr-3"></i>
                            <span>Galeri Laboratorium</span>
                        </a>
                        
                        <a href="{{ route('admin.staff.index') }}" 
                           class="flex items-center px-4 py-2 text-sm text-white rounded-lg hover:bg-white hover:bg-opacity-20 transition-colors {{ request()->routeIs('admin.staff.*') ? 'bg-orange-500' : '' }}">
                            <i class="fas fa-users w-4 h-4 mr-3"></i>
                            <span>Staf & Tenaga Ahli</span>
                        </a>
                    </div>
                </div>

                <a href="{{ route('admin.equipment.index') }}" 
                   class="flex items-center px-4 py-3 text-white rounded-lg hover:bg-white hover:bg-opacity-20 transition-colors {{ request()->routeIs('admin.equipment.*') ? 'bg-orange-500' : '' }}">
                    <i class="fas fa-tools w-5 h-5 mr-3"></i>
                    <span>Alat & Peralatan</span>
                </a>

                <a href="{{ route('admin.loans.index') }}" 
                   class="flex items-center px-4 py-3 text-white rounded-lg hover:bg-white hover:bg-opacity-20 transition-colors {{ request()->routeIs('admin.loans.*') ? 'bg-orange-500' : '' }}">
                    <i class="fas fa-handshake w-5 h-5 mr-3"></i>
                    <span>Peminjaman Alat</span>
                </a>

                <a href="{{ route('admin.kunjungan.index') }}" 
                   class="flex items-center px-4 py-3 text-white rounded-lg hover:bg-white hover:bg-opacity-20 transition-colors {{ request()->routeIs('admin.kunjungan.*') ? 'bg-orange-500' : '' }}">
                    <i class="fas fa-calendar-check w-5 h-5 mr-3"></i>
                    <span>Kunjungan</span>
                </a>

                <a href="{{ route('admin.jadwal.index') }}" 
                   class="flex items-center px-4 py-3 text-white rounded-lg hover:bg-white hover:bg-opacity-20 transition-colors {{ request()->routeIs('admin.jadwal.*') ? 'bg-orange-500' : '' }}">
                    <i class="fas fa-calendar-alt w-5 h-5 mr-3"></i>
                    <span>Jadwal</span>
                </a>

                <a href="{{ route('admin.pengujian.index') }}" 
                   class="flex items-center px-4 py-3 text-white rounded-lg hover:bg-white hover:bg-opacity-20 transition-colors {{ request()->routeIs('admin.pengujian.*') ? 'bg-orange-500' : '' }}">
                    <i class="fas fa-vial w-5 h-5 mr-3"></i>
                    <span>Pengujian</span>
                </a>

                <a href="{{ route('admin.jenis-pengujian.index') }}" 
                   class="flex items-center px-4 py-3 text-white rounded-lg hover:bg-white hover:bg-opacity-20 transition-colors {{ request()->routeIs('admin.jenis-pengujian.*') ? 'bg-orange-500' : '' }}">
                    <i class="fas fa-flask w-5 h-5 mr-3"></i>
                    <span>Jenis Pengujian</span>
                </a>
            </nav>

            <!-- User Info -->
            <div class="p-4">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-white text-sm"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-white text-opacity-80">Administrator</p>
                    </div>
                    <form method="POST" action="{{ route('admin.logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-white text-opacity-80 hover:text-red-300 transition-colors" title="Keluar">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="main-content main-bg">
            <!-- Page Content -->
            <main class="p-3 h-full">
                <div class="bg-white rounded-lg shadow-lg h-[calc(100vh-1.5rem)] overflow-hidden">
                    <!-- Mobile Header -->
                    <div class="lg:hidden flex items-center justify-between p-4 border-b border-gray-100">
                        <button @click="sidebarOpen = true" class="text-gray-600 hover:text-gray-800">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        <h1 class="text-xl font-semibold text-gray-800">@yield('title', 'Dashboard')</h1>
                        <a href="{{ route('home') }}" target="_blank" class="text-blue-600 hover:text-blue-800">
                            <i class="fas fa-external-link-alt"></i>
                        </a>
                    </div>
                    
                    <!-- Scrollable Content Area -->
                    <div class="h-full overflow-y-auto p-4 content-scroll">
                        @if(session('success'))
                            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg flex items-center">
                                <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                <span class="text-green-700">{{ session('success') }}</span>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg flex items-center">
                                <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                                <span class="text-red-700">{{ session('error') }}</span>
                            </div>
                        @endif

                        @yield('content')
                    </div>
                </div>
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

        // Ensure sidebar doesn't block content on mobile
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                Alpine.store('sidebarOpen', false);
            }
        });


    </script>
</body>
</html>
