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

        th,
        td {
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

        .customer-info,
        .shipping-info {
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

        th,
        td {
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
            margin-right: 5px;
            /* Khoảng cách giữa liên kết và tiêu đề */
            text-decoration: none;
            /* Bỏ gạch chân */
            color: black;
            /* Màu chữ cho liên kết */
            font-size: 14px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <?php //include './header.php'; 
    ?>
    <?php require_once 'header.php'; ?>
    <section class="order">
        <div style='font-size: 14px;'>
            <a href="http://localhost/GongCha/orderadmin" class="back-link">Đơn hàng</a>>> Chi tiết <?= $data['orderCommon']['id_DatHang'] ?>
        </div>
        <h2>Chi tiết đơn hàng</h2>

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
                $formattedDate = $date->format('d/m/Y H:i:s'); ?>
                <p>Ngày đặt: <?= $formattedDate; ?></p>
                <p>Trạng thái:
                    <select name="tinhTrang" id="selected">
                        <option value="Đang giao" <?= $data['orderCommon']['tinhTrang'] == 'Đang giao' ? 'selected' : '' ?>>Đang giao</option>
                        <option value="Đã giao" <?= $data['orderCommon']['tinhTrang'] == 'Đã giao' ? 'selected' : '' ?>>Đã giao</option>
                    </select>
                    <button type="submit" id="buttonUpdate">Cập nhật</button>
                </p>
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
                <?php $stt = 1; ?>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#buttonUpdate').on('click', function(event) {
            event.preventDefault();

            const orderId = <?= json_encode($data['orderCommon']['id_DatHang']); ?>;
            const newStatus = $('#selected').val();

            $.ajax({
                url: 'http://localhost/GongCha/orderadmin/action',
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'updateStatus',
                    orderId: orderId,
                    status: newStatus
                },
                success: function(response) {
                    window.location.href = "http://localhost/GongCha/orderadmin";
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                    alert('Có lỗi xảy ra khi cập nhật trạng thái.');
                }
            });
        });
    });
</script>

</section>