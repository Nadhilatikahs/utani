@extends('layouts.app')

@section('title', 'Tambah Data')

@section('contents')
    <h1 class="mb-0">Beban</h1>
    <hr />

    <form action="{{ route('bebans.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- {{-- Kode Beban (auto, TIDAK DIUBAH) --}}
        <fieldset disabled>
            <div class="mb-3">
                <label for="kodebebanlabel">Kode Beban</label>
                <input
                    class="form-control form-control-solid"
                    id="kode_beban_tampil"
                    type="text"
                    value="{{ $kode_beban }}"
                    readonly
                >
            </div> -->
        </fieldset>

        {{-- Hidden ID (tetap ada untuk konsistensi lama) --}}
        <input type="hidden" name="id_beban">

        <div class="row mb-3">
            {{-- Nama Beban --}}
            <div class="col">
                <label>Nama Beban</label>
                <input
                    type="text"
                    name="nama_beban"
                    class="form-control"
                    required
                >
            </div>

            {{-- Kategori Beban (STRING, FLOW LAMA) --}}
            <div class="col">
                <label>Kategori Beban</label>
                <select
                    class="form-select custom-select"
                    style="height: auto;"
                    name="kategori"
                    required
                >
                    <option value="" disabled selected>Pilih Kategori</option>
                    <option value="Persiapan Lahan">Persiapan Lahan</option>
                    <option value="Pemupukan">Pemupukan</option>
                    <option value="Pemeliharaan">Pemeliharaan</option>
                    <option value="Pasca Panen">Panen dan Pasca Panen</option>
                    <option value="Pajak">Pajak</option>
                </select>
            </div>
        </div>

        {{-- Keterangan (id_kategori, RELASI LAMA) --}}
        <div class="row mb-3">
            <div class="col">
                <label>Keterangan</label>
                <select
                    class="form-select custom-select"
                    style="height: auto;"
                    name="id_kategori"
                    required
                >
                    <option value="" disabled selected>Pilih Keterangan</option>
                    @foreach ($kategori as $k)
                        <option value="{{ $k->id_kategori }}">
                            {{ $k->keterangan }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Kelompok Biaya Produksi (id_kelompok_biaya_produksi, BARU) --}}
        <div class="row mb-3">
            <div class="col">
                <label>Kelompok Biaya Produksi (opsional)</label>
                <select
                    class="form-select custom-select"
                    style="height: auto;"
                    name="id_kelompok_biaya_produksi"
                >
                    <option value="">Pilih Kelompok Biaya Produksi (Boleh dikosongkan)</option>
                    @foreach ($kelompokList as $k)
                        <option value="{{ $k->id_kelompok_biaya_produksi }}">
                            {{ $k->nama_kelompok }}
                        </option>
                    @endforeach
                </select>
                <small class="form-text text-muted">
                    Jika dikosongkan, sistem akan mengklasifikasikan otomatis berdasarkan nama, kategori, dan keterangan beban.
                </small>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col text-left d-flex gap-2">
                <a href="{{ route('bebans.index') }}" class="btn btn-secondary">
                    Kembali
                </a>
                <button type="submit" class="btn btn-primary">
                    Submit
                </button>
            </div>
        </div>
    </form>
@endsection
