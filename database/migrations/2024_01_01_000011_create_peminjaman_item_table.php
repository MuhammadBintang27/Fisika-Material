<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peminjaman_item', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('peminjamanId');
            $table->uuid('alat_id');
            $table->integer('jumlah');
            $table->timestamps();

            $table->foreign('peminjamanId')->references('id')->on('peminjaman')->onDelete('cascade');
            $table->foreign('alat_id')->references('id')->on('alat')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjaman_item');
    }
};