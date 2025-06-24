@extends('admin.layouts.app')
@section('title', 'Edit Galeri Laboratorium')
@section('content')
<div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-6">Edit Galeri</h2>
    <form action="{{ route('admin.galeri.update', $galeri->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Judul</label>
            <input type="text" name="judul" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" value="{{ old('judul', $galeri->judul) }}" required>
            @error('judul')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Gambar Saat Ini</label>
            <img src="/{{ $galeri->gambar_url }}" alt="{{ $galeri->judul }}" class="w-32 h-20 object-cover rounded mb-2">
            <label class="block text-gray-700 font-semibold mb-2">Ganti Gambar (opsional)</label>
            <input type="file" name="gambar" accept="image/*" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            @error('gambar')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>
        <div class="flex justify-between items-center mt-6">
            <a href="{{ route('admin.galeri.index') }}" class="text-gray-600 hover:underline">Kembali</a>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Update</button>
        </div>
    </form>
</div>
@endsection 