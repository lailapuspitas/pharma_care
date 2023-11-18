-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 04, 2023 at 02:51 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `user_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `obat`
--

CREATE TABLE `obat` (
  `id_obat` int(10) NOT NULL,
  `nama_obat` varchar(100) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `tgl_prd` date DEFAULT NULL,
  `tgl_exp` date DEFAULT NULL,
  `stok` int(10) DEFAULT NULL,
  `gambar_obat` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `obat`
--

INSERT INTO `obat` (`id_obat`, `nama_obat`, `deskripsi`, `tgl_prd`, `tgl_exp`, `stok`, `gambar_obat`) VALUES
(6, 'Feminax', 'Obat Pereda Nyeri Haid dengan Kandungan Paracetamol', '2023-02-01', '2023-06-30', 12, '514-feminax.jpeg'),
(7, 'Panadol', 'Obat paracetamol untuk menurunkan demam', '2022-06-07', '2024-07-07', 14, '350-logounsika.png'),
(9, 'Bodrex', 'Obat untuk meringankan sakit kepala', '2023-02-09', '2026-06-27', 56, '268-pbw-Page-2.drawio (1).png'),
(10, 'OBH Combi', 'Obat untuk meredakan batuk dan pilek', '2022-02-10', '2026-10-21', 22, '936-pbw-Page-2.drawio.png');

-- --------------------------------------------------------

--
-- Table structure for table `user_form`
--

CREATE TABLE `user_form` (
  `id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` varchar(255) NOT NULL DEFAULT 'staff'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_form`
--

INSERT INTO `user_form` (`id`, `name`, `email`, `password`, `user_type`) VALUES
(7, 'admin01', 'admin01@gmail.com', '$2y$10$8B6rHgx4T55Izp9Vr2FR3ORMswy3vl3sjtfS93zHzfEjs8LEHRNuC', 'admin'),
(8, 'staff01', 'staff01@gmail.com', '$2y$10$NOgA3zXjVpNqz.465ypd.eGThjKMQ4wHuAe9tANN2JzDxrRjf/e8e', 'staff');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `obat`
--
ALTER TABLE `obat`
  ADD PRIMARY KEY (`id_obat`);

--
-- Indexes for table `user_form`
--
ALTER TABLE `user_form`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `obat`
--
ALTER TABLE `obat`
  MODIFY `id_obat` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user_form`
--
ALTER TABLE `user_form`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
