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
.stat-card.yellow { border-left: 4px solid #f59e0b !important; }
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
.badge-lunas { background-color: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
.badge-dp    { background-color: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
.badge-belum { background-color: #fee2e2; color: #b91c1c; border: 1px solid #fecaca; }

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
.modal-body-scroll {
    max-height: 70vh;
    overflow-y: auto;
}
.total-box {
    background: #f1f5f9;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    padding: 10px 14px;
    font-weight: 700;
}
.total-box .lbl-total { color: #1d4ed8; font-size: 1.1rem; }
</style>

<div class="container-fluid px-4 pt-3 pb-4 crm-wrapper" style="background: linear-gradient(135deg, #eef1f3 0%, #eef1f3 100%); min-height: 100vh;">

    <!-- ================================================================= -->
    <!-- BANNER UTAMA                                                      -->
    <!-- ================================================================= -->
    <div class="card rounded-3 mb-4 text-white shadow-sm overflow-hidden" style="background: #0f172a; border: 1px solid #1e293b;">
        <div class="card-body p-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h1 class="h4 mb-1 text-white fw-bold d-flex align-items-center gap-2">
                    <i class="fas fa-check-circle text-info"></i> Closing Servis (FR04)
                </h1>
                <p class="text-light opacity-75 mb-0" style="font-weight: 400; font-size: 0.85rem;">
                    Selesaikan tiket servis, catat biaya &amp; pembayaran, terbitkan invoice, dan cetak nota
                </p>
            </div>
        </div>
    </div>

    <!-- Alert Notifikasi Sukses / Error -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4 border-0 shadow-sm rounded-3" role="alert" style="background-color: #dcfce7; color: #166534;">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="background:transparent; border:none; font-size:1.2rem;">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4 border-0 shadow-sm rounded-3" role="alert" style="background-color: #fee2e2; color: #991b1b;">
            <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="background:transparent; border:none; font-size:1.2rem;">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Alert Error Validasi Laravel -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mb-4 border-0 shadow-sm rounded-3" role="alert" style="background-color: #fee2e2; color: #991b1b;">
            <i class="fas fa-exclamation-triangle mr-2"></i> <strong>Gagal Menyimpan!</strong> Periksa kembali form input Anda:
            <ul class="mb-0 mt-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="background:transparent; border:none; font-size:1.2rem;">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- ================================================================= -->
    <!-- KARTU STATISTIK                                                   -->
    <!-- ================================================================= -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card stat-card blue h-100 p-3 border-0">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted text-uppercase mb-1" style="font-size: 0.75rem; font-weight: 600;">Total Transaksi Closing</p>
                        <h4 class="mb-0 fw-bold text-dark">{{ $totalTransaksi }} <span style="font-size: 0.9rem; font-weight: 500; color: #64748b;">Invoice</span></h4>
                    </div>
                    <div class="rounded p-2" style="background-color: #e0f2fe; color: #0284c7;">
                        <i class="fas fa-file-invoice fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card yellow h-100 p-3 border-0">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted text-uppercase mb-1" style="font-size: 0.75rem; font-weight: 600;">Total Omset</p>
                        <h4 class="mb-0 fw-bold text-dark">Rp {{ number_format($totalOmset, 0, ',', '.') }}</h4>
                    </div>
                    <div class="rounded p-2" style="background-color: #fef3c7; color: #d97706;">
                        <i class="fas fa-money-bill-wave fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card green h-100 p-3 border-0">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted text-uppercase mb-1" style="font-size: 0.75rem; font-weight: 600;">Transaksi Lunas</p>
                        <h4 class="mb-0 fw-bold text-dark">{{ $totalLunas }} <span style="font-size: 0.9rem; font-weight: 500; color: #64748b;">Invoice</span></h4>
                    </div>
                    <div class="rounded p-2" style="background-color: #dcfce3; color: #15803d;">
                        <i class="fas fa-check-circle fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ================================================================= -->
    <!-- DAFTAR CLOSING                                                    -->
    <!-- ================================================================= -->
    <div class="card crm-card overflow-hidden mb-4">
        <div class="card-header bg-white border-bottom pt-4 px-4 pb-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h5 class="m-0 text-dark fw-bold">Daftar Invoice Closing</h5>
                <small class="text-muted">Riwayat closing servis, status pembayaran, dan cetak nota pelanggan</small>
            </div>
            <button type="button" class="btn btn-primary px-3 py-2 fw-semibold rounded-pill shadow-sm text-sm" data-toggle="modal" data-target="#modalTambahClosing">
                <i class="fas fa-file-invoice-dollar mr-1"></i> Tambah Closing
            </button>
        </div>

        <!-- Bar Filter & Pencarian -->
        <div class="card-body border-bottom bg-white py-3 px-4">
            <form action="{{ route('closing.index') }}" method="GET" autocomplete="off" class="row align-items-center">
                <div class="col-md-5 col-sm-12 mb-2 mb-md-0">
                    <div class="input-group">
                        <div class="input-group-prepend input-group-text bg-white border-right-0 border-end-0 text-muted" style="border-radius: 6px 0 0 6px; border-color: #cbd5e1;">
                            <i class="fas fa-search"></i>
                        </div>
                        <input type="text" name="search" class="form-control crm-form-control border-left-0 border-start-0" placeholder="Cari Invoice, Tiket, Pelanggan, atau Teknisi..." value="{{ request('search') }}" style="border-radius: 0 6px 6px 0;">
                    </div>
                </div>

                <div class="col-md-4 col-sm-6 mb-2 mb-md-0">
                    <select name="status_pembayaran" class="form-control crm-form-control">
                        <option value="">-- Semua Status Pembayaran --</option>
                        @foreach(['Belum Lunas', 'DP', 'Lunas'] as $st)
                            <option value="{{ $st }}" {{ request('status_pembayaran') === $st ? 'selected' : '' }}>{{ $st }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3 col-sm-6 d-flex">
                    <button type="submit" class="btn btn-dark w-100 shadow-sm mr-2 me-2" style="font-weight: 600; border-radius: 6px; background-color: #1e293b; border-color: #1e293b;">
                        <i class="fas fa-filter mr-1 me-1"></i> Filter
                    </button>
                    @if(request()->filled('search') || request()->filled('status_pembayaran'))
                        <a href="{{ route('closing.index') }}" class="btn btn-light shadow-sm" style="font-weight: 600; border-radius: 6px; border: 1px solid #cbd5e1;" title="Reset filter"><i class="fas fa-undo"></i></a>
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
                            <th class="py-3 text-white text-center" style="width: 14%;">NO INVOICE / TIKET</th>
                            <th class="py-3 text-white text-center" style="width: 14%;">PELANGGAN</th>
                            <th class="py-3 text-white text-center" style="width: 17%;">UNIT</th>
                            <th class="py-3 text-white text-center" style="width: 10%;">TEKNISI</th>
                            <th class="py-3 text-white text-center" style="width: 13%;">TOTAL BAYAR</th>
                            <th class="py-3 text-white text-center" style="width: 12%;">PEMBAYARAN</th>
                            <th class="py-3 text-white text-center" style="width: 8%;">TGL CLOSING</th>
                            <th class="py-3 text-white text-center" style="width: 12%; min-width: 130px;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody style="font-weight: 500;">
                        @forelse($closing as $c)
                        @php
                            $kelasBayar = $c->status_pembayaran === 'Lunas' ? 'badge-lunas' : ($c->status_pembayaran === 'DP' ? 'badge-dp' : 'badge-belum');
                        @endphp
                        <tr>
                            <td class="px-3 py-3 text-secondary text-center">{{ $loop->iteration }}</td>
                            <td class="py-3 text-center">
                                <div class="text-primary fw-bold" style="font-weight: 700;">{{ $c->no_invoice }}</div>
                                <small class="text-muted">{{ $c->no_tiket }}</small>
                            </td>
                            <td class="py-3">
                                <div class="text-dark" style="font-weight: 600;">{{ $c->unit->konsumen->nama ?? '-' }}</div>
                                <small class="text-muted">{{ $c->unit->konsumen->no_whatsapp ?? '' }}</small>
                            </td>
                            <td class="py-3 text-secondary">{{ $c->label_unit }}</td>
                            <td class="py-3 text-center text-dark fw-bold">{{ $c->teknisi->nama_teknisi ?? '-' }}</td>
                            <td class="py-3 text-right" style="white-space: nowrap;">
                                <div class="text-dark fw-bold">Rp {{ number_format($c->total_bayar, 0, ',', '.') }}</div>
                                @if($c->sisa_bayar > 0)
                                    <small class="text-danger">Sisa Rp {{ number_format($c->sisa_bayar, 0, ',', '.') }}</small>
                                @endif
                            </td>
                            <td class="py-3 text-center">
                                <span class="badge crm-badge {{ $kelasBayar }}">{{ $c->status_pembayaran }}</span>
                                <div><small class="text-muted">{{ $c->metode_pembayaran ?? '-' }}</small></div>
                            </td>
                            <td class="py-3 text-center text-secondary" style="font-size: 0.85rem;">{{ $c->tanggal_closing ? $c->tanggal_closing->format('d/m/Y') : '-' }}</td>
                            <td class="py-3 text-center">
                                <div class="aksi-wrap">
                                    <button type="button" class="btn btn-sm btn-outline-primary shadow-sm px-2 py-1" title="Ubah data" data-toggle="modal" data-target="#modalEditClosing{{ $c->id_servis }}"><i class="fas fa-edit"></i></button>
                                    <a href="{{ route('closing.cetak', $c->id_servis) }}" target="_blank" class="btn btn-sm btn-outline-success shadow-sm px-2 py-1" title="Cetak nota"><i class="fas fa-print"></i></a>
                                    <form action="{{ route('closing.destroy', $c->id_servis) }}" method="POST" class="d-inline" onsubmit="return confirm('Batalkan closing {{ $c->no_invoice }}? Tiket {{ $c->no_tiket }} akan kembali ke status Proses Servis.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger shadow-sm px-2 py-1" title="Batalkan closing"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="py-4 text-center text-muted">
                                @if(request()->filled('search') || request()->filled('status_pembayaran'))
                                    Tidak ada data closing yang cocok dengan pencarian / filter.
                                @else
                                    Belum ada data closing. Klik "Tambah Closing" untuk menyelesaikan tiket servis.
                                @endif
                            </td>
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

<!-- Modal Tambah Closing (dari file closing/create.blade.php) -->
@include('closing.create')

<!-- Modal Edit Closing (satu per data) -->
@foreach($closing as $c)
@php $isOld = old('_modal') === 'modalEditClosing' . $c->id_servis; @endphp
<div class="modal fade crm-wrapper" id="modalEditClosing{{ $c->id_servis }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-custom-size modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 10px; border: none; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.2);">
            <div class="modal-header py-3 px-4 text-white" style="background-color: #1e293b; border-bottom: 1px solid #1e293b; border-top-left-radius: 10px; border-top-right-radius: 10px;">
                <h5 class="modal-title text-white mb-0" style="font-weight: 700; font-size: 1.15rem;"><i class="fas fa-edit mr-2"></i>Edit Invoice {{ $c->no_invoice }}</h5>
                <button type="button" data-dismiss="modal" aria-label="Close" style="color: #ffffff; opacity: 1; background: transparent; border: none; font-size: 1.5rem; padding: 0; line-height: 1;"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="{{ route('closing.update', $c->id_servis) }}" method="POST" autocomplete="off" class="form-closing">
                @csrf
                @method('PUT')
                <input type="hidden" name="_modal" value="modalEditClosing{{ $c->id_servis }}">
                <div class="modal-body modal-body-scroll p-4 bg-white text-dark">

                    <div class="row mb-3">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="text-dark" style="font-size: 0.875rem; font-weight: 600;">No. Invoice / Tiket</label>
                            <input type="text" class="form-control py-2" value="{{ $c->no_invoice }} / {{ $c->no_tiket }}" readonly style="border-radius: 6px; background-color: #f1f5f9; cursor: not-allowed;">
                        </div>
                        <div class="col-md-6">
                            <label class="text-dark" style="font-size: 0.875rem; font-weight: 600;">Pelanggan</label>
                            <input type="text" class="form-control py-2" value="{{ $c->unit->konsumen->nama ?? '-' }}" readonly style="border-radius: 6px; background-color: #f1f5f9; cursor: not-allowed;">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="text-dark" style="font-size: 0.875rem; font-weight: 600;">Unit Servis</label>
                            <input type="text" class="form-control py-2" value="{{ $c->label_unit }}" readonly style="border-radius: 6px; background-color: #f1f5f9; cursor: not-allowed;">
                        </div>
                        <div class="col-md-6">
                            <label class="text-dark" style="font-size: 0.875rem; font-weight: 600;">Nama Teknisi <span class="text-danger">*</span></label>
                            <input type="text" name="teknisi" class="form-control py-2" list="datalist_teknisi" value="{{ $isOld ? old('teknisi') : ($c->teknisi->nama_teknisi ?? '') }}" required style="border-radius: 6px;">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="text-dark" style="font-size: 0.875rem; font-weight: 600;">Rincian Tindakan / Sparepart <span class="text-danger">*</span></label>
                        <textarea name="rincian_pengerjaan" class="form-control" rows="3" required style="border-radius: 6px;">{{ $isOld ? old('rincian_pengerjaan') : $c->catatan }}</textarea>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 mb-3 mb-md-0">
                            <label class="text-dark" style="font-size: 0.875rem; font-weight: 600;">Biaya Jasa (Rp) <span class="text-danger">*</span></label>
                            <input type="number" name="biaya_jasa" class="form-control py-2 in-jasa" min="0" step="1" value="{{ $isOld ? old('biaya_jasa') : $c->biaya_jasa }}" required style="border-radius: 6px;">
                        </div>
                        <div class="col-md-4 mb-3 mb-md-0">
                            <label class="text-dark" style="font-size: 0.875rem; font-weight: 600;">Biaya Sparepart (Rp)</label>
                            <input type="number" name="biaya_sparepart" class="form-control py-2 in-sparepart" min="0" step="1" value="{{ $isOld ? old('biaya_sparepart') : $c->biaya_sparepart }}" style="border-radius: 6px;">
                        </div>
                        <div class="col-md-4">
                            <label class="text-dark" style="font-size: 0.875rem; font-weight: 600;">Diskon (Rp)</label>
                            <input type="number" name="diskon" class="form-control py-2 in-diskon" min="0" step="1" value="{{ $isOld ? old('diskon') : $c->diskon }}" style="border-radius: 6px;">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 mb-3 mb-md-0">
                            <label class="text-dark" style="font-size: 0.875rem; font-weight: 600;">Metode Pembayaran <span class="text-danger">*</span></label>
                            <select name="metode_pembayaran" class="form-control py-2" required style="border-radius: 6px;">
                                @php $metodeNow = $isOld ? old('metode_pembayaran') : $c->metode_pembayaran; @endphp
                                @foreach(['Tunai', 'QRIS/Transfer'] as $m)
                                    <option value="{{ $m }}" {{ $metodeNow === $m ? 'selected' : '' }}>{{ $m }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-3 mb-md-0">
                            <label class="text-dark" style="font-size: 0.875rem; font-weight: 600;">Masa Garansi <span class="text-danger">*</span></label>
                            <select name="garansi" class="form-control py-2" required style="border-radius: 6px;">
                                @php $garansiNow = $isOld ? old('garansi') : $c->masa_garansi_hari; @endphp
                                @foreach([0 => 'Tanpa Garansi', 7 => '7 Hari', 14 => '14 Hari', 30 => '30 Hari', 60 => '60 Hari'] as $hari => $label)
                                    <option value="{{ $hari }}" {{ (string) $garansiNow === (string) $hari ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="text-dark" style="font-size: 0.875rem; font-weight: 600;">Status Pembayaran <span class="text-danger">*</span></label>
                            <select name="status_pembayaran" class="form-control py-2 in-status" required style="border-radius: 6px;">
                                @php $statusNow = $isOld ? old('status_pembayaran') : $c->status_pembayaran; @endphp
                                @foreach(['Lunas', 'DP', 'Belum Lunas'] as $sb)
                                    <option value="{{ $sb }}" {{ $statusNow === $sb ? 'selected' : '' }}>{{ $sb }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-6 mb-3 mb-md-0 grp-dp" style="display: none;">
                            <label class="text-dark" style="font-size: 0.875rem; font-weight: 600;">Jumlah DP (Rp) <span class="text-danger">*</span></label>
                            <input type="number" name="jumlah_dp" class="form-control py-2 in-dp" min="1" step="1" value="{{ $isOld ? old('jumlah_dp') : ($c->jumlah_dp > 0 ? $c->jumlah_dp : '') }}" style="border-radius: 6px;">
                        </div>
                        <div class="col-md-6 ml-md-auto">
                            <div class="total-box d-flex justify-content-between align-items-center">
                                <span class="text-dark">Total Bayar</span>
                                <span class="lbl-total">Rp 0</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer px-4 py-3" style="border-top: 1px solid #e2e8f0; background-color: #f8fafc; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
                    <button type="button" class="btn btn-light px-4 py-2" data-dismiss="modal" style="font-weight: 600; border-radius: 6px; border: 1px solid #cbd5e1;">Batal</button>
                    <button type="submit" class="btn btn-primary px-4 py-2" style="font-weight: 600; border-radius: 6px; background-color: #2563eb; border-color: #2563eb;"><i class="fas fa-save mr-1"></i> Perbarui Invoice</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<!-- Datalist Global untuk Auto-complete nama teknisi -->
<datalist id="datalist_teknisi">
    @foreach($teknisi as $namaTeknisi)
        <option value="{{ $namaTeknisi }}"></option>
    @endforeach
</datalist>

<!-- Script JS (Bootstrap 4.6) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
$(document).ready(function(){
    // Notifikasi sukses hilang otomatis setelah 4 detik
    setTimeout(function() {
        $(".alert-success").fadeOut(500, function() { $(this).remove(); });
    }, 4000);

    // Hitung total bayar & tampilkan kolom DP hanya jika status "DP"
    function rupiah(n) {
        return 'Rp ' + (n || 0).toLocaleString('id-ID');
    }
    function hitung($form) {
        var jasa      = parseInt($form.find('.in-jasa').val(), 10) || 0;
        var sparepart = parseInt($form.find('.in-sparepart').val(), 10) || 0;
        var diskon    = parseInt($form.find('.in-diskon').val(), 10) || 0;
        $form.find('.lbl-total').text(rupiah(jasa + sparepart - diskon));
    }
    function aturDp($form) {
        var pakaiDp = $form.find('.in-status').val() === 'DP';
        $form.find('.grp-dp').toggle(pakaiDp);
        $form.find('.in-dp').prop('required', pakaiDp);
    }

    $('.form-closing').each(function() {
        hitung($(this));
        aturDp($(this));
    });
    $(document).on('input change', '.form-closing', function() {
        hitung($(this));
        aturDp($(this));
    });

    // Angka 0 default hilang otomatis saat kolom biaya diklik, dan kembali jadi 0 jika dibiarkan kosong
    $(document).on('focus', '.in-jasa, .in-sparepart, .in-diskon', function() {
        if ($(this).val() === '0') {
            $(this).val('');
            hitung($(this).closest('form'));
        }
    });
    $(document).on('blur', '.in-jasa, .in-sparepart, .in-diskon', function() {
        if ($(this).val() === '') {
            $(this).val('0');
            hitung($(this).closest('form'));
        }
    });

    // Isi otomatis nama teknisi dari tiket yang dipilih (jika kolom teknisi masih kosong)
    $(document).on('change', '.in-tiket', function() {
        var teknisi = $(this).find('option:selected').data('teknisi');
        var $input  = $(this).closest('form').find('.in-teknisi');
        if (teknisi && !$input.val()) {
            $input.val(teknisi);
        }
    });

    // Buka kembali modal yang tadi diisi jika validasi gagal
    @if($errors->any() && old('_modal'))
    var modalId = @json(old('_modal'));
    if (modalId === 'tambah') {
        $('#modalTambahClosing').modal('show');
    } else if (/^modalEditClosing\d+$/.test(modalId)) {
        $('#' + modalId).modal('show');
    }
    @endif
});
</script>
@endsection