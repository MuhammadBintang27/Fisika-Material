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
           class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali ke Daftar
        </a>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <form action="{{ route('admin.equipment.update', $equipment->id) }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama Alat -->
                <div class="col-span-2">
                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Alat <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="nama" 
                           name="nama" 
                           value="{{ old('nama', $equipment->nama) }}"
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
                              required>{{ old('deskripsi', $equipment->deskripsi) }}</textarea>
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
                           value="{{ old('stok', $equipment->stok) }}"
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
                           value="{{ old('stok_rusak', $equipment->stok_rusak ?? 0) }}"
                           min="0"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                           placeholder="Jumlah alat rusak">
                    @error('stok_rusak')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <!-- Jumlah Diperbaiki -->
                <div>
                    <label for="jumlah_perbaikan" class="block text-sm font-medium text-gray-700 mb-2">
                        Jumlah Diperbaiki (pindah dari rusak ke tersedia)
                    </label>
                    <input type="number"
                           id="jumlah_perbaikan"
                           name="jumlah_perbaikan"
                           value="0"
                           min="0"
                           max="{{ $equipment->stok_rusak ?? 0 }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                           placeholder="Jumlah alat yang berhasil diperbaiki">
                    @error('jumlah_perbaikan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <!-- Status Otomatis -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status Otomatis</label>
                    <div class="px-3 py-2 rounded-lg bg-gray-100 border border-gray-200">
                        {{ ($equipment->stok ?? 0) > 0 ? 'Tersedia' : 'Tidak Tersedia' }}
                    </div>
                </div>
                <!-- Stok Total (Info Otomatis) -->
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Stok Total (Otomatis)</label>
                    <div class="px-3 py-2 rounded-lg bg-gray-100 border border-gray-200">
                        <span id="stok_total_info">{{ ($equipment->stok ?? 0) + ($equipment->stok_dipinjam ?? 0) + ($equipment->stok_rusak ?? 0) }}</span> unit
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
            <div class="flex justify-end space-x-3 mt-8">
                <a href="{{ route('admin.equipment.index') }}" 
                   class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                    <i class="fas fa-save mr-2"></i>
                    Update Alat
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 
 