@extends('admin.layouts.app')

@section('title', 'Manajemen Kunjungan')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Manajemen Kunjungan</h1>
            <p class="text-gray-600">Kelola permintaan kunjungan laboratorium</p>
        </div>
        <div class="flex items-center space-x-2">
            <a href="{{ route('admin.kunjungan.pending') }}" 
               class="bg-gradient-to-r from-yellow-600 to-yellow-700 text-white px-6 py-3 rounded-lg hover:from-yellow-700 hover:to-yellow-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center">
                <i class="fas fa-clock mr-2"></i>
                Pending ({{ \App\Models\Kunjungan::where('status', 'PENDING')->count() }})
            </a>
        </div>
    </div>

    <!-- Search Form -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 hover:shadow-xl transition-all duration-300 p-6">
        <form method="GET" action="{{ route('admin.kunjungan.index') }}" class="flex items-center space-x-4">
            <div class="flex-1">
                <input type="text" name="search" 
                       value="{{ request()->input('search') }}"
                       placeholder="Cari berdasarkan nama pengunjung, instansi, atau kode tracking..."
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 hover:border-blue-400">
            </div>
            <button type="submit" 
                    class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-3 rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center">
                <i class="fas fa-search mr-2"></i>Cari
            </button>
        </form>
    </div>

    <!-- Status Filter -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 hover:shadow-xl transition-all duration-300 p-6">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.kunjungan.index') }}" 
               class="px-4 py-2 rounded-lg font-semibold transition-all duration-200 {{ request()->routeIs('admin.kunjungan.index') ? 'bg-gradient-to-r from-blue-100 to-blue-200 text-blue-700 shadow-md' : 'text-gray-600 hover:bg-gray-100 hover:shadow-md' }}">
                Semua
            </a>
            <a href="{{ route('admin.kunjungan.pending') }}" 
               class="px-4 py-2 rounded-lg font-semibold transition-all duration-200 {{ request()->routeIs('admin.kunjungan.pending') ? 'bg-gradient-to-r from-yellow-100 to-yellow-200 text-yellow-700 shadow-md' : 'text-gray-600 hover:bg-gray-100 hover:shadow-md' }}">
                Pending
            </a>
            <a href="{{ route('admin.kunjungan.approved') }}" 
               class="px-4 py-2 rounded-lg font-semibold transition-all duration-200 {{ request()->routeIs('admin.kunjungan.approved') ? 'bg-gradient-to-r from-green-100 to-green-200 text-green-700 shadow-md' : 'text-gray-600 hover:bg-gray-100 hover:shadow-md' }}">
                Disetujui
            </a>
            <a href="{{ route('admin.kunjungan.completed') }}" 
               class="px-4 py-2 rounded-lg font-semibold transition-all duration-200 {{ request()->routeIs('admin.kunjungan.completed') ? 'bg-gradient-to-r from-gray-100 to-gray-200 text-gray-700 shadow-md' : 'text-gray-600 hover:bg-gray-100 hover:shadow-md' }}">
                Selesai
            </a>
            <a href="{{ route('admin.kunjungan.rejected') }}" 
               class="px-4 py-2 rounded-lg font-semibold transition-all duration-200 {{ request()->routeIs('admin.kunjungan.rejected') ? 'bg-gradient-to-r from-red-100 to-red-200 text-red-700 shadow-md' : 'text-gray-600 hover:bg-gray-100 hover:shadow-md' }}">
                Ditolak
            </a>
        </div>
    </div>

    <!-- Visits List -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 hover:shadow-xl transition-all duration-300">
        <div class="p-6">
            @if($kunjungan->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kode Tracking</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama Pengunjung</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Instansi</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal Kunjungan</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Jadwal</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($kunjungan as $visit)
                                <tr class="hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 transition-all duration-200 transform hover:scale-[1.01]">
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-semibold text-gray-900 hover:text-blue-600 transition-colors">{{ $visit->tracking_code }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div>
                                            <div class="text-sm font-semibold text-gray-900 hover:text-blue-600 transition-colors">{{ $visit->namaPengunjung }}</div>
                                            <div class="text-xs text-gray-500">{{ $visit->noHp }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">{{ $visit->namaInstansi }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">
                                            <div>{{ $visit->jadwal ? \Carbon\Carbon::parse($visit->jadwal->tanggal)->format('d M Y') : 'Tidak ada jadwal' }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">
                                            @if($visit->jadwal)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    {{ $visit->jadwal->jamMulai }} - {{ $visit->jadwal->jamSelesai }}
                                                </span>
                                            @else
                                                <span class="text-gray-500">-</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($visit->status === 'PENDING')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                Pending
                                            </span>
                                        @elseif($visit->status === 'APPROVED')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Disetujui
                                            </span>
                                        @elseif($visit->status === 'COMPLETED')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                Selesai
                                            </span>
                                        @elseif($visit->status === 'REJECTED')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                Ditolak
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center space-x-3">
                                            <a href="{{ route('admin.kunjungan.show', $visit->id) }}" 
                                               class="text-blue-600 hover:text-blue-900 hover:scale-110 transition-all duration-200 p-2 rounded-full hover:bg-blue-50">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if($visit->status === 'PENDING')
                                                <form method="POST" action="{{ route('admin.kunjungan.approved', $visit->id) }}" class="inline">
                                                    @csrf
                                                    <button type="submit" 
                                                            class="text-green-600 hover:text-green-900 hover:scale-110 transition-all duration-200 p-2 rounded-full hover:bg-green-50">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                                <form method="POST" action="{{ route('admin.kunjungan.rejected', $visit->id) }}" class="inline">
                                                    @csrf
                                                    <button type="submit" 
                                                            class="text-red-600 hover:text-red-900 hover:scale-110 transition-all duration-200 p-2 rounded-full hover:bg-red-50">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="mt-6">
                    {{ $kunjungan->links() }}
                </div>
            @else
                <div class="text-center py-16">
                    <div class="w-24 h-24 bg-gradient-to-br from-gray-200 to-gray-300 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-users text-gray-400 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Belum ada kunjungan</h3>
                    <p class="text-gray-500 mb-8 max-w-md mx-auto">Belum ada permintaan kunjungan yang masuk</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection