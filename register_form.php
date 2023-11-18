<?php
include 'config.php';

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $user_type = $_POST['user_type'];

    $select = "SELECT * FROM user_form WHERE email = '$email'";

    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result) > 0) {
        $error[] = 'User already exists!';
    } else {
        if ($password !== $cpassword) {
            $error[] = 'Passwords do not match!';
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $insert = "INSERT INTO user_form(name, email, password, user_type) VALUES('$name','$email','$hashedPassword','$user_type')";
            mysqli_query($conn, $insert);
            header('location:login_form.php');
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Laman Daftar User</title>

    <!-- File CSS -->
    <link rel="stylesheet" href="css/style.css" />

    <!-- Link Icon -->
    <script src="https://unpkg.com/feather-icons"></script>

    <!-- Link Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap"
      rel="stylesheet"
    />
  </head>

<body>
<section class="register_form" id="register_form">
   <form action="" method="post">
      <h1>DAFTAR AKUN</h1>
      <?php
         if (isset($error)) {
            foreach ($error as $error) {
               echo '<span class="error-msg">' . $error . '</span>';
               }
         }
      ?>
      <label for="name">Nama</label>
      <input type="text" name="name" required placeholder="enter your name">

      <label for="email">E-Mail</label>
      <input type="email" name="email" required placeholder="enter your email">

      <label for="user_type">Tipe User</label>
      <select name="user_type">
         <option value="staff">staff</option>
         <option value="admin">admin</option>
      </select>

      <label for="password">Password</label>
      <input type="password" name="password" required placeholder="enter your password">

      <label for="cpassword">Konfirmasi Password</label>
      <input type="password" name="cpassword" required placeholder="confirm your password">

      <p>Sudah memiliki akun? <a href="login_form.php">Masuk Di Sini!</a></p>

      <input type="submit" name="submit" value="Daftar" class="form-btn">

      <p class="atau">- Atau Daftar Dengan -</p>
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
   </form>

</section>
</body>
</html>
