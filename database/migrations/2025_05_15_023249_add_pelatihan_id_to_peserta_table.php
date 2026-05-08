<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('peserta', function (Blueprint $table) {
            if (!Schema::hasColumn('peserta', 'pelatihan_id')) {
                $table->unsignedBigInteger('pelatihan_id')->nullable()->after('asal_pimpinan');
                $table->foreign('pelatihan_id')
                      ->references('id')
                      ->on('pelatihan')
                      ->onDelete('set null');
            }
        });
    }

    public function down()
    {
        Schema::table('peserta', function (Blueprint $table) {
            $table->dropForeign(['pelatihan_id']);
            $table->dropColumn('pelatihan_id');
        });
    }
};
