<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('pengujianId')->nullable();
            $table->uuid('kunjunganId')->nullable();
            $table->datetime('tanggalMulai')->default(now());
            $table->datetime('tanggalSelesai')->nullable();
            $table->timestamps();

            $table->foreign('pengujianId')->references('id')->on('pengujian')->onDelete('cascade');
            $table->foreign('kunjunganId')->references('id')->on('kunjungan')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal');
    }
}; 
 