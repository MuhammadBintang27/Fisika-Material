@extends('admin.layouts.app')

@section('title', 'Galeri & Fasilitas Laboratorium')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="bg-gradient-to-br from-blue-700 to-blue-800 rounded-xl p-8 text-white shadow-xl border border-blue-600">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold mb-2">Galeri & Fasilitas Laboratorium</h1>
                <p class="text-blue-100 text-lg">Kelola foto dan fasilitas laboratorium</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.galeri.create') }}" 
                   class="px-6 py-3 bg-white/90 backdrop-blur-sm text-blue-700 rounded-xl font-semibold shadow-lg hover:shadow-xl hover:bg-white transition-all duration-300 flex items-center">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Galeri
                </a>
            </div>
        </div>
    </div>

    <!-- Fasilitas Section -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-cog text-green-600"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Fasilitas Laboratorium</h2>
                        <p class="text-gray-500 text-sm">Kelola daftar fasilitas yang tersedia</p>
                    </div>
                </div>
            </div>

            <form id="fasilitasForm" method="POST">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                        Fasilitas <span class="text-red-500">*</span>
                    </label>
                    
                    <div id="fasilitas-container" class="space-y-3 mb-4">
                        @if($fasilitas->count() > 0)
                            @foreach($fasilitas as $item)
                            <div class="fasilitas-item bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-800 font-medium">{{ $item->nama }}</span>
                                    <div class="flex items-center space-x-2">
                                        <button type="button" 
                                                onclick="editFasilitas({{ $item->id }}, '{{ $item->nama }}')"
                                                class="w-8 h-8 text-blue-600 hover:bg-blue-100 rounded-lg transition-all duration-200 flex items-center justify-center">
                                            <i class="fas fa-edit text-sm"></i>
                                        </button>
                                        <form action="{{ route('admin.galeri.fasilitas.destroy', $item->id) }}" 
                                              method="POST" 
                                              onsubmit="return confirm('Yakin hapus fasilitas ini?')" 
                                              class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="w-8 h-8 text-red-600 hover:bg-red-100 rounded-lg transition-all duration-200 flex items-center justify-center">
                                                <i class="fas fa-trash text-sm"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="text-center py-8 text-gray-500">
                                <i class="fas fa-cog text-2xl mb-2"></i>
                                <p>Belum ada fasilitas</p>
                            </div>
                        @endif
                    </div>
                    
                    <button type="button" 
                            onclick="openAddFasilitasModal()"
                            class="w-full py-3 border-2 border-dashed border-green-300 rounded-lg text-green-600 hover:border-green-500 hover:text-green-700 hover:bg-green-50 transition-all duration-200 flex items-center justify-center font-medium">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Fasilitas
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Galeri Section -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
        <div class="p-6">
            <div class="flex items-center space-x-3 mb-6">
                <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-images text-blue-600"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Galeri Laboratorium</h2>
                    <p class="text-gray-500 text-sm">Kelola foto dan dokumentasi laboratorium</p>
                </div>
            </div>
            @if($galeri->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    <i class="fas fa-hashtag mr-2"></i>No
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    <i class="fas fa-heading mr-2"></i>Judul
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    <i class="fas fa-image mr-2"></i>Gambar
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    <i class="fas fa-cog mr-2"></i>Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($galeri as $item)
                                <tr class="hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 transition-all duration-200">
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full text-sm font-bold bg-blue-100 text-blue-600">
                                            {{ $loop->iteration }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-semibold text-gray-900 hover:text-blue-600 transition-colors">
                                            {{ $item->judul }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="relative group">
                                            <img src="{{ url('storage/' . $item->gambar_url) }}" 
                                                 alt="{{ $item->judul }}" 
                                                 class="w-24 h-16 object-cover rounded-xl shadow-md hover:shadow-lg transition-all duration-300 group-hover:scale-105">
                                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 rounded-xl transition-all duration-300 flex items-center justify-center">
                                                <i class="fas fa-eye text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300"></i>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center space-x-3">
                                            <a href="{{ route('admin.galeri.edit', $item->id) }}" 
                                               class="flex items-center justify-center w-10 h-10 text-yellow-600 hover:text-white hover:bg-yellow-500 rounded-xl transition-all duration-200 border border-yellow-200 hover:border-yellow-500">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.galeri.destroy', $item->id) }}" 
                                                  method="POST" 
                                                  onsubmit="return confirm('Yakin hapus galeri ini?')" 
                                                  class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="flex items-center justify-center w-10 h-10 text-red-600 hover:text-white hover:bg-red-500 rounded-xl transition-all duration-200 border border-red-200 hover:border-red-500">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-20">
                    <div class="w-32 h-32 bg-gradient-to-br from-blue-100 to-blue-200 rounded-full flex items-center justify-center mx-auto mb-8">
                        <i class="fas fa-images text-blue-500 text-4xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Belum Ada Galeri</h3>
                    <p class="text-gray-500 mb-8 max-w-lg mx-auto text-lg">Mulai dengan menambahkan galeri pertama untuk menampilkan foto laboratorium</p>
                    <a href="{{ route('admin.galeri.create') }}" 
                       class="px-8 py-4 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl font-semibold shadow-xl hover:shadow-2xl hover:from-blue-700 hover:to-blue-800 transition-all duration-300 inline-flex items-center text-lg">
                        <i class="fas fa-plus mr-3"></i>
                        Tambah Galeri Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal Tambah Fasilitas -->
<div id="addFasilitasModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl p-6 w-full max-w-md mx-4">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-gray-900">
                <i class="fas fa-plus text-green-600 mr-2"></i>
                Tambah Fasilitas
            </h3>
            <button onclick="closeAddFasilitasModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form action="{{ route('admin.galeri.fasilitas.store') }}" method="POST">
            @csrf
            <div class="mb-6">
                <label for="nama" class="block text-sm font-semibold text-gray-700 mb-2">
                    Nama Fasilitas <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="nama" 
                       name="nama" 
                       required
                       placeholder="Masukkan nama fasilitas..."
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200">
            </div>
            <div class="flex justify-end space-x-3">
                <button type="button" 
                        onclick="closeAddFasilitasModal()"
                        class="px-6 py-2 text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50 transition-all duration-200">
                    Batal
                </button>
                <button type="submit" 
                        class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-all duration-200 flex items-center">
                    <i class="fas fa-save mr-2"></i>
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Fasilitas -->
<div id="editFasilitasModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl p-6 w-full max-w-md mx-4">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-gray-900">
                <i class="fas fa-edit text-blue-600 mr-2"></i>
                Edit Fasilitas
            </h3>
            <button onclick="closeEditFasilitasModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="editFasilitasForm" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-6">
                <label for="edit_nama" class="block text-sm font-semibold text-gray-700 mb-2">
                    Nama Fasilitas <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="edit_nama" 
                       name="nama" 
                       required
                       placeholder="Masukkan nama fasilitas..."
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
            </div>
            <div class="flex justify-end space-x-3">
                <button type="button" 
                        onclick="closeEditFasilitasModal()"
                        class="px-6 py-2 text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50 transition-all duration-200">
                    Batal
                </button>
                <button type="submit" 
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all duration-200 flex items-center">
                    <i class="fas fa-save mr-2"></i>
                    Update
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openAddFasilitasModal() {
    document.getElementById('addFasilitasModal').classList.remove('hidden');
    document.getElementById('addFasilitasModal').classList.add('flex');
}

function closeAddFasilitasModal() {
    document.getElementById('addFasilitasModal').classList.add('hidden');
    document.getElementById('addFasilitasModal').classList.remove('flex');
}

function editFasilitas(id, nama) {
    document.getElementById('editFasilitasForm').action = `/admin/galeri/fasilitas/${id}`;
    document.getElementById('edit_nama').value = nama;
    document.getElementById('editFasilitasModal').classList.remove('hidden');
    document.getElementById('editFasilitasModal').classList.add('flex');
}

function closeEditFasilitasModal() {
    document.getElementById('editFasilitasModal').classList.add('hidden');
    document.getElementById('editFasilitasModal').classList.remove('flex');
}

// Close modal when clicking outside
document.getElementById('addFasilitasModal').addEventListener('click', function(e) {
    if (e.target === this) closeAddFasilitasModal();
});

document.getElementById('editFasilitasModal').addEventListener('click', function(e) {
    if (e.target === this) closeEditFasilitasModal();
});
</script>
@endsection 