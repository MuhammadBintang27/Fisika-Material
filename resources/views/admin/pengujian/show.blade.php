@extends('admin.layouts.app')

@section('title', 'Detail Pengujian')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Detail Pengujian</h2>
                <p class="text-gray-600">Informasi lengkap pengujian laboratorium</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.pengujian.edit', $pengujian->id) }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                    <i class="fas fa-edit mr-2"></i>
                    Edit
                </a>
                <a href="{{ route('admin.pengujian.index') }}" 
                   class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali
                </a>
            </div>
        </div>

        <!-- Status Badge -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Status Pengujian</h3>
                    <p class="text-gray-600">Status terkini pengujian</p>
                </div>
                <span class="px-4 py-2 text-sm font-medium rounded-full
                    @if($pengujian->status === 'PENDING') bg-yellow-100 text-yellow-800
                    @elseif($pengujian->status === 'PROCESSING') bg-blue-100 text-blue-800
                    @elseif($pengujian->status === 'COMPLETED') bg-green-100 text-green-800
                    @elseif($pengujian->status === 'CANCELLED') bg-red-100 text-red-800
                    @else bg-gray-100 text-gray-800
                    @endif">
                    {{ $pengujian->status }}
                </span>
            </div>
        </div>

        <!-- Penguji Information -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Penguji</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Penguji</label>
                    <p class="text-gray-900 font-medium">{{ $pengujian->namaPenguji }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">No. HP Penguji</label>
                    <p class="text-gray-900">{{ $pengujian->noHpPenguji }}</p>
                </div>
            </div>
        </div>

        <!-- Pengujian Details -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Detail Pengujian</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pengujian</label>
                    <p class="text-gray-900">{{ \Carbon\Carbon::parse($pengujian->tanggalPengujian)->format('d/m/Y H:i') }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Total Harga</label>
                    <p class="text-gray-900 font-bold text-lg">Rp {{ number_format($pengujian->totalHarga, 0, ',', '.') }}</p>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Pengujian</label>
                    <p class="text-gray-900">{{ $pengujian->deskripsi }}</p>
                </div>
            </div>
        </div>

        <!-- Jenis Pengujian -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Jenis Pengujian</h3>
            @if($pengujian->pengujianItems->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($pengujian->pengujianItems as $item)
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="font-medium text-gray-900">{{ $item->jenisPengujian->namaPengujian }}</h4>
                                    <p class="text-sm text-gray-600">Rp {{ number_format($item->jenisPengujian->hargaPerSampel, 0, ',', '.') }}</p>
                                </div>
                                <div class="text-right">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Tersedia
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <i class="fas fa-flask text-gray-400 text-3xl mb-3"></i>
                    <p class="text-gray-500">Belum ada jenis pengujian yang dipilih</p>
                </div>
            @endif
        </div>

        <!-- Timestamps -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Sistem</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Dibuat Pada</label>
                    <p class="text-gray-900">{{ \Carbon\Carbon::parse($pengujian->created_at)->format('d/m/Y H:i') }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Terakhir Diupdate</label>
                    <p class="text-gray-900">{{ \Carbon\Carbon::parse($pengujian->updated_at)->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-end space-x-4">
            <form action="{{ route('admin.pengujian.destroy', $pengujian->id) }}" method="POST" 
                  onsubmit="return confirm('Yakin ingin menghapus pengujian ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg flex items-center">
                    <i class="fas fa-trash mr-2"></i>
                    Hapus Pengujian
                </button>
            </form>
        </div>
    </div>
</div>
@endsection 
 