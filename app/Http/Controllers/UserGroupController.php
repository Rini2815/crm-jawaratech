<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserGroupController extends Controller
{
    /**
     * Halaman Hak Akses sekarang menjadi tab di halaman Manajemen Pengguna.
     * Link lama /user-group dialihkan supaya tidak error.
     */
    public function index(Request $request)
    {
        return redirect()->route('hak-akses', ['tab' => 'hak-akses']);
    }

    /**
     * Simpan Perubahan Hak Akses / Matriks Perizinan Menu
     */
    public function update(Request $request)
    {
        $accessData = $request->input('access', []);

        // Peta nama role => id_role
        $petaRole = Role::pluck('id_role', 'nama_role');

        DB::transaction(function () use ($accessData, $petaRole) {
            // Hapus hanya hak akses 'lihat' (aksi tambah/ubah/hapus tidak disentuh)
            DB::table('ms_hak_akses')->where('aksi', 'lihat')->delete();

            // Simpan hanya yang benar-benar dicentang (value = 1)
            foreach ($accessData as $roleName => $menus) {
                if (!isset($petaRole[$roleName])) {
                    continue;
                }

                foreach ($menus as $menuKey => $value) {
                    if ($value == 1) {
                        DB::table('ms_hak_akses')->insert([
                            'id_role' => $petaRole[$roleName],
                            'modul'   => $menuKey,
                            'aksi'    => 'lihat',
                        ]);
                    }
                }
            }
        });

        return redirect()->route('hak-akses')
            ->with('tab', 'hak-akses')
            ->with('success', 'Hak akses modul dan menu berhasil diperbarui!');
    }

    /**
     * Tambah Role Baru dari Modal Mengambang
     */
    public function store(Request $request)
    {
        $request->validate([
            'role_name'   => 'required|string|max:45|unique:ms_role,nama_role',
            'description' => 'nullable|string|max:60',
        ]);

        Role::create([
            'nama_role' => trim($request->role_name),
            'deskripsi' => $request->description,
        ]);

        return redirect()->route('hak-akses')
            ->with('tab', 'hak-akses')
            ->with('success', 'Role "' . $request->role_name . '" berhasil ditambahkan!');
    }

    /**
     * Hapus Role dari Sistem
     */
    public function destroy($roleName)
    {
        $role = Role::where('nama_role', $roleName)->first();

        if (!$role) {
            return redirect()->route('hak-akses')
                ->with('tab', 'hak-akses')
                ->with('error', 'Data role tidak ditemukan.');
        }

        // Role Super Administrator tidak boleh dihapus
        if (str_contains(strtolower($role->nama_role), 'admin')) {
            return redirect()->route('hak-akses')
                ->with('tab', 'hak-akses')
                ->with('error', "Role '{$roleName}' tidak boleh dihapus.");
        }

        // Role yang masih dipakai pengguna tidak boleh dihapus
        if (User::where('id_role', $role->id_role)->exists()) {
            return redirect()->route('hak-akses')
                ->with('tab', 'hak-akses')
                ->with('error', "Role '{$roleName}' masih dipakai oleh pengguna, pindahkan penggunanya dulu.");
        }

        DB::transaction(function () use ($role) {
            DB::table('ms_hak_akses')->where('id_role', $role->id_role)->delete();
            $role->delete();
        });

        return redirect()->route('hak-akses')
            ->with('tab', 'hak-akses')
            ->with('success', "Role '{$roleName}' berhasil dihapus secara permanen.");
    }
}