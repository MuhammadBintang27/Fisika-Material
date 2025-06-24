<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('namaPeminjam');
            $table->string('noHp');
            $table->text('tujuanPeminjaman')->nullable();
            $table->dateTime('tanggal_pinjam')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('tanggal_pengembalian');
            $table->enum('status', ['PENDING', 'APPROVED', 'REJECTED', 'COMPLETED']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
}; 