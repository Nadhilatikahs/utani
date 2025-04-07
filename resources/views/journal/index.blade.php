<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Jurnal</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #e9f7ef; /* Warna latar hijau muda */
        }
        h1 {
            color: #1e8449; /* Warna hijau gelap */
        }
        .table {
            background-color: #ffffff; /* Latar belakang tabel putih */
            border: 1px solid #28a745; /* Warna border hijau */
        }
        .table th {
            background-color: #28a745; /* Header tabel hijau */
            color: #ffffff; /* Teks putih */
        }
        .btn-back {
            background-color: #28a745; /* Tombol hijau */
            color: #ffffff; /* Teks putih */
        }
        .btn-back:hover {
            background-color: #1e8449; /* Warna hijau lebih gelap saat hover */
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Daftar Jurnal</h1>

        <!-- Tombol kembali -->
        <div class="d-flex justify-content-start mb-4">
            <button class="btn btn-back" onclick="history.back()">&larr; Kembali</button>
        </div>

        <!-- Table untuk menampilkan jurnal -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Akun</th>
                    <th>Debit</th>
                    <th>Kredit</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($journal as $journal)
                    <tr>
                        <td>{{ $journal->No }}</td>
                        <td>{{ $journal->akun }}</td>
                        <td>{{ number_format($journal->debit, 2, ',', '.') }}</td>
                        <td>{{ number_format($journal->kredit, 2, ',', '.') }}</td>
                        <td>{{ $journal->created_at->format('d-m-Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
