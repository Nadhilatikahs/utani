<div class="modal fade" id="modal_edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ url('detail-jenis-transaksi/update') }}" method="post" id="formEdit">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" name="id" id="id_edit" hidden>
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label for="jenis_transaksi" class="form-label">Jenis Transaksi</label>
                                {{-- <input type="text" name="keterangan" id="keterangan" value="{{ old('keterangan') }}" class="form-control @error('keterangan') is-invalid @enderror"> --}}
                                <select name="jenis_transaksi" id="jenis_transaksi_edit" class="form-control">
                                    @foreach ($jenis_transaksi as $item)
                                    <option value="{{ $item->id }}">{{ $item->keterangan }}</option>
                                    @endforeach
                                </select>
                                @error('jenis_transaksi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="keterangan" class="form-label">Keterangan</label>
                                <input type="text" name="keterangan" id="keterangan_edit" value="{{ old('keterangan') }}" class="form-control @error('keterangan') is-invalid @enderror">
                                @error('keterangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
