@extends('layouts.app')
@section('title', 'Clustering R/C')

@section('contents')
    {{-- Stylesheet Leaflet --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <div class="container-fluid py-4">
        {{-- Form Pilih Kategori --}}
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Pilih Kategori Clustering R/C</h5>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('clustering.show') }}">
                    <div class="row gx-2 align-items-end">
                        <div class="col-md-4">
                            <label for="kategori" class="form-label">Kategori</label>
                            <select id="kategori" name="kategori" class="form-select">
                                <option value="desa"     {{ request('kategori')=='desa'?'selected':'' }}>Per Desa</option>
                                <option value="kabupaten"{{ request('kategori')=='kabupaten'?'selected':'' }}>Per Kabupaten</option>
                                <option value="upt"      {{ request('kategori')=='upt'?'selected':'' }}>Per UPT</option>
                                <option value="komoditas"{{ request('kategori')=='komoditas'?'selected':'' }}>Per Komoditas</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-success w-100">Tampilkan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @if(count($result))
        {{-- Tabel Hasil Clustering --}}
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Hasil Clustering {{ $judul }}</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered table-sm align-middle text-center mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>R/C</th>
                                <th>Cluster</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($result as $i => $row)
                            <tr>
                                <td>{{ $i+1 }}</td>
                                <td class="text-start">{{ $row['nama'] }}</td>
                                <td>{{ number_format($row['rc'], 2) }}</td>
                                <td>
                                    @php
                                        $colors = ['success','warning text-dark','danger'];
                                        $badge = $colors[$row['cluster']-1] ?? 'secondary';
                                    @endphp
                                    <span class="badge bg-{{ $badge }}">
                                        C{{ $row['cluster'] }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Peta Sebaran Cluster --}}
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Peta Sebaran Cluster</h5>
            </div>
            <div class="card-body p-0">
                <div id="map" style="height: 400px;"></div>
            </div>
        </div>
        @else
            <div class="alert alert-warning text-center">
                Tidak ada data untuk kategori <strong>{{ $judul }}</strong>.
            </div>
        @endif
    </div>

    {{-- Script Leaflet --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // Inisialisasi peta
        var map = L.map('map').setView([-2.5, 118], 5);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Warna untuk tiap cluster
        const colors = ['green','orange','red'];

        // Data hasil clustering
        const data = @json($result);

        // Plot marker
        data.forEach(item => {
            if (item.latitude && item.longitude) {
                L.circleMarker([item.latitude, item.longitude], {
                    color: colors[item.cluster - 1] || colors[0],
                    radius: 8,
                    fillOpacity: 0.8
                }).addTo(map)
                  .bindPopup(`<strong>${item.nama}</strong><br>R/C: ${item.rc.toFixed(2)}<br>Cluster: ${item.cluster}`);
            }
        });

        // Tambahkan legend
        const legend = L.control({ position: 'bottomright' });
        legend.onAdd = function() {
            const div = L.DomUtil.create('div', 'info legend');
            const clusters = [1,2,3];
            clusters.forEach(i => {
                div.innerHTML +=
                    `<i style="background:${colors[i-1]};width:12px;height:12px;display:inline-block;margin-right:5px;"></i>
                     Cluster ${i}<br>`;
            });
            return div;
        };
        legend.addTo(map);
    </script>

    {{-- Legend CSS --}}
    <style>
    .info.legend {
        background: white;a
        padding: 6px 8px;
        box-shadow: 0 0 15px rgba(0,0,0,0.2);
        border-radius: 5px;
        font-size: 14px;
        line-height: 18px;
    }
    .info.legend i {
        vertical-align: middle;
    }
    </style>
@endsection
