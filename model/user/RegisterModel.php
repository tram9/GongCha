<?php
// model/user/RegisterModel.php

class RegisterModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Kiểm tra số điện thoại đã tồn tại
    public function phoneExists($sdt) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM users WHERE sdt = ?");
        $stmt->execute([$sdt]);
        return $stmt->fetchColumn() > 0; // Trả về true nếu số điện thoại đã tồn tại
    }
    public function usernameExists($username) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetchColumn() > 0; 
    }

    public function addRegister($data) {
        // Kiểm tra nếu số điện thoại đã tồn tại
        if ($this->phoneExists($data['sdt'])) {
            throw new Exception("Số điện thoại đã tồn tại.");
        }
        else if ($this->usernameExists($data['username'])) {
            throw new Exception("Username đã tồn tại.");
        }

        // Chuẩn bị câu lệnh SQL
        $stmt = $this->conn->prepare("INSERT INTO users (username, password, hoten, sdt, diachi) VALUES (?, ?, ?, ?, ?)");
        
        // Thực hiện câu lệnh
        if ($stmt->execute([$data['username'], $data['password'], $data['hoten'], $data['sdt'], $data['diachi']])) {
            return true; // Trả về true nếu thêm thành công
        } else {
            throw new Exception("Không thể thêm người dùng: " . implode(", ", $stmt->errorInfo())); // Thông báo lỗi nếu thêm không thành công
        }
    }
}
?>