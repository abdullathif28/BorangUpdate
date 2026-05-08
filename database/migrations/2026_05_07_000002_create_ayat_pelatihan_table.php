<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ayat_pelatihan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pelatihan_id');
            $table->string('nama_ayat');
            $table->integer('urutan')->default(0);
            $table->timestamps();

            $table->foreign('pelatihan_id')->references('id')->on('pelatihan')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ayat_pelatihan');
    }
};
