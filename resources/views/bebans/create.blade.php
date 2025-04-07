<!-- //resources/views/products/create.blade.php -->
@extends('layouts.app')
  
@section('title', 'Tambah Data ')
  
@section('contents')
    <h1 class="mb-0">Beban</h1>
    <hr />
    <form action="{{ route('bebans.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <fieldset disabled>
                        <div class="mb-3"><label for="kodebebanlabel">Kode Beban</label>
                        <input class="form-control form-control-solid" id="kode_beban_tampil" name="kode_beban_tampil" type="text" placeholder="Contoh: BB-001" value="{{$kode_beban}}" readonly></div>
                    </fieldset>
                    <input type="hidden" id="kode_beban" name="kode_beban" value="{{$kode_beban}}">

        <div class="row mb-3">
        <div class="col">
                <input type="hidden" name="id_beban" class="form-control" placeholder="ID">
            </div>
        
        </div>
        <div class="row mb-3"> 
        <div class="col">Nama Beban
                <input type="text" name="nama_beban" class="form-control" placeholder="" required>
            </div>
            <div class="col">Kategori Beban
                <label for="kategori"></label>
                <select class="form-control select" style="width:100%;" name="kategori" id="kategori">
                    <option disabled value>Pilih Kategori</option>
                    <option value="Persiapan Lahan">Persiapan Lahan</option>
                    <option value="Pemupukan">Pemupukan</option>
                    <option value="Pemeliharaan">Pemeliharaan</option>
                    <option value="Pasca Panen">Panen dan Pasca Panen</option>
                    <option value="Pajak">Pajak</option>
                </select>
            </div>
            
           
            <div class="row mb-3"> 
            <div class="form-group"> keterangan
                <select class= "form-control select" style ="width:100%;" name="id_kategori" id="id_kategori">
                <option disabled value> Pilih Keterangan</option>
                @foreach($kategori as $k)
                <option value="{{$k->id_kategori}}">{{$k->keterangan}}</option>
                @endforeach
                </select>
            </div> 
            
        </div>
        </div>
        <div class="row mb-3">
            <div class="col text-left">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
@endsection