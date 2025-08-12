@extends('admin.layouts.app')

@section('title', 'Detail Kunjungan')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="bg-gradient-to-br from-blue-700 to-blue-800 rounded-xl p-8 text-white shadow-xl border border-blue-600">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold mb-2">Detail Kunjungan</h1>
                <p class="text-blue-100 text-lg mb-3">ID Kunjungan: #{{ $kunjungan->id }}</p>
                <div class="flex items-center space-x-4">
                    <!-- Status Badge -->
                    @if($kunjungan->status === 'PENDING')
                        <span class="bg-amber-500 text-white px-4 py-2 rounded-xl text-sm font-semibold flex items-center">
                            <i class="fas fa-clock mr-2"></i>
                            Pending
                        </span>
                    @elseif($kunjungan->status === 'PROCESSING')
                        <span class="bg-blue-500 text-white px-4 py-2 rounded-xl text-sm font-semibold flex items-center">
                            <i class="fas fa-cogs mr-2"></i>
                            Diproses
                        </span>
                    @elseif($kunjungan->status === 'COMPLETED')
                        <span class="bg-green-500 text-white px-4 py-2 rounded-xl text-sm font-semibold flex items-center">
                            <i class="fas fa-check-double mr-2"></i>
                            Selesai
                        </span>
                    @elseif($kunjungan->status === 'CANCELLED')
                        <span class="bg-red-500 text-white px-4 py-2 rounded-xl text-sm font-semibold flex items-center">
                            <i class="fas fa-times mr-2"></i>
                            Dibatalkan
                        </span>
                    @endif
                    
                   
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.kunjungan.index') }}" 
                   class="bg-white/20 backdrop-blur-sm rounded-xl p-4 hover:bg-white/30 transition-all duration-300 shadow-lg hover:shadow-xl group">
                    <i class="fas fa-arrow-left text-xl group-hover:scale-110 transition-transform"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Visit Information -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                            <i class="fas fa-info text-white"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Informasi Kunjungan</h3>
                    </div>
                </div>
                <div class="p-8 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Nama Pengunjung</label>
                            <p class="text-lg font-semibold text-gray-900 bg-gray-50 rounded-lg p-3">{{ $kunjungan->namaPengunjung }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Nama Institusi</label>
                            <p class="text-lg font-semibold text-gray-900 bg-gray-50 rounded-lg p-3">{{ $kunjungan->namaInstansi }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">No. Handphone</label>
                            <p class="text-lg font-semibold text-gray-900 bg-gray-50 rounded-lg p-3">{{ $kunjungan->noHp }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Jumlah Pengunjung</label>
                            <p class="text-lg font-semibold text-gray-900 bg-gray-50 rounded-lg p-3">{{ $kunjungan->jumlahPengunjung }} orang</p>
                        </div>
                        @if($kunjungan->jadwal)
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Tanggal Kunjungan</label>
                            <p class="text-lg font-semibold text-gray-900 bg-gray-50 rounded-lg p-3">{{ \Carbon\Carbon::parse($kunjungan->jadwal->tanggal)->format('d F Y') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Waktu Kunjungan</label>
                            <p class="text-lg font-semibold text-gray-900 bg-gray-50 rounded-lg p-3">{{ \Carbon\Carbon::parse($kunjungan->jadwal->jamMulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($kunjungan->jadwal->jamSelesai)->format('H:i') }}</p>
                        </div>
                        @endif
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Tujuan Kunjungan</label>
                            <p class="text-lg font-semibold text-gray-900 bg-gray-50 rounded-lg p-3">{{ $kunjungan->tujuan }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Surat Pengajuan -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center">
                            <i class="fas fa-file-alt text-white"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Surat Pengajuan</h3>
                    </div>
                </div>
                <div class="p-6">
                    @if($kunjungan->suratPengajuan)
                    <div class="text-center py-8">
                        <div class="mb-4">
                            @php
                                $fileExtension = pathinfo($kunjungan->suratPengajuan, PATHINFO_EXTENSION);
                                $isImage = in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png']);
                            @endphp
                            @if($isImage)
                                <i class="fas fa-image text-6xl text-blue-500"></i>
                            @else
                                <i class="fas fa-file-pdf text-6xl text-red-500"></i>
                            @endif
                        </div>
                        <a href="{{ $kunjungan->surat_pengajuan_url }}" target="_blank" 
                           class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-3 rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 inline-flex items-center">
                            <i class="fas fa-external-link-alt mr-2"></i>
                            Lihat/Download Surat
                        </a>
                    </div>
                    @else
                    <div class="text-center py-8">
                        <div class="mb-4">
                            <i class="fas fa-file-times text-6xl text-gray-400"></i>
                        </div>
                        <p class="text-gray-500 text-lg">Surat pengajuan belum diunggah</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1 space-y-6">
            

            <!-- Actions -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center">
                            <i class="fas fa-cogs text-white"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Aksi Admin</h3>
                    </div>
                </div>
                <div class="p-6 space-y-4">
                    @if($kunjungan->status === 'PENDING')
                        <form action="{{ route('admin.kunjungan.updateStatus', $kunjungan->id) }}" method="POST" id="approveForm" class="w-full">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="APPROVED">
                            <button type="submit" 
                                    class="w-full bg-gradient-to-r from-green-600 to-green-700 text-white px-6 py-3 rounded-xl hover:from-green-700 hover:to-green-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center justify-center">
                                <i class="fas fa-check mr-2"></i>
                                Setujui & WhatsApp
                            </button>
                        </form>
                        <button type="button" onclick="showRejectForm()" 
                                class="w-full bg-gradient-to-r from-red-600 to-red-700 text-white px-6 py-3 rounded-xl hover:from-red-700 hover:to-red-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center justify-center">
                            <i class="fas fa-times mr-2"></i>
                            Tolak
                        </button>
                        <form action="{{ route('admin.kunjungan.updateStatus', $kunjungan->id) }}" method="POST" id="rejectForm" class="hidden w-full">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="CANCELLED">
                            <div class="mb-4">
                                <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Alasan Penolakan</label>
                                <textarea id="notes" name="notes" class="w-full border border-gray-300 rounded-lg p-2" rows="4" placeholder="Masukkan alasan penolakan..."></textarea>
                            </div>
                            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl flex items-center justify-center">
                                <i class="fas fa-times mr-2"></i> Tolak & WhatsApp
                            </button>
                        </form>
                    @elseif($kunjungan->status === 'APPROVED')
                        <form action="{{ route('admin.kunjungan.updateStatus', $kunjungan->id) }}" method="POST" class="w-full">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="COMPLETED">
                            <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-3 rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-300 shadow-lg hover:shadow-xl flex items-center justify-center">
                                <i class="fas fa-check-circle mr-2"></i> Selesaikan & WhatsApp
                            </button>
                        </form>
                    @endif
                    <form action="{{ route('admin.kunjungan.destroy', $kunjungan->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kunjungan ini?')" class="w-full">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full bg-gradient-to-r from-gray-600 to-gray-700 text-white px-6 py-3 rounded-xl hover:from-gray-700 hover:to-gray-800 transition-all duration-300 shadow-lg hover:shadow-xl flex items-center justify-center">
                            <i class="fas fa-trash mr-2"></i> Hapus Kunjungan
                        </button>
                    </form>
                </div>
            </div>

            @if($kunjungan->notes)
            <!-- Catatan -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-yellow-500 rounded-lg flex items-center justify-center">
                            <i class="fas fa-sticky-note text-white"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Catatan</h3>
                    </div>
                </div>
                <div class="p-6">
                    <p class="text-gray-900 bg-yellow-50 rounded-lg p-4 border-l-4 border-yellow-400">{{ $kunjungan->notes }}</p>
                </div>
            </div>
            @endif

            <!-- Informasi Sistem -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gray-500 rounded-lg flex items-center justify-center">
                            <i class="fas fa-info-circle text-white"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Informasi Sistem</h3>
                    </div>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Kode Tracking</label>
                            <p class="text-gray-900 bg-blue-50 rounded-lg p-3 font-mono text-sm border-l-4 border-blue-400">{{ $kunjungan->tracking_code }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Dibuat Pada</label>
                            <p class="text-gray-900 bg-gray-50 rounded-lg p-3">{{ \Carbon\Carbon::parse($kunjungan->created_at)->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Terakhir Diupdate</label>
                            <p class="text-gray-900 bg-gray-50 rounded-lg p-3">{{ \Carbon\Carbon::parse($kunjungan->updated_at)->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function showRejectForm() {
    document.getElementById('rejectForm').classList.remove('hidden');
    document.querySelector('button[onclick="showRejectForm()"]').classList.add('hidden');
}
</script>
@endsection