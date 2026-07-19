<div class="modal fade" id="modal_edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ url('coa/update') }}" method="post" id="formEdit">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Data</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <input type="text" name="id" id="id_edit" hidden>
                            <div class="mb-3">
                                <label for="kode_akun" class="form-label">Kode Akun</label>
                                <input type="text" name="kode_akun" id="kode_akun_edit" value="{{ old('kode_akun') }}" class="form-control @error('kode_akun') is-invalid @enderror" readonly>
                                @error('kode_akun')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="jenis_transaksi" class="form-label">Jenis Transaksi</label>
                                <select name="jenis_transaksi" id="jenis_transaksi_edit" class="form-control">
                                    <option value="" disabled selected>Pilih</option>
                                    @foreach ($jenis_transaksi as $item)
                                    <option value="{{ $item->id }}">{{ $item->keterangan }}</option>
                                    @endforeach
                                </select>
                                @error('jenis_transaksi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="posisi_dr_cr" class="form-label">Posisi dr/cr</label>
                                <select name="posisi_dr_cr" id="posisi_dr_cr_edit" class="form-control">
                                    <option value="" disabled selected>Pilih</option>
                                    <option value="d">Debit</option>
                                    <option value="k">Kredit</option>
                                </select>
                                @error('posisi_dr_cr')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nama_akun" class="form-label">Nama Akun</label>
                                <input type="text" name="nama_akun" id="nama_akun_edit" value="{{ old('nama_akun') }}" class="form-control @error('nama_akun') is-invalid @enderror">
                                @error('nama_akun')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            {{-- <div class="mb-3">
                                <label for="header" class="form-label">Header</label>
                                <input type="date" class="form-control" id="header_edit" name="header">
                            </div> --}}
                            <div class="mb-3">
                                <label for="saldo_awal" class="form-label">Saldo Awal</label>
                                <input type="number" name="saldo_awal" id="saldo_awal_edit" value="{{ old('saldo_awal') }}" class="form-control @error('saldo_awal') is-invalid @enderror">
                                @error('saldo_awal')
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
