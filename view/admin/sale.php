<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bán Trà Sữa Trực Tiếp</title>
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0/css/bootstrap.min.css"> -->
    
    <link rel="stylesheet" href="public/css/sale.css">
    
</head>
<body>
<div class="container">
    <div class="flex-container">
        <!-- Cột trái - Chọn sản phẩm trà sữa -->
        <div class="col-md-6">
            <div class="form-card products">
                <h3>Chọn Sản Phẩm Trà Sữa</h3>
                <div class="product-list">
                    <?php if (!empty($drinks)): ?>
                        <?php foreach($drinks as $product): ?>
                            <div class="card product-card">
                                <img src="public/images/<?= $product['hinh_anh'] ?>" class="card-img-top" alt="<?= $product['tenSP'] ?>">
                                <div class="card-body text-center">
                                    <h5 class="card-title" style="font-size: 1rem;" id="productName"><?= $product['tenSP'] ?></h5>
                                    <div class="size-buttons" data-product-id="<?= $product['id_sanpham'] ?>">
                                        <button class="btn btn-secondary btn-sm" 
                                            data-size="S" 
                                            data-price="<?= $product['gia_S'] ?>"
                                            onclick="selectSize('S', <?= $product['id_sanpham'] ?>)" 
                                            <?= ($product['gia_S'] == null || $product['gia_S'] == 0) ? 'disabled' : '' ?>>
                                            S
                                        </button>
                                        
                                        <button class="btn btn-secondary btn-sm" 
                                            data-size="M" 
                                            data-price="<?= $product['gia_M'] ?>"
                                            onclick="selectSize('M', <?= $product['id_sanpham'] ?>)" 
                                            <?= ($product['gia_M'] == null || $product['gia_M'] == 0) ? 'disabled' : '' ?>>
                                            M
                                        </button>
                                        
                                        <button class="btn btn-secondary btn-sm" 
                                            data-size="L" 
                                            data-price="<?= $product['gia_L'] ?>"
                                            onclick="selectSize('L', <?= $product['id_sanpham'] ?>)" 
                                            <?= ($product['gia_L'] == null || $product['gia_L'] == 0) ? 'disabled' : '' ?>>
                                            L
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Không có sản phẩm nào.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Cột phải - Chia thành 2 phần -->
        <div class="col-md-6">
            <div class="form-card toppings">
                <h3>Chọn Topping</h3>
                <div class="topping-list">
                    <?php if (!empty($toppings)): ?>
                        <?php foreach($toppings as $topping): ?>
                            <div class="card topping-card">
                                <img src="public/images/<?= $topping['hinh_anh'] ?>" class="card-img-top" alt="<?= $topping['tenSP'] ?>">
                                <div class="card-body text-center">
                                    <h5 class="card-title" style="font-size: 1rem;"><?= $topping['tenSP'] ?> - <?= $topping['gia_M'] ?> VNĐ</h5>
                                    <div class="quantity-confirm">
                                        <input type="number" min="0" value="0" class="form-control" id="quantity-<?= $topping['id_sanpham'] ?>" style="width: 50px; display: inline-block;">
                                        <button class="btn btn-success btn-sm topping-button" 
                                                topping-price="<?= $topping['gia_M'] ?>" 
                                                topping-name="<?= $topping['tenSP'] ?>" 
                                                style="width: 50px;">
                                            Chọn
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Không có topping nào.</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Nửa dưới - Hiện những gì đã chọn -->
            <div class="total-card">
                <h3>Đã Chọn</h3>
                <div class="selected-items" id="selectedItems">
                    <p><strong>Sản phẩm:</strong> <span id="selectedProduct">Chưa chọn</span></p>
                    <p><strong>Kích thước:</strong> <span id="selectedSize">Chưa chọn</span></p>
                    <p><strong>Giá:</strong> <span id="selectedPrice">0 VNĐ</span></p>
                    <p><strong>Topping:</strong> <span id="selectedToppings">Chưa chọn</span></p>
                    <p><strong>Giá:</strong> <span id="ToppingPrice">0 VNĐ</span></p>
                    <p><strong>Tổng tiền:</strong> <span id="totalPrice">0 VNĐ</span></p>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="selected_size" />
<input type="hidden" id="total_price" />
<script>
    // Lấy tất cả các nút kích thước và các phần tử cần thiết khác
const sizeButtons = document.querySelectorAll('.size-buttons .btn');
const priceDisplay = document.getElementById('selectedPrice');
const selectedSizeInput = document.getElementById('selected_size');

const toppingList = document.getElementById('topping-list');

// const quantityInput = document.querySelector('input[name="qty"]');

const selectedProductDisplay = document.getElementById('selectedProduct');
const selectedSizeDisplay = document.getElementById('selectedSize');
const productName = document.getElementById('productName').innerText; // Lấy tên sản phẩm

const selectedToppingsDisplay = document.getElementById('selectedToppings');
const toppingPriceDisplay = document.getElementById('ToppingPrice');
const totalPriceDisplay = document.getElementById('totalPrice');

let basePrice = 0; // Giá cơ bản (giá sản phẩm)
let toppingPrice = 0; // Giá topping
let totalPrice =0

// Thêm sự kiện cho từng nút kích thước
sizeButtons.forEach(button => {
    button.addEventListener('click', function() {
        const selectedPrice = parseFloat(this.getAttribute('data-price')); // Lấy giá kích thước
        priceDisplay.innerText = selectedPrice + " VNĐ"; // Hiển thị giá mới
        selectedSizeInput.value = this.getAttribute('data-size'); // Cập nhật size vào input ẩn

        // Cập nhật tên sản phẩm đã chọn
        selectedProductDisplay.innerText = productName; // Cập nhật tên sản phẩm

        // Cập nhật kích thước đã chọn
        const selectedSize = this.getAttribute('data-size'); // Lấy kích thước từ data-size
        selectedSizeDisplay.innerText = selectedSize;

        // Cập nhật giá cơ bản
        basePrice = selectedPrice;

        // Cập nhật tổng giá dựa trên số lượng
        updateTotalPrice();

        // Xóa lớp active ở tất cả các nút
        sizeButtons.forEach(btn => btn.classList.remove('active'));
        this.classList.add('active'); // Thêm lớp active vào nút đã chọn
    });
});



// Lấy tất cả các nút topping
const toppingButtons = document.querySelectorAll('.topping-button');

// Thêm sự kiện click cho mỗi nút topping
toppingButtons.forEach(button => {
    button.addEventListener('click', function() {
        const toppingPriceValue = parseFloat(this.getAttribute('topping-price')); // Lấy giá topping
        const toppingName = this.getAttribute('topping-name'); // Lấy tên topping
        const quantityInput = this.previousElementSibling; // Lấy input số lượng

        const quantity = parseInt(quantityInput.value) || 0; // Lấy số lượng, mặc định là 0 nếu không hợp lệ

        // Kiểm tra số lượng
        if (quantity > 0) {
            // Cập nhật giá topping
            toppingPrice += toppingPriceValue * quantity; // Cộng dồn giá topping

            // Cập nhật danh sách topping đã chọn
            const currentToppings = selectedToppingsDisplay.innerText === "Chưa chọn" ? "" : selectedToppingsDisplay.innerText + ", ";
            selectedToppingsDisplay.innerText = currentToppings + toppingName + " (x" + quantity + ")";

            // Cập nhật giá topping
            toppingPriceDisplay.innerText = toppingPrice + " VNĐ";

            // Cập nhật tổng giá
            updateTotalPrice();
            
            // Reset lại số lượng sau khi chọn
            quantityInput.value = 0; // Đặt lại giá trị input về 0
        } else {
            alert("Vui lòng chọn số lượng lớn hơn 0."); // Thông báo nếu số lượng không hợp lệ
        }
    });
});

// Hàm cập nhật tổng tiền
function updateTotalPrice() {
    totalPrice = basePrice + toppingPrice; // Tính tổng giá
    totalPriceDisplay.innerText = totalPrice + " VNĐ"; // Cập nhật tổng tiền
}
// Cập nhật tổng tiền khi số lượng thay đổi
quantityInput.addEventListener('input', updateTotalPrice);
</script>
</body>
</html>
