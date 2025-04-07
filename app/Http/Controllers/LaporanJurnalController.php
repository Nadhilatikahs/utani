<?php
require_once "models/JurnalModel.php";
require_once "models/CoaModel.php";

$conn = new mysqli("localhost", "root", "", "utani_xyz");
$jurnalModel = new JurnalModel($conn);
$coaModel = new CoaModel($conn);

$tanggal_mulai = $_GET['tanggal_mulai'] ?? "";
$tanggal_selesai = $_GET['tanggal_selesai'] ?? "";
$akun_id = $_GET['akun_id'] ?? "";

$laporanJurnal = $jurnalModel->getLaporanJurnal($tanggal_mulai, $tanggal_selesai, $akun_id);
$akunList = $coaModel->getAkun();
?>
