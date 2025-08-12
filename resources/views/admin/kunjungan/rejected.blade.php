@extends('admin.layouts.app')

@section('title', 'Kunjungan Ditolak')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-gradient-to-r from-red-500 to-red-600 rounded-xl shadow-lg text-white p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Kunjungan Ditolak</h1>
                <p class="text-red-100">Kelola permintaan kunjungan laboratorium yang ditolak</p>
            </div>
            <div class="text-right">
                <div class="text-2xl font-bold">{{ $kunjungan->total() }}</div>
                <div class="text-red-100">Total Kunjungan</div>
            </div>
        </div>
    </div>

    <!-- Status Navigation -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <div class="flex items-center space-x-2 overflow-x-auto">
            <a href="{{ route('admin.kunjungan.index') }}" 
               class="px-6 py-3 rounded-xl font-semibold transition-all duration-300 whitespace-nowrap text-gray-600 hover:bg-gray-100">
                <i class="fas fa-list mr-2"></i>Semua
            </a>
            <a href="{{ route('admin.kunjungan.pending') }}" 
               class="px-6 py-3 rounded-xl font-semibold transition-all duration-300 whitespace-nowrap text-gray-600 hover:bg-gray-100">
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
               class="px-6 py-3 rounded-xl font-semibold transition-all duration-300 whitespace-nowrap bg-gradient-to-r from-red-500 to-red-600 text-white shadow-lg">
                <i class="fas fa-times-circle mr-2"></i>Ditolak
            </a>
        </div>
    </div>
                Disetujui
            </a>
            <a href="{{ route('admin.kunjungan.completed') }}" 
               class="px-4 py-2 rounded-lg font-medium text-gray-600 hover:bg-gray-100">
        </div>
    </div>

    <!-- Visits List -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100">
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
                                <tr class="hover:bg-red-50 transition-colors duration-200">
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $visit->tracking_code }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-full bg-gradient-to-r from-red-500 to-red-600 flex items-center justify-center">
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
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                            DITOLAK
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium">
                                        <div class="flex items-center space-x-3">
                                            <a href="{{ route('admin.kunjungan.show', $visit->id) }}" 
                                               class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                                                <i class="fas fa-eye mr-1"></i>Detail
                                            </a>
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
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection