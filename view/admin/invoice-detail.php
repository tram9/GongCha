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
    <link rel="stylesheet" href="../../public/css/style copy.css" type="text/css">
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
        /* th {
            background-color: #f2f2f2;
        } */
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
        h2 {
            text-align: center;
            margin-bottom: 10px;
        }
        .info-container {
            display: flex;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            font-size: 14px;

        }
        .customer-info, .shipping-info {
            border: 1px solid #f0f0f0;
            padding: 15px;
            width: 50%; 
            background-color: #f9f9f9;
        }
        .info-title {
            font-weight: bold;
            margin-bottom: 10px;
            font-size: 16px;
        }
        /* Style cho bảng sản phẩm */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 8px;
            text-align: center;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        .total-row {
            background-color: #e9e9e9;
            font-weight: bold;
        }
        .details-link a {
            color: blue;
            text-decoration: none;
        }
        /* .details-link a:hover {
            text-decoration: underline;
        }  */
        .back-link {
            margin-right: 5px;    /* Khoảng cách giữa liên kết và tiêu đề */
            text-decoration: none;  /* Bỏ gạch chân */
            color: black;           /* Màu chữ cho liên kết */
            font-size: 14px;
            cursor: pointer; 
        }
        .product-container {
            display: flex;
            align-items: center; /* Căn giữa ảnh và tên sản phẩm theo chiều dọc */
        }

        .product-image {
            width: 50px; /* Kích thước cố định cho khối ảnh */
            margin-right: 5px;
            margin-left: 10px; 
        }

        .product-image img {
            width: 100%;
            height: auto;
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
        <a href="http://localhost/GongCha/invoice" class="back-link">Hóa đơn</a>>>  Chi tiết
    </div>
    <h2>Chi tiết hóa đơn</h2>
    
    <div class="info-container">
        <div class="customer-info">
            <!-- <div class="info-title">Địa chỉ nhận hàng</div> -->
            <p>Mã hóa đơn: <?= $data['invoiceCommon']['id_DatHang'] ?></p>
            <p>Tên KH: <?= $data['invoiceCommon']['tenKH'] ?></p>
            <p>Điện thoại: <?= $data['invoiceCommon']['sdt'] ?></p>
            <?php $date = new DateTime($data['invoiceCommon']['ngayDat']);
            $formattedDate = $date->format('d/m/Y H:i:s');?>
            <p>Thời gian: <?= $formattedDate ?></p>
        </div>

        <div class="shipping-info">
           
            <p>Trạng thái: <?= $data['invoiceCommon']['tinhTrang']; ?></p>
            <p>Phương thức thanh toán: <?= $data['invoiceCommon']['phuongThuc']; ?></p>
            <p>Người bán: </p>
            <p>Kênh bán: <?= $data['invoiceCommon']['loai'] ?></p>
        </div>

    </div>

    <!-- Bảng thông tin sản phẩm -->
    <table>
        <thead>
            <tr>
                <th>Mã sản phẩm</th>
                <th>Sản phẩm</th>
                <th>Số lượng</th>
                <th>Size</th>
                <th>Đơn giá</th>
                <th>Topping</th>
                <th>Thành tiền</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($data['invoiceDetail'] as $order): ?>
            <?php
            $size = $order['size']; // Kích thước được lấy từ order
            $price = 0; // Biến lưu giá
        
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
                <td><?= $order['id_sanpham'] ?></td>
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
                <td colspan="6" style="text-align: right;">Tổng tiền:</td>
                <td><?= number_format($data['invoiceCommon']['tongTien'], 0, ',', ',') ?></td>
            </tr>
            
        </tbody>
    </table>

</body>
</html>

</body>
</html>


</section>
