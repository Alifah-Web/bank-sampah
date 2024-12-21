-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 05 Des 2024 pada 13.32
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bank_sampah`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_sampah`
--

CREATE TABLE `data_sampah` (
  `id` int(11) NOT NULL,
  `id_nasabah` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `tanggal` date NOT NULL,
  `harga` varchar(20) NOT NULL,
  `berat` int(11) NOT NULL,
  `jenis` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `data_sampah`
--

INSERT INTO `data_sampah` (`id`, `id_nasabah`, `nama`, `tanggal`, `harga`, `berat`, `jenis`) VALUES
(1, 113, 'Aegon', '2024-12-26', '30000', 6, 'Sampah Plastik'),
(3, 113, 'Aegon', '2024-12-05', '30000', 10, 'Sampah Kaca');

-- --------------------------------------------------------

--
-- Struktur dari tabel `nasabah`
--

CREATE TABLE `nasabah` (
  `tanggal` date NOT NULL,
  `id_nasabah` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `no_reg` int(11) NOT NULL,
  `kontak` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `nasabah`
--

INSERT INTO `nasabah` (`tanggal`, `id_nasabah`, `nama`, `no_reg`, `kontak`, `alamat`) VALUES
('2024-12-04', 112, 'Aegon', 90909, '09898091', 'Makassar'),
('2024-12-04', 113, 'Aegon', 90909, '12', 'Makassar'),
('2024-12-28', 115, 'Raenyra Targaryen', 90909, '9898091', 'Makassar');

-- --------------------------------------------------------

--
-- Struktur dari tabel `registrasi`
--

CREATE TABLE `registrasi` (
  `id` int(11) NOT NULL,
  `fName` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `registrasi`
--

INSERT INTO `registrasi` (`id`, `fName`, `email`, `password`) VALUES
(1, 'admin1', 'admin1@gmail.com', 'admin12345');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `data_sampah`
--
ALTER TABLE `data_sampah`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `nasabah`
--
ALTER TABLE `nasabah`
  ADD PRIMARY KEY (`id_nasabah`);

--
-- Indeks untuk tabel `registrasi`
--
ALTER TABLE `registrasi`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `data_sampah`
--
ALTER TABLE `data_sampah`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `nasabah`
--
ALTER TABLE `nasabah`
  MODIFY `id_nasabah` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT untuk tabel `registrasi`
--
ALTER TABLE `registrasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
