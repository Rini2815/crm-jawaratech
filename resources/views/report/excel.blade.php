@php
    $namaFile = "Laporan_Rekapitulasi_Jawaratech_" . date('Y-m-d') . ".xls";
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=\"$namaFile\"");
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Rekapitulasi Jawaratech</title>
    <style>
        table { border-collapse: collapse; width: 100%; font-family: Arial, sans-serif; font-size: 11px; }
        th { background-color: #000000; color: #FFFFFF; font-weight: bold; text-align: center; padding: 8px; border: 1px solid #000000; }
        td { border: 1px solid #000000; padding: 6px; vertical-align: middle; }
        .title { font-size: 14px; font-weight: bold; text-align: center; margin-bottom: 10px; text-transform: uppercase; }
        .subtitle { font-weight: bold; margin-top: 15px; margin-bottom: 5px; font-size: 12px; }
    </style>
</head>
<body>

    <table>
        <tr>
            <td colspan="12" align="center" style="font-size: 15px; font-weight: bold; border: none;">JAWARATECH - LAPORAN REKAPITULASI SERVIS & FOLLOW-UP</td>
        </tr>
        <tr>
            <td colspan="12" align="center" style="font-size: 10px; border: none;">Pusat Madiun/Caruban & Magetan | WhatsApp: +62 822-2808-4708</td>
        </tr>
        <tr><td colspan="12" style="border: none;"></td></tr>
    </table>

    @if(isset($konsumen))
    <table>
        <tr>
            <td style="font-weight: bold; width: 15%; border: none;">Nama Konsumen</td>
            <td style="width: 35%; border: none;">: {{ $konsumen->nama }}</td>
            <td style="font-weight: bold; width: 15%; border: none;">ID Konsumen</td>
            <td style="width: 35%; border: none;">: #{{ $konsumen->id_konsumen }}</td>
        </tr>
        <tr>
            <td style="font-weight: bold; border: none;">No. WhatsApp</td>
            <td style="border: none;">: {{ $konsumen->no_whatsapp ?? '-' }}</td>
            <td style="font-weight: bold; border: none;">Alamat Klien</td>
            <td style="border: none;">: {{ $konsumen->alamat ?? '-' }}</td>
        </tr>
        <tr><td colspan="4" style="border: none;"></td></tr>
    </table>
    @endif

    <!-- TABEL 1: RIWAYAT SERVIS UTAMA -->
    <div class="subtitle">1. Rekam Jejak Transaksi & Pengerjaan Unit Servis</div>
    <table>
        <thead>
            <tr>
                <th>NO</th>
                <th>NO TIKET</th>
                <th>INVOICE</th>
                <th>TANGGAL REG</th>
                <th>KONSUMEN</th>
                <th>WHATSAPP</th>
                <th>UNIT & MEREK</th>
                <th>MODEL</th>
                <th>KELUHAN</th>
                <th>STATUS</th>
                <th>TEKNISI</th>
                <th>BIAYA (RP)</th>
                <th>METODE</th>
                <th>GARANSI</th>
                <th>NEXT SERVIS</th>
                <th>FOLLOW-UP</th>
            </tr>
        </thead>
        <tbody>
            @forelse($riwayatServis as $index => $item)
            <tr>
                <td align="center">{{ $index + 1 }}</td>
                <td>{{ $item->no_tiket ?? '-' }}</td>
                <td>{{ $item->no_invoice ?? 'Belum Cetak' }}</td>
                <td align="center">{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}</td>
                <td>{{ $item->nama ?? '-' }}</td>
                <td>{{ $item->no_whatsapp ?? '-' }}</td>
                <td>{{ $item->jenis_unit ?? '-' }} ({{ $item->merek ?? '-' }})</td>
                <td>{{ $item->tipe_model ?? '-' }}</td>
                <td>{{ $item->keluhan ?? '-' }}</td>
                <td align="center">{{ $item->status ?? '-' }}</td>
                <td>{{ $item->nama_teknisi ?? 'Belum Ditugaskan' }}</td>
                <td align="right">{{ $item->biaya_jasa ?? ($item->total_biaya ?? 0) }}</td>
                <td align="center">{{ $item->metode_pembayaran ?? '-' }}</td>
                <td align="center">{{ str_contains(strtolower($item->status_garansi ?? ''), 'aktif') ? 'Valid' : 'Non-Garansi' }}</td>
                <td align="center">{{ !empty($item->tanggal_jatuh_tempo) ? \Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->format('d-m-Y') : '-' }}</td>
                <td>{{ $item->status_follow_up ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="16" align="center">Tidak ada riwayat servis tercatat.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <br><br>

    <!-- TABEL 2: AGENDA FOLLOW-UP & PERAWATAN BERKALA -->
    <div class="subtitle">2. Agenda Pengingat Perawatan Berkala & Follow-up WhatsApp Konsumen</div>
    <table>
        <thead>
            <tr>
                <th>NO</th>
                <th>NAMA KONSUMEN</th>
                <th>NO WHATSAPP</th>
                <th>UNIT PERANGKAT</th>
                <th>KATEGORI</th>
                <th>STATUS</th>
                <th>JADWAL TEMPO</th>
                <th>CATATAN / HASIL</th>
            </tr>
        </thead>
        <tbody>
            @forelse($followUpList ?? [] as $idx => $fup)
            <tr>
                <td align="center">{{ $idx + 1 }}</td>
                <td>{{ $fup->nama ?? '-' }}</td>
                <td>{{ $fup->no_whatsapp ?? '-' }}</td>
                <td>{{ $fup->jenis_unit ?? '-' }} ({{ $fup->merek ?? '-' }})</td>
                <td>{{ $fup->kategori ?? 'Perawatan Berkala' }}</td>
                <td align="center">{{ $fup->status ?? '-' }}</td>
                <td align="center">{{ !empty($fup->tanggal_jadwal) ? \Carbon\Carbon::parse($fup->tanggal_jadwal)->format('d-m-Y') : '-' }}</td>
                <td>{{ $fup->catatan_hasil ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8" align="center">Tidak ada data pengingat atau follow-up.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>