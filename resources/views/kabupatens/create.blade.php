@extends('layouts.app')

@section('title', 'Tambah Data Kabupaten')

@section('style')
<style>
    #map {
        height: 70vh;
        width: 100%;
    }
</style>
@endsection

@section('contents')
    <h1 class="mb-0">Tambah Data Kabupaten</h1>
    <hr />

    @if ($errors->any())
        <div class="alert alert-danger">
            <b>Validation failed:</b>
            <ul class="mb-0">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('kabupatens.store') }}" method="POST">
        @csrf

        <fieldset disabled>
            <div class="mb-3">
                <label for="kode_kabupaten_tampil" class="form-label">Kode Kabupaten</label>
                <input class="form-control" id="kode_kabupaten_tampil" name="kode_kabupaten_tampil" type="text"
                    value="{{ $kode_kabupaten }}" readonly>
            </div>
        </fieldset>
        <input type="hidden" id="kode_kabupaten" name="kode_kabupaten" value="{{ $kode_kabupaten }}">

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="id_provinsi" class="form-label">Provinsi</label>
                <select name="id_provinsi" id="id_provinsi" class="form-control" required>
                    <option value="" disabled selected>Pilih Provinsi</option>
                    @foreach ($provinsis as $prov)
                        <option value="{{ $prov->id_provinsi }}" {{ old('id_provinsi') == $prov->id_provinsi ? 'selected' : '' }}>
                            {{ $prov->kode_provinsi ?? '' }} - {{ $prov->nama_provinsi }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label for="nama_kabupaten" class="form-label">Nama Kabupaten</label>
                <input type="text" name="nama_kabupaten" id="nama_kabupaten" class="form-control"
                    placeholder="Contoh: Bandung" value="{{ old('nama_kabupaten') }}" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="latitude" class="form-label">Latitude</label>
                <input type="text" name="latitude" id="latitude" class="form-control"
                    placeholder="Klik di peta untuk isi otomatis" value="{{ old('latitude') }}" readonly required>
            </div>
            <div class="col-md-6">
                <label for="longitude" class="form-label">Longitude</label>
                <input type="text" name="longitude" id="longitude" class="form-control"
                    placeholder="Klik di peta untuk isi otomatis" value="{{ old('longitude') }}" readonly required>
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label">Pilih Lokasi Kabupaten di Peta</label>
            <div id="map"></div>
        </div>

        <div class="text-left d-flex gap-2">
                <a href="{{ route('kabupatens.index') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan Data</button>
            </div>
    </form>
@endsection

@section('script')
<script>
    var kabupatens = @json($kabupatens ?? []);

    var map = L.map('map').setView([-2.5489, 118.0149], 5); // Indonesia center

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    var marker = null;

    function updateMarker(latlng, name = null) {
        if (marker) map.removeLayer(marker);
        marker = L.marker(latlng).addTo(map);
        if (name) marker.bindPopup(name).openPopup();
        document.getElementById('latitude').value = latlng.lat;
        document.getElementById('longitude').value = latlng.lng;
    }

    map.on('click', function(e) {
        const nama = document.getElementById('nama_kabupaten')?.value || 'Kabupaten baru';
        updateMarker(e.latlng, nama);
    });

    // Existing kabupaten markers (optional)
    kabupatens.forEach(function(kab) {
        if (kab.latitude && kab.longitude) {
            L.marker([kab.latitude, kab.longitude])
                .addTo(map)
                .bindPopup((kab.kode_kabupaten || '') + ' - ' + (kab.nama_kabupaten || ''));
        }
    });
</script>
@endsection
