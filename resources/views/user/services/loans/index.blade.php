@extends('user.layouts.app')

@section('title', 'Peminjaman Alat - Laboratorium Fisika Material dan Energi')

@section('content')
<!-- Hero Section -->
<section class="relative min-h-[60vh] flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('/images/hero.jpg') }}" alt="Peminjaman Alat" class="w-full h-full object-cover">
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
                            <span class="text-white font-medium">Peminjaman Alat</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>

        <div class="scroll-animate mb-8 opacity-0" data-animation="fade-up" data-delay="200">
            <h1 class="font-poppins text-4xl md:text-6xl font-bold leading-tight mb-6">
                <span class="text-white">Peminjaman</span>
                <span class="bg-gradient-to-r from-yellow-400 to-orange-400 bg-clip-text text-transparent drop-shadow-lg"> Alat</span>
            </h1>
            <p class="text-xl md:text-2xl text-blue-100 max-w-4xl mx-auto leading-relaxed">
                Laboratorium Fisika Material dan Energi Departemen Fisika Universitas Syiah Kuala
            </p>
        </div>
    </div>
</section>

<!-- Equipment Selection Section -->
<section class="py-16 bg-gradient-to-b from-gray-50 to-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-12 scroll-animate" data-animation="fade-down">
            <div class="inline-flex items-center px-6 py-3 bg-blue-50 border border-blue-200 rounded-full text-blue-700 text-sm font-semibold mb-6 shadow-sm">
                <i class="fas fa-tools mr-2"></i>
                Langkah 1: Pilih Alat
            </div>
            <h2 class="font-poppins text-3xl md:text-5xl font-bold text-gray-900 mb-6">
                Pilih <span class="bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent">Peralatan</span>
            </h2>
            <p class="text-gray-600 text-lg max-w-3xl mx-auto leading-relaxed">
                Pilih alat yang ingin Anda pinjam. Anda dapat memilih lebih dari satu alat.
            </p>
        </div>

        <!-- Filter Section -->
        <div class="mb-8 scroll-animate" data-animation="fade-up" data-delay="200">
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                <div class="flex flex-col lg:flex-row gap-6 items-center">
                    <!-- Search -->
                    <div class="flex-1">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Cari Alat</label>
                        <div class="relative">
                            <input type="text"
                                   id="search-input"
                                   placeholder="Masukkan nama alat..."
                                   class="w-full px-4 py-3 pl-12 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                            <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                    </div>

                    <!-- Category Filter -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Kategori</label>
                        <select id="category-filter" class="px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Kategori</option>
                            <option value="elektronik">Elektronik</option>
                            <option value="mekanik">Mekanik</option>
                            <option value="optik">Optik</option>
                            <option value="kimia">Kimia</option>
                        </select>
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Status</label>
                        <select id="status-filter" class="px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="all">Semua Status</option>
                            <option value="available">Tersedia</option>
                            <option value="maintenance">Maintenance</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Selected Equipment Summary -->
        <div id="selectedSummary" class="mb-8 bg-blue-50 border border-blue-200 rounded-xl p-6 hidden">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-blue-900 mb-2">Alat yang Dipilih</h3>
                    <div id="selectedEquipmentList" class="text-sm text-blue-700"></div>
                </div>
                <button onclick="clearSelection()" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                    <i class="fas fa-times mr-1"></i>Hapus Semua
                </button>
            </div>
        </div>

        <!-- Equipment Grid -->
        <div id="equipment-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($equipments as $index => $equipment)
            <div class="equipment-card bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 scroll-animate"
                 data-animation="fade-up"
                 data-delay="{{ $index * 100 }}"
                 data-name="{{ strtolower($equipment->nama) }}"
                 data-category="{{ strtolower($equipment->kategori ?? 'lainnya') }}"
                 data-status="{{ strtolower($equipment->kondisi ?? 'available') }}">
                
                <!-- Selection Checkbox -->
                <div class="absolute top-4 left-4 z-10">
                    <input type="checkbox" 
                           class="equipment-checkbox w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500" 
                           value="{{ $equipment->id }}" 
                           data-nama="{{ $equipment->nama }}"
                           data-stok="{{ $equipment->stok }}">
                </div>

                <!-- Image -->
                <div class="relative overflow-hidden h-48 bg-gradient-to-br from-gray-100 to-gray-200">
                    @if($equipment->gambar->first())
                        <img src="{{ asset($equipment->gambar->first()->url) }}"
                             alt="{{ $equipment->nama }}"
                             class="w-full h-full object-cover transform hover:scale-110 transition-transform duration-700">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gray-200 text-gray-400">
                            <i class="fas fa-tools text-4xl"></i>
                        </div>
                    @endif
                    
                    <!-- Status Badge -->
                    <div class="absolute top-4 right-4">
                        <span class="px-2 py-1 text-xs font-medium rounded-full
                            @if($equipment->kondisi === 'BAIK') bg-green-100 text-green-800
                            @elseif($equipment->kondisi === 'RUSAK') bg-red-100 text-red-800
                            @else bg-yellow-100 text-yellow-800
                            @endif">
                            {{ $equipment->kondisi ?? 'Tersedia' }}
                        </span>
                    </div>
                </div>

                <!-- Content -->
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-2 leading-tight">{{ $equipment->nama }}</h3>
                    <p class="text-gray-600 text-sm leading-relaxed mb-4 line-clamp-3">
                        {{ $equipment->deskripsi }}
                    </p>
                    <div class="mb-2 text-sm text-gray-700">Stok: <span class="font-semibold">{{ $equipment->stok }}</span></div>
                    <div class="mb-2 text-xs">
                        Status: <span class="font-semibold {{ $equipment->stok > 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $equipment->stok > 0 ? 'Tersedia' : 'Tidak Tersedia' }}
                        </span>
                    </div>
                    {{-- Jika ingin tampilkan stok rusak: --}}
                    {{-- <div class="mb-2 text-xs text-red-600">Rusak: <span class="font-semibold">{{ $equipment->stok_rusak ?? 0 }}</span></div> --}}
                    <div class="mb-4 text-sm text-gray-700">Harga: <span class="font-semibold">{{ $equipment->harga ? 'Rp ' . number_format($equipment->harga,0,',','.') : '-' }}</span></div>
                    
                    <!-- Quantity Input (hidden by default) -->
                    <div class="equipment-quantity hidden mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Jumlah</label>
                        <input type="number" 
                               min="1" 
                               max="{{ $equipment->stok }}" 
                               value="1" 
                               class="quantity-input w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               data-id="{{ $equipment->id }}">
                    </div>

                    <button type="button" class="lihat-detail-btn w-full bg-blue-500 text-white px-4 py-2 rounded-xl font-semibold hover:bg-blue-600 transition-colors duration-200 flex items-center justify-center mt-2" data-id="{{ $equipment->id }}">
                        <i class="fas fa-eye mr-2"></i> Lihat Detail
                    </button>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Next Step Button -->
        <div class="mt-12 flex justify-center">
            <button id="nextStepBtn" class="bg-blue-600 text-white px-8 py-4 rounded-xl font-bold text-lg hover:bg-blue-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                <i class="fas fa-arrow-right mr-2"></i>Lanjut ke Formulir
            </button>
        </div>

        <!-- No Results Message -->
        <div id="no-results" class="hidden text-center py-16">
            <div class="max-w-md mx-auto">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-search text-gray-400 text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Tidak ada alat ditemukan</h3>
                <p class="text-gray-600">Coba ubah filter atau kata kunci pencarian Anda.</p>
            </div>
        </div>
    </div>
</section>

<style>
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
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

.equipment-card.selected {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    initScrollAnimations();
    initFilters();
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

function initFilters() {
    const searchInput = document.getElementById('search-input');
    const categoryFilter = document.getElementById('category-filter');
    const statusFilter = document.getElementById('status-filter');

    searchInput.addEventListener('input', filterEquipment);
    categoryFilter.addEventListener('change', filterEquipment);
    statusFilter.addEventListener('change', filterEquipment);
}

function filterEquipment() {
    const searchTerm = document.getElementById('search-input').value.toLowerCase();
    const category = document.getElementById('category-filter').value;
    const status = document.getElementById('status-filter').value;

    const equipmentCards = document.querySelectorAll('.equipment-card');
    let visibleCount = 0;

    equipmentCards.forEach(card => {
        const name = card.dataset.name;
        const cardCategory = card.dataset.category;
        const cardStatus = card.dataset.status;

        const searchMatch = name.includes(searchTerm);
        const categoryMatch = !category || cardCategory === category;
        const statusMatch = status === 'all' || cardStatus === status;

        if (searchMatch && categoryMatch && statusMatch) {
            card.style.display = 'block';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });

    // Show/hide no results message
    const noResults = document.getElementById('no-results');
    if (visibleCount === 0) {
        noResults.classList.remove('hidden');
    } else {
        noResults.classList.add('hidden');
    }
}

function initEquipmentSelection() {
    const checkboxes = document.querySelectorAll('.equipment-checkbox');
    const nextStepBtn = document.getElementById('nextStepBtn');

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const card = this.closest('.equipment-card');
            const quantityDiv = card.querySelector('.equipment-quantity');
            
            if (this.checked) {
                card.classList.add('selected');
                quantityDiv.classList.remove('hidden');
            } else {
                card.classList.remove('selected');
                quantityDiv.classList.add('hidden');
            }
            
            updateSelectedSummary();
            updateNextStepButton();
        });
    });

    // Quantity input change
    document.addEventListener('input', function(e) {
        if (e.target.classList.contains('quantity-input')) {
            updateSelectedSummary();
        }
    });
}

function updateSelectedSummary() {
    const selectedCheckboxes = document.querySelectorAll('.equipment-checkbox:checked');
    const summaryDiv = document.getElementById('selectedSummary');
    const listDiv = document.getElementById('selectedEquipmentList');

    if (selectedCheckboxes.length === 0) {
        summaryDiv.classList.add('hidden');
        return;
    }

    let html = '';
    selectedCheckboxes.forEach(checkbox => {
        const quantityInput = document.querySelector(`.quantity-input[data-id="${checkbox.value}"]`);
        const quantity = quantityInput ? quantityInput.value : 1;
        html += `<div class="mb-1">• ${checkbox.dataset.nama} (${quantity} unit)</div>`;
    });

    listDiv.innerHTML = html;
    summaryDiv.classList.remove('hidden');
}

function updateNextStepButton() {
    const selectedCheckboxes = document.querySelectorAll('.equipment-checkbox:checked');
    const nextStepBtn = document.getElementById('nextStepBtn');

    if (selectedCheckboxes.length > 0) {
        nextStepBtn.disabled = false;
        nextStepBtn.onclick = proceedToForm;
    } else {
        nextStepBtn.disabled = true;
        nextStepBtn.onclick = null;
    }
}

function clearSelection() {
    const checkboxes = document.querySelectorAll('.equipment-checkbox:checked');
    checkboxes.forEach(checkbox => {
        checkbox.checked = false;
        const card = checkbox.closest('.equipment-card');
        card.classList.remove('selected');
        const quantityDiv = card.querySelector('.equipment-quantity');
        quantityDiv.classList.add('hidden');
    });
    
    updateSelectedSummary();
    updateNextStepButton();
}

function proceedToForm() {
    const selectedEquipment = [];
    const selectedCheckboxes = document.querySelectorAll('.equipment-checkbox:checked');
    
    selectedCheckboxes.forEach(checkbox => {
        const quantityInput = document.querySelector(`.quantity-input[data-id="${checkbox.value}"]`);
        const quantity = quantityInput ? parseInt(quantityInput.value) : 1;
        
        selectedEquipment.push({
            id: checkbox.value,
            nama: checkbox.dataset.nama,
            jumlah: quantity
        });
    });

    // Store selected equipment in session storage
    sessionStorage.setItem('selectedEquipment', JSON.stringify(selectedEquipment));
    
    // Redirect to form page
    window.location.href = '{{ route("equipment.loan.form") }}';
}

// Lihat Detail functionality
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('lihat-detail-btn')) {
        const id = e.target.dataset.id;
        window.location.href = `/services/equipment-loan/${id}`;
    }
});
</script>
@endsection 