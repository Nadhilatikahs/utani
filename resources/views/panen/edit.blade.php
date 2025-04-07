@extends('layouts.app')
  
@section('title', 'Edit ')
  
@section('contents')
    <h1 class="mb-0">Data</h1>
    <hr />
    <form action="panen.update, $panens->id_panen" method="POST">
        @csrf
        @method('PUT')
        <fieldset disabled>
                        <div class="mb-3"><label for="kodepanenlabel">Kode </label>
                        <input class="form-control form-control-solid" id="kode_panentampil" name="kode_panentampil" type="text" placeholder="Contoh: P-001" value="{{$kode_panen}}" readonly></div>
                    </fieldset>
                    <input type="hidden" id="kode_panen" name="kode_panen" value="{{$kode_panen}}">

                    <div class="row mb-3">
            <div class="col">
                <input type="hidden" name="id_panen" class="form-control" placeholder="ID" value="{{ $id_panen }}">
            
        
        
                <div class="row mb-3">
            <div class="col ">
                <label class="form-label">Tanggal Panen</label>
                <input type="date" name="tgal_panen" class="form-control" placeholder="Tanggal Panen" value="{{ $tgal_panen }}" >
            </div>
            </div>
            
            <div class="col ">
                <label class="form-label">Jumlah</label>
                <input type="text" name="jumlah" class="form-control" placeholder="jumlah" value="{{ $jumlah }}" >
            <div class="col text-left">
                <label class="form-label">Harga</label>
                <input type="text" name="harga" class="form-control" placeholder="Harga" value="{{ $harga }}" >
                </div>
            
                </div>
                </div>
            
            
                </div>
            
           
            

        
        <div class="row">
            <div class="d-grid">
                <button class="btn btn-warning">Update</button>
            </div>
        </div>
    </form>
@endsection