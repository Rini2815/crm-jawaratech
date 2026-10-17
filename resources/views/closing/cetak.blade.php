<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice {{ $s->no_invoice }}</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; background: #e2e8f0; font-family: 'Segoe UI', Arial, sans-serif; color: #0f172a; font-size: 13px; }
        .toolbar { max-width: 760px; margin: 16px auto 0; padding: 0 8px; display: flex; gap: 8px; align-items: center; flex-wrap: wrap; }
        .btn { display: inline-block; padding: 8px 16px; border-radius: 6px; border: 1px solid #cbd5e1; background: #fff; color: #0f172a; font-weight: 600; font-size: 13px; text-decoration: none; cursor: pointer; }
        .btn-primary { background: #16a34a; border-color: #16a34a; color: #fff; }
        .info { flex: 1; color: #166534; font-weight: 600; }
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
        table { width: 100%; border-collapse: collapse; margin-bottom: 14px; }
        td, th { padding: 8px 10px; border-bottom: 1px solid #e2e8f0; text-align: left; }
        th { background: #1e293b; color: #fff; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; }
        td.num, th.num { text-align: right; }
        tr.total td { font-weight: 800; font-size: 15px; border-top: 2px solid #1e293b; border-bottom: none; }
        .status { display: inline-block; padding: 3px 10px; border-radius: 4px; font-weight: 700; font-size: 12px; }
        .Lunas { background: #dcfce7; color: #15803d; }
        .DP { background: #fef3c7; color: #92400e; }
        .Belum { background: #fee2e2; color: #b91c1c; }
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

<div class="toolbar no-print">
    <a href="{{ route('closing.index') }}" class="btn">&larr; Kembali ke Daftar Closing</a>
    <button type="button" class="btn btn-primary" onclick="window.print()">Cetak Nota</button>
    @if(session('success'))
        <span class="info">{{ session('success') }}</span>
    @endif
</div>

<div class="nota">
    <div class="head">
        <div class="brand">JAWARATECH <small>Nota Servis &amp; Invoice</small></div>
        <div class="meta">
            <strong>{{ $s->no_invoice }}</strong><br>
            Tanggal: {{ $s->tanggal_closing->translatedFormat('j F Y') }}<br>
            No. Tiket: {{ $s->no_tiket }}
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
                Tanggal masuk: {{ $s->tanggal_masuk->translatedFormat('j F Y') }}<br>
                Teknisi: {{ $s->teknisi->nama_teknisi ?? '-' }}
            </div>
        </div>
    </div>

    <div class="label">Keluhan</div>
    <div class="box" style="margin-bottom: 14px;">{!! nl2br(e($s->keluhan)) !!}</div>

    <div class="label">Rincian Tindakan / Sparepart</div>
    <div class="box" style="margin-bottom: 18px;">{!! nl2br(e($s->catatan)) !!}</div>

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
            @if($s->status_pembayaran === 'Lunas' && $s->tanggal_pelunasan)
                <tr><td>Pelunasan ({{ $s->tanggal_pelunasan->translatedFormat('j M Y') }})</td><td class="num">Rp {{ number_format($s->jumlah_pelunasan, 0, ',', '.') }}</td></tr>
            @endif
            @if($s->sisa_bayar > 0)
                <tr><td><strong>Sisa yang harus dibayar</strong></td><td class="num"><strong>Rp {{ number_format($s->sisa_bayar, 0, ',', '.') }}</strong></td></tr>
            @endif
        </tbody>
    </table>

    <div class="grid">
        <div>
            <div class="label">Pembayaran</div>
            <div class="box">
                Status:
                <span class="status {{ $s->status_pembayaran === 'Belum Lunas' ? 'Belum' : $s->status_pembayaran }}">{{ strtoupper($s->status_pembayaran) }}</span><br>
                Metode: {{ $s->metode_pembayaran ?? '-' }}
            </div>
        </div>
        <div>
            <div class="label">Garansi Servis</div>
            <div class="box">
                {{ $s->masa_garansi_hari > 0 ? $s->label_garansi : 'Tanpa Garansi' }}<br>
                @if($s->garansi_berakhir)
                    Berlaku sampai {{ $s->garansi_berakhir->translatedFormat('j F Y') }}
                @else
                    -
                @endif
            </div>
        </div>
    </div>

    <div class="ttd">
        <div>Teknisi<div class="garis">{{ $s->teknisi->nama_teknisi ?? '-' }}</div></div>
        <div>Pelanggan<div class="garis">{{ $s->unit->konsumen->nama ?? '-' }}</div></div>
    </div>

    <div class="foot">Terima kasih telah mempercayakan servis Anda kepada Jawaratech.</div>
</div>

@if($auto)
<script>
    window.addEventListener('load', function () { window.print(); });
</script>
@endif
</body>
</html>