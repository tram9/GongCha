<?php
require_once 'config/connect.php';

class menuModel {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    public function getMenu($limit = 3) {
        $stmt = $this->conn->prepare("SELECT * FROM `menu` LIMIT :limit");
        $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDanhMucList() {
        $query = "SELECT id_danhmuc, tenLoai FROM danhmuc"; // Chọn các cột cụ thể nếu cần
        $stmt = $this->conn->prepare($query);
        
        try {
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Xử lý lỗi, có thể ghi log hoặc thông báo cho người dùng
            echo "Lỗi truy vấn: " . $e->getMessage();
            return []; // Trả về mảng rỗng trong trường hợp có lỗi
        }
    }
    

    public function getAllMenu() {
        try {
            $sql = "SELECT 
                menu.id_sanpham,
                menu.id_danhmuc,
                danhmuc.tenLoai AS danhmuc,
                menu.tenSP,
                menu.hinh_anh,
                menu.congthuc,
                menu.gia_S,
                menu.gia_M,
                menu.gia_L
            FROM 
                menu
            JOIN 
                danhmuc ON menu.id_danhmuc = danhmuc.id_danhmuc";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Lỗi truy vấn cơ sở dữ liệu: " . $e->getMessage();
            return [];
        }
    }

    public function addMenu($id_sanpham, $id_danhmuc, $tenSP, $hinh_anh, $congthuc, $gia_S, $gia_M, $gia_L) {
        $sql = "INSERT INTO menu (id_sanpham, id_danhmuc, tenSP, hinh_anh, congthuc, gia_S, gia_M, gia_L) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id_sanpham, $id_danhmuc, $tenSP, $hinh_anh, $congthuc, $gia_S, $gia_M, $gia_L]);
    }

    public function getMenuById($id_sanpham) {
        $sql = "SELECT * FROM menu WHERE id_sanpham = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id_sanpham]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateMenu($id_sanpham, $id_danhmuc, $tenSP, $hinh_anh, $congthuc, $gia_S, $gia_M, $gia_L) {
        $sql = "UPDATE menu SET id_danhmuc = ?, tenSP = ?, hinh_anh = ?, congthuc = ?, gia_S = ?, gia_M = ?, gia_L = ? WHERE id_sanpham = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id_danhmuc, $tenSP, $hinh_anh, $congthuc, $gia_S, $gia_M, $gia_L, $id_sanpham]);
    }

    public function deleteMenu($id_sanpham) {
        $sql = "DELETE FROM menu WHERE id_sanpham = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id_sanpham]);
    }

    public function searchMenuByName($keyword) {
        $stmt = $this->conn->prepare("SELECT 
                menu.id_sanpham,
                menu.id_danhmuc,
                danhmuc.tenLoai AS danhmuc,
                menu.tenSP,
                menu.hinh_anh,
                menu.congthuc,
                menu.gia_S,
                menu.gia_M,
                menu.gia_L 
            FROM menu JOIN danhmuc ON menu.id_danhmuc = danhmuc.id_danhmuc WHERE tenSP LIKE :keyword");
        $stmt->execute(['keyword' => "%$keyword%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function searchMenuByCategory($keyword) {
        $stmt = $this->conn->prepare("SELECT 
                menu.id_sanpham,
                menu.id_danhmuc,
                danhmuc.tenLoai AS danhmuc,
                menu.tenSP,
                menu.hinh_anh,
                menu.congthuc,
                menu.gia_S,
                menu.gia_M,
                menu.gia_L 
            FROM menu JOIN danhmuc ON menu.id_danhmuc = danhmuc.id_danhmuc WHERE menu.id_danhmuc LIKE :keyword");
        $stmt->execute(['keyword' => "%$keyword%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getMenuCount() {
        $query = $this->conn->prepare("SELECT * FROM `menu` ");
        $query->execute();
        return $query->rowCount();
    }
    public function getMenuDrinks() {
        $query = $this->conn->prepare("SELECT id_sanpham, tenSP, hinh_anh, gia_S, gia_M, gia_L FROM menu WHERE id_danhmuc != 'lsp10'");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getToppings() {
        $query = $this->conn->prepare("SELECT id_sanpham, tenSP, hinh_anh, gia_M FROM menu WHERE id_danhmuc = 'lsp10'");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getProductsByCategory($category) {
        $stmt = $this->conn->prepare("SELECT * FROM `menu` WHERE id_danhmuc = ?");
        $stmt->execute([$category]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
