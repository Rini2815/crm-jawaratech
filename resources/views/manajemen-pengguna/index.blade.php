@extends('layouts.app')

@section('content')
<!-- Import Font 'Inter' untuk tampilan teks profesional & tegas -->
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
    
    body, html {
        background-color: #060910 !important;
    }
    .crm-wrapper {
        font-family: 'Inter', sans-serif;
        color: #f8fafc;
    }
    .crm-card {
        border: 1px solid rgba(36, 59, 85, 0.35);
        box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.06), 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        border-radius: 12px;
        background: linear-gradient(135deg, #f1f5f9 0%, #cbd5e1 100%) !important;
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

    .super-thick-table th, 
    .super-thick-table td {
        border-width: 2px !important;
        border-color: #334155 !important;
    }
    .stat-card {
        transition: transform 0.2s ease;
    }
    .stat-card:hover {
        transform: translateY(-2px);
    }
</style>

<div class="container-fluid px-4 pt-3 pb-4 crm-wrapper" style="background: linear-gradient(135deg, #eef1f3 0%, #eef1f3); min-height: 100vh;">
    <!-- Header Halaman (Dibungkus Card Gelap Elegan) -->
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

    <!-- 3 Card Statistik Ringkasan di Atas (Tanpa Batasan Gender di Judul) -->
    <div class="row g-3 mb-4">
        <div class="col-xl-4 col-md-6">
            <div class="card crm-card stat-card p-3 h-100" style="border-left: 5px solid #2563eb !important;">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-uppercase text-secondary fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">Total Pengguna Aktif</div>
                        <div class="h4 mb-0 fw-bold text-dark mt-1" style="font-weight: 700;">4 <span class="fs-6 fw-normal text-muted">Akun</span></div>
                    </div>
                    <div class="p-3 bg-primary bg-opacity-10 rounded-circle text-primary" style="background-color: rgba(37, 99, 235, 0.15); color: #2563eb;">
                        <i class="fas fa-users fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card crm-card stat-card p-3 h-100" style="border-left: 5px solid #4f46e5 !important;">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-uppercase text-secondary fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">Super Admin </div>
                        <div class="h4 mb-0 fw-bold text-dark mt-1" style="font-weight: 700;">2 <span class="fs-6 fw-normal text-muted">Staf</span></div>
                    </div>
                    <div class="p-3 rounded-circle" style="background-color: rgba(79, 70, 229, 0.15); color: #4f46e5;">
                        <i class="fas fa-user-shield fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card crm-card stat-card p-3 h-100" style="border-left: 5px solid #db2777 !important;">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-uppercase text-secondary fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">Digital Marketing </div>
                        <div class="h4 mb-0 fw-bold text-dark mt-1" style="font-weight: 700;">2 <span class="fs-6 fw-normal text-muted">Staf</span></div>
                    </div>
                    <div class="p-3 rounded-circle" style="background-color: rgba(219, 39, 119, 0.15); color: #db2777;">
                        <i class="fas fa-headset fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Data Pengguna -->
    <div class="card crm-card overflow-hidden mb-4">
        <!-- Card Header dengan Judul & Kolom Pencarian -->
        <div class="card-header text-white border-0 pt-3 px-4 pb-3 d-flex flex-column flex-md-row align-items-md-center justify-content-between shadow-sm" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); border-bottom: 2px solid rgba(56, 189, 248, 0.4) !important;">
            <div class="d-flex align-items-center gap-2 mb-2 mb-md-0">
                <div class="p-2 rounded-circle bg-primary bg-opacity-25 text-info">
                    <i class="fas fa-users-cog fa-lg"></i>
                </div>
                <div>
                    <h5 class="m-0 text-white fw-bold">Daftar Pengguna Sistem & Kelompok Role</h5>
                    <small class="text-light opacity-75">Kelompokkan akun staf berdasarkan hak akses dan gender operasional</small>
                </div>
            </div>

            <!-- Kolom Pencarian -->
            <div class="position-relative" style="min-width: 280px;">
                <input type="text" id="searchInput" class="form-control form-control-sm ps-5 pe-3 py-2 bg-white text-dark" placeholder="Cari nama, email, role..." style="border-radius: 20px; border: 1px solid #cbd5e1; font-size: 0.875rem;">
                <i class="fas fa-search position-absolute text-secondary" style="left: 15px; top: 50%; transform: translateY(-50%); font-size: 0.85rem;"></i>
            </div>
        </div>

        <div class="card-body p-4 bg-white">
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle mb-0 super-thick-table" id="tablePengguna">
                    <thead class="crm-table-header text-uppercase text-center fs-7">
                        <tr>
                            <th class="py-3 text-white" style="width: 6%;">NO</th>
                            <th class="py-3 text-white text-start" style="width: 24%;">NAMA PENGGUNA & GENDER</th>
                            <th class="py-3 text-white text-start" style="width: 26%;">ALAMAT EMAIL</th>
                            <th class="py-3 text-white text-start" style="width: 18%;">ROLE AKSES</th>
                            <th class="py-3 text-white text-center" style="width: 12%;">STATUS</th>
                            <th class="text-center py-3 text-white" style="width: 14%;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody style="font-weight: 500;">
                        @php
                            $users = [
                                [
                                    'nama' => 'Hanif Nur Azis', 
                                    'gender' => 'Laki-laki (Male)', 
                                    'gender_icon' => 'fa-mars text-primary', 
                                    'email' => 'admin@jawaratech.com', 
                                    'role' => 'Super Admin', 
                                    'icon' => 'fa-user-shield', 
                                    'class' => 'badge-superadmin'
                                ],
                                [
                                    'nama' => 'Ahmad Fauzi', 
                                    'gender' => 'Laki-laki (Male)', 
                                    'gender_icon' => 'fa-mars text-primary', 
                                    'email' => 'fauzi.admin@jawaratech.com', 
                                    'role' => 'Super Admin', 
                                    'icon' => 'fa-user-shield', 
                                    'class' => 'badge-superadmin'
                                ],
                                [
                                    'nama' => 'Siti Aminah', 
                                    'gender' => 'Perempuan (Female)', 
                                    'gender_icon' => 'fa-venus text-danger', 
                                    'email' => 'marketing1@jawaratech.com', 
                                    'role' => 'Digital Marketing', 
                                    'icon' => 'fa-headset', 
                                    'class' => 'badge-marketing'
                                ],
                                [
                                    'nama' => 'Dewi Lestari', 
                                    'gender' => 'Perempuan (Female)', 
                                    'gender_icon' => 'fa-venus text-danger', 
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
                                    <small class="text-muted"><i class="fas {{ $user['gender_icon'] }} me-1"></i> {{ $user['gender'] }}</small>
                                </td>
                                <td class="py-3 text-secondary">{{ $user['email'] }}</td>
                                <td class="py-3">
                                    <span class="badge crm-badge {{ $user['class'] }}">
                                        <i class="fas {{ $user['icon'] }} mr-1 me-1"></i> {{ $user['role'] }}
                                    </span>
                                </td>
                                <td class="py-3 text-center">
                                    <span class="badge crm-badge badge-aktif">
                                        <i class="fas fa-check-circle mr-1 me-1"></i> Aktif
                                    </span>
                                </td>
                                <td class="py-3 text-center">
                                    <!-- Tombol Aksi Sejajar Menyamping Tanpa Turun -->
                                    <div class="d-flex justify-content-center align-items-center gap-1 flex-nowrap">
                                        <!-- Tombol Edit: Memanggil Modal Edit sesuai ID baris datanya -->
                                        <button class="btn btn-sm btn-outline-primary shadow-sm px-2 py-1" title="Edit Data" style="border-radius: 4px;" data-toggle="modal" data-bs-toggle="modal" data-target="#modalEditPengguna{{ $index }}" data-bs-target="#modalEditPengguna{{ $index }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger shadow-sm px-2 py-1" title="Hapus Pengguna" style="border-radius: 4px;">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
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