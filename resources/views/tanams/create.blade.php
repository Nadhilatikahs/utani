<!-- //resources/views/products/create.blade.php -->
@extends('layouts.app')
  
@section('title', 'Tambah Data ')
  
@section('contents')
    <h1 class="mb-0">Siklus Tanam</h1>
    <hr />
    <form action="{{ route('tanams.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <fieldset disabled>
                        <div class="mb-3"><label for="kodetanamlabel">Kode </label>
                        <input class="form-control form-control-solid" id="kode_tanam_tampil" name="kode_tanam_tampil" type="text" placeholder="Contoh: tanam-001" value="{{$kode_tanam}}" readonly></div>
                    </fieldset>
                    <input type="hidden" id="kode_tanam" name="kode_tanam" value="{{$kode_tanam}}">

        <div class="row mb-3">
        <div class="col">
                <input type="hidden" name="id_tanam" class="form-control" placeholder="ID">


        <div class="row mb-3">
            
            
            <div class="form-group"> lahan
                <select class= "form-control select" style ="width:100%;" name="id_lahan" id="id_lahan">
                <option disabled value> Pilih lahan</option>
                @foreach($lahans as $lh)
                <option value="{{$lh->id_lahan}}">{{$lh->kode_lahan}}</option>
                @endforeach
                </select>
            </div>
            
            <div class="form-group">komoditas
                <select class= "form-control select" style ="width:100%;" name="id_komoditas" id="id_komoditas">
                <option disabled value> Pilih Komoditas</option>
                @foreach($komoditas as $kd)
                <option value="{{$kd->id_komoditas}}">{{$kd->nama_komoditas}}</option>
                @endforeach
                </select>

                
            </div>

            <div class="col">Tanggal Tanam
                <input type="date" name="tgl_tanam" class="form-control" placeholder="Tanggal Tanam">
            </div>
           </div>
            
        
 
        <div class="row"> 
            
            <div class="col text-left">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
        
    </form>
@endsection