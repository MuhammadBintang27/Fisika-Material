@extends('admin.layouts.app')

@section('title', 'Edit Artikel')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="bg-gradient-to-br from-blue-700 to-blue-800 rounded-xl p-8 text-white shadow-xl border border-blue-600">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold mb-2">Edit Artikel</h1>
                <p class="text-blue-100 text-lg">Perbarui informasi artikel laboratorium</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.articles.index') }}" 
                   class="px-6 py-3 bg-white/90 backdrop-blur-sm text-blue-700 rounded-xl font-semibold shadow-lg hover:shadow-xl hover:bg-white transition-all duration-300 flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
        <form method="POST" action="{{ route('admin.articles.update', $article->id) }}" enctype="multipart/form-data" class="p-8">
            @csrf
            @method('PUT')

            <!-- Nama Acara -->
            <div>
                <label for="namaAcara" class="block text-sm font-semibold text-gray-700 mb-2">
                    Nama Acara <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="namaAcara" 
                       name="namaAcara" 
                       value="{{ old('namaAcara', $article->namaAcara) }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 hover:border-blue-400 @error('namaAcara') border-red-500 @enderror"
                       placeholder="Masukkan nama acara"
                       required>
                @error('namaAcara')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Penulis -->
            <div>
                <label for="penulis" class="block text-sm font-semibold text-gray-700 mb-2">
                    Penulis
                </label>
                <input type="text" 
                       id="penulis" 
                       name="penulis" 
                       value="{{ old('penulis', $article->penulis) }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 hover:border-blue-400 @error('penulis') border-red-500 @enderror"
                       placeholder="Masukkan nama penulis (opsional)">
                @error('penulis')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Deskripsi Penulis -->
            <div>
                <label for="deskripsi_penulis" class="block text-sm font-semibold text-gray-700 mb-2">
                    Deskripsi Penulis
                </label>
                <textarea id="deskripsi_penulis" 
                          name="deskripsi_penulis" 
                          rows="4"
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 hover:border-blue-400 @error('deskripsi_penulis') border-red-500 @enderror"
                          placeholder="Tulis deskripsi singkat tentang penulis (opsional)...">{{ old('deskripsi_penulis', $article->deskripsi_penulis) }}</textarea>
                <div class="mt-2 flex items-center justify-between text-sm text-gray-500">
                    <span>Contoh: "Peneliti dan dosen di Laboratorium Fisika Dasar dengan fokus pada bidang geofisika"</span>
                    <span id="penulisCharCount">{{ strlen($article->deskripsi_penulis ?? '') }} karakter</span>
                </div>
                @error('deskripsi_penulis')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tanggal Acara -->
            <div>
                <label for="tanggalAcara" class="block text-sm font-semibold text-gray-700 mb-2">
                    Tanggal Acara <span class="text-red-500">*</span>
                </label>
                <input type="datetime-local" 
                       id="tanggalAcara" 
                       name="tanggalAcara" 
                       value="{{ old('tanggalAcara', \Carbon\Carbon::parse($article->tanggalAcara)->format('Y-m-d\TH:i')) }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 hover:border-blue-400 @error('tanggalAcara') border-red-500 @enderror"
                       required>
                @error('tanggalAcara')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Deskripsi -->
            <div>
                <label for="deskripsi" class="block text-sm font-semibold text-gray-700 mb-2">
                    Deskripsi <span class="text-red-500">*</span>
                </label>
                <textarea id="deskripsi" 
                          name="deskripsi" 
                          rows="10"
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 hover:border-blue-400 @error('deskripsi') border-red-500 @enderror"
                          placeholder="Tulis deskripsi artikel di sini..."
                          required>{{ old('deskripsi', $article->deskripsi) }}</textarea>
                @error('deskripsi')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Gambar Artikel Saat Ini & Upload Baru -->
            <div>
                <label for="image" class="block text-sm font-semibold text-gray-700 mb-2">
                    Gambar Artikel
                </label>
                <div class="flex items-center space-x-6 mb-2">
                    @if($article->gambar && $article->gambar->first())
                        <div class="w-32 h-24 border border-gray-300 rounded-lg overflow-hidden">
                            <img src="{{ url('storage/' . $article->gambar->first()->url) }}" alt="Gambar Artikel" class="w-full h-full object-cover">
                        </div>
                    @else
                        <div class="w-32 h-24 bg-gray-200 border border-gray-300 rounded-lg flex items-center justify-center text-gray-400">
                            <i class="fas fa-image text-2xl"></i>
                        </div>
                    @endif
                    <input type="file" 
                           id="image" 
                           name="image" 
                           accept="image/*" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 hover:border-blue-400 @error('image') border-red-500 @enderror">
                </div>
                <p class="text-xs text-gray-500 mt-1">Format yang didukung: JPG, PNG, GIF. Maksimal 2MB.</p>
                @error('image')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <!-- Preview Gambar Baru -->
                <div id="imagePreview" class="hidden mt-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Preview Gambar Baru</label>
                    <div class="w-32 h-24 border border-gray-300 rounded-lg overflow-hidden">
                        <img id="preview" src="" alt="Preview" class="w-full h-full object-cover">
                    </div>
                </div>
            </div>

            </div>
            
            <!-- Submit Button -->
            <div class="flex justify-end space-x-4 mt-8 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.articles.index') }}" 
                   class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-all duration-200">
                    Batal
                </a>
                <button type="submit" 
                        class="px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center">
                    <i class="fas fa-save mr-2"></i>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
<script>
// Image preview functionality
document.getElementById('image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('preview');
    const previewContainer = document.getElementById('imagePreview');
    
    if (file) {
        // Validasi ukuran file (2MB)
        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran file terlalu besar. Maksimal 2MB.');
            e.target.value = '';
            return;
        }
        
        // Validasi tipe file
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        if (!allowedTypes.includes(file.type)) {
            alert('Format file tidak didukung. Gunakan JPG, PNG, atau GIF.');
            e.target.value = '';
            return;
        }
        
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

// Character counter for author description
document.getElementById('deskripsi_penulis').addEventListener('input', function(e) {
    const charCount = document.getElementById('penulisCharCount');
    const length = e.target.value.length;
    charCount.textContent = length + ' karakter';
    
    // Change color based on length
    if (length < 50) {
        charCount.className = 'text-red-500';
    } else if (length < 200) {
        charCount.className = 'text-yellow-500';
    } else {
        charCount.className = 'text-green-500';
    }
});

// Initialize character count on page load
document.addEventListener('DOMContentLoaded', function() {
    // Initialize author description character count
    const penulisTextarea = document.getElementById('deskripsi_penulis');
    const penulisCharCount = document.getElementById('penulisCharCount');
    const penulisLength = penulisTextarea.value.length;
    penulisCharCount.textContent = penulisLength + ' karakter';
    
    if (penulisLength < 50) {
        penulisCharCount.className = 'text-red-500';
    } else if (penulisLength < 200) {
        penulisCharCount.className = 'text-yellow-500';
    } else {
        penulisCharCount.className = 'text-green-500';
    }
});
</script>
@endsection
 