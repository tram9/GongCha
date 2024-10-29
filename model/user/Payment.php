<?php 
class Payment extends Model
{
    function __construct()
    {
        parent::__construct();
    }
    public function insert_payment($id_order, $id_taikhoan, $method_payment, $today)
    {
        // Câu lệnh SQL để chèn thông tin thanh toán
        $sql = "INSERT INTO tbl_payment (id_order, id_taikhoan, thanhtoan, order_date, status) 
                VALUES (?, ?, ?, ?, '0')";
        
        // Chuẩn bị câu lệnh SQL
        $stmt = $this->conn->prepare($sql);
        
        // Tạo mảng chứa các tham số
        $params = [$id_order, $id_taikhoan, $method_payment, $today];
        
        // Thực thi câu lệnh và trả về kết quả
        return $stmt->execute($params);
    }

    public function update_payment_status($orderId)
    {
        $query = "UPDATE tbl_payment SET status = '1' WHERE id_order = ?";
        
        $stmt = $this->conn->prepare($query);
        
        return $stmt->execute([$orderId]);
    }

    public function getPayment($orderId)
    {
        // Câu lệnh SQL để lấy thông tin thanh toán
        $query = "SELECT * FROM tbl_payment WHERE id_order = ?";
        
        // Chuẩn bị câu lệnh SQL
        $stmt = $this->conn->prepare($query);
        
        // Thực thi câu lệnh với ID đơn hàng
        $stmt->execute([$orderId]);
        
        // Lấy kết quả
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Trả về kết quả hoặc null nếu không có kết quả
        return $result ? $result : null;
    }
}