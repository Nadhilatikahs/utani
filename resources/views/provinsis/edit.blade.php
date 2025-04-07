<!-- //resources/views/products/edit.blade.php -->
@extends('layouts.app')
  
@section('title', 'Edit ')
  
@section('contents')
    <h1 class="mb-0">Provinsi</h1>
    <hr />
    <form action="provinsis.update, $provinsi->id_provinsi" method="POST">
        @csrf
        @method('PUT')
        <fieldset disabled>
                        <div class="mb-3"><label for="kodeprovinsilabel">Kode provinsi</label>
                        <input class="form-control form-control-solid" id="kode_provinsi_tampil" name="kode_provinsi_tampil" type="text" placeholder="Contoh: PL-001" value="{{$kode_provinsi}}" readonly></div>
                    </fieldset>
                    <input type="hidden" id="kode_provinsi" name="kode_provinsi" value="{{$kode_provinsi}}">
                    
        <div class="row">
            
                
                <input type="hidden" name="id_provinsi" class="form-control" placeholder="ID" value="{{ $id_provinsi }}" >
            
            <div class="col mb-3">
                <label class="form-label">Nama</label>
                <input type="text" name="nama_provinsi" class="form-control" placeholder="Nama Provinsi" value="{{ $nama_provinsi }}" pattern="[A-Za-z\s]+" title="Hanya huruf yang diizinkan" required>
            </div>
        </div>
        <div class="row">
            <div class="col mb-3">
                <label class="form-label">Latitude</label>
                <input type="text" name="latitude" id="latitude" class="form-control" placeholder="Latitude" value="{{ $latitude }}" pattern="-?\d+(\.\d+)?" title="Harap masukkan titik latitude yang valid" readonly required >
            </div>
            <div class="col mb-3">
                <label class="form-label">Longitude</label>
                <input type="text" name="longitude" id="longitude" class="form-control" placeholder="longitude" value="{{ $longitude }}" pattern="-?\d+(\.\d+)?" title="Harap masukkan titik longitude yang valid" readonly required>
            </div>
        </div>
        <div class="mb-3">
            <div id="map"></div>
        </div>
        <div class="row">
            <div class="d-grid">
                <button class="btn btn-warning">Update</button>
            </div>
        </div>
    </form>
@endsection

@section('script')
<script>
    // Initialize the map
    var map = L.map('map').setView([{{ $latitude }}, {{ $longitude }}], 13); // Use coordinates from database

    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Variable to hold the marker
    var marker = L.marker([{{ $latitude }}, {{ $longitude }}]).addTo(map);

    // Function to update marker and form inputs
    function updateMarker(latlng, name = null) {
        // Remove the existing marker
        if (marker) {
            map.removeLayer(marker);
        }

        // Add a new marker at the new location
        marker = L.marker(latlng).addTo(map);

        // Optionally bind a popup
        if (name) {
            marker.bindPopup(name).openPopup();
        }

        // Update the form inputs with the new latitude and longitude
        document.getElementById('latitude').value = latlng.lat;
        document.getElementById('longitude').value = latlng.lng;
    }

    // Allow user to move the marker by clicking on the map
    map.on('click', function(e) {
        updateMarker(e.latlng);
    });

    // Add Leaflet Control Geocoder for searching
    var geocoder = L.Control.geocoder({
        defaultMarkGeocode: false
    })
    .on('markgeocode', function(e) {
        var latlng = e.geocode.center;

        // Update the map and marker
        map.setView(latlng, 13);
        updateMarker(latlng, e.geocode.name);
    })
    .addTo(map);
</script>
@endsection