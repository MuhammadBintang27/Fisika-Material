@extends('admin.layouts.app')

@section('title', 'Detail Kunjungan')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Detail Kunjungan</h2>
                <p class="text-gray-600">Informasi lengkap kunjungan laboratorium</p>
            </div>
            <a href="{{ route('admin.kunjungan.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center" aria-label="Kembali ke Daftar Kunjungan">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Status Kunjungan</h3>
                    <p class="text-gray-600">Status terkini kunjungan</p>
                </div>
                <span class="px-4 py-2 text-sm font-medium rounded-full
                    @if($kunjungan->status === 'PENDING') bg-yellow-100 text-yellow-800
                    @elseif($kunjungan->status === 'PROCESSING') bg-blue-100 text-blue-800
                    @elseif($kunjungan->status === 'COMPLETED') bg-green-100 text-green-800
                    @elseif($kunjungan->status === 'CANCELLED') bg-red-100 text-red-800
                    @else bg-gray-100 text-gray-800
                    @endif">
                    {{ $kunjungan->status }}
                </span>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Kunjungan</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Pengunjung / Instansi</label>
                    <p class="text-gray-900 font-medium">{{ $kunjungan->namaPengunjung }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tujuan Kunjungan</label>
                    <p class="text-gray-900">{{ $kunjungan->tujuan }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah Pengunjung</label>
                    <p class="text-gray-900">{{ $kunjungan->jumlahPengunjung }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Kunjungan</label>
                    <p class="text-gray-900">{{ \Carbon\Carbon::parse($kunjungan->jadwal->tanggal)->format('d/m/Y') }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Waktu Kunjungan</label>
                    <p class="text-gray-900">{{ $kunjungan->jadwal->time_label }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Surat Pengajuan</h3>
            <a href="{{ $kunjungan->surat }}" target="_blank" class="text-blue-600 hover:text-blue-800" aria-label="Lihat atau Download Surat Pengajuan">Lihat/Download Surat</a>
        </div>

        @if($kunjungan->notes)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Catatan</h3>
                <p class="text-gray-900">{{ $kunjungan->notes }}</p>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Sistem</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Dibuat Pada</label>
                    <p class="text-gray-900">{{ \Carbon\Carbon::parse($kunjungan->created_at)->format('d/m/Y H:i') }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Terakhir Diupdate</label>
                    <p class="text-gray-900">{{ \Carbon\Carbon::parse($kunjungan->updated_at)->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>

        <div class="flex justify-end space-x-4">
            @if($kunjungan->status === 'PENDING')
                <form action="{{ route('admin.kunjungan.updateStatus', $kunjungan->id) }}" method="POST" id="approveForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="PROCESSING">
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg flex items-center" aria-label="Setujui Kunjungan">
                        <i class="fas fa-check mr-2"></i> Setujui & WhatsApp
                    </button>
                </form>
                <button type="button" onclick="showRejectForm()" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg flex items-center" aria-label="Tolak Kunjungan">
                    <i class="fas fa-times mr-2"></i> Tolak
                </button>
                <form action="{{ route('admin.kunjungan.updateStatus', $kunjungan->id) }}" method="POST" id="rejectForm" class="hidden">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="CANCELLED">
                    <div class="mb-4">
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Alasan Penolakan</label>
                        <textarea id="notes" name="notes" class="w-full border border-gray-300 rounded-lg p-2" rows="4" placeholder="Masukkan alasan penolakan..."></textarea>
                    </div>
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg flex items-center" aria-label="Tolak Kunjungan">
                        <i class="fas fa-times mr-2"></i> Tolak & WhatsApp
                    </button>
                </form>
            @elseif($kunjungan->status === 'PROCESSING')
                <form action="{{ route('admin.kunjungan.updateStatus', $kunjungan->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="COMPLETED">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg flex items-center" aria-label="Selesaikan Kunjungan">
                        <i class="fas fa-check-circle mr-2"></i> Selesaikan & WhatsApp
                    </button>
                </form>
            @endif
            <form action="{{ route('admin.kunjungan.destroy', $kunjungan->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kunjungan ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg flex items-center" aria-label="Hapus Kunjungan">
                    <i class="fas fa-trash mr-2"></i> Hapus Kunjungan
                </button>
            </form>
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