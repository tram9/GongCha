<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>menu</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="public/css/style.css">

</head>
<body>

<div class="heading">
   <h3>GongCha menu</h3>
   <p><a href="index_home.php?controller=home&action=home">home</a> <span> / menu</span></p>
</div>

<!-- menu section starts  -->

<section class="products">

   <h1 class="title">Thực đơn hiện tại</h1>

   <div class="box-container">

      <?php if (!empty($products)): ?>
         <?php foreach ($products as $fetch_products): ?>
      <form action="" method="post" class="box">
         <input type="hidden" name="pid" value="<?= $fetch_products['id_sanpham']; ?>">
         <input type="hidden" name="name" value="<?= $fetch_products['tenSP']; ?>">
         <input type="hidden" name="price" value="<?= $fetch_products['gia_M']; ?>">
         <input type="hidden" name="image" value="<?= $fetch_products['hinh_anh']; ?>">
         <a href="index_home.php?controller=menu&action=quickview&id=<?php echo $fetch_products['id_sanpham']; ?>" class="fas fa-eye"></a>
         <button type="submit" class="fas fa-shopping-cart" name="add_to_cart"></button>
         <img src="public/images/<?= $fetch_products['hinh_anh']; ?>" alt="">
         <a href="category.php?category=<?= $fetch_products['id_danhmuc']; ?>" class="cat"><?= $fetch_products['id_danhmuc']; ?></a>
         <div class="name"><?= $fetch_products['tenSP']; ?></div>
         <div class="flex">
            <div class="price"><span>$</span><?= $fetch_products['gia_M']; ?></div>
            <input type="number" name="qty" class="qty" min="1" max="99" value="1" maxlength="2">
         </div>
      </form>
         <?php endforeach; ?>
      <?php else: ?>
         <p class="empty">no products added yet!</p>
      <?php endif; ?>

   </div>

</section>

<!-- menu section ends -->

<!-- footer section starts  -->
<?php include 'view/user/footer.php'; ?>
<!-- footer section ends -->

<!-- custom js file link  -->
<script src="public/js/script.js"></script>


</body>
</html>
