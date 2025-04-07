@extends('layouts.app')
  
@section('title', 'Tambah Data')

@section('style')
<style>
    #map {
        height: 70vh; /* Full screen height */
        width: 100%; /* Full screen width */
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
                <label for="kodeprovinsilabel">Kode provinsi</label>
                <input class="form-control form-control-solid" id="kode_provinsi_tampil" name="kode_provinsi_tampil" type="text" placeholder="Contoh: PR-001" value="{{ $kode_provinsi }}" readonly>
            </div>
        </fieldset>
        <input type="hidden" id="kode_provinsi" name="kode_provinsi" value="{{ $kode_provinsi }}">
        <div class="row mb-3">
            <div class="col">
                <input type="text" name="nama_provinsi" class="form-control" placeholder="Nama Provinsi" pattern="[A-Za-z\s]+" title="Hanya huruf yang diizinkan" required>
                @error('nama_provinsi')
                <div id="flash-message" class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <input type="text" name="latitude" id="latitude" class="form-control" placeholder="Latitude" pattern="-?\d+(\.\d+)?" title="Harap masukkan angka desimal yang valid, seperti -6.975353" readonly required>
                @error('latitude')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col">
                <input type="text" name="longitude" id="longitude" class="form-control" placeholder="Longitude" pattern="-?\d+(\.\d+)?" title="Harap masukkan angka desimal yang valid, seperti 106.823453" readonly required>
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

    <!-- Tambah Data Menggunakan Modal -->
    {{-- <div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="tambahModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahModalLabel">Tambah Data Provinsi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form untuk input -->
                    <form action="{{ route('provinsis.store') }}" method="POST" class="formtambahprovinsi">
                        @csrf
                        <fieldset disabled>
                            <div class="mb-3">
                                <label for="kodeprovinsilabel">Kode provinsi</label>
                                <input class="form-control form-control-solid" id="kode_provinsi_tampil" name="kode_provinsi_tampil" type="text" placeholder="Contoh: PR-001" value="{{ $kode_provinsi }}" readonly>
                            </div>
                        </fieldset>
                        <input type="hidden" id="kode_provinsi" name="kode_provinsi" value="{{ $kode_provinsi }}">
                        <div class="mb-3 row">
                            <label for="nama_provinsi" class="col-sm-4 col-form-label">Nama Provinsi</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="nama_provinsi" name="nama_provinsi" placeholder="Nama Provinsi" required>
                                @error('nama_provinsi')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="latitude" class="col-sm-4 col-form-label">Latitude</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="latitude" name="latitude" placeholder="Latitude" required>
                                @error('latitude')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="longitude" class="col-sm-4 col-form-label">Longitude</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="longitude" name="longitude" placeholder="Longitude" required>
                                @error('longitude')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btnsimpan">Simpan</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- Akhir Tambah Data Menggunakan Modal -->
     
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
</script>
@endsection
