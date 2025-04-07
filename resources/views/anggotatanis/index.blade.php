@extends('layouts.app')
  
@section('title', 'List')
  
@section('contents')
    <div class="d-flex align-items-center justify-content-between">
        <h1 class="mb-0"> Anggota Tani</h1> 
        <a href="{{ route('anggotatanis.create') }}" class="btn btn-primary">Tambah Data</a>
    </div>
    
    <!-- import data -->
    <div class="d-flex align-items-center justify-content-between">
        <a href="{{ route('anggotatanis.import') }}" class="btn btn-success">import</a>
    </div><br>
    
    <!-- export data -->
    <div class="d-flex align-items-center justify-content-between">
        <a href="{{ route('anggotatanis.export') }}" class="btn btn-success">export</a>
    </div>

    <hr />

    @if(Session::has('success'))
        <div id="flash-message" class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif

    @if($errors->any())
        <div id="flash-message" class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <table class="table table-hover">
        <thead class="table-primary">
            <tr>
                <th>Kode Anggota</th>
                <th>Nama Anggota</th>
                <th>Tempat/Tgl Lahir</th>
                <th>Alamat</th>
                <th>Jenis Kelamin</th>
                <th>No HP</th>
                <th>Status Anggota</th>
                <th>Kategori Petani</th>
                <th>Kelompok Tani</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($anggotatanis as $d)
                <tr>
                    <td class="align-middle">{{ $d->kode_anggota }}</td>
                    <td class="align-middle">{{ $d->nama_anggota }}</td>
                    <td class="align-middle">{{ $d->tempat_lahir }}</td>
                    <td class="align-middle">{{ $d->alamat }}</td>
                    <td class="align-middle">{{ $d->jenis_kelamin }}</td>
                    <td class="align-middle">{{ $d->no_hp }}</td>
                    <td class="align-middle">{{ $d->status_anggota }}</td>
                    <td class="align-middle">{{ $d->kategori_petani }}</td>
                    <td class="align-middle">{{ $d->nama_keltani }}</td>
                    <td class="align-middle">
                        
                            <a href="{{ route('anggotatanis.edit', $d->id_anggota)}}" class="btn btn-success btn-circle">
                            <i class="fas fa-pencil-alt"></i></a>
                            @if (!$d->hasLahans)
                            <form action="{{ route('anggotatanis.destroy', $d->id_anggota) }}" method="POST" class="d-inline" id="delete-form-{{ $d->id_anggota }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="deleteConfirm({{ $d->id_anggota }}, '{{ $d->kode_anggota }}')" class="btn btn-danger btn-circle">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="text-center alert alert-danger">
                        Data Anggota Tani belum tersedia.
                    </td>
                </tr>
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
            }, 3000); // 3000 ms = 3 detik
        }
    });
    </script>
@endsection
