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
    
    /* Style khusus Switch Checkbox agar tampil rapi */
    .form-check-input-custom {
        width: 1.3em;
        height: 1.3em;
        cursor: pointer;
    }
</style>

<div class="container-fluid px-4 pt-3 pb-4 crm-wrapper" style="background: linear-gradient(135deg, #eef1f3 0%, #eef1f3 100%); min-height: 100vh;">

    <!-- Header Halaman (Banner Gelap Elegan Khusus Header Saja) -->
    <div class="card rounded-4 mb-4 text-white shadow-lg overflow-hidden" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); border: 1px solid rgba(56, 189, 248, 0.35) !important;">
        <div class="card-body p-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h1 class="h3 mb-1 text-white" style="font-weight: 700;">
                    <i class="fas fa-shield-alt text-primary me-2"></i> User Group & Hak Akses Role
                </h1>
                <p class="text-light opacity-75 mb-0" style="font-weight: 500;">
                    Kelola matriks perizinan menu operasional dan kelompok peran staf di CRM Jawaratech
                </p>
            </div>
            
            <!-- Tombol Tambah Role (Membuka Modal Mengambang) -->
            <button type="button" class="btn btn-primary shadow-sm px-4 py-2 fw-bold d-flex align-items-center gap-2 rounded-pill" style="font-size: 0.875rem; background-color: #2563eb; border-color: #2563eb;" data-bs-toggle="modal" data-bs-target="#modalTambahRole" data-toggle="modal" data-target="#modalTambahRole">
                <i class="fas fa-plus-circle"></i> Tambah Role
            </button>
        </div>
    </div>

    <!-- Alert Notifikasi Sukses -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4 border-0 shadow-sm rounded-3" role="alert" style="background-color: #dcfce7; color: #166534;">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- 3 Card Statistik Ringkasan di Atas (Gaya Terang Clean) -->
    <div class="row g-3 mb-4">
        <div class="col-xl-4 col-md-6">
            <div class="card stat-card-light p-3 h-100" style="border-left: 5px solid #2563eb !important;">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-uppercase text-muted fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">Total Group Role</div>
                        <div class="h4 mb-0 fw-bold text-dark mt-1" style="font-weight: 700;">
                            2 <span class="fs-6 fw-normal text-muted">Role Aktif</span>
                        </div>
                    </div>
                    <div class="p-3 rounded-circle" style="background-color: rgba(37, 99, 235, 0.1); color: #2563eb;">
                        <i class="fas fa-layer-group fa-lg"></i>
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
                            <span class="badge badge-superadmin px-2 py-1 fs-6 fw-bold">Full Access</span>
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
                            <span class="badge badge-marketing px-2 py-1 fs-6 fw-bold">Custom Access</span>
                        </div>
                    </div>
                    <div class="p-3 rounded-circle" style="background-color: rgba(219, 39, 119, 0.1); color: #db2777;">
                        <i class="fas fa-headset fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Pembungkus Simpan Hak Akses -->
    <form action="{{ route('user-group.update') }}" method="POST">
        @csrf

        <!-- Tabel Data Permisi Hak Akses Menu -->
        <div class="card crm-card-light overflow-hidden mb-4 bg-white">
            <div class="card-body p-4 bg-white">
                
                <!-- Baris Atas Tabel: Judul Utama & Subtitle Clean + Search Box -->
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
                    <div>
                        <h5 class="fw-bold text-dark mb-1" style="font-size: 1.2rem; letter-spacing: -0.3px;">Matriks Perizinan Akses Menu</h5>
                        <p class="text-secondary mb-0" style="font-size: 0.875rem; font-weight: 400;">Centang fitur yang diizinkan untuk diakses oleh masing-masing grup role</p>
                    </div>

                    <!-- Input Pencarian Realtime -->
                    <div class="position-relative" style="min-width: 280px;">
                        <input type="text" id="searchInput" class="form-control form-control-sm ps-5 pe-3 py-2 bg-white text-dark" placeholder="Cari modul atau nama menu..." style="border-radius: 20px; border: 1px solid #cbd5e1; font-size: 0.875rem;">
                        <i class="fas fa-search position-absolute text-secondary" style="left: 15px; top: 50%; transform: translateY(-50%); font-size: 0.85rem;"></i>
                    </div>
                </div>

                <!-- Tabel Matriks Permisi -->
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle mb-0 super-thick-table" id="tableGroup">
                        <thead class="crm-table-header text-uppercase fs-7">
                            <tr>
                                <th class="py-3 text-white text-center" style="width: 6%;">NO</th>
                                <th class="py-3 text-white text-center" style="width: 44%;">MODUL / NAMA MENU</th>
                                <th class="py-3 text-white text-center" style="width: 25%;">
                                    <span class="badge badge-superadmin px-3 py-1">
                                        <i class="fas fa-user-shield me-1"></i> SUPER ADMIN
                                    </span>
                                </th>
                                <th class="py-3 text-white text-center" style="width: 25%;">
                                    <span class="badge badge-marketing px-3 py-1">
                                        <i class="fas fa-headset me-1"></i> DIGITAL MARKETING
                                    </span>
                                </th>
                            </tr>
                        </thead>
                        <tbody style="font-weight: 500;">
                            @php
                                $menuList = [
                                    [
                                        'key' => 'dashboard',
                                        'label' => 'Dashboard & Grafik Analisis',
                                        'icon' => 'fa-chart-pie',
                                    ],
                                    [
                                        'key' => 'data-konsumen',
                                        'label' => 'Data Master Konsumen & Unit',
                                        'icon' => 'fa-users',
                                    ],
                                    [
                                        'key' => 'layanan-servis',
                                        'label' => 'Layanan Servis (Registrasi, Closing, Followup)',
                                        'icon' => 'fa-tools',
                                    ],
                                    [
                                        'key' => 'hak-akses',
                                        'label' => 'Manajemen Pengguna & Kelola Akun',
                                        'icon' => 'fa-user-cog',
                                    ],
                                    [
                                        'key' => 'user-group',
                                        'label' => 'User Group / Kelola Role',
                                        'icon' => 'fa-shield-alt',
                                    ],
                                    [
                                        'key' => 'report',
                                        'label' => 'Laporan & Log Kronologis',
                                        'icon' => 'fa-file-alt',
                                    ],
                                    [
                                        'key' => 'schedules',
                                        'label' => 'Jadwal Perawatan Servis',
                                        'icon' => 'fa-calendar-alt',
                                    ],
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
                                    
                                    <!-- Role Superadmin (Selalu Centang / Full Access) -->
                                    <td class="py-3 text-center bg-light bg-opacity-50">
                                        <div class="d-flex align-items-center justify-content-center gap-2">
                                            <input type="checkbox" class="form-check-input form-check-input-custom" checked disabled>
                                            <span class="badge badge-aktif">Full Access</span>
                                        </div>
                                    </td>

                                    <!-- Role Digital Marketing (Bisa Dicentang / Diatur) -->
                                    <td class="py-3 text-center">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <input type="hidden" name="access[Digital Marketing][{{ $menu['key'] }}]" value="0">
                                            <input type="checkbox" 
                                                   name="access[Digital Marketing][{{ $menu['key'] }}]" 
                                                   value="1" 
                                                   class="form-check-input form-check-input-custom" 
                                                   {{ isset($permissions['Digital Marketing'][$menu['key']]) ? 'checked' : '' }}>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Footer Simpan Hak Akses -->
                <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                    <span class="text-secondary small">
                        <i class="fas fa-info-circle me-1 text-primary"></i> Superadmin secara otomatis memiliki hak akses ke seluruh fitur sistem.
                    </span>
                    <button type="submit" class="btn btn-primary px-4 py-2 fw-bold rounded-pill shadow-sm" style="background-color: #2563eb; border-color: #2563eb;">
                        <i class="fas fa-save me-1"></i> Simpan Hak Akses
                    </button>
                </div>

            </div>
        </div>
    </form>

</div>

<!-- MODAL MENGAMBANG: Tambah Role Baru -->
<div class="modal fade" id="modalTambahRole" tabindex="-1" aria-labelledby="modalTambahRoleLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <!-- Modal Header Navy Gradient -->
            <div class="modal-header text-white p-3" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);">
                <h5 class="modal-title fw-bold fs-6" id="modalTambahRoleLabel">
                    <i class="fas fa-shield-alt text-primary me-2"></i> Tambah Role / Kelompok Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="#" method="POST">
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

<!-- Script JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Script Filter Pencarian Real-Time -->
<script>
$(document).ready(function(){
    $("#searchInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#tableGroup tbody tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
});
</script>
@endsection