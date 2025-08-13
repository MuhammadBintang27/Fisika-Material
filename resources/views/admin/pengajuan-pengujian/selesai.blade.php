@extends('admin.layouts.app')

@section('title', 'Pengajuan Selesai')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-xl shadow-lg text-white p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Pengajuan Selesai</h1>
                <p class="text-indigo-100">Kelola pengajuan pengujian yang telah selesai</p>
            </div>
            <div class="text-right">
                <div class="text-2xl font-bold">{{ $pengajuan->total() }}</div>
                <div class="text-indigo-100">Total Pengajuan</div>
            </div>
        </div>
    </div>

    <!-- Search Form -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-8">
        <div class="flex items-center space-x-3 mb-6">
            <div class="w-10 h-10 bg-indigo-500 rounded-lg flex items-center justify-center">
                <i class="fas fa-search text-white"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900">Pencarian Pengajuan</h3>
        </div>
        <form method="GET" action="{{ route('admin.pengajuan-pengujian.selesai') }}" class="flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-4">
            <div class="flex-1 w-full">
                <input type="text" name="search" 
                       value="{{ request('search') }}"
                       placeholder="Cari berdasarkan nama, kode tracking, atau layanan..."
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
            </div>
            <button type="submit" 
                    class="bg-gradient-to-r from-indigo-600 to-indigo-700 text-white px-6 py-3 rounded-xl hover:from-indigo-700 hover:to-indigo-800 transition-all duration-300 shadow-lg font-semibold">
                <i class="fas fa-search mr-2"></i>Cari
            </button>
        </form>
    </div>

    <!-- Status Filter -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <div class="flex items-center space-x-2 overflow-x-auto">
            <a href="{{ route('admin.pengajuan-pengujian.index') }}" 
               class="px-6 py-3 rounded-xl font-semibold transition-all duration-300 whitespace-nowrap text-gray-600 hover:bg-gray-100">
                <i class="fas fa-list mr-2"></i>Semua
            </a>
            <a href="{{ route('admin.pengajuan-pengujian.menunggu') }}" 
               class="px-6 py-3 rounded-xl font-semibold transition-all duration-300 whitespace-nowrap text-gray-600 hover:bg-gray-100">
                <i class="fas fa-clock mr-2"></i>Menunggu
            </a>
            <a href="{{ route('admin.pengajuan-pengujian.disetujui') }}" 
               class="px-6 py-3 rounded-xl font-semibold transition-all duration-300 whitespace-nowrap text-gray-600 hover:bg-gray-100">
                <i class="fas fa-check-circle mr-2"></i>Disetujui
            </a>
            <a href="{{ route('admin.pengajuan-pengujian.diproses') }}" 
               class="px-6 py-3 rounded-xl font-semibold transition-all duration-300 whitespace-nowrap text-gray-600 hover:bg-gray-100">
                <i class="fas fa-cogs mr-2"></i>Diproses
            </a>
            <a href="{{ route('admin.pengajuan-pengujian.selesai') }}" 
               class="px-6 py-3 rounded-xl font-semibold transition-all duration-300 whitespace-nowrap bg-gradient-to-r from-indigo-500 to-indigo-600 text-white shadow-lg">
                <i class="fas fa-check-double mr-2"></i>Selesai
            </a>
            <a href="{{ route('admin.pengajuan-pengujian.ditolak') }}" 
               class="px-6 py-3 rounded-xl font-semibold transition-all duration-300 whitespace-nowrap text-gray-600 hover:bg-gray-100">
                <i class="fas fa-times-circle mr-2"></i>Ditolak
            </a>
        </div>
    </div>

    <!-- Pengajuan List -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 hover:shadow-xl transition-all duration-300">
        <div class="p-6">
            @if($pengajuan->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Tracking</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Pengaju</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Layanan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Selesai</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($pengajuan as $item)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $item->trackingCode }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $item->namaPengaju }}</div>
                                        <div class="text-sm text-gray-500">{{ $item->instansi }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $item->layanan->namaLayanan }}</div>
                                        <div class="text-sm text-gray-500">{{ $item->jumlahSampel }} sampel</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $item->tanggalSelesai ? \Carbon\Carbon::parse($item->tanggalSelesai)->format('d M Y') : '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                            SELESAI
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center space-x-3">
                                            <a href="{{ route('admin.pengajuan-pengujian.show', $item->id) }}" 
                                               class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
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
                    {{ $pengajuan->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-check-double text-gray-400 text-4xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada pengajuan selesai</h3>
                    <p class="text-gray-500">Belum ada pengajuan pengujian yang selesai</p>
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
