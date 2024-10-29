<?php
require_once 'config/connect.php';
require_once 'model/admin/menuModel.php'; 
require_once 'controller/user/headerController.php';

class CategoryController {
    private $menuModel;    
    private $headerController;


    public function __construct($db) {
        $this->menuModel = new MenuModel($db);        
        $this->headerController = new headerController($db);

    }

    public function display($category) {
        $user_id = $_SESSION['user_id'] ?? '';
        $this->headerController->getHeaderData($user_id);
        $products = $this->menuModel->getProductsByCategory($category);
        include 'views/user/category.php';
    }
}

// Kiểm tra nếu tham số category tồn tại trong URL
// if (isset($_GET['id'])) {
//     $db = $conn; // sử dụng kết nối cơ sở dữ liệu có sẵn
//     $categoryController = new CategoryController($db);
//     $category = $_GET['id'];
//     $categoryController->displayCategoryProducts($category);
// } else {
//     echo "Không có danh mục nào được chọn!";
// }
?>
