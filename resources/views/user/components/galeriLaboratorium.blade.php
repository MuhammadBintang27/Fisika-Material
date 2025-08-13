<section id="laboratorium" class="py-24 relative">
    <!-- Top Divider/Separator -->
    <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-blue-200 to-transparent"></div>
    <div class="absolute top-0 left-1/2 transform -translate-x-1/2 w-32 h-1 bg-gradient-to-r from-blue-600 to-blue-700 rounded-full"></div>

    <!-- Decorative Background Elements -->
    <div class="absolute top-20 left-10 w-32 h-32 bg-gray-100 rounded-full opacity-20 blur-3xl"></div>
    <div class="absolute bottom-20 right-10 w-40 h-40 bg-gray-200 rounded-full opacity-30 blur-3xl"></div>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Section Header -->
        <div class="text-center mb-20 scroll-animate" data-animation="fade-down">
            <div class="inline-flex items-center px-4 py-2 bg-gray-50 border border-gray-200 rounded-full text-blue-700 text-sm font-medium mb-6">
                <i class="fas fa-flask mr-2 text-blue-600"></i>
                Galeri Laboratorium
            </div>
            <h2 class="font-poppins text-4xl md:text-6xl font-bold text-gray-900 mb-6">
                Jelajahi <span class="bg-clip-text text-transparent" style="background-image: linear-gradient(to right, #1e3a8a, #2563eb);">Laboratorium Kami</span>
            </h2>
            <p class="text-gray-600 text-lg max-w-3xl mx-auto leading-relaxed">
                Lihat fasilitas canggih dan lingkungan penelitian kami yang mendukung inovasi di bidang geofisika.
            </p>
        </div>

        <!-- Gallery Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mb-20">
            @forelse($galeriLaboratorium as $item)
            <div class="group relative rounded-3xl overflow-hidden shadow-lg bg-white border border-blue-200 hover:shadow-blue-200/50 transition-all duration-300 scroll-animate" data-animation="fade-down" data-delay="{{ $loop->iteration * 100 }}">
                <img src="{{ url('storage/' . $item->gambar_url) }}" alt="{{ $item->judul }}" class="w-full h-64 object-cover transform group-hover:scale-105 transition-transform duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-blue-800/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="absolute bottom-4 left-4 text-blue-900 text-lg font-poppins font-semibold opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    {{ $item->judul }}
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center text-gray-500 py-12">
                Belum ada galeri laboratorium yang ditampilkan.
            </div>
            @endforelse
        </div>

        <!-- CTA Section -->
        <div class="text-center scroll-animate" data-animation="fade-down" data-delay="700">
            <div class="bg-gradient-to-br from-blue-50 to-yellow-50/50 rounded-3xl p-12 border border-blue-200">
                <h3 class="text-3xl font-bold text-gray-900 mb-4">Tertarik Mengunjungi Laboratorium Kami?</h3>
                <p class="text-gray-600 mb-8 max-w-2xl mx-auto">
                    Jelajahi koleksi alat laboratorium kami atau jadwalkan kunjungan untuk melihat fasilitas kami secara langsung.
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center space-y-4 sm:space-y-0 sm:space-x-6">
                    <a href="/catalog" class="group inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-600 to-blue-800 hover:from-blue-700 hover:to-blue-900 text-white font-semibold rounded-2xl transition-all duration-300 shadow-lg hover:shadow-blue-600/25 hover:shadow-2xl transform hover:-translate-y-1">
                        <i class="fas fa-book mr-3"></i>
                        Lihat Katalog Alat
                        <i class="fas fa-arrow-right ml-3 group-hover:translate-x-1 transition-transform duration-300"></i>
                    </a>
                    <a href="/visit" class="group inline-flex items-center px-8 py-4 bg-white border-2 border-blue-300 text-blue-700 hover:text-blue-800 hover:border-blue-400 font-semibold rounded-2xl transition-all duration-300 hover:shadow-lg">
                        <i class="fas fa-calendar-alt mr-3"></i>
                        Jadwalkan Kunjungan
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* Laboratorium section styles */
#laboratorium {
    background: #ffffff !important;
    position: relative;
    z-index: 10;
}

#laboratorium::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: #ffffff;
    z-index: -1;
}

/* Gradient text effect */
.bg-clip-text {
    -webkit-background-clip: text;
    background-clip: text;
}

/* Smooth transitions */
.transition-all {
    transition-property: all;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
}

/* Custom blur effects */
.blur-3xl {
    filter: blur(64px);
}

/* Card hover glow effect */
.group:hover {
    box-shadow: 0 25px 50px -12px rgba(59, 130, 246, 0.2);
}

/* Button hover effects */
.hover\:shadow-blue-600\/25:hover {
    box-shadow: 0 25px 50px -12px rgba(29, 78, 216, 0.25);
}

/* Typography */
.font-poppins {
    font-family: 'Poppins', sans-serif;
}

/* Consistent spacing */
.space-y-4 > * + * {
    margin-top: 1rem;
}

/* Modern card design */
.rounded-3xl {
    border-radius: 1.5rem;
}

/* === ANIMASI LABORATORIUM === */
.scroll-animate {
    opacity: 0;
    transition: all 0.6s ease-out;
}

/* Animasi dari atas */
.scroll-animate[data-animation="fade-down"] {
    transform: translateY(-50px);
}

.scroll-animate[data-animation="fade-down"].animate {
    opacity: 1;
    transform: translateY(0);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const animatedElements = document.querySelectorAll('.scroll-animate');
    const labSection = document.getElementById('laboratorium');
    let lastScrollY = window.scrollY;
    let labSectionTop = labSection.offsetTop - 200;

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            const currentScrollY = window.scrollY;
            const scrollDirection = currentScrollY > lastScrollY ? 'down' : 'up';

            if (entry.isIntersecting) {
                const delay = entry.target.dataset.delay || 0;
                setTimeout(() => {
                    entry.target.classList.add('animate');
                }, delay);
            } else {
                if (scrollDirection === 'up' && currentScrollY < labSectionTop) {
                    entry.target.classList.remove('animate');
                }
            }

            lastScrollY = currentScrollY;
        });
    }, {
        threshold: 0.2,
        rootMargin: '0px 0px -50px 0px'
    });

    animatedElements.forEach(element => {
        observer.observe(element);
    });

    window.addEventListener('resize', () => {
        labSectionTop = labSection.offsetTop - 200;
    });
});
</script>
