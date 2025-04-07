@extends('layouts.app')
  
@section('title', 'Tambah Data ')
  
@section('contents')
    <h1 class="mb-0">Panen</h1>
    <hr />
    <form action="{{ route('panen.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <fieldset disabled>
            <div class="mb-3"><label for="kodepanenlabel">Kode </label>
            <input class="form-control form-control-solid" id="kode_panen_tampil" name="kode_panen_tampil" type="text" placeholder="Contoh: P-001" value="{{$kode_panen}}" readonly></div>
        </fieldset>
        <input type="hidden" id="kode_panen" name="kode_panen" value="{{$kode_panen}}">

        <div class="row mb-3">
            <div class="col">
                <input type="hidden" name="id_panen" class="form-control" placeholder="ID">

                <div class="row mb-3">
                    <div class="form-group"> Tanam
                        <select class="form-control select" style="width:100%;" name="id_tanam" id="id_tanam">
                            <option disabled value>Pilih Data Tanam</option>
                            @foreach($tanams as $lh)
                                <option value="{{$lh->id_tanam}}">{{$lh->kode_tanam}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col">Tanggal Panen
                        <input type="date" name="tgal_panen" class="form-control" placeholder="Tanggal panen" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col">Kg
                        <input type="number" name="jumlah" class="form-control" placeholder="jumlah panen" max="999999" required>
                    </div>
                    <div class="col">Rp.
                        <input type="number" name="harga" class="form-control" placeholder="harga/satuan" max="999999" required>
                    </div>
                </div>

                <div class="row"> 
                    <div class="col text-left">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const jumlahInput = document.querySelector('input[name="jumlah"]');
            const hargaInput = document.querySelector('input[name="harga"]');

            // Batasi panjang input ke 6 digit
            jumlahInput.addEventListener('input', function() {
                if (jumlahInput.value.length > 6) {
                    jumlahInput.value = jumlahInput.value.slice(0, 6);
                }
            });

            hargaInput.addEventListener('input', function() {
                if (hargaInput.value.length > 6) {
                    hargaInput.value = hargaInput.value.slice(0, 6);
                }
            });
        });
    </script>
@endsection
