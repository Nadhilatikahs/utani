<div class="modal fade" id="modal_tambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ url('transaksi/simpan') }}" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label for="transaksi_id" class="form-label">Transaksi ID</label>
                                <input type="text" class="form-control" id="transaksi_id" name="transaksi_id" value="{{ $kode }}" readonly>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="tgl_transaksi" class="form-label">Tgl. Transaksi</label>
                                <input type="date" class="form-control" id="tgl_transaksi" name="tgl_transaksi" value="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label for="jenis_transaksi" class="form-label">Jenis Transaksi</label>
                                <select name="jenis_transaksi" id="jenis_transaksi" class="form-control">
                                    <option value="">Pilih</option>
                                    @foreach ($jenis_transaksi as $item)
                                    <option value="{{ $item->id }}">{{ $item->keterangan }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="detail_jenis_transaksi" class="form-label">Detail Transaksi</label>
                                <select name="detail_jenis_transaksi" id="detail_jenis_transaksi" class="form-control"></select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="nominal" class="form-label">Nominal</label>
                        <input type="number" class="form-control" id="nominal" name="nominal">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
