<?php

// Bắt đầu session để lưu thông tin user
session_start();

// Kết nối cơ sở dữ liệu
require_once 'config/connect.php';
require_once 'vendor/Model.php';
require_once 'controller/user/homeController.php';
require_once 'controller/user/CartController.php';
require_once 'controller/user/menuController.php';
require_once 'controller/user/loginController.php';
require_once 'controller/user/categoryController.php';
require_once 'controller/user/NewsController.php';
require_once 'controller/user/RegisterController.php';
require_once 'controller/user/ProfileController.php';

$user_id = $_SESSION['user_id'] ?? '';

$controller = $_GET['controller'] ?? 'home'; 
$action = $_GET['action'] ?? 'home';

function handleActionWithId($controller, $action) {
    $id = $_GET['id'] ?? null; // Lấy ID từ URL
    if ($id !== null) {
        $controller->$action($id);
    } else {
        echo ucfirst($action) . " requires an ID.";
    }
}

switch ($controller) {
    case 'Register':
        $registerController = new RegisterController($conn);
        switch ($action) {
            case 'add':
                $registerController->add();
                break;
            default:
                echo "Unknown action: $action";
                break;
        }
        break;
    case 'login':
        $loginController = new loginController($conn);
        switch ($action) {
            case 'loginForm':
                $loginController->show();
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

    case 'home':
        $homeController = new homeController($conn);
        switch ($action) {
            case 'home':
                $homeController->displayHome();
                break;
            default:
                echo "Unknown action: $action";
                break;
        }
        break;
    case 'category':
        $categoryController = new categoryController($conn);
        switch ($action) {
            case 'home':
                handleActionWithId($categoryController, 'display');
                break;
            default:
                echo "Unknown action: $action";
                break;
        }
        break;
    case 'menu':
        $menuController = new menuController($conn);
        switch ($action) {
            case 'view':
                $menuController->showMenu();
                break;
            case 'quickview':
                handleActionWithId($menuController, 'view');
                break;
            default:
                echo "Unknown action: $action";
                break;
        }
        break;

    case 'cart':
        $cartController = new CartController($conn);
        switch ($action) {
            case 'add':
                $cartController->add();
                break;
            case 'view':
                $cartController->view();
                break;
            case 'update':
                $cartController->update();
                break;
            case 'delete':
                $cartController->delete();
                break;
            default:
                echo "Unknown action: $action";
                break;
        }
        break;
    case 'news':
        $newsController = new NewsController($conn);
        switch ($action) {
            case 'news':
                $newsController->displayNews();
                break;
            default:
                echo "Unknown action: $action";
                break;
        }
        break;
    case 'Profile':
        $profileController = new ProfileController($conn);
        switch ($action) {
            // case 'view':
            //     $profileController->view();
            //     break;
            case 'update':
                $profileController->update();
                break;
            default:
                echo "Unknown action: $action";
                break;
        }
        break;
    
}
?>
