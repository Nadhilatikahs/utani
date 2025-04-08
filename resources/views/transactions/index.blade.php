@extends('layouts.app')

@section('contents')
    {{-- <h1>Daftar Transaksi</h1> --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Daftar Transaksi</h4>
                </div>
                <div class="card-body">
                    <button class="btn btn-primary btn-sm mb-3" id="btn_tambah">
                        <i class="fas fa-plus"></i>
                        Tambah Data
                    </button>
                    <table class="table table-bordered table-striped table-hover table-sm">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Transaksi ID</th>
                                <th>Tgl. Transaksi</th>
                                <th>Nominal</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($transactions as $item)    
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $item->transaksi_id }}</td>
                                <td>{{ $item->tgl_transaksi }}</td>
                                <td class="text-right">{{ number_format($item->total) }}</td>
                                <td>{{ $item->status }}</td>
                            @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    @include('transactions.add')
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $("#btn_tambah").on("click", function() {
                $("#modal_tambah").modal("show")
            })

            $("#jenis_transaksi").on("change", function() {
                let value = $(this).val();
                getDropdown(value);
            })

            function getDropdown(id) {
                $.ajax({
                    url: '{{ url('transaksi/list-detail-transaksi') }}',
                    method: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                    },
                    data: {
                        id_jenis_transaksi: id,
                    },
                    success: function(response) {
                        let option = '';

                        for (let i = 0; i < response.length; i++) {
                            option += `<option value="${response[i].id}">${response[i].keterangan}</option>`;
                        }

                        $("#detail_transaksi").html(option);
                    }
                })
            }
        })
    </script>
@endsection
