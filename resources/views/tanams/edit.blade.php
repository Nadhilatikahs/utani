<!-- //resources/views/products/edit.blade.php -->
@extends('layouts.app')
  
@section('title', 'Edit ')
  
@section('contents')
    <h1 class="mb-0">Data</h1>
    <hr />
    <form action="tanams.update, $tanams->id_tanam" method="POST">
        @csrf
        @method('PUT')
        <fieldset disabled>
                        <div class="mb-3"><label for="kodetanamlabel">Kode </label>
                        <input class="form-control form-control-solid" id="kode_tanam_tampil" name="kode_tanam_tampil" type="text" placeholder="Contoh: tanam-001" value="{{$kode_tanam}}" readonly></div>
                    </fieldset>
                    <input type="hidden" id="kode_tanam" name="kode_tanam" value="{{$kode_tanam}}">

                    <div class="row mb-3">
        <div class="col">
                <input type="hidden" name="id_tanam" class="form-control" placeholder="ID" value="{{$id_tanam}}">
            
        
        
            <div class="col mb-3">
                <label class="form-label">Tanggal Tanam</label>
                <input type="date" name="tgl_tanam" class="form-control" placeholder="tanggal tanam" value="{{ $tgl_tanam }}" >
                </div>
            
                </div>
            
            
                </div>
        
        <div class="row">
            <div class="col text right">
                <button class="btn btn-warning">Update</button>
            </div>
        </div>
    </form>
@endsection