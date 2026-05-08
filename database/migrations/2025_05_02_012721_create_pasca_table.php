<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePascaTable extends Migration
{
    public function up()
    {
        Schema::create('observasi_pasca', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('peserta_id');
            $table->unsignedBigInteger('materi_id');

            $table->unsignedTinyInteger('afektif');
            $table->unsignedTinyInteger('psikomotorik');
            $table->unsignedTinyInteger('kognitif');

            $table->timestamps();

            $table->foreign('peserta_id')->references('id')->on('peserta')->onDelete('cascade');
            $table->foreign('materi_id')->references('id')->on('materi_pelatihan')->onDelete('cascade');

            $table->unique(['peserta_id', 'materi_id']); // agar 1 peserta hanya 1 entry per materi
            
        });
    }

    public function down()
    {
        Schema::dropIfExists('observasi_pasca');
    }
}
