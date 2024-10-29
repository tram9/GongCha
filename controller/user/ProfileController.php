<?php
// controller/user/ProfileController.php

require_once $_SERVER['DOCUMENT_ROOT'] . '/GongCha/config/connect.php'; // Đường dẫn tuyệt đối
require_once $_SERVER['DOCUMENT_ROOT'] . '/GongCha/model/user/ProfileModel.php'; // Đường dẫn tuyệt đối
require_once 'controller/user/headerController.php';

class ProfileController {
    private $profileModel;
    private $headerController;

    public function __construct($db) {
        $this->profileModel = new ProfileModel($db);
        $this->headerController = new headerController($db);
    }

    public function update() {
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
            $khachItems = $this->profileModel->getprofile($userId);
            $this->headerController->getHeaderData($userId);
            
            // Chỉ xử lý POST khi có yêu cầu
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                try {
                    // Lấy dữ liệu từ form và kiểm tra
                    $username = $_POST['username'];
                    $password = $_POST['password'];
                    $hoten = $_POST['hoten'];
                    $sdt = $_POST['sdt'];
                    $diachi = $_POST['diachi'];
    
                    // Kiểm tra dữ liệu
                    if (!$username || !$password || !$hoten || !$sdt || !$diachi) {
                        throw new Exception("Tất cả các trường thông tin đều bắt buộc.");
                    }
                    
                    // Lấy ID từ session
                    $id = $_SESSION['user_id'];
    
                    // Tạo mảng dữ liệu để cập nhật
                    $data = [
                        'username' => $username,
                        'password' => $password,
                        'hoten' => $hoten,
                        'sdt' => $sdt,
                        'diachi' => $diachi,
                        'id' => $id,
                    ];
    
                    // Cập nhật dữ liệu vào cơ sở dữ liệu
                    $this->profileModel->updateProfile($data);
                    header('Location: index_home.php?controller=home&action=home'); // Chuyển hướng đến trang chính
                    exit();
                } catch (Exception $e) {
                    echo "Lỗi: " . htmlspecialchars($e->getMessage()); // Hiển thị thông báo lỗi an toàn
                }
            }
    
            // Hiển thị form cập nhật
            include 'view/user/profile.php'; // Đảm bảo bạn bao gồm file này sau khi xử lý POST
        } else {
            header("Location: index_home.php?controller=login&action=logForm");
            exit();
        }
    }
}
?>