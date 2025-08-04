@extends('user.layouts.app')

@section('title', 'Formulir Peminjaman - Laboratorium Fisika Material dan Energi')

@section('content')
<!-- Hero Section -->
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
        <!-- Selected Equipment Summary -->
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

            <!-- User Type Selection -->
            <div class="mb-8">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Kategori Peminjam</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <label class="user-type-option cursor-pointer">
                        <input type="radio" name="user_type" value="dosen" class="sr-only">
                        <div class="p-6 border-2 border-gray-200 rounded-xl text-left hover:border-blue-300 hover:bg-blue-50 transition-all duration-300">
                            <div class="flex items-center mb-3">
                                <i class="fas fa-user-tie text-2xl text-blue-600 mr-3"></i>
                                <h4 class="font-semibold text-gray-900">Dosen</h4>
                            </div>
                            <p class="text-sm text-gray-600">Dosen USK yang akan menggunakan sarana laboratorium untuk penelitian</p>
                        </div>
                    </label>
                    
                    <label class="user-type-option cursor-pointer">
                        <input type="radio" name="user_type" value="mahasiswa" class="sr-only">
                        <div class="p-6 border-2 border-gray-200 rounded-xl text-left hover:border-blue-300 hover:bg-blue-50 transition-all duration-300">
                            <div class="flex items-center mb-3">
                                <i class="fas fa-user-graduate text-2xl text-green-600 mr-3"></i>
                                <h4 class="font-semibold text-gray-900">Mahasiswa</h4>
                            </div>
                            <p class="text-sm text-gray-600">Mahasiswa yang akan menggunakan sarana laboratorium untuk penelitian</p>
                        </div>
                    </label>
                    
                    <label class="user-type-option cursor-pointer">
                        <input type="radio" name="user_type" value="pihak-luar" class="sr-only">
                        <div class="p-6 border-2 border-gray-200 rounded-xl text-left hover:border-blue-300 hover:bg-blue-50 transition-all duration-300">
                            <div class="flex items-center mb-3">
                                <i class="fas fa-building text-2xl text-purple-600 mr-3"></i>
                                <h4 class="font-semibold text-gray-900">Pihak Luar USK</h4>
                            </div>
                            <p class="text-sm text-gray-600">Pihak luar USK yang ingin menggunakan peralatan laboratorium</p>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Applicant Information -->
            <div class="mb-8">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Informasi Pemohon</h3>
                
                <!-- Dosen Form -->
                <div id="dosenForm" class="user-form hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Dosen *</label>
                            <input type="text" name="nama_dosen" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">NIP *</label>
                            <input type="text" name="nip_dosen" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">No HP *</label>
                            <input type="text" name="no_hp_dosen" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Email *</label>
                            <input type="email" name="email_dosen" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                </div>

                <!-- Mahasiswa Form -->
                <div id="mahasiswaForm" class="user-form hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Mahasiswa *</label>
                            <input type="text" name="nama_mahasiswa" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">NIM *</label>
                            <input type="text" name="nim_mahasiswa" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">No HP *</label>
                            <input type="text" name="no_hp_mahasiswa" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Email *</label>
                            <input type="email" name="email_mahasiswa" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                    
                    <!-- Supervisor Information -->
                    <div class="mt-6 p-4 bg-green-50 rounded-xl border border-green-200">
                        <h4 class="font-semibold text-green-900 mb-4">Informasi Dosen Pembimbing</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Dosen Pembimbing *</label>
                                <input type="text" name="nama_pembimbing" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">NIP Dosen Pembimbing *</label>
                                <input type="text" name="nip_pembimbing" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pihak Luar Form -->
                <div id="pihakLuarForm" class="user-form hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap *</label>
                            <input type="text" name="nama_pihak_luar" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">NIP/ID *</label>
                            <input type="text" name="nip_pihak_luar" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Instansi *</label>
                            <input type="text" name="instansi" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Jabatan *</label>
                            <input type="text" name="jabatan" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">No HP *</label>
                            <input type="text" name="no_hp_pihak_luar" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Email *</label>
                            <input type="email" name="email_pihak_luar" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Research Information -->
            <div class="mb-8">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Informasi Penelitian</h3>
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Judul Penelitian *</label>
                        <input type="text" name="judul_penelitian" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Masukkan judul penelitian">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi Penelitian</label>
                        <textarea name="deskripsi_penelitian" rows="4" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Jelaskan secara singkat tentang penelitian yang akan dilakukan"></textarea>
                    </div>
                </div>
            </div>

            <!-- Research Schedule -->
            <div class="mb-8">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Jadwal Penelitian</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Mulai Penelitian *</label>
                        <input type="date" name="tanggal_mulai" id="tanggalMulai" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <p class="text-sm text-gray-500 mt-1">Minimal 7 hari dari hari ini</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Selesai Penelitian *</label>
                        <input type="date" name="tanggal_selesai" id="tanggalSelesai" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Waktu Penelitian *</label>
                        <input type="time" name="waktu_mulai" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Durasi (Jam) *</label>
                        <input type="number" name="durasi_jam" min="1" max="24" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
            </div>

            <!-- Terms and Conditions -->
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

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-xl font-semibold hover:bg-blue-700 transition-colors">
                    <i class="fas fa-paper-plane mr-2"></i>Ajukan Peminjaman
                </button>
            </div>
        </form>
    </div>
</section>

<style>
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

    animatedElements.forEach(element => {
        observer.observe(element);
    });
}

function initUserTypeSelection() {
    const userTypeOptions = document.querySelectorAll('.user-type-option input');
    const userForms = document.querySelectorAll('.user-form');

    userTypeOptions.forEach(option => {
        option.addEventListener('change', function() {
            const userType = this.value;
            
            // Hide all forms
            userForms.forEach(form => form.classList.add('hidden'));
            
            // Show selected form
            document.getElementById(userType + 'Form').classList.remove('hidden');
        });
    });
}

function initDateValidation() {
    const today = new Date();
    const minDate = new Date(today.getTime() + (7 * 24 * 60 * 60 * 1000)); // 7 days from now
    
    const tanggalMulai = document.getElementById('tanggalMulai');
    const tanggalSelesai = document.getElementById('tanggalSelesai');
    
    tanggalMulai.setAttribute('min', minDate.toISOString().split('T')[0]);
    
    tanggalMulai.addEventListener('change', function() {
        const startDate = new Date(this.value);
        const minEndDate = new Date(startDate.getTime() + (24 * 60 * 60 * 1000)); // 1 day after start
        tanggalSelesai.setAttribute('min', minEndDate.toISOString().split('T')[0]);
    });
}

function loadSelectedEquipment() {
    console.log('Loading selected equipment from session storage...');
    const selectedEquipment = JSON.parse(sessionStorage.getItem('selectedEquipment') || '[]');
    const displayDiv = document.getElementById('selectedEquipmentDisplay');
    const inputDiv = document.getElementById('selectedEquipmentInput');
    
    console.log('Selected equipment from session:', selectedEquipment);
    
    if (selectedEquipment.length === 0) {
        console.log('No equipment selected, redirecting...');
        // Redirect back to equipment selection if no equipment selected
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

// Form validation
document.getElementById('loanForm').addEventListener('submit', function(e) {
    console.log('Form submission started');
    
    const userType = document.querySelector('input[name="user_type"]:checked');
    
    if (!userType) {
        e.preventDefault();
        alert('Silakan pilih kategori peminjam terlebih dahulu.');
        return;
    }
    
    // Additional validation based on user type
    if (userType.value === 'mahasiswa') {
        const pembimbing = document.querySelector('input[name="nama_pembimbing"]').value;
        if (!pembimbing) {
            e.preventDefault();
            alert('Nama dosen pembimbing harus diisi untuk mahasiswa.');
            return;
        }
    }
    
    const selectedEquipment = JSON.parse(document.getElementById('selectedEquipmentInput').value || '[]');
    if (selectedEquipment.length === 0) {
        e.preventDefault();
        alert('Silakan pilih minimal satu peralatan.');
        return;
    }
    
    console.log('Form validation passed, submitting...');
    console.log('Selected equipment:', selectedEquipment);
    console.log('User type:', userType.value);
});
</script>
@endsection 