<?php
// model/user/ProfileModel.php

class ProfileModel {
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

    public function getprofile($userId) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = :user_id");
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateProfile($data) {
        $currentUserProfile = $this->getProfile($data['id']); 

        if ($this->phoneExists($data['sdt']) && $currentUserProfile['sdt'] !== $data['sdt']) {
            throw new Exception("Số điện thoại đã tồn tại.");
        }
        else if ($this->usernameExists($data['username']) && $currentUserProfile['username'] !== $data['username']) {
            throw new Exception("Tên người dùng đã tồn tại.");
        }
        $stmt = $this->conn->prepare("UPDATE users SET username = ?, password = ?, hoten = ?, sdt = ?, diachi = ? WHERE id = ?");
        if ($stmt->execute([$data['username'], $data['password'], $data['hoten'], $data['sdt'], $data['diachi'], $data['id']])) {
            return true; // Trả về true nếu cập nhật thành công
        } else {
            throw new Exception("Không thể cập nhật người dùng: " . implode(", ", $stmt->errorInfo())); // Thông báo lỗi nếu không thành công
        }
    }
}
?>