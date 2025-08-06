@extends('admin.layouts.app')

@section('title', 'Manajemen Alat & Peralatan')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Manajemen Alat & Peralatan</h1>
            <p class="text-gray-600">Kelola alat dan peralatan laboratorium</p>
        </div>
        <a href="{{ route('admin.equipment.create') }}" 
           class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
            <i class="fas fa-plus mr-2"></i>
            Tambah Alat
        </a>
    </div>

    <!-- Equipment List -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-6">
            @if($equipments->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Alat
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Stok Tersedia
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Stok Dipinjam
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Stok Rusak
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Harga
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($equipments as $equipment)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            @if($equipment->gambar->first())
                                                <img src="{{ asset($equipment->gambar->first()->url) }}" 
                                                     alt="{{ $equipment->nama }}" 
                                                     class="w-12 h-12 rounded-lg object-cover mr-4">
                                            @else
                                                <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center mr-4">
                                                    <i class="fas fa-tools text-gray-400"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $equipment->nama }}
                                                </div>
                                                <div class="text-sm text-gray-500 line-clamp-1">
                                                    {{ Str::limit($equipment->deskripsi, 50) }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">
                                            {{ $equipment->stok }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">
                                            {{ $equipment->stok_dipinjam ?? 0 }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">
                                            {{ $equipment->stok_rusak ?? 0 }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">
                                            @if($equipment->harga)
                                                Rp {{ number_format($equipment->harga, 0, ',', '.') }}
                                            @else
                                                -
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('admin.equipment.edit', $equipment->id) }}" 
                                               class="text-blue-600 hover:text-blue-900">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form method="POST" action="{{ route('admin.equipment.destroy', $equipment->id) }}" 
                                                  class="inline" 
                                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus alat ini?')">
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
                    {{ $equipments->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-tools text-gray-400 text-4xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada alat</h3>
                    <p class="text-gray-500 mb-6">Mulai dengan menambahkan alat pertama Anda</p>
                    <a href="{{ route('admin.equipment.create') }}" 
                       class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Alat Pertama
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

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection 
 