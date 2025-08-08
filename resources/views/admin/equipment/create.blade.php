@extends('admin.layouts.app')

@section('title', 'Tambah Alat Baru')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Tambah Alat Baru</h1>
            <p class="text-gray-600">Tambah alat dan peralatan laboratorium</p>
        </div>
        <a href="{{ route('admin.equipment.index') }}" 
           class="bg-gradient-to-r from-gray-600 to-gray-700 text-white px-6 py-3 rounded-lg hover:from-gray-700 hover:to-gray-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali ke Daftar
        </a>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 hover:shadow-xl transition-all duration-300">
        <form action="{{ route('admin.equipment.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama Alat -->
                <div class="col-span-2">
                    <label for="nama" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nama Alat <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="nama" 
                           name="nama" 
                           value="{{ old('nama') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 hover:border-green-400"
                           placeholder="Masukkan nama alat"
                           required>
                    @error('nama')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div class="col-span-2">
                    <label for="deskripsi" class="block text-sm font-semibold text-gray-700 mb-2">
                        Deskripsi <span class="text-red-500">*</span>
                    </label>
                    <textarea id="deskripsi" 
                              name="deskripsi" 
                              rows="4"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 hover:border-green-400"
                              placeholder="Deskripsikan alat dan fungsinya..."
                              required>{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Stok Tersedia -->
                <div>
                    <label for="stok" class="block text-sm font-semibold text-gray-700 mb-2">
                        Stok Tersedia <span class="text-red-500">*</span>
                    </label>
                    <input type="number"
                           id="stok"
                           name="stok"
                           value="{{ old('stok') }}"
                           min="0"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 hover:border-green-400"
                           placeholder="Jumlah stok tersedia"
                           required>
                    @error('stok')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <!-- Stok Rusak -->
                <div>
                    <label for="stok_rusak" class="block text-sm font-semibold text-gray-700 mb-2">
                        Stok Rusak
                    </label>
                    <input type="number"
                           id="stok_rusak"
                           name="stok_rusak"
                           value="{{ old('stok_rusak', 0) }}"
                           min="0"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 hover:border-green-400"
                           placeholder="Jumlah alat rusak">
                    @error('stok_rusak')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <!-- Stok Total (Info Otomatis) -->
                <div class="col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Stok Total (Otomatis)</label>
                    <div class="px-4 py-3 rounded-lg bg-gradient-to-r from-green-50 to-green-100 border border-green-200">
                        <span id="stok_total_info" class="font-semibold text-green-700">0</span> unit
                    </div>
                </div>
                <script>
                document.addEventListener('DOMContentLoaded', function() {
                    function updateStokTotal() {
                        var stok = parseInt(document.getElementById('stok').value) || 0;
                        var stokRusak = parseInt(document.getElementById('stok_rusak').value) || 0;
                        var stokDipinjam = 0; // selalu 0 saat create
                        document.getElementById('stok_total_info').innerText = stok + stokRusak + stokDipinjam;
                    }
                    document.getElementById('stok').addEventListener('input', updateStokTotal);
                    document.getElementById('stok_rusak').addEventListener('input', updateStokTotal);
                    updateStokTotal();
                });
                </script>

                <!-- Harga -->
                <div>
                    <label for="harga" class="block text-sm font-semibold text-gray-700 mb-2">
                        Harga (Rp)
                    </label>
                    <input type="number" 
                           id="harga" 
                           name="harga" 
                           value="{{ old('harga') }}"
                           min="0"
                           step="1000"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 hover:border-green-400"
                           placeholder="Harga alat">
                    @error('harga')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kondisi -->
                <div class="col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Kondisi Alat
                    </label>
                    <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" 
                                   name="isBroken" 
                                   value="1"
                                   {{ old('isBroken') ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-green-600 focus:ring-green-500 transition-all">
                            <span class="ml-2 text-sm text-gray-700">Alat Rusak</span>
                        </label>
                    </div>
                    <p class="mt-1 text-sm text-gray-500">
                        Centang jika alat dalam kondisi rusak atau tidak dapat digunakan
                    </p>
                    @error('isBroken')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Foto Alat -->
                <div class="col-span-2">
                    <label for="image" class="block text-sm font-semibold text-gray-700 mb-2">
                        Foto Alat
                    </label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-green-400 transition-all duration-200">
                        <input type="file" 
                               id="image" 
                               name="image" 
                               accept="image/*"
                               class="w-full opacity-0 absolute inset-0 cursor-pointer">
                        <div class="space-y-2">
                            <i class="fas fa-cloud-upload-alt text-gray-400 text-3xl"></i>
                            <p class="text-sm text-gray-600">Klik atau seret file gambar ke sini</p>
                            <p class="text-xs text-gray-500">Format yang didukung: JPG, PNG, GIF. Maksimal 2MB.</p>
                        </div>
                    </div>
                    @error('image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end space-x-4 mt-8">
                <a href="{{ route('admin.equipment.index') }}" 
                   class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-all duration-200">
                    Batal
                </a>
                <button type="submit" 
                        class="px-8 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-lg hover:from-green-700 hover:to-green-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center">
                    <i class="fas fa-save mr-2"></i>
                    Simpan Alat
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 
 