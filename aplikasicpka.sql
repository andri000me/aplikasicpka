-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 19, 2020 at 08:45 PM
-- Server version: 10.1.44-MariaDB-0ubuntu0.18.04.1
-- PHP Version: 7.2.24-0ubuntu0.18.04.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aplikasicpka`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id` int(11) NOT NULL,
  `kodeBarang` varchar(50) NOT NULL,
  `namaBarang` varchar(100) NOT NULL,
  `satuan` varchar(30) NOT NULL,
  `hargaBeli` double NOT NULL,
  `stok` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id`, `kodeBarang`, `namaBarang`, `satuan`, `hargaBeli`, `stok`) VALUES
(1, 'BRG1592569328', 'spare part', 'bh', 4500000, 2);

-- --------------------------------------------------------

--
-- Table structure for table `barang_jual`
--

CREATE TABLE `barang_jual` (
  `id` int(11) NOT NULL,
  `kodeBarangJual` varchar(50) NOT NULL,
  `namaBarangJual` varchar(30) NOT NULL,
  `idCustomer` int(11) NOT NULL,
  `tglJual` date NOT NULL,
  `tglTempo` date NOT NULL,
  `jumlahJual` int(11) NOT NULL,
  `satuan` varchar(50) NOT NULL,
  `hargaJual` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barang_jual`
--

INSERT INTO `barang_jual` (`id`, `kodeBarangJual`, `namaBarangJual`, `idCustomer`, `tglJual`, `tglTempo`, `jumlahJual`, `satuan`, `hargaJual`) VALUES
(1, 'BJ1592569635', 'Palm Oil', 1, '2020-06-19', '2020-12-19', 1000, 'Liter', 100000);

-- --------------------------------------------------------

--
-- Table structure for table `barang_keluar`
--

CREATE TABLE `barang_keluar` (
  `id` int(11) UNSIGNED NOT NULL,
  `kode_keluar` varchar(50) NOT NULL,
  `id_karyawan` int(11) NOT NULL,
  `tgl_keluar` date NOT NULL,
  `keterangan` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barang_keluar`
--

INSERT INTO `barang_keluar` (`id`, `kode_keluar`, `id_karyawan`, `tgl_keluar`, `keterangan`) VALUES
(1, 'BK0000001', 3, '2020-06-19', 'Untuk Keperluan Kerja');

-- --------------------------------------------------------

--
-- Table structure for table `barang_keluar_detail`
--

CREATE TABLE `barang_keluar_detail` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_keluar` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `jumlah_keluar` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barang_keluar_detail`
--

INSERT INTO `barang_keluar_detail` (`id`, `id_keluar`, `id_barang`, `jumlah_keluar`) VALUES
(1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `barang_masuk`
--

CREATE TABLE `barang_masuk` (
  `id` int(11) NOT NULL,
  `kode_masuk` varchar(50) NOT NULL,
  `tgl_masuk` date NOT NULL,
  `tgl_tempo` date NOT NULL,
  `id_supplier` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barang_masuk`
--

INSERT INTO `barang_masuk` (`id`, `kode_masuk`, `tgl_masuk`, `tgl_tempo`, `id_supplier`) VALUES
(1, 'INV0000001', '2020-06-19', '2020-12-19', 1);

-- --------------------------------------------------------

--
-- Table structure for table `barang_masuk_detail`
--

CREATE TABLE `barang_masuk_detail` (
  `id` int(11) NOT NULL,
  `id_masuk` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `jumlah_masuk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barang_masuk_detail`
--

INSERT INTO `barang_masuk_detail` (`id`, `id_masuk`, `id_barang`, `jumlah_masuk`) VALUES
(1, 1, 1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `barang_retur`
--

CREATE TABLE `barang_retur` (
  `id` int(11) NOT NULL,
  `kode_retur` varchar(50) NOT NULL,
  `id_supplier` int(11) NOT NULL,
  `tgl_retur` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barang_retur`
--

INSERT INTO `barang_retur` (`id`, `kode_retur`, `id_supplier`, `tgl_retur`) VALUES
(1, 'RTR0000001', 1, '2020-06-19');

-- --------------------------------------------------------

--
-- Table structure for table `barang_retur_detail`
--

CREATE TABLE `barang_retur_detail` (
  `id` int(11) NOT NULL,
  `id_retur` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `jumlah_retur` int(11) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barang_retur_detail`
--

INSERT INTO `barang_retur_detail` (`id`, `id_retur`, `id_barang`, `jumlah_retur`, `keterangan`) VALUES
(1, 1, 1, 1, 'Rusak');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `kodeCustomer` varchar(50) NOT NULL,
  `namaCustomer` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `telp` varchar(14) NOT NULL,
  `penanggungJawab` varchar(100) NOT NULL,
  `tglPersetujuan` date NOT NULL,
  `berkas` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `kodeCustomer`, `namaCustomer`, `alamat`, `telp`, `penanggungJawab`, `tglPersetujuan`, `berkas`) VALUES
(1, 'CS1592569369', 'PT. Sumber Jaya Abadi', 'Jl. A Yani Km 7.0', '089627306954', 'Bambang Prakarsa', '2020-06-19', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `karyawan`
--

CREATE TABLE `karyawan` (
  `id` int(11) NOT NULL,
  `nik` varchar(30) NOT NULL,
  `namaKaryawan` varchar(50) NOT NULL,
  `noTelp` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `karyawan`
--

INSERT INTO `karyawan` (`id`, `nik`, `namaKaryawan`, `noTelp`) VALUES
(1, '11367', 'Fahrul Razzi', '089627306954'),
(2, '11369', 'Ibnu Hasfinoza', '089627306954'),
(3, '18928', 'Razzy Tirta', '089627306954');

-- --------------------------------------------------------

--
-- Table structure for table `penagihan`
--

CREATE TABLE `penagihan` (
  `id` int(11) NOT NULL,
  `kode_penagihan` varchar(15) NOT NULL,
  `id_jual` int(11) NOT NULL,
  `jangka_waktu` int(11) NOT NULL,
  `sisa_hutang` int(11) NOT NULL,
  `angsuran_perbulan` int(11) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penagihan`
--

INSERT INTO `penagihan` (`id`, `kode_penagihan`, `id_jual`, `jangka_waktu`, `sisa_hutang`, `angsuran_perbulan`, `status`) VALUES
(1, 'PGN0000001', 1, 12, 100833000, 9166667, 'Belum Lunas');

-- --------------------------------------------------------

--
-- Table structure for table `penagihan_detail`
--

CREATE TABLE `penagihan_detail` (
  `id` int(11) NOT NULL,
  `id_penagihan` int(11) NOT NULL,
  `angsuran` varbinary(30) NOT NULL,
  `jumlah_bayar` int(11) NOT NULL,
  `tgl_bayar` date NOT NULL,
  `tgl_byr_selanjutnya` date NOT NULL,
  `keterlambatan` varchar(30) NOT NULL,
  `denda` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penagihan_detail`
--

INSERT INTO `penagihan_detail` (`id`, `id_penagihan`, `angsuran`, `jumlah_bayar`, `tgl_bayar`, `tgl_byr_selanjutnya`, `keterlambatan`, `denda`) VALUES
(1, 1, 0x416e67737572616e206b652d31, 9167000, '2020-06-19', '2020-07-19', 'Tepat Waktu', 0);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id` int(11) NOT NULL,
  `kodeSupplier` varchar(50) NOT NULL,
  `namaSupplier` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `telp` varchar(14) NOT NULL,
  `penanggungJawab` varchar(100) NOT NULL,
  `tglPersetujuan` date NOT NULL,
  `berkas` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id`, `kodeSupplier`, `namaSupplier`, `alamat`, `telp`, `penanggungJawab`, `tglPersetujuan`, `berkas`) VALUES
(1, 'SP1592569425', 'PT. Laut Timur Abadi', 'Jl. Lambung Mangkurat', '089627306954', 'Leonard Andreas', '2020-06-19', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tagihan`
--

CREATE TABLE `tagihan` (
  `id` int(11) NOT NULL,
  `kode_tagihan` varchar(50) NOT NULL,
  `id_masuk` int(11) NOT NULL,
  `no_retur` varchar(11) DEFAULT NULL,
  `jangka_waktu` int(11) NOT NULL,
  `jumlah_retur` int(11) NOT NULL,
  `sisa_hutang` int(11) NOT NULL,
  `angsuran_perbulan` int(11) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tagihan`
--

INSERT INTO `tagihan` (`id`, `kode_tagihan`, `id_masuk`, `no_retur`, `jangka_waktu`, `jumlah_retur`, `sisa_hutang`, `angsuran_perbulan`, `status`) VALUES
(1, 'TG0000001', 1, 'RTR0000001', 12, 4950000, 13612500, 1237500, 'Belum Lunas');

-- --------------------------------------------------------

--
-- Table structure for table `tagihan_detail`
--

CREATE TABLE `tagihan_detail` (
  `id` int(11) NOT NULL,
  `id_tagihan` int(11) NOT NULL,
  `angsuran` varchar(30) NOT NULL,
  `jumlah_bayar` int(11) NOT NULL,
  `tgl_bayar` date NOT NULL,
  `tgl_byr_selanjutnya` date NOT NULL,
  `keterlambatan` varchar(30) NOT NULL,
  `denda` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tagihan_detail`
--

INSERT INTO `tagihan_detail` (`id`, `id_tagihan`, `angsuran`, `jumlah_bayar`, `tgl_bayar`, `tgl_byr_selanjutnya`, `keterlambatan`, `denda`) VALUES
(1, 1, 'Angsuran ke-1', 1237500, '2020-06-19', '2020-07-19', 'Tepat Waktu', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `id_role` int(11) NOT NULL COMMENT '1 : Admin, 2: Manajer'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `id_role`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 1),
(2, 'manajer', '69b731ea8f289cf16a192ce78a37b4f0', 2),
(3, 'user', '6ad14ba9986e3615423dfca256d04e3f', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `barang_jual`
--
ALTER TABLE `barang_jual`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `barang_keluar`
--
ALTER TABLE `barang_keluar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `barang_keluar_detail`
--
ALTER TABLE `barang_keluar_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `barang_masuk_detail`
--
ALTER TABLE `barang_masuk_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `barang_retur`
--
ALTER TABLE `barang_retur`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `barang_retur_detail`
--
ALTER TABLE `barang_retur_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `penagihan`
--
ALTER TABLE `penagihan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `penagihan_detail`
--
ALTER TABLE `penagihan_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tagihan`
--
ALTER TABLE `tagihan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tagihan_detail`
--
ALTER TABLE `tagihan_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `barang_jual`
--
ALTER TABLE `barang_jual`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `barang_keluar`
--
ALTER TABLE `barang_keluar`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `barang_keluar_detail`
--
ALTER TABLE `barang_keluar_detail`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `barang_masuk_detail`
--
ALTER TABLE `barang_masuk_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `barang_retur`
--
ALTER TABLE `barang_retur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `barang_retur_detail`
--
ALTER TABLE `barang_retur_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `karyawan`
--
ALTER TABLE `karyawan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `penagihan`
--
ALTER TABLE `penagihan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `penagihan_detail`
--
ALTER TABLE `penagihan_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tagihan`
--
ALTER TABLE `tagihan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tagihan_detail`
--
ALTER TABLE `tagihan_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
