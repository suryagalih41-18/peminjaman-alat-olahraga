-- Versi SQL yang disesuaikan untuk impor InfinityFree.
-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 02, 2026 at 04:24 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_peminjaman_olahraga`
--

-- Stored procedures/functions omitted for InfinityFree compatibility.

-- --------------------------------------------------------

-- Table structure for table `alat`
--

CREATE TABLE `alat` (
  `id` int(11) NOT NULL,
  `nama_alat` varchar(100) NOT NULL,
  `kategori_id` int(11) NOT NULL,
  `stok` int(11) NOT NULL DEFAULT 0,
  `kondisi` enum('Baik','Rusak Ringan','Rusak Berat') DEFAULT 'Baik',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `alat`
--

INSERT INTO `alat` (`id`, `nama_alat`, `kategori_id`, `stok`, `kondisi`, `created_at`) VALUES
(1, 'Bola Futsal', 1, 10, 'Baik', '2026-08-30 06:19:19'),
(2, 'Bola Basket', 1, 11, 'Baik', '2026-08-30 06:19:19'),
(3, 'Raket Badminton', 2, 6, 'Baik', '2026-08-30 06:19:19'),
(4, 'Bola Volly', 1, 9, 'Baik', '2026-08-30 06:19:19'),
(14, 'bola volly', 1, 0, 'Baik', '2026-09-28 03:41:44'),
(15, 'cone cone', 3, 1, 'Baik', '2026-10-01 23:49:51');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `nama_kategori`) VALUES
(1, 'Bola'),
(2, 'Raket'),
(3, 'Perlengkapan Lapangan'),
(4, 'Perlengkapan Fitness');

-- --------------------------------------------------------

--
-- Table structure for table `log_aktivitas`
--

CREATE TABLE `log_aktivitas` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `aktivitas` varchar(255) NOT NULL,
  `waktu` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `alat_id` int(11) NOT NULL,