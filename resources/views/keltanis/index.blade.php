<!-- /resources/views/products/index.blade.php -->
@extends('layouts.app')
  
@section('title', 'List')
  
@section('contents')
    <div class="d-flex align-items-center justify-content-between">
        <h1 class="mb-0"> Kelompok Tani</h1>
        <a href="{{ route('keltanis.create') }}" class="btn btn-primary">Tambah Data</a>
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
                <th>Kode Kelompok Tani </th>
                <th>Nama Kelompok Tani</th>
                <th>Alamat</th>
                <th>Desa</th>
                <th>Latitude</th>
                <th>Longitude</th>
                
                
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
           
                @forelse($kelompoktanis as $d)
                    <tr>
                        <td class="align-middle">{{ $d->kode_keltani }}</td>
                        <td class="align-middle">{{ $d->nama_keltani }}</td>
                        <td class="align-middle">{{ $d->alamat }}</td>
                        <td class="align-middle">{{ $d->nama_desa }}</td>
                        <td class="align-middle">{{ $d->latitude }}</td>
                        <td class="align-middle">{{ $d->longitude }}</td>
                       
                       
                       
                        <td class="align-middle">
                        
                                <a href="{{ route('keltanis.edit', $d->id_keltani)}}" type="button" class="btn btn-success btn-circle">
                                <i class="fas fa-pencil-alt"></i></a>
                                <form action="{{ route('keltanis.destroy', $d->id_keltani) }}" method="POST" class="d-inline" id="delete-form-{{ $d->id_keltani }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="deleteConfirm({{ $d->id_keltani }}, '{{ $d->kode_keltani }}')" class="btn btn-danger btn-circle">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                
                @empty
                                  <div class="alert alert-danger">
                                      Data Kelompok Tani belum Tersedia.
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
            const pesan = `Kelompok Tani dengan kode <b>${kode}</b> akan dihapus`;
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
            }, 3000); // 3000 ms = 3 detik
        }
    });
    </script>
@endsection