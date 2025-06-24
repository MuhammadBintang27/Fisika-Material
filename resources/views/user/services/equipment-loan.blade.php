{{-- resources/views/services/equipment-loan.blade.php --}}
@extends('user.layouts.app')

@section('title', 'Layanan Peminjaman Alat - Laboratorium Fisika Dasar')

@section('content')
<!-- Hero Section -->
<section class="relative min-h-[70vh] flex items-center justify-center overflow-hidden">
    <!-- Background Image with Gradient -->
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('/images/hero.jpg') }}"
             alt="Layanan Peminjaman Alat"
             class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-700/90 via-blue-800/80 to-blue-900/70"></div>
    </div>

    <!-- Content -->
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

        <!-- Main Title -->
        <div class="scroll-animate mb-8 opacity-0" data-animation="fade-up" data-delay="200">
            <h1 class="font-poppins text-5xl md:text-7xl font-bold leading-tight mb-6">
                <span class="text-white">Layanan</span>
                <span class="bg-gradient-to-r from-yellow-400 to-orange-400 bg-clip-text text-transparent drop-shadow-lg"> Peminjaman</span>
            </h1>
            <p class="text-xl md:text-2xl text-blue-100 max-w-4xl mx-auto leading-relaxed">
                Akses mudah ke peralatan laboratorium berkualitas tinggi untuk mendukung penelitian dan praktikum Anda
            </p>
        </div>

       
    </div>
</section>

<!-- Equipment Section -->
<section class="py-24 bg-gradient-to-b from-gray-50 to-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-16 scroll-animate" data-animation="fade-down">
            <div class="inline-flex items-center px-6 py-3 bg-blue-50 border border-blue-200 rounded-full text-blue-700 text-sm font-semibold mb-6 shadow-sm">
                <i class="fas fa-tools mr-2"></i>
                Katalog Peralatan
            </div>
            <h2 class="font-poppins text-4xl md:text-6xl font-bold text-gray-900 mb-6">
                Peralatan <span class="bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent">Laboratorium</span>
            </h2>
            <p class="text-gray-600 text-lg md:text-xl max-w-4xl mx-auto leading-relaxed">
                Jelajahi koleksi lengkap peralatan laboratorium modern yang tersedia untuk mendukung kegiatan akademik dan penelitian Anda.
            </p>
        </div>

        <!-- Filter Section -->
        <div class="mb-12 scroll-animate" data-animation="fade-up" data-delay="200">
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                <div class="flex flex-col lg:flex-row gap-6 items-center">
                    <!-- Category Filter -->
                    <div class="flex-1">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Filter Kategori</label>
                        <div class="flex flex-wrap gap-2" id="category-filter">
                            @foreach($categories as $key => $category)
                            <button class="category-btn px-4 py-2 rounded-full border transition-all duration-300
                                {{ $key === 'all' ? 'bg-blue-500 text-white border-blue-500' : 'bg-gray-50 text-gray-700 border-gray-200 hover:bg-blue-50 hover:border-blue-300 hover:text-blue-600' }}"
                                data-category="{{ $key }}">
                                {{ $category }}
                            </button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Search -->
                    <div class="flex-1 lg:max-w-md">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Cari Alat</label>
                        <div class="relative">
                            <input type="text"
                                   id="search-input"
                                   placeholder="Masukkan nama alat..."
                                   class="w-full px-4 py-3 pl-12 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                            <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
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

        <!-- Multi-select toggle -->
        <div class="mb-4 flex items-center gap-2">
            <input type="checkbox" id="multiSelectToggle" class="h-4 w-4 text-blue-600 border-gray-300 rounded">
            <label for="multiSelectToggle" class="text-sm text-gray-700 select-none">Pilih lebih dari satu alat</label>
        </div>

        <!-- Equipment Grid -->
        <div id="equipment-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($equipments as $index => $equipment)
            <div class="equipment-card bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 scroll-animate"
                 data-animation="fade-up"
                 data-delay="{{ $index * 100 }}">
                <div class="absolute top-4 left-4 z-10">
                    <input type="radio" name="alatRadio" class="alat-radio w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500" value="{{ $equipment->id }}" data-nama="{{ $equipment->nama }}">
                    <input type="checkbox" class="alat-checkbox w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500 hidden" value="{{ $equipment->id }}" data-nama="{{ $equipment->nama }}">
                </div>
                <!-- Image -->
                <div class="relative overflow-hidden h-48 bg-gradient-to-br from-gray-100 to-gray-200">
                    @if($equipment->gambar->first())
                        <img src="{{ asset($equipment->gambar->first()->url) }}"
                             alt="{{ $equipment->nama }}"
                             class="w-full h-full object-cover transform hover:scale-110 transition-transform duration-700">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gray-200 text-gray-400">No Image</div>
                    @endif
                </div>
                <!-- Content -->
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-2 leading-tight">{{ $equipment->nama }}</h3>
                    <p class="text-gray-600 text-sm leading-relaxed mb-4 line-clamp-3">
                        {{ $equipment->deskripsi }}
                    </p>
                    <div class="mb-2 text-sm text-gray-700">Stok: <span class="font-semibold">{{ $equipment->stok }}</span></div>
                    <div class="mb-4 text-sm text-gray-700">Harga: <span class="font-semibold">{{ $equipment->harga ? 'Rp ' . number_format($equipment->harga,0,',','.') : '-' }}</span></div>
                    <button type="button" class="lihat-detail-btn w-full bg-blue-500 text-white px-4 py-2 rounded-xl font-semibold hover:bg-blue-600 transition-colors duration-200 flex items-center justify-center mt-2" data-id="{{ $equipment->id }}">
                        <i class="fas fa-eye mr-2"></i> Lihat Detail
                    </button>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Button to open loan modal -->
        <div class="mt-8 flex justify-center">
            <button id="openLoanModal" class="bg-blue-600 text-white px-6 py-3 rounded-xl font-bold" disabled>
                Ajukan Peminjaman
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

<!-- Loan Modal -->
<div id="loanModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black/40 flex items-center justify-center">
    <div class="bg-white rounded-2xl shadow-xl max-w-lg w-full p-8 relative">
        <button onclick="closeLoanModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600"><i class="fas fa-times text-xl"></i></button>
        <h2 class="text-2xl font-bold mb-6 text-center">Formulir Peminjaman Alat</h2>
        <form id="loanForm" method="POST" action="#">
            @csrf
            <input type="hidden" name="alat" id="alatInput">
            <div class="mb-4">
                <label class="block text-sm font-semibold mb-2">Nama Lengkap *</label>
                <input type="text" name="namaPeminjam" required class="w-full px-4 py-3 border border-gray-200 rounded-xl">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-semibold mb-2">No HP *</label>
                <input type="text" name="noHp" required class="w-full px-4 py-3 border border-gray-200 rounded-xl">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-semibold mb-2">Tujuan Peminjaman</label>
                <input type="text" name="tujuanPeminjaman" class="w-full px-4 py-3 border border-gray-200 rounded-xl">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-semibold mb-2">Tanggal Pinjam *</label>
                <input type="date" name="tanggal_pinjam" required class="w-full px-4 py-3 border border-gray-200 rounded-xl">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-semibold mb-2">Tanggal Kembali *</label>
                <input type="date" name="tanggal_pengembalian" required class="w-full px-4 py-3 border border-gray-200 rounded-xl">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-semibold mb-2">Alat yang Dipilih</label>
                <ul id="selectedAlatList" class="list-disc pl-5 text-sm text-gray-700"></ul>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-semibold mb-2">Rincian Peminjaman</label>
                <table class="w-full text-sm border">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="p-2">Alat</th>
                            <th class="p-2">Jumlah</th>
                            <th class="p-2">Harga</th>
                            <th class="p-2">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody id="alatRincianTable"></tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-right font-bold p-2">Total</td>
                            <td class="font-bold p-2" id="totalHargaCell">Rp 0</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="flex justify-end gap-4 mt-6">
                <button type="button" onclick="closeLoanModal()" class="px-6 py-2 border border-gray-300 rounded-xl text-gray-700">Batal</button>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-xl font-semibold">Kirim Permohonan</button>
            </div>
        </form>
    </div>
</div>

<!-- Confirmation Modal -->
<div id="confirmationModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black/40 flex items-center justify-center">
    <div class="bg-white rounded-2xl shadow-xl max-w-lg w-full p-8 relative">
        <h2 class="text-2xl font-bold mb-6 text-center">Rincian Peminjaman</h2>
        <div id="confirmationContent"></div>
        <form id="realSubmitForm" method="POST" action="{{ route('equipment.loan.request') }}" class="hidden">
            @csrf
            <input type="hidden" name="namaPeminjam">
            <input type="hidden" name="noHp">
            <input type="hidden" name="tujuanPeminjaman">
            <input type="hidden" name="tanggal_pinjam">
            <input type="hidden" name="tanggal_pengembalian">
            <input type="hidden" name="alat">
        </form>
        <div class="flex justify-end gap-4 mt-6">
            <button type="button" onclick="closeConfirmationModal()" class="px-6 py-2 border border-gray-300 rounded-xl text-gray-700">Batal</button>
            <button type="button" id="confirmAndSubmitBtn" class="px-6 py-2 bg-blue-600 text-white rounded-xl font-semibold">Konfirmasi & Kirim</button>
        </div>
    </div>
</div>

@if ($errors->any())
    <div class="fixed top-6 left-1/2 transform -translate-x-1/2 bg-red-500 text-white px-6 py-3 rounded-xl shadow-lg z-50 text-center text-lg font-semibold transition-opacity duration-500">
        <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    <script>
    setTimeout(() => {
        const alert = document.querySelector('.bg-red-500');
        if(alert) alert.style.opacity = 0;
    }, 5000);
    </script>
@endif
@if(!empty($success))
<div id="successAlert" class="fixed top-6 left-1/2 transform -translate-x-1/2 bg-green-500 text-white px-6 py-3 rounded-xl shadow-lg z-50 text-center text-lg font-semibold transition-opacity duration-500">
    {{ $success }}
</div>
<script>
setTimeout(() => {
    const alert = document.getElementById('successAlert');
    if(alert) alert.style.opacity = 0;
}, 4000);
</script>
@endif

<style>
/* Line clamp for text truncation */
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Scroll animations */
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

/* Enhanced gradient text */
.bg-clip-text {
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
}

/* Modal animations */
#loanModal.show {
    display: flex !important;
    animation: modalFadeIn 0.3s ease-out;
}

@keyframes modalFadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .scroll-animate[data-animation="fade-down"],
    .scroll-animate[data-animation="fade-up"] {
        transform: translateY(40px);
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Equipment data for JavaScript
    const equipments = @json($equipments);

    // Initialize scroll animations
    initScrollAnimations();

    // Initialize filters
    initFilters();

    // Set minimum date for date inputs (fix selector)
    const today = new Date().toISOString().split('T')[0];
    document.querySelector('input[name="tanggal_pinjam"]').setAttribute('min', today);
    document.querySelector('input[name="tanggal_pengembalian"]').setAttribute('min', today);

    // Update end date minimum when start date changes
    document.querySelector('input[name="tanggal_pinjam"]').addEventListener('change', function() {
        const startDate = this.value;
        document.querySelector('input[name="tanggal_pengembalian"]').setAttribute('min', startDate);
    });
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
    const categoryBtns = document.querySelectorAll('.category-btn');
    const searchInput = document.getElementById('search-input');
    const statusFilter = document.getElementById('status-filter');

    // Category filter
    categoryBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Update active button
            categoryBtns.forEach(b => {
                b.classList.remove('bg-blue-500', 'text-white', 'border-blue-500');
                b.classList.add('bg-gray-50', 'text-gray-700', 'border-gray-200');
            });
            this.classList.remove('bg-gray-50', 'text-gray-700', 'border-gray-200');
            this.classList.add('bg-blue-500', 'text-white', 'border-blue-500');

            filterEquipment();
        });
    });

    // Search filter
    searchInput.addEventListener('input', filterEquipment);

    // Status filter
    statusFilter.addEventListener('change', filterEquipment);
}

function filterEquipment() {
    const activeCategory = document.querySelector('.category-btn.bg-blue-500').dataset.category;
    const searchTerm = document.getElementById('search-input').value.toLowerCase();
    const statusFilter = document.getElementById('status-filter').value;

    const equipmentCards = document.querySelectorAll('.equipment-card');
    let visibleCount = 0;

    equipmentCards.forEach(card => {
        const category = card.dataset.category;
        const name = card.dataset.name;
        const status = card.dataset.status;

        const categoryMatch = activeCategory === 'all' || category === activeCategory;
        const searchMatch = name.includes(searchTerm);
        const statusMatch = statusFilter === 'all' || status === statusFilter;

        if (categoryMatch && searchMatch && statusMatch) {
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

function showEquipmentDetail(equipmentId) {
    window.location.href = `/services/equipment-loan/${equipmentId}`;
}

function openLoanModal(equipmentId) {
    const equipment = @json($equipments).find(eq => eq.id === equipmentId);
    if (!equipment) return;

    // Populate equipment info in modal
    const equipmentInfo = document.getElementById('equipment-info');
    equipmentInfo.innerHTML = `
        <h4 class="font-semibold text-gray-900 mb-3">Alat yang Dipinjam</h4>
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center">
                <i class="${equipment.icon} text-white"></i>
            </div>
            <div>
                <div class="font-semibold text-gray-900">${equipment.name}</div>
                <div class="text-sm text-gray-600">${equipment.model}</div>
                <div class="text-sm text-blue-600">Tersedia: ${equipment.quantity_available}/${equipment.quantity_total} unit</div>
            </div>
        </div>
        <div class="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
            <h5 class="font-semibold text-yellow-800 mb-2">Persyaratan Peminjaman:</h5>
            <ul class="text-sm text-yellow-700 space-y-1">
                ${equipment.requirements.map(req => `<li>• ${req}</li>`).join('')}
            </ul>
        </div>
    `;

    // Show modal
    document.getElementById('loanModal').classList.remove('hidden');
    document.getElementById('loanModal').classList.add('show');
    document.body.style.overflow = 'hidden';
}

function closeLoanModal() {
    document.getElementById('loanModal').classList.add('hidden');
    document.getElementById('loanModal').classList.remove('show');
    document.body.style.overflow = 'auto';
}

// Handle form submission
document.getElementById('loanForm').addEventListener('submit', function(e) {
    e.preventDefault();
    // Ambil data form
    const form = e.target;
    const data = {
        namaPeminjam: form.namaPeminjam.value,
        noHp: form.noHp.value,
        tujuanPeminjaman: form.tujuanPeminjaman.value,
        tanggal_pinjam: form.tanggal_pinjam.value,
        tanggal_pengembalian: form.tanggal_pengembalian.value,
        alat: selectedAlat.map(a => ({
            id: a.id,
            jumlah: a.jumlah
        }))
    };
    // Tampilkan konfirmasi
    showConfirmation(data);
    closeLoanModal();
});

let selectedAlat = [];
const alatRadios = document.querySelectorAll('.alat-radio');
const alatCheckboxes = document.querySelectorAll('.alat-checkbox');
const openLoanModalBtn = document.getElementById('openLoanModal');
const loanModal = document.getElementById('loanModal');
const alatInput = document.getElementById('alatInput');
const selectedAlatList = document.getElementById('selectedAlatList');
const multiSelectToggle = document.getElementById('multiSelectToggle');

function updateSelectionMode() {
    if (multiSelectToggle.checked) {
        // Enable multi-select (checkbox)
        alatRadios.forEach(r => { r.classList.add('hidden'); r.checked = false; });
        alatCheckboxes.forEach(cb => cb.classList.remove('hidden'));
        selectedAlat = Array.from(document.querySelectorAll('.alat-checkbox:checked')).map(cb => ({
            id: cb.value,
            jumlah: 1
        }));
    } else {
        // Single select (radio)
        alatRadios.forEach(r => r.classList.remove('hidden'));
        alatCheckboxes.forEach(cb => { cb.classList.add('hidden'); cb.checked = false; });
        // If any radio is checked, set selectedAlat to that
        const checkedRadio = document.querySelector('.alat-radio:checked');
        selectedAlat = checkedRadio ? [{ id: checkedRadio.value, jumlah: 1 }] : [];
    }
    openLoanModalBtn.disabled = selectedAlat.length === 0;
}

multiSelectToggle.addEventListener('change', updateSelectionMode);
alatRadios.forEach(radio => {
    radio.addEventListener('change', function() {
        if (!multiSelectToggle.checked) {
            selectedAlat = [{ id: this.value, jumlah: 1 }];
            openLoanModalBtn.disabled = false;
        }
    });
});
alatCheckboxes.forEach(cb => {
    cb.addEventListener('change', function() {
        if (multiSelectToggle.checked) {
            selectedAlat = Array.from(document.querySelectorAll('.alat-checkbox:checked')).map(cb => ({
                id: cb.value,
                jumlah: 1
            }));
            openLoanModalBtn.disabled = selectedAlat.length === 0;
        }
    });
});

// Lihat Detail
const lihatDetailBtns = document.querySelectorAll('.lihat-detail-btn');
lihatDetailBtns.forEach(btn => {
    btn.addEventListener('click', function() {
        const id = this.dataset.id;
        window.location.href = `/services/equipment-loan/${id}`;
    });
});

openLoanModalBtn.addEventListener('click', function() {
    loanModal.classList.remove('hidden');
    updateSelectedAlatList();
    // If jumlah not set, default to 1
    selectedAlat.forEach(a => { if (!a.jumlah) a.jumlah = 1; });
    renderRincianTable();
    alatInput.value = JSON.stringify(selectedAlat);
});

// Data alat dari backend
const alatData = @json($equipments);

function getAlatById(id) {
    return alatData.find(a => a.id === id);
}

function renderRincianTable() {
    let total = 0;
    let html = selectedAlat.map(a => {
        const alat = getAlatById(a.id);
        const harga = alat ? alat.harga : 0;
        const jumlah = a.jumlah;
        const subtotal = harga * jumlah;
        total += subtotal;
        return `<tr>
            <td class='p-2'>${alat ? alat.nama : '-'}</td>
            <td class='p-2'><input type='number' min='1' max='${alat ? alat.stok : 1}' value='${jumlah}' class='jumlah-input w-16 border rounded text-center' data-id='${a.id}'></td>
            <td class='p-2'>Rp ${harga.toLocaleString('id-ID')}</td>
            <td class='p-2'>Rp ${(subtotal).toLocaleString('id-ID')}</td>
        </tr>`;
    }).join('');
    document.getElementById('alatRincianTable').innerHTML = html;
    document.getElementById('totalHargaCell').innerText = 'Rp ' + total.toLocaleString('id-ID');
}

function updateJumlah(id, value, rerender = true) {
    const alat = getAlatById(id);
    const max = alat ? alat.stok : 1;
    value = Math.max(1, Math.min(max, value));
    const idx = selectedAlat.findIndex(a => a.id === id);
    if (idx !== -1) selectedAlat[idx].jumlah = value;
    if (rerender) renderRincianTable();
    alatInput.value = JSON.stringify(selectedAlat);
}

function updateSelectedAlatList() {
    selectedAlatList.innerHTML = selectedAlat.map(a => {
        const nama = getAlatById(a.id)?.nama || '-';
        return `<li>${nama}</li>`;
    }).join('');
}

let lastConfirmationData = null;
function showConfirmation(data) {
    lastConfirmationData = data;
    let alatRows = data.alat.map(a => {
        const alat = getAlatById(a.id);
        const harga = alat ? alat.harga : 0;
        const subtotal = harga * a.jumlah;
        return `<tr>
            <td class='p-2'>${alat ? alat.nama : '-'}</td>
            <td class='p-2'>${a.jumlah}</td>
            <td class='p-2'>Rp ${harga.toLocaleString('id-ID')}</td>
            <td class='p-2'>Rp ${(subtotal).toLocaleString('id-ID')}</td>
        </tr>`;
    }).join('');
    let total = data.alat.reduce((sum, a) => {
        const alat = getAlatById(a.id);
        return sum + (alat ? alat.harga * a.jumlah : 0);
    }, 0);
    document.getElementById('confirmationContent').innerHTML = `
        <div class='mb-4'>
            <div><b>Nama:</b> ${data.namaPeminjam}</div>
            <div><b>No HP:</b> ${data.noHp}</div>
            <div><b>Tujuan:</b> ${data.tujuanPeminjaman}</div>
            <div><b>Tanggal Pinjam:</b> ${data.tanggal_pinjam}</div>
            <div><b>Tanggal Kembali:</b> ${data.tanggal_pengembalian}</div>
        </div>
        <div class='mb-4'>
            <table class='w-full text-sm border'>
                <thead><tr class='bg-gray-100'><th class='p-2'>Alat</th><th class='p-2'>Jumlah</th><th class='p-2'>Harga</th><th class='p-2'>Subtotal</th></tr></thead>
                <tbody>${alatRows}</tbody>
                <tfoot><tr><td colspan='3' class='text-right font-bold p-2'>Total</td><td class='font-bold p-2'>Rp ${total.toLocaleString('id-ID')}</td></tr></tfoot>
            </table>
        </div>
    `;
    document.getElementById('confirmationModal').classList.remove('hidden');
}

document.getElementById('confirmAndSubmitBtn').onclick = function() {
    if (!lastConfirmationData) return;
    const form = document.getElementById('realSubmitForm');
    form.namaPeminjam.value = lastConfirmationData.namaPeminjam;
    form.noHp.value = lastConfirmationData.noHp;
    form.tujuanPeminjaman.value = lastConfirmationData.tujuanPeminjaman;
    form.tanggal_pinjam.value = lastConfirmationData.tanggal_pinjam;
    form.tanggal_pengembalian.value = lastConfirmationData.tanggal_pengembalian;
    form.alat.value = JSON.stringify(lastConfirmationData.alat);
    form.submit();
};

document.addEventListener('input', function(e) {
    if (e.target.classList.contains('jumlah-input')) {
        const id = e.target.dataset.id;
        const value = parseInt(e.target.value) || 1;
        updateJumlah(id, value, true); // Always rerender
    }
});
</script>
@endsection

