<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat Akun Super Administrator Utama
        User::create([
            'name'     => 'Admin Jawaratech',
            'email'    => 'admin@jawaratech.com',
            'role'     => 'Super Administrator',
            'status'   => 'Aktif',
            'password' => Hash::make('password123'), // Password default
        ]);

        // 2. Buat Akun Digital Marketing (Opsional, sebagai contoh)
        User::create([
            'name'     => 'Digital Marketing',
            'email'    => 'marketing@jawaratech.com',
            'role'     => 'Digital Marketing',
            'status'   => 'Aktif',
            'password' => Hash::make('password123'),
        ]);
        
        $this->command->info('Akun Admin Jawaratech berhasil dibuat!');
    }
}