<?php
class orderApiController extends Controller
{
    function index(){
		echo 'apiorder';
	}
    function get_order($id_order = null) {
        require_once 'vendor/Model.php';
        $order_Model = $this->model("orderModel");
        $mang = [];
        // Nếu không có ID đơn hàng, lấy tất cả đơn hàng
        if (empty($id_order)) {
            $orders = $order_Model->getAllOrder('online');
            $donHangMap = [];
            foreach ($orders as $s) {
                if (!isset($donHangMap[$s["id_DatHang"]])) {
                    // Tạo mới đối tượng đơn hàng
                    $donHang = new donhang(
                        $s["id_DatHang"], $s["id_user"], $s["tenKH"], $s["sdt"],
                        $s["diaChi"], $s["tongTien"], $s["ngayDat"], $s["loai"],
                        $s["phuongThuc"], $s["tinhTrang"], $s["ghiChu"]
                    );
                    // Lấy chi tiết đơn hàng
                    $chiTietDon = $order_Model->getOrderDetail($s["id_DatHang"]);
                    $chiTietDonHangArray = [];
                    foreach ($chiTietDon as $detail) {
                        $chiTietDonHangArray[] = new ChiTietDonHang(
                            $detail["id_DatHang"], $detail["id_sanpham"], 
                            $detail["soLuong"], $detail["size"], 
                            $detail["toppings"], $detail["thanhTien"]
                        );
                    }
    
                    $donHang->chiTietDon = $chiTietDonHangArray; // Thêm chi tiết
                    $donHangMap[$s["id_DatHang"]] = $donHang; // Lưu vào mảng
                }
            }
            $mang = array_values($donHangMap); // Chỉ lấy giá trị
    
        } else {
            // Nếu có ID đơn hàng, lấy chi tiết đơn hàng
            $orderDetails = $order_Model->getOrderDetail($id_order);
            $donHang = null;
            $chiTietDonHangArray = [];
    
            foreach ($orderDetails as $detail) {
                if (!$donHang) {
                    $donHang = new donhang(
                        $detail["id_DatHang"], $detail["id_user"], 
                        $detail["tenKH"], $detail["sdt"], 
                        $detail["diaChi"], $detail["tongTien"], 
                        $detail["ngayDat"], $detail["loai"], 
                        $detail["phuongThuc"], $detail["tinhTrang"], 
                        $detail["ghiChu"]
                    );
                }
                $chiTietDonHangArray[] = new ChiTietDonHang(
                    $detail["id_DatHang"], $detail["id_sanpham"], 
                    $detail["soLuong"], $detail["size"], 
                    $detail["toppings"], $detail["thanhTien"]
                );
            }
    
            if ($donHang) {
                $donHang->chiTietDon = $chiTietDonHangArray;
                $mang[] = $donHang; // Thêm đơn hàng vào kết quả
            }
        }
    
        echo json_encode($mang); // Trả về dữ liệu JSON
    }    
    
    public function post_order() {
        $data = json_decode(file_get_contents("php://input"));
    
        require_once 'vendor/Model.php';
        $order_Model = $this->model("orderModel");
    
        $id_user = $data->id_user;
        $tenKH = $data->tenKH;
        $sdt = $data->sdt;
        $diaChi = $data->diaChi;
        $city = $data->city;
        $tongTien = $data->tongTien;
        $ngayDat = $data->ngayDat; 
        $loai = $data->loai;
        $phuongThuc = $data->phuongThuc;
        $tinhTrang = $data->tinhTrang;
        $ghiChu = $data->ghiChu;
    
        // Thêm đơn hàng và lấy ID
        $id_DatHang = $order_Model->addOrder($id_user, $tenKH, $sdt, $diaChi, $city, $tongTien, $ngayDat, $loai, $phuongThuc, $tinhTrang, $ghiChu);
    
        // Kiểm tra xem đơn hàng có được thêm thành công không
        if ($id_DatHang) {
            // Thêm thông tin thanh toán
            if (isset($data->payment)) {
                $id_taikhoan = $data->payment->id_taikhoan; 
                $thanhtoan = $data->payment->thanhtoan; 
                $status = $data->payment->status; 
                $orderDate = date('Y-m-d H:i:s'); 
                $order_Model->addPayment($id_DatHang, $id_taikhoan, $thanhtoan, $orderDate, $status);
            }
            // Thêm chi tiết đơn hàng
            if (!empty($data->chiTietDon)) {
                foreach ($data->chiTietDon as $item) {
                    $id_sanpham = $item->id_sanpham;
                    $soLuong = $item->soLuong;
                    $size = $item->size;
                    $toppings = $item->toppings; 
                    $thanhTien = $item->thanhTien;
                    // Gọi hàm thêm chi tiết đơn hàng
                    $order_Model->addOrderProduct($id_DatHang, $id_sanpham, $soLuong, $size, $toppings, $thanhTien);
                }
            }
            // Trả về phản hồi thành công
            echo json_encode(['message' => 'Thêm đơn hàng thành công', 'id_DatHang' => $id_DatHang]);
        } else {
            // Trả về phản hồi lỗi
            echo json_encode(['message' => 'Thêm đơn hàng không thành công']);
        }
    }
    
    
    public function put_order()
    {
        $data = json_decode(file_get_contents("php://input"));
        require_once 'vendor/Model.php';
		$orderModel = $this->model("orderModel");

        $id_order = $data ->id_order;
        $tinhTrang = $data->tinhTrang;

        $ktrama =$orderModel->KiemTraMa($id_order);
        // Kiểm tra ko null và tồn tại
        if (empty($id_order) ) {
            echo json_encode([ 'message' => 'Vui lòng nhập mã đơn hàng']);
            exit();
        }
        
        else if($ktrama==false){
            echo json_encode([ 'message' => 'Mã này không tồn tại ']);
            exit();
        }
        else{
            $result = $orderModel->updateStatus($id_order,$tinhTrang);
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Cập nhật trạng thái đơn hàng thành công']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Cập nhật không thành công']);
            }
        }
    }
    public function delete_order(){

        $data = json_decode(file_get_contents("php://input"));
        // Khởi tạo model
        require_once 'vendor/Model.php';
        $orderModel = $this->model("orderModel");
        $id_order = $data->id_order;

        $ktrama =$orderModel->KiemTraMa($id_order);
        // kiểm tra null và có mã trong csdl
        if (empty($id_order)) {
            echo json_encode(array('message' => 'Vui lòng nhập mã để xóa.'));
            return;
        }
        
        else if($ktrama==false){
            echo json_encode([ 'message' => 'Mã này không tồn tại ']);
            exit();
        }
        else{
            $result = $orderModel->deleteOrder($id_order);

            if ($result) {
                echo json_encode(['message' => 'Xóa đơn hàng thành công']);

            } else {
                echo json_encode(['message' => 'Xóa đơn hàng không thành công']);
            }
        }
    }
}
class ChiTietDonHang {
    public $id_DatHang;
    public $id_sanpham;
    public $soLuong;
    public $size;
    public $toppings;
    public $thanhTien;

    public function __construct($id_DatHang,$id_sanpham, $soLuong, $size, $toppings,$thanhTien) {
        $this->id_DatHang = $id_DatHang;
        $this->id_sanpham = $id_sanpham;
        $this->soLuong = $soLuong;
        $this->size = $size;
        $this->toppings = $toppings;
        $this->thanhTien = $thanhTien;
    }
}
class DonHang {
    public $id_DatHang;
    public $id_user;
    public $tenKH;
    public $sdt;
    public $diaChi; 
    public $tongTien;
    public $ngayDat;
    public $loai;
    public $phuongThuc;
    public $tinhTrang;
    public $ghiChu;
    public $chiTietDon = [];
    
    public function __construct($id_DatHang, $id_user, $tenKH, $sdt, $diaChi, $tongTien, $ngayDat, $loai, $phuongThuc, $tinhTrang, $ghiChu) {
        $this->id_DatHang = $id_DatHang;
        $this->id_user = $id_user;
        $this->tenKH = $tenKH;
        $this->sdt = $sdt;
        $this->diaChi = $diaChi;
        $this->tongTien = $tongTien;
        $this->ngayDat = $ngayDat;
        $this->loai = $loai;
        $this->phuongThuc = $phuongThuc;
        $this->tinhTrang = $tinhTrang;
        $this->ghiChu = $ghiChu;
    }
    
    public function addChiTietDon($chiTietDon) {
        $this->chiTietDon[] = $chiTietDon;
    }
}

