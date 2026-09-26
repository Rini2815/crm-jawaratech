@extends('layouts.app')

@section('content')
<!-- Import Font 'Inter' & Custom CSS Jawaratech CRM -->
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
    
    .crm-wrapper {
        font-family: 'Inter', sans-serif;
        color: #334155;
    }
    .crm-card {
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        border-radius: 8px;
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
        border-left: 4px solid #2563eb;
        transition: transform 0.2s ease;
    }
    .stat-card:hover {
        transform: translateY(-2px);
    }
</style>

<div class="container-fluid py-4 crm-wrapper">
    <!-- Header Halaman -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h1 class="h3 mb-1 text-dark" style="font-weight: 700; color: #0f172a !important;">Follow-up Konsumen</h1>
            <p class="text-secondary mb-0" style="font-weight: 500;">Modul integrasi pesan untuk Happy Call, konfirmasi purna servis, dan pengingat servis berkala via WhatsApp</p>
        </div>
        
        <!-- Tombol Tambah Agenda Follow-up -->
        <button type="button" class="btn btn-primary shadow-sm px-4 py-2" style="font-weight: 600; border-radius: 6px; background-color: #2563eb; border-color: #2563eb;" data-toggle="modal" data-bs-toggle="modal" data-target="#modalTambahFollowup" data-bs-target="#modalTambahFollowup">
            <i class="fas fa-plus fa-sm me-1 mr-1"></i> Agendakan Follow-up
        </button>
    </div>

    <!-- Metric Cards / Ringkasan Status -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card crm-card stat-card bg-white p-3" style="border-left-color: #2563eb;">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-uppercase text-secondary fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">Total Agenda</div>
                        <div class="h4 mb-0 fw-bold text-dark mt-1" style="font-weight: 700;">24</div>
                    </div>
                    <div class="p-3 bg-primary bg-opacity-10 rounded text-primary" style="background-color: #eff6ff;">
                        <i class="fas fa-calendar-alt fa-lg" style="color: #2563eb;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card crm-card stat-card bg-white p-3" style="border-left-color: #d97706;">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-uppercase text-secondary fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">Belum Dihubungi</div>
                        <div class="h4 mb-0 fw-bold text-dark mt-1" style="font-weight: 700;">8</div>
                    </div>
                    <div class="p-3 rounded" style="background-color: #fef3c7; color: #d97706;">
                        <i class="fas fa-clock fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card crm-card stat-card bg-white p-3" style="border-left-color: #16a34a;">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-uppercase text-secondary fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">Selesai Dihubungi</div>
                        <div class="h4 mb-0 fw-bold text-dark mt-1" style="font-weight: 700;">14</div>
                    </div>
                    <div class="p-3 rounded" style="background-color: #dcfce7; color: #16a34a;">
                        <i class="fas fa-check-circle fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card crm-card stat-card bg-white p-3" style="border-left-color: #0284c7;">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-uppercase text-secondary fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">Jadwal Ulang</div>
                        <div class="h4 mb-0 fw-bold text-dark mt-1" style="font-weight: 700;">2</div>
                    </div>
                    <div class="p-3 rounded" style="background-color: #e0f2fe; color: #0284c7;">
                        <i class="fas fa-sync-alt fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Main Data Follow-up -->
    <div class="card crm-card bg-white">
        <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h6 class="m-0 text-dark" style="font-weight: 700;">
                <i class="fas fa-comments text-primary me-2 mr-2"></i>Daftar Antrean Follow-up Konsumen
            </h6>

            <!-- Search Bar Real-time (Frontend JS) -->
            <div class="position-relative" style="min-width: 280px;">
                <input type="text" id="searchInput" class="form-control form-control-sm ps-5 pe-3 pl-4 pr-3 py-2" placeholder="Cari nama konsumen, jenis unit..." style="border-radius: 6px; border: 1px solid #cbd5e1; font-size: 0.875rem;">
                <i class="fas fa-search position-absolute text-secondary" style="left: 12px; top: 50%; transform: translateY(-50%); font-size: 0.85rem;"></i>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="crm-table-header">
                        <tr>
                            <th class="px-4 py-3 border-0">NO</th>
                            <th class="py-3 border-0">KONSUMEN & WA</th>
                            <th class="py-3 border-0">UNIT & LAYANAN</th>
                            <th class="py-3 border-0">KATEGORI & TANGGAL</th>
                            <th class="py-3 border-0">STATUS</th>
                            <th class="py-3 border-0">CATATAN HASIL</th>
                            <th class="text-center py-3 border-0">AKSI INTEGRASI</th>
                        </tr>
                    </thead>
                    <tbody id="followupTableBody" style="font-weight: 500;">
                        @php
                            // Data Dummy khusus untuk Frontend Preview
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
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <td class="px-4 py-3 text-secondary">{{ $index + 1 }}</td>
                            <td class="py-3">
                                <div class="text-dark" style="font-weight: 600;">{{ $f['nama'] }}</div>
                                <div class="text-secondary" style="font-size: 0.85rem;">
                                    <i class="fab fa-whatsapp text-success me-1 mr-1"></i> {{ $f['wa_fmt'] }}
                                </div>
                            </td>
                            <td class="py-3">
                                <div class="text-dark" style="font-weight: 600; font-size: 0.9rem;">{{ $f['unit'] }}</div>
                                <div class="text-muted" style="font-size: 0.825rem;">{{ $f['layanan'] }}</div>
                            </td>
                            <td class="py-3">
                                <span class="badge crm-badge {{ $f['badge_kat'] }} mb-1">{{ $f['kategori'] }}</span>
                                <div class="text-secondary" style="font-size: 0.825rem;"><i class="far fa-calendar text-muted me-1 mr-1"></i> {{ $f['tgl_jadwal'] }}</div>
                            </td>
                            <td class="py-3">
                                <span class="badge crm-badge {{ $f['badge_status'] }}">
                                    {{ $f['status'] }}
                                </span>
                            </td>
                            <td class="py-3 text-secondary" style="font-size: 0.85rem; max-width: 220px;">
                                {{ $f['catatan'] }}
                            </td>
                            <td class="py-3 text-center">
                                <div class="btn-group" role="group">
                                    <!-- Direct WhatsApp Link Button -->
                                    <a href="https://wa.me/{{ $f['wa'] }}?text={{ urlencode($f['draft_wa']) }}" target="_blank" class="btn btn-sm btn-success shadow-sm me-1 mr-1" title="Kirim WA Langsung" style="border-radius: 4px; font-weight: 600;">
                                        <i class="fab fa-whatsapp me-1 mr-1"></i> Chat
                                    </a>
                                    <!-- Modal Trigger Edit Status / Catat Response -->
                                    <button class="btn btn-sm btn-outline-primary shadow-sm" title="Update Status Follow-up" style="border-radius: 4px;" data-toggle="modal" data-bs-toggle="modal" data-target="#modalUpdateFollowup{{ $f['id'] }}" data-bs-target="#modalUpdateFollowup{{ $f['id'] }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Modal Update Hasil Follow-up (800px) -->
                        <div class="modal fade crm-wrapper" id="modalUpdateFollowup{{ $f['id'] }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-custom-size modal-dialog-centered">
                                <div class="modal-content" style="border-radius: 10px; border: none; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.2);">
                                    <div class="modal-header py-3 px-4 d-flex align-items-center" style="background-color: #1e293b; border-bottom: 1px solid #1e293b; border-top-left-radius: 10px; border-top-right-radius: 10px;">
                                        <h5 class="modal-title text-white mb-0" style="font-weight: 700; font-size: 1.15rem;">
                                            <i class="fas fa-user-check me-2 mr-2"></i>Update Respon & Status Follow-up
                                        </h5>
                                        <button type="button" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close" style="color: #ffffff; opacity: 1; background: transparent; border: none; font-size: 1.5rem; padding: 0; line-height: 1;">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="#" method="POST">
                                        @csrf
                                        <div class="modal-body p-4">
                                            <div class="row mb-3">
                                                <div class="col-md-6 mb-3 mb-md-0">
                                                    <label class="form-label text-dark" style="font-size: 0.875rem; font-weight: 600;">Pelanggan</label>
                                                    <input type="text" class="form-control py-2" value="{{ $f['nama'] }} ({{ $f['wa_fmt'] }})" readonly style="border-radius: 6px; background-color: #f1f5f9; cursor: not-allowed;">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label text-dark" style="font-size: 0.875rem; font-weight: 600;">Unit & Layanan</label>
                                                    <input type="text" class="form-control py-2" value="{{ $f['unit'] }}" readonly style="border-radius: 6px; background-color: #f1f5f9; cursor: not-allowed;">
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-md-6 mb-3 mb-md-0">
                                                    <label class="form-label text-dark" style="font-size: 0.875rem; font-weight: 600;">Status Follow-up</label>
                                                    <select name="status" class="form-control py-2" style="border-radius: 6px;">
                                                        <option value="Belum Dihubungi" {{ $f['status'] == 'Belum Dihubungi' ? 'selected' : '' }}>Belum Dihubungi</option>
                                                        <option value="Sudah Dihubungi" {{ $f['status'] == 'Sudah Dihubungi' ? 'selected' : '' }}>Sudah Dihubungi (Selesai)</option>
                                                        <option value="Perlu Jadwal Ulang" {{ $f['status'] == 'Perlu Jadwal Ulang' ? 'selected' : '' }}>Perlu Jadwal Ulang</option>
                                                        <option value="Tidak Merespon" {{ $f['status'] == 'Tidak Merespon' ? 'selected' : '' }}>Tidak Merespon</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label text-dark" style="font-size: 0.875rem; font-weight: 600;">Kategori Follow-up</label>
                                                    <input type="text" class="form-control py-2" value="{{ $f['kategori'] }}" readonly style="border-radius: 6px; background-color: #f1f5f9;">
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label text-dark" style="font-size: 0.875rem; font-weight: 600;">Draft Pesan WhatsApp</label>
                                                <textarea class="form-control" rows="3" style="border-radius: 6px; font-size: 0.875rem;">{{ $f['draft_wa'] }}</textarea>
                                            </div>

                                            <div class="mb-2">
                                                <label class="form-label text-dark" style="font-size: 0.875rem; font-weight: 600;">Catatan / Hasil Konsultasi Pelanggan</label>
                                                <textarea name="catatan" class="form-control" rows="3" placeholder="Masukkan respons konsumen, keluhan tambahan, atau kesepakatan re-servis..." style="border-radius: 6px; font-size: 0.875rem;">{{ $f['catatan'] }}</textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer px-4 py-3" style="border-top: 1px solid #e2e8f0; background-color: #f8fafc; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
                                            <button type="button" class="btn btn-light px-4 py-2" data-dismiss="modal" data-bs-dismiss="modal" style="font-weight: 600; border-radius: 6px; border: 1px solid #cbd5e1;">Batal</button>
                                            <button type="submit" class="btn btn-primary px-4 py-2" style="font-weight: 600; border-radius: 6px; background-color: #2563eb; border-color: #2563eb;">
                                                <i class="fas fa-save me-1 mr-1"></i> Simpan Catatan
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
        <div class="modal-content" style="border-radius: 10px; border: none; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.2);">
            <div class="modal-header py-3 px-4 d-flex align-items-center" style="background-color: #1e293b; border-bottom: 1px solid #1e293b; border-top-left-radius: 10px; border-top-right-radius: 10px;">
                <h5 class="modal-title text-white mb-0" style="font-weight: 700; font-size: 1.15rem;">
                    <i class="fas fa-calendar-plus me-2 mr-2"></i>Buat Agenda Follow-up Baru
                </h5>
                <button type="button" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close" style="color: #ffffff; opacity: 1; background: transparent; border: none; font-size: 1.5rem; padding: 0; line-height: 1;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label text-dark" style="font-size: 0.875rem; font-weight: 600;">Pilih Servis Pelanggan (Pemicu)</label>
                        <select name="closing_servis_id" class="form-control py-2" required style="border-radius: 6px;">
                            <option value="" disabled selected>Pilih Data Closing Servis Terakhir...</option>
                            <option value="1">Budi Santoso - AC Daikin Inverter (Servis Tgl: 24 Sep 2026)</option>
                            <option value="2">Siti Aminah - Mesin Cuci LG (Servis Tgl: 15 Jun 2026)</option>
                        </select>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="form-label text-dark" style="font-size: 0.875rem; font-weight: 600;">Kategori Follow-up</label>
                            <select name="kategori" class="form-control py-2" required style="border-radius: 6px;">
                                <option value="Happy Call (H+3)">Happy Call (H+3 Purna Servis)</option>
                                <option value="Pengingat Servis (3 Bulan)">Pengingat Servis Berkala (3 Bulan)</option>
                                <option value="Penawaran Promo">Penawaran Promo / Maintenance</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-dark" style="font-size: 0.875rem; font-weight: 600;">Tanggal Rencana Kontak</label>
                            <input type="date" name="tgl_jadwal" class="form-control py-2" required style="border-radius: 6px;">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-dark" style="font-size: 0.875rem; font-weight: 600;">Template Pesan WhatsApp</label>
                        <textarea name="draft_wa" class="form-control" rows="3" placeholder="Tuliskan draf template pesan yang akan dikirim via WhatsApp..." style="border-radius: 6px; font-size: 0.875rem;"></textarea>
                    </div>

                    <div class="mb-2">
                        <label class="form-label text-dark" style="font-size: 0.875rem; font-weight: 600;">Catatan Tambahan Petugas</label>
                        <input type="text" name="catatan" class="form-control py-2" placeholder="Contoh: Tanyakan kondisi suhu AC setelah perbaikan outdoor" style="border-radius: 6px;">
                    </div>
                </div>
                <div class="modal-footer px-4 py-3" style="border-top: 1px solid #e2e8f0; background-color: #f8fafc; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
                    <button type="button" class="btn btn-light px-4 py-2" data-dismiss="modal" data-bs-dismiss="modal" style="font-weight: 600; border-radius: 6px; border: 1px solid #cbd5e1;">Batal</button>
                    <button type="submit" class="btn btn-primary px-4 py-2" style="font-weight: 600; border-radius: 6px; background-color: #2563eb; border-color: #2563eb;">
                        <i class="fas fa-save me-1 mr-1"></i> Agendakan
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