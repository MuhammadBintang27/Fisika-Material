<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alat', function (Blueprint $table) {
            $table->uuid('id')->primary(); // pakai UUID
            $table->string('nama');
            $table->text('deskripsi');
            $table->boolean('isBroken')->default(true);
            $table->integer('stok')->default(1);
            $table->integer('stok_dipinjam')->default(0); // jumlah alat yang sedang dipinjam
            $table->integer('stok_rusak')->default(0); // jumlah alat rusak
            $table->decimal('harga', 15, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alat');
    }
};