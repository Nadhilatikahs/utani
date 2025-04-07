@extends('layouts.app')
  
@section('title', 'List')
  
@section('contents')
    <div class="d-flex align-items-center justify-content-between">
        <h1 class="mb-0"> Data Panen</h1>
        <a href="{{ route('panen.create') }}" class="btn btn-primary">Tambah Data</a>
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
                <th>Kode Panen</th>
                <th>Tanam</th>
                <th>Tanggal Panen</th>
                <th>Jumlah</th>
                <th>Harga/satuan</th>
                <th>Hasil Panen</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>+
           
                @forelse($panens as $tm)
                    <tr>
                        <td class="align-middle">{{ $tm->kode_panen }}</td>
                        <td class="align-middle">{{ $tm->kode_tanam }}</td>
                        
                        <td class="align-middle">
    @if($tm->tgal_panen)
        {{ date('d F Y', strtotime($tm->tgal_panen)) }}
    @else
        <!-- Tampilkan pesan atau nilai default jika tanggal panen kosong -->
        -
    @endif
</td>
                        <td class="align-middle">{{number_format ($tm->jumlah) }}kg</td>
                        <td class="align-middle">Rp.{{number_format ($tm->harga) }}</td>
                        <td class="align-middle">Rp.{{number_format ($tm->hasil_panen) }}</td>
                       
                       
                       
                        <td class="align-middle">
                            <div class="btn-group" role="group" aria-label="Basic example">
                               
                                <a href="{{ route('panen.edit', $tm->id_panen)}}" type="button" class="btn btn-warning">Edit</a>
                                <form action="{{ route('panen.destroy', $tm->id_panen) }}" method="POST" type="button" class="btn btn-danger p-0" onsubmit="return confirm('Delete?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger m-0">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                
                @empty
                                  <div class="alert alert-danger">
                                      Data Panen Belum Tersedia.
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