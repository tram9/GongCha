<?php
require_once 'config/connect.php';
class KhoHangModel {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    public function getAllProducts() {
        $sql = "SELECT * FROM kho_hang";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function addProduct($ten_nl, $so_luong, $ngay_nhap, $gia_nhap, $ncc_id) {
        $sql = "INSERT INTO kho_hang (ten_nl, so_luong, ngay_nhap, gia_nhap, ncc_id) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$ten_nl, $so_luong, $ngay_nhap, $gia_nhap, $ncc_id]);
    }
    public function getProductById($id) {
        $sql = "SELECT * FROM kho_hang WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }    

    public function updateProduct($id, $ten_nl, $so_luong, $ngay_nhap, $gia_nhap, $ncc_id) {
        $sql = "UPDATE kho_hang SET ten_nl = ?, so_luong = ?, ngay_nhap = ?, gia_nhap = ?, ncc_id = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$ten_nl, $so_luong, $ngay_nhap, $gia_nhap, $ncc_id, $id]);
    }

    public function deleteProduct($id) {
        $sql = "DELETE FROM kho_hang WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }
    public function searchProducts($keyword) {
        $stmt = $this->conn->prepare("SELECT * FROM kho_hang WHERE ten_nl LIKE :keyword");
        $stmt->execute(['keyword' => "%$keyword%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getKhoCount() {
        $query = $this->conn->prepare("SELECT * FROM `kho_hang`");
        $query->execute();
        return $query->rowCount();
    }
}
?>
