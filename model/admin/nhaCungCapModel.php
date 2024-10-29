<?php
require_once 'config/connect.php';
class NhaCungCapModel {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    public function getAllSuppliers() {
        $sql = "SELECT * FROM ncc";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function addSupplier($ten_ncc, $diachi, $sdt, $masothue, $ghichu) {
        $sql = "INSERT INTO ncc (ten_ncc, diachi, sdt, masothue, ghichu) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$ten_ncc, $diachi, $sdt, $masothue, $ghichu]);
    }
    public function getSupplierById($id) {
        $sql = "SELECT * FROM ncc WHERE ncc_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }    

    public function updateSupplier($ncc_id, $ten_ncc, $diachi, $sdt, $masothue, $ghichu) {
        $sql = "UPDATE ncc SET ten_ncc = ?, diachi = ?, sdt = ?, masothue = ?, ghichu = ? WHERE ncc_id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$ten_ncc, $diachi, $sdt, $masothue, $ghichu, $ncc_id]);
    }

    public function deleteSupplier($id) {
        $sql = "DELETE FROM ncc WHERE ncc_id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }
    public function searchSupplier($keyword) {
        $stmt = $this->conn->prepare("SELECT * FROM ncc WHERE ten_ncc LIKE :keyword");
        $stmt->execute(['keyword' => "%$keyword%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
 
}
?>