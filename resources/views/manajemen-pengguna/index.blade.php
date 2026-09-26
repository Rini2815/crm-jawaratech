@extends('layouts.app')

@section('content')
<!-- Import Font 'Inter' untuk tampilan teks profesional & tegas -->
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
    
    .crm-wrapper {
        font-family: 'Inter', sans-serif;
        color: #334155;
    }
    .crm-card {
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        border-radius: 8px;
    }
    .crm-table-header {
        background-color: #1e293b; /* Warna Navy/Slate tegas */
        color: #ffffff;
        font-weight: 600;
        letter-spacing: 0.5px;
    }
    .crm-badge {
        font-weight: 600;
        letter-spacing: 0.3px;
        border-radius: 4px;
        padding: 0.35em 0.65em;
        font-size: 0.8rem;
    }
    .badge-superadmin { background-color: #e0e7ff; color: #3730a3; border: 1px solid #c7d2fe; }
    .badge-marketing { background-color: #fce7f3; color: #be185d; border: 1px solid #fbcfe8; }
    .badge-aktif { background-color: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
</style>

<div class="container-fluid py-4 crm-wrapper">
    <!-- Header Halaman -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-dark" style="font-weight: 700; color: #0f172a !important;">Manajemen Pengguna</h1>
            <p class="text-secondary mb-0" style="font-weight: 500;">Kelola hak akses operasional dan tim di sistem CRM Jawaratech</p>
        </div>
        
        <!-- Tombol Tambah Pengguna -->
        <button type="button" class="btn btn-primary shadow-sm px-4 py-2" style="font-weight: 600; border-radius: 6px; background-color: #2563eb; border-color: #2563eb;" data-toggle="modal" data-bs-toggle="modal" data-target="#modalTambahPengguna" data-bs-target="#modalTambahPengguna">
            <i class="fas fa-plus fa-sm mr-2 me-2"></i> Tambah Pengguna
        </button>
    </div>

    <!-- Tabel Data Pengguna -->
    <div class="card crm-card bg-white">
        <!-- Card Header dengan Judul & Kolom Pencarian -->
        <div class="card-header bg-white py-3 border-bottom d-flex flex-column flex-md-row align-items-md-center justify-content-between">
            <h6 class="m-0 text-dark mb-2 mb-md-0" style="font-weight: 700;">
                <i class="fas fa-users-cog text-primary mr-2 me-2"></i>Daftar Pengguna Sistem
            </h6>

            <!-- Kolom Pencarian -->
            <div class="input-group input-group-sm" style="max-width: 300px;">
                <input type="text" id="searchInput" class="form-control" placeholder="Cari nama, email, role..." style="border-radius: 6px 0 0 6px;">
                <div class="input-group-append input-group-text bg-white" style="border-radius: 0 6px 6px 0;">
                    <i class="fas fa-search text-secondary"></i>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="tablePengguna">
                    <thead class="crm-table-header">
                        <tr>
                            <th class="px-4 py-3 border-0">NO</th>
                            <th class="py-3 border-0">NAMA PENGGUNA</th>
                            <th class="py-3 border-0">ALAMAT EMAIL</th>
                            <th class="py-3 border-0">ROLE AKSES</th>
                            <th class="py-3 border-0">STATUS</th>
                            <th class="text-center py-3 border-0">AKSI</th>
                        </tr>
                    </thead>
                    <tbody style="font-weight: 500;">
                        @php
                            $users = [
                                ['nama' => 'Hanif Nur Azis', 'email' => 'admin@jawaratech.com', 'role' => 'Super Admin', 'icon' => 'fa-user-shield', 'class' => 'badge-superadmin'],
                                ['nama' => 'Tim Happy Call', 'email' => 'marketing@jawaratech.com', 'role' => 'Digital Marketing', 'icon' => 'fa-headset', 'class' => 'badge-marketing'],
                            ];
                        @endphp

                        @foreach($users as $index => $user)
                            <tr style="border-bottom: 1px solid #f1f5f9;">
                                <td class="px-4 py-3 text-secondary">{{ $index + 1 }}</td>
                                <td class="py-3 text-dark" style="font-weight: 600;">{{ $user['nama'] }}</td>
                                <td class="py-3 text-secondary">{{ $user['email'] }}</td>
                                <td class="py-3">
                                    <span class="badge crm-badge {{ $user['class'] }}">
                                        <i class="fas {{ $user['icon'] }} mr-1 me-1"></i> {{ $user['role'] }}
                                    </span>
                                </td>
                                <td class="py-3">
                                    <span class="badge crm-badge badge-aktif">
                                        <i class="fas fa-check-circle mr-1 me-1"></i> Aktif
                                    </span>
                                </td>
                                <td class="py-3 text-center">
                                    <!-- Tombol Edit: Memanggil Modal Edit sesuai ID baris datanya -->
                                    <button class="btn btn-sm btn-outline-primary shadow-sm mr-1 me-1" title="Edit Data" style="border-radius: 4px;" data-toggle="modal" data-bs-toggle="modal" data-target="#modalEditPengguna{{ $index }}" data-bs-target="#modalEditPengguna{{ $index }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger shadow-sm" title="Hapus Pengguna" style="border-radius: 4px;">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            
                            <!-- Memanggil file modal edit (diletakkan di dalam perulangan agar membaca $user & $index) -->
                            @include('manajemen-pengguna.edit')

                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Memanggil file modal tambah -->
@include('manajemen-pengguna.create')

<!-- Script JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Script Filter Pencarian Realtime -->
<script>
    $(document).ready(function(){
        $("#searchInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#tablePengguna tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>
@endsection