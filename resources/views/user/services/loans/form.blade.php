@extends('user.layouts.app')

@section('title', 'Formulir Peminjaman - Laboratorium Fisika Material dan Energi')

@section('content')
<!-- Hero Section (unchanged) -->
<section class="relative min-h-[50vh] flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('/images/hero.jpg') }}" alt="Formulir Peminjaman" class="w-full h-full object-cover">
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
                            <span class="text-white font-medium">Formulir</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
        <div class="scroll-animate mb-8 opacity-0" data-animation="fade-up" data-delay="200">
            <h1 class="font-poppins text-4xl md:text-6xl font-bold leading-tight mb-6">
                <span class="text-white">Formulir</span>
                <span class="bg-gradient-to-r from-yellow-400 to-orange-400 bg-clip-text text-transparent drop-shadow-lg"> Peminjaman</span>
            </h1>
            <p class="text-xl md:text-2xl text-blue-100 max-w-4xl mx-auto leading-relaxed">
                Langkah 2: Lengkapi data peminjaman
            </p>
        </div>
    </div>
</section>

<!-- Form Section -->
<section class="py-16 bg-gradient-to-b from-gray-50 to-white">
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
        <!-- Selected Equipment Summary (unchanged) -->
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 mb-8">
            <h3 class="text-lg font-semibold text-blue-900 mb-4">Alat yang Dipilih</h3>
            <div id="selectedEquipmentDisplay" class="space-y-2"></div>
            <div class="mt-4 pt-4 border-t border-blue-200">
                <a href="{{ route('equipment.loan') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                    <i class="fas fa-edit mr-1"></i>Ubah Pilihan Alat
                </a>
            </div>
        </div>

        <!-- Loan Form -->
        <form id="loanForm" method="POST" action="{{ route('equipment.loan.submit') }}" class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
            @csrf
            <input type="hidden" name="selected_equipment" id="selectedEquipmentInput">

            <!-- Error Messages (unchanged) -->
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

            <!-- User Type Selection (add old input support) -->
            <div class="mb-8">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Kategori Peminjam</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <label class="user-type-option cursor-pointer">
                        <input type="radio" name="user_type" value="dosen" class="sr-only" {{ old('user_type') == 'dosen' ? 'checked' : '' }}>
                        <div class="p-6 border-2 border-gray-200 rounded-xl text-left hover:border-blue-300 hover:bg-blue-50 transition-all duration-300">
                            <div class="flex items-center mb-3">
                                <i class="fas fa-user-tie text-2xl text-blue-600 mr-3"></i>
                                <h4 class="font-semibold text-gray-900">Dosen</h4>
                            </div>
                            <p class="text-sm text-gray-600">Dosen USK yang akan menggunakan sarana laboratorium untuk penelitian</p>
                        </div>
                    </label>
                    <label class="user-type-option cursor-pointer">
                        <input type="radio" name="user_type" value="mahasiswa" class="sr-only" {{ old('user_type') == 'mahasiswa' ? 'checked' : '' }}>
                        <div class="p-6 border-2 border-gray-200 rounded-xl text-left hover:border-blue-300 hover:bg-blue-50 transition-all duration-300">
                            <div class="flex items-center mb-3">
                                <i class="fas fa-user-graduate text-2xl text-green-600 mr-3"></i>
                                <h4 class="font-semibold text-gray-900">Mahasiswa</h4>
                            </div>
                            <p class="text-sm text-gray-600">Mahasiswa yang akan menggunakan sarana laboratorium untuk penelitian</p>
                        </div>
                    </label>
                    <label class="user-type-option cursor-pointer">
                        <input type="radio" name="user_type" value="pihak-luar" class="sr-only" {{ old('user_type') == 'pihak-luar' ? 'checked' : '' }}>
                        <div class="p-6 border-2 border-gray-200 rounded-xl text-left hover:border-blue-300 hover:bg-blue-50 transition-all duration-300">
                            <div class="flex items-center mb-3">
                                <i class="fas fa-building text-2xl text-purple-600 mr-3"></i>
                                <h4 class="font-semibold text-gray-900">Pihak Luar USK</h4>
                            </div>
                            <p class="text-sm text-gray-600">Pihak luar USK yang ingin menggunakan peralatan laboratorium</p>
                        </div>
                    </label>
                </div>
                @error('user_type')
                    <div class="text-red-600 text-sm mt-2">{{ $message }}</div>
                @enderror
            </div>

            <!-- Applicant Information (add old input and error display) -->
            <div class="mb-8">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Informasi Pemohon</h3>

                <!-- Dosen Form -->
                <div id="dosenForm" class="user-form hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Dosen *</label>
                            <input type="text" name="nama_dosen" value="{{ old('nama_dosen') }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('nama_dosen')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">NIP *</label>
                            <input type="text" name="nip_dosen" value="{{ old('nip_dosen') }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('nip_dosen')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">No HP *</label>
                            <input type="text" name="no_hp_dosen" value="{{ old('no_hp_dosen') }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('no_hp_dosen')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Email *</label>
                            <input type="email" name="email_dosen" value="{{ old('email_dosen') }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('email_dosen')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Mahasiswa Form -->
                <div id="mahasiswaForm" class="user-form hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Mahasiswa *</label>
                            <input type="text" name="nama_mahasiswa" value="{{ old('nama_mahasiswa') }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('nama_mahasiswa')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">NIM *</label>
                            <input type="text" name="nim_mahasiswa" value="{{ old('nim_mahasiswa') }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('nim_mahasiswa')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">No HP *</label>
                            <input type="text" name="no_hp_mahasiswa" value="{{ old('no_hp_mahasiswa') }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('no_hp_mahasiswa')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Email *</label>
                            <input type="email" name="email_mahasiswa" value="{{ old('email_mahasiswa') }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('email_mahasiswa')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mt-6 p-4 bg-green-50 rounded-xl border border-green-200">
                        <h4 class="font-semibold text-green-900 mb-4">Informasi Dosen Pembimbing</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Dosen Pembimbing *</label>
                                <input type="text" name="nama_pembimbing" value="{{ old('nama_pembimbing') }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                @error('nama_pembimbing')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">NIP Dosen Pembimbing *</label>
                                <input type="text" name="nip_pembimbing" value="{{ old('nip_pembimbing') }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                @error('nip_pembimbing')
                                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pihak Luar Form -->
                <div id="pihakLuarForm" class="user-form hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap *</label>
                            <input type="text" name="nama_pihak_luar" value="{{ old('nama_pihak_luar') }}" placeholder="Nama Lengkap" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('nama_pihak_luar')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">NIP/ID *</label>
                            <input type="text" name="nip_pihak_luar" value="{{ old('nip_pihak_luar') }}" placeholder="NIP/ID" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('nip_pihak_luar')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Instansi *</label>
                            <input type="text" name="instansi" value="{{ old('instansi') }}" placeholder="Instansi" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('instansi')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Jabatan *</label>
                            <input type="text" name="jabatan" value="{{ old('jabatan') }}" placeholder="Jabatan" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('jabatan')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">No HP *</label>
                            <input type="text" name="no_hp_pihak_luar" value="{{ old('no_hp_pihak_luar') }}" placeholder="No HP" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('no_hp_pihak_luar')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Email *</label>
                            <input type="email" name="email_pihak_luar" value="{{ old('email_pihak_luar') }}" placeholder="Email" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('email_pihak_luar')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Research Information (add tujuan_peminjaman) -->
            <div class="mb-8">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Informasi Penelitian</h3>
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Judul Penelitian *</label>
                        <input type="text" name="judul_penelitian" value="{{ old('judul_penelitian') }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Masukkan judul penelitian">
                        @error('judul_penelitian')
                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi Penelitian</label>
                        <textarea name="deskripsi_penelitian" rows="4" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Jelaskan secara singkat tentang penelitian yang akan dilakukan">{{ old('deskripsi_penelitian') }}</textarea>
                        @error('deskripsi_penelitian')
                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tujuan Peminjaman</label>
                        <textarea name="tujuan_peminjaman" rows="4" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Jelaskan tujuan peminjaman alat">{{ old('tujuan_peminjaman') }}</textarea>
                        @error('tujuan_peminjaman')
                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Research Schedule (unchanged) -->
            <div class="mb-8">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Jadwal Penelitian</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Mulai Penelitian *</label>
                        <input type="date" name="tanggal_mulai" id="tanggalMulai" value="{{ old('tanggal_mulai') }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <p class="text-sm text-gray-500 mt-1">Minimal 7 hari dari hari ini</p>
                        @error('tanggal_mulai')
                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Selesai Penelitian *</label>
                        <input type="date" name="tanggal_selesai" id="tanggalSelesai" value="{{ old('tanggal_selesai') }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @error('tanggal_selesai')
                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Waktu Penelitian *</label>
                        <input type="time" name="waktu_mulai" value="{{ old('waktu_mulai') }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @error('waktu_mulai')
                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Durasi (Jam) *</label>
                        <input type="number" name="durasi_jam" min="1" max="24" value="{{ old('durasi_jam') }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @error('durasi_jam')
                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Terms and Conditions (unchanged) -->
            <div class="mb-8">
                <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6">
                    <h4 class="font-semibold text-yellow-900 mb-4">Ketentuan dan Tanggung Jawab</h4>
                    <div class="space-y-3 text-sm text-yellow-800">
                        <p>1. Segala sesuatu yang menyebabkan kerugian akan menjadi tanggung jawab peminjam yang bersangkutan.</p>
                        <p>2. Peminjam wajib mengembalikan peralatan dalam kondisi yang sama seperti saat dipinjam.</p>
                        <p>3. Peminjam wajib mengikuti prosedur keselamatan laboratorium yang berlaku.</p>
                        <p>4. Permohonan harus diajukan minimal 7 hari sebelum kegiatan penelitian dilakukan.</p>
                    </div>
                </div>
            </div>

            <!-- Submit Button (unchanged) -->
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-xl font-semibold hover:bg-blue-700 transition-colors">
                    <i class="fas fa-paper-plane mr-2"></i>Ajukan Peminjaman
                </button>
            </div>
        </form>
    </div>
</section>

<style>
/* Unchanged styles */
.user-type-option input:checked + div {
    border-color: #3b82f6;
    background-color: #eff6ff;
}
.user-form {
    transition: all 0.3s ease;
}
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
    initUserTypeSelection();
    initDateValidation();
    loadSelectedEquipment();
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

function initUserTypeSelection() {
    const userTypeOptions = document.querySelectorAll('.user-type-option input');
    const userForms = document.querySelectorAll('.user-form');

    userTypeOptions.forEach(option => {
        option.addEventListener('change', function() {
            const userType = this.value;
            console.log('User type selected:', userType); // Debug log

            // Hide all forms
            userForms.forEach(form => form.classList.add('hidden'));

            // Map user type to form ID
            const formIdMap = {
                'dosen': 'dosenForm',
                'mahasiswa': 'mahasiswaForm',
                'pihak-luar': 'pihakLuarForm' // Explicit mapping for pihak-luar
            };

            // Show the selected form
            const selectedFormId = formIdMap[userType];
            const selectedForm = document.getElementById(selectedFormId);
            if (selectedForm) {
                console.log('Showing form:', selectedFormId); // Debug log
                selectedForm.classList.remove('hidden');
            } else {
                console.error('Form not found for ID:', selectedFormId); // Error log
            }
        });
    });

    // Show form for pre-selected user type (e.g., from old input)
    const checked = document.querySelector('.user-type-option input:checked');
    if (checked) {
        console.log('Pre-selected user type:', checked.value); // Debug log
        userForms.forEach(form => form.classList.add('hidden'));
        const formIdMap = {
            'dosen': 'dosenForm',
            'mahasiswa': 'mahasiswaForm',
            'pihak-luar': 'pihakLuarForm'
        };
        const selectedFormId = formIdMap[checked.value];
        const selectedForm = document.getElementById(selectedFormId);
        if (selectedForm) {
            selectedForm.classList.remove('hidden');
            console.log('Pre-showing form:', selectedFormId); // Debug log
        }
    }
}

function initDateValidation() {
    const today = new Date();
    const minDate = new Date(today.getTime() + (7 * 24 * 60 * 60 * 1000));
    const tanggalMulai = document.getElementById('tanggalMulai');
    const tanggalSelesai = document.getElementById('tanggalSelesai');

    if (tanggalMulai) {
        tanggalMulai.setAttribute('min', minDate.toISOString().split('T')[0]);
        tanggalMulai.addEventListener('change', function() {
            const startDate = new Date(this.value);
            const minEndDate = new Date(startDate.getTime() + (24 * 60 * 60 * 1000));
            if (tanggalSelesai) {
                tanggalSelesai.setAttribute('min', minEndDate.toISOString().split('T')[0]);
            }
        });
    }
}

function loadSelectedEquipment() {
    console.log('Loading selected equipment from session storage...');
    const selectedEquipment = JSON.parse(sessionStorage.getItem('selectedEquipment') || '[]');
    const displayDiv = document.getElementById('selectedEquipmentDisplay');
    const inputDiv = document.getElementById('selectedEquipmentInput');

    console.log('Selected equipment from session:', selectedEquipment);

    if (selectedEquipment.length === 0) {
        console.log('No equipment selected, redirecting...');
        window.location.href = '{{ route("equipment.loan") }}';
        return;
    }

    let html = '';
    selectedEquipment.forEach(item => {
        html += `<div class="flex items-center justify-between p-3 bg-white rounded-lg border border-blue-200">
            <div class="flex items-center space-x-3">
                <i class="fas fa-tools text-blue-600"></i>
                <span class="font-medium">${item.nama}</span>
            </div>
            <span class="text-sm text-blue-600 font-semibold">${item.jumlah} unit</span>
        </div>`;
    });

    displayDiv.innerHTML = html;
    inputDiv.value = JSON.stringify(selectedEquipment);
    console.log('Equipment loaded successfully');
}

document.getElementById('loanForm').addEventListener('submit', function(e) {
    console.log('Form submission started');

    const userType = document.querySelector('input[name="user_type"]:checked');
    console.log('Checked userType:', userType ? userType.value : null);

    if (!userType) {
        console.log('No user type selected');
        e.preventDefault();
        alert('Silakan pilih kategori peminjam terlebih dahulu.');
        return;
    }

    // Client-side validation for user type fields
    if (userType.value === 'dosen') {
        console.log('Validating dosen fields');
        const namaDosen = document.querySelector('input[name="nama_dosen"]').value;
        const nipDosen = document.querySelector('input[name="nip_dosen"]').value;
        const noHpDosen = document.querySelector('input[name="no_hp_dosen"]').value;
        const emailDosen = document.querySelector('input[name="email_dosen"]').value;
        if (!namaDosen || !nipDosen || !noHpDosen || !emailDosen) {
            console.log('Dosen fields incomplete');
            e.preventDefault();
            alert('Semua field dosen harus diisi.');
            return;
        }
    } else if (userType.value === 'mahasiswa') {
        console.log('Validating mahasiswa fields');
        const namaMahasiswa = document.querySelector('input[name="nama_mahasiswa"]').value;
        const nimMahasiswa = document.querySelector('input[name="nim_mahasiswa"]').value;
        const noHpMahasiswa = document.querySelector('input[name="no_hp_mahasiswa"]').value;
        const emailMahasiswa = document.querySelector('input[name="email_mahasiswa"]').value;
        const namaPembimbing = document.querySelector('input[name="nama_pembimbing"]').value;
        const nipPembimbing = document.querySelector('input[name="nip_pembimbing"]').value;
        if (!namaMahasiswa || !nimMahasiswa || !noHpMahasiswa || !emailMahasiswa || !namaPembimbing || !nipPembimbing) {
            console.log('Mahasiswa fields incomplete');
            e.preventDefault();
            alert('Semua field mahasiswa dan dosen pembimbing harus diisi.');
            return;
        }
    } else if (userType.value === 'pihak-luar') {
        console.log('Validating pihak luar fields');
        const namaPihakLuar = document.querySelector('input[name="nama_pihak_luar"]').value;
        const nipPihakLuar = document.querySelector('input[name="nip_pihak_luar"]').value;
        const instansi = document.querySelector('input[name="instansi"]').value;
        const jabatan = document.querySelector('input[name="jabatan"]').value;
        const noHpPihakLuar = document.querySelector('input[name="no_hp_pihak_luar"]').value;
        const emailPihakLuar = document.querySelector('input[name="email_pihak_luar"]').value;
        if (!namaPihakLuar || !nipPihakLuar || !instansi || !jabatan || !noHpPihakLuar || !emailPihakLuar) {
            console.log('Pihak luar fields incomplete');
            e.preventDefault();
            alert('Semua field pihak luar harus diisi.');
            return;
        }
    }

    const selectedEquipment = JSON.parse(document.getElementById('selectedEquipmentInput').value || '[]');
    console.log('Selected equipment:', selectedEquipment);
    if (selectedEquipment.length === 0) {
        console.log('No equipment selected');
        e.preventDefault();
        alert('Silakan pilih minimal satu peralatan.');
        return;
    }

    console.log('Form validation passed, submitting...');
});
</script>
@endsection