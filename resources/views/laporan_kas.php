<form method="GET" action="">
    <label>Tanggal Mulai:</label>
    <input type="date" name="tanggal_mulai" value="<?= $_GET['tanggal_mulai'] ?? '' ?>">
    
    <label>Tanggal Selesai:</label>
    <input type="date" name="tanggal_selesai" value="<?= $_GET['tanggal_selesai'] ?? '' ?>">
    
    <button type="submit">Filter</button>
</form>

<table border="1">
    <tr>
        <th>Tanggal</th>
        <th>Jenis</th>
        <th>Akun</th>
        <th>Jumlah</th>
        <th>Keterangan</th>
    </tr>
    <?php foreach ($laporanKas as $kas): ?>
        <tr>
            <td><?= $kas['tanggal'] ?></td>
            <td><?= $kas['jenis'] ?></td>
            <td><?= $kas['nama_akun'] ?></td>
            <td><?= number_format($kas['jumlah'], 2) ?></td>
            <td><?= $kas['keterangan'] ?></td>
        </tr>
    <?php endforeach; ?>
</table>
