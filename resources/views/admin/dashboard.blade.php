@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Welcome Section -->
    <div class="bg-gradient-to-br from-blue-700 to-blue-800 rounded-xl p-8 text-white shadow-xl border border-blue-600">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold mb-3">Selamat Datang, {{ auth()->user()->name }}!</h2>
                <p class="text-blue-100 text-lg">Kelola website Laboratorium Fisika Dasar dengan mudah</p>
                <div class="mt-4 flex items-center space-x-2">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-600 text-blue-100">
                        <i class="fas fa-crown mr-1"></i>
                        @if(auth()->user()->isSuperAdmin()) Super Administrator @else Administrator @endif
                    </span>
                </div>
            </div>
            <div class="hidden md:block">
                <div class="w-20 h-20 bg-blue-600 rounded-full flex items-center justify-center shadow-lg">
                    <i class="fas fa-chart-line text-3xl text-blue-100"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Articles -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Total Artikel</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['total_articles'] }}</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform shadow-lg">
                    <i class="fas fa-newspaper text-white text-xl"></i>
                </div>
            </div>
            <div class="mt-6 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.articles.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-700 text-sm font-semibold group-hover:underline transition-all">
                    <span>Kelola Artikel</span>
                    <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </div>

        <!-- Total Equipment -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Total Alat</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['total_equipment'] }}</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform shadow-lg">
                    <i class="fas fa-tools text-white text-xl"></i>
                </div>
            </div>
            <div class="mt-6 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.equipment.index') }}" class="inline-flex items-center text-emerald-600 hover:text-emerald-700 text-sm font-semibold group-hover:underline transition-all">
                    <span>Kelola Alat</span>
                    <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </div>

        <!-- Pending Loans -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Peminjaman Pending</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['pending_loans'] }}</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform shadow-lg">
                    <i class="fas fa-clock text-white text-xl"></i>
                </div>
            </div>
            <div class="mt-6 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.loans.pending') }}" class="inline-flex items-center text-amber-600 hover:text-amber-700 text-sm font-semibold group-hover:underline transition-all">
                    <span>Lihat Pending</span>
                    <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </div>

        <!-- Total Staff -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Total Staf</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['total_staff'] }}</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform shadow-lg">
                    <i class="fas fa-users text-white text-xl"></i>
                </div>
            </div>
            <div class="mt-6 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.staff.index') }}" class="inline-flex items-center text-purple-600 hover:text-purple-700 text-sm font-semibold group-hover:underline transition-all">
                    <span>Kelola Staf</span>
                    <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </div>

        <!-- Total Jenis Pengujian -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Jenis Pengujian</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['total_jenis_pengujian'] ?? 0 }}</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform shadow-lg">
                    <i class="fas fa-flask text-white text-xl"></i>
                </div>
            </div>
            <div class="mt-6 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.jenis-pengujian.index') }}" class="inline-flex items-center text-orange-600 hover:text-orange-700 text-sm font-semibold group-hover:underline transition-all">
                    <span>Kelola Jenis</span>
                    <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </div>

        <!-- Total Pengujian -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Total Pengujian</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['total_pengujian'] ?? 0 }}</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform shadow-lg">
                    <i class="fas fa-microscope text-white text-xl"></i>
                </div>
            </div>
            <div class="mt-6 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.pengujian.index') }}" class="inline-flex items-center text-red-600 hover:text-red-700 text-sm font-semibold group-hover:underline transition-all">
                    <span>Kelola Pengujian</span>
                    <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </div>
    </div>

    @if(auth()->user()->isSuperAdmin())
    <!-- Admin Management Stats -->
    <div class="bg-gradient-to-br from-purple-600 to-purple-700 rounded-xl p-8 text-white shadow-xl border border-purple-500">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-2xl font-bold">Manajemen Administrator</h3>
                <p class="text-purple-100 text-lg">Kelola akun administrator sistem</p>
            </div>
            <div class="hidden md:block">
                <div class="w-16 h-16 bg-purple-500 rounded-full flex items-center justify-center shadow-lg">
                    <i class="fas fa-user-shield text-2xl text-purple-100"></i>
                </div>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Total Admins -->
            <div class="bg-white bg-opacity-20 backdrop-blur-sm rounded-xl p-6 hover:bg-opacity-30 transition-all duration-300 border border-purple-400 border-opacity-30">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100 text-sm font-semibold uppercase tracking-wide">Total Admin</p>
                        <p class="text-3xl font-bold mt-1">{{ $stats['total_admins'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-users text-white text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Super Admins -->
            <div class="bg-white bg-opacity-20 backdrop-blur-sm rounded-xl p-6 hover:bg-opacity-30 transition-all duration-300 border border-purple-400 border-opacity-30">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100 text-sm font-semibold uppercase tracking-wide">Super Admin</p>
                        <p class="text-3xl font-bold mt-1">{{ $stats['total_super_admins'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-crown text-white text-xl"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-6 pt-6 border-t border-purple-400 border-opacity-30">
            <a href="{{ route('admin.admin-management.index') }}" 
               class="inline-flex items-center text-white hover:text-purple-200 font-semibold text-lg transition-colors group">
                <i class="fas fa-cog mr-3 group-hover:rotate-90 transition-transform duration-300"></i>
                <span>Kelola Administrator</span>
                <i class="fas fa-arrow-right ml-3 group-hover:translate-x-1 transition-transform"></i>
            </a>
        </div>
    </div>
    @endif

    <!-- Recent Activities -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Loans -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
            <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-blue-100 rounded-t-xl">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                            <i class="fas fa-handshake text-white"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Peminjaman Terbaru</h3>
                    </div>
                    <a href="{{ route('admin.loans.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-700 text-sm font-semibold hover:underline transition-all group">
                        <span>Lihat Semua</span>
                        <i class="fas fa-arrow-right ml-1 group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </div>
            <div class="p-6">
                @if($recentLoans->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentLoans as $loan)
                            <div class="flex items-center justify-between p-4 bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl hover:from-blue-50 hover:to-blue-100 hover:shadow-md transition-all duration-300 border border-gray-200">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-user text-white"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-semibold text-gray-900">{{ $loan->namaPeminjam }}</p>
                                        <p class="text-sm text-gray-600 flex items-center">
                                            <i class="fas fa-tools mr-1"></i>
                                            {{ $loan->items->count() }} alat 
                                            <i class="fas fa-calendar ml-2 mr-1"></i>
                                            {{ $loan->tanggalPinjam }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full
                                        @if($loan->status === 'PENDING') bg-amber-100 text-amber-800 border border-amber-200
                                        @elseif($loan->status === 'APPROVED') bg-emerald-100 text-emerald-800 border border-emerald-200
                                        @elseif($loan->status === 'REJECTED') bg-red-100 text-red-800 border border-red-200
                                        @else bg-gray-100 text-gray-800 border border-gray-200
                                        @endif">
                                        {{ $loan->status }}
                                    </span>
                                    <a href="{{ route('admin.loans.show', $loan->id) }}" 
                                       class="w-8 h-8 bg-blue-500 hover:bg-blue-600 rounded-lg flex items-center justify-center text-white hover:scale-110 transition-all duration-200">
                                        <i class="fas fa-eye text-sm"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-handshake text-gray-400 text-2xl"></i>
                        </div>
                        <p class="text-gray-500 font-medium">Belum ada peminjaman</p>
                        <p class="text-gray-400 text-sm">Peminjaman baru akan muncul di sini</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Recent Articles -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
            <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-emerald-50 to-emerald-100 rounded-t-xl">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-emerald-500 rounded-lg flex items-center justify-center">
                            <i class="fas fa-newspaper text-white"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Artikel Terbaru</h3>
                    </div>
                    <a href="{{ route('admin.articles.index') }}" class="inline-flex items-center text-emerald-600 hover:text-emerald-700 text-sm font-semibold hover:underline transition-all group">
                        <span>Lihat Semua</span>
                        <i class="fas fa-arrow-right ml-1 group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </div>
            <div class="p-6">
                @if($recentArticles->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentArticles as $article)
                            <div class="flex items-center justify-between p-4 bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl hover:from-emerald-50 hover:to-emerald-100 hover:shadow-md transition-all duration-300 border border-gray-200">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-emerald-500 rounded-full flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-newspaper text-white"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-semibold text-gray-900 line-clamp-1">{{ $article->namaAcara }}</p>
                                        <p class="text-sm text-gray-600 flex items-center">
                                            <i class="fas fa-calendar mr-1"></i>
                                            {{ $article->tanggalAcara }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <a href="{{ route('admin.articles.edit', $article->id) }}" 
                                       class="w-8 h-8 bg-emerald-500 hover:bg-emerald-600 rounded-lg flex items-center justify-center text-white hover:scale-110 transition-all duration-200">
                                        <i class="fas fa-edit text-sm"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-newspaper text-gray-400 text-2xl"></i>
                        </div>
                        <p class="text-gray-500 font-medium">Belum ada artikel</p>
                        <p class="text-gray-400 text-sm">Artikel baru akan muncul di sini</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl shadow-lg border border-gray-200 p-8 hover:shadow-xl transition-all duration-300">
        <div class="flex items-center space-x-3 mb-6">
            <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                <i class="fas fa-bolt text-white"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900">Aksi Cepat</h3>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('admin.articles.create') }}" 
               class="group flex items-center p-5 bg-white rounded-xl hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 border border-gray-200 hover:border-blue-300">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                    <i class="fas fa-plus text-white text-lg"></i>
                </div>
                <div>
                    <span class="font-semibold text-gray-900 group-hover:text-blue-600 transition-colors">Tambah Artikel</span>
                    <p class="text-xs text-gray-500">Buat artikel baru</p>
                </div>
            </a>
            
            <a href="{{ route('admin.equipment.create') }}" 
               class="group flex items-center p-5 bg-white rounded-xl hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 border border-gray-200 hover:border-emerald-300">
                <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                    <i class="fas fa-plus text-white text-lg"></i>
                </div>
                <div>
                    <span class="font-semibold text-gray-900 group-hover:text-emerald-600 transition-colors">Tambah Alat</span>
                    <p class="text-xs text-gray-500">Tambah peralatan</p>
                </div>
            </a>
            
            <a href="{{ route('admin.staff.create') }}" 
               class="group flex items-center p-5 bg-white rounded-xl hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 border border-gray-200 hover:border-purple-300">
                <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                    <i class="fas fa-plus text-white text-lg"></i>
                </div>
                <div>
                    <span class="font-semibold text-gray-900 group-hover:text-purple-600 transition-colors">Tambah Staf</span>
                    <p class="text-xs text-gray-500">Tambah anggota</p>
                </div>
            </a>
            
            <a href="{{ route('admin.jenis-pengujian.create') }}" 
               class="group flex items-center p-5 bg-white rounded-xl hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 border border-gray-200 hover:border-orange-300">
                <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                    <i class="fas fa-plus text-white text-lg"></i>
                </div>
                <div>
                    <span class="font-semibold text-gray-900 group-hover:text-orange-600 transition-colors">Jenis Pengujian</span>
                    <p class="text-xs text-gray-500">Tambah jenis baru</p>
                </div>
            </a>
            
            <a href="{{ route('admin.pengujian.create') }}" 
               class="group flex items-center p-5 bg-white rounded-xl hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 border border-gray-200 hover:border-red-300 md:col-span-2 lg:col-span-1">
                <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                    <i class="fas fa-plus text-white text-lg"></i>
                </div>
                <div>
                    <span class="font-semibold text-gray-900 group-hover:text-red-600 transition-colors">Tambah Pengujian</span>
                    <p class="text-xs text-gray-500">Buat pengujian baru</p>
                </div>
            </a>
        </div>
    </div>
</div>

<style>
.line-clamp-1 {
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection 
 