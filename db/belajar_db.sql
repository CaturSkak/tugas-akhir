-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 27 Nov 2022 pada 08.21
-- Versi server: 10.4.11-MariaDB
-- Versi PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `belajar_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_jurusan`
--

CREATE TABLE `tbl_jurusan` (
  `jurusan_id` int(11) NOT NULL,
  `jurusan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_jurusan`
--

INSERT INTO `tbl_jurusan` (`jurusan_id`, `jurusan`) VALUES
(1, 'TEKNIK INFORMATIKA'),
(2, 'MANAJEMEN INFORMATIKA'),
(3, 'TEKNIK KOMPUTER');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_mahasiswa`
--

CREATE TABLE `tbl_mahasiswa` (
  `id` int(11) NOT NULL,
  `id_jurusan` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jenis_kelamin` varchar(100) NOT NULL,
  `kota` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_mahasiswa`
--

INSERT INTO `tbl_mahasiswa` (`id`, `id_jurusan`, `nama`, `jenis_kelamin`, `kota`) VALUES
(1, 2, 'Ahmad Catur Yulianto', 'Laki-laki', 'Lumajang'),
(4, 3, 'Roni', 'Laki-laki', 'Jember'),
(5, 3, 'Zaki', 'Laki-laki', 'Jember'),
(6, 2, 'Farhan', 'Laki-laki', 'Jember'),
(7, 3, 'Zaskia', 'Perempuan', 'Jember'),
(9, 3, 'Vina', 'Perempuan', 'Jember'),
(10, 3, 'Rani', 'Perempuan', 'Malang'),
(11, 3, 'Roy', 'Laki-laki', 'Jember'),
(12, 2, 'Ani', 'Perempuan', 'Jember'),
(15, 1, 'Andi', 'Laki-laki', 'Salatiga'),
(21, 2, 'AAAAA', 'Laki-laki', 'Salatiga'),
(25, 3, 'adsdsad', 'Perempuan', 'asdsadsa'),
(33, 1, 'zzzz', 'Laki-laki', 'zzzzz'),
(34, 2, 'asDAASD', 'Laki-laki', 'zzzz'),
(35, 2, 'asDAASD', 'Laki-laki', 'zzzz'),
(36, 1, 'ASSADSA', 'Perempuan', 'ASDASD'),
(37, 2, 'asasdadsd', 'Pilih jenis kelamin', 'adasds'),
(38, 1, 'adad', 'Laki-laki', 'adad');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_pengguna`
--

CREATE TABLE `tbl_pengguna` (
  `user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `tipe` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_pengguna`
--

INSERT INTO `tbl_pengguna` (`user_id`, `username`, `first_name`, `last_name`, `password`, `tipe`) VALUES
(1, 'aaaaa', 'aaa', 'vvvv', 'b0baee9d279d34fa1dfd71aadb908c3f', 2),
(2, 'Catur', 'Ahmad', 'Catur', 'b0baee9d279d34fa1dfd71aadb908c3f', 1),
(3, 'zzzzz', 'zzzz', 'zzzzz', 'b0baee9d279d34fa1dfd71aadb908c3f', 1),
(4, 'ccccc', 'cccc', 'cccc', 'b0baee9d279d34fa1dfd71aadb908c3f', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_tipe_pengguna`
--

CREATE TABLE `tbl_tipe_pengguna` (
  `tipe_id` int(2) NOT NULL,
  `pengguna` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_tipe_pengguna`
--

INSERT INTO `tbl_tipe_pengguna` (`tipe_id`, `pengguna`) VALUES
(1, 'Admin'),
(2, 'Customer');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tbl_jurusan`
--
ALTER TABLE `tbl_jurusan`
  ADD PRIMARY KEY (`jurusan_id`);

--
-- Indeks untuk tabel `tbl_mahasiswa`
--
ALTER TABLE `tbl_mahasiswa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_jurusan` (`id_jurusan`);

--
-- Indeks untuk tabel `tbl_pengguna`
--
ALTER TABLE `tbl_pengguna`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `tipe` (`tipe`);

--
-- Indeks untuk tabel `tbl_tipe_pengguna`
--
ALTER TABLE `tbl_tipe_pengguna`
  ADD PRIMARY KEY (`tipe_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tbl_jurusan`
--
ALTER TABLE `tbl_jurusan`
  MODIFY `jurusan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tbl_mahasiswa`
--
ALTER TABLE `tbl_mahasiswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT untuk tabel `tbl_pengguna`
--
ALTER TABLE `tbl_pengguna`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `tbl_tipe_pengguna`
--
ALTER TABLE `tbl_tipe_pengguna`
  MODIFY `tipe_id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tbl_mahasiswa`
--
ALTER TABLE `tbl_mahasiswa`
  ADD CONSTRAINT `tbl_join` FOREIGN KEY (`id_jurusan`) REFERENCES `tbl_jurusan` (`jurusan_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tbl_pengguna`
--
ALTER TABLE `tbl_pengguna`
  ADD CONSTRAINT `join` FOREIGN KEY (`tipe`) REFERENCES `tbl_tipe_pengguna` (`tipe_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
