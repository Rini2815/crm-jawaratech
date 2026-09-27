@extends('layouts.app')

@section('content')
<!-- Wrapper Utama dengan background gelap malam -->
<div class="container-fluid px-4 pt-3 pb-4" style="background: linear-gradient(135deg, #0b131d 0%, #060910 100%); min-height: 100vh; color: #f8fafc;">
    
    <!-- Header Title -->
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom border-secondary border-opacity-25">
        <div>
            <h2 class="text-white fw-bold mb-1"><i class="fas fa-file-alt text-primary me-2"></i> Laporan & Riwayat Servis</h2>
            <p class="text-light opacity-75 small mb-0">Kelola log kronologis perbaikan unit, filter periode, dan unduh laporan (PDF/Excel)</p>
        </div>
        <div class="d-flex gap-2">
            <!-- Tombol Cetak PDF Harian -->
            <a href="#" class="btn btn-danger px-3 py-2 rounded-pill shadow-sm fw-bold d-flex align-items-center gap-2" style="font-size: 0.875rem;">
                <i class="fas fa-file-pdf"></i> Cetak Harian (PDF)
            </a>
            <!-- Tombol Rekap Excel Bulanan/Tahunan -->
            <a href="#" class="btn btn-success px-3 py-2 rounded-pill shadow-sm fw-bold d-flex align-items-center gap-2" style="font-size: 0.875rem;">
                <i class="fas fa-file-excel"></i> Rekap (Excel)
            </a>
        </div>
    </div>

    <!-- 1. KARTU RINGKASAN STATISTIK LAPORAN DI BAGIAN ATAS -->
    <div class="row">
        <!-- Total Laporan Periode Ini -->
        <div class="col-xl-4 col-md-4 mb-4">
            <div class="card rounded-4 text-dark" style="background: linear-gradient(135deg, #f1f5f9 0%, #cbd5e1 100%); border-left: 4px solid #0d1b2a !important; border: 1px solid rgba(36, 59, 85, 0.35) !important; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5), inset 0 0 20px rgba(36, 59, 85, 0.15) !important;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-secondary small fw-bold text-uppercase mb-1">Total Laporan Aktif</div>
                            <div class="fs-3 fw-bold mb-0 text-dark">48 <span class="fs-6 fw-normal text-muted">Data</span></div>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle text-primary">
                            <i class="fas fa-file-invoice fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Laporan Berdasarkan Bulan -->
        <div class="col-xl-4 col-md-4 mb-4">
            <div class="card rounded-4 text-dark" style="background: linear-gradient(135deg, #f1f5f9 0%, #cbd5e1 100%); border-left: 4px solid #b45309 !important; border: 1px solid rgba(36, 59, 85, 0.35) !important; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5), inset 0 0 20px rgba(36, 59, 85, 0.15) !important;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-secondary small fw-bold text-uppercase mb-1">Rekap Bulan Ini</div>
                            <div class="fs-3 fw-bold mb-0 text-dark">32 <span class="fs-6 fw-normal text-muted">Servis</span></div>
                        </div>
                        <div class="p-3 rounded-circle" style="background: rgba(180, 83, 9, 0.15); color: #b45309;">
                            <i class="fas fa-calendar-alt fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Laporan Berdasarkan Tahun -->
        <div class="col-xl-4 col-md-4 mb-4">
            <div class="card rounded-4 text-dark" style="background: linear-gradient(135deg, #f1f5f9 0%, #cbd5e1 100%); border-left: 4px solid #10b981 !important; border: 1px solid rgba(36, 59, 85, 0.35) !important; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5), inset 0 0 20px rgba(36, 59, 85, 0.15) !important;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-secondary small fw-bold text-uppercase mb-1">Rekap Tahun 2026</div>
                            <div class="fs-3 fw-bold mb-0 text-dark">120 <span class="fs-6 fw-normal text-muted">Total Unit</span></div>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded-circle text-success">
                            <i class="fas fa-chart-line fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. CARD FILTER PERIODE (HARI, BULAN, TAHUN) & JENIS UNIT -->
    <div class="card rounded-4 mb-4 text-dark shadow-sm" style="background: linear-gradient(135deg, #f1f5f9 0%, #cbd5e1 100%); border: 1px solid rgba(36, 59, 85, 0.35) !important; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5), inset 0 0 25px rgba(36, 59, 85, 0.12) !important;">
        <div class="card-body p-4">
            <h5 class="fw-bold text-dark mb-3"><i class="fas fa-filter text-primary me-2"></i> Filter Periode & Kategori Laporan</h5>
            <form action="#" method="GET">
                <div class="row g-3">
                    <!-- Filter Berdasarkan Hari / Tanggal Spesifik -->
                    <div class="col-md-3">
                        <label class="form-label small fw-bold text-secondary">Pilih Tanggal (Harian)</label>
                        <input type="date" class="form-control rounded-pill border-secondary border-opacity-25" value="{{ date('Y-m-d') }}">
                    </div>
                    <!-- Filter Berdasarkan Bulan -->
                    <div class="col-md-3">
                        <label class="form-label small fw-bold text-secondary">Pilih Bulan (Bulanan)</label>
                        <select class="form-select rounded-pill border-secondary border-opacity-25">
                            <option value="">Semua Bulan</option>
                            <option value="01" {{ date('m') == '01' ? 'selected' : '' }}>Januari</option>
                            <option value="02" {{ date('m') == '02' ? 'selected' : '' }}>Februari</option>
                            <option value="03" {{ date('m') == '03' ? 'selected' : '' }}>Maret</option>
                            <option value="04" {{ date('m') == '04' ? 'selected' : '' }}>April</option>
                            <option value="05" {{ date('m') == '05' ? 'selected' : '' }}>Mei</option>
                            <option value="06" {{ date('m') == '06' ? 'selected' : '' }}>Juni</option>
                            <option value="07" {{ date('m') == '07' ? 'selected' : '' }}>Juli</option>
                            <option value="08" {{ date('m') == '08' ? 'selected' : '' }}>Agustus</option>
                            <option value="09" {{ date('m') == '09' ? 'selected' : '' }}>September</option>
                            <option value="10" {{ date('m') == '10' ? 'selected' : '' }}>Oktober</option>
                            <option value="11" {{ date('m') == '11' ? 'selected' : '' }}>November</option>
                            <option value="12" {{ date('m') == '12' ? 'selected' : '' }}>Desember</option>
                        </select>
                    </div>
                    <!-- Filter Berdasarkan Tahun -->
                    <div class="col-md-3">
                        <label class="form-label small fw-bold text-secondary">Pilih Tahun (Tahunan)</label>
                        <select class="form-select rounded-pill border-secondary border-opacity-25">
                            <option value="2026" selected>2026</option>
                            <option value="2025">2025</option>
                            <option value="2024">2024</option>
                        </select>
                    </div>
                    <!-- Tombol Terapkan Filter -->
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-dark w-100 rounded-pill fw-semibold shadow-sm py-2">
                            <i class="fas fa-search me-1"></i> Terapkan Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- 3. TABEL HASIL RIWAYAT & LOG KRONOLOGIS -->
    <div class="card rounded-4 mb-4 text-dark shadow-sm" style="background: linear-gradient(135deg, #f1f5f9 0%, #cbd5e1 100%); border: 1px solid rgba(36, 59, 85, 0.35) !important; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5), inset 0 0 25px rgba(36, 59, 85, 0.12) !important;">
        <div class="card-header bg-transparent border-0 pt-4 px-4 pb-3 d-flex justify-content-between align-items-center">
            <h5 class="fw-bold text-dark m-0"><i class="fas fa-history text-primary me-2"></i> Log Kronologis Riwayat Servis Konsumen</h5>
            <span class="badge bg-secondary rounded-pill px-3 py-2">Menampilkan Data Periode Terpilih</span>
        </div>
        <div class="card-body px-4 pb-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 bg-transparent" width="100%" cellspacing="0">
                    <thead class="table-light text-uppercase fs-7 text-secondary border-bottom border-secondary border-opacity-25" style="background: rgba(255, 255, 255, 0.5);">
                        <tr>
                            <th class="py-3 text-secondary">No</th>
                            <th class="py-3 text-secondary">Nama Konsumen & Kontak</th>
                            <th class="py-3 text-secondary">Detail Unit</th>
                            <th class="py-3 text-secondary">Histori Kunjungan & Teknisi</th>
                            <th class="py-3 text-secondary text-center">Aksi Detail</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        <!-- Baris Log 1 -->
                        <tr class="border-bottom border-secondary border-opacity-10">
                            <td class="py-3 fw-semibold text-dark">1</td>
                            <td class="py-3 text-dark">
                                <div class="fw-bold">Siti Aminah</div>
                                <div class="text-muted small"><i class="fab fa-whatsapp text-success me-1"></i> 08123456789</div>
                            </td>
                            <td class="py-3">
                                <span class="badge px-3 py-1.5 fw-bold shadow-sm" style="background-color: rgba(13, 202, 240, 0.12); color: #087990; border: 1px solid rgba(13, 202, 240, 0.4);">
                                    <i class="fas fa-snowflake me-1"></i> AC Split
                                </span>
                                <div class="text-muted small mt-1">Sharp 1 PK</div>
                            </td>
                            <td class="py-3">
                                <div class="small fw-semibold text-dark">• 10 Jan 2026: Cuci (Teknisi: Budi)</div>
                                <div class="small text-secondary">• 12 Jun 2026: Isi Freon (Teknisi: Joko)</div>
                            </td>
                            <td class="py-3 text-center">
                                <button class="btn btn-sm btn-outline-dark rounded-pill px-3" title="Lihat Kronologi Lengkap">
                                    <i class="fas fa-eye me-1"></i> Detail
                                </button>
                            </td>
                        </tr>
                        <!-- Baris Log 2 -->
                        <tr>
                            <td class="py-3 fw-semibold text-dark">2</td>
                            <td class="py-3 text-dark">
                                <div class="fw-bold">Budi Santoso</div>
                                <div class="text-muted small"><i class="fab fa-whatsapp text-success me-1"></i> 08987654321</div>
                            </td>
                            <td class="py-3">
                                <span class="badge px-3 py-1.5 fw-bold shadow-sm" style="background-color: rgba(13, 110, 253, 0.12); color: #0d6efd; border: 1px solid rgba(13, 110, 253, 0.4);">
                                    <i class="fas fa-tint me-1"></i> Dispenser
                                </span>
                                <div class="text-muted small mt-1">Miyako</div>
                            </td>
                            <td class="py-3">
                                <div class="small fw-semibold text-dark">• 05 Mar 2026: Ganti Part (Teknisi: Joko)</div>
                            </td>
                            <td class="py-3 text-center">
                                <button class="btn btn-sm btn-outline-dark rounded-pill px-3" title="Lihat Kronologi Lengkap">
                                    <i class="fas fa-eye me-1"></i> Detail
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Tambahan CSS Global agar Background Body Ikut Gelap -->
<style>
    body, html {
        background-color: #060910 !important;
    }
    .table-hover tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.04) !important;
    }
</style>
@endsection