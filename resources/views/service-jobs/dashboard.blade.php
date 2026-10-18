@extends('layouts.app')

@section('content')
<!-- Wrapper Utama dengan background terang/putih keabuan -->
<div class="container-fluid px-4 pt-3 pb-4 crm-wrapper" style="background: linear-gradient(135deg, #eef1f3 0%, #eef1f3); min-height: 100vh; color: #f8fafc;">
    
    <!-- Header Title & Realtime Clock -->
    <div class="card rounded-4 mb-4 text-white shadow-lg overflow-hidden" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); border: 1px solid rgba(56, 189, 248, 0.35) !important;">
        <div class="card-body p-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h2 class="text-white fw-bold mb-1">Dashboard CRM Jawaratech</h2>
                <p class="text-light opacity-75 small mb-0">Sistem Administrasi Layanan Servis & Manajemen Data Konsumen</p>
            </div>
            <div class="d-flex align-items-center gap-3">
                <div class="badge text-white px-3 py-2 rounded-pill shadow-sm fs-6" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); border: 1px solid rgba(56, 189, 248, 0.3);">
                    <i class="fas fa-calendar-alt me-2 text-info"></i> {{ date('d M Y') }}
                </div>
                <div class="badge text-info px-3 py-2 rounded-pill shadow-sm fw-bold fs-6" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); border: 1px solid rgba(56, 189, 248, 0.3);">
                    <i class="fas fa-clock me-2 text-info"></i> <span id="realtime-clock">00:00:00</span> WIB
                </div>
            </div>
        </div>
    </div>

    <!-- 1. KARTU STATISTIK UTAMA -->
    <div class="row">
        <!-- Total Konsumen -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card rounded-4 text-dark h-100" style="background: linear-gradient(135deg, #f1f5f9 0%, #cbd5e1 100%); border-left: 4px solid #0d1b2a !important; border: 1px solid rgba(36, 59, 85, 0.35) !important; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-secondary small fw-bold text-uppercase mb-1">Total Konsumen</div>
                            <div class="fs-3 fw-bold mb-0 text-dark">{{ $totalKonsumen ?? 0 }} <span class="fs-6 fw-normal text-muted">Orang</span></div>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle text-primary">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 px-4 pb-3 pt-0">
                    <a class="small text-primary text-decoration-none d-flex align-items-center fw-semibold" href="{{ route('data-konsumen') ?? '#' }}">
                        <span>Kelola Data Konsumen</span> <i class="fas fa-arrow-right ms-auto"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Antrean Servis Masuk -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card rounded-4 text-dark h-100" style="background: linear-gradient(135deg, #f1f5f9 0%, #cbd5e1 100%); border-left: 4px solid #b45309 !important; border: 1px solid rgba(36, 59, 85, 0.35) !important; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-secondary small fw-bold text-uppercase mb-1">Servis Masuk</div>
                            <div class="fs-3 fw-bold mb-0 text-dark">{{ $servisMasuk ?? 0 }} <span class="fs-6 fw-normal text-muted">Unit</span></div>
                        </div>
                        <div class="p-3 rounded-circle" style="background: rgba(180, 83, 9, 0.15); color: #b45309;">
                            <i class="fas fa-tools fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 px-4 pb-3 pt-0">
                    <a class="text-decoration-none d-flex align-items-center fw-bold" href="{{ route('registrasi.index') ?? '#' }}" style="color: #b45309; font-size: 0.875rem;">
                        <span>Registrasi Unit</span> <i class="fas fa-arrow-right ms-auto"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Servis Selesai / Closing -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card rounded-4 text-dark h-100" style="background: linear-gradient(135deg, #f1f5f9 0%, #cbd5e1 100%); border-left: 4px solid #10b981 !important; border: 1px solid rgba(36, 59, 85, 0.35) !important; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-secondary small fw-bold text-uppercase mb-1">Servis Selesai</div>
                            <div class="fs-3 fw-bold mb-0 text-dark">{{ $servisSelesai ?? 0 }} <span class="fs-6 fw-normal text-muted">Unit</span></div>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded-circle text-success">
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 px-4 pb-3 pt-0">
                    <a class="small text-success text-decoration-none d-flex align-items-center fw-semibold" href="{{ route('closing.index') ?? '#' }}">
                        <span>Lihat Riwayat Closing</span> <i class="fas fa-arrow-right ms-auto"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Jadwal Perawatan -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card rounded-4 text-dark h-100" style="background: linear-gradient(135deg, #f1f5f9 0%, #cbd5e1 100%); border-left: 4px solid #d90429 !important; border: 1px solid rgba(36, 59, 85, 0.35) !important; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-secondary small fw-bold text-uppercase mb-1">Jadwal Perawatan</div>
                            <div class="fs-3 fw-bold mb-0 text-dark">{{ $jadwalPerawatan ?? 0 }} <span class="fs-6 fw-normal text-muted">Perangkat</span></div>
                        </div>
                        <div class="bg-danger bg-opacity-10 p-3 rounded-circle text-danger">
                            <i class="fas fa-clock fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 px-4 pb-3 pt-0">
                    <a class="small text-danger text-decoration-none d-flex align-items-center fw-semibold" href="{{ route('schedules.index') ?? '#' }}">
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
            <div class="card rounded-4 h-100 text-dark" style="background: linear-gradient(135deg, #f1f5f9 0%, #cbd5e1 100%); border: 1px solid rgba(36, 59, 85, 0.35) !important; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold text-dark m-0"><i class="fas fa-chart-bar text-primary me-2"></i> Statistik Kategori Keluhan Servis</h5>
                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 rounded-pill px-3 py-1">
                        Bulan {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}
                    </span>
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
            <div class="card rounded-4 h-100 text-dark" style="background: linear-gradient(135deg, #f1f5f9 0%, #cbd5e1 100%); border: 1px solid rgba(36, 59, 85, 0.35) !important; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);">
                @php
                    // Menghitung otomatis total dan persentase untuk keterangan grafik
                    $totalStatus = ($statusSelesai ?? 0) + ($statusPengecekan ?? 0) + ($statusMenunggu ?? 0);
                    $persenSelesai =$totalStatus > 0 ? round((($statusSelesai ?? 0) / $totalStatus) * 100) : 0;
                    $persenPengecekan =$totalStatus > 0 ? round((($statusPengecekan ?? 0) / $totalStatus) * 100) : 0;
                    $persenMenunggu =$totalStatus > 0 ? round((($statusMenunggu ?? 0) / $totalStatus) * 100) : 0;
                @endphp
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold text-dark m-0">
                        <i class="fas fa-chart-pie text-primary me-2"></i> Proporsi Status
                    </h5>
                    <span class="badge bg-dark text-white rounded-pill px-3 py-1 extra-small">
                        Total: {{ $totalStatus }} Unit
                    </span>
                </div>
                <div class="card-body px-4 d-flex flex-column align-items-center justify-content-center">
                    <div style="height: 180px; width: 100%; position: relative;">
                        <canvas id="statusPieChart"></canvas>
                        <!-- Menambahkan teks keterangan total di tengah lingkaran chart -->
                        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center; pointer-events: none;">
                            <span class="d-block fw-bold text-dark fs-4">{{ $totalStatus }}</span>
                            <span class="d-block text-muted" style="font-size: 0.7rem;">Unit Servis</span>
                        </div>
                    </div>
                    
                    <div class="w-100 mt-3 pt-2 border-top border-secondary border-opacity-25">
                        <div class="row g-2 text-center" style="font-size: 0.8rem;">
                            <!-- Selesai -->
                            <div class="col-4">
                                <div class="p-2 rounded-3 bg-white bg-opacity-50 border border-success border-opacity-25 shadow-sm">
                                    <span class="d-inline-block rounded-circle me-1" style="width: 10px; height: 10px; background-color: #15803d;"></span>
                                    <strong class="d-block text-dark fw-bold" style="font-size: 0.75rem;">Selesai</strong>
                                    <small class="fw-bold d-block mt-1" style="color: #15803d;">{{ $statusSelesai ?? 0 }} Unit</small>
                                    <span class="badge text-white rounded-pill mt-1 px-2" style="background-color: #15803d; font-size: 0.65rem;">{{ $persenSelesai }}%</span>
                                </div>
                            </div>

                            <!-- Pengecekan -->
                            <div class="col-4">
                                <div class="p-2 rounded-3 bg-white bg-opacity-50 border border-warning border-opacity-25 shadow-sm">
                                    <span class="d-inline-block rounded-circle me-1" style="width: 10px; height: 10px; background-color: #b45309;"></span>
                                    <strong class="d-block text-dark fw-bold" style="font-size: 0.75rem;">Pengecekan</strong>
                                    <small class="fw-bold d-block mt-1" style="color: #b45309;">{{ $statusPengecekan ?? 0 }} Unit</small>
                                    <span class="badge text-white rounded-pill mt-1 px-2" style="background-color: #b45309; font-size: 0.65rem;">{{ $persenPengecekan }}%</span>
                                </div>
                            </div>

                            <!-- Menunggu -->
                            <div class="col-4">
                                <div class="p-2 rounded-3 bg-white bg-opacity-50 border border-info border-opacity-25 shadow-sm">
                                    <span class="d-inline-block rounded-circle me-1" style="width: 10px; height: 10px; background-color: #1e3a8a;"></span>
                                    <strong class="d-block text-dark fw-bold" style="font-size: 0.75rem;">Menunggu</strong>
                                    <small class="fw-bold d-block mt-1" style="color: #1e3a8a;">{{ $statusMenunggu ?? 0 }} Unit</small>
                                    <span class="badge text-white rounded-pill mt-1 px-2" style="background-color: #1e3a8a; font-size: 0.65rem;">{{ $persenMenunggu }}%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. SECTION NOTIFIKASI PENGINGAT JADWAL SERVIS & INFORMASI LAYANAN -->
    <div class="row">
        <!-- Widget Notifikasi Pengingat Jadwal Servis -->
        <div class="col-xl-4 mb-4">
            <div class="card rounded-4 h-100 text-dark shadow-sm overflow-hidden" style="background: linear-gradient(135deg, #f1f5f9 0%, #cbd5e1 100%); border: 1px solid rgba(36, 59, 85, 0.35) !important; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);">
                <div class="p-3 pb-2 d-flex justify-content-between align-items-center border-bottom border-secondary border-opacity-25">
                    <span class="fw-bold text-dark" style="font-size: 14px;"><i class="fas fa-bell text-dark me-1"></i> Pengingat Servis Berkala</span>
                    <span class="badge bg-primary rounded-pill shadow-sm px-3 py-2" style="font-size: 11px;">{{ $jadwalPerawatan ?? 0 }} Unit Perlu</span>
                </div>
                <div class="card-body p-3 d-flex flex-column gap-2">
                    
                    @forelse($listPengingat ?? [] as $pengingat)
                        @php
                            $noWa = preg_replace('/^0/', '62', $pengingat->no_whatsapp);$pesanWa = 'Halo ' . $pengingat->nama . ', mengingatkan jadwal perawatan berkala ' .$pengingat->jenis_unit . ' di Jawaratech.';
                        @endphp
                        <div class="p-3 rounded-pill border d-flex justify-content-between align-items-center shadow-sm px-4" style="background: linear-gradient(135deg, #ffffff 0%, #e0f2fe 100%); border-color: rgba(56, 189, 248, 0.4) !important;">
                            <div>
                                <div class="fw-bold text-dark" style="font-size: 14px;">{{ $pengingat->nama }}</div>
                                <div class="text-secondary mt-1" style="font-size: 11px;"><i class="fas fa-circle text-info me-1" style="font-size: 5px;"></i> {{ $pengingat->jenis_unit }} - {{$pengingat->kategori }}</div>
                            </div>
                            <a href="https://wa.me/{{ $noWa }}?text={{ rawurlencode($pesanWa) }}" target="_blank" class="btn btn-sm btn-success py-1 px-3 rounded-pill shadow-sm d-flex align-items-center gap-1 fw-semibold" style="font-size: 12px; background-color: #198754; border: none;">
                                <i class="fab fa-whatsapp"></i> Chat
                            </a>
                        </div>
                    @empty
                        <div class="text-center p-4">
                            <i class="fas fa-check-circle text-success fs-3 mb-2 opacity-50"></i>
                            <p class="text-muted small mb-0">Belum ada antrean jadwal perawatan berkala.</p>
                        </div>
                    @endforelse

                </div>
            </div>
        </div>        
        
        <!-- Informasi Layanan -->
        <div class="col-xl-8 mb-4">
            <div class="card rounded-4 h-100 text-dark" style="background: linear-gradient(135deg, #f1f5f9 0%, #cbd5e1 100%); border: 1px solid rgba(36, 59, 85, 0.35) !important; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);">
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fw-bold text-dark m-0"><i class="fas fa-info-circle text-primary me-2"></i> Proporsi Layanan</h5>
                            <span class="badge bg-dark bg-opacity-10 text-dark border border-dark border-opacity-25 rounded-pill px-3 py-1">
                                Tahun {{ date('Y') }}
                            </span>
                        </div>
                        <p class="text-muted small">Akumulasi proporsi unit servis masuk sepanjang tahun berjalan.</p>
                        <hr class="text-muted opacity-25">
                        
                        <!-- AC -->
                        <div class="mb-3">
                            <div class="d-flex justify-content-between small fw-bold mb-1 text-dark">
                                <span>AC <span class="text-muted fw-normal ms-1">({{ $unitTahunan['AC'] ?? 0 }} Unit)</span></span>
                                <span class="text-primary">{{ $persenAC ?? 0 }}%</span>
                            </div>
                            <div class="progress bg-light border" style="height: 8px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $persenAC ?? 0 }}%;"></div>
                            </div>
                        </div>

                        <!-- Mesin Cuci -->
                        <div class="mb-3">
                            <div class="d-flex justify-content-between small fw-bold mb-1 text-dark">
                                <span>Mesin Cuci <span class="text-muted fw-normal ms-1">({{ $unitTahunan['Mesin Cuci'] ?? 0 }} Unit)</span></span>
                                <span class="text-success">{{ $persenMC ?? 0 }}%</span>
                            </div>
                            <div class="progress bg-light border" style="height: 8px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: {{ $persenMC ?? 0 }}%;"></div>
                            </div>
                        </div>

                        <!-- Dispenser -->
                        <div class="mb-3">
                            <div class="d-flex justify-content-between small fw-bold mb-1 text-dark">
                                <span>Dispenser <span class="text-muted fw-normal ms-1">({{ $unitTahunan['Dispenser'] ?? 0 }} Unit)</span></span>
                                <span class="text-warning">{{ $persenDS ?? 0 }}%</span>
                            </div>
                            <div class="progress bg-light border" style="height: 8px;">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $persenDS ?? 0 }}%;"></div>
                            </div>
                        </div>

                        <!-- Water Heater -->
                        <div class="mb-3">
                            <div class="d-flex justify-content-between small fw-bold mb-1 text-dark">
                                <span>Water Heater <span class="text-muted fw-normal ms-1">({{ $unitTahunan['Water Heater'] ?? 0 }} Unit)</span></span>
                                <span class="text-info">{{ $persenWH ?? 0 }}%</span>
                            </div>
                            <div class="progress bg-light border" style="height: 8px;">
                                <div class="progress-bar bg-info" role="progressbar" style="width: {{ $persenWH ?? 0 }}%;"></div>
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
    <div class="card rounded-4 mb-4 text-dark" style="background: linear-gradient(135deg, #f1f5f9 0%, #cbd5e1 100%); border: 1px solid rgba(36, 59, 85, 0.35) !important; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);">
        <div class="card-header bg-transparent border-0 pt-4 px-4 pb-3 d-flex justify-content-between align-items-center">
            <h5 class="fw-bold text-dark m-0"><i class="fas fa-table text-primary me-2"></i> Daftar Antrean Servis Terbaru</h5>
            <a href="{{ route('service-jobs.index') ?? '#' }}" class="btn btn-sm btn-outline-dark px-3 rounded-pill">Lihat Semua</a>
        </div>
        <div class="card-body px-4 pb-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 bg-transparent" width="100%" cellspacing="0">
                    <thead class="table-light text-uppercase fs-7 text-secondary border-bottom border-secondary border-opacity-25" style="background: rgba(255, 255, 255, 0.5);">
                        <tr>
                            <th class="py-3 text-secondary">No</th>
                            <th class="py-3 text-secondary">Nama Konsumen</th>
                            <th class="py-3 text-secondary">Jenis Unit</th>
                            <th class="py-3 text-secondary">Status Servis</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        
                        @forelse($antreanTerbaru ?? [] as $index =>$antrean)
                            <tr class="border-bottom border-secondary border-opacity-10">
                                <td class="py-3 fw-semibold text-dark">{{ $index + 1 }}</td>
                                <td class="py-3 text-dark">{{ $antrean->nama }}</td>
                                <td class="py-3">
                                    <span class="badge px-3 py-2 fw-bold shadow-sm" style="background-color: rgba(13, 110, 253, 0.12); color: #0d6efd; border: 1px solid rgba(13, 110, 253, 0.4);">
                                        {{ $antrean->jenis_unit }}
                                    </span>
                                </td>
                                <td class="py-3">
                                    @if($antrean->status == 'Selesai')
                                        <!-- Hijau Tua Elegan -->
                                        <span class="badge text-white fw-bold px-3 py-2 rounded-pill shadow-sm" style="background-color: #15803d; letter-spacing: 0.5px;">
                                            <i class="fas fa-check-circle me-1"></i> {{ $antrean->status }}
                                        </span>
                                    @elseif($antrean->status == 'Menunggu Konfirmasi')
                                        <!-- Biru Dongker / Navy -->
                                        <span class="badge text-white fw-bold px-3 py-2 rounded-pill shadow-sm" style="background-color: #1e3a8a; letter-spacing: 0.5px;">
                                            <i class="fas fa-clock me-1"></i> {{ $antrean->status }}
                                        </span>
                                    @else
                                        <!-- Oranye Bata / Caramel -->
                                        <span class="badge text-white fw-bold px-3 py-2 rounded-pill shadow-sm" style="background-color: #b45309; letter-spacing: 0.5px;">
                                            <i class="fas fa-spinner fa-spin me-1"></i> {{ $antrean->status }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-3 text-muted">Belum ada antrean servis yang tercatat.</td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
body, html {
    background-color: #060910 !important;
}
.table-hover tbody tr:hover {
    background-color: rgba(0, 0, 0, 0.04) !important;
}
</style>

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

document.addEventListener("DOMContentLoaded", function() {
    
    // ==========================================
    // 1. BAR CHART (Efek Gelas Kaca / Stacked)
    // ==========================================
    const valAC = {{ $chartKeluhan['AC'] ?? 0 }};
    const valMC = {{ $chartKeluhan['Mesin Cuci'] ?? 0 }};
    const valDS = {{ $chartKeluhan['Dispenser'] ?? 0 }};
    const valWH = {{ $chartKeluhan['Water Heater'] ?? 0 }};
    
    const maxVal = Math.max(10, valAC, valMC, valDS, valWH); 

    const ctxBar = document.getElementById('keluhanChart').getContext('2d');
    new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: ['AC', 'Mesin Cuci', 'Dispenser', 'Water Heater'],
            datasets: [
                {
                    label: 'Jumlah Unit Masuk',
                    data: [valAC, valMC, valDS, valWH],
                    backgroundColor: [
                        'rgb(8, 45, 102)', 'rgb(122, 4, 4)', 'rgb(151, 84, 25)', 'rgb(21, 66, 62)'
                    ],
                    borderColor: [
                        'rgba(13, 71, 161, 1)', 'rgba(183, 28, 28, 1)', 'rgba(245, 127, 23, 1)', 'rgba(0, 137, 123, 1)'
                    ],
                    borderWidth: 2,
                },
                {
                    label: 'Placeholder',
                    data: [maxVal - valAC, maxVal - valMC, maxVal - valDS, maxVal - valWH],
                    backgroundColor: [
                        'rgba(13, 71, 161, 0.15)', 'rgba(183, 28, 28, 0.15)', 'rgba(245, 127, 23, 0.15)', 'rgba(0, 137, 123, 0.15)'
                    ],
                    borderColor: [
                        'rgba(13, 71, 161, 0.6)', 'rgba(183, 28, 28, 0.6)', 'rgba(245, 127, 23, 0.6)', 'rgba(0, 137, 123, 0.6)'
                    ],
                    borderWidth: 2,
                    borderDash: [5, 5],
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { 
                legend: { display: false },
                tooltip: {
                    filter: function(tooltipItem) {
                        return tooltipItem.datasetIndex === 0;
                    }
                }
            },
            scales: {
                x: { stacked: true, grid: { display: false }, ticks: { color: '#475569', font: { weight: 'bold' } } },
                y: { stacked: true, beginAtZero: true, max: maxVal, grid: { color: 'rgba(0, 0, 0, 0.05)' }, ticks: { color: '#475569', font: { weight: 'bold' }, stepSize: 1, precision: 0 } }
            }
        }
    });

    // ==========================================
    // 2. PIE CHART (Lingkaran Kosong Berwarna + Persentase Interaktif)
    // ==========================================
    const valSelesai = {{ $statusSelesai ?? 0 }};
    const valPengecekan = {{ $statusPengecekan ?? 0 }};
    const valMenunggu = {{ $statusMenunggu ?? 0 }};
    const totalStatus = valSelesai + valPengecekan + valMenunggu;

    const pieColors = ['46, 125, 50', '251, 192, 45', '2, 132, 199'];

    let pieData, pieBg, pieBorder;
    if (totalStatus === 0) {
        pieData = [1, 1, 1];
        pieBg = pieColors.map(c => `rgba(${c}, 0.15)`);
        pieBorder = pieColors.map(c => `rgba(${c}, 0.7)`);
    } else {
        pieData = [valSelesai, valPengecekan, valMenunggu];
        pieBg = pieColors.map(c => `rgba(${c}, 0.9)`);
        pieBorder = pieColors.map(c => `rgba(${c}, 1)`);
    }

    const ctxPie = document.getElementById('statusPieChart').getContext('2d');
    new Chart(ctxPie, {
        type: 'doughnut',
        data: {
            labels: ['Selesai', 'Pengecekan', 'Menunggu'],
            datasets: [{ data: pieData, backgroundColor: pieBg, borderColor: pieBorder, borderWidth: 1.5 }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '65%',
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            if (totalStatus === 0) return ' ' + context.label + ': Belum ada data';
                            let percentage = Math.round((context.raw / totalStatus) * 100);
                            return ' ' + context.label + ': ' + context.raw + ' Unit (' + percentage + '%)';
                        }
                    }
                }
            }
        }
    });
});
</script>
@endsection