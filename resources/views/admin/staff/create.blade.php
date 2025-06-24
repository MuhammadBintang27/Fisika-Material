@extends('admin.layouts.app')

@section('title', 'Tambah Staf')

@section('content')
<div class="max-w-xl mx-auto">
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-900">Tambah Staf</h2>
            <a href="{{ route('admin.staff.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <form action="{{ route('admin.staff.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">Nama <span class="text-red-500">*</span></label>
                        <input type="text" name="nama" id="nama" value="{{ old('nama') }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500 @error('nama') border-red-500 @enderror" placeholder="Nama staf">
                        @error('nama')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="jabatan" class="block text-sm font-medium text-gray-700 mb-2">Jabatan <span class="text-red-500">*</span></label>
                        <input type="text" name="jabatan" id="jabatan" value="{{ old('jabatan') }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500 @error('jabatan') border-red-500 @enderror" placeholder="Jabatan staf">
                        @error('jabatan')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Foto</label>
                        <input type="file" name="image" id="image" accept="image/*" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500 @error('image') border-red-500 @enderror">
                        @error('image')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div class="flex justify-end space-x-4 mt-8 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.staff.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg">Batal</a>
                    <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg flex items-center"><i class="fas fa-save mr-2"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 
 