<?php
require_once "config/database.php";

class KasModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function tambahTransaksi($tanggal, $jenis, $akun_id, $jumlah, $keterangan) {
        $sql = "INSERT INTO transaksi_kas (tanggal, jenis, akun_id, jumlah, keterangan) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssids", $tanggal, $jenis, $akun_id, $jumlah, $keterangan);
        return $stmt->execute();
    }

    public function getTransaksi() {
        $sql = "SELECT t.id, t.tanggal, t.jenis, c.nama_akun, t.jumlah, t.keterangan 
                FROM transaksi_kas t 
                JOIN chart_of_accounts c ON t.akun_id = c.id 
                ORDER BY t.tanggal DESC";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>
