@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 pt-3 pb-4 crm-wrapper" style="background: linear-gradient(135deg, #eef1f3 0%, #eef1f3 100%); min-height: 100vh; color: #f8fafc;">
    
    <!-- 1. HEADER HALAMAN (Dibungkus Card Gelap Elegan agar kontras & jelas dibaca) -->
    <div class="card rounded-4 mb-4 text-white shadow-lg overflow-hidden" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); border: 1px solid rgba(56, 189, 248, 0.35) !important;">
        <div class="card-body p-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h3 class="fw-bold text-white mb-1">
                    <i class="fas fa-calendar-alt text-primary me-2"></i> Jadwal Perawatan Berkala
                </h3>
                <p class="text-light opacity-75 small mb-0">
                    Monitoring interval perawatan otomatis: AC (3 Bulan), Dispenser/WH (6 Bulan), & Mesin Cuci (1 Tahun)
                </p>
            </div>
            <button class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold">
                <i class="fas fa-sync-alt me-1"></i> Perbarui Jadwal
            </button>
        </div>
    </div>

    <!-- 2. RINGKASAN STATISTIK PERAWATAN (Dengan Spasi & Bayangan yang Rapi) -->
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-white text-dark border-0 shadow-sm rounded-4 p-2" style="border-left: 5px solid #ca8a04 !important;">
                <div class="card-body d-flex align-items-center justify-content-between py-3">
                    <div>
                        <span class="text-muted small d-block mb-1 text-uppercase fw-bold" style="font-size: 0.7rem;">Jatuh Tempo Bulan Ini</span>
                        <h4 class="fw-bold mb-0 text-dark">12 <span class="fs-6 fw-normal text-muted">Unit</span></h4>
                    </div>
                    <div class="bg-warning bg-opacity-25 text-warning p-3 rounded-circle">
                        <i class="fas fa-clock fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-white text-dark border-0 shadow-sm rounded-4 p-2" style="border-left: 5px solid #2563eb !important;">
                <div class="card-body d-flex align-items-center justify-content-between py-3">
                    <div>
                        <span class="text-muted small d-block mb-1 text-uppercase fw-bold" style="font-size: 0.7rem;">Perawatan AC (3 Bln)</span>
                        <h4 class="fw-bold mb-0 text-dark">7 <span class="fs-6 fw-normal text-muted">Unit</span></h4>
                    </div>
                    <div class="bg-primary bg-opacity-25 text-primary p-3 rounded-circle">
                        <i class="fas fa-snowflake fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-white text-dark border-0 shadow-sm rounded-4 p-2" style="border-left: 5px solid #0891b2 !important;">
                <div class="card-body d-flex align-items-center justify-content-between py-3">
                    <div>
                        <span class="text-muted small d-block mb-1 text-uppercase fw-bold" style="font-size: 0.7rem;">Dispenser / WH (6 Bln)</span>
                        <h4 class="fw-bold mb-0 text-dark">3 <span class="fs-6 fw-normal text-muted">Unit</span></h4>
                    </div>
                    <div class="bg-info bg-opacity-25 text-info p-3 rounded-circle">
                        <i class="fas fa-faucet fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-white text-dark border-0 shadow-sm rounded-4 p-2" style="border-left: 5px solid #16a34a !important;">
                <div class="card-body d-flex align-items-center justify-content-between py-3">
                    <div>
                        <span class="text-muted small d-block mb-1 text-uppercase fw-bold" style="font-size: 0.7rem;">Mesin Cuci (1 Thn)</span>
                        <h4 class="fw-bold mb-0 text-dark">2 <span class="fs-6 fw-normal text-muted">Unit</span></h4>
                    </div>
                    <div class="bg-success bg-opacity-25 text-success p-3 rounded-circle">
                        <i class="fas fa-soap fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. TABEL DATA JADWAL PERAWATAN -->
    <div class="card border-0 shadow-lg rounded-4 overflow-hidden bg-white mb-4">
        <div class="card-header border-bottom py-3 px-4 d-flex justify-content-between align-items-center flex-wrap gap-2" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);">
            <h5 class="fw-bold text-white mb-0">
                <i class="fas fa-list text-info me-2"></i> Daftar Antrean Perawatan
            </h5>
            <!-- Filter Kategori -->
            <div class="d-flex gap-2">
                <select class="form-select form-select-sm bg-light text-dark border-secondary">
                    <option value="">Semua Perangkat</option>
                    <option value="AC">AC (3 Bulan)</option>
                    <option value="Dispenser">Dispenser / Water Heater (6 Bulan)</option>
                    <option value="Mesin Cuci">Mesin Cuci (1 Tahun)</option>
                </select>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="text-white small text-uppercase" style="background-color: #1e293b;">
                        <tr>
                            <th class="ps-4 py-3">Pelanggan</th>
                            <th class="py-3">Unit Perangkat</th>
                            <th class="py-3">Interval Servis</th>
                            <th class="py-3">Servis Terakhir</th>
                            <th class="py-3">Jatuh Tempo</th>
                            <th class="py-3">Status Follow-Up</th>
                            <th class="text-center pe-4 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0 small fw-medium">
                        <!-- Baris 1: AC (3 Bulan) -->
                        <tr>
                            <td class="ps-4 fw-bold text-dark">
                                Siti Aminah
                                <span class="d-block text-muted fw-normal" style="font-size: 0.75rem;">0812-3456-7890</span>
                            </td>
                            <td>
                                <!-- Badge Biru Tua Kontras & Jelas -->
                                <span class="badge px-2 py-1 fw-semibold" style="background-color: #1e3a8a; color: #ffffff;">
                                    <i class="fas fa-snowflake me-1"></i> AC Sharp 1 PK
                                </span>
                            </td>
                            <td><span class="text-info fw-bold">3 Bulan</span></td>
                            <td class="text-secondary">10 Juni 2026</td>
                            <td class="text-warning fw-bold">10 Sept 2026</td>
                            <td>
                                <span class="badge bg-warning text-dark fw-bold px-2 py-1"><i class="fas fa-clock me-1"></i> Minggu 1</span>
                            </td>
                            <td class="text-center pe-4">
                                <a href="https://wa.me/6281234567890?text=Halo%20Ibu%20Siti%20Aminah,%20jadwal%20perawatan%20cuci%20AC%20Sharp%20Anda%20di%20Jawaratech%20sudah%20jatuh%20tempo." target="_blank" class="btn btn-sm btn-success rounded-pill px-3 fw-semibold">
                                    <i class="fab fa-whatsapp me-1"></i> Ingatkan
                                </a>
                            </td>
                        </tr>
                        <!-- Baris 2: Dispenser (6 Bulan) -->
                        <tr>
                            <td class="ps-4 fw-bold text-dark">
                                Hendra Wijaya
                                <span class="d-block text-muted fw-normal" style="font-size: 0.75rem;">0857-1122-3344</span>
                            </td>
                            <td>
                                <!-- Badge Cokelat Tua Kontras & Jelas -->
                                <span class="badge px-2 py-1 fw-semibold" style="background-color: #78350f; color: #ffffff;">
                                    <i class="fas fa-faucet me-1"></i> Dispenser Miyako
                                </span>
                            </td>
                            <td><span class="text-info fw-bold">6 Bulan</span></td>
                            <td class="text-secondary">15 Maret 2026</td>
                            <td class="text-warning fw-bold">15 Sept 2026</td>
                            <td>
                                <span class="badge bg-warning text-dark fw-bold px-2 py-1"><i class="fas fa-clock me-1"></i> Minggu 1</span>
                            </td>
                            <td class="text-center pe-4">
                                <a href="https://wa.me/6285711223344?text=Halo%20Bapak%20Hendra,%20jadwal%20pembersihan%20elemen%20dispenser%20Miyako%20Anda%20di%20Jawaratech%20sudah%20jatuh%20tempo." target="_blank" class="btn btn-sm btn-success rounded-pill px-3 fw-semibold">
                                    <i class="fab fa-whatsapp me-1"></i> Ingatkan
                                </a>
                            </td>
                        </tr>
                        <!-- Baris 3: Mesin Cuci (1 Tahun) -->
                        <tr>
                            <td class="ps-4 fw-bold text-dark">
                                Budi Santoso
                                <span class="d-block text-muted fw-normal" style="font-size: 0.75rem;">0813-9988-7766</span>
                            </td>
                            <td>
                                <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 px-2 py-1 fw-semibold">
                                    <i class="fas fa-soap me-1"></i> Mesin Cuci LG
                                </span>
                            </td>
                            <td><span class="text-info fw-bold">1 Tahun</span></td>
                            <td class="text-secondary">28 Sept 2025</td>
                            <td class="text-danger fw-bold">28 Sept 2026</td>
                            <td>
                                <span class="badge bg-danger text-white fw-bold px-2 py-1"><i class="fas fa-exclamation-circle me-1"></i> Minggu 2</span>
                            </td>
                            <td class="text-center pe-4">
                                <a href="https://wa.me/6281399887766?text=Halo%20Bapak%20Budi,%20jadwal%20perawatan%201%20tahun%20mesin%20cuci%20LG%20Anda%20di%20Jawaratech%20sudah%20memasuki%20minggu%20ke-2." target="_blank" class="btn btn-sm btn-success rounded-pill px-3 fw-semibold">
                                    <i class="fab fa-whatsapp me-1"></i> Follow-Up
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<!-- CSS Global Tambahan -->
<style>
    body, html {
        background-color: #060910 !important;
    }
    .table-hover tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.02) !important;
    }
</style>
@endsection