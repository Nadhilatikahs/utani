<!-- //resources/views/products/create.blade.php -->
@extends('layouts.app')
  
@section('title', 'Tambah Data ')
  
@section('contents')
    <h1 class="mb-0">Kategori</h1>
    <hr />
    <form action="kategori.update, $kategori->id_kategori" method="POST">
        @csrf
        @method('PUT')
        <fieldset disabled>
                        <div class="mb-3"><label for="kodekategorilabel">Kode Kategori</label>
                        <input class="form-control form-control-solid" id="kode_kategori_tampil" name="kode_kategori_tampil" type="text" placeholder="Contoh: K-001" value="{{$kode_kategori}}" readonly></div>
                    </fieldset>
                    <input type="hidden" id="kode_kategori" name="kode_kategori" value="{{$kode_kategori}}">
        <div class="row mb-3">
            
            <div class="col">
                <input type="text" name="keterangan" class="form-control" placeholder="keterangan" value="{{$keterangan}}">
            </div>
        </div>
        
        
            
        
 
        <div class="row">
            <div class="col text-left d-flex gap-2">
                <a href="{{ route('kategori.index') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
@endsection