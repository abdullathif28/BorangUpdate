<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Peserta;

class PesertaSeeder extends Seeder
{
    public function run()
    {
        $namaPeserta = [
            ['nama' => 'Ahmad Rizki', 'jenis_kelamin' => 'Laki-laki'],
            ['nama' => 'Dina Lestari', 'jenis_kelamin' => 'Perempuan'],
            ['nama' => 'Bagus Saputra', 'jenis_kelamin' => 'Laki-laki'],
            ['nama' => 'Siti Nurhaliza', 'jenis_kelamin' => 'Perempuan'],
            ['nama' => 'Rian Maulana', 'jenis_kelamin' => 'Laki-laki'],
            ['nama' => 'Desi Fitriani', 'jenis_kelamin' => 'Perempuan'],
            ['nama' => 'Aditya Pratama', 'jenis_kelamin' => 'Laki-laki'],
            ['nama' => 'Laila Azizah', 'jenis_kelamin' => 'Perempuan'],
        ];

        foreach ($namaPeserta as $peserta) {
            Peserta::create([
                'nama' => $peserta['nama'],
                'asal_pimpinan' => 'PC IPM Brebes',
                'alamat' => 'Brebes',
                'ttl' => 'Brebes, 1 Januari 2005', // Contoh TTL
                'jenis_kelamin' => $peserta['jenis_kelamin'],
                'nomor_hp' => rand(80000000000, 89999999999), // Random nomor HP
                'moto_hidup' => 'Menjadi yang terbaik', // Contoh moto hidup
            ]);
        }
    }
}
