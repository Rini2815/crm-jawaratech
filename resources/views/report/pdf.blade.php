<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Resmi Rekapitulasi Servis & Follow-up - Jawaratech</title>
    <style>
        /* Pengaturan umum halaman & cetak agar pas di kertas A4 */
        @page {
            size: A4;
            margin: 8mm 8mm 8mm 8mm;
        }
        body { 
            font-family: Arial, sans-serif; 
            font-size: 10px; 
            color: #000000; 
            margin: 0; 
            padding: 10px; 
            background-color: #ffffff; 
            -webkit-print-color-adjust: exact;
        }
        
        /* Kop Surat Resmi dengan Logo di Kiri */
        .kop-surat { 
            border-bottom: 3px double #000000; 
            padding-bottom: 8px; 
            margin-bottom: 10px; 
            width: 100%; 
        }
        .kop-table { width: 100%; border-collapse: collapse; }
        .kop-table td { vertical-align: middle; border: none; }
        .logo-col { width: 15%; text-align: left; }
        .logo-col img { width: 65px; height: auto; }
        .text-col { width: 85%; text-align: center; padding-right: 40px; }
        .text-col h2 { margin: 0; color: #000000; font-size: 15px; text-transform: uppercase; letter-spacing: 1px; font-weight: bold; }
        .text-col h4 { margin: 2px 0; color: #000000; font-size: 10px; font-weight: bold; }
        .text-col p { margin: 1px 0; color: #000000; font-size: 9px; }

        /* Deskripsi Perusahaan & Pengantar Laporan */
        .company-desc { 
            background: #ffffff; 
            border: 1px solid #000000; 
            border-left: 4px solid #000000; 
            padding: 8px 10px; 
            margin-bottom: 10px; 
            font-size: 9.5px; 
            line-height: 1.3; 
        }

        /* Judul Laporan */
        .report-title { text-align: center; margin-bottom: 10px; }
        .report-title h3 { 
            margin: 0; 
            color: #000000; 
            text-transform: uppercase; 
            font-size: 12px; 
            border-bottom: 1px solid #000000; 
            display: inline-block; 
            padding-bottom: 2px; 
            font-weight: bold; 
        }

        /* Identitas Klien / Konsumen */
        .client-info { 
            background: #ffffff; 
            border: 1px solid #000000; 
            padding: 8px 10px; 
            border-radius: 4px; 
            margin-bottom: 10px; 
        }
        .client-info table { width: 100%; border-collapse: collapse; }
        .client-info td { padding: 3px 5px; vertical-align: top; font-size: 10px; border: none; color: #000000; }
        .label { font-weight: bold; width: 105px; color: #000000; }

        /* Subtitle Tabel */
        p.section-subtitle { margin: 12px 0 5px 0; font-weight: bold; font-size: 10px; color: #000000; }

        /* Tabel Data / Riwayat Servis */
        table.data-table { width: 100%; border-collapse: collapse; margin-top: 2px; }
        table.data-table th, table.data-table td { 
            border: 1px solid #000000; 
            padding: 6px; 
            text-align: left; 
            vertical-align: top; 
            font-size: 9px; 
            color: #000000; 
            line-height: 1.4;
        }
        
        /* Header Hitam Pekat */
        table.data-table th { 
            background-color: #000000 !important; 
            color: #ffffff !important; 
            -webkit-print-color-adjust: exact; 
            text-transform: uppercase; 
            font-size: 9px; 
            text-align: center; 
            font-weight: bold; 
            vertical-align: middle;
            padding: 7px 4px;
        }
        
        .text-center { text-align: center; }
        .fw-bold { font-weight: bold; }

        /* Styling Kotak Kecil / Badge */
        .mini-box { width: 100%; border-collapse: collapse; margin-bottom: 3px; }
        .mini-box td { border: 1px solid #b0c4de; padding: 3px 5px; font-size: 8.5px; background: #fdfdfd; }
        .mini-box td.sub-label { width: 38%; font-weight: bold; color: #333; background: #f0f4f8; border-right: 1px solid #b0c4de; }
        
        /* Box Keluhan Khusus */
        .keluhan-box { border: 1px solid #8b0000; margin-top: 4px; border-radius: 2px; overflow: hidden; }
        .keluhan-header { background-color: #8b0000 !important; color: #ffffff; text-align: center; font-weight: bold; font-size: 8.5px; padding: 2px; -webkit-print-color-adjust: exact; text-transform: uppercase; }
        .keluhan-content { padding: 4px; font-style: italic; font-size: 8.5px; background-color: #fffdfd; }

        /* Badge Status & Garansi */
        .badge-status { background-color: #d4edda !important; color: #155724; padding: 2px 6px; border-radius: 3px; font-weight: bold; border: 1px solid #c3e6cb; -webkit-print-color-adjust: exact; display: inline-block; }
        .badge-garansi { background-color: #d4edda !important; color: #155724; padding: 2px 6px; border-radius: 3px; font-weight: bold; border: 1px solid #c3e6cb; -webkit-print-color-adjust: exact; display: inline-block; }

        /* Tanda Tangan */
        .footer-sign { margin-top: 20px; width: 100%; page-break-inside: avoid; }
        .footer-sign table { width: 100%; border: none; }
        .footer-sign td { border: none; text-align: center; font-size: 10px; color: #000000; }
    </style>
</head>
<body>

    <!-- KOP SURAT DENGAN LOGO DI KIRI -->
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

    <!-- DESKRIPSI PENGANTAR -->
    <div class="company-desc">
        <strong>Tentang Jawaratech:</strong> Jawaratech (CV Jawara Tiga Pendiri) adalah pusat layanan servis elektronik panggilan dan pemeliharaan perangkat rumah tangga terkemuka di wilayah Karesidenan Madiun. Laporan resmi ini merangkum rekam jejak riwayat servis, pemeliharaan berkala, serta status pengerjaan unit konsumen secara transparan dan akurat.
    </div>

    <!-- Judul Dokumen -->
    <div class="report-title">
        <h3>{{ isset($konsumen) ? 'Laporan Riwayat Servis & Follow-up Konsumen' : 'Laporan Rekapitulasi Global Servis & Follow-up' }}</h3>
    </div>

    <!-- Identitas Konsumen -->
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

    <!-- TABEL 1: RIWAYAT SERVIS UTAMA -->
    <p class="section-subtitle">1. Rekam jejak transaksi, pengerjaan unit, keluhan & status layanan:</p>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 4%;">NO</th>
                <th style="width: 22%;">TIKET & INVOICE</th>
                <th style="width: 28%;">DETAIL UNIT & KELUHAN</th>
                <th style="width: 23%;">TEKNISI, STATUS & BIAYA</th>
                <th style="width: 23%;">GARANSI & NEXT SERVIS</th>
            </tr>
        </thead>
        <tbody>
            @forelse($riwayatServis as $index => $item)
            <tr>
                <td class="text-center fw-bold" style="vertical-align: middle; font-size: 12px;">{{ $index + 1 }}</td>
                
                <!-- Kolom 1: Tiket & Invoice -->
                <td>
                    <table class="mini-box">
                        <tr>
                            <td class="sub-label">Tiket</td>
                            <td><strong>{{ $item->no_tiket ?? '-' }}</strong></td>
                        </tr>
                        <tr>
                            <td class="sub-label">Inv</td>
                            <td>{{ $item->no_invoice ?? 'Belum Cetak' }}</td>
                        </tr>
                        <tr>
                            <td class="sub-label">Tgl Reg</td>
                            <td>{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d M Y') }}</td>
                        </tr>
                    </table>
                    @if(!isset($konsumen) && !empty($item->nama))
                        <div style="margin-top: 4px; padding-top: 3px; border-top: 1px dotted #000; font-size: 8.5px;">
                            <span class="fw-bold">Klien:</span> {{ $item->nama }}<br>
                            <span>WA: {{ $item->no_whatsapp ?? '-' }}</span>
                        </div>
                    @endif
                </td>
                
                <!-- Kolom 2: Detail Unit & Keluhan -->
                <td>
                    <table class="mini-box">
                        <tr>
                            <td class="sub-label">Unit</td>
                            <td><strong>{{ $item->jenis_unit ?? 'Unit' }}</strong> ({{ $item->merek ?? '-' }})</td>
                        </tr>
                        <tr>
                            <td class="sub-label">Model</td>
                            <td>{{ $item->tipe_model ?? '-' }}</td>
                        </tr>
                    </table>
                    <div class="keluhan-box">
                        <div class="keluhan-header">KELUHAN</div>
                        <div class="keluhan-content">"{{ $item->keluhan ?? '-' }}"</div>
                    </div>
                </td>
                
                <!-- Kolom 3: Teknisi, Status & Biaya -->
                <td>
                    <table class="mini-box">
                        <tr>
                            <td class="sub-label">Status</td>
                            <td><span class="badge-status">{{ $item->status ?? 'Proses' }}</span></td>
                        </tr>
                        <tr>
                            <td class="sub-label">Teknisi</td>
                            <td>{{ $item->nama_teknisi ?? ($item->id_teknisi ?? 'Belum Ditugaskan') }}</td>
                        </tr>
                        <tr>
                            <td class="sub-label">Biaya</td>
                            <td>
                                @php
                                    $biaya = $item->biaya_jasa ?? ($item->total_biaya ?? 0);
                                @endphp
                                {{ $biaya > 0 ? 'Rp ' . number_format($biaya, 0, ',', '.') : '-' }}
                            </td>
                        </tr>
                        <tr>
                            <td class="sub-label">Metode</td>
                            <td>{{ $item->metode_pembayaran ?? '-' }}</td>
                        </tr>
                    </table>
                </td>
                
                <!-- Kolom 4: Garansi & Next Servis -->
                <td>
                    <table class="mini-box">
                        <tr>
                            <td class="sub-label">Garansi</td>
                            <td>
                                @php 
                                    $isGaransi = str_contains(strtolower($item->status_garansi ?? ''), 'aktif'); 
                                @endphp
                                <span class="{{ $isGaransi ? 'badge-garansi' : '' }}">
                                    {{ $isGaransi ? 'Valid' : 'Non-Garansi' }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="sub-label">Next Servis</td>
                            <td>{{ !empty($item->tanggal_jatuh_tempo) ? \Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->translatedFormat('d M Y') : 'Belum Dijadwalkan' }}</td>
                        </tr>
                        <tr>
                            <td class="sub-label">Follow-up</td>
                            <td>{{ $item->status_follow_up ?? 'Belum Dihubungi' }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center" style="padding: 15px; color: #000000;">
                    Tidak ada riwayat servis tercatat pada periode pencarian ini.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- TABEL 2: PENGINGAT PERAWATAN & FOLLOW-UP WHATSAPP -->
    <p class="section-subtitle">2. Agenda Pengingat Perawatan Berkala & Follow-up WhatsApp Konsumen:</p>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%;">NO</th>
                <th style="width: 25%;">KONSUMEN & WHATSAPP</th>
                <th style="width: 30%;">UNIT & KETERANGAN</th>
                <th style="width: 20%;">STATUS & JADWAL</th>
                <th style="width: 20%;">CATATAN / HASIL</th>
            </tr>
        </thead>
        <tbody>
            @forelse($followUpList ?? [] as $idx => $fup)
            <tr>
                <td class="text-center fw-bold" style="vertical-align: middle;">{{ $idx + 1 }}</td>
                <td>
                    <strong>{{ $fup->nama ?? '-' }}</strong><br>
                    <span style="font-size: 8.5px;">WA: {{ $fup->no_whatsapp ?? '-' }}</span>
                </td>
                <td>
                    <strong>{{ $fup->jenis_unit ?? 'Perangkat' }}</strong> ({{ $fup->merek ?? '-' }})<br>
                    <span style="font-size: 8px; color: #333;">Kategori: {{ $fup->kategori ?? 'Perawatan Berkala' }}</span>
                </td>
                <td>
                    <span class="badge-status">{{ $fup->status ?? 'Belum Dihubungi' }}</span><br>
                    <span style="font-size: 8px;">Jadwal: {{ !empty($fup->tanggal_jadwal) ? \Carbon\Carbon::parse($fup->tanggal_jadwal)->translatedFormat('d M Y') : '-' }}</span>
                </td>
                <td>
                    {{ $fup->catatan_hasil ?? '-' }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center" style="padding: 12px; color: #000000;">
                    Tidak ada antrean pengingat perawatan atau follow-up saat ini.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Tanda Tangan / Pengesahan -->
    <div class="footer-sign">
        <table>
            <tr>
                <td style="width: 65%;"></td>
                <td style="width: 35%; text-align: center;">
                    <p style="margin-bottom: 35px;">Madiun, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br><strong>Admin Jawaratech</strong></p>
                    <p style="border-top: 1px solid #000000; display: inline-block; width: 140px; padding-top: 2px; font-weight: bold;">( .................................... )</p>
                </td>
            </tr>
        </table>
    </div>

    <!-- Script Print Otomatis -->
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>