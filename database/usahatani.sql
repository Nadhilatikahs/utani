-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 07, 2025 at 11:27 PM
-- Server version: 8.0.30
-- PHP Version: 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `usahatani`
--

-- --------------------------------------------------------

--
-- Table structure for table `akun`
--

CREATE TABLE `akun` (
  `nama_akun` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `kode_akun` varchar(100) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `anggotatanis`
--

CREATE TABLE `anggotatanis` (
  `id_anggota` bigint UNSIGNED NOT NULL,
  `kode_anggota` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_anggota` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nik` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tempat_lahir` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_kelamin` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_hp` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_anggota` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori_petani` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `longitude` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_keltani` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `anggotatanis`
--

INSERT INTO `anggotatanis` (`id_anggota`, `kode_anggota`, `nama_anggota`, `nik`, `tempat_lahir`, `alamat`, `jenis_kelamin`, `no_hp`, `status_anggota`, `kategori_petani`, `latitude`, `longitude`, `id_keltani`, `created_at`, `updated_at`) VALUES
(2, 'AT-004', 'ADE RUSTAMA', '3205390901700001', 'GARUT, 9-1-1970', 'KP. CIJERUK RT 01 RW 06 DESA PUTRAJAWA', 'Laki-laki', '-', 'Sebagai Anggota', 'Pemilik Lahan', '-700191677', '10799303122', 1, '2024-06-12 06:58:04', '2024-09-25 16:29:17'),
(3, 'AT-002', 'AAN BURHANUDIN', '3205390107510018', 'GARUT, 1-7-1951', 'KP. CIJERUK RT 01 RW 06 DESA PUTRAJAWA', 'Laki-laki', '-', 'Sebagai Anggota', 'Pemilik Lahan', '-699894075', '10799351033', 1, '2024-05-13 04:22:20', '2024-08-17 01:09:10'),
(4, 'AT-003', 'ajang', '3205390107510018', 'GARUT, 1-7-1951', 'KP. CIJERUK RT 01 RW 06 DESA PUTRAJAWA', 'Laki-laki', '085756765212', 'Ketua Kelompok Anggota Tani', 'Pemilik lahan', '-6.99894075', '107.99351033', 3, '2024-05-15 20:08:05', '2024-09-25 16:28:50'),
(6, 'AT-005', 'Adang', '3173041412670002', 'jakarta, 14-12-1967', 'KP. CIJERUK RT 01 RW 06 DESA PUTRAJAWA', 'Laki-laki', '082317017983', 'Sebagai Anggota', 'Pemilik Lahan', '-700191677', '10799303122', 1, '2024-08-17 01:11:36', '2024-09-25 16:29:12'),
(9, 'AT-006', 'AI IDA', '3205394305830001', 'GARUT, 3-5-1983', 'KP CIJERUK RT 001 RW 06 DESA PUTRAJAWA', 'Perempuan', '-', 'Sebagai Anggota', 'Pemilik dan Penggarap Lahan', '-699,734,175', '10803571992', 1, '2024-09-25 18:48:20', '2024-09-25 18:48:20'),
(11, 'AT-008', 'Iim Heryanto', '3205392001690001', 'Garut', 'Kp. Kubang RT 01 RW 04 Desa Samida', 'Laki-laki', '082118769049', 'Ketua', 'Pemilik dan Penggarap', '-6.99237', '108.02152', 6, '2024-09-26 20:57:58', '2024-09-26 20:57:58'),
(12, 'AT-009', 'Asep', '1377900387363', 'Bandung, 11 Jamuari 2000', 'Bandung', 'Laki-laki', '08726537299', 'Tetap', 'Petani Cabe', '-6.984251362086101', '107.6408126095194', 3, '2024-12-27 03:57:04', '2024-12-27 03:57:04'),
(13, 'AT-010', 'cucup', '1377900387363', 'Bandung, 15 Agustus 2007', 'Bandung', 'Laki-laki', '081234567890', 'Tetap', 'Petani Bawang', '-6.984251362086106', '107.6408126095197', 1, '2024-12-27 04:26:20', '2024-12-27 04:26:20');

-- --------------------------------------------------------

--
-- Table structure for table `arus_kas`
--

CREATE TABLE `arus_kas` (
  `id` int NOT NULL,
  `type` enum('masuk','keluar') COLLATE utf8mb4_general_ci NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `arus_kas`
--

INSERT INTO `arus_kas` (`id`, `type`, `amount`, `created_at`) VALUES
(35, 'masuk', '1000000.00', '2025-02-03 21:08:17'),
(36, 'keluar', '50000.00', '2025-02-03 21:08:42');

-- --------------------------------------------------------

--
-- Table structure for table `bebanfixes`
--

CREATE TABLE `bebanfixes` (
  `id_bebanfix` bigint UNSIGNED NOT NULL,
  `kode_beban_fix` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nominal` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bebans`
--

CREATE TABLE `bebans` (
  `id_beban` bigint UNSIGNED NOT NULL,
  `kode_beban` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_beban` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_kategori` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bebans`
--

INSERT INTO `bebans` (`id_beban`, `kode_beban`, `nama_beban`, `kategori`, `id_kategori`, `created_at`, `updated_at`) VALUES
(3, 'BB-001', 'Perbaikan pemantang sawah', 'Persiapan Lahan', 1, '2024-05-15 05:19:11', '2024-05-15 05:19:11'),
(4, 'BB-002', 'Pengolahan Lahan (Traktor)', 'Persiapan Lahan', 1, '2024-05-15 05:19:49', '2024-05-15 05:19:49'),
(5, 'BB-003', 'Meratakan Tanah', 'Persiapan Lahan', 1, '2024-05-15 05:19:59', '2024-05-15 05:19:59'),
(6, 'BB-004', 'Nyaplak dan angkut benih', 'Persiapan Lahan', 1, '2024-05-15 05:20:24', '2024-05-15 05:20:24'),
(7, 'BB-005', 'Tanam system jajar legowo', 'Persiapan Lahan', 1, '2024-05-15 20:11:55', '2024-05-15 20:11:55'),
(8, 'BB-006', 'Pajak tanah', 'Pajak', 2, '2024-06-30 23:22:45', '2024-06-30 23:22:45'),
(9, 'BB-007', 'angkut benih', 'Persiapan Lahan', 1, '2024-07-01 03:12:04', '2024-07-01 03:12:04'),
(10, 'BB-008', 'Pemupukan Dasar Pupuk Organik', 'Pemupukan', 1, '2024-07-25 00:42:48', '2024-07-25 00:42:48'),
(11, 'BB-009', 'Penyulaman dan Penyiangan', 'Pemeliharaan', 1, '2024-07-25 00:56:35', '2024-07-25 00:56:35'),
(12, 'BB-010', 'Pemanenan', 'Pasca Panen', 1, '2024-07-31 21:09:17', '2024-07-31 21:09:17'),
(14, 'BB-011', 'Pengendalian hama penyakit', 'Pemeliharaan', 1, '2024-09-25 20:00:50', '2024-09-25 20:00:50'),
(15, 'BB-012', 'insektisida (kurakkron)', 'Persiapan Lahan', 1, '2024-09-25 20:05:39', '2024-09-26 19:56:24'),
(16, 'BB-013', 'Beban Pupuk', 'Pemupukan', 1, '2024-12-27 03:57:47', '2024-12-27 03:57:47'),
(17, 'BB-014', 'Beban Air', 'Persiapan Lahan', 1, '2024-12-27 04:26:46', '2024-12-27 04:26:46'),
(18, 'BB-015', 'beban listrik', 'Pemeliharaan', 2, '2024-12-27 05:40:07', '2024-12-27 05:40:07'),
(19, 'BB-016', 'beban lainnya', 'Pajak', 1, '2024-12-27 05:42:38', '2024-12-27 05:42:38'),
(20, 'BB-017', 'Beban Air', 'Persiapan Lahan', 1, '2024-12-27 05:55:44', '2024-12-27 05:55:44');

-- --------------------------------------------------------

--
-- Table structure for table `bebantanam`
--

CREATE TABLE `bebantanam` (
  `id_bebantanam` bigint UNSIGNED NOT NULL,
  `kode_bebantanam` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_tanam` bigint UNSIGNED NOT NULL,
  `id_beban` bigint UNSIGNED NOT NULL,
  `satuan` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` int NOT NULL,
  `harga` int NOT NULL,
  `total` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bebantanam`
--

INSERT INTO `bebantanam` (`id_bebantanam`, `kode_bebantanam`, `id_tanam`, `id_beban`, `satuan`, `jumlah`, `harga`, `total`, `created_at`, `updated_at`) VALUES
(34, 'BT-001', 6, 3, 'HOK', 1, 70000, 70000, '2024-08-04 20:43:31', '2024-08-04 20:43:31'),
(35, 'BT-002', 6, 8, 'Ha', 1, 100000, 100000, '2024-08-04 21:20:42', '2024-08-04 21:20:42'),
(36, 'BT-003', 6, 4, 'bata', 70, 4000, 280000, '2024-08-04 21:22:24', '2024-08-04 21:22:24'),
(37, 'BT-004', 6, 5, 'HOK', 1, 70000, 70000, '2024-08-04 21:22:42', '2024-08-04 21:22:42'),
(38, 'BT-005', 6, 6, 'HOK', 1, 70000, 70000, '2024-08-04 21:22:59', '2024-08-04 21:22:59'),
(39, 'BT-006', 6, 7, 'HOK', 1, 70000, 70000, '2024-08-04 21:23:10', '2024-08-04 21:23:10'),
(40, 'BT-007', 6, 7, 'HOK', 2, 50000, 100000, '2024-08-04 21:23:45', '2024-08-04 21:23:45'),
(44, 'BT-008', 6, 10, 'kg', 200, 5000, 1000000, '2024-08-04 21:26:26', '2024-08-04 21:26:26'),
(45, 'BT-009', 6, 11, 'HOK', 3, 70000, 210000, '2024-08-04 21:27:09', '2024-08-04 21:27:09'),
(46, 'BT-010', 6, 12, 'HOK', 5, 70000, 350000, '2024-08-04 21:27:30', '2024-08-04 21:27:30'),
(47, 'BT-011', 6, 12, 'HOK', 10, 70000, 700000, '2024-08-04 21:27:49', '2024-08-04 21:27:49'),
(49, 'BT-012', 8, 3, 'HOK', 10, 10000, 100000, '2024-08-17 02:03:33', '2024-08-17 02:03:33'),
(50, 'BT-013', 6, 8, 'Ha', 1, 5000, 5000, '2024-08-17 02:04:45', '2024-08-17 02:04:45'),
(51, 'BT-014', 8, 8, 'Ha', 1, 100000, 100000, '2024-08-17 02:05:19', '2024-08-17 02:05:19'),
(52, 'BT-015', 7, 6, 'kg', 10, 50000, 500000, '2024-08-17 03:53:31', '2024-08-17 03:53:31'),
(53, 'BT-016', 7, 8, 'HOK', 1, 50000, 50000, '2024-08-17 03:54:47', '2024-08-17 03:54:47'),
(54, 'BT-017', 7, 8, 'HOK', 1, 100000, 100000, '2024-08-17 03:56:18', '2024-08-17 03:56:18'),
(55, 'BT-018', 10, 3, 'HOK', 1, 170000, 170000, '2024-08-17 06:32:38', '2024-08-17 06:32:38'),
(56, 'BT-019', 10, 8, 'HOK', 1, 50000, 50000, '2024-08-17 06:33:01', '2024-08-17 06:33:01'),
(57, 'BT-020', 11, 4, 'HOK', 12, 70000, 840000, '2024-09-25 19:42:31', '2024-09-25 19:42:31'),
(58, 'BT-021', 8, 14, 'HOK', 1, 100000, 100000, '2024-09-25 20:02:01', '2024-09-25 20:02:01'),
(59, 'BT-022', 8, 15, 'kg', 1, 200000, 200000, '2024-09-25 20:07:15', '2024-09-25 20:07:15');

--
-- Triggers `bebantanam`
--
DELIMITER $$
CREATE TRIGGER `after_delete_bebantanam` AFTER DELETE ON `bebantanam` FOR EACH ROW BEGIN  

  DECLARE vtotal DECIMAL(10, 2);
  DECLARE vid INT;
  
    -- cari tahu kategorinya
    SELECT id_kategori INTO vid
    FROM bebans
    WHERE id_beban = OLD.id_beban;
    
    SELECT SUM(total) INTO vtotal
            FROM bebantanam a
            JOIN bebans b ON (a.id_beban=b.id_beban)
            WHERE a.id_tanam = OLD.id_tanam 
            AND b.id_kategori=vid;
    
    -- Hitung total harga untuk order_id terkait
    IF vid = 1 THEN
            
            
             UPDATE tanams
             SET beban_variabel = vtotal
             WHERE id_tanam = OLD.id_tanam;
    ELSE
            
             UPDATE tanams
             SET beban_fix = vtotal
             WHERE id_tanam = OLD.id_tanam;
    END IF;
    




END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_insert_bebantanam` AFTER INSERT ON `bebantanam` FOR EACH ROW BEGIN  

  DECLARE vtotal_var DECIMAL(10, 2);
  DECLARE vtotal_fix DECIMAL(10, 2);

    -- Hitung total harga untuk order_id terkait
    SELECT SUM(total) INTO vtotal_var
    FROM bebantanam a
    JOIN bebans b ON (a.id_beban=b.id_beban)
    WHERE a.id_tanam = NEW.id_tanam AND b.id_kategori=1;
    
    SELECT SUM(total) INTO vtotal_fix
    FROM bebantanam a
    JOIN bebans b ON (a.id_beban=b.id_beban)
    WHERE a.id_tanam = NEW.id_tanam AND b.id_kategori=2;

 UPDATE tanams
 SET beban_variabel = vtotal_var,
     beban_fix = vtotal_fix
 WHERE id_tanam = NEW.id_tanam;

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_update_bebantanam` AFTER UPDATE ON `bebantanam` FOR EACH ROW BEGIN  

  DECLARE vtotal DECIMAL(10, 2);
  DECLARE vid INT;
  
    -- cari tahu kategorinya
    SELECT id_kategori INTO vid
    FROM bebans
    WHERE id_beban = NEW.id_beban;
    
    SELECT SUM(total) INTO vtotal
            FROM bebantanam a
            JOIN bebans b ON (a.id_beban=b.id_beban)
            WHERE a.id_tanam = OLD.id_tanam 
            AND b.id_kategori=vid;
    
    -- Hitung total harga untuk order_id terkait
    IF vid = 1 THEN
            
            
             UPDATE tanams
             SET beban_variabel = vtotal
             WHERE id_tanam = OLD.id_tanam;
    ELSE
            
             UPDATE tanams
             SET beban_fix = vtotal
             WHERE id_tanam = OLD.id_tanam;
    END IF;
    




END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `bpps`
--

CREATE TABLE `bpps` (
  `id_bpp` bigint UNSIGNED NOT NULL,
  `kode_bpp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_bpp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `longitude` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_upt` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bpps`
--

INSERT INTO `bpps` (`id_bpp`, `kode_bpp`, `nama_bpp`, `alamat`, `latitude`, `longitude`, `id_upt`, `created_at`, `updated_at`) VALUES
(1, 'BPP-001', 'bpp salaawi', 'garut', '-6.975353', '107.629601', 1, '2024-05-01 23:14:29', '2024-05-01 23:14:29'),
(4, 'BPP-002', 'BPP baru', 'Desa Selawi', '-6.99751295', '108.02335542690264', 1, '2025-02-02 09:53:29', '2025-02-02 09:53:29');

-- --------------------------------------------------------

--
-- Table structure for table `cash_transactions`
--

CREATE TABLE `cash_transactions` (
  `id` int NOT NULL,
  `transaction_type` enum('masuk','keluar') COLLATE utf8mb4_general_ci NOT NULL,
  `transaction_date` date NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chart_of_accounts`
--

CREATE TABLE `chart_of_accounts` (
  `id` int NOT NULL,
  `kode_akun` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `id_jenis_transaksi` int NOT NULL,
  `nama_akun` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `header` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `posisi_dr_cr` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `saldo_awal` int NOT NULL DEFAULT (0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chart_of_accounts`
--

INSERT INTO `chart_of_accounts` (`id`, `kode_akun`, `id_jenis_transaksi`, `nama_akun`, `header`, `posisi_dr_cr`, `saldo_awal`) VALUES
(2, '111', 1, 'Kas', '111', 'd', 0);

-- --------------------------------------------------------

--
-- Table structure for table `desas`
--

CREATE TABLE `desas` (
  `id_desa` bigint UNSIGNED NOT NULL,
  `kode_desa` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_desa` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `longitude` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_bpp` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `desas`
--

INSERT INTO `desas` (`id_desa`, `kode_desa`, `nama_desa`, `alamat`, `latitude`, `longitude`, `id_bpp`, `created_at`, `updated_at`) VALUES
(1, 'DES-001', 'desa sapto', 'dusun 1 sapto rt3/rw1', '-6.975353', '107.629601', 1, '2024-05-01 23:14:56', '2024-05-01 23:14:56'),
(2, 'DES-002', 'desa sapto1', 'dusun 1 sapto rt3/rw1', '-6.975353', '107.629601', 1, '2024-05-01 23:15:06', '2024-05-01 23:15:06'),
(3, 'DES-003', 'Putra Jawa', 'Kampung putra jawa', '-6.99894075', '107.99351033', 1, '2024-05-15 20:03:49', '2024-05-15 20:03:49'),
(5, 'DES-004', 'Desa Cigawir', 'Kp. Cikaso Rt 01 RW 06', '-7.020579', '108.004608', 1, '2024-09-26 19:44:17', '2024-09-26 19:44:17'),
(6, 'DES-005', 'Desa Samida', 'Kp. Baeud', '-6.99592', '108.02281', 1, '2024-09-26 20:04:36', '2024-09-26 20:04:36');

-- --------------------------------------------------------

--
-- Table structure for table `dinas`
--

CREATE TABLE `dinas` (
  `id_dinas` bigint UNSIGNED NOT NULL,
  `kode_dinas` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_dinas` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `longitude` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_kabupaten` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dinas`
--

INSERT INTO `dinas` (`id_dinas`, `kode_dinas`, `nama_dinas`, `alamat`, `latitude`, `longitude`, `id_kabupaten`, `created_at`, `updated_at`) VALUES
(1, 'DN-001', 'dinas pertanian daerah', 'garut', '-6.975353', '107.629601', 2, '2024-05-01 23:12:22', '2024-05-01 23:12:22'),
(2, 'DN-002', 'dinas pertanian garut', 'garut', '-6.975353', '107.629601', 1, '2024-05-01 23:12:38', '2024-05-01 23:12:38'),
(3, 'DN-003', 'DInas pertanian Garut', 'Jl pembangunan', '-6.975353', '107.629601', 4, '2024-05-15 20:00:56', '2024-05-15 20:00:56');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `general_journals`
--

CREATE TABLE `general_journals` (
  `id` int NOT NULL,
  `transaction_date` date NOT NULL,
  `account_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `debit` decimal(15,2) DEFAULT '0.00',
  `credit` decimal(15,2) DEFAULT '0.00',
  `description` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gis`
--

CREATE TABLE `gis` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `latitude` decimal(10,8) NOT NULL,
  `longitude` decimal(11,8) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gis`
--

INSERT INTO `gis` (`id`, `name`, `latitude`, `longitude`, `created_at`, `updated_at`) VALUES
(1, 'Bandung', '-6.91750000', '107.61910000', '2025-01-24 16:02:50', '2025-01-24 16:02:50'),
(2, 'Jakarta', '-6.20880000', '106.84560000', '2025-01-24 16:02:50', '2025-01-24 16:02:50');

-- --------------------------------------------------------

--
-- Table structure for table `g_i_s`
--

CREATE TABLE `g_i_s` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `importanggotas`
--

CREATE TABLE `importanggotas` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jenis_transaksi`
--

CREATE TABLE `jenis_transaksi` (
  `id` int NOT NULL,
  `keterangan` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `jenis_transaksi`
--

INSERT INTO `jenis_transaksi` (`id`, `keterangan`) VALUES
(1, 'Kas Masuk'),
(2, 'Kas Keluar');

-- --------------------------------------------------------

--
-- Table structure for table `journal`
--

CREATE TABLE `journal` (
  `No` bigint UNSIGNED NOT NULL,
  `akun` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `debit` decimal(15,2) NOT NULL DEFAULT '0.00',
  `kredit` decimal(15,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `journal`
--

INSERT INTO `journal` (`No`, `akun`, `debit`, `kredit`, `created_at`, `updated_at`) VALUES
(26, 'Kas', '1000000.00', '0.00', '2025-02-03 21:08:17', NULL),
(27, 'Bantuan Pemerintah', '0.00', '1000000.00', '2025-02-03 21:08:17', NULL),
(28, 'Perbaikan Lahan', '50000.00', '0.00', '2025-02-03 21:08:42', NULL),
(29, 'Kas', '0.00', '50000.00', '2025-02-03 21:08:42', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `journal_entries`
--

CREATE TABLE `journal_entries` (
  `id` int NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `account_id` int NOT NULL,
  `debit` decimal(15,2) DEFAULT '0.00',
  `credit` decimal(15,2) DEFAULT '0.00',
  `description` text COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jurnal`
--

CREATE TABLE `jurnal` (
  `id` int NOT NULL,
  `tanggal` date NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `kas_masuk` decimal(15,2) DEFAULT '0.00',
  `kas_keluar` decimal(15,2) DEFAULT '0.00',
  `saldo` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jurnal`
--

INSERT INTO `jurnal` (`id`, `tanggal`, `keterangan`, `kas_masuk`, `kas_keluar`, `saldo`) VALUES
(1, '2025-01-01', 'Penjualan Produk', '1000000.00', '0.00', '1000000.00'),
(2, '2025-01-02', 'Pembelian Barang', '0.00', '200000.00', '800000.00'),
(3, '2025-01-03', 'Pendapatan Jasa', '500000.00', '0.00', '1300000.00'),
(4, '2025-01-04', 'Pengeluaran Operasional', '0.00', '300000.00', '1000000.00'),
(5, '2025-01-26', 'Biaya Pajak', '67.00', '0.00', '1000067.00'),
(6, '2025-01-26', 'Biaya Operasional', '100000.00', '0.00', '1100067.00'),
(7, '2025-01-26', 'Biaya Perbaikan Lahan', '0.00', '67.00', '1100000.00');

-- --------------------------------------------------------

--
-- Table structure for table `jurnall`
--

CREATE TABLE `jurnall` (
  `tanggal` date NOT NULL,
  `id` int NOT NULL,
  `transaksi_id` int DEFAULT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `debet` decimal(15,2) DEFAULT '0.00',
  `kredit` decimal(15,2) DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jurnals`
--

CREATE TABLE `jurnals` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jurnal_kas`
--

CREATE TABLE `jurnal_kas` (
  `id` int NOT NULL,
  `type` enum('masuk','keluar') COLLATE utf8mb4_general_ci NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jurnal_umum`
--

CREATE TABLE `jurnal_umum` (
  `id` int NOT NULL,
  `id_jurnal` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `tgl_jurnal` date NOT NULL,
  `no_coa` int NOT NULL,
  `posisi_dr_cr` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `nominal` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kabupatens`
--

CREATE TABLE `kabupatens` (
  `id_kabupaten` bigint UNSIGNED NOT NULL,
  `kode_kabupaten` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_kabupaten` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `longitude` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_provinsi` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kabupatens`
--

INSERT INTO `kabupatens` (`id_kabupaten`, `kode_kabupaten`, `nama_kabupaten`, `latitude`, `longitude`, `id_provinsi`, `created_at`, `updated_at`) VALUES
(1, 'KB-001', 'Bandung', '-6.975353', '107.629601', 1, '2024-05-01 23:11:49', '2024-05-01 23:11:49'),
(2, 'KB-002', 'Bandung Barat', '-6.975353', '107.629601', 1, '2024-05-01 23:11:55', '2024-05-01 23:11:55'),
(3, 'KB-003', 'Lampung Tengah', '-6.975353', '107.629601', 1, '2024-05-01 23:12:04', '2024-05-01 23:12:04'),
(4, 'KB-004', 'Garut', '-6.99894075', '107.99351033', 1, '2024-05-15 19:59:18', '2024-05-15 19:59:18'),
(7, 'KB-005', 'Kabupaten Bandung', '-6.569291576027199', '107.76140273195749', 1, '2025-01-29 08:18:37', '2025-01-29 08:18:37'),
(8, 'KB-006', 'Kabupaten Bandung Barat', '-6.89775405', '107.41242936450845', 1, '2025-01-29 08:20:04', '2025-01-29 08:20:04'),
(9, 'KB-007', 'Kabupaten Garut', '-7.2162543', '107.9014912', 1, '2025-02-03 21:02:35', '2025-02-03 21:02:35');

-- --------------------------------------------------------

--
-- Table structure for table `kas_transaksi`
--

CREATE TABLE `kas_transaksi` (
  `id` int NOT NULL,
  `jenis_transaksi` enum('Masuk','Keluar') COLLATE utf8mb4_general_ci NOT NULL,
  `deskripsi` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `jumlah` decimal(15,2) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` bigint UNSIGNED NOT NULL,
  `kode_kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `kode_kategori`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 'K-001', 'Beban Variabel', '2024-06-30 22:45:20', '2024-06-30 22:45:20'),
(2, 'K-002', 'Beban Fix', '2024-06-30 22:45:37', '2024-06-30 22:45:37');

-- --------------------------------------------------------

--
-- Table structure for table `kelompoktanis`
--

CREATE TABLE `kelompoktanis` (
  `id_keltani` bigint UNSIGNED NOT NULL,
  `kode_keltani` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_keltani` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `longitude` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_desa` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kelompoktanis`
--

INSERT INTO `kelompoktanis` (`id_keltani`, `kode_keltani`, `nama_keltani`, `alamat`, `latitude`, `longitude`, `id_desa`, `created_at`, `updated_at`) VALUES
(1, 'KT-001', 'kelompok damar', 'garut', '-6.975353', '107.629601', 1, '2024-05-01 23:15:21', '2024-05-01 23:15:21'),
(2, 'KT-002', 'kelompok damars', 'selaawi selatan', '-6.975353', '107.629601', 2, '2024-05-01 23:15:29', '2024-05-01 23:15:29'),
(3, 'KT-003', 'sawargi cijeruk', 'kampung cijeruk', '-6.99894075', '107.629601', 3, '2024-05-15 20:04:52', '2024-05-15 20:04:52'),
(5, 'KT-004', 'Lumbung Cigawir', 'Kp. Cikaso Rt 01 RW 06', '-7.020579', '108.004608', 5, '2024-09-26 19:44:52', '2024-09-26 19:44:52'),
(6, 'KT-005', 'Sukamaju', 'Kp. Kubang', '-6.99592', '108.02494', 6, '2024-09-26 20:05:29', '2024-09-26 20:05:29');

-- --------------------------------------------------------

--
-- Table structure for table `komoditas`
--

CREATE TABLE `komoditas` (
  `id_komoditas` bigint UNSIGNED NOT NULL,
  `kode_komoditas` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_komoditas` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga_satuan` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `komoditas`
--

INSERT INTO `komoditas` (`id_komoditas`, `kode_komoditas`, `nama_komoditas`, `kategori`, `harga_satuan`, `created_at`, `updated_at`) VALUES
(4, 'KD-003', 'padi', 'Mapan P05', 120000, '2024-05-13 14:19:56', '2024-05-13 14:34:45'),
(5, 'KD-004', 'jagung', 'Hibrida sumo', 140000, '2024-05-15 20:10:40', '2024-05-15 20:10:40'),
(7, 'KD-005', 'Jagung', 'NK Sumo', 150000, '2024-09-26 19:50:17', '2024-09-26 19:50:17');

-- --------------------------------------------------------

--
-- Table structure for table `lahans`
--

CREATE TABLE `lahans` (
  `id_lahan` bigint UNSIGNED NOT NULL,
  `kode_lahan` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_anggota` bigint UNSIGNED NOT NULL,
  `luas` float(10,0) NOT NULL,
  `jml_petak` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lahans`
--

INSERT INTO `lahans` (`id_lahan`, `kode_lahan`, `id_anggota`, `luas`, `jml_petak`, `created_at`, `updated_at`) VALUES
(3, 'LH-001', 3, 1, 4, '2024-05-15 05:02:35', '2024-05-15 05:02:35'),
(4, 'LH-002', 4, 2, 8, '2024-05-15 20:09:23', '2024-05-15 20:09:23'),
(9, 'LH-003', 3, 123, 1, '2024-08-15 15:58:50', '2024-08-15 15:58:50'),
(11, 'LH-004', 4, 1, 3, '2024-09-26 19:49:33', '2024-09-26 19:49:33');

-- --------------------------------------------------------

--
-- Table structure for table `laporan`
--

CREATE TABLE `laporan` (
  `id` int NOT NULL,
  `arus_kas_id` int DEFAULT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `debit` decimal(15,2) DEFAULT '0.00',
  `credit` decimal(15,2) DEFAULT '0.00',
  `saldo` decimal(15,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `laporans`
--

CREATE TABLE `laporans` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_01_20_024131_create_provinsis_table', 1),
(6, '2024_01_21_053137_create_komoditas_table', 1),
(7, '2024_01_21_060951_create_lahans_table', 1),
(8, '2024_01_21_072323_create_anggotatanis_table', 1),
(9, '2024_01_21_083923_create_bebans_table', 1),
(10, '2024_01_21_145027_create_tanams_table', 1),
(11, '2024_02_23_062053_create_dinas_table', 1),
(12, '2024_02_26_041217_create_upts_table', 1),
(13, '2024_03_22_004851_create_bebantanams_table', 1),
(14, '2024_04_27_234924_create_kabupatens_table', 1),
(15, '2024_05_01_155446_create_bpps_table', 1),
(16, '2024_05_01_170209_create_desas_table', 1),
(17, '2024_05_01_172543_create_kelompoktanis_table', 1),
(18, '2024_06_04_164502_create_importanggotas_table', 2),
(19, '2024_06_12_144007_create_panens_table', 2),
(20, '2024_06_13_163343_create_bebanfixes_table', 3),
(21, '2024_07_01_050045_create_kategoris_table', 4),
(22, '2024_07_02_161824_create_laporans_table', 5),
(23, '2025_01_24_160337_create_g_i_s_table', 5),
(24, '2025_01_25_140631_create_jurnals_table', 5),
(25, '2025_01_25_162547_add_tanggal_to_jurnal_table', 6),
(26, '2025_01_27_113151_create_journal_table', 7);

-- --------------------------------------------------------

--
-- Table structure for table `panens`
--

CREATE TABLE `panens` (
  `id_panen` bigint UNSIGNED NOT NULL,
  `kode_panen` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_tanam` bigint UNSIGNED NOT NULL,
  `tgal_panen` date NOT NULL,
  `jumlah` int NOT NULL,
  `harga` int NOT NULL,
  `hasil_panen` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `panens`
--

INSERT INTO `panens` (`id_panen`, `kode_panen`, `id_tanam`, `tgal_panen`, `jumlah`, `harga`, `hasil_panen`, `created_at`, `updated_at`) VALUES
(12, 'P-001', 6, '2024-08-09', 200, 6000, '3000000', '2024-08-04 21:21:25', '2024-12-27 05:57:12'),
(13, 'P-002', 6, '2024-08-31', 1000, 6000, '6000000', '2024-08-04 21:26:06', '2024-08-04 21:26:06'),
(16, 'P-003', 8, '2024-08-17', 100, 5000, '500000', '2024-08-17 03:34:32', '2024-08-17 03:34:32'),
(19, 'P-004', 7, '2024-08-16', 100, 50000, '5000000', '2024-08-17 03:56:48', '2024-08-17 03:56:48'),
(21, 'P-005', 10, '2024-08-18', 100, 5000, '500000', '2024-08-17 16:44:50', '2024-08-17 16:44:50'),
(22, 'P-006', 8, '2024-09-01', 10, 50000, '500000', '2024-09-26 15:50:44', '2024-09-26 15:50:44'),
(23, 'P-007', 6, '2024-12-27', 200, 15000, '3000000', '2024-12-27 01:42:26', '2024-12-27 01:42:26'),
(24, 'P-008', 6, '2024-12-23', 100, 20000, '2000000', '2024-12-27 03:59:40', '2024-12-27 03:59:40'),
(25, 'P-009', 6, '2024-12-02', 12, 8000, '96000', '2024-12-27 04:27:13', '2024-12-27 04:27:13'),
(26, 'P-010', 6, '2024-12-27', 6, 6000, '36000', '2024-12-27 05:40:35', '2024-12-27 05:40:35'),
(27, 'P-011', 6, '2024-12-27', 5, 30000, '150000', '2024-12-27 05:43:17', '2024-12-27 05:43:17'),
(28, 'P-012', 6, '2024-12-27', 1, 15000, '15000', '2024-12-27 05:56:32', '2024-12-27 05:56:32');

--
-- Triggers `panens`
--
DELIMITER $$
CREATE TRIGGER `after_delete_panens` AFTER DELETE ON `panens` FOR EACH ROW BEGIN  

  DECLARE vhasil_panen DECIMAL(10, 2);

    -- Hitung total harga untuk order_id terkait
    SELECT SUM(hasil_panen) INTO vhasil_panen
    FROM panens
    WHERE id_tanam = OLD.id_tanam ;

 UPDATE tanams
 SET volume_panen = vhasil_panen
 WHERE id_tanam = OLD.id_tanam;

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_insert_panens` AFTER INSERT ON `panens` FOR EACH ROW BEGIN  

  DECLARE vhasil_panen DECIMAL(10, 2);
DECLARE vtgl_panen date;

    -- Hitung total harga untuk order_id terkait
    SELECT SUM(hasil_panen) INTO vhasil_panen
    FROM panens
    WHERE id_tanam = NEW.id_tanam ;

    -- Hitung total harga untuk order_id terkait
    SELECT MAX(tgal_panen) INTO vtgl_panen
    FROM panens
    WHERE id_tanam = NEW.id_tanam ;


 UPDATE tanams
 SET volume_panen = vhasil_panen,  tgl_panen = vtgl_panen
 WHERE id_tanam = NEW.id_tanam;

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_update_panens` AFTER UPDATE ON `panens` FOR EACH ROW BEGIN  

  DECLARE vhasil_panen DECIMAL(10, 2);
  DECLARE vtgl_panen date;


    -- Hitung total harga untuk order_id terkait
    SELECT SUM(hasil_panen) INTO vhasil_panen
    FROM panens
    WHERE id_tanam = NEW.id_tanam ;
	
	 SELECT MAX(tgal_panen) INTO vtgl_panen
    FROM panens
    WHERE id_tanam = NEW.id_tanam ;


 UPDATE tanams
 SET volume_panen = vhasil_panen,tgl_panen = vtgl_panen
 WHERE id_tanam = NEW.id_tanam;

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pemetaan_hasiltani`
--

CREATE TABLE `pemetaan_hasiltani` (
  `longitude` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `latitude` varchar(100) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pencatatan_kas`
--

CREATE TABLE `pencatatan_kas` (
  `kode_transaksi` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_transaksi` date NOT NULL,
  `jenis_transaksi` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `posisi_dr_cr` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `nominal` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `keterangan` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `kode_akun` varchar(100) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `provinsis`
--

CREATE TABLE `provinsis` (
  `id_provinsi` bigint UNSIGNED NOT NULL,
  `kode_provinsi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_provinsi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `longitude` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `provinsis`
--

INSERT INTO `provinsis` (`id_provinsi`, `kode_provinsi`, `nama_provinsi`, `latitude`, `longitude`, `created_at`, `updated_at`) VALUES
(1, 'PR-001', 'jawa barat', '-6.975353', '107.629601', '2024-05-01 23:11:38', '2025-03-25 21:04:10'),
(2, 'PR-002', 'Jawa Tengah', '-6.998940751', '107.629601', '2024-05-15 19:58:40', '2024-08-22 09:18:40'),
(8, 'PR-003', 'Jawa Timur', '-7.627570241834104', '112.51870071519991', '2025-01-29 07:51:35', '2025-01-29 07:51:58');

-- --------------------------------------------------------

--
-- Table structure for table `tanams`
--

CREATE TABLE `tanams` (
  `id_tanam` bigint UNSIGNED NOT NULL,
  `kode_tanam` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_lahan` bigint UNSIGNED NOT NULL,
  `id_komoditas` bigint UNSIGNED NOT NULL,
  `tgl_tanam` date NOT NULL,
  `tgl_panen` date DEFAULT NULL,
  `volume_panen` int UNSIGNED DEFAULT NULL,
  `keuntungan` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `beban_variabel` int UNSIGNED DEFAULT NULL,
  `beban_fix` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tanams`
--

INSERT INTO `tanams` (`id_tanam`, `kode_tanam`, `id_lahan`, `id_komoditas`, `tgl_tanam`, `tgl_panen`, `volume_panen`, `keuntungan`, `beban_variabel`, `beban_fix`, `created_at`, `updated_at`) VALUES
(6, 'TM-001', 3, 4, '2023-08-05', '2024-12-27', 14297000, '11272000', 2920000, '105000.00', '2024-08-04 20:41:23', '2024-08-04 20:41:23'),
(7, 'TM-002', 3, 4, '2024-08-23', '2024-08-16', 5000000, '4350000', 500000, '150000.00', '2024-08-04 21:17:34', '2024-08-04 21:17:34'),
(8, 'TM-003', 4, 5, '2024-08-10', '2024-09-01', 1000000, '500000', 400000, '100000.00', '2024-08-04 22:04:10', '2024-08-04 22:04:10'),
(12, 'TM-006', 11, 5, '2024-09-28', NULL, NULL, NULL, NULL, NULL, '2024-09-26 19:51:15', '2024-12-27 03:59:13'),
(13, 'TM-005', 3, 4, '2024-12-27', NULL, NULL, '0', NULL, NULL, '2024-12-27 03:59:00', '2024-12-27 03:59:00');

--
-- Triggers `tanams`
--
DELIMITER $$
CREATE TRIGGER `calculate_keuntungan` BEFORE UPDATE ON `tanams` FOR EACH ROW BEGIN
    SET NEW.keuntungan = NEW.volume_panen - NEW.beban_variabel - NEW.beban_fix;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `type` enum('kas masuk','kas keluar') COLLATE utf8mb4_general_ci NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL,
  `account_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int NOT NULL,
  `transaksi_id` varchar(50) DEFAULT NULL,
  `tgl_transaksi` date DEFAULT NULL,
  `total` int DEFAULT NULL,
  `status` tinyint DEFAULT '0',
  `created_at` timestamp NULL DEFAULT (now())
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `transaksi_id`, `tgl_transaksi`, `total`, `status`, `created_at`) VALUES
(1, 'TRX05042025001', '2025-04-05', 150000, 1, '2025-04-05 15:15:14'),
(4, '2', '2025-04-05', 19900, 0, '2025-04-05 15:47:12');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_kas`
--

CREATE TABLE `transaksi_kas` (
  `id` int NOT NULL,
  `tanggal` date NOT NULL,
  `jenis` enum('Masuk','Keluar') COLLATE utf8mb4_general_ci NOT NULL,
  `akun_id` int NOT NULL,
  `jumlah` decimal(15,2) NOT NULL,
  `keterangan` text COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `upts`
--

CREATE TABLE `upts` (
  `id_upt` bigint UNSIGNED NOT NULL,
  `kode_upt` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_upt` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `longitude` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_dinas` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `upts`
--

INSERT INTO `upts` (`id_upt`, `kode_upt`, `nama_upt`, `alamat`, `latitude`, `longitude`, `id_dinas`, `created_at`, `updated_at`) VALUES
(1, 'UPT-001', 'upt selaawi', 'garut', '-6.975353', '107.629601', 1, '2024-05-01 23:13:05', '2024-05-01 23:13:05'),
(2, 'UPT-002', 'upt bandung', 'bandung 01', '-6.975353', '107.629601', 1, '2024-05-01 23:13:29', '2024-05-01 23:13:29'),
(3, 'UPT-003', 'UPT pertanian wilayah', 'Jl selaawi limbangan', '-6.99894075', '107.629601', 3, '2024-05-15 20:02:09', '2024-09-25 19:35:44');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'forlandito', 'forlandito14@gmail.com', NULL, '$2y$12$CpbzKsHIkwLPRXUBf3q1yemG/ugkA9tNw2IS0K1CH2zrDLskbdZ.a', NULL, '2024-05-01 23:11:25', '2024-05-01 23:11:25'),
(2, 'Tora Fahrudin', 'torakelana@gmail.com', NULL, '$2y$12$9/RohCVkBy4YMJzhcoEG5e0yvslh77ddxvgSm.I43i.tvC08lcolq', NULL, '2024-08-15 15:49:14', '2024-08-15 15:49:14'),
(3, 'Peny Resmawati', 'penyresmawati@gmail.com', NULL, '$2y$12$sQexMLinxpkhjMtOaaSyxeVk0HGLX713PpBS0ggbn67MPNBd1JAX2', NULL, '2024-09-25 19:30:57', '2024-09-25 19:30:57'),
(4, 'Hendri', 'hardiansyahhendri@gmail.com', NULL, '$2y$12$Pge7oRHg3xZjYl3pOg9Ahe7ipL16aXNAwFWFNeSsRhCJwZnZrnF/O', 'NxzhM4eSvEOGdD0CjWCJfW5hmskFYKpBMZZWmgGVl5AYTwWxzTtJr9KFSXAR', '2024-09-25 19:31:16', '2024-09-25 19:31:16'),
(5, 'llinamarcelina', 'llinamarcelina24@gmail.com', NULL, '$2y$12$.zq3OtRecUZJvHFg2o3cleqCyCP50U1OYOwOdJ/wfUrQGplGXxDxm', 'F9g8aGMwchoU5hVs13wvUDOPFAKKp02DmAP2HvQfGqXrYXW8idc3jV2XJjee', '2024-09-25 19:31:36', '2024-09-25 19:31:36'),
(6, 'Tantan Kertanugraha', 'tantancihayam@gmail.com', NULL, '$2y$12$8zDzKyC9Iy8Jx5ckFj4k9uuTNM1gb6I7MSCt149Uc3LUqYr5cVcwi', 'M0LSoZEK2i0H7xzQ1mpGKmmvVCKoidM6SWB7zcqmjb2ZoDJ9NJxRGZc6tiZh', '2024-09-25 19:32:14', '2024-09-25 19:32:14'),
(7, 'Utami Dwi Nurcahyani', 'utamidwi210@gmail.com', NULL, '$2y$12$/TLqtzriYERFTetw5oWdGOhWoGGPmkiy/H.bbEd7gL8YpQnK6D72K', NULL, '2024-11-06 23:42:24', '2024-11-06 23:42:24'),
(8, 'Utami Test (admin)', 'admin@example.com', NULL, '$2y$10$LLGoczG.NofrFAMe3kCT2e4psU78Rc7eNhoUO9173t62L0171ZPkK', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_waktu_parameter`
-- (See below for the actual view)
--
CREATE TABLE `v_waktu_parameter` (
`waktu` varchar(2)
);

-- --------------------------------------------------------

--
-- Structure for view `v_waktu_parameter`
--
DROP TABLE IF EXISTS `v_waktu_parameter`;

CREATE ALGORITHM=UNDEFINED DEFINER=`utanixyz`@`localhost` SQL SECURITY DEFINER VIEW `v_waktu_parameter`  AS SELECT '01' AS `waktu` union select '02' AS `waktu` union select '03' AS `waktu` union select '04' AS `waktu` union select '05' AS `waktu` union select '06' AS `waktu` union select '07' AS `waktu` union select '08' AS `waktu` union select '09' AS `waktu` union select '10' AS `waktu` union select '11' AS `waktu` union select '12' AS `waktu`  ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `akun`
--
ALTER TABLE `akun`
  ADD PRIMARY KEY (`kode_akun`);

--
-- Indexes for table `anggotatanis`
--
ALTER TABLE `anggotatanis`
  ADD PRIMARY KEY (`id_anggota`);

--
-- Indexes for table `arus_kas`
--
ALTER TABLE `arus_kas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bebanfixes`
--
ALTER TABLE `bebanfixes`
  ADD PRIMARY KEY (`id_bebanfix`);

--
-- Indexes for table `bebans`
--
ALTER TABLE `bebans`
  ADD PRIMARY KEY (`id_beban`);

--
-- Indexes for table `bebantanam`
--
ALTER TABLE `bebantanam`
  ADD PRIMARY KEY (`id_bebantanam`);

--
-- Indexes for table `bpps`
--
ALTER TABLE `bpps`
  ADD PRIMARY KEY (`id_bpp`);

--
-- Indexes for table `cash_transactions`
--
ALTER TABLE `cash_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chart_of_accounts`
--
ALTER TABLE `chart_of_accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_akun` (`kode_akun`);

--
-- Indexes for table `desas`
--
ALTER TABLE `desas`
  ADD PRIMARY KEY (`id_desa`);

--
-- Indexes for table `dinas`
--
ALTER TABLE `dinas`
  ADD PRIMARY KEY (`id_dinas`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `general_journals`
--
ALTER TABLE `general_journals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gis`
--
ALTER TABLE `gis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `g_i_s`
--
ALTER TABLE `g_i_s`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `importanggotas`
--
ALTER TABLE `importanggotas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jenis_transaksi`
--
ALTER TABLE `jenis_transaksi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `journal`
--
ALTER TABLE `journal`
  ADD PRIMARY KEY (`No`);

--
-- Indexes for table `journal_entries`
--
ALTER TABLE `journal_entries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jurnal`
--
ALTER TABLE `jurnal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jurnall`
--
ALTER TABLE `jurnall`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaksi_id` (`transaksi_id`);

--
-- Indexes for table `jurnals`
--
ALTER TABLE `jurnals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jurnal_kas`
--
ALTER TABLE `jurnal_kas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jurnal_umum`
--
ALTER TABLE `jurnal_umum`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kabupatens`
--
ALTER TABLE `kabupatens`
  ADD PRIMARY KEY (`id_kabupaten`),
  ADD UNIQUE KEY `kabupatens_kode_kabupaten_unique` (`kode_kabupaten`),
  ADD UNIQUE KEY `kabupatens_nama_kabupaten_unique` (`nama_kabupaten`);

--
-- Indexes for table `kas_transaksi`
--
ALTER TABLE `kas_transaksi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `kelompoktanis`
--
ALTER TABLE `kelompoktanis`
  ADD PRIMARY KEY (`id_keltani`);

--
-- Indexes for table `komoditas`
--
ALTER TABLE `komoditas`
  ADD PRIMARY KEY (`id_komoditas`);

--
-- Indexes for table `lahans`
--
ALTER TABLE `lahans`
  ADD PRIMARY KEY (`id_lahan`);

--
-- Indexes for table `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `arus_kas_id` (`arus_kas_id`);

--
-- Indexes for table `laporans`
--
ALTER TABLE `laporans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `panens`
--
ALTER TABLE `panens`
  ADD PRIMARY KEY (`id_panen`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pencatatan_kas`
--
ALTER TABLE `pencatatan_kas`
  ADD PRIMARY KEY (`kode_transaksi`),
  ADD UNIQUE KEY `kode_akun` (`kode_akun`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `provinsis`
--
ALTER TABLE `provinsis`
  ADD PRIMARY KEY (`id_provinsi`),
  ADD UNIQUE KEY `provinsis_kode_provinsi_unique` (`kode_provinsi`),
  ADD UNIQUE KEY `provinsis_nama_provinsi_unique` (`nama_provinsi`);

--
-- Indexes for table `tanams`
--
ALTER TABLE `tanams`
  ADD PRIMARY KEY (`id_tanam`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi_kas`
--
ALTER TABLE `transaksi_kas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `akun_id` (`akun_id`);

--
-- Indexes for table `upts`
--
ALTER TABLE `upts`
  ADD PRIMARY KEY (`id_upt`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `anggotatanis`
--
ALTER TABLE `anggotatanis`
  MODIFY `id_anggota` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `arus_kas`
--
ALTER TABLE `arus_kas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `bebanfixes`
--
ALTER TABLE `bebanfixes`
  MODIFY `id_bebanfix` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bebans`
--
ALTER TABLE `bebans`
  MODIFY `id_beban` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `bebantanam`
--
ALTER TABLE `bebantanam`
  MODIFY `id_bebantanam` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `bpps`
--
ALTER TABLE `bpps`
  MODIFY `id_bpp` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cash_transactions`
--
ALTER TABLE `cash_transactions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chart_of_accounts`
--
ALTER TABLE `chart_of_accounts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `desas`
--
ALTER TABLE `desas`
  MODIFY `id_desa` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `dinas`
--
ALTER TABLE `dinas`
  MODIFY `id_dinas` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `general_journals`
--
ALTER TABLE `general_journals`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gis`
--
ALTER TABLE `gis`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `g_i_s`
--
ALTER TABLE `g_i_s`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `importanggotas`
--
ALTER TABLE `importanggotas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jenis_transaksi`
--
ALTER TABLE `jenis_transaksi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `journal`
--
ALTER TABLE `journal`
  MODIFY `No` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `journal_entries`
--
ALTER TABLE `journal_entries`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jurnal`
--
ALTER TABLE `jurnal`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `jurnall`
--
ALTER TABLE `jurnall`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jurnals`
--
ALTER TABLE `jurnals`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jurnal_kas`
--
ALTER TABLE `jurnal_kas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jurnal_umum`
--
ALTER TABLE `jurnal_umum`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kabupatens`
--
ALTER TABLE `kabupatens`
  MODIFY `id_kabupaten` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `kas_transaksi`
--
ALTER TABLE `kas_transaksi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kelompoktanis`
--
ALTER TABLE `kelompoktanis`
  MODIFY `id_keltani` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `komoditas`
--
ALTER TABLE `komoditas`
  MODIFY `id_komoditas` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `lahans`
--
ALTER TABLE `lahans`
  MODIFY `id_lahan` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `laporan`
--
ALTER TABLE `laporan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `laporans`
--
ALTER TABLE `laporans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `panens`
--
ALTER TABLE `panens`
  MODIFY `id_panen` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `provinsis`
--
ALTER TABLE `provinsis`
  MODIFY `id_provinsi` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tanams`
--
ALTER TABLE `tanams`
  MODIFY `id_tanam` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `transaksi_kas`
--
ALTER TABLE `transaksi_kas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `upts`
--
ALTER TABLE `upts`
  MODIFY `id_upt` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `jurnall`
--
ALTER TABLE `jurnall`
  ADD CONSTRAINT `jurnall_ibfk_1` FOREIGN KEY (`transaksi_id`) REFERENCES `kas_transaksi` (`id`);

--
-- Constraints for table `laporan`
--
ALTER TABLE `laporan`
  ADD CONSTRAINT `laporan_ibfk_1` FOREIGN KEY (`arus_kas_id`) REFERENCES `arus_kas` (`id`);

--
-- Constraints for table `transaksi_kas`
--
ALTER TABLE `transaksi_kas`
  ADD CONSTRAINT `transaksi_kas_ibfk_1` FOREIGN KEY (`akun_id`) REFERENCES `chart_of_accounts` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
