<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengujian', function (Blueprint $table) {
            $table->uuid('id')->primary(); // GANTI dari $table->id()
            $table->string('namaPemohon');
            $table->string('noHp');
            $table->string('email')->nullable();
            $table->string('instansi')->nullable();
            $table->text('deskripsi_sampel');
            $table->datetime('tanggal_pengujian');
            $table->enum('status', ['PENDING', 'APPROVED', 'REJECTED', 'COMPLETED'])->default('PENDING');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengujian');
    }
};