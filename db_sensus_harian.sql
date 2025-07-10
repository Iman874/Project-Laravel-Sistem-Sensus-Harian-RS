-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 10 Jul 2025 pada 14.20
-- Versi server: 10.4.27-MariaDB
-- Versi PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_sensus_harian`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `bangsal`
--

CREATE TABLE `bangsal` (
  `kd_bangsal` bigint(20) UNSIGNED NOT NULL,
  `nama_bangsal` varchar(255) NOT NULL,
  `total_tempat_tidur` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `bangsal`
--

INSERT INTO `bangsal` (`kd_bangsal`, `nama_bangsal`, `total_tempat_tidur`, `created_at`, `updated_at`) VALUES
(1, 'Bedah', 40, NULL, NULL),
(2, 'Anak', 21, NULL, NULL),
(3, 'Kebidanan', 24, NULL, NULL),
(4, 'Paviliun Nantongga', 21, NULL, NULL),
(5, 'Indera', 10, NULL, NULL),
(6, 'Paru', 16, NULL, NULL),
(7, 'Jantung', 11, NULL, NULL),
(8, 'Neurologi', 12, NULL, NULL),
(9, 'Interne', 28, NULL, NULL),
(10, 'ICU', 12, NULL, NULL),
(11, 'NICU', 8, NULL, NULL),
(12, 'Perinatologi', 4, NULL, NULL),
(13, 'Observasi Bayi', 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelas_bangsal`
--

CREATE TABLE `kelas_bangsal` (
  `id_kelas` bigint(20) UNSIGNED NOT NULL,
  `nama_kelas` varchar(255) NOT NULL,
  `jenis_kelas` varchar(255) DEFAULT NULL,
  `jumlah_tempat_tidur` int(11) NOT NULL,
  `fk_kd_bangsal` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kelas_bangsal`
--

INSERT INTO `kelas_bangsal` (`id_kelas`, `nama_kelas`, `jenis_kelas`, `jumlah_tempat_tidur`, `fk_kd_bangsal`, `created_at`, `updated_at`) VALUES
(1, 'Melati 1', 'Kelas 1', 2, 1, NULL, NULL),
(2, 'Melati 2', 'Kelas 1', 2, 1, NULL, NULL),
(3, 'Melati 3', 'Kelas 1', 2, 1, NULL, NULL),
(4, 'Melati 4', 'Kelas 1', 2, 1, NULL, NULL),
(5, 'Melati 5', 'Kelas 1', 2, 1, NULL, NULL),
(6, 'Melati 6', 'Kelas 1', 2, 1, NULL, NULL),
(7, 'Melati 7', 'Kelas 1', 2, 1, NULL, NULL),
(8, 'Melati 8', 'Kelas 1', 2, 1, NULL, NULL),
(9, 'II B', 'Kelas 2', 2, 1, NULL, NULL),
(10, 'II C', 'Kelas 2', 2, 1, NULL, NULL),
(11, 'II D', 'Kelas 2', 2, 1, NULL, NULL),
(12, 'III Pria', 'Kelas 3', 4, 1, NULL, NULL),
(13, 'III Wanita', 'Kelas 3', 4, 1, NULL, NULL),
(14, 'III Isolasi', 'Kelas 3', 4, 1, NULL, NULL),
(15, 'III Anak', 'Kelas 3', 3, 1, NULL, NULL),
(16, 'HCU', '-', 3, 1, NULL, NULL),
(17, 'IA', 'Kelas 1', 1, 2, NULL, NULL),
(18, 'IB', 'Kelas 1', 1, 2, NULL, NULL),
(19, 'IC', 'Kelas 1', 1, 2, NULL, NULL),
(20, 'ID', 'Kelas 1', 1, 2, NULL, NULL),
(21, 'IE', 'Kelas 1', 1, 2, NULL, NULL),
(22, 'IIA', 'Kelas 2', 2, 2, NULL, NULL),
(23, 'IIB', 'Kelas 2', 3, 2, NULL, NULL),
(24, 'III A', 'Kelas 3', 4, 2, NULL, NULL),
(25, 'III B', 'Kelas 3', 4, 2, NULL, NULL),
(26, 'HCU', '-', 3, 2, NULL, NULL),
(27, 'I', 'Kelas 1', 2, 3, NULL, NULL),
(28, 'II', 'Kelas 2', 2, 3, NULL, NULL),
(29, 'III obs', 'Kelas 3', 6, 3, NULL, NULL),
(30, 'III gyn', 'Kelas 3', 6, 3, NULL, NULL),
(31, 'HCU', '-', 4, 3, NULL, NULL),
(32, 'VK', '-', 4, 3, NULL, NULL),
(33, 'Lili 1', 'Kelas 1', 2, 4, NULL, NULL),
(34, 'Lili 2', 'Kelas 1', 2, 4, NULL, NULL),
(35, 'Lili 3', 'Kelas 1', 2, 4, NULL, NULL),
(36, 'Lili 4', 'Kelas 1', 2, 4, NULL, NULL),
(37, 'Lili 5', 'Kelas 1', 2, 4, NULL, NULL),
(38, 'Lili 7', 'Kelas 1', 2, 4, NULL, NULL),
(39, 'Anggrek 1', 'Kelas 1', 1, 4, NULL, NULL),
(40, 'Anggrek 2', 'Kelas 1', 1, 4, NULL, NULL),
(41, 'Anggrek 3', 'Kelas 1', 1, 4, NULL, NULL),
(42, 'Anggrek 4', 'Kelas 1', 1, 4, NULL, NULL),
(43, 'Anggrek 5', 'Kelas 1', 1, 4, NULL, NULL),
(44, 'Anggrek 6', 'Kelas 1', 1, 4, NULL, NULL),
(45, 'Anggrek 7', 'Kelas 1', 1, 4, NULL, NULL),
(46, 'Bougenville 1', 'VIP', 1, 4, NULL, NULL),
(47, 'Bougenville 2', 'VIP', 1, 4, NULL, NULL),
(48, 'II', 'Kelas 2', 4, 5, NULL, NULL),
(49, 'III', 'Kelas 3', 6, 5, NULL, NULL),
(50, 'III Pria', 'Kelas 3', 6, 6, NULL, NULL),
(51, 'III Wanita', 'Kelas 3', 6, 6, NULL, NULL),
(52, 'Isolasi SO', '-', 2, 6, NULL, NULL),
(53, 'Isolasi RO', '-', 2, 6, NULL, NULL),
(54, 'I A', 'Kelas 1', 2, 7, NULL, NULL),
(55, 'I B', 'Kelas 1', 1, 7, NULL, NULL),
(56, 'II', 'Kelas 2', 2, 7, NULL, NULL),
(57, 'III A', 'Kelas 3', 3, 7, NULL, NULL),
(58, 'III B', 'Kelas 3', 3, 7, NULL, NULL),
(59, 'I', 'Kelas 1', 1, 8, NULL, NULL),
(60, 'II A', 'Kelas 2', 2, 8, NULL, NULL),
(61, 'II B', 'Kelas 2', 2, 8, NULL, NULL),
(62, 'III A', 'Kelas 3', 2, 8, NULL, NULL),
(63, 'III B', 'Kelas 3', 3, 8, NULL, NULL),
(64, 'HCU', '-', 2, 8, NULL, NULL),
(65, 'II A', 'Kelas 2', 2, 9, NULL, NULL),
(66, 'II B', 'Kelas 2', 2, 9, NULL, NULL),
(67, 'III W 1', 'Kelas 3', 4, 9, NULL, NULL),
(68, 'III W 2', 'Kelas 3', 4, 9, NULL, NULL),
(69, 'III W 3', 'Kelas 3', 3, 9, NULL, NULL),
(70, 'III P 1', 'Kelas 3', 3, 9, NULL, NULL),
(71, 'III P 2', 'Kelas 3', 4, 9, NULL, NULL),
(72, 'HCU', '-', 6, 9, NULL, NULL),
(73, 'ICU', '-', 12, 10, NULL, NULL),
(74, 'NICU', '-', 8, 11, NULL, NULL),
(75, 'Perinatologi', '-', 4, 12, NULL, NULL),
(76, 'Observasi Bayi', '-', 2, 13, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kepala_instalasi`
--

CREATE TABLE `kepala_instalasi` (
  `id_kepala_instalasi` bigint(20) UNSIGNED NOT NULL DEFAULT 1,
  `username` varchar(255) NOT NULL DEFAULT 'kepala_instalasi',
  `password` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `gelar` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'kepala_instalasi',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kepala_instalasi`
--

INSERT INTO `kepala_instalasi` (`id_kepala_instalasi`, `username`, `password`, `nama`, `gelar`, `role`, `created_at`, `updated_at`) VALUES
(1, 'kepala1', '$2y$12$0b1JKcQQFNlo6konpeqNrOBP8DdlPZVE9I7RgKTda0JayqYfEbnBy', 'Kepala Satu', 'Dr.', 'kepala_instalasi', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan`
--

CREATE TABLE `laporan` (
  `id_laporan` bigint(20) UNSIGNED NOT NULL,
  `id_petugas` varchar(255) NOT NULL,
  `id_kepala_instalasi` varchar(255) NOT NULL,
  `nama_laporan` varchar(255) NOT NULL,
  `tanggal_kirim` datetime NOT NULL,
  `tanggal_dibaca` datetime NOT NULL,
  `komentar` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `logs_tabel_pasien`
--

CREATE TABLE `logs_tabel_pasien` (
  `id_logs` bigint(20) UNSIGNED NOT NULL,
  `action` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `id_role` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `logs_tabel_pasien`
--

INSERT INTO `logs_tabel_pasien` (`id_logs`, `action`, `role`, `id_role`, `created_at`, `updated_at`) VALUES
(1, '2025-01-01 23:31:19', 'Developer', '1', NULL, NULL),
(2, '2025-01-01 23:31:19', 'Developer', '1', NULL, NULL),
(3, '2025-01-01 23:31:19', 'Developer', '1', NULL, NULL),
(4, '2025-01-01 23:31:19', 'Developer', '1', NULL, NULL),
(5, '2025-01-01 23:31:19', 'Developer', '1', NULL, NULL),
(6, '2025-01-01 23:31:19', 'Developer', '1', NULL, NULL),
(7, '2025-01-01 23:31:19', 'Developer', '1', NULL, NULL),
(8, '2025-01-01 23:31:19', 'Developer', '1', NULL, NULL),
(9, '2025-01-01 23:31:19', 'Developer', '1', NULL, NULL),
(10, '2025-01-01 23:31:19', 'Developer', '1', NULL, NULL),
(11, '2025-01-01 23:31:19', 'Developer', '1', NULL, NULL),
(12, '2025-01-01 23:31:19', 'Developer', '1', NULL, NULL),
(13, '2025-01-01 23:31:19', 'Developer', '1', NULL, NULL),
(14, '2025-01-01 23:31:19', 'Developer', '1', NULL, NULL),
(15, '2025-01-01 23:31:19', 'Developer', '1', NULL, NULL),
(16, '2025-01-01 23:31:19', 'Developer', '1', NULL, NULL),
(17, '2025-01-01 23:31:19', 'Developer', '1', NULL, NULL),
(18, '2025-01-01 23:31:19', 'Developer', '1', NULL, NULL),
(19, '2025-01-01 23:31:19', 'Developer', '1', NULL, NULL),
(20, '2025-01-01 23:31:19', 'Developer', '1', NULL, NULL),
(21, '2025-01-01 23:31:19', 'Developer', '1', NULL, NULL),
(22, '2025-01-01 23:31:19', 'Developer', '1', NULL, NULL),
(23, '2025-01-01 23:31:19', 'Developer', '1', NULL, NULL),
(24, '2025-01-01 23:31:19', 'Developer', '1', NULL, NULL),
(25, '2025-01-01 23:31:19', 'Developer', '1', NULL, NULL),
(26, '2025-01-01 23:31:19', 'Developer', '1', NULL, NULL),
(27, '2025-01-01 23:31:19', 'Developer', '1', NULL, NULL),
(28, '2025-01-01 23:31:19', 'Developer', '1', NULL, NULL),
(29, '2025-01-01 23:31:19', 'Developer', '1', NULL, NULL),
(30, '2025-01-01 23:31:19', 'Developer', '1', NULL, NULL),
(31, '2025-01-01 23:31:19', 'Developer', '1', NULL, NULL),
(32, '2025-01-01 23:31:19', 'Developer', '1', NULL, NULL),
(33, '2025-01-01 23:31:19', 'Developer', '1', NULL, NULL),
(34, '2025-01-01 23:31:19', 'Developer', '1', NULL, NULL),
(35, '2025-01-01 23:31:19', 'Developer', '1', NULL, NULL),
(36, '2025-01-01 23:31:19', 'Developer', '1', NULL, NULL),
(37, '2025-01-01 23:31:19', 'Developer', '1', NULL, NULL),
(38, '2025-01-01 23:31:19', 'Developer', '1', NULL, NULL),
(39, '2025-01-01 23:31:19', 'Developer', '1', NULL, NULL),
(40, '2025-01-01 23:31:19', 'Developer', '1', NULL, NULL),
(41, '2025-01-01 23:31:19', 'Developer', '1', NULL, NULL),
(42, '2025-01-01 23:31:19', 'Developer', '1', NULL, NULL),
(43, '2025-01-01 23:31:19', 'Developer', '1', NULL, NULL),
(44, '2025-01-01 23:31:19', 'Developer', '1', NULL, NULL),
(45, '2025-01-01 23:31:19', 'Developer', '1', NULL, NULL),
(46, '2025-01-01 23:31:19', 'Developer', '1', NULL, NULL),
(47, '2025-01-01 23:31:19', 'Developer', '1', NULL, NULL),
(48, '2025-01-01 23:31:19', 'Developer', '1', NULL, NULL),
(49, '2025-01-01 23:31:19', 'Developer', '1', NULL, NULL),
(50, '2025-01-01 23:31:19', 'Developer', '1', NULL, NULL),
(51, '2025-02-01 23:32:47', 'Developer', '1', NULL, NULL),
(52, '2025-02-01 23:32:47', 'Developer', '1', NULL, NULL),
(53, '2025-02-01 23:32:47', 'Developer', '1', NULL, NULL),
(54, '2025-02-01 23:32:47', 'Developer', '1', NULL, NULL),
(55, '2025-02-01 23:32:47', 'Developer', '1', NULL, NULL),
(56, '2025-02-01 23:32:47', 'Developer', '1', NULL, NULL),
(57, '2025-02-01 23:32:47', 'Developer', '1', NULL, NULL),
(58, '2025-02-01 23:32:47', 'Developer', '1', NULL, NULL),
(59, '2025-02-01 23:32:47', 'Developer', '1', NULL, NULL),
(60, '2025-02-01 23:32:47', 'Developer', '1', NULL, NULL),
(61, '2025-02-01 23:32:47', 'Developer', '1', NULL, NULL),
(62, '2025-02-01 23:32:47', 'Developer', '1', NULL, NULL),
(63, '2025-02-01 23:32:47', 'Developer', '1', NULL, NULL),
(64, '2025-02-01 23:32:47', 'Developer', '1', NULL, NULL),
(65, '2025-02-01 23:32:47', 'Developer', '1', NULL, NULL),
(66, '2025-02-01 23:32:47', 'Developer', '1', NULL, NULL),
(67, '2025-02-01 23:32:47', 'Developer', '1', NULL, NULL),
(68, '2025-02-01 23:32:47', 'Developer', '1', NULL, NULL),
(69, '2025-02-01 23:32:47', 'Developer', '1', NULL, NULL),
(70, '2025-02-01 23:32:47', 'Developer', '1', NULL, NULL),
(71, '2025-03-01 23:33:06', 'Developer', '1', NULL, NULL),
(72, '2025-03-01 23:33:06', 'Developer', '1', NULL, NULL),
(73, '2025-03-01 23:33:06', 'Developer', '1', NULL, NULL),
(74, '2025-03-01 23:33:06', 'Developer', '1', NULL, NULL),
(75, '2025-03-01 23:33:06', 'Developer', '1', NULL, NULL),
(76, '2025-03-01 23:33:06', 'Developer', '1', NULL, NULL),
(77, '2025-03-01 23:33:06', 'Developer', '1', NULL, NULL),
(78, '2025-03-01 23:33:06', 'Developer', '1', NULL, NULL),
(79, '2025-03-01 23:33:06', 'Developer', '1', NULL, NULL),
(80, '2025-03-01 23:33:06', 'Developer', '1', NULL, NULL),
(81, 'create', 'petugas_indikator', '1', '2025-04-18 05:06:07', '2025-04-18 05:06:07');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_001_create_cache_table', 1),
(2, '2025_01_01_000_create_logs_tabel_pasien_table', 1),
(3, '2025_01_01_001_create_kepala_instalasi_table', 1),
(4, '2025_01_01_002_create_perawat_table', 1),
(5, '2025_01_01_003_create_petugas_indikator_table', 1),
(6, '2025_01_02_0001_create_bangsal_table', 1),
(7, '2025_01_02_0002_create_kelas_bangsal_table', 1),
(8, '2025_01_03_1001_create_pasien_masuk_table', 1),
(9, '2025_01_03_1002_create_pasien_pindah_table', 1),
(10, '2025_01_03_1003_create_pasien_keluar_table', 1),
(11, '2025_01_04_0001_create_laporan_table', 1),
(12, '2025_01_05_0000_create_sessions_table', 1),
(13, '2025_01_99_0000_model_r_s', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `model_rs`
--

CREATE TABLE `model_rs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `BOR` int(11) NOT NULL,
  `LOS` int(11) NOT NULL,
  `TOI` int(11) NOT NULL,
  `BTO` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pasien_keluar`
--

CREATE TABLE `pasien_keluar` (
  `fk_id_pasien_masuk` bigint(20) UNSIGNED NOT NULL,
  `waktu_keluar` datetime NOT NULL,
  `cara_keluar` varchar(255) NOT NULL,
  `fk_id_logs` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pasien_keluar`
--

INSERT INTO `pasien_keluar` (`fk_id_pasien_masuk`, `waktu_keluar`, `cara_keluar`, `fk_id_logs`, `created_at`, `updated_at`) VALUES
(5, '2025-03-01 23:33:06', 'hidup', 70, NULL, NULL),
(6, '2025-03-01 23:33:06', 'hidup', 71, NULL, NULL),
(7, '2025-03-01 23:33:06', 'dipindahkan', 72, NULL, NULL),
(8, '2025-03-01 23:33:06', 'mati', 73, NULL, NULL),
(9, '2025-03-01 23:33:06', 'mati', 74, NULL, NULL),
(1, '2025-03-01 23:33:06', 'dipindahkan', 75, NULL, NULL),
(2, '2025-03-01 23:33:06', 'mati', 76, NULL, NULL),
(3, '2025-03-01 23:33:06', 'dipindahkan', 77, NULL, NULL),
(4, '2025-03-01 23:33:06', 'dipindahkan', 78, NULL, NULL),
(11, '2025-03-01 23:33:06', 'mati', 79, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pasien_masuk`
--

CREATE TABLE `pasien_masuk` (
  `id_pasien_masuk` bigint(20) UNSIGNED NOT NULL,
  `no_rm` varchar(255) NOT NULL,
  `nama_pasien` varchar(255) NOT NULL,
  `jenis_kelamin` varchar(255) NOT NULL,
  `waktu_masuk` datetime NOT NULL,
  `fk_id_logs` bigint(20) UNSIGNED NOT NULL,
  `fk_kd_bangsal` bigint(20) UNSIGNED NOT NULL,
  `fk_id_kelas` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pasien_masuk`
--

INSERT INTO `pasien_masuk` (`id_pasien_masuk`, `no_rm`, `nama_pasien`, `jenis_kelamin`, `waktu_masuk`, `fk_id_logs`, `fk_kd_bangsal`, `fk_id_kelas`, `created_at`, `updated_at`) VALUES
(1, '300', 'Pasien 1 1', 'Laki-laki', '2025-01-01 23:31:20', 1, 1, 14, NULL, NULL),
(2, '301', 'Pasien 1 2', 'Perempuan', '2025-01-01 23:31:20', 2, 1, 7, NULL, NULL),
(3, '302', 'Pasien 1 3', 'Laki-laki', '2025-01-01 23:31:20', 3, 1, 9, NULL, NULL),
(4, '303', 'Pasien 1 4', 'Perempuan', '2025-01-01 23:31:20', 4, 1, 15, NULL, NULL),
(5, '304', 'Pasien 1 5', 'Perempuan', '2025-01-01 23:31:20', 5, 1, 3, NULL, NULL),
(6, '305', 'Pasien 1 6', 'Perempuan', '2025-01-01 23:31:20', 6, 1, 16, NULL, NULL),
(7, '306', 'Pasien 1 7', 'Perempuan', '2025-01-01 23:31:20', 7, 1, 15, NULL, NULL),
(8, '307', 'Pasien 1 8', 'Perempuan', '2025-01-01 23:31:20', 8, 1, 11, NULL, NULL),
(9, '308', 'Pasien 1 9', 'Laki-laki', '2025-01-01 23:31:20', 9, 1, 1, NULL, NULL),
(10, '309', 'Pasien 1 10', 'Laki-laki', '2025-01-01 23:31:20', 10, 1, 15, NULL, NULL),
(11, '310', 'Pasien 2 1', 'Perempuan', '2025-01-01 23:31:20', 11, 2, 23, NULL, NULL),
(12, '311', 'Pasien 2 2', 'Perempuan', '2025-01-01 23:31:20', 12, 2, 19, NULL, NULL),
(13, '312', 'Pasien 2 3', 'Laki-laki', '2025-01-01 23:31:20', 13, 2, 24, NULL, NULL),
(14, '313', 'Pasien 2 4', 'Laki-laki', '2025-01-01 23:31:20', 14, 2, 18, NULL, NULL),
(15, '314', 'Pasien 2 5', 'Perempuan', '2025-01-01 23:31:20', 15, 2, 25, NULL, NULL),
(16, '315', 'Pasien 3 1', 'Laki-laki', '2025-01-01 23:31:20', 16, 3, 29, NULL, NULL),
(17, '316', 'Pasien 3 2', 'Laki-laki', '2025-01-01 23:31:20', 17, 3, 29, NULL, NULL),
(18, '317', 'Pasien 3 3', 'Perempuan', '2025-01-01 23:31:20', 18, 3, 31, NULL, NULL),
(19, '318', 'Pasien 3 4', 'Laki-laki', '2025-01-01 23:31:20', 19, 3, 31, NULL, NULL),
(20, '319', 'Pasien 3 5', 'Perempuan', '2025-01-01 23:31:21', 20, 3, 32, NULL, NULL),
(21, '320', 'Pasien 4 1', 'Laki-laki', '2025-01-01 23:31:21', 21, 4, 37, NULL, NULL),
(22, '321', 'Pasien 4 2', 'Laki-laki', '2025-01-01 23:31:21', 22, 4, 38, NULL, NULL),
(23, '322', 'Pasien 4 3', 'Perempuan', '2025-01-01 23:31:21', 23, 4, 35, NULL, NULL),
(24, '323', 'Pasien 4 4', 'Laki-laki', '2025-01-01 23:31:21', 24, 4, 46, NULL, NULL),
(25, '324', 'Pasien 4 5', 'Laki-laki', '2025-01-01 23:31:21', 25, 4, 36, NULL, NULL),
(26, '325', 'Pasien 4 6', 'Perempuan', '2025-01-01 23:31:21', 26, 4, 38, NULL, NULL),
(27, '326', 'Pasien 4 7', 'Laki-laki', '2025-01-01 23:31:21', 27, 4, 37, NULL, NULL),
(28, '327', 'Pasien 4 8', 'Perempuan', '2025-01-01 23:31:21', 28, 4, 44, NULL, NULL),
(29, '328', 'Pasien 4 9', 'Perempuan', '2025-01-01 23:31:21', 29, 4, 42, NULL, NULL),
(30, '329', 'Pasien 4 10', 'Perempuan', '2025-01-01 23:31:21', 30, 4, 41, NULL, NULL),
(31, '330', 'Pasien 5 1', 'Perempuan', '2025-01-01 23:31:21', 31, 5, 49, NULL, NULL),
(32, '331', 'Pasien 5 2', 'Laki-laki', '2025-01-01 23:31:21', 32, 5, 49, NULL, NULL),
(33, '332', 'Pasien 5 3', 'Perempuan', '2025-01-01 23:31:21', 33, 5, 49, NULL, NULL),
(34, '333', 'Pasien 5 4', 'Perempuan', '2025-01-01 23:31:21', 34, 5, 49, NULL, NULL),
(35, '334', 'Pasien 5 5', 'Laki-laki', '2025-01-01 23:31:21', 35, 5, 49, NULL, NULL),
(36, '335', 'Pasien 5 6', 'Perempuan', '2025-01-01 23:31:21', 36, 5, 49, NULL, NULL),
(37, '336', 'Pasien 5 7', 'Perempuan', '2025-01-01 23:31:21', 37, 5, 48, NULL, NULL),
(38, '337', 'Pasien 5 8', 'Laki-laki', '2025-01-01 23:31:21', 38, 5, 48, NULL, NULL),
(39, '338', 'Pasien 5 9', 'Perempuan', '2025-01-01 23:31:21', 39, 5, 48, NULL, NULL),
(40, '339', 'Pasien 5 10', 'Laki-laki', '2025-01-01 23:31:21', 40, 5, 48, NULL, NULL),
(41, '340', 'Pasien 6 1', 'Laki-laki', '2025-01-01 23:31:21', 41, 6, 52, NULL, NULL),
(42, '341', 'Pasien 6 2', 'Laki-laki', '2025-01-01 23:31:21', 42, 6, 53, NULL, NULL),
(43, '342', 'Pasien 6 3', 'Perempuan', '2025-01-01 23:31:21', 43, 6, 52, NULL, NULL),
(44, '343', 'Pasien 6 4', 'Perempuan', '2025-01-01 23:31:21', 44, 6, 51, NULL, NULL),
(45, '344', 'Pasien 6 5', 'Laki-laki', '2025-01-01 23:31:21', 45, 6, 53, NULL, NULL),
(46, '345', 'Pasien 7 1', 'Perempuan', '2025-01-01 23:31:21', 46, 7, 55, NULL, NULL),
(47, '346', 'Pasien 7 2', 'Laki-laki', '2025-01-01 23:31:21', 47, 7, 58, NULL, NULL),
(48, '347', 'Pasien 7 3', 'Perempuan', '2025-01-01 23:31:21', 48, 7, 58, NULL, NULL),
(49, '348', 'Pasien 7 4', 'Laki-laki', '2025-01-01 23:31:21', 49, 7, 54, NULL, NULL),
(50, '349', 'Pasien 7 5', 'Perempuan', '2025-01-01 23:31:21', 50, 7, 58, NULL, NULL),
(51, '1001', 'Pasien testing 4', 'Laki-laki', '2026-01-18 18:05:00', 81, 10, 73, '2025-04-18 05:06:07', '2025-04-18 05:06:07');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pasien_pindah`
--

CREATE TABLE `pasien_pindah` (
  `id_pindah` bigint(20) UNSIGNED NOT NULL,
  `fk_id_pasien_masuk` bigint(20) UNSIGNED NOT NULL,
  `fk_asal_bangsal` bigint(20) UNSIGNED NOT NULL,
  `fk_tujuan_bangsal` bigint(20) UNSIGNED NOT NULL,
  `fk_id_kelas_asal` bigint(20) UNSIGNED NOT NULL,
  `fk_id_kelas_tujuan` bigint(20) UNSIGNED DEFAULT NULL,
  `waktu_pindah` datetime NOT NULL,
  `fk_id_logs` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pasien_pindah`
--

INSERT INTO `pasien_pindah` (`id_pindah`, `fk_id_pasien_masuk`, `fk_asal_bangsal`, `fk_tujuan_bangsal`, `fk_id_kelas_asal`, `fk_id_kelas_tujuan`, `waktu_pindah`, `fk_id_logs`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 9, 14, 69, '2025-02-01 23:32:47', 50, NULL, NULL),
(2, 2, 1, 9, 7, 68, '2025-02-01 23:32:47', 51, NULL, NULL),
(3, 3, 1, 9, 9, 65, '2025-02-01 23:32:47', 52, NULL, NULL),
(4, 4, 1, 9, 15, 69, '2025-02-01 23:32:47', 53, NULL, NULL),
(5, 11, 2, 8, 23, 64, '2025-02-01 23:32:47', 54, NULL, NULL),
(6, 12, 2, 8, 19, 59, '2025-02-01 23:32:47', 55, NULL, NULL),
(7, 13, 2, 8, 24, 64, '2025-02-01 23:32:47', 56, NULL, NULL),
(8, 16, 3, 7, 29, 56, '2025-02-01 23:32:47', 57, NULL, NULL),
(9, 17, 3, 7, 29, 57, '2025-02-01 23:32:47', 58, NULL, NULL),
(10, 18, 3, 7, 31, 54, '2025-02-01 23:32:48', 59, NULL, NULL),
(11, 21, 4, 6, 37, 50, '2025-02-01 23:32:48', 60, NULL, NULL),
(12, 22, 4, 6, 38, 51, '2025-02-01 23:32:48', 61, NULL, NULL),
(13, 23, 4, 6, 35, 50, '2025-02-01 23:32:48', 62, NULL, NULL),
(14, 24, 4, 6, 46, 51, '2025-02-01 23:32:48', 63, NULL, NULL),
(15, 25, 4, 6, 36, 51, '2025-02-01 23:32:48', 64, NULL, NULL),
(16, 31, 5, 1, 49, 12, '2025-02-01 23:32:48', 65, NULL, NULL),
(17, 32, 5, 1, 49, 9, '2025-02-01 23:32:48', 66, NULL, NULL),
(18, 33, 5, 1, 49, 15, '2025-02-01 23:32:48', 67, NULL, NULL),
(19, 34, 5, 1, 49, 12, '2025-02-01 23:32:48', 68, NULL, NULL),
(20, 35, 5, 1, 49, 7, '2025-02-01 23:32:48', 69, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `perawat`
--

CREATE TABLE `perawat` (
  `id_perawat` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `jenis_kelamin` varchar(255) NOT NULL,
  `penempatan` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'perawat',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `perawat`
--

INSERT INTO `perawat` (`id_perawat`, `username`, `password`, `nama`, `jenis_kelamin`, `penempatan`, `role`, `created_at`, `updated_at`) VALUES
(1, 'perawat1', '$2y$12$RKfprWDwSxHFJuggYpzPTOEVNEVMOdZFUVTp/Lg4qg2iLUknyXBEO', 'Perawat Satu', 'Laki-laki', 'Paru', 'perawat', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `petugas_indikator`
--

CREATE TABLE `petugas_indikator` (
  `id_petugas` bigint(20) UNSIGNED NOT NULL DEFAULT 1,
  `username` varchar(255) NOT NULL DEFAULT 'admin',
  `password` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'petugas_indikator',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `petugas_indikator`
--

INSERT INTO `petugas_indikator` (`id_petugas`, `username`, `password`, `nama`, `role`, `created_at`, `updated_at`) VALUES
(1, 'admin1', '$2y$12$N42ut9dYycF8L.YN6NyfseH93MqK1Zluj4B8SecE4yeGJQD.5FSGe', 'Admin Satu', 'petugas_indikator', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('RVVxmDOoTzbGkQSYjJwzOhdYl5CC8T93n0Lklz0y', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 Edg/135.0.0.0', 'YTo3OntzOjY0OiJsb2dpbl9wZXR1Z2FzX2luZGlrYXRvcl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtzOjY6ImFkbWluMSI7czo3OiJ1c2VyX2lkIjtpOjE7czo0OiJyb2xlIjtzOjE3OiJwZXR1Z2FzX2luZGlrYXRvciI7czo1OiJndWFyZCI7czoxNzoicGV0dWdhc19pbmRpa2F0b3IiO3M6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NjoiX3Rva2VuIjtzOjQwOiJIZEM4UERyYTN1QmppSUxvN2t4bUZiUUU4bWtEWXRnbmVaSHJNWXI3IjtzOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo2MDoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL3BldHVnYXNfaW5kaWthdG9yL2xhcG9yYW4vcmVrYXBpdHVsYXNpIjt9fQ==', 1744983231),
('uBANNuBuXnm5dX9vyJrJQfXlgeDoeld8apsfhzmG', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 Edg/135.0.0.0', 'YTo3OntzOjY0OiJsb2dpbl9wZXR1Z2FzX2luZGlrYXRvcl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtzOjY6ImFkbWluMSI7czo3OiJ1c2VyX2lkIjtpOjE7czo0OiJyb2xlIjtzOjE3OiJwZXR1Z2FzX2luZGlrYXRvciI7czo1OiJndWFyZCI7czoxNzoicGV0dWdhc19pbmRpa2F0b3IiO3M6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NjoiX3Rva2VuIjtzOjQwOiJoM3J6QW9JV0ZaZE1KbHRvRXlxa1RHNnNyaVBjUWxya0taSkt6QmlxIjtzOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo2MDoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL3BldHVnYXNfaW5kaWthdG9yL2xhcG9yYW4vcmVrYXBpdHVsYXNpIjt9fQ==', 1745130099),
('WfvKJqR3kD8TewlqTqXPwBqtFm5yirjwjaZjktPV', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', 'YTo3OntzOjY0OiJsb2dpbl9wZXR1Z2FzX2luZGlrYXRvcl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtzOjY6ImFkbWluMSI7czo3OiJ1c2VyX2lkIjtpOjE7czo0OiJyb2xlIjtzOjE3OiJwZXR1Z2FzX2luZGlrYXRvciI7czo1OiJndWFyZCI7czoxNzoicGV0dWdhc19pbmRpa2F0b3IiO3M6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NjoiX3Rva2VuIjtzOjQwOiIyR2h1eDlNNVc4MXl0eHVON0tiaGx6TzNpTXVJYnJQNHdGMWhuM1g5IjtzOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo1MToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL3BldHVnYXNfaW5kaWthdG9yL2RhdGEtcGFzaWVuIjt9fQ==', 1746771833);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `bangsal`
--
ALTER TABLE `bangsal`
  ADD PRIMARY KEY (`kd_bangsal`);

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `kelas_bangsal`
--
ALTER TABLE `kelas_bangsal`
  ADD PRIMARY KEY (`id_kelas`),
  ADD KEY `kelas_bangsal_fk_kd_bangsal_foreign` (`fk_kd_bangsal`);

--
-- Indeks untuk tabel `kepala_instalasi`
--
ALTER TABLE `kepala_instalasi`
  ADD UNIQUE KEY `kepala_instalasi_username_unique` (`username`);

--
-- Indeks untuk tabel `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`id_laporan`);

--
-- Indeks untuk tabel `logs_tabel_pasien`
--
ALTER TABLE `logs_tabel_pasien`
  ADD PRIMARY KEY (`id_logs`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `model_rs`
--
ALTER TABLE `model_rs`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pasien_keluar`
--
ALTER TABLE `pasien_keluar`
  ADD KEY `pasien_keluar_fk_id_pasien_masuk_foreign` (`fk_id_pasien_masuk`),
  ADD KEY `pasien_keluar_fk_id_logs_foreign` (`fk_id_logs`);

--
-- Indeks untuk tabel `pasien_masuk`
--
ALTER TABLE `pasien_masuk`
  ADD PRIMARY KEY (`id_pasien_masuk`),
  ADD KEY `pasien_masuk_fk_id_logs_foreign` (`fk_id_logs`),
  ADD KEY `pasien_masuk_fk_kd_bangsal_foreign` (`fk_kd_bangsal`),
  ADD KEY `pasien_masuk_fk_id_kelas_foreign` (`fk_id_kelas`);

--
-- Indeks untuk tabel `pasien_pindah`
--
ALTER TABLE `pasien_pindah`
  ADD PRIMARY KEY (`id_pindah`),
  ADD KEY `pasien_pindah_fk_id_pasien_masuk_foreign` (`fk_id_pasien_masuk`),
  ADD KEY `pasien_pindah_fk_asal_bangsal_foreign` (`fk_asal_bangsal`),
  ADD KEY `pasien_pindah_fk_tujuan_bangsal_foreign` (`fk_tujuan_bangsal`),
  ADD KEY `pasien_pindah_fk_id_kelas_asal_foreign` (`fk_id_kelas_asal`),
  ADD KEY `pasien_pindah_fk_id_kelas_tujuan_foreign` (`fk_id_kelas_tujuan`),
  ADD KEY `pasien_pindah_fk_id_logs_foreign` (`fk_id_logs`);

--
-- Indeks untuk tabel `perawat`
--
ALTER TABLE `perawat`
  ADD PRIMARY KEY (`id_perawat`),
  ADD UNIQUE KEY `perawat_username_unique` (`username`);

--
-- Indeks untuk tabel `petugas_indikator`
--
ALTER TABLE `petugas_indikator`
  ADD UNIQUE KEY `petugas_indikator_username_unique` (`username`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `bangsal`
--
ALTER TABLE `bangsal`
  MODIFY `kd_bangsal` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `kelas_bangsal`
--
ALTER TABLE `kelas_bangsal`
  MODIFY `id_kelas` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT untuk tabel `laporan`
--
ALTER TABLE `laporan`
  MODIFY `id_laporan` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `logs_tabel_pasien`
--
ALTER TABLE `logs_tabel_pasien`
  MODIFY `id_logs` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `model_rs`
--
ALTER TABLE `model_rs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pasien_masuk`
--
ALTER TABLE `pasien_masuk`
  MODIFY `id_pasien_masuk` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT untuk tabel `pasien_pindah`
--
ALTER TABLE `pasien_pindah`
  MODIFY `id_pindah` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `perawat`
--
ALTER TABLE `perawat`
  MODIFY `id_perawat` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `kelas_bangsal`
--
ALTER TABLE `kelas_bangsal`
  ADD CONSTRAINT `kelas_bangsal_fk_kd_bangsal_foreign` FOREIGN KEY (`fk_kd_bangsal`) REFERENCES `bangsal` (`kd_bangsal`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pasien_keluar`
--
ALTER TABLE `pasien_keluar`
  ADD CONSTRAINT `pasien_keluar_fk_id_logs_foreign` FOREIGN KEY (`fk_id_logs`) REFERENCES `logs_tabel_pasien` (`id_logs`) ON DELETE NO ACTION,
  ADD CONSTRAINT `pasien_keluar_fk_id_pasien_masuk_foreign` FOREIGN KEY (`fk_id_pasien_masuk`) REFERENCES `pasien_masuk` (`id_pasien_masuk`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pasien_masuk`
--
ALTER TABLE `pasien_masuk`
  ADD CONSTRAINT `pasien_masuk_fk_id_kelas_foreign` FOREIGN KEY (`fk_id_kelas`) REFERENCES `kelas_bangsal` (`id_kelas`) ON DELETE NO ACTION,
  ADD CONSTRAINT `pasien_masuk_fk_id_logs_foreign` FOREIGN KEY (`fk_id_logs`) REFERENCES `logs_tabel_pasien` (`id_logs`) ON DELETE NO ACTION,
  ADD CONSTRAINT `pasien_masuk_fk_kd_bangsal_foreign` FOREIGN KEY (`fk_kd_bangsal`) REFERENCES `bangsal` (`kd_bangsal`) ON DELETE NO ACTION;

--
-- Ketidakleluasaan untuk tabel `pasien_pindah`
--
ALTER TABLE `pasien_pindah`
  ADD CONSTRAINT `pasien_pindah_fk_asal_bangsal_foreign` FOREIGN KEY (`fk_asal_bangsal`) REFERENCES `bangsal` (`kd_bangsal`) ON DELETE CASCADE,
  ADD CONSTRAINT `pasien_pindah_fk_id_kelas_asal_foreign` FOREIGN KEY (`fk_id_kelas_asal`) REFERENCES `kelas_bangsal` (`id_kelas`) ON DELETE CASCADE,
  ADD CONSTRAINT `pasien_pindah_fk_id_kelas_tujuan_foreign` FOREIGN KEY (`fk_id_kelas_tujuan`) REFERENCES `kelas_bangsal` (`id_kelas`) ON DELETE CASCADE,
  ADD CONSTRAINT `pasien_pindah_fk_id_logs_foreign` FOREIGN KEY (`fk_id_logs`) REFERENCES `logs_tabel_pasien` (`id_logs`) ON DELETE NO ACTION,
  ADD CONSTRAINT `pasien_pindah_fk_id_pasien_masuk_foreign` FOREIGN KEY (`fk_id_pasien_masuk`) REFERENCES `pasien_masuk` (`id_pasien_masuk`) ON DELETE CASCADE,
  ADD CONSTRAINT `pasien_pindah_fk_tujuan_bangsal_foreign` FOREIGN KEY (`fk_tujuan_bangsal`) REFERENCES `bangsal` (`kd_bangsal`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
