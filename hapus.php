<?php
include 'config.php';
session_start();

// Check if user is logged in as admin, otherwise redirect to index.php
if (!isset($_SESSION['admin_name'])) {
    echo "<script>alert('Hanya admin yang dapat mengakses halaman ini.');window.location='index.php';</script>";
    exit;
}

// Periksa apakah parameter id_obat ada dalam URL
if (isset($_GET['id'])) {
    $id_obat = $_GET['id'];

    // Hapus data obat berdasarkan id_obat dari tabel "obat"
    $query = "DELETE FROM obat WHERE id_obat = $id_obat";
    $result = mysqli_query($conn, $query);

    // Cek apakah query berhasil dijalankan
    if ($result) {
        // Jika berhasil, alihkan kembali ke halaman index.php
        header("Location: index.php");
        exit();
    } else {
        // Jika terjadi kesalahan dalam menjalankan query, tampilkan pesan error
        echo "Error: " . mysqli_error($conn);
        exit();
    }
} else {
    // Jika parameter id_obat tidak ada dalam URL, alihkan ke halaman index.php
    header("Location: index.php");
    exit();
}

// Tutup koneksi ke database
mysqli_close($conn);
?>
