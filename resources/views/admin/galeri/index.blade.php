@extends('admin.layouts.app')
@section('title', 'Manajemen Galeri Laboratorium')
@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold">Galeri Laboratorium</h2>
    <a href="{{ route('admin.galeri.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"><i class="fas fa-plus mr-2"></i>Tambah Galeri</a>
</div>
<table class="min-w-full bg-white rounded-lg shadow overflow-hidden">
    <thead class="bg-gray-100">
        <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Judul</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Gambar</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($galeri as $item)
        <tr class="border-b">
            <td class="px-6 py-4">{{ $loop->iteration }}</td>
            <td class="px-6 py-4">{{ $item->judul }}</td>
            <td class="px-6 py-4">
                <img src="{{ asset($item->gambar_url) }}" alt="{{ $item->judul }}" class="w-24 h-16 object-cover rounded">
            </td>
            <td class="px-6 py-4 flex space-x-2">
                <a href="{{ route('admin.galeri.edit', $item->id) }}" class="px-3 py-1 bg-yellow-400 text-white rounded hover:bg-yellow-500"><i class="fas fa-edit"></i></a>
                <form action="{{ route('admin.galeri.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus galeri ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600"><i class="fas fa-trash"></i></button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="4" class="px-6 py-4 text-center text-gray-500">Belum ada data galeri.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection 