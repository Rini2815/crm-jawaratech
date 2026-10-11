@extends('layouts.app')

@section('content')
@php
    // DATA DUMMY (nanti diganti data dari database)

    // Konsumen HANYA untuk pilihan dropdown "Pilih Konsumen Pemilik" di modal Tambah Unit.
    $konsumen = [
        ['id' => 1, 'nama' => 'Budi Santoso',  'wa' => '081399887766'],
        ['id' => 2, 'nama' => 'Siti Aminah',   'wa' => '081234567890'],
        ['id' => 3, 'nama' => 'Hendra Wijaya', 'wa' => '085711223344'],
        ['id' => 4, 'nama' => 'Ahmad Faisal',  'wa' => '081987654321'],
    ];

    $unit = [
        ['pemilik' => 'Budi Santoso',  'wa' => '081399887766', 'jenis' => 'AC',         'merek' => 'Daikin',   'model' => 'Inverter 1 PK (FTKC25)', 'masuk' => '28 Sep 2026', 'garansi' => true],
        ['pemilik' => 'Budi Santoso',  'wa' => '081399887766', 'jenis' => 'Mesin Cuci', 'merek' => 'LG',       'model' => '2 Tabung 8 Kg (P800N)',  'masuk' => '28 Sep 2025', 'garansi' => false],
        ['pemilik' => 'Siti Aminah',   'wa' => '081234567890', 'jenis' => 'AC',         'merek' => 'Sharp',    'model' => 'Standar 1 PK',           'masuk' => '4 Jul 2026',  'garansi' => true],
        ['pemilik' => 'Hendra Wijaya', 'wa' => '085711223344', 'jenis' => 'Dispenser',  'merek' => 'Miyako',   'model' => 'Galon Bawah',            'masuk' => '9 Apr 2026',  'garansi' => false],
        ['pemilik' => 'Ahmad Faisal',  'wa' => '081987654321', 'jenis' => 'Dispenser',  'merek' => 'Polytron', 'model' => 'Hyda',                   'masuk' => '1 Okt 2026',  'garansi' => true],
    ];

    // Angka kartu dihitung otomatis dari data di atas
    $totalUnit     = count($unit);
    $unitAC        = collect($unit)->where('jenis', 'AC')->count();
    $unitDispenser = collect($unit)->whereIn('jenis', ['Dispenser', 'Water Heater'])->count();
    $unitMesinCuci = collect($unit)->where('jenis', 'Mesin Cuci')->count();
@endphp

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
.stat-card.purple { border-left: 4px solid #8b5cf6 !important; }
.stat-card.cyan { border-left: 4px solid #0891b2 !important; }

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

    <!-- ================================================================= -->
    <!-- DATA UNIT SERVIS                                                  -->
    <!-- ================================================================= -->

    <!-- KARTU STATISTIK DATA UNIT -->
    <div class="row mb-4">
        <div class="col-md-3">
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
        <div class="col-md-3">
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
        <div class="col-md-3">
            <div class="card stat-card cyan h-100 p-3 border-0">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted text-uppercase mb-1" style="font-size: 0.75rem; font-weight: 600;">Dispenser / WH</p>
                        <h4 class="mb-0 fw-bold text-dark">{{ $unitDispenser }} <span style="font-size: 0.9rem; font-weight: 500; color: #64748b;">Unit</span></h4>
                    </div>
                    <div class="rounded p-2" style="background-color: #cffafe; color: #0891b2;">
                        <i class="fas fa-faucet fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
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
                        @foreach($unit as $u)
                        <tr>
                            <td class="px-4 py-3 text-secondary text-center fw-bold">{{ $loop->iteration }}</td>
                            <td class="py-3">
                                <div class="text-dark fw-bold">{{ $u['pemilik'] }}</div>
                                <small class="text-success"><i class="fab fa-whatsapp"></i> {{ $u['wa'] }}</small>
                            </td>
                            <td class="py-3">
                                @if($u['jenis'] == 'AC')
                                    <span class="badge bg-info text-dark">AC</span>
                                @elseif($u['jenis'] == 'Mesin Cuci')
                                    <span class="badge bg-warning text-dark">Mesin Cuci</span>
                                @else
                                    <span class="badge" style="background-color: #cffafe; color: #0e7490;">{{ $u['jenis'] }}</span>
                                @endif
                                {{ $u['merek'] }}
                            </td>
                            <td class="py-3 text-secondary">{{ $u['model'] }}</td>
                            <td class="py-3 text-center">{{ $u['masuk'] }}</td>
                            <td class="py-3 text-center">
                                @if($u['garansi'])
                                    <span class="badge" style="background-color: #dcfce3; color: #15803d; border: 1px solid #bbf7d0;">Aktif (Ada Kartu)</span>
                                @else
                                    <span class="badge" style="background-color: #fee2e2; color: #b91c1c; border: 1px solid #fecaca;">Tidak Bergaransi</span>
                                @endif
                            </td>
                            <td class="py-3 text-center">
                                <div class="aksi-wrap">
                                    <button type="button" class="btn btn-sm btn-outline-primary shadow-sm px-2 py-1" title="Ubah data" data-toggle="modal" data-target="#modalEditUnit{{ $loop->iteration }}"><i class="fas fa-edit"></i></button>
                                    <button type="button" class="btn btn-sm btn-outline-danger shadow-sm px-2 py-1" title="Hapus" onclick="return confirm('Yakin ingin menghapus unit ini?')"><i class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
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
            <form action="#" method="POST" autocomplete="off">
                @csrf
                <div class="modal-body p-4 bg-white text-dark">
                    <div class="mb-3">
                        <label class="text-dark" style="font-size: 0.875rem; font-weight: 600;">Pilih Konsumen Pemilik</label>
                        <select name="konsumen_id" class="form-control py-2" required style="border-radius: 6px;">
                            <option value="" disabled selected>Pilih Konsumen...</option>
                            @foreach($konsumen as $k)
                            <option value="{{ $k['id'] }}">{{ $k['nama'] }} - {{ $k['wa'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="text-dark" style="font-size: 0.875rem; font-weight: 600;">Jenis Unit</label>
                            <select name="jenis_unit" class="form-control py-2" required style="border-radius: 6px;">
                                <option value="" disabled selected>Pilih...</option>
                                <option value="AC">AC</option>
                                <option value="Mesin Cuci">Mesin Cuci</option>
                                <option value="Dispenser">Dispenser</option>
                                <option value="Water Heater">Water Heater</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="text-dark" style="font-size: 0.875rem; font-weight: 600;">Merek Unit</label>
                            <input type="text" name="merek" class="form-control py-2" placeholder="Contoh: Daikin, LG, Sharp" required style="border-radius: 6px;">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="text-dark" style="font-size: 0.875rem; font-weight: 600;">Model / Tipe Rinci</label>
                        <input type="text" name="tipe" class="form-control py-2" placeholder="Contoh: Inverter 1 PK / 2 Tabung" required style="border-radius: 6px;">
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="text-dark" style="font-size: 0.875rem; font-weight: 600;">Tanggal Masuk Servis</label>
                            <input type="date" name="tgl_masuk" class="form-control py-2" style="border-radius: 6px;">
                        </div>
                        <div class="col-md-6">
                            <label class="text-dark" style="font-size: 0.875rem; font-weight: 600;">Status Garansi</label>
                            <select name="status_garansi" class="form-control py-2" required style="border-radius: 6px;">
                                <option value="Aktif (Ada Kartu)">Aktif (Ada Kartu)</option>
                                <option value="Tidak Bergaransi">Tidak Bergaransi</option>
                            </select>
                        </div>
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
<div class="modal fade crm-wrapper" id="modalEditUnit{{ $loop->iteration }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-custom-size modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 10px; border: none; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.2);">
            <div class="modal-header py-3 px-4 text-white" style="background-color: #1e293b; border-bottom: 1px solid #1e293b; border-top-left-radius: 10px; border-top-right-radius: 10px;">
                <h5 class="modal-title text-white mb-0" style="font-weight: 700; font-size: 1.15rem;"><i class="fas fa-edit mr-2"></i>Edit Data Unit Servis</h5>
                <button type="button" data-dismiss="modal" aria-label="Close" style="color: #ffffff; opacity: 1; background: transparent; border: none; font-size: 1.5rem; padding: 0; line-height: 1;"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="#" method="POST" autocomplete="off">
                @csrf
                @method('PUT')
                <div class="modal-body p-4 bg-white text-dark">
                    <div class="mb-3">
                        <label class="text-dark" style="font-size: 0.875rem; font-weight: 600;">Pemilik Unit</label>
                        <input type="text" class="form-control py-2" value="{{ $u['pemilik'] }}" readonly style="border-radius: 6px; background-color: #f1f5f9; cursor: not-allowed;">
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="text-dark" style="font-size: 0.875rem; font-weight: 600;">Jenis Unit</label>
                            <select name="jenis_unit" class="form-control py-2" style="border-radius: 6px;">
                                <option value="AC" {{ $u['jenis'] == 'AC' ? 'selected' : '' }}>AC</option>
                                <option value="Mesin Cuci" {{ $u['jenis'] == 'Mesin Cuci' ? 'selected' : '' }}>Mesin Cuci</option>
                                <option value="Dispenser" {{ $u['jenis'] == 'Dispenser' ? 'selected' : '' }}>Dispenser</option>
                                <option value="Water Heater" {{ $u['jenis'] == 'Water Heater' ? 'selected' : '' }}>Water Heater</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="text-dark" style="font-size: 0.875rem; font-weight: 600;">Merek Unit</label>
                            <input type="text" name="merek" class="form-control py-2" value="{{ $u['merek'] }}" required style="border-radius: 6px;">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="text-dark" style="font-size: 0.875rem; font-weight: 600;">Model / Tipe Rinci</label>
                        <input type="text" name="tipe" class="form-control py-2" value="{{ $u['model'] }}" required style="border-radius: 6px;">
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="text-dark" style="font-size: 0.875rem; font-weight: 600;">Tanggal Masuk Servis</label>
                            <input type="text" name="tgl_masuk" class="form-control py-2" value="{{ $u['masuk'] }}" style="border-radius: 6px;">
                        </div>
                        <div class="col-md-6">
                            <label class="text-dark" style="font-size: 0.875rem; font-weight: 600;">Status Garansi</label>
                            <select name="status_garansi" class="form-control py-2" style="border-radius: 6px;">
                                <option value="Aktif (Ada Kartu)" {{ $u['garansi'] ? 'selected' : '' }}>Aktif (Ada Kartu)</option>
                                <option value="Tidak Bergaransi" {{ !$u['garansi'] ? 'selected' : '' }}>Tidak Bergaransi</option>
                            </select>
                        </div>
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

<!-- Script JS (Bootstrap 4.6) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
@endsection