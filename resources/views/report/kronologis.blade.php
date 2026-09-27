@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 pt-3 pb-4" style="background: linear-gradient(135deg, #eef1f3 0%, #eef1f3 100%); min-height: 100vh; color: #f8fafc;">
    
    <!-- HEADER TITLE & TOMBOL AKSI (DIBUNGKUS DALAM CARD GELAP ELEGAN) -->
    <div class="card rounded-4 mb-4 text-white shadow-lg overflow-hidden" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); border: 1px solid rgba(56, 189, 248, 0.35) !important;">
        <div class="card-body p-4 d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item text-light opacity-75 small">Laporan Sistem</li>
                        <li class="breadcrumb-item text-info small active fw-bold" aria-current="page">Log Kronologis</li>
                    </ol>
                </nav>
                <h2 class="text-white fw-bold mb-1"><i class="fas fa-history text-primary me-2"></i> Log Kronologis Aktivitas & Servis</h2>
                <p class="text-light opacity-75 small mb-0">Rekapitulasi jejak waktu seluruh tahapan servis, registrasi, hingga closing teknisi</p>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <!-- Tombol Tambah Log Manual oleh Admin -->
                <button class="btn btn-primary px-3 py-2 rounded-pill shadow-sm fw-bold d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#modalTambahLog" style="font-size: 0.875rem;">
                    <i class="fas fa-plus-circle"></i> Tambah Log Baru
                </button>
                <a href="{{ route('report.export.pdf') }}" class="btn btn-danger px-3 py-2 rounded-pill shadow-sm fw-bold d-flex align-items-center gap-2" style="font-size: 0.875rem;">
                    <i class="fas fa-file-pdf"></i> Cetak Log PDF
                </a>
                <a href="{{ route('report.export.excel') }}" class="btn btn-success px-3 py-2 rounded-pill shadow-sm fw-bold d-flex align-items-center gap-2" style="font-size: 0.875rem;">
                    <i class="fas fa-file-excel"></i> Export Excel
                </a>
            </div>
        </div>
    </div>

    <!-- ========================================================================= -->
    <!-- TIMELINE INFOGRAPHIC -->
    <!-- ========================================================================= -->
    <div class="card rounded-4 mb-4 text-dark shadow-lg overflow-hidden" style="background: linear-gradient(135deg, #f1f5f9 0%, #cbd5e1 100%); border: 1px solid rgba(36, 59, 85, 0.35) !important;">
        <div class="card-header bg-dark text-white border-0 pt-3 px-4 pb-3 text-center" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);">
            <h5 class="fw-bold text-white mb-1"><i class="fas fa-stream text-info me-2"></i> TIMELINE DIAGRAM INFOGRAPHIC</h5>
            <p class="text-light opacity-75 small mb-0">Alur Siklus Layanan Servis Harian Jawaratech</p>
        </div>
        
        <div class="card-body px-4 py-5 position-relative">
            
            <!-- GARIS PUSAT (CENTER LINE) -->
            <div class="d-none d-lg-block position-absolute start-0 w-100" style="top: 52%; height: 6px; background: rgba(30, 41, 59, 0.2); z-index: 1;"></div>

            <div class="row text-center position-relative" style="z-index: 2;">
                
                <!-- 1. TAHAP ATAS: REGISTRASI -->
                <div class="col-lg-3 col-md-6 mb-5 mb-lg-0">
                    <div class="d-flex flex-column align-items-center">
                        <div class="mb-3 px-2">
                            <span class="badge text-white fw-bold px-3 py-1 mb-2 rounded-pill shadow-sm" style="background-color: #d97706;">1. KELOMPOK MASUK</span>
                            <h6 class="fw-bold text-dark mb-1">Registrasi Unit</h6>
                            <p class="text-secondary small px-2 mb-0">Pencatatan data konsumen, jenis perangkat, dan keluhan awal.</p>
                        </div>
                        <div class="timeline-node shadow-lg d-flex align-items-center justify-content-center text-dark fw-bold bg-white" style="width: 80px; height: 80px; border-radius: 50%; border: 4px solid #d97706; animation: pulseGlow 2s infinite;">
                            <i class="fas fa-user-plus fa-2x text-warning"></i>
                        </div>
                        <div class="mt-2 text-dark fw-bold small">14 Unit</div>
                    </div>
                </div>

                <!-- 2. TAHAP BAWAH: PENGECEKAN -->
                <div class="col-lg-3 col-md-6 mb-5 mb-lg-0 pt-lg-5">
                    <div class="d-flex flex-column align-items-center">
                        <div class="mb-2 text-dark fw-bold small">8 Proses</div>
                        <div class="timeline-node shadow-lg d-flex align-items-center justify-content-center text-dark fw-bold mb-3 bg-white" style="width: 80px; height: 80px; border-radius: 50%; border: 4px solid #059669; animation: pulseGlow 2s infinite;">
                            <i class="fas fa-tools fa-2x text-success"></i>
                        </div>
                        <div class="px-2">
                            <span class="badge bg-success text-white fw-bold px-3 py-1 mb-2 rounded-pill shadow-sm">2. DIAGNOSIS</span>
                            <h6 class="fw-bold text-dark mb-1">Pengecekan Teknisi</h6>
                            <p class="text-secondary small px-2 mb-0">Pembongkaran unit dan pengecekan komponen yang bermasalah.</p>
                        </div>
                    </div>
                </div>

                <!-- 3. TAHAP ATAS: PERBAIKAN -->
                <div class="col-lg-3 col-md-6 mb-5 mb-md-0">
                    <div class="d-flex flex-column align-items-center">
                        <div class="mb-3 px-2">
                            <span class="badge text-white fw-bold px-3 py-1 mb-2 rounded-pill shadow-sm" style="background-color: #0284c7;">3. TINDAKAN</span>
                            <h6 class="fw-bold text-dark mb-1">Perbaikan & QC</h6>
                            <p class="text-secondary small px-2 mb-0">Penggantian sparepart, pencucian, dan pengujian kualitas.</p>
                        </div>
                        <div class="timeline-node shadow-lg d-flex align-items-center justify-content-center text-dark fw-bold bg-white" style="width: 80px; height: 80px; border-radius: 50%; border: 4px solid #0284c7; animation: pulseGlow 2s infinite;">
                            <i class="fas fa-wrench fa-2x text-info"></i>
                        </div>
                        <div class="mt-2 text-dark fw-bold small">6 Unit</div>
                    </div>
                </div>

                <!-- 4. TAHAP BAWAH: SUCCESS / CLOSING -->
                <div class="col-lg-3 col-md-6 pt-lg-5">
                    <div class="d-flex flex-column align-items-center">
                        <div class="mb-2 text-dark fw-bold small">10 Nota Selesai</div>
                        <div class="timeline-node shadow-lg d-flex align-items-center justify-content-center text-dark fw-bold mb-3 bg-white" style="width: 80px; height: 80px; border-radius: 50%; border: 4px solid #7c3aed; animation: pulseGlow 2s infinite;">
                            <i class="fas fa-check-circle fa-2x text-purple" style="color: #7c3aed;"></i>
                        </div>
                        <div class="px-2">
                            <span class="badge text-white fw-bold px-3 py-1 mb-2 rounded-pill shadow-sm" style="background-color: #7c3aed;">4. SUCCESS</span>
                            <h6 class="fw-bold text-dark mb-1">Closing & Nota PDF</h6>
                            <p class="text-secondary small px-2 mb-0">Penyerahan unit kepada konsumen dan pencetakan nota garansi.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- FILTER PENCARIAN -->
    <div class="card rounded-4 mb-4 text-dark shadow-sm" style="background: linear-gradient(135deg, #f1f5f9 0%, #cbd5e1 100%); border: 1px solid rgba(36, 59, 85, 0.35) !important;">
        <div class="card-body p-4">
            <h5 class="fw-bold text-dark mb-3"><i class="fas fa-filter text-primary me-2"></i> Filter & Pencarian Log Kronologis</h5>
            <form action="{{ route('report.kronologis') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label small fw-bold text-secondary">Cari Konsumen / Teknisi</label>
                        <input type="text" name="keyword" class="form-control rounded-pill border-secondary shadow-sm text-dark bg-white" placeholder="Ketik nama...">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold text-secondary">Status Tahapan</label>
                        <select name="status" class="form-select rounded-pill border-secondary shadow-sm text-dark bg-white">
                            <option value="">Semua Status Log</option>
                            <option value="registrasi">Registrasi Masuk</option>
                            <option value="proses">Proses Pengerjaan</option>
                            <option value="closing">Closing Selesai</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold text-secondary">Bulan Kronologis</label>
                        <select name="bulan" class="form-select rounded-pill border-secondary shadow-sm text-dark bg-white">
                            <option value="09" selected>September 2026</option>
                            <option value="08">Agustus 2026</option>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-dark w-100 rounded-pill fw-semibold shadow py-2">
                            <i class="fas fa-search me-1"></i> Filter Log
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- TABEL UTAMA LOG KRONOLOGIS DENGAN TOMBOL AKSI LENGKAP -->
    <div class="card rounded-4 mb-4 text-dark shadow-sm overflow-hidden" style="background: linear-gradient(135deg, #f1f5f9 0%, #cbd5e1 100%); border: 1px solid rgba(36, 59, 85, 0.35) !important;">
        <div class="card-header text-white border-0 pt-3 px-4 pb-3 d-flex justify-content-between align-items-center shadow-sm" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); border-bottom: 2px solid rgba(56, 189, 248, 0.4) !important;">
            <div class="d-flex align-items-center gap-2">
                <div class="p-2 rounded-circle bg-primary bg-opacity-25 text-info">
                    <i class="fas fa-history fa-lg"></i>
                </div>
                <div>
                    <h5 class="fw-bold m-0 text-white">Tabel Detail Log Kronologis Servis</h5>
                    <small class="text-light opacity-75">Catatan lengkap urutan kejadian dari awal masuk hingga penyerahan unit</small>
                </div>
            </div>
            <span class="badge bg-primary bg-opacity-75 border border-info rounded-pill px-3 py-2 text-white shadow-sm">
                <i class="fas fa-database me-1"></i> Total 3 Log Terbaru Ditampilkan
            </span>
        </div>

        <div class="card-body px-4 pb-4">
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle mb-0 bg-white shadow-sm rounded super-thick-table" width="100%" cellspacing="0">
                    <thead class="text-uppercase fs-7 text-white text-center" style="background-color: #1e293b;">
                        <tr>
                            <th class="py-3 text-white" style="width: 5%;">No</th>
                            <th class="py-3 text-white text-start" style="width: 18%;">Waktu & Status Log</th>
                            <th class="py-3 text-white text-start" style="width: 20%;">Identitas Konsumen</th>
                            <th class="py-3 text-white text-start" style="width: 27%;">Kronologi / Deskripsi Aktivitas</th>
                            <th class="py-3 text-white text-start" style="width: 15%;">Petugas / Teknisi</th>
                            <th class="py-3 text-white text-center" style="width: 15%;">Aksi (Edit/Hapus)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="fw-bold text-center">1</td>
                            <td>
                                <div class="p-2 rounded bg-light border border-dark border-opacity-75 shadow-sm small">
                                    <span class="badge bg-success text-white mb-1"><i class="fas fa-check-circle me-1"></i> Closing Selesai</span>
                                    <div><strong>26 Sep 2026</strong>, 14:30 WIB</div>
                                </div>
                            </td>
                            <td>
                                <div class="p-2 rounded bg-light border border-dark border-opacity-75 shadow-sm">
                                    <div class="fw-bold text-dark"><i class="fas fa-venus text-danger me-1"></i> Siti Aminah</div>
                                    <div class="text-muted small"><i class="fab fa-whatsapp text-success me-1"></i> 08123456789</div>
                                </div>
                            </td>
                            <td>
                                <div class="p-2 rounded bg-white border border-dark border-opacity-75 shadow-sm text-dark small">
                                    <strong class="text-success">Closing Servis:</strong> Penggantian kapasitor unit AC Sharp 1 PK selesai dilakukan dan unit kembali normal.
                                </div>
                            </td>
                            <td>
                                <div class="p-2 rounded bg-white border border-dark border-opacity-75 shadow-sm text-dark small">
                                    <i class="fas fa-user-shield text-primary me-1"></i> <strong>Teknisi:</strong> Budi
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <button class="btn btn-sm btn-outline-primary rounded-pill px-2 py-1" title="Edit Log">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger rounded-pill px-2 py-1" title="Hapus Log">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td class="fw-bold text-center">2</td>
                            <td>
                                <div class="p-2 rounded bg-light border border-dark border-opacity-75 shadow-sm small">
                                    <span class="badge bg-warning text-dark mb-1"><i class="fas fa-tools me-1"></i> Pengerjaan</span>
                                    <div><strong>25 Sep 2026</strong>, 10:15 WIB</div>
                                </div>
                            </td>
                            <td>
                                <div class="p-2 rounded bg-light border border-dark border-opacity-75 shadow-sm">
                                    <div class="fw-bold text-dark"><i class="fas fa-mars text-primary me-1"></i> Budi Santoso</div>
                                    <div class="text-muted small"><i class="fab fa-whatsapp text-success me-1"></i> 08987654321</div>
                                </div>
                            </td>
                            <td>
                                <div class="p-2 rounded bg-white border border-dark border-opacity-75 shadow-sm text-dark small">
                                    <strong class="text-warning">Pengecekan Unit:</strong> Pembongkaran dispenser Miyako untuk mendiagnosis elemen pemanas yang konslet.
                                </div>
                            </td>
                            <td>
                                <div class="p-2 rounded bg-white border border-dark border-opacity-75 shadow-sm text-dark small">
                                    <i class="fas fa-user-shield text-primary me-1"></i> <strong>Teknisi:</strong> Joko
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <button class="btn btn-sm btn-outline-primary rounded-pill px-2 py-1" title="Edit Log">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger rounded-pill px-2 py-1" title="Hapus Log">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- ========================================================================= -->
<!-- MODAL TAMBAH LOG BARU (INPUTAN FORM MANUAL) -->
<!-- ========================================================================= -->
<div class="modal fade" id="modalTambahLog" tabindex="-1" aria-labelledby="modalTambahLogLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 shadow-lg text-dark" style="background: #f8fafc; border: 2px solid #334155;">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title fw-bold" id="modalTambahLogLabel"><i class="fas fa-plus-circle text-info me-2"></i> Tambah Log Kronologis Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">Nama Konsumen</label>
                        <input type="text" name="nama_konsumen" class="form-control rounded-pill border-secondary bg-white" placeholder="Contoh: Siti Aminah" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">Tahapan Status Log</label>
                        <select name="status_log" class="form-select rounded-pill border-secondary bg-white" required>
                            <option value="registrasi">1. Registrasi Masuk</option>
                            <option value="proses">2. Pengecekan / Pengerjaan</option>
                            <option value="qc">3. Perbaikan & QC</option>
                            <option value="closing">4. Closing Selesai</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">Nama Teknisi / Petugas</label>
                        <input type="text" name="teknisi" class="form-control rounded-pill border-secondary bg-white" placeholder="Contoh: Budi" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">Deskripsi / Kronologi Aktivitas</label>
                        <textarea name="deskripsi" class="form-control rounded-4 border-secondary bg-white" rows="3" placeholder="Tuliskan detail kronologi servis..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light px-4 py-3">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">Simpan Log</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    body, html {
        background-color: #060910 !important;
    }
    .super-thick-table th, 
    .super-thick-table td {
        border-width: 2.5px !important;
        border-color: #334155 !important;
    }
    .timeline-node {
        transition: all 0.3s ease;
    }
    .timeline-node:hover {
        transform: scale(1.1);
        box-shadow: 0 0 25px rgba(2, 132, 199, 0.6) !important;
    }
    @keyframes pulseGlow {
        0% { box-shadow: 0 0 0 0 rgba(56, 189, 248, 0.4); }
        70% { box-shadow: 0 0 0 12px rgba(56, 189, 248, 0); }
        100% { box-shadow: 0 0 0 0 rgba(56, 189, 248, 0); }
    }
</style>
@endsection