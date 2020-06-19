-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 17 Jun 2020 pada 08.09
-- Versi server: 10.4.6-MariaDB
-- Versi PHP: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
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
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `id` int(11) NOT NULL,
  `kodeBarang` varchar(50) NOT NULL,
  `namaBarang` varchar(100) NOT NULL,
  `satuan` varchar(30) NOT NULL,
  `hargaBeli` double NOT NULL,
  `stok` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`id`, `kodeBarang`, `namaBarang`, `satuan`, `hargaBeli`, `stok`) VALUES
(5, 'PO1590059826', 'Cangkul', 'set', 250000, 2),
(8, 'PO1590595980', 'Spare part ', 'bh', 10000000, 100),
(9, 'PO1590802204', 'Sparepart truk', 'bh', 10000000, 4),
(10, 'BRG1592096762', 'Palm Oil', 'liter', 100000, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang_jual`
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
-- Dumping data untuk tabel `barang_jual`
--

INSERT INTO `barang_jual` (`id`, `kodeBarangJual`, `namaBarangJual`, `idCustomer`, `tglJual`, `tglTempo`, `jumlahJual`, `satuan`, `hargaJual`) VALUES
(1, 'BJ1590597626', 'MInyak', 4, '2020-05-30', '2020-06-01', 4, 'Liter', 100000),
(2, 'BJ1590794530', 'Palm Oil', 9, '2020-05-30', '2020-06-28', 5, 'Liter', 100000),
(3, 'BJ1590802675', 'Minyak Sawit', 10, '2020-05-30', '2020-06-25', 6, 'Liter', 100000),
(4, 'BJ1592094962', 'Palm Oil', 9, '2020-06-14', '2020-06-19', 10, 'Liter', 100000),
(5, 'BJ1592359813', 'Palm Oil', 8, '2020-06-17', '2020-06-17', 20, 'Liter', 100000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang_keluar`
--

CREATE TABLE `barang_keluar` (
  `id` int(11) UNSIGNED NOT NULL,
  `kode_keluar` varchar(50) NOT NULL,
  `id_karyawan` int(11) NOT NULL,
  `tgl_keluar` date NOT NULL,
  `keterangan` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `barang_keluar`
--

INSERT INTO `barang_keluar` (`id`, `kode_keluar`, `id_karyawan`, `tgl_keluar`, `keterangan`) VALUES
(3, 'BK0000003', 1, '2020-06-14', 'Keperluan Kerja'),
(4, 'BK0000004', 2, '2020-06-14', 'Untuk Kerja'),
(5, 'BK0000005', 3, '2020-06-17', 'Keperluan kerja');

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang_keluar_detail`
--

CREATE TABLE `barang_keluar_detail` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_keluar` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `jumlah_keluar` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `barang_keluar_detail`
--

INSERT INTO `barang_keluar_detail` (`id`, `id_keluar`, `id_barang`, `jumlah_keluar`) VALUES
(4, 3, 8, 5),
(5, 3, 5, 6),
(6, 3, 9, 8),
(7, 4, 5, 2),
(8, 4, 9, 2),
(9, 5, 5, 2),
(10, 5, 8, 12);

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang_masuk`
--

CREATE TABLE `barang_masuk` (
  `id` int(11) NOT NULL,
  `kode_masuk` varchar(50) NOT NULL,
  `tgl_masuk` date NOT NULL,
  `tgl_tempo` date NOT NULL,
  `id_supplier` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `barang_masuk`
--

INSERT INTO `barang_masuk` (`id`, `kode_masuk`, `tgl_masuk`, `tgl_tempo`, `id_supplier`) VALUES
(1, 'INV0000001', '2020-06-13', '2020-06-10', 2),
(2, 'INV0000002', '2020-06-13', '2020-06-14', 1),
(3, 'INV0000003', '2020-06-13', '2020-06-30', 2),
(5, 'INV0000005', '2020-06-14', '2020-06-30', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang_masuk_detail`
--

CREATE TABLE `barang_masuk_detail` (
  `id` int(11) NOT NULL,
  `id_masuk` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `jumlah_masuk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `barang_masuk_detail`
--

INSERT INTO `barang_masuk_detail` (`id`, `id_masuk`, `id_barang`, `jumlah_masuk`) VALUES
(1, 1, 8, 20),
(2, 1, 9, 20),
(3, 1, 8, 20),
(4, 2, 8, 50),
(5, 2, 9, 50),
(6, 2, 5, 50),
(7, 3, 5, 30),
(15, 5, 5, 2),
(16, 5, 8, 2),
(17, 5, 9, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang_retur`
--

CREATE TABLE `barang_retur` (
  `id` int(11) NOT NULL,
  `kode_retur` varchar(50) NOT NULL,
  `id_supplier` int(11) NOT NULL,
  `tgl_retur` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `barang_retur`
--

INSERT INTO `barang_retur` (`id`, `kode_retur`, `id_supplier`, `tgl_retur`) VALUES
(2, 'INV0000002', 13, '2020-06-15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang_retur_detail`
--

CREATE TABLE `barang_retur_detail` (
  `id` int(11) NOT NULL,
  `id_retur` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `jumlah_retur` int(11) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `barang_retur_detail`
--

INSERT INTO `barang_retur_detail` (`id`, `id_retur`, `id_barang`, `jumlah_retur`, `keterangan`) VALUES
(3, 2, 9, 70, 'Rusak'),
(4, 2, 5, 600, 'Rusak');

-- --------------------------------------------------------

--
-- Struktur dari tabel `customer`
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
-- Dumping data untuk tabel `customer`
--

INSERT INTO `customer` (`id`, `kodeCustomer`, `namaCustomer`, `alamat`, `telp`, `penanggungJawab`, `tglPersetujuan`, `berkas`) VALUES
(4, 'CS1590597571', 'PT. Berkat', 'Palangka', '085251141111', 'Imah', '2020-05-30', ''),
(8, 'CS1590741703', 'PT. Sumber Jaya Abadi', '    A.Yani    ', '089618573639', 'Hoiriyah', '2020-05-29', '20200529CS1590741703.pdf'),
(9, 'CS1590794485', 'PT. Citra Putra Kebun Asri', 'Banjarmasin', '089618573639', 'Hendra', '2020-05-30', 'CS1590794485.pdf'),
(10, 'CS1590802577', 'PT. Suka Ria', 'BanjarBaru', '089618573639', 'Budi', '2020-05-30', 'CS1590802577.pdf');

-- --------------------------------------------------------

--
-- Struktur dari tabel `karyawan`
--

CREATE TABLE `karyawan` (
  `id` int(11) NOT NULL,
  `nik` varchar(30) NOT NULL,
  `namaKaryawan` varchar(50) NOT NULL,
  `noTelp` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `karyawan`
--

INSERT INTO `karyawan` (`id`, `nik`, `namaKaryawan`, `noTelp`) VALUES
(1, '89673272', 'Fahrul Razzi', '089627306954'),
(2, '9878654', 'Ibnu Hasfinoza', '089616564578'),
(3, '11367', 'Leonel Messi', '089627306954');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penagihan`
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
-- Dumping data untuk tabel `penagihan`
--

INSERT INTO `penagihan` (`id`, `kode_penagihan`, `id_jual`, `jangka_waktu`, `sisa_hutang`, `angsuran_perbulan`, `status`) VALUES
(1, 'PGN0000001', 4, 6, 0, 183333, 'Lunas'),
(2, 'PGN0000002', 5, 6, -2, 366667, 'Lunas'),
(3, 'PGN0000003', 1, 6, 366667, 73333, 'Belum Lunas'),
(4, 'PGN0000004', 2, 12, 504000, 45833, 'Belum Lunas'),
(5, 'PGN0000005', 3, 12, 605000, 55000, 'Belum Lunas'),
(6, 'PGN0000006', 3, 12, 605000, 55000, 'Belum Lunas');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penagihan_detail`
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
-- Dumping data untuk tabel `penagihan_detail`
--

INSERT INTO `penagihan_detail` (`id`, `id_penagihan`, `angsuran`, `jumlah_bayar`, `tgl_bayar`, `tgl_byr_selanjutnya`, `keterlambatan`, `denda`) VALUES
(2, 1, 0x416e67737572616e206b652d31, 183333, '2020-06-17', '2020-07-17', 'Tepat Waktu', 0),
(3, 1, 0x416e67737572616e206b652d32, 183333, '2020-07-17', '2020-08-17', 'Tepat Waktu', 0),
(4, 1, 0x416e67737572616e206b652d33, 183333, '2020-08-17', '2020-09-17', 'Tepat Waktu', 0),
(5, 1, 0x416e67737572616e206b652d34, 183333, '2020-09-17', '2020-10-17', 'Tepat Waktu', 0),
(6, 1, 0x416e67737572616e206b652d35, 183333, '2020-10-17', '2020-11-17', 'Tepat Waktu', 0),
(7, 1, 0x416e67737572616e206b652d36, 183333, '2020-11-17', '2020-12-17', 'Tepat Waktu', 0),
(8, 1, 0x416e67737572616e206b652d37, 250, '2020-12-17', '2021-01-17', 'Tepat Waktu', 0),
(9, 2, 0x416e67737572616e206b652d31, 466667, '2020-06-17', '2020-07-17', '1 Bulan', 100000),
(10, 2, 0x416e67737572616e206b652d32, 566667, '2020-07-17', '2020-08-17', '2 Bulan', 200000),
(11, 2, 0x416e67737572616e206b652d33, 366667, '2020-08-17', '2020-09-17', 'Tepat Waktu', 0),
(12, 2, 0x416e67737572616e206b652d34, 366667, '2020-09-17', '2020-10-17', 'Tepat Waktu', 0),
(13, 2, 0x416e67737572616e206b652d35, 366667, '2020-10-17', '2020-11-17', 'Tepat Waktu', 0),
(14, 2, 0x416e67737572616e206b652d36, 366667, '2020-11-17', '2020-12-17', 'Tepat Waktu', 0),
(15, 3, 0x416e67737572616e206b652d31, 73333, '2020-06-17', '2020-07-17', 'Tepat Waktu', 0),
(16, 4, 0x416e67737572616e206b652d31, 46000, '2020-06-17', '2020-07-17', 'Tepat Waktu', 0),
(17, 5, 0x416e67737572616e206b652d31, 55000, '2020-06-17', '2020-06-23', 'Tepat Waktu', 0),
(18, 6, 0x416e67737572616e206b652d31, 55000, '2020-06-17', '2020-06-24', 'Tepat Waktu', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `supplier`
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
-- Dumping data untuk tabel `supplier`
--

INSERT INTO `supplier` (`id`, `kodeSupplier`, `namaSupplier`, `alamat`, `telp`, `penanggungJawab`, `tglPersetujuan`, `berkas`) VALUES
(1, 'SP1589972159', 'PT. Sumber Jaya Abadi', ' Jl. A Yani KM 10 ', '081351278556', 'Sutrisno', '2020-05-30', ''),
(2, 'SP1590596424', 'PT. Angkasa', 'Banjarbaru', '089618573639', 'Ayi', '2020-05-28', ''),
(11, 'SP1590766322', 'adis', '  adis  ', '75558868687678', 'adis', '2020-05-29', '20200603SP1590766322.pdf'),
(12, 'SP1590802245', 'PT.CPKA', ' Banjarmasin ', '085251141111', 'Fahrul Razi', '2020-05-30', ''),
(13, 'SP1592183694', 'PT. Laut Timur Abadi', 'Jl. Ampera', '081351278556', 'Bambang', '2020-06-15', 'SP1592183694.pdf');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tagihan`
--

CREATE TABLE `tagihan` (
  `id` int(11) NOT NULL,
  `kodeTagihan` varchar(50) NOT NULL,
  `idMasuk` int(11) NOT NULL,
  `idSupplier` int(11) NOT NULL,
  `idBarang` int(50) NOT NULL,
  `ppn` varchar(12) NOT NULL,
  `tglTempo` date NOT NULL,
  `jumlahPembayaran` int(11) NOT NULL,
  `jumlahRetur` int(11) NOT NULL DEFAULT 0,
  `keterlambatan` varchar(30) NOT NULL,
  `denda` int(11) NOT NULL,
  `idPenanggungJawab` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tagihan`
--

INSERT INTO `tagihan` (`id`, `kodeTagihan`, `idMasuk`, `idSupplier`, `idBarang`, `ppn`, `tglTempo`, `jumlahPembayaran`, `jumlahRetur`, `keterlambatan`, `denda`, `idPenanggungJawab`) VALUES
(1, 'KT1590596838', 2, 2, 8, '10%', '2020-06-03', 900000, 3, 'Tepat Waktu', 0, 0),
(2, 'KT1590802474', 4, 12, 9, '10%', '2020-06-05', 5000000, 1, 'Tepat Waktu', 0, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `id_role` int(11) NOT NULL COMMENT '1 : Admin, 2: Manajer'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `id_role`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 1),
(2, 'manajer', '69b731ea8f289cf16a192ce78a37b4f0', 2),
(3, 'user', '6ad14ba9986e3615423dfca256d04e3f', 2);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `barang_jual`
--
ALTER TABLE `barang_jual`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `barang_keluar`
--
ALTER TABLE `barang_keluar`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `barang_keluar_detail`
--
ALTER TABLE `barang_keluar_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `barang_masuk_detail`
--
ALTER TABLE `barang_masuk_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `barang_retur`
--
ALTER TABLE `barang_retur`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `barang_retur_detail`
--
ALTER TABLE `barang_retur_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `penagihan`
--
ALTER TABLE `penagihan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `penagihan_detail`
--
ALTER TABLE `penagihan_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tagihan`
--
ALTER TABLE `tagihan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `barang_jual`
--
ALTER TABLE `barang_jual`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `barang_keluar`
--
ALTER TABLE `barang_keluar`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `barang_keluar_detail`
--
ALTER TABLE `barang_keluar_detail`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `barang_masuk`
--
ALTER TABLE `barang_masuk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `barang_masuk_detail`
--
ALTER TABLE `barang_masuk_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `barang_retur`
--
ALTER TABLE `barang_retur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `barang_retur_detail`
--
ALTER TABLE `barang_retur_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `karyawan`
--
ALTER TABLE `karyawan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `penagihan`
--
ALTER TABLE `penagihan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `penagihan_detail`
--
ALTER TABLE `penagihan_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `tagihan`
--
ALTER TABLE `tagihan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
