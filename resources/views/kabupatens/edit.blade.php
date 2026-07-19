<!-- //resources/views/provinsis/edit.blade.php -->
@extends('layouts.app')

@section('title', 'Edit Provinsi')

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
    <form action="{{ route('provinsis.update', $provinsi->id_provinsi) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" name="id_provinsi" class="form-control" value="{{ $id_provinsi }}">

        <fieldset disabled>
            <div class="mb-3">
                <label for="kodeprovinsilabel">Kode Provinsi</label>
                <input class="form-control form-control-solid" id="kode_provinsi_tampil" name="kode_provinsi_tampil" type="text" placeholder="Contoh: PV-001" value="{{ $kode_provinsi }}" readonly>
            </div>
        </fieldset>
        <input type="hidden" id="kode_provinsi" name="kode_provinsi" value="{{ $kode_provinsi }}">

        <div class="row mb-3">
            <div class="col">
                <input type="text" name="nama_provinsi" id="nama_provinsi" class="form-control" placeholder="Nama Provinsi" value="{{ $nama_provinsi }}" pattern="[A-Za-z\s]+" title="Hanya huruf yang diizinkan" required>
                @error('nama_provinsi')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <input type="text" name="latitude" id="latitude" class="form-control" placeholder="Latitude (Garis Lintang)" value="{{ $latitude }}" pattern="-?\d+(\.\d+)?" title="Harap masukkan titik latitude yang valid" readonly required>
                @error('latitude')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col">
                <input type="text" name="longitude" id="longitude" class="form-control" placeholder="Longitude (Garis Bujur)" value="{{ $longitude }}" pattern="-?\d+(\.\d+)?" title="Harap masukkan titik longitude yang valid" readonly required>
                @error('longitude')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-3">
            <div id="map"></div>
        </div>

        <div class="row">
            <div class="col text-left d-flex gap-2">
                <a href="{{ route('kabupatens.index') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
@endsection

@section('script')
<script>
    var map = L.map('map').setView([{{ $latitude }}, {{ $longitude }}], 5);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    var marker = L.marker([{{ $latitude }}, {{ $longitude }}]).addTo(map);
    marker.bindPopup(`<strong>{{ $nama_provinsi }}</strong><br>Latitude: {{ $latitude }}<br>Longitude: {{ $longitude }}`).openPopup();

    function updateMarker(latlng) {
        if (marker) {
            map.removeLayer(marker);
        }

        var namaProvinsi = document.getElementById('nama_provinsi').value || 'Provinsi Baru';
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
        var latlng = e.geocode.center;
        map.setView(latlng, 5);
        updateMarker(latlng);
    })
    .addTo(map);

    @foreach($provinsis as $prov)
        @if($prov->latitude != $latitude || $prov->longitude != $longitude)
            L.marker([{{ $prov->latitude }}, {{ $prov->longitude }}])
                .addTo(map)
                .bindPopup("<strong>{{ $prov->nama_provinsi }}</strong><br>Latitude: {{ $prov->latitude }}<br>Longitude: {{ $prov->longitude }}");
        @endif
    @endforeach
</script>
@endsection
