<!-- //resources/views/products/create.blade.php -->
@extends('layouts.app')
  
@section('title', 'Tambah Data ')
  
@section('contents')
    <h1 class="mb-0">Beban</h1>
    <hr />
    <form action="{{ route('bebanfix.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <fieldset disabled>
                        <div class="mb-3"><label for="kodebebanfixlabel">Kode beban Fix</label>
                        <input class="form-control form-control-solid" id="kode_beban_fix_tampil" name="kode_beban_fix_tampil" type="text" placeholder="Contoh: BF-001" value="{{$kode_beban_fix}}" readonly></div>
                    </fieldset>
                    <input type="hidden" id="kode_beban_fix" name="kode_beban_fix" value="{{$kode_beban_fix}}">

        <div class="row mb-3">
        <div class="col">
                <input type="hidden" name="id_bebanfix" class="form-control" placeholder="ID">
            </div>
        
        </div>
        <div class="row mb-3">
        <div class="col">keterangan
                <input type="text" name="keterangan" class="form-control" placeholder="">
            </div>
        <div class="col">nominal
                <input type="number" name="nominal" class="form-control" placeholder="">
            </div>
           
       
            
        </div>
 
        <div class="row">
            <div class="d-grid">
                <a href="{{ route('bebanfix.index') }}" class="btn btn-secondary mr-2">Kembali</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
@endsection