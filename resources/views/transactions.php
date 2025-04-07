<?php
require_once "../models/TransactionModel.php";

$transactionModel = new TransactionModel();
$transactions = $transactionModel->getTransactions();
?>

<h2>Pencatatan Kas Masuk & Keluar</h2>
<form action="../controllers/TransactionController.php" method="POST">
    <label>Jenis Transaksi:</label>
    <select name="type" required>
        <option value="kas masuk">Kas Masuk</option>
        <option value="kas keluar">Kas Keluar</option>
    </select>
    <br>

    <label>Jumlah:</label>
    <input type="number" name="amount" required>
    <br>

    <label>Deskripsi:</label>
    <input type="text" name="description" required>
    <br>

    <label>ID Akun:</label>
    <input type="number" name="account_id" required>
    <br>

    <button type="submit">Tambah Transaksi</button>
</form>

<h3>Daftar Transaksi</h3>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Tanggal</th>
        <th>Jenis</th>
        <th>Jumlah</th>
        <th>Deskripsi</th>
    </tr>
    <?php while ($row = $transactions->fetch_assoc()) { ?>
        <tr>
            <td><?= $row["id"] ?></td>
            <td><?= $row["date"] ?></td>
            <td><?= $row["type"] ?></td>
            <td><?= $row["amount"] ?></td>
            <td><?= $row["description"] ?></td>
        </tr>
    <?php } ?>
</table>
