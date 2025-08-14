{{-- resources/views/staff.blade.php --}}
@extends('user.layouts.app')

@section('title', 'Staff dan Tenaga Ahli - Laboratorium Fisika Dasar')

@section('content')
<!-- Hero Section -->
<section class="relative min-h-[60vh] flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('/images/hero.jpg') }}" alt="Staff dan Tenaga Ahli" class="w-full h-full object-cover">
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
                            <span class="text-white font-medium">Staff dan Tenaga Ahli</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>

        <div class="scroll-animate mb-8 opacity-0" data-animation="fade-up" data-delay="200">
            <h1 class="font-poppins text-4xl md:text-6xl font-bold leading-tight mb-6">
                <span class="text-white">Tim</span>
                <span class="bg-gradient-to-r from-yellow-400 to-orange-400 bg-clip-text text-transparent drop-shadow-lg"> Profesional</span>
            </h1>
            <p class="text-xl md:text-2xl text-blue-100 max-w-4xl mx-auto leading-relaxed">
                Laboratorium Fisika Material dan Energi Departemen Fisika Universitas Syiah Kuala
            </p>
        </div>
    </div>
</section>

<!-- Main Staff Section -->
<section class="py-24 bg-gray-50 relative">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <!-- Filter & Search Section -->
        <div class="mb-16 staff-animate" data-animation="fade-down">
            <div class="bg-white rounded-3xl p-8 border border-gray-200 shadow-lg">
                <div class="flex flex-col lg:flex-row items-center justify-between gap-6">
                    <!-- Category Filter -->
                    <div class="flex flex-wrap justify-center lg:justify-start gap-4">
                        <button class="staff-filter-btn active px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-800 text-white rounded-full font-medium transition-all duration-300 hover:from-blue-700 hover:to-blue-900 shadow-lg" data-filter="all">
                            <i class="fas fa-users mr-2"></i>Semua Tim ({{ $stats['total_staff'] }})
                        </button>
                        @foreach($stats['jabatan_list'] as $jabatan => $count)
                        <button class="staff-filter-btn px-6 py-3 bg-white text-blue-700 border border-blue-200 rounded-full font-medium transition-all duration-300 hover:bg-blue-50" data-filter="{{ $jabatan }}">
                            <span class="mr-2">{{ $jabatan }}</span> ({{ $count }})
                        </button>
                        @endforeach
                    </div>
                    <!-- Search (by name only) -->
                    <div class="relative">
                        <input type="text" id="staff-search" placeholder="Cari berdasarkan nama..."
                               class="pl-12 pr-4 py-3 w-80 border border-gray-300 rounded-full focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                        <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Staff Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16" id="staff-grid">
            @php
                // Urutkan: Kepala Laboratorium paling atas, lalu urutkan jabatan lain sesuai abjad
                $sortedStaff = collect($staff)->sortBy(function($item) {
                    if (strtolower($item->jabatan) === 'kepala laboratorium') return '0';
                    return $item->jabatan;
                });
            @endphp
            @foreach($sortedStaff as $index => $member)
            <div class="staff-card group relative bg-white rounded-3xl p-8 border border-gray-200 hover:border-blue-200 transition-all duration-300 hover:shadow-lg hover:-translate-y-1 overflow-hidden staff-animate"
                 data-animation="fade-up"
                 data-delay="{{ ($index + 1) * 100 }}"
                 data-category="{{ $member->jabatan }}"
                 data-search="{{ strtolower($member->nama) }}">
                <div class="relative z-10 text-center">
                    <!-- Staff Photo -->
                    <div class="mb-6">
                        @if($member->gambar && $member->gambar->first())
                            <div class="relative mx-auto w-40 h-48 bg-gradient-to-br from-gray-200 to-gray-300 rounded-2xl flex items-center justify-center shadow-md group-hover:shadow-lg transition-all duration-300 overflow-hidden">
                                <img src="{{ url('storage/' . $member->gambar->first()->url) }}" alt="{{ $member->nama }}" class="w-full h-full object-cover rounded-2xl group-hover:scale-105 transition-transform duration-300">
                            </div>
                        @else
                            <div class="relative mx-auto w-40 h-48 bg-gradient-to-br from-gray-200 to-gray-300 rounded-2xl flex items-center justify-center shadow-md group-hover:shadow-lg transition-all duration-300">
                                <i class="fas fa-user text-5xl text-gray-400 group-hover:text-blue-500 transition-colors duration-300"></i>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Staff Info -->
                    <div class="space-y-3">
                        <h3 class="font-poppins text-xl font-bold text-gray-900 group-hover:text-blue-700 transition-colors duration-300">
                            {{ $member->nama }}
                        </h3>
                        <div class="flex justify-center">
                            <span class="text-sm text-blue-600 font-medium bg-blue-50 px-4 py-2 rounded-full border border-blue-200">
                                {{ $member->jabatan }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<style>
/* Scroll Animations */
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

/* Enhanced Gradient Text */
.bg-clip-text {
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
}

/* ===== MOLECULAR ANIMATION STYLES ===== */
.staff-molecules-container {
    position: absolute;
    width: 100%;
    height: 100%;
    overflow: hidden;
}

.staff-molecule {
    position: absolute;
    width: 60px;
    height: 60px;
    opacity: 0.8;
    pointer-events: none;
}

.staff-atom {
    position: absolute;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(255,255,255,0.9), rgba(255,215,0,0.4));
    box-shadow: 0 0 20px rgba(255,255,255,0.6);
}

.staff-atom.core {
    width: 12px;
    height: 12px;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    animation: staffPulse 2s infinite ease-in-out;
}

.staff-atom.electron {
    width: 6px;
    height: 6px;
}

.staff-orbit {
    position: absolute;
    border: 1px solid rgba(255,255,255,0.3);
    border-radius: 50%;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

.staff-orbit-1 {
    width: 40px;
    height: 40px;
    animation: staffRotate 4s linear infinite;
}

.staff-orbit-2 {
    width: 55px;
    height: 55px;
    animation: staffRotate 6s linear infinite reverse;
}

.staff-orbit-1 .staff-atom.electron {
    top: -3px;
    left: 50%;
    transform: translateX(-50%);
}

.staff-orbit-2 .staff-atom.electron {
    top: -3px;
    left: 50%;
    transform: translateX(-50%);
}

/* Keyframe Animations */
@keyframes staffRotate {
    from { transform: translate(-50%, -50%) rotate(0deg); }
    to { transform: translate(-50%, -50%) rotate(360deg); }
}

@keyframes staffPulse {
    0%, 100% {
        transform: translate(-50%, -50%) scale(1);
    }
    50% {
        transform: translate(-50%, -50%) scale(1.3);
    }
}

.staff-molecule.float {
    animation: staffMoleculeFloat 18s infinite linear;
}

@keyframes staffMoleculeFloat {
    0% {
        transform: translateY(100vh) translateX(-50px) rotate(0deg) scale(0.5);
        opacity: 0;
    }
    5% {
        opacity: 0.8;
        transform: translateY(95vh) translateX(-40px) rotate(18deg) scale(0.7);
    }
    25% {
        transform: translateY(75vh) translateX(-10px) rotate(90deg) scale(1);
    }
    50% {
        transform: translateY(50vh) translateX(20px) rotate(180deg) scale(1.1);
    }
    75% {
        transform: translateY(25vh) translateX(40px) rotate(270deg) scale(1);
    }
    95% {
        opacity: 0.8;
        transform: translateY(5vh) translateX(60px) rotate(342deg) scale(0.7);
    }
    100% {
        transform: translateY(-10vh) translateX(80px) rotate(360deg) scale(0.5);
        opacity: 0;
    }
}

/* Molecule Color Variants */
.staff-molecule.amber .staff-atom.core {
    background: radial-gradient(circle, #fbbf24, #d97706);
    box-shadow: 0 0 25px rgba(251, 191, 36, 0.9);
}

.staff-molecule.amber .staff-atom.electron {
    background: radial-gradient(circle, #fbbf24, #d97706);
    box-shadow: 0 0 15px rgba(251, 191, 36, 0.7);
}

.staff-molecule.orange .staff-atom.core {
    background: radial-gradient(circle, #fb923c, #ea580c);
    box-shadow: 0 0 25px rgba(251, 146, 60, 0.8);
}

.staff-molecule.orange .staff-atom.electron {
    background: radial-gradient(circle, #fb923c, #ea580c);
    box-shadow: 0 0 15px rgba(251, 146, 60, 0.7);
}

.staff-molecule.brown .staff-atom.core {
    background: radial-gradient(circle, #a78bfa, #7c3aed);
    box-shadow: 0 0 25px rgba(167, 139, 250, 0.8);
}

.staff-molecule.brown .staff-atom.electron {
    background: radial-gradient(circle, #a78bfa, #7c3aed);
    box-shadow: 0 0 15px rgba(167, 139, 250, 0.7);
}

/* ===== STAFF PAGE SPECIFIC STYLES ===== */
.staff-hero-animate {
    opacity: 0;
    transition: all 0.8s ease-out;
}

.staff-hero-animate[data-animation="fade-down"] {
    transform: translateY(-40px);
}

.staff-hero-animate[data-animation="fade-up"] {
    transform: translateY(40px);
}

.staff-hero-animate.animate {
    opacity: 1;
    transform: translateY(0);
}

/* Staff Card Styles */
.staff-card {
    transition: all 0.3s ease;
    min-height: 380px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.staff-card:hover {
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
    transform: translateY(-4px);
}

/* Filter Button Styles */
.staff-filter-btn.active {
    background: linear-gradient(135deg, #968c82 0%, #635849 100%);
    color: white;
    box-shadow: 0 4px 15px rgba(150, 140, 130, 0.3);
}

/* Search Input */
#staff-search:focus {
    transform: scale(1.02);
}

/* Animation Classes */
.staff-animate {
    opacity: 0;
    transition: all 0.6s ease-out;
}

.staff-animate[data-animation="fade-down"] {
    transform: translateY(-60px);
}

.staff-animate[data-animation="fade-up"] {
    transform: translateY(60px);
}

.staff-animate.animate {
    opacity: 1;
    transform: translateY(0);
}

/* Card Filtering */
.staff-card.hidden {
    opacity: 0;
    transform: scale(0.8);
    transition: all 0.5s ease;
}

.staff-card.visible {
    opacity: 1;
    transform: scale(1);
    transition: all 0.5s ease;
}

/* ===== RESPONSIVE DESIGN ===== */
@media (max-width: 768px) {
    .staff-card {
        margin-bottom: 1.5rem;
        min-height: 320px;
    }

    #staff-search {
        width: 100%;
    }

    .staff-molecule {
        width: 40px;
        height: 40px;
    }

    .staff-orbit-1 {
        width: 30px;
        height: 30px;
    }

    .staff-orbit-2 {
        width: 40px;
        height: 40px;
    }

    /* Adjust photo size for mobile */
    .staff-card .w-40 {
        width: 7rem;
    }

    .staff-card .h-48 {
        height: 8.5rem;
    }
}

@media (max-width: 640px) {
    .staff-card {
        min-height: 300px;
        padding: 1.5rem;
    }

    .staff-card .w-40 {
        width: 6rem;
    }

    .staff-card .h-48 {
        height: 7.5rem;
    }

    .staff-card h3 {
        font-size: 1.1rem;
    }
}

@media (max-width: 480px) {
    .staff-card {
        min-height: 280px;
        padding: 1rem;
    }

    .staff-card .w-40 {
        width: 5.5rem;
    }

    .staff-card .h-48 {
        height: 7rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize scroll animations
    initScrollAnimations();
    
    // Function for scroll animations
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
    
    // ===== MOLECULAR ANIMATION =====
    function createStaffMolecularAnimation() {
        const container = document.getElementById('staff-molecules-container');
        if (!container) return;

        const moleculeTypes = ['blue', 'cyan', 'indigo'];
        const moleculeSizes = ['small', 'normal', 'large'];

        function createMolecule() {
            const molecule = document.createElement('div');
            const type = moleculeTypes[Math.floor(Math.random() * moleculeTypes.length)];
            const size = moleculeSizes[Math.floor(Math.random() * moleculeSizes.length)];

            molecule.className = `staff-molecule float ${type} ${size}`;
            molecule.style.left = Math.random() * 100 + '%';
            molecule.style.animationDelay = Math.random() * 5 + 's';
            molecule.style.animationDuration = (15 + Math.random() * 10) + 's';

            // Core atom
            const core = document.createElement('div');
            core.className = 'staff-atom core';
            molecule.appendChild(core);

            // Create orbits
            const numOrbits = Math.random() > 0.5 ? 2 : 1;
            for (let i = 1; i <= numOrbits; i++) {
                const orbit = document.createElement('div');
                orbit.className = `staff-orbit staff-orbit-${i}`;

                const electron = document.createElement('div');
                electron.className = 'staff-atom electron';
                orbit.appendChild(electron);

                molecule.appendChild(orbit);
            }

            container.appendChild(molecule);

            // Cleanup
            setTimeout(() => {
                if (container.contains(molecule)) {
                    container.removeChild(molecule);
                }
            }, 20000);
        }

        // Initialize molecules
        for (let i = 0; i < 3; i++) {
            setTimeout(() => createMolecule(), i * 2000);
        }

        const moleculeInterval = setInterval(createMolecule, 3000);

        window.addEventListener('beforeunload', () => {
            clearInterval(moleculeInterval);
        });
    }

    // ===== ANIMATIONS =====
    createStaffMolecularAnimation();

    // Hero animations
    const heroElements = document.querySelectorAll('.staff-hero-animate');
    setTimeout(() => {
        heroElements.forEach(element => {
            const delay = element.dataset.delay || 0;
            setTimeout(() => {
                element.classList.add('animate');
            }, delay);
        });
    }, 300);

    // Staff section animations
    const staffElements = document.querySelectorAll('.staff-animate');
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
        rootMargin: '0px 0px -100px 0px'
    });

    staffElements.forEach(element => {
        observer.observe(element);
    });

    // ===== FILTERING & SEARCH =====
    const filterButtons = document.querySelectorAll('.staff-filter-btn');
    const staffCards = document.querySelectorAll('.staff-card');
    const searchInput = document.getElementById('staff-search');

    // Filter functionality
    filterButtons.forEach(button => {
        button.addEventListener('click', () => {
            const filter = button.dataset.filter;
            filterButtons.forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');
            filterCards(filter, searchInput.value);
        });
    });

    // Search functionality
    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            const searchTerm = e.target.value.toLowerCase();
            const activeFilter = document.querySelector('.staff-filter-btn.active').dataset.filter;
            filterCards(activeFilter, searchTerm);
        });
    }

    // Filter cards function
    function filterCards(categoryFilter, searchTerm) {
        staffCards.forEach(card => {
            const category = card.dataset.category;
            const searchData = card.dataset.search || '';
            const categoryMatch = categoryFilter === 'all' || category === categoryFilter;
            const searchMatch = searchTerm === '' || searchData.includes(searchTerm);
            if (categoryMatch && searchMatch) {
                card.style.display = 'block';
                setTimeout(() => {
                    card.classList.remove('hidden');
                    card.classList.add('visible');
                }, 50);
            } else {
                card.classList.remove('visible');
                card.classList.add('hidden');
                setTimeout(() => {
                    card.style.display = 'none';
                }, 500);
            }
        });
    }

    // Initialize all cards as visible
    staffCards.forEach(card => {
        card.classList.add('visible');
    });

    // ===== PARALLAX EFFECT =====
    window.addEventListener('scroll', () => {
        const scrolled = window.pageYOffset;
        const parallax = document.querySelector('.staff-molecules-container');
        if (parallax) {
            const speed = scrolled * 0.3;
            parallax.style.transform = `translateY(${speed}px)`;
        }
    });

    // ===== PERFORMANCE OPTIMIZATION =====
    const heroSection = document.querySelector('section');
    const heroObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            const molecules = entry.target.querySelectorAll('.staff-molecule');
            if (entry.isIntersecting) {
                molecules.forEach(molecule => {
                    molecule.style.animationPlayState = 'running';
                });
            } else {
                molecules.forEach(molecule => {
                    molecule.style.animationPlayState = 'paused';
                });
            }
        });
    });

    if (heroSection) {
        heroObserver.observe(heroSection);
    }
});
</script>
@endsection
