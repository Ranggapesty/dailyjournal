-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 10, 2025 at 01:07 PM
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
-- Database: `webdailyjournal`
--

-- --------------------------------------------------------

--
-- Table structure for table `article`
--

CREATE TABLE `article` (
  `id` int(11) NOT NULL,
  `judul` text NOT NULL,
  `isi` text NOT NULL,
  `gambar` text NOT NULL,
  `tanggal` datetime NOT NULL,
  `username` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `article`
--

INSERT INTO `article` (`id`, `judul`, `isi`, `gambar`, `tanggal`, `username`) VALUES
(1, 'Makan Bergizi Gratis Jadi Program Paling Disambut Positif Masyarakat', 'Hasil survei LSI Denny JA soal 100 hari kinerja pemerintahan Prabowo-Gibran mencatat makan bergizi gratis (MBG) sebagai program yang paling mendapatkan respons positif dari masyarakat.', 'artikel1.jpeg', '2025-12-10 12:11:27', 'admin'),
(2, 'Program MBG Perkuat Upaya Perbaikan Gizi Anak di Seluruh Negeri', 'Program Makan Bergizi Gratis (MBG) menunjukkan hasil positit dalam mendukung peningkatan kualitas gizi dan kesehatan anak-anak di berbagai daerah. Kepala Badan Gizi Nasional (BGN), Dadan Hindayana, menyebut program ini\r\nmenjadi salah satu langkah strategis untuk memastikan anak Indonesia tumbuh sehat dan produktif di masa depan.', 'article2.jpeg', '2025-12-10 12:26:58', 'admin'),
(3, 'Makan Bergizi Gratis: Investasi Gizi untuk Masa Depan Indonesia', 'Pemerintah Indonesia menunjukkan komitmen serius dalam membangun sumber days manusia unggul melalui peluncuran Program Makan Bergizi Gratis (MBG)', 'article3.jpeg', '2025-12-10 12:26:58', 'admin'),
(4, 'Puluhan Siswa SMP di Banjar Jabar Keracunan MBG', 'Puluhan siswa SMP Negeri 3 Banjar, Jawa Barat mengalami keracunan usai menyantap makan bergizi gratis (MBG), Rabu (1/10). Saat ini beberapa siswa dilarikan ke rumah sakit untuk mendapatkan penanganan.', 'article4.jpeg', '2025-12-10 12:29:08', 'admin'),
(5, 'Marak Keracunan MBG, Pantaskah BGN Minta Tambah Anggaran Rp28 T?', 'Kepala Badan Gizi Nasional (BGN) Dadan Hindayana mengakui ada 4.711 porsi makan bergizi gratis (MBG) yang menimbulkan gangguan kesehatan pada anak.', 'article5.jpeg', '2025-12-10 12:29:08', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `article`
--
ALTER TABLE `article`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
