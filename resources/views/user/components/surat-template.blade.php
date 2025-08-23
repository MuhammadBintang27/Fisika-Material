@extends('user.layouts.app')

@section('title', 'Template Surat Pengajuan - Laboratorium Fisika Material dan Energi')

@section('content')
<section class="py-16 bg-gradient-to-b from-gray-50 to-white">
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <!-- Back Button -->
            <div class="flex justify-start mb-6">
                <button onclick="goBack()" 
                        class="bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition-colors flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </button>
            </div>
            
            <h1 class="font-poppins text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                Template <span class="bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent">Surat Pengajuan</span>
            </h1>
            <p class="text-gray-600 text-lg max-w-2xl mx-auto">
                Unduh dan gunakan template surat resmi untuk pengajuan layanan laboratorium
            </p>
        </div>

        <!-- Template Options -->
        <div class="grid md:grid-cols-2 gap-8 mb-12">
            <!-- Template Pengujian -->
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200">
                <div class="text-center mb-6">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-flask text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Template Pengujian</h3>
                    <p class="text-gray-600">Format surat untuk layanan pengujian material</p>
                </div>
                <div class="space-y-4">
                    <a href="{{ route('template.download', 'pengujian') }}" 
                       class="w-full bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors flex items-center justify-center">
                        <i class="fas fa-download mr-2"></i>Download DOC
                    </a>
                    <a href="{{ route('template.preview', 'pengujian') }}" 
                       class="w-full bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition-colors flex items-center justify-center">
                        <i class="fas fa-eye mr-2"></i>Preview Template
                    </a>
                </div>
            </div>

            <!-- Template Kunjungan -->
            <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200">
                <div class="text-center mb-6">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-handshake text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Template Kunjungan</h3>
                    <p class="text-gray-600">Format surat untuk kunjungan laboratorium</p>
                </div>
                <div class="space-y-4">
                    <a href="{{ route('template.download', 'kunjungan') }}" 
                       class="w-full bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition-colors flex items-center justify-center">
                        <i class="fas fa-download mr-2"></i>Download DOC
                    </a>
                    <a href="{{ route('template.preview', 'kunjungan') }}" 
                       class="w-full bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition-colors flex items-center justify-center">
                        <i class="fas fa-eye mr-2"></i>Preview Template
                    </a>
                </div>
            </div>
        </div>

        <!-- Panduan Penggunaan -->
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 mb-8">
            <h4 class="font-semibold text-blue-900 mb-4 flex items-center">
                <i class="fas fa-info-circle mr-2"></i>Panduan Penggunaan Template
            </h4>
            <div class="space-y-3 text-sm text-blue-800">
                <div class="flex items-start space-x-3">
                    <span class="bg-blue-600 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold">1</span>
                    <p>Unduh template sesuai dengan jenis layanan yang dibutuhkan</p>
                </div>
                <div class="flex items-start space-x-3">
                    <span class="bg-blue-600 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold">2</span>
                    <p>Isi data yang diperlukan sesuai dengan format yang telah disediakan</p>
                </div>
                <div class="flex items-start space-x-3">
                    <span class="bg-blue-600 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold">3</span>
                    <p>Pastikan surat ditandatangani oleh pihak yang berwenang</p>
                </div>
                <div class="flex items-start space-x-3">
                    <span class="bg-blue-600 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold">4</span>
                    <p>Scan atau foto surat dalam format PDF/JPG dengan kualitas yang jelas</p>
                </div>
                <div class="flex items-start space-x-3">
                    <span class="bg-blue-600 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold">5</span>
                    <p>Upload surat melalui formulir pengajuan online</p>
                </div>
            </div>
        </div>

        <!-- Requirements -->
        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6">
            <h4 class="font-semibold text-yellow-900 mb-4 flex items-center">
                <i class="fas fa-exclamation-triangle mr-2"></i>Persyaratan Surat Pengajuan
            </h4>
            <div class="grid md:grid-cols-2 gap-6 text-sm text-yellow-800">
                <div>
                    <h5 class="font-semibold mb-2">Format File:</h5>
                    <ul class="space-y-1">
                        <li>• PDF, JPG, atau PNG</li>
                        <li>• Maksimal ukuran 2MB</li>
                        <li>• Resolusi minimal 300 DPI</li>
                        <li>• File harus jelas dan dapat dibaca</li>
                    </ul>
                </div>
                <div>
                    <h5 class="font-semibold mb-2">Konten Surat:</h5>
                    <ul class="space-y-1">
                        <li>• Kop surat resmi institusi</li>
                        <li>• Tujuan surat ke Departemen Fisika</li>
                        <li>• Data pemohon lengkap</li>
                        <li>• Rencana penelitian/kunjungan</li>
                        <li>• Tanda tangan pejabat berwenang</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
function goBack() {
    // Cek apakah ada history sebelumnya
    if (window.history.length > 1) {
        window.history.back();
    } else {
        // Jika tidak ada history, arahkan ke halaman utama
        window.location.href = '{{ route("home") }}';
    }
}
</script>
@endsection
