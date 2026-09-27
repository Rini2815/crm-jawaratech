@extends('layouts.app')

@section('content')
<!-- Import Font 'Inter' & Custom CSS Jawaratech -->
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

body, html {
    background-color: #060910 !important;
}
.crm-wrapper {
    font-family: 'Inter', sans-serif;
    color: #0f172a;
}
/* Card Terang & Bersih */
.crm-card-light {
    border: 1px solid #cbd5e1;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
    border-radius: 12px;
    background: #ffffff !important;
}
.crm-table-header {
    background-color: #1e293b; /* Warna Navy/Slate tegas */
    color: #ffffff;
    font-weight: 600;
    letter-spacing: 0.5px;
}
.super-thick-table th, 
.super-thick-table td {
    border-width: 2px !important;
    border-color: #cbd5e1 !important;
}
.stat-card-light {
    background: #ffffff !important;
    border: 1px solid #cbd5e1;
    border-radius: 12px;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.stat-card-light:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
}

/* Animasi lembut untuk ikon */
@keyframes pulse-soft {
    0% { transform: scale(1); }
    50% { transform: scale(1.08); }
    100% { transform: scale(1); }
}
.animated-icon {
    animation: pulse-soft 2s infinite ease-in-out;
}
</style>

<div class="container-fluid px-4 pt-3 pb-4 crm-wrapper" style="background: linear-gradient(135deg, #eef1f3 0%, #eef1f3 100%); min-height: 100vh;">
    <!-- Header Halaman (Dibungkus Card Gelap Elegan Khusus Header Saja) -->
    <div class="card rounded-4 mb-4 text-white shadow-lg overflow-hidden" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); border: 1px solid rgba(56, 189, 248, 0.35) !important;">
        <div class="card-body p-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h1 class="h3 mb-1 text-white" style="font-weight: 700;"><i class="fas fa-users text-primary me-2"></i> Data Konsumen</h1>
                <p class="text-light opacity-75 mb-0" style="font-weight: 500;">Buku kontak dan master informasi pelanggan sistem CRM Jawaratech</p>
            </div>
            
            <!-- Tombol Tambah Konsumen -->
            <button type="button" class="btn btn-primary shadow-sm px-4 py-2 fw-bold d-flex align-items-center gap-2 rounded-pill" style="font-size: 0.875rem; background-color: #2563eb; border-color: #2563eb;" data-toggle="modal" data-bs-toggle="modal" data-target="#modalTambahKonsumen" data-bs-target="#modalTambahKonsumen">
                <i class="fas fa-plus-circle"></i> Tambah Konsumen
            </button>
        </div>
    </div>

    <!-- Bagian Statistik Card Terang & Banner Model Baru -->
    <div class="row g-3 mb-4">
        <!-- Card 1: Total Konsumen (Terang) -->
        <div class="col-xl-3 col-md-6">
            <div class="card stat-card-light p-3 h-100" style="border-left: 5px solid #2563eb !important;">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-uppercase text-muted fw-bold" style="font-size: 0.7rem; letter-spacing: 0.5px;">Total Konsumen</div>
                        <div class="h5 mb-0 fw-bold text-dark mt-1" style="font-weight: 700;">2 <span class="fs-6 fw-normal text-muted">Orang</span></div>
                    </div>
                    <div class="p-2 rounded-circle animated-icon" style="background-color: rgba(37, 99, 235, 0.1); color: #2563eb;">
                        <i class="fas fa-users fa-fw fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2: Total Unit (Terang) -->
        <div class="col-xl-3 col-md-6">
            <div class="card stat-card-light p-3 h-100" style="border-left: 5px solid #0369a1 !important;">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-uppercase text-muted fw-bold" style="font-size: 0.7rem; letter-spacing: 0.5px;">Total Unit Masuk</div>
                        <div class="h5 mb-0 fw-bold text-dark mt-1" style="font-weight: 700;">3 <span class="fs-6 fw-normal text-muted">Unit</span></div>
                    </div>
                    <div class="p-2 rounded-circle animated-icon" style="background-color: rgba(3, 105, 161, 0.1); color: #0369a1;">
                        <i class="fas fa-boxes fa-fw fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 3: Banner Info Interaktif Terang & Kontras -->
        <div class="col-xl-6 col-md-12">
            <div class="card stat-card-light p-3 h-100 d-flex flex-row align-items-center gap-3" style="border-left: 5px solid #16a34a !important;">
                <div class="p-2 rounded-circle text-success animated-icon" style="background-color: rgba(22, 163, 74, 0.1); font-size: 1.2rem;">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <div>
                    <div class="text-success fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">STATUS SISTEM: ONLINE & AMAN</div>
                    <div class="text-secondary" style="font-size: 0.83rem; font-weight: 500;">Sinkronisasi buku kontak dan data pelanggan berjalan normal secara real-time.</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Data Konsumen -->
    <div class="card crm-card-light overflow-hidden mb-4 bg-white">
        <div class="card-body p-4 bg-white">
            
            <!-- Baris Atas Tabel: Judul & Subtitle Clean (Sesuai Referensi Gambar) + Search Box -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
                <!-- Judul Utama + Subtitle Keterangan -->
                <div>
                    <h5 class="fw-bold text-dark mb-1" style="font-size: 1.2rem; letter-spacing: -0.3px;">Daftar Konsumen Jawaratech</h5>
                    <p class="text-secondary mb-0" style="font-size: 0.875rem; font-weight: 400;">Kelola dan pantau seluruh kontak serta informasi pelanggan</p>
                </div>

                <!-- Input Pencarian (Kanan) -->
                <div class="position-relative" style="min-width: 280px;">
                    <input type="text" id="searchInput" class="form-control form-control-sm ps-5 pe-3 py-2 bg-white text-dark" placeholder="Cari nama, WA, alamat..." style="border-radius: 20px; border: 1px solid #cbd5e1; font-size: 0.875rem;">
                    <i class="fas fa-search position-absolute text-secondary" style="left: 15px; top: 50%; transform: translateY(-50%); font-size: 0.85rem;"></i>
                </div>
            </div>

            <!-- Tabel Data -->
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle mb-0 super-thick-table" id="tableKonsumen">
                    <thead class="crm-table-header text-uppercase text-center fs-7">
                        <tr>
                            <th class="py-3 text-white text-center" style="width: 60px;">NO</th>
                            <th class="py-3 text-white text-center">NAMA KONSUMEN</th>
                            <th class="py-3 text-white text-center">NOMOR WHATSAPP</th>
                            <th class="py-3 text-white text-center">ALAMAT DOMISILI</th>
                            <th class="py-3 text-white text-center" style="width: 140px;">JUMLAH UNIT</th>
                            <th class="py-3 text-white text-center" style="width: 130px;">AKSI</th>
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
                        <tr>
                            <td class="px-3 py-3 text-secondary text-center">{{ $index + 1 }}</td>
                            <td class="py-3">
                                <div class="text-dark fw-bold" style="font-weight: 600;">{{ $k['nama'] }}</div>
                            </td>
                            <td class="py-3">
                                <div class="text-secondary"><i class="fab fa-whatsapp text-success me-1"></i> {{ $k['wa'] }}</div>
                            </td>
                            <td class="py-3">
                                <div class="text-secondary">{{ $k['alamat'] }}</div>
                            </td>
                            <td class="py-3 text-center">
                                <span class="badge px-3 py-2" style="border-radius: 6px; font-weight: 600; font-size: 0.82rem; background-color: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd;">
                                    <i class="fas fa-boxes me-1"></i> {{ $k['jumlah_unit'] }} Unit
                                </span>
                            </td>
                            <td class="py-3 text-center">
                                <!-- Tombol Aksi Sejajar Menyamping Tanpa Turun -->
                                <div class="d-flex justify-content-center align-items-center gap-1 flex-nowrap">
                                    <!-- Tombol Edit -->
                                    <button class="btn btn-sm btn-outline-primary shadow-sm px-2 py-1" title="Edit Data" style="border-radius: 4px;" data-toggle="modal" data-bs-toggle="modal" data-target="#modalEditKonsumen{{ $index }}" data-bs-target="#modalEditKonsumen{{ $index }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <!-- Tombol Hapus -->
                                    <button class="btn btn-sm btn-outline-danger shadow-sm px-2 py-1" title="Hapus Data" style="border-radius: 4px;">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
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