<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Usaha Tani — {{ $biayaProduksi['tanam']['kode_tanam'] ?? $tanam->kode_tanam }}</title>
    <style>
        @page {
            margin: 10mm 15mm;
        }

        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 14px;
            color: #000;
            background: #fff;
            margin: 0;
            padding: 0;
        }

        .page {
            width: 100%;
            margin: 0 auto;
            page-break-after: always;
        }

        .page:last-child {
            page-break-after: auto;
        }

        .report-header {
            text-align: center;
            margin-bottom: 4px;
            line-height: 1.2;
        }

        .report-header .group-name,
        .report-header .title {
            font-weight: bold;
            text-transform: uppercase;
        }

        .header-line {
            border-top: 1px solid #000;
            margin: 4px 0 6px 0;
        }

        table {
            border-collapse: collapse;
            table-layout: fixed;
        }

        td {
            padding: 0.5px 2px;
            vertical-align: top;
        }

        .identity-table {
            width: 100%;
            margin-bottom: 10px;
        }

        .identity-label {
            width: 120px;
        }

        .identity-colon {
            width: 10px;
            text-align: center;
        }

        .identity-value {
            width: auto;
        }

        .section-title {
            font-weight: bold;
            margin-top: 5px;
            margin-bottom: 1px;
        }

        .production-table {
            width: 100%;
            table-layout: fixed;
            margin-bottom: 4px;
        }

        .production-table .item {
            padding-left: 18px;
            text-align: left;
        }

        .production-table .colon,
        .income-table .colon {
            text-align: center;
        }

        .production-table .qty {
            text-align: right;
        }

        .production-table .multiply {
            text-align: center;
        }

        .production-table .unit-price {
            text-align: right;
            white-space: nowrap;
        }

        .production-table .amount {
            text-align: right;
            white-space: nowrap;
        }

        .production-table .sign {
            text-align: center;
        }

        .production-table .spacer {
            /* width is auto via colgroup */
        }

        .production-table .subtotal {
            text-align: right;
            white-space: nowrap;
        }

        .production-table .subtotal-sign {
            text-align: center;
        }

        .addition-line td {
            height: 4px;
            padding-top: 0;
            padding-bottom: 0;
        }

        .underline {
            border-top: 1px solid #000;
        }

        .subtotal-row td {
            font-weight: bold;
            padding-top: 2px;
        }

        .subtotal-label {
            text-align: left;
        }

        .grand-total-row td {
            font-weight: bold;
            padding-top: 4px;
            font-size: 15px;
        }

        .grand-total-row .amount {
            font-weight: bold;
        }

        .income-table {
            width: 100%;
            table-layout: fixed;
        }

        .income-table .label {
            text-align: left;
        }

        .income-table .detail {
            padding-left: 25px;
        }

        .income-table .detail-amount {
            text-align: right;
            white-space: nowrap;
        }

        .income-table .detail-sign {
            text-align: center;
        }

        .income-table .spacer {
            /* width is auto/fixed via colgroup */
        }

        .income-table .final-amount {
            text-align: right;
            white-space: nowrap;
        }

        .income-table .final-sign {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        .spacer-row td {
            height: 4px;
        }
    </style>
</head>
<body>

@php
    $infoTanam   = $biayaProduksi['tanam'] ?? [];
    $ringkasan   = $biayaProduksi['ringkasan'] ?? [];
    $detailBiaya = $biayaProduksi['detail_biaya'] ?? [];
    $margin      = $marginKontribusi['nilai'] ?? [];

    $bbbItems    = $detailBiaya['BBB']['items'] ?? [];
    $btklItems   = $detailBiaya['BTKL']['items'] ?? [];
    $bopItems    = $detailBiaya['BOP']['items'] ?? [];
    $bbbSub      = $detailBiaya['BBB']['subtotal'] ?? 0;
    $btklSub     = $detailBiaya['BTKL']['subtotal'] ?? 0;
    $bopSub      = $detailBiaya['BOP']['subtotal'] ?? 0;

    $pendapatan  = $margin['pendapatan'] ?? 0;
    $biayaVar    = $margin['total_biaya_variabel'] ?? (is_array($margin['biaya_variabel'] ?? null) ? ($margin['biaya_variabel']['total'] ?? 0) : ($margin['biaya_variabel'] ?? 0));
    $biayaTetap  = $margin['total_biaya_tetap'] ?? ($margin['biaya_tetap'] ?? 0);
    $biayaVariabelItems = $margin['biaya_variabel_items'] ?? [];
    $biayaTetapItems    = $margin['biaya_tetap_items'] ?? [];
    $totalBiaya  = $margin['total_biaya'] ?? 0;
    $laba        = $margin['laba_bersih'] ?? 0;
    $marginTotal = $margin['margin_total'] ?? 0;

    $kodeTanam   = $infoTanam['kode_tanam'] ?? $tanam->kode_tanam;
    $komoditas   = $infoTanam['komoditas'] ?? '-';
    $petani      = $infoTanam['petani'] ?? '-';
    $volume      = $infoTanam['volume'] ?? 0;

    // Attempt to get Kelompok Tani
    $kelompokTani = "KELOMPOK TANI SUKAMAJU";
    if(isset($tanam->lahan->petani->kelompokTani->nama_kelompok)) {
        $kelompokTani = strtoupper($tanam->lahan->petani->kelompokTani->nama_kelompok);
    } elseif(isset($tanam->lahan->kelompok_tani)) {
         $kelompokTani = strtoupper($tanam->lahan->kelompok_tani);
    }

    $tglTanam = $tanam->tgl_tanam ? $tanam->tgl_tanam->format('d/m/Y') : '-';
    $tglPanen = $tanam->tgl_panen ? $tanam->tgl_panen->format('d/m/Y') : '-';
@endphp

{{-- ================================================================= --}}
{{-- 1. LAPORAN BIAYA PRODUKSI                                         --}}
{{-- ================================================================= --}}
<div class="report-container page">
    <div class="report-header">
        <div class="group-name">{{ $kelompokTani }}</div>
        <div class="title">LAPORAN BIAYA PRODUKSI</div>
        <div class="period">Periode: {{ $tglTanam }} &nbsp;s/d&nbsp; {{ $tglPanen }}</div>
    </div>

    <div class="header-line"></div>

    <table class="identity-table">
        <tr>
            <td class="identity-label">Kode Tanam</td>
            <td class="identity-colon">:</td>
            <td class="identity-value">{{ $kodeTanam }}</td>
        </tr>
        <tr>
            <td class="identity-label">Komoditas</td>
            <td class="identity-colon">:</td>
            <td class="identity-value">{{ number_format($volume, 0, ',', '.') }} {{ $infoTanam['satuan'] ?? 'Kg' }} {{ $komoditas }}</td>
        </tr>
        <tr>
            <td class="identity-label">Petani</td>
            <td class="identity-colon">:</td>
            <td class="identity-value">{{ $petani }}</td>
        </tr>
    </table>

    {{-- BIAYA BAHAN BAKU --}}
    <div class="section-title">Biaya Bahan Baku</div>
    <table class="production-table">
        <colgroup>
            <col style="width: 270px;">
            <col style="width: 10px;">
            <col style="width: 40px;">
            <col style="width: 15px;">
            <col style="width: 85px;">
            <col style="width: 100px;">
            <col style="width: 15px;">
            <col style="width: 60px;">
            <col style="width: 120px;">
            <col style="width: 15px;">
        </colgroup>
        @forelse($bbbItems as $item)
        <tr>
            <td class="item">{{ $item['nama_beban'] }}</td>
            <td class="colon">:</td>
            @if(($item['harga'] ?? 0) > 0 && ($item['jumlah'] ?? 0) > 0)
                <td class="qty">{{ number_format($item['jumlah'], 0, ',', '.') }}</td>
                <td class="multiply">X</td>
                <td class="unit-price" style="{{ $loop->last ? 'border-bottom: 1px solid #000;' : '' }}">Rp. {{ number_format($item['harga'], 0, ',', '.') }}</td>
            @else
                <td class="qty">{{ ($item['jumlah'] ?? 0) > 0 ? number_format($item['jumlah'], 0, ',', '.') : '' }}</td>
                <td class="multiply"></td>
                <td class="unit-price" style="{{ $loop->last ? 'border-bottom: 1px solid #000;' : '' }}"></td>
            @endif
            <td class="amount" style="{{ $loop->last ? 'border-bottom: 1px solid #000;' : '' }}">Rp. {{ number_format($item['total'] ?? ($item['jumlah'] * $item['harga']), 0, ',', '.') }}</td>
            <td class="sign" style="{{ $loop->last ? 'border-bottom: 1px solid #000;' : '' }}">{{ $loop->last ? '+' : '' }}</td>
            <td class="spacer"></td>
            <td class="subtotal"></td>
            <td class="subtotal-sign"></td>
        </tr>
        @empty
        <tr>
            <td class="item" colspan="10" style="color: #777;">Tidak ada data</td>
        </tr>
        @endforelse
        <tr class="addition-line">
            <td colspan="8"></td>
            <td class="subtotal"></td>
            <td class="subtotal-sign"></td>
        </tr>
        <tr class="subtotal-row">
            <td colspan="8" class="subtotal-label">TOTAL BIAYA BAHAN BAKU (BBB)</td>
            <td class="subtotal">Rp. {{ number_format($bbbSub, 0, ',', '.') }}</td>
            <td class="subtotal-sign"></td>
        </tr>
    </table>

    {{-- BIAYA TENAGA KERJA LANGSUNG --}}
    <div class="section-title">Biaya Tenaga Kerja Langsung</div>
    <table class="production-table">
        <colgroup>
            <col style="width: 270px;">
            <col style="width: 10px;">
            <col style="width: 40px;">
            <col style="width: 15px;">
            <col style="width: 85px;">
            <col style="width: 100px;">
            <col style="width: 15px;">
            <col style="width: 60px;">
            <col style="width: 120px;">
            <col style="width: 15px;">
        </colgroup>
        @forelse($btklItems as $item)
        <tr>
            <td class="item">{{ $item['nama_beban'] }}</td>
            <td class="colon">:</td>
            @if(($item['harga'] ?? 0) > 0 && ($item['jumlah'] ?? 0) > 0)
                <td class="qty">{{ number_format($item['jumlah'], 0, ',', '.') }}</td>
                <td class="multiply">X</td>
                <td class="unit-price" style="{{ $loop->last ? 'border-bottom: 1px solid #000;' : '' }}">Rp. {{ number_format($item['harga'], 0, ',', '.') }}</td>
            @else
                <td class="qty">{{ ($item['jumlah'] ?? 0) > 0 ? number_format($item['jumlah'], 0, ',', '.') : '' }}</td>
                <td class="multiply"></td>
                <td class="unit-price" style="{{ $loop->last ? 'border-bottom: 1px solid #000;' : '' }}"></td>
            @endif
            <td class="amount" style="{{ $loop->last ? 'border-bottom: 1px solid #000;' : '' }}">Rp. {{ number_format($item['total'] ?? ($item['jumlah'] * $item['harga']), 0, ',', '.') }}</td>
            <td class="sign" style="{{ $loop->last ? 'border-bottom: 1px solid #000;' : '' }}">{{ $loop->last ? '+' : '' }}</td>
            <td class="spacer"></td>
            <td class="subtotal"></td>
            <td class="subtotal-sign"></td>
        </tr>
        @empty
        <tr>
            <td class="item" colspan="10" style="color: #777;">Tidak ada data</td>
        </tr>
        @endforelse
        <tr class="addition-line">
            <td colspan="8"></td>
            <td class="subtotal"></td>
            <td class="subtotal-sign"></td>
        </tr>
        <tr class="subtotal-row">
            <td colspan="8" class="subtotal-label">TOTAL BIAYA TENAGA KERJA LANGSUNG (BTKL)</td>
            <td class="subtotal">Rp. {{ number_format($btklSub, 0, ',', '.') }}</td>
            <td class="subtotal-sign"></td>
        </tr>
    </table>

    {{-- BIAYA OVERHEAD PABRIK --}}
    <div class="section-title">Biaya Overhead Pabrik</div>
    <table class="production-table">
        <colgroup>
            <col style="width: 270px;">
            <col style="width: 10px;">
            <col style="width: 40px;">
            <col style="width: 15px;">
            <col style="width: 85px;">
            <col style="width: 100px;">
            <col style="width: 15px;">
            <col style="width: 60px;">
            <col style="width: 120px;">
            <col style="width: 15px;">
        </colgroup>
        @forelse($bopItems as $item)
        <tr>
            <td class="item">{{ $item['nama_beban'] }}</td>
            <td class="colon">:</td>
            @if(($item['harga'] ?? 0) > 0 && ($item['jumlah'] ?? 0) > 0)
                <td class="qty">{{ number_format($item['jumlah'], 0, ',', '.') }}</td>
                <td class="multiply">X</td>
                <td class="unit-price" style="{{ $loop->last ? 'border-bottom: 1px solid #000;' : '' }}">Rp. {{ number_format($item['harga'], 0, ',', '.') }}</td>
            @else
                <td class="qty">{{ ($item['jumlah'] ?? 0) > 0 ? number_format($item['jumlah'], 0, ',', '.') : '' }}</td>
                <td class="multiply"></td>
                <td class="unit-price" style="{{ $loop->last ? 'border-bottom: 1px solid #000;' : '' }}"></td>
            @endif
            <td class="amount" style="{{ $loop->last ? 'border-bottom: 1px solid #000;' : '' }}">Rp. {{ number_format($item['total'] ?? ($item['jumlah'] * $item['harga']), 0, ',', '.') }}</td>
            <td class="sign" style="{{ $loop->last ? 'border-bottom: 1px solid #000;' : '' }}">{{ $loop->last ? '+' : '' }}</td>
            <td class="spacer"></td>
            <td class="subtotal"></td>
            <td class="subtotal-sign"></td>
        </tr>
        @empty
        <tr>
            <td class="item" colspan="10" style="color: #777;">Tidak ada data</td>
        </tr>
        @endforelse
        <tr class="addition-line">
            <td colspan="8"></td>
            <td class="subtotal"></td>
            <td class="subtotal-sign"></td>
        </tr>
        <tr class="subtotal-row">
            <td colspan="8" class="subtotal-label">TOTAL BIAYA OVERHEAD PABRIK (BOP)</td>
            <td class="subtotal" style="border-bottom: 1px solid #000;">Rp. {{ number_format($bopSub, 0, ',', '.') }}</td>
            <td class="subtotal-sign" style="border-bottom: 1px solid #000;">+</td>
        </tr>
    </table>

    {{-- GRAND TOTAL --}}
    <table class="production-table" style="margin-top: 12px;">
        <colgroup>
            <col style="width: 270px;">
            <col style="width: 10px;">
            <col style="width: 40px;">
            <col style="width: 15px;">
            <col style="width: 85px;">
            <col style="width: 100px;">
            <col style="width: 15px;">
            <col style="width: 60px;">
            <col style="width: 120px;">
            <col style="width: 15px;">
        </colgroup>
        <tr class="grand-total-row">
            <td colspan="8" class="subtotal-label">TOTAL BIAYA PRODUKSI</td>
            <td class="subtotal" style="border-bottom: 3px double #000;">Rp. {{ number_format($ringkasan['total_biaya'] ?? 0, 0, ',', '.') }}</td>
            <td class="subtotal-sign"></td>
        </tr>
    </table>
</div>

{{-- ================================================================= --}}
{{-- 2. LAPORAN LABA RUGI                                              --}}
{{-- ================================================================= --}}
<div class="report-container page">
    <div class="report-header">
        <div class="group-name">{{ $kelompokTani }}</div>
        <div class="title">LAPORAN LABA RUGI</div>
        <div class="period">Periode: {{ $tglTanam }} &nbsp;s/d&nbsp; {{ $tglPanen }}</div>
    </div>

    <div class="header-line"></div>

    <table class="income-table" style="margin-top: 15px;">
        <colgroup>
            <col style="width: 360px;">
            <col style="width: 10px;">
            <col style="width: 130px;">
            <col style="width: 15px;">
            <col style="width: 60px;">
            <col style="width: 140px;">
            <col style="width: 15px;">
        </colgroup>
        <tr>
            <td class="label bold">Pendapatan</td>
            <td class="colon"></td>
            <td class="detail-amount"></td>
            <td class="detail-sign"></td>
            <td class="spacer"></td>
            <td class="final-amount">Rp. {{ number_format($pendapatan, 0, ',', '.') }}</td>
            <td class="final-sign"></td>
        </tr>
        <tr class="spacer-row"><td colspan="7"></td></tr>

        <tr>
            <td class="label income-section-title">Biaya Variabel</td>
            <td class="colon"></td>
            <td class="detail-amount"></td>
            <td class="detail-sign"></td>
            <td class="spacer"></td>
            <td class="final-amount"></td>
            <td class="final-sign"></td>
        </tr>

        @forelse($biayaVariabelItems as $item)
        <tr>
            <td class="label detail">{{ $item['nama'] ?? '-' }}</td>
            <td class="colon">:</td>
            <td class="detail-amount" style="{{ $loop->last ? 'border-bottom: 1px solid #000;' : '' }}">Rp. {{ number_format($item['total'], 0, ',', '.') }}</td>
            <td class="detail-sign" style="{{ $loop->last ? 'border-bottom: 1px solid #000;' : '' }}">{{ $loop->last ? '+' : '' }}</td>
            <td class="spacer"></td>
            <td class="final-amount"></td>
            <td class="final-sign"></td>
        </tr>
        @empty
        <tr>
            <td class="label detail" colspan="7" style="color: #777;">Tidak ada data</td>
        </tr>
        @endforelse

        <tr class="addition-line">
            <td colspan="5"></td>
            <td class="final-amount"></td>
            <td class="final-sign"></td>
        </tr>
        <tr class="bold">
            <td colspan="5" class="label">TOTAL BIAYA VARIABEL</td>
            <td class="final-amount" style="border-bottom: 1px solid #000;">Rp. {{ number_format($biayaVar, 0, ',', '.') }}</td>
            <td class="final-sign" style="border-bottom: 1px solid #000;">-</td>
        </tr>
        <tr class="spacer-row"><td colspan="7"></td></tr>

        <tr class="bold">
            <td colspan="5" class="label">MARGIN KONTRIBUSI</td>
            <td class="final-amount">Rp. {{ number_format($marginTotal, 0, ',', '.') }}</td>
            <td class="final-sign"></td>
        </tr>
        <tr class="spacer-row"><td colspan="7"></td></tr>

        <tr>
            <td class="label income-section-title">Biaya Tetap</td>
            <td class="colon"></td>
            <td class="detail-amount"></td>
            <td class="detail-sign"></td>
            <td class="spacer"></td>
            <td class="final-amount"></td>
            <td class="final-sign"></td>
        </tr>

        @forelse($biayaTetapItems as $item)
        <tr>
            <td class="label detail">{{ $item['nama'] ?? '-' }}</td>
            <td class="colon">:</td>
            <td class="detail-amount" style="{{ $loop->last ? 'border-bottom: 1px solid #000;' : '' }}">Rp. {{ number_format($item['total'], 0, ',', '.') }}</td>
            <td class="detail-sign" style="{{ $loop->last ? 'border-bottom: 1px solid #000;' : '' }}">{{ $loop->last ? '+' : '' }}</td>
            <td class="spacer"></td>
            <td class="final-amount"></td>
            <td class="final-sign"></td>
        </tr>
        @empty
        <tr>
            <td class="label detail" colspan="7" style="color: #777;">Tidak ada data</td>
        </tr>
        @endforelse

        <tr class="addition-line">
            <td colspan="5"></td>
            <td class="final-amount"></td>
            <td class="final-sign"></td>
        </tr>
        <tr class="bold">
            <td colspan="5" class="label">TOTAL BIAYA TETAP</td>
            <td class="final-amount" style="border-bottom: 1px solid #000;">Rp. {{ number_format($biayaTetap, 0, ',', '.') }}</td>
            <td class="final-sign" style="border-bottom: 1px solid #000;">-</td>
        </tr>
        <tr class="spacer-row"><td colspan="7"></td></tr>

        <tr class="bold" style="font-size: 14.5px;">
            <td colspan="5" class="label">NET OPERATING INCOME (LABA BERSIH)</td>
            <td class="final-amount">Rp. {{ number_format($laba, 0, ',', '.') }}</td>
            <td class="final-sign"></td>
        </tr>
    </table>
</div>

<script>
window.onload = function() {
    setTimeout(function() {
        // Uncomment below to auto-print
        // window.print();
    }, 600);
};
</script>
</body>
</html>
