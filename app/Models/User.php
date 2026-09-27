<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

#[Fillable(['name', 'email', 'password', 'role'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Cek apakah user memiliki akses ke menu tertentu berdasarkan role-nya
     */
    public function hasMenu($menuKey)
    {
        $userRole = strtolower(trim($this->role ?? $this->level ?? ''));
        $userName = strtolower(trim($this->name ?? ''));

        // Jika role ATAU nama user mengandung kata 'admin' / 'superadmin', OTOMATIS BISA AKSES SEMUA MENU
        if (
            empty($userRole) || 
            in_array($userRole, ['superadmin', 'super admin', 'super_admin', 'admin']) ||
            str_contains($userRole, 'admin') ||
            str_contains($userName, 'superadmin')
        ) {
            return true;
        }

        // Cek ke tabel role_menus
        return DB::table('role_menus')
            ->whereRaw('LOWER(role) = ?', [$userRole])
            ->where('menu_key', $menuKey)
            ->exists();
    }
}