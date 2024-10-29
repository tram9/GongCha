<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&display=swap"
    rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="../../public/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="../../public/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="../../public/css/style-thao.css" type="text/css">
    <title>GongCha</title>

    <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="../../public/css/style.css">
    <style>
        /* Style cho bảng */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 14px;
        }
        th, td {
            padding: 8px;
            text-align: center;
            border: 1px solid #ddd;
        }
        .total-row {
            /* background-color: #e9e9e9; */
            font-weight: bold;
        }
        .order-row {
            cursor: pointer;
        }
        .order-row:hover {
            background-color: #f9f9f9;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h3 {
            text-align: center;
            margin-bottom: 10px;
        }
        .total-row {
            background-color: #e9e9e9;
            font-weight: bold;
        }
        .product-container {
            display: flex;
            align-items: center; /* Căn giữa ảnh và tên sản phẩm theo chiều dọc */
        }
        .product-name {
            flex-grow: 1; /* Để tên sản phẩm chiếm phần còn lại của không gian */
        }
        

    </style>
</head>
<body>
<?php //include './header.php'; ?>
<?php require_once 'header.php'; ?>
<section class="order">
    <div style='font-size: 14px;'>
        <a href="http://localhost/GongCha/order" class="back-link">Đơn hàng</a>>>  Chi tiết đơn <?= $data['orderCommon']['id_DatHang'] ?>
    </div>
    <h3>Chi tiết đơn hàng</h3>
    
    <div class="info-container">
        <div class="customer-info">
            <div class="info-title">Địa chỉ nhận hàng</div>
            <p>Tên KH: <?= $data['orderCommon']['tenKH'] ?></p>
            <p>Điện thoại: <?= $data['orderCommon']['sdt'] ?></p>
            <p>Địa chỉ: <?= $data['orderCommon']['diaChi'] ?></p>
        </div>

        <div class="shipping-info">
            <div class="info-title">Thông tin đơn hàng</div>
            <?php $date = new DateTime($data['orderCommon']['ngayDat']);
            $formattedDate = $date->format('d/m/Y H:i:s');?>
            <p>Ngày đặt: <?= $formattedDate; ?></p>
            <p>Trạng thái: <?= $data['orderCommon']['tinhTrang'] ?></p>
            <p>Phương thức thanh toán: <?= $data['orderCommon']['phuongThuc']; ?> -
                <?php if($data['payment']['status'] == 0) { ?>
                    <span class="payment-status pending">Chưa thanh toán</span>
                <?php } elseif($data['payment']['status'] == 1) { ?>
                    <span class="payment-status paid">Đã thanh toán</span>
                <?php } ?>
            </p>
        </div>
    </div>

    <!-- Bảng thông tin sản phẩm -->
    <table>
        <thead>
            <tr>
                <th>STT</th>
                <th>Sản phẩm</th>
                <th>Số lượng</th>
                <th>Size</th>
                <th>Đơn giá</th>
                <th>Topping</th>
                <th>Thành tiền</th>
            </tr>
        </thead>
        <tbody>
        <?php $stt =1; ?>
        <?php foreach ($data['orderDetail'] as $order): ?>
            <?php
                $size = $order['size']; 
                $price = 0; 
                // Kiểm tra kích thước và gán giá tương ứng
                if ($size == 'M') {
                    $price = $order['gia_M'];
                } elseif ($size == 'L') {
                    $price = $order['gia_L'];
                } elseif ($size == 'S') {
                    $price = $order['gia_S'];
                }
            ?>
            <tr>
                <td><?= $stt++; ?></td>
                <td>
                <div class="product-container">
                    <img src="../../public/images/<?= $order['hinh_anh']; ?>"
                        alt="Product Image" style="width: 50px; height: auto; margin-right: 10px;">
                    <?= $order['tenSP'] ?>
                </div>
                </td>
                <td><?php echo $order['soLuong']; ?></td>
                <td><?php echo $order['size']; ?></td>
                <td><?= number_format($price, 0, ',', ',') ?></td>
                <td><?= $order['toppings'] ?></td>
                <td><?= number_format($order['thanhTien'], 0, ',', ',') ?></td>
        <?php endforeach; ?>
            </tr>
            <tr style='font-weight: bold;'>
                <td colspan="6" style="text-align: right;">Tổng tiền đơn hàng:</td>
                <td><?= number_format($data['orderCommon']['tongTien'], 0, ',', ',') ?></td>
            </tr>
        </tbody>
    </table>

</body>
</html>

</body>
</html>


</section>
