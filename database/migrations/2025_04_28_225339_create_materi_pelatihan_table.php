<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMateriPelatihanTable extends Migration
{
    public function up()
    {
        Schema::create('materi_pelatihan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelatihan_id')->constrained('pelatihan')->onDelete('cascade');
            $table->string('nama_materi');
            $table->integer('urutan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('materi_pelatihan');
    }
}
