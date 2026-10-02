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

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `setujui_peminjaman` (IN `p_id` INT, IN `p_petugas` INT)   BEGIN

    UPDATE peminjaman

    SET
        status = 'disetujui',
        disetujui_oleh = p_petugas

    WHERE id = p_id
    AND status = 'menunggu';

END$$

--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `hitung_denda` (`tanggal_rencana` DATE, `tanggal_kembali` DATE) RETURNS DECIMAL(12,2) DETERMINISTIC BEGIN

    DECLARE hari INT;

    SET hari = DATEDIFF(
        tanggal_kembali,
        tanggal_rencana
    );

    IF hari < 0 THEN
        SET hari = 0;
    END IF;

    RETURN hari * 5000;

END$$

DELIMITER ;

-- --------------------------------------------------------

--
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
  `jumlah` int(11) NOT NULL,
  `tanggal_pinjam` date NOT NULL,
  `tanggal_rencana_kembali` date NOT NULL,
  `status` enum('diajukan','disetujui','menunggu_pengembalian','dikembalikan','ditolak') NOT NULL DEFAULT 'disetujui',
  `disetujui_oleh` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`id`, `user_id`, `alat_id`, `jumlah`, `tanggal_pinjam`, `tanggal_rencana_kembali`, `status`, `disetujui_oleh`, `created_at`) VALUES
(1, 2, 1, 1, '2026-09-22', '2026-09-24', 'dikembalikan', NULL, '2026-09-22 05:21:59'),
(2, 2, 1, 1, '2026-09-23', '2026-09-25', 'dikembalikan', NULL, '2026-09-23 00:59:04'),
(3, 4, 2, 9, '2026-09-23', '2026-09-22', '', NULL, '2026-09-23 05:03:04'),
(4, 4, 2, 8, '2026-09-23', '2026-09-24', '', NULL, '2026-09-23 05:03:27'),
(5, 4, 1, 4, '2026-09-23', '2026-09-26', '', NULL, '2026-09-23 05:03:51'),
(6, 4, 1, 1, '2026-09-23', '2026-09-24', '', NULL, '2026-09-23 05:09:49'),
(7, 2, 1, 1, '2026-09-23', '2026-09-25', '', NULL, '2026-09-23 05:12:14'),
(8, 2, 2, 1, '2026-09-23', '2026-09-24', '', NULL, '2026-09-23 05:14:20'),
(9, 2, 1, 1, '2026-09-23', '2026-09-24', 'dikembalikan', NULL, '2026-09-23 05:16:36'),
(10, 2, 1, 1, '2026-09-23', '2026-09-24', 'dikembalikan', NULL, '2026-09-23 05:18:19'),
(11, 2, 1, 1, '2026-09-23', '2026-09-24', 'dikembalikan', NULL, '2026-09-23 05:21:03'),
(12, 2, 3, 2, '2026-09-23', '2026-09-25', 'dikembalikan', NULL, '2026-09-23 05:22:34'),
(13, 2, 2, 3, '2026-09-23', '2026-09-23', 'dikembalikan', NULL, '2026-09-23 05:24:14'),
(14, 2, 2, 4, '2026-09-23', '2026-09-23', 'dikembalikan', NULL, '2026-09-23 05:31:45'),
(15, 2, 14, 4, '2026-09-28', '2026-09-25', '', NULL, '2026-09-28 05:03:43'),
(16, 2, 14, 1, '2026-09-28', '2026-09-30', '', NULL, '2026-09-28 09:23:52'),
(17, 2, 3, 1, '2026-09-28', '2026-09-28', '', NULL, '2026-09-28 09:32:31'),
(18, 2, 4, 1, '2026-10-02', '2026-10-03', '', NULL, '2026-10-01 23:41:28'),
(19, 2, 15, 2, '2026-10-02', '2026-10-03', '', NULL, '2026-10-02 00:26:43'),
(20, 2, 4, 5, '2026-10-02', '2026-10-03', 'dikembalikan', 6, '2026-10-02 00:35:52'),
(21, 8, 15, 2, '2026-10-02', '2026-10-03', 'disetujui', NULL, '2026-10-02 01:03:49');

--
-- Triggers `peminjaman`
--
DELIMITER $$
CREATE TRIGGER `kurangi_stok_peminjaman` AFTER UPDATE ON `peminjaman` FOR EACH ROW BEGIN

    IF NEW.status = 'disetujui'
    AND OLD.status <> 'disetujui' THEN

        UPDATE alat

        SET stok = stok - NEW.jumlah

        WHERE id = NEW.alat_id;

    END IF;

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `pengembalian`
--

CREATE TABLE `pengembalian` (
  `id` int(11) NOT NULL,
  `peminjaman_id` int(11) NOT NULL,
  `tanggal_dikembalikan` date NOT NULL,
  `kondisi_kembali` enum('Baik','Rusak Ringan','Rusak Berat') NOT NULL,
  `terlambat` int(11) DEFAULT 0,
  `denda` decimal(12,2) DEFAULT 0.00,
  `keterangan` text DEFAULT NULL,
  `diproses_oleh` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengembalian`
--

INSERT INTO `pengembalian` (`id`, `peminjaman_id`, `tanggal_dikembalikan`, `kondisi_kembali`, `terlambat`, `denda`, `keterangan`, `diproses_oleh`, `created_at`) VALUES
(1, 1, '2026-09-23', 'Baik', 0, 0.00, ' beres\r\n', 2, '2026-09-23 00:49:46'),
(2, 2, '2026-09-24', 'Rusak Ringan', 0, 0.00, 'hampura rajet', 2, '2026-09-23 00:59:30');

--
-- Triggers `pengembalian`
--
DELIMITER $$
CREATE TRIGGER `tambah_stok_pengembalian` AFTER INSERT ON `pengembalian` FOR EACH ROW BEGIN

    UPDATE alat a

    JOIN peminjaman p
    ON a.id = p.alat_id

    SET a.stok = a.stok + p.jumlah

    WHERE p.id = NEW.peminjaman_id;

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `role` enum('admin','petugas','peminjam') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `nama_lengkap`, `role`, `created_at`) VALUES
(1, 'iman', '$2y$10$7ir2IFlYt4yMij3f.FrVRuPyZYEnrVAhrrUq5Mtj8o9vHqIzrZOD6', 'iman', 'peminjam', '2026-09-22 03:21:43'),
(2, 'surya', '$2y$10$T5mX/1Bvyva/nhOEq28IquhFLG9vydsAzulyniegG4dK5uXKggLuK', 'suryagalih', 'peminjam', '2026-09-22 03:24:03'),
(3, 'admin', '$2y$10$pDE8RDVpOalrexXfteRqluGiHWHgQYLO6lHLm.2/DM3dbulF74tRK', 'Administrator', 'admin', '2026-09-23 01:21:01'),
(4, 'rida', '$2y$10$hnIak1C5RJHVX3n2sOz.y.f1hCVUS21ZEN5F2O2p5Y/k5dX8kvDS2', 'aa rida', 'peminjam', '2026-09-23 05:02:03'),
(5, 'ujang', '$2y$10$BkSGP7Jc7dBERFweinrhzO./m2prxm4Hot3XfIcOe5DnXYGF7kh.6', 'ujangjang', 'peminjam', '2026-09-28 02:02:08'),
(6, 'petugas', '$2y$10$19grJYPLzUKAX152ax0VOuQks8HLYIGnNrYyCYOBKJJbShvJ4DqRq', 'Petugas Olahraga', 'petugas', '2026-09-28 02:47:07'),
(7, 'Beben', '$2y$10$96k1sx.Gis.kt9DoDTwoaOV9zNBLXmJKN4RAqeWi57cJ6o4DHJory', 'Beben', 'peminjam', '2026-10-01 23:44:35'),
(8, 'siapa', '$2y$10$r25AMBjYrQAPFJap51eUxeEaYnA/joNqJIZIYjLaDbKgBiNmX0SXi', 'Siapa aja', 'peminjam', '2026-10-02 01:03:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alat`
--
ALTER TABLE `alat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kategori_id` (`kategori_id`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `alat_id` (`alat_id`),
  ADD KEY `disetujui_oleh` (`disetujui_oleh`);

--
-- Indexes for table `pengembalian`
--
ALTER TABLE `pengembalian`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `peminjaman_id` (`peminjaman_id`),
  ADD KEY `diproses_oleh` (`diproses_oleh`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alat`
--
ALTER TABLE `alat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `pengembalian`
--
ALTER TABLE `pengembalian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alat`
--
ALTER TABLE `alat`
  ADD CONSTRAINT `alat_ibfk_1` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  ADD CONSTRAINT `log_aktivitas_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `peminjaman_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `peminjaman_ibfk_2` FOREIGN KEY (`alat_id`) REFERENCES `alat` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `peminjaman_ibfk_3` FOREIGN KEY (`disetujui_oleh`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `pengembalian`
--
ALTER TABLE `pengembalian`
  ADD CONSTRAINT `pengembalian_ibfk_1` FOREIGN KEY (`peminjaman_id`) REFERENCES `peminjaman` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `pengembalian_ibfk_2` FOREIGN KEY (`diproses_oleh`) REFERENCES `users` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
