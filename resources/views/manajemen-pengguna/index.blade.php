@extends('layouts.app')

@section('content')
<!-- Import Font 'Inter' & Custom CSS Jawaratech -->
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

body, html {
    background-color: #060910 !important;
}
.crm-wrapper {
    font-family: 'Inter', sans-serif;
    color: #0f172a;
}
/* Card Terang & Bersih */
.crm-card-light {
    border: 1px solid #cbd5e1;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
    border-radius: 12px;
    background: #ffffff !important;
}
.crm-table-header {
    background-color: #1e293b; /* Warna Navy/Slate khas Jawaratech */
    color: #ffffff;
    font-weight: 600;
    letter-spacing: 0.5px;
}
.crm-badge {
    font-weight: 600;
    letter-spacing: 0.3px;
    border-radius: 4px;
    padding: 0.35em 0.65em;
    font-size: 0.75rem;
}

/* Custom Badge Role & Status */
.badge-superadmin { background-color: #e0e7ff; color: #3730a3; border: 1px solid #c7d2fe; }
.badge-marketing { background-color: #fce7f3; color: #be185d; border: 1px solid #fbcfe8; }
.badge-aktif { background-color: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }

.super-thick-table th, 
.super-thick-table td {
    border-width: 2px !important;
    border-color: #cbd5e1 !important;
}

.stat-card-light {
    background: #ffffff !important;
    border: 1px solid #cbd5e1;
    border-radius: 12px;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.stat-card-light:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
}
</style>

<div class="container-fluid px-4 pt-3 pb-4 crm-wrapper" style="background: linear-gradient(135deg, #eef1f3 0%, #eef1f3 100%); min-height: 100vh;">

    <!-- Header Halaman (Banner Gelap Elegan Khusus Header Saja) -->
    <div class="card rounded-4 mb-4 text-white shadow-lg overflow-hidden" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); border: 1px solid rgba(56, 189, 248, 0.35) !important;">
        <div class="card-body p-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h1 class="h3 mb-1 text-white" style="font-weight: 700;"><i class="fas fa-users-cog text-primary me-2"></i> Manajemen Pengguna & Hak Akses</h1>
                <p class="text-light opacity-75 mb-0" style="font-weight: 500;">Kelola hak akses operasional, kelompok tim, dan profil staf di sistem CRM Jawaratech</p>
            </div>
            
            <!-- Tombol Tambah Pengguna -->
            <button type="button" class="btn btn-primary shadow-sm px-4 py-2 fw-bold d-flex align-items-center gap-2 rounded-pill" style="font-size: 0.875rem; background-color: #2563eb; border-color: #2563eb;" data-toggle="modal" data-bs-toggle="modal" data-target="#modalTambahPengguna" data-bs-target="#modalTambahPengguna">
                <i class="fas fa-plus-circle"></i> Tambah Pengguna
            </button>
        </div>
    </div>

    <!-- 3 Card Statistik Ringkasan di Atas (Gaya Terang Clean) -->
    <div class="row g-3 mb-4">
        <div class="col-xl-4 col-md-6">
            <div class="card stat-card-light p-3 h-100" style="border-left: 5px solid #2563eb !important;">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-uppercase text-muted fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">Total Pengguna Aktif</div>
                        <div class="h4 mb-0 fw-bold text-dark mt-1" style="font-weight: 700;">4 <span class="fs-6 fw-normal text-muted">Akun</span></div>
                    </div>
                    <div class="p-3 rounded-circle" style="background-color: rgba(37, 99, 235, 0.1); color: #2563eb;">
                        <i class="fas fa-users fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card stat-card-light p-3 h-100" style="border-left: 5px solid #4f46e5 !important;">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-uppercase text-muted fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">Super Admin</div>
                        <div class="h4 mb-0 fw-bold text-dark mt-1" style="font-weight: 700;">2 <span class="fs-6 fw-normal text-muted">Staf</span></div>
                    </div>
                    <div class="p-3 rounded-circle" style="background-color: rgba(79, 70, 229, 0.1); color: #4f46e5;">
                        <i class="fas fa-user-shield fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card stat-card-light p-3 h-100" style="border-left: 5px solid #db2777 !important;">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-uppercase text-muted fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">Digital Marketing</div>
                        <div class="h4 mb-0 fw-bold text-dark mt-1" style="font-weight: 700;">2 <span class="fs-6 fw-normal text-muted">Staf</span></div>
                    </div>
                    <div class="p-3 rounded-circle" style="background-color: rgba(219, 39, 119, 0.1); color: #db2777;">
                        <i class="fas fa-headset fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Data Pengguna -->
    <div class="card crm-card-light overflow-hidden mb-4 bg-white">
        <div class="card-body p-4 bg-white">
            
            <!-- Baris Atas Tabel: Judul Utama & Subtitle Keterangan Clean + Search Box -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
                <!-- Judul + Subtitle Keterangan -->
                <div>
                    <h5 class="fw-bold text-dark mb-1" style="font-size: 1.2rem; letter-spacing: -0.3px;">Daftar Master Pengguna Sistem</h5>
                    <p class="text-secondary mb-0" style="font-size: 0.875rem; font-weight: 400;">Kelola seluruh akun staf, perizinan hak akses operasional, dan status keaktifan tim</p>
                </div>

                <!-- Input Pencarian / Search Bar -->
                <div class="position-relative" style="min-width: 280px;">
                    <input type="text" id="searchInput" class="form-control form-control-sm ps-5 pe-3 py-2 bg-white text-dark" placeholder="Cari nama, email, role..." style="border-radius: 20px; border: 1px solid #cbd5e1; font-size: 0.875rem;">
                    <i class="fas fa-search position-absolute text-secondary" style="left: 15px; top: 50%; transform: translateY(-50%); font-size: 0.85rem;"></i>
                </div>
            </div>

            <!-- Tabel Data -->
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle mb-0 super-thick-table" id="tablePengguna">
                    <thead class="crm-table-header text-uppercase fs-7">
                        <tr>
                            <!-- Seluruh Header Rata Tengah (text-center) -->
                            <th class="py-3 text-white text-center" style="width: 6%;">NO</th>
                            <th class="py-3 text-white text-center" style="width: 24%;">NAMA PENGGUNA</th>
                            <th class="py-3 text-white text-center" style="width: 26%;">ALAMAT EMAIL</th>
                            <th class="py-3 text-white text-center" style="width: 18%;">ROLE AKSES</th>
                            <th class="py-3 text-white text-center" style="width: 12%;">STATUS</th>
                            <th class="py-3 text-white text-center" style="width: 14%;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody style="font-weight: 500;">
                        @php
                            $users = [
                                [
                                    'nama' => 'Hanif Nur Azis', 
                                    'email' => 'admin@jawaratech.com', 
                                    'role' => 'Super Admin', 
                                    'icon' => 'fa-user-shield', 
                                    'class' => 'badge-superadmin'
                                ],
                                [
                                    'nama' => 'Ahmad Fauzi', 
                                    'email' => 'fauzi.admin@jawaratech.com', 
                                    'role' => 'Super Admin', 
                                    'icon' => 'fa-user-shield', 
                                    'class' => 'badge-superadmin'
                                ],
                                [
                                    'nama' => 'Siti Aminah', 
                                    'email' => 'marketing1@jawaratech.com', 
                                    'role' => 'Digital Marketing', 
                                    'icon' => 'fa-headset', 
                                    'class' => 'badge-marketing'
                                ],
                                [
                                    'nama' => 'Dewi Lestari', 
                                    'email' => 'marketing2@jawaratech.com', 
                                    'role' => 'Digital Marketing', 
                                    'icon' => 'fa-headset', 
                                    'class' => 'badge-marketing'
                                ],
                            ];
                        @endphp

                        @foreach($users as $index => $user)
                            <tr>
                                <td class="px-3 py-3 text-secondary text-center">{{ $index + 1 }}</td>
                                <td class="py-3">
                                    <div class="text-dark fw-bold" style="font-weight: 600;">{{ $user['nama'] }}</div>
                                </td>
                                <td class="py-3 text-secondary">{{ $user['email'] }}</td>
                                <td class="py-3">
                                    <span class="badge crm-badge {{ $user['class'] }}">
                                        <i class="fas {{ $user['icon'] }} me-1"></i> {{ $user['role'] }}
                                    </span>
                                </td>
                                <td class="py-3 text-center">
                                    <span class="badge crm-badge badge-aktif">
                                        <i class="fas fa-check-circle me-1"></i> Aktif
                                    </span>
                                </td>
                                <td class="py-3 text-center">
                                    <!-- Tombol Aksi Sejajar Menyamping -->
                                    <div class="d-flex justify-content-center align-items-center gap-1 flex-nowrap">
                                        <!-- Tombol Edit -->
                                        <button class="btn btn-sm btn-outline-primary shadow-sm px-2 py-1" title="Edit Data" style="border-radius: 4px;" data-toggle="modal" data-bs-toggle="modal" data-target="#modalEditPengguna{{ $index }}" data-bs-target="#modalEditPengguna{{ $index }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <!-- Tombol Hapus -->
                                        <button class="btn btn-sm btn-outline-danger shadow-sm px-2 py-1" title="Hapus Pengguna" style="border-radius: 4px;">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            
                            <!-- Include Modal Edit Pengguna -->
                            @include('manajemen-pengguna.edit')

                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Include Modal Tambah Pengguna -->
@include('manajemen-pengguna.create')

<!-- Script JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Script Filter Pencarian Real-Time -->
<script>
$(document).ready(function(){
    $("#searchInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#tablePengguna tbody tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
});
</script>
@endsection