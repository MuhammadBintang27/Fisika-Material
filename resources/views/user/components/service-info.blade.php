<!-- Info Section -->
<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="mt-16 bg-gradient-to-r from-blue-600 to-blue-800 rounded-2xl p-8 text-white">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
            <div>
                <h3 class="text-2xl font-bold mb-4">Butuh Bantuan?</h3>
                <p class="text-blue-100 mb-6 leading-relaxed">
                    Tim ahli kami siap membantu Anda memilih layanan yang tepat untuk kebutuhan penelitian Anda.
                </p>
                <div class="space-y-3">
                    <div class="flex items-center">
                        <i class="fab fa-whatsapp w-5 h-5 mr-3"></i>
                        <a href="https://wa.me/{{ config('app.admin_whatsapp') }}" target="_blank" class="hover:text-yellow-300 transition-colors duration-200">
                            +{{ config('app.admin_whatsapp') }}
                        </a>
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
</div>
