@extends('layouts.app')

@section('title', 'Laporan Biaya Produksi per Komoditas')

@section('contents')
    <style>
        /* Modern Dark Green Dashboard Style */
        .laporan-commodity-page {
            font-size: 16px;
            color: #334155;
        }
        .laporan-commodity-page h1 {
            font-size: 2.2rem;
            font-weight: 700;
            color: #0f172a;
        }
        .laporan-commodity-page h3 {
            font-size: 1.8rem;
            font-weight: 700;
            color: #0f172a;
        }
        .laporan-commodity-page h6 {
            font-size: 1rem;
            font-weight: 500;
            color: #64748b;
            white-space: nowrap;
        }
        
        /* Cards */
        .laporan-commodity-page .card {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            margin-bottom: 24px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        .laporan-commodity-page .card-header {
            background-color: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            border-top-left-radius: 0.5rem !important;
            border-top-right-radius: 0.5rem !important;
            padding: 18px 24px;
            position: relative;
            overflow: hidden;
        }
        /* Green Accent on Cards */
        .laporan-commodity-page .card-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: #10b981;
        }
        .laporan-commodity-page .card-body {
            padding: 20px;
        }

        /* Summary Cards Content */
        .summary-card-title {
            color: #94a3b8;
            font-size: 0.95rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 8px;
            font-weight: 600;
        }
        .summary-card-value {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0;
        }
        
        /* Table Styles */
        .laporan-commodity-page .table-responsive {
            border-radius: 0.5rem;
            overflow: hidden;
            border: 1px solid #e2e8f0;
            overflow-x: auto;
        }
        .laporan-commodity-page .table {
            margin-bottom: 0;
            color: #334155;
            border-collapse: collapse;
        }
        .laporan-commodity-page .table th {
            background-color: #10b981; /* Green Header from Picture 2 */
            color: #ffffff;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.05em;
            padding: 16px 20px;
            border: none;
            vertical-align: middle;
            white-space: nowrap;
        }
        .laporan-commodity-page .table td {
            padding: 16px 20px;
            border-bottom: 1px solid #e2e8f0;
            border-top: none;
            background-color: #ffffff;
            vertical-align: middle;
            white-space: nowrap;
        }
        .laporan-commodity-page .table tbody tr:hover td {
            background-color: #f8fafc;
        }
        
        /* Summary Row */
        .laporan-commodity-page .table-summary th,
        .laporan-commodity-page tfoot th,
        .laporan-commodity-page tfoot td {
            background-color: #ffffff;
            color: #0f172a;
            font-size: 1rem;
            padding: 20px;
            border-top: 2px solid #10b981;
            border-bottom: none;
        }

        /* Utilities */
        .text-accent { color: #10b981; }
        .text-success-light { color: #4ade80; }
        .text-warning-light { color: #facc15; }
        .text-danger-light { color: #f87171; }

        .laporan-commodity-page .btn-secondary {
            background-color: #334155;
            border-color: #334155;
            color: #f8fafc;
            border-radius: 0.25rem;
            padding: 8px 16px;
            font-weight: 500;
            transition: all 0.2s;
        }
        .laporan-commodity-page .btn-secondary:hover {
            background-color: #475569;
            border-color: #475569;
        }
        
        .komoditas-badge {
            display: inline-flex;
            align-items: center;
            padding: 6px 12px;
            background-color: rgba(16, 185, 129, 0.2);
            border: 1px solid #10b981;
            border-radius: 0.5rem;
            font-size: 0.9rem;
            font-weight: 500;
            color: #10b981;
        }
        
        /* Detail Table Override */
        .details-row .table {
            border: 1px solid #e2e8f0;
        }
        .details-row .table th {
            background-color: #f8fafc;
            color: #10b981;
            border-bottom: 1px solid #e2e8f0;
        }
        .details-row .table td {
            background-color: #ffffff;
        }



    </style>

    <div class="laporan-commodity-page">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h1 class="mb-0">Laporan Biaya Produksi per Komoditas</h1>
            <div>
                <a href="{{ route('laporan.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali ke Laporan
                </a>
            </div>
        </div>
        <hr style="border-width: 2px;" />

    @if (Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif

    @if (Session::has('error'))
        <div class="alert alert-danger" role="alert">
            {{ Session::get('error') }}
        </div>
    @endif

        {{-- Summary Cards --}}
        <div class="row mb-4">
            <div class="col-md-6 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <h6 class="text-muted mb-3">Total Komoditas</h6>
                        <h3 class="mb-0">{{ count($commodityGroups) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <h6 class="text-muted mb-3">Total Biaya Produksi</h6>
                        <h3 class="mb-0 text-primary">
                            Rp {{ number_format(array_sum(array_column($commodityGroups, 'total_biaya')), 0, ',', '.') }}
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <h6 class="text-muted mb-3">Total Pendapatan</h6>
                        <h3 class="mb-0 text-success">
                            Rp {{ number_format(array_sum(array_column($commodityGroups, 'total_pendapatan')), 0, ',', '.') }}
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <h6 class="text-muted mb-3">Total Keuntungan</h6>
                        <h3 class="mb-0 {{ array_sum(array_column($commodityGroups, 'total_keuntungan')) >= 0 ? 'text-success' : 'text-danger' }}">
                            Rp {{ number_format(array_sum(array_column($commodityGroups, 'total_keuntungan')), 0, ',', '.') }}
                        </h3>
                    </div>
                </div>
            </div>
        </div>

        {{-- Commodity Groups Table --}}
        <div class="card">
            <div class="card-header bg-primary text-white">
                <strong><i class="fas fa-chart-bar"></i> Ringkasan Biaya Produksi per Komoditas</strong>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" style="width: 70px; font-size: 1.3rem;">#</th>
                                <th style="font-size: 1.3rem;">Komoditas</th>
                                <th class="text-center" style="font-size: 1.3rem;">Jumlah Tanam</th>
                                <th class="text-end" style="font-size: 1.3rem;">Total Biaya Bahan Baku</th>
                                <th class="text-end" style="font-size: 1.3rem;">Total Biaya Tenaga Kerja Langsung</th>
                                <th class="text-end" style="font-size: 1.3rem;">Total Biaya Overhead Pabrik</th>
                                <th class="text-end" style="font-size: 1.3rem;">Total Biaya Produksi</th>
                                <th class="text-center" style="font-size: 1.3rem;">Aksi</th>
                            </tr>
                        </thead>
                    <tbody>
                        @forelse ($commodityGroups as $index => $group)
                            @php
                                $keuntungan = $group['total_keuntungan'];
                                $statusClass = $keuntungan > 0 ? 'text-success' : ($keuntungan < 0 ? 'text-danger' : 'text-secondary');
                                $statusText = $keuntungan > 0 ? 'Untung' : ($keuntungan < 0 ? 'Rugi' : 'Impas');
                            @endphp
                            <tr class="commodity-row" data-commodity-id="{{ $group['id_komoditas'] }}">
                                <td class="text-center">
                                    <button class="btn btn-link text-decoration-none p-2 toggle-details" 
                                            data-target="details-{{ $group['id_komoditas'] }}" 
                                            style="font-size: 1.5rem;">
                                        <i class="fas fa-chevron-down"></i>
                                    </button>
                                </td>
                                <td style="font-size: 1.2rem;">
                                    <strong>{{ $group['nama_komoditas'] }}</strong>
                                    <br>
                                    <span class="text-muted" style="font-size: 1.1rem;">{{ $group['kode_komoditas'] }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-info" style="font-size: 1.1rem; padding: 10px 15px;">{{ $group['jumlah_tanam'] }} Tanam</span>
                                </td>
                                <td class="text-end" style="font-size: 1.15rem;">
                                    Rp {{ number_format($group['total_bbb'] ?? 0, 0, ',', '.') }}
                                </td>
                                <td class="text-end" style="font-size: 1.15rem;">
                                    Rp {{ number_format($group['total_btkl'] ?? 0, 0, ',', '.') }}
                                </td>
                                <td class="text-end" style="font-size: 1.15rem;">
                                    Rp {{ number_format($group['total_bop'] ?? 0, 0, ',', '.') }}
                                </td>
                                <td class="text-end fw-bold" style="font-size: 1.2rem;">
                                    Rp {{ number_format(($group['total_bbb'] ?? 0) + ($group['total_btkl'] ?? 0) + ($group['total_bop'] ?? 0), 0, ',', '.') }}
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-outline-primary view-details" 
                                            data-commodity-id="{{ $group['id_komoditas'] }}"
                                            style="font-size: 1.1rem; padding: 10px 20px;">
                                        <i class="fas fa-eye"></i> Detail
                                    </button>
                                </td>
                            </tr>
                            {{-- Expandable Details Row --}}
                            <tr class="details-row" id="details-{{ $group['id_komoditas'] }}" style="display: none;">
                                <td colspan="8" class="bg-light">
                                    <div class="p-4">
                                        <h6 class="mb-4" style="font-size: 1.5rem; font-weight: bold;">
                                            <i class="fas fa-seedling"></i> Detail Tanam untuk {{ $group['nama_komoditas'] }}
                                        </h6>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" style="font-size: 1.1rem;">
                                                <thead class="table-secondary">
                                                    <tr>
                                                        <th style="font-size: 1.2rem; padding: 15px 10px;">Kode Tanam</th>
                                                        <th style="font-size: 1.2rem; padding: 15px 10px;">Petani</th>
                                                        <th style="font-size: 1.2rem; padding: 15px 10px;">Tanggal Tanam</th>
                                                        <th style="font-size: 1.2rem; padding: 15px 10px;">Volume</th>
                                                        <th class="text-end" style="font-size: 1.2rem; padding: 15px 10px;">Biaya Bahan Baku (BBB)</th>
                                                        <th class="text-end" style="font-size: 1.2rem; padding: 15px 10px;">Biaya Tenaga Kerja (BTKL)</th>
                                                        <th class="text-end" style="font-size: 1.2rem; padding: 15px 10px;">Biaya Overhead (BOP)</th>
                                                        <th class="text-end" style="font-size: 1.2rem; padding: 15px 10px;">Total Biaya Produksi</th>
                                                        <th class="text-center" style="font-size: 1.2rem; padding: 15px 10px;">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($group['tanams'] as $tanamData)
                                                        @php
                                                            $t = $tanamData['tanam'];
                                                            $petaniObj = optional(optional($t->lahan)->petani);
                                                            $petani = $petaniObj->nama_anggota ?? $petaniObj->nama_petani ?? '-';
                                                            $tanamKeuntungan = $tanamData['keuntungan'];
                                                            $tanamStatusClass = $tanamKeuntungan > 0 ? 'text-success' : ($tanamKeuntungan < 0 ? 'text-danger' : 'text-secondary');
                                                        @endphp
                                                        <tr>
                                                            <td style="font-size: 1.1rem; padding: 15px 10px;">{{ $t->kode_tanam }}</td>
                                                            <td style="font-size: 1.1rem; padding: 15px 10px;">{{ $petani }}</td>
                                                            <td style="font-size: 1.1rem; padding: 15px 10px;">{{ $t->tgl_tanam ? $t->tgl_tanam->format('d-m-Y') : '-' }}</td>
                                                            <td style="font-size: 1.1rem; padding: 15px 10px;">{{ number_format($tanamData['volume'], 2, ',', '.') }}</td>
                                                            <td class="text-end" style="font-size: 1.1rem; padding: 15px 10px;">
                                                                Rp {{ number_format($tanamData['bbb'] ?? 0, 0, ',', '.') }}
                                                            </td>
                                                            <td class="text-end" style="font-size: 1.1rem; padding: 15px 10px;">
                                                                Rp {{ number_format($tanamData['btkl'] ?? 0, 0, ',', '.') }}
                                                            </td>
                                                            <td class="text-end" style="font-size: 1.1rem; padding: 15px 10px;">
                                                                Rp {{ number_format($tanamData['bop'] ?? 0, 0, ',', '.') }}
                                                            </td>
                                                            <td class="text-end" style="font-size: 1.1rem; padding: 15px 10px;">
                                                                Rp {{ number_format(($tanamData['bbb'] ?? 0) + ($tanamData['btkl'] ?? 0) + ($tanamData['bop'] ?? 0), 0, ',', '.') }}
                                                            </td>
                                                            <td class="text-center" style="padding: 15px 10px;">
                                                                <a href="{{ route('laporan.show', ['tanam_id' => $t->id_tanam]) }}" 
                                                                   class="btn btn-outline-primary"
                                                                   style="font-size: 1.1rem; padding: 10px 20px;">
                                                                    <i class="fas fa-file-alt"></i> Laporan
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <p class="text-muted mb-0" style="font-size: 1.3rem;">Belum ada data tanam.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>
    </div>
    </div>

    <style>
        .commodity-row {
            cursor: pointer;
        }
        .commodity-row:hover {
            background-color: #f8fafc !important;
        }
        .details-row {
            background-color: #ffffff;
        }
        .toggle-details {
            transition: transform 0.3s;
        }
        .toggle-details.expanded {
            transform: rotate(180deg);
        }
        /* Additional spacing for better readability */
        .laporan-commodity-page .card {
            margin-bottom: 20px;
        }
        .laporan-commodity-page .card-body {
            padding: 25px;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle details row
            document.querySelectorAll('.toggle-details').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const targetId = this.getAttribute('data-target');
                    const detailsRow = document.getElementById(targetId);
                    const icon = this.querySelector('i');
                    
                    if (detailsRow.style.display === 'none') {
                        detailsRow.style.display = '';
                        icon.classList.remove('fa-chevron-down');
                        icon.classList.add('fa-chevron-up');
                        this.classList.add('expanded');
                    } else {
                        detailsRow.style.display = 'none';
                        icon.classList.remove('fa-chevron-up');
                        icon.classList.add('fa-chevron-down');
                        this.classList.remove('expanded');
                    }
                });
            });

            // View details button
            document.querySelectorAll('.view-details').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const commodityId = this.getAttribute('data-commodity-id');
                    const detailsRow = document.getElementById('details-' + commodityId);
                    const toggleButton = document.querySelector(`[data-target="details-${commodityId}"]`);
                    
                    if (detailsRow.style.display === 'none') {
                        detailsRow.style.display = '';
                        const icon = toggleButton.querySelector('i');
                        icon.classList.remove('fa-chevron-down');
                        icon.classList.add('fa-chevron-up');
                        toggleButton.classList.add('expanded');
                        
                        // Scroll to details
                        detailsRow.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                    } else {
                        detailsRow.style.display = 'none';
                        const icon = toggleButton.querySelector('i');
                        icon.classList.remove('fa-chevron-up');
                        icon.classList.add('fa-chevron-down');
                        toggleButton.classList.remove('expanded');
                    }
                });
            });
        });
    </script>
@endsection
