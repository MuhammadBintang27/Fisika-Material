@extends('admin.layouts.app')

@section('title', 'Manajemen Galeri Laboratorium')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Manajemen Galeri Laboratorium</h1>
            <p class="text-gray-600">Kelola galeri foto laboratorium</p>
        </div>
        <a href="{{ route('admin.galeri.create') }}" 
           class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-3 rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center">
            <i class="fas fa-plus mr-2"></i>
            Tambah Galeri
        </a>
    </div>

    <!-- Galeri List -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 hover:shadow-xl transition-all duration-300">
        <div class="p-6">
            @if($galeri->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">#</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Judul</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Gambar</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($galeri as $item)
                                <tr class="hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 transition-all duration-200 transform hover:scale-[1.01]">
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            {{ $loop->iteration }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-semibold text-gray-900 hover:text-blue-600 transition-colors">
                                            {{ $item->judul }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <img src="{{ url('storage/' . $item->gambar_url) }}" 
                                             alt="{{ $item->judul }}" 
                                             class="w-24 h-16 object-cover rounded-lg shadow-md hover:shadow-lg transition-shadow">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center space-x-3">
                                            <a href="{{ route('admin.galeri.edit', $item->id) }}" 
                                               class="text-yellow-600 hover:text-yellow-900 hover:scale-110 transition-all duration-200 p-2 rounded-full hover:bg-yellow-50">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.galeri.destroy', $item->id) }}" 
                                                  method="POST" 
                                                  onsubmit="return confirm('Yakin hapus galeri ini?')" 
                                                  class="inline">
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
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-16">
                    <div class="w-24 h-24 bg-gradient-to-br from-gray-200 to-gray-300 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-images text-gray-400 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Belum ada galeri</h3>
                    <p class="text-gray-500 mb-8 max-w-md mx-auto">Mulai dengan menambahkan galeri pertama Anda untuk menampilkan foto laboratorium</p>
                    <a href="{{ route('admin.galeri.create') }}" 
                       class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-3 rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 inline-flex items-center">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Galeri Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 