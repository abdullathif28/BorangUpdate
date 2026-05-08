<?php

// 2025_04_26_000002_create_hafalan_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHafalanTable extends Migration
{
    public function up()
    {
        Schema::create('hafalan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peserta_id')->constrained('peserta')->onDelete('cascade');
            $table->string('surat_1')->nullable();
            $table->string('surat_2')->nullable();
            $table->string('surat_3')->nullable();
            $table->string('surat_4')->nullable();
            $table->string('surat_5')->nullable();
            $table->string('surat_6')->nullable();
            $table->string('surat_7')->nullable();
            $table->integer('nilai')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('hafalan');
    }
}
