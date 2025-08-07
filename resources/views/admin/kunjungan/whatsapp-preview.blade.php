@extends('admin.layouts.app')

@section('title', 'Preview WhatsApp')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Preview Pesan WhatsApp</h1>
                <p class="text-gray-600">Tinjau pesan sebelum mengirim ke pengunjung</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.kunjungan.show', $kunjungan->id) }}" 
                   class="text-gray-600 hover:text-gray-900">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali ke Detail
                </a>
            </div>
        </div>

        <!-- WhatsApp Preview -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="p-6 sm:p-8">
                <!-- Recipient Info -->
                <div class="mb-6 pb-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Penerima</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Pengunjung</label>
                            <p class="text-sm text-gray-900 bg-gray-50 px-3 py-2 rounded-lg">{{ $kunjungan->namaPengunjung }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nomor WhatsApp</label>
                            <p class="text-sm text-gray-900 bg-gray-50 px-3 py-2 rounded-lg">{{ $phone }}</p>
                        </div>
                    </div>
                </div>

                <!-- Message Preview -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Preview Pesan</h3>
                    <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                        <div class="flex items-center mb-4">
                            <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center mr-3">
                                <i class="fab fa-whatsapp text-white text-lg"></i>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900">WhatsApp Message</h4>
                                <p class="text-sm text-gray-500">Preview pesan yang akan dikirim</p>
                            </div>
                        </div>
                        <div class="bg-white rounded-lg p-4 border border-green-200">
                            <pre class="text-sm text-gray-900 whitespace-pre-wrap font-sans">{{ $message }}</pre>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('admin.kunjungan.show', $kunjungan->id) }}" 
                           class="px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors font-medium">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali
                        </a>
                        <button onclick="copyMessage()" 
                                class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                            <i class="fas fa-copy mr-2"></i>
                            Salin Pesan
                        </button>
                        <button onclick="openWhatsApp()" 
                                class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium">
                            <i class="fab fa-whatsapp mr-2"></i>
                            Buka WhatsApp
                        </button>
                    </div>
                </div>

                <!-- Status Update Confirmation -->
                <div id="statusUpdateSection" class="hidden mt-6 pt-6 border-t border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Konfirmasi Pembaruan Status</h3>
                    <p class="text-sm text-gray-600 mb-4">Apakah Anda ingin mengupdate status kunjungan setelah mengirim pesan?</p>
                    <div class="flex items-center space-x-4">
                        <button onclick="updateStatus()" 
                                class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium">
                            <i class="fas fa-check mr-2"></i>
                            Ya, Update Status
                        </button>
                        <button onclick="hideStatusUpdate()" 
                                class="px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors font-medium">
                            Tidak, Kembali Saja
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let messageCopied = false;
let whatsappOpened = false;

function copyMessage() {
    const message = `{{ addslashes($message) }}`;
    navigator.clipboard.writeText(message).then(function() {
        const button = document.querySelector('button[onclick="copyMessage()"]');
        if (button) {
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-check mr-2"></i> Tersalin!';
            button.classList.remove('bg-blue-600', 'hover:bg-blue-700');
            button.classList.add('bg-green-600', 'hover:bg-green-700');
            
            messageCopied = true;
            checkActions();
            
            setTimeout(function() {
                button.innerHTML = originalText;
                button.classList.remove('bg-green-600', 'hover:bg-green-700');
                button.classList.add('bg-blue-600', 'hover:bg-blue-700');
            }, 5000);
        }
    }).catch(function(err) {
        console.error('Could not copy text: ', err);
        alert('Gagal menyalin pesan. Silakan salin manual.');
    });
}

function openWhatsApp() {
    const whatsappUrl = '{{ $whatsappUrl }}';
    window.open(whatsappUrl, '_blank');
    
    const button = document.querySelector('button[onclick="openWhatsApp()"]');
    if (button) {
        const originalText = button.innerHTML;
        button.innerHTML = '<i class="fas fa-check mr-2"></i> WhatsApp Dibuka!';
        button.classList.remove('bg-green-600', 'hover:bg-green-700');
        button.classList.add('bg-blue-600', 'hover:bg-blue-700');
        
        whatsappOpened = true;
        checkActions();
        
        setTimeout(function() {
            button.innerHTML = originalText;
            button.classList.remove('bg-blue-600', 'hover:bg-blue-700');
            button.classList.add('bg-green-600', 'hover:bg-green-700');
        }, 5000);
    }
}

function checkActions() {
    if (messageCopied || whatsappOpened) {
        document.getElementById('statusUpdateSection').classList.remove('hidden');
    }
}

function updateStatus() {
    if (confirm('Apakah Anda yakin ingin mengupdate status kunjungan ini?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("admin.kunjungan.confirmStatusUpdate", $kunjungan->id) }}';
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);
        
        document.body.appendChild(form);
        form.submit();
    }
}

function hideStatusUpdate() {
    document.getElementById('statusUpdateSection').classList.add('hidden');
}
</script>
@endsection