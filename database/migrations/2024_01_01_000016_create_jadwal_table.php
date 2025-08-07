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
            $table->date('tanggal');
            $table->time('jamMulai');
            $table->time('jamSelesai');
            $table->boolean('isActive')->default(true);
            $table->uuid('kunjunganId')->nullable();
            $table->foreign('kunjunganId')->references('id')->on('kunjungan')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal');
    }
};