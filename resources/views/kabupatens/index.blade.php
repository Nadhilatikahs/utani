<!-- /resources/views/products/index.blade.php -->
@extends('layouts.app')
  
@section('title', 'List')
  
@section('contents')
    <div class="d-flex align-items-center justify-content-between">
        <h1 class="mb-0"> Kabupaten</h1>
        <a href="{{ route('kabupatens.create') }}" class="btn btn-primary">Tambah Data</a>
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
                <th>Kode Kabupaten </th>
                <th>Nama Kabupaten</th>
                <th>Latitude</th>
                <th>Longitude</th>
                <th>Provinsi</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>+
           
                @forelse($kabupatens as $kb)
                    <tr>
                        <td class="align-middle">{{ $kb->kode_kabupaten }}</td>
                        <td class="align-middle">{{ $kb->nama_kabupaten }}</td>
                        <td class="align-middle">{{ $kb->latitude }}</td>
                        <td class="align-middle">{{ $kb->longitude }}</td>
                        <td class="align-middle">{{ $kb->nama_provinsi }}</td>
                       
                        <td class="align-middle">
                        
                                <a href="{{ route('kabupatens.edit', $kb->id_kabupaten)}}"  class="btn btn-success btn-circle">
                                <i class="fas fa-pencil-alt"></i>
                                </a>
                                
                                <form action="{{ route('kabupatens.destroy', $kb->id_kabupaten) }}" method="POST" class="d-inline" id="delete-form-{{ $kb->id_kabupaten }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="deleteConfirm({{ $kb->id_kabupaten }}, '{{ $kb->kode_kabupaten }}')" class="btn btn-danger btn-circle">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        
                            </div>
                        </td>
                    </tr>
                
                @empty
                                  <div class="alert alert-danger">
                                      Data Kabupaten belum Tersedia.
                                  </div>
             @endforelse
        </tbody>
    </table>
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
            const pesan = `Provinsi dengan kode <b>${kode}</b> akan dihapus`;
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