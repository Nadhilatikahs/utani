@extends('layouts.app')
  
@section('title', 'Tambah Data ')
  
@section('contents')
    <h1 class="mb-0">Panen</h1>
    <hr />
    <form action="{{ route('panen.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <fieldset disabled>
            <div class="mb-3"><label for="kodepanenlabel">Kode </label>
            <input class="form-control form-control-solid" id="kode_panen_tampil" name="kode_panen_tampil" type="text" placeholder="Contoh: P-001" value="{{$kode_panen}}" readonly></div>
        </fieldset>
        <input type="hidden" id="kode_panen" name="kode_panen" value="{{$kode_panen}}">

        <div class="row mb-3">
            <div class="col">
                <input type="hidden" name="id_panen" class="form-control" placeholder="ID">

                <div class="row mb-3">
                    <div class="form-group"> Tanam
                        <select class="form-control select" style="width:100%;" name="id_tanam" id="id_tanam">
                            <option disabled value>Pilih Data Tanam</option>
                            @foreach($tanams as $lh)
                                <option value="{{$lh->id_tanam}}">{{$lh->kode_tanam}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col">Tanggal Panen
                        <input type="date" name="tgal_panen" class="form-control" placeholder="Tanggal panen" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col">Kg
                        <input type="number" name="jumlah" class="form-control" placeholder="jumlah panen" max="999999" required>
                    </div>
                    <div class="col">Rp.
                        <input type="number" name="harga" class="form-control" placeholder="harga/satuan" max="999999" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <label>Status Panen</label>
                        <select name="status_panen" id="status_panen" class="form-control" required>
                            <option value="berhasil" {{ old('status_panen', 'berhasil') === 'berhasil' ? 'selected' : '' }}>Berhasil</option>
                            <option value="gagal_sebagian" {{ old('status_panen') === 'gagal_sebagian' ? 'selected' : '' }}>Gagal Sebagian</option>
                            <option value="gagal_total" {{ old('status_panen') === 'gagal_total' ? 'selected' : '' }}>Gagal Total</option>
                        </select>
                    </div>
                </div>

                <div id="failure-fields" style="display: none;">
                    <div class="row mb-3">
                        <div class="col">
                            <label>Penyebab Gagal</label>
                            <select name="penyebab_gagal" id="penyebab_gagal" class="form-control">
                                <option value="">Pilih penyebab</option>
                                <option value="hama" {{ old('penyebab_gagal') === 'hama' ? 'selected' : '' }}>Hama</option>
                                <option value="penyakit" {{ old('penyebab_gagal') === 'penyakit' ? 'selected' : '' }}>Penyakit</option>
                                <option value="cuaca_ekstrem" {{ old('penyebab_gagal') === 'cuaca_ekstrem' ? 'selected' : '' }}>Cuaca Ekstrem</option>
                                <option value="banjir" {{ old('penyebab_gagal') === 'banjir' ? 'selected' : '' }}>Banjir</option>
                                <option value="kekeringan" {{ old('penyebab_gagal') === 'kekeringan' ? 'selected' : '' }}>Kekeringan</option>
                                <option value="kesalahan_teknis" {{ old('penyebab_gagal') === 'kesalahan_teknis' ? 'selected' : '' }}>Kesalahan Teknis</option>
                                <option value="lainnya" {{ old('penyebab_gagal') === 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <label>Keterangan</label>
                            <textarea name="keterangan" id="keterangan" class="form-control" rows="3">{{ old('keterangan') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="row"> 
                    <div class="col text-left d-flex gap-2">
                <a href="{{ route('panen.index') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
                </div>
            </div>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const jumlahInput    = document.querySelector('input[name="jumlah"]');
            const hargaInput     = document.querySelector('input[name="harga"]');
            const statusSelect   = document.getElementById('status_panen');
            const failureFields  = document.getElementById('failure-fields');
            const penyebabGagal  = document.getElementById('penyebab_gagal');
            const keteranganText = document.getElementById('keterangan');

            function enforceMaxLength(input) {
                input.addEventListener('input', function() {
                    if (input.value.length > 6) {
                        input.value = input.value.slice(0, 6);
                    }
                });
            }

            if (jumlahInput) {
                enforceMaxLength(jumlahInput);
            }
            if (hargaInput) {
                enforceMaxLength(hargaInput);
            }

            function updateFailureFields() {
                if (!statusSelect || !failureFields) {
                    return;
                }

                const status = statusSelect.value;

                if (status === 'berhasil') {
                    failureFields.style.display = 'none';
                    if (penyebabGagal) penyebabGagal.value = '';
                    if (keteranganText) keteranganText.value = '';
                    if (jumlahInput) jumlahInput.removeAttribute('readonly');
                } else {
                    failureFields.style.display = 'block';

                    if (status === 'gagal_total') {
                        if (jumlahInput) {
                            jumlahInput.value = 0;
                            jumlahInput.setAttribute('readonly', 'readonly');
                        }
                    } else {
                        if (jumlahInput) {
                            jumlahInput.removeAttribute('readonly');
                        }
                    }
                }
            }

            if (statusSelect) {
                statusSelect.addEventListener('change', updateFailureFields);
            }

            updateFailureFields();
        });
    </script>
@endsection
