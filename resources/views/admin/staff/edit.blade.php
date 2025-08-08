@extends('admin.layouts.app')

@section('title', 'Edit Staf')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit Staf</h1>
            <p class="text-gray-600">Edit data staf dan tenaga ahli laboratorium</p>
        </div>
        <a href="{{ route('admin.staff.index') }}" 
           class="bg-gradient-to-r from-gray-600 to-gray-700 text-white px-6 py-3 rounded-lg hover:from-gray-700 hover:to-gray-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali ke Daftar
        </a>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 hover:shadow-xl transition-all duration-300">
        <form action="{{ route('admin.staff.update', $staff->id) }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            @method('PUT')
            <div class="space-y-6">
                <div>
                    <label for="nama" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nama <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="nama" 
                           id="nama" 
                           value="{{ old('nama', $staff->nama) }}" 
                           required 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 hover:border-blue-400 @error('nama') border-red-500 @enderror" 
                           placeholder="Nama staf">
                    @error('nama')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="jabatan" class="block text-sm font-semibold text-gray-700 mb-2">
                        Jabatan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="jabatan" 
                           id="jabatan" 
                           value="{{ old('jabatan', $staff->jabatan) }}" 
                           required 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 hover:border-blue-400 @error('jabatan') border-red-500 @enderror" 
                           placeholder="Jabatan staf">
                    @error('jabatan')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="image" class="block text-sm font-semibold text-gray-700 mb-2">Foto</label>
                    @if($staff->gambar->first())
                        <div class="mb-4">
                            <img src="{{ asset($staff->gambar->first()->url) }}" 
                                 alt="{{ $staff->nama }}" 
                                 class="w-24 h-24 rounded-lg object-cover shadow-md hover:shadow-lg transition-shadow">
                        </div>
                    @endif
                    <input type="file" 
                           name="image" 
                           id="image" 
                           accept="image/*" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 hover:border-blue-400 @error('image') border-red-500 @enderror">
                    <p class="text-xs text-gray-500 mt-1">Format yang didukung: JPG, PNG, GIF. Maksimal 2MB.</p>
                    @error('image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <!-- Submit Button -->
            <div class="flex justify-end space-x-4 mt-8 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.staff.index') }}" 
                   class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-all duration-200">
                    Batal
                </a>
                <button type="submit" 
                        class="px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center">
                    <i class="fas fa-save mr-2"></i>
                    Update Staf
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 
 