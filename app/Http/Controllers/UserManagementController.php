<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    public function index()
    {
        // 1. Mengambil semua data pengguna beserta role-nya
        $users = User::with('peran')->get();

        // 2. Role tambahan (selain dua role bawaan) dari tabel ms_role,
        //    supaya otomatis tampil di modal create/edit
        $customRoles = Role::whereNotIn('nama_role', ['Super Administrator', 'Digital Marketing'])
            ->orderBy('id_role')
            ->get()
            ->map(fn($role) => [
                'id'          => $role->id_role,
                'name'        => $role->nama_role,
                'description' => $role->deskripsi,
            ])
            ->all();

        // 3. Kirim variabel customRoles bersama users ke view index
        return view('user-management.index', compact('users', 'customRoles'));
    }

    public function store(Request $request)
    {
        // 1. Validasi data yang masuk dari form modal
        $request->validate([
            'name'        => 'required|string|max:45',
            'email'       => 'required|string|email|max:45|unique:ms_pengguna,email',
            'role'        => 'required|string|exists:ms_role,nama_role',
            'status'      => 'nullable|string',
            'no_whatsapp' => 'nullable|string|max:15',
            'password'    => 'required|string|min:8|confirmed',
        ]);

        // 2. Ubah nama role dari form menjadi id_role
        $role = Role::where('nama_role', $request->role)->firstOrFail();

        // 3. Memasukkan data ke dalam database
        User::create([
            'id_role'     => $role->id_role,
            'nama'        => $request->name,
            'email'       => $request->email,
            'no_whatsapp' => $request->no_whatsapp,
            'status'      => $this->normalisasiStatus($request->status),
            'password'    => Hash::make($request->password),
        ]);

        // 4. Kembalikan ke halaman manajemen dengan pesan sukses
        return redirect()->route('hak-akses')->with('success', 'Data pengguna baru berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'        => 'required|string|max:45',
            'email'       => 'required|string|email|max:45|unique:ms_pengguna,email,' . $id . ',id_pengguna',
            'role'        => 'required|string|exists:ms_role,nama_role',
            'status'      => 'nullable|string',
            'no_whatsapp' => 'nullable|string|max:15',
            'password'    => 'nullable|string|min:8|confirmed',
        ]);

        $role = Role::where('nama_role', $request->role)->firstOrFail();

        $user->nama    = $request->name;
        $user->email   = $request->email;
        $user->id_role = $role->id_role;

        if ($request->has('status')) {
            $user->status = $this->normalisasiStatus($request->status);
        }

        if ($request->has('no_whatsapp')) {
            $user->no_whatsapp = $request->no_whatsapp;
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('hak-akses')->with('success', 'Data pengguna berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if (auth()->id() == $user->id_pengguna) {
            return redirect()->route('hak-akses')->with('error', 'Gagal! Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif.');
        }

        // Simpan id_role dulu sebelum pengguna dihapus
        $idRole = $user->id_role;

        try {
            $user->delete();
        } catch (QueryException $e) {
            // Akun yang sudah punya riwayat (log audit / follow up) ditolak oleh database
            return redirect()->route('hak-akses')->with('error', 'Akun ini sudah memiliki riwayat aktivitas sehingga tidak bisa dihapus. Ubah statusnya menjadi Tidak Aktif saja.');
        }

        // Hapus role dari ms_role jika sudah tidak dipakai pengguna mana pun,
        // supaya card role tersebut ikut hilang dari halaman manajemen pengguna.
        // Dua role bawaan tidak pernah dihapus.
        $role = Role::find($idRole);

        if (
            $role
            && !in_array($role->nama_role, ['Super Administrator', 'Digital Marketing'])
            && !User::where('id_role', $idRole)->exists()
        ) {
            try {
                DB::transaction(function () use ($role) {
                    // ms_hak_akses punya foreign key ke ms_role (ON DELETE NO ACTION),
                    // jadi hak akses milik role ini harus dihapus dulu
                    DB::table('ms_hak_akses')->where('id_role', $role->id_role)->delete();
                    $role->delete();
                });
            } catch (QueryException $e) {
                // Role masih dipakai tabel lain, biarkan saja tetap ada
            }
        }

        return redirect()->route('hak-akses')->with('success', 'Data pengguna berhasil dihapus permanen!');
    }

    /**
     * Ubah nilai status dari form menjadi nilai enum di ms_pengguna: 'Aktif' atau 'Tidak Aktif'
     */
    private function normalisasiStatus($status)
    {
        $status = strtolower(trim($status ?? ''));

        return in_array($status, ['nonaktif', 'non aktif', 'tidak aktif', 'inactive']) ? 'Tidak Aktif' : 'Aktif';
    }
}