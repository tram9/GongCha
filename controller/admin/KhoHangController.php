<?php
require_once 'model/admin/KhoHangModel.php';
require_once 'model/admin/nhaCungCapModel.php';
require_once 'controller/admin/HeaderController.php';

class KhoHangController {
    private $model;
    private $nccModel;
    private $headerController;

    public function __construct($dbConnection) {
        $this->model = new KhoHangModel($dbConnection); // Model cho kho hàng
        $this->nccModel = new NhaCungCapModel($dbConnection); // Model cho nhà cung cấp        
        $this->headerController = new HeaderController($dbConnection);

    }

    public function addProduct() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $ten_nl = $_POST['ten_nl'];
            $so_luong = $_POST['so_luong'];
            $ngay_nhap = $_POST['ngay_nhap'];
            $gia_nhap = $_POST['gia_nhap'];
            $ncc_id = $_POST['ncc_id'];
    
            
            $this->model->addProduct($ten_nl, $so_luong, $ngay_nhap, $gia_nhap, $ncc_id);
            
            
            header('Location: index.php?controller=khoHang&action=listProducts');
        } else {
            include 'view/admin/kho_hang/add.php'; 
        }
    }

    // Xử lý thêm nhà cung cấp
    public function addSupplier() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ten_ncc = $_POST['ten_ncc'];
            $diachi = $_POST['diachi'];
            $sdt = $_POST['sdt'];
            $masothue = $_POST['masothue'];
            $ghichu = $_POST['ghichu'];

            
            $this->nccModel->addSupplier($ten_ncc, $diachi, $sdt, $masothue, $ghichu);
            
            
            header('Location: index.php?controller=khoHang&action=listProducts');
        } else {
            include 'view/admin/kho_hang/add_ncc.php'; 
        }
    }


    public function updateProduct($id) {
        
        $product = $this->model->getProductById($id); 
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $ten_nl = $_POST['ten_nl'];
            $so_luong = $_POST['so_luong'];
            $ngay_nhap = $_POST['ngay_nhap'];
            $gia_nhap = $_POST['gia_nhap'];
            $ncc_id = $_POST['ncc_id'];
    
            
            $this->model->updateProduct($id, $ten_nl, $so_luong, $ngay_nhap, $gia_nhap, $ncc_id);
            
            
            header('Location: index.php?controller=khoHang&action=listProducts');
        } else {
            include 'view/admin/kho_hang/edit.php'; 
        }
    }
    // Nha cung cấp 
    public function updateSupplier($id) {
        
        $supplier = $this->nccModel->getSupplierById($id); 
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $ten_ncc = $_POST['ten_ncc'];
            $diachi = $_POST['diachi'];
            $sdt = $_POST['sdt'];
            $masothue = $_POST['masothue'];
            $ghichu = $_POST['ghichu'];
    
            
            $this->nccModel->updateSupplier($id, $ten_ncc, $diachi, $sdt, $masothue, $ghichu);
            
            
            header('Location: index.php?controller=khoHang&action=listProducts');
        } else {
            include 'view/admin/kho_hang/edit_ncc.php'; 
        }
    }

    public function deleteProduct($id) {
        $this->model->deleteProduct($id);
        header('Location: index.php?controller=khoHang&action=listProducts'); 
    }

    public function deleteSupplier($id) {
        $this->nccModel->deleteSupplier($id);
        header('Location: index.php?controller=khoHang&action=listProducts'); 
    }

    public function searchProducts() {
        $keyword = $_GET['search'] ?? '';
        
       
        $products = $this->model->searchProducts($keyword);
        
       
        $suppliers = $this->nccModel->getAllSuppliers();
        
       
        include 'view/admin/kho_hang/list.php'; 
    }  
    public function searchSupplier() {
        $keyword = $_GET['search'] ?? '';
        
        $suppliers = $this->nccModel->searchSupplier($keyword);
        
        $products = $this->model->getAllProducts();
        
        include 'view/admin/kho_hang/list.php'; 
    }

    public function listProducts() {
        $admin_id = $_SESSION['id_nhanvien'];
        $this->headerController->displayHeader($admin_id);
        // Fetch all products
        $products = $this->model->getAllProducts();
        
        // Fetch all suppliers
        $suppliers = $this->nccModel->getAllSuppliers();
        
        // Pass the data to the view
        include 'view/admin/kho_hang/list.php'; // Ensure this view is correctly defined
    }

    // RESTful API: List Products
    public function apiListProducts() {
        $products = $this->model->getAllProducts();
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'data' => $products]);
    }

    // RESTful API: Add Product
    public function apiAddProduct() {
        $data = json_decode(file_get_contents('php://input'), true);
        if (isset($data['ten_nl'], $data['so_luong'], $data['ngay_nhap'], $data['gia_nhap'], $data['ncc_id'])) {
          
            if ($this->model->addProduct($data['ten_nl'], $data['so_luong'], $data['ngay_nhap'], $data['gia_nhap'], $data['ncc_id'])) {
                http_response_code(201);
                echo json_encode(['success' => true, 'message' => 'Product added successfully']);
            } else {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Failed to add product']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Invalid input']);
        }
    }

    // RESTful API: Update Product
    public function apiUpdateProduct($id) {
      
        $data = json_decode(file_get_contents('php://input'), true);
    

        if (isset($data['ten_nl'], $data['so_luong'], $data['ngay_nhap'], $data['gia_nhap'], $data['ncc_id'])) {
            
            
            if ($this->model->updateProduct($id, $data['ten_nl'], $data['so_luong'], $data['ngay_nhap'], $data['gia_nhap'], $data['ncc_id'])) {
                echo json_encode(['success' => true, 'message' => 'Product updated successfully']);
            } else {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Failed to update product']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Invalid input']);
        }
    }
    

    // RESTful API: Delete Product
    public function apiDeleteProduct($id) {
        if ($this->model->deleteProduct($id)) {
            echo json_encode(['success' => true, 'message' => 'Product deleted successfully']);
        } else {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Failed to delete product']);
        }
    }

    // RESTful API: List Suppliers
    public function apiListSupplier() {
        $suppliers = $this->nccModel->getAllSuppliers();
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'data' => $suppliers]);
    }

    // RESTful API: Add Supplier
    public function apiAddSupplier() {
        $data = json_decode(file_get_contents('php://input'), true);
        if (isset($data['ten_ncc'], $data['diachi'], $data['sdt'], $data['masothue'], $data['ghichu'])) {
            if ($this->nccModel->addSupplier($data['ten_ncc'], $data['diachi'], $data['sdt'], $data['masothue'], $data['ghichu'])) {
                http_response_code(201);
                echo json_encode(['success' => true, 'message' => 'Supplier added successfully']);
            } else {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Failed to add supplier']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Invalid input']);
        }
    }

    // RESTful API: Update Supplier
    public function apiUpdateSupplier($id) {
        $data = json_decode(file_get_contents('php://input'), true);
        if (isset($data['ten_ncc'], $data['diachi'], $data['sdt'], $data['masothue'], $data['ghichu'])) {
            if ($this->nccModel->updateSupplier($id, $data['ten_ncc'], $data['diachi'], $data['sdt'], $data['masothue'], $data['ghichu'])) {
                echo json_encode(['success' => true, 'message' => 'Supplier updated successfully']);
            } else {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Failed to update supplier']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Invalid input']);
        }
    }

    // RESTful API: Delete Supplier
    public function apiDeleteSupplier($id) {
        if ($this->nccModel->deleteSupplier($id)) {
            echo json_encode(['success' => true, 'message' => 'Supplier deleted successfully']);
        } else {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Failed to delete supplier']);
        }
    }
}
?>