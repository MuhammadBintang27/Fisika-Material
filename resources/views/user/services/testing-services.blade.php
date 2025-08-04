@extends('user.layouts.app')

@section('title', 'Layanan Pengujian Laboratorium')

@section('content')
<!-- Hero Section -->
<section class="relative min-h-[60vh] flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('/images/hero.jpg') }}"
             alt="Layanan Pengujian"
             class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-700/90 via-blue-800/80 to-blue-900/70"></div>
    </div>
    <div class="relative z-20 mx-6 px-4 sm:px-6 lg:px-8 text-center max-w-4xl">
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
            <h1 class="font-poppins text-5xl md:text-7xl font-bold leading-tight mb-6">
                <span class="text-white">Layanan</span>
                <span class="bg-gradient-to-r from-yellow-400 to-orange-400 bg-clip-text text-transparent drop-shadow-lg"> Pengujian</span>
            </h1>
            <p class="text-xl md:text-2xl text-blue-100 max-w-3xl mx-auto leading-relaxed">
                Pengujian laboratorium modern untuk mendukung penelitian, praktikum, dan kebutuhan industri Anda
            </p>
        </div>
    </div>
</section>

<!-- Section Daftar Pengujian -->
<section class="py-24 bg-gradient-to-b from-gray-50 to-white">
    <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 scroll-animate" data-animation="fade-down">
            <div class="inline-flex items-center px-6 py-3 bg-blue-50 border border-blue-200 rounded-full text-blue-700 text-sm font-semibold mb-6 shadow-sm">
                <i class="fas fa-vial mr-2"></i>
                Daftar Jenis Pengujian
            </div>
            <h2 class="font-poppins text-4xl md:text-6xl font-bold text-gray-900 mb-6">
                Jenis <span class="bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent">Pengujian</span>
            </h2>
            <p class="text-gray-600 text-lg md:text-xl max-w-3xl mx-auto leading-relaxed">
                Pilih layanan pengujian yang sesuai dengan kebutuhan Anda. Semua pengujian dilakukan oleh tenaga ahli dan peralatan terstandar.
            </p>
        </div>
        <div class="overflow-x-auto mb-12 scroll-animate" data-animation="fade-up" data-delay="200">
            <table class="min-w-full bg-white rounded-2xl shadow-lg overflow-hidden">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jenis Pengujian</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga/Sampel</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jenisPengujian as $item)
                    <tr class="border-b">
                        <td class="px-6 py-4">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4">{{ $item->namaPengujian }}</td>
                        <td class="px-6 py-4">Rp {{ number_format($item->hargaPerSampel,0,',','.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-center text-gray-500">Belum ada jenis pengujian tersedia.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-lg p-10 mt-12 scroll-animate" data-animation="fade-up" data-delay="400">
            <h2 class="text-2xl font-semibold mb-6 text-center">Form Booking Pengujian</h2>
            <form action="{{ route('pengujian.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Nama Penguji / Instansi *</label>
                        <input type="text" name="namaPenguji" required class="w-full px-4 py-3 border border-gray-200 rounded-xl">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">No HP *</label>
                        <input type="text" name="noHpPenguji" required class="w-full px-4 py-3 border border-gray-200 rounded-xl">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-gray-700 font-semibold mb-2">Deskripsi / Keterangan *</label>
                        <textarea name="deskripsi" rows="3" required class="w-full px-4 py-3 border border-gray-200 rounded-xl"></textarea>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Tanggal Pengujian *</label>
                        <input type="date" name="tanggalPengujian" required class="w-full px-4 py-3 border border-gray-200 rounded-xl">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Pilih Jenis Pengujian *</label>
                        <select name="jenisPengujianIds[]" multiple required class="w-full px-4 py-3 border border-gray-200 rounded-xl">
                            @foreach($jenisPengujian as $item)
                            <option value="{{ $item->id }}">{{ $item->namaPengujian }} (Rp {{ number_format($item->hargaPerSampel,0,',','.') }})</option>
                            @endforeach
                        </select>
                        <small class="text-gray-500">Tekan Ctrl (atau Cmd) untuk memilih lebih dari satu.</small>
                    </div>
                </div>
                <div class="flex justify-end mt-8">
                    <button type="submit" class="px-8 py-3 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 transition">Kirim Permohonan</button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
