<?php
include 'config.php';
session_start();

// Check if user is logged in, otherwise redirect to login page
if (!isset($_SESSION['admin_name']) && !isset($_SESSION['staff_name'])) {
    header('Location: login_form.php');
    exit;
}

// Check user role and restrict certain features for staff
$is_admin = isset($_SESSION['admin_name']);
$is_staff = isset($_SESSION['staff_name']);

// Fetch the list of drugs from the database
$select = "SELECT * FROM obat";

// Check if search parameter is provided
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $select .= " WHERE nama_obat LIKE '%$search%'";
}

$result = mysqli_query($conn, $select);
$daftar_obat = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Laman Stock Obat</title>

    <!-- File CSS -->
    <link rel="stylesheet" href="css/index.css" />
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
                    <a class="nav-link active" aria-current="page" href="#">Akun</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Keluar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><button>Bantuan</button></a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="index">
        <div class="judul-index">
            <h1>STOK DAN KETERANGAN OBAT</h1>
        </div>

        <div class="search-container">
            <form action="index.php" method="GET" onsubmit="searchObat(event)">
                <input type="text" class="search-input" id="search-input" name="search" placeholder="Cari Obat..." />
            </form>
            <?php if ($is_admin) { ?>
                <a href="tambah.php">
                    <button class="add-button">+ Tambah Obat</button>
                </a>
            <?php } else { ?>
                <a href="javascript:void(0)" onclick="staffAccessAlert()">
                    <button class="add-button">+ Tambah Obat</button>
                </a>
            <?php } ?>
        </div>

        <table class="tabel-index">
            <tr>
                <th>No</th>
                <th>Gambar</th>
                <th>ID Obat</th>
                <th>Nama Obat</th>
                <th>Deskripsi</th>
                <th>Tanggal Produksi</th>
                <th>Tanggal Kedaluwarsa</th>
                <th>Stok Obat</th>
                <th>Action</th>
            </tr>

            <?php
            $no = 1;
            foreach ($daftar_obat as $obat) {
                echo '<tr>';
                echo '<td>' . $no++ . '</td>';
                echo '<td style="text-align: center;"><img src="img/' . $obat['gambar_obat'] . '" style="width: 120px;"></td>';
                echo '<td>' . $obat['id_obat'] . '</td>';
                echo '<td>' . $obat['nama_obat'] . '</td>';
                echo '<td>' . $obat['deskripsi'] . '</td>';
                echo '<td>' . $obat['tgl_prd'] . '</td>';
                echo '<td>' . $obat['tgl_exp'] . '</td>';
                echo '<td>' . $obat['stok'] . '</td>';
                echo '<td>';
                if ($is_admin) {
                    echo '<a href="edit.php?id=' . $obat['id_obat'] . '"><button type="button" class="btn btn-outline-primary" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: 1rem; --bs-btn-font-size: .75rem;">Edit</button></a>';
                    echo '</br></br><button type="button" class="btn btn-outline-primary" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;" onclick="confirmDelete(' . $obat['id_obat'] . ')">Delete</button>';
                } else if ($is_staff) {
                    echo '<button type="button" class="btn btn-outline-primary" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: 1rem; --bs-btn-font-size: .75rem;" onclick="staffAccessAlert()">Edit</button>';
                    echo '</br></br><button type="button" class="btn btn-outline-primary" style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;" onclick="staffAccessAlert()">Delete</button>';
                }
                echo '</td>';
                echo '</tr>';
            }
            ?>
        </table>

        <p>&copy; Kelompok 3 | Hak Cipta Dilindungi</p>

        <script>
            function searchObat(event) {
                event.preventDefault(); // Prevent default form submission

                var searchInput = document.getElementById('search-input');
                var searchValue = searchInput.value.trim();
                if (searchValue !== '') {
                    // Submit form
                    searchInput.closest('form').submit();
                }
            }

            function confirmDelete(id) {
                var confirmation = confirm("Apakah Anda yakin ingin menghapus data ini?");
                if (confirmation) {
                    window.location.href = "hapus.php?id=" + id;
                }
            }

            function staffAccessAlert() {
                alert("Anda tidak memiliki izin untuk mengakses fitur ini. Hanya admin yang dapat mengakses fitur ini.");
            }
        </script>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
</body>

</html>
