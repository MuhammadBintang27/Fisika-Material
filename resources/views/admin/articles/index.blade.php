@extends('admin.layouts.app')

@section('title', 'Manajemen Artikel')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="bg-gradient-to-br from-blue-700 to-blue-800 rounded-xl p-8 text-white shadow-xl border border-blue-600">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold mb-2">Manajemen Artikel</h1>
                <p class="text-blue-100 text-lg">Kelola artikel dan berita laboratorium fisika</p>
            </div>
            <a href="{{ route('admin.articles.create') }}" 
               class="bg-white text-blue-700 px-6 py-3 rounded-xl hover:bg-gray-50 transition-all duration-300 shadow-lg hover:shadow-xl flex items-center font-semibold group">
                <i class="fas fa-plus mr-2 group-hover:rotate-90 transition-transform"></i>
                <span>Tambah Artikel</span>
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Total Artikel</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $articles->total() }}</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform shadow-lg">
                    <i class="fas fa-newspaper text-white text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Artikel Bulan Ini</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $articles->where('created_at', '>=', now()->startOfMonth())->count() }}</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform shadow-lg">
                    <i class="fas fa-calendar text-white text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Artikel Terbaru</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $articles->take(5)->count() }}</p>
                </div>
                <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform shadow-lg">
                    <i class="fas fa-clock text-white text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter Form -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-8">
        <div class="flex items-center space-x-3 mb-6">
            <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                <i class="fas fa-search text-white"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900">Filter & Pencarian</h3>
        </div>
        <form method="GET" action="{{ route('admin.articles.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label for="search" class="block text-sm font-semibold text-gray-700 mb-3">Cari Nama Acara / Penulis</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}" 
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" 
                       placeholder="Masukkan nama acara atau penulis...">
            </div>
            <div>
                <label for="from_date" class="block text-sm font-semibold text-gray-700 mb-3">Dari Tanggal</label>
                <input type="date" name="from_date" id="from_date" value="{{ request('from_date') }}" 
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
            </div>
            <div>
                <label for="to_date" class="block text-sm font-semibold text-gray-700 mb-3">Sampai Tanggal</label>
                <input type="date" name="to_date" id="to_date" value="{{ request('to_date') }}" 
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
            </div>
            <div class="flex items-end">
                <div class="flex space-x-3">
                    <button type="submit" class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-3 rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all shadow-lg hover:shadow-xl font-semibold">
                        <i class="fas fa-search mr-2"></i> Cari
                    </button>
                    @if(request()->hasAny(['search', 'from_date', 'to_date']))
                        <a href="{{ route('admin.articles.index') }}" class="bg-gray-500 text-white px-6 py-3 rounded-xl hover:bg-gray-600 transition-all shadow-lg font-semibold">
                            <i class="fas fa-times mr-2"></i> Reset
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    @if($articles->count() > 0)
        <!-- Articles Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($articles as $article)
                <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100 overflow-hidden group hover:-translate-y-2">
                    <!-- Card Header with Photo -->
                    <div class="relative overflow-hidden">
                        @if($article->gambar->first())
                            <img src="{{ url('storage/' . $article->gambar->first()->url) }}" 
                                 alt="{{ $article->namaAcara }}" 
                                 class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                            <div class="w-full h-48 bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center group-hover:from-blue-200 group-hover:to-blue-300 transition-all duration-300">
                                <i class="fas fa-image text-blue-400 text-4xl group-hover:scale-110 transition-transform"></i>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-semibold text-gray-700 shadow-lg border border-white/20">
                            <i class="fas fa-calendar mr-1"></i>{{ $article->tanggalAcara }}
                        </div>
                    </div>

                    <!-- Card Content -->
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-blue-600 transition-colors line-clamp-2">
                            {{ $article->namaAcara }}
                        </h3>
                        <p class="text-sm text-gray-600 mb-4 line-clamp-3 leading-relaxed">
                            {{ Str::limit($article->deskripsi, 120) }}
                        </p>
                        <div class="flex items-center justify-between text-sm">
                            <div class="flex items-center space-x-2">
                                <div class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-white text-xs"></i>
                                </div>
                                <span class="font-medium text-gray-700">{{ $article->penulis }}</span>
                            </div>
                            <span class="text-gray-500 flex items-center">
                                <i class="fas fa-eye mr-1"></i> 
                                {{ $article->views ?? 0 }}
                            </span>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex border-t border-gray-100">
                        <a href="{{ route('admin.articles.edit', $article->id) }}" 
                           class="flex-1 bg-gradient-to-r from-blue-50 to-blue-100 text-blue-600 py-4 text-center font-semibold hover:from-blue-100 hover:to-blue-200 transition-all duration-300 group/btn">
                            <i class="fas fa-edit mr-2 group-hover/btn:rotate-12 transition-transform"></i> Edit
                        </a>
                        <form method="POST" action="{{ route('admin.articles.destroy', $article->id) }}" class="flex-1" onsubmit="return confirm('Yakin ingin menghapus artikel ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full bg-gradient-to-r from-red-50 to-red-100 text-red-600 py-4 text-center font-semibold hover:from-red-100 hover:to-red-200 transition-all duration-300 group/btn">
                                <i class="fas fa-trash mr-2 group-hover/btn:scale-110 transition-transform"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="flex justify-center mt-8">
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-4">
                {{ $articles->appends(request()->query())->links() }}
            </div>
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-gradient-to-br from-gray-50 to-blue-50 rounded-xl shadow-lg p-16 text-center border border-gray-200">
            <div class="max-w-md mx-auto">
                <div class="mb-8">
                    <div class="w-32 h-32 bg-gradient-to-br from-blue-100 to-blue-200 rounded-full flex items-center justify-center mx-auto shadow-lg">
                        <i class="fas fa-newspaper text-blue-400 text-5xl"></i>
                    </div>
                </div>
                
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Belum ada artikel terdaftar</h3>
                <p class="text-gray-600 mb-8 leading-relaxed text-lg">
                    Mulai publikasikan pengetahuan laboratorium fisika dengan menambahkan artikel pertama Anda
                </p>
                
                <a href="{{ route('admin.articles.create') }}" 
                   class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-8 py-4 rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-300 shadow-lg hover:shadow-xl inline-flex items-center group">
                    <i class="fas fa-plus mr-3 text-lg group-hover:rotate-90 transition-transform"></i>
                    <span class="font-semibold">Tambah Artikel Pertama</span>
                </a>
            </div>
        </div>
    @endif

    @if($articles->count() > 0)
        <!-- Pagination -->
        <div class="flex justify-center mt-8">
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-4">
                {{ $articles->appends(request()->query())->links() }}
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
    
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection