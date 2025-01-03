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
        Schema::create('nilai_laporan_siswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laporan_siswa_id')->constrained('laporan_siswa')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('mata_pelajaran_id')->constrained('mata_pelajaran')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('nilai');
            $table->integer('alfa');
            $table->integer('sakit');
            $table->integer('izin');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_laporan_siswa');
    }
};

