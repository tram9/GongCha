<?php
// controller/admin/KhachController.php

require_once $_SERVER['DOCUMENT_ROOT'] . '/GongCha/config/connect.php'; // Đường dẫn tuyệt đối
require_once $_SERVER['DOCUMENT_ROOT'] . '/GongCha/model/admin/KhachModel.php'; // Cũng sử dụng đường dẫn tuyệt đối
require_once 'controller/admin/HeaderController.php';


class KhachController {
    private $KhachModel;
    private $headerController;

    public function __construct($db) {
        $this->KhachModel = new KhachModel($db);
        $this->headerController = new HeaderController($db);

    }

    // Hiển thị danh sách tin tức
    public function khach() {
        $admin_id = $_SESSION['id_nhanvien'];
        $this->headerController->displayHeader($admin_id);
        $search = isset($_GET['search']) ? $_GET['search'] : ''; // Lấy giá trị tìm kiếm
        $searchBy = isset($_GET['searchBy']) ? $_GET['searchBy'] : 'id';
        $khach = $this->KhachModel->getAllKhach($search); // Lấy dữ liệu tin tức
        require_once $_SERVER['DOCUMENT_ROOT'] . '/GongCha/view/admin/khachhang.php'; // Gọi view
    }

}
?>
