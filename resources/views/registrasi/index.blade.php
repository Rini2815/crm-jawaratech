@extends('layouts.app')

@section('content')
@php
    // DATA DUMMY (nanti diganti data dari database)
    $tiket = [
        ['no' => 'SRV-202609-001', 'pelanggan' => 'Budi Santoso', 'wa' => '081234567890', 'unit' => 'AC Daikin (Inverter 1 PK)',      'keluhan' => 'AC Tidak Dingin & Indikator Kedip-Kedip', 'teknisi' => 'Mas Anto',    'status' => 'Sedang Dicek'],
        ['no' => 'SRV-202609-002', 'pelanggan' => 'Siti Aminah',  'wa' => '089876543210', 'unit' => 'Mesin Cuci LG (Front Loading)', 'keluhan' => 'Air Tidak Mau Keluar Saat Pengeringan',  'teknisi' => 'Pak Slamet',  'status' => 'Proses Servis'],
    ];

    $tiketAktif   = count($tiket);
    $tiketProses  = collect($tiket)->whereIn('status', ['Sedang Dicek', 'Proses Servis'])->count();
    $tiketSelesai = collect($tiket)->where('status', 'Selesai')->count();
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
.stat-card.blue { border-left: 4px solid #2563eb !important; }
.stat-card.yellow { border-left: 4px solid #d97706 !important; }
.stat-card.green { border-left: 4px solid #16a34a !important; }

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

.modal-custom-size {
    max-width: 800px !important;
    width: 90%;
}

.super-thick-table th, 
.super-thick-table td {
    border-width: 2px !important;
    border-color: #cbd5e1 !important;
}
</style>

<div class="container-fluid px-4 pt-3 pb-4 crm-wrapper" style="background: linear-gradient(135deg, #eef1f3 0%, #eef1f3 100%); min-height: 100vh;">

    <!-- ================================================================= -->
    <!-- BANNER UTAMA REGISTRASI SERVIS                                    -->
    <!-- ================================================================= -->
    <div class="card rounded-3 mb-4 text-white shadow-sm overflow-hidden" style="background: #0f172a; border: 1px solid #1e293b;">
        <div class="card-body p-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h1 class="h3 mb-1 text-white fw-bold d-flex align-items-center gap-2">
                    <i class="fas fa-file-alt text-info"></i> Registrasi Servis 
                </h1>
                <p class="text-light opacity-75 mb-0" style="font-weight: 400; font-size: 0.95rem;">
                    Halaman Tiket Registrasi Servis Berjalan CRM Jawaratech
                </p>
            </div>
        </div>
    </div>

    <!-- ================================================================= -->
    <!-- REGISTRASI SERVIS                                                 -->
    <!-- ================================================================= -->

    <!-- KARTU STATISTIK REGISTRASI -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card stat-card blue h-100 p-3 border-0" style="border-left: 4px solid #3b82f6 !important; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted text-uppercase mb-1" style="font-size: 0.75rem; font-weight: 600; letter-spacing: 0.5px;">Total Tiket Aktif</p>
                        <h4 class="mb-0 fw-bold text-dark">{{ $tiketAktif }} <span style="font-size: 0.9rem; font-weight: 500; color: #64748b;">Tiket</span></h4>
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
                        <h4 class="mb-0 fw-bold text-dark">{{ $tiketProses }} <span style="font-size: 0.9rem; font-weight: 500; color: #64748b;">Unit</span></h4>
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
            <form action="{{ route('registrasi-servis.index') }}" method="GET" autocomplete="off" class="row align-items-center">
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
                                <div class="d-flex justify-content-center align-items-center gap-1">
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

{{-- MODAL EDIT SERVIS / TIKET (satu per data) --}}
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