@extends('user.layouts.app')

@section('title', 'Formulir Peminjaman Alat - Laboratorium Fisika Material dan Energi')

@section('content')
<!-- Hero Section -->
<section class="relative min-h-[60vh] flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('/images/hero.jpg') }}" alt="Formulir Peminjaman Alat" class="w-full h-full object-cover">
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
                            <span class="text-white font-medium">Formulir Peminjaman</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>

        <div class="scroll-animate mb-8 opacity-0" data-animation="fade-up" data-delay="200">
            <h1 class="font-poppins text-4xl md:text-6xl font-bold leading-tight mb-6">
                <span class="text-white">Formulir</span>
                <span class="bg-gradient-to-r from-yellow-400 to-orange-400 bg-clip-text text-transparent drop-shadow-lg"> Peminjaman Alat</span>
            </h1>
            <p class="text-xl md:text-2xl text-blue-100 max-w-4xl mx-auto leading-relaxed">
                Laboratorium Fisika Material dan Energi Departemen Fisika Universitas Syiah Kuala
            </p>
        </div>
    </div>
</section>

<!-- Loan Form Section -->
<section class="py-16 bg-gradient-to-b from-gray-50 to-white">
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
        <!-- Form Header -->
        <div class="text-center mb-12 scroll-animate" data-animation="fade-down">
            <div class="inline-flex items-center px-6 py-3 bg-blue-50 border border-blue-200 rounded-full text-blue-700 text-sm font-semibold mb-6 shadow-sm">
                <i class="fas fa-file-alt mr-2"></i>
                Surat Izin Pemakaian Alat
            </div>
            <h2 class="font-poppins text-3xl md:text-5xl font-bold text-gray-900 mb-6">
                Formulir <span class="bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent">Peminjaman</span>
            </h2>
            <p class="text-gray-600 text-lg max-w-3xl mx-auto leading-relaxed">
                Silakan pilih kategori peminjam dan lengkapi formulir sesuai dengan ketentuan yang berlaku.
            </p>
        </div>

        <!-- User Type Selection -->
        <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100 mb-8">
            <h3 class="text-xl font-bold text-gray-900 mb-6">Kategori Peminjam</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <button type="button" class="user-type-btn p-6 border-2 border-gray-200 rounded-xl text-left hover:border-blue-300 hover:bg-blue-50 transition-all duration-300" data-type="dosen">
                    <div class="flex items-center mb-3">
                        <i class="fas fa-user-tie text-2xl text-blue-600 mr-3"></i>
                        <h4 class="font-semibold text-gray-900">Dosen</h4>
                    </div>
                    <p class="text-sm text-gray-600">Dosen USK yang akan menggunakan sarana laboratorium untuk penelitian</p>
                </button>
                
                <button type="button" class="user-type-btn p-6 border-2 border-gray-200 rounded-xl text-left hover:border-blue-300 hover:bg-blue-50 transition-all duration-300" data-type="mahasiswa">
                    <div class="flex items-center mb-3">
                        <i class="fas fa-user-graduate text-2xl text-green-600 mr-3"></i>
                        <h4 class="font-semibold text-gray-900">Mahasiswa</h4>
                    </div>
                    <p class="text-sm text-gray-600">Mahasiswa yang akan menggunakan sarana laboratorium untuk penelitian</p>
                </button>
                
                <button type="button" class="user-type-btn p-6 border-2 border-gray-200 rounded-xl text-left hover:border-blue-300 hover:bg-blue-50 transition-all duration-300" data-type="pihak-luar">
                    <div class="flex items-center mb-3">
                        <i class="fas fa-building text-2xl text-purple-600 mr-3"></i>
                        <h4 class="font-semibold text-gray-900">Pihak Luar USK</h4>
                    </div>
                    <p class="text-sm text-gray-600">Pihak luar USK yang ingin menggunakan peralatan laboratorium</p>
                </button>
            </div>
        </div>

        <!-- Loan Form -->
        <form id="loanForm" method="POST" action="{{ route('equipment.loan.request') }}" class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
            @csrf
            <input type="hidden" name="user_type" id="userTypeInput">
            <input type="hidden" name="alat" id="alatInput">

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
                    <div class="mt-6 p-4 bg-blue-50 rounded-xl border border-blue-200">
                        <h4 class="font-semibold text-blue-900 mb-4">Informasi Dosen Pembimbing</h4>
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
                            <label class="block text-sm font-semibold text-gray-700 mb-2">No HP *</label>
                            <input type="text" name="no_hp_pihak_luar" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Email *</label>
                            <input type="email" name="email_pihak_luar" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Jabatan *</label>
                            <input type="text" name="jabatan" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
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

            <!-- Equipment Selection -->
            <div class="mb-8">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Peralatan yang Akan Digunakan</h3>
                <div class="bg-gray-50 rounded-xl p-6">
                    <div class="mb-4">
                        <button type="button" id="selectEquipmentBtn" class="bg-blue-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-blue-700 transition-colors">
                            <i class="fas fa-plus mr-2"></i>Pilih Peralatan
                        </button>
                    </div>
                    <div id="selectedEquipmentList" class="space-y-3">
                        <!-- Selected equipment will be displayed here -->
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
                    <i class="fas fa-paper-plane mr-2"></i>Kirim Permohonan
                </button>
            </div>
        </form>
    </div>
</section>

<!-- Equipment Selection Modal -->
<div id="equipmentModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black/40 flex items-center justify-center">
    <div class="bg-white rounded-2xl shadow-xl max-w-4xl w-full m-4 max-h-[90vh] overflow-y-auto">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold text-gray-900">Pilih Peralatan</h2>
                <button onclick="closeEquipmentModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>
        
        <div class="p-6">
            <!-- Search and Filter -->
            <div class="mb-6">
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <input type="text" id="equipmentSearch" placeholder="Cari peralatan..." class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <select id="equipmentCategory" class="px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Kategori</option>
                            <option value="elektronik">Elektronik</option>
                            <option value="mekanik">Mekanik</option>
                            <option value="optik">Optik</option>
                            <option value="kimia">Kimia</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Equipment Grid -->
            <div id="equipmentGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($equipments as $equipment)
                <div class="equipment-item border border-gray-200 rounded-xl p-4 hover:border-blue-300 hover:shadow-md transition-all cursor-pointer" data-id="{{ $equipment->id }}" data-name="{{ $equipment->nama }}" data-category="{{ $equipment->kategori ?? 'lainnya' }}">
                    <div class="flex items-center space-x-3">
                        <input type="checkbox" class="equipment-checkbox w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500" value="{{ $equipment->id }}">
                        <div class="flex-1">
                            <h4 class="font-semibold text-gray-900">{{ $equipment->nama }}</h4>
                            <p class="text-sm text-gray-600">{{ Str::limit($equipment->deskripsi, 60) }}</p>
                            <p class="text-sm text-blue-600">Stok: {{ $equipment->stok }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Modal Footer -->
            <div class="mt-6 flex justify-end space-x-4">
                <button onclick="closeEquipmentModal()" class="px-6 py-2 border border-gray-300 rounded-xl text-gray-700">Batal</button>
                <button onclick="confirmEquipmentSelection()" class="px-6 py-2 bg-blue-600 text-white rounded-xl font-semibold">Konfirmasi Pilihan</button>
            </div>
        </div>
    </div>
</div>

<style>
.user-type-btn.active {
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
    initEquipmentSelection();
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
    const userTypeBtns = document.querySelectorAll('.user-type-btn');
    const userTypeInput = document.getElementById('userTypeInput');
    const userForms = document.querySelectorAll('.user-form');

    userTypeBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const userType = this.dataset.type;
            
            // Update active button
            userTypeBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            // Update hidden input
            userTypeInput.value = userType;
            
            // Show/hide forms
            userForms.forEach(form => form.classList.add('hidden'));
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

function initEquipmentSelection() {
    const selectBtn = document.getElementById('selectEquipmentBtn');
    const modal = document.getElementById('equipmentModal');
    const searchInput = document.getElementById('equipmentSearch');
    const categorySelect = document.getElementById('equipmentCategory');
    
    selectBtn.addEventListener('click', function() {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    });
    
    // Search functionality
    searchInput.addEventListener('input', filterEquipment);
    categorySelect.addEventListener('change', filterEquipment);
}

function filterEquipment() {
    const searchTerm = document.getElementById('equipmentSearch').value.toLowerCase();
    const category = document.getElementById('equipmentCategory').value;
    const equipmentItems = document.querySelectorAll('.equipment-item');
    
    equipmentItems.forEach(item => {
        const name = item.dataset.name.toLowerCase();
        const itemCategory = item.dataset.category;
        
        const searchMatch = name.includes(searchTerm);
        const categoryMatch = !category || itemCategory === category;
        
        if (searchMatch && categoryMatch) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });
}

function closeEquipmentModal() {
    document.getElementById('equipmentModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

function confirmEquipmentSelection() {
    const selectedCheckboxes = document.querySelectorAll('.equipment-checkbox:checked');
    const selectedEquipmentList = document.getElementById('selectedEquipmentList');
    const alatInput = document.getElementById('alatInput');
    
    let html = '';
    let selectedEquipment = [];
    
    selectedCheckboxes.forEach(checkbox => {
        const item = checkbox.closest('.equipment-item');
        const id = checkbox.value;
        const name = item.dataset.name;
        
        html += `
            <div class="flex items-center justify-between p-3 bg-white rounded-lg border border-gray-200">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-tools text-blue-600"></i>
                    <span class="font-medium">${name}</span>
                </div>
                <div class="flex items-center space-x-2">
                    <label class="text-sm text-gray-600">Jumlah:</label>
                    <input type="number" min="1" value="1" class="w-16 px-2 py-1 border border-gray-200 rounded text-center quantity-input" data-id="${id}">
                </div>
            </div>
        `;
        
        selectedEquipment.push({
            id: id,
            jumlah: 1
        });
    });
    
    selectedEquipmentList.innerHTML = html;
    alatInput.value = JSON.stringify(selectedEquipment);
    
    // Add event listeners to quantity inputs
    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('change', updateEquipmentQuantity);
    });
    
    closeEquipmentModal();
}

function updateEquipmentQuantity() {
    const quantityInputs = document.querySelectorAll('.quantity-input');
    const alatInput = document.getElementById('alatInput');
    let selectedEquipment = [];
    
    quantityInputs.forEach(input => {
        selectedEquipment.push({
            id: input.dataset.id,
            jumlah: parseInt(input.value) || 1
        });
    });
    
    alatInput.value = JSON.stringify(selectedEquipment);
}

// Form validation
document.getElementById('loanForm').addEventListener('submit', function(e) {
    const userType = document.getElementById('userTypeInput').value;
    
    if (!userType) {
        e.preventDefault();
        alert('Silakan pilih kategori peminjam terlebih dahulu.');
        return;
    }
    
    // Additional validation based on user type
    if (userType === 'mahasiswa') {
        const pembimbing = document.querySelector('input[name="nama_pembimbing"]').value;
        if (!pembimbing) {
            e.preventDefault();
            alert('Nama dosen pembimbing harus diisi untuk mahasiswa.');
            return;
        }
    }
    
    const selectedEquipment = JSON.parse(document.getElementById('alatInput').value || '[]');
    if (selectedEquipment.length === 0) {
        e.preventDefault();
        alert('Silakan pilih minimal satu peralatan.');
        return;
    }
});
</script>
@endsection 