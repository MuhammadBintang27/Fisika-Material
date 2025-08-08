@extends('admin.layouts.app')

@section('title', 'Kelola Jenis Pengujian')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Kelola Jenis Pengujian</h1>
            <p class="text-gray-600">Daftar semua jenis pengujian laboratorium</p>
        </div>
        <a href="{{ route('admin.jenis-pengujian.create') }}" 
           class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-3 rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center">
            <i class="fas fa-plus mr-2"></i>
            Tambah Jenis Pengujian
        </a>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 hover:shadow-xl transition-all duration-300 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Nama Pengujian
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Harga per Sampel
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($jenisPengujian as $item)
                        <tr class="hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 transition-all duration-200 transform hover:scale-[1.01]">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-gray-900 hover:text-blue-600 transition-colors">{{ $item->namaPengujian }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-green-600">Rp {{ number_format($item->hargaPerSampel, 0, ',', '.') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($item->isAvailable)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Tersedia
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Tidak Tersedia
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-3">
                                    <a href="{{ route('admin.jenis-pengujian.edit', $item->id) }}" 
                                       class="text-yellow-600 hover:text-yellow-900 hover:scale-110 transition-all duration-200 p-2 rounded-full hover:bg-yellow-50">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.jenis-pengujian.destroy', $item->id) }}" method="POST" 
                                          class="inline" onsubmit="return confirm('Yakin ingin menghapus jenis pengujian ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="text-red-600 hover:text-red-900 hover:scale-110 transition-all duration-200 p-2 rounded-full hover:bg-red-50">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <div class="text-center py-16">
                                    <div class="w-24 h-24 bg-gradient-to-br from-gray-200 to-gray-300 rounded-full flex items-center justify-center mx-auto mb-6">
                                        <i class="fas fa-flask text-gray-400 text-3xl"></i>
                                    </div>
                                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Belum ada jenis pengujian</h3>
                                    <p class="text-gray-500 mb-8 max-w-md mx-auto">Belum ada data jenis pengujian yang tersedia</p>
                                    <a href="{{ route('admin.jenis-pengujian.create') }}" 
                                       class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-3 rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 inline-flex items-center">
                                        <i class="fas fa-plus mr-2"></i>
                                        Tambah Jenis Pengujian Pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($jenisPengujian->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $jenisPengujian->links() }}
            </div>
        @endif
    </div>
</div>
@endsection 
 