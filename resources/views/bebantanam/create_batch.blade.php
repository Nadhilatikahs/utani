@extends('layouts.app')

@section('title', 'Input Beban Tanam (Multi-row)')

@section('contents')
    <div class="d-flex align-items-center justify-content-between">
        <div>
            <h1 class="mb-0">Tambah Data</h1>
            <div class="text-muted">Beban Tanam — <b>{{ $tanam->kode_tanam }}</b></div>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('bebantanam.byTanam', $tanam->id_tanam) }}" class="btn btn-outline-secondary">
                Lihat Rincian Tanam Ini
            </a>
            <a href="{{ route('bebantanam.index') }}" class="btn btn-outline-secondary">
                Kembali ke List
            </a>
        </div>
    </div>

    <hr />

    @if ($errors->any())
        <div class="alert alert-danger">
            <b>Validasi gagal:</b>
            <ul class="mb-0">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @php
        // meta untuk auto-isi satuan default
        $bebansMeta = $bebans->mapWithKeys(function ($b) {
            return [
                $b->id_beban => [
                    'satuan_default' => null,
                ],
            ];
        })->toArray();
    @endphp

    <form action="{{ route('bebantanam.storeBatch', $tanam->id_tanam) }}" method="POST">
        @csrf

        <div class="card">
            <div class="card-body">
                <div class="alert alert-info mb-3">
                    Isi beberapa beban sekaligus untuk <b>{{ $tanam->kode_tanam }}</b>.
                    Total akan dihitung otomatis di bawah.
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th style="min-width: 360px;">Nama Beban</th>
                                <th style="width: 140px;" class="text-center">Jumlah</th>
                                <th style="width: 160px;" class="text-center">Satuan</th>
                                <th style="width: 180px;" class="text-end">Harga</th>
                                <th style="width: 180px;" class="text-end">Total</th>
                                <th style="width: 90px;" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="rows"></tbody>
                        <tfoot class="table-light">
                            <tr>
                                <td colspan="4" class="text-end"><b>Grand Total</b></td>
                                <td class="text-end"><b id="grandTotal">Rp 0</b></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <datalist id="satuanOptions">
                    <option value="kg">
                    <option value="g">
                    <option value="L">
                    <option value="ml">
                    <option value="HOK">
                    <option value="jam">
                    <option value="hari">
                    <option value="minggu">
                    <option value="bulan">
                    <option value="musim">
                    <option value="paket">
                    <option value="kali">
                    <option value="trip">
                    <option value="ha">
                    <option value="m2">
                    <option value="tahun">
                    <option value="sak">
                    <option value="karung">
                    <option value="botol">
                    <option value="unit">
                </datalist>

                {{-- template row: tidak pakai blade di dalam JS string --}}
                <template id="rowTemplate">
                    <tr>
                        <td>
                            <select name="id_beban[]" class="form-control bebanSelect" required>
                                <option value="" selected disabled>-- pilih beban --</option>
                                @foreach ($bebans as $b)
                                    <option value="{{ $b->id_beban }}">
                                        {{ $b->kode_beban }} — {{ $b->nama_beban }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted d-block mt-1">
                                Kalau belum ada, tambah di Master Beban dulu.
                            </small>
                        </td>
                        <td>
                            <input type="number" step="0.01" min="0" name="jumlah[]" class="form-control text-center jumlahInp" required>
                        </td>
                        <td>
                            <input name="satuan[]" class="form-control satuanInp" list="satuanOptions"
                                   placeholder="kg / jam / paket / tahun" required>
                        </td>
                        <td>
                            <input type="number" step="1" min="0" name="harga[]" class="form-control text-end hargaInp" required>
                        </td>
                        <td class="text-end rowTotal">Rp 0</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-outline-danger btnDel">X</button>
                        </td>
                    </tr>
                </template>

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <button type="button" id="btnAdd" class="btn btn-outline-primary">
                        + Tambah Baris
                    </button>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            Submit Semua Beban
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script>
        (function () {
            const rowsEl = document.getElementById('rows');
            const btnAdd = document.getElementById('btnAdd');
            const grandTotalEl = document.getElementById('grandTotal');
            const tpl = document.getElementById('rowTemplate');

            const bebanMeta = @json($bebansMeta);

            function rupiah(n) {
                const v = Number(n || 0);
                return 'Rp ' + v.toLocaleString('id-ID');
            }

            function recalc() {
                let grand = 0;

                rowsEl.querySelectorAll('tr').forEach(tr => {
                    const jumlah = Number(tr.querySelector('.jumlahInp').value || 0);
                    const harga  = Number(tr.querySelector('.hargaInp').value || 0);
                    const total  = jumlah * harga;

                    tr.querySelector('.rowTotal').textContent = rupiah(total);
                    grand += total;
                });

                grandTotalEl.textContent = rupiah(grand);
            }

            function addRow(prefill = {}) {
                const node = tpl.content.cloneNode(true);
                const tr = node.querySelector('tr');

                const select = tr.querySelector('.bebanSelect');
                const jumlahInp = tr.querySelector('.jumlahInp');
                const satuanInp = tr.querySelector('.satuanInp');
                const hargaInp  = tr.querySelector('.hargaInp');
                const btnDel    = tr.querySelector('.btnDel');

                if (prefill.id_beban) select.value = String(prefill.id_beban);
                if (prefill.jumlah)   jumlahInp.value = prefill.jumlah;
                if (prefill.satuan)   satuanInp.value = prefill.satuan;
                if (prefill.harga)    hargaInp.value  = prefill.harga;

                // auto satuan default dari master beban
                select.addEventListener('change', () => {
                    const meta = bebanMeta[select.value];
                    if (meta && meta.satuan_default && !satuanInp.value) {
                        satuanInp.value = meta.satuan_default;
                    }
                });

                [jumlahInp, satuanInp, hargaInp, select].forEach(el => {
                    el.addEventListener('input', recalc);
                    el.addEventListener('change', recalc);
                });

                btnDel.addEventListener('click', () => {
                    tr.remove();
                    recalc();
                });

                rowsEl.appendChild(node);
                recalc();
            }

            btnAdd.addEventListener('click', () => addRow());

            // default 3 baris
            addRow();
            addRow();
            addRow();
        })();
    </script>
@endsection
