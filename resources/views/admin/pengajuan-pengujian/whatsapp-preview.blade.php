@extends('admin.layouts.app')

@section('title', 'Preview WhatsApp')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="bg-gradient-to-br from-green-600 to-green-700 rounded-xl p-8 text-white shadow-xl border border-green-500">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold mb-2">Preview Pesan WhatsApp</h1>
                <p class="text-green-100 text-lg">Tinjau pesan sebelum mengirim ke pengaju</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.pengajuan-pengujian.show', $pengajuan->id) }}" 
                   class="bg-white text-green-700 px-6 py-3 rounded-xl hover:bg-gray-50 transition-all duration-300 shadow-lg hover:shadow-xl font-semibold group">
                    <i class="fas fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform"></i>
                    Kembali ke Detail
                </a>
            </div>
        </div>
    </div>

    <!-- WhatsApp Preview -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
        <div class="p-8">
            <!-- Recipient Info -->
            <div class="mb-8 pb-8 border-b border-gray-200">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-user text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">Informasi Penerima</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Nama Pengaju</label>
                        <p class="text-sm text-gray-900 bg-gray-50 px-4 py-3 rounded-xl border border-gray-200">{{ $pengajuan->namaPengaju }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Nomor WhatsApp</label>
                        <p class="text-sm text-gray-900 bg-gray-50 px-4 py-3 rounded-xl border border-gray-200">{{ $phone }}</p>
                    </div>
                </div>
            </div>

            <!-- Message Preview -->
            <div class="mb-8">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center">
                        <i class="fab fa-whatsapp text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">Preview Pesan</h3>
                </div>
                
                <!-- WhatsApp Chat Interface -->
                <div class="bg-gray-100 rounded-lg p-6 max-w-md mx-auto">
                    <div class="bg-green-500 text-white p-4 rounded-lg mb-4 relative">
                        <div class="absolute -bottom-2 left-4 w-0 h-0 border-l-8 border-l-transparent border-r-8 border-r-transparent border-t-8 border-t-green-500"></div>
                        <div class="text-sm leading-relaxed whitespace-pre-line">{{ $message }}</div>
                        <div class="text-xs text-green-100 mt-2 text-right">{{ now()->format('H:i') }}</div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-gray-50 rounded-lg p-6">
                <div class="flex items-center justify-center space-x-4">
                    <a href="{{ $whatsappUrl }}" 
                       target="_blank" 
                       class="bg-green-600 text-white px-8 py-3 rounded-xl hover:bg-green-700 transition-all duration-300 shadow-lg hover:shadow-xl font-semibold group flex items-center">
                        <i class="fab fa-whatsapp mr-2 group-hover:scale-110 transition-transform"></i>
                        Buka WhatsApp & Kirim
                    </a>
                    
                    <form method="POST" action="{{ route('admin.pengajuan-pengujian.confirm-status', $pengajuan->id) }}" class="inline">
                        @csrf
                        <button type="submit" 
                                class="bg-blue-600 text-white px-8 py-3 rounded-xl hover:bg-blue-700 transition-all duration-300 shadow-lg hover:shadow-xl font-semibold group flex items-center">
                            <i class="fas fa-check mr-2 group-hover:scale-110 transition-transform"></i>
                            Konfirmasi Status Terkirim
                        </button>
                    </form>
                </div>
                
                <div class="text-center mt-4">
                    <p class="text-sm text-gray-600">
                        <i class="fas fa-info-circle mr-1"></i>
                        Klik "Buka WhatsApp & Kirim" untuk mengirim pesan, kemudian klik "Konfirmasi Status Terkirim" untuk menyelesaikan proses.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Message Details -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100">
        <div class="p-8">
            <div class="flex items-center space-x-3 mb-6">
                <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                    <i class="fas fa-info text-white"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900">Detail Pengajuan</h3>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Kode Tracking</label>
                    <p class="text-sm text-gray-900 bg-gray-50 px-4 py-3 rounded-xl border border-gray-200">{{ $pengajuan->trackingCode }}</p>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Layanan</label>
                    <p class="text-sm text-gray-900 bg-gray-50 px-4 py-3 rounded-xl border border-gray-200">{{ $pengajuan->layanan->namaLayanan }}</p>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Status Baru</label>
                    <p class="text-sm text-gray-900 bg-gray-50 px-4 py-3 rounded-xl border border-gray-200">{{ session('intended_status') }}</p>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Jumlah Sampel</label>
                    <p class="text-sm text-gray-900 bg-gray-50 px-4 py-3 rounded-xl border border-gray-200">{{ $pengajuan->jumlahSampel }} sampel</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
