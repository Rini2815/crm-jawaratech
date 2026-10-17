<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserGroupController extends Controller
{
    /**
     * Tampilan Utama User Group & Matriks Hak Akses
     */
    public function index(Request $request)
    {
        // 1. Total User terdaftar
        $totalUsers = User::count();

        // 2. Jumlah user per role (dari ms_pengguna)
        $jumlahPerRole = User::select('id_role', DB::raw('COUNT(*) as total'))
            ->groupBy('id_role')
            ->pluck('total', 'id_role');

        // 3. Daftar role dari tabel ms_role
        $rolesData = Role::orderBy('id_role')->get()->map(function ($role) use ($jumlahPerRole) {
            return [
                'id'          => $role->id_role,
                'name'        => $role->nama_role,
                'description' => $role->deskripsi,
                'users'       => (int) ($jumlahPerRole[$role->id_role] ?? 0),
                'status'      => 'Active',
            ];
        })->all();

        // 4. Ringkasan statistik
        $totalGroups  = count($rolesData);
        $activeGroups = count(array_filter($rolesData, fn($item) => ($item['status'] ?? 'Active') === 'Active'));
        $emptyGroups  = count(array_filter($rolesData, fn($item) => ($item['users'] ?? 0) === 0));

        // 5. Hak akses menu dari ms_hak_akses (aksi 'lihat'), bentuk: [nama_role][menu] = 1
        $permissions = [];
        $hakAkses = DB::table('ms_hak_akses')
            ->join('ms_role', 'ms_role.id_role', '=', 'ms_hak_akses.id_role')
            ->where('ms_hak_akses.aksi', 'lihat')
            ->select('ms_role.nama_role', 'ms_hak_akses.modul')
            ->get();

        foreach ($hakAkses as $row) {
            $permissions[$row->nama_role][$row->modul] = 1;
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

        return redirect()->back()->with('success', 'Hak akses modul dan menu berhasil diperbarui!');
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

        return redirect()->back()->with('success', 'Role "' . $request->role_name . '" berhasil ditambahkan!');
    }

    /**
     * Hapus Role dari Sistem
     */
    public function destroy($roleName)
    {
        $role = Role::where('nama_role', $roleName)->first();

        if (!$role) {
            return back()->with('error', 'Data role tidak ditemukan.');
        }

        // Role Super Administrator tidak boleh dihapus
        if (str_contains(strtolower($role->nama_role), 'admin')) {
            return back()->with('error', "Role '{$roleName}' tidak boleh dihapus.");
        }

        // Role yang masih dipakai pengguna tidak boleh dihapus
        if (User::where('id_role', $role->id_role)->exists()) {
            return back()->with('error', "Role '{$roleName}' masih dipakai oleh pengguna, pindahkan penggunanya dulu.");
        }

        DB::transaction(function () use ($role) {
            DB::table('ms_hak_akses')->where('id_role', $role->id_role)->delete();
            $role->delete();
        });

        return redirect()->back()->with('success', "Role '{$roleName}' berhasil dihapus secara permanen.");
    }
}