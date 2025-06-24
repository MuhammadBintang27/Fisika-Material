<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('misi', 'misi') && !Schema::hasColumn('misi', 'pointMisi')) {
            Schema::table('misi', function (Blueprint $table) {
                $table->renameColumn('misi', 'pointMisi');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('misi', 'pointMisi') && !Schema::hasColumn('misi', 'misi')) {
            Schema::table('misi', function (Blueprint $table) {
                $table->renameColumn('pointMisi', 'misi');
            });
        }
    }
}; 