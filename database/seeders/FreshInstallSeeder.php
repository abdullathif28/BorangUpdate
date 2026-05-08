<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class FreshInstallSeeder extends Seeder
{
    /**
     * Hapus semua data lama (termasuk admin, pelatihan, peserta, borang),
     * lalu buat ulang akun Superadmin bersih.
     *
     * Jalankan dengan:
     *   php artisan db:seed --class=FreshInstallSeeder
     * atau:
     *   php artisan db:seed  (jika DatabaseSeeder memanggil ini)
     */
    public function run(): void
    {
        $this->command->info('🧹 Membersihkan semua data lama...');

        // Nonaktifkan foreign key check sementara
        Schema::disableForeignKeyConstraints();

        // =========================================================
        // HAPUS DATA — urutan dari child ke parent (hindari FK error)
        // =========================================================

        // Borang / observasi (child paling dalam)
        DB::table('hafalan_nilai')->truncate();
        DB::table('hafalan')->truncate();
        DB::table('hafalan_pelatihan')->truncate();
        DB::table('absensi')->truncate();
        DB::table('observasi_proses')->truncate();
        DB::table('observasi_pra')->truncate();
        DB::table('observasi_pasca')->truncate();
        DB::table('observasi_pendalaman')->truncate();
        DB::table('observasi_imamah_kajian')->truncate();
        DB::table('observasi_games')->truncate();
        DB::table('kultum')->truncate();
        DB::table('notulensi_pertanyaan')->truncate();
        DB::table('notulensi')->truncate();
        DB::table('pimpinans')->truncate();

        // Struktur pelatihan (child)
        DB::table('ayat_pelatihan')->truncate();
        DB::table('materi_pelatihan')->truncate();
        DB::table('fgd_pelatihan')->truncate();
        DB::table('imamah_kajian')->truncate();
        DB::table('games')->truncate();

        // Peserta
        DB::table('peserta')->truncate();

        // Pelatihan
        DB::table('pelatihan')->truncate();

        // Users (admin, iot, mog, observer) — tapi JANGAN hapus superadmin dulu
        DB::table('users')->where('role', '!=', 'superadmin')->delete();

        // Hapus superadmin lama juga agar bisa buat ulang yang fresh
        DB::table('users')->truncate();

        $this->command->info('✅ Semua data lama berhasil dihapus.');

        // =========================================================
        // BUAT ULANG SUPERADMIN
        // =========================================================

        DB::table('users')->insert([
            'name'       => 'Super Admin',
            'username'   => 'superadmin',
            'email'      => 'superadmin@borangdigital.id',
            'password'   => Hash::make('superadmin123'),
            'role'       => 'superadmin',
            'status'     => 'approved',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Aktifkan kembali foreign key check
        Schema::enableForeignKeyConstraints();

        $this->command->info('');
        $this->command->info('✅ Fresh install selesai! Akun Superadmin:');
        $this->command->info('   Email    : superadmin@borangdigital.id');
        $this->command->info('   Password : superadmin123');
        $this->command->info('');
        $this->command->warn('⚠️  Segera ganti password Superadmin setelah login pertama!');
    }
}
