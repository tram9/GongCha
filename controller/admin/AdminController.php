<?php
class AdminController extends Controller
{
    function __construct()
	{
		$this->folder = "admin";	 
	}
    public function index()
    {
        $this->render('ThongKe', 'Thống kê', 'admin'); 
    }
    public function thongkengay(){
        require_once 'vendor/Model.php';
        require_once 'model/admin/orderModel.php';
        $orderModel = new orderModel;
    
        $startDate = isset($_GET['startDate']) ? $_GET['startDate'] : null;
        $endDate = isset($_GET['endDate']) ? $_GET['endDate'] : null;
        $type = isset($_GET['type']) ? $_GET['type'] : null; 
    
        if ($startDate && $endDate) {
            $sales_data = $orderModel->thongkengay($startDate, $endDate, $type); 
        } else {
            $sales_data = [];
        }
    
        header('Content-Type: application/json');
        echo json_encode($sales_data);
    }
    
    public function thongkethang(){
        require_once 'vendor/Model.php';
        require_once 'model/admin/orderModel.php';
        $orderModel = new orderModel;
    
        $startDate = isset($_GET['startDate']) ? $_GET['startDate'] : null;
        $endDate = isset($_GET['endDate']) ? $_GET['endDate'] : null;
        $type = isset($_GET['type']) ? $_GET['type'] : null; // Thêm tham số loại
    
        if ($startDate && $endDate) {
            $sales_data = $orderModel->thongkethang($startDate, $endDate, $type);
        } else {
            $sales_data = [];
        }
    
        header('Content-Type: application/json');
        echo json_encode($sales_data);
    }
    
    
    public function viewthongkeSP()
    {
        require_once "./view/admin/ThongKeSanPham.php";
        
    }
    public function thongkeSP()
    {
        require_once 'vendor/Model.php';
        require_once 'model/admin/orderModel.php';
        $orderModel = new orderModel;

        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : null;

        if ($limit) {
            $thongkeSP = $orderModel->getTopProducts($limit);
        } else {
            $thongkeSP = [];
        }

        header('Content-Type: application/json');
        echo json_encode($thongkeSP);
    }
}
