{{-- resources/views/components/navbar.blade.php --}}
<nav class="fixed top-0 left-0 right-0 z-50 bg-transparent transition-all duration-300" id="navbar">
    <div class="mx-6 px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo Section -->
            <div class="flex items-center">
                <div class="flex items-center space-x-3">
                    <!-- Logo dengan 2 versi -->
                    <div class="w-20 h-10 relative">
                        <!-- Logo putih (default) -->
                        <img src="{{ asset('images/logo-fisika-putih.png') }}"
                             alt="Logo Fisika"
                             class="w-full h-full object-contain transition-opacity duration-300"
                             id="logo-white" />
                        <!-- Logo hitam (ketika scroll) -->
                        <img src="{{ asset('images/logo-fisika-hitam.png') }}"
                             alt="Logo Fisika"
                             class="w-full h-full object-contain absolute top-0 left-0 opacity-0 transition-opacity duration-300"
                             id="logo-dark" />
                    </div>
                </div>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:block">
                <div class="flex items-center space-x-8">
                    <a href="{{ route('home') }}#visi-misi" class="nav-link text-white hover:text-yellow-400 font-medium transition-colors duration-200">Beranda</a>
                    <a href="{{ route('staff') }}" class="nav-link text-white hover:text-yellow-400 font-medium transition-colors duration-200">Staf dan Tenaga Ahli</a>
                    <a href="{{ route('articles.index') }}" class="nav-link text-white hover:text-yellow-400 font-medium transition-colors duration-200">Artikel</a>

                    <!-- Layanan Dropdown - Simple -->
                    <div class="relative group">
                        <button class="nav-link text-white hover:text-yellow-400 font-medium transition-colors duration-200 flex items-center">
                            Layanan
                            <i class="fas fa-chevron-down ml-1 text-sm"></i>
                        </button>

                        <!-- Simple Dropdown Menu -->
                        <div class="absolute top-full left-0 w-48 bg-white rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 mt-2">
                            <div class="py-2">
                                <a href="{{ route('equipment.loan') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 transition-colors duration-200">
                                    Peminjaman Alat
                                </a>
                                <a href="{{ route('tracking') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 transition-colors duration-200">
                                    Tracking Pengajuan
                                </a>
                                <a href="{{ route('testing.services') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 transition-colors duration-200">
                                    Layanan Pengujian
                                </a>
                                <a href="{{ route('user.kunjungan.form') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 transition-colors duration-200">
                                    Kunjungan Laboratorium
                                </a>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('facilities') }}" class="nav-link text-white hover:text-yellow-400 font-medium transition-colors duration-200">Fasilitas</a>

                </div>
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button type="button"
                        class="mobile-menu-button text-gray-900 hover:text-blue-600 focus:outline-none transition-colors duration-200"
                        onclick="toggleMobileMenu()"
                        aria-controls="mobile-menu"
                        aria-expanded="false">
                    <svg class="h-6 w-6 hamburger-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg class="h-6 w-6 close-icon hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div class="md:hidden hidden" id="mobile-menu">
        <div class="px-2 pt-2 pb-3 space-y-1 mobile-menu-bg bg-white backdrop-blur-md shadow-lg">
            <a href="{{ route('home') }}#visi-misi" class="mobile-nav-link block px-3 py-2 text-gray-900 hover:text-blue-600 font-medium">Beranda</a>
            <a href="{{ route('staff') }}" class="mobile-nav-link block px-3 py-2 text-gray-900 hover:text-blue-600 font-medium">Staf dan Tenaga Ahli</a>
            <a href="{{ route('articles.index') }}" class="mobile-nav-link block px-3 py-2 text-gray-900 hover:text-blue-600 font-medium">Artikel</a>

            <!-- Mobile Layanan - Simple -->
            <div class="mobile-dropdown">
                <button onclick="toggleMobileDropdown()" class="mobile-dropdown-btn w-full text-left px-3 py-2 text-gray-900 hover:text-blue-600 font-medium flex items-center justify-between">
                    Layanan
                    <i class="fas fa-chevron-down text-sm"></i>
                </button>
                <div class="mobile-dropdown-content hidden pl-6 space-y-1">
                    <a href="{{ route('equipment.loan') }}" class="mobile-nav-link block px-3 py-2 text-gray-700 hover:text-blue-600">
                        Peminjaman Alat
                    </a>
                    <a href="{{ route('tracking') }}" class="mobile-nav-link block px-3 py-2 text-gray-700 hover:text-blue-600">
                        Tracking Pengajuan
                    </a>
                    <a href="{{ route('testing.services') }}" class="mobile-nav-link block px-3 py-2 text-gray-700 hover:text-blue-600">
                        Layanan Pengujian
                    </a>
                    <a href="{{ route('user.kunjungan.form') }}" class="mobile-nav-link block px-3 py-2 text-gray-700 hover:text-blue-600">
                        Kunjungan Laboratorium
                    </a>
                </div>
            </div>
            <a href="{{ route('facilities') }}" class="mobile-nav-link block px-3 py-2 text-gray-900 hover:text-blue-600 font-medium">Fasilitas</a>

        </div>
    </div>
</nav>

<style>
/* Navbar styling on scroll */
.navbar-scrolled {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
}

/* Navbar text colors when scrolled */
.navbar-scrolled .nav-link {
    color: #1f2937 !important;
}

.navbar-scrolled .nav-link:hover {
    color: #3b82f6 !important;
}

/* Mobile button selalu hitam */
.mobile-menu-button {
    color: #1f2937 !important;
}

.mobile-menu-button:hover {
    color: #3b82f6 !important;
}

/* Mobile menu background selalu putih */
.mobile-menu-bg {
    background: rgba(255, 255, 255, 0.98) !important;
    backdrop-filter: blur(10px);
}

/* Mobile nav links selalu hitam */
.mobile-nav-link {
    color: #1f2937 !important;
}

.mobile-nav-link:hover {
    color: #3b82f6 !important;
}

/* Simple dropdown styling */
.navbar-scrolled .group:hover > div {
    background: rgba(255, 255, 255, 0.98);
}

/* Active page indicator */
.nav-link.active {
    color: #fbbf24 !important;
    font-weight: 600;
}

.navbar-scrolled .nav-link.active {
    color: #3b82f6 !important;
}

/* Mobile dropdown simple styling */
.mobile-dropdown-content.show {
    display: block !important;
}
</style>

<script>
// Global function untuk mobile menu toggle (agar onclick bisa akses)
function toggleMobileMenu() {
    const mobileMenu = document.getElementById('mobile-menu');
    const hamburgerIcon = document.querySelector('.hamburger-icon');
    const closeIcon = document.querySelector('.close-icon');
    
    if (mobileMenu) {
        mobileMenu.classList.toggle('hidden');
        
        // Toggle icon
        if (hamburgerIcon && closeIcon) {
            hamburgerIcon.classList.toggle('hidden');
            closeIcon.classList.toggle('hidden');
        }
    }
}

function toggleMobileDropdown() {
    const mobileDropdownContent = document.querySelector('.mobile-dropdown-content');
    if (mobileDropdownContent) {
        mobileDropdownContent.classList.toggle('hidden');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Mobile menu toggle (backup jika onclick tidak jalan)
    const mobileMenuButton = document.querySelector('.mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');

    if (mobileMenuButton) {
        mobileMenuButton.addEventListener('click', function(e) {
            e.preventDefault();
            toggleMobileMenu();
        });
    }

    // Simple mobile dropdown
    const mobileDropdownBtn = document.querySelector('.mobile-dropdown-btn');
    const mobileDropdownContent = document.querySelector('.mobile-dropdown-content');

    if (mobileDropdownBtn && mobileDropdownContent) {
        mobileDropdownBtn.addEventListener('click', function(e) {
            e.preventDefault();
            toggleMobileDropdown();
        });
    }

    // Navbar scroll effect
    function handleNavbarScroll() {
        const navbar = document.getElementById('navbar');
        const logoWhite = document.getElementById('logo-white');
        const logoDark = document.getElementById('logo-dark');

        if (window.scrollY > 50) {
            navbar.classList.add('navbar-scrolled');
            if (logoWhite && logoDark) {
                logoWhite.style.opacity = '0';
                logoDark.style.opacity = '1';
            }
        } else {
            navbar.classList.remove('navbar-scrolled');
            if (logoWhite && logoDark) {
                logoWhite.style.opacity = '1';
                logoDark.style.opacity = '0';
            }
        }
    }

    handleNavbarScroll();
    window.addEventListener('scroll', handleNavbarScroll);

    // Close mobile menu when clicking outside
    document.addEventListener('click', function(event) {
        const isClickInsideNav = mobileMenu.contains(event.target) || mobileMenuButton.contains(event.target);

        if (!isClickInsideNav && !mobileMenu.classList.contains('hidden')) {
            mobileMenu.classList.add('hidden');
        }
    });

    // Highlight active menu based on current page
    function highlightActiveMenu() {
        const currentPath = window.location.pathname;
        const navLinks = document.querySelectorAll('.nav-link');
        const mobileNavLinks = document.querySelectorAll('.mobile-nav-link');

        // Remove active class from all links
        [...navLinks, ...mobileNavLinks].forEach(link => {
            link.classList.remove('active');
        });

        // Add active class to current page link
        [...navLinks, ...mobileNavLinks].forEach(link => {
            const href = link.getAttribute('href');
            if (href && (currentPath === href || currentPath.startsWith(href + '/'))) {
                link.classList.add('active');
            }
        });
    }

    // Highlight active menu on page load
    highlightActiveMenu();
});
</script>
