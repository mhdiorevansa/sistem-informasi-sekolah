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
        Schema::create('pembayaran_spp', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('data_siswa')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('periode_spp')->constrained('spp')->onUpdate('cascade')->onDelete('cascade');
            $table->float('jumlah_bayar');
            $table->date('tanggal_bayar');
            $table->string('status_bayar', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran_spp');
    }
};
