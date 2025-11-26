-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 23, 2024 at 02:58 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kasir_ukom`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_barang`
--

CREATE TABLE `tbl_barang` (
  `id_brg` varchar(100) NOT NULL,
  `barcode` varchar(100) NOT NULL,
  `nama_brg` varchar(100) NOT NULL,
  `harga_beli` int(11) NOT NULL,
  `harga_jual` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `satuan` varchar(20) NOT NULL,
  `stock_min` int(11) NOT NULL,
  `gambar` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_barang`
--

INSERT INTO `tbl_barang` (`id_brg`, `barcode`, `nama_brg`, `harga_beli`, `harga_jual`, `stock`, `satuan`, `stock_min`, `gambar`) VALUES
('BRG-001', '83210811231', 'susu bendera', 10000, 12000, 2, 'kaleng', 5, 'BRG-001.jpg'),
('BRG-002', '3102818231', 'atribut logo smk ', 4000, 5000, 5, 'piece', 5, 'BRG-002.jpg'),
('BRG-003', '810238103131', 'cv kreasi indonesia', 10000, 15000, 9, 'piece', 5, 'BRG-003.jpg'),
('BRG-004', '8992856906860', 'Romano Grandiose', 9000, 11000, 0, 'piece', 3, 'default-brg.png');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_beli_detail`
--

CREATE TABLE `tbl_beli_detail` (
  `id` int(11) NOT NULL,
  `no_beli` varchar(20) NOT NULL,
  `tgl_beli` date NOT NULL,
  `kode_brg` varchar(10) NOT NULL,
  `nama_brg` varchar(100) NOT NULL,
  `qty` int(11) NOT NULL,
  `harga_beli` int(11) NOT NULL,
  `jml_harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_beli_detail`
--

INSERT INTO `tbl_beli_detail` (`id`, `no_beli`, `tgl_beli`, `kode_brg`, `nama_brg`, `qty`, `harga_beli`, `jml_harga`) VALUES
(51, 'PB0001', '2024-02-23', 'BRG-001', 'susu bendera', 10, 10000, 100000),
(52, 'PB0001', '2024-02-23', 'BRG-002', 'atribut logo smk ', 10, 4000, 40000),
(53, 'PB0001', '2024-02-23', 'BRG-003', 'cv kreasi indonesia', 10, 10000, 100000);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_beli_head`
--

CREATE TABLE `tbl_beli_head` (
  `no_beli` varchar(20) NOT NULL,
  `tgl_beli` date NOT NULL,
  `supplier` varchar(255) NOT NULL,
  `total` int(11) NOT NULL,
  `keterangan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_beli_head`
--

INSERT INTO `tbl_beli_head` (`no_beli`, `tgl_beli`, `supplier`, `total`, `keterangan`) VALUES
('PB0001', '2024-02-23', '', 240000, '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customer`
--

CREATE TABLE `tbl_customer` (
  `id_customer` int(11) NOT NULL,
  `nama` varchar(256) NOT NULL,
  `telpon` varchar(15) NOT NULL,
  `deskripsi` varchar(256) NOT NULL,
  `alamat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_customer`
--

INSERT INTO `tbl_customer` (`id_customer`, `nama`, `telpon`, `deskripsi`, `alamat`) VALUES
(1, 'rakha', '813290123', 'umum', 'maja sari'),
(2, 'tes', '099832943', 'tes', 'tes'),
(3, 'umum', '0831729321', 'umum', 'umum');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_jual_detail`
--

CREATE TABLE `tbl_jual_detail` (
  `id` int(11) NOT NULL,
  `no_jual` varchar(20) NOT NULL,
  `tgl_jual` date NOT NULL,
  `barcode` varchar(100) NOT NULL,
  `nama_brg` varchar(100) NOT NULL,
  `qty` int(11) NOT NULL,
  `harga_jual` int(11) NOT NULL,
  `jml_harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_jual_detail`
--

INSERT INTO `tbl_jual_detail` (`id`, `no_jual`, `tgl_jual`, `barcode`, `nama_brg`, `qty`, `harga_jual`, `jml_harga`) VALUES
(37, 'PJ0001', '2024-02-23', '83210811231', 'susu bendera', 1, 12000, 12000),
(38, 'PJ0001', '2024-02-23', '3102818231', 'atribut logo smk ', 1, 5000, 5000),
(39, 'PJ0002', '2024-02-23', '83210811231', 'susu bendera', 1, 12000, 12000),
(40, 'PJ0003', '2024-02-23', '3102818231', 'atribut logo smk ', 1, 5000, 5000),
(41, 'PJ0004', '2024-02-23', '83210811231', 'susu bendera', 2, 12000, 24000),
(42, 'PJ0005', '2024-02-23', '3102818231', 'atribut logo smk ', 1, 5000, 5000),
(43, 'PJ0006', '2024-02-23', '83210811231', 'susu bendera', 1, 12000, 12000),
(44, 'PJ0006', '2024-02-23', '3102818231', 'atribut logo smk ', 1, 5000, 5000),
(45, 'PJ0006', '2024-02-23', '810238103131', 'cv kreasi indonesia', 1, 15000, 15000),
(47, 'PJ0007', '2024-02-23', '83210811231', 'susu bendera', 1, 12000, 12000),
(48, 'PJ0008', '2024-02-23', '3102818231', 'atribut logo smk ', 1, 5000, 5000),
(49, 'PJ0009', '2024-02-23', '83210811231', 'susu bendera', 1, 12000, 12000),
(50, 'PJ0010', '2024-02-23', '83210811231', 'susu bendera', 1, 12000, 12000);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_jual_head`
--

CREATE TABLE `tbl_jual_head` (
  `no_jual` varchar(20) NOT NULL,
  `tgl_jual` date NOT NULL,
  `customer` varchar(255) NOT NULL,
  `total` int(11) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `jml_bayar` int(11) NOT NULL,
  `kembalian` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_jual_head`
--

INSERT INTO `tbl_jual_head` (`no_jual`, `tgl_jual`, `customer`, `total`, `keterangan`, `jml_bayar`, `kembalian`) VALUES
('PJ0001', '2024-02-23', 'umum', 17000, '', 0, 0),
('PJ0002', '2024-02-23', 'umum', 12000, '', 15000, 3000),
('PJ0003', '2024-02-23', 'umum', 5000, '', 10000, 5000),
('PJ0004', '2024-02-23', 'umum', 24000, '', 25000, 1000),
('PJ0005', '2024-02-23', 'umum', 5000, '', 5000, 0),
('PJ0006', '2024-02-23', 'umum', 32000, '', 50000, 18000),
('PJ0007', '2024-02-23', 'umum', 12000, '', 15000, 3000),
('PJ0008', '2024-02-23', 'umum', 5000, '', 0, 0),
('PJ0009', '2024-02-23', 'umum', 12000, '', 0, 0),
('PJ0010', '2024-02-23', 'umum', 12000, '', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_supplier`
--

CREATE TABLE `tbl_supplier` (
  `id_supplier` int(11) NOT NULL,
  `nama` varchar(256) NOT NULL,
  `telpon` varchar(25) NOT NULL,
  `deskripsi` varchar(256) NOT NULL,
  `alamat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_supplier`
--

INSERT INTO `tbl_supplier` (`id_supplier`, `nama`, `telpon`, `deskripsi`, `alamat`) VALUES
(6, 'alan', 'opah', 'supp pulsa', 'cipacung'),
(7, 'rizky', '0831392183', 'supp rokok', 'kadu manggu'),
(8, 'ajat', '0931321901', 'supp masako', 'cikedal'),
(10, 'tesq', '20139023321', 'tes', 'tes');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `userid` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `fullname` varchar(150) NOT NULL,
  `password` varchar(256) NOT NULL,
  `address` varchar(100) NOT NULL,
  `telepon` varchar(15) NOT NULL,
  `privilege` enum('Admin','Owner','Pegawai','') NOT NULL,
  `foto` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`userid`, `username`, `fullname`, `password`, `address`, `telepon`, `privilege`, `foto`) VALUES
(114, 'admin', 'administartor', '$2y$10$gJxPDVgHvB1cQVZ2LKkw6OMGXzE0ATxjh2LQajzaZ9ji5JEb/yxUi', 'admin', '1234567890', 'Admin', 'default.png'),
(119, 'skensa', 'smk 1 pandeglang', '$2y$10$Zi0Qb0lA3r/Tu/EE1YYCp.vNCZuntFVCEiqu9hAADZTaf/01kYWcG', 'jln labuan no 05', '11238098', 'Owner', '893-logosmk.jpg'),
(120, 'arief', 'M Arief R', '$2y$10$NtW5WK3cWtvOex.iGnbeI.CNLRokJCKGB.kRYbxA/AdR/b7Kv3Sz2', 'Kp. Ciherang', '085163741320', 'Admin', '687-untirta.jpg'),
(124, 'setiawan', 'fahmi setiawan', '$2y$10$G.dotpd7DigYPjES5GNxg.hRmAn47dFPl1b/0ktZgl3pt1RXJvXAC', 'cihasem', '0831293019871', 'Pegawai', 'default.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_barang`
--
ALTER TABLE `tbl_barang`
  ADD PRIMARY KEY (`id_brg`);

--
-- Indexes for table `tbl_beli_detail`
--
ALTER TABLE `tbl_beli_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_beli_head`
--
ALTER TABLE `tbl_beli_head`
  ADD PRIMARY KEY (`no_beli`);

--
-- Indexes for table `tbl_customer`
--
ALTER TABLE `tbl_customer`
  ADD PRIMARY KEY (`id_customer`);

--
-- Indexes for table `tbl_jual_detail`
--
ALTER TABLE `tbl_jual_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_jual_head`
--
ALTER TABLE `tbl_jual_head`
  ADD PRIMARY KEY (`no_jual`);

--
-- Indexes for table `tbl_supplier`
--
ALTER TABLE `tbl_supplier`
  ADD PRIMARY KEY (`id_supplier`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_beli_detail`
--
ALTER TABLE `tbl_beli_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `tbl_customer`
--
ALTER TABLE `tbl_customer`
  MODIFY `id_customer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_jual_detail`
--
ALTER TABLE `tbl_jual_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `tbl_supplier`
--
ALTER TABLE `tbl_supplier`
  MODIFY `id_supplier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
