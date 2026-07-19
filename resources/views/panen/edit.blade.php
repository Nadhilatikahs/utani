@extends('layouts.app')
  
@section('title', 'Edit ')
  
@section('contents')
    <h1 class="mb-0">Data</h1>
    <hr />
    <form action="{{ route('panen.update', $id_panen) }}" method="POST">
        @csrf
        @method('PUT')

        <fieldset disabled>
            <div class="mb-3">
                <label for="kodepanenlabel">Kode </label>
                <input
                    class="form-control form-control-solid"
                    id="kode_panentampil"
                    name="kode_panentampil"
                    type="text"
                    placeholder="Contoh: P-001"
                    value="{{ $kode_panen }}"
                    readonly
                >
            </div>
        </fieldset>

        <input type="hidden" id="kode_panen" name="kode_panen" value="{{ $kode_panen }}">

        <div class="row mb-3">
            <div class="col">
                <input type="hidden" name="id_panen" class="form-control" placeholder="ID" value="{{ $id_panen }}">

                <div class="row mb-3">
                    <div class="col">
                        <label class="form-label">Tanggal Panen</label>
                        <input
                            type="date"
                            name="tgal_panen"
                            class="form-control"
                            placeholder="Tanggal Panen"
                            value="{{ old('tgal_panen', $tgal_panen) }}"
                        >
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <label class="form-label">Jumlah</label>
                        <input
                            type="number"
                            name="jumlah"
                            id="jumlah"
                            class="form-control"
                            placeholder="jumlah"
                            value="{{ old('jumlah', $jumlah) }}"
                        >
                    </div>
                    <div class="col">
                        <label class="form-label">Harga</label>
                        <input
                            type="number"
                            name="harga"
                            id="harga"
                            class="form-control"
                            placeholder="Harga"
                            value="{{ old('harga', $harga) }}"
                        >
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <label class="form-label">Status Panen</label>
                        @php
                            $currentStatus = old('status_panen', $status_panen ?? 'berhasil');
                        @endphp
                        <select name="status_panen" id="status_panen" class="form-control" required>
                            <option value="berhasil" {{ $currentStatus === 'berhasil' ? 'selected' : '' }}>Berhasil</option>
                            <option value="gagal_sebagian" {{ $currentStatus === 'gagal_sebagian' ? 'selected' : '' }}>Gagal Sebagian</option>
                            <option value="gagal_total" {{ $currentStatus === 'gagal_total' ? 'selected' : '' }}>Gagal Total</option>
                        </select>
                    </div>
                </div>

                <div id="failure-fields" style="display: none;">
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label">Penyebab Gagal</label>
                            @php
                                $currentCause = old('penyebab_gagal', $penyebab_gagal ?? '');
                            @endphp
                            <select name="penyebab_gagal" id="penyebab_gagal" class="form-control">
                                <option value="">Pilih penyebab</option>
                                <option value="hama" {{ $currentCause === 'hama' ? 'selected' : '' }}>Hama</option>
                                <option value="penyakit" {{ $currentCause === 'penyakit' ? 'selected' : '' }}>Penyakit</option>
                                <option value="cuaca_ekstrem" {{ $currentCause === 'cuaca_ekstrem' ? 'selected' : '' }}>Cuaca Ekstrem</option>
                                <option value="banjir" {{ $currentCause === 'banjir' ? 'selected' : '' }}>Banjir</option>
                                <option value="kekeringan" {{ $currentCause === 'kekeringan' ? 'selected' : '' }}>Kekeringan</option>
                                <option value="kesalahan_teknis" {{ $currentCause === 'kesalahan_teknis' ? 'selected' : '' }}>Kesalahan Teknis</option>
                                <option value="lainnya" {{ $currentCause === 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label">Keterangan</label>
                            <textarea
                                name="keterangan"
                                id="keterangan"
                                class="form-control"
                                rows="3"
                            >{{ old('keterangan', $keterangan ?? '') }}</textarea>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="d-grid">
                <button class="btn btn-warning">Update</button>
            </div>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const jumlahInput   = document.getElementById('jumlah');
            const statusSelect  = document.getElementById('status_panen');
            const failureFields = document.getElementById('failure-fields');

            function updateFailureFields() {
                if (!statusSelect || !failureFields) {
                    return;
                }

                const status = statusSelect.value;

                if (status === 'berhasil') {
                    failureFields.style.display = 'none';
                    if (jumlahInput) {
                        jumlahInput.removeAttribute('readonly');
                    }
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