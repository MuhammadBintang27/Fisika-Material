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
        Schema::create('pengajuan_hasil', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengajuanId')->constrained('pengajuan_pengujian')->onDelete('cascade');
            $table->string('fileHasil')->nullable(); // Made nullable from fix migration
            // File metadata fields - consolidated from fix_pengajuan_hasil_table migration
            $table->string('namaFile')->nullable();
            $table->string('ukuranFile')->nullable();
            $table->string('tipeFile')->nullable();
            $table->text('catatan')->nullable();
            $table->datetime('uploadedAt')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_hasil');
    }
};
