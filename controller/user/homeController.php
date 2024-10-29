<?php

require_once 'config/connect.php';
require_once 'model/admin/menuModel.php';
require_once 'controller/user/headerController.php';


class homeController {
    private $menuModel;
    private $headerController;

    public function __construct($db) {
        $this->menuModel = new menuModel($db);
        $this->headerController = new headerController($db);

    }

    public function displayHome() {

        $userId = $_SESSION['user_id'] ?? '';
        // $fetch_profile = $headerController->getProfile($user_id);
        // $total_cart_items = $headerController->getCartItemCount($user_id);
        $this->headerController->getHeaderData($userId);
        // Gọi view header với dữ liệu cần thiết
        // include 'views/header.php';
        $categories = $this->menuModel->getDanhMucList();
        $products = $this->menuModel->getMenu();
        include 'view/user/home.php';
    }

}

// Khởi tạo HomeController và hiển thị trang
// $controller = new HomeController($conn);
// $controller->displayHome();
?>
