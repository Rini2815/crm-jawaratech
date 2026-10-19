<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Resmi Rekapitulasi Servis - Jawaratech</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; color: #000000; margin: 0; padding: 20px; background-color: #ffffff; }
        
        /* Kop Surat Resmi dengan Logo di Kiri */
        .kop-surat { border-bottom: 3px double #000000; padding-bottom: 12px; margin-bottom: 15px; width: 100%; }
        .kop-table { width: 100%; border-collapse: collapse; }
        .kop-table td { vertical-align: middle; border: none; }
        .logo-col { width: 15%; text-align: left; }
        .logo-col img { width: 75px; height: auto; }
        .text-col { width: 85%; text-align: center; padding-right: 50px; }
        .text-col h2 { margin: 0; color: #000000; font-size: 16px; text-transform: uppercase; letter-spacing: 1px; font-weight: bold; }
        .text-col h4 { margin: 3px 0; color: #000000; font-size: 11px; font-weight: bold; }
        .text-col p { margin: 1px 0; color: #000000; font-size: 9.5px; }

        /* Deskripsi Perusahaan & Pengantar Laporan */
        .company-desc { background: #ffffff; border: 1px solid #000000; border-left: 4px solid #000000; padding: 10px 12px; margin-bottom: 15px; font-size: 10px; line-height: 1.4; color: #000000; }

        /* Judul Laporan */
        .report-title { text-align: center; margin-bottom: 15px; }
        .report-title h3 { margin: 0; color: #000000; text-transform: uppercase; font-size: 13px; border-bottom: 1px solid #000000; display: inline-block; padding-bottom: 3px; font-weight: bold; }

        /* Identitas Klien / Konsumen */
        .client-info { background: #ffffff; border: 1px solid #000000; padding: 10px 12px; border-radius: 4px; margin-bottom: 15px; }
        .client-info table { width: 100%; border-collapse: collapse; }
        .client-info td { padding: 3px 5px; vertical-align: top; font-size: 10.5px; border: none; color: #000000; }
        .label { font-weight: bold; width: 110px; color: #000000; }

        /* Tabel Riwayat - Super Komprehensif */
        table.data-table { width: 100%; border-collapse: collapse; margin-top: 5px; }
        table.data-table th, table.data-table td { 
            border: 1px solid #000000; 
            padding: 8px 7px; 
            text-align: left; 
            vertical-align: top; /* Diubah ke top agar teks bertumpuk rapi di atas */
            font-size: 9.5px; 
            color: #000000; 
            line-height: 1.5;
        }
        
        /* Header Hitam Pekat */
        table.data-table th { 
            background-color: #000000 !important; 
            color: #ffffff !important; 
            -webkit-print-color-adjust: exact; 
            text-transform: uppercase; 
            font-size: 9.5px; 
            text-align: center; 
            font-weight: bold; 
            vertical-align: middle;
        }
        
        .text-center { text-align: center; }
        .fw-bold { font-weight: bold; }
        
        /* Tanda Tangan */
        .footer-sign { margin-top: 25px; width: 100%; page-break-inside: avoid; }
        .footer-sign table { width: 100%; border: none; }
        .footer-sign td { border: none; text-align: center; font-size: 10.5px; color: #000000; }
    </style>
</head>
<body>

    <!-- KOP SURAT DENGAN LOGO DI KIRI -->
    <div class="kop-surat">
        <table class="kop-table">
            <tr>
                <td class="logo-col">
                    <!-- Ganti path gambar ini sesuai lokasi logo Anda di public folder -->
                    <img src="{{ asset('image/logo.png') }}" alt="Logo Jawaratech">
                </td>
                <td class="text-col">
                    <h2>JAWARATECH</h2>
                    <h4>Penyedia Jasa Servis Elektronik </h4>
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
        <h3>{{ isset($konsumen) ? 'Laporan Riwayat Servis Konsumen' : 'Laporan Rekapitulasi Global Servis' }}</h3>
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

    <!-- Tabel Data / Riwayat Servis Lengkap -->
    <p style="margin-bottom: 5px; font-weight: bold; color: #000000; font-size: 10.5px;">
        Rekam Jejak Transaksi, Pengerjaan Unit, Keluhan & Status Layanan:
    </p>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 4%;">NO</th>
                <th style="width: 22%;">TIKET & INVOICE</th>
                <th style="width: 26%;">DETAIL UNIT & KELUHAN</th>
                <th style="width: 24%;">TEKNISI, STATUS & BIAYA</th>
                <th style="width: 24%;">GARANSI & NEXT SERVIS</th>
            </tr>
        </thead>
        <tbody>
            @forelse($riwayatServis as $index => $item)
            <tr>
                <td class="text-center fw-bold">{{ $index + 1 }}</td>
                
                <!-- Kolom 1: Tiket & Invoice -->
                <td>
                    <span class="fw-bold">Tiket:</span> {{ $item->no_tiket ?? '-' }}<br>
                    <span class="fw-bold">Inv:</span> {{ $item->no_invoice ?? 'Belum Cetak' }}<br>
                    <span class="fw-bold">Tgl Reg:</span> {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d M Y') }}
                    
                    @if(!isset($konsumen))
                        <div style="margin-top: 5px; padding-top: 5px; border-top: 1px dotted #000;">
                            <span class="fw-bold">Klien:</span> {{ $item->nama ?? '-' }}<br>
                            <span style="font-size: 8.5px;">WA: {{ $item->no_whatsapp ?? '-' }}</span>
                        </div>
                    @endif
                </td>
                
                <!-- Kolom 2: Detail Unit & Keluhan -->
                <td>
                    <span class="fw-bold">Unit:</span> {{ $item->jenis_unit ?? 'Unit' }} ({{ $item->merek ?? '-' }})<br>
                    <span class="fw-bold">Model/Tipe:</span> {{ $item->tipe_model ?? '-' }}<br>
                    <div style="margin-top: 4px;">
                        <span class="fw-bold">Keluhan:</span><br>
                        <span style="font-style: italic;">"{{ $item->keluhan ?? '-' }}"</span>
                    </div>
                </td>
                
                <!-- Kolom 3: Teknisi, Status & Biaya -->
                <td>
                    <span class="fw-bold">Status:</span> {{ $item->status ?? 'Proses' }}<br>
                    <span class="fw-bold">Teknisi:</span> {{ $item->nama_teknisi ?? 'Belum Ditugaskan' }}<br>
                    
                    <div style="margin-top: 5px; padding-top: 5px; border-top: 1px dotted #000;">
                        <span class="fw-bold">Biaya:</span> 
                        {{ !empty($item->total_biaya) ? 'Rp ' . number_format($item->total_biaya, 0, ',', '.') : '-' }}<br>
                        <span class="fw-bold">Metode:</span> {{ $item->metode_pembayaran ?? '-' }}
                    </div>
                </td>
                
                <!-- Kolom 4: Garansi & After-Sales -->
                <td>
                    <span class="fw-bold">Garansi:</span> 
                    {{ str_contains(strtolower($item->status_garansi ?? ''), 'aktif') ? 'Valid' : 'Non-Garansi' }}<br>
                    
                    <div style="margin-top: 5px; padding-top: 5px; border-top: 1px dotted #000;">
                        <span class="fw-bold">Next Servis:</span><br>
                        {{ !empty($item->tanggal_jatuh_tempo) ? \Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->translatedFormat('d M Y') : 'Belum Dijadwalkan' }}<br>
                        <span class="fw-bold">Follow-up:</span> <br>
                        {{ $item->status_follow_up ?? 'Belum Dihubungi' }}
                    </div>
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

    <!-- Tanda Tangan / Pengesahan -->
    <div class="footer-sign">
        <table>
            <tr>
                <td style="width: 65%;"></td>
                <td style="width: 35%; text-align: center;">
                    <p style="margin-bottom: 45px;">Madiun, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br><strong>Admin Jawaratech</strong></p>
                    <p style="border-top: 1px solid #000000; display: inline-block; width: 150px; padding-top: 3px; font-weight: bold;">( .................................... )</p>
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