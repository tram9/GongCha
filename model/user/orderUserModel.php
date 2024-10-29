<?php

class orderUserModel extends Model
{
    function __construct()
    {
        parent::__construct();
    }
    public function getOrdersByStatus($user_id, $status = null, $loai=null) {
        if($loai===null){
			if ($status === null) {
				$sql = "SELECT * FROM tbl_dathang WHERE id_user = ? ORDER BY ngaydat ASC";
				$stmt = $this->conn->prepare($sql);
				$stmt->execute([$user_id]);
			} else {
				$sql = "SELECT * FROM tbl_dathang WHERE id_user = ? AND tinhTrang = ? ORDER BY ngaydat ASC";
				$stmt = $this->conn->prepare($sql);
				$stmt->execute([$user_id, $status]);
			}
		}else{
			if ($status === null) {
				$sql = "SELECT * FROM tbl_dathang WHERE id_user = ? AND loai=? ORDER BY ngaydat ASC";
				$stmt = $this->conn->prepare($sql);
				$stmt->execute([$user_id, $loai]);
			} else {
				$sql = "SELECT * FROM tbl_dathang WHERE id_user = ? AND tinhTrang = ? and loai =? ORDER BY ngaydat ASC";
				$stmt = $this->conn->prepare($sql);
				$stmt->execute([$user_id, $status, $loai]);
			}
		}
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // get info common of orderbyuser : fetch lấy 1 record, 
    public function getOrdersInfoByStatus($user_id, $id_order) {
            $sql = "SELECT * FROM tbl_dathang WHERE id_user = ? AND id_DatHang = ?  ORDER BY ngaydat ASC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$user_id, $id_order]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    function getOrderDetailsByUser($user_id, $id_order) {
        $sql = "SELECT * FROM tbl_dathang dat 
                INNER JOIN tbl_ctdathang ct ON dat.id_DatHang = ct.id_DatHang 
                INNER JOIN menu sp ON ct.id_sanpham = sp.id_sanpham 
                WHERE dat.id_user = ? AND dat.id_DatHang = ? 
                ORDER BY dat.ngaydat ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$user_id, $id_order]);
        $orderDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $orderDetails;
    }
    public function addOrder($user_id, $name, $phone, $address, $city, $totalPrice, $date, $loai, $payment_method, $status, $note) {
        $fullAddress = $address . ', ' . $city; // Kết hợp địa chỉ và thành phố
        $date = date('Y-m-d H:i:s'); // Lấy thời gian hiện tại cho trường ngày đặt
    
        // Chuẩn bị câu lệnh SQL để chèn
        $sql = "INSERT INTO tbl_dathang (id_user, tenKH, sdt, diaChi, tongTien, ngayDat, loai, phuongThuc, tinhTrang, ghiChu) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
        $stmt = $this->conn->prepare($sql);
        $params = [$user_id, $name, $phone, $fullAddress, $totalPrice, $date, $loai, $payment_method, $status, $note];
    
        // Thực thi câu lệnh và kiểm tra kết quả
        if ($stmt->execute($params)) {
            return $this->conn->lastInsertId(); // Trả về ID của đơn hàng vừa được thêm
        } else {
            return false; 
        }
    }
    
    public function addOrderProduct($order_id, $id_sanpham, $quantity, $size, $toppings, $price) {
		$sql = "INSERT INTO tbl_ctdathang (id_DatHang, id_sanpham, soLuong, size, toppings, thanhTien) 
				VALUES (?, ?, ?, ?, ?, ?)";
		$stmt = $this->conn->prepare($sql);
		$params = [$order_id, $id_sanpham, $quantity, $size, $toppings, $price];
		return $stmt->execute($params);
	}
    

	

    


}
