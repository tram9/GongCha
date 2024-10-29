<?php
require_once 'model/admin/menuModel.php';
require_once 'controller/admin/HeaderController.php';

class menuController {
    private $model;
    private $headerController;

    public function __construct($dbConnection) {
        $this->headerController = new HeaderController($dbConnection);
        $this->model = new menuModel($dbConnection); // Model cho bảng dtb_menu
    }

    private function ImageUpload() {
        if (isset($_FILES['hinh_anh']) && $_FILES['hinh_anh']['error'] === UPLOAD_ERR_OK) {
            $hinh_anh = $_FILES['hinh_anh'];
            $uploadDir = 'public/images/'; // Thư mục gốc lưu hình ảnh
            $folder = ''; // Biến để lưu tên folder
    
            // Lấy tên folder từ đường dẫn của hình ảnh
            $folder = basename(dirname($hinh_anh['name'])); // Lấy tên folder cha
            $uploadFile = $uploadDir . $folder . '/' . basename($hinh_anh['name']); // Lưu tệp tại đường dẫn mong muốn
    
            // Kiểm tra xem tệp có phải là hình ảnh không
            $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
            $check = getimagesize($hinh_anh['tmp_name']);
            if ($check !== false) {
                // Chỉ cho phép các định dạng hình ảnh cụ thể
                $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
                if (in_array($imageFileType, $allowedTypes)) {
                    if (move_uploaded_file($hinh_anh['tmp_name'], $uploadFile)) {
                        return $folder . '/' . basename($hinh_anh['name']); // Trả về đường dẫn hình ảnh đã lưu mà không bao gồm thư mục gốc
                    } else {
                        echo "Có lỗi khi tải lên hình ảnh.";
                    }
                } else {
                    echo "Chỉ cho phép các định dạng hình ảnh: " . implode(", ", $allowedTypes);
                }
            } else {
                echo "Tệp không phải là hình ảnh.";
            }
        } else {
            echo "Không có hình ảnh nào được tải lên.";
        }
        return null; // Trả về null nếu không có hình ảnh
    }
    
    

    // Thêm sản phẩm vào menu
    public function addMenu() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_sanpham = $_POST['id_sanpham'];
            $id_danhmuc = $_POST['id_danhmuc'];
            $tenSP = $_POST['tenSP'];
            $congthuc = $_POST['congthuc'];
            $gia_S = $_POST['gia_S'];
            $gia_M = $_POST['gia_M'];
            $gia_L = $_POST['gia_L'];

            // Gọi hàm xử lý tải lên hình ảnh
            $hinh_anh = $this->ImageUpload();
            if ($hinh_anh) {
                // Thêm sản phẩm vào cơ sở dữ liệu
                $this->model->addMenu($id_sanpham, $id_danhmuc, $tenSP, $hinh_anh, $congthuc, $gia_S, $gia_M, $gia_L);
                header('Location: index.php?controller=menu&action=listMenu');
            }
        } else {
            include 'view/admin/menu.php';
        }
    }
    

    // Cập nhật thông tin sản phẩm trong menu
    public function updateMenu($id) {
        $menuItem = $this->model->getMenuById($id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_danhmuc = $_POST['id_danhmuc'];
            $tenSP = $_POST['tenSP'];
            $congthuc = $_POST['congthuc'];
            $gia_S = $_POST['gia_S'];
            $gia_M = $_POST['gia_M'];
            $gia_L = $_POST['gia_L'];

            // Gọi hàm xử lý tải lên hình ảnh
            $hinh_anh = $this->ImageUpload();
            if ($hinh_anh) {
                // Cập nhật thông tin sản phẩm
                $this->model->updateMenu($id, $id_danhmuc, $tenSP, $hinh_anh, $congthuc, $gia_S, $gia_M, $gia_L);
            } else {
                // Nếu không có hình ảnh mới, cập nhật thông tin mà không thay đổi hình ảnh
                $hinh_anh = $menuItem['hinh_anh'];
                $this->model->updateMenu($id, $id_danhmuc, $tenSP, $hinh_anh, $congthuc, $gia_S, $gia_M, $gia_L);
            }
            header('Location: index.php?controller=menu&action=listMenu');
        } else {
            include 'view/admin/menu.php';
        }
    }

    // Xóa sản phẩm trong menu
    public function deleteMenu($id) {
        $this->model->deleteMenu($id);
        header('Location: index.php?controller=menu&action=listMenu');
    }

    // Tìm kiếm sản phẩm trong menu
    public function searchMenuByName($admin_id) {
        $this->headerController->displayHeader($admin_id); // Hiển thị header
        $keyword = $_POST['search'] ?? '';
        $menuItems = $this->model->searchMenuByName($keyword);
        include 'view/admin/menu.php';
    }
    public function searchMenuByCategory($admin_id) {
        
        // include 'view/admin/header.php';
        $this->headerController->displayHeader($admin_id); // Hiển thị header
        $keyword = $_POST['search_category'] ?? '';
        $menuItems = $this->model->searchMenuByCategory($keyword);
        include 'view/admin/menu.php';
    }

    // Hiển thị danh sách sản phẩm trong menu
    public function listMenu($admin_id) {
        $this->headerController->displayHeader($admin_id); // Hiển thị header
        $danhMucList = $this->model->getDanhMucList();

        $menuItems = $this->model->getAllMenu();
        include 'view/admin/menu.php';
    }

    

    // API: Danh sách sản phẩm trong menu
    public function apiListMenu() {
        $menuItems = $this->model->getAllMenu();
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'data' => $menuItems]);
    }

    // API: Thêm sản phẩm vào menu
    public function apiAddMenu() {
        $data = json_decode(file_get_contents('php://input'), true);
        if (isset($data['id_sanpham'], $data['id_danhmuc'], $data['tenSP'], $data['hinh_anh'], $data['congthuc'], $data['gia_S'], $data['gia_M'], $data['gia_L'])) {
            if ($this->model->addMenu($data['id_sanpham'], $data['id_danhmuc'], $data['tenSP'], $data['hinh_anh'], $data['congthuc'], $data['gia_S'], $data['gia_M'], $data['gia_L'])) {
                http_response_code(201);
                echo json_encode(['success' => true, 'message' => 'Menu item added successfully']);
            } else {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Failed to add menu item']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Invalid input']);
        }
    }

    // API: Cập nhật sản phẩm trong menu
    public function apiUpdateMenu($id) {
        $data = json_decode(file_get_contents('php://input'), true);
        if (isset($data['id_danhmuc'], $data['tenSP'], $data['hinh_anh'], $data['congthuc'], $data['gia_S'], $data['gia_M'], $data['gia_L'])) {
            if ($this->model->updateMenu($id, $data['id_danhmuc'], $data['tenSP'], $data['hinh_anh'], $data['congthuc'], $data['gia_S'], $data['gia_M'], $data['gia_L'])) {
                echo json_encode(['success' => true, 'message' => 'Menu item updated successfully']);
            } else {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Failed to update menu item']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Invalid input']);
        }
    }

    // API: Xóa sản phẩm trong menu
    public function apiDeleteMenu($id) {
        if ($this->model->deleteMenu($id)) {
            echo json_encode(['success' => true, 'message' => 'Menu item deleted successfully']);
        } else {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Failed to delete menu item']);
        }
    }
}
?>
