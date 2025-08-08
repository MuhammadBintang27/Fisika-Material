@extends('admin.layouts.app')

@section('title', 'Tambah Artikel')

@section('content')
<div class="space-y-6">
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
                    <div class="bg-white rounded-xl shadow-lg border border-gray-200 hover:shadow-xl transition-all duration-300">
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

                <!-- Deskripsi Penulis -->
                <div>
                    <label for="deskripsi_penulis" class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi Penulis
                    </label>
                    <textarea id="deskripsi_penulis" 
                              name="deskripsi_penulis" 
                              rows="4"
                              class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Tulis deskripsi singkat tentang penulis (opsional)...">{{ old('deskripsi_penulis') }}</textarea>
                    <div class="mt-2 flex items-center justify-between text-sm text-gray-500">
                        <span>Contoh: "Peneliti dan dosen di Laboratorium Fisika Dasar dengan fokus pada bidang geofisika"</span>
                        <span id="penulisCharCount">0 karakter</span>
                    </div>
                    @error('deskripsi_penulis')
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
                              rows="12"
                              class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Tulis deskripsi artikel di sini. Anda dapat menggunakan format teks biasa atau HTML untuk formatting..."
                              required>{{ old('deskripsi') }}</textarea>
                    <div class="mt-2 flex items-center justify-between text-sm text-gray-500">
                        <span>Minimal 100 karakter untuk deskripsi yang informatif</span>
                        <span id="charCount">0 karakter</span>
                    </div>
                    @error('deskripsi')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Image -->
                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                        Gambar Artikel <span class="text-red-500">*</span>
                    </label>
                    <div class="flex items-center space-x-4">
                        <input type="file" 
                               id="image" 
                               name="image" 
                               accept="image/*"
                               class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               required>
                    </div>
                    <p class="mt-1 text-sm text-gray-500">
                        Format yang didukung: JPG, PNG, GIF. Maksimal 2MB. Gambar akan ditampilkan di halaman artikel.
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
                    <div class="w-64 h-40 border border-gray-300 rounded-lg overflow-hidden bg-gray-50">
                        <img id="preview" src="" alt="Preview" class="w-full h-full object-cover">
                    </div>
                    <p class="mt-2 text-sm text-gray-500">
                        Gambar akan ditampilkan seperti ini di halaman artikel
                    </p>
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

// Character counter for description
document.getElementById('deskripsi').addEventListener('input', function(e) {
    const charCount = document.getElementById('charCount');
    const length = e.target.value.length;
    charCount.textContent = length + ' karakter';
    
    // Change color based on length
    if (length < 100) {
        charCount.className = 'text-red-500';
    } else if (length < 500) {
        charCount.className = 'text-yellow-500';
    } else {
        charCount.className = 'text-green-500';
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
    const textarea = document.getElementById('deskripsi');
    const charCount = document.getElementById('charCount');
    const length = textarea.value.length;
    charCount.textContent = length + ' karakter';
    
    if (length < 100) {
        charCount.className = 'text-red-500';
    } else if (length < 500) {
        charCount.className = 'text-yellow-500';
    } else {
        charCount.className = 'text-green-500';
    }

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
 