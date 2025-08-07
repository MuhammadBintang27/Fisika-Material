@extends('admin.layouts.app')

@section('title', 'Detail Peminjaman')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Detail Peminjaman</h1>
                <p class="text-gray-600">Informasi lengkap peminjaman alat</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('tracking') }}?nama={{ urlencode($loan->namaPeminjam) }}&nip_nim={{ urlencode($loan->nip_nim) }}" 
                   target="_blank"
                   class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-external-link-alt mr-2"></i>
                    Lihat di User
                </a>
                <a href="{{ route('admin.loans.index') }}" 
                   class="text-gray-600 hover:text-gray-900">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali ke Daftar
                </a>
            </div>
        </div>

        <!-- Loan Information -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="p-6 sm:p-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Borrower Information -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Peminjam</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                                <span class="px-3 py-1 text-sm font-medium rounded-full
                                    @if($loan->user_type === 'dosen') bg-blue-100 text-blue-800
                                    @elseif($loan->user_type === 'mahasiswa') bg-green-100 text-green-800
                                    @else bg-purple-100 text-purple-800
                                    @endif">
                                    {{ $loan->user_type_label }}
                                </span>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Peminjam</label>
                                <p class="text-sm text-gray-900 bg-gray-50 px-3 py-2 rounded-lg">{{ $loan->namaPeminjam }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">NIP/NIM</label>
                                <p class="text-sm text-gray-900 bg-gray-50 px-3 py-2 rounded-lg">{{ $loan->nip_nim ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nomor HP</label>
                                <p class="text-sm text-gray-900 bg-gray-50 px-3 py-2 rounded-lg">{{ $loan->noHp }}</p>
                            </div>
                            @if($loan->email)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                    <p class="text-sm text-gray-900 bg-gray-50 px-3 py-2 rounded-lg">{{ $loan->email }}</p>
                                </div>
                            @endif
                            @if($loan->instansi)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Instansi</label>
                                    <p class="text-sm text-gray-900 bg-gray-50 px-3 py-2 rounded-lg">{{ $loan->instansi }}</p>
                                </div>
                            @endif
                            @if($loan->jabatan)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Jabatan</label>
                                    <p class="text-sm text-gray-900 bg-gray-50 px-3 py-2 rounded-lg">{{ $loan->jabatan }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Research Information -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Penelitian</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Judul Penelitian</label>
                                <p class="text-sm text-gray-900 bg-gray-50 px-3 py-2 rounded-lg">{{ $loan->judul_penelitian ?? 'N/A' }}</p>
                            </div>
                            @if($loan->deskripsi_penelitian)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Penelitian</label>
                                    <p class="text-sm text-gray-900 bg-gray-50 px-3 py-2 rounded-lg">{{ $loan->deskripsi_penelitian }}</p>
                                </div>
                            @endif
                            @if($loan->supervisor_name)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Dosen Pembimbing</label>
                                    <p class="text-sm text-gray-900 bg-gray-50 px-3 py-2 rounded-lg">{{ $loan->supervisor_name }} ({{ $loan->supervisor_nip }})</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Loan Period -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Periode Peminjaman</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                            <p class="text-sm text-gray-900 bg-gray-50 px-3 py-2 rounded-lg">{{ \Carbon\Carbon::parse($loan->tanggal_pinjam)->format('d M Y H:i') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
                            <p class="text-sm text-gray-900 bg-gray-50 px-3 py-2 rounded-lg">{{ \Carbon\Carbon::parse($loan->tanggal_pengembalian)->format('d M Y H:i') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Durasi</label>
                            <p class="text-sm text-gray-900 bg-gray-50 px-3 py-2 rounded-lg">{{ $loan->durasi_jam ?? 'N/A' }} jam</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <span class="px-3 py-1 text-sm font-medium rounded-full
                                @if($loan->status === 'PENDING') bg-yellow-100 text-yellow-800
                                @elseif($loan->status === 'APPROVED') bg-green-100 text-green-800
                                @elseif($loan->status === 'REJECTED') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ $loan->status_label }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Equipment List -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Alat yang Dipinjam</h3>
                    <div class="bg-gray-50 rounded-lg p-6">
                        <div class="space-y-4">
                            @foreach($loan->items as $item)
                                <div class="flex items-center justify-between p-4 bg-white rounded-lg shadow-sm">
                                    <div class="flex items-center space-x-4">
                                        @if($item->alat->gambar && $item->alat->gambar->first())
                                            <img src="{{ asset($item->alat->gambar->first()->url) }}" 
                                                 alt="{{ $item->alat->namaAlat }}" 
                                                 class="w-16 h-16 rounded-lg object-cover">
                                        @else
                                            <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                                <i class="fas fa-tools text-gray-400 text-xl"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <p class="font-medium text-gray-900">{{ $item->alat->namaAlat }}</p>
                                            <p class="text-sm text-gray-500 mt-1">{{ $item->alat->deskripsi }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-medium text-gray-900 text-lg">{{ $item->jumlah }} unit</p>
                                        <p class="text-sm text-gray-500 mt-1">
                                            <span class="px-2 py-1 text-xs font-medium rounded-full
                                                @if($item->alat->kondisi === 'BAIK') bg-green-100 text-green-800
                                                @elseif($item->alat->kondisi === 'RUSAK') bg-red-100 text-red-800
                                                @else bg-yellow-100 text-yellow-800
                                                @endif">
                                                {{ $item->alat->kondisi }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Status Update Form -->
                @if($loan->status === 'PENDING')
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi Admin</h3>
                        <form id="statusForm" method="POST" action="{{ route('admin.loans.updateStatus', $loan->id) }}" class="space-y-4">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" id="statusInput">
                            <input type="hidden" name="notes" id="notesInput">
                            
                            <!-- Notes field for rejection -->
                            <div id="notesField" class="hidden">
                                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Catatan Penolakan (Opsional)</label>
                                <textarea name="notes" id="notes" rows="3" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Berikan alasan penolakan jika diperlukan..."></textarea>
                            </div>
                            
                            <div class="flex items-center gap-4">
                                <button type="button" class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium" onclick="submitStatus('APPROVED')">
                                    <i class="fas fa-check mr-2"></i> Approve & WhatsApp
                                </button>
                                <button type="button" class="px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-medium" onclick="showRejectForm()">
                                    <i class="fas fa-times mr-2"></i> Tolak & WhatsApp
                                </button>
                            </div>
                        </form>
                    </div>
                @elseif($loan->status === 'APPROVED')
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi Admin</h3>
                        <form id="statusForm" method="POST" action="{{ route('admin.loans.updateStatus', $loan->id) }}" class="space-y-4">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" id="statusInput">
                            <input type="hidden" name="notes" id="notesInput">
                            <div class="bg-gray-50 rounded-lg p-6">
                                <h4 class="font-semibold mb-4 text-gray-900">Kondisi Pengembalian Alat</h4>
                                @foreach($loan->items as $item)
                                    <div class="flex items-center mb-4 gap-4 p-3 bg-white rounded-lg">
                                        <span class="w-48 font-medium text-gray-900">{{ $item->alat->nama }} ({{ $item->jumlah }} unit)</span>
                                        <div class="flex items-center gap-2">
                                            <input type="number" name="return_baik[{{ $item->id }}]" min="0" max="{{ $item->jumlah }}" value="{{ $item->jumlah }}" class="border rounded px-3 py-2 w-20 text-center" placeholder="Baik">
                                            <span class="text-sm text-gray-600">Baik</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <input type="number" name="return_rusak[{{ $item->id }}]" min="0" max="{{ $item->jumlah }}" value="0" class="border rounded px-3 py-2 w-20 text-center" placeholder="Rusak">
                                            <span class="text-sm text-gray-600">Rusak</span>
                                        </div>
                                    </div>
                                @endforeach
                                <small class="text-gray-500 block mt-2">Jumlah baik + rusak harus sama dengan jumlah dipinjam.</small>
                            </div>
                            <div class="flex items-center gap-4">
                                <button type="button" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium" onclick="submitStatus('COMPLETED')">
                                    <i class="fas fa-check-circle mr-2"></i> Tandai Selesai & WhatsApp
                                </button>
                            </div>
                        </form>
                    </div>
                @else
                    @if($loan->notes)
                        <div class="mt-8 pt-6 border-t border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Catatan</h3>
                            <div class="bg-gray-50 rounded-lg p-6">
                                <p class="text-sm text-gray-900 leading-relaxed">{{ $loan->notes }}</p>
                            </div>
                        </div>
                    @endif
                @endif

                <!-- Timestamps -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm text-gray-500">
                        <div class="bg-gray-50 px-4 py-3 rounded-lg">
                            <span class="font-medium text-gray-700">Dibuat:</span> {{ $loan->created_at->format('d M Y H:i') }}
                        </div>
                        <div class="bg-gray-50 px-4 py-3 rounded-lg">
                            <span class="font-medium text-gray-700">Diperbarui:</span> {{ $loan->updated_at->format('d M Y H:i') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function submitStatus(status) {
    document.getElementById('statusInput').value = status;
    
    // If rejecting, get notes from textarea
    if (status === 'REJECTED') {
        const notesTextarea = document.getElementById('notes');
        const notesValue = notesTextarea ? notesTextarea.value : '';
        document.getElementById('notesInput').value = notesValue;
    } else {
        document.getElementById('notesInput').value = '';
    }
    
    document.getElementById('statusForm').submit();
}

function showRejectForm() {
    const notesField = document.getElementById('notesField');
    notesField.classList.remove('hidden');
    
    // Change button to submit form
    const rejectButton = document.querySelector('button[onclick="showRejectForm()"]');
    if (rejectButton) {
        rejectButton.onclick = function() {
            submitStatus('REJECTED');
        };
        rejectButton.innerHTML = '<i class="fas fa-times mr-2"></i> Tolak & WhatsApp';
    }
}
</script>
@endsection