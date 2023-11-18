<?php

@include 'config.php';

session_start();

if(!isset($_SESSION['staff_name'])){
   header('location:login_form.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Laman Staff</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<div class="container">
   <div class="content">
      <h3>hi, <span>staff</span></h3>
      <h1>welcome <span><?php echo $_SESSION['staff_name'] ?></span></h1>
      <p>this is an staff page</p>
      <a href="login_form.php" class="btn">Masuk</a>
      <a href="index.php" class="btn">Utama</a>
      <a href="logout.php" class="btn">Keluar</a>
   </div>
</div>

</body>
</html>