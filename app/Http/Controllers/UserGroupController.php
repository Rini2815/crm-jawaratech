<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class UserGroupController extends Controller
{
    private $permissionsFilePath = 'user_permissions.json';
    private $rolesFilePath = 'user_roles.json';

    /**
     * Tampilan Utama User Group & Matriks Hak Akses
     */
    public function index(Request $request)
    {
        // 1. Total User terdaftar
        $totalUsers = User::count();

        // 2. Hitung statistik user berdasarkan role
        $hasRoleColumn = Schema::hasColumn('users', 'role');
        $superCount = 0;
        $adminCount = 0;
        $verifikatorCount = 0;
        $userCount = 0;

        if ($hasRoleColumn) {
            $superCount = User::whereRaw('LOWER(role) LIKE ?', ['%super%'])->count();
            $adminCount = User::whereRaw('LOWER(role) = ?', ['admin'])->count();
            $verifikatorCount = User::whereRaw('LOWER(role) = ?', ['verifikator'])->count();
            $userCount = User::whereRaw('LOWER(role) = ?', ['user'])->count();
        } else {
            $superCount = 1;
            $userCount = max(0, $totalUsers - 1);
        }

        // 3. Ambil Daftar Role (Bawaan + Role Baru Hasil Tambah Role)
        $defaultRoles = [
            ['id' => 1, 'name' => 'Super Administrator', 'users' => $superCount, 'status' => 'Active'],
            ['id' => 2, 'name' => 'Digital Marketing', 'users' => $adminCount, 'status' => 'Active'],
        ];

        if (Storage::exists($this->rolesFilePath)) {
            $customRoles = json_decode(Storage::get($this->rolesFilePath), true) ?? [];
            $rolesData = array_merge($defaultRoles, $customRoles);
        } else {
            $rolesData = $defaultRoles;
        }

        // 4. Hitung Ringkasan Statistik
        $totalGroups = count($rolesData);
        $activeGroups = count(array_filter($rolesData, fn($item) => ($item['status'] ?? 'Active') === 'Active'));
        $emptyGroups = count(array_filter($rolesData, fn($item) => ($item['users'] ?? 0) === 0));

        // 5. Load Data Hak Akses / Permisi yang Tersimpan
        $permissions = [];
        if (Storage::exists($this->permissionsFilePath)) {
            $permissions = json_decode(Storage::get($this->permissionsFilePath), true) ?? [];
        } else {
            // Default permission awal jika belum pernah disimpan
            $permissions = [
                'Digital Marketing' => [
                    'dashboard' => 1,
                    'data-konsumen' => 1,
                    'layanan-servis' => 1,
                ]
            ];
        }

        return view('user-group.index', compact(
            'rolesData',
            'totalGroups',
            'activeGroups',
            'totalUsers',
            'emptyGroups',
            'permissions'
        ));
    }

    /**
     * Simpan Perubahan Hak Akses / Matriks Perizinan Menu
     */
    public function update(Request $request)
    {
        $accessData = $request->input('access', []);

        // Kita saring datanya. Hanya simpan ke JSON jika valuenya = 1 (benar-benar dicentang)
        $filteredAccess = [];
        foreach ($accessData as $role => $menus) {
            foreach ($menus as $menuKey => $value) {
                if ($value == 1) {
                    $filteredAccess[$role][$menuKey] = 1;
                }
            }
        }

        // Simpan matriks perizinan ke file JSON di storage/app/user_permissions.json pakai data yang sudah disaring
        Storage::put($this->permissionsFilePath, json_encode($filteredAccess, JSON_PRETTY_PRINT));

        return redirect()->back()->with('success', 'Hak akses modul dan menu berhasil diperbarui!');
    }

    /**
     * Tambah Role Baru dari Modal Mengambang
     */
    public function store(Request $request)
    {
        $request->validate([
            'role_name' => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
        ]);

        $existingRoles = [];
        if (Storage::exists($this->rolesFilePath)) {
            $existingRoles = json_decode(Storage::get($this->rolesFilePath), true) ?? [];
        }

        // Buat data role baru
        $newRole = [
            'id' => time(),
            'name' => trim($request->role_name),
            'description' => $request->description,
            'users' => 0,
            'status' => 'Active'
        ];

        $existingRoles[] = $newRole;

        // Simpan ke storage/app/user_roles.json
        Storage::put($this->rolesFilePath, json_encode($existingRoles, JSON_PRETTY_PRINT));

        return redirect()->back()->with('success', 'Role "' . $request->role_name . '" berhasil ditambahkan!');
    }

    /**
     * Hapus Role dari Sistem
     */
    public function destroy($roleName)
    {
        // 1. Baca data dari user_roles.json
        $existingRoles = [];
        if (Storage::exists($this->rolesFilePath)) {
            $existingRoles = json_decode(Storage::get($this->rolesFilePath), true) ?? [];
        } else {
            return back()->with('error', 'Data role tidak ditemukan.');
        }

        // 2. Filter / buang role yang mau dihapus
        $updatedRoles = array_filter($existingRoles, function($role) use ($roleName) {
            return $role['name'] !== $roleName;
        });

        // 3. Simpan kembali ke file (dengan array_values agar index rapi lagi)
        Storage::put($this->rolesFilePath, json_encode(array_values($updatedRoles), JSON_PRETTY_PRINT));

        // 4. Hapus juga perizinannya dari user_permissions.json jika ada
        if (Storage::exists($this->permissionsFilePath)) {
            $permissionsData = json_decode(Storage::get($this->permissionsFilePath), true) ?? [];
            if (isset($permissionsData[$roleName])) {
                unset($permissionsData[$roleName]);
                Storage::put($this->permissionsFilePath, json_encode($permissionsData, JSON_PRETTY_PRINT));
            }
        }

        return redirect()->back()->with('success', "Role '{$roleName}' berhasil dihapus secara permanen.");
    }
}