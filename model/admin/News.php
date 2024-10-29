<?php
// model/admin/News.php

class News {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Lấy tất cả tin tức
    public function getAllNews($search = '', $searchBy = 'tieude') {
        $sql = "
            SELECT t.id_tintuc, t.tieude, t.mota, t.anh, t.trang_thai, t.ngaydang, n.tenNV
            FROM tbl_tintuc t
            JOIN nhanvien n ON t.id_nhanvien = n.id_nhanvien
        ";

        // Thêm điều kiện tìm kiếm nếu có
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

    // Lấy danh sách nhân viên
    public function getEmployees() {
        $stmt = $this->conn->prepare("SELECT id_nhanvien, tenNV FROM nhanvien");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addNews($data) {
        $noidung = htmlspecialchars($data['noidung']);
        $stmt = $this->conn->prepare("INSERT INTO tbl_tintuc (tieude, mota, anh, trang_thai, noidung, id_nhanvien) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$data['tieude'], $data['mota'], $data['anh'], $data['trang_thai'], $data['noidung'], $data['id_nhanvien']]);
    }

    // Lấy tin tức theo ID
    public function getNewsById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM tbl_tintuc WHERE id_tintuc = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    private function uploadImage($file) {
        $targetDir = "public/images/tintuc/";  // Thư mục lưu ảnh
        $targetFile = $targetDir . basename($file["name"]);

        // Kiểm tra định dạng file
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $validImageTypes = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($imageFileType, $validImageTypes)) {
            throw new Exception("Chỉ chấp nhận file ảnh (JPG, JPEG, PNG, GIF).");
        }

        // Kiểm tra nếu file đã tồn tại và tạo tên mới nếu cần
        if (file_exists($targetFile)) {
            $fileNameWithoutExt = pathinfo($file["name"], PATHINFO_FILENAME);
            $targetFile = $targetDir . $fileNameWithoutExt . "_" . time() . "." . $imageFileType;
        }

        // Di chuyển file từ vị trí tạm thời đến thư mục đích
        if (move_uploaded_file($file["tmp_name"], $targetFile)) {
            return basename($targetFile);  // Trả về tên file đã lưu
        } else {
            throw new Exception("Lỗi khi upload ảnh.");
        }
    }


    public function editNews($data) {
        $noidung = htmlspecialchars($data['noidung']);
        $stmt = $this->conn->prepare("UPDATE tbl_tintuc SET tieude = ?, mota = ?, anh = ?, trang_thai = ?, noidung = ?, id_nhanvien = ? WHERE id_tintuc = ?");
        $stmt->execute([$data['tieude'], $data['mota'], $data['anh'], $data['trang_thai'], $data['noidung'], $data['id_nhanvien'], $data['id_tintuc']]);
    }

    public function deleteNews($id) {
        $sql = "DELETE FROM tbl_tintuc WHERE id_tintuc = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
    public function getNewsCount() {
        $query = $this->conn->prepare("SELECT * FROM `tbl_tintuc`");
        $query->execute();
        return $query->rowCount();
    }
}
?>