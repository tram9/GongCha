<?php
// Import các model cần thiết
include_once 'model/admin/orderModel.php';
require_once 'model/admin/EmployeeModel.php';
require_once 'model/admin/menuModel.php';
include_once 'model/admin/News.php';
include_once 'model/admin/KhachModel.php';
require_once 'model/admin/KhoHangModel.php';
require_once 'controller/admin/HeaderController.php';

class dashboardController {
    private $db;
    private $orderModel;
    private $employeeModel;
    private $menuModel;
    private $newsModel;
    private $KhachModel;
    private $KhoHangModel;
    private $headerController;

    public function __construct($db) {
        // Kết nối cơ sở dữ liệu
        $this->db = $db;

        // Khởi tạo các model
        $this->orderModel = new orderModel($db);
        $this->employeeModel = new EmployeeModel($db);
        $this->menuModel = new menuModel($db);
        $this->newsModel = new News($db);
        $this->KhachModel = new KhachModel($db);
        $this->KhoHangModel = new KhoHangModel($db);
        $this->headerController = new HeaderController($db);
    }

    // Hàm quản lý dashboard
    public function dashboard() {
        // Bắt đầu session và kiểm tra quyền admin
        // session_start();
        $admin_id = $_SESSION['id_nhanvien'];
        
        if (!isset($admin_id)) {
            header('location:index.php?controller=Login&action=loginForm');
            exit;
        }
        $this->headerController->displayHeader($admin_id);

        // Lấy tên admin từ session (hoặc model nếu cần)
        $admin_name = $_SESSION['tenNV'];

        // Lấy tổng giá trị đơn hàng đang giao
        $total_pendings = 0;
        $pendings = $this->orderModel->getOrdersByStatus('Đang giao', null);
        foreach ($pendings as $pending) {
            $total_pendings += $pending['tongTien'];
        }

        // Lấy tổng giá trị đơn hàng đã giao
        $total_completes = 0;
        $completes = $this->orderModel->getOrdersByStatus('Đã giao', null);
        foreach ($completes as $complete) {
            $total_completes += $complete['tongTien'];
        }
        
        $total_invoice = $this->orderModel ->getTotalRecords('tbl_dathang',null,'Đã giao');
        // Lấy tổng số đơn hàng
        $order_count = $this->orderModel->getTotalRecords('tbl_dathang',null,null);

        // Lấy số lượng nhân viên và quản lý
        $employee_count = $this->employeeModel->getEmployeeCount();
        $admin_count = $this->employeeModel->getAdminCount();

        // Lấy số lượng tin tức
        $numbers_of_news = $this->newsModel->getNewsCount();

        // Lấy số lượng sản phẩm trong thực đơn
        $numbers_of_products = $this->menuModel->getMenuCount();

        // Lấy số lượng mặt hàng trong kho
        $numbers_of_messages = $this->KhoHangModel->getKhoCount();

        // Lấy số lượng khách hàng (hoặc đơn hàng)
        $numbers_of_customers = $this->KhachModel->getCustomerCount();

        // Truyền dữ liệu xuống view
        include 'view/admin/dashboard.php';
    }
}
?>