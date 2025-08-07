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

        <!-- Status Progress for Peminjaman -->
        @if(request('type') !== 'kunjungan' && isset($peminjaman))
            <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100 mb-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-8 text-center">Status Peminjaman</h3>
                
                <div class="relative">
                    <!-- Progress Line -->
                    <div class="absolute top-6 left-0 w-full h-1 bg-gray-200 rounded-full">
                        @php
                            $progressWidth = 0;
                            if($peminjaman->status === 'PENDING') $progressWidth = 25;
                            elseif($peminjaman->status === 'APPROVED') $progressWidth = 50;
                            elseif($peminjaman->status === 'ONGOING') $progressWidth = 75;
                            elseif($peminjaman->status === 'COMPLETED') $progressWidth = 100;
                            elseif($peminjaman->status === 'REJECTED') $progressWidth = 50;
                        @endphp
                        <div class="h-full bg-emerald-500 rounded-full transition-all duration-1000" style="width: {{ $progressWidth }}%"></div>
                    </div>
                    
                    <!-- Progress Steps -->
                    <div class="relative flex justify-between">
                        <!-- Step 1: Pengajuan Dikirim -->
                        <div class="flex flex-col items-center">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center mb-3 {{ in_array($peminjaman->status, ['PENDING', 'APPROVED', 'ONGOING', 'COMPLETED']) ? 'bg-emerald-500 text-white' : 'bg-gray-200 text-gray-500' }}">
                                <i class="fas fa-paper-plane"></i>
                            </div>
                            <span class="text-sm font-medium text-gray-600 text-center">Pengajuan<br>Dikirim</span>
                        </div>
                        
                        <!-- Step 2: Disetujui/Ditolak -->
                        <div class="flex flex-col items-center">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center mb-3 {{ in_array($peminjaman->status, ['APPROVED', 'ONGOING', 'COMPLETED']) ? 'bg-emerald-500 text-white' : ($peminjaman->status === 'REJECTED' ? 'bg-red-500 text-white' : 'bg-gray-200 text-gray-500') }}">
                                @if($peminjaman->status === 'REJECTED')
                                    <i class="fas fa-times-circle"></i>
                                @else
                                    <i class="fas fa-check-circle"></i>
                                @endif
                            </div>
                            <span class="text-sm font-medium text-gray-600 text-center">
                                @if($peminjaman->status === 'REJECTED')
                                    Ditolak
                                @else
                                    Disetujui
                                @endif
                            </span>
                        </div>
                        
                        <!-- Step 3: Berlangsung -->
                        <div class="flex flex-col items-center">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center mb-3 {{ in_array($peminjaman->status, ['ONGOING', 'COMPLETED']) ? 'bg-emerald-500 text-white' : 'bg-gray-200 text-gray-500' }}">
                                <i class="fas fa-play"></i>
                            </div>
                            <span class="text-sm font-medium text-gray-600 text-center">Peminjaman<br>Berlangsung</span>
                        </div>
                        
                        <!-- Step 4: Selesai -->
                        <div class="flex flex-col items-center">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center mb-3 {{ $peminjaman->status === 'COMPLETED' ? 'bg-emerald-500 text-white' : 'bg-gray-200 text-gray-500' }}">
                                <i class="fas fa-flag-checkered"></i>
                            </div>
                            <span class="text-sm font-medium text-gray-600 text-center">Selesai<br>Dikembalikan</span>
                        </div>
                    </div>
                </div>

                <!-- Current Status -->
                <div class="mt-8 text-center">
                    <div class="inline-flex items-center gap-2 px-6 py-3 rounded-full text-lg font-semibold
                        {{ $peminjaman->status === 'PENDING' ? 'bg-yellow-100 text-yellow-800' : '' }}
                        {{ $peminjaman->status === 'APPROVED' ? 'bg-green-100 text-green-800' : '' }}
                        {{ $peminjaman->status === 'ONGOING' ? 'bg-blue-100 text-blue-800' : '' }}
                        {{ $peminjaman->status === 'COMPLETED' ? 'bg-green-100 text-green-800' : '' }}
                        {{ $peminjaman->status === 'REJECTED' ? 'bg-red-100 text-red-800' : '' }}">
                        @php
                            $statusIcons = [
                                'PENDING' => 'hourglass-half',
                                'APPROVED' => 'check-circle',
                                'ONGOING' => 'play',
                                'COMPLETED' => 'flag-checkered',
                                'REJECTED' => 'times-circle'
                            ];
                            $statusTexts = [
                                'PENDING' => 'Menunggu Konfirmasi',
                                'APPROVED' => 'Disetujui',
                                'ONGOING' => 'Berlangsung',
                                'COMPLETED' => 'Selesai',
                                'REJECTED' => 'Ditolak'
                            ];
                        @endphp
                        <i class="fas fa-{{ $statusIcons[$peminjaman->status] ?? 'question-circle' }}"></i>
                        {{ $statusTexts[$peminjaman->status] ?? $peminjaman->status }}
                    </div>
                    @if($peminjaman->status === 'PENDING')
                        <p class="text-gray-600 mt-3">Pengajuan peminjaman Anda sedang menunggu review dari admin laboratorium</p>
                    @elseif($peminjaman->status === 'APPROVED')
                        <p class="text-gray-600 mt-3">✅ Peminjaman disetujui! Silakan ambil alat sesuai jadwal dan unduh surat peminjaman</p>
                    @elseif($peminjaman->status === 'ONGOING')
                        <p class="text-gray-600 mt-3">🚀 Peminjaman sedang berlangsung. Silakan kembalikan alat sesuai jadwal</p>
                    @elseif($peminjaman->status === 'COMPLETED')
                        <p class="text-gray-600 mt-3">✅ <strong>Peminjaman selesai!</strong> Terima kasih telah mengembalikan alat</p>
                    @elseif($peminjaman->status === 'REJECTED')
                        <p class="text-gray-600 mt-3">❌ Pengajuan peminjaman ditolak oleh admin. {{ $peminjaman->notes ? 'Alasan: ' . $peminjaman->notes : '' }}</p>
                    @endif
                </div>

                <!-- Peminjaman Summary -->
                <div class="mt-6">
                    <p><b>Kode Tracking:</b> {{ $peminjaman->tracking_code }}</p>
                    <p><b>Nama Peminjam:</b> {{ $peminjaman->namaPeminjam }}</p>
                    @if($peminjaman->status === 'APPROVED')
                        <div class="mt-4">
                            <a href="{{ route('equipment.loan.letter', $peminjaman->id) }}" 
                               class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
                                <i class="fas fa-file-pdf mr-2"></i>Unduh Surat Peminjaman (PDF)
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Peminjaman Details -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <!-- Header -->
                <div class="p-6 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-lg font-bold text-gray-900">{{ $peminjaman->namaPeminjam }}</h4>
                            <p class="text-sm text-gray-600">{{ $peminjaman->nip_nim }} • {{ $peminjaman->user_type_label }}</p>
                        </div>
                        <div class="text-right">
                            <span class="px-3 py-1 text-xs font-medium rounded-full
                                {{ $peminjaman->status === 'PENDING' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $peminjaman->status === 'APPROVED' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $peminjaman->status === 'ONGOING' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $peminjaman->status === 'COMPLETED' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $peminjaman->status === 'REJECTED' ? 'bg-red-100 text-red-800' : '' }}">
                                {{ $peminjaman->status === 'ONGOING' ? 'BERLANGSUNG' : ($peminjaman->status === 'COMPLETED' ? 'SELESAI' : $peminjaman->status) }}
                            </span>
                            <p class="text-xs text-gray-500 mt-1">{{ $peminjaman->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Content -->
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h5 class="font-semibold text-gray-900 mb-3">Informasi Penelitian</h5>
                            <div class="space-y-2 text-sm">
                                <p><span class="font-medium">Judul:</span> {{ $peminjaman->judul_penelitian ?? 'N/A' }}</p>
                                @if($peminjaman->deskripsi_penelitian)
                                    <p><span class="font-medium">Deskripsi:</span> {{ Str::limit($peminjaman->deskripsi_penelitian, 100) }}</p>
                                @endif
                                @if($peminjaman->durasi_jam)
                                    <p><span class="font-medium">Durasi:</span> {{ $peminjaman->durasi_jam }} jam</p>
                                @endif
                            </div>
                        </div>
                        
                        <div>
                            <h5 class="font-semibold text-gray-900 mb-3">Jadwal</h5>
                            <div class="space-y-2 text-sm">
                                <p><span class="font-medium">Mulai:</span> {{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d/m/Y H:i') }}</p>
                                <p><span class="font-medium">Selesai:</span> {{ \Carbon\Carbon::parse($peminjaman->tanggal_pengembalian)->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Equipment List -->
                    <div class="mt-6">
                        <h5 class="font-semibold text-gray-900 mb-3">Alat yang Dipinjam</h5>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($peminjaman->items as $item)
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
                                @if($item->return_condition)
                                    <p class="text-xs text-gray-600">Kondisi: {{ $item->return_condition }}</p>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Status Progress for Kunjungan -->
        @if(request('type') === 'kunjungan' && isset($record))
            <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100 mb-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-8 text-center">Status Kunjungan</h3>
                
                <div class="relative">
                    <!-- Progress Line -->
                    <div class="absolute top-6 left-0 w-full h-1 bg-gray-200 rounded-full">
                        @php
                            $progressWidth = 0;
                            if($record->status === 'PENDING') $progressWidth = 25;
                            elseif($record->status === 'PROCESSING') $progressWidth = 50;
                            elseif($record->status === 'COMPLETED') $progressWidth = 100;
                            elseif($record->status === 'CANCELLED') $progressWidth = 50;
                        @endphp
                        <div class="h-full bg-emerald-500 rounded-full transition-all duration-1000" style="width: {{ $progressWidth }}%"></div>
                    </div>
                    
                    <!-- Progress Steps -->
                    <div class="relative flex justify-between">
                        <!-- Step 1: Pengajuan Dikirim -->
                        <div class="flex flex-col items-center">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center mb-3 {{ in_array($record->status, ['PENDING', 'PROCESSING', 'COMPLETED']) ? 'bg-emerald-500 text-white' : 'bg-gray-200 text-gray-500' }}">
                                <i class="fas fa-paper-plane"></i>
                            </div>
                            <span class="text-sm font-medium text-gray-600 text-center">Pengajuan<br>Dikirim</span>
                        </div>
                        
                        <!-- Step 2: Disetujui/Ditolak -->
                        <div class="flex flex-col items-center">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center mb-3 {{ in_array($record->status, ['PROCESSING', 'COMPLETED']) ? 'bg-emerald-500 text-white' : ($record->status === 'CANCELLED' ? 'bg-red-500 text-white' : 'bg-gray-200 text-gray-500') }}">
                                @if($record->status === 'CANCELLED')
                                    <i class="fas fa-times-circle"></i>
                                @else
                                    <i class="fas fa-check-circle"></i>
                                @endif
                            </div>
                            <span class="text-sm font-medium text-gray-600 text-center">
                                @if($record->status === 'CANCELLED')
                                    Ditolak
                                @else
                                    Disetujui
                                @endif
                            </span>
                        </div>
                        
                       
                        
                        <!-- Step 3: Selesai -->
                        <div class="flex flex-col items-center">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center mb-3 {{ $record->status === 'COMPLETED' ? 'bg-emerald-500 text-white' : 'bg-gray-200 text-gray-500' }}">
                                <i class="fas fa-flag-checkered"></i>
                            </div>
                            <span class="text-sm font-medium text-gray-600 text-center">Kunjungan<br>Selesai</span>
                        </div>
                    </div>
                </div>

                <!-- Current Status -->
                <div class="mt-8 text-center">
                    <div class="inline-flex items-center gap-2 px-6 py-3 rounded-full text-lg font-semibold
                        {{ $record->status === 'PENDING' ? 'bg-yellow-100 text-yellow-800' : '' }}
                        {{ $record->status === 'PROCESSING' ? 'bg-blue-100 text-blue-800' : '' }}
                        {{ $record->status === 'COMPLETED' ? 'bg-green-100 text-green-800' : '' }}
                        {{ $record->status === 'CANCELLED' ? 'bg-red-100 text-red-800' : '' }}">
                        @php
                            $statusIcons = [
                                'PENDING' => 'hourglass-half',
                                'PROCESSING' => 'check-circle',
                                'COMPLETED' => 'flag-checkered',
                                'CANCELLED' => 'times-circle'
                            ];
                            $statusTexts = [
                                'PENDING' => 'Menunggu Persetujuan',
                                'PROCESSING' => 'Disetujui',
                                'COMPLETED' => 'Selesai',
                                'CANCELLED' => 'Ditolak'
                            ];
                        @endphp
                        <i class="fas fa-{{ $statusIcons[$record->status] ?? 'question-circle' }}"></i>
                        {{ $statusTexts[$record->status] ?? $record->status }}
                    </div>
                    @if($record->status === 'PENDING')
                        <p class="text-gray-600 mt-3">Pengajuan kunjungan Anda sedang menunggu review dari admin laboratorium</p>
                    @elseif($record->status === 'PROCESSING')
                        <p class="text-gray-600 mt-3">✅ Kunjungan disetujui! Silakan konfirmasi kehadiran via WhatsApp</p>
                    @elseif($record->status === 'COMPLETED')
                        <p class="text-gray-600 mt-3">✅ <strong>Kunjungan selesai!</strong> Terima kasih telah berkunjung ke laboratorium kami</p>
                    @elseif($record->status === 'CANCELLED')
                        <p class="text-gray-600 mt-3">❌ Pengajuan kunjungan ditolak oleh admin. {{ $record->notes ? 'Alasan: ' . $record->notes : '' }}</p>
                    @endif
                </div>

                <!-- Kunjungan Details -->
                <div class="mt-6">
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
        @endif

        <!-- No Results -->
        @if(request('tracking_code') && !isset($peminjaman) && !isset($record))
            <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100 text-center">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-search text-gray-400 text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Tidak ada pengajuan ditemukan</h3>
                <p class="text-gray-600">Coba periksa kembali kode tracking atau jenis pengajuan yang Anda masukkan.</p>
            </div>
        @elseif(!request('tracking_code'))
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
