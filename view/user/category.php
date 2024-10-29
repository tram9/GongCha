<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Category</title>

   <!-- Font Awesome CDN link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Custom CSS file link -->
   <link rel="stylesheet" href="public/css/style.css">
</head>
<body>


<section class="products">
   <h1 class="title">Food Category</h1>

   <div class="box-container">
      <?php if (!empty($products)): ?>
         <?php foreach ($products as $product): ?>
         <form action="" method="post" class="box">
            <input type="hidden" name="pid" value="<?= $product['id_sanpham']; ?>">
            <input type="hidden" name="name" value="<?= $product['tenSP']; ?>">
            <input type="hidden" name="price" value="<?= $product['gia_M']; ?>">
            <input type="hidden" name="image" value="<?= $product['hinh_anh']; ?>">
            <a href="menu_detail.php?id=<?= $product['id_sanpham']; ?>" class="fas fa-eye"></a>
            <button type="submit" class="fas fa-shopping-cart" name="add_to_cart"></button>
            <img src="public/images/<?= $product['hinh_anh']; ?>" alt="">
            <a href="category.php?category=<?= $product['id_danhmuc']; ?>" class="cat"><?= $product['id_danhmuc']; ?></a>
            <div class="name"><?= $product['tenSP']; ?></div>
            <div class="flex">
               <div class="price"><span>$</span><?= $product['gia_M']; ?></div>
               <input type="number" name="qty" class="qty" min="1" max="99" value="1" maxlength="2">
            </div>
         </form>
         <?php endforeach; ?>
      <?php else: ?>
         <p class="empty">No products added yet!</p>
      <?php endif; ?>
   </div>
</section>

<?php include './footer.php'; ?>

<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
<script src="public/js/script.js"></script>
</body>
</html>
