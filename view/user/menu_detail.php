
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quick View</title>

    <!-- Font Awesome CDN link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- Custom CSS file link -->
    <link rel="stylesheet" href="public/css/style.css">
</head>

<body>

    <section class="quick-view">
        <h1 class="title">MENU</h1>

        <?php if ($product): ?>
        <div class="product-and-toppings" style="display: flex; gap: 20px;">
            <form action="index_home.php?controller=cart&action=add" method="post" class="box product-form" onsubmit="setTotalPrice()">
                <input type="hidden" name="pid" value="<?= $product['id_sanpham']; ?>">
                <input type="hidden" name="name" value="<?= $product['tenSP']; ?>">
                <input type="hidden" id="selected_size" name="size" value="M">
                <input type="hidden" id="price_input" name="price" value="0">
                <input type="hidden" name="image" value="<?= $product['hinh_anh']; ?>">

                <img src="public/images/<?= $product['hinh_anh']; ?>" alt="<?= $product['tenSP']; ?>">
                <div class="name"><?= $product['tenSP']; ?></div>

                <div class="sizes">
                    <button type="button" class="size-btn <?= empty($product['gia_S']) ? 'disabled' : ''; ?>"
                        data-size="S" data-price="<?= $product['gia_S']; ?>"
                        <?= empty($product['gia_S']) ? 'disabled' : ''; ?>>Size S</button>
                    <button type="button" class="size-btn <?= empty($product['gia_M']) ? 'disabled' : ''; ?>"
                        data-size="M" data-price="<?= $product['gia_M']; ?>"
                        <?= empty($product['gia_M']) ? 'disabled' : ''; ?>>Size M</button>
                    <button type="button" class="size-btn <?= empty($product['gia_L']) ? 'disabled' : ''; ?>"
                        data-size="L" data-price="<?= $product['gia_L']; ?>"
                        <?= empty($product['gia_L']) ? 'disabled' : ''; ?>>Size L</button>
                </div>

                <div class="flex">
                    <div class="price"><span>VND </span><span id="price_display">0</span></div>
                    <input type="number" name="qty" class="qty" min="1" max="99" value="1">
                </div>

                <div class="selected-toppings">
                    <h3>Toppings Selected:</h3>
                    <ul id="topping-list"></ul>
                    <input type="hidden" name="toppings" id="toppings-input" value="">
                </div>
                <input type="hidden" name="total_price" id="total_price" value="0">
                <div class="total-price" style="margin-top: 10px;">
                    <strong>Total: </strong><span id="total_display">0</span> VND
                </div>

                <button type="submit" name="add_to_cart" class="cart-btn">Add to Cart</button>
            </form>

            <form action="" method="post" class="box toppings-form">
                <h3>Topping</h3>
                <div class="topping-grid">
                    <?php if ($toppings): ?>
                        <?php foreach ($toppings as $topping): ?>
                        <div class="topping-item">
                            <img src="public/images/<?= $topping['hinh_anh']; ?>" alt="<?= $topping['tenSP']; ?>" class="topping-img">
                            <div class="topping-info">
                                <input type="checkbox" name="topping[]" value="<?= $topping['id_sanpham']; ?>"
                                    id="topping-<?= $topping['id_sanpham']; ?>" data-price="11000">
                                <label for="topping-<?= $topping['id_sanpham']; ?>"><?= $topping['tenSP']; ?> (+ 11,000)</label>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No toppings available.</p>
                    <?php endif; ?>
                </div>
            </form>
        </div>
        <?php else: ?>
            <p class="empty">No products added yet!</p>
        <?php endif; ?>
    </section>

    <?php include 'view/user/footer.php'; ?>

    <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
    <script src="public/js/script.js"></script>
    <script>
        const sizeButtons = document.querySelectorAll('.size-btn');
        const priceDisplay = document.getElementById('price_display');
        const selectedSizeInput = document.getElementById('selected_size');
        const toppingCheckboxes = document.querySelectorAll('.topping-info input[type="checkbox"]');
        const toppingList = document.getElementById('topping-list');
        const toppingsInput = document.getElementById('toppings-input');
        const totalDisplay = document.getElementById('total_display');
        const quantityInput = document.querySelector('input[name="qty"]');

        let basePrice = 0; // Giá cơ bản (giá sản phẩm)
        let toppingPrice = 0; // Giá topping

        sizeButtons.forEach(button => {
            button.addEventListener('click', function() {
                const selectedPrice = parseFloat(this.getAttribute('data-price')); // Lấy giá kích thước
                priceDisplay.textContent = selectedPrice; // Hiển thị giá mới
                selectedSizeInput.value = this.getAttribute('data-size'); // Cập nhật size vào input ẩn

                // Cập nhật giá cơ bản
                basePrice = selectedPrice;

                // Cập nhật tổng giá dựa trên số lượng
                updateTotalPrice();

                sizeButtons.forEach(btn => {
                    btn.classList.remove('active'); // Xóa lớp active ở tất cả các nút
                });
                this.classList.add('active'); // Thêm lớp active vào nút đã chọn
            });
        });

        // Cập nhật giá khi chọn topping
        toppingCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const toppingPriceValue = parseFloat(this.getAttribute('data-price')); // Giá topping
                const toppingName = this.nextElementSibling.innerText.split(' (+ ')[0]; // Tên topping

                if (this.checked) {
                    toppingPrice += toppingPriceValue; // Nếu topping được chọn, cộng giá topping

                    // Thêm topping vào danh sách
                    const li = document.createElement('li');
                    li.textContent = `${toppingName} (+ ${toppingPriceValue} VND)`; // Cập nhật thêm giá topping
                    toppingList.appendChild(li);
                } else {
                    toppingPrice -= toppingPriceValue; // Nếu topping bị bỏ chọn, trừ giá topping

                    // Loại bỏ topping khỏi danh sách
                    const items = Array.from(toppingList.children);
                    const toppingIndex = items.findIndex(item => item.textContent.startsWith(toppingName));
                    if (toppingIndex !== -1) {
                        toppingList.removeChild(items[toppingIndex]);
                    }
                }

                // Cập nhật tổng giá sau khi thay đổi topping
                updateTotalPrice();
                toppingsInput.value = Array.from(toppingList.children).map(item => item.textContent).join(', ');
            });
        });

        // Cập nhật tổng tiền dựa trên số lượng và giá cơ bản
        function updateTotalPrice() {
            const quantity = parseInt(quantityInput.value) || 1; // Lấy giá trị số lượng, mặc định là 1 nếu không hợp lệ
            const totalPrice = ((basePrice + toppingPrice) * quantity).toFixed(0); // Tính tổng giá (giá sản phẩm * số lượng + giá topping)
            totalDisplay.textContent = totalPrice; // Cập nhật tổng tiền
        }

        // Cập nhật tổng tiền khi số lượng thay đổi
        quantityInput.addEventListener('input', updateTotalPrice);
        function setTotalPrice() {
            // Lấy giá trị từ span
            const totalDisplayValue = parseFloat(totalDisplay.textContent) || 0; // Lấy nội dung của span
            // Cập nhật trường ẩn trước khi gửi form
            document.getElementById('total_price').value = totalDisplayValue; // Gán giá trị cho trường ẩn
        }

    </script>

</body>
</html>
