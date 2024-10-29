<?php
require_once 'model/admin/menuModel.php';
require_once 'controller/admin/HeaderController.php';


class SaleController {
    private $menuModel;
    private $headerController;


    public function __construct($db) {
        $this->menuModel = new menuModel($db);
        $this->headerController = new HeaderController($db);

    }

    public function saleForm() {
        $admin_id = $_SESSION['id_nhanvien'] ?? '';
        // $this->headerController->displayHeader($admin_id);
        $drinks = $this->menuModel->getMenuDrinks();
        $toppings = $this->menuModel->getToppings();
        include 'view/admin/sale.php'; // Gọi view
    }

}
?>
