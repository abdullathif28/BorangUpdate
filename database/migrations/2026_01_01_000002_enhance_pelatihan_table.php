<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pelatihan', function (Blueprint $table) {
            // Relasi ke admin yang membuat pelatihan
            $table->foreignId('admin_id')->nullable()->after('id')->constrained('users')->nullOnDelete();
            // Status pelatihan: pending, aktif, selesai, ditolak
            $table->enum('status', ['pending', 'aktif', 'selesai', 'ditolak'])->default('pending')->after('admin_id');
            $table->text('catatan_superadmin')->nullable()->after('status');
            $table->integer('jumlah_games')->nullable()->after('jumlah_kajian');
        });
    }

    public function down(): void
    {
        Schema::table('pelatihan', function (Blueprint $table) {
            $table->dropForeign(['admin_id']);
            $table->dropColumn(['admin_id', 'status', 'catatan_superadmin', 'jumlah_games']);
        });
    }
};
