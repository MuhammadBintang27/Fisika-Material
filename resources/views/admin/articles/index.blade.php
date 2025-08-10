@extends('admin.layouts.app')

@section('title', 'Manajemen Artikel')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Manajemen Artikel</h1>
            <p class="text-gray-600 mt-1">Kelola artikel laboratorium fisika</p>
        </div>
        <a href="{{ route('admin.articles.create') }}" 
           class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-3 rounded-lg hover:from-blue-700 hover:to-blue-800 transition-colors duration-300 shadow-md hover:shadow-lg flex items-center">
            <i class="fas fa-plus mr-2"></i>
            <span class="font-medium">Tambah Artikel</span>
        </a>
    </div>

    <!-- Stats Cards (Hanya Total) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-gradient-to-br from-slate-50 to-gray-100 rounded-lg p-6 shadow-md border border-gray-200 hover:shadow-lg transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Total Artikel</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $articles->total() }}</p>
                </div>
                <div class="p-3 bg-blue-500 rounded-lg shadow-md">
                    <i class="fas fa-newspaper text-white text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter Form -->
    <div class="bg-white rounded-xl shadow-md p-6 mb-8">
        <form method="GET" action="{{ route('admin.articles.index') }}" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Cari Nama Acara / Penulis</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                       placeholder="Masukkan nama acara atau penulis...">
            </div>
            <div class="flex-1">
                <label for="from_date" class="block text-sm font-medium text-gray-700 mb-2">Dari Tanggal</label>
                <input type="date" name="from_date" id="from_date" value="{{ request('from_date') }}" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div class="flex-1">
                <label for="to_date" class="block text-sm font-medium text-gray-700 mb-2">Sampai Tanggal</label>
                <input type="date" name="to_date" id="to_date" value="{{ request('to_date') }}" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div class="flex items-end">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-search mr-2"></i> Cari
                </button>
            </div>
        </form>
    </div>

    @if($articles->count() > 0)
        <!-- Articles Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($articles as $article)
                <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-all duration-300 border border-gray-200 overflow-hidden">
                    <!-- Card Header with Photo -->
                    <div class="relative">
                        @if($article->gambar->first())
                            <img src="{{ asset($article->gambar->first()->url) }}" 
                                 alt="{{ $article->namaAcara }}" 
                                 class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center">
                                <i class="fas fa-image text-gray-400 text-4xl"></i>
                            </div>
                        @endif
                        <div class="absolute top-4 right-4 bg-white/80 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-medium text-gray-700 shadow">
                            {{ $article->tanggalAcara }}
                        </div>
                    </div>

                    <!-- Card Content -->
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2 hover:text-blue-600 transition-colors">
                            {{ $article->namaAcara }}
                        </h3>
                        <p class="text-sm text-gray-600 mb-4 line-clamp-2">
                            {{ Str::limit($article->deskripsi, 100) }}
                        </p>
                        <div class="flex items-center justify-between text-sm">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full bg-purple-100 text-purple-800 font-medium">
                                {{ $article->penulis }}
                            </span>
                            <span class="text-gray-500"><i class="fas fa-eye mr-1"></i> {{ $article->views ?? 0 }} views</span>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex border-t border-gray-100">
                        <a href="{{ route('admin.articles.edit', $article->id) }}" 
                           class="flex-1 bg-blue-50 text-blue-600 py-3 text-center font-medium hover:bg-blue-100 transition-colors">
                            <i class="fas fa-edit mr-2"></i> Edit
                        </a>
                        <form method="POST" action="{{ route('admin.articles.destroy', $article->id) }}" class="flex-1" onsubmit="return confirm('Yakin ingin menghapus artikel ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full bg-red-50 text-red-600 py-3 text-center font-medium hover:bg-red-100 transition-colors">
                                <i class="fas fa-trash mr-2"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="flex justify-center mt-8">
            <div class="bg-white rounded-lg shadow-md p-4 border border-gray-200">
                {{ $articles->links() }}
            </div>
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-gradient-to-br from-gray-50 to-slate-100 rounded-lg shadow-md p-12 text-center border border-gray-200">
            <div class="max-w-md mx-auto">
                <div class="mb-8">
                    <div class="w-32 h-32 bg-gradient-to-br from-gray-200 to-gray-300 rounded-full flex items-center justify-center mx-auto shadow-md">
                        <i class="fas fa-newspaper text-gray-500 text-5xl"></i>
                    </div>
                </div>
                
                <h3 class="text-2xl font-semibold text-gray-900 mb-4">Belum ada artikel terdaftar</h3>
                <p class="text-gray-600 mb-8 leading-relaxed">
                    Mulai publikasikan pengetahuan laboratorium fisika dengan menambahkan artikel pertama Anda
                </p>
                
                <a href="{{ route('admin.articles.create') }}" 
                   class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-8 py-4 rounded-lg hover:from-blue-700 hover:to-blue-800 transition-colors duration-300 shadow-md hover:shadow-lg inline-flex items-center">
                    <i class="fas fa-plus mr-3 text-lg"></i>
                    <span class="font-semibold">Tambah Artikel Pertama</span>
                </a>
            </div>
        </div>
    @endif
</div>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .transition-colors {
        transition-property: color, background-color, border-color;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 300ms;
    }
    
    .transition-shadow {
        transition-property: box-shadow;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 300ms;
    }
</style>
@endsection