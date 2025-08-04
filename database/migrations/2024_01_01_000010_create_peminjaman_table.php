<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_code')->unique();
            $table->enum('user_type', ['dosen', 'mahasiswa', 'pihak-luar'])->default('mahasiswa');
            $table->string('namaPeminjam');
            $table->string('noHp');
            $table->string('email')->nullable();
            $table->string('nip_nim')->nullable();
            $table->string('instansi')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('judul_penelitian')->nullable();
            $table->text('deskripsi_penelitian')->nullable();
            $table->text('tujuan_peminjaman')->nullable();
            $table->datetime('tanggal_pinjam');
            $table->datetime('tanggal_pengembalian');
            $table->integer('durasi_jam')->nullable();
            $table->enum('status', ['PENDING', 'APPROVED', 'REJECTED', 'COMPLETED'])->default('PENDING');
            $table->text('notes')->nullable();
            $table->string('supervisor_name')->nullable();
            $table->string('supervisor_nip')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};