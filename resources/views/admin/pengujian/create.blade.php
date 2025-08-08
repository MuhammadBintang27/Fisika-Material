@extends('admin.layouts.app')

@section('title', 'Tambah Pengujian')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Tambah Pengujian Baru</h1>
            <p class="text-gray-600">Tambah pengujian laboratorium baru</p>
        </div>
        <a href="{{ route('admin.pengujian.index') }}" 
           class="bg-gradient-to-r from-gray-600 to-gray-700 text-white px-6 py-3 rounded-lg hover:from-gray-700 hover:to-gray-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali ke Daftar
        </a>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 hover:shadow-xl transition-all duration-300">
        <form action="{{ route('admin.pengujian.store') }}" method="POST" class="p-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama Penguji -->
                <div class="md:col-span-2">
                    <label for="namaPenguji" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nama Penguji <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="namaPenguji" id="namaPenguji" 
                           value="{{ old('namaPenguji') }}" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 hover:border-blue-400 @error('namaPenguji') border-red-500 @enderror"
                           placeholder="Masukkan nama penguji">
                    @error('namaPenguji')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- No HP Penguji -->
                <div class="md:col-span-2">
                    <label for="noHpPenguji" class="block text-sm font-semibold text-gray-700 mb-2">
                        No. HP Penguji <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="noHpPenguji" id="noHpPenguji" 
                           value="{{ old('noHpPenguji') }}" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 hover:border-blue-400 @error('noHpPenguji') border-red-500 @enderror"
                           placeholder="Masukkan nomor HP penguji">
                    @error('noHpPenguji')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div class="md:col-span-2">
                    <label for="deskripsi" class="block text-sm font-semibold text-gray-700 mb-2">
                        Deskripsi Pengujian <span class="text-red-500">*</span>
                    </label>
                    <textarea name="deskripsi" id="deskripsi" rows="4" required
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 hover:border-blue-400 @error('deskripsi') border-red-500 @enderror"
                              placeholder="Masukkan deskripsi pengujian">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Total Harga -->
                <div>
                    <label for="totalHarga" class="block text-sm font-semibold text-gray-700 mb-2">
                        Total Harga <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-3 text-gray-500">Rp</span>
                        <input type="number" name="totalHarga" id="totalHarga" 
                               value="{{ old('totalHarga') }}" required min="0"
                               class="w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 hover:border-blue-400 @error('totalHarga') border-red-500 @enderror"
                               placeholder="0">
                    </div>
                    @error('totalHarga')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tanggal Pengujian -->
                <div>
                    <label for="tanggalPengujian" class="block text-sm font-semibold text-gray-700 mb-2">
                        Tanggal Pengujian <span class="text-red-500">*</span>
                    </label>
                    <input type="datetime-local" name="tanggalPengujian" id="tanggalPengujian" 
                           value="{{ old('tanggalPengujian') }}" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 hover:border-blue-400 @error('tanggalPengujian') border-red-500 @enderror">
                    @error('tanggalPengujian')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select name="status" id="status" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 hover:border-blue-400 @error('status') border-red-500 @enderror">
                        <option value="">Pilih Status</option>
                        <option value="PENDING" {{ old('status') === 'PENDING' ? 'selected' : '' }}>Pending</option>
                        <option value="PROCESSING" {{ old('status') === 'PROCESSING' ? 'selected' : '' }}>Processing</option>
                        <option value="COMPLETED" {{ old('status') === 'COMPLETED' ? 'selected' : '' }}>Completed</option>
                        <option value="CANCELLED" {{ old('status') === 'CANCELLED' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    @error('status')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jenis Pengujian -->
                <div>
                    <label for="jenisPengujian" class="block text-sm font-semibold text-gray-700 mb-2">
                        Jenis Pengujian <span class="text-red-500">*</span>
                    </label>
                    <select name="jenisPengujian" id="jenisPengujian" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 hover:border-blue-400 @error('jenisPengujian') border-red-500 @enderror">
                        <option value="">Pilih Jenis Pengujian</option>
                        @foreach($jenisPengujian as $jenis)
                            <option value="{{ $jenis->id }}" {{ old('jenisPengujian') == $jenis->id ? 'selected' : '' }}>
                                {{ $jenis->namaPengujian }} - Rp {{ number_format($jenis->hargaPerSampel, 0, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                    @error('jenisPengujian')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end space-x-4 mt-8 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.pengujian.index') }}" 
                   class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-all duration-200">
                    Batal
                </a>
                <button type="submit" 
                        class="px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center">
                    <i class="fas fa-save mr-2"></i>
                    Simpan Pengujian
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 
 