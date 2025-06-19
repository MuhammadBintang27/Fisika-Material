document.addEventListener("DOMContentLoaded", function () {
    const navbar = document.getElementById("navbar");
    const mobileMenuButton = document.querySelector(".mobile-menu-button");
    const mobileMenu = document.getElementById("mobile-menu");
    const logoWhite = document.getElementById("logo-white");
    const logoDark = document.getElementById("logo-dark");

    // ===== TAMBAHAN BARU: Daftar halaman yang navbar harus langsung "scrolled" =====
    const pagesWithScrolledNavbar = [
        '/staff',
        '/articles',
        '/facilities',
        '/services/testing-services',
        // Tambahkan path halaman lain sesuai kebutuhan
    ];

    // Fungsi untuk mengecek apakah halaman saat ini perlu navbar scrolled
    function shouldNavbarBeScrolled() {
        const currentPath = window.location.pathname;

        // Cek halaman dengan exact match
        if (pagesWithScrolledNavbar.includes(currentPath)) {
            return true;
        }

        // Cek khusus untuk halaman detail equipment-loan (dengan ID)
        // Pattern: /services/equipment-loan/[angka]
        const equipmentDetailPattern = /^\/services\/equipment-loan\/\d+$/;
        if (equipmentDetailPattern.test(currentPath)) {
            return true;
        }

        // Cek khusus untuk halaman detail testing (dengan ID)
        // Pattern: /services/testing/[angka]
        const testingDetailPattern = /^\/services\/testing\/\d+$/;
        if (testingDetailPattern.test(currentPath)) {
            return true;
        }

        return false;
    }

    // Fungsi untuk force navbar ke kondisi scrolled
    function forceNavbarScrolled() {
        navbar.classList.add("navbar-scrolled");
        if (logoWhite && logoDark) {
            logoWhite.style.opacity = "0";
            logoDark.style.opacity = "1";
        }
    }

    // Fungsi untuk reset navbar ke kondisi normal
    function resetNavbar() {
        navbar.classList.remove("navbar-scrolled");
        if (logoWhite && logoDark) {
            logoWhite.style.opacity = "1";
            logoDark.style.opacity = "0";
        }
    }

    // Navbar scroll effect dengan pergantian logo dan warna
    function updateNavbar() {
        // Jika halaman tertentu, paksa navbar scrolled
        if (shouldNavbarBeScrolled()) {
            forceNavbarScrolled();
            return; // Skip scroll check
        }

        // Logic normal untuk scroll
        if (window.scrollY > 50) {
            forceNavbarScrolled();
        } else {
            resetNavbar();
        }
    }
    // ===== AKHIR TAMBAHAN BARU =====

    // Event listener untuk scroll
    window.addEventListener("scroll", updateNavbar);
    // Panggil sekali saat load
    updateNavbar();

    // Mobile menu toggle
    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener("click", function () {
            mobileMenu.classList.toggle("hidden");
        });
    }

    // Mobile dropdown layanan
    const mobileDropdownBtn = document.querySelector(".mobile-dropdown-btn");
    const mobileDropdownContent = document.querySelector(".mobile-dropdown-content");

    if (mobileDropdownBtn && mobileDropdownContent) {
        mobileDropdownBtn.addEventListener("click", function (e) {
            e.preventDefault();
            mobileDropdownContent.classList.toggle("hidden");
        });
    }

    // Smooth scroll untuk anchor links
    document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
        anchor.addEventListener("click", function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute("href"));
            if (target) {
                const navbarHeight = navbar.offsetHeight;
                const targetPosition = target.offsetTop - navbarHeight;

                if (mobileMenu && !mobileMenu.classList.contains("hidden")) {
                    mobileMenu.classList.add("hidden");
                }

                window.scrollTo({
                    top: targetPosition,
                    behavior: "smooth",
                });
            }
        });
    });

    // Tutup mobile menu ketika klik di luar
    document.addEventListener("click", function (e) {
        if (
            mobileMenu &&
            !mobileMenu.contains(e.target) &&
            !mobileMenuButton.contains(e.target)
        ) {
            mobileMenu.classList.add("hidden");
        }
    });

    // Tutup mobile menu ketika resize ke desktop
    window.addEventListener("resize", function () {
        if (window.innerWidth >= 768 && mobileMenu) {
            mobileMenu.classList.add("hidden");
     }
});
});
