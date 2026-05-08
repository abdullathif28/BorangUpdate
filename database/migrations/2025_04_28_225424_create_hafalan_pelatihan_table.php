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
    Schema::create('hafalan_pelatihan', function (Blueprint $table) {
        $table->id();
        $table->foreignId('pelatihan_id')->constrained('pelatihan')->onDelete('cascade');
        $table->foreignId('id_peserta')->nullable()->constrained('peserta')->onDelete('cascade'); // tambahan
        $table->string('nama_ayat');
        $table->string('sumber')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hafalan_pelatihan');
    }
};
