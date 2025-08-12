@extends('admin.layouts.app')

@section('title', 'Tambah Layanan Pengujian')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="bg-gradient-to-br from-blue-700 to-blue-800 rounded-xl p-8 text-white shadow-xl border border-blue-600">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold mb-2">Tambah Layanan Pengujian</h1>
                <p class="text-blue-100 text-lg">Tambah layanan pengujian baru ke laboratorium</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.layanan-pengujian.index') }}" 
                   class="bg-white/20 backdrop-blur-sm rounded-xl p-4 hover:bg-white/30 transition-all duration-300 shadow-lg hover:shadow-xl group">
                    <i class="fas fa-arrow-left text-xl group-hover:scale-110 transition-transform"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                    <i class="fas fa-plus text-white"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900">Form Tambah Layanan</h3>
            </div>
        </div>
        
        <form action="{{ route('admin.layanan-pengujian.store') }}" method="POST" class="p-8">
            @csrf
            
            <div class="space-y-6">
                <!-- Nama Layanan -->
                <div>
                    <label for="namaLayanan" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nama Layanan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="namaLayanan" id="namaLayanan" 
                           value="{{ old('namaLayanan') }}" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 hover:border-blue-400 @error('namaLayanan') border-red-500 @enderror"
                           placeholder="Masukkan nama layanan pengujian">
                    @error('namaLayanan')
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
                              placeholder="Masukkan deskripsi layanan pengujian (opsional)">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Estimasi Selesai (Hari) -->
                <div>
                    <label for="estimasiSelesaiHari" class="block text-sm font-semibold text-gray-700 mb-2">
                        Estimasi Selesai (Hari) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="estimasiSelesaiHari" id="estimasiSelesaiHari" 
                           value="{{ old('estimasiSelesaiHari') }}" required min="1" max="365"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 hover:border-blue-400 @error('estimasiSelesaiHari') border-red-500 @enderror"
                           placeholder="Jumlah hari">
                    @error('estimasiSelesaiHari')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Harga -->
                <div>
                    <label for="harga" class="block text-sm font-semibold text-gray-700 mb-2">
                        Harga
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-3 text-gray-500">Rp</span>
                        <input type="number" name="harga" id="harga" 
                               value="{{ old('harga') }}" min="0"
                               class="w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 hover:border-blue-400 @error('harga') border-red-500 @enderror"
                               placeholder="0">
                    </div>
                    @error('harga')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status Aktif -->
                <div>
                    <label for="isAktif" class="block text-sm font-semibold text-gray-700 mb-2">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select name="isAktif" id="isAktif" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 hover:border-blue-400 @error('isAktif') border-red-500 @enderror">
                        <option value="">Pilih Status</option>
                        <option value="1" {{ old('isAktif') == '1' ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ old('isAktif') == '0' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                    @error('isAktif')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Instruksi Sampel -->
                <div>
                    <label for="instruksiSampel" class="block text-sm font-semibold text-gray-700 mb-2">
                        Instruksi Sampel
                    </label>
                    <textarea name="instruksiSampel" id="instruksiSampel" rows="4"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 hover:border-blue-400 @error('instruksiSampel') border-red-500 @enderror"
                              placeholder="Masukkan instruksi pengambilan/persiapan sampel (opsional)">{{ old('instruksiSampel') }}</textarea>
                    @error('instruksiSampel')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end space-x-4 mt-8 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.layanan-pengujian.index') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl font-semibold">
                    <i class="fas fa-times mr-2"></i>
                    Batal
                </a>
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl font-semibold group">
                    <i class="fas fa-plus mr-2 group-hover:scale-110 transition-transform"></i>
                    Simpan Layanan Pengujian
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
