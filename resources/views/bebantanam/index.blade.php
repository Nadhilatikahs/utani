@extends('layouts.app')

@section('title', 'Data Beban Tanam')

@section('contents')
    <div class="d-flex align-items-center justify-content-between">
        <h1 class="mb-0"> Data Beban Tanam</h1>
        <a href="{{ route('bebantanam.create') }}" class="btn btn-primary">Tambah Data</a>
    </div>
    <hr />
    @if(Session::has('success'))
        <div id="flash-message" class="alert alert-success" role="alert">
            <i class="fas fa-check-circle mr-2"></i>{{ Session::get('success') }}
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-header bg-gradient-primary text-white">
            <h5 class="mb-0"><i class="fas fa-list mr-2"></i>Daftar Beban Tanam per Kode Tanam</h5>
        </div>
        <div class="card-body">
            @forelse($tanamsWithBeban as $tanam)
                <div class="card mb-3 border">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1 fw-bold">
                                    <i class="fas fa-seedling mr-2" style="color: var(--button-green);"></i>
                                    {{ $tanam->kode_tanam }}
                                </h6>
                                <small class="text-muted">
                                    <i class="fas fa-list mr-1"></i>{{ $tanam->bebantanam_count }} item beban
                                </small>
                            </div>
                            <a href="{{ route('bebantanam.byTanam', $tanam->id_tanam) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-eye mr-1"></i>Detail
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Belum ada data beban tanam.</p>
                    <a href="{{ route('bebantanam.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus mr-2"></i>Tambah Data Pertama
                    </a>
                </div>
            @endforelse
        </div>
    </div>
    <!-- Modal Konfirmasi Penghapusan -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Apakah Anda yakin?</h5>
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
//sweet alert
        document.addEventListener('DOMContentLoaded', function() {
        const flashMessage = document.getElementById('flash-message');
        if (flashMessage) {
            setTimeout(function() {
                flashMessage.style.display = 'none';
            }, 3000); // 5000 ms = 5 detik
        }
    });
    </script>
@endsection