@extends('user.layouts.app')

@section('title', 'Formulir Pengajuan Pengujian - Laboratorium Fisika Material dan Energi')

@section('content')
<!-- Hero Section -->
<section class="relative min-h-[50vh] flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('/images/hero.jpg') }}" alt="Formulir Pengajuan Pengujian" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-br from-orange-700/90 via-orange-800/80 to-red-900/70"></div>
    </div>
    <div class="relative z-20 mx-6 px-4 sm:px-6 lg:px-8 text-center max-w-6xl">
        <div class="scroll-animate mb-8 opacity-0" data-animation="fade-down">
            <nav class="flex justify-center" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3 bg-white/10 backdrop-blur-sm rounded-full px-6 py-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}" class="text-orange-200 hover:text-white transition-colors duration-200 flex items-center">
                            <i class="fas fa-home mr-2"></i>Beranda
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-orange-300 mx-3"></i>
                            <span class="text-orange-200">Pengujian</span>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-orange-300 mx-3"></i>
                            <span class="text-white font-medium">Formulir</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
        <div class="scroll-animate mb-8 opacity-0" data-animation="fade-up" data-delay="200">
            <h1 class="font-poppins text-4xl md:text-6xl font-bold leading-tight mb-6">
                <span class="text-white">Formulir</span>
                <span class="bg-gradient-to-r from-yellow-400 to-orange-400 bg-clip-text text-transparent drop-shadow-lg"> Pengajuan Pengujian</span>
            </h1>
            <p class="text-xl md:text-2xl text-orange-100 max-w-4xl mx-auto leading-relaxed">
                Langkah 2: Lengkapi data pengajuan pengujian
            </p>
        </div>
    </div>
</section>

<!-- Form Section -->
<section class="py-16 bg-gradient-to-b from-gray-50 to-white">
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
        <!-- Selected Services Summary -->
        <div class="bg-orange-50 border border-orange-200 rounded-xl p-6 mb-8">
            <h3 class="text-lg font-semibold text-orange-900 mb-4">Layanan yang Dipilih</h3>
            <div id="selectedServicesDisplay" class="space-y-2"></div>
            <div class="mt-4 pt-4 border-t border-orange-200">
                <a href="{{ route('testing.services') }}" class="text-orange-600 hover:text-orange-800 text-sm font-medium">
                    <i class="fas fa-edit mr-1"></i>Ubah Pilihan Layanan
                </a>
            </div>
        </div>

        <!-- Testing Form -->
        <form id="testingForm" method="POST" action="{{ route('testing.submit') }}" class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="selected_services" id="selectedServicesInput">

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
                <h3 class="text-xl font-bold text-gray-900 mb-6">Kategori Pengaju</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <label class="user-type-option cursor-pointer">
                        <input type="radio" name="user_type" value="dosen" class="sr-only" {{ old('user_type') == 'dosen' ? 'checked' : '' }}>
                        <div class="p-6 border-2 border-gray-200 rounded-xl text-left hover:border-orange-300 hover:bg-orange-50 transition-all duration-300">
                            <div class="flex items-center mb-3">
                                <i class="fas fa-user-tie text-2xl text-orange-600 mr-3"></i>
                                <h4 class="font-semibold text-gray-900">Dosen</h4>
                            </div>
                            <p class="text-sm text-gray-600">Dosen USK yang akan menggunakan layanan pengujian untuk penelitian</p>
                        </div>
                    </label>
                    <label class="user-type-option cursor-pointer">
                        <input type="radio" name="user_type" value="mahasiswa" class="sr-only" {{ old('user_type') == 'mahasiswa' ? 'checked' : '' }}>
                        <div class="p-6 border-2 border-gray-200 rounded-xl text-left hover:border-orange-300 hover:bg-orange-50 transition-all duration-300">
                            <div class="flex items-center mb-3">
                                <i class="fas fa-user-graduate text-2xl text-orange-600 mr-3"></i>
                                <h4 class="font-semibold text-gray-900">Mahasiswa</h4>
                            </div>
                            <p class="text-sm text-gray-600">Mahasiswa USK yang akan menggunakan layanan pengujian untuk tugas akhir atau penelitian</p>
                        </div>
                    </label>
                    <label class="user-type-option cursor-pointer">
                        <input type="radio" name="user_type" value="pihak-luar" class="sr-only" {{ old('user_type') == 'pihak-luar' ? 'checked' : '' }}>
                        <div class="p-6 border-2 border-gray-200 rounded-xl text-left hover:border-orange-300 hover:bg-orange-50 transition-all duration-300">
                            <div class="flex items-center mb-3">
                                <i class="fas fa-building text-2xl text-orange-600 mr-3"></i>
                                <h4 class="font-semibold text-gray-900">Pihak Luar</h4>
                            </div>
                            <p class="text-sm text-gray-600">Pihak luar USK yang memerlukan layanan pengujian laboratorium</p>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Dynamic Forms for each user type -->
            <!-- Dosen Form -->
            <div id="dosenForm" class="user-form hidden">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Informasi Dosen</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <label for="nama_dosen" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                        <input type="text" id="nama_dosen" name="nama_dosen" value="{{ old('nama_dosen') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors">
                    </div>
                    <div>
                        <label for="nip_dosen" class="block text-sm font-medium text-gray-700 mb-2">NIP</label>
                        <input type="text" id="nip_dosen" name="nip_dosen" value="{{ old('nip_dosen') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors">
                    </div>
                    <div>
                        <label for="no_hp_dosen" class="block text-sm font-medium text-gray-700 mb-2">No. HP</label>
                        <input type="tel" id="no_hp_dosen" name="no_hp_dosen" value="{{ old('no_hp_dosen') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors">
                    </div>
                    <div>
                        <label for="email_dosen" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" id="email_dosen" name="email_dosen" value="{{ old('email_dosen') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors">
                    </div>
                </div>
            </div>

            <!-- Mahasiswa Form -->
            <div id="mahasiswaForm" class="user-form hidden">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Informasi Mahasiswa</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="nama_mahasiswa" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                        <input type="text" id="nama_mahasiswa" name="nama_mahasiswa" value="{{ old('nama_mahasiswa') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors">
                    </div>
                    <div>
                        <label for="nim_mahasiswa" class="block text-sm font-medium text-gray-700 mb-2">NIM</label>
                        <input type="text" id="nim_mahasiswa" name="nim_mahasiswa" value="{{ old('nim_mahasiswa') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors">
                    </div>
                    <div>
                        <label for="no_hp_mahasiswa" class="block text-sm font-medium text-gray-700 mb-2">No. HP</label>
                        <input type="tel" id="no_hp_mahasiswa" name="no_hp_mahasiswa" value="{{ old('no_hp_mahasiswa') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors">
                    </div>
                    <div>
                        <label for="email_mahasiswa" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" id="email_mahasiswa" name="email_mahasiswa" value="{{ old('email_mahasiswa') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors">
                    </div>
                </div>
                
                <h4 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pembimbing</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <label for="nama_pembimbing" class="block text-sm font-medium text-gray-700 mb-2">Nama Pembimbing</label>
                        <input type="text" id="nama_pembimbing" name="nama_pembimbing" value="{{ old('nama_pembimbing') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors">
                    </div>
                    <div>
                        <label for="nip_pembimbing" class="block text-sm font-medium text-gray-700 mb-2">NIP Pembimbing</label>
                        <input type="text" id="nip_pembimbing" name="nip_pembimbing" value="{{ old('nip_pembimbing') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors">
                    </div>
                </div>
            </div>

            <!-- Pihak Luar Form -->
            <div id="pihakLuarForm" class="user-form hidden">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Informasi Pihak Luar</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <label for="nama_pihak_luar" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                        <input type="text" id="nama_pihak_luar" name="nama_pihak_luar" value="{{ old('nama_pihak_luar') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors">
                    </div>
                    <div>
                        <label for="nip_pihak_luar" class="block text-sm font-medium text-gray-700 mb-2">NIK/Nomor Identitas</label>
                        <input type="text" id="nip_pihak_luar" name="nip_pihak_luar" value="{{ old('nip_pihak_luar') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors">
                    </div>
                    <div>
                        <label for="instansi" class="block text-sm font-medium text-gray-700 mb-2">Instansi/Perusahaan</label>
                        <input type="text" id="instansi" name="instansi" value="{{ old('instansi') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors">
                    </div>
                    <div>
                        <label for="jabatan" class="block text-sm font-medium text-gray-700 mb-2">Jabatan</label>
                        <input type="text" id="jabatan" name="jabatan" value="{{ old('jabatan') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors">
                    </div>
                    <div>
                        <label for="no_hp_pihak_luar" class="block text-sm font-medium text-gray-700 mb-2">No. HP</label>
                        <input type="tel" id="no_hp_pihak_luar" name="no_hp_pihak_luar" value="{{ old('no_hp_pihak_luar') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors">
                    </div>
                    <div>
                        <label for="email_pihak_luar" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" id="email_pihak_luar" name="email_pihak_luar" value="{{ old('email_pihak_luar') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors">
                    </div>
                </div>
            </div>

            <!-- Common Fields -->
            <div class="space-y-6">
                <!-- Research Information -->
                <div>
                    <label for="judul_penelitian" class="block text-sm font-medium text-gray-700 mb-2">Judul Penelitian <span class="text-red-500">*</span></label>
                    <input type="text" id="judul_penelitian" name="judul_penelitian" value="{{ old('judul_penelitian') }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors">
                </div>

                <div>
                    <label for="deskripsi_penelitian" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Penelitian</label>
                    <textarea id="deskripsi_penelitian" name="deskripsi_penelitian" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors">{{ old('deskripsi_penelitian') }}</textarea>
                </div>

                <!-- Sample Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="tanggal_penyerahan" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Penyerahan Sampel <span class="text-red-500">*</span></label>
                        <input type="date" id="tanggal_penyerahan" name="tanggal_penyerahan" value="{{ old('tanggal_penyerahan') }}" required min="{{ date('Y-m-d', strtotime('+1 day')) }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors">
                    </div>
                    <div>
                        <label for="jumlah_sampel" class="block text-sm font-medium text-gray-700 mb-2">Jumlah Sampel <span class="text-red-500">*</span></label>
                        <input type="number" id="jumlah_sampel" name="jumlah_sampel" value="{{ old('jumlah_sampel') }}" required min="1" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors">
                    </div>
                </div>

                <div>
                    <label for="deskripsi_sampel" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Sampel <span class="text-red-500">*</span></label>
                    <textarea id="deskripsi_sampel" name="deskripsi_sampel" rows="4" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors">{{ old('deskripsi_sampel') }}</textarea>
                </div>

                <div>
                    <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">Alamat Lengkap</label>
                    <textarea id="alamat" name="alamat" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors">{{ old('alamat') }}</textarea>
                </div>

                <!-- File Upload -->
                <div>
                    <label for="file_pendukung" class="block text-sm font-medium text-gray-700 mb-2">File Pendukung</label>
                    <input type="file" id="file_pendukung" name="file_pendukung" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors">
                    <p class="text-sm text-gray-500 mt-1">Format: PDF, DOC, DOCX, JPG, PNG (Maks. 5MB)</p>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="mt-8 pt-6 border-t border-gray-200">
                <button type="submit" class="w-full bg-gradient-to-r from-orange-600 to-red-600 text-white py-4 px-6 rounded-lg font-semibold text-lg hover:from-orange-700 hover:to-red-700 focus:ring-4 focus:ring-orange-200 transition-all duration-300 shadow-lg">
                    <i class="fas fa-paper-plane mr-2"></i>
                    Kirim Pengajuan Pengujian
                </button>
            </div>
        </form>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Load selected services from session storage
    const selectedServices = JSON.parse(sessionStorage.getItem('selectedServices') || '[]');
    
    // Display selected services
    displaySelectedServices(selectedServices);
    
    // Set hidden input value
    document.getElementById('selectedServicesInput').value = JSON.stringify(selectedServices);
    
    // Handle user type selection
    const userTypeInputs = document.querySelectorAll('input[name="user_type"]');
    const userForms = document.querySelectorAll('.user-form');
    
    userTypeInputs.forEach(input => {
        input.addEventListener('change', function() {
            // Hide all forms
            userForms.forEach(form => {
                form.classList.add('hidden');
            });
            
            // Show selected form
            const selectedForm = document.getElementById(this.value + 'Form');
            if (selectedForm) {
                selectedForm.classList.remove('hidden');
            }
            
            // Update UI
            updateUserTypeUI();
        });
    });
    
    // Initialize user type UI
    updateUserTypeUI();
    
    // Show form for initially selected user type
    const checkedInput = document.querySelector('input[name="user_type"]:checked');
    if (checkedInput) {
        const selectedForm = document.getElementById(checkedInput.value + 'Form');
        if (selectedForm) {
            selectedForm.classList.remove('hidden');
        }
    }

    function displaySelectedServices(services) {
        const container = document.getElementById('selectedServicesDisplay');
        
        if (services.length === 0) {
            container.innerHTML = '<p class="text-orange-700 italic">Belum ada layanan yang dipilih. <a href="{{ route("testing.services") }}" class="text-orange-600 hover:text-orange-800 font-medium">Pilih layanan</a></p>';
            return;
        }
        
        container.innerHTML = services.map(service => `
            <div class="flex items-center justify-between bg-white rounded-lg p-3 border border-orange-100">
                <div class="flex items-center">
                    <i class="fas fa-flask text-orange-600 mr-3"></i>
                    <div>
                        <h4 class="font-medium text-gray-900">${service.name}</h4>
                        <p class="text-sm text-gray-600">${service.price || 'Gratis'}</p>
                    </div>
                </div>
            </div>
        `).join('');
    }
    
    function updateUserTypeUI() {
        const options = document.querySelectorAll('.user-type-option');
        options.forEach(option => {
            const input = option.querySelector('input[type="radio"]');
            const div = option.querySelector('div');
            
            if (input.checked) {
                div.classList.add('border-orange-500', 'bg-orange-50');
                div.classList.remove('border-gray-200');
            } else {
                div.classList.remove('border-orange-500', 'bg-orange-50');
                div.classList.add('border-gray-200');
            }
        });
    }
});
</script>
@endsection
