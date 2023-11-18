<?php
include 'config.php';
session_start();

// Check if user is logged in as admin, otherwise redirect to index.php
if (!isset($_SESSION['admin_name'])) {
    echo "<script>alert('Hanya admin yang dapat mengakses halaman ini.');window.location='index.php';</script>";
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id_obat = $_GET['id'];

// Ambil data obat berdasarkan id_obat dari tabel "obat"
$query = "SELECT * FROM obat WHERE id_obat = $id_obat";
$result = mysqli_query($conn, $query);

// Cek apakah query berhasil dijalankan
if (!$result || mysqli_num_rows($result) == 0) {
    header("Location: index.php");
    exit();
}

$obat = mysqli_fetch_assoc($result);

if (isset($_POST['update'])) {
    $nama_obat = $_POST['nama_obat'];
    $deskripsi = $_POST['deskripsi'];
    $tgl_prd = $_POST['tgl_prd'];
    $tgl_exp = $_POST['tgl_exp'];
    $stok = $_POST['stok'];

    // Cek apakah gambar baru diupload
    if ($_FILES['gambar_obat']['name'] != "") {
        $ekstensi_diperbolehkan = array('jpeg', 'png', 'jpg');
        $x = explode('.', $_FILES['gambar_obat']['name']);
        $ekstensi = strtolower(end($x));
        $file_tmp = $_FILES['gambar_obat']['tmp_name'];
        $angka_acak = rand(1, 999);
        $nama_gambar_baru = $angka_acak . '-' . $_FILES['gambar_obat']['name'];

        // Upload gambar baru
        if (in_array($ekstensi, $ekstensi_diperbolehkan) === true) {
            move_uploaded_file($file_tmp, 'gambar/' . $nama_gambar_baru);

            // Hapus gambar lama
            if ($obat['gambar_obat'] != null) {
                unlink('gambar/' . $obat['gambar_obat']);
            }

            // Update data obat dengan gambar baru
            $query = "UPDATE obat SET nama_obat = '$nama_obat', deskripsi = '$deskripsi', tgl_prd = '$tgl_prd', tgl_exp = '$tgl_exp', stok = '$stok', gambar_obat = '$nama_gambar_baru' WHERE id_obat = $id_obat";
        } else {
            echo "<script>alert('Ekstensi gambar yang boleh hanya jpg atau png.');window.location='edit.php?id=$id_obat';</script>";
            exit;
        }
    } else {
        // Update data obat tanpa mengubah gambar
        $query = "UPDATE obat SET nama_obat = '$nama_obat', deskripsi = '$deskripsi', tgl_prd = '$tgl_prd', tgl_exp = '$tgl_exp', stok = '$stok' WHERE id_obat = $id_obat";
    }

    $result = mysqli_query($conn, $query);

    if (!$result) {
        echo "Error: " . mysqli_error($conn);
        exit();
    } else {
        header("Location: index.php");
        exit();
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laman Edit Obat</title>

    <!-- File CSS -->
    <link rel="stylesheet" href="css/style.css">

    <!-- Link Icon -->
    <script src="https://unpkg.com/feather-icons"></script>

    <!-- Link Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
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

    <section class="edit" id="edit">
        <form method="POST" action="" enctype="multipart/form-data">
            <h1>Edit Obat</h1>
            <div>
                <label>Nama Obat:</label>
                <input type="text" name="nama_obat" value="<?php echo $obat['nama_obat']; ?>" autofocus required>
            </div>
            <div>
                <label>Deskripsi:</label>
                <input type="text" name="deskripsi" value="<?php echo $obat['deskripsi']; ?>">
            </div>
            <div>
                <label>Tanggal Produksi:</label>
                <input type="date" name="tgl_prd" value="<?php echo $obat['tgl_prd']; ?>" required>
            </div>
            <div>
                <label>Tanggal Kedaluarsa:</label>
                <input type="date" name="tgl_exp" value="<?php echo $obat['tgl_exp']; ?>" required>
            </div>
            <div>
                <label>Stok:</label>
                <input type="text" name="stok" value="<?php echo $obat['stok']; ?>" required>
            </div>
            <div>
                <label>Gambar Obat:</label>
                <input type="file" name="gambar_obat">
            </div>
            <?php if ($obat['gambar_obat'] != null) : ?>
                <div>
                    <label>Gambar Obat Saat Ini:</label>
                    <img src="img/<?php echo $obat['gambar_obat']; ?>" width="200">
                </div>
            <?php endif; ?>
            <div>
                <button type="submit" name="update">Update</button>
                <a href="index.php"><button name="batal">Batal</button></a>
            </div>
        </form>
        <p>&copy; Kelompok 3 | Hak Cipta Dilindungi</p>
    </section>

    <script>
        feather.replace();
    </script>
</body>
</html>
