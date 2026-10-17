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

/* Style Kartu Ringkasan Statistik */
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
.stat-card.blue { border-left: 4px solid #2563eb; }
.stat-card.yellow { border-left: 4px solid #d97706; }
.stat-card.green { border-left: 4px solid #16a34a; }

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
.badge-lunas { background-color: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
.badge-dp { background-color: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
.badge-belum { background-color: #fee2e2; color: #b91c1c; border: 1px solid #fca5a5; }

.super-thick-table th, 
.super-thick-table td {
    border-width: 2px !important;
    border-color: #cbd5e1 !important;
}

/* Tombol silang notifikasi: di ujung kanan, tanpa kotak putih */
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
    opacity: 0.8;
    text-shadow: none;
}
.alert-close:hover { opacity: 1; }
.alert-success .alert-close { color: #16a34a; }
.alert-danger .alert-close { color: #991b1b; }
</style>

<div class="container-fluid px-4 pt-3 pb-4 crm-wrapper" style="background: linear-gradient(135deg, #eef1f3 0%, #eef1f3 100%); min-height: 100vh;">

    <!-- 1. BANNER HEADER UTAMA (JUDUL RATA KIRI, TOMBOL DI KANAN) -->
    <div class="card rounded-3 mb-4 text-white shadow-sm overflow-hidden" style="background: #0f172a; border: 1px solid #1e293b;">
        <div class="card-body p-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div class="text-start">
                <h1 class="h3 mb-1 text-white fw-bold d-flex align-items-center gap-2">
                    <i class="fas fa-file-invoice-dollar text-success"></i> Closing Servis & Transaksi
                </h1>
                <p class="text-light opacity-75 mb-0" style="font-weight: 400; font-size: 0.95rem;">
                    Penyelesaian pekerjaan servis, rincian biaya, kalkulasi garansi, dan pembuatan invoice CRM Jawaratech
                </p>
            </div>
            
            <!-- Tombol Proses Closing Baru -->
            <button type="button" class="btn btn-success px-4 py-2 fw-semibold d-flex align-items-center gap-2 rounded-pill shadow-sm" style="background-color: #16a34a; border-color: #16a34a; font-size: 0.875rem;" data-toggle="modal" data-bs-toggle="modal" data-target="#modalTambahClosing" data-bs-target="#modalTambahClosing">
                <i class="fas fa-file-invoice-dollar"></i> Proses Closing Servis
            </button>
        </div>
    </div>

    <!-- Alert Notifikasi -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4 border-0 shadow-sm rounded-3" role="alert" style="background-color: #dcfce7; color: #166534;">
            <i class="fas fa-check-circle mr-2 me-2"></i> {{ session('success') }}
            <button type="button" class="alert-close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4 border-0 shadow-sm rounded-3" role="alert" style="background-color: #fee2e2; color: #991b1b;">
            <i class="fas fa-exclamation-circle mr-2 me-2"></i> {{ session('error') }}
            <button type="button" class="alert-close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mb-4 border-0 shadow-sm rounded-3" role="alert" style="background-color: #fee2e2; color: #991b1b;">
            <i class="fas fa-exclamation-triangle mr-2 me-2"></i> <strong>Gagal Menyimpan!</strong> Periksa kembali form input Anda:
            <ul class="mb-0 mt-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="alert-close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
    @endif

    <!-- 2. RINGKASAN KARTU STATISTIK -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card stat-card blue p-3 h-100">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-uppercase text-muted fw-bold small" style="font-size: 0.75rem; letter-spacing: 0.5px;">TOTAL TRANSAKSI</span>
                        <div class="d-flex align-items-baseline gap-2 mt-1">
                            <span class="fs-2 fw-bold text-dark">{{ $totalTransaksi }}</span>
                            <span class="text-secondary fw-medium">Closing</span>
                        </div>
                    </div>
                    <div class="p-3 rounded-circle bg-primary bg-opacity-10 text-primary">
                        <i class="fas fa-receipt fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card stat-card yellow p-3 h-100">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-uppercase text-muted fw-bold small" style="font-size: 0.75rem; letter-spacing: 0.5px;">TOTAL OMSET / BIAYA</span>
                        <div class="d-flex align-items-baseline gap-2 mt-1">
                            <span class="fs-2 fw-bold text-dark">{{ number_format($totalOmset, 0, ',', '.') }}</span>
                            <span class="text-secondary fw-medium">Rupiah</span>
                        </div>
                    </div>
                    <div class="p-3 rounded-circle bg-warning bg-opacity-10 text-warning">
                        <i class="fas fa-coins fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card stat-card green p-3 h-100">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-uppercase text-muted fw-bold small" style="font-size: 0.75rem; letter-spacing: 0.5px;">TRANSAKSI LUNAS</span>
                        <div class="d-flex align-items-baseline gap-2 mt-1">
                            <span class="fs-2 fw-bold text-dark">{{ $totalLunas }}</span>
                            <span class="text-secondary fw-medium">Invoice</span>
                        </div>
                    </div>
                    <div class="p-3 rounded-circle bg-success bg-opacity-10 text-success">
                        <i class="fas fa-check-circle fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. CARD UTAMA DATA CLOSING & FILTER -->
    <div class="card crm-card overflow-hidden mb-4">
        
        <!-- Header Card Tabel (Judul Rata Kiri) -->
        <div class="card-header bg-white border-bottom pt-4 px-4 pb-3 text-start">
            <h5 class="m-0 text-dark fw-bold">Daftar Transaksi Closing & Struk Nota</h5>
            <small class="text-muted">Kelola rincian biaya, status pembayaran, serta cetak kwitansi purna servis</small>
        </div>

        <!-- BAR PENCARIAN & FILTER DATA -->
        <div class="card-body border-bottom bg-white py-3 px-4">
            <form action="{{ route('closing.index') }}" method="GET" class="row g-2 align-items-center">
                <div class="col-md-5 col-sm-12 mb-2 mb-md-0">
                    <div class="input-group">
                        <div class="input-group-prepend input-group-text bg-white border-right-0 border-end-0 text-muted" style="border-radius: 6px 0 0 6px; border-color: #cbd5e1;">
                            <i class="fas fa-search"></i>
                        </div>
                        <input type="text" name="search" class="form-control crm-form-control border-left-0 border-start-0" placeholder="Cari No. Invoice, Tiket, Pelanggan, atau Teknisi..." value="{{ request('search') }}" style="border-radius: 0 6px 6px 0;">
                    </div>
                </div>

                <div class="col-md-4 col-sm-6 mb-2 mb-md-0">
                    <select name="status_pembayaran" class="form-control crm-form-control">
                        <option value="">-- Semua Status Pembayaran --</option>
                        <option value="Lunas" {{ request('status_pembayaran') == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                        <option value="DP" {{ request('status_pembayaran') == 'DP' ? 'selected' : '' }}>DP</option>
                        <option value="Belum Lunas" {{ request('status_pembayaran') == 'Belum Lunas' ? 'selected' : '' }}>Belum Lunas</option>
                    </select>
                </div>

                <div class="col-md-3 col-sm-6 d-flex">
                    <button type="submit" class="btn btn-dark w-100 shadow-sm mr-2 me-2" style="font-weight: 600; border-radius: 6px; background-color: #1e293b; border-color: #1e293b;">
                        <i class="fas fa-filter mr-1 me-1"></i> Filter
                    </button>
                    @if(request('search') || request('status_pembayaran'))
                        <a href="{{ route('closing.index') }}" class="btn btn-outline-secondary shadow-sm" title="Reset Filter" style="border-radius: 6px;">
                            <i class="fas fa-undo"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Tabel Data Closing Servis -->
        <div class="card-body p-4 bg-white">
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle mb-0 super-thick-table">
                    <thead class="crm-table-header text-uppercase text-center fs-7">
                        <tr>
                            <th class="py-3 text-white text-center" style="width: 5%;">NO</th>
                            <th class="py-3 text-white text-center" style="width: 17%;">NO INVOICE / TIKET</th>
                            <th class="py-3 text-white text-start" style="width: 18%;">PELANGGAN & UNIT</th>
                            <th class="py-3 text-white text-center" style="width: 12%;">TEKNISI</th>
                            <th class="py-3 text-white text-start" style="width: 15%;">TOTAL BIAYA</th>
                            <th class="py-3 text-white text-start" style="width: 15%;">METODE & GARANSI</th>
                            <th class="py-3 text-white text-center" style="width: 10%;">STATUS BAYAR</th>
                            <th class="py-3 text-white text-center" style="width: 8%;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody style="font-weight: 500;">
                        @forelse($closing as $s)
                            <tr>
                                <td class="px-4 py-3 text-secondary text-center fw-bold">{{ $loop->iteration }}</td>
                                <td class="py-3 text-center">
                                    <div class="text-primary fw-bold" style="font-weight: 700;">{{ $s->no_invoice }}</div>
                                    <small class="text-muted"><i class="fas fa-ticket-alt mr-1 me-1"></i>{{ $s->no_tiket }}</small>
                                </td>
                                <td class="py-3">
                                    <div class="text-dark fw-bold">{{ $s->unit->konsumen->nama ?? '-' }}</div>
                                    <small class="text-secondary">{{ $s->label_unit }}</small>
                                </td>
                                <td class="py-3 text-center text-dark fw-bold">{{ $s->teknisi->nama_teknisi ?? '-' }}</td>
                                <td class="py-3">
                                    <div class="text-dark fw-bold" style="font-weight: 700; color: #0f172a;">Rp {{ number_format($s->total_bayar, 0, ',', '.') }}</div>
                                    <small class="text-muted">Jasa: Rp {{ number_format($s->biaya_jasa, 0, ',', '.') }}</small>
                                    @if($s->status_pembayaran === 'DP')
                                        <div><small class="text-danger fw-bold">Sisa: Rp {{ number_format($s->sisa_bayar, 0, ',', '.') }}</small></div>
                                    @endif
                                </td>
                                <td class="py-3">
                                    <div class="text-dark" style="font-size: 0.88rem;">{{ $s->metode_pembayaran ?? '-' }}</div>
                                    <small class="{{ $s->masa_garansi_hari > 0 ? 'text-success' : 'text-muted' }} fw-bold"><i class="fas fa-shield-alt mr-1 me-1"></i>{{ $s->masa_garansi_hari > 0 ? 'Garansi ' . $s->label_garansi : 'Tanpa Garansi' }}</small>
                                    @if($s->garansi_berakhir)
                                        <div><small class="text-muted">s/d {{ $s->garansi_berakhir->translatedFormat('j M Y') }}</small></div>
                                    @endif
                                </td>
                                <td class="py-3 text-center">
                                    @if($s->status_pembayaran == 'Lunas')
                                        <span class="badge crm-badge badge-lunas"><i class="fas fa-check-circle mr-1 me-1"></i> LUNAS</span>
                                    @elseif($s->status_pembayaran == 'DP')
                                        <span class="badge crm-badge badge-dp"><i class="fas fa-clock mr-1 me-1"></i> DP</span>
                                    @else
                                        <span class="badge crm-badge badge-belum"><i class="fas fa-exclamation-circle mr-1 me-1"></i> BELUM LUNAS</span>
                                    @endif
                                </td>
                                <td class="py-3 text-center">
                                    <div class="d-flex justify-content-center align-items-center gap-1 flex-nowrap">
                                        <!-- Tombol Edit -->
                                        <button type="button" class="btn btn-sm btn-outline-primary shadow-sm px-2 py-1" title="Edit Closing / Pelunasan" style="border-radius: 4px;" data-toggle="modal" data-bs-toggle="modal" data-target="#modalEditClosing{{ $s->id_servis }}" data-bs-target="#modalEditClosing{{ $s->id_servis }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        
                                        <!-- Tombol Cetak -->
                                        <a href="{{ route('closing.cetak', $s->id_servis) }}" target="_blank" class="btn btn-sm btn-outline-success shadow-sm px-2 py-1" title="Cetak Kwitansi / Struk Closing" style="border-radius: 4px;">
                                            <i class="fas fa-print"></i>
                                        </a>
                                        
                                        <!-- Tombol Batalkan Closing -->
                                        <form action="{{ route('closing.destroy', $s->id_servis) }}" method="POST" class="d-inline" onsubmit="return confirm('Batalkan closing {{ $s->no_invoice }}? Data invoice akan dikosongkan dan tiket kembali ke Proses Servis.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger shadow-sm px-2 py-1" title="Batalkan / Hapus Closing" style="border-radius: 4px;">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">Belum ada transaksi closing.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- MODAL EDIT (satu per data, di luar tabel) --}}
@foreach($closing as $s)
    @include('closing.edit', ['s' => $s])
@endforeach

<!-- Include Modal Tambah -->
@include('closing.create')

<!-- Datalist Global nama teknisi (dari tabel ms_teknisi) -->
<datalist id="datalist_teknisi">
    @foreach($teknisi as $namaTeknisi)
        <option value="{{ $namaTeknisi }}"></option>
    @endforeach
</datalist>

<!-- Script JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
$(document).ready(function(){
    setTimeout(function() {
        $(".alert-success").fadeOut(500, function() { $(this).remove(); });
    }, 4000);

    // Buka kembali modal yang gagal disimpan, supaya isian tidak hilang
    @php $modalBuka = old('_modal'); @endphp
    @if($errors->any() && $modalBuka)
        $('#{{ $modalBuka === 'tambah' ? 'modalTambahClosing' : 'modalEditClosing' . (int) substr($modalBuka, 5) }}').modal('show');
    @endif
});

// Hitung total, tampilkan kolom DP, dan isi teknisi otomatis (semua form closing)
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.form-closing').forEach(function (form) {
        var jasa = form.querySelector('.in-jasa'), sp = form.querySelector('.in-sparepart'), dk = form.querySelector('.in-diskon');
        var lbl = form.querySelector('.lbl-total'), st = form.querySelector('.in-status');
        var grp = form.querySelector('.grp-dp'), dp = form.querySelector('.in-dp');
        var tiket = form.querySelector('.in-tiket'), tek = form.querySelector('.in-teknisi');

        function hitung() {
            var total = (parseFloat(jasa.value) || 0) + (parseFloat(sp.value) || 0) - (parseFloat(dk.value) || 0);
            if (total < 0) total = 0;
            lbl.textContent = 'Rp ' + total.toLocaleString('id-ID');
        }

        function aturDp() {
            var tampil = st.value === 'DP';
            grp.style.display = tampil ? '' : 'none';
            dp.required = tampil;
        }

        [jasa, sp, dk].forEach(function (el) { el.addEventListener('input', hitung); });
        st.addEventListener('change', aturDp);

        if (tiket && tek) {
            tiket.addEventListener('change', function () {
                var o = tiket.options[tiket.selectedIndex];
                if (o && o.getAttribute('data-teknisi')) tek.value = o.getAttribute('data-teknisi');
            });
        }

        hitung();
        aturDp();
    });
});
</script>
@endsection