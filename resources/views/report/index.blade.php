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
                <a href="{{ route('report.pdf', request()->all()) }}" target="_blank" class="btn btn-danger px-3 py-2 rounded-pill shadow-sm fw-bold d-flex align-items-center gap-2" style="font-size: 0.875rem;">
                    <i class="fas fa-file-pdf"></i> Cetak Laporan PDF (Global)
                </a>
                <!-- Tombol Rekap Excel -->
                <a href="{{ route('report.export-csv') }}" class="btn btn-success">
    <i class="fas fa-file-csv"></i> Rekap CSV (Excel)
</a>
            </div>
        </div>
    </div>

    <!-- ========================================================================= -->
    <!-- 1. 6 KARTU RINGKASAN STATISTIK -->
    <!-- ========================================================================= -->
    <div class="row g-3 mb-4">
        <!-- Kotak 1 -->
        <div class="col-xl-4 col-md-6">
            <div class="card rounded-4 text-dark shadow-sm h-100" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); border-left: 5px solid #0284c7 !important; border: 1px solid rgba(148, 163, 184, 0.5);">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-secondary small fw-bold text-uppercase mb-1">Total Unit Terdaftar</div>
                            <div class="fs-3 fw-bold mb-0 text-dark">{{ $totalKonsumen ?? 0 }} <span class="fs-6 fw-normal text-muted">Konsumen</span></div>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle text-primary">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kotak 2 -->
        <div class="col-xl-4 col-md-6">
            <div class="card rounded-4 text-dark shadow-sm h-100" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); border-left: 5px solid #059669 !important; border: 1px solid rgba(148, 163, 184, 0.5);">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-secondary small fw-bold text-uppercase mb-1">Closing Servis Bulan Ini</div>
                            <div class="fs-3 fw-bold mb-0 text-dark">{{ $closingBulanIni ?? 0 }} <span class="fs-6 fw-normal text-muted">Selesai</span></div>
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
            <div class="card rounded-4 text-dark shadow-sm h-100" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); border-left: 5px solid #0ea5e9 !important; border: 1px solid rgba(148, 163, 184, 0.5);">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-secondary small fw-bold text-uppercase mb-1">Unit Bergaransi Aktif</div>
                            <div class="fs-3 fw-bold mb-0 text-dark">{{ $garansiAktif ?? 0 }} <span class="fs-6 fw-normal text-muted">Valid</span></div>
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
            <div class="card rounded-4 text-dark shadow-sm h-100" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); border-left: 5px solid #d97706 !important; border: 1px solid rgba(148, 163, 184, 0.5);">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-secondary small fw-bold text-uppercase mb-1">Antrean Perawatan Berkala</div>
                            <div class="fs-3 fw-bold mb-0 text-dark">{{ $antreanPerawatan ?? 0 }} <span class="fs-6 fw-normal text-muted">Jadwal</span></div>
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
            <div class="card rounded-4 text-dark shadow-sm h-100" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); border-left: 5px solid #7c3aed !important; border: 1px solid rgba(148, 163, 184, 0.5);">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-secondary small fw-bold text-uppercase mb-1">Follow-Up WhatsApp (DM)</div>
                            <div class="fs-3 fw-bold mb-0 text-dark">{{ $followUpTerkirim ?? 0 }} <span class="fs-6 fw-normal text-muted">Terkirim</span></div>
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
            <div class="card rounded-4 text-dark shadow-sm h-100" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); border-left: 5px solid #475569 !important; border: 1px solid rgba(148, 163, 184, 0.5);">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-secondary small fw-bold text-uppercase mb-1">Total Unit Tahun {{ date('Y') }}</div>
                            <div class="fs-3 fw-bold mb-0 text-dark">{{ $totalUnitTahunIni ?? 0 }} <span class="fs-6 fw-normal text-muted">Unit</span></div>
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
    <!-- 2. CARD FILTER PERIODE -->
    <!-- ========================================================================= -->
    <div class="card rounded-4 mb-4 text-dark shadow-sm" style="background: linear-gradient(135deg, #f1f5f9 0%, #cbd5e1 100%); border: 1px solid rgba(36, 59, 85, 0.35) !important;">
        <div class="card-body p-4">
            <h5 class="fw-bold text-dark mb-3"><i class="fas fa-filter text-primary me-2"></i> Filter Periode, Unit & Kategori Laporan</h5>
            <form action="" method="GET">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label small fw-bold text-secondary">Pilih Tanggal (Harian)</label>
                        <input type="date" name="tanggal" class="form-control rounded-pill border-secondary shadow-sm text-dark" value="{{ request('tanggal') }}" style="background-color: #ffffff;">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold text-secondary">Pilih Bulan (Bulanan)</label>
                        <select name="bulan" class="form-select rounded-pill border-secondary shadow-sm text-dark" style="background-color: #ffffff;">
                            <option value="">Semua Bulan</option>
                            <option value="01" {{ request('bulan') == '01' ? 'selected' : '' }}>Januari</option>
                            <option value="02" {{ request('bulan') == '02' ? 'selected' : '' }}>Februari</option>
                            <option value="03" {{ request('bulan') == '03' ? 'selected' : '' }}>Maret</option>
                            <option value="04" {{ request('bulan') == '04' ? 'selected' : '' }}>April</option>
                            <option value="05" {{ request('bulan') == '05' ? 'selected' : '' }}>Mei</option>
                            <option value="06" {{ request('bulan') == '06' ? 'selected' : '' }}>Juni</option>
                            <option value="07" {{ request('bulan') == '07' ? 'selected' : '' }}>Juli</option>
                            <option value="08" {{ request('bulan') == '08' ? 'selected' : '' }}>Agustus</option>
                            <option value="09" {{ request('bulan') == '09' ? 'selected' : '' }}>September</option>
                            <option value="10" {{ request('bulan') == '10' ? 'selected' : '' }}>Oktober</option>
                            <option value="11" {{ request('bulan') == '11' ? 'selected' : '' }}>November</option>
                            <option value="12" {{ request('bulan') == '12' ? 'selected' : '' }}>Desember</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold text-secondary">Pilih Tahun (Tahunan)</label>
                        <select name="tahun" class="form-select rounded-pill border-secondary shadow-sm text-dark" style="background-color: #ffffff;">
                            <option value="2026" {{ request('tahun', date('Y')) == '2026' ? 'selected' : '' }}>2026</option>
                            <option value="2025" {{ request('tahun') == '2025' ? 'selected' : '' }}>2025</option>
                            <option value="2024" {{ request('tahun') == '2024' ? 'selected' : '' }}>2024</option>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-primary w-100 rounded-pill fw-semibold shadow-sm py-2" style="background-color: #2563eb; border-color: #2563eb;">
                            <i class="fas fa-search me-1"></i> Terapkan Filter
                        </button>
                        @if(request('tanggal') || request('bulan'))
                            <a href="{{ request()->url() }}" class="btn btn-outline-danger rounded-pill py-2" title="Reset Filter">
                                <i class="fas fa-times"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- ========================================================================= -->
    <!-- 3. TABEL KOMPREHENSIF DINAMIS DENGAN MODAL DETAIL LENGKAP -->
    <!-- ========================================================================= -->
    <div class="card rounded-4 mb-4 text-dark shadow-sm overflow-hidden" style="background: linear-gradient(135deg, #f1f5f9 0%, #cbd5e1 100%); border: 1px solid rgba(36, 59, 85, 0.35) !important;">
        <div class="card-header text-white border-0 pt-3 px-4 pb-3 d-flex justify-content-between align-items-center" style="background-color: #1e293b;">
            <h5 class="fw-bold m-0"><i class="fas fa-history text-info me-2"></i> Log Komprehensif: Registrasi, Unit, Tiket, Teknisi & Closing</h5>
            <span class="badge bg-primary rounded-pill px-3 py-2 text-white border border-info">Menampilkan Data Riwayat Konsumen</span>
        </div>
        
        <div class="card-body px-4 pb-4">
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle mb-0 bg-white shadow-sm rounded super-thick-table" width="100%" cellspacing="0">
                    <thead class="text-uppercase fs-7 text-white text-center" style="background-color: #1e293b;">
                        <tr>
                            <th class="py-3 text-white text-center" style="width: 5%;">No</th>
                            <th class="py-3 text-white text-center" style="width: 12%;">No Tiket / SPK</th>
                            <th class="py-3 text-white text-center" style="width: 18%;">Identitas Konsumen</th>
                            <th class="py-3 text-white text-center" style="width: 20%;">Master Unit & Model</th>
                            <th class="py-3 text-white text-center" style="width: 18%;">Keluhan & Tgl Reg</th>
                            <th class="py-3 text-white text-center" style="width: 17%;">Teknisi & Closing Transaksi</th>
                            <th class="py-3 text-white text-center" style="width: 10%;">Aksi & Cetak</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($riwayatServis as $index => $item)
                        <tr>
                            <!-- No -->
                            <td class="fw-bold text-center">{{ $riwayatServis->firstItem() + $index }}</td>
                            
                            <!-- No Tiket / SPK & Invoice -->
                            <td class="text-center">
                                <span class="badge bg-dark text-white px-2 py-1 fw-bold">{{ $item->no_tiket ?? 'SRV-...' }}</span><br>
                                <span class="text-muted small">Inv: {{ $item->no_invoice ?? 'Belum Closing' }}</span>
                            </td>

                            <!-- Identitas Konsumen -->
                            <td>
                                <div class="p-2 rounded bg-light border border-dark border-opacity-75 shadow-sm">
                                    <div class="fw-bold text-dark">{{ $item->nama ?? 'Tanpa Nama' }}</div>
                                    <div class="text-secondary small mt-1 border-top border-dark border-opacity-50 pt-1">
                                        <span class="badge bg-white text-success border border-success px-2 py-1"><i class="fab fa-whatsapp me-1"></i> {{ $item->no_whatsapp ?? '-' }}</span>
                                    </div>
                                    <div class="text-muted small mt-1">Alamat: {{ $item->alamat ?? '-' }}</div>
                                </div>
                            </td>
                            
                            <!-- Master Unit & Model / Tipe -->
                            <td>
                                <div class="p-2 rounded bg-light border border-dark border-opacity-75 shadow-sm">
                                    <span class="badge bg-info text-dark fw-bold px-2 py-1 mb-1 border border-info">
                                        <i class="fas fa-snowflake text-info me-1"></i> {{ $item->jenis_unit ?? 'Unit' }} ({{ $item->merek ?? '-' }})
                                    </span>
                                    <div class="small text-dark">Model/Tipe: <strong>{{ $item->model_tipe ?? '-' }}</strong></div>
                                    <div class="small text-muted">Masuk: {{ $item->tanggal_masuk ?? '-' }}</div>
                                    <div>
                                        @if(str_contains(strtolower($item->status_garansi ?? ''), 'aktif'))
                                            <span class="badge bg-success text-white px-2 py-1 small fw-semibold mt-1"><i class="fas fa-check-circle me-1"></i> Garansi Valid</span>
                                        @else
                                            <span class="badge bg-secondary text-white px-2 py-1 small fw-semibold mt-1"><i class="fas fa-times-circle me-1"></i> Non-Garansi</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            
                            <!-- Keluhan & Tanggal Registrasi -->
                            <td>
                                <div class="p-2 rounded bg-white border border-dark border-opacity-75 shadow-sm text-dark small">
                                    <strong class="text-primary"><i class="fas fa-comment-alt me-1"></i> Keluhan:</strong><br>
                                    {{ $item->keluhan ?? '-' }}
                                    <div class="text-dark mt-1 border-top border-dark border-opacity-50 pt-1">
                                        <span class="badge bg-light text-dark border border-dark px-2 py-1"><strong>Reg:</strong> {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d M Y') }}</span>
                                    </div>
                                </div>
                            </td>
                            
                            <!-- Teknisi & Closing Transaksi -->
                            <td>
                                <div class="p-2 rounded bg-white border border-dark border-opacity-75 shadow-sm text-dark small">
                                    <strong class="text-success"><i class="fas fa-wrench me-1"></i> Teknisi:</strong> {{ $item->nama_teknisi ?? 'Belum Ditugaskan' }}<br>
                                    <strong class="text-primary">Status:</strong> {{ $item->status ?? 'Proses' }}<br>
                                    @if(!empty($item->total_biaya))
                                        <span class="text-success fw-bold">Biaya: Rp {{ number_format($item->total_biaya, 0, ',', '.') }}</span><br>
                                        <span class="text-muted" style="font-size: 9px;">Metode: {{ $item->metode_pembayaran ?? '-' }}</span>
                                    @else
                                        <span class="text-muted" style="font-size: 9px;">Belum ada transaksi closing</span>
                                    @endif
                                </div>
                            </td>
                            
                            <!-- Aksi & Cetak (Dengan Modal Detail Pop-up) -->
                            <td class="text-center">
                                <div class="d-flex flex-column gap-1">
                                    <!-- Tombol Pemicu Modal Detail -->
                                    <button type="button" class="btn btn-sm btn-outline-dark rounded-pill px-2 py-1" data-bs-toggle="modal" data-bs-target="#detailModal{{ $item->id_servis ?? $index }}">
                                        <i class="fas fa-eye me-1"></i> Detail
                                    </button>
                                    <a href="{{ route('report.pdf', ['id_konsumen' => $item->id_konsumen]) }}" target="_blank" class="btn btn-sm btn-danger rounded-pill px-2 py-1 shadow-sm text-white" title="Cetak Riwayat PDF Klien Ini">
                                        <i class="fas fa-print me-1"></i> Cetak PDF
                                    </a>
                                </div>

                                <!-- Bootstrap Modal Pop-up Unik Lengkap -->
                                <div class="modal fade" id="detailModal{{ $item->id_servis ?? $index }}" tabindex="-1" aria-labelledby="detailModalLabel{{ $index }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content rounded-4 shadow-lg text-dark text-start" style="background: #f8fafc; border: 1px solid #cbd5e1;">
                                            <div class="modal-header bg-dark text-white rounded-top-4">
                                                <h5 class="modal-title fw-bold" id="detailModalLabel{{ $index }}">
                                                    <i class="fas fa-info-circle text-info me-2"></i> Detail Komprehensif Servis & Transaksi — {{ $item->nama ?? 'Konsumen' }}
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body p-4">
                                                <div class="row g-3">
                                                    <!-- Data Konsumen -->
                                                    <div class="col-md-6">
                                                        <div class="p-3 bg-white rounded-3 border shadow-sm h-100">
                                                            <h6 class="fw-bold text-primary border-bottom pb-2 mb-2"><i class="fas fa-user me-1"></i> Data Konsumen</h6>
                                                            <p class="mb-1"><strong>ID Konsumen:</strong> #{{ $item->id_konsumen ?? '-' }}</p>
                                                            <p class="mb-1"><strong>Nama:</strong> {{ $item->nama ?? '-' }}</p>
                                                            <p class="mb-1"><strong>WhatsApp:</strong> {{ $item->no_whatsapp ?? '-' }}</p>
                                                            <p class="mb-0"><strong>Alamat:</strong> {{ $item->alamat ?? '-' }}</p>
                                                        </div>
                                                    </div>
                                                 <!-- Spesifikasi Master Unit -->
<div class="col-md-6">
    <div class="p-3 bg-white rounded-3 border shadow-sm h-100">
        <h6 class="fw-bold text-success border-bottom pb-2 mb-2"><i class="fas fa-snowflake me-1"></i> Master Unit & Garansi</h6>
        <p class="mb-1"><strong>Jenis Unit:</strong> {{ $item->jenis_unit ?? '-' }}</p>
        <p class="mb-1"><strong>Merek:</strong> {{ $item->merek ?? '-' }}</p>
        <!-- UBAH DI SINI DARI model_tipe MENJADI tipe_model -->
        <p class="mb-1"><strong>Model / Tipe:</strong> {{ $item->tipe_model ?? '-' }}</p>
        <p class="mb-1"><strong>Tanggal Masuk:</strong> {{ $item->tanggal_masuk ?? '-' }}</p>
        <p class="mb-0"><strong>Status Garansi:</strong> <span class="badge bg-success">{{ $item->status_garansi ?? 'Valid' }}</span></p>
    </div>
</div>
                                                    <!-- Kronologi, Teknisi & Closing -->
                                                    <div class="col-12">
                                                        <div class="p-3 bg-white rounded-3 border shadow-sm">
                                                            <h6 class="fw-bold text-dark border-bottom pb-2 mb-2"><i class="fas fa-clipboard-list me-1"></i> Tiket, Teknisi & Closing Transaksi</h6>
                                                            <p class="mb-1"><strong>No Tiket / SPK:</strong> <span class="badge bg-dark text-white">{{ $item->no_tiket ?? '-' }}</span></p>
                                                            <p class="mb-1"><strong>Keluhan Utama:</strong><br><span class="text-muted bg-light p-2 d-block rounded mt-1">{{ $item->keluhan ?? 'Tidak ada catatan keluhan.' }}</span></p>
                                                            <hr class="my-2">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <p class="mb-1"><strong>Teknisi Bertugas:</strong> <span class="text-dark fw-bold">{{ $item->nama_teknisi ?? 'Belum ditugaskan' }}</span></p>
                                                                    <p class="mb-1"><strong>Status Servis:</strong> <span class="badge bg-primary">{{ $item->status ?? 'Proses' }}</span></p>
                                                                    <p class="mb-0"><strong>Tanggal Registrasi:</strong> {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y, H:i') }}</p>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <p class="mb-1"><strong>Nomor Invoice:</strong> {{ $item->no_invoice ?? 'Belum ada invoice' }}</p>
                                                                    <p class="mb-1"><strong>Total Biaya:</strong> <span class="text-success fw-bold">{{ !empty($item->total_biaya) ? 'Rp ' . number_format($item->total_biaya, 0, ',', '.') : '-' }}</span></p>
                                                                    <p class="mb-1"><strong>Metode Pembayaran:</strong> {{ $item->metode_pembayaran ?? '-' }}</p>
                                                                    <p class="mb-0"><strong>Jadwal Next Perawatan:</strong> {{ !empty($item->tanggal_jatuh_tempo) ? \Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->translatedFormat('d F Y') : '-' }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer bg-light rounded-bottom-4">
                                                <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                <i class="fas fa-folder-open fs-3 mb-2 opacity-50"></i><br>
                                Tidak ada data riwayat servis yang ditemukan pada database atau filter tersebut.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="mt-3">
                {{ $riwayatServis->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Tambahan CSS -->
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