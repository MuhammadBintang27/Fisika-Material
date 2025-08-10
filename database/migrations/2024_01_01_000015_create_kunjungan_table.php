<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kunjungan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('tracking_code')->unique();
            $table->string('namaPengunjung');
            $table->string('noHp');
            $table->string('namaInstansi');
            $table->text('tujuan');
            $table->integer('jumlahPengunjung');
            $table->enum('status', ['PENDING', 'APPROVED', 'COMPLETED', 'CANCELLED'])->default('PENDING');
            $table->string('suratPengajuan')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kunjungan');
    }
};