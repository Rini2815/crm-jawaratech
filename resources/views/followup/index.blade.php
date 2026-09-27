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
        border-color: #334155 !important;
    }
</style>

<div class="container-fluid px-4 pt-3 pb-4" style="background: linear-gradient(135deg, #eef1f3 0%, #eef1f3 100%); min-height: 100vh; color: #f8fafc;">
    
    <!-- Header Halaman (Dibungkus Card Gelap Elegan) -->
    <div class="card rounded-4 mb-4 text-white shadow-lg overflow-hidden" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); border: 1px solid rgba(56, 189, 248, 0.35) !important;">
        <div class="card-body p-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h2 class="text-white fw-bold mb-1" style="font-weight: 700;"><i class="fas fa-comments text-primary me-2"></i> Follow-up Konsumen</h2>
                <p class="text-light opacity-75 small mb-0" style="font-weight: 500;">Modul integrasi pesan untuk Happy Call, konfirmasi purna servis, dan pengingat servis berkala via WhatsApp</p>
            </div>
            
            <!-- Tombol Tambah Agenda Follow-up -->
            <button type="button" class="btn btn-primary shadow-sm px-4 py-2 fw-bold d-flex align-items-center gap-2 rounded-pill" style="font-size: 0.875rem; background-color: #2563eb; border-color: #2563eb;" data-toggle="modal" data-bs-toggle="modal" data-target="#modalTambahFollowup" data-bs-target="#modalTambahFollowup">
                <i class="fas fa-plus-circle"></i> Agendakan Follow-up
            </button>
        </div>
    </div>

    <!-- Metric Cards / Ringkasan Status -->
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card crm-card stat-card p-3 h-100" style="border-left: 5px solid #2563eb !important;">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-uppercase text-secondary fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">Total Agenda</div>
                        <div class="h4 mb-0 fw-bold text-dark mt-1" style="font-weight: 700;">24</div>
                    </div>
                    <div class="p-3 bg-primary bg-opacity-10 rounded-circle text-primary" style="background-color: rgba(37, 99, 235, 0.15); color: #2563eb;">
                        <i class="fas fa-calendar-alt fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card crm-card stat-card p-3 h-100" style="border-left: 5px solid #d97706 !important;">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-uppercase text-secondary fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">Belum Dihubungi</div>
                        <div class="h4 mb-0 fw-bold text-dark mt-1" style="font-weight: 700;">8</div>
                    </div>
                    <div class="p-3 rounded-circle" style="background-color: rgba(217, 119, 6, 0.15); color: #d97706;">
                        <i class="fas fa-clock fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card crm-card stat-card p-3 h-100" style="border-left: 5px solid #16a34a !important;">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-uppercase text-secondary fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">Selesai Dihubungi</div>
                        <div class="h4 mb-0 fw-bold text-dark mt-1" style="font-weight: 700;">14</div>
                    </div>
                    <div class="p-3 rounded-circle" style="background-color: rgba(22, 163, 74, 0.15); color: #16a34a;">
                        <i class="fas fa-check-circle fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card crm-card stat-card p-3 h-100" style="border-left: 5px solid #0284c7 !important;">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-uppercase text-secondary fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">Jadwal Ulang</div>
                        <div class="h4 mb-0 fw-bold text-dark mt-1" style="font-weight: 700;">2</div>
                    </div>
                    <div class="p-3 rounded-circle" style="background-color: rgba(2, 132, 199, 0.15); color: #0284c7;">
                        <i class="fas fa-sync-alt fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Main Data Follow-up -->
    <div class="card crm-card overflow-hidden mb-4">
        <div class="card-header text-white border-0 pt-3 px-4 pb-3 d-flex justify-content-between align-items-center flex-wrap gap-2 shadow-sm" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); border-bottom: 2px solid rgba(56, 189, 248, 0.4) !important;">
            <div class="d-flex align-items-center gap-2">
                <div class="p-2 rounded-circle bg-primary bg-opacity-25 text-info">
                    <i class="fas fa-comments fa-lg"></i>
                </div>
                <div>
                    <h5 class="m-0 text-white fw-bold">Daftar Antrean Follow-up Konsumen</h5>
                    <small class="text-light opacity-75">Kelola komunikasi dan pemantauan kepuasan pelanggan secara berkala</small>
                </div>
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
                    <thead class="crm-table-header text-uppercase text-center fs-7">
                        <tr>
                            <th class="py-3 text-white" style="width: 5%;">NO</th>
                            <th class="py-3 text-white text-start" style="width: 20%;">KONSUMEN & WA</th>
                            <th class="py-3 text-white text-start" style="width: 20%;">UNIT & LAYANAN</th>
                            <th class="py-3 text-white text-start" style="width: 18%;">KATEGORI & TANGGAL</th>
                            <th class="py-3 text-white text-center" style="width: 12%;">STATUS</th>
                            <th class="py-3 text-white text-start" style="width: 15%;">CATATAN HASIL</th>
                            <th class="text-center py-3 text-white" style="width: 10%;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody id="followupTableBody" style="font-weight: 500;">
                        @php
                            $dummyFollowups = [
                                [
                                    'id' => 1,
                                    'nama' => 'Budi Santoso',
                                    'wa' => '6281234567890',
                                    'wa_fmt' => '081234567890',
                                    'unit' => 'AC Daikin Inverter 1 PK',
                                    'layanan' => 'Perbaikan Kebocoran Freon',
                                    'kategori' => 'Happy Call (H+3)',
                                    'badge_kat' => 'badge-kategori-happycall',
                                    'tgl_jadwal' => '27 Sep 2026',
                                    'status' => 'Belum Dihubungi',
                                    'badge_status' => 'badge-followup-pending',
                                    'catatan' => 'Konfirmasi apakah AC masih dingin dan tidak ada kendala bocor ulang.',
                                    'draft_wa' => 'Halo Bpk Budi Santoso, kami dari Jawaratech CRM ingin mengonfirmasi hasil perbaikan AC Daikin Anda pada tanggal 24 Sep 2026. Apakah AC sudah berfungsi dingin optimal dan tidak ada kendala?'
                                ],
                                [
                                    'id' => 2,
                                    'nama' => 'Siti Aminah',
                                    'wa' => '6285712345678',
                                    'wa_fmt' => '085712345678',
                                    'unit' => 'Mesin Cuci LG 2 Tabung',
                                    'layanan' => 'Servis Rutin & Ganti Modul',
                                    'kategori' => 'Pengingat Servis (3 Bulan)',
                                    'badge_kat' => 'badge-kategori-rutin',
                                    'tgl_jadwal' => '25 Sep 2026',
                                    'status' => 'Sudah Dihubungi',
                                    'badge_status' => 'badge-followup-done',
                                    'catatan' => 'Konsumen setuju untuk penjadwalan cuci ulang minggu depan.',
                                    'draft_wa' => 'Halo Ibu Siti Aminah, sudah 3 bulan sejak perawatan Mesin Cuci LG Anda di Jawaratech. Untuk menjaga kinerja unit tetap awet, apakah berkenan kami jadwalkan perawatan berkala minggu ini?'
                                ],
                                [
                                    'id' => 3,
                                    'nama' => 'Ahmad Faisal',
                                    'wa' => '6281987654321',
                                    'wa_fmt' => '081987654321',
                                    'unit' => 'Dispenser Polytron Hyda',
                                    'layanan' => 'Perbaikan Pemanas Air',
                                    'kategori' => 'Happy Call (H+3)',
                                    'badge_kat' => 'badge-kategori-happycall',
                                    'tgl_jadwal' => '28 Sep 2026',
                                    'status' => 'Perlu Jadwal Ulang',
                                    'badge_status' => 'badge-followup-rescheduled',
                                    'catatan' => 'Pelanggan minta dihubungi kembali hari Sabtu di jam kerja.',
                                    'draft_wa' => 'Halo Bpk Ahmad Faisal, kami dari Jawaratech CRM ingin mengonfirmasi perbaikan Dispenser Polytron Anda. Apakah porsi pemanas airnya sudah berfungsi normal?'
                                ]
                            ];
                        @endphp

                        @foreach($dummyFollowups as $index => $f)
                        <tr>
                            <td class="px-4 py-3 text-secondary text-center fw-bold">{{ $index + 1 }}</td>
                            <td class="py-3">
                                <div class="text-dark fw-bold">{{ $f['nama'] }}</div>
                                <div class="text-secondary small">
                                    <span class="badge bg-light text-success border border-success px-2 py-1 mt-1"><i class="fab fa-whatsapp me-1"></i> {{ $f['wa_fmt'] }}</span>
                                </div>
                            </td>
                            <td class="py-3">
                                <div class="text-dark fw-bold small">{{ $f['unit'] }}</div>
                                <div class="text-muted small">{{ $f['layanan'] }}</div>
                            </td>
                            <td class="py-3">
                                <span class="badge crm-badge {{ $f['badge_kat'] }} mb-1">{{ $f['kategori'] }}</span>
                                <div class="text-secondary small"><i class="far fa-calendar text-muted me-1"></i> {{ $f['tgl_jadwal'] }}</div>
                            </td>
                            <td class="py-3 text-center">
                                <span class="badge crm-badge {{ $f['badge_status'] }}">
                                    {{ $f['status'] }}
                                </span>
                            </td>
                            <td class="py-3 text-secondary small" style="max-width: 220px;">
                                {{ $f['catatan'] }}
                            </td>
                            <td class="py-3 text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <!-- Direct WhatsApp Link Button -->
                                    <a href="https://wa.me/{{ $f['wa'] }}?text={{ urlencode($f['draft_wa']) }}" target="_blank" class="btn btn-sm btn-success rounded-pill px-2 py-1 shadow-sm text-white" title="Kirim WA Langsung" style="font-weight: 600;">
                                        <i class="fab fa-whatsapp me-1"></i> Chat
                                    </a>
                                    <!-- Modal Trigger Edit Status / Catat Response -->
                                    <button class="btn btn-sm btn-outline-primary rounded-pill px-2 py-1 shadow-sm" title="Update Status Follow-up" data-toggle="modal" data-bs-toggle="modal" data-target="#modalUpdateFollowup{{ $f['id'] }}" data-bs-target="#modalUpdateFollowup{{ $f['id'] }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Modal Update Hasil Follow-up (800px) -->
                        <div class="modal fade crm-wrapper" id="modalUpdateFollowup{{ $f['id'] }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-custom-size modal-dialog-centered">
                                <div class="modal-content rounded-4 shadow-lg text-dark" style="background: #f8fafc; border: 2px solid #334155;">
                                    <div class="modal-header bg-dark text-white">
                                        <h5 class="modal-title fw-bold" style="font-size: 1.15rem;">
                                            <i class="fas fa-user-check text-info me-2"></i>Update Respon & Status Follow-up
                                        </h5>
                                        <button type="button" class="btn-close btn-close-white" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="#" method="POST">
                                        @csrf
                                        <div class="modal-body p-4">
                                            <div class="row mb-3">
                                                <div class="col-md-6 mb-3 mb-md-0">
                                                    <label class="form-label text-dark small fw-bold">Pelanggan</label>
                                                    <input type="text" class="form-control py-2 rounded-pill bg-white border-secondary" value="{{ $f['nama'] }} ({{ $f['wa_fmt'] }})" readonly style="background-color: #f1f5f9 !important; cursor: not-allowed;">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label text-dark small fw-bold">Unit & Layanan</label>
                                                    <input type="text" class="form-control py-2 rounded-pill bg-white border-secondary" value="{{ $f['unit'] }}" readonly style="background-color: #f1f5f9 !important; cursor: not-allowed;">
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-md-6 mb-3 mb-md-0">
                                                    <label class="form-label text-dark small fw-bold">Status Follow-up</label>
                                                    <select name="status" class="form-select py-2 rounded-pill bg-white border-secondary">
                                                        <option value="Belum Dihubungi" {{ $f['status'] == 'Belum Dihubungi' ? 'selected' : '' }}>Belum Dihubungi</option>
                                                        <option value="Sudah Dihubungi" {{ $f['status'] == 'Sudah Dihubungi' ? 'selected' : '' }}>Sudah Dihubungi (Selesai)</option>
                                                        <option value="Perlu Jadwal Ulang" {{ $f['status'] == 'Perlu Jadwal Ulang' ? 'selected' : '' }}>Perlu Jadwal Ulang</option>
                                                        <option value="Tidak Merespon" {{ $f['status'] == 'Tidak Merespon' ? 'selected' : '' }}>Tidak Merespon</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label text-dark small fw-bold">Kategori Follow-up</label>
                                                    <input type="text" class="form-control py-2 rounded-pill bg-white border-secondary" value="{{ $f['kategori'] }}" readonly style="background-color: #f1f5f9 !important;">
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label text-dark small fw-bold">Draft Pesan WhatsApp</label>
                                                <textarea class="form-control rounded-4 bg-white border-secondary" rows="3" style="font-size: 0.875rem;">{{ $f['draft_wa'] }}</textarea>
                                            </div>

                                            <div class="mb-2">
                                                <label class="form-label text-dark small fw-bold">Catatan / Hasil Konsultasi Pelanggan</label>
                                                <textarea name="catatan" class="form-control rounded-4 bg-white border-secondary" rows="3" placeholder="Masukkan respons konsumen, keluhan tambahan, atau kesepakatan re-servis..." style="font-size: 0.875rem;">{{ $f['catatan'] }}</textarea>
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
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Agendakan Follow-up Baru (800px) -->
<div class="modal fade crm-wrapper" id="modalTambahFollowup" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-custom-size modal-dialog-centered">
        <div class="modal-content rounded-4 shadow-lg text-dark" style="background: #f8fafc; border: 2px solid #334155;">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title fw-bold" style="font-size: 1.15rem;">
                    <i class="fas fa-calendar-plus text-info me-2"></i>Buat Agenda Follow-up Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label text-dark small fw-bold">Pilih Servis Pelanggan (Pemicu)</label>
                        <select name="closing_servis_id" class="form-select py-2 rounded-pill bg-white border-secondary" required>
                            <option value="" disabled selected>Pilih Data Closing Servis Terakhir...</option>
                            <option value="1">Budi Santoso - AC Daikin Inverter (Servis Tgl: 24 Sep 2026)</option>
                            <option value="2">Siti Aminah - Mesin Cuci LG (Servis Tgl: 15 Jun 2026)</option>
                        </select>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="form-label text-dark small fw-bold">Kategori Follow-up</label>
                            <select name="kategori" class="form-select py-2 rounded-pill bg-white border-secondary" required>
                                <option value="Happy Call (H+3)">Happy Call (H+3 Purna Servis)</option>
                                <option value="Pengingat Servis (3 Bulan)">Pengingat Servis Berkala (3 Bulan)</option>
                                <option value="Penawaran Promo">Penawaran Promo / Maintenance</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-dark small fw-bold">Tanggal Rencana Kontak</label>
                            <input type="date" name="tgl_jadwal" class="form-control py-2 rounded-pill bg-white border-secondary" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-dark small fw-bold">Template Pesan WhatsApp</label>
                        <textarea name="draft_wa" class="form-control rounded-4 bg-white border-secondary" rows="3" placeholder="Tuliskan draf template pesan yang akan dikirim via WhatsApp..." style="font-size: 0.875rem;"></textarea>
                    </div>

                    <div class="mb-2">
                        <label class="form-label text-dark small fw-bold">Catatan Tambahan Petugas</label>
                        <input type="text" name="catatan" class="form-control py-2 rounded-pill bg-white border-secondary" placeholder="Contoh: Tanyakan kondisi suhu AC setelah perbaikan outdoor">
                    </div>
                </div>
                <div class="modal-footer bg-light px-4 py-3">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-dismiss="modal" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">
                        <i class="fas fa-save me-1"></i> Agendakan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

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
    });
</script>
@endsection