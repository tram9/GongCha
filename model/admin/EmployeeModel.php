<?php
require_once 'config/connect.php';
class EmployeeModel {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    public function idExists($id) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM nhanvien WHERE id_nhanvien = ?");
        $stmt->execute([$id]);
        return $stmt->fetchColumn() > 0;
    }

    public function sdtExists($sdt) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM nhanvien WHERE sdt = ?");
        $stmt->execute([$sdt]);
        return $stmt->fetchColumn() > 0;
    }

    public function emailExists($email) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM nhanvien WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetchColumn() > 0;
    }

    public function taikhoanExists($taikhoan) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM nhanvien WHERE taikhoan = ?");
        $stmt->execute([$taikhoan]);
        return $stmt->fetchColumn() > 0;
    }

    public function getAllEmployees() {
        try {
            $sql = "SELECT * FROM nhanvien";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Hiển thị lỗi nếu có vấn đề trong quá trình thực hiện truy vấn
            echo "Lỗi truy vấn cơ sở dữ liệu: " . $e->getMessage();
            return [];
        }
    }
    
    public function addEmployee($id_nhanvien, $tenNV, $email, $sdt,  $ngayvaolam, $luong, $taikhoan, $matkhau, $quyen ) {
        $sql = "INSERT INTO nhanvien (id_nhanvien, tenNV, email, sdt,  ngayvaolam, luong, taikhoan, matkhau, quyen) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id_nhanvien, $tenNV, $email, $sdt,  $ngayvaolam, $luong, $taikhoan, $matkhau, $quyen]);
    }
    public function getEmployeeById($id) {
        $sql = "SELECT * FROM nhanvien WHERE id_nhanvien = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }    

    public function updateEmployee($id_nhanvien, $tenNV, $email, $sdt,  $ngayvaolam, $luong, $taikhoan, $matkhau, $quyen) {
        $sql = "UPDATE nhanvien SET tenNV = ?, email = ?, sdt = ?, ngayvaolam = ?, luong = ?, taikhoan = ?, matkhau =?, quyen = ? WHERE id_nhanvien = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$tenNV, $email, $sdt,  $ngayvaolam, $luong, $taikhoan, $matkhau, $quyen, $id_nhanvien]);
    }

    public function deleteEmployee($id) {
        $sql = "DELETE FROM nhanvien WHERE id_nhanvien = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }
    public function searchEmployeesByName($keyword) {
        $stmt = $this->conn->prepare("SELECT * FROM nhanvien WHERE id_nhanvien LIKE :keyword");
        $stmt->execute(['keyword' => "%$keyword%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function searchEmployeesByDate($startDate, $endDate) {
        $stmt = $this->conn->prepare("SELECT * FROM nhanvien WHERE ngayvaolam BETWEEN :startDate AND :endDate");
        $stmt->execute(['startDate' => $startDate, 'endDate' => $endDate]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getEmployeeCount() {
        $query = $this->conn->prepare("SELECT * FROM `nhanvien` WHERE quyen = 1");
        $query->execute();
        return $query->rowCount();
    }

    public function getAdminCount() {
        $query = $this->conn->prepare("SELECT * FROM `nhanvien` WHERE quyen = 0");
        $query->execute();
        return $query->rowCount();
    }
    public function login($username, $password) {
        $query = "SELECT * FROM `nhanvien` WHERE taikhoan = ? AND matkhau = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$username, $password]);
        return $stmt;
    }
}
?>
