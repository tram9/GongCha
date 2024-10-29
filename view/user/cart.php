<!DOCTYPE html>
<html lang="en">

<head>
    <title>Giỏ hàng</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="public/css/style.css">  
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
      

    <style>
    .table-responsive {
        max-height: 300px;
        /* Chiều cao cố định của bảng */
        overflow-y: auto;
        /* Hiển thị thanh cuộn dọc nếu nội dung vượt quá chiều cao */
    }

    /* Làm tiêu đề cố định */
    thead th {
        position: sticky;
        top: 0;
        background-color: #fff;
        /* Màu nền cho tiêu đề để không bị trong suốt */
        z-index: 10;
        /* Đảm bảo tiêu đề ở trên cùng */
    }

    .btn-container {
        text-align: right;
        /* Căn chỉnh nút sang bên phải */
        margin-top: 10px;
        /* Thêm khoảng cách phía trên nút */
    }
    </style>
</head>

<body>

    <div class="container">
        <h2>Giỏ hàng</h2>

        

        <!-- <a href="index.php?controller=menu&action=detail" class="btn btn-primary">Quay về Menu</a> -->
        <br>
        <br>
        <form action="./checkout" method="post">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <!-- <th>Product ID</th> -->
                            <th>Hình ảnh</th>
                            <th>Tên sản phẩm</th>
                            <th>Size</th>
                            <th>Số lượng</th>
                            <th>Topping</th>
                            <th>Giá</th>
                            <th>Hành động</th>
                            <!-- <th>
                                <input type="checkbox" id="select_all">
                            </th> -->
                        </tr>
                    </thead>
                    <tbody>

                        <?php foreach ($cartItems as $item): 
                        ?>
                        <tr>
                            <td>
                                <img src="public/images/<?php echo $item['hinh_anh']; ?>"
                                    alt="<?php echo $item['tenSP']; ?>" class="product-image"
                                    style="width: 50px; height: auto;">
                            </td>
                            <td><?php echo $item['tenSP']; ?></td>
                            <td><?php echo $item['size']; ?></td>
                            <td>
                                <form action="index.php?controller=cart&action=update" method="post" >
                                    <input type="hidden" name="cart_id" value="<?php echo $item['id']; ?>">
                                    <input type="number" name="quantity" min="1"
                                        value="<?php echo $item['quantity']; ?>">
                                    <button type="submit" name="update_cart">Cập nhật</button>
                                </form>
                            </td>
                            <td>
                            <?php
                            // Giả sử topping được lưu dưới dạng chuỗi phân cách bởi dấu phẩy
                            $toppings = explode(',', $item['toppings']);
                            
                            // Hiển thị mỗi topping trên một dòng
                            foreach ($toppings as $topping) {
                                echo $topping . "<br>";
                            }
                            ?>
                            </td>
                            <td><?php echo $item['price']; ?> VND</td>
                            <td>
                                <a href="index.php?controller=cart&action=delete&id=<?php echo $item['id']; ?>"
                                    class="btn btn-info">Xóa</a>
                                <a href="view/user/menu_detail.php?id=<?php echo $item['product_id']; ?>"
                                    class="btn btn-info">Xem chi tiết</a>

                            </td>
                            <!-- <td>
                                <input type="checkbox" name="selected_products[]" value="<?php echo $item['id']; ?>"
                                    class="product_checkbox">
                            </td> -->
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <br>
            </div>
            <div class="btn-container">
                <button type="submit" class="btn btn-success">Mua hàng đã chọn</button>
            </div>

        </form>
        <a href="view/user/home.php?id=<?php echo $item['product_id']; ?>" class="btn btn-info">Tiếp tục mua</a>


    </div>
    <script src="public/js/script.js"></script>

    <script>
    $(document).ready(function() {
        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myTable tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
        $("#select_all").click(function() {
            // Nếu checkbox chọn tất cả được chọn
            if ($(this).is(":checked")) {
                $(".product_checkbox").prop("checked", true); // Đánh dấu tất cả checkbox
            } else {
                $(".product_checkbox").prop("checked", false); // Bỏ chọn tất cả checkbox
            }
        });
    });
    </script>
</body>

</html>