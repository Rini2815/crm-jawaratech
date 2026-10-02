<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage; // Pastikan Storage di-import

class UserManagementController extends Controller
{
    public function index()
    {
        // 1. Mengambil semua data pengguna dari database
        $users = User::all();
        
        // 2. Membaca data custom role dari file JSON agar otomatis tampil di modal create/edit
        $rolesFilePath = 'user_roles.json';
        $customRoles = [];
        if (Storage::exists($rolesFilePath)) {
            $customRoles = json_decode(Storage::get($rolesFilePath), true) ?? [];
        }
        
        // 3. Kirim variabel $customRoles bersama $users ke view index
        return view('user-management.index', compact('users', 'customRoles'));
    }

    public function store(Request $request)
    {
        // 1. Validasi data yang masuk dari form modal
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'role'     => 'required|string',
            'status'   => 'nullable|string', 
            'password' => 'required|string|min:8|confirmed',
        ]);

        // 2. Memasukkan data ke dalam database
        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'role'     => $request->role,
            'password' => Hash::make($request->password),
        ]);

        // 3. Kembalikan ke halaman manajemen dengan pesan sukses
        return redirect()->route('hak-akses')->with('success', 'Data pengguna baru berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users,email,' . $id,
            'role'     => 'required|string',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('hak-akses')->with('success', 'Data pengguna berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        if (auth()->id() == $user->id) {
            return redirect()->route('hak-akses')->with('error', 'Gagal! Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif.');
        }

        $user->delete();

        return redirect()->route('hak-akses')->with('success', 'Data pengguna berhasil dihapus permanen!');
    }
}