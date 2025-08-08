@extends('admin.layouts.app')

@section('title', 'Kunjungan Pending')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Kunjungan Pending</h1>
            <p class="text-gray-600">Kelola permintaan kunjungan laboratorium yang masih menunggu persetujuan</p>
        </div>
        <div class="flex items-center space-x-2">
            <a href="{{ route('admin.kunjungan.pending') }}" 
               class="bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700 transition-colors">
                <i class="fas fa-clock mr-2"></i>
                Pending ({{ \App\Models\Kunjungan::where('status', 'PENDING')->count() }})
            </a>
        </div>
    </div>

    <!-- Search Form -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 hover:shadow-xl transition-all duration-300 p-4">
        <form method="GET" action="{{ route('admin.kunjungan.pending') }}" class="flex items-center space-x-4">
            <div class="flex-1">
                <input type="text" name="search" 
                       value="{{ request()->input('search') }}"
                       placeholder="Cari berdasarkan nama pengunjung, instansi, atau kode tracking..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
            </div>
            <button type="submit" 
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                <i class="fas fa-search mr-2"></i>Cari
            </button>
        </form>
    </div>

    <!-- Status Filter -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 hover:shadow-xl transition-all duration-300 p-4">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.kunjungan.index') }}" 
               class="px-4 py-2 rounded-lg font-medium text-gray-600 hover:bg-gray-100">
                Semua
            </a>
            <a href="{{ route('admin.kunjungan.pending') }}" 
               class="px-4 py-2 rounded-lg font-medium bg-yellow-100 text-yellow-700">
                Pending
            </a>
            <a href="{{ route('admin.kunjungan.approved') }}" 
               class="px-4 py-2 rounded-lg font-medium text-gray-600 hover:bg-gray-100">
                Disetujui
            </a>
            <a href="{{ route('admin.kunjungan.completed') }}" 
               class="px-4 py-2 rounded-lg font-medium text-gray-600 hover:bg-gray-100">
                Selesai
            </a>
            <a href="{{ route('admin.kunjungan.rejected') }}" 
               class="px-4 py-2 rounded-lg font-medium text-gray-600 hover:bg-gray-100">
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
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Tracking</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Pengunjung</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Instansi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Kunjungan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jadwal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($kunjungan as $visit)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $visit->tracking_code }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $visit->namaPengunjung }}</div>
                                            <div class="text-sm text-gray-500">{{ $visit->noHp }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">{{ $visit->namaInstansi }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">
                                            <div>{{ \Carbon\Carbon::parse($visit->jadwal->tanggal)->format('d M Y') }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">
                                            <div>{{ $visit->jadwal->jam_mulai }} - {{ $visit->jadwal->jam_selesai }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-700">{{ $visit->status_label }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('admin.kunjungan.show', $visit->id) }}" 
                                               class="text-blue-600 hover:text-blue-900">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <form method="POST" action="{{ route('admin.kunjungan.destroy', $visit->id) }}" 
                                                  class="inline" 
                                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus data kunjungan ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
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
                <div class="text-center py-12">
                    <i class="fas fa-handshake text-gray-400 text-4xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada kunjungan</h3>
                    <p class="text-gray-500">Belum ada permintaan kunjungan laboratorium</p>
                </div>
            @endif
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