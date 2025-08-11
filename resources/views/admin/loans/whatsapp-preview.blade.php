@extends('admin.layouts.app')

@section('title', 'Preview WhatsApp')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="bg-gradient-to-br from-green-600 to-green-700 rounded-xl p-8 text-white shadow-xl border border-green-500">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold mb-2">Preview Pesan WhatsApp</h1>
                <p class="text-green-100 text-lg">Tinjau pesan sebelum mengirim ke peminjam</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.loans.show', $loan->id) }}" 
                   class="bg-white text-green-700 px-6 py-3 rounded-xl hover:bg-gray-50 transition-all duration-300 shadow-lg hover:shadow-xl font-semibold group">
                    <i class="fas fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform"></i>
                    Kembali ke Detail
                </a>
            </div>
        </div>
    </div>

    <!-- WhatsApp Preview -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
        <div class="p-8">
            <!-- Recipient Info -->
            <div class="mb-8 pb-8 border-b border-gray-200">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-user text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">Informasi Penerima</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Nama Peminjam</label>
                        <p class="text-sm text-gray-900 bg-gray-50 px-4 py-3 rounded-xl border border-gray-200">{{ $loan->namaPeminjam }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Nomor WhatsApp</label>
                        <p class="text-sm text-gray-900 bg-gray-50 px-4 py-3 rounded-xl border border-gray-200">{{ $phone }}</p>
                    </div>
                </div>
            </div>

            <!-- Message Preview -->
            <div class="mb-8">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center">
                        <i class="fab fa-whatsapp text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">Preview Pesan</h3>
                </div>
                <div class="bg-gradient-to-br from-green-50 to-green-100 border border-green-200 rounded-xl p-8">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center mr-4">
                            <i class="fab fa-whatsapp text-white text-xl"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 text-lg">WhatsApp Message</h4>
                            <p class="text-sm text-green-700">Preview pesan yang akan dikirim</p>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl p-6 border border-green-200 shadow-sm">
                        <pre class="text-sm text-gray-900 whitespace-pre-wrap font-sans leading-relaxed">{{ $message }}</pre>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-8 border-t border-gray-200">
                <div class="flex flex-col sm:flex-row items-center space-y-3 sm:space-y-0 sm:space-x-4">
                    <a href="{{ route('admin.loans.show', $loan->id) }}" 
                       class="px-6 py-3 bg-gray-600 text-white rounded-xl hover:bg-gray-700 transition-all duration-300 shadow-lg hover:shadow-xl font-semibold">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali
                    </a>
                    <button onclick="copyMessage()" 
                            class="px-6 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-all duration-300 shadow-lg hover:shadow-xl font-semibold">
                        <i class="fas fa-copy mr-2"></i>
                        Salin Pesan
                    </button>
                </div>
                <button onclick="openWhatsApp()" 
                        class="px-8 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-xl hover:from-green-700 hover:to-green-800 transition-all duration-300 shadow-lg hover:shadow-xl font-semibold">
                    <i class="fab fa-whatsapp mr-2"></i>
                    Buka WhatsApp
                </button>
            </div>

                <!-- Status Update Section -->
                <div id="statusUpdateSection" class="mt-6 pt-6 border-t border-gray-200 hidden">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Update Status</h3>
                    <p class="text-sm text-gray-600 mb-4">Pesan telah dikirim. Apakah Anda ingin mengupdate status peminjaman?</p>
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
        // Show success message
        const button = document.querySelector('button[onclick="copyMessage()"]');
        if (button) {
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-check mr-2"></i> Tersalin!';
            button.classList.remove('bg-blue-600', 'hover:bg-blue-700');
            button.classList.add('bg-green-600', 'hover:bg-green-700');
            
            messageCopied = true;
            checkActions();
            
            // Keep the success state for longer
            setTimeout(function() {
                button.innerHTML = originalText;
                button.classList.remove('bg-green-600', 'hover:bg-green-700');
                button.classList.add('bg-blue-600', 'hover:bg-blue-700');
            }, 5000); // 5 seconds
        }
    }).catch(function(err) {
        console.error('Could not copy text: ', err);
        alert('Gagal menyalin pesan. Silakan salin manual.');
    });
}

function openWhatsApp() {
    const whatsappUrl = '{{ $whatsappUrl }}';
    window.open(whatsappUrl, '_blank');
    
    // Show success message
    const button = document.querySelector('button[onclick="openWhatsApp()"]');
    if (button) {
        const originalText = button.innerHTML;
        button.innerHTML = '<i class="fas fa-check mr-2"></i> WhatsApp Dibuka!';
        button.classList.remove('bg-green-600', 'hover:bg-green-700');
        button.classList.add('bg-blue-600', 'hover:bg-blue-700');
        
        whatsappOpened = true;
        checkActions();
        
        // Keep the success state for longer
        setTimeout(function() {
            button.innerHTML = originalText;
            button.classList.remove('bg-blue-600', 'hover:bg-blue-700');
            button.classList.add('bg-green-600', 'hover:bg-green-700');
        }, 5000); // 5 seconds
    }
}

function checkActions() {
    if (messageCopied || whatsappOpened) {
        document.getElementById('statusUpdateSection').classList.remove('hidden');
    }
}

function updateStatus() {
    if (confirm('Apakah Anda yakin ingin mengupdate status peminjaman ini?')) {
        // Create form and submit to confirm status update
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("admin.loans.confirmStatusUpdate", $loan->id) }}';
        
        // Add CSRF token
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