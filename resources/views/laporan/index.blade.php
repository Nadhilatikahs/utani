@extends('layouts.app')
@section('title', 'Laporan Usaha Tani')
@section('contents')
<style>
    :root {
        --primary: #1F6F54;
        --primary-light: #27916D;
        --primary-dark: #165242;
        --bg-light: #F4F7F6;
        --card-shadow: 0 2px 12px rgba(31,111,84,0.08);
    }
    .rpt-page { font-family: 'Inter', sans-serif; color: #1F2937; }
    /* Header */
    .rpt-header {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        border-radius: 12px;
        padding: 1.75rem 2rem;
        margin-bottom: 1.75rem;
        color: white;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .rpt-header h1 { font-size: 1.7rem; font-weight: 700; margin: 0 0 0.3rem; }
    .rpt-header p  { margin: 0; opacity: 0.85; font-size: 0.95rem; }
    /* Cards */
    .rpt-card {
        background: white;
        border-radius: 10px;
        box-shadow: var(--card-shadow);
        margin-bottom: 1.5rem;
        overflow: hidden;
        border: 1px solid #E5EDE9;
    }
    .rpt-card-header {
        background: var(--primary);
        color: white;
        padding: 0.9rem 1.5rem;
        font-weight: 600;
        font-size: 1rem;
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }
    .rpt-card-body { padding: 1.5rem; }
    /* Filter */
    .filter-label { font-weight: 600; color: #374151; margin-bottom: 0.4rem; display: block; font-size: 0.9rem; }
    .filter-select {
        display: block; width: 100%;
        padding: 0.65rem 1rem; font-size: 0.97rem;
        color: #374151; background: white;
        border: 1px solid #D1D5DB; border-radius: 8px;
        appearance: none; transition: border-color .15s, box-shadow .15s;
    }
    .filter-select:focus {
        border-color: var(--primary);
        outline: 0;
        box-shadow: 0 0 0 3px rgba(31,111,84,.15);
    }
    .btn-primary-rpt {
        background: var(--primary); color: white;
        font-weight: 600; border-radius: 8px;
        padding: 0.65rem 1.5rem; border: none;
        transition: all .2s; display: inline-flex;
        align-items: center; gap: 0.5rem; width: 100%;
        justify-content: center; font-size: 0.97rem;
        cursor: pointer;
    }
    .btn-primary-rpt:hover { background: var(--primary-dark); color: white; text-decoration: none; }
    .btn-outline-rpt {
        background: transparent; color: var(--primary);
        border: 1.5px solid var(--primary); font-weight: 600;
        border-radius: 8px; padding: 0.55rem 1.2rem;
        transition: all .2s; display: inline-flex;
        align-items: center; gap: 0.5rem; font-size: 0.9rem;
    }
    .btn-outline-rpt:hover { background: var(--primary); color: white; text-decoration: none; }
    /* Table */
    .rpt-table { width: 100%; margin-bottom: 0; border-collapse: collapse; }
    .rpt-table th {
        background: #F4F7F6; color: #374151;
        font-weight: 700; font-size: 0.78rem;
        text-transform: uppercase; letter-spacing: 0.05em;
        padding: 0.85rem 1.2rem; border-bottom: 2px solid #D1E8DC;
        white-space: nowrap;
    }
    .rpt-table th:first-child { border-radius: 0; }
    .rpt-table td {
        padding: 0.9rem 1.2rem;
        border-bottom: 1px solid #F0F5F2;
        vertical-align: middle;
        font-size: 0.93rem;
    }
    .rpt-table tbody tr:hover { background: #F9FDFB; }
    .rpt-table tr:last-child td { border-bottom: none; }
    /* Badges */
    .badge-rpt {
        padding: 0.3rem 0.75rem; border-radius: 999px;
        font-weight: 700; font-size: 0.75rem; letter-spacing: 0.04em;
    }
    .badge-untung { background: #D1FAE5; color: #065F46; }
    .badge-rugi   { background: #FEE2E2; color: #991B1B; }
    .badge-impas  { background: #F3F4F6; color: #4B5563; }
    /* Action btn */
    .btn-action {
        background: transparent; color: var(--primary);
        border: 1.5px solid var(--primary); border-radius: 6px;
        padding: 0.3rem 0.9rem; font-weight: 600;
        font-size: 0.82rem; transition: all .2s;
        display: inline-block; white-space: nowrap;
    }
    .btn-action:hover { background: var(--primary); color: white; text-decoration: none; }
    .currency { font-variant-numeric: tabular-nums; }
    .text-green { color: var(--primary) !important; }
    .text-red   { color: #DC2626 !important; }
    .rpt-table th,
    .rpt-table td { white-space: nowrap; }
    .rpt-table td:nth-child(3),
    .rpt-table td:nth-child(4),
    .rpt-table td:nth-child(5),
    .rpt-table td:nth-child(6),
    .rpt-table td:nth-child(7) { white-space: nowrap; }
</style>
<div class="rpt-page container-fluid px-0">
    @if (Session::has('success'))
        <div class="alert alert-success mb-4" style="border-left: 4px solid var(--primary); border-radius: 8px;">
            {{ Session::get('success') }}
        </div>
    @endif
    @if (Session::has('error'))
        <div class="alert alert-danger mb-4" style="border-left: 4px solid #DC2626; border-radius: 8px;">
            {{ Session::get('error') }}
        </div>
    @endif
    {{-- Hero Header --}}
    <div class="rpt-header">
        <div>
            <h1>Laporan Usaha Tani</h1>
            <p>Rangkuman analisis biaya produksi, laba rugi, dan break even point seluruh usaha tani</p>
        </div>
        <div>
            <a href="{{ route('laporan.byCommodity') }}" class="btn-outline-rpt" style="color:white; border-color:rgba(255,255,255,0.6);">
                Per Komoditas
            </a>
        </div>
    </div>
    {{-- Filter Card --}}
    <div class="rpt-card">
        <div class="rpt-card-header">
            Pilih Data Tanam
        </div>
        <div class="rpt-card-body">
            <form action="{{ route('laporan.show') }}" method="GET">
                <div class="row align-items-end">
                    <div class="col-md-9 mb-3 mb-md-0">
                        <label for="tanam_id" class="filter-label">Kode Tanam</label>
                        <select name="tanam_id" id="tanam_id" class="filter-select" required>
                            <option value="">— Pilih Kode Tanam —</option>
                            @foreach ($tanams as $t)
                                @php
                                    $petaniObj = optional(optional($t->lahan)->petani);
                                    $petani = $petaniObj->nama_anggota ?? $petaniObj->nama_petani ?? '-';
                                @endphp
                                <option value="{{ $t->id_tanam }}">
                                    {{ $t->kode_tanam }}
                                    — {{ optional($t->komoditas)->nama_komoditas ?? '-' }}
                                    — {{ $petani }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn-primary-rpt">
                            <i class="fas fa-search"></i> Tampilkan Laporan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{-- Summary Table --}}
    <div class="rpt-card">
        <div class="rpt-card-header">
            Ringkasan Seluruh Usaha Tani
        </div>
        <div class="table-responsive">
            <table class="rpt-table">
                <thead>
                    <tr>
                        <th class="text-center" style="width:4%">#</th>
                        <th style="width:12%">Kode Tanam</th>
                        <th style="width:15%">Komoditas</th>
                        <th style="width:15%">Petani</th>
                        <th class="text-right" style="width:16%; white-space:nowrap;">Pendapatan</th>
                        <th class="text-right" style="width:16%; white-space:nowrap;">Total Biaya</th>
                        <th class="text-right" style="width:16%; white-space:nowrap;">Laba / Rugi</th>
                        <th class="text-center" style="width:8%">Status</th>
                        <th class="text-center" style="width:8%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tanams as $index => $t)
                        @php
                            $petaniObj = optional(optional($t->lahan)->petani);
                            $petani    = $petaniObj->nama_anggota ?? $petaniObj->nama_petani ?? '-';
                            $pendapatan = $t->total_pendapatan ?? 0;
                            $totalBiaya = $t->total_biaya ?? 0;
                            $laba       = $t->keuntungan_aktual ?? 0;
                            if ($laba > 0)      { $status = 'Untung'; $badge = 'badge-untung'; }
                            elseif ($laba < 0)  { $status = 'Rugi';   $badge = 'badge-rugi'; }
                            else                { $status = 'Impas';  $badge = 'badge-impas'; }
                        @endphp
                        <tr>
                            <td class="text-center text-muted">{{ $index + 1 }}</td>
                            <td class="font-weight-bold" style="color: var(--primary);">{{ $t->kode_tanam }}</td>
                            <td>{{ optional($t->komoditas)->nama_komoditas ?? '-' }}</td>
                            <td>{{ $petani }}</td>
                            <td class="text-right currency" style="white-space:nowrap;">Rp {{ number_format($pendapatan, 0, ',', '.') }}</td>
                            <td class="text-right currency" style="white-space:nowrap;">Rp {{ number_format($totalBiaya, 0, ',', '.') }}</td>
                            <td class="text-right currency font-weight-bold {{ $laba >= 0 ? 'text-green' : 'text-red' }}" style="white-space:nowrap;">
                                Rp {{ number_format($laba, 0, ',', '.') }}
                            </td>
                            <td class="text-center">
                                <span class="badge-rpt {{ $badge }}">{{ $status }}</span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('laporan.show', ['tanam_id' => $t->id_tanam]) }}" class="btn-action">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-5 text-muted">
                                <i class="fas fa-folder-open fa-2x mb-2 d-block" style="opacity:0.4;"></i>
                                Belum ada data tanam.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
