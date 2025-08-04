<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('artikel', function (Blueprint $table) {
           $table->uuid('id')->primary();
            $table->string('namaAcara');
            $table->text('deskripsi');
            $table->string('penulis')->nullable();
            $table->dateTime('tanggalAcara')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamps();
            $table->text('deskripsi_penulis')->nullable();
        
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('artikel');
    }
};