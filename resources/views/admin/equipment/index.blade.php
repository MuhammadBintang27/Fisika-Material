@extends('admin.layouts.app')

@section('title', 'Manajemen Alat & Peralatan')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="bg-gradient-to-br from-blue-700 to-blue-800 rounded-xl p-8 text-white shadow-xl border border-blue-600">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold mb-2">Manajemen Alat & Peralatan</h1>
                <p class="text-blue-100 text-lg">Kelola alat dan peralatan laboratorium fisika</p>
            </div>
            <a href="{{ route('admin.equipment.create') }}" 
               class="bg-white text-blue-700 px-6 py-3 rounded-xl hover:bg-gray-50 transition-all duration-300 shadow-lg hover:shadow-xl flex items-center font-semibold group">
                <i class="fas fa-plus mr-2 group-hover:rotate-90 transition-transform"></i>
                <span>Tambah Alat</span>
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Total Alat</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $equipments->count() }}</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform shadow-lg">
                    <i class="fas fa-tools text-white text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Tersedia</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $equipments->sum('stok') - $equipments->sum('stok_dipinjam') - $equipments->sum('stok_rusak') }}</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform shadow-lg">
                    <i class="fas fa-check-circle text-white text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Dipinjam</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $equipments->sum('stok_dipinjam') }}</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform shadow-lg">
                    <i class="fas fa-handshake text-white text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Rusak</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $equipments->sum('stok_rusak') }}</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform shadow-lg">
                    <i class="fas fa-exclamation-triangle text-white text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Equipment List -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
        <div class="p-8">
            <div class="flex items-center space-x-3 mb-6">
                <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                    <i class="fas fa-list text-white"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900">Daftar Alat & Peralatan</h3>
            </div>
            @if($equipments->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    Alat
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    Stok Tersedia
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    Stok Dipinjam
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    Stok Rusak
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    Harga
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($equipments as $equipment)
                                <tr class="hover:bg-gradient-to-r hover:from-blue-50 hover:to-blue-100 transition-all duration-300 group">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            @if($equipment->gambar->first())
                                                <img src="{{ asset($equipment->gambar->first()->url) }}" 
                                                     alt="{{ $equipment->nama }}" 
                                                     class="w-16 h-16 rounded-xl object-cover mr-4 shadow-lg hover:shadow-xl transition-all duration-300 border-2 border-gray-200 group-hover:border-blue-300">
                                            @else
                                                <div class="w-16 h-16 bg-gradient-to-br from-blue-100 to-blue-200 rounded-xl flex items-center justify-center mr-4 shadow-lg hover:shadow-xl transition-all border-2 border-gray-200 group-hover:border-blue-300">
                                                    <i class="fas fa-tools text-blue-500 text-xl"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="text-lg font-bold text-gray-900 group-hover:text-blue-600 transition-colors">
                                                    {{ $equipment->nama }}
                                                </div>
                                                <div class="text-sm text-gray-600 line-clamp-1 mt-1">
                                                    {{ Str::limit($equipment->deskripsi, 60) }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-center">
                                            <span class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-bold bg-gradient-to-r from-emerald-100 to-emerald-200 text-emerald-800 border border-emerald-300">
                                                <i class="fas fa-check-circle mr-2"></i>{{ $equipment->stok - $equipment->stok_dipinjam - $equipment->stok_rusak }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-center">
                                            <span class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-bold bg-gradient-to-r from-amber-100 to-amber-200 text-amber-800 border border-amber-300">
                                                <i class="fas fa-handshake mr-2"></i>{{ $equipment->stok_dipinjam }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-center">
                                            <span class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-bold bg-gradient-to-r from-red-100 to-red-200 text-red-800 border border-red-300">
                                                <i class="fas fa-exclamation-triangle mr-2"></i>{{ $equipment->stok_rusak }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-center">
                                            <span class="text-lg font-bold text-blue-600">
                                                Rp {{ number_format($equipment->harga, 0, ',', '.') }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('admin.equipment.edit', $equipment->id) }}" 
                                               class="group/btn bg-blue-500 hover:bg-blue-600 text-white p-3 rounded-xl transition-all duration-300 hover:scale-110 shadow-lg hover:shadow-xl">
                                                <i class="fas fa-edit group-hover/btn:rotate-12 transition-transform"></i>
                                            </a>
                                            <form method="POST" action="{{ route('admin.equipment.destroy', $equipment->id) }}" 
                                                  class="inline" 
                                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus alat ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="group/btn bg-red-500 hover:bg-red-600 text-white p-3 rounded-xl transition-all duration-300 hover:scale-110 shadow-lg hover:shadow-xl">
                                                    <i class="fas fa-trash group-hover/btn:scale-110 transition-transform"></i>
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
                <div class="mt-8 flex justify-center">
                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                        {{ $equipments->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-16">
                    <div class="w-24 h-24 bg-gradient-to-br from-blue-100 to-blue-200 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                        <i class="fas fa-tools text-blue-400 text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Belum ada alat terdaftar</h3>
                    <p class="text-gray-600 mb-8 max-w-md mx-auto text-lg">Mulai dengan menambahkan alat pertama Anda untuk mengelola inventaris laboratorium</p>
                    <a href="{{ route('admin.equipment.create') }}" 
                       class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-8 py-4 rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-300 shadow-lg hover:shadow-xl inline-flex items-center group">
                        <i class="fas fa-plus mr-3 group-hover:rotate-90 transition-transform"></i>
                        <span class="font-semibold">Tambah Alat Pertama</span>
                    </a>
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
 