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
    Schema::create('peserta', function (Blueprint $table) {
        $table->id();
        $table->string('nama');
        $table->string('asal_pimpinan');
        $table->string('alamat');
        $table->string('ttl'); // atau bisa dibuat jadi dua kolom: tempat_lahir & tanggal_lahir
        $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
        $table->string('nomor_hp');
        $table->string('moto_hidup');
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peserta');
    }
};
