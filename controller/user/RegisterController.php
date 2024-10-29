<?php
// controller/user/RegisterController.php

require_once $_SERVER['DOCUMENT_ROOT'] . '/GongCha/config/connect.php'; 
require_once $_SERVER['DOCUMENT_ROOT'] . '/GongCha/model/user/RegisterModel.php'; 
require_once 'controller/user/headerController.php';

class RegisterController {
    private $registerModel;
    private $headerController;

    public function __construct($db) {
        $this->registerModel = new RegisterModel($db);
        $this->headerController = new headerController($db);
    }

    // Thêm tài khoản người dùng
    public function add() {
        $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';
        $this->headerController->getHeaderData($user_id);
        include "view/user/register.php";
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                // Lấy dữ liệu từ form
                $username = $_POST['username'];
                $password = $_POST['password'];
                $hoten = $_POST['hoten'];
                $sdt = $_POST['sdt'];
                $diachi = $_POST['diachi'];

                // Tạo mảng dữ liệu để thêm vào model
                $data = [
                    'username' => $username,
                    'password' => $password,
                    'hoten' => $hoten,
                    'sdt' => $sdt,
                    'diachi' => $diachi,
                ];

                // Thêm dữ liệu vào cơ sở dữ liệu
                $this->registerModel->addRegister($data);
                
                // Chuyển hướng sau khi thêm thành công
                header('Location: view/user/home.php');
                exit();
            } catch (Exception $e) {
                echo "Lỗi: " . $e->getMessage();
            }
        }

        // Hiển thị form nếu không phải là POST
        require_once $_SERVER['DOCUMENT_ROOT'] . '/GongCha/view/user/register.php';
    }
}

// Khởi tạo và gọi phương thức
// $registerController = new RegisterController($conn);
// $registerController->add(); // Gọi phương thức add() để xử lý yêu cầu
?>