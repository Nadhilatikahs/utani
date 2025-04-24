@extends('layouts.app')
@section('title', 'List')

@section('contents')
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0">Capaian R/C {{ $judul }}</h4>
            </div>
            <div class="card-body">
                {{-- <pre>{{ print_r($result, true) }}</pre> ini debug --}}
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>R/C</th>
                            <th>Cluster</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($result as $row)
                            <tr>
                                <td>{{ $row['nama'] }}</td>
                                <td>{{ number_format($row['rc'], 2) }}</td>
                                <td>Cluster {{ $row['cluster'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
