@extends('user.layouts.app')

@section('title', 'Tracking Peminjaman - Laboratorium Fisika Material dan Energi')

@section('content')
<!-- Hero Section -->
<section class="relative min-h-[60vh] flex items-center justify-center overflow-hidden">
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
                            <span class="text-blue-200">Layanan Laboratorium</span>
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
                <span class="bg-gradient-to-r from-yellow-400 to-orange-400 bg-clip-text text-transparent drop-shadow-lg"> Layanan</span>
            </h1>
            <p class="text-xl md:text-2xl text-blue-100 max-w-4xl mx-auto leading-relaxed">
                Lacak status peminjaman alat, kunjungan laboratorium, atau pengujian/karakterisasi Anda
            </p>
        </div>
    </div>
</section>

<!-- Tracking Section -->
<section class="py-16 bg-gradient-to-b from-gray-50 to-white">
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
        
        <!-- Flash Messages -->
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-6">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-600 mr-3"></i>
                    <p class="text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-6">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle text-red-600 mr-3"></i>
                    <p class="text-red-800">{{ session('error') }}</p>
                </div>
            </div>
        @endif
        
        <!-- Search Form -->
        <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100 mb-8">
            <h3 class="text-2xl font-bold text-gray-900 mb-6">Cari Pengajuan</h3>
            
            <form method="GET" action="{{ route('tracking') }}" class="space-y-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Jenis Pengajuan</label>
                    <select name="type" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="peminjaman" {{ request('type') === 'peminjaman' || !request('type') ? 'selected' : '' }}>Peminjaman Alat</option>
                        <option value="kunjungan" {{ request('type') === 'kunjungan' ? 'selected' : '' }}>Kunjungan Laboratorium</option>
                        <option value="pengujian" {{ request('type') === 'pengujian' ? 'selected' : '' }}>Pengujian/Karakterisasi</option>
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
                        <i class="fas fa-search mr-2"></i>Cari {{ request('type') === 'kunjungan' ? 'Kunjungan' : (request('type') === 'pengujian' ? 'Pengujian' : 'Peminjaman') }}
                    </button>
                </div>
            </form>
        </div>

        <!-- Status Progress for Peminjaman -->
        @if((request('type') === 'peminjaman' || !request('type')) && isset($peminjaman))
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
                        <p class="text-gray-600 mt-3">✅ Peminjaman disetujui! Silakan unduh surat peminjaman di bawah ini, print surat tersebut, dan bawa saat datang ke laboratorium untuk mengambil alat.</p>
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
                        <div class="mt-6 p-4 bg-green-50 border border-green-200 rounded-xl">
                            <h4 class="font-semibold text-green-900 mb-3">
                                <i class="fas fa-file-download mr-2"></i>Unduh Surat Izin Peminjaman
                            </h4>
                            <p class="text-sm text-green-800 mb-3">
                                Surat izin ini wajib dibawa saat datang ke laboratorium untuk mengambil alat. 
                                Silakan print surat dan tunjukkan kepada petugas laboratorium.
                            </p>
                            <div class="flex gap-3">
                                <a href="{{ route('equipment.loan.letter', $peminjaman->id) }}" 
                                   class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
                                    <i class="fas fa-eye mr-2"></i>Lihat Surat
                                </a>
                                <a href="{{ route('equipment.loan.download', $peminjaman->id) }}" 
                                   class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-green-700 transition-colors">
                                    <i class="fas fa-download mr-2"></i>Unduh PDF
                                </a>
                            </div>
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
                                        <img src="{{ url('storage/' . $item->alat->gambar->first()->url) }}" 
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
                            elseif($record->status === 'APPROVED') $progressWidth = 50;
                            elseif($record->status === 'COMPLETED') $progressWidth = 100;
                            elseif($record->status === 'CANCELLED') $progressWidth = 50;
                        @endphp
                        <div class="h-full bg-emerald-500 rounded-full transition-all duration-1000" style="width: {{ $progressWidth }}%"></div>
                    </div>
                    
                    <!-- Progress Steps -->
                    <div class="relative flex justify-between">
                        <!-- Step 1: Pengajuan Dikirim -->
                        <div class="flex flex-col items-center">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center mb-3 {{ in_array($record->status, ['PENDING', 'APPROVED', 'COMPLETED']) ? 'bg-emerald-500 text-white' : 'bg-gray-200 text-gray-500' }}">
                                <i class="fas fa-paper-plane"></i>
                            </div>
                            <span class="text-sm font-medium text-gray-600 text-center">Pengajuan<br>Dikirim</span>
                        </div>
                        
                        <!-- Step 2: Disetujui/Ditolak -->
                        <div class="flex flex-col items-center">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center mb-3 {{ in_array($record->status, ['APPROVED', 'COMPLETED']) ? 'bg-emerald-500 text-white' : ($record->status === 'CANCELLED' ? 'bg-red-500 text-white' : 'bg-gray-200 text-gray-500') }}">
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
                        {{ $record->status === 'APPROVED' ? 'bg-blue-100 text-blue-800' : '' }}
                        {{ $record->status === 'COMPLETED' ? 'bg-green-100 text-green-800' : '' }}
                        {{ $record->status === 'CANCELLED' ? 'bg-red-100 text-red-800' : '' }}">
                        @php
                            $statusIcons = [
                                'PENDING' => 'hourglass-half',
                                'APPROVED' => 'check-circle',
                                'COMPLETED' => 'flag-checkered',
                                'CANCELLED' => 'times-circle'
                            ];
                            $statusTexts = [
                                'PENDING' => 'Menunggu Persetujuan',
                                'APPROVED' => 'Disetujui',
                                'COMPLETED' => 'Selesai',
                                'CANCELLED' => 'Ditolak'
                            ];
                        @endphp
                        <i class="fas fa-{{ $statusIcons[$record->status] ?? 'question-circle' }}"></i>
                        {{ $statusTexts[$record->status] ?? $record->status }}
                    </div>
                    @if($record->status === 'PENDING')
                        <p class="text-gray-600 mt-3">Pengajuan kunjungan Anda sedang menunggu review dari admin laboratorium</p>
                    @elseif($record->status === 'APPROVED')
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
                    <!-- @if($record->canBeCancelled())
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
                    @endif -->
                </div>
            </div>
        @endif

        <!-- Status Progress for Pengujian -->
        @if(request('type') === 'pengujian' && isset($pengujian))
            <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100 mb-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-8 text-center">Status Pengujian</h3>
                
                <div class="relative">
                    <!-- Progress Line -->
                    <div class="absolute top-6 left-0 w-full h-1 bg-gray-200 rounded-full">
                        @php
                            $progressWidth = 0;
                            if($pengujian->status === 'MENUNGGU') $progressWidth = 20;
                            elseif($pengujian->status === 'DISETUJUI') $progressWidth = 40;
                            elseif($pengujian->status === 'DITOLAK') $progressWidth = 40;
                            elseif($pengujian->status === 'DIPROSES') $progressWidth = 70;
                            elseif($pengujian->status === 'SELESAI') $progressWidth = 100;
                        @endphp
                        <div class="h-full bg-emerald-500 rounded-full transition-all duration-1000" style="width: {{ $progressWidth }}%"></div>
                    </div>
                    
                    <!-- Progress Steps -->
                    <div class="relative flex justify-between">
                        <!-- Step 1: Pengajuan Dikirim -->
                        <div class="flex flex-col items-center">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center mb-3 {{ in_array($pengujian->status, ['MENUNGGU', 'DISETUJUI', 'DIPROSES', 'SELESAI']) ? 'bg-emerald-500 text-white' : 'bg-gray-200 text-gray-500' }}">
                                <i class="fas fa-paper-plane"></i>
                            </div>
                            <span class="text-sm font-medium text-gray-600 text-center">Pengajuan<br>Dikirim</span>
                        </div>
                        
                        <!-- Step 2: Disetujui/Ditolak -->
                        <div class="flex flex-col items-center">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center mb-3 {{ in_array($pengujian->status, ['DISETUJUI', 'DIPROSES', 'SELESAI']) ? 'bg-emerald-500 text-white' : ($pengujian->status === 'DITOLAK' ? 'bg-red-500 text-white' : 'bg-gray-200 text-gray-500') }}">
                                @if($pengujian->status === 'DITOLAK')
                                    <i class="fas fa-times-circle"></i>
                                @else
                                    <i class="fas fa-check-circle"></i>
                                @endif
                            </div>
                            <span class="text-sm font-medium text-gray-600 text-center">
                                @if($pengujian->status === 'DITOLAK')
                                    Ditolak
                                @else
                                    Disetujui
                                @endif
                            </span>
                        </div>
                        
                        <!-- Step 3: Diproses -->
                        <div class="flex flex-col items-center">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center mb-3 {{ in_array($pengujian->status, ['DIPROSES', 'SELESAI']) ? 'bg-emerald-500 text-white' : 'bg-gray-200 text-gray-500' }}">
                                <i class="fas fa-cogs"></i>
                            </div>
                            <span class="text-sm font-medium text-gray-600 text-center">Sedang<br>Diproses</span>
                        </div>
                        
                        <!-- Step 4: Selesai -->
                        <div class="flex flex-col items-center">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center mb-3 {{ $pengujian->status === 'SELESAI' ? 'bg-emerald-500 text-white' : 'bg-gray-200 text-gray-500' }}">
                                <i class="fas fa-flag-checkered"></i>
                            </div>
                            <span class="text-sm font-medium text-gray-600 text-center">Hasil<br>Tersedia</span>
                        </div>
                    </div>
                </div>

                <!-- Current Status -->
                <div class="mt-8 text-center">
                    <div class="inline-flex items-center gap-2 px-6 py-3 rounded-full text-lg font-semibold
                        {{ $pengujian->status === 'MENUNGGU' ? 'bg-yellow-100 text-yellow-800' : '' }}
                        {{ $pengujian->status === 'DISETUJUI' ? 'bg-green-100 text-green-800' : '' }}
                        {{ $pengujian->status === 'DIPROSES' ? 'bg-blue-100 text-blue-800' : '' }}
                        {{ $pengujian->status === 'SELESAI' ? 'bg-green-100 text-green-800' : '' }}
                        {{ $pengujian->status === 'DITOLAK' ? 'bg-red-100 text-red-800' : '' }}">
                        @php
                            $statusIcons = [
                                'MENUNGGU' => 'hourglass-half',
                                'DISETUJUI' => 'check-circle',
                                'DIPROSES' => 'cogs',
                                'SELESAI' => 'flag-checkered',
                                'DITOLAK' => 'times-circle'
                            ];
                            $statusTexts = [
                                'MENUNGGU' => 'Menunggu Persetujuan',
                                'DISETUJUI' => 'Disetujui',
                                'DIPROSES' => 'Sedang Diproses',
                                'SELESAI' => 'Selesai',
                                'DITOLAK' => 'Ditolak'
                            ];
                        @endphp
                        <i class="fas fa-{{ $statusIcons[$pengujian->status] ?? 'question-circle' }}"></i>
                        {{ $statusTexts[$pengujian->status] ?? $pengujian->status }}
                    </div>
                    @if($pengujian->status === 'MENUNGGU')
                        <p class="text-gray-600 mt-3">Pengajuan pengujian Anda sedang menunggu review dari admin laboratorium</p>
                    @elseif($pengujian->status === 'DISETUJUI')
                        <p class="text-gray-600 mt-3">✅ Pengajuan disetujui! Silakan serahkan sampel sesuai jadwal yang ditentukan</p>
                        @if($pengujian->estimasiSelesai)
                            <p class="text-gray-600 mt-1">📅 Estimasi selesai: {{ \Carbon\Carbon::parse($pengujian->estimasiSelesai)->format('d M Y') }}</p>
                        @endif
                    @elseif($pengujian->status === 'DIPROSES')
                        <p class="text-gray-600 mt-3">🔬 Sampel sedang dalam proses pengujian di laboratorium</p>
                        @if($pengujian->estimasiSelesai)
                            <p class="text-gray-600 mt-1">📅 Estimasi selesai: {{ \Carbon\Carbon::parse($pengujian->estimasiSelesai)->format('d M Y') }}</p>
                        @endif
                    @elseif($pengujian->status === 'SELESAI')
                        <p class="text-gray-600 mt-3">✅ <strong>Pengujian selesai!</strong> Hasil pengujian sudah tersedia untuk diunduh</p>
                    @elseif($pengujian->status === 'DITOLAK')
                        <p class="text-gray-600 mt-3">❌ Pengajuan pengujian ditolak. {{ $pengujian->catatanAdmin ? 'Alasan: ' . $pengujian->catatanAdmin : '' }}</p>
                    @endif
                </div>

                <!-- Pengujian Summary -->
                <div class="mt-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Kode Tracking</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $pengujian->trackingCode }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Nama Pengaju</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $pengujian->namaPengaju }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Jenis Layanan</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $pengujian->layanan->namaLayanan }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Tanggal Penyerahan</p>
                            <p class="text-lg font-semibold text-gray-900">{{ \Carbon\Carbon::parse($pengujian->tanggalPenyerahan)->format('d M Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Jumlah Sampel</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $pengujian->jumlahSampel }} sampel</p>
                        </div>
                        @if($pengujian->instansi)
                        <div>
                            <p class="text-sm text-gray-500">Instansi</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $pengujian->instansi }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Pengujian Details -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <!-- Header -->
                <div class="p-6 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-lg font-bold text-gray-900">{{ $pengujian->namaPengaju }}</h4>
                            <p class="text-sm text-gray-600">{{ $pengujian->instansi ?? 'Tidak ada instansi' }}</p>
                            @if($pengujian->user_type)
                                <p class="text-sm text-gray-600">{{ $pengujian->nim ?? $pengujian->nip ?? 'N/A' }} • {{ $pengujian->getUserTypeLabelAttribute() }}</p>
                            @endif
                        </div>
                        <div class="text-right">
                            <span class="px-3 py-1 text-xs font-medium rounded-full {{ $pengujian->getStatusBadgeAttribute() }}">
                                {{ $pengujian->status }}
                            </span>
                            <p class="text-xs text-gray-500 mt-1">{{ $pengujian->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Content -->
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h5 class="font-semibold text-gray-900 mb-3">Informasi Layanan</h5>
                            <div class="space-y-2 text-sm">
                                <p><span class="font-medium">Layanan:</span> {{ $pengujian->layanan->namaLayanan }}</p>
                                @if($pengujian->layanan->deskripsi)
                                    <p><span class="font-medium">Deskripsi:</span> {{ Str::limit($pengujian->layanan->deskripsi, 100) }}</p>
                                @endif
                                @if($pengujian->layanan->harga)
                                    <p><span class="font-medium">Harga:</span> Rp {{ number_format($pengujian->layanan->harga, 0, ',', '.') }}</p>
                                @endif
                                @if($pengujian->judul_penelitian)
                                    <p><span class="font-medium">Judul Penelitian:</span> {{ $pengujian->judul_penelitian }}</p>
                                @endif
                            </div>
                        </div>
                        
                        <div>
                            <h5 class="font-semibold text-gray-900 mb-3">Informasi Sampel</h5>
                            <div class="space-y-2 text-sm">
                                <p><span class="font-medium">Jumlah:</span> {{ $pengujian->jumlahSampel }} sampel</p>
                                <p><span class="font-medium">Deskripsi:</span> {{ Str::limit($pengujian->deskripsiSampel, 100) }}</p>
                                @if($pengujian->filePendukung)
                                    <p><span class="font-medium">File Pendukung:</span> <a href="{{ asset('storage/' . $pengujian->filePendukung) }}" target="_blank" class="text-blue-600 hover:underline">Lihat File</a></p>
                                @endif
                                @if($pengujian->supervisor_name)
                                    <p><span class="font-medium">Pembimbing:</span> {{ $pengujian->supervisor_name }} ({{ $pengujian->supervisor_nip }})</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Hasil Pengujian -->
                    @if($pengujian->status === 'SELESAI' && $pengujian->hasil && $pengujian->hasil->count() > 0)
                    <div class="mt-6 p-4 bg-green-50 border border-green-200 rounded-xl">
                        <div class="flex items-center mb-3">
                            <i class="fas fa-file-download text-green-600 mr-2"></i>
                            <h5 class="font-semibold text-green-900">Hasil Pengujian Tersedia</h5>
                        </div>
                        <p class="text-green-700 text-sm mb-4">Hasil pengujian sudah selesai dan dapat diunduh. Silakan download file hasil pengujian di bawah ini:</p>
                        
                        <div class="space-y-3">
                            @foreach($pengujian->hasil as $hasil)
                            <div class="flex items-center justify-between p-3 bg-white border border-green-200 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-file-alt text-green-600 text-xl"></i>
                                    </div>
                                    <div>
                                        <h6 class="font-medium text-gray-900">{{ $hasil->namaFile ?: 'Hasil Pengujian' }}</h6>
                                        <div class="flex items-center space-x-4 text-xs text-gray-500">
                                            @if($hasil->ukuranFile)
                                                <span><i class="fas fa-weight mr-1"></i>{{ $hasil->ukuranFile }}</span>
                                            @endif
                                            @if($hasil->uploadedAt)
                                                <span><i class="fas fa-clock mr-1"></i>{{ $hasil->uploadedAt->format('d/m/Y H:i') }}</span>
                                            @endif
                                        </div>
                                        @if($hasil->catatan)
                                            <p class="text-sm text-gray-600 mt-1">{{ $hasil->catatan }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex-shrink-0">
                                    <a href="{{ route('testing.downloadHasil', ['pengajuanId' => $pengujian->id, 'hasilId' => $hasil->id]) }}" 
                                       class="inline-flex items-center px-3 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors duration-200">
                                        <i class="fas fa-download mr-2"></i>
                                        Download
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        
                        <div class="mt-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                            <div class="flex items-start">
                                <i class="fas fa-info-circle text-blue-600 mr-2 mt-1"></i>
                                <div class="text-sm text-blue-700">
                                    <p class="font-medium mb-1">Catatan Penting:</p>
                                    <ul class="list-disc list-inside space-y-1">
                                        <li>Hasil pengujian telah diverifikasi oleh tim laboratorium</li>
                                        <li>File hasil dapat diunduh kapan saja selama masih tersimpan di sistem</li>
                                        <li>Jika mengalami kesulitan dalam mengunduh, silakan hubungi tim laboratorium</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    @elseif($pengujian->status === 'SELESAI')
                    <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-xl">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-triangle text-yellow-600 mr-2"></i>
                            <p class="text-yellow-700 text-sm">
                                <strong>Pengujian telah selesai</strong> namun hasil belum tersedia untuk diunduh. 
                                Silakan hubungi tim laboratorium jika diperlukan.
                            </p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        @endif

        <!-- No Results -->
        @if(request('tracking_code') && !isset($peminjaman) && !isset($record) && !isset($pengujian))
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
