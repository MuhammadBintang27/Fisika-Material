<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengujian', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('namaPenguji');
            $table->string('noHpPenguji');
            $table->text('deskripsi');
            $table->integer('totalHarga');
            $table->datetime('tanggalPengujian')->default(now());
            $table->enum('status', ['PENDING', 'PROCESSING', 'COMPLETED', 'CANCELLED'])->default('PENDING');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengujian');
    }
}; 
 