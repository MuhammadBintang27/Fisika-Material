<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jenis_pengujian', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('namaPengujian');
            $table->integer('hargaPerSampel');
            $table->boolean('isAvailable')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jenis_pengujian');
    }
}; 
 