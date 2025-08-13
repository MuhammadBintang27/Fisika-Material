{{-- resources/views/components/articles.blade.php --}}
<section id="articles" class="py-24 bg-white relative">
    <!-- Decorative Elements -->
    <div class="absolute top-20 left-10 w-32 h-32 bg-yellow-100 rounded-full opacity-20 blur-3xl"></div>
    <div class="absolute bottom-20 right-10 w-40 h-40 bg-yellow-200 rounded-full opacity-20 blur-3xl"></div>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Section Header -->
        <div class="text-center mb-20 articles-animate" data-animation="fade-down">
            <div class="inline-flex items-center px-6 py-3 bg-yellow-50 border border-yellow-200 rounded-full text-yellow-700 text-sm font-medium mb-8 shadow-lg">
                <i class="fas fa-newspaper mr-2 text-yellow-600"></i>
                Artikel & Berita
            </div>
            <h2 class="font-poppins text-4xl md:text-6xl font-bold text-gray-900 mb-6">
                Artikel <span class="bg-gradient-to-r from-yellow-400 to-yellow-600 bg-clip-text text-transparent">Terbaru</span>
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                Berita terkini, penelitian, dan perkembangan di Laboratorium Fisika Dasar
            </p>
            <div class="mt-8 w-24 h-1 bg-gradient-to-r from-yellow-400 to-yellow-500 mx-auto rounded-full"></div>
        </div>

        <!-- Articles Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
            @foreach($featuredArticles as $index => $article)
            <!-- Article {{ $index + 1 }} -->
            <article class="group bg-white rounded-3xl overflow-hidden border border-yellow-200 hover:border-yellow-300 transition-all duration-500 hover:shadow-2xl hover:-translate-y-2 articles-animate" data-animation="fade-up" data-delay="{{ ($index + 1) * 100 }}">
                <div class="relative overflow-hidden">
                    @if($article->gambar && $article->gambar->first())
                        <img src="{{ url('storage/' . $article->gambar->first()->url) }}"
                             alt="{{ $article->namaAcara }}"
                             class="w-full h-48 object-cover transition-transform duration-500 group-hover:scale-105">
                    @else
                        <div class="w-full h-48 flex items-center justify-center bg-yellow-50 text-yellow-400">
                            <i class="fas fa-image text-4xl mb-2"></i>
                            <span class="text-sm">Tidak ada gambar</span>
                        </div>
                    @endif
                </div>
                <div class="p-6">
                    <div class="flex items-center text-sm text-gray-500 mb-3">
                        <i class="fas fa-calendar mr-2 text-yellow-600"></i>
                        <span>{{ date('d M Y', strtotime($article->tanggalAcara)) }}</span>
                        <i class="fas fa-user ml-4 mr-2 text-yellow-600"></i>
                        <span>{{ $article->penulis ?? '-' }}</span>
                    </div>
                    <h3 class="font-poppins text-xl font-bold text-gray-900 mb-3 group-hover:text-yellow-700 transition-colors duration-300">
                        {{ $article->namaAcara }}
                    </h3>
                    <p class="text-gray-600 leading-relaxed mb-4">
                        {{ Str::limit(strip_tags($article->deskripsi), 100) }}
                    </p>
                    <a href="{{ route('articles.show', $article->id) }}" class="inline-flex items-center text-yellow-700 font-medium hover:text-yellow-800 transition-colors duration-200">
                        Baca Selengkapnya
                        <i class="fas fa-arrow-right ml-2 text-sm group-hover:translate-x-1 transition-transform duration-200"></i>
                    </a>
                </div>
            </article>
            @endforeach
        </div>

        <!-- View All Articles Button -->
        <div class="text-center articles-animate" data-animation="fade-up" data-delay="400">
            <a href="{{ route('articles.index') }}" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-yellow-400 to-yellow-600 text-white font-medium rounded-full hover:from-yellow-500 hover:to-yellow-700 transform hover:-translate-y-1 transition-all duration-300 shadow-lg hover:shadow-yellow-500/25">
                <i class="fas fa-newspaper mr-2"></i>
                Lihat Semua Artikel
                <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>
</section>

<style>
/* Articles section styling */
#articles {
    background-color: #ffffff !important;
    position: relative;
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

/* Article card hover effects */
.group:hover {
    box-shadow: 0 25px 50px -12px rgba(253, 224, 71, 0.15); /* kuning */
}

/* Button hover effects */
.hover\:shadow-yellow-500\/25:hover {
    box-shadow: 0 25px 50px -12px rgba(253, 224, 71, 0.25);
}

/* Typography */
.font-poppins {
    font-family: 'Poppins', sans-serif;
}

/* Modern card design */
.rounded-3xl {
    border-radius: 1.5rem;
}

/* === ANIMASI ARTICLES === */
.articles-animate {
    opacity: 0;
    transition: all 0.6s ease-out;
}

/* Animasi dari atas */
.articles-animate[data-animation="fade-down"] {
    transform: translateY(-60px);
}

.articles-animate[data-animation="fade-down"].animate {
    opacity: 1;
    transform: translateY(0);
}

/* Animasi dari bawah */
.articles-animate[data-animation="fade-up"] {
    transform: translateY(60px);
}

.articles-animate[data-animation="fade-up"].animate {
    opacity: 1;
    transform: translateY(0);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const articlesElements = document.querySelectorAll('.articles-animate');
    const articlesSection = document.getElementById('articles');
    let lastScrollY = window.scrollY;
    let articlesSectionTop = articlesSection.offsetTop - 200;

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            const currentScrollY = window.scrollY;
            const scrollDirection = currentScrollY > lastScrollY ? 'down' : 'up';

            if (entry.isIntersecting) {
                // Animasi dengan delay berdasarkan data-delay
                const delay = entry.target.dataset.delay || 0;
                setTimeout(() => {
                    entry.target.classList.add('animate');
                }, delay);
            } else {
                // Reset animasi hanya jika scroll ke atas dan berada di atas section
                if (scrollDirection === 'up' && currentScrollY < articlesSectionTop) {
                    entry.target.classList.remove('animate');
                }
            }

            lastScrollY = currentScrollY;
        });
    }, {
        threshold: 0.1,
        rootMargin: '0px 0px -100px 0px'
    });

    articlesElements.forEach(element => {
        observer.observe(element);
    });

    // Update posisi section saat window resize
    window.addEventListener('resize', () => {
        articlesSectionTop = articlesSection.offsetTop - 200;
    });
});
</script>
