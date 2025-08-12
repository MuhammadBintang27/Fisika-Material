@extends('admin.layouts.app')

@section('title', 'Detail Pengajuan Pengujian - ' . $pengajuan->trackingCode)

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="bg-gradient-to-br from-blue-700 to-blue-800 rounded-xl p-8 text-white shadow-xl border border-blue-600">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold mb-2">Detail Pengajuan Pengujian</h1>
                <p class="text-blue-100 text-lg mb-3">Kode Tracking: {{ $pengajuan->trackingCode }}</p>
                <div class="flex items-center space-x-4">
                    <!-- Status Badge -->
                    @if($pengajuan->status == 'MENUNGGU')
                        <span class="bg-amber-500 text-white px-4 py-2 rounded-xl text-sm font-semibold flex items-center">
                            <i class="fas fa-clock mr-2"></i>
                            Menunggu
                        </span>
                    @elseif($pengajuan->status == 'DISETUJUI')
                        <span class="bg-green-500 text-white px-4 py-2 rounded-xl text-sm font-semibold flex items-center">
                            <i class="fas fa-check mr-2"></i>
                            Disetujui
                        </span>
                    @elseif($pengajuan->status == 'DIPROSES')
                        <span class="bg-blue-500 text-white px-4 py-2 rounded-xl text-sm font-semibold flex items-center">
                            <i class="fas fa-cogs mr-2"></i>
                            Diproses
                        </span>
                    @elseif($pengajuan->status == 'SELESAI')
                        <span class="bg-indigo-500 text-white px-4 py-2 rounded-xl text-sm font-semibold flex items-center">
                            <i class="fas fa-check-double mr-2"></i>
                            Selesai
                        </span>
                    @elseif($pengajuan->status == 'DITOLAK')
                        <span class="bg-red-500 text-white px-4 py-2 rounded-xl text-sm font-semibold flex items-center">
                            <i class="fas fa-times mr-2"></i>
                            Ditolak
                        </span>
                    @endif
                    
                    
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.pengajuan-pengujian.index') }}" 
                   class="bg-white/20 backdrop-blur-sm rounded-xl p-4 hover:bg-white/30 transition-all duration-300 shadow-lg hover:shadow-xl group">
                    <i class="fas fa-arrow-left text-xl group-hover:scale-110 transition-transform"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Pengajuan Details -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                            <i class="fas fa-info text-white"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Informasi Pengajuan</h3>
                    </div>
                </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Nama Pengaju</label>
                                    <p class="mt-1 text-lg font-semibold text-gray-900">{{ $pengajuan->namaPengaju }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Kode Tracking</label>
                                    <p class="mt-1 text-lg font-mono font-bold text-blue-600">{{ $pengajuan->trackingCode }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Nomor WhatsApp</label>
                                    <p class="mt-1 text-lg font-semibold text-gray-900">{{ $pengajuan->noHp }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Tipe User</label>
                                    <p class="mt-1 text-lg text-gray-900">{{ $pengajuan->getUserTypeLabelAttribute() }}</p>
                                </div>
                                @if($pengajuan->nip_nim)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">NIP/NIM</label>
                                    <p class="mt-1 text-lg text-gray-900">{{ $pengajuan->nip_nim }}</p>
                                </div>
                                @endif
                                @if($pengajuan->email)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Email</label>
                                    <p class="mt-1 text-lg text-gray-900">{{ $pengajuan->email }}</p>
                                </div>
                                @endif
                                @if($pengajuan->instansi)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Instansi</label>
                                    <p class="mt-1 text-lg text-gray-900">{{ $pengajuan->instansi }}</p>
                                </div>
                                @endif
                                @if($pengajuan->alamat)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Alamat</label>
                                    <p class="mt-1 text-lg text-gray-900">{{ $pengajuan->alamat }}</p>
                                </div>
                                @endif
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Tanggal Pengajuan</label>
                                    <p class="mt-1 text-lg text-gray-900">{{ $pengajuan->tanggalPengajuan->format('d F Y, H:i') }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Tanggal Penyerahan Sampel</label>
                                    <p class="mt-1 text-lg text-gray-900">{{ \Carbon\Carbon::parse($pengajuan->tanggalPenyerahan)->format('d F Y') }}</p>
                                </div>
                                @if($pengajuan->estimasiSelesai)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Estimasi Selesai</label>
                                    <p class="mt-1 text-lg text-gray-900">{{ \Carbon\Carbon::parse($pengajuan->estimasiSelesai)->format('d F Y') }}</p>
                                </div>
                                @endif
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Status Saat Ini</label>
                                    <div class="mt-1">
                                        @if($pengajuan->status == 'MENUNGGU')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                                <i class="fas fa-clock mr-2"></i>Menunggu Persetujuan
                                            </span>
                                        @elseif($pengajuan->status == 'DISETUJUI')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                                <i class="fas fa-check mr-2"></i>Disetujui
                                            </span>
                                        @elseif($pengajuan->status == 'DIPROSES')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-orange-100 text-orange-800">
                                                <i class="fas fa-cog mr-2"></i>Sedang Diproses
                                            </span>
                                        @elseif($pengajuan->status == 'SELESAI')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                                <i class="fas fa-flag-checkered mr-2"></i>Selesai
                                            </span>
                                        @elseif($pengajuan->status == 'DITOLAK')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                                <i class="fas fa-times mr-2"></i>Ditolak
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Supervisor Info -->
                            @if($pengajuan->supervisor_name)
                            <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                                <h5 class="font-semibold text-blue-900 mb-2">
                                    @if($pengajuan->user_type === 'mahasiswa')
                                        Informasi Pembimbing
                                    @else
                                        Informasi Penanggung Jawab
                                    @endif
                                </h5>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <span class="text-sm text-blue-700">Nama:</span>
                                        <span class="ml-2 font-medium text-blue-900">{{ $pengajuan->supervisor_name }}</span>
                                    </div>
                                    @if($pengajuan->supervisor_nip)
                                    <div>
                                        <span class="text-sm text-blue-700">NIP:</span>
                                        <span class="ml-2 font-medium text-blue-900">{{ $pengajuan->supervisor_nip }}</span>
                                    </div>
                                    @endif
                                    @if($pengajuan->supervisor_jabatan)
                                    <div>
                                        <span class="text-sm text-blue-700">Jabatan:</span>
                                        <span class="ml-2 font-medium text-blue-900">{{ $pengajuan->supervisor_jabatan }}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endif

                            @if($pengajuan->detailKhusus)
                            <div class="mt-6">
                                <label class="block text-sm font-medium text-gray-500 mb-2">Detail Khusus</label>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <p class="text-gray-900 leading-relaxed">{{ $pengajuan->detailKhusus }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Sample Information -->
                    <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Informasi Sampel</h3>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Jumlah Sampel</label>
                                    <p class="mt-1 text-lg font-semibold text-gray-900">{{ $pengajuan->jumlahSampel }} sampel</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Deskripsi Sampel</label>
                                    <div class="mt-1 bg-gray-50 rounded-lg p-3">
                                        <p class="text-gray-900">{{ $pengajuan->deskripsiSampel }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- File Pendukung -->
                            @if($pengajuan->filePendukung)
                            <div class="mt-6">
                                <label class="block text-sm font-medium text-gray-500 mb-3">File Pendukung</label>
                                <div class="border border-gray-200 rounded-lg p-4 bg-blue-50">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                                <i class="fas fa-file-alt text-blue-600"></i>
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-900">File Pendukung Pengujian</p>
                                                <p class="text-sm text-gray-500">Diupload saat pengajuan</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ asset('storage/' . $pengajuan->filePendukung) }}" 
                                               target="_blank"
                                               class="bg-blue-600 text-white px-3 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors duration-200 flex items-center">
                                                <i class="fas fa-eye mr-2"></i>
                                                Lihat File
                                            </a>
                                            <a href="{{ asset('storage/' . $pengajuan->filePendukung) }}" 
                                               download
                                               class="bg-gray-600 text-white px-3 py-2 rounded-lg text-sm font-medium hover:bg-gray-700 transition-colors duration-200 flex items-center">
                                                <i class="fas fa-download mr-2"></i>
                                                Download
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @else
                            <div class="mt-6">
                                <label class="block text-sm font-medium text-gray-500 mb-3">File Pendukung</label>
                                <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                                    <div class="text-center text-gray-500">
                                        <i class="fas fa-file-alt text-2xl mb-2"></i>
                                        <p>Tidak ada file pendukung yang diunggah</p>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Service Details -->
                    <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Detail Layanan</h3>
                        </div>
                        <div class="p-6">
                            <div class="flex items-start space-x-4">
                                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-flask text-orange-600 text-xl"></i>
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-xl font-semibold text-gray-900 mb-2">{{ $pengajuan->layanan->namaLayanan }}</h4>
                                    @if($pengajuan->layanan->deskripsi)
                                        <p class="text-gray-600 mb-4">{{ $pengajuan->layanan->deskripsi }}</p>
                                    @endif
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <span class="text-sm text-gray-500">Harga:</span>
                                            @if($pengajuan->layanan->harga)
                                                <span class="ml-2 font-semibold text-orange-600">
                                                    Rp {{ number_format($pengajuan->layanan->harga, 0, ',', '.') }}
                                                </span>
                                            @else
                                                <span class="ml-2 font-semibold text-green-600">Gratis</span>
                                            @endif
                                        </div>
                                        <div>
                                            <span class="text-sm text-gray-500">Estimasi Selesai:</span>
                                            <span class="ml-2 font-semibold text-gray-900">{{ $pengajuan->layanan->estimasiSelesaiHari }} hari</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Results Section -->
                    @if($pengajuan->hasil->count() > 0)
                    <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">File Hasil Pengujian</h3>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                @foreach($pengajuan->hasil as $hasil)
                                <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-file-pdf text-blue-600"></i>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900">{{ $hasil->namaFile }}</p>
                                            <p class="text-sm text-gray-500">Diupload: {{ $hasil->created_at->format('d/m/Y H:i') }}</p>
                                        </div>
                                    </div>
                                    <a href="{{ asset('storage/pengujian-hasil/' . $hasil->filePath) }}" 
                                       target="_blank"
                                       class="text-blue-600 hover:text-blue-800 font-medium">
                                        <i class="fas fa-download mr-1"></i>Download
                                    </a>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Sidebar Actions -->
                <div class="lg:col-span-1">
                    <!-- Status Management -->
                    <div class="bg-white rounded-xl shadow-lg border border-gray-100 mb-6">
                        <div class="p-6 border-b border-gray-200">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-tasks text-white"></i>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900">Ubah Status & Kirim WhatsApp</h3>
                            </div>
                        </div>
                        <div class="p-6">
                            @if($pengajuan->status == 'MENUNGGU')
                                <form id="statusForm" method="POST" action="{{ route('admin.pengajuan-pengujian.update-status', $pengajuan->id) }}" class="space-y-4">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" id="statusInput">
                                    <input type="hidden" name="catatan" id="catatanInput">
                                    
                                    <div id="catatanField" class="hidden">
                                        <label for="catatan" class="block text-sm font-medium text-gray-700 mb-2">Catatan Penolakan (Opsional)</label>
                                        <textarea name="catatan" id="catatan" rows="3" 
                                                  class="w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500"
                                                  placeholder="Berikan alasan penolakan jika diperlukan..."></textarea>
                                    </div>
                                    
                                    <div class="flex flex-col gap-3">
                                        <button type="button" onclick="submitStatus('DISETUJUI')"
                                                class="w-full bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 transition-colors duration-200 flex items-center justify-center">
                                            <i class="fas fa-check mr-2"></i>
                                            Setujui & Kirim WhatsApp
                                        </button>
                                        
                                        <button type="button" onclick="showRejectForm()"
                                                class="w-full bg-red-600 text-white py-2 px-4 rounded-md hover:bg-red-700 transition-colors duration-200 flex items-center justify-center">
                                            <i class="fas fa-times mr-2"></i>
                                            Tolak & Kirim WhatsApp
                                        </button>
                                    </div>
                                </form>
                            @elseif($pengajuan->status == 'DISETUJUI')
                                <form id="statusForm" method="POST" action="{{ route('admin.pengajuan-pengujian.update-status', $pengajuan->id) }}" class="space-y-4">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" id="statusInput">
                                    <input type="hidden" name="catatan" id="catatanInput">
                                    
                                    <div class="flex flex-col gap-3">
                                        <button type="button" onclick="submitStatus('DIPROSES')"
                                                class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition-colors duration-200 flex items-center justify-center">
                                            <i class="fas fa-cogs mr-2"></i>
                                            Mulai Proses & Kirim WhatsApp
                                        </button>
                                    </div>
                                </form>
                            @elseif($pengajuan->status == 'DIPROSES')
                                <form id="statusForm" method="POST" action="{{ route('admin.pengajuan-pengujian.update-status', $pengajuan->id) }}" class="space-y-4">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" id="statusInput">
                                    <input type="hidden" name="catatan" id="catatanInput">
                                    
                                    <div class="flex flex-col gap-3">
                                        <button type="button" onclick="submitStatus('SELESAI')"
                                                class="w-full bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 transition-colors duration-200 flex items-center justify-center">
                                            <i class="fas fa-flag-checkered mr-2"></i>
                                            Selesai & Kirim WhatsApp
                                        </button>
                                    </div>
                                </form>
                            @else
                                <div class="text-center text-gray-500">
                                    <p>Tidak ada aksi yang tersedia untuk status saat ini.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- WhatsApp Actions -->
                    <div class="bg-white rounded-xl shadow-lg border border-gray-100 mb-6">
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

                    @if($pengajuan->status == 'DIPROSES' || $pengajuan->status == 'SELESAI')
                    <!-- Upload Results -->
                    <div class="bg-white rounded-xl shadow-lg border border-gray-100">
                        <div class="p-6 border-b border-gray-200">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-upload text-white"></i>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900">Upload Hasil Pengujian</h3>
                            </div>
                        </div>
                        <div class="p-6">
                            <form action="{{ route('admin.pengajuan-pengujian.upload-hasil', $pengajuan->id) }}" 
                                  method="POST" enctype="multipart/form-data">
                                @csrf
                                
                                <div class="mb-4">
                                    <label for="file" class="block text-sm font-medium text-gray-700 mb-2">File Hasil</label>
                                    <input type="file" name="file" id="file" required 
                                           accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500">
                                    <p class="text-xs text-gray-500 mt-1">Format: PDF, DOC, DOCX, JPG, PNG (Max: 10MB)</p>
                                </div>

                                <div class="mb-4">
                                    <label for="catatan" class="block text-sm font-medium text-gray-700 mb-2">Catatan (Opsional)</label>
                                    <textarea name="catatan" id="catatan" rows="3"
                                              class="w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500"
                                              placeholder="Tambahkan catatan untuk hasil pengujian..."></textarea>
                                </div>

                                <button type="submit" 
                                        class="w-full bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl font-semibold group">
                                    <i class="fas fa-upload mr-2 group-hover:scale-110 transition-transform"></i>
                                    Upload File Hasil
                                </button>
                            </form>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

<!-- Custom Message Modal -->
<div id="customMessageModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Kirim Pesan WhatsApp</h3>
            <form id="customMessageForm">
                <div class="mb-4">
                    <label for="customMessage" class="block text-sm font-medium text-gray-700 mb-2">Pesan</label>
                    <textarea id="customMessage" rows="4" required
                              class="w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500"
                              placeholder="Tulis pesan Anda..."></textarea>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeCustomMessageModal()" 
                            class="bg-gray-300 text-gray-700 py-2 px-4 rounded-md hover:bg-gray-400 transition-colors duration-200">
                        Batal
                    </button>
                    <button type="submit" 
                            class="bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 transition-colors duration-200">
                        <i class="fab fa-whatsapp mr-2"></i>
                        Kirim
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function submitStatus(status) {
    document.getElementById('statusInput').value = status;
    
    if (status === 'DITOLAK') {
        const catatanTextarea = document.getElementById('catatan');
        const catatanValue = catatanTextarea ? catatanTextarea.value : '';
        document.getElementById('catatanInput').value = catatanValue;
    } else {
        document.getElementById('catatanInput').value = '';
    }
    
    document.getElementById('statusForm').submit();
}

function showRejectForm() {
    const catatanField = document.getElementById('catatanField');
    catatanField.classList.remove('hidden');
    
    const rejectButton = document.querySelector('button[onclick="showRejectForm()"]');
    if (rejectButton) {
        rejectButton.onclick = function() {
            submitStatus('DITOLAK');
        };
        rejectButton.innerHTML = '<i class="fas fa-times mr-2"></i> Tolak & Kirim WhatsApp';
    }
}

function sendStatusMessage() {
    const phone = "{{ $pengajuan->noHp }}";
    const status = "{{ $pengajuan->status }}";
    const trackingCode = "{{ $pengajuan->trackingCode }}";
    const layanan = "{{ $pengajuan->layanan->namaLayanan }}";
    const nama = "{{ $pengajuan->namaPengaju }}";
    
    let message = '';
    
    switch(status) {
        case 'MENUNGGU':
            message = `Halo ${nama},\n\nPengajuan pengujian Anda untuk layanan "${layanan}" dengan kode tracking *${trackingCode}* telah kami terima dan sedang menunggu proses review.\n\nAnda dapat memantau status pengajuan melalui halaman tracking di website kami.\n\nTerima kasih,\nLaboratorium Fisika Material dan Energi`;
            break;
        case 'DISETUJUI':
            message = `Halo ${nama},\n\n✅ *PENGAJUAN DISETUJUI*\n\nPengajuan pengujian Anda untuk layanan "${layanan}" dengan kode tracking *${trackingCode}* telah disetujui.\n\nSilakan serahkan sampel sesuai dengan jadwal yang telah ditentukan.\n\nAnda dapat memantau status pengajuan melalui halaman tracking di website kami.\n\nTerima kasih,\nLaboratorium Fisika Material dan Energi`;
            break;
        case 'DIPROSES':
            message = `Halo ${nama},\n\n🔬 *SAMPEL SEDANG DIPROSES*\n\nSampel untuk pengujian "${layanan}" dengan kode tracking *${trackingCode}* sedang dalam proses pengujian di laboratorium kami.\n\nHasil pengujian akan segera tersedia setelah proses selesai.\n\nAnda dapat memantau status pengajuan melalui halaman tracking di website kami.\n\nTerima kasih,\nLaboratorium Fisika Material dan Energi`;
            break;
        case 'SELESAI':
            message = `Halo ${nama},\n\n✅ *PENGUJIAN SELESAI*\n\nPengujian untuk layanan "${layanan}" dengan kode tracking *${trackingCode}* telah selesai!\n\nHasil pengujian sudah tersedia dan dapat diunduh melalui halaman tracking di website kami.\n\n🔗 Link tracking: [Website URL]/tracking\n\nTerima kasih telah menggunakan layanan kami,\nLaboratorium Fisika Material dan Energi`;
            break;
        case 'DITOLAK':
            message = `Halo ${nama},\n\n❌ *PENGAJUAN DITOLAK*\n\nMohon maaf, pengajuan pengujian Anda untuk layanan "${layanan}" dengan kode tracking *${trackingCode}* tidak dapat kami proses.\n\nUntuk informasi lebih lanjut, silakan hubungi kami.\n\nTerima kasih,\nLaboratorium Fisika Material dan Energi`;
            break;
        default:
            message = `Halo ${nama},\n\nUpdate status pengajuan pengujian Anda untuk layanan "${layanan}" dengan kode tracking *${trackingCode}*.\n\nAnda dapat memantau status pengajuan melalui halaman tracking di website kami.\n\nTerima kasih,\nLaboratorium Fisika Material dan Energi`;
    }
    
    const whatsappUrl = `https://wa.me/${phone.replace(/^0/, '62')}?text=${encodeURIComponent(message)}`;
    window.open(whatsappUrl, '_blank');
}

function sendCustomMessage() {
    document.getElementById('customMessageModal').classList.remove('hidden');
}

function closeCustomMessageModal() {
    document.getElementById('customMessageModal').classList.add('hidden');
    document.getElementById('customMessage').value = '';
}

document.getElementById('customMessageForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const phone = "{{ $pengajuan->noHp }}";
    const message = document.getElementById('customMessage').value;
    
    if (message.trim()) {
        const whatsappUrl = `https://wa.me/${phone.replace(/^0/, '62')}?text=${encodeURIComponent(message)}`;
        window.open(whatsappUrl, '_blank');
        closeCustomMessageModal();
    }
});

// Close modal when clicking outside
document.getElementById('customMessageModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeCustomMessageModal();
    }
});

// Form submission with confirmation
document.getElementById('statusForm').addEventListener('submit', function(e) {
    const status = document.getElementById('status').value;
    if (status && !confirm('Apakah Anda yakin ingin mengubah status pengajuan ini?')) {
        e.preventDefault();
    }
});
</script>
@endsection
