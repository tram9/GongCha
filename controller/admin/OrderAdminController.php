<?php

/**
* 
*/

class OrderAdminController extends Controller
{
	
	function __construct()
	{
		$this->folder = "admin";
		// if(!isset($admin_id)){
		// 	header("Location: http://localhost/GongCha/view/admin/dashboard.php");

		//  }		 
	}
	function index(){
		require_once 'vendor/Model.php';
		require_once 'model/admin/orderModel.php';
		$md = new orderModel;
        $data['allOrders'] = $md->getOrdersByStatus(null,'online');
        $data['deliveringOrders'] = $md->getOrdersByStatus('đang giao','online');
        $data['shippedOrders'] = $md->getOrdersByStatus('đã giao','online');
		$data['totalOrder']= $md->getTotalRecords('tbl_dathang','online');
		$data['totalDeliver']= $md->getTotalRecords('tbl_dathang','online','Đang giao');
		$data['totalComplete']= $md->getTotalRecords('tbl_dathang','online','Đã giao');
		$this->render('order',$data,"Order",'admin');
	}
    function orderDetail($id_order){
        require_once 'vendor/Model.php';
		require_once 'model/admin/orderModel.php';
		require_once 'model/admin/Payment.php';
		$md = new orderModel;
		$payment = new Payment;
        $data['orderDetail'] = $md->getOrderDetail($id_order); 
        $data['orderCommon'] = $md->getOrdersById($id_order,'online'); 
		$data['payment'] = $payment->getPayment($id_order); 
		require_once 'view/admin/order-detail.php';
    }
	public function action() {
		
		$actionName = isset($_POST['action']) ? $_POST['action'] : '';
		// $orderId = isset($_POST['id']) ? $_POST['id'] : '';
		
		require_once 'vendor/Model.php';
		require_once 'model/admin/orderModel.php';
		$md = new orderModel;
		
		switch ($actionName) {
			case 'search':
				$orderId = isset($_POST['orderId']) ? $_POST['orderId'] : null;
				$customerName = isset($_POST['customerName']) ? $_POST['customerName'] : null;
				$address = isset($_POST['address']) ? $_POST['address'] : null;
				$salesChannel = isset($_POST['salesChannel']) ? $_POST['salesChannel'] : null;
				$startDate = isset($_POST['startDate']) ? $_POST['startDate'] : null;
				$endDate = isset($_POST['endDate']) ? $_POST['endDate'] : null;

				// Kiểm tra ít nhất một điều kiện tìm kiếm được cung cấp
				if ($orderId || $customerName || $address || $salesChannel || $startDate || $endDate) {
					// Gọi hàm tìm kiếm từ model
					$data = $md->searchOrder($orderId, $customerName, $address, $salesChannel, $startDate, $endDate);

					// Trả về dữ liệu dưới dạng JSON
					header('Content-Type: application/json');
					echo json_encode($data);
				} else {
					// Nếu không có tiêu chí tìm kiếm nào, trả về mảng rỗng
					header('Content-Type: application/json');
					echo json_encode(['status' => 'success', 'data' => []]);
				}
				break;
	
			case 'updateStatus':
				$orderId = isset($_POST['orderId']) ? $_POST['orderId'] : null;
				$newStatus = isset($_POST['status']) ? $_POST['status'] : '';
				if ($orderId && ($newStatus == 'Đang giao' || $newStatus == 'Đã giao')) {
					$data = $md->updateStatus($orderId, $newStatus);
					header('Content-Type: application/json');
					echo json_encode(['status' => 'success', 'data' => $data]);
				} else {
					header('HTTP/1.1 400 Bad Request');
					echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
				}
				break;
	
			default:
				header('HTTP/1.1 400 Bad Request');
				echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
				break;
		}
	}
	
    // public function updateStatus() {
    //     $orderId = isset($_POST['id']) ? $_POST['id'] : '';
    //     $newStatus = isset($_POST['status']) ? $_POST['status'] : '';
    
    //     // Kiểm tra giá trị hợp lệ
    //     if ($orderId && ($newStatus == 'Đang giao' || $newStatus == 'Đã giao')) {
    //         require_once 'vendor/Model.php';
    //         require_once 'model/admin/orderModel.php';
    //         $md = new orderModel;
    
    //         // Gọi hàm cập nhật trạng thái trong model
    //         $md->updateStatus($orderId, $newStatus);
    
    //         // Trả về phản hồi JSON
    //         header('Content-Type: application/json');
    //         echo json_encode(['status' => 'success']);
    //     } else {
    //         header('HTTP/1.1 400 Bad Request');
    //         echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
    //     }
    // }
    
    
}

