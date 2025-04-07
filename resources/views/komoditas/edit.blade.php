<!-- //resources/views/products/edit.blade.php -->
@extends('layouts.app')
  
@section('title', 'Edit ')
  
@section('contents')
    <h1 class="mb-0">Komoditas</h1>
    <hr />
    <form action="komoditass.update, $komoditas->id_komoditas" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3"><label for="kodekomoditaslabel">Kode Komoditas </label>
                        <input class="form-control form-control-solid" id="kode_komoditas_tampil" name="kode_komoditas_tampil" type="text" placeholder="Contoh: komoditas-001" value="{{$kode_komoditas}}" readonly></div>
                    </fieldset>
                    <input type="hidden" id="kode_komoditas" name="kode_komoditas" value="{{$kode_komoditas}}">
        <input type="hidden" id="id_komoditas" name="id_komoditas" value="{{ $id_komoditas }}">
                <div class="form-row">
            
            <div class="col mb-3">
                <label class="form-label">Nama</label>
                <input type="text" name="nama_komoditas" class="form-control" placeholder="Nama Komoditas" value="{{ $nama_komoditas }}" >
            </div>
        </div>
        
            <div class="col mb-3">
            <div class="row">
                <label class="form-label">Kategori</label>
                <input type="text" name="kategori" class="form-control" placeholder="Kategori" value="{{ $kategori }}" >
            </div>
            </div>
            <div class="col mb-3">
            <div class="row">Harga Satuan</label>
                <input type="text" name="harga_satuan" class="form-control" placeholder="harga satuan" value="{{ $harga_satuan }}" >
            </div>
            
            
            
            
            
        </div>
        <div class="row">
            <div class="d-grid">
                <button class="btn btn-warning">Update</button>
            </div>
        </div>
    </form>
@endsection