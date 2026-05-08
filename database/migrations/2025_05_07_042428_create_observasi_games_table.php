<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('observasi_games', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('games_id');
            $table->unsignedBigInteger('peserta_id');
            $table->integer('afektif')->default(0);
            $table->integer('kognitif')->default(0);
            $table->integer('psikomotorik')->default(0);
            $table->integer('jumlah')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('observasi_games');
    }
};