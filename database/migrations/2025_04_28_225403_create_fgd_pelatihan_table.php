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
    Schema::create('fgd_pelatihan', function (Blueprint $table) {
        $table->id();
        $table->foreignId('pelatihan_id')->constrained('pelatihan')->onDelete('cascade');
        $table->string('nama_fgd');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fgd_pelatihan');
    }
};
