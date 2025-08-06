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
           class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali ke Daftar
        </a>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <form action="{{ route('admin.equipment.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama Alat -->
                <div class="col-span-2">
                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Alat <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="nama" 
                           name="nama" 
                           value="{{ old('nama') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                           placeholder="Masukkan nama alat"
                           required>
                    @error('nama')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div class="col-span-2">
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi <span class="text-red-500">*</span>
                    </label>
                    <textarea id="deskripsi" 
                              name="deskripsi" 
                              rows="4"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                              placeholder="Deskripsikan alat dan fungsinya..."
                              required>{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Stok Tersedia -->
                <div>
                    <label for="stok" class="block text-sm font-medium text-gray-700 mb-2">
                        Stok Tersedia <span class="text-red-500">*</span>
                    </label>
                    <input type="number"
                           id="stok"
                           name="stok"
                           value="{{ old('stok') }}"
                           min="0"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                           placeholder="Jumlah stok tersedia"
                           required>
                    @error('stok')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <!-- Stok Rusak -->
                <div>
                    <label for="stok_rusak" class="block text-sm font-medium text-gray-700 mb-2">
                        Stok Rusak
                    </label>
                    <input type="number"
                           id="stok_rusak"
                           name="stok_rusak"
                           value="{{ old('stok_rusak', 0) }}"
                           min="0"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                           placeholder="Jumlah alat rusak">
                    @error('stok_rusak')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <!-- Stok Total (Info Otomatis) -->
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Stok Total (Otomatis)</label>
                    <div class="px-3 py-2 rounded-lg bg-gray-100 border border-gray-200">
                        <span id="stok_total_info">0</span> unit
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
                    <label for="harga" class="block text-sm font-medium text-gray-700 mb-2">
                        Harga (Rp)
                    </label>
                    <input type="number" 
                           id="harga" 
                           name="harga" 
                           value="{{ old('harga') }}"
                           min="0"
                           step="1000"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                           placeholder="Harga alat">
                    @error('harga')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kondisi -->
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Kondisi Alat
                    </label>
                    <div class="flex items-center space-x-4">
                        <label class="flex items-center">
                            <input type="checkbox" 
                                   name="isBroken" 
                                   value="1"
                                   {{ old('isBroken') ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-green-600 focus:ring-green-500">
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
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                        Foto Alat
                    </label>
                    <input type="file" 
                           id="image" 
                           name="image" 
                           accept="image/*"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    <p class="mt-1 text-sm text-gray-500">
                        Format yang didukung: JPG, PNG, GIF. Maksimal 2MB.
                    </p>
                    @error('image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end space-x-3 mt-8">
                <a href="{{ route('admin.equipment.index') }}" 
                   class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                    <i class="fas fa-save mr-2"></i>
                    Simpan Alat
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 
 