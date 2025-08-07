@extends('user.layouts.app')

@section('title', 'Tracking Peminjaman - Laboratorium Fisika Material dan Energi')

@section('content')
<!-- Hero Section -->
<section class="relative min-h-[50vh] flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('/images/hero.jpg') }}" alt="Tracking Peminjaman" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-700/90 via-blue-800/80 to-blue-900/70"></div>
    </div>

    <div class="relative z-20 mx-6 px-4 sm:px-6 lg:px-8 text-center max-w-6xl">
        <div class="scroll-animate mb-8 opacity-0" data-animation="fade-down">
            <nav class="flex justify-center" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3 bg-white/10 backdrop-blur-sm rounded-full px-6 py-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}" class="text-blue-200 hover:text-white transition-colors duration-200 flex items-center">
                            <i class="fas fa-home mr-2"></i>Beranda
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-blue-300 mx-3"></i>
                            <span class="text-blue-200">Peminjaman Alat</span>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-blue-300 mx-3"></i>
                            <span class="text-white font-medium">Tracking</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>

        <div class="scroll-animate mb-8 opacity-0" data-animation="fade-up" data-delay="200">
            <h1 class="font-poppins text-4xl md:text-6xl font-bold leading-tight mb-6">
                <span class="text-white">Tracking</span>
                <span class="bg-gradient-to-r from-yellow-400 to-orange-400 bg-clip-text text-transparent drop-shadow-lg"> Peminjaman</span>
            </h1>
            <p class="text-xl md:text-2xl text-blue-100 max-w-4xl mx-auto leading-relaxed">
                Lacak status peminjaman alat atau kunjungan laboratorium Anda
            </p>
        </div>
    </div>
</section>

<!-- Tracking Section -->
<section class="py-16 bg-gradient-to-b from-gray-50 to-white">
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
        <!-- Search Form -->
        <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100 mb-8">
            <h3 class="text-2xl font-bold text-gray-900 mb-6">Cari Pengajuan</h3>
            
            <form method="GET" action="{{ route('tracking') }}" class="space-y-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Jenis Pengajuan</label>
                    <select name="type" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="peminjaman" {{ request('type') === 'peminjaman' || !request('type') ? 'selected' : '' }}>Peminjaman Alat</option>
                        <option value="kunjungan" {{ request('type') === 'kunjungan' ? 'selected' : '' }}>Kunjungan Laboratorium</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kode Tracking</label>
                    <input type="text" name="tracking_code" value="{{ request('tracking_code') }}" 
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Masukkan kode tracking">
                </div>
                
                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-blue-700 transition-colors">
                        <i class="fas fa-search mr-2"></i>Cari {{ request('type') === 'kunjungan' ? 'Kunjungan' : 'Peminjaman' }}
                    </button>
                </div>
            </form>
        </div>

        <!-- Peminjaman Status Summary -->
        @if(request('type') !== 'kunjungan' && isset($peminjaman))
            <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100 mb-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Status Peminjaman</h3>
                <p><b>Kode Tracking:</b> {{ $peminjaman->tracking_code }}</p>
                <p><b>Nama Peminjam:</b> {{ $peminjaman->namaPeminjam }}</p>
                <p><b>Status:</b> <span class="font-semibold">
                    @if($peminjaman->status === 'PENDING')
                        <span class="text-yellow-600">Menunggu Konfirmasi</span>
                    @elseif($peminjaman->status === 'APPROVED')
                        <span class="text-green-600">Disetujui</span>
                    @elseif($peminjaman->status === 'REJECTED')
                        <span class="text-red-600">Ditolak</span>
                    @else
                        <span class="text-gray-600">{{ ucfirst(strtolower($peminjaman->status)) }}</span>
                    @endif
                </span></p>
                @if($peminjaman->status === 'APPROVED')
                    <div class="mt-4">
                        <a href="{{ route('equipment.loan.download', $peminjaman->id) }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
                            <i class="fas fa-file-pdf mr-2"></i>Download Surat Peminjaman (PDF)
                        </a>
                    </div>
                @endif
            </div>
        @endif

        <!-- Results -->
        @if(request('tracking_code'))
            @if(request('type') !== 'kunjungan' && $loans->count() > 0)
                <div class="space-y-6">
                    @foreach($loans as $loan)
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <!-- Header -->
                        <div class="p-6 border-b border-gray-100">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="text-lg font-bold text-gray-900">{{ $loan->namaPeminjam }}</h4>
                                    <p class="text-sm text-gray-600">{{ $loan->nip_nim }} • {{ $loan->user_type_label }}</p>
                                </div>
                                <div class="text-right">
                                    <span class="px-3 py-1 text-xs font-medium rounded-full
                                        @if($loan->status === 'PENDING') bg-yellow-100 text-yellow-800
                                        @elseif($loan->status === 'APPROVED') bg-green-100 text-green-800
                                        @elseif($loan->status === 'REJECTED') bg-red-100 text-red-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ $loan->status_label }}
                                    </span>
                                    <p class="text-xs text-gray-500 mt-1">{{ $loan->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <h5 class="font-semibold text-gray-900 mb-3">Informasi Penelitian</h5>
                                    <div class="space-y-2 text-sm">
                                        <p><span class="font-medium">Judul:</span> {{ $loan->judul_penelitian }}</p>
                                        @if($loan->deskripsi_penelitian)
                                            <p><span class="font-medium">Deskripsi:</span> {{ Str::limit($loan->deskripsi_penelitian, 100) }}</p>
                                        @endif
                                        <p><span class="font-medium">Durasi:</span> {{ $loan->durasi_jam }} jam</p>
                                    </div>
                                </div>
                                
                                <div>
                                    <h5 class="font-semibold text-gray-900 mb-3">Jadwal</h5>
                                    <div class="space-y-2 text-sm">
                                        <p><span class="font-medium">Mulai:</span> {{ \Carbon\Carbon::parse($loan->tanggal_pinjam)->format('d/m/Y H:i') }}</p>
                                        <p><span class="font-medium">Selesai:</span> {{ \Carbon\Carbon::parse($loan->tanggal_pengembalian)->format('d/m/Y H:i') }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Equipment List -->
                            <div class="mt-6">
                                <h5 class="font-semibold text-gray-900 mb-3">Alat yang Dipinjam</h5>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @foreach($loan->items as $item)
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                        <div class="flex items-center space-x-3">
                                            @if($item->alat->gambar->first())
                                                <img src="{{ asset($item->alat->gambar->first()->url) }}" 
                                                     alt="{{ $item->alat->nama }}" 
                                                     class="w-10 h-10 object-cover rounded">
                                            @else
                                                <div class="w-10 h-10 bg-gray-200 rounded flex items-center justify-center">
                                                    <i class="fas fa-tools text-gray-400"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <p class="font-medium text-sm">{{ $item->alat->nama }}</p>
                                                <p class="text-xs text-gray-600">{{ $item->jumlah }} unit</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="mt-6 flex flex-col sm:flex-row gap-3">
                                @if($loan->status === 'APPROVED')
                                    <a href="{{ route('equipment.loan.letter', $loan->id) }}" 
                                       class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors text-center">
                                        <i class="fas fa-print mr-2"></i>Lihat Surat
                                    </a>
                                @endif
                                
                                @if($loan->status === 'PENDING')
                                    <span class="bg-yellow-100 text-yellow-800 px-4 py-2 rounded-lg text-sm font-medium text-center">
                                        <i class="fas fa-clock mr-2"></i>Menunggu Persetujuan
                                    </span>
                                @elseif($loan->status === 'APPROVED')
                                    <span class="bg-green-100 text-green-800 px-4 py-2 rounded-lg text-sm font-medium text-center">
                                        <i class="fas fa-check mr-2"></i>Disetujui
                                    </span>
                                @elseif($loan->status === 'REJECTED')
                                    <span class="bg-red-100 text-red-800 px-4 py-2 rounded-lg text-sm font-medium text-center">
                                        <i class="fas fa-times mr-2"></i>Ditolak
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @elseif(request('type') === 'kunjungan' && $record)
                <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
                    <h3 class="text-xl font-semibold text-gray-900 mb-6">Detail Kunjungan Laboratorium</h3>
                    
                    <div class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Kode Tracking</p>
                                <p class="text-lg font-semibold text-gray-900">{{ $record->tracking_code }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Nama Pengunjung</p>
                                <p class="text-lg font-semibold text-gray-900">{{ $record->namaPengunjung }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Instansi</p>
                                <p class="text-lg font-semibold text-gray-900">{{ $record->namaInstansi }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Tanggal Kunjungan</p>
                                <p class="text-lg font-semibold text-gray-900">{{ \Carbon\Carbon::parse($record->jadwal->tanggal)->format('d M Y') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Jadwal</p>
                                <p class="text-lg font-semibold text-gray-900">{{ substr($record->jadwal->jamMulai, 0, 5) }} - {{ substr($record->jadwal->jamSelesai, 0, 5) }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Status</p>
                                <div>
                                    @if($record->status === 'PENDING')
                                        <span class="bg-yellow-100 text-yellow-800 px-4 py-2 rounded-lg text-sm font-medium">
                                            <i class="fas fa-clock mr-2"></i>Menunggu Persetujuan
                                        </span>
                                    @elseif($record->status === 'PROCESSING')
                                        <span class="bg-blue-100 text-blue-800 px-4 py-2 rounded-lg text-sm font-medium">
                                            <i class="fas fa-spinner mr-2"></i>Diproses
                                        </span>
                                    @elseif($record->status === 'COMPLETED')
                                        <span class="bg-green-100 text-green-800 px-4 py-2 rounded-lg text-sm font-medium">
                                            <i class="fas fa-check-circle mr-2"></i>Selesai
                                        </span>
                                    @elseif($record->status === 'CANCELLED')
                                        <span class="bg-red-100 text-red-800 px-4 py-2 rounded-lg text-sm font-medium">
                                            <i class="fas fa-times mr-2"></i>Dibatalkan
                                        </span>
                                    @endif
                                </div>
                            </div>
                            @if($record->status === 'CANCELLED' && $record->notes)
                                <div>
                                    <p class="text-sm text-gray-500">Catatan Pembatalan</p>
                                    <p class="text-lg font-semibold text-gray-900">{{ $record->notes }}</p>
                                </div>
                            @endif
                        </div>
                        @if($record->canBeCancelled())
                            <div class="mt-6">
                                <form method="POST" action="{{ route('tracking.cancel') }}" 
                                      onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pengajuan ini?')">
                                    @csrf
                                    <input type="hidden" name="type" value="kunjungan">
                                    <input type="hidden" name="id" value="{{ $record->id }}">
                                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-700 transition-colors">
                                        <i class="fas fa-times mr-2"></i>Batalkan Pengajuan
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            @else
                <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100 text-center">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-search text-gray-400 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Tidak ada pengajuan ditemukan</h3>
                    <p class="text-gray-600">Coba periksa kembali kode tracking atau jenis pengajuan yang Anda masukkan.</p>
                </div>
            @endif
        @else
            <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100 text-center">
                <div class="w-24 h-24 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-search text-blue-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Lacak Pengajuan Anda</h3>
                <p class="text-gray-600">Pilih jenis pengajuan dan masukkan kode tracking untuk melihat status pengajuan Anda.</p>
            </div>
        @endif
    </div>
</section>

<style>
.scroll-animate {
    opacity: 0;
    transition: all 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}

.scroll-animate[data-animation="fade-down"] {
    transform: translateY(-60px);
}

.scroll-animate[data-animation="fade-up"] {
    transform: translateY(60px);
}

.scroll-animate.animate {
    opacity: 1;
    transform: translateY(0);
}

.bg-clip-text {
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    initScrollAnimations();
});

function initScrollAnimations() {
    const animatedElements = document.querySelectorAll('.scroll-animate');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const delay = entry.target.dataset.delay || 0;
                setTimeout(() => {
                    entry.target.classList.add('animate');
                }, delay);
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    });

    animatedElements.forEach(element => {
        observer.observe(element);
    });
}
</script>
@endsection