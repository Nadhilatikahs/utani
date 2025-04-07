<?php
require_once "models/KasModel.php";

$conn = new mysqli("localhost", "root", "", "utani_xyz");
$kasModel = new KasModel($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tanggal = $_POST['tanggal'];
    $jenis = $_POST['jenis'];
    $akun_id = $_POST['akun_id'];
    $jumlah = $_POST['jumlah'];
    $keterangan = $_POST['keterangan'];

    if ($kasModel->tambahTransaksi($tanggal, $jenis, $akun_id, $jumlah, $keterangan)) {
        header("Location: index.php");
    } else {
        echo "Gagal menambahkan transaksi.";
    }
}
?>