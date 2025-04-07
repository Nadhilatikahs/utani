<!-- /resources/views/products/index.blade.php -->
@extends('layouts.app')
  
@section('title', 'List')
  
@section('contents')
    <div class="d-flex align-items-center justify-content-between">
        <h1 class="mb-0"> Beban fix </h1>
        <a href="{{ route('bebanfix.create') }}" class="btn btn-primary">Tambah Data</a>
    </div>
    <hr />
    @if(Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif
    <table class="table table-hover">
        <thead class="table-primary">
            <tr>
                <th>Kode Beban FIX </th>
                <th>Keterangan</th>
               
                <th>Nominal</th>
               
               
                
               
                <th>Action</th>
            </tr>
        </thead>
        <tbody>+
           
                @forelse($bebanfixes as $bb)
                    <tr>
                        <td class="align-middle">{{ $bb->kode_beban_fix }}</td>
                        <td class="align-middle">{{ $bb->keterangan }}</td>
                        <!-- <td class="align-middle">{{ $bb->nama_komoditas }}</td> -->
                        <td class="align-middle">{{ $bb->nominal }}</td>
                        <!-- <td class="align-middle">{{ $bb->volume }}</td>
                        <td class="align-middle">{{ $bb->satuan }}</td> -->
                        <!-- <td class="align-middle">{{ number_format ($bb->harga_satuan) }}</td> -->
                        <!-- <td class="align-middle">{{number_format ($bb->volume*$bb->harga_satuan )}}</td> -->
                       
                       
                        <td class="align-middle">
                            <div class="btn-group" role="group" aria-label="Basic example">
                               
                                <a href="{{ route('bebans.edit', $bb->id_beban)}}" type="button" class="btn btn-warning">Edit</a>
                                <form action="{{ route('bebans.destroy', $bb->id_beban) }}" method="POST" type="button" class="btn btn-danger p-0" onsubmit="return confirm('Delete?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger m-0">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                
                @empty
                                  <div class="alert alert-danger">
                                      Data Beban belum Tersedia.
                                  </div>
             @endforelse
        </tbody>
    </table>
@endsection