@extends('user.layouts.app')

@section('title', 'Booking Kunjungan - Laboratorium Fisika Material dan Energi')

@section('content')
<!-- Hero Section -->
<section class="relative min-h-[60vh] flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('/images/hero.jpg') }}" alt="Booking Kunjungan" class="w-full h-full object-cover">
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
                            <span class="text-blue-200">Layanan</span>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-blue-300 mx-3"></i>
                            <span class="text-white font-medium">Booking Kunjungan</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>

        <div class="scroll-animate mb-8 opacity-0" data-animation="fade-up" data-delay="200">
            <h1 class="font-poppins text-4xl md:text-6xl font-bold leading-tight mb-6">
                <span class="text-white">Booking</span>
                <span class="bg-gradient-to-r from-yellow-400 to-orange-400 bg-clip-text text-transparent drop-shadow-lg">Kunjungan</span>
            </h1>
            <p class="text-xl md:text-2xl text-blue-100 max-w-4xl mx-auto leading-relaxed">
                Laboratorium Fisika Material dan Energi Departemen Fisika Universitas Syiah Kuala
            </p>
        </div>
    </div>
</section>

<!-- Booking Form Section -->
<section class="py-16 bg-gradient-to-b from-gray-50 to-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <!-- Flow Information Section -->
        <div class="mb-16 scroll-animate" data-animation="fade-up">
            <div class="text-center mb-12">
                <div class="inline-flex items-center px-6 py-3 bg-blue-50 border border-blue-200 rounded-full text-blue-700 text-sm font-semibold mb-6 shadow-sm">
                    <i class="fas fa-route mr-2"></i>
                    Prosedur Kunjungan Laboratorium
                </div>
                <h2 class="font-poppins text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Alur <span class="bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent">Kunjungan</span>
                </h2>
                <p class="text-gray-600 text-lg max-w-3xl mx-auto leading-relaxed">
                    Ikuti langkah-langkah berikut untuk mengajukan kunjungan ke laboratorium kami
                </p>
            </div>

            <!-- Flow Steps -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                <!-- Step 1 -->
                <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100 relative overflow-hidden group hover:shadow-xl transition-all duration-300">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-500 to-blue-600"></div>
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                            <span class="text-blue-600 font-bold text-lg">1</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Ajukan Permohonan</h3>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <i class="fas fa-file-upload text-blue-500 mr-3 mt-1"></i>
                            <div>
                                <p class="font-semibold text-gray-900 text-sm">Upload Surat Pengajuan</p>
                                <p class="text-gray-600 text-sm">Gunakan template surat resmi dari institusi</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-calendar-check text-blue-500 mr-3 mt-1"></i>
                            <div>
                                <p class="font-semibold text-gray-900 text-sm">Pilih Tanggal & Waktu</p>
                                <p class="text-gray-600 text-sm">Sesuai ketersediaan jadwal laboratorium</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-info-circle text-blue-500 mr-3 mt-1"></i>
                            <div>
                                <p class="font-semibold text-gray-900 text-sm">Lengkapi Data</p>
                                <p class="text-gray-600 text-sm">Isi informasi pengunjung dan tujuan kunjungan</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100 relative overflow-hidden group hover:shadow-xl transition-all duration-300">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-yellow-500 to-orange-500"></div>
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center mr-4">
                            <span class="text-yellow-600 font-bold text-lg">2</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Menunggu Konfirmasi</h3>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <i class="fas fa-clock text-yellow-500 mr-3 mt-1"></i>
                            <div>
                                <p class="font-semibold text-gray-900 text-sm">Review Admin</p>
                                <p class="text-gray-600 text-sm">Admin akan mereview pengajuan Anda</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-bell text-yellow-500 mr-3 mt-1"></i>
                            <div>
                                <p class="font-semibold text-gray-900 text-sm">Notifikasi Status</p>
                                <p class="text-gray-600 text-sm">Anda akan mendapat konfirmasi via WhatsApp</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-search text-yellow-500 mr-3 mt-1"></i>
                            <div>
                                <p class="font-semibold text-gray-900 text-sm">Cek Status</p>
                                <p class="text-gray-600 text-sm">Gunakan fitur tracking untuk memantau status</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100 relative overflow-hidden group hover:shadow-xl transition-all duration-300">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-green-500 to-green-600"></div>
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mr-4">
                            <span class="text-green-600 font-bold text-lg">3</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Kunjungan Disetujui</h3>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mr-3 mt-1"></i>
                            <div>
                                <p class="font-semibold text-gray-900 text-sm">Pengajuan Disetujui</p>
                                <p class="text-gray-600 text-sm">Anda akan mendapat konfirmasi persetujuan</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-print text-green-500 mr-3 mt-1"></i>
                            <div>
                                <p class="font-semibold text-gray-900 text-sm">Siapkan Surat Fisik</p>
                                <p class="text-gray-600 text-sm">Print dan bawa surat pengajuan asli</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-map-marker-alt text-green-500 mr-3 mt-1"></i>
                            <div>
                                <p class="font-semibold text-gray-900 text-sm">Datang ke Laboratorium</p>
                                <p class="text-gray-600 text-sm">Sesuai tanggal dan waktu yang telah ditentukan</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Important Notes -->
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-triangle text-blue-600 text-xl mr-3 mt-1"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-blue-900 mb-3">Penting untuk Diperhatikan:</h4>
                        <ul class="space-y-2 text-sm text-blue-800">
                            <li class="flex items-start">
                                <i class="fas fa-chevron-right text-blue-600 mr-2 mt-1 text-xs"></i>
                                <span>Pengajuan harus disubmit minimal <strong>3 hari sebelum</strong> tanggal kunjungan yang diinginkan</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-chevron-right text-blue-600 mr-2 mt-1 text-xs"></i>
                                <span>Surat pengajuan harus menggunakan <strong>kop surat resmi institusi</strong> dan ditandatangani pejabat berwenang</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-chevron-right text-blue-600 mr-2 mt-1 text-xs"></i>
                                <span>Bawa <strong>surat pengajuan asli</strong> dan <strong>identitas diri</strong> saat berkunjung</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-chevron-right text-blue-600 mr-2 mt-1 text-xs"></i>
                                <span>Jika ada perubahan jadwal, segera hubungi admin laboratorium</span>
                            </li>
                        </ul>
                        
                        <!-- Quick Actions -->
                        <div class="mt-4 pt-4 border-t border-blue-200">
                            <div class="flex flex-wrap gap-3">
                                <a href="{{ route('tracking') }}?type=kunjungan" 
                                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200">
                                    <i class="fas fa-search mr-2"></i>
                                    Cek Status Kunjungan
                                </a>
                                <a href="{{ route('template.index') }}" 
                                   class="inline-flex items-center px-4 py-2 bg-white text-blue-600 text-sm font-medium rounded-lg border border-blue-600 hover:bg-blue-50 transition-colors duration-200">
                                    <i class="fas fa-download mr-2"></i>
                                    Unduh Template Surat
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section Header -->
        <div class="text-center mb-12 scroll-animate" data-animation="fade-down">
            <div class="inline-flex items-center px-6 py-3 bg-blue-50 border border-blue-200 rounded-full text-blue-700 text-sm font-semibold mb-6 shadow-sm">
                <i class="fas fa-calendar-alt mr-2"></i>
                Formulir Pendaftaran Kunjungan
            </div>
            <h2 class="font-poppins text-3xl md:text-5xl font-bold text-gray-900 mb-6">
                Formulir <span class="bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent">Kunjungan</span>
            </h2>
            <p class="text-gray-600 text-lg max-w-3xl mx-auto leading-relaxed">
                Isi formulir di bawah ini untuk mengajukan kunjungan ke laboratorium kami.
            </p>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="mb-6 p-6 bg-green-50 border border-green-200 rounded-xl text-green-700 text-center font-semibold scroll-animate" data-animation="fade-up">
                {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="mb-6 p-6 bg-red-50 border border-red-200 rounded-xl text-red-700 text-center font-semibold scroll-animate" data-animation="fade-up">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <!-- Form -->
        <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100 scroll-animate" data-animation="fade-up" data-delay="200">
            <form action="{{ route('user.kunjungan.store') }}" method="POST" enctype="multipart/form-data" id="visit-form">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nama Pengunjung -->
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2" for="namaPengunjung">Nama Pengunjung *</label>
                        <div class="relative">
                            <input type="text" name="namaPengunjung" id="namaPengunjung" required
                                   class="w-full px-4 py-3 pl-10 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                   value="{{ old('namaPengunjung') }}" aria-label="Nama Pengunjung">
                            <i class="fas fa-user absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                    </div>

                    <!-- Nomor HP -->
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2" for="noHp">Nomor HP *</label>
                        <div class="relative">
                            <input type="text" name="noHp" id="noHp" required
                                   class="w-full px-4 py-3 pl-10 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                   value="{{ old('noHp') }}" aria-label="Nomor HP">
                            <i class="fas fa-phone absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                    </div>

                    <!-- Nama Instansi -->
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2" for="namaInstansi">Nama Instansi *</label>
                        <div class="relative">
                            <input type="text" name="namaInstansi" id="namaInstansi" required
                                   class="w-full px-4 py-3 pl-10 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                   value="{{ old('namaInstansi') }}" aria-label="Nama Instansi">
                            <i class="fas fa-building absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                    </div>

                    <!-- Tujuan Kunjungan -->
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2" for="tujuan">Tujuan Kunjungan *</label>
                        <div class="relative">
                            <input type="text" name="tujuan" id="tujuan" required
                                   class="w-full px-4 py-3 pl-10 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                   value="{{ old('tujuan') }}" aria-label="Tujuan Kunjungan">
                            <i class="fas fa-info-circle absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                    </div>

                    <!-- Jumlah Pengunjung -->
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2" for="jumlahPengunjung">Jumlah Pengunjung *</label>
                        <div class="relative">
                            <input type="number" name="jumlahPengunjung" id="jumlahPengunjung" min="1" max="50" required
                                   class="w-full px-4 py-3 pl-10 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                   value="{{ old('jumlahPengunjung', 1) }}" aria-label="Jumlah Pengunjung">
                            <i class="fas fa-users absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                    </div>

                    <!-- Tanggal Kunjungan -->
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2" for="tanggal">Tanggal Kunjungan *</label>
                        <div class="relative">
                            <input type="date" name="tanggal" id="tanggal" required
                                   class="w-full px-4 py-3 pl-10 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                   value="{{ old('tanggal') }}" min="{{ now()->toDateString() }}" aria-label="Tanggal Kunjungan">
                            <i class="fas fa-calendar absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                    </div>

                    <!-- Jam Kunjungan -->
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2" for="jamMulai">Pilih Jam Kunjungan *</label>
                        <div class="relative">
                            <select name="jamMulai" id="jamMulai" required
                                    class="w-full px-4 py-3 pl-10 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                    aria-label="Pilih Jam Mulai Kunjungan">
                                <option value="">-- Pilih Jam Mulai --</option>
                            </select>
                            <i class="fas fa-clock absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="hidden" name="jamSelesai" id="jamSelesai" aria-hidden="true">
                        </div>
                    </div>

                    <!-- Upload Surat Pengajuan -->
                    <div class="mb-6">
                        <div class="flex items-center justify-between mb-3">
                            <label class="block text-sm font-semibold text-gray-700" for="suratPengajuan">
                                Upload Surat Pengajuan *
                            </label>
                            <a href="{{ route('template.index') }}" 
                               class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center">
                                <i class="fas fa-download mr-1"></i>Unduh Template
                            </a>
                        </div>
                        
                        <!-- File Upload Area -->
                        <div class="relative border-2 border-dashed border-gray-300 rounded-xl p-6 hover:border-blue-400 transition-colors duration-200" id="uploadArea">
                            <input type="file" name="suratPengajuan" id="suratPengajuan" accept=".pdf,.jpg,.jpeg,.png" required
                                   class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                   aria-label="Upload Surat Pengajuan">
                            
                            <div class="text-center" id="uploadPlaceholder">
                                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <i class="fas fa-upload text-blue-600 text-xl"></i>
                                </div>
                                <p class="text-gray-700 font-medium mb-1">Klik untuk upload atau drag & drop</p>
                                <p class="text-sm text-gray-500">PDF, JPG, PNG • Maksimal 2MB</p>
                            </div>
                            
                            <div class="hidden" id="uploadPreview">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-file-alt text-green-600"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-medium text-gray-900" id="fileName"></p>
                                        <p class="text-sm text-gray-500" id="fileSize"></p>
                                    </div>
                                    <button type="button" class="text-red-600 hover:text-red-800" id="removeFile">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        @error('suratPengajuan')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                        
                        <!-- Requirements -->
                        <div class="mt-3 bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                            <h5 class="font-semibold text-yellow-900 text-sm mb-2">Persyaratan Surat:</h5>
                            <ul class="text-xs text-yellow-800 space-y-1">
                                <li>• Menggunakan kop surat resmi institusi</li>
                                <li>• Ditujukan kepada Ketua Departemen Fisika FMIPA USK</li>
                                <li>• Mencantumkan data lengkap pengunjung dan tujuan kunjungan</li>
                                <li>• Ditandatangani oleh pejabat berwenang</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end mt-8">
                    <button type="submit"
                            class="bg-blue-600 text-white px-8 py-4 rounded-xl font-bold text-lg hover:bg-blue-700 transition-colors duration-200 flex items-center">
                        <i class="fas fa-paper-plane mr-2"></i>Kirim Permohonan
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    @include('user.components.service-info')
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

.spinner {
    border: 2px solid #f3f3f3;
    border-top: 2px solid #3498db;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    animation: spin 1s linear infinite;
    display: inline-block;
    vertical-align: middle;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    initScrollAnimations();
    initForm();
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

    animatedElements.forEach(element => observer.observe(element));
}

function initForm() {
    const tanggalInput = document.getElementById('tanggal');
    const jamMulaiSelect = document.getElementById('jamMulai');
    const jamSelesaiInput = document.getElementById('jamSelesai');
    const form = document.getElementById('visit-form');

    tanggalInput.addEventListener('change', async function() {
        const tanggal = this.value;
        if (!tanggal) {
            jamMulaiSelect.innerHTML = '<option value="">-- Pilih Jam Mulai --</option>';
            return;
        }

        jamMulaiSelect.innerHTML = '<option value="">Memuat... <span class="spinner"></span></option>';

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        if (!csrfToken) {
            jamMulaiSelect.innerHTML = '<option value="">Gagal: CSRF token tidak ditemukan</option>';
            return;
        }

        try {
            const response = await fetch(`/jadwal/get-available-sessions?date=${tanggal}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            });

            if (!response.ok) {
                throw new Error(`HTTP error ${response.status}`);
            }

            const data = await response.json();
            jamMulaiSelect.innerHTML = '<option value="">-- Pilih Jam Mulai --</option>';

            if (data.error) {
                jamMulaiSelect.innerHTML = `<option value="">${data.error}</option>`;
            } else if (data.available_sessions && data.available_sessions.length > 0) {
                data.available_sessions.forEach(session => {
                    const option = document.createElement('option');
                    option.value = session.jamMulai;
                    option.textContent = `${session.jamMulai.substring(0, 5)} - ${session.jamSelesai.substring(0, 5)}`;
                    option.dataset.jamSelesai = session.jamSelesai;
                    jamMulaiSelect.appendChild(option);
                });
            } else {
                jamMulaiSelect.innerHTML = '<option value="">Tidak ada jadwal tersedia untuk tanggal ini</option>';
            }
            jamSelesaiInput.value = '';
        } catch (error) {
            console.error('Fetch error:', error.message);
            jamMulaiSelect.innerHTML = '<option value="">Gagal memuat jadwal: Silakan coba lagi</option>';
        }
    });

    jamMulaiSelect.addEventListener('change', function() {
        const selected = this.options[this.selectedIndex];
        jamSelesaiInput.value = selected ? selected.dataset.jamSelesai : '';
    });

    form.addEventListener('submit', function(e) {
        if (!jamMulaiSelect.value) {
            e.preventDefault();
            alert('Pilih jam kunjungan terlebih dahulu.');
        }
    });
    
    // Initialize file upload enhancement
    initFileUpload();
}

function initFileUpload() {
    const fileInput = document.getElementById('suratPengajuan');
    const uploadArea = document.getElementById('uploadArea');
    const placeholder = document.getElementById('uploadPlaceholder');
    const preview = document.getElementById('uploadPreview');
    const fileName = document.getElementById('fileName');
    const fileSize = document.getElementById('fileSize');
    const removeBtn = document.getElementById('removeFile');

    // Drag and drop events
    uploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        uploadArea.classList.add('border-blue-400', 'bg-blue-50');
    });

    uploadArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        uploadArea.classList.remove('border-blue-400', 'bg-blue-50');
    });

    uploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        uploadArea.classList.remove('border-blue-400', 'bg-blue-50');
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            handleFileSelection(files[0]);
        }
    });

    // File input change
    fileInput.addEventListener('change', function(e) {
        if (e.target.files.length > 0) {
            handleFileSelection(e.target.files[0]);
        }
    });

    // Remove file
    removeBtn.addEventListener('click', function() {
        fileInput.value = '';
        placeholder.classList.remove('hidden');
        preview.classList.add('hidden');
        uploadArea.classList.remove('border-green-400');
    });

    function handleFileSelection(file) {
        // Validate file type
        const allowedTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];
        if (!allowedTypes.includes(file.type)) {
            alert('Format file tidak didukung. Gunakan PDF, JPG, atau PNG.');
            return;
        }

        // Validate file size (2MB = 2097152 bytes)
        if (file.size > 2097152) {
            alert('Ukuran file terlalu besar. Maksimal 2MB.');
            return;
        }

        // Update preview
        fileName.textContent = file.name;
        fileSize.textContent = formatFileSize(file.size);
        placeholder.classList.add('hidden');
        preview.classList.remove('hidden');
        uploadArea.classList.add('border-green-400');
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }
}
</script>
@endsection