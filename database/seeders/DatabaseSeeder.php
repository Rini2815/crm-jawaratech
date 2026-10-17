<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat role terlebih dahulu (ms_role)
        $roleAdmin = Role::firstOrCreate(
            ['nama_role' => 'Super Administrator'],
            ['deskripsi' => 'Akses penuh']
        );

        $roleMarketing = Role::firstOrCreate(
            ['nama_role' => 'Digital Marketing'],
            ['deskripsi' => 'Mengelola follow up konsumen']
        );

        // 2. Buat Akun Super Administrator Utama (ms_pengguna)
        User::updateOrCreate(
            ['email' => 'admin@jawaratech.com'],
            [
                'id_role'  => $roleAdmin->id_role,
                'nama'     => 'Admin Jawaratech',
                'status'   => 'Aktif',
                'password' => Hash::make('password123'), // Password default
            ]
        );

        // 3. Buat Akun Digital Marketing (Opsional, sebagai contoh)
        User::updateOrCreate(
            ['email' => 'marketing@jawaratech.com'],
            [
                'id_role'  => $roleMarketing->id_role,
                'nama'     => 'Digital Marketing',
                'status'   => 'Aktif',
                'password' => Hash::make('password123'),
            ]
        );

        // 4. Hak akses default Digital Marketing sesuai dokumen Analisis Kebutuhan:
        //    hanya Pengingat Perawatan dan Follow-up (dashboard & profil terbuka untuk semua user login)
        DB::table('ms_hak_akses')->where('id_role', $roleMarketing->id_role)->delete();

        foreach (['pengingat-perawatan', 'follow-up'] as $modul) {
            DB::table('ms_hak_akses')->insert([
                'id_role' => $roleMarketing->id_role,
                'modul'   => $modul,
                'aksi'    => 'lihat',
            ]);
        }

        $this->command->info('Akun Admin Jawaratech berhasil dibuat!');
    }
}