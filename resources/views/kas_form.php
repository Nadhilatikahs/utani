<form method="POST" action="controllers/KasController.php">
    <label>Tanggal:</label>
    <input type="date" name="tanggal" required>

    <label>Jenis Transaksi:</label>
    <select name="jenis">
        <option value="Masuk">Kas Masuk</option>
        <option value="Keluar">Kas Keluar</option>
    </select>

    <label>Akun:</label>
    <select name="akun_id">
        <?php
        require_once "models/CoaModel.php";
        $coaModel = new CoaModel($conn);
        $akunList = $coaModel->getAkun();
        foreach ($akunList as $akun) {
            echo "<option value='{$akun['id']}'>{$akun['nama_akun']}</option>";
        }
        ?>
    </select>

    <label>Jumlah:</label>
    <input type="number" name="jumlah" step="0.01" required>

    <label>Keterangan:</label>
    <textarea name="keterangan"></textarea>

    <button type="submit">Simpan</button>
</form>
