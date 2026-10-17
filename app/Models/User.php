<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

#[Fillable(['id_role', 'google_id', 'nama', 'email', 'no_whatsapp', 'password', 'status'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $table = 'ms_pengguna';
    protected $primaryKey = 'id_pengguna';

    /** Daftar menu yang boleh dilihat role ini (diisi sekali per request) */
    protected ?array $menuCache = null;

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi ke tabel ms_role
     */
    public function peran()
    {
        return $this->belongsTo(Role::class, 'id_role', 'id_role');
    }

    /**
     * Supaya Auth::user()->name di view lama tetap berfungsi (hanya untuk membaca)
     */
    public function getNameAttribute()
    {
        return $this->attributes['nama'] ?? null;
    }

    /**
     * Supaya Auth::user()->role tetap berisi nama role, misal "Super Administrator" (hanya untuk membaca)
     */
    public function getRoleAttribute()
    {
        return $this->peran?->nama_role;
    }

    /**
     * Apakah user ini Super Administrator
     */
    public function isSuperadmin(): bool
    {
        return strtolower(trim($this->role ?? '')) === 'super administrator';
    }

    /**
     * Cek apakah user memiliki akses ke menu tertentu berdasarkan role-nya
     */
    public function hasMenu($menuKey)
    {
        // Super Administrator selalu punya akses ke seluruh menu
        if ($this->isSuperadmin()) {
            return true;
        }

        if (!$this->id_role) {
            return false;
        }

        // Role lain: baca ms_hak_akses (modul = kunci menu, aksi 'lihat'), cukup sekali per request
        if ($this->menuCache === null) {
            $this->menuCache = DB::table('ms_hak_akses')
                ->where('id_role', $this->id_role)
                ->where('aksi', 'lihat')
                ->pluck('modul')
                ->all();
        }

        return in_array($menuKey, $this->menuCache, true);
    }
}