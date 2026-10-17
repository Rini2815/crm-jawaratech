<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tanda Terima {{ $s->no_tiket }}</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; background: #e2e8f0; font-family: 'Segoe UI', Arial, sans-serif; color: #0f172a; font-size: 13px; }
        .toolbar { max-width: 760px; margin: 16px auto 0; padding: 0 8px; display: flex; gap: 8px; align-items: center; flex-wrap: wrap; }
        .btn { display: inline-block; padding: 8px 16px; border-radius: 6px; border: 1px solid #cbd5e1; background: #fff; color: #0f172a; font-weight: 600; font-size: 13px; text-decoration: none; cursor: pointer; }
        .btn-primary { background: #16a34a; border-color: #16a34a; color: #fff; }
        .nota { max-width: 760px; margin: 12px auto 24px; background: #fff; padding: 32px 36px; border: 1px solid #cbd5e1; }
        .head { display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 3px solid #1e293b; padding-bottom: 12px; margin-bottom: 18px; }
        .brand { font-size: 24px; font-weight: 800; letter-spacing: 1px; color: #1e293b; }
        .brand small { display: block; font-size: 12px; font-weight: 500; letter-spacing: 0; color: #64748b; }
        .meta { text-align: right; line-height: 1.6; }
        .meta strong { font-size: 15px; color: #2563eb; }
        .grid { display: flex; gap: 24px; margin-bottom: 18px; }
        .grid > div { flex: 1; }
        .label { font-size: 11px; text-transform: uppercase; letter-spacing: 0.6px; color: #64748b; font-weight: 700; margin-bottom: 4px; }
        .box { border: 1px solid #e2e8f0; border-radius: 6px; padding: 10px 12px; line-height: 1.6; }
        .centang { display: flex; flex-wrap: wrap; gap: 6px 24px; }
        .centang span { white-space: nowrap; }
        .status { display: inline-block; padding: 3px 10px; border-radius: 4px; font-weight: 700; font-size: 12px; background: #e0f2fe; color: #0369a1; }
        .ttd { display: flex; justify-content: space-between; margin-top: 36px; text-align: center; }
        .ttd > div { width: 40%; }
        .ttd .garis { width: 80%; margin: 56px auto 0; border-top: 1px solid #0f172a; padding-top: 4px; font-weight: 600; }
        .foot { margin-top: 24px; text-align: center; color: #64748b; font-size: 12px; }
        @media print {
            body { background: #fff; }
            .no-print { display: none !important; }
            .nota { margin: 0; border: none; max-width: 100%; padding: 0; }
        }
    </style>
</head>
<body>

@php
    $daftarKelengkapan = ['Unit Utama', 'Remote AC/TV', 'Kabel Power', 'Adaptor'];
    $dibawa = array_filter(array_map('trim', explode(',', (string) $s->kelengkapan)));
@endphp

<div class="toolbar no-print">
    <a href="{{ route('registrasi-servis.index') }}" class="btn">&larr; Kembali ke Registrasi Servis</a>
    <button type="button" class="btn btn-primary" onclick="window.print()">Cetak Tanda Terima</button>
</div>

<div class="nota">
    <div class="head">
        <div class="brand">JAWARATECH <small>Tanda Terima Unit Servis (SPK)</small></div>
        <div class="meta">
            <strong>{{ $s->no_tiket }}</strong><br>
            Tanggal masuk: {{ \Carbon\Carbon::parse($s->tanggal_masuk)->translatedFormat('j F Y') }}<br>
            Perkiraan selesai: {{ $s->tanggal_estimasi_selesai ? \Carbon\Carbon::parse($s->tanggal_estimasi_selesai)->translatedFormat('j F Y') : '-' }}
        </div>
    </div>

    <div class="grid">
        <div>
            <div class="label">Pelanggan</div>
            <div class="box">
                <strong>{{ $s->unit->konsumen->nama ?? '-' }}</strong><br>
                WhatsApp: {{ $s->unit->konsumen->no_whatsapp ?? '-' }}<br>
                {{ $s->unit->konsumen->alamat ?? '-' }}
            </div>
        </div>
        <div>
            <div class="label">Unit Servis</div>
            <div class="box">
                <strong>{{ $s->label_unit }}</strong><br>
                Teknisi penanggung jawab: {{ $s->teknisi->nama_teknisi ?? '-' }}<br>
                Status saat ini: <span class="status">{{ strtoupper($s->status) }}</span>
            </div>
        </div>
    </div>

    <div class="label">Keluhan Utama</div>
    <div class="box" style="margin-bottom: 14px;">{!! nl2br(e($s->keluhan)) !!}</div>

    <div class="label">Kelengkapan Unit yang Diterima</div>
    <div class="box" style="margin-bottom: 18px;">
        <div class="centang">
            @foreach($daftarKelengkapan as $item)
                <span>{{ in_array($item, $dibawa, true) ? '☑' : '☐' }} {{ $item }}</span>
            @endforeach
        </div>
    </div>

    <div class="ttd">
        <div>Teknisi<div class="garis">{{ $s->teknisi->nama_teknisi ?? '-' }}</div></div>
        <div>Pelanggan<div class="garis">{{ $s->unit->konsumen->nama ?? '-' }}</div></div>
    </div>

    <div class="foot">Simpan tanda terima ini sebagai bukti penerimaan unit. Terima kasih telah mempercayakan servis Anda kepada Jawaratech.</div>
</div>

</body>
</html>