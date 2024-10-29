<footer class="footer">

   <section class="grid">

      <div class="box">
         <h3>our email</h3>
         <a href="mailto:gongcha@gmail.com">gongcha@gmail.com</a>
      </div>

      <div class="box">
         <h3>opening hours</h3>
         <p>08:00am to 10:00pm</p>
      </div>

      <div class="box">
         <h3>our address</h3>
         <a href="#">Hà Nội, Việt Nam</a>
      </div>

      <div class="box">
         <h3>our number</h3>
         <a href="tel:0376390962">0376390962</a>
      </div>

   </section>

   <div class="credit">&copy; copyright @ <?= date('Y'); ?> by <span>23's team</span> | all rights reserved!</div>

</footer>

<div class="loader" id="loading">
   <img src="public/images/icon/load1.gif" alt="">
</div>

<script>
    // Đợi trang tải xong
    window.onload = function() {
        // Ẩn ảnh GIF khi trang đã tải xong
        document.getElementById('loading').style.display = 'none';
    };
</script>
