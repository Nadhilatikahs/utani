<form action="/cash-transactions" method="POST">
    @csrf
    <label>Jenis Transaksi:</label>
    <select name="transaction_type">
        <option value="masuk">Kas Masuk</option>
        <option value="keluar">Kas Keluar</option>
    </select>

    <label>Tanggal:</label>
    <input type="date" name="transaction_date" required>

    <label>Jumlah:</label>
    <input type="number" name="amount" step="0.01" required>

    <label>Deskripsi:</label>
    <input type="text" name="description">

    <button type="submit">Simpan</button>
</form>