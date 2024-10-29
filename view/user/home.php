<!-- views/home.php -->
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>GongCha</title>

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="public/css/style.css">
</head>
<body>


<section class="hero">
   <div class="swiper hero-slider">
      <div class="swiper-wrapper">
         <div class="swiper-slide slide">
            <div class="content">
               <span>welcome</span>
               <h3>GongCha</h3>
               <a href="menu.html" class="btn">see menus</a>
            </div>
            <div class="image">
               <img src="public/images/icon/logo3.png" alt="">
            </div>
         </div>
         <!-- Add additional slides here -->
      </div>
      <div class="swiper-pagination"></div>
   </div>
</section>

<section class="category">
    <h1 class="title">Sleep</h1>
    <div class="box-container">
      <?php
      //   $categoryController = new CategoryController();
      //   $categories = $categoryController->displayCategories();
        
        foreach ($categories as $category) {
            echo "<a href='index_home.php?controller=category&action=display&id={$category['id_danhmuc']}' class='box'>";
            echo "<h3>{$category['tenLoai']}</h3>";
            echo "</a>";
        }
        ?>
    </div>
</section>

<section class="products">
   <h1 class="title">Ice Cream</h1>
   <div class="box-container">
      <?php if (!empty($products)) {
         foreach ($products as $product) { ?>
            <form action="" method="post" class="box">
               <input type="hidden" name="pid" value="<?= $product['id_sanpham']; ?>">
               <input type="hidden" name="name" value="<?= $product['tenSP']; ?>">
               <input type="hidden" name="image" value="<?= $product['hinh_anh']; ?>">
               <a href="menu_detail.php?id=<?= $product['id_sanpham']; ?>" class="fas fa-eye"></a>
               <button type="submit" class="fas fa-shopping-cart" name="add_to_cart"></button>
               <img src="public/images/<?= $product['hinh_anh']; ?>" alt="">
               <div class="name"><?= $product['tenSP']; ?></div>
               <div class="flex">
                  <div class="price"><span>VND</span><?= $product['gia_M']; ?></div>
                  <input type="number" name="qty" class="qty" min="1" max="99" value="1" maxlength="2">
               </div>
            </form>
      <?php }
      } else { ?>
         <p class="empty">no products added yet!</p>
      <?php } ?>
   </div>
   <div class="more-btn">
      <a href="menu.php" class="btn">See menus</a>
   </div>
</section>

<?php include 'view/user/footer.php'; ?>

<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
<script src="public/js/script.js"></script>
<script>
   var swiper = new Swiper(".hero-slider", {
      loop:true,
      grabCursor: true,
      effect: "flip",
      pagination: {
         el: ".swiper-pagination",
         clickable:true,
      },
   });
</script>
</body>
</html>
