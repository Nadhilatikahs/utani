@extends('layouts.app')

@section('title', 'Edit Data Beban')

@section('contents')
    <h1 class="mb-0">Edit Data Beban</h1>
    <hr />

    <form action="{{ route('bebans.update', $id_beban) }}" method="POST">
        @csrf
        @method('PUT')

        <input type="hidden" name="id_beban" value="{{ $id_beban }}">

        {{-- Kode Beban (read-only, TETAP) --}}
        <div class="mb-3">
            <label for="kode_beban">Kode Beban</label>
            <input
                type="text"
                id="kode_beban"
                name="kode_beban"
                class="form-control"
                value="{{ old('kode_beban', $kode_beban) }}"
                readonly
            >
        </div>

        <div class="row mb-3">
            {{-- Nama Beban --}}
            <div class="col">
                <label>Nama Beban</label>
                <input
                    type="text"
                    name="nama_beban"
                    class="form-control"
                    value="{{ old('nama_beban', $nama_beban) }}"
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
                    @php
                        $kategoriOptions = [
                            'Persiapan Lahan',
                            'Pemupukan',
                            'Pemeliharaan',
                            'Pasca Panen',
                            'Pajak',
                        ];
                        $selectedKategori = old('kategori', $kategori);
                    @endphp

                    <option value="" disabled>Pilih Kategori</option>

                    @foreach ($kategoriOptions as $opt)
                        <option value="{{ $opt }}"
                            {{ $selectedKategori === $opt ? 'selected' : '' }}>
                            {{ $opt === 'Pasca Panen' ? 'Panen dan Pasca Panen' : $opt }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Keterangan (id_kategori, RELASI LAMA) --}}
        <div class="mb-3">
            <label>Keterangan</label>
            <select
                class="form-select custom-select"
                style="height: auto;"
                name="id_kategori"
                required
            >
                <option value="" disabled>Pilih Keterangan</option>
                @foreach ($kategoriList as $k)
                    <option value="{{ $k->id_kategori }}"
                        {{ old('id_kategori', $id_kategori) == $k->id_kategori ? 'selected' : '' }}>
                        {{ $k->keterangan }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Kelompok Biaya Produksi (id_kelompok_biaya_produksi, BARU) --}}
        <div class="mb-3">
            <label>Kelompok Biaya Produksi (opsional)</label>
            <select
                class="form-select custom-select"
                style="height: auto;"
                name="id_kelompok_biaya_produksi"
            >
                <option value="">Pilih Kelompok Biaya Produksi (Boleh dikosongkan)</option>
                @foreach ($kelompokList as $k)
                    <option value="{{ $k->id_kelompok_biaya_produksi }}"
                        {{ old('id_kelompok_biaya_produksi', $id_kelompok_biaya_produksi) == $k->id_kelompok_biaya_produksi ? 'selected' : '' }}>
                        {{ $k->nama_kelompok }}
                    </option>
                @endforeach
            </select>
            <small class="form-text text-muted">
                Jika dikosongkan, sistem akan mengklasifikasikan otomatis berdasarkan nama, kategori, dan keterangan beban.
            </small>
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
