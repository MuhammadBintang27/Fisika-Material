@extends('admin.layouts.app')

@section('title', 'Edit Alat')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit Alat</h1>
            <p class="text-gray-600">Edit data alat dan peralatan laboratorium</p>
        </div>
        <a href="{{ route('admin.equipment.index') }}" 
           class="bg-gradient-to-r from-gray-600 to-gray-700 text-white px-6 py-3 rounded-lg hover:from-gray-700 hover:to-gray-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali ke Daftar
        </a>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 hover:shadow-xl transition-all duration-300">
        <form action="{{ route('admin.equipment.update', $equipment->id) }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama Alat -->
                <div class="col-span-2">
                    <label for="nama" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nama Alat <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="nama" 
                           name="nama" 
                           value="{{ old('nama', $equipment->nama) }}"
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
                              required>{{ old('deskripsi', $equipment->deskripsi) }}</textarea>
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
                           value="{{ old('stok', $equipment->stok) }}"
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
                           value="{{ old('stok_rusak', $equipment->stok_rusak ?? 0) }}"
                           min="0"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 hover:border-green-400"
                           placeholder="Jumlah alat rusak">
                    @error('stok_rusak')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <!-- Jumlah Diperbaiki -->
                <div>
                    <label for="jumlah_perbaikan" class="block text-sm font-semibold text-gray-700 mb-2">
                        Jumlah Diperbaiki (pindah dari rusak ke tersedia)
                    </label>
                    <input type="number"
                           id="jumlah_perbaikan"
                           name="jumlah_perbaikan"
                           value="0"
                           min="0"
                           max="{{ $equipment->stok_rusak ?? 0 }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 hover:border-green-400"
                           placeholder="Jumlah alat yang berhasil diperbaiki">
                    @error('jumlah_perbaikan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <!-- Status Otomatis -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Status Otomatis</label>
                    <div class="px-4 py-3 rounded-lg bg-gradient-to-r from-blue-50 to-blue-100 border border-blue-200">
                        <span class="font-semibold text-blue-700">
                            {{ ($equipment->stok ?? 0) > 0 ? 'Tersedia' : 'Tidak Tersedia' }}
                        </span>
                    </div>
                </div>
                <!-- Stok Total (Info Otomatis) -->
                <div class="col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Stok Total (Otomatis)</label>
                    <div class="px-4 py-3 rounded-lg bg-gradient-to-r from-green-50 to-green-100 border border-green-200">
                        <span id="stok_total_info" class="font-semibold text-green-700">{{ ($equipment->stok ?? 0) + ($equipment->stok_dipinjam ?? 0) + ($equipment->stok_rusak ?? 0) }}</span> unit
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
                    Update Alat
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 
 