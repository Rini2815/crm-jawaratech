<!DOCTYPE html>
<html lang="id"
      xmlns:o="urn:schemas-microsoft-com:office:office"
      xmlns:x="urn:schemas-microsoft-com:office:excel"
      xmlns="http://www.w3.org/TR/REC-html40">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <!-- Konfigurasi Excel -->
    <!--[if gte mso 9]>
    @verbatim
    <xml>
        <x:ExcelWorkbook>
            <x:ExcelWorksheets>
                <x:ExcelWorksheet>
                    <x:Name>Laporan Servis</x:Name>
                    <x:WorksheetOptions>
                        <x:Selected/>
                        <x:FreezePanes/>
                        <x:FrozenNoSplit/>
                        <x:SplitHorizontal>5</x:SplitHorizontal>
                        <x:TopRowBottomPane>5</x:TopRowBottomPane>
                        <x:SplitVertical>5</x:SplitVertical>
                        <x:LeftColumnRightPane>5</x:LeftColumnRightPane>
                        <x:ActivePane>0</x:ActivePane>
                        <x:Panes>
                            <x:Pane><x:Number>3</x:Number></x:Pane>
                            <x:Pane><x:Number>1</x:Number></x:Pane>
                            <x:Pane><x:Number>2</x:Number></x:Pane>
                            <x:Pane>
                                <x:Number>0</x:Number>
                                <x:Selected/>
                            </x:Pane>
                        </x:Panes>
                        <x:ProtectContents>False</x:ProtectContents>
                        <x:DisplayGridlines>False</x:DisplayGridlines>
                    </x:WorksheetOptions>
                </x:ExcelWorksheet>
            </x:ExcelWorksheets>
        </x:ExcelWorkbook>
    </xml>
    @endverbatim
    <![endif]-->

    <style>
        @page {
            size: landscape;
            margin: 0.3in;
        }

        table {
            border-collapse: collapse;
            table-layout: fixed;
            font-family: Calibri, Arial, sans-serif;
            font-size: 11pt;
        }

        td, th {
            vertical-align: middle;
        }

        /* JUDUL */
        .judul {
            font-size: 20pt;
            font-weight: bold;
            text-align: center;
            color: #000000;
            height: 42px;
        }

        .sub {
            font-size: 10pt;
            text-align: center;
            color: #333333;
        }

        .info {
            font-size: 11pt;
            font-weight: bold;
            text-align: left;
        }

        /* RINGKASAN */
        .ringkas {
            font-size: 10pt;
            font-weight: bold;
            background: #F2F2F2;
            border: 1px solid #000000;
            text-align: left;
            padding: 8px;
            white-space: nowrap;
        }

        /* HEADER */
        th {
            background: #000000;
            color: #FFFFFF;
            font-weight: bold;
            text-align: center;
            border: 1px solid #000000;
            height: 42px;
            padding: 7px;
            white-space: normal;
        }

        /* ISI TABEL */
        td {
            border: 1px solid #808080;
            padding: 7px;
            height: 30px;
            vertical-align: middle;
        }

        tr.zebra td {
            background: #F2F2F2;
        }

        /* ALIGNMENT */
        .c { text-align: center; }
        .l { text-align: left; }
        .r { text-align: right; }
        .b { font-weight: bold; }

        .wrap {
            white-space: normal;
        }

        /* FORMAT TEKS EXCEL */
        .txt {
            mso-number-format: '\@';
            white-space: nowrap;
        }

        /* KHUSUS NOMOR WHATSAPP */
        .wa {
            mso-number-format: '\@' !important;
            white-space: nowrap !important;
            text-align: left;
        }

        /* FORMAT RUPIAH */
        .rp {
            mso-number-format: '\@';
            text-align: right;
            white-space: nowrap;
        }

        /* STATUS */
        .ok {
            background: #D4EDDA;
            color: #155724;
            font-weight: bold;
            text-align: center;
        }

        .warn {
            background: #FFF3CD;
            color: #856404;
            font-weight: bold;
            text-align: center;
        }

        .abu {
            background: #E2E3E5;
            color: #383D41;
            font-weight: bold;
            text-align: center;
        }

        /* TOTAL */
        .total td {
            background: #000000;
            color: #FFFFFF;
            font-weight: bold;
            border: 1px solid #000000;
            height: 35px;
            white-space: nowrap;
        }
    </style>
</head>

<body>

@php

    /* FORMAT TANGGAL */
    $tglFmt = function ($v) {
        return !empty($v)
            ? \Carbon\Carbon::parse($v)->format('d/m/Y')
            : '-';
    };

    /* FORMAT JAM */
    $jamFmt = function ($v) {
        if (empty($v)) {
            return '-';
        }

        $c = \Carbon\Carbon::parse($v);

        return $c->format('H:i') === '00:00'
            ? '-'
            : $c->format('H:i') . ' WIB';
    };

    /* FORMAT RUPIAH */
    $rupiah = function ($v) {
        return 'Rp ' . number_format(
            (float) ($v ?? 0),
            0,
            ',',
            '.'
        );
    };

    /* JUMLAH DATA */
    $jumlahData = count($riwayatServis);

    /* TOTAL KEUANGAN */
    $sumJasa = 0;
    $sumSpare = 0;
    $sumDiskon = 0;
    $sumTotal = 0;

    foreach ($riwayatServis as $r) {
        $sumJasa += (float) ($r->biaya_jasa ?? 0);
        $sumSpare += (float) ($r->x_sparepart ?? 0);
        $sumDiskon += (float) ($r->x_diskon ?? 0);
        $sumTotal += (float) ($r->x_total_bayar ?? 0);
    }

    $kolom = 28;

@endphp

<table>

    <!-- LEBAR MASING-MASING KOLOM -->
    <colgroup>
        <col width="55">
        <col width="110">
        <col width="110">
        <col width="170">
        <col width="155">
        <col width="190">
        <col width="155">
        <col width="155">
        <col width="125">
        <col width="110">
        <col width="115">
        <col width="230">
        <col width="140">
        <col width="110">
        <col width="120">
        <col width="190">
        <col width="145">
        <col width="155">
        <col width="130">
        <col width="150">
        <col width="115">
        <col width="130">
        <col width="120">
        <col width="120">
        <col width="135">
        <col width="145">
        <col width="160">
        <col width="210">
    </colgroup>

    <!-- BARIS 1: JUDUL -->
    <tr>
        <td colspan="{{ $kolom }}"
            class="judul"
            style="border:none;">
            JAWARATECH — LAPORAN REKAPITULASI SERVIS & FOLLOW-UP
        </td>
    </tr>

    <!-- BARIS 2: IDENTITAS -->
    <tr>
        <td colspan="{{ $kolom }}"
            class="sub"
            style="border:none;">
            Dikelola oleh CV Jawara Tiga Pendiri
            &nbsp;|&nbsp;
            Pusat Madiun/Caruban &amp; Magetan
            &nbsp;|&nbsp;
            WhatsApp: +62 822-2808-4708
        </td>
    </tr>

    <!-- BARIS 3: PERIODE -->
    <tr>
        <td colspan="{{ $kolom }}"
            class="info"
            style="border:none; height:30px;">

            Periode Tanggal Registrasi: {{ $periode ?? '-' }}

            @if(isset($konsumen))
                &nbsp; | &nbsp;
                Konsumen: {{ $konsumen->nama }}

                &nbsp; | &nbsp;
                WA: {{ $konsumen->no_whatsapp ?? '-' }}

                &nbsp; | &nbsp;
                Alamat: {{ $konsumen->alamat ?? '-' }}
            @endif

        </td>
    </tr>

    <!-- BARIS 4: RINGKASAN -->
    <tr>
        <td colspan="3" class="ringkas">
            Jumlah Data Servis: {{ $jumlahData }}
        </td>

        <td colspan="6" class="ringkas">
            Total Biaya Jasa: {{ $rupiah($sumJasa) }}
        </td>

        <td colspan="6" class="ringkas">
            Total Sparepart: {{ $rupiah($sumSpare) }}
        </td>

        <td colspan="7" class="ringkas">
            Total Diskon: {{ $rupiah($sumDiskon) }}
        </td>

        <td colspan="6" class="ringkas">
            Total Pemasukan: {{ $rupiah($sumTotal) }}
        </td>
    </tr>

    <!-- BARIS 5: HEADER KOLOM -->
    <tr>
        <th>NO</th>
        <th>TGL REGISTRASI</th>
        <th>JAM REGISTRASI</th>
        <th>NAMA KONSUMEN</th>
        <th>NO. WHATSAPP</th>
        <th>ALAMAT</th>
        <th>NO TIKET</th>
        <th>INVOICE</th>
        <th>UNIT</th>
        <th>MEREK</th>
        <th>MODEL</th>
        <th>KELUHAN</th>
        <th>PERKIRAAN SELESAI</th>
        <th>STATUS</th>
        <th>TGL CLOSING</th>
        <th>TEKNISI</th>
        <th>BIAYA JASA</th>
        <th>BIAYA SPAREPART</th>
        <th>DISKON</th>
        <th>TOTAL BAYAR</th>
        <th>METODE</th>
        <th>STATUS BAYAR</th>
        <th>GARANSI</th>
        <th>MASA GARANSI</th>
        <th>GARANSI BERLAKU S.D.</th>
        <th>JADWAL NEXT SERVICE</th>
        <th>HASIL FOLLOW-UP</th>
        <th>CATATAN HASIL</th>
    </tr>

    <!-- DATA SERVIS -->
    @forelse($riwayatServis as $index => $item)

        @php

            $isGaransi = str_contains(
                strtolower($item->status_garansi ?? ''),
                'aktif'
            );

            $hariGaransi = $item->x_garansi_hari !== null
                ? (int) preg_replace(
                    '/\D/',
                    '',
                    (string) $item->x_garansi_hari
                )
                : null;

            $nextService = $item->tanggal_jadwal_fu
                ?? $item->tanggal_jatuh_tempo
                ?? null;

            $fuStatus = $item->status_follow_up
                ?? 'Belum Dihubungi';

            $statusBayar = $item->x_status_bayar ?? null;

            $kelasRow = $index % 2 === 1 ? 'zebra' : '';

            /*
             * Nomor WhatsApp diambil langsung dari JOIN ms_konsumen.
             * Tidak dikonversi menjadi integer atau float.
             */
            $nomorWA = $item->no_whatsapp ?? null;

            $nomorWA = $nomorWA !== null
                ? trim((string) $nomorWA)
                : '';

        @endphp

        <tr class="{{ $kelasRow }}">

            <td class="c b">
                {{ $index + 1 }}
            </td>

            <td class="c txt">
                {{ $tglFmt($item->created_at) }}
            </td>

            <td class="c txt">
                {{ $jamFmt($item->created_at) }}
            </td>

            <td class="l b wrap">
                {{ $item->nama ?? '-' }}
            </td>

            <!-- WHATSAPP: DIPAKSA MENJADI TEKS -->
            <td class="wa">
    @if($nomorWA !== '')
        {{ $nomorWA }}
    @else
        -
    @endif
</td>

            <td class="l wrap">
                {{ $item->alamat ?? '-' }}
            </td>

            <td class="l b txt">
                {{ $item->no_tiket ?? '-' }}
            </td>

            <td class="l txt">
                {{ $item->no_invoice ?? 'Belum Cetak' }}
            </td>

            <td class="l b wrap">
                {{ $item->jenis_unit ?? '-' }}
            </td>

            <td class="l b">
                {{ $item->merek ?? '-' }}
            </td>

            <td class="l txt">
                {{ $item->tipe_model ?? '-' }}
            </td>

            <td class="l wrap">
                {{ $item->keluhan ?? '-' }}
            </td>

            <td class="c txt">
                {{ $tglFmt($item->x_perkiraan) }}
            </td>

            <td class="{{ ($item->status ?? '') === 'Selesai' ? 'ok' : 'warn' }}">
                {{ $item->status ?? 'Proses' }}
            </td>

            <td class="c txt">
                {{ $tglFmt($item->x_tgl_closing) }}
            </td>

            <td class="l wrap">
                {{ $item->nama_teknisi ?? 'Belum Ditugaskan' }}
            </td>

            <td class="rp">
                {{ $rupiah($item->biaya_jasa) }}
            </td>

            <td class="rp">
                {{ $rupiah($item->x_sparepart) }}
            </td>

            <td class="rp">
                {{ $rupiah($item->x_diskon) }}
            </td>

            <td class="rp b">
                {{ $rupiah($item->x_total_bayar) }}
            </td>

            <td class="c">
                {{ $item->metode_pembayaran ?? '-' }}
            </td>

            <td class="{{ $statusBayar
                ? (strtolower($statusBayar) === 'lunas' ? 'ok' : 'warn')
                : 'c' }}">
                {{ $statusBayar ?? '-' }}
            </td>

            <td class="{{ $isGaransi ? 'ok' : 'abu' }}">
                {{ $isGaransi ? 'Valid' : 'Non-Garansi' }}
            </td>

            <td class="c">
                {{ $hariGaransi ? $hariGaransi . ' Hari' : '-' }}
            </td>

            <td class="c txt">
                {{ $tglFmt($item->x_garansi_sampai) }}
            </td>

            <td class="c txt">
                {{ !empty($nextService)
                    ? $tglFmt($nextService)
                    : 'Belum Dijadwalkan' }}
            </td>

            <td class="{{ $fuStatus === 'Belum Dihubungi' ? 'warn' : 'ok' }}">
                {{ $fuStatus }}
            </td>

            <td class="l wrap">
                {{ $item->catatan_hasil ?? '-' }}
            </td>

        </tr>

    @empty

        <tr>
            <td colspan="{{ $kolom }}"
                class="c"
                style="height:40px;">
                Tidak ada riwayat servis tercatat pada periode ini.
            </td>
        </tr>

    @endforelse

    <!-- BARIS TOTAL -->
    @if($jumlahData > 0)

        <tr class="total">

            <td colspan="16" style="text-align:right;">
                TOTAL ({{ $jumlahData }} servis)
            </td>

            <td class="rp">
                {{ $rupiah($sumJasa) }}
            </td>

            <td class="rp">
                {{ $rupiah($sumSpare) }}
            </td>

            <td class="rp">
                {{ $rupiah($sumDiskon) }}
            </td>

            <td class="rp">
                {{ $rupiah($sumTotal) }}
            </td>

            <td colspan="8"></td>

        </tr>

    @endif

</table>

</body>
</html>