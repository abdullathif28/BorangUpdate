<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
{
    Schema::create('notulensi', function (Blueprint $table) {
        $table->id();
        $table->foreignId('pelatihan_id')->constrained('pelatihan')->onDelete('cascade');
        $table->foreignId('materi_id')->constrained('materi_pelatihan')->onDelete('cascade');
        $table->string('pengampu');
        $table->string('moderator');
        $table->string('notulis');
        $table->date('tanggal');
        $table->time('waktu_mulai');
        $table->time('waktu_selesai');
        $table->integer('jumlah_peserta');
        $table->text('kondisi_peserta');
        $table->text('pokok_materi');
        $table->text('jalannya_materi');
        $table->text('pokok_pembahasan');
        $table->timestamps();
    });
}


    public function down(): void
    {
        Schema::dropIfExists('notulensi');
    }
};
