<!-- //resources/views/products/create.blade.php -->
@extends('layouts.app')
  
@section('title', 'Tambah Data ')
  
@section('contents')
    <h1 class="mb-0">Komoditas</h1>
    <hr />
    <form action="{{ route('komoditas.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <fieldset disabled>
            <div class="mb-3">
                <label for="kodekomoditaslabel">Kode Komoditas</label>
                <input class="form-control form-control-solid" id="kode_komoditas_tampil" name="kode_komoditas_tampil" type="text" placeholder="Contoh: komoditas-001" value="{{$kode_komoditas}}" readonly>
            </div>
        </fieldset>
        <input type="hidden" id="kode_komoditas" name="kode_komoditas" value="{{$kode_komoditas}}" >
        
        <div class="col">
            <input type="hidden" name="id_komoditas" class="form-control" placeholder="ID Komoditas">
        </div>
        
        <div class="row mb-3">
            <div class="col">
                <input type="text" name="nama_komoditas" class="form-control" placeholder="Nama Komoditas" pattern="[A-Za-z\s]+" title="Hanya huruf yang diizinkan" required>
            </div>
        </div>
        
        <div class="row mb-3">
            <div class="col">
                <input type="text" name="kategori" class="form-control" placeholder="Kategori">
            </div>
            <div class="col">
                <input type="text" id="harga_satuan" name="harga_satuan" class="form-control" placeholder="Harga Satuan" maxlength="7" pattern="\d*" title="Harap masukkan angka hingga 7 digit">
            </div>
        </div>
 
        <div class="row">
            <div class="col text-left d-flex gap-2">
                <a href="{{ route('komoditas.index') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const hargaSatuanInput = document.getElementById('harga_satuan');

            hargaSatuanInput.addEventListener('input', function() {
                let value = hargaSatuanInput.value;

                // Batasi panjang input ke 7 karakter
                if (value.length > 7) {
                    hargaSatuanInput.value = value.slice(0, 7);
                }
            });
        });
    </script>
@endsection
