<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@sipeba.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Petugas
        User::create([
            'name' => 'Petugas Satu',
            'email' => 'petugas1@sipeba.com',
            'password' => Hash::make('password'),
            'role' => 'petugas',
        ]);

        User::create([
            'name' => 'Petugas Dua',
            'email' => 'petugas2@sipeba.com',
            'password' => Hash::make('password'),
            'role' => 'petugas',
        ]);

        // Pegawai
        User::create([
            'name' => 'Pegawai Satu',
            'email' => 'pegawai1@sipeba.com',
            'password' => Hash::make('password'),
            'role' => 'pegawai',
        ]);

        User::create([
            'name' => 'Pegawai Dua',
            'email' => 'pegawai2@sipeba.com',
            'password' => Hash::make('password'),
            'role' => 'pegawai',
        ]);

        User::create([
            'name' => 'Pegawai Tiga',
            'email' => 'pegawai3@sipeba.com',
            'password' => Hash::make('password'),
            'role' => 'pegawai',
        ]);
    }
}
