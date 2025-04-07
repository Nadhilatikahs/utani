<!-- /resources/views/products/index.blade.php -->
@extends('layouts.app')
  
@section('title', 'List')
  
@section('contents')
    <div class="d-flex align-items-center justify-content-between">
        <h1 class="mb-0"> Kategori</h1>
        <a href="{{ route('kategori.create') }}" class="btn btn-primary">Tambah Data</a>
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
                
				<th>Kode Kategori</th>
                <th>Keterangan</th>
                

               
        
                <th>Action</th>
            </tr>
        </thead>
        <tbody>+
        
                @forelse($kategori as $k)
				
                    
                    
                        <td class="align-middle">{{ $k->kode_kategori }}</td>
                        <td class="align-middle">{{ $k->keterangan }}</td>
                        
						<td class="align-middle">
                            <a href="{{ route('kategori.edit', $k->id_kategori) }}" class="btn btn-success btn-circle"> 
                            <i class="fas fa-pencil-alt"></i>
                            </a>
                            @if (!$k->hasBebans)
                            <form action="{{ route('kategori.destroy', $k->id_kategori) }}" method="POST" class="d-inline" id="delete-form-{{ $k->id_kategori }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="deleteConfirm({{ $k->id_kategori }}, '{{ $k->kode_kategori }}')" class="btn btn-danger btn-circle">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            @endif
						</td>
                    </tr>
                
                @empty
                                  <div class="alert alert-danger">
                                      Data Provinsi belum Tersedia.
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
            }, 3000); // 3000 ms = 3 detik
        }
    });
    </script>
    


@endsection
