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
.badge-menunggu { background-color: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; }
.badge-dicek { background-color: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
.badge-proses { background-color: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; }
.badge-selesai { background-color: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }

.super-thick-table th, 
.super-thick-table td {
    border-width: 2px !important;
    border-color: #cbd5e1 !important;
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

    <!-- Alert Notifikasi -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4 border-0 shadow-sm rounded-3" role="alert" style="background-color: #dcfce7; color: #166534;">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4 border-0 shadow-sm rounded-3" role="alert" style="background-color: #fee2e2; color: #991b1b;">
            <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
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
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
    @endif

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
                <div class="col-md-4 col-sm-12 mb-2 mb-md-0">
                    <div class="input-group">
                        <div class="input-group-prepend input-group-text bg-white border-right-0 border-end-0 text-muted" style="border-radius: 6px 0 0 6px; border-color: #cbd5e1;">
                            <i class="fas fa-search"></i>
                        </div>
                        <input type="text" name="search" class="form-control crm-form-control border-left-0 border-start-0" placeholder="Cari Tiket, Pelanggan, Unit, atau Teknisi..." value="{{ request('search') }}" style="border-radius: 0 6px 6px 0;">
                    </div>
                </div>

                <!-- Filter periode berdasarkan tanggal masuk -->
                <div class="col-md-2 col-sm-6 mb-2 mb-md-0">
                    <select name="periode" class="form-control crm-form-control">
                        <option value="">-- Semua Periode --</option>
                        @foreach(['hari_ini' => 'Hari Ini', 'minggu_ini' => 'Minggu Ini', 'bulan_ini' => 'Bulan Ini', 'tahun_ini' => 'Tahun Ini'] as $nilai => $label)
                            <option value="{{ $nilai }}" {{ request('periode') === $nilai ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter status servis -->
                <div class="col-md-3 col-sm-6 mb-2 mb-md-0">
                    <select name="status" class="form-control crm-form-control">
                        <option value="">-- Semua Status --</option>
                        @foreach(['Menunggu Konfirmasi', 'Sedang Dicek', 'Proses Servis', 'Selesai'] as $st)
                            <option value="{{ $st }}" {{ request('status') === $st ? 'selected' : '' }}>{{ $st }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3 col-sm-12 d-flex">
                    <button type="submit" class="btn btn-dark w-100 shadow-sm mr-2 me-2" style="font-weight: 600; border-radius: 6px; background-color: #1e293b; border-color: #1e293b;">
                        <i class="fas fa-filter mr-1 me-1"></i> Filter
                    </button>
                    @if(request()->filled('search') || request()->filled('periode') || request()->filled('status'))
                        <a href="{{ route('registrasi-servis.index') }}" class="btn btn-light shadow-sm" title="Reset filter" style="border: 1px solid #cbd5e1; border-radius: 6px;">
                            <i class="fas fa-times"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <div class="card-body p-4 bg-white">
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle mb-0 super-thick-table">
                    <thead class="crm-table-header text-uppercase text-center fs-7">
                        <tr>
                            <th class="py-3 text-white text-center" style="width: 4%;">NO</th>
                            <th class="py-3 text-white text-center" style="width: 11%;">NO TIKET / SPK</th>
                            <th class="py-3 text-white text-center" style="width: 13%;">PELANGGAN</th>
                            <th class="py-3 text-white text-center" style="width: 9%;">TGL MASUK</th>
                            <th class="py-3 text-white text-center" style="width: 10%;">PERKIRAAN SELESAI</th>
                            <th class="py-3 text-white text-center" style="width: 14%;">UNIT & MEREK</th>
                            <th class="py-3 text-white text-center" style="width: 14%;">KELUHAN</th>
                            <th class="py-3 text-white text-center" style="width: 9%;">TEKNISI</th>
                            <th class="py-3 text-white text-center" style="width: 10%;">STATUS SERVIS</th>
                            <th class="py-3 text-white text-center" style="width: 6%;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody style="font-weight: 500;">
                        @forelse($tiket as $t)
                        <tr>
                            <td class="px-3 py-3 text-secondary text-center">{{ $loop->iteration }}</td>
                            <td class="py-3 text-center text-primary fw-bold" style="font-weight: 700;">{{ $t->no_tiket }}</td>
                            <td class="py-3">
                                <div class="text-dark" style="font-weight: 600;">{{ $t->unit->konsumen->nama ?? '-' }}</div>
                                <small class="text-muted">{{ $t->unit->konsumen->no_whatsapp ?? '-' }}</small>
                            </td>
                            <td class="py-3 text-center text-dark small">
                                {{ $t->tanggal_masuk ? \Carbon\Carbon::parse($t->tanggal_masuk)->format('d/m/Y') : '-' }}
                            </td>
                            <td class="py-3 text-center text-dark small">
                                {{ $t->tanggal_estimasi_selesai ? \Carbon\Carbon::parse($t->tanggal_estimasi_selesai)->format('d/m/Y') : '-' }}
                            </td>
                            <td class="py-3 text-secondary">{{ $t->label_unit }}</td>
                            <td class="py-3 text-secondary small">{{ \Illuminate\Support\Str::limit($t->keluhan, 80) }}</td>
                            <td class="py-3 text-center text-dark fw-bold">{{ $t->teknisi->nama_teknisi ?? '-' }}</td>
                            <td class="py-3 text-center">
                                @if($t->status == 'Menunggu Konfirmasi')
                                    <span class="badge crm-badge badge-menunggu">
                                        <i class="fas fa-hourglass-half mr-1 me-1"></i> Menunggu Konfirmasi
                                    </span>
                                @elseif($t->status == 'Sedang Dicek')
                                    <span class="badge crm-badge badge-dicek">
                                        <i class="fas fa-search mr-1 me-1"></i> Sedang Dicek
                                    </span>
                                @elseif($t->status == 'Selesai')
                                    <span class="badge crm-badge badge-selesai">
                                        <i class="fas fa-check-circle mr-1 me-1"></i> Selesai
                                    </span>
                                @else
                                    <span class="badge crm-badge badge-proses">
                                        <i class="fas fa-cog fa-spin mr-1 me-1"></i> {{ $t->status }}
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 text-center">
                                <div class="d-flex justify-content-center align-items-center gap-1">
                                    <button type="button" class="btn btn-sm btn-outline-primary shadow-sm px-2 py-1" title="Ubah data" data-toggle="modal" data-target="#modalEditRegistrasi{{ $t->id_servis }}"><i class="fas fa-edit"></i></button>
                                    <a href="{{ route('registrasi-servis.cetak', $t->id_servis) }}" target="_blank" class="btn btn-sm btn-outline-success shadow-sm px-2 py-1" title="Cetak Tanda Terima"><i class="fas fa-print"></i></a>

                                    <form action="{{ route('registrasi-servis.destroy', $t->id_servis) }}" method="POST" class="d-inline form-hapus" data-judul="Yakin ingin menghapus?" data-pesan="Tiket {{ $t->no_tiket }} akan dihapus dan tidak dapat dikembalikan.">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger shadow-sm px-2 py-1" title="Hapus"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted py-4">Belum ada tiket servis yang terdaftar.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

{{-- MODAL EDIT TIKET (satu per data, di luar container) --}}
@foreach($tiket as $t)
    @include('registrasi.edit', ['t' => $t])
@endforeach

<!-- Include Modal Tambah Registrasi -->
@include('registrasi.create')

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

    // Buka kembali modal tambah jika validasi gagal, supaya isian tidak hilang
    @if($errors->any() && session('_modal') === 'tambah')
        $('#modalTambahRegistrasi').modal('show');
    @endif
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
@endsection