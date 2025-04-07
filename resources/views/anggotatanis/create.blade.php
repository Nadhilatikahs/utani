<!-- //resources/views/products/create.blade.php -->
@extends('layouts.app')
  
@section('title', 'Tambah Data ')
  
@section('contents')
    <h1 class="mb-0">Anggota Tani</h1>
    <hr />
    <form action="{{ route('anggotatanis.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <fieldset disabled>
            <div class="mb-3">
                <label for="kodeanggotalabel">Kode Anggota Tani</label>
                <input class="form-control form-control-solid" id="kode_anggota_tampil" name="kode_anggota_tampil" type="text" placeholder="Contoh: anggota-001" value="{{$kode_anggota}}" readonly>
            </div>
        </fieldset>
        <input type="hidden" id="kode_anggota" name="kode_anggota" value="{{$kode_anggota}}">

        <div class="row mb-3">
            <div class="col">
                <input type="hidden" name="id_anggota" class="form-control" placeholder="ID">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <input type="text" name="nama_anggota" class="form-control" placeholder="Nama anggota" pattern="[A-Za-z\s]+" title="Hanya huruf yang diizinkan" required>
                @error('nama_anggota')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col">
                <input type="text" id="nik" name="nik" class="form-control" placeholder="NIK" maxlength="16" pattern="\d*"title="Harap masukkan angka 16 digit" required>
                @error('nik')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <input type="text" name="tempat_lahir" class="form-control" placeholder="Tempat Tgl Lahir">
            </div>
            <div class="col">
                <input type="text" name="alamat" class="form-control" placeholder="Alamat">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <input type="text" name="jenis_kelamin" class="form-control" placeholder="Jenis Kelamin">
            </div>
            <div class="col">
                <input type="text" name="no_hp" class="form-control" placeholder="No HP">
               
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <input type="text" name="status_anggota" class="form-control" placeholder="Status Anggota">
            </div>
            <div class="col">
                <input type="text" name="kategori_petani" class="form-control" placeholder="Kategori Petani">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <input type="text" name="latitude" class="form-control" placeholder="Latitude">
            </div>
            <div class="col">
                <input type="text" name="longitude" class="form-control" placeholder="Longitude">
            </div>
        </div>

        <div class="form-group">
            <select class="form-control select" style="width:100%;" name="id_keltani" id="id_keltani">
                <option disabled value>Pilih Kelompok Tani</option>
                @foreach($kelompoktanis as $bp)
                    <option value="{{$bp->id_keltani}}">{{$bp->nama_keltani}}</option>
                @endforeach
            </select>
        </div>

        <div class="row">
            <div class="col text-left">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nikInput = document.getElementById('nik');

            nikInput.addEventListener('input', function() {
                let value = nikInput.value;

                // Batasi panjang input ke 16 karakter
                if (value.length > 16) {
                    nikInput.value = value.slice(0, 16);
                }
            });
        });
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
