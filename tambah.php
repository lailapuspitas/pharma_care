<?php
include 'config.php';
session_start();

// Check if user is logged in as admin, otherwise redirect to index.php
if (!isset($_SESSION['admin_name'])) {
    echo "<script>alert('Hanya admin yang dapat mengakses halaman ini.');window.location='index.php';</script>";
    exit;
}

if(isset($_POST['simpan'])){
    $nama_obat   = $_POST['nama_obat'];
    $deskripsi   = $_POST['deskripsi'];
    $tgl_prd     = $_POST['tgl_prd'];
    $tgl_exp     = $_POST['tgl_exp'];
    $stok        = $_POST['stok'];
    $gambar_obat = $_FILES['gambar_obat']['name'];

    if($gambar_obat != "") {
        $ekstensi_diperbolehkan = array('jpeg','png','jpg');
        $x = explode('.', $gambar_obat);
        $ekstensi = strtolower(end($x));
        $file_tmp = $_FILES['gambar_obat']['tmp_name'];
        $angka_acak = rand(1,999);
        $nama_gambar_baru = $angka_acak.'-'.$gambar_obat;
        if(in_array($ekstensi, $ekstensi_diperbolehkan) === true)  {
            move_uploaded_file($file_tmp, 'gambar/'.$nama_gambar_baru);
            $query = "INSERT INTO obat (nama_obat, deskripsi, tgl_prd, tgl_exp, stok, gambar_obat) VALUES ('$nama_obat', '$deskripsi', '$tgl_prd', '$tgl_exp', '$stok', '$nama_gambar_baru')";
            $result = mysqli_query($conn, $query);
            if(!$result){
                die("Query gagal dijalankan: ".mysqli_error($conn)." - ".mysqli_error($conn));
            } else {
                echo "<script>alert('Data berhasil ditambah.');window.location='index.php';</script>";
                exit;
            }
        } else {
            echo "<script>alert('Ekstensi gambar yang boleh hanya jpg atau png.');window.location='tambah.php';</script>";
            exit;
        }
    } else {
        $query = "INSERT INTO obat (nama_obat, deskripsi, tgl_prd, tgl_exp, stok, gambar_obat) VALUES ('$nama_obat', '$deskripsi', '$tgl_prd', '$tgl_exp', '$stok', null)";
        $result = mysqli_query($conn, $query);
        if(!$result){
            die("Query gagal dijalankan: ".mysqli_error($conn)." - ".mysqli_error($conn));
        } else {
            echo "<script>alert('Data berhasil ditambah.');window.location='index.php';</script>";
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Laman Tambah Data Obat</title>
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
<nav class="navbar">
    <div class="navbar-logo">
        <p>Pharma<span>.Care</span></p>
    </div>

    <div class="navbar-nav">
        <a href="keluar.php">Keluar</a>
        <button>Bantuan</button>
    </div>
</nav>

<section class="tambah" id="tambah">
    <form method="POST" action="" enctype="multipart/form-data">
        <h1>Tambah Obat</h1>
        <div>
            <label>Nama Obat</label>
            <input type="text" name="nama_obat" autofocus required />
        </div>
        <div>
            <label>Deskripsi</label>
            <input type="text" name="deskripsi" />
        </div>
        <div>
            <label>Tanggal Produksi</label>
            <input type="date" name="tgl_prd" required />
        </div>
        <div>
            <label>Tanggal Kedaluarsa</label>
            <input type="date" name="tgl_exp" required />
        </div>
        <div>
            <label>Stok Obat</label>
            <input type="text" name="stok" required />
        </div>
        <div>
            <label>Gambar Obat</label>
            <input type="file" name="gambar_obat" required />
        </div>
        <div>
            <button type="submit" name="simpan">Simpan Obat</button>
        </div>
        <div>
            <?php
            if (isset($_POST['simpan'])) {
                echo "<img src='img/$nama_gambar_baru'>";
            }
            ?>
        </div>
    </form>

    <p>&copy; Kelompok 3 | Hak Cipta Dilindungi</p>
</section>

<script>
    feather.replace();
</script>
</body>
</html>
