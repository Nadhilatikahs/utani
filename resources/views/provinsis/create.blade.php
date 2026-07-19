@extends('layouts.app')
  
@section('title', 'Tambah Data')

@section('style')
<style>
    #map {
        height: 70vh;
        width: 100%;
    }
</style>
@endsection

@section('contents')
    <h1 class="mb-0">Tambah Data Provinsi</h1>
    <hr />
    <form action="{{ route('provinsis.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <fieldset disabled>
            <div class="mb-3">
                <label for="kode_provinsi_tampil" class="form-label">Kode Provinsi</label>
                <input class="form-control" id="kode_provinsi_tampil" name="kode_provinsi_tampil" type="text" value="{{ $kode_provinsi }}" readonly>
            </div>
        </fieldset>
        <input type="hidden" id="kode_provinsi" name="kode_provinsi" value="{{ $kode_provinsi }}">
        
        <div class="mb-3">
            <label for="nama_provinsi" class="form-label">Nama Provinsi</label>
            <input type="text" name="nama_provinsi" class="form-control" placeholder="Contoh: Jawa Barat" pattern="[A-Za-z\s]+" title="Hanya huruf yang diizinkan" required>
            @error('nama_provinsi')
            <div id="flash-message" class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="latitude" class="form-label">Latitude (Garis Lintang)</label>
                <input type="text" name="latitude" id="latitude" class="form-control" placeholder="Contoh: -6.975353" pattern="-?\d+(\.\d+)?" title="Masukkan angka desimal, contoh: -6.975353" readonly required>
                @error('latitude')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="longitude" class="form-label">Longitude (Garis Bujur)</label>
                <input type="text" name="longitude" id="longitude" class="form-control" placeholder="Contoh: 106.823453" pattern="-?\d+(\.\d+)?" title="Masukkan angka desimal, contoh: 106.823453" readonly required>
                @error('longitude')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label">Pilih Lokasi Provinsi di Peta</label>
            <div id="map"></div>
        </div>

        <div class="text-left d-flex gap-2">
                <a href="{{ route('provinsis.index') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan Data</button>
            </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const flashMessage = document.getElementById('flash-message');
            if (flashMessage) {
                setTimeout(() => flashMessage.style.display = 'none', 3000);
            }
        });
    </script>
@endsection

@section('script')
<script>
    var provinsis = @json($provinsis);
    var map = L.map('map').setView([-2.5489, 118.0149], 5); // Pusat Indonesia

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    var marker = null;

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

    var geocoder = L.Control.geocoder({
        defaultMarkGeocode: false
    }).on('markgeocode', function(e) {
        var bbox = e.geocode.bbox;
        var latlng = e.geocode.center;
        map.fitBounds([
            [bbox.getSouthWest().lat, bbox.getSouthWest().lng],
            [bbox.getNorthEast().lat, bbox.getNorthEast().lng]
        ]);
        updateMarker(latlng, e.geocode.name);
    }).addTo(map);

    map.on('click', function(e) {
        updateMarker(e.latlng);
    });

    provinsis.forEach(function(provinsi) {
        if (provinsi.latitude && provinsi.longitude) {
            L.marker([provinsi.latitude, provinsi.longitude])
                .addTo(map)
                .bindPopup(provinsi.kode_provinsi + ' - ' + provinsi.nama_provinsi);
        }
    });
</script>
@endsection
