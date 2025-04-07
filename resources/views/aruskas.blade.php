<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arus Kas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color:rgb(204, 224, 202);
            font-family: 'Arial', sans-serif;
        }
        .card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .btn-custom {
            font-size: 1.2rem;
            border-radius: 0.5rem;
            padding: 1rem;
            width: 100%;
            color: white;
        }
        .btn-success {
            background-color: #28a745;
        }
        .btn-warning {
            background-color: #ffc107;
            color: #343a40;
        }
        .btn-primary {
            background-color: #007bff;
        }
        .btn-secondary {
            margin-top: 1rem;
            color: white;
        }
        .container-title {
            background-color: #007bff;
            color: white;
            padding: 1.5rem;
            border-radius: 1rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <!-- Header -->
        <div class="container-title text-center">
            <h1>Selamat Datang di Arus Kas</h1>
            <p>Kelola keuangan Anda dengan mudah dan cepat</p>
        </div>

        <!-- Content -->
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card text-center p-3">
                    <button class="btn btn-custom btn-success">
                        Rp {{ number_format($kasMasuk, 0, ',', '.') }} <br><small>Kas Masuk</small>
                    </button>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center p-3">
                    <button class="btn btn-custom btn-warning">
                        Rp {{ number_format($kasKeluar, 0, ',', '.') }} <br><small>Kas Keluar</small>
                    </button>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center p-3">
                    <button class="btn btn-custom btn-primary">
                        Rp {{ number_format($saldoKas, 0, ',', '.') }} <br><small>Saldo Kas</small>
                    </button>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="text-center mt-5">
    <a href="{{ route('aruskas.create') }}" class="btn btn-success btn-lg me-3 mb-3" style="width: 200px;">Tambah Kas</a>
    <!-- Button untuk lihat jurnal -->
    <a href="{{ route('journal.index') }}" class="btn btn-info btn-lg mb-3" style="width: 200px;">Lihat Jurnal</a>
    <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-lg me-3 mb-3" style="width: 200px;">Kembali ke Dashboard</a>
</div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="alert alert-success text-center mt-4">
                {{ session('success') }}
            </div>
        @endif
    </div>



    
</body>
</html>
