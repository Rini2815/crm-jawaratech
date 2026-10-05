@extends('layouts.app')

@section('content')
@php
    // DATA DUMMY (nanti diganti data dari database)
    $konsumen = [
        ['id' => 1, 'nama' => 'Budi Santoso',  'wa' => '081399887766', 'alamat' => 'Jl. Manggis No. 12, Madiun'],
        ['id' => 2, 'nama' => 'Siti Aminah',   'wa' => '081234567890', 'alamat' => 'Jl. Pahlawan No. 45, Madiun'],
        ['id' => 3, 'nama' => 'Hendra Wijaya', 'wa' => '085711223344', 'alamat' => 'Jl. Diponegoro No. 8, Madiun'],
        ['id' => 4, 'nama' => 'Ahmad Faisal',  'wa' => '081987654321', 'alamat' => 'Jl. Thamrin No. 21, Madiun'],
    ];

    $unit = [
        ['pemilik' => 'Budi Santoso',  'wa' => '081399887766', 'jenis' => 'AC',         'merek' => 'Daikin',   'model' => 'Inverter 1 PK (FTKC25)', 'masuk' => '28 Sep 2026', 'garansi' => true],
        ['pemilik' => 'Budi Santoso',  'wa' => '081399887766', 'jenis' => 'Mesin Cuci', 'merek' => 'LG',       'model' => '2 Tabung 8 Kg (P800N)',  'masuk' => '28 Sep 2025', 'garansi' => false],
        ['pemilik' => 'Siti Aminah',   'wa' => '081234567890', 'jenis' => 'AC',         'merek' => 'Sharp',    'model' => 'Standar 1 PK',           'masuk' => '4 Jul 2026',  'garansi' => true],
        ['pemilik' => 'Hendra Wijaya', 'wa' => '085711223344', 'jenis' => 'Dispenser',  'merek' => 'Miyako',   'model' => 'Galon Bawah',            'masuk' => '9 Apr 2026',  'garansi' => false],
        ['pemilik' => 'Ahmad Faisal',  'wa' => '081987654321', 'jenis' => 'Dispenser',  'merek' => 'Polytron', 'model' => 'Hyda',                   'masuk' => '1 Okt 2026',  'garansi' => true],
    ];

    $tiket = [
        ['no' => 'SRV-202610-001', 'pelanggan' => 'Budi Santoso',  'wa' => '081399887766', 'unit' => 'Mesin Cuci LG (2 Tabung 8 Kg)', 'keluhan' => 'Air Tidak Mau Keluar Saat Pengeringan', 'teknisi' => 'Pak Slamet', 'status' => 'Proses Servis'],
        ['no' => 'SRV-202610-002', 'pelanggan' => 'Hendra Wijaya', 'wa' => '085711223344', 'unit' => 'Dispenser Miyako (Galon Bawah)',  'keluhan' => 'Air Panas Kurang Panas',               'teknisi' => 'Mas Anto',   'status' => 'Sedang Dicek'],
    ];

    // Angka kartu dihitung otomatis dari data di atas
    $totalKonsumen   = count($konsumen);
    $totalUnit       = count($unit);
    $unitGaransi     = collect($unit)->where('garansi', true)->count();
    $unitAC          = collect($unit)->where('jenis', 'AC')->count();
    $unitDispenser   = collect($unit)->whereIn('jenis', ['Dispenser', 'Water Heater'])->count();
    $unitMesinCuci   = collect($unit)->where('jenis', 'Mesin Cuci')->count();
    $tiketAktif      = count($tiket);
    $tiketProses     = collect($tiket)->whereIn('status', ['Sedang Dicek', 'Proses Servis'])->count();
    $tiketSelesai    = collect($tiket)->where('status', 'Selesai')->count();
@endphp

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
.stat-card.blue { border-left: 4px solid #3b82f6 !important; }
.stat-card.yellow { border-left: 4px solid #f59e0b !important; }
.stat-card.green { border-left: 4px solid #10b981 !important; }
.stat-card.purple { border-left: 4px solid #8b5cf6 !important; }
.stat-card.cyan { border-left: 4px solid #0891b2 !important; }

.crm-table-header {
    background-color: #1e293b; 
    color: #ffffff;
    font-weight: 600;
    letter-spacing: 0.5px;
}
/* Semua header tabel rata tengah */
.crm-table-header th {
    text-align: center !important;
    vertical-align: middle !important;
}
/* Tombol aksi sejajar horizontal (tidak turun ke bawah) */
.aksi-wrap {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 6px;
    flex-wrap: nowrap;
    white-space: nowrap;
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

/* Lebar modal */
.modal-custom-size {
    max-width: 800px !important;
    width: 90%;
}

/* CUSTOM STYLE UNTUK TABS DI DALAM BANNER HITAM */
.custom-pills {
    gap: 8px;
}
.custom-pills .nav-link {
    background-color: transparent;
    border: 1px solid #334155;
    color: #cbd5e1;
    font-weight: 600;
    font-size: 0.85rem;
    padding: 8px 16px;
    border-radius: 6px;
    transition: all 0.3s ease;
}
.custom-pills .nav-link:hover {
    background-color: #1e293b;
    color: #ffffff;
}
.custom-pills .nav-link.active {
    background-color: #2563eb !important;
    border-color: #2563eb !important;
    color: #ffffff !important;
}
</style>

<div class="container-fluid px-4 pt-3 pb-4 crm-wrapper" style="background: linear-gradient(135deg, #eef1f3 0%, #eef1f3 100%); min-height: 100vh;">

    <!-- ================================================================= -->
    <!-- BAGIAN 1: BANNER UTAMA DENGAN TOMBOL TAB                          -->
    <!-- ================================================================= -->
    <div class="card rounded-3 mb-4 text-white shadow-sm overflow-hidden" style="background: #0f172a; border: 1px solid #1e293b;">
        <div class="card-body p-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h1 class="h4 mb-1 text-white fw-bold d-flex align-items-center gap-2">
                    <i class="fas fa-address-book text-info"></i> Registrasi Konsumen & Unit Servis
                </h1>
                <p class="text-light opacity-75 mb-0" style="font-weight: 400; font-size: 0.85rem;">
                    Kelola data konsumen, unit perangkat, dan registrasi servis dalam satu halaman
                </p>
            </div>
            
            <!-- 3 TOMBOL TAB -->
            <ul class="nav nav-pills custom-pills mb-0" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-konsumen-tab" data-toggle="pill" data-target="#konsumen" type="button" role="tab" aria-controls="konsumen" aria-selected="true">
                        <i class="fas fa-users mr-1"></i> Data Konsumen
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-unit-tab" data-toggle="pill" data-target="#unit" type="button" role="tab" aria-controls="unit" aria-selected="false">
                        <i class="fas fa-tools mr-1"></i> Data Unit Servis
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-registrasi-tab" data-toggle="pill" data-target="#registrasi" type="button" role="tab" aria-controls="registrasi" aria-selected="false">
                        <i class="fas fa-file-alt mr-1"></i> Registrasi Servis
                    </button>
                </li>
            </ul>
        </div>
    </div>

    <!-- ================================================================= -->
    <!-- ISI TAB KONTEN                                                    -->
    <!-- ================================================================= -->
    <div class="tab-content" id="myTabContent">
        
        <!-- ================= TAB 1: DATA KONSUMEN =================== -->
        <div class="tab-pane fade show active" id="konsumen" role="tabpanel" aria-labelledby="pills-konsumen-tab">
            
            <!-- KARTU STATISTIK DATA KONSUMEN -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card stat-card blue h-100 p-3 border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted text-uppercase mb-1" style="font-size: 0.75rem; font-weight: 600;">Total Konsumen</p>
                                <h4 class="mb-0 fw-bold text-dark">{{ $totalKonsumen }} <span style="font-size: 0.9rem; font-weight: 500; color: #64748b;">Orang</span></h4>
                            </div>
                            <div class="bg-primary bg-opacity-10 rounded p-2 text-primary" style="background-color: #e0f2fe; color: #0284c7;">
                                <i class="fas fa-user-friends fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card stat-card blue h-100 p-3 border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted text-uppercase mb-1" style="font-size: 0.75rem; font-weight: 600;">Total Unit Terdaftar</p>
                                <h4 class="mb-0 fw-bold text-dark">{{ $totalUnit }} <span style="font-size: 0.9rem; font-weight: 500; color: #64748b;">Unit</span></h4>
                            </div>
                            <div class="bg-primary bg-opacity-10 rounded p-2 text-primary" style="background-color: #e0f2fe; color: #0284c7;">
                                <i class="fas fa-box fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card stat-card green h-100 p-3 border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted text-uppercase mb-1" style="font-size: 0.75rem; font-weight: 600;">Unit Bergaransi</p>
                                <h4 class="mb-0 fw-bold text-dark">{{ $unitGaransi }} <span style="font-size: 0.9rem; font-weight: 500; color: #64748b;">Unit</span></h4>
                            </div>
                            <div class="bg-success bg-opacity-10 rounded p-2 text-success" style="background-color: #dcfce3; color: #15803d;">
                                <i class="fas fa-shield-alt fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card crm-card overflow-hidden mb-4">
                <div class="card-header bg-white border-bottom pt-4 px-4 pb-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <h5 class="m-0 text-dark fw-bold">Daftar Konsumen Jawaratech</h5>
                        <small class="text-muted">Buku kontak dan master informasi pelanggan sistem CRM Jawaratech</small>
                    </div>
                    <!-- Tombol Tambah Konsumen: membuka modal -->
                    <button type="button" class="btn btn-primary px-3 py-2 fw-semibold rounded-pill shadow-sm text-sm" data-toggle="modal" data-target="#modalTambahKonsumen">
                        <i class="fas fa-user-plus mr-1"></i> Tambah Konsumen
                    </button>
                </div>
                <div class="card-body p-4 bg-white">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered align-middle mb-0 super-thick-table">
                            <thead class="crm-table-header text-uppercase text-center fs-7">
                                <tr>
                                    <th class="py-3 text-white text-center" style="width: 6%;">NO</th>
                                    <th class="py-3 text-white text-center" style="width: 22%;">NAMA KONSUMEN</th>
                                    <th class="py-3 text-white text-center" style="width: 22%;">NOMOR WHATSAPP</th>
                                    <th class="py-3 text-white text-center" style="width: 25%;">ALAMAT DOMISILI</th>
                                    <th class="py-3 text-white text-center" style="width: 12%;">JUMLAH UNIT</th>
                                    <th class="py-3 text-white text-center" style="width: 13%; min-width: 100px;">AKSI</th>
                                </tr>
                            </thead>
                            <tbody style="font-weight: 500;">
                                @foreach($konsumen as $k)
                                <tr>
                                    <td class="px-4 py-3 text-secondary text-center fw-bold">{{ $loop->iteration }}</td>
                                    <td class="py-3 text-dark fw-bold">{{ $k['nama'] }}</td>
                                    <td class="py-3 text-success fw-semibold"><i class="fab fa-whatsapp"></i> {{ $k['wa'] }}</td>
                                    <td class="py-3 text-secondary">{{ $k['alamat'] }}</td>
                                    <td class="py-3 text-center"><span class="badge bg-primary text-white px-2 py-1">{{ collect($unit)->where('pemilik', $k['nama'])->count() }} Unit</span></td>
                                    <td class="py-3 text-center">
                                        <div class="aksi-wrap">
                                            <button type="button" class="btn btn-sm btn-outline-primary shadow-sm px-2 py-1" title="Ubah data" data-toggle="modal" data-target="#modalEditKonsumen{{ $k['id'] }}"><i class="fas fa-edit"></i></button>
                                            <button type="button" class="btn btn-sm btn-outline-danger shadow-sm px-2 py-1" title="Hapus" onclick="return confirm('Yakin ingin menghapus konsumen ini?')"><i class="fas fa-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- ================= TAB 2: DATA UNIT SERVIS =================== -->
        <div class="tab-pane fade" id="unit" role="tabpanel" aria-labelledby="pills-unit-tab">
            
            <!-- KARTU STATISTIK DATA UNIT -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card stat-card blue h-100 p-3 border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted text-uppercase mb-1" style="font-size: 0.75rem; font-weight: 600;">Total Unit Terdaftar</p>
                                <h4 class="mb-0 fw-bold text-dark">{{ $totalUnit }} <span style="font-size: 0.9rem; font-weight: 500; color: #64748b;">Perangkat</span></h4>
                            </div>
                            <div class="bg-primary bg-opacity-10 rounded p-2 text-primary" style="background-color: #e0f2fe; color: #0284c7;">
                                <i class="fas fa-boxes fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stat-card purple h-100 p-3 border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted text-uppercase mb-1" style="font-size: 0.75rem; font-weight: 600;">Unit AC</p>
                                <h4 class="mb-0 fw-bold text-dark">{{ $unitAC }} <span style="font-size: 0.9rem; font-weight: 500; color: #64748b;">Unit</span></h4>
                            </div>
                            <div class="rounded p-2" style="background-color: #f3e8ff; color: #7e22ce;">
                                <i class="fas fa-wind fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stat-card cyan h-100 p-3 border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted text-uppercase mb-1" style="font-size: 0.75rem; font-weight: 600;">Dispenser / WH</p>
                                <h4 class="mb-0 fw-bold text-dark">{{ $unitDispenser }} <span style="font-size: 0.9rem; font-weight: 500; color: #64748b;">Unit</span></h4>
                            </div>
                            <div class="rounded p-2" style="background-color: #cffafe; color: #0891b2;">
                                <i class="fas fa-faucet fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stat-card green h-100 p-3 border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted text-uppercase mb-1" style="font-size: 0.75rem; font-weight: 600;">Unit Mesin Cuci</p>
                                <h4 class="mb-0 fw-bold text-dark">{{ $unitMesinCuci }} <span style="font-size: 0.9rem; font-weight: 500; color: #64748b;">Unit</span></h4>
                            </div>
                            <div class="bg-success bg-opacity-10 rounded p-2 text-success" style="background-color: #dcfce3; color: #15803d;">
                                <i class="fas fa-tshirt fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card crm-card overflow-hidden mb-4">
                <div class="card-header bg-white border-bottom pt-4 px-4 pb-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <h5 class="m-0 text-dark fw-bold">Daftar Master Unit Pelanggan</h5>
                        <small class="text-muted">Kelola spesifikasi teknis unit pelanggan, tanggal masuk servis, dan status garansi</small>
                    </div>
                    <!-- Tombol Tambah Unit: warna biru, membuka modal -->
                    <button type="button" class="btn btn-primary px-3 py-2 fw-semibold rounded-pill shadow-sm text-sm" data-toggle="modal" data-target="#modalTambahUnit">
                        <i class="fas fa-plus-circle mr-1"></i> Tambah Unit Servis
                    </button>
                </div>
                <div class="card-body p-4 bg-white">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered align-middle mb-0 super-thick-table">
                            <thead class="crm-table-header text-uppercase text-center fs-7">
                                <tr>
                                    <th class="py-3 text-white text-center" style="width: 5%;">NO</th>
                                    <th class="py-3 text-white text-center" style="width: 20%;">PEMILIK UNIT</th>
                                    <th class="py-3 text-white text-center" style="width: 18%;">JENIS & MEREK UNIT</th>
                                    <th class="py-3 text-white text-center" style="width: 20%;">MODEL / TIPE</th>
                                    <th class="py-3 text-white text-center" style="width: 13%;">TANGGAL MASUK</th>
                                    <th class="py-3 text-white text-center" style="width: 12%;">STATUS GARANSI</th>
                                    <th class="py-3 text-white text-center" style="width: 12%; min-width: 100px;">AKSI</th>
                                </tr>
                            </thead>
                            <tbody style="font-weight: 500;">
                                @foreach($unit as $u)
                                <tr>
                                    <td class="px-4 py-3 text-secondary text-center fw-bold">{{ $loop->iteration }}</td>
                                    <td class="py-3">
                                        <div class="text-dark fw-bold">{{ $u['pemilik'] }}</div>
                                        <small class="text-success"><i class="fab fa-whatsapp"></i> {{ $u['wa'] }}</small>
                                    </td>
                                    <td class="py-3">
                                        @if($u['jenis'] == 'AC')
                                            <span class="badge bg-info text-dark">AC</span>
                                        @elseif($u['jenis'] == 'Mesin Cuci')
                                            <span class="badge bg-warning text-dark">Mesin Cuci</span>
                                        @else
                                            <span class="badge" style="background-color: #cffafe; color: #0e7490;">{{ $u['jenis'] }}</span>
                                        @endif
                                        {{ $u['merek'] }}
                                    </td>
                                    <td class="py-3 text-secondary">{{ $u['model'] }}</td>
                                    <td class="py-3 text-center">{{ $u['masuk'] }}</td>
                                    <td class="py-3 text-center">
                                        @if($u['garansi'])
                                            <span class="badge" style="background-color: #dcfce3; color: #15803d; border: 1px solid #bbf7d0;">Aktif (Ada Kartu)</span>
                                        @else
                                            <span class="badge" style="background-color: #fee2e2; color: #b91c1c; border: 1px solid #fecaca;">Tidak Bergaransi</span>
                                        @endif
                                    </td>
                                    <td class="py-3 text-center">
                                        <div class="aksi-wrap">
                                            <button type="button" class="btn btn-sm btn-outline-primary shadow-sm px-2 py-1" title="Ubah data" data-toggle="modal" data-target="#modalEditUnit{{ $loop->iteration }}"><i class="fas fa-edit"></i></button>
                                            <button type="button" class="btn btn-sm btn-outline-danger shadow-sm px-2 py-1" title="Hapus" onclick="return confirm('Yakin ingin menghapus unit ini?')"><i class="fas fa-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- ================= TAB 3: REGISTRASI SERVIS =================== -->
        <div class="tab-pane fade" id="registrasi" role="tabpanel" aria-labelledby="pills-registrasi-tab">
            
            <!-- KARTU STATISTIK REGISTRASI -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card stat-card blue h-100 p-3 border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted text-uppercase mb-1" style="font-size: 0.75rem; font-weight: 600;">Total Tiket Aktif</p>
                                <h4 class="mb-0 fw-bold text-dark">{{ $tiketAktif }} <span style="font-size: 0.9rem; font-weight: 500; color: #64748b;">Tiket</span></h4>
                            </div>
                            <div class="bg-primary bg-opacity-10 rounded p-2 text-primary" style="background-color: #e0f2fe; color: #0284c7;">
                                <i class="fas fa-tools fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card stat-card yellow h-100 p-3 border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted text-uppercase mb-1" style="font-size: 0.75rem; font-weight: 600;">Sedang Proses / Dicek</p>
                                <h4 class="mb-0 fw-bold text-dark">{{ $tiketProses }} <span style="font-size: 0.9rem; font-weight: 500; color: #64748b;">Unit</span></h4>
                            </div>
                            <div class="bg-warning bg-opacity-10 rounded p-2 text-warning" style="background-color: #fef3c7; color: #d97706;">
                                <i class="fas fa-cog fa-spin fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card stat-card green h-100 p-3 border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted text-uppercase mb-1" style="font-size: 0.75rem; font-weight: 600;">Servis Selesai</p>
                                <h4 class="mb-0 fw-bold text-dark">{{ $tiketSelesai }} <span style="font-size: 0.9rem; font-weight: 500; color: #64748b;">Unit</span></h4>
                            </div>
                            <div class="bg-success bg-opacity-10 rounded p-2 text-success" style="background-color: #dcfce3; color: #15803d;">
                                <i class="fas fa-check-circle fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card crm-card overflow-hidden mb-4">
                <div class="card-header bg-white border-bottom pt-4 px-4 pb-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <h5 class="m-0 text-dark fw-bold">Daftar Servis Berjalan (Active Tickets)</h5>
                        <small class="text-muted">Pantau status pengerjaan, teknisi bertugas, dan kelengkapan unit pelanggan</small>
                    </div>
                    <button type="button" class="btn btn-primary px-3 py-2 fw-semibold rounded-pill shadow-sm text-sm" data-toggle="modal" data-target="#modalTambahRegistrasi">
                        <i class="fas fa-file-signature mr-1"></i> Tambah Registrasi Baru
                    </button>
                </div>
                <!-- Bar Filter & Pencarian Registrasi -->
                <div class="card-body border-bottom bg-white py-3 px-4">
                    <form action="{{ route('data-konsumen') }}" method="GET" class="row g-2 align-items-center">
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
                                    <th class="py-3 text-white text-center" style="width: 14%;">NO TIKET / SPK</th>
                                    <th class="py-3 text-white text-center" style="width: 14%;">PELANGGAN</th>
                                    <th class="py-3 text-white text-center" style="width: 17%;">UNIT & MEREK</th>
                                    <th class="py-3 text-white text-center" style="width: 17%;">KELUHAN</th>
                                    <th class="py-3 text-white text-center" style="width: 10%;">TEKNISI</th>
                                    <th class="py-3 text-white text-center" style="width: 11%;">STATUS SERVIS</th>
                                    <th class="py-3 text-white text-center" style="width: 12%; min-width: 130px;">AKSI</th>
                                </tr>
                            </thead>
                            <tbody style="font-weight: 500;">
                                @foreach($tiket as $t)
                                <tr>
                                    <td class="px-3 py-3 text-secondary text-center">{{ $loop->iteration }}</td>
                                    <td class="py-3 text-center text-primary fw-bold" style="font-weight: 700;">{{ $t['no'] }}</td>
                                    <td class="py-3">
                                        <div class="text-dark" style="font-weight: 600;">{{ $t['pelanggan'] }}</div>
                                        <small class="text-muted">{{ $t['wa'] }}</small>
                                    </td>
                                    <td class="py-3 text-secondary">{{ $t['unit'] }}</td>
                                    <td class="py-3 text-secondary small">{{ $t['keluhan'] }}</td>
                                    <td class="py-3 text-center text-dark fw-bold">{{ $t['teknisi'] }}</td>
                                    <td class="py-3 text-center">
                                        @if($t['status'] == 'Sedang Dicek')
                                            <span class="badge crm-badge badge-dicek">
                                                <i class="fas fa-search mr-1 me-1"></i> Sedang Dicek
                                            </span>
                                        @else
                                            <span class="badge crm-badge badge-proses">
                                                <i class="fas fa-cog fa-spin mr-1 me-1"></i> {{ $t['status'] }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3 text-center">
                                        <div class="aksi-wrap">
                                            <button type="button" class="btn btn-sm btn-outline-primary shadow-sm px-2 py-1" title="Ubah data" data-toggle="modal" data-target="#modalEditServis{{ $loop->iteration }}"><i class="fas fa-edit"></i></button>
                                            <button type="button" class="btn btn-sm btn-outline-success shadow-sm px-2 py-1" title="Cetak"><i class="fas fa-print"></i></button>
                                            <button type="button" class="btn btn-sm btn-outline-danger shadow-sm px-2 py-1" title="Hapus" onclick="return confirm('Yakin ingin menghapus registrasi ini?')"><i class="fas fa-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div> <!-- End Tab Content -->
</div>

{{-- ================================================================= --}}
{{-- MODAL (diletakkan di luar tab-content agar tidak tertutup layar gelap) --}}
{{-- ================================================================= --}}

<!-- Modal Tambah Konsumen -->
<div class="modal fade crm-wrapper" id="modalTambahKonsumen" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-custom-size modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 10px; border: none; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.2);">
            <div class="modal-header py-3 px-4 text-white" style="background-color: #1e293b; border-bottom: 1px solid #1e293b; border-top-left-radius: 10px; border-top-right-radius: 10px;">
                <h5 class="modal-title text-white mb-0" style="font-weight: 700; font-size: 1.15rem;"><i class="fas fa-user-plus mr-2"></i>Tambah Data Konsumen</h5>
                <button type="button" data-dismiss="modal" aria-label="Close" style="color: #ffffff; opacity: 1; background: transparent; border: none; font-size: 1.5rem; padding: 0; line-height: 1;"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="#" method="POST" autocomplete="off">
                @csrf
                <div class="modal-body p-4 bg-white text-dark">
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="text-dark" style="font-size: 0.875rem; font-weight: 600;">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control py-2" placeholder="Masukkan nama lengkap konsumen" required style="border-radius: 6px;">
                        </div>
                        <div class="col-md-6">
                            <label class="text-dark" style="font-size: 0.875rem; font-weight: 600;">Nomor WhatsApp <span class="text-danger">*</span></label>
                            <input type="text" name="no_wa" class="form-control py-2" placeholder="contoh: 081234567890" required style="border-radius: 6px;">
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="text-dark" style="font-size: 0.875rem; font-weight: 600;">Alamat Domisili <span class="text-danger">*</span></label>
                        <textarea name="alamat" class="form-control" rows="3" placeholder="contoh: Jl. Manggis No. 12, Madiun" required style="border-radius: 6px;"></textarea>
                    </div>
                </div>
                <div class="modal-footer px-4 py-3" style="border-top: 1px solid #e2e8f0; background-color: #f8fafc; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
                    <button type="button" class="btn btn-light px-4 py-2" data-dismiss="modal" style="font-weight: 600; border-radius: 6px; border: 1px solid #cbd5e1;">Batal</button>
                    <button type="submit" class="btn btn-primary px-4 py-2" style="font-weight: 600; border-radius: 6px; background-color: #2563eb; border-color: #2563eb;"><i class="fas fa-save mr-1"></i> Simpan Konsumen</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Konsumen (satu per data) -->
@foreach($konsumen as $k)
<div class="modal fade crm-wrapper" id="modalEditKonsumen{{ $k['id'] }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-custom-size modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 10px; border: none; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.2);">
            <div class="modal-header py-3 px-4 text-white" style="background-color: #1e293b; border-bottom: 1px solid #1e293b; border-top-left-radius: 10px; border-top-right-radius: 10px;">
                <h5 class="modal-title text-white mb-0" style="font-weight: 700; font-size: 1.15rem;"><i class="fas fa-edit mr-2"></i>Edit Data Konsumen</h5>
                <button type="button" data-dismiss="modal" aria-label="Close" style="color: #ffffff; opacity: 1; background: transparent; border: none; font-size: 1.5rem; padding: 0; line-height: 1;"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="#" method="POST" autocomplete="off">
                @csrf
                @method('PUT')
                <div class="modal-body p-4 bg-white text-dark">
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="text-dark" style="font-size: 0.875rem; font-weight: 600;">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control py-2" value="{{ $k['nama'] }}" required style="border-radius: 6px;">
                        </div>
                        <div class="col-md-6">
                            <label class="text-dark" style="font-size: 0.875rem; font-weight: 600;">Nomor WhatsApp</label>
                            <input type="text" name="no_wa" class="form-control py-2" value="{{ $k['wa'] }}" required style="border-radius: 6px;">
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="text-dark" style="font-size: 0.875rem; font-weight: 600;">Alamat Domisili</label>
                        <textarea name="alamat" class="form-control" rows="3" required style="border-radius: 6px;">{{ $k['alamat'] }}</textarea>
                    </div>
                </div>
                <div class="modal-footer px-4 py-3" style="border-top: 1px solid #e2e8f0; background-color: #f8fafc; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
                    <button type="button" class="btn btn-light px-4 py-2" data-dismiss="modal" style="font-weight: 600; border-radius: 6px; border: 1px solid #cbd5e1;">Batal</button>
                    <button type="submit" class="btn btn-primary px-4 py-2" style="font-weight: 600; border-radius: 6px; background-color: #2563eb; border-color: #2563eb;"><i class="fas fa-save mr-1"></i> Perbarui Konsumen</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<!-- Modal Tambah Unit -->
<div class="modal fade crm-wrapper" id="modalTambahUnit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-custom-size modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 10px; border: none; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.2);">
            <div class="modal-header py-3 px-4 text-white" style="background-color: #1e293b; border-bottom: 1px solid #1e293b; border-top-left-radius: 10px; border-top-right-radius: 10px;">
                <h5 class="modal-title text-white mb-0" style="font-weight: 700; font-size: 1.15rem;"><i class="fas fa-plus-circle mr-2"></i>Tambah Data Unit Servis</h5>
                <button type="button" data-dismiss="modal" aria-label="Close" style="color: #ffffff; opacity: 1; background: transparent; border: none; font-size: 1.5rem; padding: 0; line-height: 1;"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="#" method="POST" autocomplete="off">
                @csrf
                <div class="modal-body p-4 bg-white text-dark">
                    <div class="mb-3">
                        <label class="text-dark" style="font-size: 0.875rem; font-weight: 600;">Pilih Konsumen Pemilik</label>
                        <select name="konsumen_id" class="form-control py-2" required style="border-radius: 6px;">
                            <option value="" disabled selected>Pilih Konsumen...</option>
                            @foreach($konsumen as $k)
                            <option value="{{ $k['id'] }}">{{ $k['nama'] }} - {{ $k['wa'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="text-dark" style="font-size: 0.875rem; font-weight: 600;">Jenis Unit</label>
                            <select name="jenis_unit" class="form-control py-2" required style="border-radius: 6px;">
                                <option value="" disabled selected>Pilih...</option>
                                <option value="AC">AC</option>
                                <option value="Mesin Cuci">Mesin Cuci</option>
                                <option value="Dispenser">Dispenser</option>
                                <option value="Water Heater">Water Heater</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="text-dark" style="font-size: 0.875rem; font-weight: 600;">Merek Unit</label>
                            <input type="text" name="merek" class="form-control py-2" placeholder="Contoh: Daikin, LG, Sharp" required style="border-radius: 6px;">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="text-dark" style="font-size: 0.875rem; font-weight: 600;">Model / Tipe Rinci</label>
                        <input type="text" name="tipe" class="form-control py-2" placeholder="Contoh: Inverter 1 PK / 2 Tabung" required style="border-radius: 6px;">
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="text-dark" style="font-size: 0.875rem; font-weight: 600;">Tanggal Masuk Servis</label>
                            <input type="date" name="tgl_masuk" class="form-control py-2" style="border-radius: 6px;">
                        </div>
                        <div class="col-md-6">
                            <label class="text-dark" style="font-size: 0.875rem; font-weight: 600;">Status Garansi</label>
                            <select name="status_garansi" class="form-control py-2" required style="border-radius: 6px;">
                                <option value="Aktif (Ada Kartu)">Aktif (Ada Kartu)</option>
                                <option value="Tidak Bergaransi">Tidak Bergaransi</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer px-4 py-3" style="border-top: 1px solid #e2e8f0; background-color: #f8fafc; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
                    <button type="button" class="btn btn-light px-4 py-2" data-dismiss="modal" style="font-weight: 600; border-radius: 6px; border: 1px solid #cbd5e1;">Batal</button>
                    <button type="submit" class="btn btn-primary px-4 py-2" style="font-weight: 600; border-radius: 6px; background-color: #2563eb; border-color: #2563eb;"><i class="fas fa-save mr-1"></i> Simpan Unit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Unit (satu per data) -->
@foreach($unit as $u)
<div class="modal fade crm-wrapper" id="modalEditUnit{{ $loop->iteration }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-custom-size modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 10px; border: none; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.2);">
            <div class="modal-header py-3 px-4 text-white" style="background-color: #1e293b; border-bottom: 1px solid #1e293b; border-top-left-radius: 10px; border-top-right-radius: 10px;">
                <h5 class="modal-title text-white mb-0" style="font-weight: 700; font-size: 1.15rem;"><i class="fas fa-edit mr-2"></i>Edit Data Unit Servis</h5>
                <button type="button" data-dismiss="modal" aria-label="Close" style="color: #ffffff; opacity: 1; background: transparent; border: none; font-size: 1.5rem; padding: 0; line-height: 1;"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="#" method="POST" autocomplete="off">
                @csrf
                @method('PUT')
                <div class="modal-body p-4 bg-white text-dark">
                    <div class="mb-3">
                        <label class="text-dark" style="font-size: 0.875rem; font-weight: 600;">Pemilik Unit</label>
                        <input type="text" class="form-control py-2" value="{{ $u['pemilik'] }}" readonly style="border-radius: 6px; background-color: #f1f5f9; cursor: not-allowed;">
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="text-dark" style="font-size: 0.875rem; font-weight: 600;">Jenis Unit</label>
                            <select name="jenis_unit" class="form-control py-2" style="border-radius: 6px;">
                                <option value="AC" {{ $u['jenis'] == 'AC' ? 'selected' : '' }}>AC</option>
                                <option value="Mesin Cuci" {{ $u['jenis'] == 'Mesin Cuci' ? 'selected' : '' }}>Mesin Cuci</option>
                                <option value="Dispenser" {{ $u['jenis'] == 'Dispenser' ? 'selected' : '' }}>Dispenser</option>
                                <option value="Water Heater" {{ $u['jenis'] == 'Water Heater' ? 'selected' : '' }}>Water Heater</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="text-dark" style="font-size: 0.875rem; font-weight: 600;">Merek Unit</label>
                            <input type="text" name="merek" class="form-control py-2" value="{{ $u['merek'] }}" required style="border-radius: 6px;">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="text-dark" style="font-size: 0.875rem; font-weight: 600;">Model / Tipe Rinci</label>
                        <input type="text" name="tipe" class="form-control py-2" value="{{ $u['model'] }}" required style="border-radius: 6px;">
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="text-dark" style="font-size: 0.875rem; font-weight: 600;">Tanggal Masuk Servis</label>
                            <input type="text" name="tgl_masuk" class="form-control py-2" value="{{ $u['masuk'] }}" style="border-radius: 6px;">
                        </div>
                        <div class="col-md-6">
                            <label class="text-dark" style="font-size: 0.875rem; font-weight: 600;">Status Garansi</label>
                            <select name="status_garansi" class="form-control py-2" style="border-radius: 6px;">
                                <option value="Aktif (Ada Kartu)" {{ $u['garansi'] ? 'selected' : '' }}>Aktif (Ada Kartu)</option>
                                <option value="Tidak Bergaransi" {{ !$u['garansi'] ? 'selected' : '' }}>Tidak Bergaransi</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer px-4 py-3" style="border-top: 1px solid #e2e8f0; background-color: #f8fafc; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
                    <button type="button" class="btn btn-light px-4 py-2" data-dismiss="modal" style="font-weight: 600; border-radius: 6px; border: 1px solid #cbd5e1;">Batal</button>
                    <button type="submit" class="btn btn-primary px-4 py-2" style="font-weight: 600; border-radius: 6px; background-color: #2563eb; border-color: #2563eb;"><i class="fas fa-save mr-1"></i> Perbarui Unit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<!-- Modal Edit Servis / Tiket (satu per data) -->
@foreach($tiket as $t)
<div class="modal fade crm-wrapper" id="modalEditServis{{ $loop->iteration }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-custom-size modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 10px; border: none; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.2);">
            <div class="modal-header py-3 px-4 text-white" style="background-color: #1e293b; border-bottom: 1px solid #1e293b; border-top-left-radius: 10px; border-top-right-radius: 10px;">
                <h5 class="modal-title text-white mb-0" style="font-weight: 700; font-size: 1.15rem;"><i class="fas fa-edit mr-2"></i>Edit Tiket Servis</h5>
                <button type="button" data-dismiss="modal" aria-label="Close" style="color: #ffffff; opacity: 1; background: transparent; border: none; font-size: 1.5rem; padding: 0; line-height: 1;"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="#" method="POST" autocomplete="off">
                @csrf
                @method('PUT')
                <div class="modal-body p-4 bg-white text-dark">
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="text-dark" style="font-size: 0.875rem; font-weight: 600;">No. Tiket / SPK</label>
                            <input type="text" class="form-control py-2" value="{{ $t['no'] }}" readonly style="border-radius: 6px; background-color: #f1f5f9; cursor: not-allowed;">
                        </div>
                        <div class="col-md-6">
                            <label class="text-dark" style="font-size: 0.875rem; font-weight: 600;">Pelanggan</label>
                            <input type="text" class="form-control py-2" value="{{ $t['pelanggan'] }} ({{ $t['wa'] }})" readonly style="border-radius: 6px; background-color: #f1f5f9; cursor: not-allowed;">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="text-dark" style="font-size: 0.875rem; font-weight: 600;">Unit & Merek</label>
                        <input type="text" class="form-control py-2" value="{{ $t['unit'] }}" readonly style="border-radius: 6px; background-color: #f1f5f9; cursor: not-allowed;">
                    </div>
                    <div class="mb-3">
                        <label class="text-dark" style="font-size: 0.875rem; font-weight: 600;">Keluhan / Kendala Utama</label>
                        <textarea name="keluhan" class="form-control" rows="2" required style="border-radius: 6px;">{{ $t['keluhan'] }}</textarea>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="text-dark" style="font-size: 0.875rem; font-weight: 600;">Nama Teknisi</label>
                            <input type="text" name="teknisi" class="form-control py-2" value="{{ $t['teknisi'] }}" list="datalist_teknisi" required style="border-radius: 6px;">
                        </div>
                        <div class="col-md-6">
                            <label class="text-dark" style="font-size: 0.875rem; font-weight: 600;">Status Servis</label>
                            <select name="status" class="form-control py-2" style="border-radius: 6px;">
                                <option value="Proses Antrean" {{ $t['status'] == 'Proses Antrean' ? 'selected' : '' }}>Proses Antrean</option>
                                <option value="Sedang Dicek" {{ $t['status'] == 'Sedang Dicek' ? 'selected' : '' }}>Sedang Dicek</option>
                                <option value="Proses Servis" {{ $t['status'] == 'Proses Servis' ? 'selected' : '' }}>Proses Servis</option>
                                <option value="Menunggu Sparepart" {{ $t['status'] == 'Menunggu Sparepart' ? 'selected' : '' }}>Menunggu Sparepart</option>
                                <option value="Selesai" {{ $t['status'] == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer px-4 py-3" style="border-top: 1px solid #e2e8f0; background-color: #f8fafc; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
                    <button type="button" class="btn btn-light px-4 py-2" data-dismiss="modal" style="font-weight: 600; border-radius: 6px; border: 1px solid #cbd5e1;">Batal</button>
                    <button type="submit" class="btn btn-primary px-4 py-2" style="font-weight: 600; border-radius: 6px; background-color: #2563eb; border-color: #2563eb;"><i class="fas fa-save mr-1"></i> Perbarui Tiket</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<!-- Include Modal Tambah Registrasi -->
@include('registrasi.create')

<!-- Datalist Global untuk Auto-complete nama teknisi -->
<datalist id="datalist_teknisi">
    <option value="Mas Anto"></option>
    <option value="Pak Slamet"></option>
    <option value="Teknisi Freelance / Luar"></option>
</datalist>

<!-- Script JS (Bootstrap 4.6) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
@endsection