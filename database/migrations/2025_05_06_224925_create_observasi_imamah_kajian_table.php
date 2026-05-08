<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('observasi_imamah_kajian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('imamah_id')->constrained('imamah_kajian')->onDelete('cascade');
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
        Schema::dropIfExists('observasi_imamah_kajian');
    }
};
