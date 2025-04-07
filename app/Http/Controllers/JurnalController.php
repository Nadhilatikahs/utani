<?php
require_once "models/JurnalModel.php";

$conn = new mysqli("localhost", "root", "", "utani_xyz");
$jurnalModel = new JurnalModel($conn);

$jurnalEntries = $jurnalModel->getJurnal();
?>