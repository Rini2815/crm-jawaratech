@extends('layouts.app')

@section('content')
<!-- Wrapper Utama dengan background gelap malam -->
<div class="container-fluid px-4 pt-3 pb-4" style="background: linear-gradient(135deg, #0b131d 0%, #060910 100%); min-height: 100vh; color: #f8fafc;">
    
    <!-- Header Title & Realtime Clock -->
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom border-secondary border-opacity-25">
        <div>
            <h2 class="text-white fw-bold mb-1">Dashboard CRM Jawaratech</h2>
            <p class="text-light opacity-75 small mb-0">Sistem Administrasi Layanan Servis & Manajemen Data Konsumen</p>
        </div>
        <div class="d-flex align-items-center gap-3">
            <!-- Badge Tanggal (Diperbesar) -->
            <div class="badge text-white px-3.5 py-2.5 rounded-pill shadow-sm fs-6" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); border: 1px solid rgba(56, 189, 248, 0.3);">
                <i class="fas fa-calendar-alt me-2 text-info"></i> {{ date('d M Y') }}
            </div>
            <!-- Badge Waktu Realtime Berjalan (Diperbesar) -->
            <div class="badge text-info px-3.5 py-2.5 rounded-pill shadow-sm fw-bold fs-6" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); border: 1px solid rgba(56, 189, 248, 0.3);">
                <i class="fas fa-clock me-2 text-info"></i> <span id="realtime-clock">00:00:00</span> WIB
            </div>
        </div>
    </div>

    <!-- 1. KARTU STATISTIK UTAMA -->
    <div class="row">
        <!-- Total Konsumen -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card rounded-4 text-dark" style="background: linear-gradient(135deg, #f1f5f9 0%, #cbd5e1 100%); border-left: 4px solid #0d1b2a !important; border: 1px solid rgba(36, 59, 85, 0.35) !important; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5), inset 0 0 20px rgba(36, 59, 85, 0.15) !important;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-secondary small fw-bold text-uppercase mb-1">Total Konsumen</div>
                            <div class="fs-3 fw-bold mb-0 text-dark">120 <span class="fs-6 fw-normal text-muted">Orang</span></div>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle text-primary">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 px-4 pb-3 pt-0">
                    <a class="small text-primary text-decoration-none d-flex align-items-center fw-semibold" href="#">
                        <span>Kelola Data Konsumen</span> <i class="fas fa-arrow-right ms-auto"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Antrean Servis Masuk -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card rounded-4 text-dark" style="background: linear-gradient(135deg, #f1f5f9 0%, #cbd5e1 100%); border-left: 4px solid #b45309 !important; border: 1px solid rgba(36, 59, 85, 0.35) !important; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5), inset 0 0 20px rgba(36, 59, 85, 0.15) !important;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-secondary small fw-bold text-uppercase mb-1">Servis Masuk</div>
                            <div class="fs-3 fw-bold mb-0 text-dark">15 <span class="fs-6 fw-normal text-muted">Unit</span></div>
                        </div>
                        <div class="p-3 rounded-circle" style="background: rgba(180, 83, 9, 0.15); color: #b45309;">
                            <i class="fas fa-tools fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 px-4 pb-3 pt-0">
                    <a class="text-decoration-none d-flex align-items-center fw-bold" href="{{ route('service-jobs.index') }}" style="color: #b45309; font-size: 0.875rem;">
                        <span>Registrasi Unit</span> <i class="fas fa-arrow-right ms-auto"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Servis Selesai / Closing -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card rounded-4 text-dark" style="background: linear-gradient(135deg, #f1f5f9 0%, #cbd5e1 100%); border-left: 4px solid #10b981 !important; border: 1px solid rgba(36, 59, 85, 0.35) !important; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5), inset 0 0 20px rgba(36, 59, 85, 0.15) !important;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-secondary small fw-bold text-uppercase mb-1">Servis Selesai</div>
                            <div class="fs-3 fw-bold mb-0 text-dark">85 <span class="fs-6 fw-normal text-muted">Unit</span></div>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded-circle text-success">
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 px-4 pb-3 pt-0">
                    <a class="small text-success text-decoration-none d-flex align-items-center fw-semibold" href="#">
                        <span>Lihat Riwayat Closing</span> <i class="fas fa-arrow-right ms-auto"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Jadwal Perawatan -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card rounded-4 text-dark" style="background: linear-gradient(135deg, #f1f5f9 0%, #cbd5e1 100%); border-left: 4px solid #d90429 !important; border: 1px solid rgba(36, 59, 85, 0.35) !important; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5), inset 0 0 20px rgba(36, 59, 85, 0.15) !important;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-secondary small fw-bold text-uppercase mb-1">Jadwal Perawatan</div>
                            <div class="fs-3 fw-bold mb-0 text-dark">5 <span class="fs-6 fw-normal text-muted">Perangkat</span></div>
                        </div>
                        <div class="bg-danger bg-opacity-10 p-3 rounded-circle text-danger">
                            <i class="fas fa-clock fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 px-4 pb-3 pt-0">
                    <a class="small text-danger text-decoration-none d-flex align-items-center fw-semibold" href="#">
                        <span>Cek Jadwal Rutin</span> <i class="fas fa-arrow-right ms-auto"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. SECTION GRAFIK BATANG & DIAGRAM LINGKARAN -->
    <div class="row">
        <!-- Grafik Kategori Keluhan Servis (Bar Chart) -->
        <div class="col-xl-8 mb-4">
            <div class="card rounded-4 h-100 text-dark" style="background: linear-gradient(135deg, #f1f5f9 0%, #cbd5e1 100%); border: 1px solid rgba(36, 59, 85, 0.35) !important; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5), inset 0 0 25px rgba(36, 59, 85, 0.12) !important;">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold text-dark m-0"><i class="fas fa-chart-bar text-primary me-2"></i> Statistik Kategori Keluhan Servis</h5>
                    <span class="text-muted small">Bulan Ini</span>
                </div>
                <div class="card-body px-4">
                    <div style="height: 300px; position: relative;">
                        <canvas id="keluhanChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Diagram Lingkaran Status Servis (Doughnut Chart) -->
        <div class="col-xl-4 mb-4">
            <div class="card rounded-4 h-100 text-dark" style="background: linear-gradient(135deg, #f1f5f9 0%, #cbd5e1 100%); border: 1px solid rgba(36, 59, 85, 0.35) !important; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5), inset 0 0 25px rgba(36, 59, 85, 0.12) !important;">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold text-dark m-0"><i class="fas fa-chart-pie text-primary me-2"></i> Proporsi Status</h5>
                </div>
                <div class="card-body px-4 d-flex align-items-center justify-content-center">
                    <div style="height: 230px; width: 100%; position: relative;">
                        <canvas id="statusPieChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. SECTION NOTIFIKASI PENGINGAT JADWAL SERVIS & INFORMASI LAYANAN -->
    <div class="row">
        <!-- Widget Notifikasi Pengingat Jadwal Servis & WhatsApp Follow-up (Warna Biru Putih Soft & Bentuk Lonjong) -->
        <div class="col-xl-4 mb-4">
            <div class="card rounded-4 h-100 text-dark shadow-sm overflow-hidden" style="background: linear-gradient(135deg, #f1f5f9 0%, #cbd5e1 100%); border: 1px solid rgba(36, 59, 85, 0.35) !important; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5), inset 0 0 25px rgba(36, 59, 85, 0.12) !important;">
                <!-- Header Widget -->
                <div class="p-3 pb-2 d-flex justify-content-between align-items-center border-bottom border-secondary border-opacity-25">
                    <span class="fw-bold text-dark" style="font-size: 14px;"><i class="fas fa-bell text-dark me-1"></i> Pengingat Servis Berkala</span>
                    <span class="badge bg-primary rounded-pill shadow-sm px-3 py-1.5" style="font-size: 11px;">3 Unit Perlu Perawatan</span>
                </div>
                <!-- Body List Notifikasi -->
                <div class="card-body p-3 d-flex flex-column gap-2.5">
                    <!-- Item 1 -->
                    <div class="p-3 rounded-pill border d-flex justify-content-between align-items-center shadow-sm px-4" style="background: linear-gradient(135deg, #ffffff 0%, #e0f2fe 100%); border-color: rgba(248, 91, 56, 0.4) !important;">
                        <div>
                            <div class="fw-bold text-dark" style="font-size: 14px;">Siti Aminah</div>
                            <div class="text-secondary mt-0.5" style="font-size: 11px;"><i class="fas fa-circle text-info me-1" style="font-size: 5px;"></i> AC Split • Cuci 3 Bulan</div>
                        </div>
                        <a href="https://wa.me/628123456789?text=Halo%20Kak%20Siti%20Aminah,%20mengingatkan%20jadwal%20perawatan%20berkala%20AC%20di%20Jawaratech%20sudah%20waktunya.%20Yuk%20jadwalkan%20servisnya!" target="_blank" class="btn btn-sm btn-success py-1 px-3 rounded-pill shadow-sm d-flex align-items-center gap-1 fw-semibold" style="font-size: 12px; background-color: #198754; border: none;" title="Follow-up via WhatsApp">
                            <i class="fab fa-whatsapp"></i> Chat
                        </a>
                    </div>
                    <!-- Item 2 -->
                    <div class="p-3 rounded-pill border d-flex justify-content-between align-items-center shadow-sm px-4" style="background: linear-gradient(135deg, #ffffff 0%, #e0f2fe 100%); border-color: rgba(141, 8, 8, 0.4) !important;">
                        <div>
                            <div class="fw-bold text-dark" style="font-size: 14px;">Budi Santoso</div>
                            <div class="text-secondary mt-0.5" style="font-size: 11px;"><i class="fas fa-circle text-primary me-1" style="font-size: 5px;"></i> Dispenser • Servis 6 Bulan</div>
                        </div>
                        <a href="https://wa.me/628987654321?text=Halo%20Bapak%20Budi%20Santoso,%20mengingatkan%20jadwal%20perawatan%20berkala%20dispenser%20di%20Jawaratech.%20Silakan%20hubungi%20kami%20untuk%20penjadwalan." target="_blank" class="btn btn-sm btn-success py-1 px-3 rounded-pill shadow-sm d-flex align-items-center gap-1 fw-semibold" style="font-size: 12px; background-color: #198754; border: none;" title="Follow-up via WhatsApp">
                            <i class="fab fa-whatsapp"></i> Chat
                        </a>
                    </div>
                    <!-- Item 3 -->
                    <div class="p-3 rounded-pill border d-flex justify-content-between align-items-center shadow-sm px-4" style="background: linear-gradient(135deg, #ffffff 0%, #e0f2fe 100%); border-color: rgba(56, 189, 248, 0.4) !important;">
                        <div>
                            <div class="fw-bold text-dark" style="font-size: 14px;">Ahmad Fauzi</div>
                            <div class="text-secondary mt-0.5" style="font-size: 11px;"><i class="fas fa-circle text-warning me-1" style="font-size: 5px;"></i> Mesin Cuci • Servis 1 Tahun</div>
                        </div>
                        <a href="https://wa.me/628567890123?text=Halo%20Bapak%20Ahmad%20Fauzi,%20mengingatkan%20jadwal%20perawatan%20tahunan%20mesin%20cuci%20di%20Jawaratech." target="_blank" class="btn btn-sm btn-success py-1 px-3 rounded-pill shadow-sm d-flex align-items-center gap-1 fw-semibold" style="font-size: 12px; background-color: #198754; border: none;" title="Follow-up via WhatsApp">
                            <i class="fab fa-whatsapp"></i> Chat
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informasi Layanan -->
        <div class="col-xl-8 mb-4">
            <div class="card rounded-4 h-100 text-dark" style="background: linear-gradient(135deg, #f1f5f9 0%, #cbd5e1 100%); border: 1px solid rgba(36, 59, 85, 0.35) !important; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5), inset 0 0 25px rgba(36, 59, 85, 0.12) !important;">
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    <div>
                        <h5 class="fw-bold text-dark mb-3"><i class="fas fa-info-circle text-primary me-2"></i> Informasi Layanan</h5>
                        <p class="text-muted small">Ringkasan cepat performa administrasi dan layanan servis perangkat di Jawaratech.</p>
                        <hr class="text-muted opacity-25">
                        <div class="mb-3">
                            <div class="d-flex justify-content-between small fw-bold mb-1 text-dark">
                                <span>Perangkat Elektronik / Laptop</span>
                                <span class="text-primary">45%</span>
                            </div>
                            <div class="progress bg-light border" style="height: 8px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 45%;"></div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between small fw-bold mb-1 text-dark">
                                <span>AC & Pendingin Ruangan</span>
                                <span class="text-success">30%</span>
                            </div>
                            <div class="progress bg-light border" style="height: 8px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 30%;"></div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between small fw-bold mb-1 text-dark">
                                <span>Mesin Cuci & Rumah Tangga</span>
                                <span class="text-warning">25%</span>
                            </div>
                            <div class="progress bg-light border" style="height: 8px;">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 25%;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="alert border-0 text-dark small mb-0 mt-3" style="background: #cbd5e1; border-left: 4px solid #0d1b2a !important;">
                        <i class="fas fa-lightbulb text-primary me-1"></i> Data grafik otomatis tersinkronisasi dari database servis masuk.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 4. TABEL ANTREAN SERVIS TERBARU -->
    <div class="card rounded-4 mb-4 text-dark" style="background: linear-gradient(135deg, #f1f5f9 0%, #cbd5e1 100%); border: 1px solid rgba(36, 59, 85, 0.35) !important; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5), inset 0 0 25px rgba(36, 59, 85, 0.12) !important;">
        <div class="card-header bg-transparent border-0 pt-4 px-4 pb-3 d-flex justify-content-between align-items-center">
            <h5 class="fw-bold text-dark m-0"><i class="fas fa-table text-primary me-2"></i> Daftar Antrean Servis Terbaru</h5>
            <a href="{{ route('service-jobs.index') }}" class="btn btn-sm btn-outline-dark px-3 rounded-pill">Lihat Semua</a>
        </div>
        <div class="card-body px-4 pb-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 bg-transparent" width="100%" cellspacing="0">
                    <thead class="table-light text-uppercase fs-7 text-secondary border-bottom border-secondary border-opacity-25" style="background: rgba(255, 255, 255, 0.5);">
                        <tr>
                            <th class="py-3 text-secondary">No</th>
                            <th class="py-3 text-secondary">Nama Konsumen</th>
                            <th class="py-3 text-secondary">Jenis Unit</th>
                            <th class="py-3 text-secondary">Status Perbaikan</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        <!-- Baris 1 -->
                        <tr class="border-bottom border-secondary border-opacity-10">
                            <td class="py-3 fw-semibold text-dark">1</td>
                            <td class="py-3 text-dark">Budi Santoso</td>
                            <td class="py-3">
                                <span class="badge px-3 py-1.5 fw-bold shadow-sm" style="background-color: rgba(13, 110, 253, 0.12); color: #0d6efd; border: 1px solid rgba(13, 110, 253, 0.4);">
                                    <i class="fas fa-laptop me-1"></i> Laptop
                                </span>
                            </td>
                            <td class="py-3"><span class="badge bg-warning text-dark fw-bold px-3 py-2 rounded-pill shadow-sm">Dalam Pengecekan</span></td>
                        </tr>
                        <!-- Baris 2 -->
                        <tr class="border-bottom border-secondary border-opacity-10">
                            <td class="py-3 fw-semibold text-dark">2</td>
                            <td class="py-3 text-dark">Siti Aminah</td>
                            <td class="py-3">
                                <span class="badge px-3 py-1.5 fw-bold shadow-sm" style="background-color: rgba(13, 202, 240, 0.12); color: #087990; border: 1px solid rgba(13, 202, 240, 0.4);">
                                    <i class="fas fa-snowflake me-1"></i> AC Split
                                </span>
                            </td>
                            <td class="py-3"><span class="badge bg-success text-white fw-bold px-3 py-2 rounded-pill shadow-sm">Selesai / Closing</span></td>
                        </tr>
                        <!-- Baris 3 -->
                        <tr>
                            <td class="py-3 fw-semibold text-dark">3</td>
                            <td class="py-3 text-dark">Ahmad Fauzi</td>
                            <td class="py-3">
                                <span class="badge px-3 py-1.5 fw-bold shadow-sm" style="background-color: rgba(255, 159, 67, 0.15); color: #b45309; border: 1px solid rgba(255, 159, 67, 0.4);">
                                    <i class="fas fa-tshirt me-1"></i> Mesin Cuci
                                </span>
                            </td>
                            <td class="py-3"><span class="badge bg-info text-dark fw-bold px-3 py-2 rounded-pill shadow-sm">Menunggu Konfirmasi</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Tambahan CSS Global agar Background Body Ikut Gelap -->
<style>
    body, html {
        background-color: #060910 !important;
    }
    .table-hover tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.04) !important;
    }
</style>

<!-- Library Chart.js & Script Realtime Jam + Grafik -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Script Jam Realtime
    function updateClock() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        document.getElementById('realtime-clock').textContent = `${hours}:${minutes}:${seconds}`;
    }
    setInterval(updateClock, 1000);
    updateClock();

    // Script Chart.js
    document.addEventListener("DOMContentLoaded", function() {
        // 1. Bar Chart Keluhan
        const ctxBar = document.getElementById('keluhanChart').getContext('2d');
        new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: ['Laptop / PC', 'AC Rumah', 'Mesin Cuci', 'Kulkas', 'Printer / Lainnya'],
                datasets: [{
                    label: 'Jumlah Unit Masuk',
                    data: [18, 12, 9, 6, 4],
                    backgroundColor: [
                        'rgba(13, 27, 42, 0.9)',    // Biru Tua Navy
                        'rgba(34, 197, 94, 0.85)',  // Hijau
                        'rgba(234, 179, 8, 0.85)',  // Kuning
                        'rgba(196, 59, 0, 0.8)',    // Orange
                        'rgba(34, 67, 197, 0.75)'   // Biru
                    ],
                    borderColor: ['#0d1b2a', '#16a34a', '#ca8a04', '#0d1b2a', '#1639a3'],
                    borderWidth: 1,
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { color: 'rgba(0, 0, 0, 0.05)' }, ticks: { color: '#475569', font: { weight: 'bold' } } },
                    x: { grid: { display: false }, ticks: { color: '#475569', font: { weight: 'bold' } } }
                }
            }
        });

        // 2. Pie / Doughnut Chart Status Servis
        const ctxPie = document.getElementById('statusPieChart').getContext('2d');
        new Chart(ctxPie, {
            type: 'doughnut',
            data: {
                labels: ['Selesai', 'Pengecekan', 'Menunggu'],
                datasets: [{
                    data: [85, 15, 5],
                    backgroundColor: [
                        'rgba(23, 68, 40, 0.91)',  // Hijau
                        'rgba(124, 150, 8, 0.85)',   // Kuning
                        'rgba(67, 192, 106, 0.85)'   // Biru
                    ],
                    borderColor: ['#16a34a', '#ca8a04', '#0284c7'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { boxWidth: 12, color: '#1e293b', font: { weight: 'bold', size: 10 } }
                    }
                }
            }
        });
    });
</script>
@endsection