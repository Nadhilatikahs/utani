<?php
require_once "models/KasModel.php";

$conn = new mysqli("localhost", "root", "", "utani_xyz");
$kasModel = new KasModel($conn);

$tanggal_mulai = $_GET['tanggal_mulai'] ?? "";
$tanggal_selesai = $_GET['tanggal_selesai'] ?? "";

$laporanKas = $kasModel->getLaporanKas($tanggal_mulai, $tanggal_selesai);
?>
