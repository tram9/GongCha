<?php
class vn_payModel extends Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function insertVnpay($data)
    {
    // Lấy dữ liệu từ $data với giá trị mặc định
    $vnp_Amount = (float) ($data['vnp_Amount'] ?? 0.0); // float
    $vnp_BankCode = $data['vnp_BankCode'] ?? '';    
    $vnp_BankTranNo = $data['vnp_BankTranNo'] ?? '';
    $vnp_CardType = $data['vnp_CardType'] ?? '';    // string
    $vnp_OrderInfo = $data['vnp_OrderInfo'] ?? '';  // string
    $vnp_PayDate = $data['vnp_PayDate'] ?? '';      // string (có thể cần convert thành dạng hợp lệ)
    $vnp_TmnCode = $data['vnp_TmnCode'] ?? '';      // string
    $vnp_TransactionNo = $data['vnp_TransactionNo'] ?? ''; // string
    $code_cart = (int) ($data['vnp_TxnRef'] ?? 0);  // Mã đơn hàng (int)

    // Câu lệnh SQL
    $sql = "INSERT INTO tbl_vnpay (vnp_amount, vnp_bankCode, vnp_banktranno, vnp_cardtype, vnp_orderinfo, vnp_paydate, vnp_tmncode, vnp_transactionno, code_cart) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Chuẩn bị truy vấn
    $stmt = $this->conn->prepare($sql);

    // Thực thi câu lệnh với tham số
    if ($stmt->execute([$vnp_Amount, $vnp_BankCode, $vnp_BankTranNo, $vnp_CardType, $vnp_OrderInfo, $vnp_PayDate, $vnp_TmnCode, $vnp_TransactionNo, $code_cart])) {
        return true;
    } else {
        echo "Lỗi: " . $stmt->errorInfo()[2]; 
        return false;
    }
}

}
