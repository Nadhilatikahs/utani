@extends('layouts.app')

@section('title', 'Edit Data')

@section('contents')
<h1 class="mb-0">Edit Beban Tanam</h1>
<hr />

<form action="{{ route('bebantanam.update', $id_bebantanam) }}" method="POST">
    @csrf
    @method('PUT')

    {{-- Kode Beban Tanam (read only) --}}
    <fieldset disabled>
        <div class="mb-3">
            <label>Kode Beban Tanam</label>
            <input
                type="text"
                class="form-control form-control-solid"
                value="{{ $kode_bebantanam }}"
                readonly
            >
        </div>
    </fieldset>

    {{-- Hidden fields --}}
    <input type="hidden" name="kode_bebantanam" value="{{ $kode_bebantanam }}">
    <input type="hidden" name="id_bebantanam" value="{{ $id_bebantanam }}">

    {{-- Tanam & Beban --}}
    <div class="row mb-3">
        <div class="col-md-6">
            <label>Kode Tanam</label>
            <select name="id_tanam" class="form-control" required>
                <option disabled>Pilih Tanam</option>
                @foreach($tanams as $tm)
                    <option value="{{ $tm->id_tanam }}"
                        {{ $tm->id_tanam == $id_tanam ? 'selected' : '' }}>
                        {{ $tm->kode_tanam }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-6">
            <label>Nama Beban</label>
            <select name="id_beban" class="form-control" required>
                <option disabled>Pilih Beban</option>
                @foreach($bebans as $bb)
                    <option value="{{ $bb->id_beban }}"
                        {{ $bb->id_beban == $id_beban ? 'selected' : '' }}>
                        {{ $bb->nama_beban }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- Satuan, Jumlah, Harga --}}
    <div class="row mb-3">
        <div class="col-md-4">
            <label>Satuan</label>
            <select name="satuan" class="form-control" required>
                <option value="kg"   {{ $satuan == 'kg' ? 'selected' : '' }}>Kg</option>
                <option value="g"    {{ $satuan == 'g' ? 'selected' : '' }}>Gram</option>
                <option value="l"    {{ $satuan == 'l' ? 'selected' : '' }}>Liter</option>
                <option value="ml"   {{ $satuan == 'ml' ? 'selected' : '' }}>Mililiter</option>
                <option value="HOK"  {{ $satuan == 'HOK' ? 'selected' : '' }}>HOK</option>
                <option value="jam"  {{ $satuan == 'jam' ? 'selected' : '' }}>Jam</option>
                <option value="hari" {{ $satuan == 'hari' ? 'selected' : '' }}>Hari</option>
                <option value="bulan"{{ $satuan == 'bulan' ? 'selected' : '' }}>Bulan</option>
                <option value="tahun"{{ $satuan == 'tahun' ? 'selected' : '' }}>Tahun</option>
                <option value="bata" {{ $satuan == 'bata' ? 'selected' : '' }}>Bata</option>
            </select>
        </div>

        <div class="col-md-4">
            <label>Jumlah</label>
            <input
                type="number"
                name="jumlah"
                id="jumlah"
                class="form-control"
                value="{{ $jumlah }}"
                min="0"
                required
            >
        </div>

        <div class="col-md-4">
            <label>Harga</label>
            <input
                type="number"
                name="harga"
                id="harga"
                class="form-control"
                value="{{ $harga }}"
                min="0"
                required
            >
        </div>
    </div>

    {{-- Submit --}}
    <div class="row">
        <div class="col">
            <a href="{{ route('bebantanam.index') }}" class="btn btn-secondary mr-2">Kembali</a>
                <button type="submit" class="btn btn-primary">
                Submit
            </button>
        </div>
    </div>
</form>

{{-- Optional input limiter --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const jumlah = document.getElementById('jumlah');
    const harga  = document.getElementById('harga');

    jumlah.addEventListener('input', () => {
        if (jumlah.value.length > 4) {
            jumlah.value = jumlah.value.slice(0, 4);
        }
    });

    harga.addEventListener('input', () => {
        if (harga.value.length > 7) {
            harga.value = harga.value.slice(0, 7);
        }
    });
});
</script>
@endsection
