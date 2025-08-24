<footer class="bg-[#212529] text-white">
    <div class=" mx-6 px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Company Info -->
            <div class="lg:col-span-1">
                <div class="flex items-center space-x-2 mb-6">
                    <img src="{{ asset('images/logo-fisika-putih.png') }}"
                             alt="Logo Fisika"
                             class="w-24 object-contain transition-opacity duration-300"
                             id="logo-white" />
                    <h5 class="font-poppins text-xl font-bold">Lab Fisika Material dan Energi</h5>
                </div>
                <p class="font-jakarta text-gray-300 mb-6 leading-relaxed">
                    Laboratorium Material dan Energi adalah fasilitas penelitian yang mengkhususkan diri dalam pengembangan material maju dan teknologi energi berkelanjutan.
                </p>
                
            </div>

            <!-- Menu Links -->
            <div>
                <h6 class="font-poppins text-lg font-semibold mb-6">Menu</h6>
                <ul class="space-y-3">
                    <li><a href="{{ route('home') }}" class="font-jakarta text-gray-300 hover:text-white transition-colors duration-200">Beranda</a></li>
                    <li><a href="{{ route('staff') }}" class="font-jakarta text-gray-300 hover:text-white transition-colors duration-200">Staff</a></li>
                    <li><a href="{{ route('articles.index') }}" class="font-jakarta text-gray-300 hover:text-white transition-colors duration-200">Artikel</a></li>
                    <li><a href="{{ route('facilities') }}" class="font-jakarta text-gray-300 hover:text-white transition-colors duration-200">Fasilitas</a></li>
                </ul>
            </div>

            <!-- Services -->
            <div>
                <h6 class="font-poppins text-lg font-semibold mb-6">Layanan</h6>
                <ul class="space-y-3">
                    <li><a href="{{ route('equipment.loan') }}" class="font-jakarta text-gray-300 hover:text-white transition-colors duration-200">Peminjaman Alat</a></li>
                    <li><a href="{{ route('testing.services') }}" class="font-jakarta text-gray-300 hover:text-white transition-colors duration-200">Pengujian Material</a></li>
                    <li><a href="{{ route('user.kunjungan.form') }}" class="font-jakarta text-gray-300 hover:text-white transition-colors duration-200">Kunjungan Lab</a></li>
                </ul>
            </div>

            <!-- Contact -->
            <div>
                <h6 class="font-poppins text-lg font-semibold mb-6">Kontak</h6>
                <ul class="space-y-4">
                    <li class="flex items-start space-x-3">
                        <i class="fas fa-map-marker-alt text-[#0d6efd] mt-1"></i>
                        <span class="font-jakarta text-gray-300">Laboratorium Fisika Material dan Energi<br>Departemen Fisika, FMIPA<br>Universitas Syiah Kuala<br>Banda Aceh, Aceh</span>
                    </li>
                    
                    <li class="flex items-center space-x-3">
                        <i class="fab fa-whatsapp text-[#0d6efd]"></i>
                        <a href="https://wa.me/{{ config('app.admin_whatsapp') }}" target="_blank" class="font-jakarta text-gray-300 hover:text-white transition-colors duration-200">
                            +{{ config('app.admin_whatsapp') }}
                        </a>
                    </li>
                    <li class="flex items-center space-x-3">
                        <i class="fas fa-envelope text-[#0d6efd]"></i>
                        <span class="font-jakarta text-gray-300">fisika@unsyiah.ac.id</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="border-t border-gray-700 mt-12 pt-8 flex flex-col md:flex-row justify-center items-center">
            <p class="font-jakarta text-gray-400 mb-4 md:mb-0 ">
                &copy; {{ date('Y') }} Laboratorium Fisika Material dan Energi - Universitas Syiah Kuala. All rights reserved.
            </p>
            {{-- <div class="flex space-x-6">
                <a href="#" class="font-jakarta text-gray-400 hover:text-white transition-colors duration-200">Privacy Policy</a>
                <a href="#" class="font-jakarta text-gray-400 hover:text-white transition-colors duration-200">Terms of Service</a>
            </div> --}}
        </div>
    </div>
</footer>
