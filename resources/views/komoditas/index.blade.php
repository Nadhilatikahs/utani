<!-- /resources/views/products/index.blade.php -->
@extends('layouts.app')
  
@section('title', 'List')
  
@section('contents')
    <div class="d-flex align-items-center justify-content-between">
        <h1 class="mb-0"> Komoditas</h1>
        <a href="{{ route('komoditas.create') }}" class="btn btn-primary">Tambah Data</a>
    </div>
    <hr />
    @if(Session::has('success'))
        <div id="flash-message" class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif
    <table class="table table-hover">
        <thead class="table-primary">
            <tr>
                <th>ID </th>
                <th>Nama Komoditas</th>
                <th>Kategori</th>
                <th>Harga satuan</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>+
           
                @forelse($komoditas as $kd)
                    <tr>
                        <td class="align-middle">{{ $kd->kode_komoditas }}</td>
                        <td class="align-middle">{{ $kd->nama_komoditas }}</td>
                        <td class="align-middle">{{ $kd->kategori }}</td>
                        <td class="align-middle">Rp{{ number_format ($kd->harga_satuan) }}/kg</td>
                        
                       
                        <td class="align-middle">
                            
                               
                                <a href="{{ route('komoditas.edit', $kd->id_komoditas)}}" type="button" class="btn btn-success btn-circle">
                                <i class="fas fa-pencil-alt"></i></a>
                            <form action="{{ route('komoditas.destroy', $kd->id_komoditas) }}" method="POST" class="d-inline" id="delete-form-{{ $kd->id_komoditas }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="if(confirm('Apakah Anda yakin?')) document.getElementById('delete-form-{{ $kd->id_komoditas }}').submit();" class="btn btn-danger btn-circle">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                               
                            </div>
                        </td>
                    </tr>
                
                @empty
                                  <div class="alert alert-danger">
                                      Data Komoditas belum Tersedia.
                                  </div>
             @endforelse
        </tbody>
    </table>
@endsection