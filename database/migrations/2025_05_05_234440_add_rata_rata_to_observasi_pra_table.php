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
        foreach (['observasi_pra', 'observasi_proses', 'observasi_pasca'] as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->float('rata_rata')->nullable()->after('psikomotorik');
            });
        }
    }

    public function down()
    {
        foreach (['observasi_pra', 'observasi_proses', 'observasi_pasca'] as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->dropColumn('rata_rata');
            });
        }
    }
};
