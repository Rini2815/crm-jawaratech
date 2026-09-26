@extends('layouts.app')

@section('content')
<!-- Import Font 'Inter' & Custom CSS Jawaratech -->
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
        background-color: #1e293b; /* Navy/Slate khas Jawaratech */
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
    
    /* Custom Badge Kategori Unit & Garansi */
    .badge-unit-ac { background-color: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; }
    .badge-unit-mc { background-color: #f3e8ff; color: #7e22ce; border: 1px solid #e9d5ff; }
    .badge-unit-dp { background-color: #ffedd5; color: #c2410c; border: 1px solid #fed7aa; }
    .badge-unit-wh { background-color: #fef3c7; color: #b45309; border: 1px solid #fde68a; }
    
    .badge-garansi-aktif { background-color: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
    .badge-garansi-habis { background-color: #fee2e2; color: #b91c1c; border: 1px solid #fecaca; }

    /* Custom Lebar Modal Spesifik */
    .modal-custom-size {
        max-width: 800px !important;
        width: 90%;
    }
</style>

<div class="container-fluid py-4 crm-wrapper">
    <!-- Header Halaman -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h1 class="h3 mb-1 text-dark" style="font-weight: 700; color: #0f172a !important;">Data Unit Servis</h1>
            <p class="text-secondary mb-0" style="font-weight: 500;">Kelola spesifikasi teknis unit pelanggan, tanggal pembelian, dan status garansi</p>
        </div>
        
        <!-- Tombol Tambah Unit -->
        <button type="button" class="btn btn-primary shadow-sm px-4 py-2" style="font-weight: 600; border-radius: 6px; background-color: #2563eb; border-color: #2563eb;" data-toggle="modal" data-bs-toggle="modal" data-target="#modalTambahUnit" data-bs-target="#modalTambahUnit">
            <i class="fas fa-plus fa-sm mr-2 me-1"></i> Tambah Unit Servis
        </button>
    </div>

    <!-- Tabel Data Unit Servis -->
    <div class="card crm-card bg-white">
        <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h6 class="m-0 text-dark" style="font-weight: 700;">
                <i class="fas fa-boxes text-primary mr-2 me-2"></i>Daftar Master Unit Pelanggan
            </h6>

            <!-- Kolom Pencarian / Search Bar -->
            <div class="position-relative" style="min-width: 260px;">
                <input type="text" id="searchInput" class="form-control form-control-sm pl-4 pr-3 ps-5 pe-3 py-2" placeholder="Cari pemilik, merek, tipe..." style="border-radius: 6px; border: 1px solid #cbd5e1; font-size: 0.875rem;">
                <i class="fas fa-search position-absolute text-secondary" style="left: 12px; top: 50%; transform: translateY(-50%); font-size: 0.85rem;"></i>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="crm-table-header">
                        <tr>
                            <th class="px-4 py-3 border-0">NO</th>
                            <th class="py-3 border-0">PEMILIK UNIT</th>
                            <th class="py-3 border-0">JENIS & MEREK UNIT</th>
                            <th class="py-3 border-0">MODEL / TIPE</th>
                            <th class="py-3 border-0">TANGGAL PEMBELIAN</th>
                            <th class="py-3 border-0">STATUS GARANSI</th>
                            <th class="text-center py-3 border-0">AKSI</th>
                        </tr>
                    </thead>
                    <tbody id="unitTableBody" style="font-weight: 500;">
                        @php
                            $units = [
                                [
                                    'id' => 1, 'pemilik' => 'Budi Santoso', 'wa' => '081234567890',
                                    'jenis' => 'AC', 'merek' => 'Daikin', 'tipe' => 'Inverter 1 PK (FTKC25)',
                                    'tgl_pembelian' => '12 Mei 2024', 'garansi' => 'Aktif (Ada Kartu)', 'badge_unit' => 'badge-unit-ac', 'badge_garansi' => 'badge-garansi-aktif'
                                ],
                                [
                                    'id' => 2, 'pemilik' => 'Siti Aminah', 'wa' => '085712345678',
                                    'jenis' => 'Mesin Cuci', 'merek' => 'LG', 'tipe' => '2 Tabung 8 Kg (P800N)',
                                    'tgl_pembelian' => '20 Jan 2023', 'garansi' => 'Tidak Bergaransi', 'badge_unit' => 'badge-unit-mc', 'badge_garansi' => 'badge-garansi-habis'
                                ]
                            ];
                        @endphp

                        @foreach($units as $index => $u)
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <td class="px-4 py-3 text-secondary">{{ $index + 1 }}</td>
                            <td class="py-3">
                                <div class="text-dark" style="font-weight: 600;">{{ $u['pemilik'] }}</div>
                                <div class="text-secondary" style="font-size: 0.85rem;"><i class="fab fa-whatsapp text-success mr-1 me-1"></i> {{ $u['wa'] }}</div>
                            </td>
                            <td class="py-3">
                                <span class="badge crm-badge {{ $u['badge_unit'] }} mb-1">{{ $u['jenis'] }}</span>
                                <div class="text-dark" style="font-size: 0.9rem; font-weight: 600;">{{ $u['merek'] }}</div>
                            </td>
                            <td class="py-3 text-secondary" style="font-size: 0.9rem;">
                                {{ $u['tipe'] }}
                            </td>
                            <td class="py-3 text-secondary" style="font-size: 0.9rem;">{{ $u['tgl_pembelian'] }}</td>
                            <td class="py-3">
                                <span class="badge crm-badge {{ $u['badge_garansi'] }}">
                                    {{ $u['garansi'] }}
                                </span>
                            </td>
                            <td class="py-3 text-center">
                                <!-- Tombol Edit -->
                                <button class="btn btn-sm btn-outline-primary shadow-sm mr-1 me-1" title="Edit Data Unit" style="border-radius: 4px;" data-toggle="modal" data-bs-toggle="modal" data-target="#modalEditUnit{{ $u['id'] }}" data-bs-target="#modalEditUnit{{ $u['id'] }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <!-- Tombol Hapus -->
                                <button class="btn btn-sm btn-outline-danger shadow-sm" title="Hapus Unit" style="border-radius: 4px;">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>

                        <!-- Modal Edit Unit (800px) -->
                        <div class="modal fade crm-wrapper" id="modalEditUnit{{ $u['id'] }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-custom-size modal-dialog-centered">
                                <div class="modal-content" style="border-radius: 10px; border: none; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.2);">
                                    <div class="modal-header py-3 px-4 d-flex align-items-center" style="background-color: #1e293b; border-bottom: 1px solid #1e293b; border-top-left-radius: 10px; border-top-right-radius: 10px;">
                                        <h5 class="modal-title text-white mb-0" style="font-weight: 700; font-size: 1.15rem;">
                                            <i class="fas fa-edit me-2 mr-2"></i>Edit Data Unit Servis
                                        </h5>
                                        <button type="button" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close" style="color: #ffffff; opacity: 1; background: transparent; border: none; font-size: 1.5rem; padding: 0; line-height: 1;">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="#" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body p-4">
                                            <div class="mb-3">
                                                <label class="form-label text-dark" style="font-size: 0.875rem; font-weight: 600;">Pemilik Unit</label>
                                                <input type="text" class="form-control py-2" value="{{ $u['pemilik'] }}" readonly style="border-radius: 6px; background-color: #f1f5f9; cursor: not-allowed;">
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-md-6 mb-3 mb-md-0">
                                                    <label class="form-label text-dark" style="font-size: 0.875rem; font-weight: 600;">Jenis Unit</label>
                                                    <select name="jenis_unit" class="form-control py-2" style="border-radius: 6px;">
                                                        <option value="AC" {{ $u['jenis'] == 'AC' ? 'selected' : '' }}>AC</option>
                                                        <option value="Mesin Cuci" {{ $u['jenis'] == 'Mesin Cuci' ? 'selected' : '' }}>Mesin Cuci</option>
                                                        <option value="Dispenser" {{ $u['jenis'] == 'Dispenser' ? 'selected' : '' }}>Dispenser</option>
                                                        <option value="Water Heater" {{ $u['jenis'] == 'Water Heater' ? 'selected' : '' }}>Water Heater</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label text-dark" style="font-size: 0.875rem; font-weight: 600;">Merek Unit</label>
                                                    <input type="text" name="merek" class="form-control py-2" value="{{ $u['merek'] }}" required style="border-radius: 6px;">
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label text-dark" style="font-size: 0.875rem; font-weight: 600;">Model / Tipe Rinci</label>
                                                <input type="text" name="tipe" class="form-control py-2" value="{{ $u['tipe'] }}" required style="border-radius: 6px;">
                                            </div>

                                            <div class="row mb-2">
                                                <div class="col-md-6 mb-3 mb-md-0">
                                                    <label class="form-label text-dark" style="font-size: 0.875rem; font-weight: 600;">Tanggal Pembelian</label>
                                                    <input type="date" name="tgl_pembelian" class="form-control py-2" value="2024-05-12" style="border-radius: 6px;">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label text-dark" style="font-size: 0.875rem; font-weight: 600;">Status Garansi</label>
                                                    <select name="status_garansi" class="form-control py-2" style="border-radius: 6px;">
                                                        <option value="Aktif (Ada Kartu)" {{ str_contains($u['garansi'], 'Aktif') ? 'selected' : '' }}>Aktif (Ada Kartu)</option>
                                                        <option value="Tidak Bergaransi" {{ str_contains($u['garansi'], 'Tidak') ? 'selected' : '' }}>Tidak Bergaransi</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer px-4 py-3" style="border-top: 1px solid #e2e8f0; background-color: #f8fafc; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
                                            <button type="button" class="btn btn-light px-4 py-2" data-dismiss="modal" data-bs-dismiss="modal" style="font-weight: 600; border-radius: 6px; border: 1px solid #cbd5e1;">Batal</button>
                                            <button type="submit" class="btn btn-primary px-4 py-2" style="font-weight: 600; border-radius: 6px; background-color: #2563eb; border-color: #2563eb;">
                                                <i class="fas fa-save me-1 mr-1"></i> Perbarui Unit
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

<!-- Modal Tambah Unit (800px) -->
<div class="modal fade crm-wrapper" id="modalTambahUnit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-custom-size modal-dialog-centered">
        <div class="modal-content" style="border-radius: 10px; border: none; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.2);">
            <div class="modal-header py-3 px-4 d-flex align-items-center" style="background-color: #1e293b; border-bottom: 1px solid #1e293b; border-top-left-radius: 10px; border-top-right-radius: 10px;">
                <h5 class="modal-title text-white mb-0" style="font-weight: 700; font-size: 1.15rem;">
                    <i class="fas fa-plus-circle me-2 mr-2"></i>Tambah Data Unit Servis
                </h5>
                <button type="button" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close" style="color: #ffffff; opacity: 1; background: transparent; border: none; font-size: 1.5rem; padding: 0; line-height: 1;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label text-dark" style="font-size: 0.875rem; font-weight: 600;">Pilih Konsumen Pemilik</label>
                        <select name="konsumen_id" class="form-control py-2" required style="border-radius: 6px;">
                            <option value="" disabled selected>Pilih Konsumen...</option>
                            <option value="1">Budi Santoso - 081234567890</option>
                            <option value="2">Siti Aminah - 085712345678</option>
                        </select>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="form-label text-dark" style="font-size: 0.875rem; font-weight: 600;">Jenis Unit</label>
                            <select name="jenis_unit" class="form-control py-2" required style="border-radius: 6px;">
                                <option value="" disabled selected>Pilih...</option>
                                <option value="AC">AC</option>
                                <option value="Mesin Cuci">Mesin Cuci</option>
                                <option value="Dispenser">Dispenser</option>
                                <option value="Water Heater">Water Heater</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-dark" style="font-size: 0.875rem; font-weight: 600;">Merek Unit</label>
                            <input type="text" name="merek" class="form-control py-2" placeholder="Contoh: Daikin, LG, Sharp" required style="border-radius: 6px;">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-dark" style="font-size: 0.875rem; font-weight: 600;">Model / Tipe Rinci</label>
                        <input type="text" name="tipe" class="form-control py-2" placeholder="Contoh: Inverter 1 PK / 2 Tabung" required style="border-radius: 6px;">
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="form-label text-dark" style="font-size: 0.875rem; font-weight: 600;">Tanggal Pembelian</label>
                            <input type="date" name="tgl_pembelian" class="form-control py-2" style="border-radius: 6px;">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-dark" style="font-size: 0.875rem; font-weight: 600;">Status Garansi</label>
                            <select name="status_garansi" class="form-control py-2" required style="border-radius: 6px;">
                                <option value="Aktif (Ada Kartu)">Aktif (Ada Kartu)</option>
                                <option value="Tidak Bergaransi">Tidak Bergaransi</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer px-4 py-3" style="border-top: 1px solid #e2e8f0; background-color: #f8fafc; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
                    <button type="button" class="btn btn-light px-4 py-2" data-dismiss="modal" data-bs-dismiss="modal" style="font-weight: 600; border-radius: 6px; border: 1px solid #cbd5e1;">Batal</button>
                    <button type="submit" class="btn btn-primary px-4 py-2" style="font-weight: 600; border-radius: 6px; background-color: #2563eb; border-color: #2563eb;">
                        <i class="fas fa-save me-1 mr-1"></i> Simpan Unit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Script Filter Pencarian Real-Time -->
<script>
    $(document).ready(function(){
        $("#searchInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#unitTableBody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });
    });
</script>
@endsection