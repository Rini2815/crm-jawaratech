<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Bersihkan tabel terlebih dahulu
        DB::table('role_menus')->truncate();

        // 1. Beri Superadmin akses ke SEMUA menu
        $superadminMenus = ['hak-akses', 'kelola-akun', 'user-group', 'layanan-servis'];
        foreach ($superadminMenus as $menu) {
            DB::table('role_menus')->insert([
                'role' => 'Superadmin',
                'menu_key' => $menu,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 2. Beri Digital Marketing akses ke Layanan Servis SAJA
        DB::table('role_menus')->insert([
            'role' => 'Digital Marketing',
            'menu_key' => 'layanan-servis',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}