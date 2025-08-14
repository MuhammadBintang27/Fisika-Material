@extends('user.layouts.app')

@section('title', $layanan->namaLayanan . ' - Layanan Pengujian')

@section('content')
<!-- Hero Section -->
<section class="relative min-h-[60vh] flex items-center justify-center overflow-hidden  pt-20 md:pt-24">
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('/images/hero.jpg') }}" alt="{{ $layanan->namaLayanan }}" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-700/90 via-blue-800/80 to-blue-900/70"></div>
    </div>

    <div class="relative z-20 mx-6 px-4 sm:px-6 lg:px-8 text-center max-w-6xl">
        <!-- Breadcrumb -->
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
                            <a href="{{ route('testing.services') }}" class="text-blue-200 hover:text-white transition-colors duration-200">
                                Pengujian
                            </a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-blue-300 mx-3"></i>
                            <span class="text-white font-medium">{{ $layanan->namaLayanan }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>

        <!-- Judul & Info Layanan -->
        <div class="scroll-animate mb-8 opacity-0" data-animation="fade-up" data-delay="200">
            @php
                $kata = explode(' ', $layanan->namaLayanan, 2);
            @endphp
            <h1 class="font-poppins text-4xl md:text-6xl font-bold leading-tight mb-6">
                <span class="text-white">{{ $kata[0] }}</span>
                @if(isset($kata[1]))
                    <span class="bg-gradient-to-r from-yellow-400 to-orange-400 bg-clip-text text-transparent drop-shadow-lg">
                        {{ $kata[1] }}
                    </span>
                @endif
            </h1>

            @if($layanan->harga)
                <p class="text-xl md:text-2xl text-blue-200 mb-4">
                    Rp {{ number_format($layanan->harga, 0, ',', '.') }}
                </p>
            @else
                <p class="text-xl md:text-2xl text-blue-200 mb-4">Gratis</p>
            @endif

            <div class="inline-flex items-center bg-white/20 backdrop-blur-sm rounded-full px-4 py-2">
                <i class="fas fa-clock mr-2 text-blue-200"></i>
                <span class="text-blue-100">Estimasi selesai: {{ $layanan->estimasiSelesaiHari }} hari kerja</span>
            </div>
        </div>
    </div>
</section>




<!-- Content Section -->
<section class="py-16 bg-gray-50">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Service Description -->
                <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Deskripsi Layanan</h2>
                    @if($layanan->deskripsi)
                        <div class="prose prose-blue max-w-none">
                            {!! nl2br(e($layanan->deskripsi)) !!}
                        </div>
                    @else
                        <p class="text-gray-600">Deskripsi layanan akan segera tersedia.</p>
                    @endif
                </div>

                <!-- Service Features -->
                <div class="bg-white rounded-2xl shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Fitur Layanan</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="flex items-start">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-4 mt-1">
                                <i class="fas fa-certificate text-blue-600"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-2">Hasil Berstandar</h3>
                                <p class="text-gray-600 text-sm">Laporan hasil pengujian menggunakan standar internasional</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-4 mt-1">
                                <i class="fas fa-clock text-blue-600"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-2">Proses Cepat</h3>
                                <p class="text-gray-600 text-sm">Estimasi selesai {{ $layanan->estimasiSelesaiHari }} hari kerja</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-4 mt-1">
                                <i class="fas fa-download text-blue-600"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-2">Report Digital</h3>
                                <p class="text-gray-600 text-sm">Hasil pengujian tersedia dalam format digital</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-4 mt-1">
                                <i class="fas fa-user-tie text-blue-600"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-2">Tim Ahli</h3>
                                <p class="text-gray-600 text-sm">Dikerjakan oleh tim berpengalaman dan tersertifikasi</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar - Service Info -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-lg p-8 sticky top-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Informasi Layanan</h3>
                    
                    <!-- Service Info -->
                    <div class="border border-gray-200 rounded-xl p-4 mb-6">
                        <div class="flex justify-between items-center mb-3">
                            <span class="text-gray-600 text-sm">Harga:</span>
                            @if($layanan->harga)
                                <span class="font-bold text-lg text-blue-600">
                                    Rp {{ number_format($layanan->harga, 0, ',', '.') }}
                                </span>
                            @else
                                <span class="font-bold text-lg text-green-600">Gratis</span>
                            @endif
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 text-sm">Estimasi selesai:</span>
                            <span class="font-semibold text-gray-900">{{ $layanan->estimasiSelesaiHari }} hari</span>
                        </div>
                    </div>

                    <!-- Contact Info -->
                    <div class="bg-gradient-to-br from-[#968c82] to-[#635849] rounded-2xl p-6 text-white">
                        <h4 class="font-bold mb-4">Butuh Bantuan?</h4>
                        <div class="space-y-3 text-sm">
                            <div class="flex items-center">
                                <i class="fas fa-phone w-4 h-4 mr-3"></i>
                                <span>+62 651 7551394</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-envelope w-4 h-4 mr-3"></i>
                                <span>fisika@unsyiah.ac.id</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-clock w-4 h-4 mr-3"></i>
                                <span>Senin - Jumat, 08:00 - 16:00</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Section - Full Width -->
        <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Ajukan Pengujian</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Lengkapi formulir di bawah untuk mengajukan layanan pengujian <strong>{{ $layanan->namaLayanan }}</strong>
                </p>
            </div>

                    <!-- Error Messages -->
                    @if($errors->any())
                        <div class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-triangle text-red-400"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800">Terjadi kesalahan:</h3>
                                    <div class="mt-2 text-sm text-red-700">
                                        <ul class="list-disc pl-5 space-y-1">
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Form -->
                    <form action="{{ route('testing.submit') }}" method="POST" id="pengujianForm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="layanan_id" value="{{ $layanan->id }}">

                        <!-- User Type Selection -->
                        <div class="mb-8">
                            <h4 class="text-2xl font-bold text-gray-900 mb-6">Kategori Peminjam</h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <label class="user-type-option cursor-pointer">
                                    <input type="radio" name="user_type" value="dosen" class="sr-only" {{ old('user_type') == 'dosen' ? 'checked' : '' }}>
                                    <div class="p-6 border-2 border-gray-200 rounded-xl text-center hover:border-blue-400 hover:bg-blue-50 transition-all duration-300 group">
                                        <div class="flex flex-col items-center">
                                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mb-4 group-hover:bg-blue-200 transition-colors">
                                                <i class="fas fa-user-tie text-xl text-blue-600"></i>
                                            </div>
                                            <h5 class="font-semibold text-gray-900 mb-2">Dosen</h5>
                                            <p class="text-sm text-gray-600">Dosen USK yang akan menggunakan sarana laboratorium untuk penelitian</p>
                                        </div>
                                    </div>
                                </label>
                                <label class="user-type-option cursor-pointer">
                                    <input type="radio" name="user_type" value="mahasiswa" class="sr-only" {{ old('user_type') == 'mahasiswa' ? 'checked' : '' }}>
                                    <div class="p-6 border-2 border-gray-200 rounded-xl text-center hover:border-green-400 hover:bg-green-50 transition-all duration-300 group">
                                        <div class="flex flex-col items-center">
                                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mb-4 group-hover:bg-green-200 transition-colors">
                                                <i class="fas fa-user-graduate text-xl text-green-600"></i>
                                            </div>
                                            <h5 class="font-semibold text-gray-900 mb-2">Mahasiswa</h5>
                                            <p class="text-sm text-gray-600">Mahasiswa yang akan menggunakan sarana laboratorium untuk penelitian</p>
                                        </div>
                                    </div>
                                </label>
                                <label class="user-type-option cursor-pointer">
                                    <input type="radio" name="user_type" value="pihak-luar" class="sr-only" {{ old('user_type') == 'pihak-luar' ? 'checked' : '' }}>
                                    <div class="p-6 border-2 border-gray-200 rounded-xl text-center hover:border-purple-400 hover:bg-purple-50 transition-all duration-300 group">
                                        <div class="flex flex-col items-center">
                                            <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mb-4 group-hover:bg-purple-200 transition-colors">
                                                <i class="fas fa-building text-xl text-purple-600"></i>
                                            </div>
                                            <h5 class="font-semibold text-gray-900 mb-2">Pihak Luar USK</h5>
                                            <p class="text-sm text-gray-600">Pihak luar USK yang ingin menggunakan peralatan laboratorium</p>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            @error('user_type')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Dynamic Forms for each user type -->
                        <!-- Dosen Form -->
                        <div id="dosenForm" class="user-form hidden mb-6">
                            <h5 class="text-2xl font-bold text-gray-900 mb-6">Informasi Pemohon</h5>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="nama_dosen" class="block text-sm font-medium text-gray-700 mb-2">Nama Dosen *</label>
                                    <input type="text" id="nama_dosen" name="nama_dosen" value="{{ old('nama_dosen') }}" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                                <div>
                                    <label for="nip_dosen" class="block text-sm font-medium text-gray-700 mb-2">NIP *</label>
                                    <input type="text" id="nip_dosen" name="nip_dosen" value="{{ old('nip_dosen') }}" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                                <div>
                                    <label for="no_hp_dosen" class="block text-sm font-medium text-gray-700 mb-2">No HP *</label>
                                    <input type="tel" id="no_hp_dosen" name="no_hp_dosen" value="{{ old('no_hp_dosen') }}" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                           placeholder="0812xxxxxxxx">
                                </div>
                                <div>
                                    <label for="email_dosen" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                                    <input type="email" id="email_dosen" name="email_dosen" value="{{ old('email_dosen') }}" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                           placeholder="nama@email.com">
                                </div>
                            </div>
                            
                            <h5 class="text-2xl font-bold text-gray-900 mb-6 mt-8">Informasi Penelitian</h5>
                            <div>
                                <label for="judul_penelitian_dosen" class="block text-sm font-medium text-gray-700 mb-2">Judul Penelitian *</label>
                                <textarea id="judul_penelitian_dosen" name="judul_penelitian" rows="3"
                                          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                          placeholder="Masukkan judul penelitian">{{ old('judul_penelitian') }}</textarea>
                            </div>
                        </div>

                        <!-- Mahasiswa Form -->
                        <div id="mahasiswaForm" class="user-form hidden mb-6">
                            <h5 class="text-2xl font-bold text-gray-900 mb-6">Informasi Pemohon</h5>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label for="nama_mahasiswa" class="block text-sm font-medium text-gray-700 mb-2">Nama Mahasiswa *</label>
                                    <input type="text" id="nama_mahasiswa" name="nama_mahasiswa" value="{{ old('nama_mahasiswa') }}" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                </div>
                                <div>
                                    <label for="nim_mahasiswa" class="block text-sm font-medium text-gray-700 mb-2">NIM *</label>
                                    <input type="text" id="nim_mahasiswa" name="nim_mahasiswa" value="{{ old('nim_mahasiswa') }}" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                </div>
                                <div>
                                    <label for="no_hp_mahasiswa" class="block text-sm font-medium text-gray-700 mb-2">No HP *</label>
                                    <input type="tel" id="no_hp_mahasiswa" name="no_hp_mahasiswa" value="{{ old('no_hp_mahasiswa') }}" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                           placeholder="0812xxxxxxxx">
                                </div>
                                <div>
                                    <label for="email_mahasiswa" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                                    <input type="email" id="email_mahasiswa" name="email_mahasiswa" value="{{ old('email_mahasiswa') }}" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                           placeholder="nama@email.com">
                                </div>
                            </div>
                            
                            <h6 class="text-sm font-semibold text-gray-900 mb-3">Informasi Pembimbing</h6>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label for="nama_pembimbing" class="block text-sm font-medium text-gray-700 mb-2">Nama Pembimbing *</label>
                                    <input type="text" id="nama_pembimbing" name="nama_pembimbing" value="{{ old('nama_pembimbing') }}" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                </div>
                                <div>
                                    <label for="nip_pembimbing" class="block text-sm font-medium text-gray-700 mb-2">NIP Pembimbing *</label>
                                    <input type="text" id="nip_pembimbing" name="nip_pembimbing" value="{{ old('nip_pembimbing') }}" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                </div>
                            </div>
                            
                            <h5 class="text-2xl font-bold text-gray-900 mb-6">Informasi Penelitian</h5>
                            <div>
                                <label for="judul_penelitian_mahasiswa" class="block text-sm font-medium text-gray-700 mb-2">Judul Penelitian *</label>
                                <textarea id="judul_penelitian_mahasiswa" name="judul_penelitian" rows="3"
                                          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                          placeholder="Masukkan judul penelitian">{{ old('judul_penelitian') }}</textarea>
                            </div>
                        </div>

                        <!-- Pihak Luar Form -->
                        <div id="pihakLuarForm" class="user-form hidden mb-6">
                            <h5 class="text-2xl font-bold text-gray-900 mb-6">Informasi Pemohon</h5>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label for="nama_pihak_luar" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap *</label>
                                    <input type="text" id="nama_pihak_luar" name="nama_pihak_luar" value="{{ old('nama_pihak_luar') }}" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                </div>
                                <div>
                                    <label for="nip_pihak_luar" class="block text-sm font-medium text-gray-700 mb-2">NIK/Nomor Identitas *</label>
                                    <input type="text" id="nip_pihak_luar" name="nip_pihak_luar" value="{{ old('nip_pihak_luar') }}" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                </div>
                                <div>
                                    <label for="no_hp_pihak_luar" class="block text-sm font-medium text-gray-700 mb-2">No HP *</label>
                                    <input type="tel" id="no_hp_pihak_luar" name="no_hp_pihak_luar" value="{{ old('no_hp_pihak_luar') }}" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                           placeholder="0812xxxxxxxx">
                                </div>
                                <div>
                                    <label for="email_pihak_luar" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                                    <input type="email" id="email_pihak_luar" name="email_pihak_luar" value="{{ old('email_pihak_luar') }}" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                           placeholder="nama@email.com">
                                </div>
                            </div>
                            
                            <h6 class="text-sm font-semibold text-gray-900 mb-3">Informasi Instansi</h6>
                            <div class="grid grid-cols-1 gap-6 mb-6">
                                <div>
                                    <label for="instansi_pihak_luar" class="block text-sm font-medium text-gray-700 mb-2">Nama Instansi *</label>
                                    <input type="text" id="instansi_pihak_luar" name="instansi_pihak_luar" value="{{ old('instansi_pihak_luar') }}" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                           placeholder="Masukkan nama instansi/perusahaan">
                                </div>
                            </div>
                            
                            <h5 class="text-2xl font-bold text-gray-900 mb-6">Informasi Penelitian</h5>
                            <div>
                                <label for="judul_penelitian_pihak_luar" class="block text-sm font-medium text-gray-700 mb-2">Judul Penelitian *</label>
                                <textarea id="judul_penelitian_pihak_luar" name="judul_penelitian" rows="3"
                                          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                          placeholder="Masukkan judul penelitian">{{ old('judul_penelitian') }}</textarea>
                            </div>
                        </div>

                        <!-- Common Fields -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="tanggal_penyerahan" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Penyerahan Sampel *</label>
                                <input type="date" id="tanggal_penyerahan" name="tanggal_penyerahan" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                       value="{{ old('tanggal_penyerahan') }}">
                                @error('tanggal_penyerahan')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="jumlah_sampel" class="block text-sm font-medium text-gray-700 mb-2">Jumlah Sampel *</label>
                                <input type="number" id="jumlah_sampel" name="jumlah_sampel" required min="1"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       placeholder="Masukkan jumlah sampel"
                                       value="{{ old('jumlah_sampel') }}">
                                @error('jumlah_sampel')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="space-y-6 mb-6">
                            <div>
                                <label for="deskripsi_sampel" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Sampel *</label>
                                <textarea id="deskripsi_sampel" name="deskripsi_sampel" required rows="4"
                                          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                          placeholder="Jelaskan detail sampel yang akan diuji, termasuk jenis material, dimensi, atau spesifikasi lainnya...">{{ old('deskripsi_sampel') }}</textarea>
                                @error('deskripsi_sampel')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">Alamat Lengkap</label>
                                <textarea id="alamat" name="alamat" rows="2"
                                          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                          placeholder="Alamat lengkap untuk pengiriman hasil">{{ old('alamat') }}</textarea>
                                @error('alamat')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="file_pendukung" class="block text-sm font-medium text-gray-700 mb-2">File Pendukung</label>
                                <input type="file" id="file_pendukung" name="file_pendukung"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                <p class="text-xs text-gray-500 mt-1">Format: PDF, DOC, DOCX, JPG, PNG. Maksimal 5MB</p>
                                @error('file_pendukung')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" 
                                class="w-full bg-gradient-to-r from-[#968c82] to-[#635849] text-white py-4 px-6 rounded-xl font-semibold hover:from-[#635849] hover:to-[#443f35] transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl flex items-center justify-center">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Kirim Pengajuan
                        </button>

                        <p class="text-xs text-gray-500 mt-4 text-center">
                            Dengan mengirim pengajuan, Anda menyetujui untuk dihubungi melalui WhatsApp
                        </p>
                    </form>
                </div>

                <!-- Contact Info -->
                <div class="bg-gradient-to-br from-[#968c82] to-[#635849] rounded-2xl p-6 text-white mt-6">
                    <h4 class="font-bold mb-4">Butuh Bantuan?</h4>
                    <div class="space-y-3 text-sm">
                        <div class="flex items-center">
                            <i class="fas fa-phone w-4 h-4 mr-3"></i>
                            <span>+62 651 7551394</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-envelope w-4 h-4 mr-3"></i>
                            <span>fisika@unsyiah.ac.id</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-clock w-4 h-4 mr-3"></i>
                            <span>Senin - Jumat, 08:00 - 16:00</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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

.prose {
    line-height: 1.6;
}

.prose p {
    margin-bottom: 1rem;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    initScrollAnimations();
    initFormValidation();
    initUserTypeSelection();
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

function initUserTypeSelection() {
    const userTypeInputs = document.querySelectorAll('input[name="user_type"]');
    const userForms = document.querySelectorAll('.user-form');
    
    userTypeInputs.forEach(input => {
        input.addEventListener('change', function() {
            console.log('User type selected:', this.value); // Debug log
            
            // Hide all forms
            userForms.forEach(form => {
                form.classList.add('hidden');
            });
            
            // Show selected form
            const selectedFormId = getFormId(this.value);
            const selectedForm = document.getElementById(selectedFormId);
            console.log('Looking for form with ID:', selectedFormId); // Debug log
            console.log('Found form:', selectedForm); // Debug log
            
            if (selectedForm) {
                selectedForm.classList.remove('hidden');
                console.log('Form shown successfully'); // Debug log
            } else {
                console.error('Form not found for ID:', selectedFormId); // Debug log
            }
            
            // Update UI
            updateUserTypeUI();
        });
    });
    
    // Helper function to get form ID
    function getFormId(userType) {
        const formIdMap = {
            'dosen': 'dosenForm',
            'mahasiswa': 'mahasiswaForm',
            'pihak-luar': 'pihakLuarForm'
        };
        return formIdMap[userType];
    }
    
    // Initialize user type UI
    updateUserTypeUI();
    
    // Show form for initially selected user type
    const checkedInput = document.querySelector('input[name="user_type"]:checked');
    if (checkedInput) {
        console.log('Initially selected user type:', checkedInput.value); // Debug log
        const selectedFormId = getFormId(checkedInput.value);
        const selectedForm = document.getElementById(selectedFormId);
        console.log('Initially looking for form with ID:', selectedFormId); // Debug log
        console.log('Initially found form:', selectedForm); // Debug log
        
        if (selectedForm) {
            selectedForm.classList.remove('hidden');
            console.log('Initial form shown successfully'); // Debug log
        }
    }
    
    function updateUserTypeUI() {
        const options = document.querySelectorAll('.user-type-option');
        options.forEach(option => {
            const input = option.querySelector('input[type="radio"]');
            const div = option.querySelector('div');
            
            if (input.checked) {
                // Remove all possible color classes
                div.classList.remove('border-gray-200', 'border-blue-400', 'bg-blue-50', 'border-green-400', 'bg-green-50', 'border-purple-400', 'bg-purple-50');
                
                // Add appropriate color based on user type
                if (input.value === 'dosen') {
                    div.classList.add('border-blue-400', 'bg-blue-50');
                } else if (input.value === 'mahasiswa') {
                    div.classList.add('border-green-400', 'bg-green-50');
                } else if (input.value === 'pihak-luar') {
                    div.classList.add('border-purple-400', 'bg-purple-50');
                }
            } else {
                // Remove all active color classes and add default
                div.classList.remove('border-blue-400', 'bg-blue-50', 'border-green-400', 'bg-green-50', 'border-purple-400', 'bg-purple-50');
                div.classList.add('border-gray-200');
            }
        });
    }
}

function initFormValidation() {
    const form = document.getElementById('pengujianForm');
    const phoneInputs = document.querySelectorAll('input[type="tel"]');
    
    // Format phone numbers
    phoneInputs.forEach(phoneInput => {
        phoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.startsWith('0')) {
                value = '62' + value.substring(1);
            } else if (!value.startsWith('62')) {
                value = '62' + value;
            }
            
            // Format display
            let displayValue = value;
            if (displayValue.startsWith('62')) {
                displayValue = '0' + displayValue.substring(2);
            }
            
            e.target.value = displayValue;
        });
    });
    
    form.addEventListener('submit', function(e) {
        const userType = document.querySelector('input[name="user_type"]:checked');
        if (!userType) {
            e.preventDefault();
            alert('Mohon pilih kategori pengaju');
            return;
        }

        // Validate required fields based on user type
        let isValid = true;
        let requiredFields = [];

        if (userType.value === 'dosen') {
            requiredFields = ['nama_dosen', 'nip_dosen', 'no_hp_dosen'];
        } else if (userType.value === 'mahasiswa') {
            requiredFields = ['nama_mahasiswa', 'nim_mahasiswa', 'no_hp_mahasiswa', 'nama_pembimbing', 'nip_pembimbing'];
        } else if (userType.value === 'pihak-luar') {
            requiredFields = ['nama_pihak_luar', 'nip_pihak_luar', 'instansi_pihak_luar', 'no_hp_pihak_luar'];
        }

        // Check user type specific fields
        requiredFields.forEach(fieldName => {
            const field = document.getElementById(fieldName);
            if (field && !field.value.trim()) {
                isValid = false;
                field.classList.add('border-red-500');
            } else if (field) {
                field.classList.remove('border-red-500');
            }
        });

        // Check common required fields
        const commonFields = ['tanggal_penyerahan', 'jumlah_sampel', 'deskripsi_sampel'];
        commonFields.forEach(fieldName => {
            const field = document.getElementById(fieldName);
            if (field && !field.value.trim()) {
                isValid = false;
                field.classList.add('border-red-500');
            } else if (field) {
                field.classList.remove('border-red-500');
            }
        });

        if (!isValid) {
            e.preventDefault();
            alert('Mohon lengkapi semua field yang wajib diisi');
            return;
        }

        // Validate phone numbers
        const phoneInputsToValidate = document.querySelectorAll('input[type="tel"]:not(.hidden)');
        phoneInputsToValidate.forEach(phoneInput => {
            if (phoneInput.value && phoneInput.value.length < 10) {
                e.preventDefault();
                alert('Nomor HP tidak valid');
                isValid = false;
                return;
            }
        });

        // Validate sample count
        const jumlahSampel = document.getElementById('jumlah_sampel').value;
        if (parseInt(jumlahSampel) < 1) {
            e.preventDefault();
            alert('Jumlah sampel minimal 1');
            return;
        }
    });
}
</script>

<style>
.user-form {
    display: block;
}
.user-form.hidden {
    display: none !important;
}
.user-type-option input:checked + div {
    border-color: #3b82f6;
    background-color: #eff6ff;
}
</style>
@endsection
