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
.alert-close:hover { opacity: 1; }
.alert-close.alert-close-top { top: 12px; transform: none; }
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
.stat-card.yellow { border-left: 4px solid #d97706 !important; }
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

/* Lebar modal */
.modal-custom-size {
    max-width: 560px !important;
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
</style>

<div class="container-fluid px-4 pt-3 pb-4 crm-wrapper" style="background: linear-gradient(135deg, #eef1f3 0%, #eef1f3 100%); min-height: 100vh;">

    <!-- BANNER UTAMA -->
    <div class="card rounded-3 mb-4 text-white shadow-sm overflow-hidden" style="background: #0f172a; border: 1px solid #1e293b;">
        <div class="card-body p-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h1 class="h4 mb-1 text-white fw-bold d-flex align-items-center gap-2">
                    <i class="fas fa-user-cog text-info"></i> Data Teknisi
                </h1>
                <p class="text-light opacity-75 mb-0" style="font-weight: 400; font-size: 0.85rem;">
                    Kelola daftar teknisi penanggung jawab servis Jawaratech
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
            <i class="fas fa-exclamation-triangle mr-2"></i> <strong>Gagal Menyimpan!</strong> Periksa kembali isian Anda:
            <ul class="mb-0 mt-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="alert-close alert-close-top" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
    @endif

    <!-- KARTU STATISTIK -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3 mb-md-0">
            <div class="card stat-card blue h-100 p-3 border-0">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted text-uppercase mb-1" style="font-size: 0.75rem; font-weight: 600;">Total Teknisi</p>
                        <h4 class="mb-0 fw-bold text-dark">{{ $totalTeknisi }} <span style="font-size: 0.9rem; font-weight: 500; color: #64748b;">Orang</span></h4>
                    </div>
                    <div class="rounded p-2" style="background-color: #e0f2fe; color: #0284c7;">
                        <i class="fas fa-user-cog fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3 mb-md-0">
            <div class="card stat-card yellow h-100 p-3 border-0">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted text-uppercase mb-1" style="font-size: 0.75rem; font-weight: 600;">Sedang Menangani Servis</p>
                        <h4 class="mb-0 fw-bold text-dark">{{ $teknisiBertugas }} <span style="font-size: 0.9rem; font-weight: 500; color: #64748b;">Orang</span></h4>
                    </div>
                    <div class="rounded p-2" style="background-color: #fef3c7; color: #d97706;">
                        <i class="fas fa-wrench fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card green h-100 p-3 border-0">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted text-uppercase mb-1" style="font-size: 0.75rem; font-weight: 600;">Total Servis Ditangani</p>
                        <h4 class="mb-0 fw-bold text-dark">{{ $totalServis }} <span style="font-size: 0.9rem; font-weight: 500; color: #64748b;">Tiket</span></h4>
                    </div>
                    <div class="rounded p-2" style="background-color: #dcfce3; color: #15803d;">
                        <i class="fas fa-check-circle fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card crm-card overflow-hidden mb-4">
        <div class="card-header bg-white border-bottom pt-4 px-4 pb-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h5 class="m-0 text-dark fw-bold">Daftar Teknisi Jawaratech</h5>
                <small class="text-muted">Nama teknisi di sini muncul sebagai saran saat registrasi dan closing servis</small>
            </div>
            <div class="d-flex align-items-center flex-wrap gap-2">
                <div class="position-relative" style="min-width: 240px;">
                    <input type="text" id="searchInput" class="form-control form-control-sm ps-5 pe-3 py-2 bg-white text-dark" placeholder="Cari nama teknisi..." style="border-radius: 20px; border: 1px solid #cbd5e1; font-size: 0.875rem; padding-left: 38px !important;">
                    <i class="fas fa-search position-absolute text-secondary" style="left: 15px; top: 50%; transform: translateY(-50%); font-size: 0.85rem;"></i>
                </div>
                <button type="button" class="btn btn-primary px-3 py-2 fw-semibold rounded-pill shadow-sm text-sm" data-toggle="modal" data-target="#modalTambahTeknisi">
                    <i class="fas fa-plus-circle mr-1"></i> Tambah Teknisi
                </button>
            </div>
        </div>
        <div class="card-body p-4 bg-white">
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle mb-0 super-thick-table" id="tableTeknisi">
                    <thead class="crm-table-header text-uppercase text-center fs-7">
                        <tr>
                            <th class="py-3 text-white text-center" style="width: 6%;">NO</th>
                            <th class="py-3 text-white text-center" style="width: 38%;">NAMA TEKNISI</th>
                            <th class="py-3 text-white text-center" style="width: 18%;">SERVIS AKTIF</th>
                            <th class="py-3 text-white text-center" style="width: 18%;">TOTAL SERVIS</th>
                            <th class="py-3 text-white text-center" style="width: 20%; min-width: 100px;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody style="font-weight: 500;">
                        @forelse($teknisi as $t)
                        @php
                            $stat   = $statistik->get($t->id_teknisi);
                            $aktif  = (int) ($stat->aktif ?? 0);
                            $total  = (int) ($stat->total ?? 0);
                        @endphp
                        <tr>
                            <td class="px-4 py-3 text-secondary text-center fw-bold">{{ $loop->iteration }}</td>
                            <td class="py-3 text-dark fw-bold"><i class="fas fa-user-cog text-secondary me-2 mr-2"></i>{{ $t->nama_teknisi }}</td>
                            <td class="py-3 text-center">
                                @if($aktif > 0)
                                    <span class="badge" style="background-color: #fef3c7; color: #92400e; border: 1px solid #fde68a;">{{ $aktif }} Tiket</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="py-3 text-center"><span class="badge bg-primary text-white px-2 py-1">{{ $total }} Tiket</span></td>
                            <td class="py-3 text-center">
                                <div class="aksi-wrap">
                                    <button type="button" class="btn btn-sm btn-outline-primary shadow-sm px-2 py-1" title="Ubah nama" data-toggle="modal" data-target="#modalEditTeknisi{{ $t->id_teknisi }}"><i class="fas fa-edit"></i></button>

                                    <form action="{{ route('data-teknisi.destroy', $t->id_teknisi) }}" method="POST" class="d-inline form-hapus" data-judul="Yakin ingin menghapus?" data-pesan="Teknisi {{ $t->nama_teknisi }} akan dihapus dan tidak dapat dikembalikan.">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger shadow-sm px-2 py-1" @if($total > 0) disabled title="Sudah memiliki riwayat servis, tidak bisa dihapus" @else title="Hapus" @endif><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Belum ada data teknisi. Klik "Tambah Teknisi" atau isi nama teknisi saat registrasi servis.</td>
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

<!-- Modal Tambah Teknisi -->
<div class="modal fade crm-wrapper" id="modalTambahTeknisi" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-custom-size modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 10px; border: none; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.2);">
            <div class="modal-header py-3 px-4 text-white" style="background-color: #1e293b; border-bottom: 1px solid #1e293b; border-top-left-radius: 10px; border-top-right-radius: 10px;">
                <h5 class="modal-title text-white mb-0" style="font-weight: 700; font-size: 1.15rem;"><i class="fas fa-plus-circle mr-2"></i>Tambah Teknisi</h5>
                <button type="button" data-dismiss="modal" aria-label="Close" style="color: #ffffff; opacity: 1; background: transparent; border: none; font-size: 1.5rem; padding: 0; line-height: 1;"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="{{ route('data-teknisi.store') }}" method="POST" autocomplete="off">
                @csrf
                <input type="hidden" name="_form" value="tambah">
                <div class="modal-body p-4 bg-white text-dark">
                    <div class="mb-2">
                        <label class="text-dark" style="font-size: 0.875rem; font-weight: 600;">Nama Teknisi <span class="text-danger">*</span></label>
                        <input type="text" name="nama_teknisi" class="form-control py-2" placeholder="Contoh: Agus" maxlength="45" value="{{ old('_form') === 'tambah' ? old('nama_teknisi') : '' }}" required style="border-radius: 6px;">
                    </div>
                </div>
                <div class="modal-footer px-4 py-3" style="border-top: 1px solid #e2e8f0; background-color: #f8fafc; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
                    <button type="button" class="btn btn-light px-4 py-2" data-dismiss="modal" style="font-weight: 600; border-radius: 6px; border: 1px solid #cbd5e1;">Batal</button>
                    <button type="submit" class="btn btn-primary px-4 py-2" style="font-weight: 600; border-radius: 6px; background-color: #2563eb; border-color: #2563eb;"><i class="fas fa-save mr-1"></i> Simpan Teknisi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Teknisi (satu per data) -->
@foreach($teknisi as $t)
<div class="modal fade crm-wrapper" id="modalEditTeknisi{{ $t->id_teknisi }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-custom-size modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 10px; border: none; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.2);">
            <div class="modal-header py-3 px-4 text-white" style="background-color: #1e293b; border-bottom: 1px solid #1e293b; border-top-left-radius: 10px; border-top-right-radius: 10px;">
                <h5 class="modal-title text-white mb-0" style="font-weight: 700; font-size: 1.15rem;"><i class="fas fa-edit mr-2"></i>Ubah Nama Teknisi</h5>
                <button type="button" data-dismiss="modal" aria-label="Close" style="color: #ffffff; opacity: 1; background: transparent; border: none; font-size: 1.5rem; padding: 0; line-height: 1;"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="{{ route('data-teknisi.update', $t->id_teknisi) }}" method="POST" autocomplete="off">
                @csrf
                @method('PUT')
                <input type="hidden" name="_form" value="edit:{{ $t->id_teknisi }}">
                <div class="modal-body p-4 bg-white text-dark">
                    <div class="mb-2">
                        <label class="text-dark" style="font-size: 0.875rem; font-weight: 600;">Nama Teknisi <span class="text-danger">*</span></label>
                        <input type="text" name="nama_teknisi" class="form-control py-2" maxlength="45" value="{{ old('_form') === 'edit:' . $t->id_teknisi ? old('nama_teknisi') : $t->nama_teknisi }}" required style="border-radius: 6px;">
                        <small class="text-muted">Perubahan nama juga berlaku pada tiket dan nota lama teknisi ini.</small>
                    </div>
                </div>
                <div class="modal-footer px-4 py-3" style="border-top: 1px solid #e2e8f0; background-color: #f8fafc; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
                    <button type="button" class="btn btn-light px-4 py-2" data-dismiss="modal" style="font-weight: 600; border-radius: 6px; border: 1px solid #cbd5e1;">Batal</button>
                    <button type="submit" class="btn btn-primary px-4 py-2" style="font-weight: 600; border-radius: 6px; background-color: #2563eb; border-color: #2563eb;"><i class="fas fa-save mr-1"></i> Perbarui</button>
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

    // Pencarian nama teknisi
    $("#searchInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#tableTeknisi tbody tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });

    // Buka kembali modal yang gagal tervalidasi supaya isian tidak hilang
    @if($errors->any() && old('_form') === 'tambah')
        $('#modalTambahTeknisi').modal('show');
    @elseif($errors->any() && str_starts_with((string) old('_form'), 'edit:'))
        $('#modalEditTeknisi{{ substr((string) old('_form'), 5) }}').modal('show');
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