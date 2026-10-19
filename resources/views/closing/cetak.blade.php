@php
    $lunas     = $s->status_pembayaran === 'Lunas';
    $konsumen  = $s->unit->konsumen ?? null;
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice {{ $s->no_invoice }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root { --navy: #1e293b; --biru: #1e3a8a; --merah: #b91c1c; --abu: #64748b; --garis: #cbd5e1; }
        * { box-sizing: border-box; }
        html, body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        body { margin: 0; background: #e2e8f0; font-family: 'Inter', 'Segoe UI', Arial, sans-serif; color: #0f172a; font-size: 13px; line-height: 1.5; }

        /* Toolbar (tidak ikut tercetak) */
        .toolbar { width: 210mm; max-width: 100%; margin: 16px auto 0; padding: 0 4px; display: flex; gap: 8px; align-items: center; flex-wrap: wrap; }
        .btn { display: inline-block; padding: 8px 16px; border-radius: 6px; border: 1px solid var(--garis); background: #fff; color: #0f172a; font-weight: 600; font-size: 13px; text-decoration: none; cursor: pointer; font-family: inherit; }
        .btn-primary { background: #16a34a; border-color: #16a34a; color: #fff; }
        .info { flex: 1; color: #166534; font-weight: 600; }

        /* Lembar nota */
        .nota { position: relative; width: 210mm; max-width: 100%; margin: 12px auto 24px; background: #fff; padding: 12mm 14mm 10mm; border: 1px solid var(--garis); overflow: hidden; }
        .isi { position: relative; z-index: 1; }

        /* Stempel LUNAS / BELUM LUNAS */
        .stempel { position: absolute; top: 52%; left: 50%; transform: translate(-50%, -50%) rotate(-24deg); z-index: 0; pointer-events: none; text-align: center; white-space: nowrap; padding: 6px 34px 8px; border: 8px solid; border-radius: 18px; font-weight: 800; line-height: 1.1; opacity: 0.17; }
        .stempel small { display: block; margin-top: 2px; font-size: 18px; font-weight: 700; letter-spacing: 1px; }
        .stempel.lunas { color: #16a34a; border-color: #16a34a; font-size: 104px; letter-spacing: 10px; }
        .stempel.belum { color: #dc2626; border-color: #dc2626; font-size: 66px; letter-spacing: 4px; }

        /* Kop surat */
        .head { display: flex; justify-content: space-between; align-items: center; gap: 16px; padding-bottom: 12px; }
        .brand { display: flex; align-items: center; gap: 14px; min-width: 0; }
        .brand .logo { width: 96px; height: auto; display: block; flex-shrink: 0; }
        .brand-teks { display: none; font-size: 22px; font-weight: 800; letter-spacing: 1px; color: var(--navy); }
        .alamat { font-size: 10.5px; line-height: 1.6; color: #334155; }
        .alamat strong { color: var(--navy); font-weight: 700; }
        .judul { text-align: right; flex-shrink: 0; }
        .judul h1 { margin: 0; font-size: 28px; font-weight: 800; letter-spacing: 3px; color: var(--navy); line-height: 1.1; }
        .judul .no { margin-top: 4px; font-size: 15px; font-weight: 800; color: #1d4ed8; }
        .judul .tgl { font-size: 12px; color: #334155; line-height: 1.6; }
        .bar { height: 5px; margin-bottom: 14px; background: linear-gradient(90deg, var(--biru) 0%, var(--biru) 50%, var(--merah) 50%, var(--merah) 100%); border-radius: 3px; }

        /* Kotak informasi */
        .grid { display: flex; gap: 14px; margin-bottom: 12px; }
        .grid > div { flex: 1; min-width: 0; }
        .label { margin-bottom: 4px; font-size: 10.5px; font-weight: 800; letter-spacing: 0.8px; text-transform: uppercase; color: var(--biru); }
        .box { border: 1px solid var(--garis); border-radius: 6px; padding: 8px 12px; line-height: 1.6; }
        .box strong { font-weight: 700; }
        .box .sub { color: #475569; }

        /* Tabel biaya */
        table { width: 100%; border-collapse: collapse; margin: 4px 0 12px; }
        th { padding: 8px 12px; background: var(--navy); color: #fff; font-size: 11px; font-weight: 700; letter-spacing: 0.6px; text-transform: uppercase; text-align: left; }
        td { padding: 7px 12px; border-bottom: 1px solid #e2e8f0; text-align: left; }
        td.num, th.num { text-align: right; font-variant-numeric: tabular-nums; }
        tr.total td { padding: 10px 12px; border-top: 2px solid var(--navy); border-bottom: 2px solid var(--navy); font-size: 15px; font-weight: 800; }
        tr.sisa td { font-weight: 800; color: var(--merah); }

        /* Status pembayaran */
        .status { display: inline-block; padding: 2px 10px; border-radius: 4px; font-size: 11.5px; font-weight: 800; letter-spacing: 0.4px; }
        .Lunas { background: #dcfce7; color: #15803d; }
        .DP { background: #fef3c7; color: #92400e; }
        .Belum { background: #fee2e2; color: #b91c1c; }

        /* Tanda tangan */
        .ttd { display: flex; justify-content: space-between; margin-top: 18px; text-align: center; }
        .ttd > div { width: 38%; font-weight: 600; }
        .ttd .garis { width: 85%; margin: 50px auto 0; padding-top: 4px; border-top: 1px solid #0f172a; font-weight: 700; }

        /* Kaki nota */
        .foot { margin-top: 16px; padding-top: 10px; border-top: 1px solid var(--garis); text-align: center; color: #475569; font-size: 11px; line-height: 1.6; }
        .foot strong { color: var(--navy); }

        @page { size: A4; margin: 8mm; }
        @media print {
            body { background: #fff; }
            .no-print { display: none !important; }
            .nota { width: auto; margin: 0; padding: 4mm 5mm; border: none; }
            .grid, table, .ttd { page-break-inside: avoid; }
        }
    </style>
</head>
<body>

<div class="toolbar no-print">
    <a href="{{ route('closing.index') }}" class="btn">&larr; Kembali ke Daftar Closing</a>
    <button type="button" class="btn btn-primary" onclick="window.print()">Cetak Nota</button>
    @if(session('success'))
        <span class="info">{{ session('success') }}</span>
    @endif
</div>

<div class="nota">

    {{-- Stempel samar di tengah nota --}}
    @if($lunas)
        <div class="stempel lunas">LUNAS
            @if($s->tanggal_pelunasan)
                <small>{{ $s->tanggal_pelunasan->translatedFormat('j F Y') }}</small>
            @endif
        </div>
    @else
        <div class="stempel belum">BELUM LUNAS
            <small>Sisa Rp {{ number_format($s->sisa_bayar, 0, ',', '.') }}</small>
        </div>
    @endif

    <div class="isi">

        {{-- KOP: logo, alamat, dan identitas invoice --}}
        <div class="head">
            <div class="brand">
                <img src="{{ asset('image/logo.png') }}" alt="Jawaratech" class="logo"
                     onerror="this.style.display='none'; document.getElementById('brandTeks').style.display='block';">
                <div id="brandTeks" class="brand-teks">JAWARATECH</div>
                <div class="alamat">
                    <strong>Pusat Madiun/Caruban:</strong> Jl. Ontorejo, RT.3/RW.2, Wonoasri, Kab. Madiun<br>
                    <strong>Magetan:</strong> Dsn. Lemi, Ds. Jajar, Kartoharjo, Kab. Magetan<br>
                    <strong>WhatsApp:</strong> +62 822-2808-4708<br>
                    <strong>Instagram/TikTok:</strong> @jawaratech
                </div>
            </div>
            <div class="judul">
                <h1>INVOICE</h1>
                <div class="no">{{ $s->no_invoice }}</div>
                <div class="tgl">
                    Tanggal: {{ $s->tanggal_closing->translatedFormat('j F Y') }}<br>
                    No. Tiket: {{ $s->no_tiket }}
                </div>
            </div>
        </div>
        <div class="bar"></div>

        {{-- PELANGGAN & UNIT --}}
        <div class="grid">
            <div>
                <div class="label">Pelanggan</div>
                <div class="box">
                    <strong>{{ $konsumen->nama ?? '-' }}</strong><br>
                    <span class="sub">WhatsApp: {{ $konsumen->no_whatsapp ?? '-' }}</span><br>
                    <span class="sub">{{ $konsumen->alamat ?? '-' }}</span>
                </div>
            </div>
            <div>
                <div class="label">Unit Servis</div>
                <div class="box">
                    <strong>{{ $s->label_unit }}</strong><br>
                    <span class="sub">Tanggal masuk: {{ $s->tanggal_masuk->translatedFormat('j F Y') }}</span><br>
                    <span class="sub">Teknisi: {{ $s->teknisi->nama_teknisi ?? '-' }}</span>
                </div>
            </div>
        </div>

        {{-- KELUHAN & RINCIAN --}}
        <div class="grid">
            <div>
                <div class="label">Keluhan</div>
                <div class="box">{!! nl2br(e($s->keluhan)) !!}</div>
            </div>
            <div>
                <div class="label">Rincian Tindakan / Sparepart</div>
                <div class="box">{!! nl2br(e($s->catatan)) !!}</div>
            </div>
        </div>

        {{-- RINCIAN BIAYA --}}
        <table>
            <thead>
                <tr><th>Keterangan Biaya</th><th class="num">Jumlah</th></tr>
            </thead>
            <tbody>
                <tr><td>Biaya Jasa Servis</td><td class="num">Rp {{ number_format($s->biaya_jasa, 0, ',', '.') }}</td></tr>
                <tr><td>Biaya Sparepart</td><td class="num">Rp {{ number_format($s->biaya_sparepart, 0, ',', '.') }}</td></tr>
                @if($s->diskon > 0)
                    <tr><td>Potongan / Diskon</td><td class="num">- Rp {{ number_format($s->diskon, 0, ',', '.') }}</td></tr>
                @endif
                <tr class="total"><td>TOTAL BAYAR</td><td class="num">Rp {{ number_format($s->total_bayar, 0, ',', '.') }}</td></tr>
                @if($s->jumlah_dp > 0)
                    <tr><td>DP dibayar{{ $s->tanggal_dp ? ' (' . $s->tanggal_dp->translatedFormat('j M Y') . ')' : '' }}</td><td class="num">Rp {{ number_format($s->jumlah_dp, 0, ',', '.') }}</td></tr>
                @endif
                @if($lunas && $s->tanggal_pelunasan)
                    <tr><td>Pelunasan ({{ $s->tanggal_pelunasan->translatedFormat('j M Y') }})</td><td class="num">Rp {{ number_format($s->jumlah_pelunasan, 0, ',', '.') }}</td></tr>
                @endif
                @if($s->sisa_bayar > 0)
                    <tr class="sisa"><td>Sisa yang harus dibayar</td><td class="num">Rp {{ number_format($s->sisa_bayar, 0, ',', '.') }}</td></tr>
                @endif
            </tbody>
        </table>

        {{-- PEMBAYARAN & GARANSI --}}
        <div class="grid">
            <div>
                <div class="label">Pembayaran</div>
                <div class="box">
                    Status:
                    <span class="status {{ $s->status_pembayaran === 'Belum Lunas' ? 'Belum' : $s->status_pembayaran }}">{{ strtoupper($s->status_pembayaran) }}</span><br>
                    Metode: <strong>{{ $s->metode_pembayaran ?? '-' }}</strong>
                </div>
            </div>
            <div>
                <div class="label">Garansi Servis</div>
                <div class="box">
                    <strong>{{ $s->masa_garansi_hari > 0 ? $s->label_garansi : 'Tanpa Garansi' }}</strong><br>
                    @if($s->garansi_berakhir)
                        <span class="sub">Berlaku sampai {{ $s->garansi_berakhir->translatedFormat('j F Y') }}</span>
                    @else
                        <span class="sub">-</span>
                    @endif
                </div>
            </div>
        </div>

        {{-- TANDA TANGAN --}}
        <div class="ttd">
            <div>Teknisi<div class="garis">{{ $s->teknisi->nama_teknisi ?? '-' }}</div></div>
            <div>Pelanggan<div class="garis">{{ $konsumen->nama ?? '-' }}</div></div>
        </div>

        {{-- KAKI NOTA --}}
        <div class="foot">
            Terima kasih telah mempercayakan servis Anda kepada <strong>Jawaratech</strong>.<br>
            Nota ini merupakan bukti pembayaran yang sah. Harap disimpan untuk keperluan garansi servis.<br>
            WhatsApp +62 822-2808-4708 &nbsp;|&nbsp; Instagram/TikTok @jawaratech
        </div>

    </div>
</div>

@if($auto)
<script>
    window.addEventListener('load', function () { window.print(); });
</script>
@endif
</body>
</html>