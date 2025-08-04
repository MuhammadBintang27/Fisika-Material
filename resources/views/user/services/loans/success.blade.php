@extends('user.layouts.app')
@section('content')
<div class="container py-5">
    <div class="alert alert-success">
        <h4>Pengajuan Peminjaman Berhasil!</h4>
        <p>Permohonan peminjaman alat Anda telah berhasil dikirim.</p>
        <p>Untuk memantau status peminjaman Anda, silakan gunakan link berikut:</p>
        <div class="mb-3">
            <a href="{{ $tracking_link }}" class="btn btn-primary">Cek Status Peminjaman</a>
        </div>
        <small>Catat atau bookmark link ini untuk mengecek status peminjaman Anda kapan saja.</small>
    </div>
</div>
@endsection