@extends('admin.layouts.app')

@section('title', 'Detail Pengujian')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Detail Pengujian</h1>
            <p class="text-gray-600">Informasi lengkap pengujian laboratorium</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.pengujian.edit', $pengujian->id) }}" 
               class="bg-gradient-to-r from-yellow-600 to-yellow-700 text-white px-6 py-3 rounded-lg hover:from-yellow-700 hover:to-yellow-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center">
                <i class="fas fa-edit mr-2"></i>
                Edit
            </a>
            <a href="{{ route('admin.pengujian.index') }}" 
               class="bg-gradient-to-r from-gray-600 to-gray-700 text-white px-6 py-3 rounded-lg hover:from-gray-700 hover:to-gray-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke Daftar
            </a>
        </div>
    </div>

    <!-- Status Badge -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 hover:shadow-xl transition-all duration-300 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Status Pengujian</h3>
                <p class="text-gray-600">Status terkini pengujian</p>
            </div>
            @if($pengujian->status === 'PENDING')
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                    Pending
                </span>
            @elseif($pengujian->status === 'PROCESSING')
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    Processing
                </span>
            @elseif($pengujian->status === 'COMPLETED')
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                    Completed
                </span>
            @elseif($pengujian->status === 'CANCELLED')
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                    Cancelled
                </span>
            @endif
        </div>
    </div>

    <!-- Penguji Information -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 hover:shadow-xl transition-all duration-300 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Penguji</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Penguji</label>
                <p class="text-gray-900 font-semibold bg-gradient-to-r from-gray-50 to-gray-100 px-3 py-2 rounded-lg">{{ $pengujian->namaPenguji }}</p>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">No. HP Penguji</label>
                <p class="text-gray-900 bg-gradient-to-r from-gray-50 to-gray-100 px-3 py-2 rounded-lg">{{ $pengujian->noHpPenguji }}</p>
            </div>
        </div>
    </div>

    <!-- Pengujian Details -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 hover:shadow-xl transition-all duration-300 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Detail Pengujian</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Pengujian</label>
                <p class="text-gray-900 bg-gradient-to-r from-gray-50 to-gray-100 px-3 py-2 rounded-lg">{{ \Carbon\Carbon::parse($pengujian->tanggalPengujian)->format('d/m/Y H:i') }}</p>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Total Harga</label>
                <p class="text-green-600 font-bold text-lg bg-gradient-to-r from-green-50 to-green-100 px-3 py-2 rounded-lg">Rp {{ number_format($pengujian->totalHarga, 0, ',', '.') }}</p>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi Pengujian</label>
                <p class="text-gray-900 bg-gradient-to-r from-gray-50 to-gray-100 px-3 py-2 rounded-lg">{{ $pengujian->deskripsi }}</p>
            </div>
        </div>
    </div>

    <!-- Jenis Pengujian -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 hover:shadow-xl transition-all duration-300 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Jenis Pengujian</h3>
        @if($pengujian->pengujianItems->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($pengujian->pengujianItems as $item)
                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-all duration-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="font-semibold text-gray-900 hover:text-blue-600 transition-colors">{{ $item->jenisPengujian->namaPengujian }}</h4>
                                <p class="text-sm text-green-600 font-semibold">Rp {{ number_format($item->jenisPengujian->hargaPerSampel, 0, ',', '.') }}</p>
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
                <div class="w-16 h-16 bg-gradient-to-br from-gray-200 to-gray-300 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-flask text-gray-400 text-xl"></i>
                </div>
                <p class="text-gray-500">Tidak ada jenis pengujian yang dipilih</p>
            </div>
        @endif
    </div>

    <!-- Timestamps -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 hover:shadow-xl transition-all duration-300 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Sistem</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Dibuat Pada</label>
                <p class="text-gray-900 bg-gradient-to-r from-gray-50 to-gray-100 px-3 py-2 rounded-lg">{{ $pengujian->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Terakhir Diperbarui</label>
                <p class="text-gray-900 bg-gradient-to-r from-gray-50 to-gray-100 px-3 py-2 rounded-lg">{{ $pengujian->updated_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection 
 