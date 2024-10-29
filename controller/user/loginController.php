<?php
require_once 'config/connect.php';
require_once 'model/admin/KhachModel.php';
require_once 'controller/user/headerController.php';


class loginController {
    private $userModel;
    private $headerController;

    public function __construct($db) {
        $this->userModel = new KhachModel($db);
        $this->headerController = new headerController($db);
    }
    public function show(){
        $user_id = $_SESSION['user_id'] ?? '';
        $this->headerController->getHeaderData($user_id);
        include 'view/user/login.php';
    }

    public function login() {
        if (isset($_POST['submit'])) {
            $name = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING);
            $pass = filter_var(trim($_POST['pass']), FILTER_SANITIZE_STRING);
            
            $user = $this->userModel->checkUser($name, $pass);

            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                header('Location: index_home.php?controller=home&action=home');
                exit;
            } else {
                return 'Incorrect username or password!';
            }
        }
        include 'view/admin/login.php'; // Hiển thị lại form đăng nhập kèm theo thông báo lỗi
    }
    public function logout() {
        session_start();
        session_unset();
        session_destroy();
        header("Location: index_home.php?controller=login&action=loginForm"); // Chuyển hướng về trang đăng nhập
        exit();
    }
}
?>
