-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 26, 2024 at 09:25 AM
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
-- Database: `angkatan3_laundry`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `adress` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `customer_name`, `phone`, `adress`, `created_at`, `updated_at`) VALUES
(1, ' didi', ' 0856479556', 'jlan cikampek', '2024-11-15 04:28:28', '2024-11-15 04:28:28'),
(3, 'oji', '086674873245', 'jln kemayoran no 20', '2024-11-20 02:34:40', '2024-11-20 02:34:40'),
(4, 'ojionya3', '086674873249', 'jln mht 13', '2024-11-20 02:34:59', '2024-11-20 02:34:59');

-- --------------------------------------------------------

--
-- Table structure for table `level`
--

CREATE TABLE `level` (
  `id` int(11) NOT NULL,
  `nama_level` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `level`
--

INSERT INTO `level` (`id`, `nama_level`, `created_at`, `update_at`) VALUES
(1, 'Administrator', '2024-11-13 11:24:09', '2024-11-13 11:24:09'),
(2, 'Operator', '2024-11-13 11:24:09', '2024-11-13 11:24:09'),
(4, 'pimpinan', '2024-11-15 01:57:43', '2024-11-15 01:57:43');

-- --------------------------------------------------------

--
-- Table structure for table `paket`
--

CREATE TABLE `paket` (
  `id` int(11) NOT NULL,
  `nama_paket` varchar(50) NOT NULL,
  `harga` int(11) NOT NULL,
  `deskripsi` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `paket`
--

INSERT INTO `paket` (`id`, `nama_paket`, `harga`, `deskripsi`, `created_at`, `updated_at`) VALUES
(1, 'gosok', 4000, 'cuci wangi', '2024-11-15 06:44:19', '2024-11-15 06:44:19'),
(2, ' cuci gosok', 6000, 'sudah terbungkus rapih', '2024-11-15 06:44:44', '2024-11-15 06:44:44'),
(3, 'paket besar', 7000, 'sprei', '2024-11-15 06:45:06', '2024-11-15 06:45:06');

-- --------------------------------------------------------

--
-- Table structure for table `trans_laundry_pickup`
--

CREATE TABLE `trans_laundry_pickup` (
  `id` int(11) NOT NULL,
  `id_customer` int(11) NOT NULL,
  `id_order` int(11) NOT NULL,
  `pickup_date` date NOT NULL,
  `pickup_pay` double(10,2) NOT NULL,
  `pickup_change` float(10,2) NOT NULL,
  `note` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trans_laundry_pickup`
--

INSERT INTO `trans_laundry_pickup` (`id`, `id_customer`, `id_order`, `pickup_date`, `pickup_pay`, `pickup_change`, `note`, `created_at`, `updated_at`) VALUES
(4, 3, 12, '2024-11-21', 30000.00, 6000.00, '', '2024-11-21 04:57:52', '2024-11-21 04:57:52'),
(5, 3, 13, '2024-11-21', 20000.00, 7000.00, '', '2024-11-21 05:02:15', '2024-11-21 05:02:15'),
(6, 4, 14, '2024-11-21', 100000.00, 16000.00, '', '2024-11-21 07:09:32', '2024-11-21 07:09:32');

-- --------------------------------------------------------

--
-- Table structure for table `trans_order`
--

CREATE TABLE `trans_order` (
  `id` int(11) NOT NULL,
  `id_customer` int(11) NOT NULL,
  `no_transaksi` varchar(50) NOT NULL,
  `tanggal_laundry` datetime NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trans_order`
--

INSERT INTO `trans_order` (`id`, `id_customer`, `no_transaksi`, `tanggal_laundry`, `status`, `created_at`, `updated_at`) VALUES
(11, 1, '#INV2011202400011', '2024-11-15 00:00:00', 1, '2024-11-20 03:34:07', '2024-11-21 04:28:01'),
(12, 3, '#INV2011202400012', '2024-11-14 00:00:00', 1, '2024-11-20 03:35:00', '2024-11-21 04:17:29'),
(13, 3, '#INV2111202400013', '2024-11-21 00:00:00', 1, '2024-11-21 05:01:56', '2024-11-21 05:02:15'),
(14, 4, '#INV2111202400014', '2024-11-23 00:00:00', 1, '2024-11-21 06:55:31', '2024-11-21 07:09:32'),
(15, 1, '#INV2111202400015', '2024-11-07 00:00:00', 0, '2024-11-21 07:14:49', '2024-11-21 07:14:49');

-- --------------------------------------------------------

--
-- Table structure for table `trans_order_detail`
--

CREATE TABLE `trans_order_detail` (
  `id` int(11) NOT NULL,
  `id_order` int(11) NOT NULL,
  `id_paket` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL,
  `catatan` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trans_order_detail`
--

INSERT INTO `trans_order_detail` (`id`, `id_order`, `id_paket`, `qty`, `subtotal`, `catatan`, `created_at`, `updated_at`) VALUES
(13, 11, 1, 3, 12000, '', '2024-11-20 03:34:07', '2024-11-20 03:34:07'),
(14, 12, 2, 2, 12000, '', '2024-11-20 03:35:00', '2024-11-20 03:35:00'),
(15, 12, 1, 3, 12000, '', '2024-11-20 03:35:00', '2024-11-20 03:35:00'),
(16, 13, 2, 1, 6000, '', '2024-11-21 05:01:56', '2024-11-21 05:01:56'),
(17, 13, 3, 1, 7000, '', '2024-11-21 05:01:56', '2024-11-21 05:01:56'),
(18, 14, 3, 6, 42000, '', '2024-11-21 06:55:31', '2024-11-21 06:55:31'),
(19, 14, 2, 7, 42000, '', '2024-11-21 06:55:31', '2024-11-21 06:55:31'),
(20, 15, 1, 2, 8000, '', '2024-11-21 07:14:49', '2024-11-21 07:14:49'),
(21, 15, 3, 5, 35000, '', '2024-11-21 07:14:49', '2024-11-21 07:14:49');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `id_level` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `id_level`, `nama`, `email`, `password`, `username`, `created_at`, `updated_at`) VALUES
(1, 1, 'Admin', 'admin@gmail.com', '12345678', 'admin', '2024-11-13 11:47:19', '2024-11-13 11:47:49'),
(2, 2, 'Operator1', 'operator1@gmail.com', '12345678', 'operator1', '2024-11-13 13:25:58', '2024-11-13 13:25:58');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `paket`
--
ALTER TABLE `paket`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trans_laundry_pickup`
--
ALTER TABLE `trans_laundry_pickup`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trans_order`
--
ALTER TABLE `trans_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trans_order_detail`
--
ALTER TABLE `trans_order_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_level` (`id_level`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `level`
--
ALTER TABLE `level`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `paket`
--
ALTER TABLE `paket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `trans_laundry_pickup`
--
ALTER TABLE `trans_laundry_pickup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `trans_order`
--
ALTER TABLE `trans_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `trans_order_detail`
--
ALTER TABLE `trans_order_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`id_level`) REFERENCES `level` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
