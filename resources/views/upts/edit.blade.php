<!-- //resources/views/products/edit.blade.php -->
@extends('layouts.app')
  
@section('title', 'Edit ')

@section('style')
<style>
    #map {
        height: 70vh; /* Full screen height */
        width: 100%; /* Full screen width */
    }
</style>
@endsection
  
@section('contents')
    <h1 class="mb-0">Unit Pelaksana Teknis</h1>
    <hr />
    <form action="upts.update, $upts->id_upt" method="POST">
        @csrf
        @method('PUT')
        @csrf
        <fieldset disabled>
                        <div class="mb-3"><label for="kodeuptlabel">Kode UPT</label>
                        <input class="form-control form-control-solid" id="kode_upt_tampil" name="kode_upt_tampil" type="text" placeholder="Contoh: UPT-001" value="{{$kode_upt}}" readonly></div>
                    </fieldset>
                    <input type="hidden" id="kode_upt" name="kode_upt" value="{{$kode_upt}}">

        <div class="row mb-3">
        <div class="col">
                <input type="hidden" name="id_upt" class="form-control" placeholder="ID" value="{{$id_upt}}">
            </div>
        
        </div>
        <div class="row mb-3">
        <div class="col">
                <input type="text" name="nama_upt" class="form-control" placeholder="Nama upt" value="{{$nama_upt}}"pattern="[A-Za-z\s]+" title="Hanya huruf yang diizinkan" required>
            </div>
        <div class="col">
                <input type="text" name="alamat" class="form-control" placeholder="Alamat" value="{{$alamat}}" required>
            </div>
            </div>
        <div class="row mb-3">
            <div class="col">
                <input type="text" name="latitude" id="latitude" class="form-control" placeholder="Latitude" value="{{$latitude}}" pattern="-?\d+(\.\d+)?" title="Harap masukkan titik latitude yang valid" required readonly>
            </div>
            <div class="col">
                <input type="text" name="longitude" id="longitude" class="form-control" placeholder="longitude" value="{{$longitude}}" pattern="-?\d+(\.\d+)?" title="Harap masukkan titik longitude yang valid"required readonly>
            </div>

            <div class="form-group">
                <select class= "form-control select" style ="width:100%;" name="id_dinas" id="id_dinas">
                <option disabled value> Pilih Dinas</option>
                @foreach($dinas as $dn)
                <option value="{{$dn->id_dinas}}">{{$dn->nama_dinas}}</option>
                @endforeach
                </select>
            </div>

            
            
        </div>
 
        <div class="row">
            <div class="col text-left d-flex gap-2">
                <a href="{{ route('upts.index') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Submit</button>
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