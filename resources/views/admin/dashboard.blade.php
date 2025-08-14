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
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
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

        <!-- Pending Tests -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Pengujian Pending</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['pending_tests'] }}</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-rose-500 to-rose-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform shadow-lg">
                    <i class="fas fa-hourglass-half text-white text-xl"></i>
                </div>
            </div>
            <div class="mt-6 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.pengajuan-pengujian.index') }}" class="inline-flex items-center text-rose-600 hover:text-rose-700 text-sm font-semibold group-hover:underline transition-all">
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
                <a href="{{ route('admin.layanan-pengujian.index') }}" class="inline-flex items-center text-orange-600 hover:text-orange-700 text-sm font-semibold group-hover:underline transition-all">
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
                <a href="{{ route('admin.pengajuan-pengujian.index') }}" class="inline-flex items-center text-red-600 hover:text-red-700 text-sm font-semibold group-hover:underline transition-all">
                    <span>Kelola Pengujian</span>
                    <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </div>
    </div>

    @if(auth()->user()->isSuperAdmin())
    <!-- Admin Management Stats -->
    <div class="bg-gradient-to-br from-slate-600 to-slate-700 rounded-xl p-8 text-white shadow-xl border border-slate-500">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-2xl font-bold">Manajemen Administrator</h3>
                <p class="text-slate-100 text-lg">Kelola akun administrator sistem</p>
            </div>
            <div class="hidden md:block">
                <div class="w-16 h-16 bg-slate-500 rounded-full flex items-center justify-center shadow-lg">
                    <i class="fas fa-user-shield text-2xl text-slate-100"></i>
                </div>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Total Admins -->
            <div class="bg-white bg-opacity-20 backdrop-blur-sm rounded-xl p-6 hover:bg-opacity-30 transition-all duration-300 border border-slate-400 border-opacity-30">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-slate-100 text-sm font-semibold uppercase tracking-wide">Total Admin</p>
                        <p class="text-3xl font-bold mt-1">{{ $stats['total_admins'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-users text-white text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Super Admins -->
            <div class="bg-white bg-opacity-20 backdrop-blur-sm rounded-xl p-6 hover:bg-opacity-30 transition-all duration-300 border border-slate-400 border-opacity-30">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-slate-100 text-sm font-semibold uppercase tracking-wide">Super Admin</p>
                        <p class="text-3xl font-bold mt-1">{{ $stats['total_super_admins'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-crown text-white text-xl"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-6 pt-6 border-t border-slate-400 border-opacity-30">
            <a href="{{ route('admin.admin-management.index') }}" 
               class="inline-flex items-center text-white hover:text-slate-200 font-semibold text-lg transition-colors group">
                <i class="fas fa-cog mr-3 group-hover:rotate-90 transition-transform duration-300"></i>
                <span>Kelola Administrator</span>
                <i class="fas fa-arrow-right ml-3 group-hover:translate-x-1 transition-transform"></i>
            </a>
        </div>
    </div>
    @endif

    <!-- Analytics Dashboard -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Monthly Statistics Chart -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
            <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-indigo-50 to-indigo-100 rounded-t-xl">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-indigo-500 rounded-lg flex items-center justify-center">
                            <i class="fas fa-chart-bar text-white"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Statistik Bulanan</h3>
                    </div>
                    <select id="monthlyChartType" class="text-sm border border-gray-300 rounded-lg px-3 py-1 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="loans">Peminjaman</option>
                        <option value="visits">Kunjungan</option>
                        <option value="tests">Pengujian</option>
                    </select>
                </div>
            </div>
            <div class="p-6">
                <canvas id="monthlyChart" height="300"></canvas>
            </div>
        </div>

        <!-- Status Distribution -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
            <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-rose-50 to-rose-100 rounded-t-xl">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-rose-500 rounded-lg flex items-center justify-center">
                            <i class="fas fa-chart-pie text-white"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Distribusi Status</h3>
                    </div>
                    <select id="statusChartType" class="text-sm border border-gray-300 rounded-lg px-3 py-1 focus:ring-2 focus:ring-rose-500 focus:border-rose-500">
                        <option value="loans">Peminjaman</option>
                        <option value="visits">Kunjungan</option>
                        <option value="tests">Pengujian</option>
                    </select>
                </div>
            </div>
            <div class="p-6">
                <canvas id="statusChart" height="300"></canvas>
            </div>
        </div>
    </div>

    <!-- Performance Metrics -->
    <div class="bg-gradient-to-br from-teal-50 to-cyan-50 rounded-xl shadow-lg border border-teal-200 p-8 hover:shadow-xl transition-all duration-300">
        <div class="flex items-center space-x-3 mb-6">
            <div class="w-12 h-12 bg-teal-500 rounded-xl flex items-center justify-center">
                <i class="fas fa-chart-line text-white text-xl"></i>
            </div>
            <div>
                <h3 class="text-xl font-bold text-gray-900">Metrik Performa</h3>
                <p class="text-gray-600">Ringkasan performa sistem dalam 30 hari terakhir</p>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <!-- Success Rate -->
            <div class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition-all duration-300 border border-teal-100">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-check-circle text-emerald-600 text-xl"></i>
                    </div>
                    <span class="text-2xl font-bold text-emerald-600">{{ $performanceMetrics['success_rate'] }}%</span>
                </div>
                <h4 class="font-semibold text-gray-900 mb-1">Tingkat Keberhasilan</h4>
                <p class="text-sm text-gray-600">Peminjaman disetujui</p>
                <div class="mt-3 bg-gray-200 rounded-full h-2">
                    <div class="bg-emerald-500 h-2 rounded-full" style="width: {{ $performanceMetrics['success_rate'] }}%"></div>
                </div>
            </div>

            <!-- Average Response Time -->
            <div class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition-all duration-300 border border-teal-100">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-clock text-blue-600 text-xl"></i>
                    </div>
                    <span class="text-2xl font-bold text-blue-600">{{ $performanceMetrics['avg_response_time'] }}h</span>
                </div>
                <h4 class="font-semibold text-gray-900 mb-1">Waktu Respons</h4>
                <p class="text-sm text-gray-600">Rata-rata persetujuan</p>
                <div class="mt-3 bg-gray-200 rounded-full h-2">
                    <div class="bg-blue-500 h-2 rounded-full" style="width: {{ min(($performanceMetrics['avg_response_time'] / 24) * 100, 100) }}%"></div>
                </div>
            </div>

            <!-- User Satisfaction -->
            <div class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition-all duration-300 border border-teal-100">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-star text-yellow-600 text-xl"></i>
                    </div>
                    <span class="text-2xl font-bold text-yellow-600">{{ $performanceMetrics['user_satisfaction'] }}</span>
                </div>
                <h4 class="font-semibold text-gray-900 mb-1">Kepuasan Pengguna</h4>
                <p class="text-sm text-gray-600">Rating berdasarkan layanan</p>
                <div class="mt-3 bg-gray-200 rounded-full h-2">
                    <div class="bg-yellow-500 h-2 rounded-full" style="width: {{ ($performanceMetrics['user_satisfaction'] / 5) * 100 }}%"></div>
                </div>
            </div>

            <!-- System Uptime -->
            <div class="bg-white rounded-xl p-6 shadow-sm hover:shadow-md transition-all duration-300 border border-teal-100">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-server text-purple-600 text-xl"></i>
                    </div>
                    <span class="text-2xl font-bold text-purple-600">{{ $performanceMetrics['uptime'] }}%</span>
                </div>
                <h4 class="font-semibold text-gray-900 mb-1">Uptime Sistem</h4>
                <p class="text-sm text-gray-600">Ketersediaan layanan</p>
                <div class="mt-3 bg-gray-200 rounded-full h-2">
                    <div class="bg-purple-500 h-2 rounded-full" style="width: {{ $performanceMetrics['uptime'] }}%"></div>
                </div>
            </div>
        </div>
    </div>

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

        <!-- Recent Tests -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
            <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-indigo-50 to-indigo-100 rounded-t-xl">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-indigo-500 rounded-lg flex items-center justify-center">
                            <i class="fas fa-microscope text-white"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Pengujian Terbaru</h3>
                    </div>
                    <a href="{{ route('admin.pengajuan-pengujian.index') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-700 text-sm font-semibold hover:underline transition-all group">
                        <span>Lihat Semua</span>
                        <i class="fas fa-arrow-right ml-1 group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </div>
            <div class="p-6">
                @if($recentTests->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentTests as $test)
                            <div class="flex items-center justify-between p-4 bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl hover:from-indigo-50 hover:to-indigo-100 hover:shadow-md transition-all duration-300 border border-gray-200">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-indigo-500 rounded-full flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-flask text-white"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-semibold text-gray-900 line-clamp-1">{{ $test->layanan->nama ?? 'Pengujian' }}</p>
                                        <p class="text-sm text-gray-600 flex items-center">
                                            <i class="fas fa-user mr-1"></i>
                                            {{ $test->namaPengaju }}
                                            <i class="fas fa-calendar ml-2 mr-1"></i>
                                            {{ \Carbon\Carbon::parse($test->created_at)->format('d M Y') }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full
                                        @if($test->status === 'pending') bg-amber-100 text-amber-800 border border-amber-200
                                        @elseif($test->status === 'in_progress') bg-blue-100 text-blue-800 border border-blue-200
                                        @elseif($test->status === 'completed') bg-emerald-100 text-emerald-800 border border-emerald-200
                                        @elseif($test->status === 'cancelled') bg-red-100 text-red-800 border border-red-200
                                        @else bg-gray-100 text-gray-800 border border-gray-200
                                        @endif">
                                        @if($test->status === 'pending') Pending
                                        @elseif($test->status === 'in_progress') Diproses
                                        @elseif($test->status === 'completed') Selesai
                                        @elseif($test->status === 'cancelled') Dibatalkan
                                        @else {{ $test->status }}
                                        @endif
                                    </span>
                                    <a href="{{ route('admin.pengajuan-pengujian.show', $test->id) }}" 
                                       class="w-8 h-8 bg-indigo-500 hover:bg-indigo-600 rounded-lg flex items-center justify-center text-white hover:scale-110 transition-all duration-200">
                                        <i class="fas fa-eye text-sm"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-microscope text-gray-400 text-2xl"></i>
                        </div>
                        <p class="text-gray-500 font-medium">Belum ada pengujian</p>
                        <p class="text-gray-400 text-sm">Pengujian baru akan muncul di sini</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl shadow-lg border border-gray-200 p-8 hover:shadow-xl transition-all duration-300">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                    <i class="fas fa-bolt text-white text-xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Aksi Cepat</h3>
                    <p class="text-gray-600">Shortcut untuk tugas yang sering dilakukan</p>
                </div>
            </div>
            <div class="hidden md:flex items-center space-x-2 text-sm text-gray-500">
                <i class="fas fa-clock mr-1"></i>
                <span>Akses cepat</span>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('admin.articles.create') }}" 
               class="group flex items-center p-6 bg-white rounded-xl hover:shadow-lg transition-all duration-300 transform hover:-translate-y-2 border border-gray-200 hover:border-blue-300 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-500 to-blue-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>
                <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform shadow-lg">
                    <i class="fas fa-newspaper text-white text-lg"></i>
                </div>
                <div>
                    <span class="font-semibold text-gray-900 group-hover:text-blue-600 transition-colors block">Tambah Artikel</span>
                    <p class="text-xs text-gray-500 mt-1">Buat artikel atau berita baru</p>
                </div>
            </a>
            
            <a href="{{ route('admin.equipment.create') }}" 
               class="group flex items-center p-6 bg-white rounded-xl hover:shadow-lg transition-all duration-300 transform hover:-translate-y-2 border border-gray-200 hover:border-emerald-300 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-500 to-emerald-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>
                <div class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform shadow-lg">
                    <i class="fas fa-tools text-white text-lg"></i>
                </div>
                <div>
                    <span class="font-semibold text-gray-900 group-hover:text-emerald-600 transition-colors block">Tambah Alat</span>
                    <p class="text-xs text-gray-500 mt-1">Tambah peralatan laboratorium</p>
                </div>
            </a>
            
            <a href="{{ route('admin.staff.create') }}" 
               class="group flex items-center p-6 bg-white rounded-xl hover:shadow-lg transition-all duration-300 transform hover:-translate-y-2 border border-gray-200 hover:border-purple-300 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-purple-500 to-purple-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>
                <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform shadow-lg">
                    <i class="fas fa-user-plus text-white text-lg"></i>
                </div>
                <div>
                    <span class="font-semibold text-gray-900 group-hover:text-purple-600 transition-colors block">Tambah Staf</span>
                    <p class="text-xs text-gray-500 mt-1">Tambah anggota staff baru</p>
                </div>
            </a>
            
            <a href="{{ route('admin.layanan-pengujian.create') }}" 
               class="group flex items-center p-6 bg-white rounded-xl hover:shadow-lg transition-all duration-300 transform hover:-translate-y-2 border border-gray-200 hover:border-orange-300 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-orange-500 to-orange-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>
                <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform shadow-lg">
                    <i class="fas fa-flask text-white text-lg"></i>
                </div>
                <div>
                    <span class="font-semibold text-gray-900 group-hover:text-orange-600 transition-colors block">Layanan Pengujian</span>
                    <p class="text-xs text-gray-500 mt-1">Tambah jenis pengujian baru</p>
                </div>
            </a>
            
            <!-- Additional Quick Actions -->
            <a href="{{ route('admin.galeri.create') }}" 
               class="group flex items-center p-6 bg-white rounded-xl hover:shadow-lg transition-all duration-300 transform hover:-translate-y-2 border border-gray-200 hover:border-pink-300 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-pink-500 to-pink-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>
                <div class="w-14 h-14 bg-gradient-to-br from-pink-500 to-pink-600 rounded-xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform shadow-lg">
                    <i class="fas fa-images text-white text-lg"></i>
                </div>
                <div>
                    <span class="font-semibold text-gray-900 group-hover:text-pink-600 transition-colors block">Tambah Galeri</span>
                    <p class="text-xs text-gray-500 mt-1">Upload foto galeri baru</p>
                </div>
            </a>
            
            <a href="{{ route('admin.jadwal.index') }}" 
               class="group flex items-center p-6 bg-white rounded-xl hover:shadow-lg transition-all duration-300 transform hover:-translate-y-2 border border-gray-200 hover:border-indigo-300 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-indigo-500 to-indigo-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>
                <div class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform shadow-lg">
                    <i class="fas fa-calendar-alt text-white text-lg"></i>
                </div>
                <div>
                    <span class="font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors block">Kelola Jadwal</span>
                    <p class="text-xs text-gray-500 mt-1">Atur jadwal kunjungan</p>
                </div>
            </a>
            
            <a href="{{ route('admin.about.edit') }}" 
               class="group flex items-center p-6 bg-white rounded-xl hover:shadow-lg transition-all duration-300 transform hover:-translate-y-2 border border-gray-200 hover:border-teal-300 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-teal-500 to-teal-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>
                <div class="w-14 h-14 bg-gradient-to-br from-teal-500 to-teal-600 rounded-xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform shadow-lg">
                    <i class="fas fa-edit text-white text-lg"></i>
                </div>
                <div>
                    <span class="font-semibold text-gray-900 group-hover:text-teal-600 transition-colors block">Edit Profil Lab</span>
                    <p class="text-xs text-gray-500 mt-1">Perbarui profil laboratorium</p>
                </div>
            </a>
            
            <div class="group flex items-center p-6 bg-gradient-to-br from-gray-100 to-gray-200 rounded-xl border border-gray-300 relative overflow-hidden cursor-pointer hover:from-gray-200 hover:to-gray-300 transition-all duration-300">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-gray-400 to-gray-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>
                <div class="w-14 h-14 bg-gradient-to-br from-gray-400 to-gray-500 rounded-xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform shadow-lg">
                    <i class="fas fa-plus text-white text-lg"></i>
                </div>
                <div>
                    <span class="font-semibold text-gray-600 group-hover:text-gray-700 transition-colors block">Lebih Banyak</span>
                    <p class="text-xs text-gray-500 mt-1">Aksi lainnya tersedia</p>
                </div>
            </div>
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

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// Chart configurations and data
const chartColors = {
    primary: '#3B82F6',
    secondary: '#8B5CF6',
    success: '#10B981',
    warning: '#F59E0B',
    danger: '#EF4444',
    info: '#06B6D4',
    light: '#F8FAFC',
    dark: '#1E293B'
};

// Real data from backend
const realChartData = @json($chartData);

// Monthly Statistics Chart
let monthlyChart;
function initMonthlyChart() {
    const ctx = document.getElementById('monthlyChart').getContext('2d');
    
    const monthlyData = {
        loans: {
            labels: realChartData.months,
            data: realChartData.loans,
            color: chartColors.success
        },
        visits: {
            labels: realChartData.months,
            data: realChartData.visits,
            color: chartColors.warning
        },
        tests: {
            labels: realChartData.months,
            data: realChartData.tests,
            color: chartColors.info
        }
    };

    monthlyChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: monthlyData.loans.labels,
            datasets: [{
                label: 'Peminjaman',
                data: monthlyData.loans.data,
                borderColor: monthlyData.loans.color,
                backgroundColor: monthlyData.loans.color + '20',
                tension: 0.4,
                fill: true,
                pointBackgroundColor: monthlyData.loans.color,
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#F1F5F9'
                    },
                    ticks: {
                        color: '#64748B',
                        callback: function(value) {
                            return Number.isInteger(value) ? value : '';
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: '#64748B'
                    }
                }
            },
            elements: {
                point: {
                    hoverBackgroundColor: '#fff'
                }
            }
        }
    });
}

// Status Distribution Chart
let statusChart;
function initStatusChart() {
    const ctx = document.getElementById('statusChart').getContext('2d');
    
    const statusData = {
        loans: {
            labels: ['Pending', 'Disetujui', 'Ditolak', 'Dikembalikan'],
            data: [
                realChartData.loanStatus.pending,
                realChartData.loanStatus.approved,
                realChartData.loanStatus.rejected,
                realChartData.loanStatus.returned
            ],
            colors: [chartColors.warning, chartColors.success, chartColors.danger, chartColors.info]
        },
        visits: {
            labels: ['Pending', 'Disetujui', 'Selesai', 'Dibatalkan'],
            data: [
                realChartData.visitStatus.pending,
                realChartData.visitStatus.approved,
                realChartData.visitStatus.completed,
                realChartData.visitStatus.cancelled
            ],
            colors: [chartColors.warning, chartColors.primary, chartColors.success, chartColors.danger]
        },
        tests: {
            labels: ['Pending', 'Diproses', 'Selesai', 'Dibatalkan'],
            data: [
                realChartData.testStatus.pending,
                realChartData.testStatus.in_progress,
                realChartData.testStatus.completed,
                realChartData.testStatus.cancelled
            ],
            colors: [chartColors.warning, chartColors.info, chartColors.success, chartColors.danger]
        }
    };

    statusChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: statusData.loans.labels,
            datasets: [{
                data: statusData.loans.data,
                backgroundColor: statusData.loans.colors,
                borderWidth: 0,
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true,
                        color: '#64748B'
                    }
                }
            },
            cutout: '60%'
        }
    });
}

// Chart type change handlers
function updateMonthlyChart(type) {
    const monthlyData = {
        loans: {
            label: 'Peminjaman',
            data: realChartData.loans,
            color: chartColors.success
        },
        visits: {
            label: 'Kunjungan',
            data: realChartData.visits,
            color: chartColors.warning
        },
        tests: {
            label: 'Pengujian',
            data: realChartData.tests,
            color: chartColors.info
        }
    };

    const selectedData = monthlyData[type];
    monthlyChart.data.datasets[0].label = selectedData.label;
    monthlyChart.data.datasets[0].data = selectedData.data;
    monthlyChart.data.datasets[0].borderColor = selectedData.color;
    monthlyChart.data.datasets[0].backgroundColor = selectedData.color + '20';
    monthlyChart.data.datasets[0].pointBackgroundColor = selectedData.color;
    monthlyChart.update();
}

function updateStatusChart(type) {
    const statusData = {
        loans: {
            labels: ['Pending', 'Disetujui', 'Ditolak', 'Dikembalikan'],
            data: [
                realChartData.loanStatus.pending,
                realChartData.loanStatus.approved,
                realChartData.loanStatus.rejected,
                realChartData.loanStatus.returned
            ],
            colors: [chartColors.warning, chartColors.success, chartColors.danger, chartColors.info]
        },
        visits: {
            labels: ['Pending', 'Disetujui', 'Selesai', 'Dibatalkan'],
            data: [
                realChartData.visitStatus.pending,
                realChartData.visitStatus.approved,
                realChartData.visitStatus.completed,
                realChartData.visitStatus.cancelled
            ],
            colors: [chartColors.warning, chartColors.primary, chartColors.success, chartColors.danger]
        },
        tests: {
            labels: ['Pending', 'Diproses', 'Selesai', 'Dibatalkan'],
            data: [
                realChartData.testStatus.pending,
                realChartData.testStatus.in_progress,
                realChartData.testStatus.completed,
                realChartData.testStatus.cancelled
            ],
            colors: [chartColors.warning, chartColors.info, chartColors.success, chartColors.danger]
        }
    };

    const selectedData = statusData[type];
    statusChart.data.labels = selectedData.labels;
    statusChart.data.datasets[0].data = selectedData.data;
    statusChart.data.datasets[0].backgroundColor = selectedData.colors;
    statusChart.update();
}

// Initialize charts when page loads
document.addEventListener('DOMContentLoaded', function() {
    initMonthlyChart();
    initStatusChart();

    // Event listeners for chart type selectors
    document.getElementById('monthlyChartType').addEventListener('change', function() {
        updateMonthlyChart(this.value);
    });

    document.getElementById('statusChartType').addEventListener('change', function() {
        updateStatusChart(this.value);
    });

    // Add loading animation to charts
    const charts = document.querySelectorAll('canvas');
    charts.forEach(chart => {
        chart.style.opacity = '0';
        chart.style.transform = 'translateY(20px)';
        chart.style.transition = 'all 0.6s ease-out';
        
        setTimeout(() => {
            chart.style.opacity = '1';
            chart.style.transform = 'translateY(0)';
        }, 200);
    });
});

// Add smooth hover effects to stat cards
document.addEventListener('DOMContentLoaded', function() {
    const statCards = document.querySelectorAll('.group');
    statCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px) scale(1.02)';
            this.style.boxShadow = '0 25px 50px -12px rgba(0, 0, 0, 0.25)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = '';
            this.style.boxShadow = '';
        });
    });
});
</script>
@endsection 
 