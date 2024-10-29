<?php
require_once 'config/connect.php';
require_once 'model/admin/EmployeeModel.php';
class LoginController {

    private $model;

    public function __construct($conn) {
        $this->model = new EmployeeModel($conn);
    }

    public function showLoginForm() {
        // Hiển thị trang đăng nhập
        include 'view/admin/login.php';
    }

    public function login() {
        // session_start();
    
        if (isset($_POST['submit'])) {
            $name = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING);
            $pass = filter_var(trim($_POST['pass']), FILTER_SANITIZE_STRING);
            
            $select_admin = $this->model->login($name, $pass);
    
            if ($select_admin->rowCount() > 0) {
                $fetch_admin_id = $select_admin->fetch(PDO::FETCH_ASSOC);
                $_SESSION['id_nhanvien'] = $fetch_admin_id['id_nhanvien'];
                $_SESSION['tenNV'] = $fetch_admin_id['tenNV'];
                header('Location: index.php?controller=dashboard&action=dashboard');
                exit;
            } else {
                // Lưu thông báo lỗi vào biến message
                $message[] = 'Tên đăng nhập hoặc mật khẩu không đúng!';
            }
        }
    
        include 'view/admin/login.php'; // Hiển thị lại form đăng nhập kèm theo thông báo lỗi
    }
    
    public function checkLogin($admin_id) {
        if (!$admin_id) {
            // Chưa đăng nhập, chuyển hướng đến trang đăng nhập
            header("Location: index.php?controller=Login&action=loginForm");
            exit();
        } else {
            // Đã đăng nhập, lấy thông tin người dùng
            $select_profile = $this->conn->prepare("SELECT * FROM `nhanvien` WHERE id_nhanvien = ?");
            $select_profile->execute([$admin_id]);
            if ($select_profile->rowCount() > 0) {
                return $select_profile->fetch(PDO::FETCH_ASSOC);
            }
            return null;
        }
    }

    // Phương thức logout
    public function logout() {
        session_start();
        session_unset();
        session_destroy();
        header("Location: index.php?controller=Login&action=loginForm"); // Chuyển hướng về trang đăng nhập
        exit();
    }
}
?>