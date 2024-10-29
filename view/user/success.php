<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt hàng thành công</title>
    <meta charset="UTF-8">
    <meta name="description" content="Male_Fashion Template">
    <meta name="keywords" content="Male_Fashion, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&display=swap"
    rel="stylesheet">
    <!-- Css Styles -->
    <link rel="stylesheet" href="././public/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="././public/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="././public/css/style-thao.css" type="text/css">
    <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- custom css file link  -->
    <link rel="stylesheet" href="../../public/css/style.css">
</head>
 <style>
    .payment {
    display: flex;
    flex-direction: column;  /* Sắp xếp các phần tử theo cột */
    justify-content: center; /* Căn giữa theo chiều dọc */
    align-items: center;     /* Căn giữa theo chiều ngang */
    min-height: 100vh;       /* Chiều cao tối thiểu bằng chiều cao toàn trang */
    text-align: center;      /* Căn giữa nội dung văn bản */
    font-size: 16px;
}

.success, .payment-top-wrap {
    max-width: 800px; /* Đặt chiều rộng tối đa nếu cần */
    padding: 20px;    /* Khoảng cách xung quanh nội dung */
}
.success-title {
    font-size: 2em; /* Tăng kích thước chữ */
    font-weight: bold; /* In đậm */
    color: #378000; /* Đổi màu cho nổi bật hơn nếu muốn */
    margin-bottom: 20px; /* Khoảng cách phía dưới */
}
.success-button a button {
    padding: 12px 24px; /* Kích thước nút */
    font-size: 1em; /* Kích thước chữ */
    border: none;
    border-radius: 5px; /* Bo góc cho nút */
    cursor: pointer;
    transition: background-color 0.3s, transform 0.3s;
    margin: 10px; /* Khoảng cách giữa các nút */
}

/* Nút "XEM CHI TIẾT ĐƠN HÀNG" */
.btn-detail {
    background-color: #378000; /* Màu nền */
    color: #fff; /* Màu chữ */
}

.btn-detail:hover {
    background-color: #2c6c00; /* Đổi màu nền khi hover */
    transform: scale(1.05); /* Tăng kích thước nhẹ khi hover */
}

/* Nút "TIẾP TỤC MUA SẮM" */
.btn-continue {
    background-color: #f58634; /* Màu nền */
    color: #fff; /* Màu chữ */
}

.btn-continue:hover {
    background-color: #d47429; /* Đổi màu nền khi hover */
    transform: scale(1.05); /* Tăng kích thước nhẹ khi hover */
}
 </style>
<body>

</body>

</html>
<?php require_once 'header.php'; ?>
<section class="payment">
   
    <section class="success">
        <div class="success-top">
            <p class="success-title">ĐẶT HÀNG THÀNH CÔNG </p>
        </div>

        <div class="success-text">

        
        <span style="font-weight: bold;">Đơn hàng của quý khách sẽ giao nhanh trong 30 phút. Rất mong quý khách chú ý điện thoại !</span><br>
        <span style="color: red;">(Lưu ý:  Đơn hàng được xử lý tự động và sẽ giao cho bạn trong thời sớm nhất)</span><br> Cảm ơn <span style="font-size: 20px; color: #378000;"><?php //echo $results['ten'] 
                                                                                                                                                                                        ?></span> đã tin dùng
        sản phẩm của GongCha.
    


        </div>

        <div class="success-button">
            <?php $orderId = $data['orderId']; ?>
            <a href="http://localhost/GongCha/order/orderDetail/<?= $orderId;?>"><button class="btn-detail">XEM CHI TIẾT ĐƠN HÀNG</button></a>
            <a href=""><button class="btn-continue">TIẾP TỤC MUA SẮM</button></a>
        </div>
        <p class="detail-footer">Mọi thắc mắc quý khách vui lòng liên hệ hotline <span style="font-size: 20px; color: red;">0985 824 745 </span> </p>
    </section>
</section>


<?php
// include "footer.php";
?>