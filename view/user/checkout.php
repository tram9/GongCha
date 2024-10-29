<!DOCTYPE html>
<html lang="zxx">

<head>
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
    <title>GongCha</title>

    <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="././public/css/style.css">
</head>
<style>
</style>
<body>
<?php require_once 'header.php'; ?>
<section class="checkout">
    <form id="checkout-form" action="http://localhost/GongCha/checkout/postCheckout" method="POST" >
    <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h5 class="coupon__code" style="color: orange;"><span class="icon_tag_alt"></span><b>Freeship for all orders</b></h5>
                    <h6 class="checkout__title">Billing Details</h6>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="checkout__input" style="color: black;">
                                <p>Tên người nhận<span>*</span></p>
                                <input type="text" id="name" name="name" required maxlength="50">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="checkout__input" style="color: black;">
                                <p>Số điện thoại<span>*</span></p>
                                <input type="tel" id="phone" name="phone" pattern="\d{10}" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)" required onfocus="showIcon()">
                                <span class="validation-icon"></span>
                            </div>
                        </div>
                    </div>
                    <div class="checkout__input">
                        <div class="form-group">
                            <p>Quận/Huyện<span>*</span></p>
                            <select class="form-control" id="city" name="city" required>
                                <option value="" class="holder" disabled selected hidden>Chọn Quận/Huyện</option>
                                <option value="Thanh Xuân">Thanh Xuân</option>
                                <option value="Ba Đình">Ba Đình</option>
                                <option value="Cầu Giấy">Cầu Giấy</option>
                                <option value="Hai Bà Trưng">Hai Bà Trưng</option>
                                <option value="Hoàn Kiếm">Hoàn Kiếm</option>
                                <option value="Hoàng Mai">Hoàng Mai</option>
                                <option value="Long Biên">Long Biên</option>
                                <option value="Hà Đông">Hà Đông</option>
                                <option value="Tây Hồ">Tây Hồ</option>
                                <option value="Nam Từ Liêm">Nam Từ Liêm</option>
                                <option value="Bắc Từ Liêm">Bắc Từ Liêm</option>
                                <option value="Đống Đa">Đống Đa</option>
                            </select>
                        </div>
                    </div>
                    <div class="checkout__input" style="color: black;">
                        <p>Địa chỉ<span>*</span></p>
                        <input type="text" placeholder="Street" class="checkout__input__add" id="address" name="address" required maxlength="100">
                    </div>
                    <div class="checkout__input">
                        <p>Ghi chú</p>
                        <input type="text" placeholder="Notes about your order, e.g. special notes for delivery." id="note" name="note">
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="checkout__order">
                        <!-- <form id="payment-form" method="POST" target="_blank" enctype="application/x-www-form-urlencoded"> -->
                            <h4 class="order__title" style="text-align:center;">Đơn hàng</h4>
                            <div class="">
                                <table>
                                    <thead class="order_user">
                                        <tr>
                                            <th>Ảnh</th>
                                            <th>Sản phẩm</th>
                                            <th>Toppings</th>
                                            <th>Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php $total=0;
                                        $quantity=0; ?>
                                    <?php foreach ($data['allCart'] as $order): ?>
                                        <tr class ="order-row user">
                                            <td>
                                                <div>
                                                    <!-- <input type="hidden" name="status" value="0"> -->
                                                    <img src="././public/images/<?= $order['hinh_anh']; ?>" width=50 alt="ảnh nước hoa">
                                                </div>
                                            </td>
                                            <td><h6><?=$order['tenSP']?> x <?=$order['quantity']?> x <?=$order['size'] ?></h6></td>
                                            <td ><?=$order['toppings'] ?></td>
                                            <td><?=number_format($order['price'], 0, ',', ',')?></td>
                                            <?php 
                                                $total+= $order['price'];
                                                $quantity+=$order['quantity'];
                                            ?>
                                        </tr>
                                    <?php endforeach; ?>

                                        <tr style= "text-align: left; font-weight: bold; font-size: 14px; margin: 20px;">
                                            <div>
                                                <td colspan='3'><div style="margin: 10px 0px;">Tổng sản phẩm</div></td>
                                                <td class="quantity"><?=$quantity?></td>
                                            </div>
                                        </tr>
                                        <tr style= "text-align: left; font-weight: bold; font-size: 14px; margin: 20px;">
                                            <td colspan='3'><b><div style="margin: 10px 0px;">Tổng tiền</div></b></td>
                                            <td class="quantity"><?=number_format($total, 0, ',', ',')?></td>
                                            <input type="hidden" name="total" value="<?= $total; ?>">
                                        </tr>
                                        <tr>
                                            <td colspan='3'>
                                                <p>Phương thức thanh toán</p>
                                                <div class="radio-option">
                                                    <input type="radio" id="qr" name="payment" value="cod" required hidden>
                                                    <label for="vnpay_qr">
                                                        <!-- <i class="fas fa-qrcode icon"></i> <span>Quét mã QR</span> -->
                                                    </label>
                                                </div>
                                                <div class="radio-option">
                                                    <input type="radio" id="atm" name="payment" value="vnpay" required>
                                                    <label for="vnpay_atm">
                                                        <i class="fas fa-money-check-alt icon"></i> <span> Thẻ tín dụng/Ghi nợ (VNPAY)</span>
                                                    </label>
                                                </div>
                                               
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <button type="submit" id="placeOrderBtn" class="site-btn" name="place_order">ĐẶT HÀNG</button>
                            <!-- <button type="submit" id="placeOrderBtn" class="site-btn" name="place_order" onclick="submitPaymentForm()">PLACE ORDER</button> -->
                        <!-- </form> -->
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<script>

// function submitPaymentForm() {
//     const form = document.getElementById('checkout-form');
//     const selectedPaymentMethod = form.payment_method.value;
//         if (selectedPaymentMethod) {
//             if (selectedPaymentMethod === 'Quét mã QR (Ví MoMo)') {
//                 form.action = "../user/menu.php";
//             } else if (selectedPaymentMethod === 'Thanh toán momo ATM') {
//                 form.action = "../user/home.php";
//             }
//             console.log("Form action:", form.action);
//             form.submit();
//         }
// }

function showIcon() {
    const validationIcon = document.querySelector('.validation-icon');
    validationIcon.style.display = 'inline';
}
// // place holder
// $(document).ready(function () {
//         $('#submit-btn').on('click', function () {
//             // Lấy dữ liệu từ form
//             const data = {
//                 name: $('#name').val(),
//                 phone: $('#phone').val(),
//                 city: $('#city').val(),
//                 address: $('#address').val(),
//                 note: $('#note').val(),
//                 payment_method: $('#momo_qr:checked').length ? $('#momo_qr').val() : $('#momo_atm').val()
//             };

//             // Gửi dữ liệu đến controller bằng AJAX
//             $.ajax({
//                 type: 'POST',
//                 url: 'checkout/postCheckout', // Thay đổi đường dẫn đến controller của bạn
//                 data: data,
//                 success: function (response) {
//                     // Xử lý phản hồi thành công
//                     alert('Đặt hàng thành công: ' + response);
//                 },
//                 error: function (xhr, status, error) {
//                     // Xử lý lỗi
//                     alert('Có lỗi xảy ra: ' + xhr.responseText);
//                 }
//             });
//         });
//     });

</script>
