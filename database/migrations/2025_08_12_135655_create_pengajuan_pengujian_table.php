<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengajuan_pengujian', function (Blueprint $table) {
            $table->id();
            $table->string('trackingCode')->unique();
            // Guest user fields
            $table->string('namaPengaju');
            $table->string('noHp');
            $table->string('email')->nullable();
            $table->string('instansi')->nullable();
            $table->string('alamat')->nullable();
            // User type fields - consolidated from add_user_type_fields migration
            $table->enum('userType', ['UMUM', 'MAHASISWA', 'DOSEN'])->default('UMUM');
            $table->string('nim')->nullable();
            $table->string('nip')->nullable();
            $table->string('prodi')->nullable();
            // Service and request details
            $table->foreignId('layananId')->constrained('layanan_pengujian');
            $table->datetime('tanggalPengajuan')->useCurrent();
            $table->date('tanggalPenyerahan');
            $table->unsignedInteger('jumlahSampel');
            $table->text('deskripsiSampel');
            $table->string('filePendukung')->nullable();
            $table->json('detailKhusus')->nullable();
            $table->enum('status', ['MENUNGGU', 'DISETUJUI', 'DITOLAK', 'DIPROSES', 'SELESAI'])->default('MENUNGGU');
            $table->date('estimasiSelesai')->nullable();
            $table->text('catatanAdmin')->nullable();
            $table->datetime('tanggalSelesai')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_pengujian');
    }
};
