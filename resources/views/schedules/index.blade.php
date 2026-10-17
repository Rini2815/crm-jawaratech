@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 pt-3 pb-4 crm-wrapper" style="background: linear-gradient(135deg, #eef1f3 0%, #eef1f3 100%); min-height: 100vh; color: #f8fafc;">
    
    <!-- 1. HEADER HALAMAN (Dibungkus Card Gelap Elegan agar kontras & jelas dibaca) -->
    <div class="card rounded-4 mb-4 text-white shadow-lg overflow-hidden" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); border: 1px solid rgba(56, 189, 248, 0.35) !important;">
        <div class="card-body p-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h3 class="fw-bold text-white mb-1">
                    <i class="fas fa-calendar-alt text-primary me-2"></i> Pengingat Perawatan Berkala
                </h3>
                <p class="text-light opacity-75 small mb-0">
                    Monitoring interval perawatan otomatis: AC (3 Bulan), Dispenser/WH (6 Bulan), & Mesin Cuci (1 Tahun). Gunakan tombol WhatsApp untuk Menghubungi konsumen.
                </p>
            </div>
        </div>
    </div>

    <!-- Alert Notifikasi -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4 border-0 shadow-sm rounded-3" role="alert" style="background-color: #dcfce7; color: #166534;">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="alert-close" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4 border-0 shadow-sm rounded-3" role="alert" style="background-color: #fee2e2; color: #991b1b;">
            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
            <button type="button" class="alert-close" data-bs-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
    @endif

    <!-- 2. RINGKASAN STATISTIK PERAWATAN (Dengan Spasi & Bayangan yang Rapi) -->
    <div class="row g-3 mb-4">
        <div class="col-xl col-md-6">
            <div class="card bg-white text-dark border-0 shadow-sm rounded-4 p-2 h-100" style="border-left: 5px solid #ca8a04 !important;">
                <div class="card-body d-flex align-items-center justify-content-between py-3">
                    <div>
                        <span class="text-muted small d-block mb-1 text-uppercase fw-bold" style="font-size: 0.7rem;" title="Unit yang sudah jatuh tempo, terlewat, atau jatuh tempo sampai akhir bulan ini">Jatuh Tempo s.d. Bulan Ini</span>
                        <h4 class="fw-bold mb-0 text-dark">{{ $totalJatuhTempo }} <span class="fs-6 fw-normal text-muted">Unit</span></h4>
                    </div>
                    <div class="bg-warning bg-opacity-25 text-warning p-3 rounded-circle">
                        <i class="fas fa-clock fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl col-md-6">
            <div class="card bg-white text-dark border-0 shadow-sm rounded-4 p-2 h-100" style="border-left: 5px solid #2563eb !important;">
                <div class="card-body d-flex align-items-center justify-content-between py-3">
                    <div>
                        <span class="text-muted small d-block mb-1 text-uppercase fw-bold" style="font-size: 0.7rem;">Perawatan AC (3 Bln)</span>
                        <h4 class="fw-bold mb-0 text-dark">{{ $totalAc }} <span class="fs-6 fw-normal text-muted">Unit</span></h4>
                    </div>
                    <div class="bg-primary bg-opacity-25 text-primary p-3 rounded-circle">
                        <i class="fas fa-snowflake fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl col-md-6">
            <div class="card bg-white text-dark border-0 shadow-sm rounded-4 p-2 h-100" style="border-left: 5px solid #0891b2 !important;">
                <div class="card-body d-flex align-items-center justify-content-between py-3">
                    <div>
                        <span class="text-muted small d-block mb-1 text-uppercase fw-bold" style="font-size: 0.7rem;">Dispenser (6 Bln)</span>
                        <h4 class="fw-bold mb-0 text-dark">{{ $totalDispenser }} <span class="fs-6 fw-normal text-muted">Unit</span></h4>
                    </div>
                    <div class="bg-info bg-opacity-25 text-info p-3 rounded-circle">
                        <i class="fas fa-faucet fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl col-md-6">
            <div class="card bg-white text-dark border-0 shadow-sm rounded-4 p-2 h-100" style="border-left: 5px solid #ea580c !important;">
                <div class="card-body d-flex align-items-center justify-content-between py-3">
                    <div>
                        <span class="text-muted small d-block mb-1 text-uppercase fw-bold" style="font-size: 0.7rem;">Water Heater (6 Bln)</span>
                        <h4 class="fw-bold mb-0 text-dark">{{ $totalWaterHeater }} <span class="fs-6 fw-normal text-muted">Unit</span></h4>
                    </div>
                    <div class="p-3 rounded-circle" style="background-color: rgba(234, 88, 12, 0.15); color: #ea580c;">
                        <i class="fas fa-fire fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl col-md-6">
            <div class="card bg-white text-dark border-0 shadow-sm rounded-4 p-2 h-100" style="border-left: 5px solid #16a34a !important;">
                <div class="card-body d-flex align-items-center justify-content-between py-3">
                    <div>
                        <span class="text-muted small d-block mb-1 text-uppercase fw-bold" style="font-size: 0.7rem;">Mesin Cuci (1 Thn)</span>
                        <h4 class="fw-bold mb-0 text-dark">{{ $totalMesinCuci }} <span class="fs-6 fw-normal text-muted">Unit</span></h4>
                    </div>
                    <div class="bg-success bg-opacity-25 text-success p-3 rounded-circle">
                        <i class="fas fa-soap fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. CARD UTAMA TABEL DATA JADWAL PERAWATAN -->
    <div class="card border-0 shadow-lg rounded-4 overflow-hidden bg-white mb-4">
        
        <!-- HEADER CARD (JUDUL SAJA) -->
        <div class="card-header bg-white border-bottom pt-4 px-4 pb-3">
            <h5 class="m-0 text-dark fw-bold">Daftar Antrean Perawatan</h5>
            <small class="text-muted">Pantau konsumen yang sudah waktunya perawatan berkala</small>
        </div>

        <!-- BARIS PENCARIAN & FILTER (TERPISAH DARI HEADER) -->
        <div class="px-4 py-3 border-bottom bg-white d-flex align-items-center flex-wrap gap-2">
            <!-- Search Bar -->
            <div class="position-relative flex-grow-1" style="min-width: 260px;">
                <i class="fas fa-search position-absolute text-secondary" style="left: 14px; top: 50%; transform: translateY(-50%); font-size: 0.85rem;"></i>
                <input type="text" id="searchInput" class="form-control bg-white text-dark" placeholder="Cari nama pelanggan atau jenis unit..." style="padding-left: 40px; border-radius: 6px; border: 1px solid #cbd5e1; font-size: 0.875rem; height: 40px;">
            </div>

            <!-- Filter Perangkat -->
            <select id="filterPerangkat" class="form-select bg-white text-dark" style="flex: 1 1 260px; max-width: 480px; border-radius: 6px; border: 1px solid #cbd5e1; font-size: 0.875rem; height: 40px;">
                <option value="">-- Semua Perangkat --</option>
                <option value="AC">AC (3 Bulan)</option>
                <option value="Dispenser">Dispenser (6 Bulan)</option>
                <option value="Water Heater">Water Heater (6 Bulan)</option>
                <option value="Mesin Cuci">Mesin Cuci (1 Tahun)</option>
            </select>

            <!-- Tombol Filter -->
            <button type="button" id="btnFilter" class="btn text-white fw-bold d-flex align-items-center justify-content-center gap-2" style="background-color: #1e293b; border-radius: 6px; font-size: 0.875rem; height: 40px; min-width: 160px;">
                <i class="fas fa-filter"></i> Filter
            </button>
        </div>

        <div class="card-body px-4 pb-4 pt-3 bg-white">
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle mb-0 super-thick-table">
                    <!-- HEADER TABEL RATA TENGAH SEMUA -->
                    <thead class="crm-table-header text-uppercase text-center fs-7">
                        <tr>
                            <th class="py-3 text-white text-center" style="width: 5%;">NO</th>
                            <th class="py-3 text-white text-center" style="width: 18%;">PELANGGAN</th>
                            <th class="py-3 text-white text-center" style="width: 17%;">UNIT PERANGKAT</th>
                            <th class="py-3 text-white text-center" style="width: 11%;">INTERVAL SERVIS</th>
                            <th class="py-3 text-white text-center" style="width: 13%;">SERVIS TERAKHIR</th>
                            <th class="py-3 text-white text-center" style="width: 12%;">JATUH TEMPO</th>
                            <th class="py-3 text-white text-center" style="width: 12%;">STATUS JATUH TEMPO</th>
                            <th class="py-3 text-white text-center" style="width: 12%;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody id="reminderTableBody" class="small fw-medium">
                        @forelse($schedules as $j)
                        @php
                            $gayaBadge = match ($j->kelompok) {
                                'AC'           => 'background-color: #1e3a8a; color: #ffffff;',
                                'Dispenser'    => 'background-color: #78350f; color: #ffffff;',
                                'Water Heater' => 'background-color: #c2410c; color: #ffffff;',
                                default        => 'background-color: #0e7490; color: #ffffff;',
                            };
                            $ikonUnit = match ($j->jenis_unit) {
                                'AC'           => 'fa-snowflake',
                                'Water Heater' => 'fa-fire',
                                'Dispenser'    => 'fa-faucet',
                                default        => 'fa-soap',
                            };
                        @endphp
                        <tr data-kategori="{{ $j->kelompok }}">
                            <td class="py-3 text-secondary text-center fw-bold">{{ $loop->iteration }}</td>
                            <td class="py-3 fw-bold text-dark">
                                {{ $j->nama_pelanggan }}
                                <span class="d-block text-muted fw-normal" style="font-size: 0.75rem;">{{ $j->no_hp }}</span>
                            </td>
                            <td class="py-3">
                                <span class="badge px-2 py-1 fw-semibold" style="{{ $gayaBadge }}">
                                    <i class="fas {{ $ikonUnit }} me-1"></i> {{ $j->nama_perangkat }}
                                </span>
                            </td>
                            <td class="py-3 text-center"><span class="text-info fw-bold">{{ $j->interval_label }}</span></td>
                            <td class="py-3 text-secondary text-center">
                                {{ $j->terakhir->translatedFormat('j M Y') }}
                                @unless($j->dari_closing)
                                    <span class="d-block text-muted fw-normal" style="font-size: 0.7rem;">(tgl. masuk unit)</span>
                                @endunless
                            </td>
                            <td class="py-3 fw-bold text-center {{ $j->warna_tanggal }}">{{ $j->jatuh_tempo->translatedFormat('j M Y') }}</td>
                            <td class="py-3 text-center">
                                <span class="badge {{ $j->badge }} fw-bold px-2 py-1"><i class="fas {{ $j->ikon_status }} me-1"></i> {{ $j->status_label }}</span>
                                <span class="d-block text-muted fw-normal mt-1" style="font-size: 0.7rem;">{{ $j->keterangan }}</span>
                                @if($j->follow_status)
                                    <span class="badge bg-light text-dark border mt-1" style="font-size: 0.65rem;">{{ $j->follow_status }}</span>
                                @endif
                            </td>
                            <td class="py-3 text-center">
                                <!-- Catat agenda follow-up lalu buka WhatsApp di tab baru -->
                                <form action="{{ route('schedules.hubungi') }}" method="POST" target="_blank" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="id_unit" value="{{ $j->id_unit }}">
                                    <button type="submit" class="btn btn-sm btn-success rounded-pill px-3 fw-semibold">
                                        <i class="fab fa-whatsapp me-1"></i> Chat
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">Belum ada unit yang terdaftar untuk dipantau perawatannya.</td>
                        </tr>
                        @endforelse
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
    .crm-table-header {
        background-color: #1e293b; /* Slate/Navy khas Jawaratech */
        color: #ffffff;
        font-weight: 600;
        letter-spacing: 0.5px;
    }
    .super-thick-table th,
    .super-thick-table td {
        border-width: 2px !important;
        border-color: #cbd5e1 !important;
    }
    #btnFilter:hover {
        background-color: #0f172a !important;
    }

    /* Tombol silang notifikasi: di ujung kanan, tanpa kotak */
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
        opacity: 0.7;
    }
    .alert-close:hover { opacity: 1; }
    .alert-success .alert-close { color: #166534; }
    .alert-danger .alert-close { color: #991b1b; }
</style>

<!-- Filter Live Search + Filter Perangkat (Client-Side, tanpa jQuery) -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    var searchInput = document.getElementById('searchInput');
    var filterSelect = document.getElementById('filterPerangkat');
    var btnFilter = document.getElementById('btnFilter');
    var rows = document.querySelectorAll('#reminderTableBody tr');

    function terapkanFilter() {
        var keyword = searchInput.value.toLowerCase();
        var kategori = filterSelect.value;

        rows.forEach(function (row) {
            var cocokTeks = row.textContent.toLowerCase().indexOf(keyword) > -1;
            var cocokKategori = kategori === '' || row.getAttribute('data-kategori') === kategori;
            row.style.display = (cocokTeks && cocokKategori) ? '' : 'none';
        });
    }

    searchInput.addEventListener('keyup', terapkanFilter);
    filterSelect.addEventListener('change', terapkanFilter);
    btnFilter.addEventListener('click', terapkanFilter);

    // Notifikasi hilang otomatis setelah 4 detik
    setTimeout(function () {
        document.querySelectorAll('.alert').forEach(function (a) { a.style.display = 'none'; });
    }, 4000);
});
</script>
@endsection