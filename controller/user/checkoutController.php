<?php
class checkoutController extends Controller
{
    function __construct()
    {
        $this->folder = "user";
    }
    function index() {
        require_once 'vendor/Model.php';
        require_once 'model/user/CartModel.php';
        $md = new CartModel;
        $user_id = $_SESSION['user_id'] ?? '';
        $data['allCart'] = $md->getCart($user_id);
        $this->render('checkout', $data, 'Checkout', 'user'); 

    }
    public function postCheckout() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user_id = $_SESSION['user_id'] ?? '';
        //    $user_id = $_SESSION['user_id'];
           $name = $_POST['name'];
           $phone = $_POST['phone'];
           $city = $_POST['city'];
           $address = $_POST['address'];
           $note = $_POST['note'];
           $totalPrice = $_POST['total'];
           date_default_timezone_set('Asia/Ho_Chi_Minh');
           $date= date('Y-m-d H:i:s');
           $payment_method = $_POST['payment']; // lấy phương thức thanh toán
           $status = 'Đang giao';
           $loai='online';

           // Khởi tạo model
           require_once 'vendor/Model.php';
           require_once 'model/user/orderUserModel.php';
           require_once 'model/user/CartModel.php';
           $cartModel = new CartModel();
           $orderUserModel = new orderUserModel();

           // Thực hiện thêm đơn hàng vào cơ sở dữ liệu
           if ($order = $orderUserModel->addOrder($user_id, $name, $phone, $address, $city, $totalPrice, $date, $loai, $payment_method, $status, $note)) {
                $carts = $cartModel->getCart($user_id);
                $orderId = $order;
                foreach ($carts as $item) {
                   // Thêm sản phẩm vào đơn hàng
                   $result = $orderUserModel->addOrderProduct(
                    $orderId,                   
                    $item['product_id'],       
                    $item['quantity'],          
                    $item['size'],              
                    $item['toppings'],          
                    $item['price']              
                );
                // xóa cart
                $deleteCarts= $cartModel->deleteFromCart($item['id']); // cart_id
               }
           require_once 'controller/user/PaymentController.php';
            $payment = new PaymentController();
                $payment->vnpay_payment($orderId, $name, $totalPrice, $payment_method);
           }
       }
    }
    public function checkoutSuccess($orderId)
    {
        // var_dump($_GET['vnp_SecureHash']);
        if (isset($_GET['vnp_SecureHash'])) {
            $vnp_Amount = $_GET['vnp_Amount'] ?? '';
            $vnp_BankCode = $_GET['vnp_BankCode'] ?? '';
            $vnp_BankTranNo = $_GET['vnp_BankTranNo'] ?? '';
            $vnp_CardType = $_GET['vnp_CardType'] ?? '';
            $vnp_OrderInfo = $_GET['vnp_OrderInfo'] ?? '';
            $vnp_PayDate = $_GET['vnp_PayDate'] ?? '';
            $vnp_ResponseCode = $_GET['vnp_ResponseCode'] ?? '';
            $vnp_TmnCode = $_GET['vnp_TmnCode'] ?? '';
            $vnp_TransactionNo = $_GET['vnp_TransactionNo'] ?? '';
            $vnp_TransactionStatus = $_GET['vnp_TransactionStatus'] ?? '';
            $vnp_TxnRef = $_GET['vnp_TxnRef'] ?? '';
            $vnp_SecureHash = $_GET['vnp_SecureHash'] ?? '';

            $vnp_HashSecret = "XQ715JX17ERO040AQV9OLC23NW7DHKF1";

            $inputData = array();
            foreach ($_GET as $key => $value) {
                if (substr($key, 0, 4) == "vnp_") {
                    $inputData[$key] = $value;
                }
            }
            unset($inputData['vnp_SecureHash']);
            ksort($inputData);
            $i = 0;
            $hashData = "";
            foreach ($inputData as $key => $value) {
                if ($i == 1) {
                    $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
                } else {
                    $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                    $i = 1;
                }
            }
            $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

            if ($secureHash === $vnp_SecureHash) {
                if ($vnp_ResponseCode == '00') {
                    try {
                        require_once 'vendor/Model.php';
                        require_once 'model/admin/Payment.php';
                        $payment = new Payment();
                        $updatePayment = $payment->update_payment_status($orderId);

                        require_once 'model/admin/vn_payModel.php';
                        $vnpay = new vn_payModel();
                        $insertVnpay = $vnpay->insertVnpay([
                            'vnp_Amount' => $vnp_Amount,
                            'vnp_BankCode' => $vnp_BankCode,
                            'vnp_BankTranNo' => $vnp_BankTranNo,
                            'vnp_CardType' => $vnp_CardType,
                            'vnp_OrderInfo' => $vnp_OrderInfo,
                            'vnp_PayDate' => $vnp_PayDate,
                            'vnp_TmnCode' => $vnp_TmnCode,
                            'vnp_TransactionNo' => $vnp_TransactionNo,
                            'vnp_TxnRef' => $vnp_TxnRef
                        ]);

                        if ($updatePayment && $insertVnpay) {
                            $this->render('success', ['orderId' => $orderId], 'Success', 'user'); 
                        }
                    } catch (Exception $e) {
                        echo "Lỗi xử lý giao dịch: " . $e->getMessage();
                    }
                } else {
                    echo "Giao dịch thất bại. Mã lỗi: " . $vnp_ResponseCode;
                }
            } else {
                echo "Giao dịch không hợp lệ.";
            }
        } else {
            echo "Không có tham số hợp lệ từ VNPay.";
        }

        $this->render('success', ['orderId' => $orderId], 'Success', 'user'); 
        // $this->view("Customer/success", [
        //     "orderId" => $orderId,
        // ]);
    }
   
}
