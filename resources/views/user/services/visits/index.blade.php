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
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2" for="suratPengajuan">Upload Surat Pengajuan (PDF/JPG/PNG, max 2MB) *</label>
                        <div class="relative">
                            <input type="file" name="suratPengajuan" id="suratPengajuan" accept=".pdf,.jpg,.jpeg,.png" required
                                   class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                   aria-label="Upload Surat Pengajuan">
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
}
</script>
@endsection