<table border="1">
    <tr>
        <th>Tanggal</th>
        <th>Akun Debet</th>
        <th>Akun Kredit</th>
        <th>Jumlah</th>
        <th>Keterangan</th>
    </tr>
    <?php foreach ($jurnalEntries as $entry): ?>
        <tr>
            <td><?= $entry['tanggal'] ?></td>
            <td><?= $entry['akun_debet'] ?></td>
            <td><?= $entry['akun_kredit'] ?></td>
            <td><?= $entry['jumlah'] ?></td>
            <td><?= $entry['keterangan'] ?></td>
        </tr>
    <?php endforeach; ?>
</table>