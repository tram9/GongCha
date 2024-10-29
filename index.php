<?php

// Kết nối cơ sở dữ liệu và các controller
require_once 'config/connect.php';
require_once 'vendor/Model.php';
require_once 'controller/admin/KhoHangController.php';
require_once 'controller/admin/EmployeeController.php';
require_once 'controller/admin/DashboardController.php';
require_once 'controller/admin/LoginController.php';
require_once 'controller/admin/HeaderController.php';
require_once 'controller/admin/menuController.php';
require_once 'controller/admin/saleController.php';
require_once 'controller/admin/NewsController.php';
require_once 'controller/admin/KhachController.php';

// require_once 'controller/admin/OderAdminController.php';
require_once 'vendor/Controller.php';
require_once 'vendor/Bootstrap.php';


session_start();
$x = new Bootstrap();

// define('LOGO', '/public/images/icon/title.png');

$admin_id = $_SESSION['id_nhanvien'] ?? 's';
// $loginController = new LoginController($conn);

// $loginController->checkLogin($admin_id);

// $employeeController = new EmployeeController($conn);
// $employeeController->listEmployees($admin_id);


// Lấy giá trị controller và action từ URL
$controller = $_GET['controller'] ?? ''; // Controller mặc định là khoHang
$action = $_GET['action'] ?? ''; // Action mặc định là listProducts
$isApiRequest = isset($_GET['api']); // Kiểm tra xem có phải là yêu cầu API không

// Hàm xử lý các hành động yêu cầu ID
function handleActionWithId($controller, $action) {
    $id = $_GET['id'] ?? null; // Lấy ID từ URL
    if ($id !== null) {
        $controller->$action($id);
    } else {
        echo ucfirst($action) . " requires an ID.";
    }
}

// Chọn Controller và xử lý yêu cầu
switch ($controller) {
    // case 'oder':
    //     $OderAdminController = new OderAdminController($conn);
    case 'khoHang':
        $khoHangController = new KhoHangController($conn);

        if ($isApiRequest) {
            // Xử lý yêu cầu API cho kho hàng
            switch ($action) {
                case 'listProducts':
                    $khoHangController->apiListProducts();
                    break;
                case 'listSupplier':
                    $khoHangController->apiListSupplier();
                    break;
                case 'addSupplier':
                    $khoHangController->apiAddSupplier();
                    break;
                case 'addProduct':
                    $khoHangController->apiAddProduct();
                    break;
                case 'updateSupplier':
                    handleActionWithId($khoHangController, 'apiUpdateSupplier');
                    break;
                case 'updateProduct':
                    handleActionWithId($khoHangController, 'apiUpdateProduct');
                    break;
                case 'deleteSupplier':
                    handleActionWithId($khoHangController, 'apiDeleteSupplier');
                    break;
                case 'deleteProduct':
                    handleActionWithId($khoHangController, 'apiDeleteProduct');
                    break;
                default:
                    http_response_code(404);
                    echo json_encode(['success' => false, 'message' => 'Unknown API action']);
                    break;
            }
        } else {
            // Xử lý giao diện người dùng cho kho hàng
            switch ($action) {
                case 'listProducts':
                    $khoHangController->listProducts();
                    break;
                case 'addProduct':
                    $khoHangController->addProduct();
                    break;
                case 'addSupplier':
                    $khoHangController->addSupplier();
                    break;
                case 'updateProduct':
                    handleActionWithId($khoHangController, 'updateProduct');
                    break;
                case 'updateSupplier':
                    handleActionWithId($khoHangController, 'updateSupplier');
                    break;
                case 'deleteProduct':
                    handleActionWithId($khoHangController, 'deleteProduct');
                    break;
                case 'deleteSupplier':
                    handleActionWithId($khoHangController, 'deleteSupplier');
                    break;
                case 'searchProducts':
                    $khoHangController->searchProducts();
                    break;
                case 'searchSupplier':
                    $khoHangController->searchSupplier();
                    break;
                default:
                    echo "Unknown action: $action";
                    break;
            }
        }
        break;

    case 'Employee':
        $employeeController = new EmployeeController($conn);
        if ($isApiRequest) {
            // Xử lý yêu cầu API cho EmployeeController
            switch ($action) {
                case 'listEmployees':
                    $employeeController->apiListEmployees();
                    break;
                case 'addEmployee':
                    $employeeController->apiAddEmployee();
                    break;
                case 'updateEmployee':
                    handleActionWithId($employeeController, 'apiUpdateEmployee');
                    break;
                case 'deleteEmployee':
                    handleActionWithId($employeeController, 'apiDeleteEmployee');
                    break;
                default:
                    http_response_code(404);
                    echo json_encode(['success' => false, 'message' => 'Unknown API action']);
                    break;
            }
        } else {
            // Xử lý giao diện người dùng cho EmployeeController
            switch ($action) {
                case 'listEmployees':
                    $employeeController->listEmployees($admin_id);
                    break;
                case 'addEmployee':
                    $employeeController->addEmployee();
                    break;
                case 'updateEmployee':
                    handleActionWithId($employeeController, 'updateEmployee');
                    break;
                case 'deleteEmployee':
                    handleActionWithId($employeeController, 'deleteEmployee');
                    break;
                case 'searchEmployees':
                    if (isset($_POST['search_type']) && $_POST['search_type'] === 'date') {
                        if (isset($_POST['startDate']) && isset($_POST['endDate'])) {
                            $startDate = $_POST['startDate'];
                            $endDate = $_POST['endDate'];
                            $employeeController->searchEmployeesByDate($startDate, $endDate);
                        } else {
                            echo "Vui lòng nhập đầy đủ khoảng ngày tìm kiếm.";
                        }
                    } else {
                        if (isset($_POST['search'])) {
                            $employeeController->searchEmployeesByName($_POST['search']);
                        } else {
                            echo "Vui lòng nhập tên tìm kiếm.";
                        }
                    }
                    break;
                // case 'employeeToExcel':
                //     $employeeController->employeeToExcel();
                //     break;
                default:
                    echo "Unknown action: $action";
                    break;
            }
        }
        break;

    case 'dashboard':
        $dashboardController = new DashboardController($conn);
        switch ($action) {
            case 'dashboard':
                $dashboardController->dashboard();
                break;
            case 'statistics':
                $dashboardController->statistics();
                break;
            default:
                echo "Unknown action: $action";
                break;
        }
        break;

    case 'Login':
        $loginController = new LoginController($conn);
        switch ($action) {
            case 'loginForm':
                $loginController->showLoginForm();
                break;
            case 'login':
                $loginController->login();
                break;
            case 'logout':
                $loginController->logout();
                break;
            default:
                echo "Unknown action: $action";
                break;
        }
        break;
    case 'menu':
        $menuController = new menuController($conn);
    
        if ($isApiRequest) {
            // Xử lý yêu cầu API cho menu
            switch ($action) {
                case 'listMenu':
                    $menuController->apiListMenu();
                    break;
                case 'addMenu':
                    $menuController->apiAddMenu();
                    break;
                case 'updateMenu':
                    handleActionWithId($menuController, 'apiUpdateMenu');
                    break;
                case 'deleteMenu':
                    handleActionWithId($menuController, 'apiDeleteMenu');
                    break;
                case 'searchMenu':
                    $menuController->apiSearchMenu();
                    break;
                default:
                    http_response_code(404);
                    echo json_encode(['success' => false, 'message' => 'Unknown API action']);
                    break;
            }
        } else {
            // Xử lý giao diện người dùng cho menu
            switch ($action) {
                case 'listMenu':
                    $menuController->listMenu($admin_id);
                    break;
                case 'addMenu':
                    $menuController->addMenu();
                    break;
                case 'updateMenu':
                    handleActionWithId($menuController, 'updateMenu');
                    break;
                case 'deleteMenu':
                    handleActionWithId($menuController, 'deleteMenu');
                    break;
                case 'searchMenu':
                    if (isset($_POST['search_type']) && $_POST['search_type'] === 'name') {
                        if (isset($_POST['search'])) {
                            $menuController->searchMenuByName($_POST['search']);
                        } else {
                            echo "Vui lòng nhập tên tìm kiếm.";
                        }
                    } else {
                        if (isset($_POST['search_category'])) {
                            $menuController->searchMenuByCategory($_POST['search_category']);
                        } else {
                            echo "Vui lòng nhập danh mục tìm kiếm.";
                        }
                    }
                    break;
                default:
                    echo "Unknown action: $action";
                    break;
            }
        }
        break;
    case 'sale':
        $saleController = new saleController($conn);
        switch ($action) {
            case 'saleForm':
                $saleController->saleForm();
                break;
            case 'login':
                $saleController->login();
                break;
            case 'logout':
                $saleController->logout();
                break;
            default:
                echo "Unknown action: $action";
                break;
        }
        break; 
        case 'News':
            $newcontroller = new NewsController($conn);
            if ($isApiRequest) {
                // Xử lý yêu cầu API cho kho hàng
                switch ($action) {
                    case 'index':
                        $newcontroller->apiListNews();
                        break;
                    case 'get':
                        $id = $_GET['id'] ?? null;
                        $newcontroller->apiGetNews($id);
                        break;
                    case 'create':
                        $newcontroller->apiCreateNews();
                        break;
                    case 'update':
                        $id = $_GET['id'] ?? null;
                        $newcontroller->apiUpdateNews($id);
                        break;
                    case 'delete':
                        handleActionWithId($newcontroller, 'apiDeleteNews');
                        break;
                    default:
                        http_response_code(404);
                        echo json_encode(['success' => false, 'message' => 'Unknown API action']);
                        break;
                }
            } else {
                // Xử lý giao diện người dùng cho kho hàng
                switch ($action) {
                    case 'index':
                        $newcontroller->tintuc();
                        break;
                    case 'add':
                        $newcontroller->add();
                        break;
                    case 'create':
                        $newcontroller->create();
                        break;
                    case 'edit':
                        $id = $_GET['id'] ?? null;
                        $newcontroller->edit($id);
                        break;
                    case 'update':
                        $id = $_POST['id'] ?? null;
                        $newcontroller->update($id);
                        break;
                    case 'delete':
                        handleActionWithId($newcontroller, 'delete');
                        break;
                    case 'search':
                        $newcontroller->search(); // Gọi phương thức tìm kiếm (nếu có)
                        break;
                    default:
                        echo "Hành động không hợp lệ."; // Xử lý hành động không hợp lệ
                        break;
                }
                break;
            }
            break;
    case 'Khach':
        $khach_controller = new KhachController($conn);
        switch ($action) {
            case 'index':
                $khach_controller->khach();
                break;
            default:
                echo "Unknown action: $action";
                break;
        }
        break;
}
?>
