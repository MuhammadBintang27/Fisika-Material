@extends('admin.layouts.app')

@section('title', 'Tambah Artikel')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Tambah Artikel Baru</h1>
                <p class="text-gray-600">Buat artikel baru untuk website laboratorium</p>
            </div>
            <a href="{{ route('admin.articles.index') }}" 
               class="text-gray-600 hover:text-gray-900">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke Daftar
            </a>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <form method="POST" action="{{ route('admin.articles.store') }}" enctype="multipart/form-data" class="p-6 space-y-6">
                @csrf

                <!-- Nama Acara -->
                <div>
                    <label for="namaAcara" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Acara <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="namaAcara" 
                           name="namaAcara" 
                           value="{{ old('namaAcara') }}"
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
                           value="{{ old('penulis') }}"
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
                           value="{{ old('tanggalAcara') }}"
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
                              required>{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Image -->
                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                        Gambar Artikel
                    </label>
                    <div class="flex items-center space-x-4">
                        <input type="file" 
                               id="image" 
                               name="image" 
                               accept="image/*"
                               class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <p class="mt-1 text-sm text-gray-500">
                        Format yang didukung: JPG, PNG, GIF. Maksimal 2MB.
                    </p>
                    @error('image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Preview Image -->
                <div id="imagePreview" class="hidden">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Preview Gambar
                    </label>
                    <div class="w-48 h-32 border border-gray-300 rounded-lg overflow-hidden">
                        <img id="preview" src="" alt="Preview" class="w-full h-full object-cover">
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.articles.index') }}" 
                       class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-save mr-2"></i>
                        Simpan Artikel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Image preview functionality
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
 