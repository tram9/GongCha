<?php
$user_id = $_SESSION['user_id'] ?? '';
?>
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
    <link rel="stylesheet" href="././public/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="././public/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="././public/css/style-thao.css" type="text/css">
    <title>GongCha</title>

    <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="././public/css/style.css">
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
        th {
            background-color: #f2f2f2;
        }
        .total-row {
            background-color: #e9e9e9;
            font-weight: bold;
        }
        .order-row {
            cursor: pointer;
        }
        .order-row:hover {
            background-color: #f9f9f9;
        }
       
    </style>
</head>
<body>
<?php require_once 'header.php'; ?>
<section class="order">
    <!-- Tabs -->
    <div class="tabs">
        <div class="tab-item active" data-target="#all-orders">Tất cả đơn</div>
        <div class="tab-item" data-target="#delivering-orders">Đang giao</div>
        <div class="tab-item" data-target="#delivered-orders">Đã giao</div>
    </div>

 <!-- Nội dung tab -->
    <div id="all-orders" class="tab-content active">
        <h3>Tất cả đơn</h3>
        <table>
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Mã đơn hàng</th>
                    <th>Ngày đặt</th>
                    <th>Tổng tiền</th>
                    <th>Phương thức thanh toán</th>
                    <th>Ghi chú</th>
                    <th>Trạng thái</th>
                    <th>Chi tiết</th>

                </tr>
            </thead>
            <tbody>
                <?php $stt =1; ?>
                <?php foreach ($data['allOrders'] as $order): ?>
                    <tr class="order-row" onclick= "openOrderDetails('<?= $order['id_DatHang']?>')">
                        <td rowspan="1"><?= $stt++ ?></td> 
                        <td><?= $order['id_DatHang']; ?></td>
                        <?php $date = new DateTime($order['ngayDat']);
                        $formattedDate = $date->format('d/m/Y H:i:s');?>
                        <td><?=$formattedDate?></td>
                        <td><?php echo number_format($order['tongTien'], 0, ',', ',') ?></td>
                        <td><?= $order['phuongThuc']; ?></td>
                        <td><?= $order['ghiChu']; ?></td>
                        <td rowspan="1"><?php echo $order['tinhTrang'];?></td>
                        <td><a href="./order/orderDetail/<?= $order['id_DatHang']?>" ><i class="fa-solid fa-circle-info" title="Chi tiết"></i></a></td>
                    </tr>
                    <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php
?>
    <div id="delivering-orders" class="tab-content">
        <h3>Đang giao</h3>
        <table>
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Mã đơn hàng</th>
                    <th>Ngày đặt</th>
                    <th>Tổng tiền</th>
                    <th>Phương thức thanh toán</th>
                    <th>Ghi chú</th>
                    <th>Trạng thái</th>
                    <th>Chi tiết</th>
                </tr>
            </thead>
            <tbody>
            <?php $stt=1 ?>
            <?php foreach ($data['deliveringOrders'] as $order): ?>
                <tr class="order-row" onclick= "openOrderDetails('<?=$order['id_DatHang'] ?>')">
                    <td rowspan="1"><?= $stt++; ?></td> 
                    <td><?= $order['id_DatHang']; ?></td>
                    <?php $date = new DateTime($order['ngayDat']);
                    $formattedDate = $date->format('d/m/Y H:i:s');?>
                    <td><?= $formattedDate ?></td>
                    <td><?php echo number_format($order['tongTien'], 0, ',', ',') ?></td>
                    <td><?= $order['phuongThuc']; ?></td>
                    <td><?= $order['ghiChu']; ?></td>
                    <td ><?php echo $order['tinhTrang'];?></td>
                    <td><a href="./order/orderDetail/<?= $order['id_DatHang']?>" ><i class="fa-solid fa-circle-info" title="Chi tiết"></i></a></td>

                </tr>
            
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div id="delivered-orders" class="tab-content">
        <h3>Đã giao</h3>
        <table>
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Mã đơn hàng</th>
                    <th>Ngày đặt</th>
                    <th>Tổng tiền</th>
                    <th>Phương thức thanh toán</th>
                    <th>Ghi chú</th>
                    <th>Trạng thái</th>
                    <th>Chi tiết</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($data['shippedOrders'] as $order): ?>
                <tr class="order-row" onclick= "openOrderDetails('<?=$order['id_DatHang'] ?>')">
                    <td rowspan="1"><?= $stt++; ?></td> 
                    <td><?= $order['id_DatHang']; ?></td>
                    <?php $date = new DateTime($order['ngayDat']);
                    $formattedDate = $date->format('d/m/Y H:i:s');?>
                    <td><?= $formattedDate ?></td>
                    <td><?php echo number_format($order['tongTien'], 0, ',', ',') ?></td>
                    <td><?= $order['phuongThuc']; ?></td>
                    <td><?= $order['ghiChu']; ?></td>
                    <td><?php echo $order['tinhTrang'] ?></td>
                    <td><a href="./order/orderDetail/<?= $order['id_DatHang']?>" ><i class="fa-solid fa-circle-info" title="Chi tiết"></i></a></td>

                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script>
        // JavaScript cho chức năng chuyển tab
        const tabs = document.querySelectorAll('.tab-item');
        const contents = document.querySelectorAll('.tab-content');

        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                // Bỏ kích hoạt tab hiện tại
                tabs.forEach(item => item.classList.remove('active'));
                contents.forEach(content => content.classList.remove('active'));
                // Kích hoạt tab mới
                tab.classList.add('active');
                const target = document.querySelector(tab.getAttribute('data-target'));
                target.classList.add('active');
            });
        });
        function openOrderDetails(orderId) {
            window.location.href = './order/orderDetail/' + orderId; 
        }
    </script>
</section>
</body>
</html>



