<!-- //resources/views/products/edit.blade.php -->
@extends('layouts.app')

@section('title', 'Edit Data')

@section('contents')
    <h1 class="mb-0">Edit Beban Tanam</h1>
    <hr />
    <form action="bebantanam.update, $bebantanam->id_bebantanam" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <fieldset disabled>
            <div class="mb-3">
                <label for="kodebebantanamlabel">Kode </label>
                <input class="form-control form-control-solid" id="kode_bebantanam_tampil" name="kode_bebantanam_tampil" type="text" placeholder="Contoh: bebantanam-001" value="{{$kode_bebantanam}}" readonly>
            </div>
        </fieldset>
        <input type="hidden" id="kode_bebantanam" name="kode_bebantanam" value="{{$kode_bebantanam}}">

        <div class="row mb-3">
            <div class="col">
                <input type="hidden" name="id_bebantanam" class="form-control" placeholder="ID" value="{{$id_tanam}}">
                <div class="row"> 
                    <div class="col text-left"> kode tanam
                        <select class="form-control select" style="width:100%;" name="id_tanam" id="id_tanam" value="{{$id_tanam}}">
                            <option disabled value> Pilih Tanam</option>
                            @foreach($tanams as $tm)
                                <option value="{{$tm->id_tanam}}">{{$tm->kode_tanam}}</option>
                            @endforeach
                        </select>
                    </div> 
                </div> 
                <div class="form-group"> nama beban
                    <select class="form-control select" style="width:100%;" name="id_beban" id="id_beban" >
                        <option disabled value> Pilih Beban</option>
                        @foreach($bebans as $bb)
                            <option value="{{$bb->id_beban}}">{{$bb->nama_beban}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col">
                    <label for="satuan"></label>
                    <select name="satuan" id="satuan" class="form-control" value="{{$satuan}}">
                        <option value="">Pilih Satuan</option>
                        <option value="kg">Kg</option>
                        <option value="g">g</option>
                        <option value="l">L</option>
                        <option value="ml">ml</option>
                        <option value="HOK">HOK</option>
                        <option value="Ha">Ha</option>
                        <option value="bata">bata</option>
                    </select>
                </div>
                <div class="col"> jumlah
                    <input type="number" name="jumlah" id="jumlah" class="form-control" placeholder="jumlah" value="{{$jumlah}}" min="0" max="99" required>
                </div>
                <div class="col"> harga
                    <input type="number" name="harga" id="harga" class="form-control" placeholder="harga" value="{{$harga}}" min="0" max="999999" required>
                </div>
            </div>
        </div>
        
        <div class="row"> 
            <div class="col text-left">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const jumlahInput = document.getElementById('jumlah');
            const hargaInput = document.getElementById('harga');

            jumlahInput.addEventListener('input', function() {
                let value = jumlahInput.value;
                
                // Batasi panjang input ke 2 digit
                if (value.length > 2) {
                    jumlahInput.value = value.slice(0, 2);
                }
            });

            hargaInput.addEventListener('input', function() {
                let value = hargaInput.value;
                
                // Batasi panjang input ke 6 digit
                if (value.length > 6) {
                    hargaInput.value = value.slice(0, 6);
                }
            });
        });
    </script>
@endsection
