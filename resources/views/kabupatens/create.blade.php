@extends('layouts.app')

@section('title', 'Tambah Data Provinsi')

@section('style')
<style>
    #map {
        height: 70vh;
        width: 100%;
    }
</style>
@endsection

@section('contents')
    <h1 class="mb-0">Provinsi</h1>
    <hr />
    <form action="{{ route('provinsis.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <fieldset disabled>
            <div class="mb-3">
                <label for="kodeprovinsilabel">Kode Provinsi</label>
                <input class="form-control form-control-solid" id="kode_provinsi_tampil" name="kode_provinsi_tampil" type="text" placeholder="Contoh: PV-001" value="{{ $kode_provinsi }}" readonly>
            </div>
        </fieldset>
        <input type="hidden" id="kode_provinsi" name="kode_provinsi" value="{{ $kode_provinsi }}">

        <div class="row mb-3">
            <div class="col">
                <input type="text" name="nama_provinsi" id="nama_provinsi" class="form-control" placeholder="Nama provinsi" pattern="[A-Za-z\s]+" title="Hanya huruf yang diizinkan" required>
                @error('nama_provinsi')
                <div id="flash-message" class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <input type="text" name="latitude" id="latitude" class="form-control" placeholder="Latitude (Garis Lintang)" pattern="-?\d+(\.\d+)?" title="Harap masukkan titik latitude yang valid" readonly required>
                @error('latitude')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col">
                <input type="text" name="longitude" id="longitude" class="form-control" placeholder="Longitude (Garis Bujur)" pattern="-?\d+(\.\d+)?" title="Harap masukkan titik longitude yang valid" readonly required>
                @error('longitude')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-3">
            <div id="map"></div>
        </div>

        <div class="row">
            <div class="col text-left">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const flashMessage = document.getElementById('flash-message');
            if (flashMessage) {
                setTimeout(function() {
                    flashMessage.style.display = 'none';
                }, 3000);
            }
        });
    </script>
@endsection

@section('script')
<script>
    var map = L.map('map').setView([-6.1751, 106.8650], 5); // Default ke Jakarta

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    var marker = null;

    function updateMarker(latlng) {
        if (marker) {
            map.removeLayer(marker);
        }

        var namaProvinsi = document.getElementById('nama_provinsi').value || 'Provinsi baru';
        var popupContent = `<strong>${namaProvinsi}</strong><br>Latitude: ${latlng.lat}<br>Longitude: ${latlng.lng}`;

        marker = L.marker(latlng).addTo(map);
        marker.bindPopup(popupContent).openPopup();

        document.getElementById('latitude').value = latlng.lat;
        document.getElementById('longitude').value = latlng.lng;
    }

    map.on('click', function(e) {
        updateMarker(e.latlng);
    });

    var geocoder = L.Control.geocoder({
        defaultMarkGeocode: false
    })
    .on('markgeocode', function(e) {
        var bbox = e.geocode.bbox;
        var latlng = e.geocode.center;
        map.fitBounds([
            [bbox.getSouthWest().lat, bbox.getSouthWest().lng],
            [bbox.getNorthEast().lat, bbox.getNorthEast().lng]
        ]);
        updateMarker(latlng);
    })
    .addTo(map);

    // Tambahkan marker untuk provinsi yang sudah ada
    @foreach($provinsis as $prov)
        L.marker([{{ $prov->latitude }}, {{ $prov->longitude }}])
            .addTo(map)
            .bindPopup("<strong>{{ $prov->nama_provinsi }}</strong><br>Latitude: {{ $prov->latitude }}<br>Longitude: {{ $prov->longitude }}");
    @endforeach
</script>
@endsection
