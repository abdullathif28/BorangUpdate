<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('absensi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peserta_id')->constrained('peserta')->onDelete('cascade');
            $table->foreignId('materi_id')->constrained('materi_pelatihan')->onDelete('cascade');
            $table->boolean('hadir')->default(false);
            $table->timestamps();

            $table->unique(['peserta_id', 'materi_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('absensi');
    }
};

