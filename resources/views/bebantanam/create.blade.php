@extends('layouts.app')

@section('title', 'Pilih Tanam - Input Beban Tanam')

@section('contents')
    <div class="d-flex align-items-center justify-content-between">
        <div>
            <h1 class="mb-0">Tambah Data Beban Tanam</h1>
            <div class="text-muted">Pilih kode tanam untuk input beban secara batch</div>
        </div>
        <a href="{{ route('bebantanam.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left mr-2"></i>Kembali
        </a>
    </div>

    <hr />

    @if ($errors->any())
        <div class="alert alert-danger">
            <b>Validasi gagal:</b>
            <ul class="mb-0">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-header bg-gradient-primary text-white">
            <h5 class="mb-0"><i class="fas fa-seedling mr-2"></i>Pilih Kode Tanam</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('bebantanam.create') }}" method="GET" id="tanamForm">
                <div class="mb-3">
                    <label for="id_tanam" class="form-label fw-bold">
                        <i class="fas fa-seedling mr-2"></i>Kode Tanam <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fas fa-list"></i></span>
                        <select class="form-select" name="id_tanam" id="id_tanam" required onchange="this.form.submit()">
                            <option value="" disabled selected>Pilih Kode Tanam</option>
                            @foreach($tanams as $tm)
                                <option value="{{ $tm->id_tanam }}" {{ request('id_tanam') == $tm->id_tanam ? 'selected' : '' }}>{{ $tm->kode_tanam }}</option>
                            @endforeach
                        </select>
                    </div>
                    <small class="text-muted mt-2 d-block">
                        <i class="fas fa-info-circle mr-1"></i>Setelah memilih kode tanam, Anda akan diarahkan ke form input beban yang dapat diisi secara batch (multiple entries sekaligus).
                    </small>
                </div>
            </form>

            @if(request('id_tanam'))
                <div class="mt-4">
                    <a href="{{ route('bebantanam.createBatch', request('id_tanam')) }}" class="btn btn-primary">
                        <i class="fas fa-arrow-right mr-2"></i>Lanjutkan ke Form Input Batch
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
