@extends('admin.layouts.app')

@section('title', 'Edit Artikel')

@section('content')
<div class="max-w-3xl mx-auto bg-white rounded-xl shadow-sm border border-gray-200 p-8 mt-8">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Edit Artikel</h1>
    <form method="POST" action="{{ route('admin.articles.update', $article->id) }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')
        <!-- Nama Acara -->
        <div>
            <label for="namaAcara" class="block text-sm font-medium text-gray-700 mb-2">
                Nama Acara <span class="text-red-500">*</span>
            </label>
            <input type="text" 
                   id="namaAcara" 
                   name="namaAcara" 
                   value="{{ old('namaAcara', $article->namaAcara) }}"
                   class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                   placeholder="Masukkan nama acara"
                   required>
            @error('namaAcara')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Penulis -->
        <div>
            <label for="penulis" class="block text-sm font-medium text-gray-700 mb-2">
                Penulis
            </label>
            <input type="text" 
                   id="penulis" 
                   name="penulis" 
                   value="{{ old('penulis', $article->penulis) }}"
                   class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                   placeholder="Masukkan nama penulis (opsional)">
            @error('penulis')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Tanggal Acara -->
        <div>
            <label for="tanggalAcara" class="block text-sm font-medium text-gray-700 mb-2">
                Tanggal Acara <span class="text-red-500">*</span>
            </label>
            <input type="datetime-local" 
                   id="tanggalAcara" 
                   name="tanggalAcara" 
                   value="{{ old('tanggalAcara', \Carbon\Carbon::parse($article->tanggalAcara)->format('Y-m-d\TH:i')) }}"
                   class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                   required>
            @error('tanggalAcara')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Deskripsi -->
        <div>
            <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
                Deskripsi <span class="text-red-500">*</span>
            </label>
            <textarea id="deskripsi" 
                      name="deskripsi" 
                      rows="10"
                      class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                      placeholder="Tulis deskripsi artikel di sini..."
                      required>{{ old('deskripsi', $article->deskripsi) }}</textarea>
            @error('deskripsi')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Gambar Artikel Saat Ini & Upload Baru -->
        <div>
            <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                Gambar Artikel
            </label>
            <div class="flex items-center space-x-6 mb-2">
                @if($article->gambar && $article->gambar->first())
                    <div class="w-32 h-24 border border-gray-300 rounded-lg overflow-hidden">
                        <img src="{{ asset($article->gambar->first()->url) }}" alt="Gambar Artikel" class="w-full h-full object-cover">
                    </div>
                @else
                    <div class="w-32 h-24 bg-gray-200 border border-gray-300 rounded-lg flex items-center justify-center text-gray-400">
                        <i class="fas fa-image text-2xl"></i>
                    </div>
                @endif
                <input type="file" id="image" name="image" accept="image/*" class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <p class="mt-1 text-sm text-gray-500">Format: JPG, PNG, GIF. Maksimal 2MB.</p>
            @error('image')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
            <!-- Preview Gambar Baru -->
            <div id="imagePreview" class="hidden mt-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Preview Gambar Baru</label>
                <div class="w-32 h-24 border border-gray-300 rounded-lg overflow-hidden">
                    <img id="preview" src="" alt="Preview" class="w-full h-full object-cover">
                </div>
            </div>
        </div>

        <!-- Tombol Aksi -->
        <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200 mt-8">
            <a href="{{ route('admin.articles.index') }}" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                Batal
            </a>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <i class="fas fa-save mr-2"></i>
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
<script>
document.getElementById('image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('preview');
    const previewContainer = document.getElementById('imagePreview');
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            previewContainer.classList.remove('hidden');
        }
        reader.readAsDataURL(file);
    } else {
        previewContainer.classList.add('hidden');
    }
});
</script>
@endsection
 