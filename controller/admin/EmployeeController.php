<?php
require_once 'model/admin/EmployeeModel.php';
require_once 'controller/admin/HeaderController.php';
class EmployeeController {
    private $model;
    private $headerController;

    public function __construct($dbConnection) {
        $this->headerController = new HeaderController($dbConnection);
        $this->model = new EmployeeModel($dbConnection); // Model cho bảng nhanvien
    }

    
    // Thêm nhân viên
    public function addEmployee() {
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_nhanvien = $_POST['id_nhanvien'];
            $tenNV = $_POST['tenNV'];
            $email = $_POST['email'];
            $sdt = $_POST['sdt'];
            $ngayvaolam = $_POST['ngayvaolam'];
            $luong = $_POST['luong'];
            $taikhoan = $_POST['taikhoan'];
            $matkhau = password_hash($_POST['matkhau'], PASSWORD_BCRYPT); // Mã hóa mật khẩu
            $quyen = $_POST['quyen'];
            if ($this->model->idExists($id_nhanvien) || $this->model->sdtExists($sdt) || $this->model->emailExists($email) ||$this->model->taikhoanExists($taikhoan)) {
                $_SESSION['message'] = "Mã nhân viên/số điện thoại/ email/ tên tài khoản đã tồn tại!";
                header("Location: index.php?controller=Employee&action=listEmployees"); // Chuyển hướng lại trang cần hiển thị
                exit;
                
            }else{
            $this->model->addEmployee($id_nhanvien, $tenNV, $email, $sdt, $ngayvaolam, $luong, $taikhoan, $matkhau, $quyen);
            header('Location: index.php?controller=Employee&action=listEmployees');
            }
        } else {
            include 'view/admin/employee.php';
        }
    }

    // Cập nhật thông tin nhân viên
    public function updateEmployee($id) {
        $employee = $this->model->getEmployeeById($id); 

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $tenNV = $_POST['tenNV'];
            $email = $_POST['email'];
            $sdt = $_POST['sdt'];
            $ngayvaolam = $_POST['ngayvaolam'];
            $luong = $_POST['luong'];
            $taikhoan = $_POST['taikhoan'];
            $matkhau = !empty($_POST['matkhau']) ? password_hash($_POST['matkhau'], PASSWORD_BCRYPT) : $employee['matkhau']; // Cập nhật nếu có thay đổi
            $quyen = $_POST['quyen'];
            if ($this->model->sdtExists($sdt) || $this->model->emailExists($email) ||$this->model->taikhoanExists($taikhoan)) {
                $_SESSION['message'] = "Số điện thoại/ email/ tên tài khoản đã tồn tại!";
                header("Location: index.php?controller=Employee&action=listEmployees"); // Chuyển hướng lại trang cần hiển thị
                exit;  
            }else{
            $this->model->updateEmployee($id, $tenNV, $email, $sdt, $ngayvaolam, $luong, $taikhoan, $matkhau, $quyen);
            header('Location: index.php?controller=Employee&action=listEmployees');
            }
        } else {
            include 'view/admin/employee.php';
        }
    }

    // Xóa nhân viên
    public function deleteEmployee($id) {
        $this->model->deleteEmployee($id);
        header('Location: index.php?controller=Employee&action=listEmployees');
    }

    // Tìm kiếm nhân viên
    public function searchEmployeesByName($admin_id) {
        $this->headerController->displayHeader($admin_id); // Hiển thị header
        $keyword = $_POST['search'] ?? '';
        $employees = $this->model->searchEmployeesByName($keyword);
        include 'view/admin/employee.php';
    }

    public function searchEmployeesByDate($admin_id) {
        $this->headerController->displayHeader($admin_id); // Hiển thị header
        
        // Lấy ngày bắt đầu và ngày kết thúc từ form
        $startDate = $_POST['startDate'] ?? '';
        $endDate = $_POST['endDate'] ?? '';
        
        // Truyền cả hai ngày cho model để thực hiện tìm kiếm trong khoảng ngày
        $employees = $this->model->searchEmployeesByDate($startDate, $endDate);
        
        include 'view/admin/employee.php';
    }
    

    // Hiển thị danh sách nhân viên
    public function listEmployees($admin_id) {
        $admin_id = $_SESSION['id_nhanvien'];

        if (!isset($admin_id)) {
            header('location:index.php?controller=Login&action=loginForm');
            exit;
        }
        $this->headerController->displayHeader($admin_id);
        $employees = $this->model->getAllEmployees();
        // include 'view/admin/header.php';
        include 'view/admin/employee.php';
    }    


    // API: Danh sách nhân viên
    public function apiListEmployees() {
        $employees = $this->model->getAllEmployees();
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'data' => $employees]);
    }

    // API: Thêm nhân viên
    public function apiAddEmployee() {
        $data = json_decode(file_get_contents('php://input'), true);
        if (isset($data['id_nhanvien'], $data['tenNV'], $data['email'], $data['sdt'], $data['ngayvaolam'], $data['luong'], $data['taikhoan'], $data['matkhau'], $data['quyen'])) {
            $matkhau_hashed = password_hash($data['matkhau'], PASSWORD_BCRYPT);
            if ($this->model->addEmployee($data['id_nhanvien'], $data['tenNV'], $data['email'], data['sdt'], $data['ngayvaolam'], $data['luong'], $data['taikhoan'], $matkhau_hashed, $data['quyen'])) {
                http_response_code(201);
                echo json_encode(['success' => true, 'message' => 'Employee added successfully']);
            } else {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Failed to add Employee']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Invalid input']);
        }
    }

    // API: Cập nhật nhân viên
    public function apiUpdateEmployee($id) {
        $data = json_decode(file_get_contents('php://input'), true);
        if (isset($data['tenNV'], $data['email'], data['sdt'], $data['ngayvaolam'], $data['luong'], $data['taikhoan'], $data['quyen'])) {
            $matkhau = !empty($data['matkhau']) ? password_hash($data['matkhau'], PASSWORD_BCRYPT) : null;
            if ($this->model->updateEmployee($id, $data['tenNV'], $data['email'], data['sdt'], $data['ngayvaolam'], $data['luong'], $data['taikhoan'], $matkhau, $data['quyen'])) {
                echo json_encode(['success' => true, 'message' => 'Employee updated successfully']);
            } else {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Failed to update Employee']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Invalid input']);
        }
    }

    // API: Xóa nhân viên
    public function apiDeleteEmployee($id) {
        if ($this->model->deleteEmployee($id)) {
            echo json_encode(['success' => true, 'message' => 'Employee deleted successfully']);
        } else {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Failed to delete Employee']);
        }
    }
}
?>
