<?php

if (isset($messages)) {
    foreach ($messages as $message) {
        echo '
        <div class="message">
            <span>' . $message . '</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
        </div>
        ';
    }
}
?>

<header class="header">
    <section class="flex">
        <a href="index_home.php?controller=home&action=home" class="logo"><img src='public/images/icon/title.png' width="120" height="40"></a>

        <nav class="navbar">
            <a href="index_home.php?controller=home&action=home">Trang chủ</a>
            <a href="view/user/about.php">Giới thiệu</a>
            <a href="index_home.php?controller=menu&action=view">Thực đơn</a>
            <a href="index_home.php?controller=menu&action=view">Tin tức</a>
        </nav>

        <div class="icons">
            <a href="search.php"><i class="fas fa-search"></i></a>
            <a href="index_home.php?controller=cart&action=view"><i class="fas fa-shopping-cart"></i><span>(<?= isset($total_cart_items) ? $total_cart_items : 0; ?>)</span></a>
            <div id="user-btn" class="fas fa-user"></div>
            <div id="menu-btn" class="fas fa-bars"></div>
        </div>

        <div class="profile">
            <?php if ($profile): ?>
                <p class="name"><?= $profile['hoten']; ?></p>
                <div class="flex">
                    <a href="index_home.php?controller=Profile&action=update" class="btn">profile</a>
                    <a href="index_home.php?controller=login&action=logout" onclick="return confirm('logout from this website?');" class="delete-btn">logout</a>
                </div>
            <?php else: ?>
                <p class="name">please login first!</p>
                <a href="index_home.php?controller=login&action=loginForm" class="btn">login</a>
            <?php endif; ?>
        </div>
    </section>
</header>
