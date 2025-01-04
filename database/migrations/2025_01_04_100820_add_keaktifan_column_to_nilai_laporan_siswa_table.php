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
        Schema::table('nilai_laporan_siswa', function (Blueprint $table) {
            $table->integer('keaktifan')->default(0)->after('nilai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nilai_laporan_siswa', function (Blueprint $table) {
            $table->dropColumn('keaktifan');
        });
    }
};
