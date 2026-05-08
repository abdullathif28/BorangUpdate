<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('pelatihan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lfp');
            $table->string('email_lfp');
            $table->string('nama_mot')->nullable();  // Nama MOT bisa NULL
            $table->string('nba_mot')->nullable();
            $table->string('nama_asisten_mot');
            $table->string('hp_asisten_mot');
            $table->string('nama_pelatihan');
            $table->string('penyelenggara');
            $table->string('nama_ketum');
            $table->string('nba_ketum');
            $table->date('tanggal_pelatihan');
            $table->string('tempat_pelatihan');
            $table->integer('jumlah_materi');
            $table->integer('jumlah_fgd');
            $table->integer('jumlah_hafalan');
            $table->integer('jumlah_kajian');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelatihan');
    }
};
