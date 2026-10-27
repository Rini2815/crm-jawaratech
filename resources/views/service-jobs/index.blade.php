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
    color: #0f172a;
}
.crm-card {
    border: 1px solid #cbd5e1;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
    border-radius: 12px;
    background: #ffffff !important;
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
    text-shadow: none;
}
.alert-close:hover {
    opacity: 1;
}
.alert-close.alert-close-top {
    top: 12px;
    transform: none;
}
.alert-success .alert-close { color: #166534; }
.alert-danger .alert-close { color: #991b1b; }

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
.stat-card.green { border-left: 4px solid #10b981 !important; }
.stat-card.purple { border-left: 4px solid #8b5cf6 !important; }
.stat-card.cyan { border-left: 4px solid #0891b2 !important; }
.stat-card.orange { border-left: 4px solid #f97316 !important; }

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

/* ===== Modal konfirmasi hapus (gaya sama dengan modal logout) ===== */
.hapus-overlay {
    position: fixed;
    inset: 0;
    z-index: 10000;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 16px;
    background: rgba(2, 6, 23, 0.65);
    backdrop-filter: blur(2px);
}
.hapus-overlay.show { display: flex; }

.hapus-box {
    width: 100%;
    max-width: 500px;
    padding: 24px 28px;
    text-align: center;
    color: #ffffff;
    background: #0f172a;
    border: 1px solid #1e293b;
    border-radius: 16px;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7);
    font-family: 'Inter', system-ui, -apple-system, sans-serif;
    animation: hapusMasuk 0.2s ease-out;
}
@keyframes hapusMasuk {
    from { opacity: 0; transform: scale(0.92); }
    to   { opacity: 1; transform: scale(1); }
}

.hapus-ikon {
    width: 60px;
    height: 60px;
    margin: 0 auto 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    color: #f43f5e;
    background: rgba(244, 63, 94, 0.15);
    border: 1px solid rgba(244, 63, 94, 0.45);
    border-radius: 50%;
}

.hapus-judul {
    margin: 0 0 6px;
    font-size: 1.15rem;
    font-weight: 700;
    color: #ffffff;
}
.hapus-pesan {
    margin: 0 0 18px;
    font-size: 0.8rem;
    line-height: 1.5;
    color: #e2e8f0;
}

.hapus-aksi {
    display: flex;
    justify-content: center;
    gap: 10px;
}
.hapus-btn {
    padding: 8px 20px;
    font-size: 0.85rem;
    font-weight: 700;
    border-radius: 999px;
    cursor: pointer;
    transition: filter 0.15s ease, background-color 0.15s ease;
}
.hapus-btn-batal {
    color: #ffffff;
    background: transparent;
    border: 1px solid #ffffff;
}
.hapus-btn-batal:hover { background: rgba(255, 255, 255, 0.1); }
.hapus-btn-ya {
    color: #ffffff;
    background: #ef4444;
    border: 1px solid #ef4444;
}
.hapus-btn-ya:hover { filter: brightness(1.1); }
.hapus-btn-ya:disabled { opacity: 0.6; cursor: not-allowed; }

/* ===== Dropdown dengan kolom pencarian ===== */
.cs-wrap { position: relative; }
.cs-native {
    position: absolute !important;
    left: 0; bottom: 0;
    width: 1px !important; height: 1px !important;
    padding: 0 !important; border: 0 !important;
    opacity: 0 !important;
    pointer-events: none !important;
}
.cs-trigger {
    position: relative;
    display: block;
    background-color: #ffffff;
    cursor: pointer;
    user-select: none;
    border-radius: 6px;
}
.cs-label {
    display: block;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    padding-right: 22px;
}
.cs-label.cs-placeholder { color: #64748b; font-weight: 400; }
.cs-caret {
    position: absolute;
    right: 12px; top: 50%;
    transform: translateY(-50%);
    font-size: 0.7rem;
    color: #64748b;
    pointer-events: none;
}
.cs-panel {
    display: none;
    position: absolute;
    left: 0; right: 0; top: calc(100% + 4px);
    z-index: 1060;
    background: #ffffff;
    border: 1px solid #cbd5e1;
    border-radius: 6px;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.2);
    padding: 8px;
}
.cs-wrap.cs-open .cs-panel { display: block; }
.cs-search {
    width: 100%;
    border: 1px solid #cbd5e1;
    border-radius: 6px;
    padding: 0.4rem 0.65rem;
    font-size: 0.9rem;
    color: #0f172a;
    outline: none;
    margin-bottom: 6px;
}
.cs-search:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 0.15rem rgba(59, 130, 246, 0.2);
}
.cs-list {
    max-height: 220px;
    overflow-y: auto;
    margin: 0; padding: 0;
    list-style: none;
}
.cs-item {
    padding: 7px 10px;
    font-size: 0.92rem;
    font-weight: 500;
    color: #0f172a;
    border-radius: 4px;
    cursor: pointer;
}
.cs-item:hover, .cs-item.cs-active { background: #e0f2fe; }
.cs-item.cs-selected { color: #1d4ed8; font-weight: 700; }
.cs-empty {
    padding: 8px 10px;
    font-size: 0.85rem;
    color: #64748b;
}
</style>

<div class="container-fluid px-4 pt-3 pb-4 crm-wrapper" style="background: linear-gradient(135deg, #eef1f3 0%, #eef1f3 100%); min-height: 100vh;">

    <!-- ================================================================= -->
    <!-- BANNER UTAMA                                                      -->
    <!-- ================================================================= -->
    <div class="card rounded-3 mb-4 text-white shadow-sm overflow-hidden" style="background: #0f172a; border: 1px solid #1e293b;">
        <div class="card-body p-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h1 class="h4 mb-1 text-white fw-bold d-flex align-items-center gap-2">
                    <i class="fas fa-tools text-info"></i> Data Unit Servis
                </h1>
                <p class="text-light opacity-75 mb-0" style="font-weight: 400; font-size: 0.85rem;">
                    Kelola spesifikasi teknis unit pelanggan, tanggal masuk servis, dan status garansi
                </p>
            </div>
        </div>
    </div>

    <!-- Alert Notifikasi -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4 border-0 shadow-sm rounded-3" role="alert" style="background-color: #dcfce7; color: #166534;">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            <button type="button" class="alert-close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4 border-0 shadow-sm rounded-3" role="alert" style="background-color: #fee2e2; color: #991b1b;">
            <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
            <button type="button" class="alert-close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mb-4 border-0 shadow-sm rounded-3" role="alert" style="background-color: #fee2e2; color: #991b1b;">
            <i class="fas fa-exclamation-triangle mr-2"></i> <strong>Gagal Menyimpan!</strong> Periksa kembali form input Anda:
            <ul class="mb-0 mt-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="alert-close alert-close-top" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
    @endif

    <!-- ================================================================= -->
    <!-- DATA UNIT SERVIS                                                  -->
    <!-- ================================================================= -->

    <!-- KARTU STATISTIK DATA UNIT (5 kartu: Total, AC, Dispenser, Water Heater, Mesin Cuci) -->
    <div class="row mb-2">
        <div class="col-lg col-md-4 col-sm-6 mb-3">
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
        <div class="col-lg col-md-4 col-sm-6 mb-3">
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
        <div class="col-lg col-md-4 col-sm-6 mb-3">
            <div class="card stat-card cyan h-100 p-3 border-0">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted text-uppercase mb-1" style="font-size: 0.75rem; font-weight: 600;">Unit Dispenser</p>
                        <h4 class="mb-0 fw-bold text-dark">{{ $unitDispenser }} <span style="font-size: 0.9rem; font-weight: 500; color: #64748b;">Unit</span></h4>
                    </div>
                    <div class="rounded p-2" style="background-color: #cffafe; color: #0891b2;">
                        <i class="fas fa-faucet fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg col-md-4 col-sm-6 mb-3">
            <div class="card stat-card orange h-100 p-3 border-0">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted text-uppercase mb-1" style="font-size: 0.75rem; font-weight: 600;">Unit Water Heater</p>
                        <h4 class="mb-0 fw-bold text-dark">{{ $unitWaterHeater }} <span style="font-size: 0.9rem; font-weight: 500; color: #64748b;">Unit</span></h4>
                    </div>
                    <div class="rounded p-2" style="background-color: #ffedd5; color: #ea580c;">
                        <i class="fas fa-fire fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg col-md-4 col-sm-6 mb-3">
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
                        @forelse($unit as $u)
                        <tr>
                            <td class="px-4 py-3 text-secondary text-center fw-bold">{{ $loop->iteration }}</td>
                            <td class="py-3">
                                <div class="text-dark fw-bold">{{ $u->konsumen->nama ?? '-' }}</div>
                                <small class="text-success"><i class="fab fa-whatsapp"></i> {{ $u->konsumen->no_whatsapp ?? '-' }}</small>
                            </td>
                            <td class="py-3">
                                @if($u->jenis_unit == 'AC')
                                    <span class="badge bg-info text-dark">AC</span>
                                @elseif($u->jenis_unit == 'Mesin Cuci')
                                    <span class="badge bg-warning text-dark">Mesin Cuci</span>
                                @else
                                    <span class="badge" style="background-color: #cffafe; color: #0e7490;">{{ $u->jenis_unit }}</span>
                                @endif
                                {{ $u->merek }}
                            </td>
                            <td class="py-3 text-secondary">{{ $u->tipe_model ?? '-' }}</td>
                            <td class="py-3 text-center">{{ $u->tanggal_masuk->translatedFormat('j M Y') }}</td>
                            <td class="py-3 text-center">
                                @if($u->status_garansi === 'Aktif')
                                    <span class="badge" style="background-color: #dcfce3; color: #15803d; border: 1px solid #bbf7d0;">Aktif (Ada Kartu)</span>
                                @else
                                    <span class="badge" style="background-color: #fee2e2; color: #b91c1c; border: 1px solid #fecaca;">Tidak Bergaransi</span>
                                @endif
                            </td>
                            <td class="py-3 text-center">
                                <div class="aksi-wrap">
                                    <button type="button" class="btn btn-sm btn-outline-primary shadow-sm px-2 py-1" title="Ubah data" data-toggle="modal" data-target="#modalEditUnit{{ $u->id_unit }}"><i class="fas fa-edit"></i></button>

                                    <form action="{{ route('service-jobs.destroy', $u->id_unit) }}" method="POST" class="d-inline form-hapus" data-judul="Yakin ingin menghapus?" data-pesan="Unit milik {{ $u->konsumen->nama ?? '-' }} akan dihapus dan tidak dapat dikembalikan.">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger shadow-sm px-2 py-1" title="Hapus"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">Belum ada data unit yang terdaftar.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

{{-- ================================================================= --}}
{{-- MODAL (diletakkan di luar container agar tidak tertutup layar gelap) --}}
{{-- ================================================================= --}}

<!-- Modal Tambah Unit -->
<div class="modal fade crm-wrapper" id="modalTambahUnit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-custom-size modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 10px; border: none; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.2);">
            <div class="modal-header py-3 px-4 text-white" style="background-color: #1e293b; border-bottom: 1px solid #1e293b; border-top-left-radius: 10px; border-top-right-radius: 10px;">
                <h5 class="modal-title text-white mb-0" style="font-weight: 700; font-size: 1.15rem;"><i class="fas fa-plus-circle mr-2"></i>Tambah Data Unit Servis</h5>
                <button type="button" data-dismiss="modal" aria-label="Close" style="color: #ffffff; opacity: 1; background: transparent; border: none; font-size: 1.5rem; padding: 0; line-height: 1;"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="{{ route('service-jobs.store') }}" method="POST" autocomplete="off">
                @csrf
                <div class="modal-body p-4 bg-white text-dark">
                    <div class="mb-3">
                        <label class="text-dark" style="font-size: 0.875rem; font-weight: 600;">Pilih Konsumen Pemilik</label>
                        <select name="konsumen_id" class="form-control py-2" data-cari="Cari nama / no. WhatsApp pelanggan..." required style="border-radius: 6px;">
                            <option value="" disabled selected>Pilih Konsumen...</option>
                            @foreach($konsumen as $k)
                            <option value="{{ $k->id_konsumen }}">{{ $k->nama }} - {{ $k->no_whatsapp }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="text-dark" style="font-size: 0.875rem; font-weight: 600;">Jenis Unit</label>
                            <select name="jenis_unit" class="form-control py-2" data-cari="Cari jenis unit..." required style="border-radius: 6px;">
                                <option value="" disabled selected>Pilih...</option>
                                <option value="AC">AC</option>
                                <option value="Mesin Cuci">Mesin Cuci</option>
                                <option value="Dispenser">Dispenser</option>
                                <option value="Water Heater">Water Heater</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="text-dark" style="font-size: 0.875rem; font-weight: 600;">Merek Unit</label>
                            <input type="text" name="merek" class="form-control py-2" placeholder="Contoh: Daikin, LG, Sharp" required maxlength="20" style="border-radius: 6px;">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="text-dark" style="font-size: 0.875rem; font-weight: 600;">Model / Tipe Rinci</label>
                        <input type="text" name="tipe" class="form-control py-2" placeholder="Contoh: Inverter 1 PK / 2 Tabung" required maxlength="45" style="border-radius: 6px;">
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="text-dark" style="font-size: 0.875rem; font-weight: 600;">Tanggal Masuk Servis</label>
                            <input type="date" name="tgl_masuk" class="form-control py-2" required style="border-radius: 6px;">
                        </div>
                        <div class="col-md-6">
                            <label class="text-dark" style="font-size: 0.875rem; font-weight: 600;">Status Garansi</label>
                            <select name="status_garansi" class="form-control py-2" required style="border-radius: 6px;">
                                <option value="Aktif">Aktif (Ada Kartu)</option>
                                <option value="Tidak Bergaransi">Tidak Bergaransi</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="text-dark" style="font-size: 0.875rem; font-weight: 600;">Interval Perawatan (Bulan)</label>
                        <input type="number" name="interval_bulan" class="form-control py-2" value="6" min="1" max="60" required style="border-radius: 6px;">
                        <small class="text-muted">Jarak antar jadwal perawatan rutin unit ini.</small>
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
<div class="modal fade crm-wrapper" id="modalEditUnit{{ $u->id_unit }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-custom-size modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 10px; border: none; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.2);">
            <div class="modal-header py-3 px-4 text-white" style="background-color: #1e293b; border-bottom: 1px solid #1e293b; border-top-left-radius: 10px; border-top-right-radius: 10px;">
                <h5 class="modal-title text-white mb-0" style="font-weight: 700; font-size: 1.15rem;"><i class="fas fa-edit mr-2"></i>Edit Data Unit Servis</h5>
                <button type="button" data-dismiss="modal" aria-label="Close" style="color: #ffffff; opacity: 1; background: transparent; border: none; font-size: 1.5rem; padding: 0; line-height: 1;"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="{{ route('service-jobs.update', $u->id_unit) }}" method="POST" autocomplete="off">
                @csrf
                @method('PUT')
                <div class="modal-body p-4 bg-white text-dark">
                    <div class="mb-3">
                        <label class="text-dark" style="font-size: 0.875rem; font-weight: 600;">Pemilik Unit</label>
                        <input type="text" class="form-control py-2" value="{{ $u->konsumen->nama ?? '-' }}" readonly style="border-radius: 6px; background-color: #f1f5f9; cursor: not-allowed;">
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="text-dark" style="font-size: 0.875rem; font-weight: 600;">Jenis Unit</label>
                            <select name="jenis_unit" class="form-control py-2" data-cari="Cari jenis unit..." required style="border-radius: 6px;">
                                <option value="AC" {{ $u->jenis_unit == 'AC' ? 'selected' : '' }}>AC</option>
                                <option value="Mesin Cuci" {{ $u->jenis_unit == 'Mesin Cuci' ? 'selected' : '' }}>Mesin Cuci</option>
                                <option value="Dispenser" {{ $u->jenis_unit == 'Dispenser' ? 'selected' : '' }}>Dispenser</option>
                                <option value="Water Heater" {{ $u->jenis_unit == 'Water Heater' ? 'selected' : '' }}>Water Heater</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="text-dark" style="font-size: 0.875rem; font-weight: 600;">Merek Unit</label>
                            <input type="text" name="merek" class="form-control py-2" value="{{ $u->merek }}" required maxlength="20" style="border-radius: 6px;">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="text-dark" style="font-size: 0.875rem; font-weight: 600;">Model / Tipe Rinci</label>
                        <input type="text" name="tipe" class="form-control py-2" value="{{ $u->tipe_model }}" required maxlength="45" style="border-radius: 6px;">
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="text-dark" style="font-size: 0.875rem; font-weight: 600;">Tanggal Masuk Servis</label>
                            <input type="date" name="tgl_masuk" class="form-control py-2" value="{{ $u->tanggal_masuk->format('Y-m-d') }}" required style="border-radius: 6px;">
                        </div>
                        <div class="col-md-6">
                            <label class="text-dark" style="font-size: 0.875rem; font-weight: 600;">Status Garansi</label>
                            <select name="status_garansi" class="form-control py-2" required style="border-radius: 6px;">
                                <option value="Aktif" {{ $u->status_garansi === 'Aktif' ? 'selected' : '' }}>Aktif (Ada Kartu)</option>
                                <option value="Tidak Bergaransi" {{ $u->status_garansi !== 'Aktif' ? 'selected' : '' }}>Tidak Bergaransi</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="text-dark" style="font-size: 0.875rem; font-weight: 600;">Interval Perawatan (Bulan)</label>
                        <input type="number" name="interval_bulan" class="form-control py-2" value="{{ $u->interval_bulan }}" min="1" max="60" required style="border-radius: 6px;">
                        <small class="text-muted">Jarak antar jadwal perawatan rutin unit ini.</small>
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

{{-- ================================================================= --}}
{{-- MODAL KONFIRMASI HAPUS (gaya sama dengan modal logout)            --}}
{{-- ================================================================= --}}
<div id="modalHapus" class="hapus-overlay" role="dialog" aria-modal="true" aria-labelledby="modalHapusJudul">
    <div class="hapus-box">
        <div class="hapus-ikon"><i class="fas fa-trash"></i></div>
        <h5 id="modalHapusJudul" class="hapus-judul">Yakin ingin menghapus?</h5>
        <p id="modalHapusPesan" class="hapus-pesan">Data yang dihapus tidak dapat dikembalikan.</p>
        <div class="hapus-aksi">
            <button type="button" id="modalHapusBatal" class="hapus-btn hapus-btn-batal">Batal</button>
            <button type="button" id="modalHapusYa" class="hapus-btn hapus-btn-ya">
                <i class="fas fa-trash me-1"></i> Ya, Hapus
            </button>
        </div>
    </div>
</div>

<!-- Script JS (Bootstrap 4.6) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
$(document).ready(function(){
    setTimeout(function() {
        $(".alert-success").fadeOut(500, function() { $(this).remove(); });
    }, 4000);
});
</script>

<!-- Script modal konfirmasi hapus (JavaScript biasa, tidak bergantung Bootstrap/jQuery) -->
<script>
(function () {
    var overlay  = document.getElementById('modalHapus');
    var elJudul  = document.getElementById('modalHapusJudul');
    var elPesan  = document.getElementById('modalHapusPesan');
    var btnBatal = document.getElementById('modalHapusBatal');
    var btnYa    = document.getElementById('modalHapusYa');
    var formAktif = null;

    function buka(form) {
        formAktif = form;
        elJudul.textContent = form.getAttribute('data-judul') || 'Yakin ingin menghapus?';
        elPesan.textContent = form.getAttribute('data-pesan') || 'Data yang dihapus tidak dapat dikembalikan.';
        btnYa.disabled = false;
        overlay.classList.add('show');
        btnBatal.focus();
    }

    function tutup() {
        overlay.classList.remove('show');
        formAktif = null;
    }

    // Tangkap submit semua form ber-class "form-hapus"
    document.addEventListener('submit', function (e) {
        var form = e.target;
        if (form.classList && form.classList.contains('form-hapus')) {
            e.preventDefault();
            buka(form);
        }
    });

    btnYa.addEventListener('click', function () {
        if (!formAktif) return;
        btnYa.disabled = true; // cegah klik ganda
        HTMLFormElement.prototype.submit.call(formAktif);
    });

    btnBatal.addEventListener('click', tutup);

    // Klik area gelap di luar kotak = batal
    overlay.addEventListener('click', function (e) {
        if (e.target === overlay) tutup();
    });

    // Tombol Esc = batal
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && overlay.classList.contains('show')) tutup();
    });
})();
</script>

<script>
// Dropdown dengan kolom pencarian: dipakai oleh semua <select data-cari="...">.
// <select> aslinya tetap dipakai untuk kirim data, jadi validasi & controller tidak berubah.
(function () {
    function buat(sel) {
        if (sel.getAttribute('data-cs-siap')) return;
        sel.setAttribute('data-cs-siap', '1');

        var wrap = document.createElement('div');
        wrap.className = 'cs-wrap';
        sel.parentNode.insertBefore(wrap, sel);
        wrap.appendChild(sel);
        sel.classList.add('cs-native');
        sel.tabIndex = -1;

        var trigger = document.createElement('div');
        trigger.className = 'form-control cs-trigger';
        trigger.tabIndex = 0;
        var label = document.createElement('span');
        label.className = 'cs-label';
        var caret = document.createElement('i');
        caret.className = 'fas fa-chevron-down cs-caret';
        trigger.appendChild(label);
        trigger.appendChild(caret);

        var panel = document.createElement('div');
        panel.className = 'cs-panel';
        var cari = document.createElement('input');
        cari.type = 'text';
        cari.className = 'cs-search';
        cari.autocomplete = 'off';
        cari.placeholder = sel.getAttribute('data-cari') || 'Cari...';
        var list = document.createElement('ul');
        list.className = 'cs-list';
        panel.appendChild(cari);
        panel.appendChild(list);

        wrap.appendChild(trigger);
        wrap.appendChild(panel);

        var tampil = [];   // opsi yang sedang tampil
        var aktif = -1;    // indeks yang disorot

        function teks(o) { return (o.text || '').replace(/\s+/g, ' ').trim(); }

        function segarkanLabel() {
            var o = sel.options[sel.selectedIndex];
            label.textContent = o ? teks(o) : '';
            label.classList.toggle('cs-placeholder', !sel.value);
        }

        function gambar(kata) {
            kata = (kata || '').toLowerCase();
            list.innerHTML = '';
            tampil = [];
            Array.prototype.forEach.call(sel.options, function (o) {
                if (!o.value) return; // lewati opsi placeholder
                if (kata && teks(o).toLowerCase().indexOf(kata) === -1) return;
                tampil.push(o);
            });

            if (!tampil.length) {
                var kosong = document.createElement('li');
                kosong.className = 'cs-empty';
                kosong.textContent = 'Tidak ditemukan.';
                list.appendChild(kosong);
                aktif = -1;
                return;
            }

            tampil.forEach(function (o, i) {
                var li = document.createElement('li');
                li.className = 'cs-item' + (o.value === sel.value ? ' cs-selected' : '');
                li.textContent = teks(o);
                li.addEventListener('mousedown', function (e) { e.preventDefault(); pilih(o); });
                li.addEventListener('mouseenter', function () { sorot(i); });
                list.appendChild(li);
            });
            sorot(0);
        }

        function sorot(i) {
            var items = list.querySelectorAll('.cs-item');
            if (!items.length) return;
            if (i < 0) i = items.length - 1;
            if (i >= items.length) i = 0;
            Array.prototype.forEach.call(items, function (el) { el.classList.remove('cs-active'); });
            items[i].classList.add('cs-active');
            items[i].scrollIntoView({ block: 'nearest' });
            aktif = i;
        }

        function pilih(o) {
            sel.value = o.value;
            sel.dispatchEvent(new Event('change', { bubbles: true }));
            tutup();
        }

        function buka() {
            wrap.classList.add('cs-open');
            cari.value = '';
            gambar('');
            setTimeout(function () { cari.focus(); }, 0);
        }

        function tutup() {
            wrap.classList.remove('cs-open');
        }

        trigger.addEventListener('click', function () {
            wrap.classList.contains('cs-open') ? tutup() : buka();
        });
        trigger.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' || e.key === ' ' || e.key === 'ArrowDown') {
                e.preventDefault();
                buka();
            }
        });

        cari.addEventListener('input', function () { gambar(cari.value); });
        cari.addEventListener('keydown', function (e) {
            if (e.key === 'ArrowDown') { e.preventDefault(); sorot(aktif + 1); }
            else if (e.key === 'ArrowUp') { e.preventDefault(); sorot(aktif - 1); }
            else if (e.key === 'Enter') {
                e.preventDefault(); // jangan ikut mengirim form
                if (aktif > -1 && tampil[aktif]) pilih(tampil[aktif]);
            }
            else if (e.key === 'Escape') {
                e.preventDefault();
                e.stopPropagation(); // di dalam modal: Esc hanya menutup daftar, bukan modalnya
                tutup();
                trigger.focus();
            }
        });

        // Klik di luar = tutup
        document.addEventListener('mousedown', function (e) {
            if (!wrap.contains(e.target)) tutup();
        });

        // Jika nilai select berubah dari luar, tampilan ikut menyesuaikan
        sel.addEventListener('change', segarkanLabel);

        segarkanLabel();
    }

    function mulai() {
        Array.prototype.forEach.call(document.querySelectorAll('select[data-cari]'), buat);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', mulai);
    } else {
        mulai();
    }
})();
</script>
@endsection