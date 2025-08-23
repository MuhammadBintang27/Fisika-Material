@extends('user.layouts.app')

@section('title', 'Layanan Pengujian - Laboratorium Fisika Material dan Energi')

@section('content')
<!-- Hero Section -->
<section class="relative min-h-[60vh] flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('/images/hero.jpg') }}" alt="Layanan Pengujian" class="w-full h-full object-cover">
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
                            <span class="text-white font-medium">Pengujian</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>

        <div class="scroll-animate mb-8 opacity-0" data-animation="fade-up" data-delay="200">
            <h1 class="font-poppins text-4xl md:text-6xl font-bold leading-tight mb-6">
                <span class="text-white">Layanan</span>
                <span class="bg-gradient-to-r from-yellow-400 to-orange-400 bg-clip-text text-transparent drop-shadow-lg"> Pengujian</span>
            </h1>
            <p class="text-xl md:text-2xl text-blue-100 max-w-4xl mx-auto leading-relaxed">
                Karakterisasi dan analisis material dengan teknologi terdepan
            </p>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="py-16 bg-gradient-to-b from-gray-50 to-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        
        <div class="text-center mb-20 scroll-animate" data-animation="fade-down">
            <div class="inline-flex items-center px-6 py-3 bg-blue-50 border border-blue-200 rounded-full text-blue-700 text-sm font-semibold mb-6 shadow-sm">
                <i class="fas fa-building mr-2"></i>
                Katalog Layanan Pengujian
            </div>
            <h2 class="font-poppins text-4xl md:text-6xl font-bold text-gray-900 mb-6">
                Pilih <span class="bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent">Pengujian</span>
            </h2>
            <p class="text-gray-600 text-lg md:text-xl max-w-4xl mx-auto leading-relaxed">
Pilih layanan pengujian yang sesuai dengan kebutuhan penelitian Anda            </p>
        </div>

        @if($layanan->count() > 0)
            <!-- Services Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($layanan as $item)
                <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100 overflow-hidden group">
                    <!-- Header -->
                    <div class="bg-gradient-to-r from-blue-600 to-blue-800 p-6 text-white">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-flask text-2xl"></i>
                            </div>
                            <div class="text-right">
                                <span class="bg-white/20 px-3 py-1 rounded-full text-sm font-medium">
                                    {{ $item->estimasiSelesaiHari }} hari
                                </span>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold mb-2">{{ $item->namaLayanan }}</h3>
                        @if($item->harga)
                            <p class="bg-gradient-to-r from-yellow-400 to-orange-400 bg-clip-text text-transparent text-lg font-semibold">
                                Rp {{ number_format($item->harga, 0, ',', '.') }}
                            </p>
                        @else
                            <p class="bg-gradient-to-r from-yellow-400 to-orange-400 bg-clip-text text-transparent text-lg font-semibold">Gratis</p>
                        @endif
                    </div>

                    <!-- Content -->
                    <div class="p-6">
                        @if($item->deskripsi)
                            <p class="text-gray-600 mb-4 leading-relaxed">
                                {{ Str::limit($item->deskripsi, 120) }}
                            </p>
                        @endif

                        <!-- Features -->
                        <div class="space-y-3 mb-6">
                            <div class="flex items-center text-sm text-gray-500">
                                <i class="fas fa-clock w-4 h-4 mr-3 bg-gradient-to-r from-yellow-400 to-orange-400 bg-clip-text text-transparent"></i>
                                <span>Estimasi selesai: {{ $item->estimasiSelesaiHari }} hari kerja</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-500">
                                <i class="fas fa-certificate w-4 h-4 mr-3 bg-gradient-to-r from-yellow-400 to-orange-400 bg-clip-text text-transparent"></i>
                                <span>Hasil berstandar internasional</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-500">
                                <i class="fas fa-download w-4 h-4 mr-3 bg-gradient-to-r from-yellow-400 to-orange-400 bg-clip-text text-transparent"></i>
                                <span>Report digital tersedia</span>
                            </div>
                        </div>

                        <!-- Action Button -->
                        <a href="{{ route('testing.detail', $item->id) }}" 
                           class="w-full bg-gradient-to-r from-blue-600 to-blue-800 text-white py-3 px-6 rounded-xl font-semibold hover:from-blue-700 hover:to-blue-900 transition-all duration-300 transform group-hover:scale-105 shadow-lg hover:shadow-xl flex items-center justify-center">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Ajukan Pengujian
                        </a>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Info Section -->
            <div class="mt-16 bg-gradient-to-r from-blue-600 to-blue-800 rounded-2xl p-8 text-white">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                    <div>
                        <h3 class="text-2xl font-bold mb-4">Butuh Bantuan?</h3>
                        <p class="text-blue-100 mb-6 leading-relaxed">
                            Tim ahli kami siap membantu Anda memilih layanan pengujian yang tepat untuk penelitian Anda.
                        </p>
                        <div class="space-y-3">
                            <div class="flex items-center">
                                <i class="fas fa-phone w-5 h-5 mr-3"></i>
                                <span>+62 651 7551394</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-envelope w-5 h-5 mr-3"></i>
                                <span>fisika@unsyiah.ac.id</span>
                            </div>
                        </div>
                    </div>
                    <div class="text-center lg:text-right">
                        <div class="inline-flex items-center justify-center w-32 h-32 bg-white/20 rounded-full mb-4">
                            <i class="fas fa-microscope text-4xl"></i>
                        </div>
                        <p class="text-blue-100">
                            Laboratorium Fisika Material dan Energi<br>
                            Universitas Syiah Kuala
                        </p>
                    </div>
                </div>
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="w-32 h-32 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-8">
                    <i class="fas fa-flask text-gray-400 text-4xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Layanan Belum Tersedia</h3>
                <p class="text-gray-600 mb-8 max-w-md mx-auto">
                    Saat ini belum ada layanan pengujian yang tersedia. Silakan hubungi admin untuk informasi lebih lanjut.
                </p>
                <a href="{{ route('home') }}" 
                   class="bg-blue-600 text-white px-6 py-3 rounded-xl hover:bg-blue-700 transition-colors font-semibold inline-flex items-center">
                    <i class="fas fa-home mr-2"></i>
                    Kembali ke Beranda
                </a>
            </div>
        @endif
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
</script>
@endsection
