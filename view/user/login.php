<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="public/css/style.css">
</head>
<body>

<section class="form-container">
   <form action="index_home.php?controller=login&action=login" method="post">
      <h3>Login Now</h3>
      <?php if (!empty($message)) echo "<p class='error-message'>$message</p>"; ?>
      <input type="text" name="name" required placeholder="Enter your username" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="pass" required placeholder="Enter your password" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="Login Now" name="submit" class="btn">
      <p>Don't have an account? <a href="index_home.php?controller=Register&action=add">Register Now</a></p>
   </form>
</section>

<?php include 'view/user/footer.php'; ?>
<script src="public/js/script.js"></script>
</body>
</html>
