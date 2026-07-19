<!-- //resources/views/products/edit.blade.php -->
@extends('layouts.app')
  
@section('title', 'Edit ')
  
@section('contents')
    <h1 class="mb-0">Lahan</h1>
    <hr />
    <form action="lahans.update, $lahan->id_lahan" method="POST">
        @csrf
        @method('PUT')
        
        <fieldset disabled>
                        <div class="mb-3"><label for="kodelahanlabel">Kode Lahan </label>
                        <input class="form-control form-control-solid" id="kode_lahan_tampil" name="kode_lahan_tampil" type="text" placeholder="Contoh: lahan-001" value="{{$kode_lahan}}" readonly></div>
                    </fieldset>
                    <input type="hidden" id="kode_lahan" name="kode_lahan" value="{{$kode_lahan}}">
                    <div class="row mb-3">
        <div class="col">
                <input type="hidden" name="id_lahan" class="form-control" placeholder="ID" value="{{$id_lahan}}">
            </div>
            </div>
            <div class="row mb-3">
            <div class="col">
            <input type="number" name="luas" class="form-control" placeholder="Luas" value="{{$luas}}" required>
            </div>
            <div class="col">
                <input type="number" name="jml_petak" class="form-control" placeholder="jumlah Petak" value="{{$jml_petak}}" required>
            </div>
            <div class="form-group">
                <select class= "form-control select" style ="width:100%;" name="id_anggota" id="id_anggota">
                <option disabled value> Pilih Nama Anggota</option>
                @foreach($anggotatanis as $at)
                <option value="{{$at->id_anggota}}">{{$at->nama_anggota}}</option>
                @endforeach
                </select>
            </div>
    
        </div>
 
        <div class="row">
            <div class="col text-left d-flex gap-2">
                <a href="{{ route('lahans.index') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
@endsection