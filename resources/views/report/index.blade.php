@extends('layouts.app')

@section('content')
<!-- Wrapper Utama -->
<div class="container-fluid px-4 pt-3 pb-4" style="background: linear-gradient(135deg, #eef1f3 0%, #eef1f3); min-height: 100vh; color: #f8fafc;">
    
    <!-- HEADER HALAMAN -->
    <div class="card rounded-4 mb-4 text-white shadow-lg overflow-hidden" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); border: 1px solid rgba(56, 189, 248, 0.35) !important;">
        <div class="card-body p-4 d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
            <div>
                <h2 class="text-white fw-bold mb-1"><i class="fas fa-file-alt text-primary me-2"></i> Laporan & Rekapitulasi Servis Jawaratech</h2>
                <p class="text-light opacity-75 small mb-0">Sistem Administrasi Layanan Servis, Registrasi, Closing, hingga Cetak Laporan PDF Riwayat Konsumen</p>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <!-- Tombol Cetak PDF Global -->
                <a href="#" class="btn btn-danger px-3 py-2 rounded-pill shadow-sm fw-bold d-flex align-items-center gap-2" style="font-size: 0.875rem;">
                    <i class="fas fa-file-pdf"></i> Cetak Laporan PDF (Global)
                </a>
                <!-- Tombol Rekap Excel -->
                <a href="#" class="btn btn-success px-3 py-2 rounded-pill shadow-sm fw-bold d-flex align-items-center gap-2" style="font-size: 0.875rem;">
                    <i class="fas fa-file-excel"></i> Rekap Excel
                </a>
            </div>
        </div>
    </div>

    <!-- ========================================================================= -->
    <!-- 1. 6 KARTU RINGKASAN STATISTIK (DENGAN EFEK BAYANGAN DALAM / INSET) -->
    <!-- ========================================================================= -->
    <div class="row g-3 mb-4">
        <!-- Kotak 1 -->
        <div class="col-xl-4 col-md-6">
            <div class="card rounded-4 text-dark shadow-sm h-100" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); border-left: 5px solid #0284c7 !important; border: 1px solid rgba(148, 163, 184, 0.5); box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.06), 0 4px 6px -1px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-secondary small fw-bold text-uppercase mb-1">Total Unit Terdaftar</div>
                            <div class="fs-3 fw-bold mb-0 text-dark">48 <span class="fs-6 fw-normal text-muted">Konsumen</span></div>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle text-primary shadow-inner">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kotak 2 -->
        <div class="col-xl-4 col-md-6">
            <div class="card rounded-4 text-dark shadow-sm h-100" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); border-left: 5px solid #059669 !important; border: 1px solid rgba(148, 163, 184, 0.5); box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.06), 0 4px 6px -1px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-secondary small fw-bold text-uppercase mb-1">Closing Servis Bulan Ini</div>
                            <div class="fs-3 fw-bold mb-0 text-dark">32 <span class="fs-6 fw-normal text-muted">Selesai</span></div>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded-circle text-success">
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kotak 3 -->
        <div class="col-xl-4 col-md-6">
            <div class="card rounded-4 text-dark shadow-sm h-100" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); border-left: 5px solid #0ea5e9 !important; border: 1px solid rgba(148, 163, 184, 0.5); box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.06), 0 4px 6px -1px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-secondary small fw-bold text-uppercase mb-1">Unit Bergaransi Aktif</div>
                            <div class="fs-3 fw-bold mb-0 text-dark">18 <span class="fs-6 fw-normal text-muted">Valid</span></div>
                        </div>
                        <div class="p-3 rounded-circle" style="background: rgba(14, 165, 233, 0.15); color: #0ea5e9;">
                            <i class="fas fa-shield-alt fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kotak 4 -->
        <div class="col-xl-4 col-md-6">
            <div class="card rounded-4 text-dark shadow-sm h-100" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); border-left: 5px solid #d97706 !important; border: 1px solid rgba(148, 163, 184, 0.5); box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.06), 0 4px 6px -1px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-secondary small fw-bold text-uppercase mb-1">Antrean Perawatan Berkala</div>
                            <div class="fs-3 fw-bold mb-0 text-dark">14 <span class="fs-6 fw-normal text-muted">Jadwal</span></div>
                        </div>
                        <div class="p-3 rounded-circle" style="background: rgba(217, 119, 6, 0.15); color: #d97706;">
                            <i class="fas fa-bell fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kotak 5 -->
        <div class="col-xl-4 col-md-6">
            <div class="card rounded-4 text-dark shadow-sm h-100" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); border-left: 5px solid #7c3aed !important; border: 1px solid rgba(148, 163, 184, 0.5); box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.06), 0 4px 6px -1px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-secondary small fw-bold text-uppercase mb-1">Follow-Up WhatsApp (DM)</div>
                            <div class="fs-3 fw-bold mb-0 text-dark">26 <span class="fs-6 fw-normal text-muted">Terkirim</span></div>
                        </div>
                        <div class="p-3 rounded-circle" style="background: rgba(124, 58, 237, 0.15); color: #7c3aed;">
                            <i class="fab fa-whatsapp fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kotak 6 -->
        <div class="col-xl-4 col-md-6">
            <div class="card rounded-4 text-dark shadow-sm h-100" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); border-left: 5px solid #475569 !important; border: 1px solid rgba(148, 163, 184, 0.5); box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.06), 0 4px 6px -1px rgba(0, 0, 0, 0.1) !important;">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-secondary small fw-bold text-uppercase mb-1">Total Unit Tahun 2026</div>
                            <div class="fs-3 fw-bold mb-0 text-dark">120 <span class="fs-6 fw-normal text-muted">Unit</span></div>
                        </div>
                        <div class="p-3 rounded-circle" style="background: rgba(71, 85, 105, 0.15); color: #475569;">
                            <i class="fas fa-chart-line fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ========================================================================= -->
    <!-- 2. CARD FILTER PERIODE & KATEGORI -->
    <!-- ========================================================================= -->
    <div class="card rounded-4 mb-4 text-dark shadow-sm" style="background: linear-gradient(135deg, #f1f5f9 0%, #cbd5e1 100%); border: 1px solid rgba(36, 59, 85, 0.35) !important;">
        <div class="card-body p-4">
            <h5 class="fw-bold text-dark mb-3"><i class="fas fa-filter text-primary me-2"></i> Filter Periode, Unit & Kategori Laporan</h5>
            <form action="#" method="GET">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label small fw-bold text-secondary">Pilih Tanggal (Harian)</label>
                        <input type="date" class="form-control rounded-pill border-secondary shadow-sm text-dark" style="border-width: 1.5px !important; background-color: #ffffff;" value="{{ date('Y-m-d') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold text-secondary">Pilih Bulan (Bulanan)</label>
                        <select class="form-select rounded-pill border-secondary shadow-sm text-dark" style="border-width: 1.5px !important; background-color: #ffffff;">
                            <option value="">Semua Bulan</option>
                            <option value="09" selected>September</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold text-secondary">Pilih Tahun (Tahunan)</label>
                        <select class="form-select rounded-pill border-secondary shadow-sm text-dark" style="border-width: 1.5px !important; background-color: #ffffff;">
                            <option value="2026" selected>2026</option>
                            <option value="2025">2025</option>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100 rounded-pill fw-semibold shadow-sm py-2" style="background-color: #2563eb; border-color: #2563eb;">
                            <i class="fas fa-search me-1"></i> Terapkan Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- ========================================================================= -->
    <!-- 3. TABEL KOMPREHENSIF DENGAN GARIS TEBAL SUPER JELAS -->
    <!-- ========================================================================= -->
    <div class="card rounded-4 mb-4 text-dark shadow-sm overflow-hidden" style="background: linear-gradient(135deg, #f1f5f9 0%, #cbd5e1 100%); border: 1px solid rgba(36, 59, 85, 0.35) !important;">
        <!-- Header Tabel Navy Slate -->
        <div class="card-header text-white border-0 pt-3 px-4 pb-3 d-flex justify-content-between align-items-center" style="background-color: #1e293b;">
            <h5 class="fw-bold m-0"><i class="fas fa-history text-info me-2"></i> Log Komprehensif: Registrasi, Servis, Garansi & Closing</h5>
            <span class="badge bg-primary rounded-pill px-3 py-2 text-white border border-info">Menampilkan 5 Data Utama Konsumen</span>
        </div>
        
        <div class="card-body px-4 pb-4">
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle mb-0 bg-white shadow-sm rounded super-thick-table" width="100%" cellspacing="0">
                    <!-- HEADER TABEL RATA TENGAH -->
                    <thead class="text-uppercase fs-7 text-white text-center" style="background-color: #1e293b;">
                        <tr>
                            <th class="py-3 text-white text-center" style="width: 5%;">No</th>
                            <th class="py-3 text-white text-center" style="width: 23%;">Identitas Konsumen & Kontak</th>
                            <th class="py-3 text-white text-center" style="width: 20%;">Detail Unit & Garansi</th>
                            <th class="py-3 text-white text-center" style="width: 24%;">Keluhan & Tanggal Registrasi</th>
                            <th class="py-3 text-white text-center" style="width: 18%;">Closing & Teknisi</th>
                            <th class="py-3 text-white text-center" style="width: 10%;">Aksi & Cetak</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data 1 -->
                        <tr>
                            <td class="fw-bold text-center">1</td>
                            <td>
                                <div class="p-2 rounded bg-light border border-dark border-opacity-75 shadow-sm">
                                    <div class="fw-bold text-dark">Siti Aminah</div>
                                    <div class="text-secondary small mt-1 border-top border-dark border-opacity-50 pt-1">
                                        <span class="badge bg-white text-success border border-success px-2 py-1"><i class="fab fa-whatsapp me-1"></i> 08123456789</span>
                                    </div>
                                    <div class="text-muted small mt-1 bg-white p-1 rounded border border-dark border-opacity-50">Jl. Mawar No. 12, Madiun</div>
                                </div>
                            </td>
                            <td>
                                <div class="p-2 rounded bg-light border border-dark border-opacity-75 shadow-sm">
                                    <span class="badge bg-info text-dark fw-bold px-2 py-1 mb-1 border border-info">
                                        <i class="fas fa-snowflake text-info me-1"></i> AC Split (Sharp 1 PK)
                                    </span>
                                    <div><span class="badge bg-success text-white px-2 py-1 small fw-semibold"><i class="fas fa-check-circle me-1"></i> Garansi Valid</span></div>
                                </div>
                            </td>
                            <td>
                                <div class="p-2 rounded bg-white border border-dark border-opacity-75 shadow-sm text-dark small">
                                    <strong class="text-primary"><i class="fas fa-comment-alt me-1"></i> Keluhan:</strong><br>
                                    AC kurang dingin dan air menetes dari indoor.
                                    <div class="text-dark mt-1 border-top border-dark border-opacity-50 pt-1">
                                        <span class="badge bg-light text-dark border border-dark px-2 py-1"><strong>Reg:</strong> 10 Jan 2026</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="p-2 rounded bg-white border border-dark border-opacity-75 shadow-sm text-dark small">
                                    <strong class="text-success"><i class="fas fa-wrench me-1"></i> Closing:</strong><br>
                                    Cuci & Tambah Freon<br>
                                    <span class="text-muted">Teknisi: Budi & Joko</span>
                                    <div class="text-dark mt-1 border-top border-dark border-opacity-50 pt-1">
                                        <span class="badge bg-light text-dark border border-dark px-2 py-1"><strong>Selesai:</strong> 12 Jun 2026</span>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="d-flex flex-column gap-1">
                                    <button class="btn btn-sm btn-outline-dark rounded-pill px-2 py-1" title="Lihat Detail Lengkap">
                                        <i class="fas fa-eye me-1"></i> Detail
                                    </button>
                                    <a href="#" class="btn btn-sm btn-danger rounded-pill px-2 py-1 shadow-sm text-white" title="Cetak Riwayat PDF Klien Ini">
                                        <i class="fas fa-print me-1"></i> Cetak PDF
                                    </a>
                                </div>
                            </td>
                        </tr>

                        <!-- Data 2 -->
                        <tr>
                            <td class="fw-bold text-center">2</td>
                            <td>
                                <div class="p-2 rounded bg-light border border-dark border-opacity-75 shadow-sm">
                                    <div class="fw-bold text-dark">Budi Santoso</div>
                                    <div class="text-secondary small mt-1 border-top border-dark border-opacity-50 pt-1">
                                        <span class="badge bg-white text-success border border-success px-2 py-1"><i class="fab fa-whatsapp me-1"></i> 08987654321</span>
                                    </div>
                                    <div class="text-muted small mt-1 bg-white p-1 rounded border border-dark border-opacity-50">Jl. Melati Blok C/5, Madiun</div>
                                </div>
                            </td>
                            <td>
                                <div class="p-2 rounded bg-light border border-dark border-opacity-75 shadow-sm">
                                    <span class="badge bg-primary text-white fw-bold px-2 py-1 mb-1 border border-primary">
                                        <i class="fas fa-tint me-1"></i> Dispenser (Miyako)
                                    </span>
                                    <div><span class="badge bg-secondary text-white px-2 py-1 small fw-semibold"><i class="fas fa-times-circle me-1"></i> Non-Garansi</span></div>
                                </div>
                            </td>
                            <td>
                                <div class="p-2 rounded bg-white border border-dark border-opacity-75 shadow-sm text-dark small">
                                    <strong class="text-primary"><i class="fas fa-comment-alt me-1"></i> Keluhan:</strong><br>
                                    Air keran galon bawah tidak mau keluar air panas.
                                    <div class="text-dark mt-1 border-top border-dark border-opacity-50 pt-1">
                                        <span class="badge bg-light text-dark border border-dark px-2 py-1"><strong>Reg:</strong> 01 Mar 2026</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="p-2 rounded bg-white border border-dark border-opacity-75 shadow-sm text-dark small">
                                    <strong class="text-success"><i class="fas fa-wrench me-1"></i> Closing:</strong><br>
                                    Ganti Part (Elemen Heater)<br>
                                    <span class="text-muted">Teknisi: Joko</span>
                                    <div class="text-dark mt-1 border-top border-dark border-opacity-50 pt-1">
                                        <span class="badge bg-light text-dark border border-dark px-2 py-1"><strong>Selesai:</strong> 05 Mar 2026</span>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="d-flex flex-column gap-1">
                                    <button class="btn btn-sm btn-outline-dark rounded-pill px-2 py-1" title="Lihat Detail Lengkap">
                                        <i class="fas fa-eye me-1"></i> Detail
                                    </button>
                                    <a href="#" class="btn btn-sm btn-danger rounded-pill px-2 py-1 shadow-sm text-white" title="Cetak Riwayat PDF Klien Ini">
                                        <i class="fas fa-print me-1"></i> Cetak PDF
                                    </a>
                                </div>
                            </td>
                        </tr>

                        <!-- Data 3 -->
                        <tr>
                            <td class="fw-bold text-center">3</td>
                            <td>
                                <div class="p-2 rounded bg-light border border-dark border-opacity-75 shadow-sm">
                                    <div class="fw-bold text-dark">Dewi Lestari</div>
                                    <div class="text-secondary small mt-1 border-top border-dark border-opacity-50 pt-1">
                                        <span class="badge bg-white text-success border border-success px-2 py-1"><i class="fab fa-whatsapp me-1"></i> 08567891234</span>
                                    </div>
                                    <div class="text-muted small mt-1 bg-white p-1 rounded border border-dark border-opacity-50">Perum Griya Asri Blok A/3</div>
                                </div>
                            </td>
                            <td>
                                <div class="p-2 rounded bg-light border border-dark border-opacity-75 shadow-sm">
                                    <span class="badge bg-warning text-dark fw-bold px-2 py-1 mb-1 border border-warning">
                                        <i class="fas fa-circle-notch me-1"></i> Mesin Cuci (LG 2 Tabung)
                                    </span>
                                    <div><span class="badge bg-success text-white px-2 py-1 small fw-semibold"><i class="fas fa-check-circle me-1"></i> Garansi Valid</span></div>
                                </div>
                            </td>
                            <td>
                                <div class="p-2 rounded bg-white border border-dark border-opacity-75 shadow-sm text-dark small">
                                    <strong class="text-primary"><i class="fas fa-comment-alt me-1"></i> Keluhan:</strong><br>
                                    Pengering berputar lambat dan berisik saat dipakai.
                                    <div class="text-dark mt-1 border-top border-dark border-opacity-50 pt-1">
                                        <span class="badge bg-light text-dark border border-dark px-2 py-1"><strong>Reg:</strong> 15 Apr 2026</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="p-2 rounded bg-white border border-dark border-opacity-75 shadow-sm text-dark small">
                                    <strong class="text-success"><i class="fas fa-wrench me-1"></i> Closing:</strong><br>
                                    Ganti Part (Belt & Kapasitor)<br>
                                    <span class="text-muted">Teknisi: Budi</span>
                                    <div class="text-dark mt-1 border-top border-dark border-opacity-50 pt-1">
                                        <span class="badge bg-light text-dark border border-dark px-2 py-1"><strong>Selesai:</strong> 18 Apr 2026</span>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="d-flex flex-column gap-1">
                                    <button class="btn btn-sm btn-outline-dark rounded-pill px-2 py-1" title="Lihat Detail Lengkap">
                                        <i class="fas fa-eye me-1"></i> Detail
                                    </button>
                                    <a href="#" class="btn btn-sm btn-danger rounded-pill px-2 py-1 shadow-sm text-white" title="Cetak Riwayat PDF Klien Ini">
                                        <i class="fas fa-print me-1"></i> Cetak PDF
                                    </a>
                                </div>
                            </td>
                        </tr>

                        <!-- Data 4 -->
                        <tr>
                            <td class="fw-bold text-center">4</td>
                            <td>
                                <div class="p-2 rounded bg-light border border-dark border-opacity-75 shadow-sm">
                                    <div class="fw-bold text-dark">Ahmad Fauzi</div>
                                    <div class="text-secondary small mt-1 border-top border-dark border-opacity-50 pt-1">
                                        <span class="badge bg-white text-success border border-success px-2 py-1"><i class="fab fa-whatsapp me-1"></i> 08198765432</span>
                                    </div>
                                    <div class="text-muted small mt-1 bg-white p-1 rounded border border-dark border-opacity-50">Jl. Pahlawan No. 45, Madiun</div>
                                </div>
                            </td>
                            <td>
                                <div class="p-2 rounded bg-light border border-dark border-opacity-75 shadow-sm">
                                    <span class="badge bg-danger text-white fw-bold px-2 py-1 mb-1 border border-danger">
                                        <i class="fas fa-fire me-1"></i> Water Heater (Ariston)
                                    </span>
                                    <div><span class="badge bg-secondary text-white px-2 py-1 small fw-semibold"><i class="fas fa-times-circle me-1"></i> Non-Garansi</span></div>
                                </div>
                            </td>
                            <td>
                                <div class="p-2 rounded bg-white border border-dark border-opacity-75 shadow-sm text-dark small">
                                    <strong class="text-primary"><i class="fas fa-comment-alt me-1"></i> Keluhan:</strong><br>
                                    Air tidak panas dan lampu indikator mati total.
                                    <div class="text-dark mt-1 border-top border-dark border-opacity-50 pt-1">
                                        <span class="badge bg-light text-dark border border-dark px-2 py-1"><strong>Reg:</strong> 02 Mei 2026</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="p-2 rounded bg-white border border-dark border-opacity-75 shadow-sm text-dark small">
                                    <strong class="text-success"><i class="fas fa-wrench me-1"></i> Closing:</strong><br>
                                    Ganti Part (Thermostat)<br>
                                    <span class="text-muted">Teknisi: Joko</span>
                                    <div class="text-dark mt-1 border-top border-dark border-opacity-50 pt-1">
                                        <span class="badge bg-light text-dark border border-dark px-2 py-1"><strong>Selesai:</strong> 04 Mei 2026</span>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="d-flex flex-column gap-1">
                                    <button class="btn btn-sm btn-outline-dark rounded-pill px-2 py-1" title="Lihat Detail Lengkap">
                                        <i class="fas fa-eye me-1"></i> Detail
                                    </button>
                                    <a href="#" class="btn btn-sm btn-danger rounded-pill px-2 py-1 shadow-sm text-white" title="Cetak Riwayat PDF Klien Ini">
                                        <i class="fas fa-print me-1"></i> Cetak PDF
                                    </a>
                                </div>
                            </td>
                        </tr>

                        <!-- Data 5 -->
                        <tr>
                            <td class="fw-bold text-center">5</td>
                            <td>
                                <div class="p-2 rounded bg-light border border-dark border-opacity-75 shadow-sm">
                                    <div class="fw-bold text-dark">Siti Rahmawati</div>
                                    <div class="text-secondary small mt-1 border-top border-dark border-opacity-50 pt-1">
                                        <span class="badge bg-white text-success border border-success px-2 py-1"><i class="fab fa-whatsapp me-1"></i> 08211223344</span>
                                    </div>
                                    <div class="text-muted small mt-1 bg-white p-1 rounded border border-dark border-opacity-50">Jl. Diponegoro No. 88</div>
                                </div>
                            </td>
                            <td>
                                <div class="p-2 rounded bg-light border border-dark border-opacity-75 shadow-sm">
                                    <span class="badge bg-info text-dark fw-bold px-2 py-1 mb-1 border border-info">
                                        <i class="fas fa-snowflake text-info me-1"></i> AC Split (Panasonic 1.5 PK)
                                    </span>
                                    <div><span class="badge bg-success text-white px-2 py-1 small fw-semibold"><i class="fas fa-check-circle me-1"></i> Garansi Valid</span></div>
                                </div>
                            </td>
                            <td>
                                <div class="p-2 rounded bg-white border border-dark border-opacity-75 shadow-sm text-dark small">
                                    <strong class="text-primary"><i class="fas fa-comment-alt me-1"></i> Keluhan:</strong><br>
                                    Servis berkala / perawatan rutin 3 bulanan.
                                    <div class="text-dark mt-1 border-top border-dark border-opacity-50 pt-1">
                                        <span class="badge bg-light text-dark border border-dark px-2 py-1"><strong>Reg:</strong> 10 Agu 2026</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="p-2 rounded bg-white border border-dark border-opacity-75 shadow-sm text-dark small">
                                    <strong class="text-success"><i class="fas fa-wrench me-1"></i> Closing:</strong><br>
                                    Cuci Rutin Berkala<br>
                                    <span class="text-muted">Teknisi: Budi</span>
                                    <div class="text-dark mt-1 border-top border-dark border-opacity-50 pt-1">
                                        <span class="badge bg-light text-dark border border-dark px-2 py-1"><strong>Selesai:</strong> 10 Agu 2026</span>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="d-flex flex-column gap-1">
                                    <button class="btn btn-sm btn-outline-dark rounded-pill px-2 py-1" title="Lihat Detail Lengkap">
                                        <i class="fas fa-eye me-1"></i> Detail
                                    </button>
                                    <a href="#" class="btn btn-sm btn-danger rounded-pill px-2 py-1 shadow-sm text-white" title="Cetak Riwayat PDF Klien Ini">
                                        <i class="fas fa-print me-1"></i> Cetak PDF
                                    </a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Tambahan CSS untuk Garis Tabel Super Tebal dan Jelas -->
<style>
    body, html {
        background-color: #060910 !important;
    }
    .super-thick-table th, 
    .super-thick-table td {
        border-width: 2.5px !important;
        border-color: #334155 !important;
    }
</style>
@endsection