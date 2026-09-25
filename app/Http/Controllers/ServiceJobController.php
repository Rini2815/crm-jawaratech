<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceJob; // Memanggil Model Database

class ServiceJobController extends Controller
{
    /**
     * Menampilkan halaman daftar data servis (index)
     */
    public function index()
    {
        // PENTING: Jika kamu SUDAH punya tabel & model database 'ServiceJob', gunakan kode ini:
        // $serviceJobs = ServiceJob::latest()->get(); 

        // TAPI, jika database/tabel belum siap, kita pakai DUMMY DATA dulu agar desainnya tampil & tidak error:
        $serviceJobs = collect([
            (object)[
                'nama_konsumen' => 'Budi Santoso',
                'no_whatsapp' => '081234567890',
                'jenis_unit' => 'Laptop',
                'merk_tipe' => 'Asus ROG Strix',
                'nama_teknisi' => 'Rizki',
                'jenis_perbaikan' => null // Contoh belum closing
            ],
            (object)[
                'nama_konsumen' => 'Siti Aminah',
                'no_whatsapp' => '089876543210',
                'jenis_unit' => 'AC Split',
                'merk_tipe' => 'Sharp 1 PK',
                'nama_teknisi' => 'Anton',
                'jenis_perbaikan' => 'Cuci AC & Tambah Freon' // Contoh sudah closing
            ]
        ]);

        // Mengirimkan data $serviceJobs ke file resources/views/service-jobs/index.blade.php
        return view('service-jobs.index', compact('serviceJobs'));
    }

    /**
     * Menampilkan form tambah servis baru
     */
    public function create()
    {
        return view('service-jobs.create');
    }

    /**
     * Menyimpan data servis baru ke database
     */
    public function store(Request $request)
    {
        // Nanti diisi logika validasi dan save ke database
    }

    /**
     * Menampilkan detail satu servis
     */
    public function show($id)
    {
        // 
    }

    /**
     * Menampilkan form edit servis
     */
    public function edit($id)
    {
        return view('service-jobs.edit');
    }

    /**
     * Update data servis ke database
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Hapus data servis
     */
    public function destroy($id)
    {
        //
    }
}