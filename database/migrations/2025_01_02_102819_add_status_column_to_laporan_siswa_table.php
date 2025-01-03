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
            $table->enum('status', ['belum naik kelas', 'naik kelas', 'tidak naik kelas', 'lulus', 'tidak lulus'])->default('belum naik kelas')->after('kelas_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laporan_siswa', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
