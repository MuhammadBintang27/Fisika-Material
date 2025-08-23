@extends('user.layouts.app')

@section('title', $templateData['title'] . ' - Laboratorium Fisika Material dan Energi')

@section('content')
<section class="py-16 bg-gradient-to-b from-gray-50 to-white">
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <!-- Back Button -->
            <div class="flex justify-start mb-6">
                <button onclick="goBack()" 
                        class="bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition-colors flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </button>
            </div>
            
            <h1 class="font-poppins text-3xl font-bold text-gray-900 mb-4">
                {{ $templateData['title'] }}
            </h1>
            <p class="text-gray-600">Preview format surat yang direkomendasikan</p>
        </div>

        <!-- Template Preview -->
        <div class="bg-white shadow-xl rounded-lg p-8 mb-8" style="min-height: 600px;">
            <!-- Header Surat -->
            <div class="text-center border-b-2 border-gray-300 pb-6 mb-6">
                <div class="text-lg font-bold text-gray-800 mb-2">
                    {{ $templateData['content']['header']['kop_surat'] }}
                </div>
                <div class="text-sm text-gray-600">
                    {{ $templateData['content']['header']['alamat'] }}<br>
                    {{ $templateData['content']['header']['telepon'] }}
                </div>
            </div>

            <!-- Alamat Tujuan -->
            <div class="mb-6">
                <div class="float-left">
                    {{ $templateData['content']['tujuan']['kepada'] }}<br>
                    {{ $templateData['content']['tujuan']['nama'] }}<br>
                    {{ $templateData['content']['tujuan']['fakultas'] }}<br>
                    {{ $templateData['content']['tujuan']['alamat'] }}
                </div>
                <div class="clear-both"></div>
            </div>

            <!-- Perihal -->
            <div class="mb-6">
                <strong>Perihal: {{ $templateData['content']['body']['perihal'] }}</strong>
            </div>

            <!-- Isi Surat -->
            <div class="mb-6 text-justify">
                <p class="mb-4">{{ $templateData['content']['body']['pembuka'] }}</p>
                <p class="mb-4">{{ $templateData['content']['body']['isi'] }}</p>
                
                @if($type === 'pengujian')
                <p class="mb-2">Data mahasiswa/staf/peneliti yang dimaksud adalah sebagai berikut:</p>
                @else
                <p class="mb-2">Detail kunjungan adalah sebagai berikut:</p>
                @endif
                
                <div class="ml-6 mb-4">
                    @foreach($templateData['content']['body']['data_fields'] as $index => $field)
                    <div class="mb-1">{{ $index + 1 }}) {{ $field }} : ________________________</div>
                    @endforeach
                    @if($type === 'pengujian')
                    <div class="mb-1">6) Tanggal dimulainya penelitian sampai dengan selesai : ________________________</div>
                    @endif
                </div>

                <p class="mb-4">{{ $templateData['content']['body']['penutup'] }}</p>
            </div>

            <!-- Footer -->
            <div class="mt-12">
                <div class="float-right text-center" style="width: 200px;">
                    <div>{{ $templateData['content']['footer']['tempat_tanggal'] }}</div>
                    <div class="mt-2">{{ $templateData['content']['footer']['jabatan'] }}</div>
                    <div>{{ $templateData['content']['footer']['instansi'] }}</div>
                    <div class="mt-16 border-b border-gray-400"></div>
                    <div class="mt-2 text-sm">
                        {!! nl2br($templateData['content']['footer']['ttd']) !!}
                    </div>
                </div>
                <div class="clear-both"></div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('template.download', $type) }}" 
               class="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition-colors flex items-center justify-center">
                <i class="fas fa-download mr-2"></i>Download Template DOC
            </a>
            <a href="{{ route('template.index') }}" 
               class="bg-gray-600 text-white px-8 py-3 rounded-lg hover:bg-gray-700 transition-colors flex items-center justify-center">
                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Template
            </a>
        </div>

        <!-- Catatan -->
        <div class="mt-8 bg-yellow-50 border border-yellow-200 rounded-lg p-6">
            <h4 class="font-semibold text-yellow-900 mb-3 flex items-center">
                <i class="fas fa-lightbulb mr-2"></i>Catatan Penting
            </h4>
            <div class="text-sm text-yellow-800 space-y-2">
                <p>• Template ini hanya sebagai panduan format. Sesuaikan dengan kebijakan institusi Anda.</p>
                <p>• Pastikan semua data diisi dengan lengkap dan benar.</p>
                <p>• Surat harus ditandatangani oleh pejabat yang berwenang.</p>
                <p>• Scan atau foto surat dengan kualitas yang jelas untuk proses upload.</p>
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
        // Jika tidak ada history, arahkan ke halaman template
        window.location.href = '{{ route("template.index") }}';
    }
}
</script>

<style>
@media print {
    .no-print { display: none !important; }
    body { background: white !important; }
    .container { max-width: none !important; }
}
</style>
@endsection
