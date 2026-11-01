<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $judulLaporan ?? 'Laporan Rekapitulasi Servis - Jawaratech' }}</title>
    <style>
        @page {
            margin: 6mm;
            size: {{ request('kertas') === 'a3' ? 'A3' : 'A4' }} landscape;
        }
        * { box-sizing: border-box; }
        body {
            font-family: Arial, sans-serif;
            font-size: 9px;
            color: #000;
            margin: 0;
            padding: 0;
            background: #fff;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        /* ===== Kop surat ===== */
        .kop-surat { border-bottom: 3px double #000; padding-bottom: 6px; margin-bottom: 8px; width: 100%; }
        .kop-table { width: 100%; border-collapse: collapse; }
        .kop-table td { vertical-align: middle; border: none; }
        .logo-col { width: 12%; text-align: left; }
        .logo-col img { width: 62px; height: auto; }
        .text-col { width: 88%; text-align: center; padding-right: 62px; }
        .text-col h2 { margin: 0; font-size: 17px; text-transform: uppercase; letter-spacing: 2px; }
        .text-col h4 { margin: 2px 0; font-size: 10px; }
        .text-col p { margin: 1px 0; font-size: 9px; }

        .company-desc {
            border: 1px solid #000; border-left: 4px solid #000;
            padding: 6px 10px; margin-bottom: 8px; font-size: 9px; line-height: 1.35;
        }

        .report-title { text-align: center; margin-bottom: 4px; }
        .report-title h3 {
            margin: 0; text-transform: uppercase; font-size: 12px;
            border-bottom: 1px solid #000; display: inline-block; padding-bottom: 2px;
        }
        .periode { text-align: center; margin: 4px 0 8px 0; font-size: 9px; }

        .client-info { border: 1px solid #000; padding: 5px 8px; border-radius: 4px; margin-bottom: 8px; }
        .client-info table { width: 100%; border-collapse: collapse; }
        .client-info td { padding: 2px 5px; vertical-align: top; font-size: 9.5px; border: none; }
        .client-info .label { font-weight: bold; width: 100px; }

        p.section-subtitle { margin: 10px 0 4px 0; font-weight: bold; font-size: 10px; }

        /* ===== Tabel: 1 tabel utuh. Lebar kolom otomatis, isi boleh turun baris
           sehingga font bisa besar dan seluruh kolom tetap muat di A4 landscape ===== */
        table.data-table { width: 100%; border-collapse: collapse; table-layout: auto; }
        table.data-table th, table.data-table td {
            border: 1px solid #000;
            padding: 5px 4px;
            font-size: 9.5px;
            font-weight: 600;
            line-height: 1.25;
            vertical-align: middle;
            word-break: normal;
            overflow-wrap: break-word;
        }
        table.data-table th {
            background: #000 !important;
            color: #fff !important;
            text-transform: uppercase;
            font-size: 8.5px;
            text-align: center;
            font-weight: bold;
            padding: 7px 4px;
            white-space: normal;
        }
        table.data-table thead { display: table-header-group; }
        table.data-table tr { page-break-inside: avoid; }
        table.data-table tbody tr:nth-child(even) td { background: #f2f2f2; }

        .text-center { text-align: center; }
        .text-right  { text-align: right; }
        .fw-bold     { font-weight: bold; }
        .nowrap      { white-space: nowrap; }

        .badge {
            display: inline-block; padding: 2px 5px; border-radius: 3px; font-weight: bold;
            border: 1px solid #555; font-size: 8.5px; white-space: normal; text-align: center;
        }
        .badge-ok   { background: #d4edda !important; color: #155724; border-color: #8fc79f; }
        .badge-no   { background: #e2e3e5 !important; color: #333;    border-color: #aaa; }
        .badge-warn { background: #fff3cd !important; color: #856404; border-color: #e0c870; }
        .badge-tgl  { background: #e5e5e5 !important; color: #000;    border-color: #000; }

        .footer-sign { margin-top: 15px; width: 100%; page-break-inside: avoid; }
        .footer-sign table { width: 100%; border: none; border-collapse: collapse; }
        .footer-sign td { border: none; text-align: center; font-size: 10px; }
    </style>
</head>
<body>

    <!-- KOP SURAT -->
    <div class="kop-surat">
        <table class="kop-table">
            <tr>
                <td class="logo-col">
                    <img src="{{ asset('image/logo.png') }}" alt="Logo Jawaratech">
                </td>
                <td class="text-col">
                    <h2>JAWARATECH</h2>
                    <h4>Penyedia Jasa Servis Elektronik</h4>
                    <p><strong>Dikelola oleh CV Jawara Tiga Pendiri</strong></p>
                    <p>
                        <strong>Pusat Madiun/Caruban:</strong> Jl. Ontorejo, RT.3/RW.2, Wonoasri, Kab. Madiun |
                        <strong>Magetan:</strong> Dsn. Lemi, Ds. Jajar, Kartoharjo, Kab. Magetan
                    </p>
                    <p><strong>WhatsApp:</strong> +62 822-2808-4708 | <strong>Instagram/TikTok:</strong> @jawaratech</p>
                </td>
            </tr>
        </table>
    </div>

    <div class="company-desc">
        <strong>Tentang Jawaratech:</strong> Jawaratech (CV Jawara Tiga Pendiri) adalah pusat layanan servis elektronik panggilan dan pemeliharaan perangkat rumah tangga terkemuka di wilayah Karesidenan Madiun. Laporan resmi ini merangkum rekam jejak riwayat servis, pemeliharaan berkala, serta status pengerjaan unit konsumen secara transparan dan akurat.
    </div>

    <div class="report-title">
        <h3>{{ isset($konsumen) ? 'Laporan Riwayat Servis & Follow-up Konsumen' : 'Laporan Rekapitulasi Global Servis & Follow-up' }}</h3>
    </div>
    <div class="periode"><strong>Periode Tanggal Registrasi:</strong> {{ $periode ?? '-' }}</div>

    @if(isset($konsumen))
    <div class="client-info">
        <table>
            <tr>
                <td class="label">Nama Konsumen</td>
                <td>: <strong>{{ $konsumen->nama }}</strong></td>
                <td class="label">ID Konsumen</td>
                <td>: #{{ $konsumen->id_konsumen }}</td>
            </tr>
            <tr>
                <td class="label">No. WhatsApp</td>
                <td>: {{ $konsumen->no_whatsapp ?? '-' }}</td>
                <td class="label">Alamat Klien</td>
                <td>: {{ $konsumen->alamat ?? '-' }}</td>
            </tr>
        </table>
    </div>
    @endif

    <!-- ============================================================ -->
    <!-- TABEL A : REGISTRASI SERVIS & PENGERJAAN                      -->
    <!-- ============================================================ -->
    @php
        $jam = function ($v) {
            if (empty($v)) return '';
            $c = \Carbon\Carbon::parse($v);
            return $c->format('H:i') === '00:00' ? '' : '<br><span style="font-weight:600;">' . $c->format('H:i') . ' WIB</span>';
        };
    @endphp
    <p class="section-subtitle">A. Registrasi Servis & Pengerjaan Unit</p>
    <table class="data-table">
        <thead>
            <tr>
                @unless(isset($konsumen))
                <th>ID</th>
                @endunless
                <th>No</th>
                <th>Tgl Registrasi</th>
                @unless(isset($konsumen))
                <th>Nama Konsumen</th>
                @endunless
                @unless(isset($konsumen))
                <th>No. WhatsApp</th>
                @endunless
                <th>Alamat</th>
                <th>No Tiket</th>
                <th>Invoice</th>
                <th>Unit</th>
                <th>Merek</th>
                <th>Model</th>
                <th>Keluhan</th>
                <th>Perkiraan Selesai</th>
                <th>Status</th>
                <th>Teknisi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($riwayatServis as $index => $item)
            <tr>
                @unless(isset($konsumen))
                <td class="text-center fw-bold nowrap">#{{ $item->id_konsumen ?? '-' }}</td>
                @endunless
                <td class="text-center fw-bold nowrap">{{ $index + 1 }}</td>
                <td class="text-center nowrap"><span class="badge badge-tgl nowrap">{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d M Y') }}{!! $jam($item->created_at) !!}</span></td>
                @unless(isset($konsumen))
                <td class="fw-bold">{{ $item->nama ?? '-' }}</td>
                @endunless
                @unless(isset($konsumen))
                <td class="nowrap">{{ $item->no_whatsapp ?? '-' }}</td>
                @endunless
                <td>{{ $item->alamat ?? '-' }}</td>
                <td class="fw-bold nowrap">{{ $item->no_tiket ?? '-' }}</td>
                <td class="nowrap">{{ $item->no_invoice ?? 'Belum Cetak' }}</td>
                <td class="fw-bold">{{ $item->jenis_unit ?? '-' }}</td>
                <td class="fw-bold">{{ $item->merek ?? '-' }}</td>
                <td>{{ $item->tipe_model ?? '-' }}</td>
                <td><em>{{ $item->keluhan ?? '-' }}</em></td>
                <td class="text-center nowrap">{{ !empty($item->x_perkiraan) ? \Carbon\Carbon::parse($item->x_perkiraan)->translatedFormat('d M Y') : '-' }}</td>
                <td class="text-center nowrap"><span class="badge badge-ok nowrap">{{ $item->status ?? 'Proses' }}</span></td>
                <td>{{ $item->nama_teknisi ?? 'Belum Ditugaskan' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="{{ isset($konsumen) ? 12 : 15 }}" class="text-center" style="padding: 15px;">
                    Tidak ada riwayat servis tercatat pada periode pencarian ini.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- ============================================================ -->
    <!-- TABEL B : CLOSING, PEMBAYARAN, GARANSI & FOLLOW-UP             -->
    <!-- ============================================================ -->
    <p class="section-subtitle">B. Closing, Pembayaran, Garansi & Follow-up</p>
    <table class="data-table">
        <thead>
            <tr>
                @unless(isset($konsumen))
                <th>ID</th>
                @endunless
                <th>No</th>
                @unless(isset($konsumen))
                <th>Nama Konsumen</th>
                @endunless
                <th>No Tiket</th>
                <th>Tgl Closing</th>
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
            </tr>
        </thead>
        <tbody>
            @forelse($riwayatServis as $index => $item)
            @php
                $biaya       = (float) ($item->biaya_jasa ?? 0);
                $sparepart   = (float) ($item->x_sparepart ?? 0);
                $diskon      = (float) ($item->x_diskon ?? 0);
                $totalBayar  = (float) ($item->x_total_bayar ?? 0);
                $statusBayar = $item->x_status_bayar ?? null;
                $isGaransi   = str_contains(strtolower($item->status_garansi ?? ''), 'aktif');
                $hariGaransi = $item->x_garansi_hari !== null ? ((int) preg_replace('/\D/', '', (string) $item->x_garansi_hari)) : null;
                $nextService = $item->tanggal_jadwal_fu ?? $item->tanggal_jatuh_tempo ?? null;
                $fuStatus    = $item->status_follow_up ?? 'Belum Dihubungi';
            @endphp
            <tr>
                @unless(isset($konsumen))
                <td class="text-center fw-bold nowrap">#{{ $item->id_konsumen ?? '-' }}</td>
                @endunless
                <td class="text-center fw-bold nowrap">{{ $index + 1 }}</td>
                @unless(isset($konsumen))
                <td class="fw-bold">{{ $item->nama ?? '-' }}</td>
                @endunless
                <td class="fw-bold nowrap">{{ $item->no_tiket ?? '-' }}</td>
                <td class="text-center nowrap">{{ !empty($item->x_tgl_closing) ? \Carbon\Carbon::parse($item->x_tgl_closing)->translatedFormat('d M Y') : '-' }}{!! $jam($item->x_tgl_closing) !!}</td>
                <td class="text-right nowrap">{{ $biaya > 0 ? 'Rp ' . number_format($biaya, 0, ',', '.') : '-' }}</td>
                <td class="text-right nowrap">{{ $sparepart > 0 ? 'Rp ' . number_format($sparepart, 0, ',', '.') : '-' }}</td>
                <td class="text-right nowrap">{{ $diskon > 0 ? "-\u{00A0}Rp " . number_format($diskon, 0, ',', '.') : '-' }}</td>
                <td class="text-right fw-bold nowrap">{{ $totalBayar > 0 ? 'Rp ' . number_format($totalBayar, 0, ',', '.') : '-' }}</td>
                <td class="text-center nowrap">{{ $item->metode_pembayaran ?? '-' }}</td>
                <td class="text-center nowrap">
                    @if($statusBayar)
                        <span class="badge nowrap {{ strtolower($statusBayar) === 'lunas' ? 'badge-ok' : 'badge-warn' }}">{{ $statusBayar }}</span>
                    @else - @endif
                </td>
                <td class="text-center nowrap">
                    <span class="badge nowrap {{ $isGaransi ? 'badge-ok' : 'badge-no' }}">{{ $isGaransi ? 'Valid' : 'Non-Garansi' }}</span>
                </td>
                <td class="text-center nowrap">
                    @if($hariGaransi)
                        <strong>{{ $hariGaransi }} Hari</strong><br>
                        s.d. {{ !empty($item->x_garansi_sampai) ? \Carbon\Carbon::parse($item->x_garansi_sampai)->format('d/m/Y') : '-' }}
                    @else - @endif
                </td>
                <td class="text-center nowrap">{{ !empty($nextService) ? \Carbon\Carbon::parse($nextService)->translatedFormat('d M Y') : 'Belum Dijadwalkan' }}</td>
                <td class="text-center">
                    <span class="badge {{ $fuStatus === 'Belum Dihubungi' ? 'badge-warn' : 'badge-ok' }}">{{ $fuStatus }}</span>
                </td>
                <td>{{ $item->catatan_hasil ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="{{ isset($konsumen) ? 14 : 16 }}" class="text-center" style="padding: 15px;">
                    Tidak ada data closing pada periode pencarian ini.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Tanda Tangan -->
    <div class="footer-sign">
        <table>
            <tr>
                <td style="width: 70%;"></td>
                <td style="width: 30%;">
                    <p style="margin: 0 0 35px 0;">Madiun, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br><strong>Admin Jawaratech</strong></p>
                    <p style="border-top: 1px solid #000; display: inline-block; width: 150px; padding-top: 2px; font-weight: bold; margin: 0;">( .................................... )</p>
                </td>
            </tr>
        </table>
    </div>

    <script>
        window.onload = function () { window.print(); }
    </script>
</body>
</html>