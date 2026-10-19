@php
    // ===== DATA USAHA: ubah di sini saja (tampil di kop nota) =====
    $usaha = [
        'slogan'  => 'Layanan Servis & Perawatan Berkala',
        'alamat'  => 'Jl. Contoh No. 1, Madiun, Jawa Timur',   // GANTI dengan alamat asli
        'telepon' => '0812-0000-0000',                          // GANTI dengan nomor asli
        'email'   => '',                                        // kosongkan jika tidak ada
    ];

    $statusBayar = $s->status_pembayaran;
    $kelasStatus = $statusBayar === 'Lunas' ? 'lunas' : ($statusBayar === 'DP' ? 'dp' : 'belum');
    $teksStempel = $statusBayar === 'Lunas' ? 'LUNAS' : ($statusBayar === 'DP' ? 'DP' : 'BELUM LUNAS');
    $subtotal    = $s->biaya_jasa + $s->biaya_sparepart;
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice {{ $s->no_invoice }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

        @page { size: A4; margin: 12mm; }

        * { box-sizing: border-box; -webkit-print-color-adjust: exact; print-color-adjust: exact; }

        body {
            margin: 0;
            background: #e2e8f0;
            font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
            font-size: 13.5px;
            line-height: 1.5;
            color: #0f172a;
        }

        /* ===== Bilah atas (tidak ikut tercetak) ===== */
        .toolbar { max-width: 820px; margin: 16px auto 0; padding: 0 8px; display: flex; gap: 8px; align-items: center; flex-wrap: wrap; }
        .btn { display: inline-block; padding: 8px 16px; border-radius: 6px; border: 1px solid #cbd5e1; background: #fff; color: #0f172a; font-family: inherit; font-weight: 600; font-size: 13px; text-decoration: none; cursor: pointer; }
        .btn-primary { background: #16a34a; border-color: #16a34a; color: #fff; }
        .info { flex: 1; color: #166534; font-weight: 600; }

        /* ===== Lembar nota ===== */
        .nota {
            position: relative;
            max-width: 820px;
            margin: 12px auto 24px;
            padding: 30px 36px 26px;
            background: #ffffff;
            border: 1px solid #cbd5e1;
            overflow: hidden;
        }
        .isi { position: relative; z-index: 1; }

        /* ===== Tanda status (samar, di belakang teks) ===== */
        .stempel {
            position: absolute;
            top: 52%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-22deg);
            z-index: 0;
            padding: 2px 34px;
            font-size: 120px;
            font-weight: 800;
            letter-spacing: 8px;
            line-height: 1.15;
            white-space: nowrap;
            border: 10px solid currentColor;
            border-radius: 18px;
            opacity: 0.15;
            pointer-events: none;
            user-select: none;
        }
        .stempel.panjang { font-size: 78px; letter-spacing: 4px; border-width: 8px; }
        .stempel.lunas { color: #15803d; }
        .stempel.dp    { color: #b45309; }
        .stempel.belum { color: #b91c1c; }

        /* ===== Kop surat ===== */
        .kop { display: flex; justify-content: space-between; align-items: center; gap: 20px; }
        .kop-kiri { display: flex; align-items: center; gap: 16px; }
        .logo { height: 86px; width: auto; display: block; }
        .brand { font-size: 26px; font-weight: 800; letter-spacing: 1px; color: #14237a; }
        .slogan { font-weight: 600; color: #14237a; font-size: 13px; }
        .alamat, .kontak { color: #334155; font-size: 12.5px; }
        .kop-kanan { text-align: right; }
        .judul { font-size: 30px; font-weight: 800; letter-spacing: 3px; color: #14237a; line-height: 1.1; }
        .no-inv { margin-top: 4px; font-size: 15px; font-weight: 700; color: #b91c1c; }
        .tgl { color: #334155; font-size: 12.5px; }
        .garis-kop { margin: 14px 0 18px; height: 4px; background: #14237a; border-bottom: 2px solid #b91c1c; box-sizing: content-box; }

        /* ===== Kotak informasi ===== */
        .grid { display: flex; gap: 16px; margin-bottom: 14px; }
        .grid > div { flex: 1; }
        .box { border: 1px solid #cbd5e1; border-radius: 8px; padding: 10px 14px; }
        .box-judul { margin: 0 0 6px; padding-bottom: 5px; border-bottom: 1px solid #e2e8f0; font-size: 11px; font-weight: 700; letter-spacing: 0.8px; text-transform: uppercase; color: #14237a; }
        .nama { font-size: 15px; font-weight: 700; }
        table.kv { width: 100%; border-collapse: collapse; }
        table.kv td { padding: 1px 0; vertical-align: top; border: none; }
        table.kv td:first-child { width: 42%; color: #475569; }
        table.kv td:last-child { font-weight: 600; }
        .teks { white-space: normal; word-wrap: break-word; }

        /* ===== Tabel biaya ===== */
        table.biaya { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        table.biaya th { background: #14237a; color: #ffffff; padding: 8px 12px; font-size: 11.5px; letter-spacing: 0.6px; text-transform: uppercase; text-align: left; }
        table.biaya td { padding: 8px 12px; border-bottom: 1px solid #e2e8f0; }
        table.biaya .no { width: 44px; text-align: center; }
        table.biaya .num { text-align: right; white-space: nowrap; }
        table.biaya th.num { text-align: right; }
        table.biaya th.no { text-align: center; }

        /* ===== Ringkasan total ===== */
        .ringkas { display: flex; justify-content: flex-end; margin-bottom: 14px; }
        table.total { width: 330px; border-collapse: collapse; }
        table.total td { padding: 5px 12px; }
        table.total td:last-child { text-align: right; font-weight: 600; white-space: nowrap; }
        table.total tr.grand td { background: #14237a; color: #ffffff; font-size: 15px; font-weight: 800; padding: 9px 12px; }
        table.total tr.sisa td { color: #b91c1c; font-weight: 800; border-top: 1px dashed #b91c1c; }

        /* ===== Status & garansi ===== */
        .status { display: inline-block; padding: 2px 12px; border-radius: 4px; font-weight: 800; font-size: 12px; letter-spacing: 0.5px; }
        .status.lunas { background: #dcfce7; color: #15803d; border: 1px solid #86efac; }
        .status.dp    { background: #fef3c7; color: #92400e; border: 1px solid #fcd34d; }
        .status.belum { background: #fee2e2; color: #b91c1c; border: 1px solid #fca5a5; }

        /* ===== Tanda tangan & penutup ===== */
        .ttd { display: flex; justify-content: space-around; margin-top: 26px; text-align: center; page-break-inside: avoid; }
        .ttd > div { width: 36%; font-weight: 600; }
        .ttd .garis { width: 88%; margin: 58px auto 0; padding-top: 4px; border-top: 1px solid #0f172a; font-weight: 700; }
        .catatan { margin-top: 18px; text-align: center; color: #334155; font-size: 12px; }
        .foot { margin-top: 4px; text-align: center; font-weight: 700; color: #14237a; }

        .box, table.biaya, .ringkas, .grid { page-break-inside: avoid; }

        @media print {
            body { background: #ffffff; }
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

    {{-- Tanda status pembayaran (samar, berada di belakang teks) --}}
    <div class="stempel {{ $kelasStatus }} {{ strlen($teksStempel) > 5 ? 'panjang' : '' }}">{{ $teksStempel }}</div>

    <div class="isi">

        {{-- ===== KOP ===== --}}
        <div class="kop">
            <div class="kop-kiri">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Jawaratech" class="logo"
                     onerror="this.style.display='none'; document.getElementById('brand-teks').style.display='block';">
                <div class="kop-teks">
                    <div id="brand-teks" class="brand" style="display: none;">JAWARATECH</div>
                    <div class="slogan">{{ $usaha['slogan'] }}</div>
                    <div class="alamat">{{ $usaha['alamat'] }}</div>
                    <div class="kontak">
                        Telp / WA: {{ $usaha['telepon'] }}@if($usaha['email']) &nbsp;|&nbsp; {{ $usaha['email'] }}@endif
                    </div>
                </div>
            </div>
            <div class="kop-kanan">
                <div class="judul">INVOICE</div>
                <div class="no-inv">{{ $s->no_invoice }}</div>
                <div class="tgl">Tanggal: {{ $s->tanggal_closing->translatedFormat('j F Y') }}</div>
            </div>
        </div>
        <div class="garis-kop"></div>

        {{-- ===== PELANGGAN & DETAIL SERVIS ===== --}}
        <div class="grid">
            <div class="box">
                <div class="box-judul">Ditagihkan Kepada</div>
                <div class="nama">{{ $s->unit->konsumen->nama ?? '-' }}</div>
                <div>WhatsApp: {{ $s->unit->konsumen->no_whatsapp ?? '-' }}</div>
                <div class="teks">{{ $s->unit->konsumen->alamat ?? '-' }}</div>
            </div>
            <div class="box">
                <div class="box-judul">Detail Servis</div>
                <table class="kv">
                    <tr><td>No. Tiket / SPK</td><td>{{ $s->no_tiket }}</td></tr>
                    <tr><td>Tanggal Masuk</td><td>{{ $s->tanggal_masuk->translatedFormat('j F Y') }}</td></tr>
                    <tr><td>Tanggal Closing</td><td>{{ $s->tanggal_closing->translatedFormat('j F Y') }}</td></tr>
                    <tr><td>Teknisi</td><td>{{ $s->teknisi->nama_teknisi ?? '-' }}</td></tr>
                </table>
            </div>
        </div>

        {{-- ===== UNIT, KELUHAN, RINCIAN ===== --}}
        <div class="box" style="margin-bottom: 14px;">
            <div class="box-judul">Unit &amp; Pekerjaan</div>
            <table class="kv">
                <tr><td>Unit Servis</td><td>{{ $s->label_unit }}</td></tr>
                <tr><td>Keluhan</td><td class="teks">{!! nl2br(e($s->keluhan)) !!}</td></tr>
                <tr><td>Rincian Tindakan / Sparepart</td><td class="teks">{!! nl2br(e($s->catatan)) !!}</td></tr>
            </table>
        </div>

        {{-- ===== RINCIAN BIAYA ===== --}}
        <table class="biaya">
            <thead>
                <tr>
                    <th class="no">No</th>
                    <th>Keterangan Biaya</th>
                    <th class="num">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="no">1</td>
                    <td>Biaya Jasa Servis</td>
                    <td class="num">Rp {{ number_format($s->biaya_jasa, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td class="no">2</td>
                    <td>Biaya Sparepart</td>
                    <td class="num">Rp {{ number_format($s->biaya_sparepart, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <div class="ringkas">
            <table class="total">
                <tr>
                    <td>Subtotal</td>
                    <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                </tr>
                @if($s->diskon > 0)
                    <tr>
                        <td>Potongan / Diskon</td>
                        <td>- Rp {{ number_format($s->diskon, 0, ',', '.') }}</td>
                    </tr>
                @endif
                <tr class="grand">
                    <td>TOTAL BAYAR</td>
                    <td>Rp {{ number_format($s->total_bayar, 0, ',', '.') }}</td>
                </tr>
                @if($s->jumlah_dp > 0)
                    <tr>
                        <td>DP dibayar{{ $s->tanggal_dp ? ' (' . $s->tanggal_dp->translatedFormat('j M Y') . ')' : '' }}</td>
                        <td>Rp {{ number_format($s->jumlah_dp, 0, ',', '.') }}</td>
                    </tr>
                @endif
                @if($s->status_pembayaran === 'Lunas' && $s->tanggal_pelunasan)
                    <tr>
                        <td>Pelunasan ({{ $s->tanggal_pelunasan->translatedFormat('j M Y') }})</td>
                        <td>Rp {{ number_format($s->jumlah_pelunasan, 0, ',', '.') }}</td>
                    </tr>
                @endif
                @if($s->sisa_bayar > 0)
                    <tr class="sisa">
                        <td>Sisa yang harus dibayar</td>
                        <td>Rp {{ number_format($s->sisa_bayar, 0, ',', '.') }}</td>
                    </tr>
                @endif
            </table>
        </div>

        {{-- ===== PEMBAYARAN & GARANSI ===== --}}
        <div class="grid">
            <div class="box">
                <div class="box-judul">Pembayaran</div>
                <table class="kv">
                    <tr><td>Status</td><td><span class="status {{ $kelasStatus }}">{{ strtoupper($statusBayar) }}</span></td></tr>
                    <tr><td>Metode</td><td>{{ $s->metode_pembayaran ?? '-' }}</td></tr>
                </table>
            </div>
            <div class="box">
                <div class="box-judul">Garansi Servis</div>
                <table class="kv">
                    <tr><td>Masa Garansi</td><td>{{ $s->masa_garansi_hari > 0 ? $s->label_garansi : 'Tanpa Garansi' }}</td></tr>
                    <tr><td>Berlaku Sampai</td><td>{{ $s->garansi_berakhir ? $s->garansi_berakhir->translatedFormat('j F Y') : '-' }}</td></tr>
                </table>
            </div>
        </div>

        {{-- ===== TANDA TANGAN ===== --}}
        <div class="ttd">
            <div>Teknisi<div class="garis">{{ $s->teknisi->nama_teknisi ?? '-' }}</div></div>
            <div>Pelanggan<div class="garis">{{ $s->unit->konsumen->nama ?? '-' }}</div></div>
        </div>

        <div class="catatan">
            @if($s->masa_garansi_hari > 0)
                Harap simpan nota ini sebagai bukti pembayaran dan klaim garansi servis.
            @else
                Harap simpan nota ini sebagai bukti pembayaran.
            @endif
        </div>
        <div class="foot">Terima kasih telah mempercayakan servis Anda kepada Jawaratech.</div>

    </div>
</div>

@if($auto)
<script>
    window.addEventListener('load', function () { window.print(); });
</script>
@endif
</body>
</html>