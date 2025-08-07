@extends('user.layouts.app')
@section('title', 'Booking Kunjungan Laboratorium')
@section('content')
<style>
    .spinner {
        border: 2px solid #f3f3f3;
        border-top: 2px solid #3498db;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        animation: spin 1s linear infinite;
        display: inline-block;
        vertical-align: middle;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
<div class="max-w-2xl mx-auto py-16 px-4">
    <h1 class="text-4xl font-bold mb-8 text-center">Booking Kunjungan Laboratorium</h1>
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700 text-center font-semibold">
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700 text-center font-semibold">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif
    <div class="bg-white rounded-lg shadow p-8">
        <h2 class="text-2xl font-semibold mb-6 text-center">Formulir Kunjungan</h2>
        <form action="{{ route('user.kunjungan.store') }}" method="POST" enctype="multipart/form-data" id="visit-form">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2" for="namaPengunjung">Nama Pengunjung *</label>
                <input type="text" name="namaPengunjung" id="namaPengunjung" required class="w-full px-4 py-3 border border-gray-200 rounded-xl" value="{{ old('namaPengunjung') }}" aria-label="Nama Pengunjung">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2" for="noHp">Nomor HP *</label>
                <input type="text" name="noHp" id="noHp" required class="w-full px-4 py-3 border border-gray-200 rounded-xl" value="{{ old('noHp') }}" aria-label="Nomor HP">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2" for="namaInstansi">Nama Instansi *</label>
                <input type="text" name="namaInstansi" id="namaInstansi" required class="w-full px-4 py-3 border border-gray-200 rounded-xl" value="{{ old('namaInstansi') }}" aria-label="Nama Instansi">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2" for="tujuan">Tujuan Kunjungan *</label>
                <input type="text" name="tujuan" id="tujuan" required class="w-full px-4 py-3 border border-gray-200 rounded-xl" value="{{ old('tujuan') }}" aria-label="Tujuan Kunjungan">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2" for="jumlahPengunjung">Jumlah Pengunjung *</label>
                <input type="number" name="jumlahPengunjung" id="jumlahPengunjung" min="1" max="50" required class="w-full px-4 py-3 border border-gray-200 rounded-xl" value="{{ old('jumlahPengunjung', 1) }}" aria-label="Jumlah Pengunjung">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2" for="tanggal">Tanggal Kunjungan *</label>
                <input type="date" name="tanggal" id="tanggal" required class="w-full px-4 py-3 border border-gray-200 rounded-xl" value="{{ old('tanggal') }}" min="{{ now()->toDateString() }}" aria-label="Tanggal Kunjungan">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2" for="jamMulai">Pilih Jam Kunjungan *</label>
                <select name="jamMulai" id="jamMulai" required class="w-full px-4 py-3 border border-gray-200 rounded-xl" aria-label="Pilih Jam Mulai Kunjungan">
                    <option value="">-- Pilih Jam Mulai --</option>
                </select>
                <input type="hidden" name="jamSelesai" id="jamSelesai" aria-hidden="true">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2" for="suratPengajuan">Upload Surat Pengajuan (PDF/JPG/PNG, max 2MB) *</label>
                <input type="file" name="suratPengajuan" id="suratPengajuan" accept=".pdf,.jpg,.jpeg,.png" required class="w-full px-4 py-3 border border-gray-200 rounded-xl" aria-label="Upload Surat Pengajuan">
            </div>
            <div class="flex justify-end mt-8">
                <button type="submit" class="px-8 py-3 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 transition" aria-label="Kirim Permohonan Kunjungan">Kirim Permohonan</button>
            </div>
        </form>
    </div>
</div>
<script>
// In visit.blade.php, inside the <script> tag
document.addEventListener('DOMContentLoaded', function() {
    const tanggalInput = document.getElementById('tanggal');
    const jamMulaiSelect = document.getElementById('jamMulai');
    const jamSelesaiInput = document.getElementById('jamSelesai');
    const form = document.getElementById('visit-form');

    tanggalInput.addEventListener('change', function() {
        const tanggal = this.value;
        if (!tanggal) {
            jamMulaiSelect.innerHTML = '<option value="">-- Pilih Jam Mulai --</option>';
            return;
        }

        jamMulaiSelect.innerHTML = '<option value="">Memuat... <span class="spinner"></span></option>';

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        if (!csrfToken) {
            jamMulaiSelect.innerHTML = '<option value="">Gagal: CSRF token tidak ditemukan</option>';
            return;
        }

        fetch(`/jadwal/get-available-sessions?date=${tanggal}`, {
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            jamMulaiSelect.innerHTML = '<option value="">-- Pilih Jam Mulai --</option>';
            if (data.error) {
                jamMulaiSelect.innerHTML = `<option value="">${data.error}</option>`;
            } else if (data.available_sessions && data.available_sessions.length > 0) {
                data.available_sessions.forEach(session => {
                    const option = document.createElement('option');
                    option.value = session.jamMulai;
                    option.textContent = `${session.jamMulai.substring(0, 5)} - ${session.jamSelesai.substring(0, 5)}`;
                    option.dataset.jamSelesai = session.jamSelesai;
                    jamMulaiSelect.appendChild(option);
                });
            } else {
                jamMulaiSelect.innerHTML = '<option value="">Tidak ada jadwal tersedia untuk tanggal ini</option>';
            }
            jamSelesaiInput.value = '';
        })
        .catch(error => {
            console.error('Fetch error:', error.message);
            jamMulaiSelect.innerHTML = '<option value="">Gagal memuat jadwal: Silakan coba lagi</option>';
        });
    });

    jamMulaiSelect.addEventListener('change', function() {
        const selected = this.options[this.selectedIndex];
        jamSelesaiInput.value = selected ? selected.dataset.jamSelesai : '';
    });

    // Remove redundant validation since server-side validation handles this
    form.addEventListener('submit', function(e) {
        if (!jamMulaiSelect.value) {
            e.preventDefault();
            alert('Pilih jam kunjungan terlebih dahulu.');
        }
    });
});
</script>
@endsection