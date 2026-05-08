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
    Schema::table('absensi', function (Blueprint $table) {
        $table->string('peserta_nama')->nullable(); // Menambahkan kolom nama peserta
    });
}

public function down()
{
    Schema::table('absensi', function (Blueprint $table) {
        $table->dropColumn('peserta_nama');
    });
}

};
