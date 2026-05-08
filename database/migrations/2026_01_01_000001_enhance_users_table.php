<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Role: superadmin, admin, iot, mog, observer
            $table->string('role')->default('admin')->after('about');
            $table->string('name')->nullable()->after('lastname');
            
            // Khusus untuk admin (Pimwil/Pimdah)
            $table->string('nama_pimpinan')->nullable()->after('role'); // nama pimpinan daerah/wilayah
            $table->string('tingkat_pimpinan')->nullable()->after('nama_pimpinan'); // Wilayah/Daerah
            $table->string('nama_ketum')->nullable()->after('tingkat_pimpinan');
            $table->string('nomor_hp')->nullable()->after('nama_ketum');
            $table->integer('jumlah_cabang')->nullable()->after('nomor_hp');
            
            // Status pendaftaran admin
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('approved')->after('jumlah_cabang');
            $table->text('catatan_penolakan')->nullable()->after('status');
            
            // Untuk sub-role (IOT, MOG, Observer) - relasi ke admin
            $table->foreignId('admin_id')->nullable()->after('catatan_penolakan')->constrained('users')->nullOnDelete();
            $table->string('token_login')->nullable()->unique()->after('admin_id');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'role', 'name', 'nama_pimpinan', 'tingkat_pimpinan', 'nama_ketum',
                'nomor_hp', 'jumlah_cabang', 'status', 'catatan_penolakan',
                'admin_id', 'token_login'
            ]);
        });
    }
};
