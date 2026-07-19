@extends('layouts.app')
@section('title', 'Laporan Usaha Tani')
@section('contents')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
    :root {
        --primary:       #1F6F54;
        --primary-light: #27916D;
        --primary-dark:  #165242;
        --primary-pale:  #EBF5F0;
        --bg-light:      #F4F7F6;
        --card-shadow:   0 2px 14px rgba(31,111,84,0.07);
        --border:        #E3EDE8;
    }
    .rpt-wrap { font-family: 'Inter', sans-serif; color: #1F2937; }
    .rpt-wrap * { box-sizing: border-box; }
    /* ── Header ─────────────────────────────────────────── */
    .rpt-hero {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        border-radius: 12px; padding: 1.5rem 2rem;
        margin-bottom: 1.5rem; color: white;
        display: flex; align-items: center; justify-content: space-between;
    }
    .rpt-hero h1 { font-size: 1.6rem; font-weight: 700; margin: 0 0 .25rem; }
    .rpt-hero p  { margin: 0; opacity: .85; font-size: .88rem; }
    .rpt-export-btns { display: flex; gap: .6rem; flex-wrap: wrap; }
    .btn-export {
        background: rgba(255,255,255,.15); color: white;
        border: 1.5px solid rgba(255,255,255,.5); border-radius: 7px;
        padding: .45rem 1rem; font-weight: 600; font-size: .82rem;
        display: inline-flex; align-items: center; gap: .4rem;
        transition: all .2s; white-space: nowrap;
    }
    .btn-export:hover { background: rgba(255,255,255,.3); color: white; text-decoration: none; }
    .btn-pdf {
        background: #E05252;
        border-color: #E05252;
    }

    .btn-pdf:hover {
        background: #C83E3E;
        border-color: #C83E3E;
    }
    /* ── Metric Cards ────────────────────────────────────── */
    .metric-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem; margin-bottom: 1.5rem;
    }
    @media(max-width: 900px) { .metric-grid { grid-template-columns: repeat(2,1fr); } }
    @media(max-width: 560px) { .metric-grid { grid-template-columns: 1fr; } }
    .metric-card {
        background: white; border-radius: 10px;
        box-shadow: var(--card-shadow); border: 1px solid var(--border);
        padding: 1.2rem 1.4rem; display: flex; align-items: flex-start; gap: 1rem;
    }
    .metric-icon {
        width: 44px; height: 44px; border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.15rem; flex-shrink: 0;
    }
    .metric-card .m-label { font-size: .78rem; font-weight: 600; text-transform: uppercase;
                            letter-spacing: .05em; color: #6B7280; margin-bottom: .2rem; }
    .metric-card .m-value { font-size: 1rem; font-weight: 700; color: #111827;
                            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
                            max-width: 180px; }
    .metric-card .m-sub   { font-size: .75rem; color: #9CA3AF; margin-top: .15rem; }
    /* ── Cards ───────────────────────────────────────────── */
    .rpt-card {
        background: white; border-radius: 10px;
        box-shadow: var(--card-shadow); border: 1px solid var(--border);
        margin-bottom: 1.25rem; overflow: hidden;
    }
    .rpt-card-header {
        background: var(--primary); color: white;
        padding: .85rem 1.5rem; font-weight: 600; font-size: .97rem;
        display: flex; align-items: center; gap: .55rem;
    }
    .rpt-card-body { padding: 1.4rem; }
    /* ── Tab Nav ─────────────────────────────────────────── */
    .rpt-tabs { display: flex; gap: .6rem; margin-bottom: 1.5rem; flex-wrap: wrap; }
    .rpt-tab {
        background: white; color: var(--primary);
        border: 1.5px solid var(--primary); border-radius: 999px;
        padding: .5rem 1.4rem; font-weight: 600; font-size: .88rem;
        cursor: pointer; transition: all .2s; white-space: nowrap;
    }
    .rpt-tab.active { background: var(--primary); color: white !important; }
    .rpt-tab:hover:not(.active) { background: var(--primary-pale); color: var(--primary) !important; }
    /* ── Section Sub-header ──────────────────────────────── */
    .section-head {
        background: var(--primary); color: white;
        padding: .65rem 1.2rem; border-radius: 7px;
        font-weight: 600; font-size: .9rem;
        display: flex; justify-content: space-between; align-items: center;
        margin-bottom: .25rem;
    }
    /* ── Collapse Toggle ─────────────────────────────────── */
    .collapse-toggle {
        background: #F4F7F6; border: none; border-radius: 7px;
        padding: .6rem 1.2rem; width: 100%; text-align: left;
        font-weight: 600; font-size: .87rem; color: var(--primary);
        display: flex; justify-content: space-between; align-items: center;
        cursor: pointer; margin-bottom: .5rem; transition: background .15s;
    }
    .collapse-toggle:hover { background: #DFF0E8; }
    .collapse-toggle .toggle-icon { transition: transform .25s; }
    .collapse-toggle[aria-expanded="true"] .toggle-icon { transform: rotate(180deg); }
    /* ── Tables ──────────────────────────────────────────── */
    .rpt-table { width: 100%; border-collapse: collapse; margin: 0; }
    .rpt-table th {
        background: #F4F7F6; color: #374151;
        font-weight: 700; font-size: .75rem;
        text-transform: uppercase; letter-spacing: .05em;
        padding: .7rem 1rem; border-bottom: 2px solid #D1E8DC;
        white-space: nowrap;
    }
    .rpt-table td { padding: .65rem 1rem; border-bottom: 1px solid #F0F5F2; font-size: .9rem; vertical-align: middle; }
    .rpt-table tr:last-child td { border-bottom: none; }
    .rpt-table tbody tr:hover { background: #FAFCFB; }
    .row-category {
        background: #F4F7F6; font-weight: 600; font-size: .87rem; color: #374151;
    }
    .row-total-vc  { background: #D4EDDA; font-weight: 700; }
    .row-total-fc  { background: #D4EDDA; font-weight: 700; }
    .row-margin    { background: #C3E6CB; font-weight: 700; font-size: 1rem; }
    .row-noi       { background: var(--primary); color: white; font-weight: 700; font-size: 1rem; }
    .row-formula   { background: #FAFCFB; font-size: .8rem; color: #6B7280; }
    /* ── Summary Cost Row ────────────────────────────────── */
    .cost-summary { border-radius: 0; }
    .cost-summary tr.total-row td { background: var(--primary); color: white; font-weight: 700; font-size: 1rem; }
    /* ── BEP Cards ───────────────────────────────────────── */
    .bep-formula-card {
        background: white; border: 1px solid var(--border);
        border-radius: 10px; box-shadow: var(--card-shadow);
        overflow: hidden; margin-bottom: 1rem;
    }
    .bep-formula-card .card-cap {
        background: var(--primary); color: white;
        padding: .7rem 1.2rem; font-weight: 600; font-size: .9rem;
        display: flex; align-items: center; gap: .5rem;
    }
    .bep-formula-card .card-body { padding: 1.1rem 1.2rem; }
    .bep-formula    { font-size: .9rem; color: #6B7280; margin-bottom: .75rem; }
    .bep-result-row { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: .5rem; }
    .bep-eq         { font-size: .93rem; color: #374151; font-weight: 500; }
    .bep-answer     {
        background: var(--primary-pale); color: var(--primary);
        font-weight: 700; font-size: 1.05rem;
        padding: .35rem .9rem; border-radius: 7px; white-space: nowrap;
    }
    /* ── Conclusion Card ─────────────────────────────────── */
    .conclusion-card {
        background: white; border-radius: 10px; border: 1px solid var(--border);
        box-shadow: var(--card-shadow); overflow: hidden; margin-top: 1rem;
    }
    .conclusion-head {
        background: linear-gradient(135deg,var(--primary),var(--primary-light));
        color: white; padding: 1rem 1.5rem; font-weight: 700; font-size: 1rem;
        display: flex; align-items: center; gap: .5rem;
    }
    .conclusion-body { padding: 1.5rem; }
    .conclusion-row {
        display: flex; justify-content: space-between; align-items: center;
        padding: .6rem 0; border-bottom: 1px solid #F0F5F2; font-size: .92rem;
    }
    .conclusion-row:last-child { border-bottom: none; }
    .status-badge {
        display: inline-block; padding: .5rem 1.5rem; border-radius: 999px;
        font-weight: 800; font-size: 1rem; letter-spacing: .07em;
    }
    .status-untung { background: #D1FAE5; color: #065F46; }
    .status-rugi   { background: #FEE2E2; color: #991B1B; }
    .status-impas  { background: #F3F4F6; color: #6B7280; }
    /* ── NOI Banner ──────────────────────────────────────── */
    .noi-banner {
        background: linear-gradient(135deg,var(--primary),var(--primary-light));
        color: white; border-radius: 10px; padding: 1.2rem 1.8rem;
        display: flex; justify-content: space-between; align-items: center;
        margin-top: 1rem; flex-wrap: wrap; gap: .75rem;
    }
    .noi-banner .noi-label { font-size: .83rem; font-weight: 600; opacity: .85; text-transform: uppercase; letter-spacing: .05em; }
    .noi-banner .noi-value { font-size: 1.6rem; font-weight: 800; }
    .noi-formula { font-size: .78rem; opacity: .75; margin-top: .2rem; }
    /* Info card inside labarugi tab */
    .info-card {
        background: var(--bg-light); border: 1px solid var(--border);
        border-radius: 10px; overflow: hidden; margin-bottom: 1rem;
    }
    .info-card-head { background: var(--primary); color: white; padding: .7rem 1.2rem; font-weight: 600; font-size: .9rem; }
    .info-card-body { padding: 1rem 1.2rem; }
    .info-item { display: flex; gap: .5rem; align-items: flex-start; margin-bottom: .45rem; font-size: .9rem; }
    .info-item:last-child { margin-bottom: 0; }
    .info-dot { color: #9CA3AF; margin-top: 3px; }
    .info-key { min-width: 130px; font-weight: 500; color: #374151; }
    .info-val { color: #1F2937; }
    /* Action button */
    .btn-dl {
        background: var(--primary); color: white; font-weight: 600;
        border-radius: 8px; padding: .55rem 1.3rem; border: none;
        display: inline-flex; align-items: center; gap: .4rem;
        transition: all .2s; font-size: .88rem; text-decoration: none;
    }
    .btn-dl:hover { background: var(--primary-dark); color: white; text-decoration: none; }
    .btn-back {
        background: #F3F4F6; color: #6B7280; font-weight: 600;
        border-radius: 8px; padding: .55rem 1.3rem; border: 1px solid #E5E7EB;
        display: inline-flex; align-items: center; gap: .4rem;
        transition: all .2s; font-size: .88rem; text-decoration: none;
    }
    .btn-back:hover { background: #E5E7EB; color: #374151; text-decoration: none; }
    .math-block {
        text-align: center;
        margin: 10px 0;
        font-size: 16px;
    }
    .bep-table-grid {
        border-collapse: collapse !important;
        border: 1.5px solid #cbd5e1 !important;
    }
    .bep-table-grid th, .bep-table-grid td {
        border: 1.5px solid #cbd5e1 !important;
        padding: 1rem !important;
    }
    /* Keterangan Cards */
    .desc-card {
        background: white; border: 1px solid var(--border);
        border-radius: 10px; box-shadow: var(--card-shadow);
        overflow: hidden; height: fit-content; margin-bottom: 1.25rem;
    }
    .desc-card-header {
        background: var(--primary-pale); color: var(--primary-dark);
        padding: .75rem 1.25rem; font-weight: 700; font-size: .88rem;
        border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: .45rem;
    }
    .desc-card-body { padding: 1.1rem 1.25rem; }
    .desc-item { margin-bottom: 0.8rem; }
    .desc-item:last-child { margin-bottom: 0; }
    .desc-title { font-size: .82rem; font-weight: 700; color: var(--primary); margin-bottom: .15rem; display: flex; align-items: center; gap: .35rem; }
    .desc-text { font-size: .8rem; color: #4B5563; line-height: 1.45; }
</style>
<div class="rpt-wrap container-fluid px-0">
@if (Session::has('success'))
    <div class="alert alert-success mb-3" style="border-left:4px solid var(--primary);border-radius:8px;">{{ Session::get('success') }}</div>
@endif
@php
    $infoTanam   = $biayaProduksi['tanam'] ?? [];
    $ringkasan   = $biayaProduksi['ringkasan'] ?? [];
    $detailBiaya = $biayaProduksi['detail_biaya'] ?? [];
    $margin      = $marginKontribusi['nilai'] ?? [];
    $fixItems    = $marginKontribusi['beban_fix_items'] ?? [];
    $kodeTanam   = $infoTanam['kode_tanam'] ?? $tanam->kode_tanam;
    $volume      = $infoTanam['volume'] ?? 0;
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
    $bepRupiah   = $margin['bep_rupiah'] ?? 0;
    $bepUnit     = $margin['bep_unit'] ?? 0;
    $status      = $margin['status'] ?? 'Impas';
    $cmrDecimal = $pendapatan > 0 ? 1 - ($biayaVar / $pendapatan) : 0;
    $cmrPercent = $cmrDecimal * 100;
@endphp
{{-- ── HERO HEADER ─────────────────────────────────────── --}}
<div class="rpt-hero">
    <div>
        <h1>Laporan Usaha Tani</h1>
        <p>Kode Tanam: <strong>{{ $kodeTanam }}</strong> &nbsp;·&nbsp; {{ $infoTanam['komoditas'] ?? '-' }} &nbsp;·&nbsp; {{ $infoTanam['petani'] ?? '-' }}</p>
    </div>
    <div class="rpt-export-btns">
        <a href="{{ route('laporan.preview', request('tanam_id') ?? $tanam->id_tanam) }}" target="_blank" class="btn-export btn-pdf">
            <i class="fas fa-file-pdf"></i> Download PDF
        </a>
        <a href="{{ route('laporan.index') }}" class="btn-export">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>
{{-- ── METRIC CARDS ─────────────────────────────────────── --}}
<div class="metric-grid">
    <div class="metric-card">
        <div class="metric-icon" style="background:#EBF9F1; color:#059669; font-size:1.4rem; font-weight:800;">Rp</div>
        <div>
            <div class="m-label">Pendapatan</div>
            <div class="m-value">Rp {{ number_format($pendapatan, 0, ',', '.') }}</div>
            <div class="m-sub">Total penjualan hasil panen</div>
        </div>
    </div>
    <div class="metric-card">
        <div class="metric-icon" style="background:#FEF3C7; color:#D97706; font-size:1.4rem; font-weight:800;">Rp</div>
        <div>
            <div class="m-label">Total Biaya</div>
            <div class="m-value">Rp {{ number_format($totalBiaya, 0, ',', '.') }}</div>
            <div class="m-sub">Variabel + tetap</div>
        </div>
    </div>
    <div class="metric-card">
        <div class="metric-icon" style="background:{{ $laba >= 0 ? '#EBF9F1' : '#FEE2E2' }}; color:{{ $laba >= 0 ? '#059669' : '#DC2626' }}; font-size:1rem; font-weight:800;">{{ $laba >= 0 ? '+' : '−' }}</div>
        <div>
            <div class="m-label">Laba Bersih</div>
            <div class="m-value" style="color:{{ $laba >= 0 ? '#059669' : '#DC2626' }};">Rp {{ number_format($laba, 0, ',', '.') }}</div>
            <div class="m-sub">Net Operating Income</div>
        </div>
    </div>
    <div class="metric-card">
        <div class="metric-icon" style="background:#EDE9FE; color:#7C3AED; font-size:1rem; font-weight:800;">BEP</div>
        <div>
            <div class="m-label">BEP Penjualan</div>
            <div class="m-value">Rp {{ number_format($bepRupiah, 0, ',', '.') }}</div>
            <div class="m-sub">Break Even Point Rupiah</div>
        </div>
    </div>
</div>
{{-- ── TAB NAVIGATION ───────────────────────────────────── --}}
<div class="rpt-tabs" id="rptTabNav">
    <button class="rpt-tab active" id="tab-produksi" onclick="switchTab('produksi')">
        Laporan Biaya Produksi
    </button>
    <button class="rpt-tab" id="tab-labarugi" onclick="switchTab('labarugi')">
        Laporan Laba Rugi
    </button>
    <button class="rpt-tab" id="tab-bep" onclick="switchTab('bep')">
        Analisis BEP
    </button>
</div>
{{-- ══════════════════════════════════════════════════════ --}}
{{-- TAB 1 — LAPORAN BIAYA PRODUKSI                         --}}
{{-- ══════════════════════════════════════════════════════ --}}
<div id="pane-produksi">
    {{-- Info Card --}}
    <div class="info-card mb-3">
        <div class="info-card-head">Informasi Usaha Tani</div>
        <div class="info-card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="info-item"><span class="info-dot">●</span><span class="info-key">Kode Tanam</span><span class="info-val">: {{ $kodeTanam }}</span></div>
                    <div class="info-item"><span class="info-dot">●</span><span class="info-key">Komoditas</span><span class="info-val">: {{ number_format($infoTanam['volume'] ?? 0, 0, ',', '.') }} {{ $infoTanam['satuan'] ?? 'Kg' }} {{ $infoTanam['komoditas'] ?? '-' }}</span></div>
                </div>
                <div class="col-md-6">
                    <div class="info-item"><span class="info-dot">●</span><span class="info-key">Petani</span><span class="info-val">: {{ $infoTanam['petani'] ?? '-' }}</span></div>
                    <div class="info-item"><span class="info-dot">●</span><span class="info-key">Tgl Tanam</span><span class="info-val">: {{ $tanam->tgl_tanam?->format('d-m-Y') ?? '-' }}</span></div>
                    <div class="info-item"><span class="info-dot">●</span><span class="info-key">Tgl Panen</span><span class="info-val">: {{ $tanam->tgl_panen?->format('d-m-Y') ?? '-' }}</span></div>
                </div>
            </div>
        </div>
    </div>
    {{-- Cost Summary Table --}}
    <div class="row">
        <div class="col-lg-8 col-md-7 mb-3 mb-md-0">
            <div class="rpt-card mb-0">
                <div class="rpt-card-header">
                    <i class="fas fa-chart-pie mr-2"></i> Ringkasan Biaya Produksi
                </div>
                <div class="table-responsive">
                    <table class="rpt-table">
                        <thead>
                            <tr>
                                <th>KOMPONEN BIAYA</th>
                                <th class="text-right" style="width: 25%;">JUMLAH (RP)</th>
                                <th class="text-center" style="width: 15%;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Biaya Bahan Baku (BBB)</td>
                                <td class="text-right font-weight-bold">Rp {{ number_format($bbbSub, 0, ',', '.') }}</td>
                                <td class="text-center text-muted">{{ $ringkasan['total_biaya'] > 0 ? number_format($bbbSub / $ringkasan['total_biaya'] * 100, 1) . '%' : '-' }}</td>
                            </tr>
                            <tr>
                                <td>Biaya Tenaga Kerja Langsung (BTKL)</td>
                                <td class="text-right font-weight-bold">Rp {{ number_format($btklSub, 0, ',', '.') }}</td>
                                <td class="text-center text-muted">{{ $ringkasan['total_biaya'] > 0 ? number_format($btklSub / $ringkasan['total_biaya'] * 100, 1) . '%' : '-' }}</td>
                            </tr>
                            <tr>
                                <td>Biaya Overhead Produksi (BOP)</td>
                                <td class="text-right font-weight-bold">Rp {{ number_format($bopSub, 0, ',', '.') }}</td>
                                <td class="text-center text-muted">{{ $ringkasan['total_biaya'] > 0 ? number_format($bopSub / $ringkasan['total_biaya'] * 100, 1) . '%' : '-' }}</td>
                            </tr>
                            <tr style="background-color: var(--primary); color: white; font-weight: bold; font-size: 1rem;">
                                <td style="color: white;">TOTAL BIAYA PRODUKSI</td>
                                <td class="text-right" style="color: white;">Rp {{ number_format($ringkasan['total_biaya'] ?? 0, 0, ',', '.') }}</td>
                                <td class="text-center" style="color: white;">100%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-5">
            <div class="desc-card mb-0">
                <div class="desc-card-header">
                    <i class="fas fa-info-circle"></i> Keterangan Komponen Biaya
                </div>
                <div class="desc-card-body">
                    <div class="desc-item">
                        <div class="desc-title"><i class="fas fa-chevron-right text-success" style="font-size:0.65rem; margin-top:2px;"></i> BBB (Biaya Bahan Baku)</div>
                        <div class="desc-text">BBB adalah biaya untuk bahan utama yang dipakai saat menanam atau merawat tanaman, seperti benih, pupuk, atau obat tanaman.</div>
                    </div>
                    <div class="desc-item">
                        <div class="desc-title"><i class="fas fa-chevron-right text-success" style="font-size:0.65rem; margin-top:2px;"></i> BTKL (Biaya Tenaga Kerja Langsung)</div>
                        <div class="desc-text">BTKL adalah biaya upah untuk orang yang membantu langsung saat menanam, merawat, atau memanen.</div>
                    </div>
                    <div class="desc-item">
                        <div class="desc-title"><i class="fas fa-chevron-right text-success" style="font-size:0.65rem; margin-top:2px;"></i> BOP (Biaya Overhead Produksi)</div>
                        <div class="desc-text">BOP adalah biaya pendukung selama proses tanam sampai panen, di luar bahan utama and upah tenaga kerja langsung, seperti sewa alat, bahan bakar, atau biaya alat pendukung lainnya.</div>
                    </div>
                    <div class="desc-item">
                        <div class="desc-title"><i class="fas fa-chevron-right text-success" style="font-size:0.65rem; margin-top:2px;"></i> Total Biaya Produksi</div>
                        <div class="desc-text">Total biaya produksi adalah jumlah seluruh biaya yang dikeluarkan selama proses tanam sampai panen.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div style="margin-bottom: 1.25rem;"></div>

    {{-- Expandable: BBB --}}
    <div class="rpt-card">
        <button class="collapse-toggle" type="button" data-toggle="collapse" data-target="#detail-bbb" aria-expanded="false">
            <span>Rincian Biaya Bahan Baku</span>
            <span>&#8964;</span>
        </button>
        <div class="collapse" id="detail-bbb">
            <div class="table-responsive">
                <table class="rpt-table">
                    <thead>
                        <tr>
                            <th>KODE BEBAN</th>
                            <th>NAMA BEBAN</th>
                            <th class="text-center">JUMLAH</th>
                            <th class="text-right">HARGA</th>
                            <th class="text-right">TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bbbItems as $item)
                            <tr>
                                <td>{{ $item['kode_beban'] ?? '-' }}</td>
                                <td>{{ $item['nama_beban'] }}</td>
                                <td class="text-center">{{ number_format($item['jumlah'] ?? 0, 0, ',', '.') }}</td>
                                <td class="text-right">Rp {{ number_format($item['harga'] ?? 0, 0, ',', '.') }}</td>
                                <td class="text-right font-weight-bold">Rp {{ number_format($item['total'] ?? 0, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">Tidak ada rincian biaya bahan baku.</td>
                            </tr>
                        @endforelse
                        <tr style="background-color: var(--primary-pale); font-weight: bold; color: var(--primary);">
                            <td colspan="4" style="color: var(--primary);">Subtotal BBB</td>
                            <td class="text-right" style="color: var(--primary);">Rp {{ number_format($bbbSub, 0, ',', '.') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Expandable: BTKL --}}
    <div class="rpt-card">
        <button class="collapse-toggle" type="button" data-toggle="collapse" data-target="#detail-btkl" aria-expanded="false">
            <span>Rincian Biaya Tenaga Kerja Langsung</span>
            <span>&#8964;</span>
        </button>
        <div class="collapse" id="detail-btkl">
            <div class="table-responsive">
                <table class="rpt-table">
                    <thead>
                        <tr>
                            <th>KODE BEBAN</th>
                            <th>NAMA BEBAN</th>
                            <th class="text-center">JUMLAH</th>
                            <th class="text-right">HARGA</th>
                            <th class="text-right">TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($btklItems as $item)
                            <tr>
                                <td>{{ $item['kode_beban'] ?? '-' }}</td>
                                <td>{{ $item['nama_beban'] }}</td>
                                <td class="text-center">{{ number_format($item['jumlah'] ?? 0, 0, ',', '.') }}</td>
                                <td class="text-right">Rp {{ number_format($item['harga'] ?? 0, 0, ',', '.') }}</td>
                                <td class="text-right font-weight-bold">Rp {{ number_format($item['total'] ?? 0, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">Tidak ada rincian biaya tenaga kerja langsung.</td>
                            </tr>
                        @endforelse
                        <tr style="background-color: var(--primary-pale); font-weight: bold; color: var(--primary);">
                            <td colspan="4" style="color: var(--primary);">Subtotal BTKL</td>
                            <td class="text-right" style="color: var(--primary);">Rp {{ number_format($btklSub, 0, ',', '.') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Expandable: BOP --}}
    <div class="rpt-card">
        <button class="collapse-toggle" type="button" data-toggle="collapse" data-target="#detail-bop" aria-expanded="false">
            <span>Rincian Biaya Overhead Produksi</span>
            <span>&#8964;</span>
        </button>
        <div class="collapse" id="detail-bop">
            <div class="table-responsive">
                <table class="rpt-table">
                    <thead>
                        <tr>
                            <th>KODE BEBAN</th>
                            <th>NAMA BEBAN</th>
                            <th class="text-center">JUMLAH</th>
                            <th class="text-right">HARGA</th>
                            <th class="text-right">TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bopItems as $item)
                            <tr>
                                <td>{{ $item['kode_beban'] ?? '-' }}</td>
                                <td>{{ $item['nama_beban'] }}</td>
                                <td class="text-center">{{ number_format($item['jumlah'] ?? 0, 0, ',', '.') }}</td>
                                <td class="text-right">Rp {{ number_format($item['harga'] ?? 0, 0, ',', '.') }}</td>
                                <td class="text-right font-weight-bold">Rp {{ number_format($item['total'] ?? 0, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">Tidak ada rincian biaya overhead produksi.</td>
                            </tr>
                        @endforelse
                        <tr style="background-color: var(--primary-pale); font-weight: bold; color: var(--primary);">
                            <td colspan="4" style="color: var(--primary);">Subtotal BOP</td>
                            <td class="text-right" style="color: var(--primary);">Rp {{ number_format($bopSub, 0, ',', '.') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-end gap-2 mt-1 mb-3">
        <a href="{{ route('laporan.index') }}" class="btn-back">Kembali</a>
    </div>
</div>
{{-- ══════════════════════════════════════════════════════ --}}
{{-- TAB 2 — LAPORAN LABA RUGI                              --}}
{{-- ══════════════════════════════════════════════════════ --}}
<div id="pane-labarugi" style="display:none;">
    {{-- Info Card --}}
    <div class="info-card mb-3">
        <div class="info-card-head">Informasi Usaha Tani</div>
        <div class="info-card-body">
            <div class="row">
                <div class="col-md-5">
                    <div class="info-item"><span class="info-dot">●</span><span class="info-key">Kode Tanam</span><span class="info-val">: {{ $kodeTanam }}</span></div>
                    <div class="info-item"><span class="info-dot">●</span><span class="info-key">Petani</span><span class="info-val">: {{ $infoTanam['petani'] ?? '-' }}</span></div>
                </div>
                <div class="col-md-7">
                    <div class="info-item"><span class="info-dot">●</span><span class="info-key">Komoditas</span><span class="info-val">: {{ number_format($infoTanam['volume'] ?? 0, 0, ',', '.') }} {{ $infoTanam['satuan'] ?? 'Kg' }} {{ $infoTanam['komoditas'] ?? '' }}</span></div>
                    <div class="info-item"><span class="info-dot">●</span><span class="info-key">Tanggal Tanam</span><span class="info-val">: {{ $tanam->tgl_tanam?->format('d-m-Y') ?? '-' }}</span></div>
                    <div class="info-item"><span class="info-dot">●</span><span class="info-key">Tanggal Panen</span><span class="info-val">: {{ $tanam->tgl_panen?->format('d-m-Y') ?? '-' }}</span></div>
                </div>
            </div>
        </div>
    </div>
    {{-- P&L Table & Keterangan --}}
    <div class="row">
        <div class="col-lg-8 col-md-7 mb-3">
            <div class="rpt-card mb-3">
                <div class="rpt-card-header">
                    <i class="fas fa-balance-scale mr-2"></i> Laporan Laba Rugi / Margin Kontribusi
                </div>
                <div class="table-responsive">
                    <table class="rpt-table">
                        <thead>
                            <tr>
                                <th>KETERANGAN</th>
                                <th class="text-right" style="width: 25%;"></th>
                                <th class="text-right" style="width: 25%;">JUMLAH (RP)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- PENDAPATAN -->
                            <tr style="background-color: #F4F7F6; font-weight: bold; border-top: 1.5px solid var(--border);">
                                <td colspan="3">PENDAPATAN</td>
                            </tr>
                            <tr>
                                <td style="padding-left: 2rem;">Penjualan Hasil Panen (Rp {{ number_format($margin['harga_per_unit'] ?? 0, 0, ',', '.') }} / {{ $infoTanam['satuan'] ?? 'Kg' }})</td>
                                <td class="text-right">Rp {{ number_format($pendapatan, 0, ',', '.') }}</td>
                                <td></td>
                            </tr>
                            <tr style="background-color: #D4EDDA; font-weight: bold;">
                                <td style="color: #155724;">Total Pendapatan</td>
                                <td></td>
                                <td class="text-right" style="color: #155724;">Rp {{ number_format($pendapatan, 0, ',', '.') }}</td>
                            </tr>
                            <tr class="row-formula">
                                <td colspan="3" class="text-muted" style="font-size: 0.8rem; font-style: italic; padding-left: 2rem;">Total Pendapatan = Harga Jual × Jumlah Produksi</td>
                            </tr>

                            <!-- BIAYA VARIABEL -->
                            <tr style="background-color: #F4F7F6; font-weight: bold; border-top: 1.5px solid var(--border);">
                                <td colspan="3" class="text-success" style="color: #155724 !important;">BIAYA VARIABEL (VARIABLE COST)</td>
                            </tr>
                            @forelse($biayaVariabelItems as $item)
                                <tr>
                                    <td style="padding-left: 2rem;">{{ $item['nama'] ?? '-' }}</td>
                                    <td class="text-right">Rp {{ number_format($item['total'] ?? 0, 0, ',', '.') }}</td>
                                    <td></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted" style="font-size: 0.85rem; font-style: italic;">Tidak ada data biaya variabel.</td>
                                </tr>
                            @endforelse
                            <tr style="background-color: #D4EDDA; font-weight: bold;">
                                <td style="color: #155724;">Total Biaya Variabel</td>
                                <td></td>
                                <td class="text-right" style="color: #155724;">Rp {{ number_format($biayaVar, 0, ',', '.') }}</td>
                            </tr>
                            <tr class="row-formula">
                                <td colspan="3" class="text-muted" style="font-size: 0.8rem; font-style: italic; padding-left: 2rem;">Total Biaya Variabel = Σ Biaya Variabel</td>
                            </tr>

                            <!-- MARGIN KONTRIBUSI -->
                            <tr style="background-color: #C3E6CB; font-weight: bold; font-size: 1rem; border-top: 1.5px solid var(--border);">
                                <td style="color: #155724;">MARGIN KONTRIBUSI</td>
                                <td></td>
                                <td class="text-right" style="color: #155724;">Rp {{ number_format($marginTotal, 0, ',', '.') }}</td>
                            </tr>
                            <tr class="row-formula">
                                <td colspan="3" class="text-muted" style="font-size: 0.8rem; font-style: italic; padding-left: 2rem;">Margin Kontribusi = Total Pendapatan − Total Biaya Variabel</td>
                            </tr>

                            <!-- BIAYA TETAP -->
                            <tr style="background-color: #F4F7F6; font-weight: bold; border-top: 1.5px solid var(--border);">
                                <td colspan="3" class="text-warning" style="color: #856404 !important;">BIAYA TETAP (FIXED COST)</td>
                            </tr>
                            @forelse($biayaTetapItems as $item)
                                <tr>
                                    <td style="padding-left: 2rem;">{{ $item['nama'] ?? '-' }}</td>
                                    <td class="text-right">Rp {{ number_format($item['total'] ?? 0, 0, ',', '.') }}</td>
                                    <td></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted" style="font-size: 0.85rem; font-style: italic;">Tidak ada data biaya tetap.</td>
                                </tr>
                            @endforelse
                            <tr style="background-color: #D4EDDA; font-weight: bold;">
                                <td style="color: #155724;">Total Biaya Tetap</td>
                                <td></td>
                                <td class="text-right" style="color: #155724;">Rp {{ number_format($biayaTetap, 0, ',', '.') }}</td>
                            </tr>
                            <tr class="row-formula">
                                <td colspan="3" class="text-muted" style="font-size: 0.8rem; font-style: italic; padding-left: 2rem;">Total Biaya Tetap = Σ Biaya Tetap</td>
                            </tr>

                            <!-- LABA BERSIH -->
                            <tr style="background-color: var(--primary); color: white; font-weight: bold; font-size: 1rem; border-top: 1.5px solid var(--border);">
                                <td style="color: white;">KEUNTUNGAN BERSIH (NET OPERATING INCOME)</td>
                                <td></td>
                                <td class="text-right" style="color: white;">Rp {{ number_format($laba, 0, ',', '.') }}</td>
                            </tr>
                            <tr class="row-formula">
                                <td colspan="3" class="text-muted" style="font-size: 0.8rem; font-style: italic; padding-left: 2rem;">Net Operating Income = Margin Kontribusi − Total Biaya Tetap</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            {{-- NOI Banner --}}
            <div style="padding: 1.2rem 1.4rem; background: #fff; border-radius: 10px; border: 1px solid var(--border); box-shadow: var(--card-shadow); margin-top: -0.5rem; margin-bottom: 1.5rem;">
                <div class="noi-banner">
                    <div>
                        <div class="noi-label">Net Operating Income</div>
                        <div class="noi-value">Rp {{ number_format($laba, 0, ',', '.') }}</div>
                        <div class="noi-formula">= Margin Kontribusi − Total Biaya Tetap</div>
                    </div>
                    <div>
                        @if($laba > 0)
                            <span class="status-badge status-untung">UNTUNG</span>
                        @elseif($laba < 0)
                            <span class="status-badge status-rugi">RUGI</span>
                        @else
                            <span class="status-badge status-impas">IMPAS</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-5 mb-3">
            <div class="desc-card">
                <div class="desc-card-header">
                    <i class="fas fa-info-circle"></i> Keterangan Laporan Laba Rugi
                </div>
                <div class="desc-card-body">
                    <div class="desc-item">
                        <div class="desc-title"><i class="fas fa-chevron-right text-success" style="font-size:0.65rem; margin-top:2px;"></i> Pendapatan</div>
                        <div class="desc-text">Pendapatan adalah uang yang diperoleh dari hasil penjualan panen.</div>
                    </div>
                    <div class="desc-item">
                        <div class="desc-title"><i class="fas fa-chevron-right text-success" style="font-size:0.65rem; margin-top:2px;"></i> Biaya Variabel</div>
                        <div class="desc-text">Biaya variabel adalah biaya yang jumlahnya bisa berubah sesuai kebutuhan selama proses tanam sampai panen, seperti benih, pupuk, obat tanaman, bahan bakar, atau upah kerja yang mengikuti banyaknya pekerjaan.</div>
                    </div>
                    <div class="desc-item">
                        <div class="desc-title"><i class="fas fa-chevron-right text-success" style="font-size:0.65rem; margin-top:2px;"></i> Margin Kontribusi</div>
                        <div class="desc-text">Margin kontribusi adalah uang yang masih tersisa dari pendapatan setelah biaya variabel dibayar. Uang ini digunakan untuk membantu menutup biaya tetap.</div>
                    </div>
                    <div class="desc-item">
                        <div class="desc-title"><i class="fas fa-chevron-right text-success" style="font-size:0.65rem; margin-top:2px;"></i> Biaya Tetap</div>
                        <div class="desc-text">Biaya tetap adalah biaya yang tetap harus dikeluarkan meskipun hasil panen banyak atau sedikit. Contohnya pajak tanah, sewa lahan, atau biaya lain yang tetap menjadi kewajiban selama periode tanam.</div>
                    </div>
                    <div class="desc-item">
                        <div class="desc-title"><i class="fas fa-chevron-right text-success" style="font-size:0.65rem; margin-top:2px;"></i> Keuntungan Bersih / Net Operating Income</div>
                        <div class="desc-text">Keuntungan bersih adalah hasil akhir setelah pendapatan dikurangi seluruh biaya yang dihitung. Jika nilainya positif berarti untung, sedangkan jika nilainya negatif berarti rugi.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-end gap-2 mt-1 mb-3">
        <a href="{{ route('laporan.index') }}" class="btn-back">Kembali</a>
    </div>
</div>
{{-- ══════════════════════════════════════════════════════ --}}
{{-- TAB 3 — ANALISIS BEP                                   --}}
{{-- ══════════════════════════════════════════════════════ --}}
<div id="pane-bep" style="display:none;">
    <div class="row">
        <div class="col-lg-8 col-md-7">
            <!-- CMR Card -->
            <div class="mb-4">
                <h5 class="font-weight-bold mb-2 text-dark" style="font-size: 1.05rem;">Contribution Margin Ratio (CMR):</h5>
                <div class="rpt-card mb-3">
                    <div class="table-responsive">
                        <table class="bep-table-grid text-center" style="table-layout: fixed; width: 100%;">
                            <thead>
                                <tr style="background-color: #F4F7F6;">
                                    <th class="text-center" style="width: 30%;">Variable Cost (VC)</th>
                                    <th class="text-center" style="width: 30%;">Sales</th>
                                    <th class="text-center" style="width: 40%;">CMR</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center" style="vertical-align: middle; font-size: 1rem;">Rp {{ number_format($biayaVar, 0, ',', '.') }}</td>
                                    <td class="text-center" style="vertical-align: middle; font-size: 1rem;">Rp {{ number_format($pendapatan, 0, ',', '.') }}</td>
                                    <td class="text-left" style="vertical-align: middle; padding: 1.2rem;">
                                        <div class="math-block">
                                            <strong>CMR = 1 - <div class="d-inline-block text-center" style="vertical-align: middle;"><div style="border-bottom: 1px solid #374151; padding: 0 4px;">VC</div><div>Sales</div></div></strong><br>
                                            <div style="margin-top: 8px;">
                                                = 1 - <div class="d-inline-block text-center" style="vertical-align: middle;"><div style="border-bottom: 1px solid #374151; padding: 0 4px;">Rp {{ number_format($biayaVar, 0, ',', '.') }}</div><div>Rp {{ number_format($pendapatan, 0, ',', '.') }}</div></div>
                                            </div>
                                            <div style="margin-top: 8px; font-size: 1.1rem; color: var(--primary);">
                                                = <strong>{{ number_format($cmrPercent, 2, ',', '.') }}%</strong>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- BEP Sales Card -->
            <div class="mb-4">
                <h5 class="font-weight-bold mb-2 text-dark" style="font-size: 1.05rem;">BEP Sales :</h5>
                <div class="rpt-card mb-3">
                    <div class="table-responsive">
                        <table class="bep-table-grid text-center" style="table-layout: fixed; width: 100%;">
                            <thead>
                                <tr style="background-color: #F4F7F6;">
                                    <th class="text-center" style="width: 30%;">Biaya Tetap</th>
                                    <th class="text-center" style="width: 30%;">CMR</th>
                                    <th class="text-center" style="width: 40%;">BEP Sales</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center" style="vertical-align: middle; font-size: 1rem;">Rp {{ number_format($biayaTetap, 0, ',', '.') }}</td>
                                    <td class="text-center" style="vertical-align: middle; font-size: 1rem;">{{ number_format($cmrPercent, 2, ',', '.') }}%</td>
                                    <td class="text-left" style="vertical-align: middle; padding: 1.2rem;">
                                        <div class="math-block">
                                            <strong>BEP Sales = <div class="d-inline-block text-center" style="vertical-align: middle;"><div style="border-bottom: 1px solid #374151; padding: 0 4px;">Biaya Tetap</div><div>CMR</div></div></strong><br>
                                            <div style="margin-top: 8px;">
                                                = <div class="d-inline-block text-center" style="vertical-align: middle;"><div style="border-bottom: 1px solid #374151; padding: 0 4px;">Rp {{ number_format($biayaTetap, 0, ',', '.') }}</div><div>{{ number_format($cmrPercent, 2, ',', '.') }}%</div></div>
                                            </div>
                                            <div style="margin-top: 8px; font-size: 1.1rem; color: var(--primary);">
                                                = <strong>Rp {{ number_format($bepRupiah, 0, ',', '.') }}</strong>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- CMPU Card -->
            <div class="mb-4">
                <h5 class="font-weight-bold mb-2 text-dark" style="font-size: 1.05rem;">Contribution Margin Per Unit (CMPU):</h5>
                <div class="rpt-card mb-3">
                    <div class="table-responsive">
                        <table class="bep-table-grid text-center" style="table-layout: fixed; width: 100%;">
                            <thead>
                                <tr style="background-color: #F4F7F6;">
                                    <th class="text-center" style="width: 30%;">Harga Jual Per Unit (HJU)</th>
                                    <th class="text-center" style="width: 30%;">Biaya Variable Per Unit (VCU)</th>
                                    <th class="text-center" style="width: 40%;">CMPU</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center" style="vertical-align: middle; font-size: 1rem;">Rp {{ number_format($margin['harga_per_unit'] ?? 0, 0, ',', '.') }}</td>
                                    <td class="text-left" style="vertical-align: middle; padding: 1.2rem;">
                                        <div class="math-block">
                                            <strong>VCU = <div class="d-inline-block text-center" style="vertical-align: middle;"><div style="border-bottom: 1px solid #374151; padding: 0 4px;">Rp {{ number_format($biayaVar, 0, ',', '.') }}</div><div>{{ number_format($volume, 0, ',', '.') }} {{ $infoTanam['satuan'] ?? 'Kg' }}</div></div></strong><br>
                                            <div style="margin-top: 8px; font-size: 1.05rem; color: var(--primary);">
                                                = <strong>Rp {{ number_format($margin['biaya_variabel_unit'] ?? 0, 0, ',', '.') }}</strong>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-left" style="vertical-align: middle; padding: 1.2rem;">
                                        <div class="math-block">
                                            <strong>CMPU = HJU - VCU</strong><br>
                                            <div style="margin-top: 8px;">
                                                = Rp {{ number_format($margin['harga_per_unit'] ?? 0, 0, ',', '.') }} - Rp {{ number_format($margin['biaya_variabel_unit'] ?? 0, 0, ',', '.') }}
                                            </div>
                                            <div style="margin-top: 8px; font-size: 1.1rem; color: var(--primary);">
                                                = <strong>Rp {{ number_format($margin['margin_per_unit'] ?? 0, 0, ',', '.') }}</strong>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- BEP Unit Card -->
            <div class="mb-4">
                <h5 class="font-weight-bold mb-2 text-dark" style="font-size: 1.05rem;">BEP Unit :</h5>
                <div class="rpt-card mb-3">
                    <div class="table-responsive">
                        <table class="bep-table-grid text-center" style="table-layout: fixed; width: 100%;">
                            <thead>
                                <tr style="background-color: #F4F7F6;">
                                    <th class="text-center" style="width: 30%;">Biaya Tetap</th>
                                    <th class="text-center" style="width: 30%;">Variable Cost</th>
                                    <th class="text-center" style="width: 40%;">BEP Unit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center" style="vertical-align: middle; font-size: 1rem;">Rp {{ number_format($biayaTetap, 0, ',', '.') }}</td>
                                    <td class="text-center" style="vertical-align: middle; font-size: 1rem;">Rp {{ number_format($margin['margin_per_unit'] ?? 0, 0, ',', '.') }}</td>
                                    <td class="text-left" style="vertical-align: middle; padding: 1.2rem;">
                                        <div class="math-block">
                                            <strong>BEP Unit = <div class="d-inline-block text-center" style="vertical-align: middle;"><div style="border-bottom: 1px solid #374151; padding: 0 4px;">Biaya Tetap</div><div>CMPU</div></div></strong><br>
                                            <div style="margin-top: 8px;">
                                                = <div class="d-inline-block text-center" style="vertical-align: middle;"><div style="border-bottom: 1px solid #374151; padding: 0 4px;">Rp {{ number_format($biayaTetap, 0, ',', '.') }}</div><div>Rp {{ number_format($margin['margin_per_unit'] ?? 0, 0, ',', '.') }}</div></div>
                                            </div>
                                            <div style="margin-top: 8px; font-size: 1.1rem; color: var(--primary);">
                                                = <strong>{{ number_format($bepUnit, 0, ',', '.') }} {{ $infoTanam['satuan'] ?? 'Kg' }}</strong>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-5 mb-4">
            <div class="desc-card">
                <div class="desc-card-header">
                    <i class="fas fa-info-circle"></i> Keterangan Analisis BEP
                </div>
                <div class="desc-card-body">
                    <div class="desc-item">
                        <div class="desc-title"><i class="fas fa-chevron-right text-success" style="font-size:0.65rem; margin-top:2px;"></i> CMR (Contribution Margin Ratio)</div>
                        <div class="desc-text">CMR adalah persentase dari penjualan yang dapat digunakan untuk membantu menutup biaya tetap, sehingga dapat diketahui apakah penjualan sudah cukup untuk mencapai titik impas atau belum.</div>
                    </div>
                    <div class="desc-item">
                        <div class="desc-title"><i class="fas fa-chevron-right text-success" style="font-size:0.65rem; margin-top:2px;"></i> BEP Sales</div>
                        <div class="desc-text">BEP Sales adalah nilai penjualan minimal dalam rupiah yang harus dicapai agar tidak mengalami rugi.</div>
                    </div>
                    <div class="desc-item">
                        <div class="desc-title"><i class="fas fa-chevron-right text-success" style="font-size:0.65rem; margin-top:2px;"></i> CMPU (Contribution Margin Per Unit)</div>
                        <div class="desc-text">CMPU adalah uang yang masih tersisa dari setiap satuan hasil panen setelah biaya variabel per satuan dihitung. Nilai ini membantu mengetahui berapa bagian dari setiap satuan penjualan yang dapat digunakan untuk menutup biaya tetap.</div>
                    </div>
                    <div class="desc-item">
                        <div class="desc-title"><i class="fas fa-chevron-right text-success" style="font-size:0.65rem; margin-top:2px;"></i> BEP Unit</div>
                        <div class="desc-text">BEP Unit adalah jumlah hasil panen minimal yang harus dijual agar tidak mengalami rugi.</div>
                    </div>
                    <div class="desc-item">
                        <div class="desc-title"><i class="fas fa-chevron-right text-success" style="font-size:0.65rem; margin-top:2px;"></i> HJU (Harga Jual Per Unit)</div>
                        <div class="desc-text">HJU adalah harga jual untuk setiap satuan hasil panen, misalnya harga per kilogram.</div>
                    </div>
                    <div class="desc-item">
                        <div class="desc-title"><i class="fas fa-chevron-right text-success" style="font-size:0.65rem; margin-top:2px;"></i> VCU (Biaya Variabel Per Unit)</div>
                        <div class="desc-text">VCU adalah rata-rata biaya variabel yang dikeluarkan untuk menghasilkan satu satuan hasil panen.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2 mt-3 mb-3">
        <a href="{{ route('laporan.index') }}" class="btn-back">Kembali</a>
    </div>
</div>
</div>{{-- /rpt-wrap --}}
<script>
function switchTab(name) {
    // Hide all panes
    ['produksi','labarugi','bep'].forEach(function(t) {
        document.getElementById('pane-' + t).style.display = 'none';
        document.getElementById('tab-' + t).classList.remove('active');
    });
    // Show selected
    document.getElementById('pane-' + name).style.display = 'block';
    document.getElementById('tab-' + name).classList.add('active');
    // Persist
    localStorage.setItem('rptActiveTab_{{ $kodeTanam }}', name);
}
document.addEventListener('DOMContentLoaded', function() {
    // Collapse toggle icon
    document.querySelectorAll('.collapse-toggle').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var expanded = this.getAttribute('aria-expanded') === 'true';
            this.setAttribute('aria-expanded', !expanded);
        });
    });
    // Restore tab
    var saved = localStorage.getItem('rptActiveTab_{{ $kodeTanam }}');
    if (saved) switchTab(saved);
    if (window.MathJax) {
        MathJax.typeset();
    }
});
</script>
@endsection