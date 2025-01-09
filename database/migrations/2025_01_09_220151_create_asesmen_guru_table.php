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
        Schema::create('asesmen_guru', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guru_id')->constrained('guru')->onDelete('cascade')->onUpdate('cascade');
            $table->float('kedisiplinan');
            $table->float('etika');
            $table->float('tanggung_jawab');
            $table->float('kreatifitas');
            $table->float('komunikasi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asesmen_guru');
    }
};
