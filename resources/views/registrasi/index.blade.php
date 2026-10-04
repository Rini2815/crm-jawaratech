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
    color: #0f172a;
}
.crm-card {
    border: 1px solid #cbd5e1;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
    border-radius: 12px;
    background: #ffffff !important;
}

/* Style Kartu Statistik Ringkasan */
.stat-card {
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
    background-color: #ffffff;
    transition: all 0.2s ease;
}
.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}
.stat-card.blue { border-left: 4px solid #2563eb !important; }
.stat-card.yellow { border-left: 4px solid #d97706 !important; }
.stat-card.green { border-left: 4px solid #16a34a !important; }
.stat-card.purple { border-left: 4px solid #7c3aed !important; }

.crm-table-header {
    background-color: #1e293b; /* Warna Navy Slate tegas */
    color: #ffffff;
    font-weight: 600;
    letter-spacing: 0.5px;
}
.crm-form-control {
    border: 1px solid #cbd5e1;
    border-radius: 6px;
    padding: 0.45rem 0.75rem;
    font-size: 0.9rem;
    font-weight: 500;
    color: #0f172a;
    background-color: #ffffff;
}
.crm-form-control:focus {
    border-color: #38bdf8;
    box-shadow: 0 0 0 0.2rem rgba(56, 189, 248, 0.25);
    outline: none;
}
.crm-badge {
    font-weight: 600;
    letter-spacing: 0.3px;
    border-radius: 4px;
    padding: 0.35em 0.65em;
    font-size: 0.75rem;
}
.badge-dicek { background-color: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
.badge-proses { background-color: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; }

.super-thick-table th, 
.super-thick-table td {
    border-width: 2px !important;
    border-color: #cbd5e1 !important;
}

/* CUSTOM STYLE UNTUK TABS AGAR TERLIHAT MODERN */
.crm-tabs {
    border-bottom: 2px solid #cbd5e1;
    margin-bottom: 20px;
}
.crm-tabs .nav-link {
    font-weight: 600;
    color: #64748b;
    border: none;
    border-bottom: 3px solid transparent;
    padding: 12px 24px;
    transition: all 0.3s ease;
    font-size: 1rem;
    border-radius: 0;
}
.crm-tabs .nav-link:hover {
    color: #0f172a;
    border-bottom-color: #94a3b8;
}
.crm-tabs .nav-link.active {
    color: #2563eb;
    border-bottom-color: #2563eb;
    background: transparent;
}
</style>

<div class="container-fluid px-4 pt-3 pb-4 crm-wrapper" style="background: linear-gradient(135deg, #eef1f3 0%, #eef1f3 100%); min-height: 100vh;">

    <!-- ================================================================= -->
    <!-- BAGIAN 1: BANNER UTAMA REGISTRASI & DATA KONSUMEN                 -->
    <!-- ================================================================= -->
    <div class="card rounded-3 mb-4 text-white shadow-sm overflow-hidden" style="background: #0f172a; border: 1px solid #1e293b;">
        <div class="card-body p-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h1 class="h3 mb-1 text-white fw-bold d-flex align-items-center gap-2">
                    <i class="fas fa-database text-info"></i> Pusat Data Master & Registrasi Servis (FR03)
                </h1>
                <p class="text-light opacity-75 mb-0" style="font-weight: 400; font-size: 0.95rem;">
                    Halaman terpadu untuk Data Konsumen, Data Unit Servis, dan Tiket Registrasi Berjalan CRM Jawaratech
                </p>
            </div>
            
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-primary px-3 py-2 fw-semibold rounded-pill shadow-sm text-sm" data-toggle="modal" data-target="#modalTambahKonsumen">
                    <i class="fas fa-user-plus"></i> + Tambah Konsumen
                </button>
                <button type="button" class="btn btn-success px-3 py-2 fw-semibold rounded-pill shadow-sm text-sm" data-toggle="modal" data-target="#modalTambahRegistrasi">
                    <i class="fas fa-plus-circle"></i> + Registrasi Baru
                </button>
            </div>
        </div>
    </div>

    <!-- ================================================================= -->
    <!-- NAV TABS (MENU NAVIGASI ANTAR TABEL)                              -->
    <!-- ================================================================= -->
    <ul class="nav nav-tabs crm-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="konsumen-tab" data-toggle="tab" href="#konsumen" role="tab" aria-controls="konsumen" aria-selected="true">
                <i class="fas fa-users mr-1"></i> Data Konsumen
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="unit-tab" data-toggle="tab" href="#unit" role="tab" aria-controls="unit" aria-selected="false">
                <i class="fas fa-tools text-purple mr-1"></i> Data Unit Servis
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="registrasi-tab" data-toggle="tab" href="#registrasi" role="tab" aria-controls="registrasi" aria-selected="false">
                <i class="fas fa-file-alt text-success mr-1"></i> Servis Berjalan
            </a>
        </li>
    </ul>

    <!-- ================================================================= -->
    <!-- ISI TAB KONTEN                                                    -->
    <!-- ================================================================= -->
    <div class="tab-content" id="myTabContent">
        
        <!-- ================= TAB 1: DATA KONSUMEN =================== -->
        <div class="tab-pane fade show active" id="konsumen" role="tabpanel" aria-labelledby="konsumen-tab">
            <div class="card crm-card overflow-hidden mb-4">
                <div class="card-header bg-white border-bottom pt-4 px-4 pb-3">
                    <h5 class="m-0 text-dark fw-bold">Daftar Konsumen Jawaratech</h5>
                    <small class="text-muted">Buku kontak dan master informasi pelanggan sistem CRM Jawaratech</small>
                </div>
                <div class="card-body p-4 bg-white">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered align-middle mb-0 super-thick-table">
                            <thead class="crm-table-header text-uppercase text-center fs-7">
                                <tr>
                                    <th class="py-3 text-white text-center" style="width: 8%;">NO</th>
                                    <th class="py-3 text-white text-start" style="width: 25%;">NAMA KONSUMEN</th>
                                    <th class="py-3 text-white text-start" style="width: 25%;">NOMOR WHATSAPP</th>
                                    <th class="py-3 text-white text-start" style="width: 27%;">ALAMAT DOMISILI</th>
                                    <th class="py-3 text-white text-center" style="width: 15%;">JUMLAH UNIT</th>
                                    <th class="py-3 text-white text-center" style="width: 10%;">AKSI</th>
                                </tr>
                            </thead>
                            <tbody style="font-weight: 500;">
                                <tr>
                                    <td class="px-4 py-3 text-secondary text-center fw-bold">1</td>
                                    <td class="py-3 text-dark fw-bold">Budi Santoso</td>
                                    <td class="py-3 text-success fw-semibold"><i class="fab fa-whatsapp"></i> 081234567890</td>
                                    <td class="py-3 text-secondary">Jl. Manggis No. 12, Madiun</td>
                                    <td class="py-3 text-center"><span class="badge bg-primary text-white px-2 py-1">2 Unit</span></td>
                                    <td class="py-3 text-center">
                                        <button class="btn btn-sm btn-outline-primary shadow-sm px-2 py-1"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-sm btn-outline-danger shadow-sm px-2 py-1"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-3 text-secondary text-center fw-bold">2</td>
                                    <td class="py-3 text-dark fw-bold">Siti Aminah</td>
                                    <td class="py-3 text-success fw-semibold"><i class="fab fa-whatsapp"></i> 085712345678</td>
                                    <td class="py-3 text-secondary">Jl. Pahlawan No. 45, Madiun</td>
                                    <td class="py-3 text-center"><span class="badge bg-primary text-white px-2 py-1">1 Unit</span></td>
                                    <td class="py-3 text-center">
                                        <button class="btn btn-sm btn-outline-primary shadow-sm px-2 py-1"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-sm btn-outline-danger shadow-sm px-2 py-1"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- ================= TAB 2: DATA UNIT SERVIS =================== -->
        <div class="tab-pane fade" id="unit" role="tabpanel" aria-labelledby="unit-tab">
            <div class="card crm-card overflow-hidden mb-4">
                <div class="card-header bg-white border-bottom pt-4 px-4 pb-3">
                    <h5 class="m-0 text-dark fw-bold">Daftar Master Unit Pelanggan</h5>
                    <small class="text-muted">Kelola spesifikasi teknis unit pelanggan, tanggal masuk servis, dan status garansi</small>
                </div>
                <div class="card-body p-4 bg-white">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered align-middle mb-0 super-thick-table">
                            <thead class="crm-table-header text-uppercase text-center fs-7">
                                <tr>
                                    <th class="py-3 text-white text-center" style="width: 5%;">NO</th>
                                    <th class="py-3 text-white text-start" style="width: 22%;">PEMILIK UNIT</th>
                                    <th class="py-3 text-white text-start" style="width: 20%;">JENIS & MEREK UNIT</th>
                                    <th class="py-3 text-white text-start" style="width: 22%;">MODEL / TIPE</th>
                                    <th class="py-3 text-white text-center" style="width: 15%;">TANGGAL MASUK</th>
                                    <th class="py-3 text-white text-center" style="width: 10%;">STATUS GARANSI</th>
                                    <th class="py-3 text-white text-center" style="width: 10%;">AKSI</th>
                                </tr>
                            </thead>
                            <tbody style="font-weight: 500;">
                                <tr>
                                    <td class="px-4 py-3 text-secondary text-center fw-bold">1</td>
                                    <td class="py-3">
                                        <div class="text-dark fw-bold">Budi Santoso</div>
                                        <small class="text-success"><i class="fab fa-whatsapp"></i> 081234567890</small>
                                    </td>
                                    <td class="py-3"><span class="badge bg-info text-dark">AC</span> Daikin</td>
                                    <td class="py-3 text-secondary">Inverter 1 PK (FTKC25)</td>
                                    <td class="py-3 text-center">25 Sep 2026</td>
                                    <td class="py-3 text-center"><span class="badge bg-success bg-opacity-15 text-success">Aktif (Ada Kartu)</span></td>
                                    <td class="py-3 text-center">
                                        <button class="btn btn-sm btn-outline-primary shadow-sm px-2 py-1"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-sm btn-outline-danger shadow-sm px-2 py-1"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-3 text-secondary text-center fw-bold">2</td>
                                    <td class="py-3">
                                        <div class="text-dark fw-bold">Siti Aminah</div>
                                        <small class="text-success"><i class="fab fa-whatsapp"></i> 085712345678</small>
                                    </td>
                                    <td class="py-3"><span class="badge bg-warning text-dark">Mesin Cuci</span> LG</td>
                                    <td class="py-3 text-secondary">2 Tabung 8 Kg (P800N)</td>
                                    <td class="py-3 text-center">26 Sep 2026</td>
                                    <td class="py-3 text-center"><span class="badge bg-danger bg-opacity-15 text-danger">Tidak Bergaransi</span></td>
                                    <td class="py-3 text-center">
                                        <button class="btn btn-sm btn-outline-primary shadow-sm px-2 py-1"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-sm btn-outline-danger shadow-sm px-2 py-1"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- ================= TAB 3: REGISTRASI SERVIS =================== -->
        <div class="tab-pane fade" id="registrasi" role="tabpanel" aria-labelledby="registrasi-tab">
            
            <!-- KARTU STATISTIK REGISTRASI -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card stat-card blue h-100 p-3 border-0" style="border-left: 4px solid #3b82f6 !important; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted text-uppercase mb-1" style="font-size: 0.75rem; font-weight: 600; letter-spacing: 0.5px;">Total Tiket Aktif</p>
                                <h4 class="mb-0 fw-bold text-dark">2 <span style="font-size: 0.9rem; font-weight: 500; color: #64748b;">Tiket</span></h4>
                            </div>
                            <div class="bg-primary bg-opacity-10 rounded p-2 text-primary" style="background-color: #e0f2fe; color: #0284c7;">
                                <i class="fas fa-tools fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card stat-card yellow h-100 p-3 border-0" style="border-left: 4px solid #f59e0b !important; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted text-uppercase mb-1" style="font-size: 0.75rem; font-weight: 600; letter-spacing: 0.5px;">Sedang Proses / Dicek</p>
                                <h4 class="mb-0 fw-bold text-dark">2 <span style="font-size: 0.9rem; font-weight: 500; color: #64748b;">Unit</span></h4>
                            </div>
                            <div class="bg-warning bg-opacity-10 rounded p-2 text-warning" style="background-color: #fef3c7; color: #d97706;">
                                <i class="fas fa-cog fa-spin fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card stat-card green h-100 p-3 border-0" style="border-left: 4px solid #10b981 !important; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted text-uppercase mb-1" style="font-size: 0.75rem; font-weight: 600; letter-spacing: 0.5px;">Servis Selesai</p>
                                <h4 class="mb-0 fw-bold text-dark">0 <span style="font-size: 0.9rem; font-weight: 500; color: #64748b;">Unit</span></h4>
                            </div>
                            <div class="bg-success bg-opacity-10 rounded p-2 text-success" style="background-color: #dcfce3; color: #15803d;">
                                <i class="fas fa-check-circle fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card crm-card overflow-hidden mb-4">
                <div class="card-header bg-white border-bottom pt-4 px-4 pb-3">
                    <h5 class="m-0 text-dark fw-bold">Daftar Servis Berjalan (Active Tickets)</h5>
                    <small class="text-muted">Pantau status pengerjaan, teknisi bertugas, dan kelengkapan unit pelanggan</small>
                </div>
                <!-- Bar Filter & Pencarian Registrasi -->
                <div class="card-body border-bottom bg-white py-3 px-4">
                   <form action="#" method="POST" autocomplete="off">
                        <div class="col-md-5 col-sm-12 mb-2 mb-md-0">
                            <div class="input-group">
                                <div class="input-group-prepend input-group-text bg-white border-right-0 border-end-0 text-muted" style="border-radius: 6px 0 0 6px; border-color: #cbd5e1;">
                                    <i class="fas fa-search"></i>
                                </div>
                                <input type="text" name="search" class="form-control crm-form-control border-left-0 border-start-0" placeholder="Cari Tiket, Pelanggan, Unit, atau Teknisi..." value="{{ request('search') }}" style="border-radius: 0 6px 6px 0;">
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-6 mb-2 mb-md-0">
                            <select name="status" class="form-control crm-form-control">
                                <option value="">-- Semua Status Servis --</option>
                                <option value="Proses Antrean">Proses Antrean</option>
                                <option value="Sedang Dicek">Sedang Dicek</option>
                                <option value="Proses Servis">Proses Servis</option>
                                <option value="Selesai">Selesai</option>
                            </select>
                        </div>

                        <div class="col-md-3 col-sm-6 d-flex">
                            <button type="submit" class="btn btn-dark w-100 shadow-sm mr-2 me-2" style="font-weight: 600; border-radius: 6px; background-color: #1e293b; border-color: #1e293b;">
                                <i class="fas fa-filter mr-1 me-1"></i> Filter
                            </button>
                        </div>
                    </form>
                </div>

                <div class="card-body p-4 bg-white">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered align-middle mb-0 super-thick-table">
                            <thead class="crm-table-header text-uppercase text-center fs-7">
                                <tr>
                                    <th class="py-3 text-white text-center" style="width: 5%;">NO</th>
                                    <th class="py-3 text-white text-center" style="width: 15%;">NO TIKET / SPK</th>
                                    <th class="py-3 text-white text-center" style="width: 15%;">PELANGGAN</th>
                                    <th class="py-3 text-white text-center" style="width: 18%;">UNIT & MEREK</th>
                                    <th class="py-3 text-white text-center" style="width: 18%;">KELUHAN</th>
                                    <th class="py-3 text-white text-center" style="width: 11%;">TEKNISI</th>
                                    <th class="py-3 text-white text-center" style="width: 12%;">STATUS SERVIS</th>
                                    <th class="py-3 text-white text-center" style="width: 8%;">AKSI</th>
                                </tr>
                            </thead>
                            <tbody style="font-weight: 500;">
                                <tr>
                                    <td class="px-3 py-3 text-secondary text-center">1</td>
                                    <td class="py-3 text-center text-primary fw-bold" style="font-weight: 700;">SRV-202609-001</td>
                                    <td class="py-3">
                                        <div class="text-dark" style="font-weight: 600;">Budi Santoso</div>
                                        <small class="text-muted">081234567890</small>
                                    </td>
                                    <td class="py-3 text-secondary">AC Daikin (Inverter 1 PK)</td>
                                    <td class="py-3 text-secondary small">AC Tidak Dingin & Indikator Kedip-Kedip</td>
                                    <td class="py-3 text-center text-dark fw-bold">Mas Anto</td>
                                    <td class="py-3 text-center">
                                        <span class="badge crm-badge badge-dicek">
                                            <i class="fas fa-search mr-1 me-1"></i> Sedang Dicek
                                        </span>
                                    </td>
                                    <td class="py-3 text-center">
                                        <div class="d-flex justify-content-center align-items-center gap-1">
                                            <button class="btn btn-sm btn-outline-primary shadow-sm px-2 py-1"><i class="fas fa-edit"></i></button>
                                            <button class="btn btn-sm btn-outline-success shadow-sm px-2 py-1"><i class="fas fa-print"></i></button>
                                            <button class="btn btn-sm btn-outline-danger shadow-sm px-2 py-1"><i class="fas fa-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-3 py-3 text-secondary text-center">2</td>
                                    <td class="py-3 text-center text-primary fw-bold" style="font-weight: 700;">SRV-202609-002</td>
                                    <td class="py-3">
                                        <div class="text-dark" style="font-weight: 600;">Siti Aminah</div>
                                        <small class="text-muted">089876543210</small>
                                    </td>
                                    <td class="py-3 text-secondary">Mesin Cuci LG (Front Loading)</td>
                                    <td class="py-3 text-secondary small">Air Tidak Mau Keluar Saat Pengeringan</td>
                                    <td class="py-3 text-center text-dark fw-bold">Pak Slamet</td>
                                    <td class="py-3 text-center">
                                        <span class="badge crm-badge badge-proses">
                                            <i class="fas fa-cog fa-spin mr-1 me-1"></i> Proses Servis
                                        </span>
                                    </td>
                                    <td class="py-3 text-center">
                                        <div class="d-flex justify-content-center align-items-center gap-1">
                                            <button class="btn btn-sm btn-outline-primary shadow-sm px-2 py-1"><i class="fas fa-edit"></i></button>
                                            <button class="btn btn-sm btn-outline-success shadow-sm px-2 py-1"><i class="fas fa-print"></i></button>
                                            <button class="btn btn-sm btn-outline-danger shadow-sm px-2 py-1"><i class="fas fa-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div> <!-- End Tab Content -->
</div>

<!-- Include Modal Tambah Registrasi & Konsumen -->
@include('registrasi.create')

<!-- Datalist Global untuk Auto-complete nama teknisi -->
<datalist id="datalist_teknisi">
    <option value="Mas Anto"></option>
    <option value="Pak Slamet"></option>
    <option value="Teknisi Freelance / Luar"></option>
</datalist>

<!-- Script JS (Bootstrap 4.6 Tab support requires this structure) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
@endsection