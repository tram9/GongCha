<?php
class OrderController extends Controller
{
    function __construct()
    {
        $this->folder = "user";
    }
    function index() {
        require_once 'vendor/Model.php';
        require_once 'model/user/orderUserModel.php';
        $md = new orderUserModel;
        // $user_id = $_SESSION['user_id'];
        $user_id = $_SESSION['user_id'] ?? '';
        $data['allOrders'] = $md->getOrdersByStatus($user_id,null,'online');
        $data['deliveringOrders'] = $md->getOrdersByStatus($user_id,'Đang giao','online');
        $data['shippedOrders'] = $md->getOrdersByStatus($user_id, 'Đã giao','online');
        $this->render('order', $data, 'ORDER', 'user'); 
    }
    function orderDetail($id_order){
        require_once 'vendor/Model.php';
		require_once 'model/user/orderUserModel.php';
		require_once 'model/admin/Payment.php';
		$md = new orderUserModel;
		$payment = new Payment;
        $user_id = $_SESSION['user_id'] ?? '';
        $data['orderDetail'] = $md->getOrderDetailsByUser($user_id,$id_order); 
        $data['orderCommon'] = $md->getOrdersInfoByStatus($user_id,$id_order); 
        $data['payment'] = $payment->getPayment($id_order); 
		require_once 'view/user/order-detail.php';
    }
    
}
