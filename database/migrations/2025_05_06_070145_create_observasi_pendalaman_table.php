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
    Schema::create('observasi_pendalaman', function (Blueprint $table) {
        $table->id();
        $table->foreignId('materi_id')->constrained('materi_pelatihan')->onDelete('cascade');
        $table->foreignId('peserta_id')->constrained('peserta')->onDelete('cascade');
        $table->boolean('afektif')->default(false);
        $table->boolean('kognitif')->default(false);
        $table->boolean('psikomotorik')->default(false);
        $table->boolean('jumlah')->default(false);
        $table->timestamps();
    });
}



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('observasi_pendalamen');
    }
};
