@extends('layouts.app')

@section('title', 'Edit')

@section('contents')
    <h1 class="mb-0">Edit Data Provinsi</h1>
    <hr />
    <form action="{{ route('provinsis.update', $id_provinsi) }}" method="POST">
        @csrf
        @method('PUT')

        <fieldset disabled>
            <div class="mb-3">
                <label for="kode_provinsi_tampil" class="form-label">Kode Provinsi</label>
                <input class="form-control form-control-solid" id="kode_provinsi_tampil" name="kode_provinsi_tampil" type="text" placeholder="Contoh: PR-001" value="{{ $kode_provinsi }}" readonly>
            </div>
        </fieldset>
        <input type="hidden" id="kode_provinsi" name="kode_provinsi" value="{{ $kode_provinsi }}">
        <input type="hidden" name="id_provinsi" class="form-control" value="{{ $id_provinsi }}">

        <div class="mb-3">
            <label for="nama_provinsi" class="form-label">Nama Provinsi</label>
            <input type="text" name="nama_provinsi" id="nama_provinsi" class="form-control" placeholder="Nama Provinsi" value="{{ $nama_provinsi }}" pattern="[A-Za-z\s]+" title="Hanya huruf yang diizinkan" required>
            @error('nama_provinsi')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="latitude" class="form-label">Latitude (Garis Lintang)</label>
                <input type="text" name="latitude" id="latitude" class="form-control" placeholder="Contoh: -6.200000" value="{{ $latitude }}" pattern="-?\d+(\.\d+)?" title="Masukkan koordinat Latitude yang valid" readonly required>
                @error('latitude')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="longitude" class="form-label">Longitude (Garis Bujur)</label>
                <input type="text" name="longitude" id="longitude" class="form-control" placeholder="Contoh: 106.816666" value="{{ $longitude }}" pattern="-?\d+(\.\d+)?" title="Masukkan koordinat Longitude yang valid" readonly required>
                @error('longitude')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Pilih Lokasi Provinsi di Peta</label>
            <div id="map" style="height: 70vh; width: 100%;"></div>
        </div>

        <div class="d-grid">
            <button class="btn btn-warning">Update</button>
        </div>
    </form>
@endsection

@section('script')
<script>
    var map = L.map('map').setView([{{ $latitude }}, {{ $longitude }}], 6);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    var marker = L.marker([{{ $latitude }}, {{ $longitude }}]).addTo(map);

    function updateMarker(latlng, name = null) {
        if (marker) {
            map.removeLayer(marker);
        }
        marker = L.marker(latlng).addTo(map);
        if (name) {
            marker.bindPopup(name).openPopup();
        }
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
        var latlng = e.geocode.center;
        map.setView(latlng, 13);
        updateMarker(latlng, e.geocode.name);
    })
    .addTo(map);
</script>
@endsection
