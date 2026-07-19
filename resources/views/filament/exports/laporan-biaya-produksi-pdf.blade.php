<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Biaya Produksi</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h1, h2, h3 { margin: 4px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        th, td { border: 1px solid #444; padding: 4px 6px; }
        th { background: #eee; }
    </style>
</head>
<body>
    <h1>Laporan Biaya Produksi</h1>
    <p>
        Kode Tanam: <strong>{{ $hasil['tanam']['kode_tanam'] }}</strong><br>
        Komoditas: {{ $hasil['tanam']['komoditas'] }}<br>
        Petani: {{ $hasil['tanam']['petani'] }}<br>
        Volume Panen: {{ number_format($hasil['tanam']['volume'] ?? 0, 2, ',', '.') }}
    </p>

    <h2>Ringkasan Biaya & Pendapatan</h2>
    <table>
        <tbody>
            <tr>
                <th>Pendapatan</th>
                <td>Rp {{ number_format($hasil['ringkasan']['pendapatan'] ?? 0, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Biaya Variabel</th>
                <td>Rp {{ number_format($hasil['ringkasan']['biaya_var'] ?? 0, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Biaya Tetap</th>
                <td>Rp {{ number_format($hasil['ringkasan']['biaya_tetap'] ?? 0, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Total Biaya</th>
                <td>Rp {{ number_format($hasil['ringkasan']['total_biaya'] ?? 0, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Keuntungan Bersih</th>
                <td>Rp {{ number_format($hasil['ringkasan']['keuntungan'] ?? 0, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th>CMPU</th>
                <td>
                    @if ($hasil['ringkasan']['cmpu'] ?? null)
                        Rp {{ number_format($hasil['ringkasan']['cmpu'], 2, ',', '.') }}
                    @else
                        -
                    @endif
                </td>
            </tr>
        </tbody>
    </table>

    <h2>Detail Biaya Produksi</h2>

    @foreach (['BBB', 'BTKL', 'BOP', 'LAIN'] as $kategori)
        @php
            $section = $hasil['detail_biaya'][$kategori] ?? null;
        @endphp

        @if ($section && count($section['items']) > 0)
            <h3>{{ $kategori }}</h3>
            <table>
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama Beban</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($section['items'] as $row)
                        <tr>
                            <td>{{ $row['kode_beban'] }}</td>
                            <td>{{ $row['nama_beban'] }}</td>
                            <td>{{ number_format($row['jumlah'], 2, ',', '.') }} {{ $row['satuan'] }}</td>
                            <td>Rp {{ number_format($row['harga'], 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($row['total'], 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    @endforeach
</body>
</html>
