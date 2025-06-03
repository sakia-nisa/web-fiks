-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 03 Jun 2025 pada 07.44
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laundry`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `cabang`
--

CREATE TABLE `cabang` (
  `id_cabang` int(11) NOT NULL,
  `nama_cabang` varchar(100) DEFAULT NULL,
  `alamat` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `cabang`
--

INSERT INTO `cabang` (`id_cabang`, `nama_cabang`, `alamat`) VALUES
(1, 'NN Laundry', 'Jl. Dr. Hamka. Walisongo'),
(2, 'Sunny Laundry', 'Jl, Gajah Mungkur No.34, Semarang');

-- --------------------------------------------------------

--
-- Struktur dari tabel `deposit`
--

CREATE TABLE `deposit` (
  `id_deposit` int(11) NOT NULL,
  `id_pelanggan` int(11) DEFAULT NULL,
  `deposit_masuk` decimal(10,2) DEFAULT 0.00,
  `deposit_keluar` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `deposit`
--

INSERT INTO `deposit` (`id_deposit`, `id_pelanggan`, `deposit_masuk`, `deposit_keluar`) VALUES
(1, 1, 500000.00, 0.00),
(2, 2, 250000.00, 0.00),
(3, 4, 0.00, 100000.00),
(4, 5, 750000.00, 0.00),
(5, 6, 0.00, 50000.00),
(6, 23, 1000000.00, 0.00),
(7, 12, 300000.00, 0.00),
(8, 14, 0.00, 200000.00),
(9, 18, 200000.00, 0.00),
(10, 16, 0.00, 150000.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_transaksi`
--

CREATE TABLE `detail_transaksi` (
  `id_detail_transaksi` int(11) NOT NULL,
  `id_transaksi` int(11) DEFAULT NULL,
  `id_layanan` int(11) DEFAULT NULL,
  `satuan` enum('kilo','satuan') DEFAULT NULL,
  `berat` decimal(10,2) DEFAULT NULL,
  `harga` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `detail_transaksi`
--

INSERT INTO `detail_transaksi` (`id_detail_transaksi`, `id_transaksi`, `id_layanan`, `satuan`, `berat`, `harga`, `total`) VALUES
(1, 1, 1, '', 3.00, 7000.00, 21000.00),
(2, 2, 3, '', 2.00, 10000.00, 20000.00),
(3, 3, 2, '', 4.00, 6000.00, 24000.00),
(4, 4, 5, '', 1.00, 15000.00, 15000.00),
(5, 5, 4, '', 2.50, 9000.00, 22500.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `layanan`
--

CREATE TABLE `layanan` (
  `id_layanan` int(11) NOT NULL,
  `nama_layanan` varchar(100) DEFAULT NULL,
  `tipe` enum('reguler','express') DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `harga_per_kilo` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `layanan`
--

INSERT INTO `layanan` (`id_layanan`, `nama_layanan`, `tipe`, `deskripsi`, `harga_per_kilo`) VALUES
(1, 'Cuci Kering Setrika Reguler', 'reguler', 'Layanan cuci, kering, dan setrika untuk pakaian dengan estimasi waktu 2-3 hari.', 7000.00),
(2, 'Cuci Kering Lipat Reguler', 'reguler', 'Layanan cuci, kering, dan lipat pakaian dengan estimasi 2-3 hari.', 6000.00),
(3, 'Cuci Kering Setrika Express', 'express', 'Layanan express (selesai dalam 24 jam) untuk cuci, kering, dan setrika pakaian.', 10000.00),
(4, 'Cuci Kering Lipat Express', 'express', 'Layanan express (selesai dalam 24 jam) untuk cuci, kering, dan lipat pakaian.', 9000.00),
(5, 'Cuci Selimut', '', 'Layanan khusus untuk mencuci selimut atau item besar lainnya.', 15000.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pegawai`
--

CREATE TABLE `pegawai` (
  `id_pegawai` int(11) NOT NULL,
  `nama_pegawai` varchar(100) DEFAULT NULL,
  `id_cabang` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pegawai`
--

INSERT INTO `pegawai` (`id_pegawai`, `nama_pegawai`, `id_cabang`) VALUES
(1, 'Sakia', 1),
(2, 'Meiva', 1),
(3, 'Sevi', 2),
(4, 'Rusdi', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `nomor_telepon` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `catatan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `nama`, `nomor_telepon`, `email`, `alamat`, `catatan`) VALUES
(1, 'Johnny', '081234567890', 'johnny@email.com', 'Jakarta', 'Pelanggan prioritas'),
(2, 'Taeyong', '081234567891', 'taeyong@email.com', 'Surabaya', ''),
(3, 'Yuta', '081234567892', 'yuta@email.com', 'Bandung', 'Suka diskon'),
(4, 'Kun', '081234567893', 'kun@email.com', 'Semarang', 'Pembayaran cepat'),
(5, 'Doyoung', '081234567894', 'doyoung@email.com', 'Yogyakarta', ''),
(6, 'Ten', '081234567895', 'ten@email.com', 'Denpasar', ''),
(7, 'Jaehyun', '081234567896', 'jaehyun@email.com', 'Makassar', 'Ramah'),
(8, 'Winwin', '081234567897', 'winwin@email.com', 'Medan', ''),
(9, 'Jungwoo', '081234567898', 'jungwoo@email.com', 'Palembang', ''),
(10, 'Mark', '081234567899', 'mark@email.com', 'Bekasi', ''),
(11, 'Xiaojun', '081234567900', 'xiaojun@email.com', 'Depok', ''),
(12, 'Hendery', '081234567901', 'hendery@email.com', 'Tangerang', ''),
(13, 'Renjun', '081234567902', 'renjun@email.com', 'Bogor', 'Sering order'),
(14, 'Jeno', '081234567903', 'jeno@email.com', 'Malang', ''),
(15, 'Haechan', '081234567904', 'haechan@email.com', 'Pekanbaru', 'Pelanggan aktif'),
(16, 'Jaemin', '081234567905', 'jaemin@email.com', 'Manado', ''),
(17, 'Yangyang', '081234567906', 'yangyang@email.com', 'Pontianak', ''),
(18, 'Chenle', '081234567907', 'chenle@email.com', 'Samarinda', ''),
(19, 'Jisung', '081234567908', 'jisung@email.com', 'Padang', ''),
(20, 'Sion', '081234567909', 'sion@email.com', 'Batam', ''),
(21, 'Riku', '081234567910', 'riku@email.com', 'Solo', ''),
(22, 'Yushi', '081234567911', 'yushi@email.com', 'Cirebon', ''),
(23, 'Jaehee', '081234567912', 'jaehee@email.com', 'Purwokerto', ''),
(24, 'Ryo', '081234567913', 'ryo@email.com', 'Kediri', ''),
(25, 'Sakuya', '081234567914', 'sakuya@email.com', 'Madiun', ''),
(28, 'Karina', '845784', 'karina@gmail.com', 'Jl. Korea Raya', 'ada satu baju yang terkena node getah pisang'),
(30, 'Winter', '082134781808', 'winter@gmail.com', 'Jl. Korea', 'Yang wangi ya'),
(31, 'Winter', '82134781808', 'winter@gmail.com', 'Jl. Korea', ''),
(33, 'Giselle', '082134781802', 'giselle@gmail.com', 'asdassd', 'halo');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengeluaran`
--

CREATE TABLE `pengeluaran` (
  `id_pengeluaran` int(11) NOT NULL,
  `id_cabang` int(11) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `kode_pengeluaran` varchar(50) DEFAULT NULL,
  `nama_pengeluaran` varchar(100) DEFAULT NULL,
  `jumlah_pengeluaran` decimal(10,2) DEFAULT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `penjualan`
--

CREATE TABLE `penjualan` (
  `id_penjualan` int(11) NOT NULL,
  `id_pelanggan` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `cabang` varchar(100) DEFAULT NULL,
  `tanggal_masuk` datetime DEFAULT NULL,
  `jumlah_pakaian` int(11) DEFAULT NULL,
  `pembayaran` enum('depan','nanti') DEFAULT 'depan',
  `sub_pembayaran` enum('tunai','gopay','EDC','BCA EC','deposit') DEFAULT 'tunai',
  `diskon` int(11) DEFAULT 0,
  `cash` int(11) DEFAULT 0,
  `total` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `penjualan`
--

INSERT INTO `penjualan` (`id_penjualan`, `id_pelanggan`, `id_user`, `cabang`, `tanggal_masuk`, `jumlah_pakaian`, `pembayaran`, `sub_pembayaran`, `diskon`, `cash`, `total`, `created_at`) VALUES
(1, 7, 1, 'NN Laundry', '2025-05-29 09:50:00', 13, 'depan', 'tunai', 0, 7000, 7000, '2025-05-29 02:51:51'),
(8, 1, 1, 'NN Laundry', '2025-05-29 12:04:00', 11, 'depan', 'EDC', 10, 0, 19010, '2025-05-29 05:04:57'),
(9, 5, 1, 'NN Laundry', '2025-05-29 12:07:00', 11, 'depan', 'EDC', 1000, 0, 34000, '2025-05-29 05:12:56'),
(10, 18, 1, 'NN Laundry', '2025-05-29 12:20:00', 111, 'depan', 'tunai', 1000, 0, 5000, '2025-05-29 05:25:47'),
(11, 2, 1, 'NN Laundry', '2025-05-29 13:03:00', 15, 'depan', 'EDC', 1000, 0, 69000, '2025-05-29 06:03:57'),
(21, 23, 1, 'NN Laundry', '2025-06-03 11:46:00', 14, 'depan', 'tunai', 0, 60000, 60000, '2025-06-03 04:47:06'),
(22, 23, 1, 'NN Laundry', '2025-06-03 12:36:00', 13, 'depan', 'EDC', 0, 150000, 150000, '2025-06-03 05:37:19');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penjualan_detail`
--

CREATE TABLE `penjualan_detail` (
  `id_detail` int(11) NOT NULL,
  `id_penjualan` int(11) NOT NULL,
  `layanan` varchar(100) DEFAULT NULL,
  `berat` float DEFAULT 0,
  `estimasi_pengambilan` datetime DEFAULT NULL,
  `status` enum('proses','selesai') DEFAULT 'proses'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `penjualan_detail`
--

INSERT INTO `penjualan_detail` (`id_detail`, `id_penjualan`, `layanan`, `berat`, `estimasi_pengambilan`, `status`) VALUES
(1, 1, 'Cuci Kering Setrika Reguler', 1, '2025-05-31 09:50:00', 'selesai'),
(8, 8, 'Cuci Kering Lipat Reguler', 3.17, '2025-05-31 12:04:00', 'selesai'),
(9, 9, 'Cuci Kering Setrika Reguler', 5, '2025-05-31 12:07:00', 'selesai'),
(10, 10, 'Cuci Kering Lipat Reguler', 1, '2025-05-31 12:20:00', 'selesai'),
(11, 11, 'Cuci Kering Setrika Reguler', 10, '2025-05-31 13:03:00', 'selesai'),
(17, 21, 'Cuci Kering Lipat Reguler', 10, '2025-06-05 11:46:00', 'selesai'),
(18, 22, 'Cuci Kering Setrika Express', 15, '2025-06-05 12:36:00', 'selesai');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `id_pelanggan` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_cabang` int(11) DEFAULT NULL,
  `tanggal_masuk` datetime DEFAULT current_timestamp(),
  `estimasi_pengambilan` datetime DEFAULT NULL,
  `status` enum('belum diproses','selesai','dibayar') DEFAULT 'belum diproses',
  `jenis_pembayaran` enum('bayar di depan','bayar nanti') DEFAULT NULL,
  `sub_pembayaran` enum('EDC','go-pay','tunai','BCA EC','deposit') DEFAULT NULL,
  `diskon` decimal(10,2) DEFAULT 0.00,
  `total` decimal(10,2) DEFAULT NULL,
  `id_pegawai` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `id_pelanggan`, `id_user`, `id_cabang`, `tanggal_masuk`, `estimasi_pengambilan`, `status`, `jenis_pembayaran`, `sub_pembayaran`, `diskon`, `total`, `id_pegawai`) VALUES
(1, 1, 1, 1, '2025-05-20 00:00:00', '2025-05-23 00:00:00', 'selesai', 'bayar nanti', 'tunai', 0.00, 21000.00, NULL),
(2, 3, 1, 1, '2025-05-21 00:00:00', '2025-05-22 00:00:00', 'belum diproses', '', '', 2000.00, 18000.00, NULL),
(3, 5, 1, 1, '2025-05-22 00:00:00', '2025-05-24 00:00:00', 'selesai', '', '', 0.00, 24000.00, NULL),
(4, 7, 1, 1, '2025-05-22 00:00:00', '2025-05-25 00:00:00', 'belum diproses', '', '', 0.00, 22500.00, NULL),
(5, 9, 1, 1, '2025-05-23 00:00:00', '2025-05-24 00:00:00', 'belum diproses', '', '', 5000.00, 30000.00, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','kasir') DEFAULT 'kasir',
  `id_cabang` int(11) DEFAULT NULL,
  `id_pegawai` int(11) DEFAULT NULL,
  `total_pengerjaan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_user`, `username`, `email`, `password`, `role`, `id_cabang`, `id_pegawai`, `total_pengerjaan`) VALUES
(1, 'Sakia', 'sakia@gmail.com', '123', 'kasir', 1, 1, 3),
(2, 'Meiva', 'meiva@gmail.com', '221', 'kasir', 1, 2, 1),
(3, 'Sevi', 'sevi@gmail.com', '223', 'kasir', 2, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `cabang`
--
ALTER TABLE `cabang`
  ADD PRIMARY KEY (`id_cabang`);

--
-- Indeks untuk tabel `deposit`
--
ALTER TABLE `deposit`
  ADD PRIMARY KEY (`id_deposit`),
  ADD KEY `id_pelanggan` (`id_pelanggan`);

--
-- Indeks untuk tabel `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD PRIMARY KEY (`id_detail_transaksi`),
  ADD KEY `id_transaksi` (`id_transaksi`),
  ADD KEY `id_layanan` (`id_layanan`);

--
-- Indeks untuk tabel `layanan`
--
ALTER TABLE `layanan`
  ADD PRIMARY KEY (`id_layanan`);

--
-- Indeks untuk tabel `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`id_pegawai`),
  ADD KEY `id_cabang` (`id_cabang`);

--
-- Indeks untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indeks untuk tabel `pengeluaran`
--
ALTER TABLE `pengeluaran`
  ADD PRIMARY KEY (`id_pengeluaran`),
  ADD KEY `id_cabang` (`id_cabang`);

--
-- Indeks untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id_penjualan`),
  ADD KEY `id_pelanggan` (`id_pelanggan`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `penjualan_detail`
--
ALTER TABLE `penjualan_detail`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `id_penjualan` (`id_penjualan`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `id_pelanggan` (`id_pelanggan`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_cabang` (`id_cabang`),
  ADD KEY `id_pegawai` (`id_pegawai`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `id_cabang` (`id_cabang`),
  ADD KEY `id_pegawai` (`id_pegawai`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `cabang`
--
ALTER TABLE `cabang`
  MODIFY `id_cabang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `deposit`
--
ALTER TABLE `deposit`
  MODIFY `id_deposit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  MODIFY `id_detail_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT untuk tabel `layanan`
--
ALTER TABLE `layanan`
  MODIFY `id_layanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `id_pegawai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT untuk tabel `pengeluaran`
--
ALTER TABLE `pengeluaran`
  MODIFY `id_pengeluaran` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `id_penjualan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `penjualan_detail`
--
ALTER TABLE `penjualan_detail`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `deposit`
--
ALTER TABLE `deposit`
  ADD CONSTRAINT `deposit_ibfk_1` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`);

--
-- Ketidakleluasaan untuk tabel `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD CONSTRAINT `detail_transaksi_ibfk_1` FOREIGN KEY (`id_transaksi`) REFERENCES `transaksi` (`id_transaksi`),
  ADD CONSTRAINT `detail_transaksi_ibfk_2` FOREIGN KEY (`id_layanan`) REFERENCES `layanan` (`id_layanan`);

--
-- Ketidakleluasaan untuk tabel `pegawai`
--
ALTER TABLE `pegawai`
  ADD CONSTRAINT `pegawai_ibfk_1` FOREIGN KEY (`id_cabang`) REFERENCES `cabang` (`id_cabang`);

--
-- Ketidakleluasaan untuk tabel `pengeluaran`
--
ALTER TABLE `pengeluaran`
  ADD CONSTRAINT `pengeluaran_ibfk_1` FOREIGN KEY (`id_cabang`) REFERENCES `cabang` (`id_cabang`);

--
-- Ketidakleluasaan untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  ADD CONSTRAINT `penjualan_ibfk_1` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`) ON DELETE CASCADE,
  ADD CONSTRAINT `penjualan_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `penjualan_detail`
--
ALTER TABLE `penjualan_detail`
  ADD CONSTRAINT `penjualan_detail_ibfk_1` FOREIGN KEY (`id_penjualan`) REFERENCES `penjualan` (`id_penjualan`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`),
  ADD CONSTRAINT `transaksi_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `transaksi_ibfk_3` FOREIGN KEY (`id_cabang`) REFERENCES `cabang` (`id_cabang`),
  ADD CONSTRAINT `transaksi_ibfk_4` FOREIGN KEY (`id_pegawai`) REFERENCES `pegawai` (`id_pegawai`);

--
-- Ketidakleluasaan untuk tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`id_cabang`) REFERENCES `cabang` (`id_cabang`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
