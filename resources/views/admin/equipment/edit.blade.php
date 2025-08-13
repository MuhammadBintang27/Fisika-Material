@extends('admin.layouts.app')

@section('title', 'Edit Alat')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="bg-gradient-to-br from-blue-700 to-blue-800 rounded-xl p-8 text-white shadow-xl border border-blue-600">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold mb-2">Edit Alat</h1>
                <p class="text-blue-100 text-lg">Edit data alat dan peralatan laboratorium fisika</p>
            </div>
            <a href="{{ route('admin.equipment.index') }}" 
               class="bg-white text-blue-700 px-6 py-3 rounded-xl hover:bg-gray-50 transition-all duration-300 shadow-lg hover:shadow-xl flex items-center font-semibold group">
                <i class="fas fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform"></i>
                <span>Kembali ke Daftar</span>
            </a>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
        <div class="p-8">
            <div class="flex items-center space-x-3 mb-8">
                <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                    <i class="fas fa-edit text-white"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900">Form Edit Alat</h3>
            </div>
            
            <form action="{{ route('admin.equipment.update', $equipment->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nama Alat -->
                    <div class="col-span-2">
                        <label for="nama" class="block text-sm font-bold text-gray-700 mb-3">
                            Nama Alat <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="nama" 
                               name="nama" 
                               value="{{ old('nama', $equipment->nama) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 hover:border-blue-400"
                               placeholder="Masukkan nama alat"
                               required>
                        @error('nama')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Deskripsi -->
                    <div class="col-span-2">
                        <label for="deskripsi" class="block text-sm font-bold text-gray-700 mb-3">
                            Deskripsi <span class="text-red-500">*</span>
                        </label>
                        <textarea id="deskripsi" 
                                  name="deskripsi" 
                                  rows="4"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 hover:border-blue-400"
                                  placeholder="Deskripsikan alat dan fungsinya..."
                                  required>{{ old('deskripsi', $equipment->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Stok Tersedia -->
                    <div>
                        <label for="stok" class="block text-sm font-bold text-gray-700 mb-3">
                            Stok Tersedia <span class="text-red-500">*</span>
                        </label>
                        <input type="number"
                               id="stok"
                               name="stok"
                               value="{{ old('stok', $equipment->stok) }}"
                               min="0"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 hover:border-blue-400"
                               placeholder="Jumlah stok tersedia"
                               required>
                        @error('stok')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Stok Rusak -->
                    <div>
                        <label for="stok_rusak" class="block text-sm font-bold text-gray-700 mb-3">
                            Stok Rusak
                        </label>
                        <input type="number"
                               id="stok_rusak"
                               name="stok_rusak"
                               value="{{ old('stok_rusak', $equipment->stok_rusak ?? 0) }}"
                               min="0"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 hover:border-blue-400"
                               placeholder="Jumlah alat rusak">
                        @error('stok_rusak')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Jumlah Diperbaiki -->
                    <div>
                        <label for="jumlah_perbaikan" class="block text-sm font-bold text-gray-700 mb-3">
                            Jumlah Diperbaiki
                        </label>
                        <input type="number"
                               id="jumlah_perbaikan"
                               name="jumlah_perbaikan"
                               value="0"
                               min="0"
                               max="{{ $equipment->stok_rusak ?? 0 }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 hover:border-blue-400"
                               placeholder="Jumlah alat yang berhasil diperbaiki">
                        <p class="mt-1 text-sm text-gray-500">Pindah dari rusak ke tersedia</p>
                        @error('jumlah_perbaikan')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Status Otomatis -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-3">Status Otomatis</label>
                        <div class="px-4 py-3 rounded-xl bg-gradient-to-r from-blue-50 to-blue-100 border border-blue-200">
                            <span class="font-bold text-blue-700">
                                {{ ($equipment->stok ?? 0) > 0 ? 'Tersedia' : 'Tidak Tersedia' }}
                            </span>
                        </div>
                    </div>
                    
                    <!-- Stok Total (Info Otomatis) -->
                    <div class="col-span-2">
                        <label class="block text-sm font-bold text-gray-700 mb-3">Stok Total (Otomatis)</label>
                        <div class="px-4 py-3 rounded-xl bg-gradient-to-r from-blue-50 to-blue-100 border border-blue-200">
                            <span id="stok_total_info" class="font-bold text-blue-700">{{ ($equipment->stok ?? 0) + ($equipment->stok_dipinjam ?? 0) + ($equipment->stok_rusak ?? 0) }}</span> unit
                        </div>
                    </div>

                    <!-- Harga -->
                    <div>
                        <label for="harga" class="block text-sm font-bold text-gray-700 mb-3">
                            Harga (Rp)
                        </label>
                        <input type="number" 
                               id="harga" 
                               name="harga" 
                               value="{{ old('harga', $equipment->harga) }}"
                               min="0"
                               step="1000"
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 hover:border-blue-400"
                               placeholder="Harga alat">
                        @error('harga')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kondisi -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-3">
                            Kondisi Alat
                        </label>
                        <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-xl border border-gray-200">
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" 
                                       name="isBroken" 
                                       value="1"
                                       {{ old('isBroken', $equipment->isBroken) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 transition-all">
                                <span class="ml-2 text-sm font-medium text-gray-700">Alat Rusak</span>
                            </label>
                        </div>
                        <p class="mt-2 text-sm text-gray-500">
                            Centang jika alat dalam kondisi rusak atau tidak dapat digunakan
                        </p>
                        @error('isBroken')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Foto Alat -->
                    <div class="col-span-2">
                        <label for="image" class="block text-sm font-bold text-gray-700 mb-3">
                            Foto Alat
                        </label>
                        
                        @if($equipment->gambar && $equipment->gambar->first())
                        <div class="mb-4 p-4 bg-gray-50 rounded-xl border border-gray-200">
                            <p class="text-sm font-medium text-gray-700 mb-2">Foto saat ini:</p>
                            <img src="{{ url('storage/' . $equipment->gambar->first()->url) }}" 
                                 alt="{{ $equipment->nama }}" 
                                 class="w-32 h-32 object-cover rounded-lg border border-gray-300">
                        </div>
                        @endif
                        
                        <div class="relative border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-blue-400 transition-all duration-200 bg-gray-50 hover:bg-blue-50">
                            <input type="file" 
                                   id="image" 
                                   name="image" 
                                   accept="image/*"
                                   class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            <div class="space-y-3">
                                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto">
                                    <i class="fas fa-cloud-upload-alt text-blue-500 text-2xl"></i>
                                </div>
                                <p class="text-sm font-medium text-gray-700">Klik atau seret file gambar ke sini</p>
                                <p class="text-xs text-gray-500">Format yang didukung: JPG, PNG, GIF. Maksimal 2MB.</p>
                                <p class="text-xs text-gray-400">Kosongkan jika tidak ingin mengubah foto</p>
                            </div>
                        </div>
                        @error('image')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end space-x-4 mt-8 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.equipment.index') }}" 
                       class="px-6 py-3 border border-gray-300 rounded-xl text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 font-semibold">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-300 shadow-lg hover:shadow-xl flex items-center font-semibold group">
                        <i class="fas fa-save mr-2 group-hover:scale-110 transition-transform"></i>
                        Update Alat
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    function updateStokTotal() {
        var stok = parseInt(document.getElementById('stok').value) || 0;
        var stokRusak = parseInt(document.getElementById('stok_rusak').value) || 0;
        var stokDipinjam = {{ $equipment->stok_dipinjam ?? 0 }};
        document.getElementById('stok_total_info').innerText = stok + stokRusak + stokDipinjam;
    }
    document.getElementById('stok').addEventListener('input', updateStokTotal);
    document.getElementById('stok_rusak').addEventListener('input', updateStokTotal);
    updateStokTotal();
});
</script>
@endsection 
 