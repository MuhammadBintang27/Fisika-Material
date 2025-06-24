@extends('admin.layouts.app')
@section('title', 'Tambah Galeri Laboratorium')
@section('content')
<div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-6">Tambah Galeri</h2>
    <form action="{{ route('admin.galeri.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Judul</label>
            <input type="text" name="judul" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" value="{{ old('judul') }}" required>
            @error('judul')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Gambar</label>
            <input type="file" name="gambar" accept="image/*" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            @error('gambar')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>
        <div class="flex justify-between items-center mt-6">
            <a href="{{ route('admin.galeri.index') }}" class="text-gray-600 hover:underline">Kembali</a>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Simpan</button>
        </div>
    </form>
</div>
@endsection 