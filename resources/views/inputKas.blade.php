<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Kas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body style="background-color:rgb(201, 242, 211);">
    <div class="container mt-5">
        <h1 class="text-center">Input Kas</h1>
        <form action="{{ route('aruskas.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="type" class="form-label">Tipe Kas</label>
                <select name="type" id="type" class="form-select" required>
                    <option value="" disabled selected>Pilih Tipe Kas</option>
                    <option value="masuk">Kas Masuk</option>
                    <option value="keluar">Kas Keluar</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="amount" class="form-label">Jumlah (Rp)</label>
                <input type="number" name="amount" id="amount" class="form-control" placeholder="Masukkan jumlah kas" required>
            </div>
            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea name="keterangan" id="keterangan" class="form-control" placeholder="Masukkan keterangan transaksi" rows="3" required></textarea>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('aruskas.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
</body>
</html>