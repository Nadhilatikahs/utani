@extends('layouts.app')
  
@section('title', 'Edit Data Desa')
  
@section('contents')
    <h1 class="mb-0">Desa</h1>
    <hr />
    <form action="{{ route('desas.update', $desas->id_desa) }}" method="POST">
        @csrf
        @method('PUT')

        <fieldset disabled>
            <div class="mb-3">
                <label for="kodedesalabel">Kode Desa</label>
                <input class="form-control form-control-solid" id="kode_desa_tampil" name="kode_desa_tampil" type="text" value="{{ $desa->kode_desa }}" readonly>
            </div>
        </fieldset>
        <input type="hidden" id="kode_desa" name="kode_desa" value="{{ $desa->kode_desa }}">

        <div class="row mb-3">
            <div class="col">
                <input type="hidden" name="id_desa" class="form-control" value="{{ $desa->id_desa }}">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label for="nama_desa">Nama Desa</label>
                <input type="text" name="nama_desa" class="form-control" placeholder="Nama Desa" value="{{ $desa->nama_desa }}" pattern="[A-Za-z\s]+" title="Hanya huruf yang diizinkan" required>
                @error('nama_desa')
                    <div id="flash-message" class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col">
                <label for="alamat">Alamat</label>
                <input type="text" name="alamat" class="form-control" placeholder="Alamat" value="{{ $desa->alamat }}" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label for="latitude">Latitude (Garis Lintang)</label>
                <input type="text" name="latitude" id="latitude" class="form-control" placeholder="Latitude" value="{{ $desa->latitude }}" pattern="-?\d+(\.\d+)?" title="Harap masukkan titik latitude yang valid" required readonly>
            </div>
            <div class="col">
                <label for="longitude">Longitude (Garis Bujur)</label>
                <input type="text" name="longitude" id="longitude" class="form-control" placeholder="Longitude" value="{{ $desa->longitude }}" pattern="-?\d+(\.\d+)?" title="Harap masukkan titik longitude yang valid" required readonly>
            </div>
        </div>

        <div class="mb-3">
            <label for="id_bpp">BPP</label>
            <select class="form-control select" style="width: 100%;" name="id_bpp" id="id_bpp" required>
                <option disabled value="">Pilih BPP</option>
                @foreach($bpps as $bp)
                    <option value="{{ $bp->id_bpp }}" {{ $desa->id_bpp == $bp->id_bpp ? 'selected' : '' }}>{{ $bp->nama_bpp }}</option>
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
    var map = L.map('map').setView([{{ $desa->latitude }}, {{ $desa->longitude }}], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    var marker = L.marker([{{ $desa->latitude }}, {{ $desa->longitude }}]).addTo(map);
    marker.bindPopup("{{ $desa->nama_desa }}").openPopup();

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

    map.on('click', function(e) {
        updateMarker(e.latlng);
    });

    var geocoder = L.Control.geocoder({
        defaultMarkGeocode: false
    }).on('markgeocode', function(e) {
        var latlng = e.geocode.center;
        map.setView(latlng, 13);
        updateMarker(latlng);
    }).addTo(map);

    // Tambahkan marker BPP untuk referensi
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
