-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: Dec 22, 2025 at 11:14 PM
-- Server version: 10.4.32-MariaDB-log
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `frozenfoodraf`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id_customer` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `nama_customer` varchar(150) NOT NULL,
  `alamat` text DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id_customer`, `id_user`, `nama_customer`, `alamat`, `no_hp`, `created_at`) VALUES
(1, NULL, 'Ilham', 'Tangerang', '0812365646', '2025-12-04 13:44:00'),
(2, NULL, 'Ilham', '', '', '2025-12-04 13:45:21'),
(3, NULL, 'Gilang', 'Cadas', '', '2025-12-10 15:07:41'),
(4, NULL, 'Gilang', NULL, NULL, '2025-12-17 05:53:52'),
(5, NULL, 'Gilang', NULL, NULL, '2025-12-17 10:18:00'),
(6, NULL, 'Raffi', NULL, NULL, '2025-12-17 10:20:53'),
(7, NULL, 'Santoso', '-', '-', '2025-12-17 12:00:32');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`, `created_at`) VALUES
(1, 'Ayam Frozen', '2025-12-03 08:27:40'),
(2, 'Frozen Food', '2025-12-03 06:40:15');

-- --------------------------------------------------------

--
-- Table structure for table `order_offline`
--

CREATE TABLE `order_offline` (
  `id_order_offline` int(11) NOT NULL,
  `id_customer` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `status` enum('Success','Cancelled') NOT NULL DEFAULT 'Success',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `order_offline`
--

INSERT INTO `order_offline` (`id_order_offline`, `id_customer`, `total`, `status`, `created_at`) VALUES
(1, 1, 35000, 'Success', '2025-12-04 13:44:00'),
(2, 2, 10000, 'Success', '2025-12-04 13:45:21'),
(3, 3, 45000, 'Success', '2025-12-10 15:07:41'),
(4, 4, 20000, 'Success', '2025-12-16 22:53:52'),
(5, 5, 20000, 'Success', '2025-12-17 03:18:00'),
(6, 6, 20000, 'Success', '2025-12-17 10:20:53'),
(7, 7, 15000, 'Success', '2025-12-17 12:00:32');

-- --------------------------------------------------------

--
-- Table structure for table `order_offline_detail`
--

CREATE TABLE `order_offline_detail` (
  `id_detail` int(11) NOT NULL,
  `id_order_offline` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `order_offline_detail`
--

INSERT INTO `order_offline_detail` (`id_detail`, `id_order_offline`, `id_produk`, `qty`, `subtotal`) VALUES
(1, 1, 6, 2, 20000),
(2, 1, 7, 1, 15000),
(3, 2, 6, 1, 10000),
(4, 3, 7, 3, 45000),
(5, 4, 6, 1, 20000),
(6, 5, 6, 1, 20000),
(7, 6, 6, 1, 20000),
(8, 7, 7, 1, 15000);

-- --------------------------------------------------------

--
-- Table structure for table `order_online`
--

CREATE TABLE `order_online` (
  `id_order_online` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `bukti_bayar` varchar(255) DEFAULT NULL,
  `status` enum('Pending','Cancelled','Success') NOT NULL DEFAULT 'Pending',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `order_online`
--

INSERT INTO `order_online` (`id_order_online`, `id_user`, `total`, `bukti_bayar`, `status`, `created_at`) VALUES
(6, 3, 10000, 'Rekening_BCA.jpg', 'Success', '2025-12-07 07:59:27'),
(7, 3, 10000, 'Screenshot_2025-12-08_165643.png', 'Cancelled', '2025-12-08 17:31:05'),
(8, 4, 20000, 'b6916d93bc1d70a3dc13d28e342ae9ee.jpg', 'Cancelled', '2025-12-10 08:30:53'),
(9, 4, 15000, '5bf2b141d85b88b9dc014eb92e61e9ca.jpg', 'Cancelled', '2025-12-10 08:40:10'),
(10, 3, 15000, '8850cb07bba9f07b88d394819b9edf3c.jpeg', 'Success', '2025-12-17 10:44:53'),
(11, 3, 210000, '64341e2c03594f857e150bcf884515b4.jpg', 'Cancelled', '2025-12-17 10:57:22'),
(12, 3, 15000, 'bc2d80be016fade0ba3cb63d9d53968f.jpeg', 'Success', '2025-12-17 12:14:02');

-- --------------------------------------------------------

--
-- Table structure for table `order_online_detail`
--

CREATE TABLE `order_online_detail` (
  `id_detail` int(11) NOT NULL,
  `id_order_online` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `order_online_detail`
--

INSERT INTO `order_online_detail` (`id_detail`, `id_order_online`, `id_produk`, `qty`, `subtotal`) VALUES
(1, 6, 6, 1, 10000),
(2, 7, 6, 1, 10000),
(3, 8, 6, 1, 20000),
(4, 9, 7, 1, 15000),
(5, 10, 7, 1, 15000),
(6, 11, 7, 14, 210000),
(7, 12, 7, 1, 15000);

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(11) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `nama_produk` varchar(150) NOT NULL,
  `harga` int(11) NOT NULL,
  `stok` int(11) DEFAULT 0,
  `id_supplier` int(11) NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id_produk`, `id_kategori`, `nama_produk`, `harga`, `stok`, `id_supplier`, `gambar`, `created_at`, `updated_at`) VALUES
(6, 1, 'Ayam Goreng Freeezer', 20000, 4, 2, '1abf3f1258cbe52865590b6a956ee9cd.jpg', '2025-12-03 09:00:29', '2025-12-23 05:41:01'),
(7, 2, 'Bakso Beku', 15000, 12, 4, '9419af5682ab5597f3772eae578f6de7.jpg', '2025-12-03 13:40:15', '2025-12-17 12:14:02');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id_supplier` int(11) NOT NULL,
  `nama_supplier` varchar(150) NOT NULL,
  `alamat` text DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id_supplier`, `nama_supplier`, `alamat`, `no_hp`, `created_at`) VALUES
(2, 'Asep', 'Cadas', '081223656546', '2025-12-03 07:24:52'),
(3, 'pasep', 'Cibodas', '081211363118123', '2025-12-03 13:39:21'),
(4, 'Raffi', 'Sepatan\r\n', '081211363118', '2025-12-03 06:40:15');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(150) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `nama_lengkap`, `email`, `no_hp`, `alamat`, `role`, `created_at`) VALUES
(2, 'admin2', '$2y$10$YXB9Jrd4nBSpDUHZH6mqfOkSpwxTDXDl6RjPjOubyVo4CxR6Q2CgK', 'Administrator Baru', 'admin@gmail.com', NULL, NULL, 'admin', '2025-12-04 16:31:38'),
(3, 'raffi', '$2y$10$RkOnDE2aZ5tzy6CoKDD2.OhZvJAOXKk4nGyU2I6SeWLL8X.x8VmSC', 'Raffi', 'raffi@gmail.com', '081223656546', 'Cadas', 'user', '2025-12-04 16:36:04'),
(4, 'daffa', '$2y$10$Ky4PfoWLUycBU6veB/BbTue0WzuL3QO1SLYWkTkV4FE6JECTzylPC', 'daffa dermawan', 'daffatest@gmail.com', NULL, NULL, 'user', '2025-12-08 22:41:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id_customer`),
  ADD KEY `fk_customer_user` (`id_user`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `order_offline`
--
ALTER TABLE `order_offline`
  ADD PRIMARY KEY (`id_order_offline`),
  ADD KEY `id_customer` (`id_customer`);

--
-- Indexes for table `order_offline_detail`
--
ALTER TABLE `order_offline_detail`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `id_order_offline` (`id_order_offline`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indexes for table `order_online`
--
ALTER TABLE `order_online`
  ADD PRIMARY KEY (`id_order_online`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `order_online_detail`
--
ALTER TABLE `order_online_detail`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `id_order_online` (`id_order_online`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`),
  ADD KEY `fk_produk_kategori` (`id_kategori`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id_supplier`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id_customer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `order_offline`
--
ALTER TABLE `order_offline`
  MODIFY `id_order_offline` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `order_offline_detail`
--
ALTER TABLE `order_offline_detail`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `order_online`
--
ALTER TABLE `order_online`
  MODIFY `id_order_online` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `order_online_detail`
--
ALTER TABLE `order_online_detail`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id_supplier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `fk_customer_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_offline`
--
ALTER TABLE `order_offline`
  ADD CONSTRAINT `order_offline_ibfk_1` FOREIGN KEY (`id_customer`) REFERENCES `customer` (`id_customer`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_offline_detail`
--
ALTER TABLE `order_offline_detail`
  ADD CONSTRAINT `order_offline_detail_ibfk_1` FOREIGN KEY (`id_order_offline`) REFERENCES `order_offline` (`id_order_offline`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_offline_detail_ibfk_2` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_online`
--
ALTER TABLE `order_online`
  ADD CONSTRAINT `order_online_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_online_detail`
--
ALTER TABLE `order_online_detail`
  ADD CONSTRAINT `order_online_detail_ibfk_1` FOREIGN KEY (`id_order_online`) REFERENCES `order_online` (`id_order_online`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_online_detail_ibfk_2` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `fk_produk_kategori` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
