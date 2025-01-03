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
        Schema::table('laporan_siswa', function (Blueprint $table) {
            $table->foreignId('kelas_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laporan_siswa', function (Blueprint $table) {
            $table->dropForeign('laporan_siswa_kelas_id_foreign');
            $table->dropColumn('kelas_id');
        });
    }
};

