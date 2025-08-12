@extends('admin.layouts.app')

@section('title', 'Manajemen Pengajuan Pengujian')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="bg-gradient-to-br from-blue-700 to-blue-800 rounded-xl p-8 text-white shadow-xl border border-blue-600">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold mb-2">Manajemen Pengajuan Pengujian</h1>
                <p class="text-blue-100 text-lg">Kelola semua pengajuan pengujian yang masuk</p>
            </div>
            <div class="flex items-center space-x-3">
                <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4 flex items-center space-x-2">
                    <i class="fas fa-clipboard-list text-2xl"></i>
                    <span class="text-lg font-semibold">{{ $pengajuan->total() }} Pengajuan</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Menunggu</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['menunggu'] ?? 0 }}</p>
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
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['disetujui'] ?? 0 }}</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform shadow-lg">
                    <i class="fas fa-check-circle text-white text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Diproses</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['diproses'] ?? 0 }}</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform shadow-lg">
                    <i class="fas fa-cogs text-white text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Selesai</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['selesai'] ?? 0 }}</p>
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
            <h3 class="text-xl font-bold text-gray-900">Filter & Pencarian</h3>
        </div>
        
        <form method="GET" action="{{ route('admin.pengajuan-pengujian.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-3">Pencarian</label>
                <input type="text" name="search" id="search" 
                       value="{{ request('search') }}"
                       placeholder="Nama, kode tracking, atau layanan..."
                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-all duration-200">
            </div>
            
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-3">Status</label>
                <select name="status" id="status" 
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-all duration-200">
                    <option value="">Semua Status</option>
                    <option value="MENUNGGU" {{ request('status') == 'MENUNGGU' ? 'selected' : '' }}>Menunggu</option>
                    <option value="DISETUJUI" {{ request('status') == 'DISETUJUI' ? 'selected' : '' }}>Disetujui</option>
                    <option value="DIPROSES" {{ request('status') == 'DIPROSES' ? 'selected' : '' }}>Diproses</option>
                    <option value="SELESAI" {{ request('status') == 'SELESAI' ? 'selected' : '' }}>Selesai</option>
                    <option value="DITOLAK" {{ request('status') == 'DITOLAK' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>

            <div>
                <label for="layanan" class="block text-sm font-medium text-gray-700 mb-3">Layanan</label>
                <select name="layanan" id="layanan" 
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-all duration-200">
                    <option value="">Semua Layanan</option>
                    @foreach($layananList as $layanan)
                        <option value="{{ $layanan->id }}" {{ request('layanan') == $layanan->id ? 'selected' : '' }}>
                            {{ $layanan->namaLayanan }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-3">Aksi</label>
                <div class="flex space-x-3">
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl font-semibold group flex-1">
                        <i class="fas fa-search mr-2 group-hover:animate-pulse"></i>
                        Cari
                    </button>
                    <a href="{{ route('admin.pengajuan-pengujian.index') }}" 
                       class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-3 rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl font-semibold">
                        <i class="fas fa-refresh"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                    <i class="fas fa-table text-white"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900">Daftar Pengajuan Pengujian</h3>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Pengajuan
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tracking Code
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Layanan
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Sampel
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tanggal
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($pengajuan as $item)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-full bg-orange-100 flex items-center justify-center">
                                                    <i class="fas fa-user text-orange-600"></i>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $item->namaPengaju }}</div>
                                                <div class="text-sm text-gray-500">{{ $item->nip_nim ?? 'No ID' }}</div>
                                                <div class="text-sm text-gray-500">{{ $item->noHp }}</div>
                                                @if($item->instansi)
                                                    <div class="text-xs text-gray-400">{{ $item->instansi }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-mono font-bold text-blue-600">{{ $item->trackingCode }}</div>
                                        <div class="text-xs text-gray-500">{{ $item->getUserTypeLabelAttribute() }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $item->layanan->namaLayanan }}</div>
                                        @if($item->layanan->harga)
                                            <div class="text-sm text-gray-500">Rp {{ number_format($item->layanan->harga, 0, ',', '.') }}</div>
                                        @else
                                            <div class="text-sm text-green-600">Gratis</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $item->jumlahSampel }} sampel</div>
                                        <div class="text-xs text-gray-500">{{ Str::limit($item->deskripsiSampel, 30) }}</div>
                                        @if($item->filePendukung)
                                            <div class="text-xs text-blue-600 mt-1">
                                                <i class="fas fa-paperclip mr-1"></i>File tersedia
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($item->status == 'MENUNGGU')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                <i class="fas fa-clock mr-1"></i>
                                                Menunggu
                                            </span>
                                        @elseif($item->status == 'DISETUJUI')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                <i class="fas fa-check mr-1"></i>
                                                Disetujui
                                            </span>
                                        @elseif($item->status == 'DIPROSES')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                                <i class="fas fa-cog mr-1"></i>
                                                Diproses
                                            </span>
                                        @elseif($item->status == 'SELESAI')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <i class="fas fa-flag-checkered mr-1"></i>
                                                Selesai
                                            </span>
                                        @elseif($item->status == 'DITOLAK')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                <i class="fas fa-times mr-1"></i>
                                                Ditolak
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <div>{{ $item->created_at->format('d/m/Y') }}</div>
                                        <div class="text-xs">{{ $item->created_at->format('H:i') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-2">
                                            <a href="{{ route('admin.pengajuan-pengujian.show', $item->id) }}" 
                                               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl font-semibold group">
                                                <i class="fas fa-eye mr-2 group-hover:scale-110 transition-transform"></i>
                                                Detail
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center">
                                        <div class="text-gray-500">
                                            <i class="fas fa-inbox text-4xl mb-4"></i>
                                            <p class="text-lg font-medium">Tidak ada pengajuan</p>
                                            <p>Belum ada pengajuan pengujian yang masuk</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($pengajuan->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $pengajuan->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
    </div>
@endsection
