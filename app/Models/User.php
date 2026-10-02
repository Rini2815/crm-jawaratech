<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

#[Fillable(['name', 'email', 'password', 'role', 'status'])]
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
        $userRoleStr = strtolower(trim($this->role ?? $this->level ?? ''));
        $userNameStr = strtolower(trim($this->name ?? ''));

        // 1. Super Admin selalu kebal dan punya akses ke seluruh menu
        if (
            empty($userRoleStr) || 
            in_array($userRoleStr, ['superadmin', 'super admin', 'super_admin', 'admin', 'super administrator']) ||
            str_contains($userRoleStr, 'admin') ||
            str_contains($userNameStr, 'superadmin')
        ) {
            return true;
        }

        // 2. Baca file izin JSON yang disimpan oleh UserGroupController
        $permissionsFile = 'user_permissions.json';
        if (!Storage::exists($permissionsFile)) {
            return false;
        }

        $permissions = json_decode(Storage::get($permissionsFile), true) ?? [];
        $currentRole = trim($this->role ?? '');

        // 3. Cek izin langsung sesuai nama role
        if (isset($permissions[$currentRole][$menuKey]) && $permissions[$currentRole][$menuKey] == 1) {
            return true;
        }

        // 4. Pengecekan fallback (kebal huruf besar/kecil)
        foreach ($permissions as $roleName => $menus) {
            if (strcasecmp($roleName, $currentRole) === 0) {
                return !empty($menus[$menuKey]);
            }
        }

        return false;
    }
}