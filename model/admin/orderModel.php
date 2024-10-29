<?php

class orderModel extends Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	public function getOrdersByStatus($status = null,  $loai=null) {
		if($loai===null){
			if ($status === null) {
				$sql = "SELECT * FROM tbl_dathang ORDER BY ngaydat ASC";
				$stmt = $this->conn->prepare($sql);
				$stmt->execute();
			} else {
				$sql = "SELECT * FROM tbl_dathang WHERE tinhTrang = ? ORDER BY ngaydat ASC";
				$stmt = $this->conn->prepare($sql);
				$stmt->execute([$status]);
			}
		}else{
			if ($status === null) {
				$sql = "SELECT * FROM tbl_dathang WHERE loai =? ORDER BY ngaydat ASC";
				$stmt = $this->conn->prepare($sql);
				$stmt->execute([$loai]);
			} else {
				$sql = "SELECT * FROM tbl_dathang WHERE tinhTrang = ? and loai =? ORDER BY ngaydat ASC";
				$stmt = $this->conn->prepare($sql);
				$stmt->execute([$status,$loai]);
			}
		}
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
	public function getOrdersById($id_order, $loai=null) {
		if($loai===null){
			$sql = "SELECT * FROM tbl_dathang WHERE id_DatHang = ? ORDER BY ngaydat ASC";
			$stmt = $this->conn->prepare($sql);
			$stmt->execute([$id_order]);
		}else{
			$sql = "SELECT * FROM tbl_dathang WHERE id_DatHang = ?  and loai =? ORDER BY ngaydat ASC";
			$stmt = $this->conn->prepare($sql);
			$stmt->execute([$id_order, $loai]);
		}
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}
	function getOrderDetail($id_order) {
		$sql = "SELECT * FROM tbl_dathang dat 
				INNER JOIN tbl_ctdathang ct ON dat.id_DatHang = ct.id_DatHang 
				INNER JOIN menu sp ON ct.id_sanpham = sp.id_sanpham 
				WHERE dat.id_DatHang = ? 
				ORDER BY dat.ngaydat ASC";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute([$id_order]);
		$orderDetails = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $orderDetails;
	}
	function updateStatus($id_order, $status){
		$stmt = $this->conn->prepare("UPDATE tbl_dathang SET tinhTrang = ? WHERE id_DatHang = ?");
        $stmt->execute([$status, $id_order]);
		return $stmt;
	}
    // Hàm tìm kiếm thông tin theo loại
    public function searchOrder($orderId = null, $customerName = null, $address = null, $salesChannel = null, $startDate= null, $endDate= null, $status=null) {
		// Bắt đầu câu truy vấn
		$query = "SELECT * FROM tbl_dathang WHERE loai = 'online'";
		$params = []; // Mảng để chứa các tham số cho câu lệnh chuẩn bị
	
		// Kiểm tra điều kiện tìm kiếm cho mã hóa đơn
		if ($orderId) {
			$query .= " AND id_DatHang = ?";
			$params[] = $orderId; 
		}
	
		// Kiểm tra điều kiện tìm kiếm cho tên khách hàng
		if ($customerName) {
			$query .= " AND tenKH LIKE ?";
			$params[] = '%' . $customerName . '%'; 
		}
	
		// Kiểm tra điều kiện tìm kiếm cho địa chỉ
		if ($address) {
			$query .= " AND diaChi LIKE ?";
			$params[] = '%' . $address . '%'; 
		}
	
		// Kiểm tra điều kiện tìm kiếm cho kênh bán
		if ($salesChannel) {
			$query .= " AND tinhTrang = ?"; 
			$params[] = $salesChannel; 
		}
		if ($startDate) {
			$startDate .= ' 00:00:00';
			$query .= " AND ngayDat >= ?";
			$params[] = $startDate;
		}
	
		// Kiểm tra và điều chỉnh ngày kết thúc
		if ($endDate) {
			$endDate .= ' 23:59:59';
			$query .= " AND ngayDat <= ?";
			$params[] = $endDate;
		}
		// Chuẩn bị câu lệnh SQL
		$stmt = $this->conn->prepare($query);
		
		// Thực thi câu lệnh với các tham số đã chuẩn bị
		$stmt->execute($params);
	
		// Trả về kết quả dưới dạng mảng các bản ghi
		return $stmt->fetchAll(PDO::FETCH_ASSOC);   
	}
	
	public function searchInvoices($invoiceId = null, $customerName = null, $address = null, $salesChannel = null, $startDate= null, $endDate= null, $status=null) {
		// Bắt đầu câu truy vấn
		$query = "SELECT * FROM tbl_dathang WHERE tinhTrang = 'Đã giao'";
		$params = []; // Mảng để chứa các tham số cho câu lệnh chuẩn bị
	
		// Kiểm tra điều kiện tìm kiếm cho mã hóa đơn
		if ($invoiceId) {
			$query .= " AND id_DatHang = ?";
			$params[] = $invoiceId; // Thêm vào mảng tham số
		}
	
		// Kiểm tra điều kiện tìm kiếm cho tên khách hàng
		if ($customerName) {
			$query .= " AND tenKH LIKE ?";
			$params[] = '%' . $customerName . '%'; // Thêm vào mảng tham số
		}
	
		// Kiểm tra điều kiện tìm kiếm cho địa chỉ
		if ($address) {
			$query .= " AND diaChi LIKE ?";
			$params[] = '%' . $address . '%'; // Thêm vào mảng tham số
		}
	
		// Kiểm tra điều kiện tìm kiếm cho kênh bán
		if ($salesChannel) {
			$query .= " AND loai = ?"; 
			$params[] = $salesChannel; // Thêm vào mảng tham số
		}
		if ($startDate) {
			$startDate .= ' 00:00:00';
			$query .= " AND ngayDat >= ?";
			$params[] = $startDate;
		}
	
		// Kiểm tra và điều chỉnh ngày kết thúc
		if ($endDate) {
			$endDate .= ' 23:59:59';
			$query .= " AND ngayDat <= ?";
			$params[] = $endDate;
		}
		// Chuẩn bị câu lệnh SQL
		$stmt = $this->conn->prepare($query);
		
		// Thực thi câu lệnh với các tham số đã chuẩn bị
		$stmt->execute($params);
	
		// Trả về kết quả dưới dạng mảng các bản ghi
		return $stmt->fetchAll(PDO::FETCH_ASSOC);   
	}
	public function getTotalRecords($table, $loai=null, $status=null) {
		if($loai===null){
			if ($status === null) {
				$sql = "SELECT COUNT(*) AS total_records FROM $table";
				$stmt = $this->conn->prepare($sql);
				$stmt->execute();
			} else {
				$sql = "SELECT COUNT(*) AS total_records FROM $table WHERE tinhTrang =?";
				$stmt = $this->conn->prepare($sql);
				$stmt->execute([$status]);
			}
		}else{
			if ($status === null) {
				$sql = "SELECT COUNT(*) AS total_records FROM $table WHERE loai=?";
				$stmt = $this->conn->prepare($sql);
				$stmt->execute([$loai]);
			} else {
				$sql = "SELECT COUNT(*) AS total_records FROM $table WHERE loai=? and tinhTrang =?";
				$stmt = $this->conn->prepare($sql);
				$stmt->execute([$loai,$status]);
			}
		}
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
		return $result['total_records'];
    }

	public function thongkengay($startDate, $endDate, $salesType=null) {
		// Thêm thời gian bắt đầu và kết thúc cho khoảng thời gian
		$startDate .= " 00:00:00";
		$endDate .= " 23:59:59";
		if($salesType ==null){
			// Truy vấn dữ liệu theo khoảng thời gian và loại doanh thu
			$sql = "SELECT DATE(ngayDat) AS day, SUM(tongTien) AS total_sales
					FROM tbl_dathang
					WHERE tinhTrang = 'Đã giao'
					AND ngayDat >= ? AND ngayDat <= ?
					GROUP BY day
                    ORDER BY day";
			
			// Chuẩn bị câu lệnh và thực thi
			$stmt = $this->conn->prepare($sql);
			$stmt->execute([$startDate, $endDate]);
		}else{
			$sql = "SELECT DATE(ngayDat) as day, SUM(tongTien) AS total_sales
					FROM tbl_dathang
					WHERE tinhTrang = 'Đã giao'
					AND loai = ?
					AND ngayDat >= ? AND ngayDat <= ? 
					GROUP BY day
                    ORDER BY day";
			
			// Chuẩn bị câu lệnh và thực thi
			$stmt = $this->conn->prepare($sql);
			$stmt->execute([$salesType, $startDate, $endDate]);
		}
		// Lấy kết quả
		$sales_data = [];
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$sales_data[] = [
				"date" => $row['day'],
				"units" => $row['total_sales']
			];
		}
		return $sales_data;
	}
	
	public function thongkethang($startDate, $endDate, $salesType=null){
		$startDate .= " 00:00:00";
		$endDate .= " 23:59:59";
		if($salesType==null){
			// Truy vấn dữ liệu theo khoảng thời gian
			$sql = "SELECT DATE_FORMAT(ngayDat, '%Y-%m') AS month, SUM(tongTien) AS total_sales 
					FROM tbl_dathang 
					WHERE tinhTrang = 'Đã giao' 
					AND ngayDat >= ? AND ngayDat <= ?
					GROUP BY month 
					ORDER BY month";
			// Chuẩn bị câu lệnh và thực thi
			$stmt = $this->conn->prepare($sql);
			$stmt->execute([$startDate, $endDate]);
		}else{
			$sql = "SELECT DATE_FORMAT(ngayDat, '%Y-%m') AS month, SUM(tongTien) AS total_sales 
				FROM tbl_dathang 
				WHERE tinhTrang = 'Đã giao' 
				AND loai=?
				AND ngayDat >= ? AND ngayDat <= ?
				GROUP BY month 
				ORDER BY month";
			// Chuẩn bị câu lệnh và thực thi
			$stmt = $this->conn->prepare($sql);
			$stmt->execute([$salesType, $startDate, $endDate]);
		}
		// Lấy kết quả
		$sales_data = [];
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$sales_data[] = [
				"date" => $row['month'],
				"units" => $row['total_sales']
			];
		}

		return $sales_data;
	}
	public function getTopProducts($limit){
		$sql = "SELECT p.tenSP, SUM(ct.quantity) as total_quantity 
				FROM menu p 
				JOIN tbl_ctdathang ct ON p.id_sanpham = ct.product_id 
				GROUP BY p.id_sanpham 
				ORDER BY total_quantity DESC 
				LIMIT ?";

		$stmt = $this->conn->prepare($sql);
		$stmt->execute([$limit]);

		$data = [];
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$data[] = [
				'label' => $row['tenSP'],
				'y' => (int) $row['total_quantity']
			];
		}

		return $data;
	}
	function doanhthu(){
		$sql = "SELECT SUM(total_price) AS total_revenue FROM tbl_dathang WHERE tinhTrang = 'Đã giao'";
		// Chuẩn bị câu lệnh
		$stmt = $this->con->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		return $result ? $result : null;
	}


	function getAllOrder($loai){
		$stmt = $this->conn->prepare("SELECT * from tbl_dathang dh INNER JOIN tbl_ctdathang ct ON dh.id_DatHang=ct.id_DatHang WHERE dh.loai =?");
		$stmt->execute([$loai]);
		return $stmt;
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
    
    public function addOrderProduct($id_DatHang, $id_sanpham, $soLuong, $size, $toppings, $thanhTien) {
		$sql = "INSERT INTO tbl_ctdathang (id_DatHang, id_sanpham, soLuong, size, toppings, thanhTien) 
				VALUES (?, ?, ?, ?, ?, ?)";
		
		$stmt = $this->conn->prepare($sql);
		$params = [$id_DatHang, $id_sanpham, $soLuong, $size, $toppings, $thanhTien];
	
		if ($stmt->execute($params)) {
			return true; 
		} else {
			return false; 
		}
	}
	public function addPayment($orderId, $user_id, $payment_method,$order_date, $status) {
		// Chuẩn bị câu lệnh SQL để chèn thông tin thanh toán
		$sql = "INSERT INTO tbl_payment (id_order, id_taikhoan, thanhtoan, order_date, status) 
				VALUES (?, ?, ?, ?, ?)";
		
		$stmt = $this->conn->prepare($sql);
		$params = [$orderId, $user_id, $payment_method, $order_date, $status];
	
		// Thực thi câu lệnh và kiểm tra kết quả
		if ($stmt->execute($params)) {
			return true; // Thêm thành công
		} else {
			return false; // Thêm không thành công
		}
	}
	public function KiemTraMa($id_order){
		$sql = "SELECT * FROM tbl_dathang WHERE id_DatHang = ?";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute([$id_order]);

		if ($stmt->rowCount() > 0) {
			return true; 
		} else {
			return false; 
		}
	}
	public function deleteOrder($id_order) {
		$this->deletePaymentById($id_order);
		$stmt = $this->conn->prepare("DELETE FROM tbl_dathang WHERE id_DatHang = ?");
		return $stmt->execute([$id_order]);
	}
	public function deletePaymentById($id_order) {
		$stmt = $this->conn->prepare("DELETE FROM tbl_payment WHERE id_order = ?");
		$stmt->execute([$id_order]);
		 // Trả về kết quả của câu lệnh xóa
		return $stmt;
	}

}