<?php

include 'config.php';

session_start();

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $select = "SELECT * FROM user_form WHERE email = '$email'";
    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        if (password_verify($password, $row['password'])) {
            if ($row['user_type'] == 'admin') {
                $_SESSION['admin_name'] = $row['name'];
                header('location: admin_page.php');
                exit;
            } elseif ($row['user_type'] == 'staff') {
                $_SESSION['staff_name'] = $row['name'];
                header('location: staff_page.php');
                exit;
            }
        } else {
            $error = 'Incorrect email or password!';
        }
    } else {
        $error = 'Incorrect email or password!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Laman Masuk User</title>

    <!-- File CSS -->
    <link rel="stylesheet" href="css/style.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

    <!-- Link Icon -->
    <script src="https://unpkg.com/feather-icons"></script>

    <!-- Link Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap"
        rel="stylesheet" />
</head>

<body>
<nav class="navbar">
    <div class="navbar-logo">
        <p>Pharma<span>.Care</span></p>
    </div>

    <div class="navbar-nav">
        <ul class="nav justify-content-end">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="login_form.php">Masuk</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="register_form.php">Daftar</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"><button>Bantuan</button></a>
            </li>
        </ul>
    </div>
</nav>
<section class="login_form" id="login_form">
   <form class="col s12 m12 offset-4 offset-4" action="" method="post">
      <h1>MASUK</h1>
      <p>Tuliskan E-mail dan Password yang benar dan sesuai.</p>

      <div class="row">
         <?php
         if (isset($error)) {
            echo '<span class="error-msg">' . $error . '</span>';
         }
         ?>

      </div>
      <div class="input-field col s12">
         <input type="email" name="email" required placeholder="Enter your email">
      </div>
      <div class="input-field col s12">
         <input type="password" name="password" required placeholder="Enter your password">
      </div>
      
      <p>Belum Mempunyai Akun? <a href="register_form.php">Daftar Di Sini!</a></p>
      
      <div class="input-field col s12">
         <input type="submit" name="submit" value="Masuk" class="form-btn">
      </div>
      
      <p class="atau">- Atau Masuk Dengan -</p>
            <div class="logo-apk">
                <div class="logo-box">
                    <a href="#fac">
                        <i data-feather="facebook"></i>
                        <span>Facebook</span>
                    </a>
                </div>
                <div class="logo-box">
                    <a href="#mail">
                        <i data-feather="mail"></i>
                        <span>Mail</span>
                    </a>
                </div>
            </div>
   </form>
      </br></br>
   <p>&copy; Kelompok 3 | Hak Cipta Dilindungi</p>
</section>
   <script>
        feather.replace();
   </script>
</body>

</html>
