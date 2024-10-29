<?php
date_default_timezone_set('Asia/Ho_Chi_Minh'); 
// $vnp_TmnCode = "10PDMKDB"; 
// $vnp_HashSecret = "XQ715JX17ERO040AQV9OLC23NW7DHKF1"; 
$vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
// $vnp_Returnurl = "http://localhost/web36Z/camon.php";
$vnp_apiUrl = "http://sandbox.vnpayment.vn/merchant_webapi/merchant.html";
$apiUrl = "https://sandbox.vnpayment.vn/merchant_webapi/api/transaction";
$startTime = date("YmdHis");
$expire = date('YmdHis',strtotime('+15 minutes',strtotime($startTime)));
