<?php
class JurnalModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getLaporanJurnal($tanggal_mulai, $tanggal_selesai, $akun_id) {
        $sql = "SELECT j.tanggal, c1.nama_akun AS akun_debet, c2.nama_akun AS akun_kredit, j.jumlah, j.keterangan
                FROM jurnal_umum j
                JOIN chart_of_accounts c1 ON j.akun_debet = c1.id
                JOIN chart_of_accounts c2 ON j.akun_kredit = c2.id
                WHERE j.tanggal BETWEEN ? AND ?";
    
        if (!empty($akun_id)) {
            $sql .= " AND (j.akun_debet = ? OR j.akun_kredit = ?)";
        }
    
        $stmt = $this->conn->prepare($sql);
    
        if (!empty($akun_id)) {
            $stmt->bind_param("ssii", $tanggal_mulai, $tanggal_selesai, $akun_id, $akun_id);
        } else {
            $stmt->bind_param("ss", $tanggal_mulai, $tanggal_selesai);
        }
    
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>