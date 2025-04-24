@extends('layouts.app')
@section('title', 'List')

@section('contents')
    {{-- Stylesheet Leaflet --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <div class="container-fluid py-4">
        {{-- Tabel Data --}}
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0">Capaian R/C Kelompok Tani</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered table-sm align-middle text-center mb-0">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Kelompok Tani</th>
                                <th scope="col">R/C</th>
                                <th scope="col">Cluster</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($result as $i => $row)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td class="text-start">{{ $row['nama_keltani'] }}</td>
                                    <td>{{ number_format($row['rc'], 2) }}</td>
                                    <td>
                                        <span class="badge 
                                            {{ $row['cluster'] == 1 ? 'bg-success' : ($row['cluster'] == 2 ? 'bg-warning text-dark' : 'bg-danger') }}">
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

        {{-- Peta Cluster --}}
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Peta Sebaran Cluster</h5>
            </div>
            <div class="card-body p-0">
                <div id="map" style="height: 400px;"></div>
            </div>
        </div>
    </div>

    {{-- Script Leaflet --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        var map = L.map('map').setView([-2.5, 118], 5);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        const colors = ['green', 'orange', 'red'];
        const data = @json($result);

        data.forEach(item => {
            if (item.latitude && item.longitude) {
                L.circleMarker([item.latitude, item.longitude], {
                    color: colors[item.cluster - 1],
                    radius: 8,
                    fillOpacity: 0.8
                }).addTo(map)
                .bindPopup(`
                    <strong>${item.nama_keltani}</strong><br>
                    R/C: ${item.rc.toFixed(2)}<br>
                    Cluster: ${item.cluster}
                `);
            }
        });
    </script>
@endsection
