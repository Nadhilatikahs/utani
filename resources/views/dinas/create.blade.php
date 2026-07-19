<!-- //resources/views/products/create.blade.php -->
@extends('layouts.app')
  
@section('title', 'Tambah Data ')

@section('style')
<style>
    #map {
        height: 70vh; /* Full screen height */
        width: 100%; /* Full screen width */
    }
</style>
@endsection
  
@section('contents')
    <h1 class="mb-0">Dinas</h1>
    <hr />
    <form action="{{ route('dinas.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <fieldset disabled>
                        <div class="mb-3"><label for="kodedinaslabel">Kode Dinas</label>
                        <input class="form-control form-control-solid" id="kode_dinas_tampil" name="kode_dinas_tampil" type="text" placeholder="Contoh: DN-001" value="{{$kode_dinas}}" readonly></div>
                    </fieldset>
                    <input type="hidden" id="kode_dinas" name="kode_dinas" value="{{$kode_dinas}}">
        <div class="row mb-3">
        <div class="col">
                <input type="hidden" name="id_dinas" class="form-control" placeholder="ID">
            </div>
            </div>
            <div class="row mb-3">
        <div class="col">
                <input type="text" name="nama_dinas" class="form-control" placeholder="Nama dinas" pattern="[A-Za-z\s]+" title="Hanya huruf yang diizinkan" required>
                @error('nama_dinas')
                <div id="flash-message" class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="row mb-3">
        <div class="col">
                <input type="text" name="alamat" class="form-control" placeholder="Alamat" required>
            </div>
            </div>
        <div class="row mb-3">
            <div class="col">
                <input type="text" name="latitude" id="latitude" class="form-control" placeholder="Latitude"pattern="-?\d+(\.\d+)?" title="Harap masukkan titik latitude yang valid" readonly required>
                @error('latitude')
                <div id="flash-message" class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col">
                <input type="text" name="longitude" id="longitude" class="form-control" placeholder="longitude"pattern="-?\d+(\.\d+)?" title="Harap masukkan titik latitude yang valid" readonly required>
                @error('longitude')
                <div id="flash-message" class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <select class= "form-control select" style ="width:100%;" name="id_kabupaten" id="id_kabupaten">
                <option disabled value> Pilih Kabupaten</option>
                @foreach($kabupatens as $kb)
                <option value="{{$kb->id_kabupaten}}">{{$kb->nama_kabupaten}}</option>
                @endforeach
                </select>
            </div>

            
            
        </div>
        <div class="mb-3">
            <div id="map"></div>
        </div>
        <div class="row">
            <div class="col text-left d-flex gap-2">
                <a href="{{ route('dinas.index') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>

    <script>
    //sweet alert
        document.addEventListener('DOMContentLoaded', function() {
        const flashMessage = document.getElementById('flash-message');
        if (flashMessage) {
            setTimeout(function() {
                flashMessage.style.display = 'none';
            }, 3000); // 5000 ms = 5 detik
        }
    });
    </script>
@endsection

@section('script')
@section('script')
<script>
    // Initialize the map
    var map = L.map('map').setView([-6.1751, 106.8650], 13); // Coordinates for Jakarta

    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Variable to hold the single marker
    var marker = null;

    // Function to update marker and form inputs
    function updateMarker(latlng, name = null) {
        // Remove the existing marker if it exists
        if (marker) {
            map.removeLayer(marker);
        }

        // Add a new marker
        marker = L.marker(latlng).addTo(map);

        // Optionally bind a popup to the marker
        if (name) {
            marker.bindPopup(name).openPopup();
        }

        // Update the form inputs with latitude and longitude
        document.getElementById('latitude').value = latlng.lat;
        document.getElementById('longitude').value = latlng.lng;
    }

    // Add Leaflet Control Geocoder
    var geocoder = L.Control.geocoder({
        defaultMarkGeocode: false // Don't add marker automatically
    })
    .on('markgeocode', function(e) {
        var bbox = e.geocode.bbox;
        var latlng = e.geocode.center;

        // Move the map to the selected location
        map.fitBounds([
            [bbox.getSouthWest().lat, bbox.getSouthWest().lng],
            [bbox.getNorthEast().lat, bbox.getNorthEast().lng]
        ]);

        // Update marker and inputs
        updateMarker(latlng, e.geocode.name);
    })
    .addTo(map);

    // Add event listener to detect click on the map
    map.on('click', function(e) {
        // Update marker and inputs
        updateMarker(e.latlng);
    });

    // Tambahan: Plot semua lokasi Dinas yang sudah ada
    const lokasiData = @json($lokasis);

    lokasiData.forEach(function(lokasi) {
        if (lokasi.latitude && lokasi.longitude) {
            const existingMarker = L.marker([lokasi.latitude, lokasi.longitude])
                .addTo(map)
                .bindPopup(`<strong>${lokasi.nama_dinas}</strong><br>Lat: ${lokasi.latitude}<br>Lng: ${lokasi.longitude}`);
        }
    });
</script>


@endsection