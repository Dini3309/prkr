<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus semua data pengguna lama
        DB::table('tb_user')->delete();

        // Isi data pengguna baru
        DB::table('tb_user')->insert([

            [
                'nama_lengkap' => 'Administrator',
                'username'     => 'admin',
                'password'     => Hash::make('admin123'),
                'role'         => 'admin',
                'status_aktif' => 1,
            ],

            [
                'nama_lengkap' => 'Petugas Parkir',
                'username'     => 'petugas',
                'password'     => Hash::make('petugas123'),
                'role'         => 'petugas',
                'status_aktif' => 1,
            ],

            [
                'nama_lengkap' => 'Dini Ayu',
                'username'     => 'owner',
                'password'     => Hash::make('owner123'),
                'role'         => 'owner',
                'status_aktif' => 1,
            ],

        ]);
    }
}