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
        font-size: 0.8rem;
    }
    .badge-antrean { background-color: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; }
    .badge-dicek { background-color: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
    .badge-proses { background-color: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; }
    .badge-sparepart { background-color: #fce7f3; color: #be185d; border: 1px solid #fbcfe8; }
    .badge-selesai { background-color: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }

    .super-thick-table th, 
    .super-thick-table td {
        border-width: 2px !important;
        border-color: #334155 !important;
    }
</style>

<div class="container-fluid px-4 pt-3 pb-4 crm-wrapper" style="background: linear-gradient(135deg, #eef1f3 0%, #eef1f3 100%); min-height: 100vh;">
    <!-- Header Halaman (Dibungkus Card Gelap Elegan) -->
    <div class="card rounded-4 mb-4 text-white shadow-lg overflow-hidden" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); border: 1px solid rgba(56, 189, 248, 0.35) !important;">
        <div class="card-body p-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h1 class="h3 mb-1 text-white" style="font-weight: 700;"><i class="fas fa-tools text-primary me-2"></i> Registrasi Unit Servis</h1>
                <p class="text-light opacity-75 mb-0" style="font-weight: 500;">Kelola transaksi penerimaan unit perbaikan (Job Intake) dan tiket servis berjalan CRM Jawaratech</p>
            </div>
            
            <!-- Tombol Tambah Registrasi -->
            <button type="button" class="btn btn-primary shadow-sm px-4 py-2 fw-bold d-flex align-items-center gap-2 rounded-pill" style="font-size: 0.875rem; background-color: #2563eb; border-color: #2563eb;" data-toggle="modal" data-bs-toggle="modal" data-target="#modalTambahRegistrasi" data-bs-target="#modalTambahRegistrasi">
                <i class="fas fa-plus-circle"></i> Tambah Registrasi Baru
            </button>
        </div>
    </div>

    <!-- Card Utama Data Servis -->
    <div class="card crm-card overflow-hidden mb-4">
        <!-- Card Header Title -->
        <div class="card-header text-white border-0 pt-3 px-4 pb-3 d-flex align-items-center justify-content-between shadow-sm" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); border-bottom: 2px solid rgba(56, 189, 248, 0.4) !important;">
            <div class="d-flex align-items-center gap-2">
                <div class="p-2 rounded-circle bg-primary bg-opacity-25 text-info">
                    <i class="fas fa-tools fa-lg"></i>
                </div>
                <div>
                    <h5 class="m-0 text-white fw-bold">Daftar Servis Berjalan (Active Tickets)</h5>
                    <small class="text-light opacity-75">Pantau status pengerjaan, teknisi bertugas, dan kelengkapan unit pelanggan</small>
                </div>
            </div>
        </div>

        <!-- BAR PENCARIAN & FILTER DATA -->
        <div class="card-body border-bottom bg-white py-3 px-4">
            <form action="{{ route('registrasi.index') }}" method="GET" class="row g-2 align-items-center">
                <!-- Kolom Input Pencarian Kata Kunci -->
                <div class="col-md-5 col-sm-12 mb-2 mb-md-0">
                    <div class="input-group">
                        <div class="input-group-prepend input-group-text bg-white border-right-0 border-end-0 text-muted" style="border-radius: 6px 0 0 6px; border-color: #cbd5e1;">
                            <i class="fas fa-search"></i>
                        </div>
                        <input type="text" name="search" class="form-control crm-form-control border-left-0 border-start-0" placeholder="Cari Tiket, Pelanggan, Unit, atau Teknisi..." value="{{ request('search') }}" style="border-radius: 0 6px 6px 0;">
                    </div>
                </div>

                <!-- Dropdown Filter Status Servis -->
                <div class="col-md-4 col-sm-6 mb-2 mb-md-0">
                    <select name="status" class="form-control crm-form-control">
                        <option value="">-- Semua Status Servis --</option>
                        <option value="Proses Antrean" {{ request('status') == 'Proses Antrean' ? 'selected' : '' }}>Proses Antrean</option>
                        <option value="Sedang Dicek" {{ request('status') == 'Sedang Dicek' ? 'selected' : '' }}>Sedang Dicek</option>
                        <option value="Proses Servis" {{ request('status') == 'Proses Servis' ? 'selected' : '' }}>Proses Servis</option>
                        <option value="Menunggu Sparepart" {{ request('status') == 'Menunggu Sparepart' ? 'selected' : '' }}>Menunggu Sparepart</option>
                        <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>

                <!-- Tombol Action Cari & Reset -->
                <div class="col-md-3 col-sm-6 d-flex">
                    <button type="submit" class="btn btn-dark w-100 shadow-sm mr-2 me-2" style="font-weight: 600; border-radius: 6px; background-color: #1e293b; border-color: #1e293b;">
                        <i class="fas fa-filter mr-1 me-1"></i> Filter
                    </button>
                    @if(request('search') || request('status'))
                        <a href="{{ route('registrasi.index') }}" class="btn btn-outline-secondary shadow-sm" title="Reset Pencarian" style="border-radius: 6px;">
                            <i class="fas fa-undo"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Tabel Data Servis Berjalan -->
        <div class="card-body p-4 bg-white">
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle mb-0 super-thick-table">
                    <thead class="crm-table-header text-uppercase text-center fs-7">
                        <tr>
                            <th class="py-3 text-white" style="width: 5%;">NO</th>
                            <th class="py-3 text-white text-start" style="width: 15%;">NO TIKET / SPK</th>
                            <th class="py-3 text-white text-start" style="width: 15%;">PELANGGAN</th>
                            <th class="py-3 text-white text-start" style="width: 18%;">UNIT & MEREK</th>
                            <th class="py-3 text-white text-start" style="width: 18%;">KELUAHAN</th>
                            <th class="py-3 text-white text-start" style="width: 10%;">TEKNISI</th>
                            <th class="py-3 text-white text-center" style="width: 11%;">STATUS SERVIS</th>
                            <th class="text-center py-3 text-white" style="width: 8%;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody style="font-weight: 500;">
                        @php
                            $registrasi = [
                                [
                                    'no_tiket' => 'SRV-202609-001',
                                    'pelanggan' => 'Budi Santoso',
                                    'no_wa' => '081234567890',
                                    'unit' => 'AC Daikin (Inverter 1 PK)',
                                    'tgl_masuk' => '2026-09-25',
                                    'perkiraan_selesai' => '2026-09-28',
                                    'keluhan' => 'AC Tidak Dingin & Indikator Kedip-Kedip',
                                    'kelengkapan' => ['Unit Utama', 'Remote AC/TV'],
                                    'teknisi' => 'Mas Anto',
                                    'status' => 'Sedang Dicek',
                                    'icon' => 'fa-search',
                                    'class' => 'badge-dicek'
                                ],
                                [
                                    'no_tiket' => 'SRV-202609-002',
                                    'pelanggan' => 'Siti Aminah',
                                    'no_wa' => '089876543210',
                                    'unit' => 'Mesin Cuci LG (Front Loading)',
                                    'tgl_masuk' => '2026-09-26',
                                    'perkiraan_selesai' => '2026-09-29',
                                    'keluhan' => 'Air Tidak Mau Keluar Saat Pengeringan',
                                    'kelengkapan' => ['Unit Utama', 'Kabel Power'],
                                    'teknisi' => 'Pak Slamet',
                                    'status' => 'Proses Servis',
                                    'icon' => 'fa-cog fa-spin',
                                    'class' => 'badge-proses'
                                ],
                            ];
                        @endphp

                        @foreach($registrasi as $index => $item)
                            <tr>
                                <td class="px-3 py-3 text-secondary text-center">{{ $index + 1 }}</td>
                                <td class="py-3 text-primary fw-bold" style="font-weight: 700;">{{ $item['no_tiket'] }}</td>
                                <td class="py-3">
                                    <div class="text-dark" style="font-weight: 600;">{{ $item['pelanggan'] }}</div>
                                    <small class="text-muted">{{ $item['no_wa'] }}</small>
                                </td>
                                <td class="py-3 text-secondary">{{ $item['unit'] }}</td>
                                <td class="py-3 text-secondary small" style="max-width: 220px;">{{ $item['keluhan'] }}</td>
                                <td class="py-3 text-dark fw-bold">{{ $item['teknisi'] }}</td>
                                <td class="py-3 text-center">
                                    <span class="badge crm-badge {{ $item['class'] }}">
                                        <i class="fas {{ $item['icon'] }} mr-1 me-1"></i> {{ $item['status'] }}
                                    </span>
                                </td>
                                <td class="py-3 text-center">
                                    <div class="d-flex justify-content-center align-items-center gap-1 flex-nowrap">
                                        <button class="btn btn-sm btn-outline-primary shadow-sm px-2 py-1" title="Edit / Update Progress" style="border-radius: 4px;" data-toggle="modal" data-bs-toggle="modal" data-target="#modalEditRegistrasi{{ $index }}" data-bs-target="#modalEditRegistrasi{{ $index }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <a href="#" class="btn btn-sm btn-outline-success shadow-sm px-2 py-1" title="Cetak SPK/Struk" style="border-radius: 4px;">
                                            <i class="fas fa-print"></i>
                                        </a>
                                        <button class="btn btn-sm btn-outline-danger shadow-sm px-2 py-1" title="Hapus Registrasi" style="border-radius: 4px;">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            
                            <!-- Modal Edit -->
                            @include('registrasi.edit')

                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
@include('registrasi.create')

<!-- Datalist Global untuk Auto-complete nama teknisi -->
<datalist id="datalist_teknisi">
    <option value="Mas Anto"></option>
    <option value="Pak Slamet"></option>
    <option value="Teknisi Freelance / Luar"></option>
</datalist>

<!-- Script JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
@endsection