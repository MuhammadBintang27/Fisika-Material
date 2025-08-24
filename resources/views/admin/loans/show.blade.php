
@extends('admin.layouts.app')

@section('title', 'Detail Peminjaman')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="bg-gradient-to-br from-blue-700 to-blue-800 rounded-xl p-8 text-white shadow-xl border border-blue-600">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold mb-2">Detail Peminjaman Alat</h1>
                <p class="text-blue-100 text-lg mb-3">ID Peminjaman: #{{ $loan->id }}</p>
                <div class="flex items-center space-x-4">
                    <!-- Status Badge -->
                    @if($loan->status == 'PENDING')
                        <span class="bg-amber-500 text-white px-4 py-2 rounded-xl text-sm font-semibold flex items-center">
                            <i class="fas fa-clock mr-2"></i>
                            Pending
                        </span>
                    @elseif($loan->status == 'APPROVED')
                        <span class="bg-green-500 text-white px-4 py-2 rounded-xl text-sm font-semibold flex items-center">
                            <i class="fas fa-check mr-2"></i>
                            Disetujui
                        </span>
                    @elseif($loan->status == 'COMPLETED')
                        <span class="bg-indigo-500 text-white px-4 py-2 rounded-xl text-sm font-semibold flex items-center">
                            <i class="fas fa-check-double mr-2"></i>
                            Selesai
                        </span>
                    @elseif($loan->status == 'REJECTED')
                        <span class="bg-red-500 text-white px-4 py-2 rounded-xl text-sm font-semibold flex items-center">
                            <i class="fas fa-times mr-2"></i>
                            Ditolak
                        </span>
                    @endif
                    
                    
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('tracking') }}?nama={{ urlencode($loan->namaPeminjam) }}&nip_nim={{ urlencode($loan->nip_nim) }}" 
                   target="_blank"
                   class="bg-white text-blue-600 px-6 py-3 rounded-xl hover:bg-gray-50 transition-all duration-300 shadow-lg hover:shadow-xl font-semibold group">
                    <i class="fas fa-external-link-alt mr-2 group-hover:rotate-12 transition-transform"></i>
                    Lihat di User
                </a>
                <a href="{{ route('admin.loans.index') }}" 
                   class="bg-white/20 backdrop-blur-sm rounded-xl p-4 hover:bg-white/30 transition-all duration-300 shadow-lg hover:shadow-xl group">
                    <i class="fas fa-arrow-left text-xl group-hover:scale-110 transition-transform"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Borrower Information -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                            <i class="fas fa-user text-white"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Informasi Peminjam</h3>
                    </div>
                </div>
                <div class="p-8 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Tracking Code</label>
                            <div class="text-lg font-mono font-bold text-blue-600 bg-blue-50 px-4 py-2 rounded-xl border border-blue-200">
                                {{ $loan->tracking_code }}
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Tanggal Pengajuan</label>
                            <p class="text-lg font-semibold text-gray-900">{{ $loan->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Kategori</label>
                            <span class="px-4 py-2 text-sm font-bold rounded-xl inline-block
                                @if($loan->user_type === 'dosen') bg-blue-100 text-blue-800
                                @elseif($loan->user_type === 'mahasiswa') bg-green-100 text-green-800
                                @else bg-purple-100 text-purple-800
                                @endif">
                                {{ $loan->user_type_label }}
                            </span>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Nama Peminjam</label>
                            <p class="text-lg font-semibold text-gray-900">{{ $loan->namaPeminjam }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">NIP/NIM</label>
                            <p class="text-lg font-semibold text-gray-900">{{ $loan->nip_nim ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Nomor HP</label>
                            <p class="text-lg font-semibold text-gray-900">{{ $loan->noHp }}</p>
                        </div>
                        @if($loan->email)
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Email</label>
                                <p class="text-lg font-semibold text-gray-900">{{ $loan->email }}</p>
                            </div>
                        @endif
                        @if($loan->instansi)
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Instansi</label>
                                <p class="text-lg font-semibold text-gray-900">{{ $loan->instansi }}</p>
                            </div>
                        @endif
                        @if($loan->jabatan)
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Jabatan</label>
                                <p class="text-lg font-semibold text-gray-900">{{ $loan->jabatan }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Research Information -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center">
                            <i class="fas fa-flask text-white"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Informasi Penelitian</h3>
                    </div>
                </div>
                <div class="p-8 space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Judul Penelitian</label>
                        <p class="text-lg text-gray-900">{{ $loan->judul_penelitian ?? 'N/A' }}</p>
                    </div>
                    @if($loan->supervisor_name)
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Dosen Pembimbing</label>
                            <p class="text-lg text-gray-900">{{ $loan->supervisor_name }} ({{ $loan->supervisor_nip }})</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Loan Period -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center">
                            <i class="fas fa-calendar text-white"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Periode Peminjaman</h3>
                    </div>
                </div>
                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Tanggal Mulai</label>
                            <p class="text-lg font-semibold text-gray-900">{{ \Carbon\Carbon::parse($loan->tanggal_pinjam)->format('d F Y') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Tanggal Selesai</label>
                            <p class="text-lg font-semibold text-gray-900">{{ \Carbon\Carbon::parse($loan->tanggal_pengembalian)->format('d F Y') }}</p>
                        </div>
                        @if($loan->durasi_jam)
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Durasi</label>
                                <p class="text-lg font-semibold text-gray-900">{{ $loan->durasi_jam }} jam</p>
                            </div>
                        @endif
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Status Peminjaman</label>
                            @if($loan->status === 'PENDING')
                                <span class="bg-amber-100 text-amber-800 px-3 py-1 rounded-xl text-sm font-semibold">Pending</span>
                            @elseif($loan->status === 'APPROVED')
                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-xl text-sm font-semibold">Disetujui</span>
                            @elseif($loan->status === 'ONGOING')
                                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-xl text-sm font-semibold">Berlangsung</span>
                            @elseif($loan->status === 'REJECTED')
                                <span class="bg-red-100 text-red-800 px-3 py-1 rounded-xl text-sm font-semibold">Ditolak</span>
                            @else
                                <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-xl text-sm font-semibold">{{ $loan->status }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Equipment List -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-orange-500 rounded-lg flex items-center justify-center">
                            <i class="fas fa-tools text-white"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Daftar Alat yang Dipinjam</h3>
                    </div>
                </div>
                <div class="p-8">
                    @if($loan->items->count() > 0)
                        <div class="space-y-4">
                            @foreach($loan->items as $item)
                                <div class="bg-gray-50 rounded-lg p-4 flex items-center justify-between hover:bg-gray-100 transition-colors">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                                        <div>
                                            <p class="font-semibold text-gray-900">{{ $item->alat->nama }}</p>
                                            <p class="text-sm text-gray-600">Jumlah: {{ $item->jumlah }} unit</p>
                                        </div>
                                    </div>
                                    @if($item->return_condition)
                                        <div class="text-right">
                                            <p class="text-sm text-gray-500">Kondisi Pengembalian:</p>
                                            <p class="text-sm font-medium text-gray-700">{{ $item->return_condition }}</p>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
                            <p class="text-gray-500">Tidak ada alat yang dipinjam.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar Actions -->
        <div class="lg:col-span-1">
            @if($loan->status === 'PENDING')
                <!-- Status Management -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 mb-6">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center">
                                <i class="fas fa-tasks text-white"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900">Aksi Admin</h3>
                        </div>
                    </div>
                    <div class="p-6">
                        <form id="statusForm" method="POST" action="{{ route('admin.loans.updateStatus', $loan->id) }}" class="space-y-4">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" id="statusInput">
                            <input type="hidden" name="notes" id="notesInput">
                            
                            <div id="notesField" class="hidden">
                                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Catatan Penolakan (Opsional)</label>
                                <textarea name="notes" id="notes" rows="3" 
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    placeholder="Berikan alasan penolakan jika diperlukan..."></textarea>
                            </div>
                            
                            <div class="space-y-3">
                                <button type="button" onclick="submitStatus('APPROVED')"
                                        class="w-full bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl font-semibold group">
                                    <i class="fas fa-check mr-2 group-hover:scale-110 transition-transform"></i>
                                    Setujui & Kirim WhatsApp
                                </button>
                                
                                <button type="button" onclick="showRejectForm()"
                                        class="w-full bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl font-semibold group">
                                    <i class="fas fa-times mr-2 group-hover:scale-110 transition-transform"></i>
                                    Tolak & Kirim WhatsApp
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @elseif($loan->status === 'APPROVED')
                <!-- Status Management -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 mb-6">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                                <i class="fas fa-tasks text-white"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900">Aksi Admin</h3>
                        </div>
                    </div>
                    <div class="p-6">
                        <form id="statusForm" method="POST" action="{{ route('admin.loans.updateStatus', $loan->id) }}" class="space-y-4">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" id="statusInput">
                            <input type="hidden" name="notes" id="notesInput">
                            
                            <button type="button" onclick="submitStatus('ONGOING')"
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl font-semibold group">
                                <i class="fas fa-play-circle mr-2 group-hover:scale-110 transition-transform"></i>
                                Tandai Berlangsung & WhatsApp
                            </button>
                        </form>
                    </div>
                </div>
            @elseif($loan->status === 'ONGOING')
                <!-- Status Management -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 mb-6">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center">
                                <i class="fas fa-tasks text-white"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900">Aksi Admin</h3>
                        </div>
                    </div>
                    <div class="p-6">
                        <form id="statusForm" method="POST" action="{{ route('admin.loans.updateStatus', $loan->id) }}" class="space-y-4">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" id="statusInput">
                            <input type="hidden" name="notes" id="notesInput">
                            <div class="bg-gray-50 rounded-lg p-6 mb-4">
                                <h4 class="font-semibold mb-4 text-gray-900">Kondisi Pengembalian Alat</h4>
                                @foreach($loan->items as $item)
                                    <div class="flex items-center mb-4 gap-4 p-4 bg-white rounded-lg shadow-sm">
                                        <span class="w-48 font-medium text-gray-900">{{ $item->alat->nama }} ({{ $item->jumlah }} unit)</span>
                                        <div class="flex items-center gap-2">
                                            <input type="number" name="return_baik[{{ $item->id }}]" min="0" max="{{ $item->jumlah }}" value="{{ $item->jumlah }}" class="border border-gray-300 rounded-lg px-3 py-2 w-20 text-center focus:ring-blue-500 focus:border-blue-500" placeholder="Baik">
                                            <span class="text-sm text-green-600 font-medium">Baik</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <input type="number" name="return_rusak[{{ $item->id }}]" min="0" max="{{ $item->jumlah }}" value="0" class="border border-gray-300 rounded-lg px-3 py-2 w-20 text-center focus:ring-blue-500 focus:border-blue-500" placeholder="Rusak">
                                            <span class="text-sm text-red-600 font-medium">Rusak</span>
                                        </div>
                                    </div>
                                @endforeach
                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mt-4">
                                    <p class="text-sm text-blue-700">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        Jumlah baik + rusak harus sama dengan jumlah dipinjam.
                                    </p>
                                </div>
                            </div>
                            
                            <button type="button" onclick="submitStatus('COMPLETED')"
                                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl font-semibold group">
                                <i class="fas fa-check-circle mr-2 group-hover:scale-110 transition-transform"></i>
                                Tandai Selesai & WhatsApp
                            </button>
                        </form>
                    </div>
                </div>
            @endif

            <!-- WhatsApp Actions -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center">
                            <i class="fab fa-whatsapp text-white"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Kirim Pesan Manual</h3>
                    </div>
                </div>
                <div class="p-6 space-y-4">
                    <button onclick="sendStatusMessage()" 
                            class="w-full bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl font-semibold group">
                        <i class="fab fa-whatsapp mr-2 group-hover:scale-110 transition-transform"></i>
                        Kirim Update Status Manual
                    </button>
                    
                    <button onclick="sendCustomMessage()" 
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl font-semibold group">
                        <i class="fas fa-comment mr-2 group-hover:scale-110 transition-transform"></i>
                        Kirim Pesan Custom
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Notes Section for Rejected/Completed -->
    @if($loan->notes && in_array($loan->status, ['REJECTED', 'COMPLETED']))
        <div class="bg-white rounded-xl shadow-lg border border-gray-100">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gray-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-sticky-note text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">Catatan</h3>
                </div>
            </div>
            <div class="p-8">
                <p class="text-lg text-gray-900 leading-relaxed">{{ $loan->notes }}</p>
            </div>
        </div>
    @endif

    <!-- Timestamps -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-gray-500 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clock text-white"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900">Informasi Waktu</h3>
            </div>
        </div>
        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Tanggal Dibuat</label>
                    <p class="text-lg font-semibold text-gray-900">{{ $loan->created_at->format('d F Y, H:i') }}</p>
                </div>
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
