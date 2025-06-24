@extends('admin.layouts.app')

@section('title', 'Manajemen Artikel')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Manajemen Artikel</h1>
            <p class="text-gray-600">Kelola artikel laboratorium</p>
        </div>
        <a href="{{ route('admin.articles.create') }}" 
           class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
            <i class="fas fa-plus mr-2"></i>
            Tambah Artikel
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-6">
            @if($articles->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gambar</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penulis</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($articles as $article)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        @if($article->gambar->first())
                                            <img src="{{ asset($article->gambar->first()->url) }}" alt="{{ $article->namaAcara }}" class="w-16 h-12 rounded-lg object-cover">
                                        @else
                                            <div class="w-16 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                                <i class="fas fa-image text-gray-400"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $article->namaAcara }}</div>
                                        <div class="text-xs text-gray-500 line-clamp-1">{{ Str::limit($article->deskripsi, 50) }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $article->penulis }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $article->tanggalAcara }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('admin.articles.edit', $article->id) }}" class="text-blue-600 hover:text-blue-900">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form method="POST" action="{{ route('admin.articles.destroy', $article->id) }}" class="inline" onsubmit="return confirm('Yakin ingin menghapus artikel ini?')">
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
                <div class="mt-6">
                    {{ $articles->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-newspaper text-gray-400 text-4xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada artikel</h3>
                    <p class="text-gray-500 mb-6">Mulai dengan menambahkan artikel pertama Anda</p>
                    <a href="{{ route('admin.articles.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Artikel Pertama
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
 