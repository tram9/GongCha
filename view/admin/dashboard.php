<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>TRANG QUẢN LÝ</title>

   <!-- Font Awesome CDN Link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Custom CSS file link -->
   <link rel="stylesheet" href="public/css/admin_style.css">
</head>
<body>
<!-- Admin dashboard section starts -->
<section class="dashboard">
   <h1 class="heading">dashboard</h1>

   <div class="box-container">

      <!-- Greeting Section -->
      <div class="box">
         <h3>Xin Chào!</h3>
         <p><?= $admin_name; ?></p>
         <a href="update_profile.php" class="btn">Cập nhật</a>
      </div>

      <!-- Pending Orders -->
      <div class="box">
         <h3>Đang giao</h3>
         <p><?= $total_pendings; ?><span> VND</span></p>
         <a href="orderAdmin" class="btn">Xem đơn hàng</a>
      </div>

      <!-- Completed Orders -->
      <div class="box">
         <h3>Hóa đơn</h3>
         <p><?= $total_invoice; ?></p>
         <a href="invoice" class="btn">Xem hóa đơn</a>
      </div>

      <!-- Number of Orders -->
      <div class="box">
         <h3>Số đơn</h3>
         <p><?= $order_count; ?></p>
         <a href="orderAdmin" class="btn">Xem đơn hàng</a>
      </div>

      <!-- News Articles -->
      <div class="box">
         <h3>Tin tức</h3>
         <p><?= $numbers_of_news; ?></p>
         <a href="index.php?controller=News&action=index" class="btn">Xem danh sách</a>
      </div>

      <!-- Menu Items -->
      <div class="box">
         <h3>Thực đơn</h3>
         <p><?= $numbers_of_products; ?></p>
         <a href="index.php?controller=menu&action=listMenu" class="btn">Xem thực đơn</a>
      </div>

      <!-- Number of Employees -->
      <div class="box">
         <h3>Nhân viên</h3>
         <p><?= $employee_count; ?></p>
         <a href="index.php?controller=Employee&action=listEmployees" class="btn">Xem danh sách</a>
      </div>

      <!-- Number of Admins -->
      <div class="box">
         <h3>Bán Hàng</h3>
         <p><?= $admin_count; ?></p>
         <a href="index.php?controller=sale&action=saleForm" class="btn">Xem danh sách</a>
      </div>

      <!-- Warehouse (Kho hàng) -->
      <div class="box">
         <h3>Kho hàng</h3>
         <p><?= $numbers_of_messages; ?></p>
         <a href="index.php?controller=khoHang&action=listProducts" class="btn">Xem kho</a>
      </div>

      <!-- Number of Customers -->
      <div class="box">
         <h3>Khách hàng</h3>
         <p><?= $numbers_of_customers; ?></p>
         <a href="index.php?controller=Khach&action=index" class="btn">Xem đơn hàng</a>
      </div>

   </div>

</section>
<!-- Admin dashboard section ends -->

<!-- Custom JS file link -->
<script src="public/js/script.js"></script>

</body>
</html>
