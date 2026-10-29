<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tanda Terima {{ $s->no_tiket }}</title>
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

        /* Lembar tanda terima */
        .nota { position: relative; width: 210mm; max-width: 100%; margin: 12px auto 24px; background: #fff; padding: 12mm 14mm 10mm; border: 1px solid var(--garis); overflow: hidden; }
        .isi { position: relative; z-index: 1; }

        /* Kop surat */
        .head { display: flex; justify-content: space-between; align-items: center; gap: 16px; padding-bottom: 12px; }
        .brand { display: flex; align-items: center; gap: 14px; min-width: 0; }
        .brand .logo { width: 96px; height: auto; display: block; flex-shrink: 0; }
        .brand-teks { display: none; font-size: 22px; font-weight: 800; letter-spacing: 1px; color: var(--navy); }
        .alamat { font-size: 10.5px; line-height: 1.6; color: #334155; }
        .alamat strong { color: var(--navy); font-weight: 700; }
        .judul { text-align: right; flex-shrink: 0; }
        .judul h1 { margin: 0; font-size: 26px; font-weight: 800; letter-spacing: 3px; color: var(--navy); line-height: 1.1; }
        .judul .sub-judul { margin-top: 2px; font-size: 11px; font-weight: 600; color: var(--abu); letter-spacing: 0.3px; }
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

        /* Status */
        .status { display: inline-block; padding: 2px 10px; border-radius: 4px; font-size: 11.5px; font-weight: 800; letter-spacing: 0.4px; background: #e0f2fe; color: #0369a1; }

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
            .grid, .ttd { page-break-inside: avoid; }
        }
    </style>
</head>
<body>

<div class="toolbar no-print">
    <a href="{{ route('registrasi-servis.index') }}" class="btn">&larr; Kembali ke Registrasi Servis</a>
    <button type="button" class="btn btn-primary" onclick="window.print()">Cetak Tanda Terima</button>
</div>

<div class="nota">
    <div class="isi">

        {{-- KOP: logo, alamat, dan identitas tanda terima --}}
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
                <h1>TANDA TERIMA</h1>
                <div class="sub-judul">Unit Servis (SPK)</div>
                <div class="no">{{ $s->no_tiket }}</div>
                <div class="tgl">
                    Tanggal masuk: {{ \Carbon\Carbon::parse($s->tanggal_masuk)->translatedFormat('j F Y') }}<br>
                    Perkiraan selesai: {{ $s->tanggal_estimasi_selesai ? \Carbon\Carbon::parse($s->tanggal_estimasi_selesai)->translatedFormat('j F Y') : '-' }}
                </div>
            </div>
        </div>
        <div class="bar"></div>

        {{-- PELANGGAN & UNIT --}}
        <div class="grid">
            <div>
                <div class="label">Pelanggan</div>
                <div class="box">
                    <strong>{{ $s->unit->konsumen->nama ?? '-' }}</strong><br>
                    <span class="sub">WhatsApp: {{ $s->unit->konsumen->no_whatsapp ?? '-' }}</span><br>
                    <span class="sub">{{ $s->unit->konsumen->alamat ?? '-' }}</span>
                </div>
            </div>
            <div>
                <div class="label">Unit Servis</div>
                <div class="box">
                    <strong>{{ $s->label_unit }}</strong><br>
                    <span class="sub">Teknisi penanggung jawab: {{ $s->teknisi->nama_teknisi ?? '-' }}</span><br>
                    Status saat ini: <span class="status">{{ strtoupper($s->status) }}</span>
                </div>
            </div>
        </div>

        {{-- KELUHAN --}}
        <div style="margin-bottom: 12px;">
            <div class="label">Keluhan Utama</div>
            <div class="box">{!! nl2br(e($s->keluhan)) !!}</div>
        </div>

        {{-- TANDA TANGAN --}}
        <div class="ttd">
            <div>Teknisi<div class="garis">{{ $s->teknisi->nama_teknisi ?? '-' }}</div></div>
            <div>Pelanggan<div class="garis">{{ $s->unit->konsumen->nama ?? '-' }}</div></div>
        </div>

        {{-- KAKI NOTA --}}
        <div class="foot">
            Simpan tanda terima ini sebagai bukti penerimaan unit. Terima kasih telah mempercayakan servis Anda kepada <strong>Jawaratech</strong>.<br>
            WhatsApp +62 822-2808-4708 &nbsp;|&nbsp; Instagram/TikTok @jawaratech
        </div>

    </div>
</div>

</body>
</html>