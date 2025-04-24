@extends('layouts.app')

@section('title', 'Clustering R/C')

@section('contents')
<div class="container-fluid py-4">
  <div class="card mb-4 shadow-sm">
    <div class="card-header bg-success text-dark">
      <h5 class="mb-0">Pilih Kategori Clustering R/C</h5>
    </div>
    <div class="card-body">
      <form method="GET" action="{{ route('clustering.show') }}">
        <div class="row gx-2 align-items-end">
          <div class="col-md-4">
            <label for="kategori" class="form-label">Kategori</label>
            <select id="kategori" name="kategori" class="form-select">
              <option value="desa"     {{ request('kategori')=='desa'?'selected':'' }}>Per Desa</option>
              <option value="kabupaten"{{ request('kategori')=='kabupaten'?'selected':'' }}>Per Kabupaten</option>
              <option value="upt"      {{ request('kategori')=='upt'?'selected':'' }}>Per UPT</option>
              <option value="komoditas"{{ request('kategori')=='komoditas'?'selected':'' }}>Per Komoditas</option>
            </select>
          </div>
          <div class="col-md-2">
            <button class="btn btn-primary w-100">Tampilkan</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  @if(isset($result) && count($result))
  <div class="card shadow-sm">
    <div class="card-header bg-success text-white">
      <h5 class="mb-0">Hasil Clustering {{ $judul }}</h5>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-striped table-hover align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>R/C</th>
              <th>Cluster</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($result as $i => $row)
            <tr>
              <td>{{ $i+1 }}</td>
              <td>{{ $row['nama'] }}</td>
              <td>{{ number_format($row['rc'],2) }}</td>
              <td><span class="badge bg-{{ ['success','warning','danger'][$row['cluster']-1] }}">
                C{{ $row['cluster'] }}
              </span></td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
  @elseif(request()->has('kategori'))
    <div class="alert alert-warning text-center">Tidak ada data untuk kategori <strong>{{ $judul }}</strong>.</div>
  @endif
</div>
@endsection
