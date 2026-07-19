<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuntungan & Kerugian</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h1, h2 { margin: 4px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        th, td { border: 1px solid #444; padding: 4px 6px; }
        th { background: #eee; }
    </style>
</head>
<body>
    <h1>Laporan Keuntungan & Kerugian</h1>

    <p>
        Kode Tanam: <strong>{{ $hasil['tanam']['kode_tanam'] }}</strong><br>
        Komoditas: {{ $hasil['tanam']['komoditas'] }}<br>
        Petani: {{ $hasil['tanam']['petani'] }}<br>
        Volume Panen: {{ number_format($hasil['tanam']['volume'] ?? 0, 2, ',', '.') }}
    </p>

    <h2>Pendapatan & Biaya</h2>
    <table>
        <tbody>
            <tr>
                <th>Pendapatan</th>
                <td>Rp {{ number_format($hasil['nilai']['pendapatan'] ?? 0, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Biaya Variabel</th>
                <td>Rp {{ number_format($hasil['nilai']['biaya_variabel'] ?? 0, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Biaya Tetap</th>
                <td>Rp {{ number_format($hasil['nilai']['biaya_tetap'] ?? 0, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Total Biaya</th>
                <td>Rp {{ number_format($hasil['nilai']['total_biaya'] ?? 0, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Laba Bersih</th>
                <td>Rp {{ number_format($hasil['nilai']['laba_bersih'] ?? 0, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <h2>Margin Kontribusi & Titik Impas</h2>
    <table>
        <tbody>
            <tr>
                <th>Margin Kontribusi Total</th>
                <td>Rp {{ number_format($hasil['nilai']['margin_total'] ?? 0, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Harga per Unit</th>
                <td>
                    @if ($hasil['nilai']['harga_per_unit'] ?? null)
                        Rp {{ number_format($hasil['nilai']['harga_per_unit'], 2, ',', '.') }}
                    @else
                        -
                    @endif
                </td>
            </tr>
            <tr>
                <th>Biaya Variabel per Unit</th>
                <td>
                    @if ($hasil['nilai']['biaya_variabel_unit'] ?? null)
                        Rp {{ number_format($hasil['nilai']['biaya_variabel_unit'], 2, ',', '.') }}
                    @else
                        -
                    @endif
                </td>
            </tr>
            <tr>
                <th>Margin Kontribusi per Unit</th>
                <td>
                    @if ($hasil['nilai']['margin_per_unit'] ?? null)
                        Rp {{ number_format($hasil['nilai']['margin_per_unit'], 2, ',', '.') }}
                    @else
                        -
                    @endif
                </td>
            </tr>
            <tr>
                <th>BEP (Unit)</th>
                <td>
                    @if ($hasil['nilai']['bep_unit'] ?? null)
                        {{ number_format($hasil['nilai']['bep_unit'], 2, ',', '.') }}
                    @else
                        -
                    @endif
                </td>
            </tr>
            <tr>
                <th>BEP (Rupiah)</th>
                <td>
                    @if ($hasil['nilai']['bep_rupiah'] ?? null)
                        Rp {{ number_format($hasil['nilai']['bep_rupiah'], 0, ',', '.') }}
                    @else
                        -
                    @endif
                </td>
            </tr>
            <tr>
                <th>Status</th>
                <td>{{ $hasil['nilai']['status'] ?? '-' }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
