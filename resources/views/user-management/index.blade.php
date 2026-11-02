@extends('layouts.app')
@section('content')
@php
    // Tab aktif: dari session (setelah simpan/hapus role), dari URL (?tab=...), atau otomatis dari input lama
    $activeTab = session('tab') ?? request('tab') ?? (old('role_name') !== null ? 'hak-akses' : 'pengguna');
    if (!in_array($activeTab, ['pengguna', 'hak-akses'])) {
        $activeTab = 'pengguna';
    }
@endphp
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
.crm-card-light {
    border: 1px solid #cbd5e1;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
    border-radius: 12px;
    background: #ffffff !important;
}
.crm-table-header {
    background-color: #1e293b;
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
.badge-superadmin { background-color: #e0e7ff; color: #3730a3; border: 1px solid #c7d2fe; }
.badge-marketing { background-color: #fce7f3; color: #be185d; border: 1px solid #fbcfe8; }
.badge-custom { background-color: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; }
.badge-default { background-color: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; }
.badge-aktif { background-color: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
.badge-nonaktif { background-color: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
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
.form-check-input-custom {
    width: 1.3em;
    height: 1.3em;
    cursor: pointer;
}

/* ===== Tab Halaman (Data Pengguna / Hak Akses) ===== */
.crm-tabs {
    display: flex;
    gap: 8px;
    margin-bottom: 20px;
    flex-wrap: wrap;
}
.crm-tab {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 22px;
    border-radius: 999px;
    border: 1px solid #cbd5e1;
    background: #ffffff;
    color: #475569;
    font-size: 0.875rem;
    font-weight: 700;
    cursor: pointer;
    transition: background-color 0.15s ease, color 0.15s ease, box-shadow 0.15s ease;
}
.crm-tab:hover { background: #f1f5f9; }
.crm-tab.active {
    background: #1e293b;
    border-color: #1e293b;
    color: #ffffff;
    box-shadow: 0 4px 10px rgba(15, 23, 42, 0.25);
}
.crm-pane { display: none; }
.crm-pane.active { display: block; }

/* ===== Modal Konfirmasi Hapus (Custom) ===== */
.hapus-overlay {
    position: fixed;
    inset: 0;
    z-index: 2000;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 16px;
    background: rgba(6, 9, 16, 0.55);
    -webkit-backdrop-filter: blur(6px);
    backdrop-filter: blur(6px);
    font-family: 'Inter', sans-serif;
}
.hapus-overlay.show {
    display: flex;
    animation: hapusFade 0.18s ease-out;
}
.hapus-box {
    width: 100%;
    max-width: 500px;
    background: #0f172a;
    border: 1px solid rgba(148, 163, 184, 0.18);
    border-radius: 18px;
    padding: 28px 28px 26px;
    text-align: center;
    color: #ffffff;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.6);
    animation: hapusPop 0.2s ease-out;
}
.hapus-icon {
    width: 60px;
    height: 60px;
    margin: 0 auto 14px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(239, 68, 68, 0.15);
    border: 1px solid rgba(239, 68, 68, 0.55);
    color: #f87171;
    font-size: 1.25rem;
}
.hapus-title {
    font-size: 1.15rem;
    font-weight: 700;
    margin: 0 0 6px;
    color: #ffffff;
}
.hapus-text {
    font-size: 0.8rem;
    margin: 0 0 20px;
    color: #e2e8f0;
}
.hapus-actions {
    display: flex;
    justify-content: center;
    gap: 10px;
}
.hapus-btn {
    border-radius: 999px;
    padding: 9px 22px;
    font-size: 0.85rem;
    font-weight: 700;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: transform 0.15s ease, background-color 0.15s ease, box-shadow 0.15s ease;
}
.hapus-btn:hover { transform: translateY(-1px); }
.hapus-btn-batal {
    background: transparent;
    color: #ffffff;
    border: 1.5px solid #ffffff;
}
.hapus-btn-batal:hover { background: rgba(255, 255, 255, 0.1); }
.hapus-btn-ya {
    background: #ef4444;
    color: #ffffff;
    border: 1.5px solid #ef4444;
}
.hapus-btn-ya:hover {
    background: #dc2626;
    border-color: #dc2626;
    box-shadow: 0 6px 16px rgba(239, 68, 68, 0.35);
}
@keyframes hapusFade { from { opacity: 0; } to { opacity: 1; } }
@keyframes hapusPop {
    from { opacity: 0; transform: scale(0.92) translateY(8px); }
    to   { opacity: 1; transform: scale(1) translateY(0); }
}
</style>

<div class="container-fluid px-4 pt-3 pb-4 crm-wrapper" style="background: linear-gradient(135deg, #eef1f3 0%, #eef1f3 100%); min-height: 100vh;">

    <!-- Header Halaman -->
    <div class="card rounded-4 mb-4 text-white shadow-lg overflow-hidden" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); border: 1px solid rgba(56, 189, 248, 0.35) !important;">
        <div class="card-body p-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h1 class="h3 mb-1 text-white" style="font-weight: 700;"><i class="fas fa-users-cog text-primary me-2"></i> Manajemen Pengguna</h1>
                <p class="text-light opacity-75 mb-0" style="font-weight: 500;">Kelola data pengguna, kelompok role, dan hak akses menu staf di sistem CRM Jawaratech</p>
            </div>

            <!-- Tombol Tambah Pengguna (tampil di tab Data Pengguna) -->
            <button type="button" id="btnTambahPengguna" class="btn btn-primary shadow-sm px-4 py-2 fw-bold align-items-center gap-2 rounded-pill" style="font-size: 0.875rem; background-color: #2563eb; border-color: #2563eb; display: {{ $activeTab === 'pengguna' ? 'inline-flex' : 'none' }};" data-toggle="modal" data-bs-toggle="modal" data-target="#modalTambahPengguna" data-bs-target="#modalTambahPengguna">
                <i class="fas fa-plus-circle"></i> Tambah Pengguna
            </button>

            <!-- Tombol Tambah Role (tampil di tab Hak Akses) -->
            <button type="button" id="btnTambahRole" class="btn btn-primary shadow-sm px-4 py-2 fw-bold align-items-center gap-2 rounded-pill" style="font-size: 0.875rem; background-color: #2563eb; border-color: #2563eb; display: {{ $activeTab === 'hak-akses' ? 'inline-flex' : 'none' }};" data-toggle="modal" data-bs-toggle="modal" data-target="#modalTambahRole" data-bs-target="#modalTambahRole">
                <i class="fas fa-plus-circle"></i> Tambah Role
            </button>
        </div>
    </div>

    <!-- Alert Notifikasi Sukses / Error -->
    @if(session('success'))
        <div class="alert alert-success alert-auto alert-dismissible fade show mb-4 border-0 shadow-sm rounded-3" role="alert" style="background-color: #dcfce7; color: #166534;">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="close float-end" data-dismiss="alert" data-bs-dismiss="alert" aria-label="Close" style="background:transparent; border:none; font-size:1.2rem;">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-auto alert-dismissible fade show mb-4 border-0 shadow-sm rounded-3" role="alert" style="background-color: #fee2e2; color: #991b1b;">
            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
            <button type="button" class="close float-end" data-dismiss="alert" data-bs-dismiss="alert" aria-label="Close" style="background:transparent; border:none; font-size:1.2rem;">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Alert Error Validasi Laravel -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mb-4 border-0 shadow-sm rounded-3" role="alert" style="background-color: #fee2e2; color: #991b1b;">
            <i class="fas fa-exclamation-triangle me-2"></i> <strong>Gagal Menyimpan!</strong> Periksa kembali form input Anda:
            <ul class="mb-0 mt-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close float-end" data-dismiss="alert" data-bs-dismiss="alert" aria-label="Close" style="background:transparent; border:none; font-size:1.2rem;">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Tab Navigasi -->
    <div class="crm-tabs">
        <button type="button" class="crm-tab {{ $activeTab === 'pengguna' ? 'active' : '' }}" data-tab="pengguna">
            <i class="fas fa-users"></i> Data Pengguna
        </button>
        <button type="button" class="crm-tab {{ $activeTab === 'hak-akses' ? 'active' : '' }}" data-tab="hak-akses">
            <i class="fas fa-shield-alt"></i> Hak Akses
        </button>
    </div>

    <!-- ===================================================== -->
    <!-- TAB 1: DATA PENGGUNA                                  -->
    <!-- ===================================================== -->
    <div class="crm-pane {{ $activeTab === 'pengguna' ? 'active' : '' }}" id="pane-pengguna">

        <!-- Card Statistik Ringkasan -->
        <div class="row g-3 mb-4">
            <div class="col-xl-4 col-md-6">
                <div class="card stat-card-light p-3 h-100" style="border-left: 5px solid #2563eb !important;">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-uppercase text-muted fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">Total Pengguna Aktif</div>
                            <div class="h4 mb-0 fw-bold text-dark mt-1" style="font-weight: 700;">{{ $users->where('status', 'Aktif')->count() }} <span class="fs-6 fw-normal text-muted">Akun</span></div>
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
                            <div class="h4 mb-0 fw-bold text-dark mt-1" style="font-weight: 700;">
                                {{ $users->filter(fn($u) => str_contains(strtolower($u->role ?? ''), 'admin'))->count() }} <span class="fs-6 fw-normal text-muted">Staf</span>
                            </div>
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
                            <div class="h4 mb-0 fw-bold text-dark mt-1" style="font-weight: 700;">
                                {{ $users->where('role', 'Digital Marketing')->count() }} <span class="fs-6 fw-normal text-muted">Staf</span>
                            </div>
                        </div>
                        <div class="p-3 rounded-circle" style="background-color: rgba(219, 39, 119, 0.1); color: #db2777;">
                            <i class="fas fa-headset fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card OTOMATIS untuk setiap role tambahan (dari tabel ms_role) -->
            @php
                $warnaRole = [
                    ['#0d9488', 'rgba(13, 148, 136, 0.1)'],
                    ['#d97706', 'rgba(217, 119, 6, 0.1)'],
                    ['#7c3aed', 'rgba(124, 58, 237, 0.1)'],
                    ['#0891b2', 'rgba(8, 145, 178, 0.1)'],
                ];
            @endphp
            @foreach($customRoles as $i => $cRole)
                @php
                    $namaRole = is_array($cRole) ? ($cRole['name'] ?? '') : $cRole;
                    $warna = $warnaRole[$i % count($warnaRole)];
                @endphp
                @if(!empty($namaRole))
                    <div class="col-xl-4 col-md-6">
                        <div class="card stat-card-light p-3 h-100" style="border-left: 5px solid {{ $warna[0] }} !important;">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <div class="text-uppercase text-muted fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">{{ $namaRole }}</div>
                                    <div class="h4 mb-0 fw-bold text-dark mt-1" style="font-weight: 700;">
                                        {{ $users->where('role', $namaRole)->count() }} <span class="fs-6 fw-normal text-muted">Staf</span>
                                    </div>
                                </div>
                                <div class="p-3 rounded-circle" style="background-color: {{ $warna[1] }}; color: {{ $warna[0] }};">
                                    <i class="fas fa-user-cog fa-lg"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        <!-- Tabel Data Pengguna -->
        <div class="card crm-card-light overflow-hidden mb-4 bg-white">
            <div class="card-body p-4 bg-white">

                <!-- Baris Atas Tabel -->
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
                    <div>
                        <h5 class="fw-bold text-dark mb-1" style="font-size: 1.2rem; letter-spacing: -0.3px;">Daftar Master Pengguna Sistem</h5>
                        <p class="text-secondary mb-0" style="font-size: 0.875rem; font-weight: 400;">Kelola seluruh akun staf dan status keaktifan tim</p>
                    </div>

                    <div class="position-relative" style="min-width: 280px;">
                        <input type="text" id="searchPengguna" class="form-control form-control-sm ps-5 pe-3 py-2 bg-white text-dark" placeholder="Cari nama, email, role..." style="border-radius: 20px; border: 1px solid #cbd5e1; font-size: 0.875rem;">
                        <i class="fas fa-search position-absolute text-secondary" style="left: 15px; top: 50%; transform: translateY(-50%); font-size: 0.85rem;"></i>
                    </div>
                </div>

                <!-- Tabel Data -->
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle mb-0 super-thick-table" id="tablePengguna">
                        <thead class="crm-table-header text-uppercase fs-7">
                            <tr>
                                <th class="py-3 text-white text-center" style="width: 6%;">NO</th>
                                <th class="py-3 text-white text-center" style="width: 24%;">NAMA PENGGUNA</th>
                                <th class="py-3 text-white text-center" style="width: 26%;">ALAMAT EMAIL</th>
                                <th class="py-3 text-white text-center" style="width: 18%;">ROLE AKSES</th>
                                <th class="py-3 text-white text-center" style="width: 12%;">STATUS</th>
                                <th class="py-3 text-white text-center" style="width: 14%;">AKSI</th>
                            </tr>
                        </thead>
                        <tbody style="font-weight: 500;">
                            @foreach($users as $index => $user)
                                @php
                                    $roleClass = 'badge-default';
                                    $roleIcon = 'fa-user';

                                    $roleName = strtolower($user->role ?? '');
                                    if(str_contains($roleName, 'admin')) {
                                        $roleClass = 'badge-superadmin';
                                        $roleIcon = 'fa-user-shield';
                                    } elseif(str_contains($roleName, 'marketing')) {
                                        $roleClass = 'badge-marketing';
                                        $roleIcon = 'fa-headset';
                                    }

                                    $statusAktif = ($user->status === 'Aktif');
                                @endphp

                                <tr>
                                    <td class="px-3 py-3 text-secondary text-center">{{ $index + 1 }}</td>
                                    <td class="py-3">
                                        <div class="text-dark fw-bold" style="font-weight: 600;">{{ $user->nama }}</div>
                                    </td>
                                    <td class="py-3 text-secondary">{{ $user->email }}</td>
                                    <td class="py-3">
                                        <span class="badge crm-badge {{ $roleClass }}">
                                            <i class="fas {{ $roleIcon }} me-1"></i> {{ $user->role ?? 'Belum Diatur' }}
                                        </span>
                                    </td>
                                    <td class="py-3 text-center">
                                        <span class="badge crm-badge {{ $statusAktif ? 'badge-aktif' : 'badge-nonaktif' }}">
                                            <i class="fas {{ $statusAktif ? 'fa-check-circle' : 'fa-times-circle' }} me-1"></i> {{ $user->status }}
                                        </span>
                                    </td>
                                    <td class="py-3 text-center">
                                        <div class="d-flex justify-content-center align-items-center gap-1 flex-nowrap">
                                            <!-- Tombol Edit -->
                                            <button class="btn btn-sm btn-outline-primary shadow-sm px-2 py-1" title="Edit Data" style="border-radius: 4px;" data-toggle="modal" data-bs-toggle="modal" data-target="#modalEditPengguna{{ $user->id_pengguna }}" data-bs-target="#modalEditPengguna{{ $user->id_pengguna }}">
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            <!-- Tombol Hapus: konfirmasi memakai modal custom -->
                                            <form id="formHapus{{ $user->id_pengguna }}" action="{{ route('hapus-pengguna', $user->id_pengguna) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-outline-danger shadow-sm px-2 py-1 btn-hapus" title="Hapus Pengguna" style="border-radius: 4px;" data-form="formHapus{{ $user->id_pengguna }}" data-nama="{{ $user->nama }}" data-jenis="pengguna">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Include Modal Edit per User -->
                                @include('user-management.edit')

                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($users->isEmpty())
                    <div class="text-center py-4">
                        <p class="text-muted mb-0">Belum ada data pengguna yang terdaftar di database.</p>
                    </div>
                @endif

            </div>
        </div>
    </div>

    <!-- ===================================================== -->
    <!-- TAB 2: HAK AKSES                                      -->
    <!-- ===================================================== -->
    <div class="crm-pane {{ $activeTab === 'hak-akses' ? 'active' : '' }}" id="pane-hak-akses">

        <!-- Card Statistik Ringkasan Role -->
        <div class="row g-3 mb-4">
            <div class="col-xl-4 col-md-6">
                <div class="card stat-card-light p-3 h-100" style="border-left: 5px solid #2563eb !important;">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-uppercase text-muted fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">Total Group Role</div>
                            <div class="h4 mb-0 fw-bold text-dark mt-1" style="font-weight: 700;">
                                {{ $totalGroups }} <span class="fs-6 fw-normal text-muted">Role Aktif</span>
                            </div>
                        </div>
                        <div class="p-3 rounded-circle" style="background-color: rgba(37, 99, 235, 0.1); color: #2563eb;">
                            <i class="fas fa-layer-group fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card untuk Setiap Role yang Terdaftar -->
            @foreach($rolesData as $role)
            <div class="col-xl-4 col-md-6">
                <div class="card stat-card-light p-3 h-100 d-flex flex-column" style="border-left: 5px solid {{ $loop->iteration % 2 == 0 ? '#db2777' : '#4f46e5' }} !important;">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div>
                            <div class="text-uppercase text-muted fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">{{ $role['name'] }}</div>
                            <div class="h4 mb-0 fw-bold text-dark mt-1" style="font-weight: 700;">
                                <span class="badge {{ $role['name'] == 'Super Administrator' ? 'badge-superadmin' : ($role['name'] == 'Digital Marketing' ? 'badge-marketing' : 'badge-custom') }} px-2 py-1 fs-6 fw-bold">
                                    {{ $role['name'] == 'Super Administrator' ? 'Full Access' : 'Custom Access' }}
                                </span>
                            </div>
                        </div>
                        <div class="p-3 rounded-circle" style="background-color: rgba(79, 70, 229, 0.1); color: #4f46e5;">
                            <i class="fas fa-shield-alt fa-lg"></i>
                        </div>
                    </div>

                    <!-- Tombol Hapus Role (semua role kecuali Super Administrator) -->
                    @if($role['name'] !== 'Super Administrator')
                        <div class="mt-auto pt-2 border-top text-end">
                            <form id="formHapusRole{{ $loop->iteration }}" action="{{ route('user-group.destroy', $role['name']) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-sm btn-outline-danger py-1 px-2 shadow-sm fw-bold btn-hapus" style="font-size: 0.75rem; border-radius: 6px;" data-form="formHapusRole{{ $loop->iteration }}" data-nama="{{ $role['name'] }}" data-jenis="role">
                                    <i class="fas fa-trash-alt me-1"></i> Hapus Role
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        <!-- Form Pembungkus Simpan Hak Akses -->
        <form action="{{ route('user-group.update') }}" method="POST">
            @csrf
            <div class="card crm-card-light overflow-hidden mb-4 bg-white">
                <div class="card-body p-4 bg-white">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
                        <div>
                            <h5 class="fw-bold text-dark mb-1" style="font-size: 1.2rem; letter-spacing: -0.3px;">Matriks Perizinan Akses Menu</h5>
                            <p class="text-secondary mb-0" style="font-size: 0.875rem; font-weight: 400;">Centang fitur yang diizinkan untuk diakses oleh masing-masing grup role</p>
                        </div>
                        <div class="position-relative" style="min-width: 280px;">
                            <input type="text" id="searchRole" class="form-control form-control-sm ps-5 pe-3 py-2 bg-white text-dark" placeholder="Cari modul atau nama menu..." style="border-radius: 20px; border: 1px solid #cbd5e1; font-size: 0.875rem;">
                            <i class="fas fa-search position-absolute text-secondary" style="left: 15px; top: 50%; transform: translateY(-50%); font-size: 0.85rem;"></i>
                        </div>
                    </div>

                    <!-- Tabel Matriks Permisi Dinamis Berdasarkan Role -->
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered align-middle mb-0 super-thick-table" id="tableGroup">
                            <thead class="crm-table-header text-uppercase fs-7">
                                <tr>
                                    <th class="py-3 text-white text-center" style="width: 5%;">NO</th>
                                    <th class="py-3 text-white text-center" style="width: 35%;">MODUL / NAMA MENU</th>
                                    @foreach($rolesData as $role)
                                        <th class="py-3 text-white text-center">
                                            <span class="badge {{ $role['name'] == 'Super Administrator' ? 'badge-superadmin' : ($role['name'] == 'Digital Marketing' ? 'badge-marketing' : 'badge-custom') }} px-3 py-1">
                                                <i class="fas {{ $role['name'] == 'Super Administrator' ? 'fa-user-shield' : ($role['name'] == 'Digital Marketing' ? 'fa-headset' : 'fa-user-cog') }} me-1"></i> {{ strtoupper($role['name']) }}
                                            </span>
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody style="font-weight: 500;">
                                @php
                                    // Kunci menu HARUS sama dengan yang dipakai CekMenu di routes/web.php.
                                    // Dashboard & profil terbuka untuk semua user login; Manajemen Pengguna
                                    // dan Switch Profile khusus Superadmin (tidak ada di matriks).
                                    $menuList = [
                                        ['key' => 'data-konsumen', 'label' => 'Data Konsumen', 'icon' => 'fa-users'],
                                        ['key' => 'data-unit', 'label' => 'Data Unit Servis', 'icon' => 'fa-tools'],
                                        ['key' => 'data-teknisi', 'label' => 'Data Teknisi', 'icon' => 'fa-user-cog'],
                                        ['key' => 'registrasi-servis', 'label' => 'Registrasi Servis', 'icon' => 'fa-clipboard-list'],
                                        ['key' => 'closing', 'label' => 'Closing Servis', 'icon' => 'fa-file-invoice'],
                                        ['key' => 'pengingat-perawatan', 'label' => 'Pengingat Perawatan Berkala', 'icon' => 'fa-calendar-alt'],
                                        ['key' => 'follow-up', 'label' => 'Follow-up Konsumen (Chat & Happy Call)', 'icon' => 'fa-headset'],
                                        ['key' => 'laporan', 'label' => 'Laporan & Riwayat Servis', 'icon' => 'fa-file-alt'],
                                    ];
                                @endphp
                                @foreach($menuList as $index => $menu)
                                    <tr>
                                        <td class="px-3 py-3 text-secondary text-center">{{ $index + 1 }}</td>
                                        <td class="py-3 px-3">
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="p-2 rounded bg-light text-primary">
                                                    <i class="fas {{ $menu['icon'] }}"></i>
                                                </div>
                                                <span class="text-dark fw-bold" style="font-weight: 600;">{{ $menu['label'] }}</span>
                                            </div>
                                        </td>
                                        @foreach($rolesData as $role)
                                            <td class="py-3 text-center {{ $role['name'] == 'Super Administrator' ? 'bg-light bg-opacity-50' : '' }}">
                                                @if($role['name'] == 'Super Administrator')
                                                    <!-- Super Admin Selalu Full Access -->
                                                    <div class="d-flex align-items-center justify-content-center gap-2">
                                                        <input type="checkbox" class="form-check-input form-check-input-custom" checked disabled>
                                                        <span class="badge badge-aktif">Full Access</span>
                                                    </div>
                                                @else
                                                    <!-- Role Lain Bisa Dicentang -->
                                                    <div class="d-flex align-items-center justify-content-center">
                                                        <input type="hidden" name="access[{{ $role['name'] }}][{{ $menu['key'] }}]" value="0">
                                                        <input type="checkbox"
                                                               name="access[{{ $role['name'] }}][{{ $menu['key'] }}]"
                                                               value="1"
                                                               class="form-check-input form-check-input-custom"
                                                               {{ isset($permissions[$role['name']][$menu['key']]) && $permissions[$role['name']][$menu['key']] == 1 ? 'checked' : '' }}>
                                                    </div>
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Footer Simpan Hak Akses -->
                    <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                        <span class="text-secondary small">
                            <i class="fas fa-info-circle me-1 text-primary"></i> Superadmin secara otomatis memiliki hak akses ke seluruh fitur sistem. Dashboard, profil, dan notifikasi terbuka untuk semua pengguna yang login, sedangkan Manajemen Pengguna dan Switch Profile khusus Superadmin.
                        </span>
                        <button type="submit" class="btn btn-primary px-4 py-2 fw-bold rounded-pill shadow-sm" style="background-color: #2563eb; border-color: #2563eb;">
                            <i class="fas fa-save me-1"></i> Simpan Hak Akses
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Include Modal Tambah Pengguna -->
@include('user-management.create')

<!-- MODAL MENGAMBANG: Tambah Role Baru -->
<div class="modal fade" id="modalTambahRole" tabindex="-1" aria-labelledby="modalTambahRoleLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header text-white p-3" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);">
                <h5 class="modal-title fw-bold fs-6" id="modalTambahRoleLabel">
                    <i class="fas fa-shield-alt text-primary me-2"></i> Tambah Role / Kelompok Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('user-group.store') }}" method="POST" autocomplete="off">
                @csrf
                <div class="modal-body p-4 bg-white">
                    <div class="mb-3">
                        <label class="form-label text-dark fw-bold small">Nama Role Baru <span class="text-danger">*</span></label>
                        <input type="text" name="role_name" class="form-control" placeholder="Contoh: Teknisi, Staff Gudang, Kasir" required style="border-radius: 8px; border: 1px solid #cbd5e1; font-size: 0.875rem;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-dark fw-bold small">Deskripsi Peran / Tugas</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Jelaskan secara singkat wewenang atau tugas role ini..." style="border-radius: 8px; border: 1px solid #cbd5e1; font-size: 0.875rem;"></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light border-top p-3 d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-secondary px-3 py-2 rounded-pill small" data-bs-dismiss="modal" data-dismiss="modal" style="font-size: 0.85rem;">Batal</button>
                    <button type="submit" class="btn btn-primary px-4 py-2 rounded-pill fw-bold small" style="background-color: #2563eb; border-color: #2563eb; font-size: 0.85rem;">
                        <i class="fas fa-plus-circle me-1"></i> Simpan Role Baru
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus (Custom, dipakai untuk Pengguna dan Role) -->
<div class="hapus-overlay" id="hapusOverlay" aria-hidden="true">
    <div class="hapus-box" role="dialog" aria-modal="true" aria-labelledby="hapusTitle">
        <div class="hapus-icon"><i class="fas fa-trash"></i></div>
        <h5 class="hapus-title" id="hapusTitle">Yakin ingin menghapus?</h5>
        <p class="hapus-text"><span id="hapusJenis">Pengguna</span> <span id="hapusNama" style="font-weight: 600;"></span> akan dihapus dan tidak dapat dikembalikan.<span id="hapusCatatanRole" style="display: none;"> Pastikan tidak ada staf yang sedang menggunakan role ini.</span></p>
        <div class="hapus-actions">
            <button type="button" class="hapus-btn hapus-btn-batal" id="hapusBatal">Batal</button>
            <button type="button" class="hapus-btn hapus-btn-ya" id="hapusYa"><i class="fas fa-trash"></i> Ya, Hapus</button>
        </div>
    </div>
</div>

<!-- Script JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
$(document).ready(function(){
    // Notifikasi sukses / error hilang otomatis setelah 4 detik
    setTimeout(function() {
        $(".alert-auto").fadeOut(500, function() { $(this).remove(); });
    }, 4000);

    // ===== Pindah Tab =====
    function tampilkanTab(nama) {
        $(".crm-tab").removeClass("active");
        $(".crm-tab[data-tab='" + nama + "']").addClass("active");
        $(".crm-pane").removeClass("active");
        $("#pane-" + nama).addClass("active");

        // Tombol di header menyesuaikan tab yang aktif
        if (nama === "hak-akses") {
            $("#btnTambahPengguna").hide();
            $("#btnTambahRole").css("display", "inline-flex");
        } else {
            $("#btnTambahRole").hide();
            $("#btnTambahPengguna").css("display", "inline-flex");
        }

        // Simpan tab di URL supaya tetap sama saat halaman di-refresh
        if (window.history && window.history.replaceState) {
            window.history.replaceState(null, "", window.location.pathname + "?tab=" + nama);
        }
    }

    $(".crm-tab").on("click", function() {
        tampilkanTab($(this).data("tab"));
    });

    // ===== Pencarian Tab Data Pengguna =====
    $("#searchPengguna").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#tablePengguna tbody > tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });

    // ===== Pencarian Tab Hak Akses =====
    $("#searchRole").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#tableGroup tbody > tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });

    // ===== Modal Konfirmasi Hapus (Custom) =====
    var formTerpilih = null;
    var $overlay = $("#hapusOverlay");

    function tutupHapus() {
        $overlay.removeClass("show").attr("aria-hidden", "true");
        formTerpilih = null;
    }

    $(document).on("click", ".btn-hapus", function() {
        var jenis = $(this).data("jenis");
        formTerpilih = document.getElementById($(this).data("form"));
        $("#hapusNama").text($(this).data("nama"));
        $("#hapusJenis").text(jenis === "role" ? "Role" : "Pengguna");
        $("#hapusCatatanRole").toggle(jenis === "role");
        $overlay.addClass("show").attr("aria-hidden", "false");
    });

    $("#hapusBatal").on("click", tutupHapus);

    // Klik area gelap di luar kotak = batal
    $overlay.on("click", function(e) {
        if (e.target === this) tutupHapus();
    });

    // Tombol ESC = batal
    $(document).on("keydown", function(e) {
        if (e.key === "Escape" && $overlay.hasClass("show")) tutupHapus();
    });

    $("#hapusYa").on("click", function() {
        if (formTerpilih) {
            formTerpilih.submit();
        }
    });
});
</script>
@endsection