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
.stat-card.blue { border-left: 4px solid #3b82f6 !important; }
.stat-card.green { border-left: 4px solid #10b981 !important; }

.crm-table-header {
    background-color: #1e293b;
    color: #ffffff;
    font-weight: 600;
    letter-spacing: 0.5px;
}
.crm-table-header th {
    text-align: center !important;
    vertical-align: middle !important;
}
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

    <!-- BANNER UTAMA -->
    <div class="card rounded-3 mb-4 text-white shadow-sm overflow-hidden" style="background: #0f172a; border: 1px solid #1e293b;">
        <div class="card-body p-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h1 class="h4 mb-1 text-white fw-bold d-flex align-items-center gap-2">
                    <i class="fas fa-address-book text-info"></i> Data Konsumen
                </h1>
                <p class="text-light opacity-75 mb-0" style="font-weight: 400; font-size: 0.85rem;">
                    Kelola data konsumen Jawaratech
                </p>
            </div>
        </div>
    </div>

    <!-- Alert Notifikasi -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4 border-0 shadow-sm rounded-3" role="alert" style="background-color: #dcfce7; color: #166534;">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="close float-end" data-dismiss="alert" data-bs-dismiss="alert" aria-label="Close" style="background:transparent; border:none; font-size:1.2rem;">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4 border-0 shadow-sm rounded-3" role="alert" style="background-color: #fee2e2; color: #991b1b;">
            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
            <button type="button" class="close float-end" data-dismiss="alert" data-bs-dismiss="alert" aria-label="Close" style="background:transparent; border:none; font-size:1.2rem;">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mb-4 border-0 shadow-sm rounded-3" role="alert" style="background-color: #fee2e2; color: #991b1b;">
            <i class="fas fa-exclamation-triangle me-2"></i> <strong>Gagal Menyimpan!</strong> Periksa kembali form input Anda:
            <ul class="mb-0 mt-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close float-end" data-dismiss="alert" data-bs-dismiss="alert" aria-label="Close" style="background:transparent; border:none; font-size:1.2rem;">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- KARTU STATISTIK DATA KONSUMEN -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card stat-card blue h-100 p-3 border-0">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted text-uppercase mb-1" style="font-size: 0.75rem; font-weight: 600;">Total Konsumen</p>
                        <h4 class="mb-0 fw-bold text-dark">{{ $totalKonsumen }} <span style="font-size: 0.9rem; font-weight: 500; color: #64748b;">Orang</span></h4>
                    </div>
                    <div class="bg-primary bg-opacity-10 rounded p-2 text-primary" style="background-color: #e0f2fe; color: #0284c7;">
                        <i class="fas fa-user-friends fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card blue h-100 p-3 border-0">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted text-uppercase mb-1" style="font-size: 0.75rem; font-weight: 600;">Total Unit Terdaftar</p>
                        <h4 class="mb-0 fw-bold text-dark">{{ $totalUnit }} <span style="font-size: 0.9rem; font-weight: 500; color: #64748b;">Unit</span></h4>
                    </div>
                    <div class="bg-primary bg-opacity-10 rounded p-2 text-primary" style="background-color: #e0f2fe; color: #0284c7;">
                        <i class="fas fa-box fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card green h-100 p-3 border-0">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted text-uppercase mb-1" style="font-size: 0.75rem; font-weight: 600;">Unit Bergaransi</p>
                        <h4 class="mb-0 fw-bold text-dark">{{ $unitGaransi }} <span style="font-size: 0.9rem; font-weight: 500; color: #64748b;">Unit</span></h4>
                    </div>
                    <div class="bg-success bg-opacity-10 rounded p-2 text-success" style="background-color: #dcfce3; color: #15803d;">
                        <i class="fas fa-shield-alt fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card crm-card overflow-hidden mb-4">
        <div class="card-header bg-white border-bottom pt-4 px-4 pb-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h5 class="m-0 text-dark fw-bold">Daftar Konsumen Jawaratech</h5>
                <small class="text-muted">Buku kontak dan master informasi pelanggan sistem CRM Jawaratech</small>
            </div>
            <button type="button" class="btn btn-primary px-3 py-2 fw-semibold rounded-pill shadow-sm text-sm" data-toggle="modal" data-bs-toggle="modal" data-target="#modalTambahKonsumen" data-bs-target="#modalTambahKonsumen">
                <i class="fas fa-user-plus mr-1 me-1"></i> Tambah Konsumen
            </button>
        </div>
        <div class="card-body p-4 bg-white">
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle mb-0 super-thick-table">
                    <thead class="crm-table-header text-uppercase text-center fs-7">
                        <tr>
                            <th class="py-3 text-white text-center" style="width: 6%;">NO</th>
                            <th class="py-3 text-white text-center" style="width: 22%;">NAMA KONSUMEN</th>
                            <th class="py-3 text-white text-center" style="width: 22%;">NOMOR WHATSAPP</th>
                            <th class="py-3 text-white text-center" style="width: 25%;">ALAMAT DOMISILI</th>
                            <th class="py-3 text-white text-center" style="width: 12%;">JUMLAH UNIT</th>
                            <th class="py-3 text-white text-center" style="width: 13%; min-width: 100px;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody style="font-weight: 500;">
                        @forelse($konsumen as $k)
                        <tr>
                            <td class="px-4 py-3 text-secondary text-center fw-bold">{{ $loop->iteration }}</td>
                            <td class="py-3 text-dark fw-bold">{{ $k->nama }}</td>
                            <td class="py-3 text-success fw-semibold"><i class="fab fa-whatsapp"></i> {{ $k->no_whatsapp }}</td>
                            <td class="py-3 text-secondary">{{ $k->alamat }}</td>
                            <td class="py-3 text-center"><span class="badge bg-primary text-white px-2 py-1">{{ $k->unit_count }} Unit</span></td>
                            <td class="py-3 text-center">
                                <div class="aksi-wrap">
                                    <button type="button" class="btn btn-sm btn-outline-primary shadow-sm px-2 py-1" title="Ubah data" data-toggle="modal" data-bs-toggle="modal" data-target="#modalEditKonsumen{{ $k->id_konsumen }}" data-bs-target="#modalEditKonsumen{{ $k->id_konsumen }}">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <form action="{{ route('hapus-konsumen', $k->id_konsumen) }}" method="POST" class="d-inline form-hapus" data-judul="Yakin ingin menghapus?" data-pesan="Data konsumen {{ $k->nama }} akan dihapus dan tidak dapat dikembalikan.">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger shadow-sm px-2 py-1" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Belum ada data konsumen yang terdaftar.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

{{-- MODAL (di luar container agar tidak tertutup layar gelap) --}}
@include('data-konsumen.create')

@foreach($konsumen as $k)
    @include('data-konsumen.edit', ['k' => $k])
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
@endsection