@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 pt-3 pb-4 crm-wrapper" style="min-height: 100vh;">

    <!-- 1. HEADER HALAMAN -->
    <div class="card rounded-4 mb-4 text-white shadow-lg overflow-hidden" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); border: 1px solid rgba(56, 189, 248, 0.35) !important;">
        <div class="card-body p-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h3 class="fw-bold text-white mb-1">
                    <i class="fas fa-bell text-primary me-2"></i> Riwayat & Log Notifikasi Perawatan
                </h3>
                <p class="text-light opacity-75 small mb-0">
                    Semua pengingat perawatan berkala yang jatuh tempo, terlewat, atau akan datang.
                </p>
            </div>
        </div>
    </div>

    <!-- 2. RINGKASAN -->
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-white text-dark border-0 shadow-sm rounded-4 p-2" style="border-left: 5px solid #dc2626 !important;">
                <div class="card-body d-flex align-items-center justify-content-between py-3">
                    <div>
                        <span class="text-muted small d-block mb-1 text-uppercase fw-bold" style="font-size: 0.7rem;">Perlu Ditindak</span>
                        <h4 class="fw-bold mb-0 text-dark">{{ $totalJatuhTempo }} <span class="fs-6 fw-normal text-muted">Notifikasi</span></h4>
                    </div>
                    <div class="bg-danger bg-opacity-25 text-danger p-3 rounded-circle">
                        <i class="fas fa-exclamation-circle fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-white text-dark border-0 shadow-sm rounded-4 p-2" style="border-left: 5px solid #ca8a04 !important;">
                <div class="card-body d-flex align-items-center justify-content-between py-3">
                    <div>
                        <span class="text-muted small d-block mb-1 text-uppercase fw-bold" style="font-size: 0.7rem;">Total Notifikasi</span>
                        <h4 class="fw-bold mb-0 text-dark">{{ $notifications->count() }} <span class="fs-6 fw-normal text-muted">Unit</span></h4>
                    </div>
                    <div class="bg-warning bg-opacity-25 text-warning p-3 rounded-circle">
                        <i class="fas fa-bell fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. TABEL NOTIFIKASI -->
    <div class="card border-0 shadow-lg rounded-4 overflow-hidden bg-white mb-4">
        <div class="card-header border-bottom py-3 px-4 d-flex justify-content-between align-items-center flex-wrap gap-2" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);">
            <h5 class="fw-bold text-white mb-0">
                <i class="fas fa-list text-info me-2"></i> Daftar Notifikasi
            </h5>
            <a href="{{ route('schedules.index') }}" class="btn btn-sm btn-outline-light rounded-pill px-3">
                <i class="fas fa-calendar-alt me-1"></i> Lihat Jadwal Perawatan
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="text-white small text-uppercase" style="background-color: #1e293b;">
                        <tr>
                            <th class="ps-4 py-3">Pelanggan</th>
                            <th class="py-3">Unit Perangkat</th>
                            <th class="py-3">Jenis Notifikasi</th>
                            <th class="py-3">Jatuh Tempo</th>
                            <th class="py-3">Status</th>
                            <th class="text-center pe-4 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0 small fw-medium">
                        @forelse ($notifications as $item)
                        <tr>
                            <td class="ps-4 fw-bold text-dark">
                                {{ $item->nama_pelanggan }}
                                <span class="d-block text-muted fw-normal" style="font-size: 0.75rem;">{{ $item->no_hp }}</span>
                            </td>
                            <td>
                                <span class="badge px-2 py-1 fw-semibold {{ $item->icon_bg }} bg-opacity-25 text-dark">
                                    <i class="fas {{ $item->icon }} me-1"></i> {{ $item->nama_perangkat }}
                                </span>
                            </td>
                            <td class="text-secondary">{{ $item->jenis_notif }}</td>
                            <td class="fw-bold {{ str_contains($item->status_minggu, 'Terlewat') ? 'text-danger' : 'text-warning' }}">
                                {{ $item->tgl_jatuh_tempo }}
                            </td>
                            <td>
                                <span class="badge {{ $item->badge_color }} fw-bold px-2 py-1">
                                    <i class="fas fa-clock me-1"></i> {{ $item->status_minggu }}
                                </span>
                            </td>
                            <td class="text-center pe-4">
                                <a href="{{ $item->wa_link }}" target="_blank" class="btn btn-sm btn-success rounded-pill px-3 fw-semibold">
                                    <i class="fab fa-whatsapp me-1"></i> {{ $item->label_aksi }}
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Tidak ada notifikasi saat ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection