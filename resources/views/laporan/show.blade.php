@extends('layouts.app')

@section('title', 'Laporan')

@section('contents')
    <div class="d-flex align-items-center justify-content-between">
        <h1 class="mb-0">Laporan Biaya Hasil Pertanian</h1>
    </div>
    <hr />
    @if(Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif

    <!-- Form Filter -->
    <form method="GET" action="{{ route('laporan.show') }}">
    <label for="filter_id_tanam">Filter berdasarkan ID Tanam:</label>
    <select id="filter_id_tanam" name="filter_id_tanam" required>
        <option value="">Pilih ID Tanam</option>
        @foreach($kodeTanamList as $id_tanam => $kode)
            <option value="{{ $id_tanam }}" {{ old('filter_id_tanam', $filter ?? '') == $id_tanam ? 'selected' : '' }}>
                {{ $kode }}
            </option>
        @endforeach
    </select>
    <button type="submit">Filter</button>

</form>

    <style>
        body {
            color: black;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 4px;
            text-align: left;
        }
        th.no, td.no {
            width: 50px;
        }
        .section-title {
            margin-top: 40px;
        }
        .sub-title {
            margin-top: 10px;
        }
    </style>

    <table>
        <thead>
            <tr>
                <th rowspan="2" class="no">No</th>
                <th rowspan="2" class="text-center">Uraian</th>
                <th rowspan="2" class="text-center">Vol</th>
                <th rowspan="2" class="text-center">harga/satuan</th>
                <th colspan="3" class="text-center">PERLAKUAN (Luas Lahan 0,1 Ha)</th>
            </tr>
            <tr>
                <th class="text-center">Anorganik (0,036 Ha)</th>
                <th class="text-center">Organik & Anorganik (0,036 Ha)</th>
                <th class="text-center">Organik (0,028 Ha)</th>
            </tr>
        </thead>
        <tbody>
            @php $cacah_pengeluaran = 0 @endphp
            @foreach ($data as $judul => $kategori)
                <tr>
                    <td colspan="7" class="section-title"><h4>{{ $judul }}</h2></td>
                </tr>
                @foreach ($kategori as $sub_judul => $isi)
                    <tr>
                        <td colspan="7" class="sub-title"><h5>{{ $sub_judul }}</h4></td>
                    </tr>
                    @php $index = 1 @endphp
                    @if (is_iterable($isi) && count($isi) > 0)
                        @foreach ($isi as $item)
                            @if ($judul == 'A. Komponen Pengeluaran' && $sub_judul == '1. Bibit ')
                                <tr>
                                    <td class="no">{{ $index++ }}</td>
                                    <td>{{ $item->nama_komoditas }}</td>
                                    <td class="text-center">kg</td>
                                    <td class="text-right">Rp.{{ format_uang($item->harga_satuan) }}</td>
                                    <td colspan="3" class="text-center">Rp.{{ format_uang($item->harga_satuan) }}</td>
                                </tr>
                            @elseif ($judul == 'A. Komponen Pengeluaran' && $sub_judul == '2. Persiapan lahan ')
                                <tr>
                                    <td class="no">{{ $index++ }}</td>
                                    <td>{{ $item->nama_beban }}</td>
                                    <td>{{ $item->jumlah }}/{{ $item->satuan }}</td>
                                    <td class="text-right">Rp.{{ format_uang($item->harga) }}</td>
                                    <td colspan="3" class="text-center">Rp.{{ format_uang($item->total) }}</td>
                                </tr>
                            @elseif ($judul == 'A. Komponen Pengeluaran' && $sub_judul == '3. Pemupukan ')
                                <tr>
                                    <td class="no">{{ $index++ }}</td>
                                    <td>{{ $item->nama_beban }}</td>
                                    <td>{{ $item->jumlah }}/{{ $item->satuan }}</td>
                                    <td class="text-right">Rp.{{ format_uang($item->harga) }}</td>
                                    <td colspan="3" class="text-center">Rp.{{ format_uang($item->total) }}</td>
                                </tr>
                            @elseif ($judul == 'A. Komponen Pengeluaran' && $sub_judul == '4. Pemeliharaan ')
                                <tr>
                                    <td class="no">{{ $index++ }}</td>
                                    <td>{{ $item->nama_beban }}</td>
                                    <td>{{ $item->jumlah }}/{{ $item->satuan }}</td>
                                    <td class="text-right">Rp.{{ format_uang($item->harga) }}</td>
                                    <td colspan="3" class="text-center">Rp.{{ format_uang($item->total) }}</td>
                                </tr>
                            @elseif ($judul == 'A. Komponen Pengeluaran' && $sub_judul == '5. Panen dan Pasca Panen ')
                                <tr>
                                    <td class="no">{{ $index++ }}</td>
                                    <td>{{ $item->nama_beban }}</td>
                                    <td>{{ $item->jumlah }}/{{ $item->satuan }}</td>
                                    <td class="text-right">Rp.{{ format_uang($item->harga) }}</td>
                                    <td colspan="3" class="text-center">Rp.{{ format_uang($item->total) }}</td>
                                </tr>
                            @elseif ($judul == 'A. Komponen Pengeluaran' && $sub_judul == '6. Pajak ')
                                <tr>
                                    <td class="no">{{ $index++ }}</td>
                                    <td>{{ $item->nama_beban }}</td>
                                    <td>{{ $item->jumlah }}/{{ $item->satuan }}</td>
                                    <td class="text-right">Rp.{{ format_uang($item->harga) }}</td>
                                    <td colspan="3" class="text-center">Rp.{{ format_uang($item->total) }}</td>
                                </tr>
                            @elseif ($judul == 'A. Komponen Pengeluaran' && $sub_judul == 'Jumlah Total Pengeluaran')
                                <tr>
                                    
                                    <td colspan="7" class="text-center"><b>Rp.{{ format_uang($item->jumlah_total) }}</b></td>
                                </tr>
                                
                                
                         @elseif ($judul == 'B. Komponen Pendapatan' && $sub_judul == '1. Hasil Panen')
                                <tr>
                                    
                                    <td class="no">{{ $index++ }}</td>
                                    <td>{{ $item->kode_panen }}</td>
                                    <td>{{ $item->jumlah }}/kg</td>
                                    <td class="text-right">Rp.{{ format_uang($item->harga) }}</td>
                                    <td colspan="3" class="text-center">Rp.{{ format_uang($item->hasil_panen) }}</td>
                                    
                                </tr>

                                @elseif ($judul == 'B. Komponen Pendapatan' && $sub_judul == 'Jumlah Total Pendapatan')
                                <tr>
                                    
                                    <td colspan="7" class="text-center"><b>Rp.{{ format_uang($item->total_panen) }}</b></td>
                                </tr>

                                @elseif ($judul == 'C. Komponen Keuntungan' && $sub_judul == '1. Keuntungan')
                                <tr>
                                    
                                    <td class="no">{{ $index++ }}</td>
                                    <td>{{ $item->kode_tanam }}</td>
                                    
                                    <td colspan="6" class="text-center"><b>Rp.{{ format_uang($item->keuntungan) }}</b></td>
                                    
                                </tr>

                                
                            @endif

                            
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7">Tidak ada data</td>
                        </tr>
                    @endif
                @endforeach
            @endforeach
        </tbody>
    </table>
@endsection
