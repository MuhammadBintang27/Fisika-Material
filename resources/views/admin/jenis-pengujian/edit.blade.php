@extends('admin.layouts.app')

@section('title', 'Edit Jenis Pengujian')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Edit Jenis Pengujian</h2>
                <p class="text-gray-600">Edit data jenis pengujian laboratorium</p>
            </div>
            <a href="{{ route('admin.jenis-pengujian.index') }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <form action="{{ route('admin.jenis-pengujian.update', $jenisPengujian->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="space-y-6">
                    <!-- Nama Pengujian -->
                    <div>
                        <label for="namaPengujian" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Pengujian <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="namaPengujian" id="namaPengujian" 
                               value="{{ old('namaPengujian', $jenisPengujian->namaPengujian) }}" required
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('namaPengujian') border-red-500 @enderror"
                               placeholder="Masukkan nama jenis pengujian">
                        @error('namaPengujian')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Harga per Sampel -->
                    <div>
                        <label for="hargaPerSampel" class="block text-sm font-medium text-gray-700 mb-2">
                            Harga per Sampel <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-2 text-gray-500">Rp</span>
                            <input type="number" name="hargaPerSampel" id="hargaPerSampel" 
                                   value="{{ old('hargaPerSampel', $jenisPengujian->hargaPerSampel) }}" required min="0"
                                   class="w-full border border-gray-300 rounded-lg pl-10 pr-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('hargaPerSampel') border-red-500 @enderror"
                                   placeholder="0">
                        </div>
                        @error('hargaPerSampel')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status Ketersediaan -->
                    <div>
                        <label for="isAvailable" class="block text-sm font-medium text-gray-700 mb-2">
                            Status Ketersediaan <span class="text-red-500">*</span>
                        </label>
                        <select name="isAvailable" id="isAvailable" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('isAvailable') border-red-500 @enderror">
                            <option value="">Pilih Status</option>
                            <option value="1" {{ old('isAvailable', $jenisPengujian->isAvailable) == 1 ? 'selected' : '' }}>Tersedia</option>
                            <option value="0" {{ old('isAvailable', $jenisPengujian->isAvailable) == 0 ? 'selected' : '' }}>Tidak Tersedia</option>
                        </select>
                        @error('isAvailable')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end space-x-4 mt-8 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.jenis-pengujian.index') }}" 
                       class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg">
                        Batal
                    </a>
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg flex items-center">
                        <i class="fas fa-save mr-2"></i>
                        Update Jenis Pengujian
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 
 