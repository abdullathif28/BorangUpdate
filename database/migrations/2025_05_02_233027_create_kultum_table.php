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
        Schema::create('kultum', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_peserta');
            $table->tinyInteger('penguasaan_materi')->default(0);
            $table->tinyInteger('kesesuaian_tema')->default(0);
            $table->tinyInteger('kefasihan')->default(0);
            $table->tinyInteger('adab_sikap')->default(0);
            $table->tinyInteger('daya_tarik')->default(0);
            $table->integer('nilai_total')->nullable();

            $table->timestamps();

            $table->foreign('id_peserta')->references('id')->on('peserta')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kultum');
    }
};
