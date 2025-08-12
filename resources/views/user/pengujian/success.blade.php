@extends('user.layouts.app')

@section('title', 'Pengajuan Berhasil - Laboratorium Fisika Material dan Energi')

@section('content')
<!-- Success Section -->
<section class="py-16 bg-gradient-to-b from-green-50 to-white min-h-screen flex items-center">
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 text-center">
        <!-- Success Icon -->
        <div class="scroll-animate mb-8 opacity-0" data-animation="fade-down">
            <div class="w-32 h-32 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6 animate-pulse">
                <i class="fas fa-check-circle text-6xl text-green-500"></i>
            </div>
        </div>

        <!-- Success Message -->
        <div class="scroll-animate mb-8 opacity-0" data-animation="fade-up" data-delay="200">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                Pengajuan Berhasil Dikirim!
            </h1>
            <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto leading-relaxed">
                Terima kasih telah mengajukan layanan pengujian. Kami akan segera memproses pengajuan Anda.
            </p>
        </div>

        <!-- Tracking Code Display -->
        @if(isset($tracking_code))
            <div class="scroll-animate mb-12 opacity-0" data-animation="fade-up" data-delay="300">
                <div class="bg-white rounded-2xl shadow-lg p-8 max-w-2xl mx-auto border border-gray-100">
                    <div class="bg-gradient-to-r from-orange-600 to-red-600 text-white p-6 rounded-xl mb-6">
                        <h2 class="text-xl font-bold mb-2">Kode Tracking Anda</h2>
                        <div class="bg-white/20 backdrop-blur rounded-lg p-4">
                            <p class="text-orange-100 text-sm mb-2">Simpan kode ini untuk melacak status pengajuan:</p>
                            <p class="font-mono text-2xl font-bold">{{ $tracking_code }}</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center justify-center space-x-4">
                            <button 
                                onclick="copyTrackingCode()" 
                                id="copyButton"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
                            >
                                <i class="fas fa-copy mr-2"></i>
                                Salin Kode
                            </button>
                            
                            @if(isset($tracking_link))
                                <a href="{{ $tracking_link }}" class="inline-flex items-center px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-colors">
                                    <i class="fas fa-search mr-2"></i>
                                    Lacak Sekarang
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Submission Details -->
        @if(isset($pengajuan))
            <div class="scroll-animate mb-12 opacity-0" data-animation="fade-up" data-delay="400">
                <div class="bg-white rounded-2xl shadow-lg p-8 max-w-2xl mx-auto border border-gray-100">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Detail Pengajuan</h3>

                    <div class="space-y-4 text-left">
                        @if($pengajuan->layanan)
                            <div class="flex justify-between items-center py-3 border-b border-gray-100">
                                <span class="text-gray-600">Layanan:</span>
                                <span class="font-semibold text-gray-900">{{ $pengajuan->layanan->namaLayanan }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="text-gray-600">Nama Pengaju:</span>
                            <span class="font-semibold text-gray-900">{{ $pengajuan->namaPengaju }}</span>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="text-gray-600">No. HP:</span>
                            <span class="font-semibold text-gray-900">{{ $pengajuan->noHp }}</span>
                        </div>
                        @if($pengajuan->email)
                            <div class="flex justify-between items-center py-3 border-b border-gray-100">
                                <span class="text-gray-600">Email:</span>
                                <span class="font-semibold text-gray-900">{{ $pengajuan->email }}</span>
                            </div>
                        @endif
                        @if($pengajuan->instansi)
                            <div class="flex justify-between items-center py-3 border-b border-gray-100">
                                <span class="text-gray-600">Instansi:</span>
                                <span class="font-semibold text-gray-900">{{ $pengajuan->instansi }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="text-gray-600">Status:</span>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                <i class="fas fa-clock mr-2"></i>
                                Menunggu Persetujuan
                            </span>
                        </div>
                        <div class="flex justify-between items-center py-3">
                            <span class="text-gray-600">Tanggal Pengajuan:</span>
                            <span class="font-semibold text-gray-900">{{ $pengajuan->tanggalPengajuan->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Next Steps -->
        <div class="scroll-animate mb-12 opacity-0" data-animation="fade-up" data-delay="600">
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-8 max-w-3xl mx-auto">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Langkah Selanjutnya</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-clock text-2xl text-blue-600"></i>
                        </div>
                        <h4 class="font-semibold text-gray-900 mb-2">Menunggu Persetujuan</h4>
                        <p class="text-sm text-gray-600">Tim kami akan meninjau pengajuan Anda dalam 1-2 hari kerja</p>
                    </div>
                    <div class="text-center">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fab fa-whatsapp text-2xl text-green-600"></i>
                        </div>
                        <h4 class="font-semibold text-gray-900 mb-2">Notifikasi WhatsApp</h4>
                        <p class="text-sm text-gray-600">Anda akan menerima notifikasi status melalui WhatsApp</p>
                    </div>
                    <div class="text-center">
                        <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-search text-2xl text-orange-600"></i>
                        </div>
                        <h4 class="font-semibold text-gray-900 mb-2">Lacak Status</h4>
                        <p class="text-sm text-gray-600">Gunakan kode tracking untuk melihat progress pengujian</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="scroll-animate opacity-0" data-animation="fade-up" data-delay="800">
            <div class="flex flex-col sm:flex-row gap-4 justify-center max-w-md mx-auto">
                @if(isset($tracking_code))
                    <a href="{{ route('tracking') }}?code={{ $tracking_code }}" 
                       class="bg-gradient-to-r from-orange-600 to-red-600 text-white py-3 px-6 rounded-xl font-semibold hover:from-orange-700 hover:to-red-700 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl flex items-center justify-center">
                        <i class="fas fa-search mr-2"></i>
                        Lacak Status
                    </a>
                @endif
                <a href="{{ route('testing.services') }}" 
                   class="bg-white text-orange-600 py-3 px-6 rounded-xl font-semibold hover:bg-orange-50 transition-all duration-300 border border-orange-600 flex items-center justify-center">
                    <i class="fas fa-plus mr-2"></i>
                    Ajukan Lagi
                </a>
            </div>
        </div>

        <!-- Contact Info -->
        <div class="scroll-animate mt-16 opacity-0" data-animation="fade-up" data-delay="1000">
            <div class="bg-gradient-to-r from-gray-800 to-gray-900 rounded-2xl p-8 text-white max-w-2xl mx-auto">
                <h4 class="text-xl font-bold mb-6">Butuh Bantuan?</h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-sm">
                    <div class="flex items-center">
                        <i class="fas fa-phone w-5 h-5 mr-3 text-orange-400"></i>
                        <div>
                            <p class="text-gray-300">Telepon</p>
                            <p class="font-semibold">+62 651 7551394</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-envelope w-5 h-5 mr-3 text-orange-400"></i>
                        <div>
                            <p class="text-gray-300">Email</p>
                            <p class="font-semibold">fisika@unsyiah.ac.id</p>
                        </div>
                    </div>
                </div>
                <div class="mt-6 pt-6 border-t border-gray-700">
                    <p class="text-gray-300 text-center">
                        <i class="fas fa-clock mr-2"></i>
                        Jam Operasional: Senin - Jumat, 08:00 - 16:00 WIB
                    </p>
                </div>
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

@keyframes pulse {
    0%, 100% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.05);
    }
}

.animate-pulse {
    animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    initScrollAnimations();
    copyTrackingCode();
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

function copyTrackingCode() {
    // Auto select tracking code when clicked
    const trackingCode = document.querySelector('.font-mono');
    if (trackingCode) {
        trackingCode.addEventListener('click', function() {
            const range = document.createRange();
            range.selectNode(trackingCode);
            window.getSelection().removeAllRanges();
            window.getSelection().addRange(range);
            
            // Try to copy to clipboard
            try {
                document.execCommand('copy');
                // Show tooltip or notification
                const originalText = trackingCode.textContent;
                trackingCode.textContent = 'Disalin!';
                setTimeout(() => {
                    trackingCode.textContent = originalText;
                }, 1000);
            } catch (err) {
                console.log('Copy failed');
            }
            
            window.getSelection().removeAllRanges();
        });
    }
}
</script>
@endsection
