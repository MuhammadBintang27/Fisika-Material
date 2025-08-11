@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Welcome Section -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl p-6 text-white shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold mb-2">Selamat Datang, {{ auth()->user()->name }}!</h2>
                <p class="text-blue-100">Kelola website Laboratorium Fisika Dasar dengan mudah</p>
            </div>
            <div class="hidden md:block">
                <i class="fas fa-chart-line text-4xl text-blue-200 animate-pulse"></i>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Articles -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6 hover:shadow-xl hover:scale-105 transition-all duration-300 transform">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Artikel</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['total_articles'] }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center hover:bg-blue-200 transition-colors">
                    <i class="fas fa-newspaper text-blue-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('admin.articles.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium hover:underline transition-all">
                    Kelola Artikel <i class="fas fa-arrow-right ml-1 hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </div>

        <!-- Total Equipment -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6 hover:shadow-xl hover:scale-105 transition-all duration-300 transform">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Alat</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['total_equipment'] }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center hover:bg-green-200 transition-colors">
                    <i class="fas fa-tools text-green-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('admin.equipment.index') }}" class="text-green-600 hover:text-green-700 text-sm font-medium hover:underline transition-all">
                    Kelola Alat <i class="fas fa-arrow-right ml-1 hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </div>

        <!-- Pending Loans -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6 hover:shadow-xl hover:scale-105 transition-all duration-300 transform">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Peminjaman Pending</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['pending_loans'] }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center hover:bg-yellow-200 transition-colors">
                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('admin.loans.pending') }}" class="text-yellow-600 hover:text-yellow-700 text-sm font-medium hover:underline transition-all">
                    Lihat Pending <i class="fas fa-arrow-right ml-1 hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </div>

        <!-- Total Staff -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6 hover:shadow-xl hover:scale-105 transition-all duration-300 transform">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Staf</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['total_staff'] }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center hover:bg-purple-200 transition-colors">
                    <i class="fas fa-users text-purple-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('admin.staff.index') }}" class="text-purple-600 hover:text-purple-700 text-sm font-medium hover:underline transition-all">
                    Kelola Staf <i class="fas fa-arrow-right ml-1 hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </div>

        <!-- Total Jenis Pengujian -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6 hover:shadow-xl hover:scale-105 transition-all duration-300 transform">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Jenis Pengujian</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['total_jenis_pengujian'] ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center hover:bg-orange-200 transition-colors">
                    <i class="fas fa-flask text-orange-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('admin.jenis-pengujian.index') }}" class="text-orange-600 hover:text-orange-700 text-sm font-medium hover:underline transition-all">
                    Kelola Jenis <i class="fas fa-arrow-right ml-1 hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </div>

        <!-- Total Pengujian -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6 hover:shadow-xl hover:scale-105 transition-all duration-300 transform">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Pengujian</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['total_pengujian'] ?? 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center hover:bg-red-200 transition-colors">
                    <i class="fas fa-microscope text-red-600 text-xl"></i>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('admin.pengujian.index') }}" class="text-red-600 hover:text-red-700 text-sm font-medium hover:underline transition-all">
                    Kelola Pengujian <i class="fas fa-arrow-right ml-1 hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </div>
    </div>

    @if(auth()->user()->isSuperAdmin())
    <!-- Admin Management Stats -->
    <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl p-6 text-white shadow-lg">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-xl font-bold">Manajemen Administrator</h3>
                <p class="text-purple-100">Kelola akun administrator sistem</p>
            </div>
            <div class="hidden md:block">
                <i class="fas fa-user-shield text-4xl text-purple-200 animate-pulse"></i>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Total Admins -->
            <div class="bg-white bg-opacity-20 rounded-lg p-4 hover:bg-opacity-30 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100 text-sm font-medium">Total Admin</p>
                        <p class="text-3xl font-bold">{{ $stats['total_admins'] ?? 0 }}</p>
                    </div>
                    <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-users text-white text-lg"></i>
                    </div>
                </div>
            </div>

            <!-- Super Admins -->
            <div class="bg-white bg-opacity-20 rounded-lg p-4 hover:bg-opacity-30 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100 text-sm font-medium">Super Admin</p>
                        <p class="text-3xl font-bold">{{ $stats['total_super_admins'] ?? 0 }}</p>
                    </div>
                    <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-crown text-white text-lg"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-4 pt-4 border-t border-purple-300 border-opacity-30">
            <a href="{{ route('admin.admin-management.index') }}" 
               class="inline-flex items-center text-white hover:text-purple-200 font-medium transition-colors">
                <i class="fas fa-cog mr-2"></i>
                Kelola Administrator
                <i class="fas fa-arrow-right ml-2 hover:translate-x-1 transition-transform"></i>
            </a>
        </div>
    </div>
    @endif

    <!-- Recent Activities -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Loans -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 hover:shadow-xl transition-all duration-300">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Peminjaman Terbaru</h3>
                    <a href="{{ route('admin.loans.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium hover:underline transition-all">
                        Lihat Semua
                    </a>
                </div>
            </div>
            <div class="p-6">
                @if($recentLoans->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentLoans as $loan)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 hover:shadow-md transition-all duration-200">
                                <div class="flex-1">
                                    <p class="font-medium text-gray-900">{{ $loan->namaPeminjam }}</p>
                                    <p class="text-sm text-gray-600">
                                        {{ $loan->items->count() }} alat • {{ $loan->tanggalPinjam }}
                                    </p>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="px-2 py-1 text-xs font-medium rounded-full
                                        @if($loan->status === 'PENDING') bg-yellow-100 text-yellow-800
                                        @elseif($loan->status === 'APPROVED') bg-green-100 text-green-800
                                        @elseif($loan->status === 'REJECTED') bg-red-100 text-red-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ $loan->status }}
                                    </span>
                                    <a href="{{ route('admin.loans.show', $loan->id) }}" 
                                       class="text-blue-600 hover:text-blue-700 hover:scale-110 transition-all">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-handshake text-gray-400 text-3xl mb-3"></i>
                        <p class="text-gray-500">Belum ada peminjaman</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Recent Articles -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 hover:shadow-xl transition-all duration-300">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Artikel Terbaru</h3>
                    <a href="{{ route('admin.articles.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium hover:underline transition-all">
                        Lihat Semua
                    </a>
                </div>
            </div>
            <div class="p-6">
                @if($recentArticles->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentArticles as $article)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 hover:shadow-md transition-all duration-200">
                                <div class="flex-1">
                                    <p class="font-medium text-gray-900 line-clamp-1">{{ $article->namaAcara }}</p>
                                    <p class="text-sm text-gray-600">{{ $article->tanggalAcara }}</p>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('admin.articles.edit', $article->id) }}" 
                                       class="text-blue-600 hover:text-blue-700 hover:scale-110 transition-all">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-newspaper text-gray-400 text-3xl mb-3"></i>
                        <p class="text-gray-500">Belum ada artikel</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6 hover:shadow-xl transition-all duration-300">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('admin.articles.create') }}" 
               class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 hover:shadow-md transition-all duration-200 transform hover:scale-105">
                <i class="fas fa-plus text-blue-600 mr-3"></i>
                <span class="font-medium text-blue-900">Tambah Artikel</span>
            </a>
            
            <a href="{{ route('admin.equipment.create') }}" 
               class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 hover:shadow-md transition-all duration-200 transform hover:scale-105">
                <i class="fas fa-plus text-green-600 mr-3"></i>
                <span class="font-medium text-green-900">Tambah Alat</span>
            </a>
            
            <a href="{{ route('admin.staff.create') }}" 
               class="flex items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 hover:shadow-md transition-all duration-200 transform hover:scale-105">
                <i class="fas fa-plus text-purple-600 mr-3"></i>
                <span class="font-medium text-purple-900">Tambah Staf</span>
            </a>
            
            <a href="{{ route('admin.jenis-pengujian.create') }}" 
               class="flex items-center p-4 bg-orange-50 rounded-lg hover:bg-orange-100 hover:shadow-md transition-all duration-200 transform hover:scale-105">
                <i class="fas fa-plus text-orange-600 mr-3"></i>
                <span class="font-medium text-orange-900">Tambah Jenis Pengujian</span>
            </a>
            
            <a href="{{ route('admin.pengujian.create') }}" 
               class="flex items-center p-4 bg-red-50 rounded-lg hover:bg-red-100 hover:shadow-md transition-all duration-200 transform hover:scale-105">
                <i class="fas fa-plus text-red-600 mr-3"></i>
                <span class="font-medium text-red-900">Tambah Pengujian</span>
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
 