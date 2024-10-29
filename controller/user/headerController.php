<?php
require_once 'model/admin/KhachModel.php';
require_once 'model/user/CartModel.php';

class headerController {
    private $KhachModel;
    private $CartModel;

    public function __construct($db) {
        $this->KhachModel = new KhachModel($db);
        $this->CartModel = new CartModel($db);
    }

    public function getHeaderData($user_id) {
        $profile = $this->KhachModel->getProfile($user_id);
        $total_cart_items = $this->CartModel->getCartItemCount($user_id);
        require 'view/user/header.php';
        
    }
}
