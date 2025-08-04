@extends('user.layouts.app')

@section('title', 'Pengajuan Berhasil - Laboratorium Fisika Material dan Energi')

@section('content')
<!-- Hero Section -->
<section class="relative min-h-[50vh] flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('/images/hero.jpg') }}" alt="Pengajuan Berhasil" class="w-full h-full object-cover">
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
                            <span class="text-white font-medium">Pengajuan Berhasil</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>

        <div class="scroll-animate mb-8 opacity-0" data-animation="fade-up" data-delay="200">
            <h1 class="font-poppins text-4xl md:text-6xl font-bold leading-tight mb-6">
                <span class="text-white">Pengajuan</span>
                <span class="bg-gradient-to-r from-yellow-400 to-orange-400 bg-clip-text text-transparent drop-shadow-lg"> Berhasil</span>
            </h1>
            <p class="text-xl md:text-2xl text-blue-100 max-w-4xl mx-auto leading-relaxed">
                Permohonan peminjaman alat Anda telah diterima!
            </p>
        </div>
    </div>
</section>

<!-- Success Section -->
<section class="py-16 bg-gradient-to-b from-gray-50 to-white">
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100 text-center">
            <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-check-circle text-green-600 text-3xl"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-4">Pengajuan Peminjaman Berhasil!</h3>
            <p class="text-gray-600 mb-4">Terima kasih telah mengajukan peminjaman alat di Laboratorium Fisika Material dan Energi.</p>
            <p class="text-gray-600 mb-6">Gunakan kode tracking berikut untuk memantau status peminjaman Anda:</p>
            
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6">
                <div class="flex items-center justify-center space-x-2">
                    <input type="text" id="trackingLink" value="{{ $tracking_code }}" readonly 
                           class="w-full max-w-md px-4 py-2 border border-gray-200 rounded-lg bg-gray-50 text-gray-700">
                    <button id="copyButton" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-copy mr-2"></i>Salin
                    </button>
                </div>
            </div>
            
            <p class="text-sm text-gray-500 mb-6">
                <i class="fas fa-info-circle mr-1"></i>
                Simpan kode tracking atau bookmark link ini untuk memeriksa perkembangan status peminjaman Anda kapan saja.
            </p>
            
            <div class="flex justify-center space-x-4">
                <a href="{{ $tracking_link }}" class="bg-blue-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-blue-700 transition-colors">
                    <i class="fas fa-search mr-2"></i>Cek Status Sekarang
                </a>
                <a href="{{ route('equipment.loan') }}" class="bg-gray-200 text-gray-700 px-6 py-3 rounded-xl font-semibold hover:bg-gray-300 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali ke Peminjaman
                </a>
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
.bg-clip-text {
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    initScrollAnimations();

    // Copy tracking link to clipboard
    const copyButton = document.getElementById('copyButton');
    const trackingLink = document.getElementById('trackingLink');
    
    copyButton.addEventListener('click', function() {
        trackingLink.select();
        try {
            document.execCommand('copy');
            copyButton.innerHTML = '<i class="fas fa-check mr-2"></i>Disalin';
            copyButton.classList.replace('bg-blue-600', 'bg-green-600');
            copyButton.classList.replace('hover:bg-blue-700', 'hover:bg-green-700');
            setTimeout(() => {
                copyButton.innerHTML = '<i class="fas fa-copy mr-2"></i>Salin';
                copyButton.classList.replace('bg-green-600', 'bg-blue-600');
                copyButton.classList.replace('hover:bg-green-700', 'hover:bg-blue-700');
            }, 2000);
        } catch (err) {
            console.error('Failed to copy:', err);
            alert('Gagal menyalin link. Silakan salin secara manual.');
        }
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
    animatedElements.forEach(element => observer.observe(element));
}
</script>
@endsection