@extends('admin.layouts.app')

@section('title', 'Detail Peminjaman')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Detail Peminjaman</h1>
                <p class="text-gray-600">Informasi lengkap peminjaman alat</p>
            </div>
            <a href="{{ route('admin.loans.index') }}" 
               class="text-gray-600 hover:text-gray-900">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke Daftar
            </a>
        </div>

        <!-- Loan Information -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Borrower Information -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Peminjam</h3>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nama Peminjam</label>
                                <p class="text-sm text-gray-900">{{ $loan->namaPeminjam }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nomor HP</label>
                                <p class="text-sm text-gray-900">{{ $loan->noHp }}</p>
                            </div>
                            @if($loan->tujuanPeminjaman)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tujuan Peminjaman</label>
                                    <p class="text-sm text-gray-900">{{ $loan->tujuanPeminjaman }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Loan Period -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Periode Peminjaman</h3>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tanggal Pinjam</label>
                                <p class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($loan->tanggal_pinjam)->format('d M Y') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tanggal Pengembalian</label>
                                <p class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($loan->tanggal_pengembalian)->format('d M Y') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Status</label>
                                <span class="px-2 py-1 text-xs font-medium rounded-full
                                    @if($loan->status === 'PENDING') bg-yellow-100 text-yellow-800
                                    @elseif($loan->status === 'APPROVED') bg-green-100 text-green-800
                                    @elseif($loan->status === 'REJECTED') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ $loan->status }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Equipment List -->
                <div class="mt-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Alat yang Dipinjam</h3>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="space-y-3">
                            @foreach($loan->items as $item)
                                <div class="flex items-center justify-between p-3 bg-white rounded-lg">
                                    <div class="flex items-center space-x-4">
                                        @if($item->alat->gambar && $item->alat->gambar->first())
                                            <img src="{{ asset($item->alat->gambar->first()->url) }}" 
                                                 alt="{{ $item->alat->namaAlat }}" 
                                                 class="w-12 h-12 rounded-lg object-cover">
                                        @else
                                            <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                                <i class="fas fa-tools text-gray-400"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <p class="font-medium text-gray-900">{{ $item->alat->namaAlat }}</p>
                                            <p class="text-sm text-gray-500">{{ $item->alat->deskripsi }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-medium text-gray-900">{{ $item->jumlah }} unit</p>
                                        <p class="text-sm text-gray-500">
                                            <span class="px-2 py-1 text-xs font-medium rounded-full
                                                @if($item->alat->kondisi === 'BAIK') bg-green-100 text-green-800
                                                @elseif($item->alat->kondisi === 'RUSAK') bg-red-100 text-red-800
                                                @else bg-yellow-100 text-yellow-800
                                                @endif">
                                                {{ $item->alat->kondisi }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Status Update Form -->
                @if($loan->status === 'PENDING')
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi Admin</h3>
                        <form id="statusForm" method="POST" action="{{ route('admin.loans.updateStatus', $loan->id) }}" class="space-y-4">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" id="statusInput">
                            <input type="hidden" name="notes" id="notesInput">
                            <div class="flex items-center gap-4">
                                <button type="button" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors" onclick="submitStatus('APPROVED')">
                                    <i class="fas fa-check mr-2"></i> Approve & WhatsApp
                                </button>
                                <button type="button" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors" onclick="submitStatus('REJECTED')">
                                    <i class="fas fa-times mr-2"></i> Tolak & WhatsApp
                                </button>
                            </div>
                        </form>
                    </div>
                    <script>
                    function submitStatus(status) {
                        document.getElementById('statusInput').value = status;
                        document.getElementById('notesInput').value = '';
                        document.getElementById('statusForm').submit();
                    }
                    </script>
                @else
                    @if($loan->notes)
                        <div class="mt-8 pt-6 border-t border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Catatan</h3>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-sm text-gray-900">{{ $loan->notes }}</p>
                            </div>
                        </div>
                    @endif
                @endif

                <!-- Timestamps -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-500">
                        <div>
                            <span class="font-medium">Dibuat:</span> {{ $loan->created_at->format('d M Y H:i') }}
                        </div>
                        <div>
                            <span class="font-medium">Diperbarui:</span> {{ $loan->updated_at->format('d M Y H:i') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
 