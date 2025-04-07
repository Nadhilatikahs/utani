<?php
require_once "../config/database.php";

class TransactionModel {
    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    public function addTransaction($type, $amount, $description, $account_id) {
        $sql = "INSERT INTO transactions (type, amount, description, account_id) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sdsi", $type, $amount, $description, $account_id);
        return $stmt->execute();
    }

    public function getTransactions() {
        $sql = "SELECT * FROM transactions ORDER BY date DESC";
        return $this->conn->query($sql);
    }

    public function getJournalEntries() {
        $sql = "SELECT * FROM journal_entries ORDER BY date DESC";
        return $this->conn->query($sql);
    }
}
?>
