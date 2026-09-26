@extends('layouts.app')

@section('content')
<!-- Import Font 'Inter' untuk tampilan teks profesional & tegas -->
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
        background-color: #1e293b; /* Warna Navy Slate tegas */
        color: #ffffff;
        font-weight: 600;
        letter-spacing: 0.5px;
    }
    .crm-form-control {
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        padding: 0.45rem 0.75rem;
        font-size: 0.9rem;
        font-weight: 500;
        color: #0f172a;
    }
    .crm-form-control:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
        outline: none;
    }
    .crm-badge {
        font-weight: 600;
        letter-spacing: 0.3px;
        border-radius: 4px;
        padding: 0.35em 0.65em;
        font-size: 0.8rem;
    }
    .badge-lunas { background-color: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
    .badge-dp { background-color: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
    .badge-batal { background-color: #fee2e2; color: #b91c1c; border: 1px solid #fca5a5; }
</style>

<div class="container-fluid py-4 crm-wrapper">
    <!-- Header Halaman -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-dark" style="font-weight: 700; color: #0f172a !important;">Closing Servis & Transaksi</h1>
            <p class="text-secondary mb-0" style="font-weight: 500;">Penyelesaian pekerjaan servis, rincian biaya, kalkulasi garansi, dan pembuatan invoice CRM Jawaratech</p>
        </div>
        
        <!-- Tombol Proses Closing Baru -->
        <button type="button" class="btn btn-success shadow-sm px-4 py-2" style="font-weight: 600; border-radius: 6px; background-color: #16a34a; border-color: #16a34a;" data-toggle="modal" data-bs-toggle="modal" data-target="#modalTambahClosing" data-bs-target="#modalTambahClosing">
            <i class="fas fa-file-invoice-dollar fa-sm mr-2 me-2"></i> Proses Closing Servis
        </button>
    </div>

    <!-- Card Utama Data Closing -->
    <div class="card crm-card bg-white">
        <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
            <h6 class="m-0 text-dark" style="font-weight: 700;">
                <i class="fas fa-check-double text-success mr-2 me-2"></i>Daftar Transaksi Closing & Struk Nota
            </h6>
        </div>

        <!-- BAR PENCARIAN & FILTER DATA -->
        <div class="card-body border-bottom bg-light py-3 px-4">
            <form action="{{ route('closing.index') }}" method="GET" class="row g-2 align-items-center">
                <div class="col-md-5 col-sm-12 mb-2 mb-md-0">
                    <div class="input-group">
                        <div class="input-group-prepend input-group-text bg-white border-right-0 border-end-0 text-muted" style="border-radius: 6px 0 0 6px; border-color: #cbd5e1;">
                            <i class="fas fa-search"></i>
                        </div>
                        <input type="text" name="search" class="form-control crm-form-control border-left-0 border-start-0" placeholder="Cari No. Invoice, Tiket, Pelanggan, atau Teknisi..." value="{{ request('search') }}" style="border-radius: 0 6px 6px 0;">
                    </div>
                </div>

                <div class="col-md-4 col-sm-6 mb-2 mb-md-0">
                    <select name="status_pembayaran" class="form-control crm-form-control">
                        <option value="">-- Semua Status Pembayaran --</option>
                        <option value="Lunas" {{ request('status_pembayaran') == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                        <option value="DP / Belum Lunas" {{ request('status_pembayaran') == 'DP / Belum Lunas' ? 'selected' : '' }}>DP / Belum Lunas</option>
                        <option value="Dibatalkan" {{ request('status_pembayaran') == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>

                <div class="col-md-3 col-sm-6 d-flex">
                    <button type="submit" class="btn btn-dark w-100 shadow-sm mr-2 me-2" style="font-weight: 600; border-radius: 6px; background-color: #1e293b; border-color: #1e293b;">
                        <i class="fas fa-filter mr-1 me-1"></i> Filter
                    </button>
                    @if(request('search') || request('status_pembayaran'))
                        <a href="{{ route('closing.index') }}" class="btn btn-outline-secondary shadow-sm" title="Reset Filter" style="border-radius: 6px;">
                            <i class="fas fa-undo"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Tabel Data Closing Servis -->
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="crm-table-header">
                        <tr>
                            <th class="px-4 py-3 border-0">NO</th>
                            <th class="py-3 border-0">NO INVOICE / TIKET</th>
                            <th class="py-3 border-0">PELANGGAN & UNIT</th>
                            <th class="py-3 border-0">TEKNISI</th>
                            <th class="py-3 border-0">TOTAL BIAYA</th>
                            <th class="py-3 border-0">METODE & GARANSI</th>
                            <th class="py-3 border-0">STATUS BAYAR</th>
                            <th class="text-center py-3 border-0">AKSI</th>
                        </tr>
                    </thead>
                    <tbody style="font-weight: 500;">
                        @php
                            $closingData = [
                                [
                                    'no_invoice' => 'INV-202609-001',
                                    'no_tiket' => 'SRV-202609-001',
                                    'pelanggan' => 'Budi Santoso',
                                    'no_wa' => '081234567890',
                                    'unit' => 'AC Daikin Inverter 1 PK',
                                    'teknisi' => 'Mas Anto',
                                    'tgl_closing' => '2026-09-26',
                                    'biaya_jasa' => 150000,
                                    'biaya_sparepart' => 250000,
                                    'diskon' => 20000,
                                    'total_bayar' => 380000,
                                    'metode_pembayaran' => 'QRIS / Transfer',
                                    'garansi' => '30 Hari',
                                    'status_pembayaran' => 'Lunas',
                                    'rincian_pengerjaan' => 'Ganti Kapasitor Outdoor & Cuci AC Clean'
                                ],
                                [
                                    'no_invoice' => 'INV-202609-002',
                                    'no_tiket' => 'SRV-202609-002',
                                    'pelanggan' => 'Siti Aminah',
                                    'no_wa' => '089876543210',
                                    'unit' => 'Mesin Cuci LG Front Loading',
                                    'teknisi' => 'Pak Slamet',
                                    'tgl_closing' => '2026-09-26',
                                    'biaya_jasa' => 200000,
                                    'biaya_sparepart' => 180000,
                                    'diskon' => 0,
                                    'total_bayar' => 380000,
                                    'metode_pembayaran' => 'Tunai / Cash',
                                    'garansi' => '14 Hari',
                                    'status_pembayaran' => 'DP / Belum Lunas',
                                    'rincian_pengerjaan' => 'Perbaikan Water Drain Valve & Modul Pcb'
                                ],
                            ];
                        @endphp

                        @foreach($closingData as $index => $item)
                            <tr style="border-bottom: 1px solid #f1f5f9;">
                                <td class="px-4 py-3 text-secondary">{{ $index + 1 }}</td>
                                <td class="py-3">
                                    <div class="text-primary fw-bold" style="font-weight: 700;">{{ $item['no_invoice'] }}</div>
                                    <small class="text-muted"><i class="fas fa-ticket-alt mr-1 me-1"></i>{{ $item['no_tiket'] }}</small>
                                </td>
                                <td class="py-3">
                                    <div class="text-dark" style="font-weight: 600;">{{ $item['pelanggan'] }}</div>
                                    <small class="text-secondary">{{ $item['unit'] }}</small>
                                </td>
                                <td class="py-3 text-dark" style="font-weight: 600;">{{ $item['teknisi'] }}</td>
                                <td class="py-3">
                                    <div class="text-dark fw-bold" style="font-weight: 700; color: #0f172a;">Rp {{ number_format($item['total_bayar'], 0, ',', '.') }}</div>
                                    <small class="text-muted">Jasa: Rp {{ number_format($item['biaya_jasa'], 0, ',', '.') }}</small>
                                </td>
                                <td class="py-3">
                                    <div class="text-dark" style="font-size: 0.88rem;">{{ $item['metode_pembayaran'] }}</div>
                                    <small class="text-success" style="font-weight: 600;"><i class="fas fa-shield-alt mr-1 me-1"></i>Garansi {{ $item['garansi'] }}</small>
                                </td>
                                <td class="py-3">
                                    @if($item['status_pembayaran'] == 'Lunas')
                                        <span class="badge crm-badge badge-lunas"><i class="fas fa-check-circle mr-1 me-1"></i> LUNAS</span>
                                    @else
                                        <span class="badge crm-badge badge-dp"><i class="fas fa-clock mr-1 me-1"></i> DP / BELUM LUNAS</span>
                                    @endif
                                </td>
                                <td class="py-3 text-center">
                                    <button class="btn btn-sm btn-outline-primary shadow-sm mr-1 me-1" title="Edit Closing / Pelunasan" style="border-radius: 4px;" data-toggle="modal" data-bs-toggle="modal" data-target="#modalEditClosing{{ $index }}" data-bs-target="#modalEditClosing{{ $index }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <a href="#" class="btn btn-sm btn-outline-success shadow-sm mr-1 me-1" title="Cetak Kwitansi / Struk Closing" style="border-radius: 4px;">
                                        <i class="fas fa-print"></i>
                                    </a>
                                    <button class="btn btn-sm btn-outline-danger shadow-sm" title="Batalkan Closing" style="border-radius: 4px;">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>

                            <!-- Include Modal Edit -->
                            @include('closing.edit')

                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Include Modal Tambah -->
@include('closing.create')

<!-- Datalist Global nama teknisi -->
<datalist id="datalist_teknisi">
    <option value="Mas Anto"></option>
    <option value="Pak Slamet"></option>
    <option value="Teknisi Freelance / Luar"></option>
</datalist>

<!-- Script JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
@endsection