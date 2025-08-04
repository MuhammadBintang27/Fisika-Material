<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profil_laboratorium', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('namaLaboratorium');
            $table->text('tentangLaboratorium')->nullable();
            $table->text('visi')->nullable();
            $table->timestamps();
        });

        Schema::create('misi', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('profilLaboratoriumId');
            $table->text('pointMisi');
            $table->timestamps();

            $table->foreign('profilLaboratoriumId')
                  ->references('id')
                  ->on('profil_laboratorium')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('misi');
        Schema::dropIfExists('profil_laboratorium');
    }
};
