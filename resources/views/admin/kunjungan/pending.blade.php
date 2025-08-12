@extends('admin.layouts.app')

@section('title', 'Kunjungan Pending')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="bg-gradient-to-br from-amber-600 to-amber-700 rounded-xl p-8 text-white shadow-xl border border-amber-500">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold mb-2">Kunjungan Pending</h1>
                <p class="text-amber-100 text-lg">Kelola permintaan kunjungan laboratorium yang menunggu persetujuan</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.kunjungan.approved') }}" 
                   class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl font-semibold group">
                    <i class="fas fa-check-circle mr-2 group-hover:animate-pulse"></i>
                    Disetujui ({{ \App\Models\Kunjungan::where('status', 'APPROVED')->count() }})
                </a>
            </div>
        </div>
    </div>

    <!-- Search Form -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-8">
        <div class="flex items-center space-x-3 mb-6">
            <div class="w-10 h-10 bg-amber-500 rounded-lg flex items-center justify-center">
                <i class="fas fa-search text-white"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900">Pencarian Kunjungan</h3>
        </div>
        <form method="GET" action="{{ route('admin.kunjungan.pending') }}" class="flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-4">
            <div class="flex-1 w-full">
                <input type="text" name="search" 
                       value="{{ request()->input('search') }}"
                       placeholder="Cari berdasarkan nama pengunjung, instansi, atau kode tracking..."
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all">
            </div>
            <button type="submit" 
                    class="bg-gradient-to-r from-amber-600 to-amber-700 text-white px-6 py-3 rounded-xl hover:from-amber-700 hover:to-amber-800 transition-all duration-300 shadow-lg font-semibold">
                <i class="fas fa-search mr-2"></i>Cari
            </button>
        </form>
    </div>

    <!-- Status Filter -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <div class="flex items-center space-x-2 overflow-x-auto">
            <a href="{{ route('admin.kunjungan.index') }}" 
               class="px-6 py-3 rounded-xl font-semibold transition-all duration-300 whitespace-nowrap text-gray-600 hover:bg-gray-100">
                <i class="fas fa-list mr-2"></i>Semua
            </a>
            <a href="{{ route('admin.kunjungan.pending') }}" 
               class="px-6 py-3 rounded-xl font-semibold transition-all duration-300 whitespace-nowrap bg-gradient-to-r from-amber-500 to-amber-600 text-white shadow-lg">
                <i class="fas fa-clock mr-2"></i>Pending
            </a>
            <a href="{{ route('admin.kunjungan.approved') }}" 
               class="px-6 py-3 rounded-xl font-semibold transition-all duration-300 whitespace-nowrap text-gray-600 hover:bg-gray-100">
                <i class="fas fa-check-circle mr-2"></i>Disetujui
            </a>
            <a href="{{ route('admin.kunjungan.completed') }}" 
               class="px-6 py-3 rounded-xl font-semibold transition-all duration-300 whitespace-nowrap text-gray-600 hover:bg-gray-100">
                <i class="fas fa-check-double mr-2"></i>Selesai
            </a>
            <a href="{{ route('admin.kunjungan.rejected') }}" 
               class="px-6 py-3 rounded-xl font-semibold transition-all duration-300 whitespace-nowrap text-gray-600 hover:bg-gray-100">
                <i class="fas fa-times-circle mr-2"></i>Ditolak
            </a>
        </div>
    </div>

    <!-- Visits List -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-gray-900">Daftar Kunjungan Pending</h3>
                <span class="text-sm text-gray-500">{{ $kunjungan->total() }} total kunjungan</span>
            </div>
            
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
                                <tr class="hover:bg-amber-50 transition-colors duration-200">
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $visit->tracking_code }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-full bg-gradient-to-r from-amber-500 to-amber-600 flex items-center justify-center">
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
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-amber-100 text-amber-800">
                                            PENDING
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium">
                                        <div class="flex items-center space-x-3">
                                            <a href="{{ route('admin.kunjungan.show', $visit->id) }}" 
                                               class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-colors">
                                                <i class="fas fa-eye mr-1"></i>
                                                Detail
                                            </a>
                                            <form method="POST" action="{{ route('admin.kunjungan.approved', $visit->id) }}" class="inline">
                                                @csrf
                                                <button type="submit" 
                                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                                                    <i class="fas fa-check mr-1"></i>
                                                    Setujui
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.kunjungan.rejected', $visit->id) }}" class="inline">
                                                @csrf
                                                <button type="submit" 
                                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                                                    <i class="fas fa-times mr-1"></i>
                                                    Tolak
                                                </button>
                                            </form>
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
                <div class="text-center py-12">
                    <div class="mx-auto h-12 w-12 text-gray-400">
                        <i class="fas fa-clock text-4xl"></i>
                    </div>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada kunjungan pending</h3>
                    <p class="mt-1 text-sm text-gray-500">Belum ada permintaan kunjungan yang menunggu persetujuan</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection