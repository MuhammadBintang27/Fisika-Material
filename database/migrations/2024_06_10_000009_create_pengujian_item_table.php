<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengujian_item', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('jenisPengujianId');
            $table->uuid('pengujianId');
            $table->timestamps();

            $table->foreign('jenisPengujianId')->references('id')->on('jenis_pengujian')->onDelete('cascade');
            $table->foreign('pengujianId')->references('id')->on('pengujian')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengujian_item');
    }
}; 
 