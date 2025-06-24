<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tambah kolom visi jika belum ada
        if (!Schema::hasColumn('profil_laboratorium', 'visi')) {
            Schema::table('profil_laboratorium', function (Blueprint $table) {
                $table->text('visi')->nullable()->after('tentangLaboratorium');
            });
        }
        // Rename deskripsi ke tentangLaboratorium jika masih ada
        if (Schema::hasColumn('profil_laboratorium', 'deskripsi') && !Schema::hasColumn('profil_laboratorium', 'tentangLaboratorium')) {
            Schema::table('profil_laboratorium', function (Blueprint $table) {
                $table->renameColumn('deskripsi', 'tentangLaboratorium');
            });
        }
    }

    public function down(): void
    {
        // Hapus kolom visi jika ada
        if (Schema::hasColumn('profil_laboratorium', 'visi')) {
            Schema::table('profil_laboratorium', function (Blueprint $table) {
                $table->dropColumn('visi');
            });
        }
        // Rename tentangLaboratorium ke deskripsi jika perlu rollback
        if (Schema::hasColumn('profil_laboratorium', 'tentangLaboratorium') && !Schema::hasColumn('profil_laboratorium', 'deskripsi')) {
            Schema::table('profil_laboratorium', function (Blueprint $table) {
                $table->renameColumn('tentangLaboratorium', 'deskripsi');
            });
        }
    }
}; 