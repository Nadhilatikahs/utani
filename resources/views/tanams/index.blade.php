<!-- /resources/views/products/index.blade.php -->
@extends('layouts.app')
  
@section('title', 'List')
  
@section('contents')
    <div class="d-flex align-items-center justify-content-between">
        <h1 class="mb-0"> Data Tanam</h1>
        <a href="{{ route('tanams.create') }}" class="btn btn-primary">Tambah Data</a>
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
                <th>Kode tanam</th>
                <th>Kode Lahan</th>
                <th>Komoditas</th>
                <th>Tanggal Tanam</th>
                <th>Tanggal Panen</th>
                <th>R/C</th>
                <th>Volume Panen</th>
                <th>Beban Variabel</th>
                <th>Beban Fixed</th>
                <th>Keuntungan</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>+
           
                @forelse($tanams as $tm)
                    <tr>
                        <td class="align-middle">{{ $tm->kode_tanam }}</td>
                        <td class="align-middle">{{ $tm->kode_lahan }}</td>
                        <td class="align-middle">{{ $tm->nama_komoditas }}</td>
                        <td class="align-middle">
    @if($tm->tgl_tanam)
        {{ date('d F Y', strtotime($tm->tgl_tanam)) }}
    @else
        <!-- Tampilkan pesan atau nilai default jika tanggal tanam kosong -->
        -
    @endif
</td>
<td class="align-middle">
    @if($tm->tgl_panen)
        {{ date('d F Y', strtotime($tm->tgl_panen)) }}
    @else
        <!-- Tampilkan pesan atau nilai default jika tanggal panen kosong -->
        -
    @endif
</td>

<td class="align-middle">
    @php
        $bebanTotal = (float)$tm->beban_variabel + (float)$tm->beban_fix;
    @endphp

    @if ($bebanTotal != 0)
        {{ round(((float)$tm->keuntungan) / $bebanTotal, 2) }}
    @else
        0
    @endif
</td>

<style>
    .text-right {
        text-align: right;
    }
</style>

                        <td class="align-middle  text-right">@if($tm->volume_panen)
                            Rp.{{format_uang ($tm->volume_panen) }}
                            @else 
                            - 
                            
                            @endif</td>

                        <td class="align-middle text-right">@if($tm->beban_variabel)
                            Rp.{{format_uang ($tm->beban_variabel) }}
                            @else 
                            - 
                            
                            @endif</td>
                        </td>

                        <td class="align-middle text-right">@if($tm->beban_fix)
                            Rp.{{format_uang ($tm->beban_fix) }}
                            @else 
                            - 
                            
                            @endif</td>
                        <td class="align-middle text-right">@if($tm->keuntungan)
                            Rp.{{format_uang ($tm->keuntungan) }}
                            @else 
                            - 
                            
                            @endif
                        </td>
                       
                       
                        <td class="align-middle">
                            <div class="btn-group" role="group" aria-label="Basic example">
                               
                                <a href="{{ route('tanams.edit', $tm->id_tanam)}}" type="button" class="btn btn-warning">Edit</a>
                                <form action="{{ route('tanams.destroy', $tm->id_tanam) }}" method="POST" type="button" class="btn btn-danger p-0" onsubmit="return confirm('Delete?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger m-0">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                
                @empty
                                  <div class="alert alert-danger">
                                      Data Tanam Belum Tersedia.
                                  </div>
             @endforelse
        </tbody>
    </table>
@endsection