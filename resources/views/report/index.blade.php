@extends('layouts.app')

@section('content')
<!-- Wrapper Utama -->
<div class="container-fluid px-4 pt-3 pb-4" style="background: linear-gradient(135deg, #eef1f3 0%, #eef1f3); min-height: 100vh; color: #f8fafc;">

    <!-- HEADER HALAMAN -->
    <div class="card rounded-4 mb-4 text-white shadow-lg overflow-hidden" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); border: 1px solid rgba(56, 189, 248, 0.35) !important;">
        <div class="card-body p-4 d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
            <div>
                <h2 class="text-white fw-bold mb-1"><i class="fas fa-file-alt text-primary me-2"></i> Laporan & Rekapitulasi Servis Jawaratech</h2>
                <p class="text-light opacity-75 small mb-0">Sistem Administrasi Layanan Servis, Registrasi, Closing, hingga Cetak Laporan PDF Riwayat Konsumen</p>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('report.pdf', request()->all()) }}" target="_blank" class="btn btn-danger px-3 py-2 rounded-pill shadow-sm fw-bold d-flex align-items-center gap-2" style="font-size: 0.875rem;">
                    <i class="fas fa-file-pdf"></i> Cetak Laporan PDF (Global)
                </a>
                <a href="{{ route('report.excel', request()->all()) }}" class="btn btn-success px-3 py-2 rounded-pill shadow-sm fw-bold d-flex align-items-center gap-2" style="font-size: 0.875rem;">
                    <i class="fas fa-file-excel"></i> Rekap Excel
                </a>
            </div>
        </div>
    </div>

    <!-- 1. 6 KARTU RINGKASAN STATISTIK -->
    <div class="row g-3 mb-4">
        <div class="col-xl-4 col-md-6">
            <div class="card rounded-4 text-dark shadow-sm h-100" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); border-left: 5px solid #0284c7 !important; border: 1px solid rgba(148, 163, 184, 0.5);">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-secondary small fw-bold text-uppercase mb-1">Total Unit Terdaftar</div>
                            <div class="fs-3 fw-bold mb-0 text-dark">{{ $totalKonsumen ?? 0 }} <span class="fs-6 fw-normal text-muted">Konsumen</span></div>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle text-primary"><i class="fas fa-users fa-2x"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="card rounded-4 text-dark shadow-sm h-100" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); border-left: 5px solid #059669 !important; border: 1px solid rgba(148, 163, 184, 0.5);">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-secondary small fw-bold text-uppercase mb-1">Closing Servis Bulan Ini</div>
                            <div class="fs-3 fw-bold mb-0 text-dark">{{ $closingBulanIni ?? 0 }} <span class="fs-6 fw-normal text-muted">Selesai</span></div>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded-circle text-success"><i class="fas fa-check-circle fa-2x"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="card rounded-4 text-dark shadow-sm h-100" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); border-left: 5px solid #0ea5e9 !important; border: 1px solid rgba(148, 163, 184, 0.5);">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-secondary small fw-bold text-uppercase mb-1">Unit Bergaransi Aktif</div>
                            <div class="fs-3 fw-bold mb-0 text-dark">{{ $garansiAktif ?? 0 }} <span class="fs-6 fw-normal text-muted">Valid</span></div>
                        </div>
                        <div class="p-3 rounded-circle" style="background: rgba(14, 165, 233, 0.15); color: #0ea5e9;"><i class="fas fa-shield-alt fa-2x"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="card rounded-4 text-dark shadow-sm h-100" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); border-left: 5px solid #d97706 !important; border: 1px solid rgba(148, 163, 184, 0.5);">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-secondary small fw-bold text-uppercase mb-1">Antrean Perawatan Berkala</div>
                            <div class="fs-3 fw-bold mb-0 text-dark">{{ $antreanPerawatan ?? 0 }} <span class="fs-6 fw-normal text-muted">Jadwal</span></div>
                        </div>
                        <div class="p-3 rounded-circle" style="background: rgba(217, 119, 6, 0.15); color: #d97706;"><i class="fas fa-bell fa-2x"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="card rounded-4 text-dark shadow-sm h-100" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); border-left: 5px solid #7c3aed !important; border: 1px solid rgba(148, 163, 184, 0.5);">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-secondary small fw-bold text-uppercase mb-1">Follow-Up WhatsApp (DM)</div>
                            <div class="fs-3 fw-bold mb-0 text-dark">{{ $followUpTerkirim ?? 0 }} <span class="fs-6 fw-normal text-muted">Terkirim</span></div>
                        </div>
                        <div class="p-3 rounded-circle" style="background: rgba(124, 58, 237, 0.15); color: #7c3aed;"><i class="fab fa-whatsapp fa-2x"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="card rounded-4 text-dark shadow-sm h-100" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); border-left: 5px solid #475569 !important; border: 1px solid rgba(148, 163, 184, 0.5);">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-secondary small fw-bold text-uppercase mb-1">Total Unit Tahun {{ date('Y') }}</div>
                            <div class="fs-3 fw-bold mb-0 text-dark">{{ $totalUnitTahunIni ?? 0 }} <span class="fs-6 fw-normal text-muted">Unit</span></div>
                        </div>
                        <div class="p-3 rounded-circle" style="background: rgba(71, 85, 105, 0.15); color: #475569;"><i class="fas fa-chart-line fa-2x"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. CARD FILTER PERIODE -->
    <div class="card rounded-4 mb-4 text-dark shadow-sm" style="background: linear-gradient(135deg, #f1f5f9 0%, #cbd5e1 100%); border: 1px solid rgba(36, 59, 85, 0.35) !important;">
        <div class="card-body p-4">
            <h5 class="fw-bold text-dark mb-3"><i class="fas fa-filter text-primary me-2"></i> Filter Periode, Unit & Kategori Laporan</h5>
            <form action="" method="GET">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label small fw-bold text-secondary">Pilih Tanggal (Harian)</label>
                        <input type="date" name="tanggal" class="form-control rounded-pill border-secondary shadow-sm text-dark" value="{{ request('tanggal') }}" style="background-color: #ffffff;">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold text-secondary">Pilih Bulan (Bulanan)</label>
                        <select name="bulan" class="form-select rounded-pill border-secondary shadow-sm text-dark" style="background-color: #ffffff;">
                            <option value="">Semua Bulan</option>
                            @foreach(['01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'] as $val => $nama)
                                <option value="{{ $val }}" {{ request('bulan') == $val ? 'selected' : '' }}>{{ $nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold text-secondary">Pilih Tahun (Tahunan)</label>
                        <select name="tahun" class="form-select rounded-pill border-secondary shadow-sm text-dark" style="background-color: #ffffff;">
                            <option value="2026" {{ request('tahun', date('Y')) == '2026' ? 'selected' : '' }}>2026</option>
                            <option value="2025" {{ request('tahun') == '2025' ? 'selected' : '' }}>2025</option>
                            <option value="2024" {{ request('tahun') == '2024' ? 'selected' : '' }}>2024</option>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-primary w-100 rounded-pill fw-semibold shadow-sm py-2" style="background-color: #2563eb; border-color: #2563eb;">
                            <i class="fas fa-search me-1"></i> Terapkan Filter
                        </button>
                        @if(request('tanggal') || request('bulan'))
                            <a href="{{ request()->url() }}" class="btn btn-outline-danger rounded-pill py-2" title="Reset Filter">
                                <i class="fas fa-times"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- 3. TABEL DATAR: 1 DATA = 1 KOLOM (urutan sama dengan PDF & CSV) -->
    <div class="card rounded-4 mb-4 text-dark shadow-sm overflow-hidden" style="background: linear-gradient(135deg, #f1f5f9 0%, #cbd5e1 100%); border: 1px solid rgba(36, 59, 85, 0.35) !important;">
        <div class="card-header text-white border-0 pt-3 px-4 pb-3 d-flex justify-content-between align-items-center" style="background-color: #1e293b;">
            <h5 class="fw-bold m-0"><i class="fas fa-history text-info me-2"></i> Log Komprehensif: Registrasi, Unit, Tiket, Teknisi & Closing</h5>
            <span class="badge bg-primary rounded-pill px-3 py-2 text-white border border-info">Menampilkan Data Riwayat Konsumen</span>
        </div>

        <div class="card-body px-3 pb-4">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover align-middle mb-0 bg-white tabel-laporan">
                    <thead class="text-uppercase text-white text-center" style="background-color: #1e293b;">
                        <tr>
                            <th>No</th>
                            <th>Tgl Registrasi</th>
                            <th>Nama Konsumen</th>
                            <th>No. WhatsApp</th>
                            <th>Alamat</th>
                            <th>No Tiket</th>
                            <th>Invoice</th>
                            <th>Unit</th>
                            <th>Merek</th>
                            <th>Model</th>
                            <th>Keluhan</th>
                            <th>Perkiraan Selesai</th>
                            <th>Status</th>
                            <th>Tgl Closing</th>
                            <th>Teknisi</th>
                            <th>Biaya Jasa</th>
                            <th>Biaya Sparepart</th>
                            <th>Diskon</th>
                            <th>Total Bayar</th>
                            <th>Metode</th>
                            <th>Status Bayar</th>
                            <th>Garansi</th>
                            <th>Masa Garansi</th>
                            <th>Jadwal Next Service</th>
                            <th>Hasil Follow-up</th>
                            <th>Catatan Hasil</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $jamWib = function ($v) {
                                if (empty($v)) return '';
                                $c = \Carbon\Carbon::parse($v);
                                return $c->format('H:i') === '00:00' ? '' : '<div class="jam-wib"><i class="far fa-clock me-1"></i>' . $c->format('H:i') . ' WIB</div>';
                            };
                        @endphp
                        @forelse($riwayatServis as $index => $item)
                        @php
                            $biaya = $item->biaya_jasa ?? ($item->total_biaya ?? 0);
                            $isGaransi = str_contains(strtolower($item->status_garansi ?? ''), 'aktif');
                            $nextService = $item->tanggal_jadwal_fu ?? $item->tanggal_jatuh_tempo ?? null;
                            $fuStatus = $item->status_follow_up ?? 'Belum Dihubungi';
                            $perkiraan = $item->x_perkiraan ?? null;
                            $totalBayar = $item->x_total_bayar ?? 0;
                                $sparepart = (float) ($item->x_sparepart ?? 0);
                                $diskon = (float) ($item->x_diskon ?? 0);
                            $statusBayar = $item->x_status_bayar ?? null;
                            $hariGaransi = $item->x_garansi_hari !== null ? ((int) preg_replace('/\D/', '', (string) $item->x_garansi_hari)) : null;
                        @endphp
                        <tr>
                            <td class="fw-bold text-center">{{ $riwayatServis->firstItem() + $index }}</td>
                            <td class="text-nowrap text-center"><span class="badge-tanggal">{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d M Y') }}</span>{!! $jamWib($item->created_at) !!}</td>
                            <td class="fw-bold text-nowrap">{{ $item->nama ?? 'Tanpa Nama' }}</td>
                            <td class="text-nowrap"><i class="fab fa-whatsapp text-success me-1"></i>{{ $item->no_whatsapp ?? '-' }}</td>
                            <td>{{ $item->alamat ?? '-' }}</td>
                            <td class="text-nowrap"><span class="badge bg-dark text-white">{{ $item->no_tiket ?? '-' }}</span></td>
                            <td class="text-nowrap">{{ $item->no_invoice ?? 'Belum Closing' }}</td>
                            <td class="text-nowrap fw-bold">{{ $item->jenis_unit ?? '-' }}</td>
                            <td class="text-nowrap fw-bold">{{ $item->merek ?? '-' }}</td>
                            <td>{{ $item->tipe_model ?? '-' }}</td>
                            <td style="min-width: 130px;">{{ $item->keluhan ?? '-' }}</td>
                            <td class="text-nowrap">{{ !empty($perkiraan) ? \Carbon\Carbon::parse($perkiraan)->translatedFormat('d M Y') : '-' }}</td>
                            <td class="text-center">
                                <span class="badge {{ ($item->status ?? '') === 'Selesai' ? 'bg-success' : 'bg-warning text-dark' }}">{{ $item->status ?? 'Proses' }}</span>
                            </td>
                            <td class="text-nowrap text-center">{{ !empty($item->x_tgl_closing) ? \Carbon\Carbon::parse($item->x_tgl_closing)->translatedFormat('d M Y') : '-' }}{!! $jamWib($item->x_tgl_closing) !!}</td>
                            <td class="text-nowrap">{{ $item->nama_teknisi ?? 'Belum Ditugaskan' }}</td>
                            <td class="text-end text-nowrap">{{ $biaya > 0 ? 'Rp ' . number_format($biaya, 0, ',', '.') : '-' }}</td>
                            <td class="text-end text-nowrap">{{ $sparepart > 0 ? 'Rp ' . number_format($sparepart, 0, ',', '.') : '-' }}</td>
                            <td class="text-end text-nowrap">{{ $diskon > 0 ? '- Rp ' . number_format($diskon, 0, ',', '.') : '-' }}</td>
                            <td class="text-end text-nowrap fw-bold">{{ $totalBayar > 0 ? 'Rp ' . number_format($totalBayar, 0, ',', '.') : '-' }}</td>
                            <td class="text-center">{{ $item->metode_pembayaran ?? '-' }}</td>
                            <td class="text-center">
                                @if($statusBayar)
                                    <span class="badge {{ strtolower($statusBayar) === 'lunas' ? 'bg-success' : 'bg-warning text-dark' }}">{{ $statusBayar }}</span>
                                @else - @endif
                            </td>
                            <td class="text-center">
                                <span class="badge {{ $isGaransi ? 'bg-success' : 'bg-secondary' }}">{{ $isGaransi ? 'Valid' : 'Non-Garansi' }}</span>
                            </td>
                            <td class="text-center text-nowrap">
                                @if($hariGaransi)
                                    <span class="badge bg-info text-dark">{{ $hariGaransi }} Hari</span><br>
                                    <small>s.d. {{ !empty($item->x_garansi_sampai) ? \Carbon\Carbon::parse($item->x_garansi_sampai)->format('d/m/Y') : '-' }}</small>
                                @else - @endif
                            </td>
                            <td class="text-nowrap">{{ !empty($nextService) ? \Carbon\Carbon::parse($nextService)->translatedFormat('d M Y') : 'Belum Dijadwalkan' }}</td>
                            <td class="text-center">
                                <span class="badge {{ $fuStatus === 'Belum Dihubungi' ? 'bg-warning text-dark' : 'bg-success' }}">{{ $fuStatus }}</span>
                            </td>
                            <td style="min-width: 120px;">{{ $item->catatan_hasil ?? '-' }}</td>
                            <td class="text-center text-nowrap">
                                <div class="d-flex flex-column gap-1">
                                    <button type="button" class="btn btn-sm btn-primary rounded-pill px-3 py-1 shadow-sm fw-bold" data-bs-toggle="modal" data-bs-target="#detailServis{{ $riwayatServis->firstItem() + $index }}" title="Lihat detail lengkap">
                                        <i class="fas fa-eye me-1"></i> Detail
                                    </button>
                                    <a href="{{ route('report.pdf', ['id_konsumen' => $item->id_konsumen]) }}" target="_blank" class="btn btn-sm btn-danger rounded-pill px-3 py-1 shadow-sm text-white fw-bold" title="Cetak Riwayat PDF Klien Ini">
                                        <i class="fas fa-print me-1"></i> PDF
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="26"class="text-center py-4 text-muted">
                                <i class="fas fa-folder-open fs-3 mb-2 opacity-50"></i><br>
                                Tidak ada data riwayat servis yang ditemukan pada database atau filter tersebut.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>


            {{-- ===================== MODAL DETAIL (satu per baris, baris kosong disembunyikan) ===================== --}}
            @foreach($riwayatServis as $index => $item)
            @php
                $nomorModal = $riwayatServis->firstItem() + $index;
                $rp   = fn ($n) => 'Rp ' . number_format($n, 0, ',', '.');
                $tgl  = fn ($d, $f = 'd F Y') => !empty($d) ? \Carbon\Carbon::parse($d)->translatedFormat($f) : null;
                $bdg  = fn ($teks, $kelas) => '<span class="badge ' . $kelas . '">' . e($teks) . '</span>';

                $mBiaya     = (float) ($item->biaya_jasa ?? 0);
                $mSparepart = (float) ($item->x_sparepart ?? 0);
                $mDiskon    = (float) ($item->x_diskon ?? 0);
                $mTotal     = (float) ($item->x_total_bayar ?? 0);
                $mGaransi   = str_contains(strtolower($item->status_garansi ?? ''), 'aktif');
                $mNext      = $item->tanggal_jadwal_fu ?? $item->tanggal_jatuh_tempo ?? null;
                $mFu        = $item->status_follow_up ?? null;
                $mHari      = $item->x_garansi_hari !== null ? ((int) preg_replace('/\D/', '', (string) $item->x_garansi_hari)) : null;
                $mSelesai   = ($item->status ?? '') === 'Selesai';
                $mLunas     = strtolower($item->x_status_bayar ?? '') === 'lunas';

                $mWa = preg_replace('/\D/', '', (string) ($item->no_whatsapp ?? ''));
                if ($mWa !== '' && substr($mWa, 0, 1) === '0') { $mWa = '62' . substr($mWa, 1); }
                $waHtml = !empty($item->no_whatsapp)
                    ? e($item->no_whatsapp) . ($mWa !== '' ? ' <a href="https://wa.me/' . $mWa . '" target="_blank" class="btn btn-sm btn-success rounded-pill py-0 px-2 ms-1"><i class="fab fa-whatsapp"></i></a>' : '')
                    : null;

                // Baris kosong (null / '' / '-') otomatis dibuang
                $bersih = fn (array $rows) => array_values(array_filter($rows, fn ($r) => $r[1] !== null && $r[1] !== '' && $r[1] !== '-'));

                $rowsKonsumen = $bersih([
                    ['Nama', e($item->nama ?? '')],
                    ['WhatsApp', $waHtml],
                    ['Alamat', e($item->alamat ?? '')],
                ]);
                $rowsUnit = $bersih([
                    ['Jenis Unit', e($item->jenis_unit ?? '')],
                    ['Merek', e($item->merek ?? '')],
                    ['Model / Tipe', e($item->tipe_model ?? '')],
                    ['Garansi Unit', $bdg($mGaransi ? 'Valid' : 'Non-Garansi', $mGaransi ? 'bg-success' : 'bg-secondary')],
                ]);
                $rowsRegistrasi = $bersih([
                    ['No Tiket', !empty($item->no_tiket) ? $bdg($item->no_tiket, 'badge-navy') : null],
                    ['Tgl Registrasi', !empty($item->created_at) ? $tgl($item->created_at, 'd F Y, H:i') . ' WIB' : null],
                    ['Perkiraan Selesai', $tgl($item->x_perkiraan)],
                    ['Teknisi', e($item->nama_teknisi ?? '')],
                    ['Status', !empty($item->status) ? $bdg($item->status, $mSelesai ? 'bg-success' : 'bg-warning text-dark') : null],
                ]);
                $rowsClosing = $bersih([
                    ['No Invoice', e($item->no_invoice ?? '')],
                    ['Tgl Closing', $tgl($item->x_tgl_closing)],
                    ['Biaya Jasa', $mBiaya > 0 ? $rp($mBiaya) : null],
                    ['Biaya Sparepart', $mSparepart > 0 ? $rp($mSparepart) : null],
                    ['Diskon', $mDiskon > 0 ? '<span class="text-danger">- ' . $rp($mDiskon) . '</span>' : null],
                    ['Metode Pembayaran', e($item->metode_pembayaran ?? '')],
                    ['Status Pembayaran', !empty($item->x_status_bayar) ? $bdg($item->x_status_bayar, $mLunas ? 'bg-success' : 'bg-warning text-dark') : null],
                ]);
                $rowsGaransi = $bersih([
                    ['Masa Garansi', $mHari ? $bdg($mHari . ' Hari', 'badge-navy') : null],
                    ['Berlaku s.d.', $tgl($item->x_garansi_sampai)],
                ]);
                $rowsFollow = $bersih([
                    ['Jadwal Next Service', $tgl($mNext)],
                    ['Status Follow-up', !empty($mFu) ? $bdg($mFu, $mFu === 'Belum Dihubungi' ? 'bg-warning text-dark' : 'bg-success') : null],
                    ['Catatan Hasil', e($item->catatan_hasil ?? '')],
                ]);

                $subJudul = array_filter([
                    $item->no_tiket ?? null,
                    $item->no_invoice ?? null,
                    $tgl($item->created_at, 'd M Y') ? 'Registrasi ' . $tgl($item->created_at, 'd M Y') : null,
                ]);
            @endphp
            <div class="modal fade" id="detailServis{{ $nomorModal }}" tabindex="-1" aria-labelledby="detailServisLabel{{ $nomorModal }}" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content rounded-4 border-0 shadow-lg" style="background:#eef2f7;">

                        <!-- Header -->
                        <div class="modal-header border-0 text-white px-4 py-3" style="background: linear-gradient(90deg, #0b0f19 0%, #1a0b12 55%, #4a0f1a 100%); border-bottom: 2px solid rgba(220, 38, 38, 0.55) !important;">
                            <div>
                                <h5 class="modal-title fw-bold mb-1" id="detailServisLabel{{ $nomorModal }}">
                                    <i class="fas fa-clipboard-list me-2 text-info"></i> Detail Servis — {{ $item->nama ?? 'Konsumen' }}
                                </h5>
                                <div class="small opacity-75">{{ implode('  •  ', $subJudul) }}</div>
                            </div>
                            <div class="d-flex align-items-center gap-2 ms-auto me-3">
                                @if(!empty($item->status))
                                    <span class="badge {{ $mSelesai ? 'bg-success' : 'bg-warning text-dark' }} px-3 py-2">{{ $item->status }}</span>
                                @endif
                                @if(!empty($item->x_status_bayar))
                                    <span class="badge {{ $mLunas ? 'bg-success' : 'bg-warning text-dark' }} px-3 py-2">{{ $item->x_status_bayar }}</span>
                                @endif
                            </div>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
                        </div>

                        <div class="modal-body p-4">
                            <div class="row g-3">

                                @if(count($rowsKonsumen))
                                <div class="col-lg-4">
                                    <div class="detail-card h-100">
                                        <div class="detail-title"><i class="fas fa-user me-2"></i>Data Konsumen</div>
                                        @foreach($rowsKonsumen as $r)
                                            <div class="kv"><span>{{ $r[0] }}</span><b>{!! $r[1] !!}</b></div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif

                                @if(count($rowsUnit))
                                <div class="col-lg-4">
                                    <div class="detail-card h-100">
                                        <div class="detail-title"><i class="fas fa-snowflake me-2"></i>Data Unit</div>
                                        @foreach($rowsUnit as $r)
                                            <div class="kv"><span>{{ $r[0] }}</span><b>{!! $r[1] !!}</b></div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif

                                @if(count($rowsRegistrasi))
                                <div class="col-lg-4">
                                    <div class="detail-card h-100">
                                        <div class="detail-title"><i class="fas fa-ticket-alt me-2"></i>Registrasi Servis & Pengerjaan</div>
                                        @foreach($rowsRegistrasi as $r)
                                            <div class="kv"><span>{{ $r[0] }}</span><b>{!! $r[1] !!}</b></div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif

                                @if(!empty($item->keluhan))
                                <div class="col-12">
                                    <div class="detail-card">
                                        <div class="detail-title"><i class="fas fa-comment-alt me-2"></i>Keluhan</div>
                                        <div class="keluhan-frame">{{ $item->keluhan }}</div>
                                    </div>
                                </div>
                                @endif

                                @if(count($rowsClosing) || $mTotal > 0)
                                <div class="col-lg-6">
                                    <div class="detail-card h-100">
                                        <div class="detail-title"><i class="fas fa-file-invoice-dollar me-2"></i>Closing & Pembayaran</div>
                                        @foreach($rowsClosing as $r)
                                            <div class="kv"><span>{{ $r[0] }}</span><b>{!! $r[1] !!}</b></div>
                                        @endforeach
                                        @if($mTotal > 0)
                                        <div class="d-flex justify-content-between align-items-center mt-3 p-3 rounded-3" style="background:#dbeafe; border:2px solid #1e3a8a;">
                                            <span class="fw-bold" style="color:#1e3a8a;">Total Bayar</span>
                                            <span class="fs-5 fw-bold" style="color:#1e3a8a;">{{ $rp($mTotal) }}</span>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                @endif

                                @if(count($rowsGaransi) || count($rowsFollow))
                                <div class="col-lg-6">
                                    @if(count($rowsGaransi))
                                    <div class="detail-card {{ count($rowsFollow) ? 'mb-3' : '' }}">
                                        <div class="detail-title"><i class="fas fa-shield-alt me-2"></i>Garansi Servis</div>
                                        @foreach($rowsGaransi as $r)
                                            <div class="kv"><span>{{ $r[0] }}</span><b>{!! $r[1] !!}</b></div>
                                        @endforeach
                                    </div>
                                    @endif
                                    @if(count($rowsFollow))
                                    <div class="detail-card">
                                        <div class="detail-title"><i class="fab fa-whatsapp me-2"></i>Follow-up & Perawatan Berkala</div>
                                        @foreach($rowsFollow as $r)
                                            <div class="kv"><span>{{ $r[0] }}</span><b>{!! $r[1] !!}</b></div>
                                        @endforeach
                                    </div>
                                    @endif
                                </div>
                                @endif

                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="modal-footer border-0 px-4 pb-4 pt-0">
                            <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
                            <a href="{{ route('report.pdf', ['id_konsumen' => $item->id_konsumen]) }}" target="_blank" class="btn rounded-pill px-4 fw-bold text-white" style="background:#1e3a8a;">
                                <i class="fas fa-print me-1"></i> Cetak PDF Konsumen Ini
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

            <!-- Pagination -->
            <div class="mt-3">
                {{ $riwayatServis->links() }}
            </div>
        </div>
    </div>
</div>

<style>
    body, html {
        background-color: #060910 !important;
    }
    .tabel-laporan {
        font-size: 1rem;
        font-weight: 600;
        color: #0f172a;
    }
    .badge-tanggal {
        display: inline-block;
        background: #dbeafe;
        color: #1e3a8a;
        border: 1.5px solid #2563eb;
        border-radius: 6px;
        padding: 3px 8px;
        font-weight: 700;
    }
    .tabel-laporan th,
    .tabel-laporan td {
        border-width: 1.5px !important;
        border-color: #334155 !important;
        padding: 0.7rem 0.8rem !important;
        vertical-align: middle;
    }
    .tabel-laporan thead th {
        background-color: #1e293b !important;
        color: #fff !important;
        font-size: 0.85rem;
        white-space: nowrap;
    }
    .tabel-laporan .badge { font-size: 0.85rem; padding: 0.4em 0.65em; }
    .tabel-laporan .badge-tanggal { font-size: 0.95rem; padding: 4px 10px; }
    .tabel-laporan .btn { font-size: 0.9rem; }
    .tabel-laporan .jam-wib { font-size: 0.82rem; color: #475569; font-weight: 700; margin-top: 4px; }

    /* ====== Modal Detail (navy + bingkai) ====== */
    .detail-card {
        background: #ffffff;
        border: 1.5px solid #cbd5e1;
        border-top: 4px solid #1e3a8a;
        border-radius: 14px;
        padding: 16px 18px;
        box-shadow: 0 2px 6px rgba(30, 58, 138, 0.10);
    }
    .detail-title {
        display: flex;
        align-items: center;
        font-weight: 800;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: .5px;
        color: #1e3a8a;
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        border-radius: 8px;
        padding: 8px 12px;
        margin-bottom: 12px;
    }
    .detail-title i { color: #1e3a8a; }
    .kv {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        padding: 5px 0;
        font-size: 0.88rem;
    }
    .kv span { color: #475569; font-weight: 600; flex: 0 0 36%; }
    /* nilai berbingkai */
    .kv b {
        color: #0f172a;
        text-align: right;
        flex: 1;
        word-break: break-word;
        background: #f8fafc;
        border: 1px solid #cbd5e1;
        border-left: 3px solid #1e3a8a;
        border-radius: 8px;
        padding: 5px 10px;
    }
    .keluhan-frame {
        background: #eff6ff;
        border: 1.5px solid #bfdbfe;
        border-left: 5px solid #1e3a8a;
        border-radius: 10px;
        padding: 12px 16px;
        font-weight: 600;
        color: #0f172a;
    }
    .badge-navy { background-color: #1e3a8a !important; }
    /* Badge di dalam modal: teks putih di atas warna gelap/hijau, supaya jelas terbaca */
    .kv b .badge:not(.text-dark) { color: #ffffff !important; }
    .kv b .badge.text-dark { color: #111827 !important; }
</style>
@endsection