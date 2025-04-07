<!-- resources/views/dashboard.blade.php -->
@extends('layouts.app')

@section('title', ' Panel')

@section('contents')
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Dashboard</h1>

<!-- Small Boxes (Stat Box) -->
<div class="row">
    <!-- Provinsi -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Provinsi</div>
                        <h4 class="font-weight-bold">{{ $provinsis }}</h4>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-map fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
            <a href="{{ route('provinsis.index') }}" class="card-footer d-flex align-items-center justify-content-between">
                <span class="text-primary">Lihat</span>
                <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    
    <!-- Kabupaten -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Kabupaten</div>
                        <h4 class="font-weight-bold">{{ $kabupatens }}</h4>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-map-marker-alt fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
            <a href="{{ route('kabupatens.index') }}" class="card-footer d-flex align-items-center justify-content-between">
                <span class="text-success">Lihat</span>
                <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    
    <!-- Dinas -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Dinas</div>
                        <h4 class="font-weight-bold">{{ $dinas }}</h4>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-building fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
            <a href="{{ route('dinas.index') }}" class="card-footer d-flex align-items-center justify-content-between">
                <span class="text-warning">Lihat</span>
                <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <!-- UPT -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Total UPT</div>
                        <h4 class="font-weight-bold">{{ $upts }}</h4>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-institution fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
            <a href="{{ route('upts.index') }}" class="card-footer d-flex align-items-center justify-content-between">
                <span class="text-danger">Lihat</span>
                <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <!-- BPP -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total BPP</div>
                        <h4 class="font-weight-bold">{{ $bpps }}</h4>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-pie-chart fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
            <a href="{{ route('bpps.index') }}" class="card-footer d-flex align-items-center justify-content-between">
                <span class="text-primary">Lihat</span>
                <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <!-- Desa -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Desa</div>
                        <h4 class="font-weight-bold">{{ $desas }}</h4>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-home fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
            <a href="{{ route('desas.index') }}" class="card-footer d-flex align-items-center justify-content-between">
                <span class="text-success">Lihat</span>
                <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <!-- Kelompok Tani -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Kelompok Tani</div>
                        <h4 class="font-weight-bold">{{ $kelompoktanis }}</h4>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
            <a href="{{ route('keltanis.index') }}" class="card-footer d-flex align-items-center justify-content-between">
                <span class="text-warning">Lihat</span>
                <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <!-- Anggota Tani -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Total Anggota Tani</div>
                        <h4 class="font-weight-bold">{{ $anggotatanis }}</h4>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
            <a href="{{ route('anggotatanis.index') }}" class="card-footer d-flex align-items-center justify-content-between">
                <span class="text-danger">Lihat</span>
                <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <!-- Lahan -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Lahan</div>
                        <h4 class="font-weight-bold">{{ $lahans }}</h4>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-tree fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
            <a href="{{ route('lahans.index') }}" class="card-footer d-flex align-items-center justify-content-between">
                <span class="text-primary">Lihat</span>
                <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <!-- Komoditas -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Komoditas</div>
                        <h4 class="font-weight-bold">{{ $komoditas }}</h4>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-leaf fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
            <a href="{{ route('komoditas.index') }}" class="card-footer d-flex align-items-center justify-content-between">
                <span class="text-success">Lihat</span>
                <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <!-- Beban -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Beban</div>
                        <h4 class="font-weight-bold">{{ $bebans }}</h4>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-balance-scale fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
            <a href="{{ route('bebans.index') }}" class="card-footer d-flex align-items-center justify-content-between">
                <span class="text-warning">Lihat</span>
                <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <!-- Kategori -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Total Kategori</div>
                        <h4 class="font-weight-bold">{{ $kategori }}</h4>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-tags fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
            <a href="{{ route('kategori.index') }}" class="card-footer d-flex align-items-center justify-content-between">
                <span class="text-danger">Lihat</span>
                <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
</div>
<!-- /.row -->
@endsection