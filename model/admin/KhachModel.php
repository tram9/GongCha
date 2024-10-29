<?php

class KhachModel{
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getProfile($user_id) {
        $select_profile = $this->conn->prepare("SELECT * FROM `users` WHERE id = ?");
        $select_profile->execute([$user_id]);
        return $select_profile->fetch(PDO::FETCH_ASSOC);
    }

    public function checkUser($username, $password) {
        $stmt = $this->conn->prepare("SELECT * FROM `users` WHERE username = ? AND password = ?");
        $stmt->execute([$username, $password]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Lấy tất cả thong tin khách
    public function getAllKhach($search = '',$searchBy = 'username') {
        $sql = "SELECT * FROM users";

        //Thêm điều kiện tìm kiếm nếu có
        if (!empty($search)) {
            $sql .= " WHERE $searchBy LIKE :search";
        }

        $stmt = $this->conn->prepare($sql);

        // Liên kết tham số tìm kiếm
        if (!empty($search)) {
            $stmt->bindValue(':search', '%' . $search . '%');
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCustomerCount() {
        $query = $this->conn->prepare("SELECT * FROM `users`");
        $query->execute();
        return $query->rowCount();
    }

    

}
?>