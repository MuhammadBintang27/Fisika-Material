@extends('admin.layouts.app')

@section('title', 'Manajemen Kunjungan')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="bg-gradient-to-br from-blue-700 to-blue-800 rounded-xl p-8 text-white shadow-xl border border-blue-600">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold mb-2">Manajemen Kunjungan</h1>
                <p class="text-blue-100 text-lg">Kelola permintaan kunjungan laboratorium</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.kunjungan.pending') }}" 
                   class="bg-amber-500 hover:bg-amber-600 text-white px-6 py-3 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl font-semibold group">
                    <i class="fas fa-clock mr-2 group-hover:animate-pulse"></i>
                    Pending ({{ \App\Models\Kunjungan::where('status', 'PENDING')->count() }})
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Total Kunjungan</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $kunjungan->total() }}</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform shadow-lg">
                    <i class="fas fa-users text-white text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Pending</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ \App\Models\Kunjungan::where('status', 'PENDING')->count() }}</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform shadow-lg">
                    <i class="fas fa-clock text-white text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Disetujui</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ \App\Models\Kunjungan::where('status', 'APPROVED')->count() }}</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform shadow-lg">
                    <i class="fas fa-check-circle text-white text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Selesai</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ \App\Models\Kunjungan::where('status', 'COMPLETED')->count() }}</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform shadow-lg">
                    <i class="fas fa-check-double text-white text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Form -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-8">
        <div class="flex items-center space-x-3 mb-6">
            <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                <i class="fas fa-search text-white"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900">Pencarian Kunjungan</h3>
        </div>
        <form method="GET" action="{{ route('admin.kunjungan.index') }}" class="flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-4">
            <div class="flex-1 w-full">
                <input type="text" name="search" 
                       value="{{ request()->input('search') }}"
                       placeholder="Cari berdasarkan nama pengunjung, instansi, atau kode tracking..."
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
            </div>
            <button type="submit" 
                    class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-3 rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-300 shadow-lg font-semibold">
                <i class="fas fa-search mr-2"></i>Cari
            </button>
        </form>
    </div>

    <!-- Status Filter -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <div class="flex items-center space-x-2 overflow-x-auto">
            <a href="{{ route('admin.kunjungan.index') }}" 
               class="px-6 py-3 rounded-xl font-semibold transition-all duration-300 whitespace-nowrap {{ request()->routeIs('admin.kunjungan.index') ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-lg' : 'text-gray-600 hover:bg-gray-100' }}">
                <i class="fas fa-list mr-2"></i>Semua
            </a>
            <a href="{{ route('admin.kunjungan.pending') }}" 
               class="px-6 py-3 rounded-xl font-semibold transition-all duration-300 whitespace-nowrap {{ request()->routeIs('admin.kunjungan.pending') ? 'bg-gradient-to-r from-amber-500 to-amber-600 text-white shadow-lg' : 'text-gray-600 hover:bg-gray-100' }}">
                <i class="fas fa-clock mr-2"></i>Pending
            </a>
            <a href="{{ route('admin.kunjungan.approved') }}" 
               class="px-6 py-3 rounded-xl font-semibold transition-all duration-300 whitespace-nowrap {{ request()->routeIs('admin.kunjungan.approved') ? 'bg-gradient-to-r from-green-500 to-green-600 text-white shadow-lg' : 'text-gray-600 hover:bg-gray-100' }}">
                <i class="fas fa-check-circle mr-2"></i>Disetujui
            </a>
            <a href="{{ route('admin.kunjungan.completed') }}" 
               class="px-6 py-3 rounded-xl font-semibold transition-all duration-300 whitespace-nowrap {{ request()->routeIs('admin.kunjungan.completed') ? 'bg-gradient-to-r from-indigo-500 to-indigo-600 text-white shadow-lg' : 'text-gray-600 hover:bg-gray-100' }}">
                <i class="fas fa-check-double mr-2"></i>Selesai
            </a>
            <a href="{{ route('admin.kunjungan.rejected') }}" 
               class="px-6 py-3 rounded-xl font-semibold transition-all duration-300 whitespace-nowrap {{ request()->routeIs('admin.kunjungan.rejected') ? 'bg-gradient-to-r from-red-500 to-red-600 text-white shadow-lg' : 'text-gray-600 hover:bg-gray-100' }}">
                <i class="fas fa-times-circle mr-2"></i>Ditolak
            </a>
        </div>
    </div>

    <!-- Visits List -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 hover:shadow-xl transition-all duration-300">
        <div class="p-6">
            @if($kunjungan->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Tracking</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Pengunjung</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Instansi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jadwal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($kunjungan as $visit)
                                <tr class="hover:bg-blue-50 transition-colors duration-200">
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $visit->tracking_code }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-full bg-gradient-to-r from-blue-500 to-blue-600 flex items-center justify-center">
                                                    <span class="text-sm font-medium text-white">{{ substr($visit->namaPengunjung, 0, 1) }}</span>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $visit->namaPengunjung }}</div>
                                                <div class="text-sm text-gray-500">{{ $visit->noHp }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">{{ $visit->namaInstansi }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">
                                            {{ $visit->jadwal ? \Carbon\Carbon::parse($visit->jadwal->tanggal)->format('d M Y') : 'Belum dijadwalkan' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">
                                            {{ $visit->jadwal ? $visit->jadwal->time_label : 'Belum dijadwalkan' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($visit->status === 'PENDING')
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-amber-100 text-amber-800">
                                                PENDING
                                            </span>
                                        @elseif($visit->status === 'APPROVED')
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                DISETUJUI
                                            </span>
                                        @elseif($visit->status === 'COMPLETED')
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                                SELESAI
                                            </span>
                                        @elseif($visit->status === 'CANCELLED')
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                DITOLAK
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium">
                                        <div class="flex items-center space-x-3">
                                            <a href="{{ route('admin.kunjungan.show', $visit->id) }}" 
                                               class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                                <i class="fas fa-eye mr-1"></i>
                                                Detail
                                            </a>
                                            
                                            <form method="POST" action="{{ route('admin.kunjungan.destroy', $visit->id) }}" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data kunjungan ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                                                    <i class="fas fa-trash mr-1"></i>
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
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