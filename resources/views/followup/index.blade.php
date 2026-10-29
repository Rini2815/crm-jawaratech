@extends('layouts.app')

@section('content')
<!-- Import Font 'Inter' & Custom CSS Jawaratech CRM -->
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
    background-color: #1e293b; /* Slate/Navy khas Jawaratech */
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

/* Custom Badge Status Follow-Up */
.badge-followup-pending { background-color: #fef3c7; color: #b45309; border: 1px solid #fde68a; }
.badge-followup-done { background-color: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
.badge-followup-rescheduled { background-color: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; }
.badge-followup-noresponse { background-color: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }

/* Custom Badge Kategori */
.badge-kategori-happycall { background-color: #f3e8ff; color: #7e22ce; border: 1px solid #e9d5ff; }
.badge-kategori-rutin { background-color: #ffedd5; color: #c2410c; border: 1px solid #fed7aa; }

/* Custom Lebar Modal Spesifik (800px) */
.modal-custom-size {
    max-width: 800px !important;
    width: 90%;
}

.stat-card {
    transition: transform 0.2s ease;
}
.stat-card:hover {
    transform: translateY(-2px);
}
.super-thick-table th, 
.super-thick-table td {
    border-width: 2px !important;
    border-color: #cbd5e1 !important;
}

/* Tombol silang notifikasi: di ujung kanan, tanpa kotak */
.alert-dismissible {
    position: relative;
    padding-right: 3.5rem !important;
}
.alert-close {
    position: absolute;
    top: 50%;
    right: 16px;
    transform: translateY(-50%);
    background: transparent !important;
    border: none !important;
    box-shadow: none !important;
    outline: none !important;
    padding: 0;
    font-size: 1.5rem;
    font-weight: 700;
    line-height: 1;
    cursor: pointer;
    opacity: 0.7;
}
.alert-close:hover { opacity: 1; }
.alert-close.alert-close-top { top: 12px; transform: none; }
.alert-success .alert-close { color: #166534; }
.alert-danger .alert-close { color: #991b1b; }
</style>

<div class="container-fluid px-4 pt-3 pb-4" style="background: linear-gradient(135deg, #eef1f3 0%, #eef1f3 100%); min-height: 100vh; color: #f8fafc;">

    <!-- 1. BANNER HEADER UTAMA -->
    <div class="card rounded-4 mb-4 text-white shadow-lg overflow-hidden" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); border: 1px solid rgba(56, 189, 248, 0.35) !important;">
        <div class="card-body p-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h2 class="text-white fw-bold mb-1" style="font-weight: 700;">
                    <i class="fas fa-comments text-primary me-2"></i> Follow-up WhatsApp Konsumen
                </h2>
                <p class="text-light opacity-75 small mb-0" style="font-weight: 500;">
                    Modul pencatatan hasil Happy Call dan konfirmasi purna servis via WhatsApp
                </p>
            </div>
        </div>
    </div>

    <!-- Alert Notifikasi -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4 border-0 shadow-sm rounded-3" role="alert" style="background-color: #dcfce7; color: #166534;">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="alert-close" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4 border-0 shadow-sm rounded-3" role="alert" style="background-color: #fee2e2; color: #991b1b;">
            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
            <button type="button" class="alert-close" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mb-4 border-0 shadow-sm rounded-3" role="alert" style="background-color: #fee2e2; color: #991b1b;">
            <i class="fas fa-exclamation-triangle me-2"></i> <strong>Gagal Menyimpan!</strong> Periksa kembali isian Anda:
            <ul class="mb-0 mt-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="alert-close alert-close-top" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
    @endif

    <!-- 2. RINGKASAN KARTU STATISTIK -->
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card crm-card stat-card p-3 h-100" style="border-left: 5px solid #2563eb !important; background: #ffffff !important;">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-uppercase text-secondary fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">Total Agenda</div>
                        <div class="h4 mb-0 fw-bold text-dark mt-1" style="font-weight: 700;">{{ $totalAgenda }}</div>
                    </div>
                    <div class="p-3 bg-primary bg-opacity-10 rounded-circle text-primary" style="background-color: rgba(37, 99, 235, 0.15); color: #2563eb;">
                        <i class="fas fa-calendar-alt fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card crm-card stat-card p-3 h-100" style="border-left: 5px solid #d97706 !important; background: #ffffff !important;">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-uppercase text-secondary fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">Belum Dihubungi</div>
                        <div class="h4 mb-0 fw-bold text-dark mt-1" style="font-weight: 700;">{{ $belumDihubungi }}</div>
                    </div>
                    <div class="p-3 rounded-circle" style="background-color: rgba(217, 119, 6, 0.15); color: #d97706;">
                        <i class="fas fa-clock fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card crm-card stat-card p-3 h-100" style="border-left: 5px solid #16a34a !important; background: #ffffff !important;">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-uppercase text-secondary fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">Selesai Dihubungi</div>
                        <div class="h4 mb-0 fw-bold text-dark mt-1" style="font-weight: 700;">{{ $sudahDihubungi }}</div>
                    </div>
                    <div class="p-3 rounded-circle" style="background-color: rgba(22, 163, 74, 0.15); color: #16a34a;">
                        <i class="fas fa-check-circle fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card crm-card stat-card p-3 h-100" style="border-left: 5px solid #0284c7 !important; background: #ffffff !important;">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-uppercase text-secondary fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">Jadwal Ulang</div>
                        <div class="h4 mb-0 fw-bold text-dark mt-1" style="font-weight: 700;">{{ $jadwalUlang }}</div>
                    </div>
                    <div class="p-3 rounded-circle" style="background-color: rgba(2, 132, 199, 0.15); color: #0284c7;">
                        <i class="fas fa-sync-alt fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. CARD UTAMA TABEL DATA FOLLOW-UP -->
    <div class="card crm-card overflow-hidden mb-4" style="background: #ffffff !important;">
        
        <!-- HEADER CARD KE-2 (BACKGROUND PUTIH & TANPA ICON) -->
        <div class="card-header bg-white border-bottom pt-4 px-4 pb-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h5 class="m-0 text-dark fw-bold">Daftar Antrean Follow-up Konsumen</h5>
                <small class="text-muted">Kelola komunikasi dan pemantauan kepuasan pelanggan secara berkala</small>
            </div>

            <!-- Search Bar Real-time (Frontend JS) -->
            <div class="position-relative" style="min-width: 280px;">
                <input type="text" id="searchInput" class="form-control form-control-sm ps-5 pe-3 py-2 bg-white text-dark" placeholder="Cari nama konsumen, jenis unit..." style="border-radius: 20px; border: 1px solid #cbd5e1; font-size: 0.875rem;">
                <i class="fas fa-search position-absolute text-secondary" style="left: 15px; top: 50%; transform: translateY(-50%); font-size: 0.85rem;"></i>
            </div>
        </div>

        <div class="card-body px-4 pb-4 bg-white">
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle mb-0 super-thick-table">
                    <!-- HEADER TABEL RATA TENGAH SEMUA -->
                    <thead class="crm-table-header text-uppercase text-center fs-7">
                        <tr>
                            <th class="py-3 text-white text-center" style="width: 5%;">NO</th>
                            <th class="py-3 text-white text-center" style="width: 20%;">KONSUMEN & WA</th>
                            <th class="py-3 text-white text-center" style="width: 20%;">UNIT & LAYANAN</th>
                            <th class="py-3 text-white text-center" style="width: 18%;">KATEGORI & TANGGAL</th>
                            <th class="py-3 text-white text-center" style="width: 12%;">STATUS</th>
                            <th class="py-3 text-white text-center" style="width: 15%;">CATATAN HASIL</th>
                            <th class="py-3 text-white text-center" style="width: 10%;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody id="followupTableBody" style="font-weight: 500;">
                        @forelse($agenda as $f)
                        @php
                            $badgeKat = 'badge-kategori-happycall';
                            $labelKat = 'Happy Call (H+3)';
                            $badgeStatus = [
                                'Belum Dihubungi'    => 'badge-followup-pending',
                                'Sudah Dihubungi'    => 'badge-followup-done',
                                'Perlu Jadwal Ulang' => 'badge-followup-rescheduled',
                            ][$f->status] ?? 'badge-followup-pending';
                        @endphp
                        <tr>
                            <td class="px-4 py-3 text-secondary text-center fw-bold">{{ $loop->iteration }}</td>
                            <td class="py-3">
                                <div class="text-dark fw-bold">{{ $f->nama_konsumen }}</div>
                                <div class="text-secondary small">
                                    <span class="badge bg-light text-success border border-success px-2 py-1 mt-1"><i class="fab fa-whatsapp me-1"></i> {{ $f->no_wa }}</span>
                                </div>
                            </td>
                            <td class="py-3">
                                <div class="text-dark fw-bold small">{{ $f->label_unit }}</div>
                                <div class="text-muted small">{{ $f->layanan }}</div>
                            </td>
                            <td class="py-3">
                                <span class="badge crm-badge {{ $badgeKat }} mb-1">{{ $labelKat }}</span>
                                <div class="text-secondary small"><i class="far fa-calendar text-muted me-1"></i> {{ $f->tanggal_jadwal->translatedFormat('j M Y') }}</div>
                                @if($f->status === 'Perlu Jadwal Ulang' && $f->tanggal_jadwal_ulang)
                                    <div class="text-primary small"><i class="fas fa-sync-alt me-1"></i> Ulang: {{ $f->tanggal_jadwal_ulang->translatedFormat('j M Y') }}</div>
                                @endif
                            </td>
                            <td class="py-3 text-center">
                                <span class="badge crm-badge {{ $badgeStatus }}">
                                    {{ $f->status }}
                                </span>
                            </td>
                            <td class="py-3 text-secondary small" style="max-width: 220px;">
                                {{ $f->catatan_hasil ?: '-' }}
                            </td>
                            <td class="py-3 text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <!-- Direct WhatsApp Link Button -->
                                    <a href="{{ $f->wa_link }}" target="_blank" class="btn btn-sm btn-success rounded-pill px-2 py-1 shadow-sm text-white" title="Kirim WA Langsung" style="font-weight: 600;">
                                        <i class="fab fa-whatsapp me-1"></i> Chat
                                    </a>
                                    <!-- Modal Trigger Edit Status / Catat Response -->
                                    <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-2 py-1 shadow-sm" title="Update Status Follow-up" data-toggle="modal" data-bs-toggle="modal" data-target="#modalUpdateFollowup{{ $f->id_follow_up }}" data-bs-target="#modalUpdateFollowup{{ $f->id_follow_up }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">Belum ada agenda follow-up. Agenda Happy Call muncul otomatis setelah tiket di-closing.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Update Hasil Follow-up (EDIT), satu per agenda, di luar container -->
@foreach($agenda as $f)
@php
    $pakaiOld     = (string) old('_id') === (string) $f->id_follow_up;
    $nilaiStatus  = $pakaiOld ? old('status') : $f->status;
    $nilaiUlang   = $pakaiOld ? old('tanggal_jadwal_ulang') : optional($f->tanggal_jadwal_ulang)->format('Y-m-d');
    $nilaiCatatan = $pakaiOld ? old('catatan') : $f->catatan_hasil;
    $labelKatModal = 'Happy Call (H+3)';
@endphp
<div class="modal fade crm-wrapper" id="modalUpdateFollowup{{ $f->id_follow_up }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-custom-size modal-dialog-centered">
        <div class="modal-content rounded-4 shadow-lg text-dark overflow-hidden" style="background: #f8fafc; border: 1px solid #cbd5e1;">
            <!-- HEADER MODAL EDIT DENGAN NIKMAT GRADIENT BIRU/NAVY -->
            <div class="modal-header text-white px-4 py-3" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); border-bottom: 2px solid rgba(56, 189, 248, 0.4);">
                <h5 class="modal-title fw-bold" style="font-size: 1.15rem;">
                    <i class="fas fa-user-check text-primary me-2"></i>Update Respon & Status Follow-up
                </h5>
                <button type="button" class="btn-close btn-close-white" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('followup.update', $f->id_follow_up) }}" method="POST" autocomplete="off">
                @csrf
                @method('PUT')
                <input type="hidden" name="_id" value="{{ $f->id_follow_up }}">
                <div class="modal-body p-4">
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="form-label text-dark small fw-bold">Pelanggan</label>
                            <input type="text" class="form-control py-2 rounded-pill bg-white border-secondary" value="{{ $f->nama_konsumen }} ({{ $f->no_wa }})" readonly style="background-color: #f1f5f9 !important; cursor: not-allowed;">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-dark small fw-bold">Unit & Layanan</label>
                            <input type="text" class="form-control py-2 rounded-pill bg-white border-secondary" value="{{ $f->label_unit }}" readonly style="background-color: #f1f5f9 !important; cursor: not-allowed;">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="form-label text-dark small fw-bold">Status Follow-up</label>
                            <select name="status" class="form-select py-2 rounded-pill bg-white border-secondary select-status-fu" data-wrap="wrapUlang{{ $f->id_follow_up }}" required>
                                <option value="Belum Dihubungi" {{ $nilaiStatus == 'Belum Dihubungi' ? 'selected' : '' }}>Belum Dihubungi</option>
                                <option value="Sudah Dihubungi" {{ $nilaiStatus == 'Sudah Dihubungi' ? 'selected' : '' }}>Sudah Dihubungi (Selesai)</option>
                                <option value="Perlu Jadwal Ulang" {{ $nilaiStatus == 'Perlu Jadwal Ulang' ? 'selected' : '' }}>Perlu Jadwal Ulang</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-dark small fw-bold">Kategori Follow-up</label>
                            <input type="text" class="form-control py-2 rounded-pill bg-white border-secondary" value="{{ $labelKatModal }}" readonly style="background-color: #f1f5f9 !important;">
                        </div>
                    </div>

                    <!-- Tampil hanya jika status = Perlu Jadwal Ulang -->
                    <div class="row mb-3" id="wrapUlang{{ $f->id_follow_up }}" style="display: none;">
                        <div class="col-md-6">
                            <label class="form-label text-dark small fw-bold">Tanggal Jadwal Ulang <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_jadwal_ulang" class="form-control py-2 rounded-pill bg-white border-secondary" value="{{ $nilaiUlang }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-dark small fw-bold">Draft Pesan WhatsApp</label>
                        <textarea id="draft{{ $f->id_follow_up }}" class="form-control rounded-4 bg-white border-secondary" rows="3" style="font-size: 0.875rem;">{{ $f->draft_wa }}</textarea>
                        <button type="button" class="btn btn-sm btn-success rounded-pill px-3 mt-2 fw-semibold btn-wa-draft" data-draft="draft{{ $f->id_follow_up }}" data-nomor="{{ $f->wa_nomor }}">
                            <i class="fab fa-whatsapp me-1"></i> Buka WhatsApp dengan Draft Ini
                        </button>
                    </div>

                    <div class="mb-2">
                        <label class="form-label text-dark small fw-bold">Catatan / Hasil Konsultasi Pelanggan</label>
                        <textarea name="catatan" class="form-control rounded-4 bg-white border-secondary" rows="3" placeholder="Masukkan respons konsumen, keluhan tambahan, atau kesepakatan re-servis..." style="font-size: 0.875rem;">{{ $nilaiCatatan }}</textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light px-4 py-3">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-dismiss="modal" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">
                        <i class="fas fa-save me-1"></i> Simpan Catatan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Filter Live Search (Client-Side) -->
<script>
$(document).ready(function(){
    $("#searchInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#followupTableBody tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });

    // Notifikasi sukses hilang otomatis setelah 4 detik
    setTimeout(function() {
        $(".alert-success").fadeOut(500, function() { $(this).remove(); });
    }, 4000);
});

document.addEventListener('DOMContentLoaded', function () {
    // Tampilkan kolom tanggal jadwal ulang hanya jika status = Perlu Jadwal Ulang
    document.querySelectorAll('.select-status-fu').forEach(function (sel) {
        function atur() {
            var wrap = document.getElementById(sel.dataset.wrap);
            if (wrap) { wrap.style.display = sel.value === 'Perlu Jadwal Ulang' ? '' : 'none'; }
        }
        sel.addEventListener('change', atur);
        atur();
    });

    // Tombol buka WhatsApp memakai isi draft yang sedang tampil di modal
    document.querySelectorAll('.btn-wa-draft').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var teks = document.getElementById(btn.dataset.draft).value;
            window.open('https://wa.me/' + btn.dataset.nomor + '?text=' + encodeURIComponent(teks), '_blank');
        });
    });

    // Buka kembali modal yang gagal tervalidasi supaya isian tidak hilang
    @if($errors->any() && old('_id'))
        var el = document.getElementById('modalUpdateFollowup{{ old('_id') }}');
        if (el && window.bootstrap) { new bootstrap.Modal(el).show(); }
    @endif
});
</script>
@endsection