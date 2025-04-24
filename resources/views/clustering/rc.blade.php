@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Clustering Berdasarkan R/C Ratio</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama</th>
                <th>R/C Ratio</th>
                <th>Cluster</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
            <tr>
                <td>{{ $item->kode }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->rc_ratio }}</td>
                <td>Cluster {{ $item->cluster }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
