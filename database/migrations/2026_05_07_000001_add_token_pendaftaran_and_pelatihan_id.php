<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Token pendaftaran peserta pada pelatihan
        if (!Schema::hasColumn('pelatihan', 'token_pendaftaran')) {
            Schema::table('pelatihan', function (Blueprint $table) {
                $table->string('token_pendaftaran', 10)->nullable()->unique()->after('admin_id');
            });
        }

        // Pelatihan_id pada users untuk sub-role (IOT/MOG/Observer)
        if (!Schema::hasColumn('users', 'pelatihan_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->unsignedBigInteger('pelatihan_id')->nullable()->after('admin_id');
                $table->foreign('pelatihan_id')->references('id')->on('pelatihan')->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['pelatihan_id']);
            $table->dropColumn('pelatihan_id');
        });

        Schema::table('pelatihan', function (Blueprint $table) {
            $table->dropColumn('token_pendaftaran');
        });
    }
};
