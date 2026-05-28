<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Drop foreign key (safe catch)
        try {
            DB::statement('ALTER TABLE absensi DROP FOREIGN KEY absensi_materi_id_foreign');
        } catch (\Exception $e) {
            // Abaikan jika foreign key sudah terlanjur terhapus dari percobaan sebelumnya
        }

        // 2. Add peserta_id index for the remaining peserta_id foreign key
        try {
            Schema::table('absensi', function (Blueprint $table) {
                $table->index('peserta_id');
            });
        } catch (\Exception $e) {
            // Abaikan jika index sudah ada
        }

        // 3. Drop old unique constraint
        try {
            DB::statement('ALTER TABLE absensi DROP INDEX absensi_peserta_id_materi_id_unique');
        } catch (\Exception $e) {
            // Abaikan jika sudah terhapus
        }

        // 4. Add kategori column if it doesn't exist
        if (!Schema::hasColumn('absensi', 'kategori')) {
            Schema::table('absensi', function (Blueprint $table) {
                $table->string('kategori', 50)->default('materi')->after('materi_id');
            });
        }

        // 5. Add new unique constraint
        try {
            Schema::table('absensi', function (Blueprint $table) {
                $table->unique(['peserta_id', 'materi_id', 'kategori'], 'absensi_peserta_materi_kategori_unique');
            });
        } catch (\Exception $e) {
            // Abaikan jika unique sudah ada
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('absensi', function (Blueprint $table) {
            $table->dropUnique('absensi_peserta_materi_kategori_unique');
            $table->dropColumn('kategori');
            $table->foreign('materi_id')->references('id')->on('materi_pelatihan')->onDelete('cascade');
            $table->unique(['peserta_id', 'materi_id']);
        });
    }
};
