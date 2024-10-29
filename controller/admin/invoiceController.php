<?php

/**
* 
*/

class invoiceController extends Controller
{
	
	function __construct()
	{
		$this->folder = "admin";	 
	}
	function index(){
		require_once 'vendor/Model.php';
		require_once 'model/admin/orderModel.php';
		$md = new orderModel;
        $data['allOrders'] = $md->getOrdersByStatus('Đã giao',null);
		$data['totalOrder']= $md->getTotalRecords('tbl_dathang',null,'Đã giao');
		$this->render('invoice',$data,"Invoices",'admin');
	}
	public function action() {
		
		$actionName = isset($_POST['action']) ? $_POST['action'] : '';
		$orderId = isset($_POST['id']) ? $_POST['id'] : '';
		// Yêu cầu model
		require_once 'vendor/Model.php';
		require_once 'model/admin/orderModel.php';
		$md = new orderModel;
	
		switch ($actionName) {
			case 'search':
				// Lấy các tham số tìm kiếm từ POST
				$invoiceId = isset($_POST['invoiceId']) ? $_POST['invoiceId'] : null;
				$customerName = isset($_POST['customerName']) ? $_POST['customerName'] : null;
				$address = isset($_POST['address']) ? $_POST['address'] : null;
				$salesChannel = isset($_POST['salesChannel']) ? $_POST['salesChannel'] : null;
				$startDate = isset($_POST['startDate']) ? $_POST['startDate'] : null;
				$endDate = isset($_POST['endDate']) ? $_POST['endDate'] : null;
	
				// Kiểm tra ít nhất một điều kiện tìm kiếm được cung cấp
				if ($invoiceId || $customerName || $address || $salesChannel || $startDate || $endDate) {
					// Gọi hàm tìm kiếm từ model
					$data = $md->searchInvoices($invoiceId, $customerName, $address, $salesChannel, $startDate, $endDate);
	
					// Trả về dữ liệu dưới dạng JSON
					header('Content-Type: application/json');
					echo json_encode($data);
				} else {
					// Nếu không có tiêu chí tìm kiếm nào, trả về mảng rỗng
					header('Content-Type: application/json');
					echo json_encode(['status' => 'success', 'data' => []]);
				}
				break;
		}
	}
	function invoiceDetail($id_order){
        require_once 'vendor/Model.php';
		require_once 'model/admin/orderModel.php';
		$md = new orderModel;
        $data['invoiceDetail'] = $md->getOrderDetail($id_order); 
        $data['invoiceCommon'] = $md->getOrdersById($id_order); 
		require_once 'view/admin/invoice-detail.php';
    }
	
	
	
    
}

