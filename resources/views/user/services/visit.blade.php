@extends('user.layouts.app')
@section('title', 'Booking Kunjungan Laboratorium')
@section('content')
<div class="max-w-2xl mx-auto py-16 px-4">
    <h1 class="text-4xl font-bold mb-8 text-center">Booking Kunjungan Laboratorium</h1>
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700 text-center font-semibold">
            {{ session('success') }}
        </div>
    @endif
    <div class="bg-white rounded-lg shadow p-8">
        <h2 class="text-2xl font-semibold mb-6 text-center">Formulir Kunjungan</h2>
        <form action="{{ route('kunjungan.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Nama Pengunjung / Instansi *</label>
                <input type="text" name="namaPengunjung" required class="w-full px-4 py-3 border border-gray-200 rounded-xl">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Tujuan Kunjungan</label>
                <input type="text" name="tujuan" class="w-full px-4 py-3 border border-gray-200 rounded-xl">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Jumlah Pengunjung *</label>
                <input type="number" name="jumlahPengunjung" min="1" value="1" required class="w-full px-4 py-3 border border-gray-200 rounded-xl">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Tanggal Kunjungan *</label>
                <input type="date" name="tanggalKunjungan" required class="w-full px-4 py-3 border border-gray-200 rounded-xl">
            </div>
            <div class="flex justify-end mt-8">
                <button type="submit" class="px-8 py-3 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 transition">Kirim Permohonan</button>
            </div>
        </form>
    </div>
</div>
@endsection 