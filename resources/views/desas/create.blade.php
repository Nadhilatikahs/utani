@extends('layouts.app')

@section('title', 'Tambah Data ')

@section('contents')
    <h1 class="mb-0">Desa</h1>
    <hr />
    <form action="{{ route('desas.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <fieldset disabled>
            <div class="mb-3">
                <label for="kodedesalabel">Kode Desa</label>
                <input class="form-control form-control-solid" id="kode_desa_tampil" name="kode_desa_tampil" type="text" placeholder="Contoh: desa-001" value="{{$kode_desa}}" readonly>
            </div>
        </fieldset>
        <input type="hidden" id="kode_desa" name="kode_desa" value="{{$kode_desa}}">

        <div class="row mb-3">
            <div class="col">
                <input type="hidden" name="id_desa" class="form-control" placeholder="ID">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <input type="text" name="nama_desa" class="form-control" placeholder="Nama desa" pattern="[A-Za-z\s]+" title="Hanya huruf yang diizinkan" required>
                @error('nama_desa')
                <div id="flash-message" class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col">
                <input type="text" name="alamat" class="form-control" placeholder="Alamat" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <input type="text" name="latitude" id="latitude" class="form-control" placeholder="Latitude" pattern="-?\d+(\.\d+)?" title="Harap masukkan titik latitude yang valid" required readonly>
            </div>
            <div class="col">
                <input type="text" name="longitude" id="longitude" class="form-control" placeholder="Longitude" pattern="-?\d+(\.\d+)?" title="Harap masukkan titik longitude yang valid" required readonly>
            </div>
        </div>

        <div class="form-group mb-3">
            <select class="form-control select" style="width:100%;" name="id_bpp" id="id_bpp">
                <option disabled selected value> Pilih Bpp</option>
                @foreach($bpps as $bp)
                    <option value="{{$bp->id_bpp}}">{{$bp->nama_bpp}}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <div id="map" style="height: 400px;"></div>
        </div>

        <div class="row">
            <div class="col text-left">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>

    <script>
        // sweet alert
        document.addEventListener('DOMContentLoaded', function () {
            const flashMessage = document.getElementById('flash-message');
            if (flashMessage) {
                setTimeout(function () {
                    flashMessage.style.display = 'none';
                }, 3000);
            }
        });
    </script>
@endsection

@section('script')
<script>
    // Inisialisasi peta
    var map = L.map('map').setView([-6.1751, 106.8650], 10); // Awal Jakarta

    // Tambahkan tile dari OSM
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap'
    }).addTo(map);

    var marker = null;

    function updateMarker(latlng) {
        if (marker) {
            map.removeLayer(marker);
        }
        marker = L.marker(latlng).addTo(map);

        var namaDesa = document.querySelector('input[name="nama_desa"]').value;
        if (namaDesa) {
            marker.bindPopup(namaDesa).openPopup();
        }

        document.getElementById('latitude').value = latlng.lat;
        document.getElementById('longitude').value = latlng.lng;
    }

    document.querySelector('input[name="nama_desa"]').addEventListener('input', function () {
        if (marker) {
            marker.bindPopup(this.value).openPopup();
        }
    });

    // Tambahkan geocoder
    var geocoder = L.Control.geocoder({
        defaultMarkGeocode: false
    }).on('markgeocode', function (e) {
        var bbox = e.geocode.bbox;
        var latlng = e.geocode.center;
        map.fitBounds([
            [bbox.getSouthWest().lat, bbox.getSouthWest().lng],
            [bbox.getNorthEast().lat, bbox.getNorthEast().lng]
        ]);
        updateMarker(latlng);
    }).addTo(map);

    // Klik peta untuk ambil lokasi
    map.on('click', function (e) {
        updateMarker(e.latlng);
    });

    // Tambahkan marker-marker BPP untuk referensi lokasi
    var bppData = @json($bpps);
    bppData.forEach(function (bp) {
        if (bp.latitude && bp.longitude) {
            L.marker([bp.latitude, bp.longitude])
                .addTo(map)
                .bindPopup("<b>" + bp.nama_bpp + "</b>");
        }
    });
</script>
@endsection
