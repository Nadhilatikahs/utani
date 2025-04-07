@extends('layouts.app')

@section('contents')
    {{-- <h1>Daftar Transaksi</h1> --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Daftar COA</h4>
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
                                <th class="text-center">Kode Akun</th>
                                <th class="text-center">Nama Akun</th>
                                <th class="text-center">Header</th>
                                <th class="text-center">Posisi</th>
                                <th class="text-center">Saldo Awal</th>
                                <th class="text-center">Jenis Transaksi</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($coa as $item)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $item->kode_akun }}</td>
                                <td>{{ $item->nama_akun }}</td>
                                <td>{{ $item->header }}</td>
                                <td>{{ $item->posisi_dr_cr }}</td>
                                <td>{{ $item->saldo_awal }}</td>
                                <td>{{ $item->keterangan }}</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-warning btn-edit" 
                                        data-id="{{ $item->id }}"
                                        data-kode_akun="{{ $item->kode_akun }}"
                                        data-nama_akun="{{ $item->nama_akun }}"
                                        {{-- data-header="{{ $item->header }}" --}}
                                        data-posisi_dr_cr="{{ $item->posisi_dr_cr }}"
                                        data-saldo_awal="{{ $item->saldo_awal }}"
                                        data-id_jenis_transaksi="{{ $item->id_jenis_transaksi }}"
                                    >Edit</button>
                                    <button class="btn btn-sm btn-danger btn-hapus" data-id="{{ $item->id }}" data-nama_akun="{{ $item->nama_akun }}">Hapus</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    @include('coa.add')
    @include('coa.edit')
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
                $('#formEdit').attr('action', '/coa/update/' + id);

                let kode_akun = $(this).data('kode_akun');
                let nama_akun = $(this).data('nama_akun');
                // let header = $(this).data('header');
                let posisi_dr_cr = $(this).data('posisi_dr_cr');
                let saldo_awal = $(this).data('saldo_awal');
                let id_jenis_transaksi = $(this).data('id_jenis_transaksi');

                $("#id_edit").val(id);
                $("#kode_akun_edit").val(kode_akun);
                $("#jenis_transaksi_edit").val(id_jenis_transaksi);
                $("#posisi_dr_cr_edit").val(posisi_dr_cr);
                $("#nama_akun_edit").val(nama_akun);
                // $("#header_edit").val(header);
                $("#saldo_awal_edit").val(saldo_awal);
            })

            $(".btn-hapus").on("click", function() {
                let id = $(this).data('id');
                let nama_akun = $(this).data('nama_akun');

                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: `Nama akun : ${nama_akun} akan dihapus dan tidak dapat dikembalikan`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        let form = $('#form-delete');
                        form.attr('action', '/coa/delete/' + id);
                        form.submit();
                    }
                });
            })
        })
    </script>
@endsection
