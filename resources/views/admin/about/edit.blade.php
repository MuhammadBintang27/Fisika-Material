@extends('admin.layouts.app')

@section('title', 'Edit Profil Laboratorium')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Edit Profil Laboratorium</h1>
                <p class="text-gray-600">Perbarui informasi profil laboratorium</p>
            </div>
            <a href="{{ route('admin.about.index') }}" 
               class="text-gray-600 hover:text-gray-900">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke Profil
            </a>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <form method="POST" action="{{ route('admin.about.update') }}" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <!-- Laboratory Name -->
                <div>
                    <label for="namaLaboratorium" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Laboratorium <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="namaLaboratorium" 
                           name="namaLaboratorium" 
                           value="{{ old('namaLaboratorium', $profil->namaLaboratorium ?? '') }}"
                           class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                           placeholder="Masukkan nama laboratorium"
                           required>
                    @error('namaLaboratorium')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- About Laboratory -->
                <div>
                    <label for="tentangLaboratorium" class="block text-sm font-medium text-gray-700 mb-2">
                        Tentang Laboratorium <span class="text-red-500">*</span>
                    </label>
                    <textarea id="tentangLaboratorium" 
                              name="tentangLaboratorium" 
                              rows="6"
                              class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                              placeholder="Deskripsikan tentang laboratorium ini..."
                              required>{{ old('tentangLaboratorium', $profil->tentangLaboratorium ?? '') }}</textarea>
                    @error('tentangLaboratorium')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Vision -->
                <div>
                    <label for="visi" class="block text-sm font-medium text-gray-700 mb-2">
                        Visi <span class="text-red-500">*</span>
                    </label>
                    <textarea id="visi" 
                              name="visi" 
                              rows="4"
                              class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                              placeholder="Tulis visi laboratorium..."
                              required>{{ old('visi', $profil->visi ?? '') }}</textarea>
                    @error('visi')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Mission -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Misi <span class="text-red-500">*</span>
                    </label>
                    <div id="misiContainer" class="space-y-3">
                        @if($misis->count() > 0)
                            @foreach($misis as $index => $misi)
                                <div class="misi-item flex items-center space-x-2">
                                    <input type="text" 
                                           name="misi[]" 
                                           value="{{ old('misi.' . $index, $misi->pointMisi) }}"
                                           class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                                           placeholder="Tulis misi {{ $index + 1 }}..."
                                           required>
                                    @if($index > 0)
                                        <button type="button" 
                                                onclick="removeMisi(this)"
                                                class="px-3 py-2 text-red-600 hover:text-red-700">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    @endif
                                </div>
                            @endforeach
                        @else
                            <div class="misi-item flex items-center space-x-2">
                                <input type="text" 
                                       name="misi[]" 
                                       value="{{ old('misi.0') }}"
                                       class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                                       placeholder="Tulis misi 1..."
                                       required>
                            </div>
                        @endif
                    </div>
                    <button type="button" 
                            onclick="addMisi()"
                            class="mt-3 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Misi
                    </button>
                    @error('misi')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.about.index') }}" 
                       class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-colors">
                        <i class="fas fa-save mr-2"></i>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
        <!-- Preview Section -->
        <div class="mt-12">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Preview Tampilan Website</h2>
            @php
                // Simulasikan data preview dari input form jika ada, jika tidak pakai data dari DB
                $previewProfil = (object) [
                    'namaLaboratorium' => old('namaLaboratorium', $profil->namaLaboratorium ?? 'Fisika Dasar'),
                    'tentangLaboratorium' => old('tentangLaboratorium', $profil->tentangLaboratorium ?? ''),
                    'visi' => old('visi', $profil->visi ?? ''),
                ];
                $previewMisis = collect(old('misi', $misis->pluck('pointMisi')->toArray() ?: []))->map(function($misi) {
                    return (object)['pointMisi' => $misi];
                });
            @endphp
            @component('components.about', ['profil' => $previewProfil, 'misis' => $previewMisis])
            @endcomponent
        </div>
    </div>
</div>

<script>
let misiCount = {{ $misis->count() > 0 ? $misis->count() : 1 }};

function addMisi() {
    misiCount++;
    const container = document.getElementById('misiContainer');
    const newMisi = document.createElement('div');
    newMisi.className = 'misi-item flex items-center space-x-2';
    newMisi.innerHTML = `
        <input type="text" 
               name="misi[]" 
               class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
               placeholder="Tulis misi ${misiCount}..."
               required>
        <button type="button" 
                onclick="removeMisi(this)"
                class="px-3 py-2 text-red-600 hover:text-red-700">
            <i class="fas fa-trash"></i>
        </button>
    `;
    container.appendChild(newMisi);
}

function removeMisi(button) {
    const misiItem = button.parentElement;
    misiItem.remove();
    misiCount--;
}
</script>
@endsection 
 