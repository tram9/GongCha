<?php
require_once 'model/user/CartModel.php';
require_once 'controller/user/headerController.php';

// session_start();
class CartController {
    private $cartModel;
    private $headerController;

    public function __construct($dbConnection) {
        $this->cartModel = new CartModel($dbConnection);         
        $this->headerController = new headerController($dbConnection);

        
    }
    
    // public function add() {
    //     if (!isset($_SESSION['user_id'])) {
    //         header("Location: view/user/login.php");
    //         exit();
    //     }
    
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    //         $userId = $_SESSION['user_id'];
    //         $productId = $_POST['pid'] ?? null;
    //         $size = $_POST['size'] ?? '';
    //         $quantity = $_POST['qty'] ?? 1;
    //         $toppings = $_POST['toppings'] ?? ''; // Lấy topping
    //         $totalPrice = $_POST['total_price'] ?? 0; // Lấy tổng giá từ form
    
    //         if ($productId && $quantity > 0) {
    //             $this->cartModel->addToCart($userId, $productId, $size, $quantity, $toppings, $totalPrice); // Gọi phương thức với giá tổng
    //             header("Location: index.php?controller=cart&action=view");
    //             exit();
    //         } else {
    //             echo "Invalid product ID or quantity.";
    //         }
    //     }
    // }
    public function add() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: view/user/login.php");
            exit();
        }
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
            $userId = $_SESSION['user_id'];
            $productId = $_POST['pid'] ?? null;
            $size = $_POST['size'] ?? '';
            $quantity = $_POST['qty'] ?? 1;
            $toppings = $_POST['toppings'] ?? '';
            $toppingPrice = 11000; // Giá topping cố định
    
            if ($productId && $quantity > 0) {
                // Kiểm tra sản phẩm đã tồn tại trong giỏ chưa
                $existingItem = $this->cartModel->productExistsInCart($userId, $productId, $size, $toppings);
    
                if ($existingItem) {
                    // Nếu sản phẩm đã tồn tại, tăng số lượng
                    $newQuantity = $existingItem['quantity'] + $quantity;
    
                    // Tính giá mới
                    $pricePerUnit = $existingItem['price'] / $existingItem['quantity'];
                    $newPrice = $pricePerUnit * $newQuantity;
    
                    if ($toppings) {
                        $newPrice += $toppingPrice; // Thêm giá topping nếu có
                    }
    
                    // Cập nhật số lượng và giá mới vào giỏ hàng
                    $this->cartModel->updateCart($existingItem['id'], $newQuantity, $newPrice);
                } else {
                    // Nếu không tồn tại, thêm sản phẩm mới vào giỏ
                    $totalPrice = ($toppingPrice * ($toppings ? 1 : 0)) + ($this->getPriceBySize($productId, $size) * $quantity);
                    $this->cartModel->addToCart($userId, $productId, $size, $quantity, $toppings, $totalPrice);
                }
    
                header("Location: index_home.php?controller=cart&action=view");
                exit();
            } else {
                echo "Invalid product ID or quantity.";
            }
        }
    }
    
    // Phương thức hỗ trợ để lấy giá theo kích thước
    private function getPriceBySize($productId, $size) {
        // Giả sử bạn có một phương thức để lấy giá sản phẩm theo kích thước
        $product = $this->cartModel->getProductById($productId);
        switch ($size) {
            case 'S':
                return $product['gia_S'];
            case 'M':
                return $product['gia_M'];
            case 'L':
                return $product['gia_L'];
            default:
                return 0; // Hoặc có thể ném ra một ngoại lệ
        }
    }

    public function view() {
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
            $this->headerController->getHeaderData($userId);
            $cartItems = $this->cartModel->getCart($userId);
            include 'view/user/cart.php';
        } else {
            header("Location: view/user/login.php");
            exit();
        }
    }
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_cart'])) {
            $cartId = $_POST['cart_id'];
            $quantity = $_POST['quantity'];
    
            if ($quantity > 0) {
                // Lấy thông tin sản phẩm trong giỏ hàng
                $cartItem = $this->cartModel->getCartItemById($cartId);
    
                // Lấy thông tin sản phẩm từ bảng product
                $product = $this->cartModel->getProductById($cartItem['product_id']);
                $size = $cartItem['size']; // Giả sử size được lưu trong giỏ hàng
    
                // Lấy giá tương ứng với kích thước
                $pricePerUnit = 0;
                switch ($size) {
                    case 'S':
                        $pricePerUnit = $product['gia_S'];
                        break;
                    case 'M':
                        $pricePerUnit = $product['gia_M'];
                        break;
                    case 'L':
                        $pricePerUnit = $product['gia_L'];
                        break;
                    default:
                        echo "Kích thước không hợp lệ.";
                        return;
                }
    
                // Kiểm tra xem có topping không
                $toppingPrice = 0; // Mặc định là 0 nếu không có topping
                if (!empty($cartItem['toppings'])) {
                    // Nếu có topping, lấy giá topping
                    $toppingPrice = 11000; // Giá topping cố định
                }
    
                // Tính tổng giá mới
                $newPrice = ($pricePerUnit + $toppingPrice) * $quantity ;
    
                // Cập nhật số lượng và giá mới vào giỏ hàng
                $this->cartModel->updateCart($cartId, $quantity, $newPrice);
    
                header("Location: index_home.php?controller=cart&action=view");
                exit();
            } else {
                echo "Số lượng không hợp lệ.";
            }
        }
    }
    
    
    public function delete() {
        if (isset($_GET['id'])) {
            $cartId = $_GET['id'];
    
            // Xóa sản phẩm khỏi giỏ hàng
            $this->cartModel->deleteFromCart($cartId);
    
            header("Location: index_home.php?controller=cart&action=view");
            exit();
        }
    }

    
    
    

    
}
?>