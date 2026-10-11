@extends('layouts.app')

@section('content')
@php
    // DATA DUMMY (nanti diganti data dari database)
    $konsumen = [
        ['id' => 1, 'nama' => 'Budi Santoso',  'wa' => '081399887766', 'alamat' => 'Jl. Manggis No. 12, Madiun'],
        ['id' => 2, 'nama' => 'Siti Aminah',   'wa' => '081234567890', 'alamat' => 'Jl. Pahlawan No. 45, Madiun'],
        ['id' => 3, 'nama' => 'Hendra Wijaya', 'wa' => '085711223344', 'alamat' => 'Jl. Diponegoro No. 8, Madiun'],
        ['id' => 4, 'nama' => 'Ahmad Faisal',  'wa' => '081987654321', 'alamat' => 'Jl. Thamrin No. 21, Madiun'],
    ];

    // Data unit HANYA untuk menghitung "Jumlah Unit" per konsumen & kartu statistik.
    // Nanti saat pakai database, ganti dengan relasi / withCount('unit').
    $unit = [
        ['pemilik' => 'Budi Santoso',  'garansi' => true],
        ['pemilik' => 'Budi Santoso',  'garansi' => false],
        ['pemilik' => 'Siti Aminah',   'garansi' => true],
        ['pemilik' => 'Hendra Wijaya', 'garansi' => false],
        ['pemilik' => 'Ahmad Faisal',  'garansi' => true],
    ];

    // Angka kartu dihitung otomatis dari data di atas
    $totalKonsumen = count($konsumen);
    $totalUnit     = count($unit);
    $unitGaransi   = collect($unit)->where('garansi', true)->count();
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
                    <i class="fas fa-address-book text-info"></i> Data Konsumen
                </h1>
                <p class="text-light opacity-75 mb-0" style="font-weight: 400; font-size: 0.85rem;">
                    Kelola data konsumen Jawaratech
                </p>
            </div>
        </div>
    </div>

    <!-- ================================================================= -->
    <!-- DATA KONSUMEN                                                     -->
    <!-- ================================================================= -->

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
            <!-- Tombol Tambah Konsumen: membuka modal -->
            <button type="button" class="btn btn-primary px-3 py-2 fw-semibold rounded-pill shadow-sm text-sm" data-toggle="modal" data-target="#modalTambahKonsumen">
                <i class="fas fa-user-plus mr-1"></i> Tambah Konsumen
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
                        @foreach($konsumen as $k)
                        <tr>
                            <td class="px-4 py-3 text-secondary text-center fw-bold">{{ $loop->iteration }}</td>
                            <td class="py-3 text-dark fw-bold">{{ $k['nama'] }}</td>
                            <td class="py-3 text-success fw-semibold"><i class="fab fa-whatsapp"></i> {{ $k['wa'] }}</td>
                            <td class="py-3 text-secondary">{{ $k['alamat'] }}</td>
                            <td class="py-3 text-center"><span class="badge bg-primary text-white px-2 py-1">{{ collect($unit)->where('pemilik', $k['nama'])->count() }} Unit</span></td>
                            <td class="py-3 text-center">
                                <div class="aksi-wrap">
                                    <button type="button" class="btn btn-sm btn-outline-primary shadow-sm px-2 py-1" title="Ubah data" data-toggle="modal" data-target="#modalEditKonsumen{{ $k['id'] }}"><i class="fas fa-edit"></i></button>
                                    <button type="button" class="btn btn-sm btn-outline-danger shadow-sm px-2 py-1" title="Hapus" onclick="return confirm('Yakin ingin menghapus konsumen ini?')"><i class="fas fa-trash"></i></button>
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

<!-- Modal Tambah Konsumen -->
<div class="modal fade crm-wrapper" id="modalTambahKonsumen" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-custom-size modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 10px; border: none; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.2);">
            <div class="modal-header py-3 px-4 text-white" style="background-color: #1e293b; border-bottom: 1px solid #1e293b; border-top-left-radius: 10px; border-top-right-radius: 10px;">
                <h5 class="modal-title text-white mb-0" style="font-weight: 700; font-size: 1.15rem;"><i class="fas fa-user-plus mr-2"></i>Tambah Data Konsumen</h5>
                <button type="button" data-dismiss="modal" aria-label="Close" style="color: #ffffff; opacity: 1; background: transparent; border: none; font-size: 1.5rem; padding: 0; line-height: 1;"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="#" method="POST" autocomplete="off">
                @csrf
                <div class="modal-body p-4 bg-white text-dark">
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="text-dark" style="font-size: 0.875rem; font-weight: 600;">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control py-2" placeholder="Masukkan nama lengkap konsumen" required style="border-radius: 6px;">
                        </div>
                        <div class="col-md-6">
                            <label class="text-dark" style="font-size: 0.875rem; font-weight: 600;">Nomor WhatsApp <span class="text-danger">*</span></label>
                            <input type="text" name="no_wa" class="form-control py-2" placeholder="contoh: 081234567890" required style="border-radius: 6px;">
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="text-dark" style="font-size: 0.875rem; font-weight: 600;">Alamat Domisili <span class="text-danger">*</span></label>
                        <textarea name="alamat" class="form-control" rows="3" placeholder="contoh: Jl. Manggis No. 12, Madiun" required style="border-radius: 6px;"></textarea>
                    </div>
                </div>
                <div class="modal-footer px-4 py-3" style="border-top: 1px solid #e2e8f0; background-color: #f8fafc; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
                    <button type="button" class="btn btn-light px-4 py-2" data-dismiss="modal" style="font-weight: 600; border-radius: 6px; border: 1px solid #cbd5e1;">Batal</button>
                    <button type="submit" class="btn btn-primary px-4 py-2" style="font-weight: 600; border-radius: 6px; background-color: #2563eb; border-color: #2563eb;"><i class="fas fa-save mr-1"></i> Simpan Konsumen</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Konsumen (satu per data) -->
@foreach($konsumen as $k)
<div class="modal fade crm-wrapper" id="modalEditKonsumen{{ $k['id'] }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-custom-size modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 10px; border: none; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.2);">
            <div class="modal-header py-3 px-4 text-white" style="background-color: #1e293b; border-bottom: 1px solid #1e293b; border-top-left-radius: 10px; border-top-right-radius: 10px;">
                <h5 class="modal-title text-white mb-0" style="font-weight: 700; font-size: 1.15rem;"><i class="fas fa-edit mr-2"></i>Edit Data Konsumen</h5>
                <button type="button" data-dismiss="modal" aria-label="Close" style="color: #ffffff; opacity: 1; background: transparent; border: none; font-size: 1.5rem; padding: 0; line-height: 1;"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="#" method="POST" autocomplete="off">
                @csrf
                @method('PUT')
                <div class="modal-body p-4 bg-white text-dark">
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="text-dark" style="font-size: 0.875rem; font-weight: 600;">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control py-2" value="{{ $k['nama'] }}" required style="border-radius: 6px;">
                        </div>
                        <div class="col-md-6">
                            <label class="text-dark" style="font-size: 0.875rem; font-weight: 600;">Nomor WhatsApp</label>
                            <input type="text" name="no_wa" class="form-control py-2" value="{{ $k['wa'] }}" required style="border-radius: 6px;">
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="text-dark" style="font-size: 0.875rem; font-weight: 600;">Alamat Domisili</label>
                        <textarea name="alamat" class="form-control" rows="3" required style="border-radius: 6px;">{{ $k['alamat'] }}</textarea>
                    </div>
                </div>
                <div class="modal-footer px-4 py-3" style="border-top: 1px solid #e2e8f0; background-color: #f8fafc; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
                    <button type="button" class="btn btn-light px-4 py-2" data-dismiss="modal" style="font-weight: 600; border-radius: 6px; border: 1px solid #cbd5e1;">Batal</button>
                    <button type="submit" class="btn btn-primary px-4 py-2" style="font-weight: 600; border-radius: 6px; background-color: #2563eb; border-color: #2563eb;"><i class="fas fa-save mr-1"></i> Perbarui Konsumen</button>
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