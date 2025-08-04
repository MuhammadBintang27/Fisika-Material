<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gambar', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('pengurusId')->nullable();
            $table->uuid('acaraId')->nullable();
            $table->uuid('alatID')->nullable();
            $table->string('url');
            $table->enum('kategori', ['PENGURUS', 'ACARA', 'ALAT']);
            $table->timestamps();

            $table->foreign('pengurusId')->references('id')->on('biodata_pengurus')->onDelete('cascade');
            $table->foreign('acaraId')->references('id')->on('artikel')->onDelete('cascade');
            $table->foreign('alatID')->references('id')->on('alat')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gambar');
    }
}; 