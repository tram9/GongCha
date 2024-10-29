<?php

require_once 'config/connect.php'; 
require_once 'model/admin/menuModel.php';
require_once 'controller/user/headerController.php';


// session_start();

class menuController {
    private $menuModel;    
    private $headerController;


    public function __construct($db) {
        $this->menuModel = new menuModel($db);
        $this->headerController = new headerController($db);
    }

    public function showMenu() {
        $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';
        $this->headerController->getHeaderData($user_id);
        $products = $this->menuModel->getAllMenu();
        include 'view/user/menu.php'; // Bao gồm view và truyền dữ liệu vào
    }

    public function view($id) {
        $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';
        $this->headerController->getHeaderData($user_id);
        $product = $this->menuModel->getMenuById($id);
        $toppings = $this->menuModel->getToppings();
        include 'view/user/menu_detail.php'; // Bao gồm view và truyền dữ liệu vào
    }

}

?>