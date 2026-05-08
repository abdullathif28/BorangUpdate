<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObservasiProsesTable extends Migration
{
    public function up()
    {
        Schema::create('observasi_proses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('peserta_id');
            $table->unsignedBigInteger('materi_id');
            
            $table->foreign('peserta_id')->references('id')->on('peserta')->onDelete('cascade');
            $table->foreign('materi_id')->references('id')->on('materi_pelatihan')->onDelete('cascade');

            $table->unsignedTinyInteger('afektif');
            $table->unsignedTinyInteger('psikomotorik');
            $table->unsignedTinyInteger('kognitif');
            $table->timestamps();

            $table->unique(['peserta_id', 'materi_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('observasi_proses');
    }
}
