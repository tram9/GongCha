<?php if(isset($message)): ?>
   <?php foreach($message as $msg): ?>
      <div class="message">
         <span><?= htmlspecialchars($msg); ?></span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
   <?php endforeach; ?>
<?php endif; ?>

<header class="header">
   <section class="flex">
      <a href="index.php?controller=dashboard&action=dashboard" class="logo"><img src="public/images/icon/title.png" width="120" height="40"></a>

      <nav class="navbar">
         <a href="index.php?controller=dashboard&action=dashboard">Trang chủ</a>
         <a href="index.php?controller=menu&action=listMenu">Thực đơn</a>
         <a href="orderAdmin">Đơn hàng</a>
         <a href="index.php?controller=Khach&action=index">Khách hàng</a>
         <a href="index.php?controller=Employee&action=listEmployees">Nhân viên</a>
         <a href="index.php?controller=khoHang&action=listProducts">Kho hàng</a>
         <a href="index.php?controller=News&action=index">Tin tức</a>
      </nav>

      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="user-btn" class="fas fa-user" onclick="toggleProfileMenu();"></div>
      </div>

      <div class="profile" id ="profile">
         <?php if ($employee): ?>
            <p><?= htmlspecialchars($employee['tenNV']); ?></p>
            <a href="update_profile.php" class="btn">update profile</a>
         <?php else: ?>
         <div class="flex-btn">
            <a href="index.php?controller=Login&action=loginForm" class="option-btn">login</a>
            <a href="register_admin.php" class="option-btn">register</a>
         </div>
         <?php endif; ?>
         <a href="index.php?controller=Login&action=logout" onclick="return confirm('logout from this website?');" class="delete-btn">logout</a>
      </div>
   </section>
   
</header>




