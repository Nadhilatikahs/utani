@extends('layouts.app')

@section('title', 'Dashboard')

@section('contents')
    {{-- Header + filter tahun --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>

        <form method="GET" action="{{ route('dashboard') }}" class="form-inline">
            @php
                $tahunAktif = $summaryKeuangan['tahun'] ?? date('Y');
                $tahunNow   = date('Y');
            @endphp

            <label for="tahun" class="mr-2 text-black-800 font-weight-bold">Tahun</label>

            <select
                name="tahun"
                id="tahun"
                class="form-control form-control-sm font-weight-bold"
                style="color: #000 !important; background-color: #fff !important; -webkit-text-fill-color: #000;"
                onchange="this.form.submit()"
            >
                @for ($t = $tahunNow; $t >= $tahunNow - 5; $t--)
                    <option value="{{ $t }}" {{ $t == $tahunAktif ? 'selected' : '' }} style="color: #000;">
                        {{ $t }}
                    </option>
                @endfor
            </select>
        </form>
    </div>

    {{-- ==== 1. Summary Statistics Cards ==== --}}
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">
                    <div class="mb-2">
                        <i class="fas fa-tractor fa-2x" style="color: #3b82f6;"></i>
                    </div>
                    <h4 class="mb-0 font-weight-bold">{{ $lahans ?? 0 }}</h4>
                    <div class="text-muted small mt-1">Total Lahan</div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">
                    <div class="mb-2">
                        <i class="fas fa-leaf fa-2x" style="color: #22c55e;"></i>
                    </div>
                    <h4 class="mb-0 font-weight-bold">{{ $komoditas ?? 0 }}</h4>
                    <div class="text-muted small mt-1">Total Komoditas</div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">
                    <div class="mb-2">
                        <i class="fas fa-coins fa-2x" style="color: #f59e0b;"></i>
                    </div>
                    <h4 class="mb-0 font-weight-bold">{{ $bebans ?? 0 }}</h4>
                    <div class="text-muted small mt-1">Total Beban</div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">
                    <div class="mb-2">
                        <i class="fas fa-users fa-2x" style="color: #8b5cf6;"></i>
                    </div>
                    <h4 class="mb-0 font-weight-bold">{{ $kelompoktanis ?? 0 }}</h4>
                    <div class="text-muted small mt-1">Total Kelompok Tani</div>
                </div>
            </div>
        </div>
    </div>

    {{-- ==== 2. Financial KPI Cards ==== --}}
    <div class="row mb-4">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <div class="text-muted small font-weight-bold mb-1">TOTAL PENDAPATAN ({{ $summaryKeuangan['tahun'] ?? date('Y') }})</div>
                            <h3 class="mb-0 font-weight-bold">Rp {{ number_format($summaryKeuangan['total_pendapatan'] ?? 0, 0, ',', '.') }}</h3>
                        </div>
                        <div class="ml-3">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                                <i class="fas fa-money-bill-wave fa-2x" style="color: var(--button-green);"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <div class="text-muted small font-weight-bold mb-1">TOTAL BIAYA PRODUKSI ({{ $summaryKeuangan['tahun'] ?? date('Y') }})</div>
                            <h3 class="mb-0 font-weight-bold">Rp {{ number_format($summaryKeuangan['total_biaya'] ?? 0, 0, ',', '.') }}</h3>
                        </div>
                        <div class="ml-3">
                            <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                                <i class="fas fa-hand-holding-usd fa-2x" style="color: #f59e0b;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <div class="text-muted small font-weight-bold mb-1">KEUNTUNGAN BERSIH ({{ $summaryKeuangan['tahun'] ?? date('Y') }})</div>
                            <h3 class="mb-0 font-weight-bold">Rp {{ number_format($summaryKeuangan['total_laba'] ?? 0, 0, ',', '.') }}</h3>
                            @php
                                $isProfit = ($summaryKeuangan['total_laba'] ?? 0) > 0;
                            @endphp
                            <span class="badge {{ $isProfit ? 'bg-success' : 'bg-danger' }} mt-2">
                                STATUS: {{ $isProfit ? 'UNTUNG' : 'RUGI' }}
                            </span>
                        </div>
                        <div class="ml-3">
                            <div class="bg-success bg-opacity-10 rounded-circle p-3">
                                <i class="fas fa-chart-line fa-2x" style="color: var(--success-green);"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ==== 3. Charts Row ==== --}}
    <div class="row mb-4">
        {{-- Cash Flow Chart --}}
        <div class="col-xl-8 col-md-12 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-gradient-primary text-white">
                    <h6 class="mb-0"><i class="fas fa-chart-bar mr-2"></i>Arus Kas Per Tahun ({{ $summaryKeuangan['tahun'] ?? date('Y') }})</h6>
                </div>
                <div class="card-body">
                    <canvas id="chartCashFlow" height="80"></canvas>
                    @if (empty($cashFlowData))
                        <p class="mt-3 text-muted small text-center">Belum ada data arus kas untuk tahun ini.</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- Popular Commodities --}}
        <div class="col-xl-4 col-md-12 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-gradient-primary text-white">
                    <h6 class="mb-0"><i class="fas fa-chart-pie mr-2"></i>Komoditas Paling Laku ({{ $summaryKeuangan['tahun'] ?? date('Y') }})</h6>
                </div>
                <div class="card-body">
                    <canvas id="chartKomoditas" height="200"></canvas>
                    @if (empty($grafikBiayaPerKomoditas))
                        <p class="mt-3 text-muted small text-center">Belum ada data komoditas.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- ==== 4. Map and Summary Row ==== --}}
    <div class="row mb-4">
        {{-- Cluster Map --}}
        <div class="col-xl-8 col-md-12 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center">
                    <h6 class="mb-0"><i class="fas fa-map mr-2"></i>Peta Cluster Biaya Pertanian ({{ $summaryKeuangan['tahun'] ?? date('Y') }})</h6>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-light dropdown-toggle" type="button" id="clusterFilter" data-toggle="dropdown">
                            Filter
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="#" onclick="filterCluster('desa'); return false;">Per Desa</a>
                            <a class="dropdown-item" href="#" onclick="filterCluster('kabupaten'); return false;">Per Kabupaten</a>
                            <a class="dropdown-item" href="#" onclick="filterCluster('upt'); return false;">Per UPT</a>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div id="clusterMap" style="height: 400px; width: 100%;"></div>
                    <div class="p-3 border-top">
                        <div class="d-flex justify-content-center gap-3">
                            <span><span class="badge bg-success">Low</span></span>
                            <span><span class="badge bg-warning">Medium</span></span>
                            <span><span class="badge bg-danger">High</span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Top Expenses and Transactions --}}
        <div class="col-xl-4 col-md-12 mb-4">
            {{-- Top 3 Expenses --}}
            <div class="card shadow-sm border-0 mb-3">
                <div class="card-header bg-gradient-primary text-white">
                    <h6 class="mb-0"><i class="fas fa-list-ol mr-2"></i>3 Beban Terbesar Tahun Ini ({{ $summaryKeuangan['tahun'] ?? date('Y') }})</h6>
                </div>
                <div class="card-body">
                    @if (!empty($topExpenses))
                        @foreach($topExpenses as $index => $expense)
                            <div class="d-flex align-items-center mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                                <div class="bg-light rounded-circle p-2 mr-3">
                                    <i class="fas fa-{{ $index == 0 ? 'wrench' : ($index == 1 ? 'seedling' : 'tractor') }} text-primary"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="font-weight-bold">{{ $expense['nama'] }}</div>
                                    <div class="text-muted small">Rp {{ number_format($expense['total'], 0, ',', '.') }}</div>
                                </div>
                            </div>
                        @endforeach
                        <a href="{{ route('bebantanam.index') }}" class="btn btn-sm btn-outline-primary btn-block mt-2">
                            <i class="fas fa-arrow-down mr-1"></i>Lihat Detail
                        </a>
                    @else
                        <p class="text-muted small text-center">Belum ada data beban untuk tahun {{ $summaryKeuangan['tahun'] ?? date('Y') }}.</p>
                    @endif
                </div>
            </div>

            {{-- Transaction Summary --}}
            <div class="card shadow-sm border-0">
                <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center">
                    <h6 class="mb-0"><i class="fas fa-check-circle mr-2"></i>{{ $transactionSummary['total'] ?? 0 }} Transaksi ({{ $summaryKeuangan['tahun'] ?? date('Y') }})</h6>
                    <a href="{{ url('transaksi') }}" class="btn btn-sm btn-light">Lihat Detail</a>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <span class="text-muted">Pending:</span>
                        <span class="font-weight-bold float-right">{{ $transactionSummary['pending'] ?? 0 }}</span>
                    </div>
                    <div class="mb-2">
                        <span class="text-muted">Terverifikasi:</span>
                        <span class="font-weight-bold float-right">{{ $transactionSummary['verified'] ?? 0 }}</span>
                    </div>
                    <div class="mb-2 border-top pt-2">
                        <span class="text-muted">Total Terverifikasi:</span>
                        <span class="font-weight-bold float-right text-success">Rp {{ number_format($transactionSummary['total_amount'] ?? 0, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ==== 5. Grafik Kelompok Tani (Leaderboard Style) ==== --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center">
                    <h6 class="mb-0"><i class="fas fa-users-chart mr-2"></i>Grafik Kelompok Tani - Top Performers ({{ $summaryKeuangan['tahun'] ?? date('Y') }})</h6>
                    <div class="btn-group btn-group-sm" role="group">
                        <button type="button" class="btn btn-light active" onclick="showKelompokTaniChart('bar')">
                            <i class="fas fa-chart-bar"></i> Bar
                        </button>
                        <button type="button" class="btn btn-light" onclick="showKelompokTaniChart('leaderboard')">
                            <i class="fas fa-trophy"></i> Leaderboard
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    {{-- Bar Chart View --}}
                    <div id="kelompokTaniChartView">
                        <canvas id="chartKelompokTani" height="60"></canvas>
                    </div>
                    
                    {{-- Leaderboard View --}}
                    <div id="kelompokTaniLeaderboardView" style="display: none;">
                        @if (!empty($grafikKelompokTani))
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 50px;">Rank</th>
                                            <th>Nama Kelompok Tani</th>
                                            <th class="text-end">Pendapatan</th>
                                            <th class="text-center" style="width: 200px;">Progress</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $maxPendapatan = max(array_column($grafikKelompokTani, 'pendapatan'));
                                        @endphp
                                        @foreach($grafikKelompokTani as $index => $item)
                                            @php
                                                $percentage = $maxPendapatan > 0 ? ($item['pendapatan'] / $maxPendapatan) * 100 : 0;
                                                $medal = $index < 3 ? ['🥇', '🥈', '🥉'][$index] : ($index + 1);
                                            @endphp
                                            <tr>
                                                <td class="text-center">
                                                    <span class="badge {{ $index < 3 ? 'bg-warning' : 'bg-secondary' }}" style="padding: 0.5rem 0.75rem; font-size: 0.875rem;">
                                                        {{ $medal }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <strong>{{ $item['nama'] }}</strong>
                                                </td>
                                                <td class="text-end">
                                                    <strong class="text-success">Rp {{ number_format($item['pendapatan'], 0, ',', '.') }}</strong>
                                                </td>
                                                <td>
                                                    <div class="progress" style="height: 20px;">
                                                        <div class="progress-bar {{ $index < 3 ? 'bg-success' : 'bg-info' }}" 
                                                             role="progressbar" 
                                                             style="width: {{ $percentage }}%"
                                                             aria-valuenow="{{ $percentage }}" 
                                                             aria-valuemin="0" 
                                                             aria-valuemax="100">
                                                            {{ number_format($percentage, 1) }}%
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted small text-center py-4">Belum ada data kelompok tani untuk tahun ini.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ==== 6. Master Data Summary (Optional - can be collapsed) ==== --}}
    <!-- <div class="card shadow-sm border-0">
        <div class="card-header bg-light">
            <h6 class="mb-0"><i class="fas fa-database mr-2"></i>Ringkasan Data Utama</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 col-6 mb-3">
                    <div class="text-center p-3 border rounded">
                        <i class="fas fa-map fa-2x text-primary mb-2"></i>
                        <div class="font-weight-bold">{{ $provinsis }}</div>
                        <div class="small text-muted">Provinsi</div>
                    </div>
                </div>
                <div class="col-md-3 col-6 mb-3">
                    <div class="text-center p-3 border rounded">
                        <i class="fas fa-city fa-2x text-success mb-2"></i>
                        <div class="font-weight-bold">{{ $kabupatens }}</div>
                        <div class="small text-muted">Kabupaten</div>
                    </div>
                </div>
                <div class="col-md-3 col-6 mb-3">
                    <div class="text-center p-3 border rounded">
                        <i class="fas fa-users fa-2x text-warning mb-2"></i>
                        <div class="font-weight-bold">{{ $kelompoktanis }}</div>
                        <div class="small text-muted">Kelompok Tani</div>
                    </div>
                </div>
                <div class="col-md-3 col-6 mb-3">
                    <div class="text-center p-3 border rounded">
                        <i class="fas fa-leaf fa-2x text-info mb-2"></i>
                        <div class="font-weight-bold">{{ $komoditas }}</div>
                        <div class="small text-muted">Komoditas</div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <script>
        // Cash Flow Chart (Bar + Line)
        const cashFlowData = @json($cashFlowData ?? []);
        (function () {
            const el = document.getElementById('chartCashFlow');
            if (!el || cashFlowData.length === 0) return;

            const labels = cashFlowData.map(i => i.label);
            const uangMasuk = cashFlowData.map(i => i.uang_masuk);
            const uangKeluar = cashFlowData.map(i => i.uang_keluar);
            const sisaUntung = cashFlowData.map(i => i.sisa_untung);

            new Chart(el, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Uang Masuk',
                            data: uangMasuk,
                            backgroundColor: 'rgba(54, 162, 235, 0.6)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Uang Keluar',
                            data: uangKeluar,
                            backgroundColor: 'rgba(255, 159, 64, 0.6)',
                            borderColor: 'rgba(255, 159, 64, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Sisa Untung',
                            data: sisaUntung,
                            type: 'line',
                            borderColor: 'rgba(34, 197, 94, 1)',
                            backgroundColor: 'rgba(34, 197, 94, 0.1)',
                            borderWidth: 2,
                            fill: false,
                            tension: 0.4,
                            yAxisID: 'y'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + (value / 1000000).toFixed(0) + 'M';
                                }
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        }
                    }
                }
            });
        })();

        // Popular Commodities Pie Chart
        const dataKomoditas = @json($grafikBiayaPerKomoditas ?? []);
        (function () {
            const el = document.getElementById('chartKomoditas');
            if (!el || dataKomoditas.length === 0) return;

            const total = dataKomoditas.reduce((sum, item) => sum + item.pendapatan, 0);
            const top3 = dataKomoditas
                .sort((a, b) => b.pendapatan - a.pendapatan)
                .slice(0, 3);
            const others = total - top3.reduce((sum, item) => sum + item.pendapatan, 0);

            const labels = top3.map(i => i.label);
            const data = top3.map(i => i.pendapatan);
            if (others > 0) {
                labels.push('Lainnya');
                data.push(others);
            }

            new Chart(el, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        data: data,
                        backgroundColor: [
                            'rgba(34, 197, 94, 0.8)',
                            'rgba(255, 159, 64, 0.8)',
                            'rgba(239, 68, 68, 0.8)',
                            'rgba(156, 163, 175, 0.8)'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        })();

        // Grafik Kelompok Tani Bar Chart
        const dataKelompokTani = @json($grafikKelompokTani ?? []);
        let kelompokTaniChart = null;

        function initKelompokTaniChart() {
            const el = document.getElementById('chartKelompokTani');
            if (!el || dataKelompokTani.length === 0) return;

            if (kelompokTaniChart) {
                kelompokTaniChart.destroy();
            }

            const labels = dataKelompokTani.map(i => i.nama.length > 20 ? i.nama.substring(0, 20) + '...' : i.nama);
            const data = dataKelompokTani.map(i => i.pendapatan);

            kelompokTaniChart = new Chart(el, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Pendapatan',
                        data: data,
                        backgroundColor: data.map((val, idx) => 
                            idx < 3 ? 'rgba(34, 197, 94, 0.8)' : 'rgba(28, 200, 138, 0.6)'
                        ),
                        borderColor: data.map((val, idx) => 
                            idx < 3 ? 'rgba(34, 197, 94, 1)' : 'rgba(28, 200, 138, 1)'
                        ),
                        borderWidth: 1
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return 'Rp ' + context.parsed.x.toLocaleString('id-ID');
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + (value / 1000000).toFixed(1) + 'M';
                                }
                            }
                        }
                    }
                }
            });
        }

        function showKelompokTaniChart(view) {
            const chartView = document.getElementById('kelompokTaniChartView');
            const leaderboardView = document.getElementById('kelompokTaniLeaderboardView');
            const buttons = document.querySelectorAll('[onclick*="showKelompokTaniChart"]');

            buttons.forEach(btn => btn.classList.remove('active'));
            if (event && event.target) {
                event.target.classList.add('active');
            }

            if (view === 'bar') {
                chartView.style.display = 'block';
                leaderboardView.style.display = 'none';
                if (dataKelompokTani.length > 0) {
                    setTimeout(initKelompokTaniChart, 100);
                }
            } else {
                chartView.style.display = 'none';
                leaderboardView.style.display = 'block';
            }
        }

        // Initialize chart on load
        if (dataKelompokTani.length > 0) {
            setTimeout(initKelompokTaniChart, 500);
        }

        // Cluster Map
        const clusterData = @json($clusterData ?? []);
        let clusterMap = null;

        function initClusterMap() {
            const mapEl = document.getElementById('clusterMap');
            if (!mapEl || clusterData.length === 0) {
                mapEl.innerHTML = '<div class="p-5 text-center text-muted">No cluster data available</div>';
                return;
            }

            if (clusterMap) {
                clusterMap.remove();
            }

            // Get center from first data point or default
            const centerLat = clusterData[0]?.latitude || -7.5;
            const centerLng = clusterData[0]?.longitude || 110.4;
            
            clusterMap = L.map('clusterMap').setView([centerLat, centerLng], 8);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors',
                maxZoom: 19
            }).addTo(clusterMap);

            clusterData.forEach((item, index) => {
                if (item.latitude && item.longitude && item.latitude != 0 && item.longitude != 0) {
                    const color = item.cluster === 'high' ? '#ef4444' : (item.cluster === 'medium' ? '#f59e0b' : '#22c55e');
                    const marker = L.circleMarker([item.latitude, item.longitude], {
                        radius: 10,
                        fillColor: color,
                        color: '#fff',
                        weight: 2,
                        opacity: 1,
                        fillOpacity: 0.8
                    }).addTo(clusterMap);

                    marker.bindPopup(`<b>${item.nama}</b><br>RC Ratio: ${item.rc}<br>Cluster: ${item.cluster.toUpperCase()}`);
                }
            });
        }

        function filterCluster(kategori) {
            // Redirect to clustering page with filter
            window.location.href = "{{ route('clustering.show') }}?kategori=" + kategori;
        }

        // Initialize map when page loads
        document.addEventListener('DOMContentLoaded', function() {
            if (clusterData.length > 0) {
                setTimeout(initClusterMap, 500); // Small delay to ensure map container is ready
            }
        });
    </script>
@endsection
