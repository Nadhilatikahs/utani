@extends('layouts.app')

@section('contents')
    {{-- <h1>Daftar Transaksi</h1> --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Daftar Jenis Transaksi</h4>
                </div>
                <div class="card-body">
                    <button class="btn btn-primary btn-sm mb-3" id="btn_tambah">
                        <i class="fas fa-plus"></i>
                        Tambah Data
                    </button>
                    <table class="table table-bordered table-striped table-hover table-sm" id="table" style="width: 100% !important;">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Keterangan</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($jenis_transaksi as $item)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $item->keterangan }}</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-warning btn-edit" 
                                        data-id="{{ $item->id }}"
                                        data-keterangan="{{ $item->keterangan }}"
                                    >Edit</button>
                                    <button class="btn btn-sm btn-danger btn-hapus" data-id="{{ $item->id }}">Hapus</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    @include('jenis_transaksi.add')
    @include('jenis_transaksi.edit')

    <form id="form-delete" action="" method="POST" style="display: none;">
        @csrf
        @method('delete')
    </form>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $("#table").DataTable();

            $("#btn_tambah").on("click", function() {
                $("#modal_tambah").modal("show")
            })

            $(".btn-edit").on("click", function() {
                $("#modal_edit").modal("show")

                let id = $(this).data('id');
                $('#formEdit').attr('action', '/jenis-transaksi/update/' + id);

                let keterangan = $(this).data('keterangan');

                $("#id_edit").val(id);
                $("#keterangan_edit").val(keterangan);
            })

            $(".btn-hapus").on("click", function() {
                let id = $(this).data('id');

                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: "Data yang sudah dihapus tidak dapat dikembalikan",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        let form = $('#form-delete');
                        form.attr('action', '/jenis-transaksi/delete/' + id);
                        form.submit();
                    }
                });
            })
        })
    </script>
@endsection
