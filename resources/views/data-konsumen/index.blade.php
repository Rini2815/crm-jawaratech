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
        background-color: #1e293b; /* Warna Navy/Slate tegas */
        color: #ffffff;
        font-weight: 600;
        letter-spacing: 0.5px;
    }
</style>

<div class="container-fluid py-4 crm-wrapper">
    <!-- Header Halaman -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-dark" style="font-weight: 700; color: #0f172a !important;">Data Konsumen</h1>
            <p class="text-secondary mb-0" style="font-weight: 500;">Buku kontak dan master informasi pelanggan</p>
        </div>
        
        <!-- Tombol Tambah Konsumen -->
        <button type="button" class="btn btn-primary shadow-sm px-4 py-2" style="font-weight: 600; border-radius: 6px; background-color: #2563eb; border-color: #2563eb;" data-toggle="modal" data-bs-toggle="modal" data-target="#modalTambahKonsumen" data-bs-target="#modalTambahKonsumen">
            <i class="fas fa-plus fa-sm mr-2 me-2"></i> Tambah Konsumen
        </button>
    </div>

    <!-- Tabel Data Konsumen -->
    <div class="card crm-card bg-white">
        <!-- Card Header dengan Judul & Kolom Pencarian -->
        <div class="card-header bg-white py-3 border-bottom d-flex flex-column flex-md-row align-items-md-center justify-content-between">
            <h6 class="m-0 text-dark mb-2 mb-md-0" style="font-weight: 700;">
                <i class="fas fa-users text-primary mr-2 me-2"></i>Daftar Konsumen Jawaratech
            </h6>
            
            <!-- Kolom Pencarian -->
            <div class="input-group input-group-sm" style="max-width: 300px;">
                <input type="text" id="searchInput" class="form-control" placeholder="Cari nama, WA, alamat..." style="border-radius: 6px 0 0 6px;">
                <div class="input-group-append input-group-text bg-white" style="border-radius: 0 6px 6px 0;">
                    <i class="fas fa-search text-secondary"></i>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="tableKonsumen">
                    <thead class="crm-table-header">
                        <tr>
                            <th class="px-4 py-3 border-0" style="width: 60px;">NO</th>
                            <th class="py-3 border-0">NAMA KONSUMEN</th>
                            <th class="py-3 border-0">NOMOR WHATSAPP</th>
                            <th class="py-3 border-0">ALAMAT DOMISILI</th>
                            <th class="text-center py-3 border-0" style="width: 140px;">JUMLAH UNIT</th>
                            <th class="text-center py-3 border-0" style="width: 120px;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody style="font-weight: 500;">
                        @php
                            $konsumens = [
                                [
                                    'nama' => 'Budi Santoso', 
                                    'wa' => '081234567890', 
                                    'alamat' => 'Jl. Manggis No. 12, Madiun',
                                    'jumlah_unit' => 2
                                ],
                                [
                                    'nama' => 'Siti Aminah', 
                                    'wa' => '085712345678', 
                                    'alamat' => 'Jl. Pahlawan No. 45, Madiun',
                                    'jumlah_unit' => 1
                                ]
                            ];
                        @endphp

                        @foreach($konsumens as $index => $k)
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <td class="px-4 py-3 text-secondary">{{ $index + 1 }}</td>
                            <td class="py-3">
                                <div class="text-dark" style="font-weight: 600;">{{ $k['nama'] }}</div>
                            </td>
                            <td class="py-3">
                                <div class="text-secondary"><i class="fab fa-whatsapp text-success mr-1 me-1"></i> {{ $k['wa'] }}</div>
                            </td>
                            <td class="py-3">
                                <div class="text-secondary">{{ $k['alamat'] }}</div>
                            </td>
                            <td class="py-3 text-center">
                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2" style="border-radius: 6px; font-weight: 600; font-size: 0.82rem; background-color: #e0f2fe; color: #0369a1;">
                                    <i class="fas fa-boxes me-1"></i> {{ $k['jumlah_unit'] }} Unit
                                </span>
                            </td>
                            <td class="py-3 text-center">
                                <!-- Tombol Edit -->
                                <button class="btn btn-sm btn-outline-primary shadow-sm mr-1 me-1" title="Edit Data" style="border-radius: 4px;" data-toggle="modal" data-bs-toggle="modal" data-target="#modalEditKonsumen{{ $index }}" data-bs-target="#modalEditKonsumen{{ $index }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <!-- Tombol Hapus -->
                                <button class="btn btn-sm btn-outline-danger shadow-sm" title="Hapus Data" style="border-radius: 4px;">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        
                        <!-- Memanggil file modal edit -->
                        @include('data-konsumen.edit')

                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Memanggil file modal tambah -->
@include('data-konsumen.create')

<!-- Script JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Script Filter Pencarian Realtime -->
<script>
    $(document).ready(function(){
        $("#searchInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#tableKonsumen tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>
@endsection