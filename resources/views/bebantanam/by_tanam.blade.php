@extends('layouts.app')

@section('title', 'Rincian Beban Tanam')

@section('contents')
<div class="d-flex align-items-center justify-content-between">
    <div>
        <h1 class="mb-0">Rincian Beban Tanam</h1>
        <div class="text-muted">Kode Tanam: <b>{{ $tanam->kode_tanam }}</b></div>
    </div>

    <div class="d-flex gap-2">
        <a href="{{ route('bebantanam.createBatch', $tanam->id_tanam) }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Input Beban
        </a>
        <a href="{{ route('bebantanam.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-list"></i> Kembali ke List
        </a>
    </div>
</div>

<hr />

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
@endif

<div class="card">
    <div class="card-header bg-gradient-primary">
        <div class="d-flex justify-content-between align-items-center">
            <strong class="text-light">
                <i class="fas fa-list"></i> Daftar Transaksi Beban untuk {{ $tanam->kode_tanam }}
            </strong>
            <span class="badge bg-primary">{{ $items->count() }} item</span>
        </div>
    </div>

    <div class="card-body">
        @if($items->isEmpty())
            <div class="text-center py-5">
                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                <p class="text-muted">Belum ada transaksi beban untuk tanam ini.</p>
                <a href="{{ route('bebantanam.createBatch', $tanam->id_tanam) }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Input Beban Pertama
                </a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th>Kode Beban</th>
                            <th>Nama Beban</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-center">Satuan</th>
                            <th class="text-end">Harga Satuan</th>
                            <th class="text-end">Total</th>
                            <th class="text-center" style="width: 100px;">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($items as $index => $bt)
                            @php
                                $total = $bt->total ?? ((float)($bt->jumlah ?? 0) * (float)($bt->harga ?? 0));
                                $beban = $bt->beban;
                            @endphp
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $beban->kode_beban ?? '-' }}</td>
                                <td>{{ $beban->nama_beban ?? '-' }}</td>
                                <td class="text-center">{{ number_format($bt->jumlah ?? 0, 2, ',', '.') }}</td>
                                <td class="text-center">
                                    <span class="badge bg-primary text-white">{{ $bt->satuan ?? '-' }}</span>
                                </td>
                                <td class="text-end">Rp {{ number_format($bt->harga ?? 0, 0, ',', '.') }}</td>
                                <td class="text-end">
                                    <strong>Rp {{ number_format($total, 0, ',', '.') }}</strong>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex gap-2 justify-content-center">
                                        <a href="{{ route('bebantanam.edit', $bt->id_bebantanam) }}" 
                                           class="btn btn-warning btn-sm" title="Edit">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('bebantanam.destroy', $bt->id_bebantanam) }}" 
                                              method="POST" class="d-inline" id="delete-form-{{ $bt->id_bebantanam }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="deleteConfirm({{ $bt->id_bebantanam }}, '{{ $bt->kode_bebantanam ?? 'data' }}')" class="btn btn-danger btn-sm" title="Hapus">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                    <tfoot class="table-secondary">
                        <tr>
                            <th colspan="6" class="text-end">Grand Total</th>
                            <th class="text-end">
                                <strong class="fs-5">Rp {{ number_format($grandTotal ?? 0, 0, ',', '.') }}</strong>
                            </th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @endif
    </div>
</div>

<!-- Modal Konfirmasi Penghapusan -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Apakah Anda yakin?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" id="xid"></div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <button id="confirm-delete" class="btn btn-danger">Hapus</button>
            </div>
        </div>
    </div>
</div>

<script>
    let formToDelete = null;

    function deleteConfirm(id, kode) {
        formToDelete = document.getElementById('delete-form-' + id);
        const pesan = `Beban Tanam dengan kode <b>${kode}</b> akan dihapus`;
        document.getElementById("xid").innerHTML = pesan;

        const myModal = new bootstrap.Modal(document.getElementById('deleteModal'), { keyboard: false });
        myModal.show();
    }

    document.getElementById('confirm-delete').addEventListener('click', function() {
        if (formToDelete) {
            formToDelete.submit();
        }
    });
</script>
@endsection
