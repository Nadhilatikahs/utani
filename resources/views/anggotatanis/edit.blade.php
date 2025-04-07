<!-- //resources/views/products/edit.blade.php -->
@extends('layouts.app')
  
@section('title', 'Edit ')
  
@section('contents')
    <h1 class="mb-0">Data Anggota</h1>
    <hr />
    <form action="anggotatanis.update, $anggotatani->id_anggota" method="POST">
        @csrf
        @method('PUT')
        <fieldset disabled>
            <div class="mb-3">
                <label for="kodeanggotalabel">Kode Anggota Tani</label>
                <input class="form-control form-control-solid" id="kode_anggota_tampil" name="kode_anggota_tampil" type="text" placeholder="Contoh: anggota-001" value="{{$kode_anggota}}" readonly>
            </div>
        </fieldset>
        <input type="hidden" id="kode_anggota" name="kode_anggota" value="{{$kode_anggota}}">

        <div class="row mb-3">
            <div class="col">
                <input type="hidden" name="id_anggota" class="form-control" placeholder="ID" value="{{$id_anggota}}">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <input type="text" name="nama_anggota" class="form-control" placeholder="Nama anggota" value="{{$nama_anggota}}" pattern="[A-Za-z\s]+" title="Hanya huruf yang diizinkan" required>
                @error('nama_anggota')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="col">
                <input type="text" id="nik" name="nik" class="form-control" placeholder="NIK" value="{{$nik}}" maxlength="16" pattern="\d*"title="Harap masukkan angka 16 digit" required>
                @error('nik')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <input type="text" name="tempat_lahir" class="form-control" placeholder="Tempat Tgl Lahir" value="{{$tempat_lahir}}">
            </div>
            <div class="col">
                <input type="text" name="alamat" class="form-control" placeholder="Alamat" value="{{$alamat}}">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <input type="text" name="jenis_kelamin" class="form-control" placeholder="Jenis Kelamin" value="{{$jenis_kelamin}}">
            </div>
            <div class="col">
                <input type="text" name="no_hp" class="form-control" placeholder="No HP" value="{{$no_hp}}">
               
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <input type="text" name="status_anggota" class="form-control" placeholder="Status Anggota" value="{{$status_anggota}}">
            </div>
            <div class="col">
                <input type="text" name="kategori_petani" class="form-control" placeholder="Kategori Petani" value="{{$kategori_petani}}">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <input type="text" name="latitude" class="form-control" placeholder="Latitude" value="{{$latitude}}">
            </div>
            <div class="col">
                <input type="text" name="longitude" class="form-control" placeholder="Longitude" value="{{$longitude}}">
            </div>
        
       
        
            
            
        </div>
        <div class="row">
            <div class="col text-left">
                <button class="btn btn-warning">Update</button>
            </div>
        </div>
    </form>
@endsection