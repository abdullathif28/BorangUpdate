<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('observasi_games', function (Blueprint $table) {
            $table->foreign('games_id')
                ->references('id')
                ->on('games')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('observasi_games', function (Blueprint $table) {
            $table->dropForeign(['games_id']);
        });
    }
};
