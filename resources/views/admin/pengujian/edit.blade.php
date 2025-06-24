@extends('admin.layouts.app')

@section('title', 'Edit Pengujian')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Edit Pengujian</h2>
                <p class="text-gray-600">Edit data pengujian laboratorium</p>
            </div>
            <a href="{{ route('admin.pengujian.index') }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <form action="{{ route('admin.pengujian.update', $pengujian->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nama Penguji -->
                    <div class="md:col-span-2">
                        <label for="namaPenguji" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Penguji <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="namaPenguji" id="namaPenguji" 
                               value="{{ old('namaPenguji', $pengujian->namaPenguji) }}" required
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('namaPenguji') border-red-500 @enderror"
                               placeholder="Masukkan nama penguji">
                        @error('namaPenguji')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- No HP Penguji -->
                    <div class="md:col-span-2">
                        <label for="noHpPenguji" class="block text-sm font-medium text-gray-700 mb-2">
                            No. HP Penguji <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="noHpPenguji" id="noHpPenguji" 
                               value="{{ old('noHpPenguji', $pengujian->noHpPenguji) }}" required
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('noHpPenguji') border-red-500 @enderror"
                               placeholder="Masukkan nomor HP penguji">
                        @error('noHpPenguji')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Deskripsi -->
                    <div class="md:col-span-2">
                        <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
                            Deskripsi Pengujian <span class="text-red-500">*</span>
                        </label>
                        <textarea name="deskripsi" id="deskripsi" rows="4" required
                                  class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('deskripsi') border-red-500 @enderror"
                                  placeholder="Masukkan deskripsi pengujian">{{ old('deskripsi', $pengujian->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Total Harga -->
                    <div>
                        <label for="totalHarga" class="block text-sm font-medium text-gray-700 mb-2">
                            Total Harga <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-2 text-gray-500">Rp</span>
                            <input type="number" name="totalHarga" id="totalHarga" 
                                   value="{{ old('totalHarga', $pengujian->totalHarga) }}" required min="0"
                                   class="w-full border border-gray-300 rounded-lg pl-10 pr-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('totalHarga') border-red-500 @enderror"
                                   placeholder="0">
                        </div>
                        @error('totalHarga')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal Pengujian -->
                    <div>
                        <label for="tanggalPengujian" class="block text-sm font-medium text-gray-700 mb-2">
                            Tanggal Pengujian <span class="text-red-500">*</span>
                        </label>
                        <input type="datetime-local" name="tanggalPengujian" id="tanggalPengujian" 
                               value="{{ old('tanggalPengujian', \Carbon\Carbon::parse($pengujian->tanggalPengujian)->format('Y-m-d\TH:i')) }}" required
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('tanggalPengujian') border-red-500 @enderror">
                        @error('tanggalPengujian')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select name="status" id="status" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('status') border-red-500 @enderror">
                            <option value="">Pilih Status</option>
                            <option value="PENDING" {{ old('status', $pengujian->status) === 'PENDING' ? 'selected' : '' }}>Pending</option>
                            <option value="PROCESSING" {{ old('status', $pengujian->status) === 'PROCESSING' ? 'selected' : '' }}>Processing</option>
                            <option value="COMPLETED" {{ old('status', $pengujian->status) === 'COMPLETED' ? 'selected' : '' }}>Completed</option>
                            <option value="CANCELLED" {{ old('status', $pengujian->status) === 'CANCELLED' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        @error('status')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jenis Pengujian -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Jenis Pengujian <span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @php
                                $selectedJenisIds = old('jenisPengujianIds', $pengujian->pengujianItems->pluck('jenisPengujianId')->toArray());
                            @endphp
                            @foreach($jenisPengujian as $jenis)
                                <label class="flex items-center p-4 border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer">
                                    <input type="checkbox" name="jenisPengujianIds[]" value="{{ $jenis->id }}"
                                           {{ in_array($jenis->id, $selectedJenisIds) ? 'checked' : '' }}
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-gray-900">{{ $jenis->namaPengujian }}</div>
                                        <div class="text-sm text-gray-500">Rp {{ number_format($jenis->hargaPerSampel, 0, ',', '.') }}</div>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                        @error('jenisPengujianIds')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end space-x-4 mt-8 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.pengujian.index') }}" 
                       class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg">
                        Batal
                    </a>
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg flex items-center">
                        <i class="fas fa-save mr-2"></i>
                        Update Pengujian
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 
 