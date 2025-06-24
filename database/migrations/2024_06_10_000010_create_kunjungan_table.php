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
            $table->string('namaPengunjung');
            $table->text('tujuan')->nullable();
            $table->integer('jumlahPengunjung')->default(1);
            $table->enum('status', ['PENDING', 'PROCESSING', 'COMPLETED', 'CANCELLED'])->default('PENDING');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kunjungan');
    }
}; 
 