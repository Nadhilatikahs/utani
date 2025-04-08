@extends('layouts.app')

@section('contents')
    {{-- <h1>Daftar Transaksi</h1> --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Daftar Detail Jenis Transaksi</h4>
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
                                <th class="text-center">Detail Transaksi</th>
                                <th class="text-center">Keterangan</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($detail_transaksi as $item)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $item->ket_jenis_transaksi }}</td>
                                <td>{{ $item->keterangan }}</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-warning btn-edit" 
                                        data-id="{{ $item->id }}"
                                        data-id_jenis_transaksi="{{ $item->id_jenis_transaksi }}"
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
    
    @include('detail_jenis_transaksi.add')
    @include('detail_jenis_transaksi.edit')

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
                $('#formEdit').attr('action', '/detail-jenis-transaksi/update/' + id);

                let id_jenis_transaksi = $(this).data('id_jenis_transaksi');
                let keterangan = $(this).data('keterangan');

                $("#id_edit").val(id);
                $("#jenis_transaksi_edit").val(id_jenis_transaksi);
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
                        form.attr('action', '/detail-jenis-transaksi/delete/' + id);
                        form.submit();
                    }
                });
            })
        })
    </script>
@endsection
