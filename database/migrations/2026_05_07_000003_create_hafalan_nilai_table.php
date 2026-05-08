<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hafalan_nilai', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('peserta_id');
            $table->unsignedBigInteger('ayat_pelatihan_id');
            $table->boolean('hafal')->default(false);
            $table->decimal('nilai', 5, 2)->default(0);
            $table->timestamps();

            $table->foreign('peserta_id')->references('id')->on('peserta')->onDelete('cascade');
            $table->foreign('ayat_pelatihan_id')->references('id')->on('ayat_pelatihan')->onDelete('cascade');
            $table->unique(['peserta_id', 'ayat_pelatihan_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hafalan_nilai');
    }
};
