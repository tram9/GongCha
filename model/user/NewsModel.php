<?php
// model/user/NewsModel.php

class NewsModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }
    public function getPublishedNews($limit = 4) {
        $stmt = $this->conn->prepare("SELECT * FROM `tbl_tintuc` WHERE `trang_thai` = 'Xuất bản' ORDER BY `ngaydang` DESC LIMIT :limit");
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
    
        if ($stmt->rowCount() > 0) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return []; // Trả về mảng rỗng nếu không có tin tức
        }
    }
   
    public function incrementViewCount($id_tintuc) {
        $stmt = $this->conn->prepare("UPDATE tbl_tintuc SET luotxem = luotxem + 1 WHERE id_tintuc = ?");
        $stmt->execute([$id_tintuc]);
    }

    public function getNewsById($id_tintuc) {
        $stmt = $this->conn->prepare("SELECT * FROM `tbl_tintuc` WHERE `id_tintuc` = :id_tintuc");
        $stmt->bindParam(':id_tintuc', $id_tintuc, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>