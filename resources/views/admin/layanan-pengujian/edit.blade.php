@extends('admin.layouts.app')

@section('title', 'Edit Layanan Pengujian')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit Layanan Pengujian</h1>
            <p class="text-gray-600">Edit data layanan pengujian laboratorium</p>
        </div>
        <a href="{{ route('admin.layanan-pengujian.index') }}" 
           class="bg-gradient-to-r from-gray-600 to-gray-700 text-white px-6 py-3 rounded-lg hover:from-gray-700 hover:to-gray-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali ke Daftar
        </a>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 hover:shadow-xl transition-all duration-300">
        <form action="{{ route('admin.layanan-pengujian.update', $layananPengujian->id) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                <!-- Nama Layanan -->
                <div>
                    <label for="namaLayanan" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nama Layanan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="namaLayanan" id="namaLayanan" 
                           value="{{ old('namaLayanan', $layananPengujian->namaLayanan) }}" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 hover:border-blue-400 @error('namaLayanan') border-red-500 @enderror"
                           placeholder="Masukkan nama layanan pengujian">
                    @error('namaLayanan')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Harga -->
                <div>
                    <label for="harga" class="block text-sm font-semibold text-gray-700 mb-2">
                        Harga <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-3 text-gray-500">Rp</span>
                        <input type="number" name="harga" id="harga" 
                               value="{{ old('harga', $layananPengujian->harga) }}" required min="0"
                               class="w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 hover:border-blue-400 @error('harga') border-red-500 @enderror"
                               placeholder="0">
                    </div>
                    @error('harga')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status Ketersediaan -->
                <div>
                    <label for="isAktif" class="block text-sm font-semibold text-gray-700 mb-2">
                        Status Ketersediaan <span class="text-red-500">*</span>
                    </label>
                    <select name="isAktif" id="isAktif" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 hover:border-blue-400 @error('isAktif') border-red-500 @enderror">
                        <option value="">Pilih Status</option>
                        <option value="1" {{ old('isAktif', $layananPengujian->isAktif) == 1 ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ old('isAktif', $layananPengujian->isAktif) == 0 ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                    @error('isAktif')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Estimasi Selesai (Hari) -->
                <div>
                    <label for="estimasiSelesaiHari" class="block text-sm font-semibold text-gray-700 mb-2">
                        Estimasi Selesai (Hari) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="estimasiSelesaiHari" id="estimasiSelesaiHari" 
                           value="{{ old('estimasiSelesaiHari', $layananPengujian->estimasiSelesaiHari) }}" required min="1" max="365"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 hover:border-blue-400 @error('estimasiSelesaiHari') border-red-500 @enderror"
                           placeholder="Masukkan estimasi waktu penyelesaian dalam hari">
                    @error('estimasiSelesaiHari')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Instruksi Sampel -->
                <div>
                    <label for="instruksiSampel" class="block text-sm font-semibold text-gray-700 mb-2">
                        Instruksi Sampel
                    </label>
                    <textarea name="instruksiSampel" id="instruksiSampel" rows="3"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 hover:border-blue-400 @error('instruksiSampel') border-red-500 @enderror"
                              placeholder="Masukkan instruksi khusus untuk pengambilan sampel (opsional)">{{ old('instruksiSampel', $layananPengujian->instruksiSampel) }}</textarea>
                    @error('instruksiSampel')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div>
                    <label for="deskripsi" class="block text-sm font-semibold text-gray-700 mb-2">
                        Deskripsi
                    </label>
                    <textarea name="deskripsi" id="deskripsi" rows="4"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 hover:border-blue-400 @error('deskripsi') border-red-500 @enderror"
                              placeholder="Masukkan deskripsi layanan pengujian (opsional)">{{ old('deskripsi', $layananPengujian->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end space-x-4 mt-8 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.layanan-pengujian.index') }}" 
                   class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-all duration-200">
                    Batal
                </a>
                <button type="submit" 
                        class="px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center">
                    <i class="fas fa-save mr-2"></i>
                    Update Layanan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
