<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Margin Kontribusi</title>
    <style>
        body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 11px; }
        h1, h2, h3 { margin: 0 0 6px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        th, td { border: 1px solid #000; padding: 4px 6px; }
        th { background: #f0f0f0; }
        .text-right { text-align: right; }
        .mt-2 { margin-top: 8px; }
        .mt-4 { margin-top: 16px; }
    </style>
</head>
<body>
    <h1>Laporan Margin Kontribusi</h1>
    <p><strong>Kode Tanam:</strong> {{ $hasil['tanam']['kode_tanam'] }}</p>
    <p>
        <strong>Komoditas:</strong> {{ $hasil['tanam']['komoditas'] }}<br>
        <strong>Petani:</strong> {{ $hasil['tanam']['petani'] }}<br>
        <strong>Volume Panen:</strong> {{ number_format($hasil['tanam']['volume'] ?? 0, 2, ',', '.') }}
    </p>

    <h3 class="mt-4">Ringkasan Pendapatan & Biaya</h3>
    <table>
        <tbody>
            <tr>
                <th>Pendapatan</th>
                <td class="text-right">
                    Rp {{ number_format($hasil['ringkasan']['pendapatan'] ?? 0, 0, ',', '.') }}
                </td>
            </tr>
            <tr>
                <th>Biaya Variabel</th>
                <td class="text-right">
                    Rp {{ number_format($hasil['ringkasan']['biaya_var'] ?? 0, 0, ',', '.') }}
                </td>
            </tr>
            <tr>
                <th>Biaya Tetap</th>
                <td class="text-right">
                    Rp {{ number_format($hasil['ringkasan']['biaya_tetap'] ?? 0, 0, ',', '.') }}
                </td>
            </tr>
            <tr>
                <th>Total Biaya Produksi</th>
                <td class="text-right">
                    Rp {{ number_format($hasil['ringkasan']['total_biaya'] ?? 0, 0, ',', '.') }}
                </td>
            </tr>
            <tr>
                <th>Keuntungan Bersih</th>
                <td class="text-right">
                    Rp {{ number_format($hasil['ringkasan']['laba_bersih'] ?? 0, 0, ',', '.') }}
                </td>
            </tr>
        </tbody>
    </table>

    <h3 class="mt-4">Perhitungan Per Unit</h3>
    <table>
        <tbody>
            <tr>
                <th>Harga Jual per Unit</th>
                <td class="text-right">
                    @if ($hasil['per_unit']['harga_jual_per_unit'] ?? null)
                        Rp {{ number_format($hasil['per_unit']['harga_jual_per_unit'], 0, ',', '.') }}
                    @else
                        -
                    @endif
                </td>
            </tr>
            <tr>
                <th>Biaya Variabel per Unit</th>
                <td class="text-right">
                    @if ($hasil['per_unit']['biaya_variabel_per_unit'] ?? null)
                        Rp {{ number_format($hasil['per_unit']['biaya_variabel_per_unit'], 0, ',', '.') }}
                    @else
                        -
                    @endif
                </td>
            </tr>
            <tr>
                <th>Margin Kontribusi per Unit</th>
                <td class="text-right">
                    @if ($hasil['per_unit']['margin_kontribusi_per_unit'] ?? null)
                        Rp {{ number_format($hasil['per_unit']['margin_kontribusi_per_unit'], 0, ',', '.') }}
                    @else
                        -
                    @endif
                </td>
            </tr>
            <tr>
                <th>Rasio Margin Kontribusi</th>
                <td class="text-right">
                    @if ($hasil['per_unit']['rasio_margin_kontribusi'] ?? null)
                        {{ number_format($hasil['per_unit']['rasio_margin_kontribusi'] * 100, 2, ',', '.') }}%
                    @else
                        -
                    @endif
                </td>
            </tr>
        </tbody>
    </table>

    <h3 class="mt-4">Break Even Point (BEP)</h3>
    <table>
        <tbody>
            <tr>
                <th>BEP (Unit)</th>
                <td class="text-right">
                    @if ($hasil['bep']['bep_unit'] ?? null)
                        {{ number_format($hasil['bep']['bep_unit'], 2, ',', '.') }}
                    @else
                        -
                    @endif
                </td>
            </tr>
            <tr>
                <th>BEP (Rupiah)</th>
                <td class="text-right">
                    @if ($hasil['bep']['bep_rupiah'] ?? null)
                        Rp {{ number_format($hasil['bep']['bep_rupiah'], 0, ',', '.') }}
                    @else
                        -
                    @endif
                </td>
            </tr>
        </tbody>
    </table>

    <h3 class="mt-4">Margin Keamanan</h3>
    <table>
        <tbody>
            <tr>
                <th>Margin Keamanan (Rp)</th>
                <td class="text-right">
                    @if ($hasil['margin_keamanan']['nominal'] ?? null)
                        Rp {{ number_format($hasil['margin_keamanan']['nominal'], 0, ',', '.') }}
                    @else
                        -
                    @endif
                </td>
            </tr>
            <tr>
                <th>Margin Keamanan (%)</th>
                <td class="text-right">
                    @if ($hasil['margin_keamanan']['persen'] ?? null)
                        {{ number_format($hasil['margin_keamanan']['persen'] * 100, 2, ',', '.') }}%
                    @else
                        -
                    @endif
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>
