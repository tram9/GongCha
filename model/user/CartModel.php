<<?php

class CartModel extends Model
{
    function __construct()
    {
        parent::__construct();
    }
    public function addToCart($userId, $productId, $size, $quantity, $toppings, $price) {
        try {
            $stmt = $this->conn->prepare("INSERT INTO cart (user_id, product_id, size, quantity, toppings, price) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$userId, $productId, $size, $quantity, $toppings, $price]);
        } catch (PDOException $e) {
            echo "Error adding to cart: " . $e->getMessage();
        }
    }
    
    public function getCartItemCount($userId){
        $query = $this->conn->prepare("SELECT SUM(quantity) as total_quantity FROM `cart` WHERE user_id = ?");
        $query->execute([$userId]); // Truyền tham số dưới dạng mảng
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result['total_quantity'] ?? 0; // Trả về 0 nếu không có sản phẩm nào
    }
    
    
    public function getCart($userId) {
        $stmt = $this->conn->prepare("SELECT c.id, c.product_id, c.size, c.quantity, c.toppings, c.price, p.tenSP, p.hinh_anh 
                                      FROM cart c 
                                      JOIN menu p ON c.product_id = p.id_sanpham 
                                      WHERE c.user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function updateCart($cartId, $quantity, $newPrice) {
        try {
            $stmt = $this->conn->prepare("UPDATE cart SET quantity = ?, price = ? WHERE id = ?");
            $stmt->execute([$quantity, $newPrice, $cartId]);
        } catch (PDOException $e) {
            echo "Lỗi khi cập nhật giỏ hàng: " . $e->getMessage();
        }
    }
    
    public function deleteFromCart($cartId) {
        try {
            $stmt = $this->conn->prepare("DELETE FROM cart WHERE id = ?");
            $stmt->execute([$cartId]);
        } catch (PDOException $e) {
            echo "Lỗi khi xóa khỏi giỏ hàng: " . $e->getMessage();
        }
    }
    public function getCartItemById($cartId) {
        $stmt = $this->conn->prepare("SELECT * FROM cart WHERE id = ?");
        $stmt->execute([$cartId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getProductById($productId) {
        $stmt = $this->conn->prepare("SELECT * FROM menu WHERE id_sanpham = ?");
        $stmt->execute([$productId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getToppingPrice($toppingId) {
        // Query to get topping price based on its ID
        $stmt = $this->conn->prepare("SELECT gia_M FROM menu WHERE id_sanpham = ?");
        $stmt->execute([$toppingId]);
        return $stmt->fetch(PDO::FETCH_ASSOC); // Returns false if not found
    }
    
    
    public function productExistsInCart($userId, $productId, $size, $toppings) {
        $stmt = $this->conn->prepare("SELECT * FROM cart WHERE user_id = :user_id AND product_id = :product_id AND size = :size AND toppings = :toppings");
        $stmt->execute([
            'user_id' => $userId,
            'product_id' => $productId,
            'size' => $size,
            'toppings' => $toppings
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC); // Trả về thông tin sản phẩm nếu có
    }       
}
?>
