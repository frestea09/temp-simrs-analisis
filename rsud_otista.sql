-- phpMyAdmin SQL Dump
-- version 5.0.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 04, 2025 at 08:01 PM
-- Server version: 8.0.42-0ubuntu0.20.04.1
-- PHP Version: 7.4.3-4ubuntu2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rsud_otista`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE `activity_log` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int DEFAULT NULL,
  `text` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_address` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `agamas`
--

CREATE TABLE `agamas` (
  `id` int UNSIGNED NOT NULL,
  `agama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `akutansi_akun_coas`
--

CREATE TABLE `akutansi_akun_coas` (
  `id` int UNSIGNED NOT NULL,
  `akun_code_1` int UNSIGNED NOT NULL,
  `akun_code_2` int UNSIGNED NOT NULL,
  `akun_code_3` int UNSIGNED NOT NULL,
  `akun_code_4` int UNSIGNED NOT NULL,
  `akun_code_5` int UNSIGNED NOT NULL,
  `akun_code_6` int UNSIGNED NOT NULL,
  `akun_code_7` int UNSIGNED NOT NULL,
  `akun_code_8` int UNSIGNED NOT NULL,
  `akun_code_9` int UNSIGNED NOT NULL,
  `code` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  `saldo_normal` enum('debit','kredit') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `akutansi_journals`
--

CREATE TABLE `akutansi_journals` (
  `id` int UNSIGNED NOT NULL,
  `id_supplier` int UNSIGNED DEFAULT NULL,
  `id_customer` int UNSIGNED DEFAULT NULL,
  `contact_type` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `total_transaksi` int NOT NULL DEFAULT '0',
  `type` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `verifikasi` tinyint NOT NULL,
  `source` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `akutansi_journal_details`
--

CREATE TABLE `akutansi_journal_details` (
  `id` int UNSIGNED NOT NULL,
  `id_journal` int UNSIGNED NOT NULL,
  `id_akun_coa` int UNSIGNED NOT NULL,
  `id_kas_dan_bank` int UNSIGNED DEFAULT NULL,
  `id_tarif` int UNSIGNED DEFAULT NULL,
  `debit` int NOT NULL DEFAULT '0',
  `credit` int NOT NULL DEFAULT '0',
  `type` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_operasional` int DEFAULT NULL,
  `keterangan` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `akutansi_kas_dan_banks`
--

CREATE TABLE `akutansi_kas_dan_banks` (
  `id` int UNSIGNED NOT NULL,
  `akun_coa_id` int UNSIGNED NOT NULL,
  `code` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_rek` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  `keterangan` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `akutansi_lap_ekuitases`
--

CREATE TABLE `akutansi_lap_ekuitases` (
  `id` int UNSIGNED NOT NULL,
  `tahun` int NOT NULL,
  `key` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `akutansi_lap_sal`
--

CREATE TABLE `akutansi_lap_sal` (
  `id` int UNSIGNED NOT NULL,
  `tahun` int NOT NULL,
  `key` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `akutansi_pengurangan_piutang`
--

CREATE TABLE `akutansi_pengurangan_piutang` (
  `id` int UNSIGNED NOT NULL,
  `akutansi_penyisihan_piutang_id` int NOT NULL,
  `tahun` int NOT NULL,
  `penyisihan` int DEFAULT NULL,
  `penghapusan` int DEFAULT NULL,
  `penambahan` int DEFAULT NULL,
  `pembayaran` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `akutansi_penyisihan_piutang`
--

CREATE TABLE `akutansi_penyisihan_piutang` (
  `id` int UNSIGNED NOT NULL,
  `cara_bayar_id` int NOT NULL,
  `tahun` int NOT NULL,
  `saldo_piutang` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `akutansi_penyusutan_piutang`
--

CREATE TABLE `akutansi_penyusutan_piutang` (
  `id` int UNSIGNED NOT NULL,
  `tahun` int NOT NULL,
  `penghapusan` int NOT NULL,
  `pengurangan` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `allergy`
--

CREATE TABLE `allergy` (
  `id` int NOT NULL,
  `code` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `display` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `codesystem` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `android_content`
--

CREATE TABLE `android_content` (
  `id` int NOT NULL,
  `type_id` int DEFAULT NULL,
  `content_title` varchar(255) DEFAULT NULL,
  `content_description` longtext,
  `content_path` varchar(255) DEFAULT NULL,
  `content_thumbnail` varchar(255) DEFAULT NULL,
  `content_author` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `android_content_type`
--

CREATE TABLE `android_content_type` (
  `id` int NOT NULL,
  `type_nama` varchar(255) NOT NULL,
  `type_slug` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `android_direksi`
--

CREATE TABLE `android_direksi` (
  `id` int NOT NULL,
  `dir_nik` varchar(255) DEFAULT NULL,
  `dir_nama` varchar(255) DEFAULT NULL,
  `dir_tgllahir` date DEFAULT NULL,
  `dir_tmplahir` varchar(255) DEFAULT NULL,
  `dir_kelamin` char(10) DEFAULT NULL,
  `dir_alamat` text,
  `dir_sambutan` longtext,
  `agama_id` int DEFAULT NULL,
  `manajemen_id` int DEFAULT NULL,
  `jabatan_id` int DEFAULT NULL,
  `dir_photo` varchar(255) DEFAULT NULL,
  `dir_photo_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `android_images`
--

CREATE TABLE `android_images` (
  `id` int NOT NULL,
  `img_path` varchar(255) DEFAULT NULL,
  `img_extention` char(50) DEFAULT NULL,
  `content_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `android_jabatan`
--

CREATE TABLE `android_jabatan` (
  `id` int NOT NULL,
  `jab_nama` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `android_manajemen`
--

CREATE TABLE `android_manajemen` (
  `id` int NOT NULL,
  `manaj_nama` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `android_slider`
--

CREATE TABLE `android_slider` (
  `id` int NOT NULL,
  `slider_path` varchar(255) DEFAULT NULL,
  `slider_img` varchar(255) DEFAULT NULL,
  `slider_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `antrian2`
--

CREATE TABLE `antrian2` (
  `id` int UNSIGNED NOT NULL,
  `nomor` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `suara` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `panggil` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `antrian3`
--

CREATE TABLE `antrian3` (
  `id` int UNSIGNED NOT NULL,
  `nomor` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `suara` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `panggil` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `antrian4`
--

CREATE TABLE `antrian4` (
  `id` int UNSIGNED NOT NULL,
  `nomor` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `suara` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `panggil` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `antrian5`
--

CREATE TABLE `antrian5` (
  `id` int UNSIGNED NOT NULL,
  `nomor` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `suara` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `panggil` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `antrian6`
--

CREATE TABLE `antrian6` (
  `id` int UNSIGNED NOT NULL,
  `nomor` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `suara` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `panggil` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `antrians`
--

CREATE TABLE `antrians` (
  `id` int UNSIGNED NOT NULL,
  `nomor` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bagian` enum('atas','bawah') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'bawah',
  `kode_booking` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomor_kode_booking` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `suara` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `panggil` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `poli_id` int DEFAULT NULL,
  `pasien_id` int DEFAULT NULL,
  `dokter_id` int DEFAULT NULL,
  `tanggal` date NOT NULL,
  `loket` int DEFAULT NULL,
  `kelompok` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `antrian_farmasis`
--

CREATE TABLE `antrian_farmasis` (
  `id` int UNSIGNED NOT NULL,
  `nomor` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `suara` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `panggil` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` date NOT NULL,
  `loket` int DEFAULT NULL,
  `kelompok` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `registrasi_id` int DEFAULT NULL,
  `processed_at` timestamp NULL DEFAULT NULL,
  `finished_at` timestamp NULL DEFAULT NULL,
  `panggil1_at` timestamp NULL DEFAULT NULL,
  `panggil2_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `antrian_laboratorium`
--

CREATE TABLE `antrian_laboratorium` (
  `id` int NOT NULL,
  `registrasi_id` int NOT NULL,
  `nomor` int NOT NULL,
  `kelompok` varchar(50) DEFAULT NULL,
  `status` int DEFAULT '0',
  `tanggal` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `antrian_logs`
--

CREATE TABLE `antrian_logs` (
  `id` int NOT NULL,
  `response` text,
  `response_taskid` text,
  `request` text,
  `status` int DEFAULT NULL,
  `nomorantrian` varchar(200) DEFAULT NULL,
  `url` varchar(200) DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `penginput` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `antrian_poli`
--

CREATE TABLE `antrian_poli` (
  `id` int UNSIGNED NOT NULL,
  `registrasi_id` int DEFAULT NULL,
  `histori_kunjungan_irj_id` int DEFAULT NULL,
  `antrian_id` int DEFAULT NULL,
  `nomor` int DEFAULT NULL,
  `suara` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `panggil` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` date NOT NULL,
  `loket` int DEFAULT NULL,
  `poli_id` int DEFAULT NULL,
  `kelompok` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sudah_dipanggil` tinyint DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `antrian_poli_BC`
--

CREATE TABLE `antrian_poli_BC` (
  `id` int UNSIGNED NOT NULL,
  `registrasi_id` int DEFAULT NULL,
  `histori_kunjungan_irj_id` int DEFAULT NULL,
  `antrian_id` int DEFAULT NULL,
  `nomor` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `suara` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `panggil` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` date NOT NULL,
  `loket` int DEFAULT NULL,
  `poli_id` int DEFAULT NULL,
  `kelompok` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sudah_dipanggil` tinyint DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `antrian_radiologis`
--

CREATE TABLE `antrian_radiologis` (
  `id` int NOT NULL,
  `registrasi_id` int NOT NULL,
  `nomor` int NOT NULL,
  `kelompok` varchar(50) DEFAULT NULL,
  `status` int DEFAULT '0',
  `tanggal` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `antrian_rawatinaps`
--

CREATE TABLE `antrian_rawatinaps` (
  `id` int UNSIGNED NOT NULL,
  `nomor` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `suara` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `panggil` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` date NOT NULL,
  `loket` int DEFAULT NULL,
  `kelompok` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `apotekers`
--

CREATE TABLE `apotekers` (
  `id` int UNSIGNED NOT NULL,
  `pegawai_id` int NOT NULL,
  `nama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `apotekers_bc`
--

CREATE TABLE `apotekers_bc` (
  `id` int UNSIGNED NOT NULL,
  `pegawai_id` int NOT NULL,
  `nama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `aturanetikets`
--

CREATE TABLE `aturanetikets` (
  `id` int UNSIGNED NOT NULL,
  `aturan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bdrs`
--

CREATE TABLE `bdrs` (
  `id` int NOT NULL,
  `no_sample` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bdrs_detail`
--

CREATE TABLE `bdrs_detail` (
  `id` int NOT NULL,
  `namatarif` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tarif_id` int DEFAULT NULL,
  `cara_bayar_id` int DEFAULT NULL,
  `total` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `dokter_id` int DEFAULT NULL,
  `pelaksana_lab_id` int DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `bdrs_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `beds`
--

CREATE TABLE `beds` (
  `id` int UNSIGNED NOT NULL,
  `kelompokkelas_id` int DEFAULT NULL,
  `kelas_id` int DEFAULT NULL,
  `kamar_id` int UNSIGNED NOT NULL,
  `nama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `virtual` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `kode` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_location_ss` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reserved` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `hidden` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'N',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bed_logs`
--

CREATE TABLE `bed_logs` (
  `id` int NOT NULL,
  `request` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `biayaregistrasis`
--

CREATE TABLE `biayaregistrasis` (
  `id` int UNSIGNED NOT NULL,
  `tipe` enum('E','R') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `shift` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tarif_id` int UNSIGNED NOT NULL,
  `tahuntarif_id` int UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `biaya_farmasi`
--

CREATE TABLE `biaya_farmasi` (
  `id` int UNSIGNED NOT NULL,
  `nama_biaya` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `biaya_farmasi_detail`
--

CREATE TABLE `biaya_farmasi_detail` (
  `id` int UNSIGNED NOT NULL,
  `biaya_farmasi_id` int NOT NULL,
  `masterobat_id` int NOT NULL,
  `qty` int DEFAULT NULL,
  `obat_racikan` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cara_minum` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `informasi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `biaya_infus`
--

CREATE TABLE `biaya_infus` (
  `id` int UNSIGNED NOT NULL,
  `nama_biaya` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `biaya_infus_detail`
--

CREATE TABLE `biaya_infus_detail` (
  `id` int UNSIGNED NOT NULL,
  `biaya_infus_id` int NOT NULL,
  `tarif_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `biaya_mcu`
--

CREATE TABLE `biaya_mcu` (
  `id` int UNSIGNED NOT NULL,
  `nama_biaya` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `biaya_mcu_detail`
--

CREATE TABLE `biaya_mcu_detail` (
  `id` int UNSIGNED NOT NULL,
  `biaya_mcu_id` int NOT NULL,
  `jenis` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tarif_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `biaya_pemeriksaans`
--

CREATE TABLE `biaya_pemeriksaans` (
  `id` int UNSIGNED NOT NULL,
  `tipe` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pasien` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tarif_id` int UNSIGNED NOT NULL,
  `poli_id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bpjs_kabs`
--

CREATE TABLE `bpjs_kabs` (
  `id` int UNSIGNED NOT NULL,
  `prov_kode` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kabupaten` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bpjs_kecs`
--

CREATE TABLE `bpjs_kecs` (
  `id` int UNSIGNED NOT NULL,
  `prov_kode` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kab_kode` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kecamatan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bpjs_logs`
--

CREATE TABLE `bpjs_logs` (
  `id` int NOT NULL,
  `response` text,
  `response_taskid` text,
  `request` text,
  `status` int DEFAULT NULL,
  `nomorantrian` varchar(200) DEFAULT NULL,
  `url` varchar(200) DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `penginput` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bpjs_master_obat_prb`
--

CREATE TABLE `bpjs_master_obat_prb` (
  `id` bigint NOT NULL,
  `kode` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bpjs_master_program_prb`
--

CREATE TABLE `bpjs_master_program_prb` (
  `id` bigint NOT NULL,
  `kode` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bpjs_prb`
--

CREATE TABLE `bpjs_prb` (
  `id` int NOT NULL,
  `reg_id` int DEFAULT NULL,
  `pasien_id` int DEFAULT NULL,
  `no_srb` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_sep` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_kartu` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `program_prb` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kode_dpjp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `saran` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bpjs_prb_detail_obat`
--

CREATE TABLE `bpjs_prb_detail_obat` (
  `id` int NOT NULL,
  `bpjs_prb_id` int DEFAULT NULL,
  `kode_obat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signa_1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signa_2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jumlah` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bpjs_prb_response`
--

CREATE TABLE `bpjs_prb_response` (
  `id` int NOT NULL,
  `bpjs_prb_id` int DEFAULT NULL,
  `response` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bpjs_provs`
--

CREATE TABLE `bpjs_provs` (
  `id` int UNSIGNED NOT NULL,
  `kode` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `propinsi` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bpjs_rencana_kontrol`
--

CREATE TABLE `bpjs_rencana_kontrol` (
  `id` int NOT NULL,
  `registrasi_id` int DEFAULT NULL,
  `resume_id` int DEFAULT NULL,
  `no_surat_kontrol` varchar(100) DEFAULT NULL,
  `dokter_id` int DEFAULT NULL,
  `poli_id` int DEFAULT NULL,
  `pasien_id` int DEFAULT NULL,
  `tgl_rencana_kontrol` date DEFAULT NULL,
  `month_only` tinyint(1) DEFAULT '0',
  `user_id` int DEFAULT NULL,
  `no_sep` varchar(100) DEFAULT NULL,
  `no_rujukan` varchar(200) DEFAULT NULL,
  `tujuanKunj` varchar(200) DEFAULT NULL,
  `flagProcedure` varchar(200) DEFAULT NULL,
  `kdPenunjang` varchar(200) DEFAULT NULL,
  `assesmentPel` varchar(200) DEFAULT NULL,
  `diagnosa_awal` varchar(255) DEFAULT NULL,
  `input_from` varchar(200) DEFAULT NULL,
  `tte` longtext,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `carabayars`
--

CREATE TABLE `carabayars` (
  `id` int UNSIGNED NOT NULL,
  `carabayar` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `general_code` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `configs`
--

CREATE TABLE `configs` (
  `id` int UNSIGNED NOT NULL,
  `nama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `website` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo_paripurna` varchar(199) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bayardepan` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kasirtindakan` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `antrianfooter` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahuntarif` char(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `panjangkodepasien` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ipsep` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `usersep` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ipinacbg` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `pt` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kota` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dinas` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `npwp` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tlp` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_pos` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `visi_misi` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pegawai_id` int NOT NULL,
  `create_org` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `province_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `regency_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `district_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `village_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_organization` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `latitude` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `altitude` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `rt` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rw` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_satusehat` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `status_finger_kiosk` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `status_tte` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `status_validasi_sep` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `conf_consid`
--

CREATE TABLE `conf_consid` (
  `id` int NOT NULL,
  `consid` varchar(100) NOT NULL,
  `aktif` enum('0','1') NOT NULL DEFAULT '1',
  `menit` int DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `conf_rl31`
--

CREATE TABLE `conf_rl31` (
  `id_conf_rl31` int NOT NULL,
  `kegiatan` varchar(100) NOT NULL,
  `nomer` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `conf_rl33`
--

CREATE TABLE `conf_rl33` (
  `id` int NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `jumlah` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `conf_rl33_new`
--

CREATE TABLE `conf_rl33_new` (
  `id_conf_rl33` int NOT NULL,
  `kegiatan` varchar(50) DEFAULT NULL,
  `nomer` varchar(15) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `conf_rl34`
--

CREATE TABLE `conf_rl34` (
  `id_conf_rl34` int NOT NULL,
  `kegiatan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomer` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `conf_rl35`
--

CREATE TABLE `conf_rl35` (
  `id_conf_rl35` int NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` int DEFAULT NULL,
  `nomor` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `conf_rl36`
--

CREATE TABLE `conf_rl36` (
  `id` int NOT NULL,
  `nama` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `conf_rl36_new`
--

CREATE TABLE `conf_rl36_new` (
  `id_conf_rl36` int NOT NULL,
  `kegiatan` varchar(50) DEFAULT NULL,
  `nomer` varchar(15) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `conf_rl37`
--

CREATE TABLE `conf_rl37` (
  `id_conf_rl37` int NOT NULL,
  `kegiatan` varchar(50) DEFAULT NULL,
  `nomer` varchar(10) DEFAULT NULL,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `conf_rl38`
--

CREATE TABLE `conf_rl38` (
  `id_conf_rl38` int NOT NULL,
  `kegiatan` varchar(50) DEFAULT NULL,
  `nomer` varchar(10) DEFAULT NULL,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `conf_rl39`
--

CREATE TABLE `conf_rl39` (
  `id_conf_rl39` int NOT NULL,
  `kegiatan` varchar(50) DEFAULT NULL,
  `nomer` varchar(10) DEFAULT NULL,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `conf_rl310`
--

CREATE TABLE `conf_rl310` (
  `id_conf_rl310` int NOT NULL,
  `kegiatan` varchar(50) DEFAULT NULL,
  `nomer` varchar(50) DEFAULT NULL,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `conf_rl311`
--

CREATE TABLE `conf_rl311` (
  `id_conf_rl311` int NOT NULL,
  `kegiatan` varchar(50) DEFAULT NULL,
  `nomer` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `conf_rl312`
--

CREATE TABLE `conf_rl312` (
  `id_conf_rl312` int NOT NULL,
  `kegiatan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomer` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `copy_reseps`
--

CREATE TABLE `copy_reseps` (
  `id` int UNSIGNED NOT NULL,
  `no_resep` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kamar_id` int DEFAULT NULL,
  `pembuat_resep` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int NOT NULL,
  `registrasi_id` int NOT NULL,
  `dokter_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `copy_resep_details`
--

CREATE TABLE `copy_resep_details` (
  `id` int UNSIGNED NOT NULL,
  `no_resep` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `penjualan_id` int NOT NULL,
  `masterobat_id` int NOT NULL,
  `logistik_batch_id` int DEFAULT NULL,
  `jumlah` int NOT NULL,
  `retur_inacbg` int DEFAULT NULL,
  `jml_kronis` int DEFAULT NULL,
  `retur_kronis` int DEFAULT NULL,
  `hargajual` int DEFAULT NULL,
  `hargajual_kronis` int DEFAULT NULL,
  `etiket` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cetak` char(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Y',
  `tipe_rawat` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `informasi1` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expired` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `data_seps`
--

CREATE TABLE `data_seps` (
  `id` int UNSIGNED NOT NULL,
  `nik` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `registrasi_id` int DEFAULT NULL,
  `namapasien` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_kartu` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_ppk_perujuk` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kode_ppk_perujuk` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_rm` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_bpjs` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_tlp` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgl_rujukan` date DEFAULT NULL,
  `no_rujukan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ppk_rujukan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_perujuk` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `diagnosa_awal` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis_layanan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `asalRujukan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hak_kelas_inap` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `katarak` int DEFAULT NULL,
  `tglSep` date DEFAULT NULL,
  `tipe_jkn` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `poli_bpjs` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `noSurat` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kodeDPJP` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `laka_lantas` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `penjamin` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_lp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tglKejadian` date DEFAULT NULL,
  `kll` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `suplesi` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `noSepSuplesi` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kdPropinsi` int DEFAULT NULL,
  `kdKabupaten` int DEFAULT NULL,
  `kdKecamatan` int DEFAULT NULL,
  `no_sep` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `carabayar_id` int DEFAULT NULL,
  `catatan_bpjs` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cob` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dokter_id` int DEFAULT NULL,
  `​kodeDPJP` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deposits`
--

CREATE TABLE `deposits` (
  `id` int UNSIGNED NOT NULL,
  `registrasi_id` int NOT NULL,
  `nominal` int NOT NULL,
  `return` int NOT NULL DEFAULT '0',
  `keluarga` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kasir` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `umur` int NOT NULL,
  `pekerjaan` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `detailradiologis`
--

CREATE TABLE `detailradiologis` (
  `id` int UNSIGNED NOT NULL,
  `hasilradiologi_id` int NOT NULL,
  `resum` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `diagnosa_keperawatans`
--

CREATE TABLE `diagnosa_keperawatans` (
  `id` int NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `kode` varchar(255) DEFAULT NULL,
  `jenis` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `districts`
--

CREATE TABLE `districts` (
  `id` char(7) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `regency_id` char(4) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `districts2`
--

CREATE TABLE `districts2` (
  `id` char(7) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `regency_id` char(4) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dokumen_rekam_medis`
--

CREATE TABLE `dokumen_rekam_medis` (
  `id` int UNSIGNED NOT NULL,
  `registrasi_id` int NOT NULL,
  `pasien_id` int NOT NULL,
  `radiologi` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `resummedis` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `operasi` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `laboratorium` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pathway` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ekg` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `echo` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `echocardiograms`
--

CREATE TABLE `echocardiograms` (
  `id` int UNSIGNED NOT NULL,
  `registrasi_id` int DEFAULT NULL,
  `pasien_id` int DEFAULT NULL,
  `fungsi_sistolik` enum('baik','cukup','menurun') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ef` int NOT NULL,
  `dimensi_ruang_jantung` enum('normal','la_dilatasi','lv_dilatasi','ra_dilatasi','rv_dilatasi','semua_dilatasi') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lv` enum('konsentrik(+)','Eksentrik(+)','(-)') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `global` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fungsi_sistolik_rv` enum('baik','menurun') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tapse` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `katup_katup_jantung_mitral` enum('ms_ringan','ms_sedang','ms_berat') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `katup_katup_jantung_aorta` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `katup_katup_jantung_aorta_cuspis` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `katup_katup_jantung_trikuspid` enum('tr_ringan','tr_sedang','tr_berat') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `katup_katup_jantung_pulmonal` enum('pr_ringan','pr_sedang','pr_berat') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `atrium_kiri` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `ventrikel_kanan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pwd` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lvesd` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ea` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pws` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `diagnosa` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `ee` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lvmi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lvedd` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rwt` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ejeksi_fraksi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ivss` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ivsd` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kesimpulan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `catatan_dokter` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `tte` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `edukasis`
--

CREATE TABLE `edukasis` (
  `id` int NOT NULL,
  `keterangan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `display` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='sumber: satusehat';

-- --------------------------------------------------------

--
-- Table structure for table `edukasi_diets`
--

CREATE TABLE `edukasi_diets` (
  `id` int NOT NULL,
  `nama` varchar(255) NOT NULL,
  `registrasi_id` int NOT NULL,
  `jenis` char(10) DEFAULT NULL,
  `jenis_diet` char(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `carabayar_id` int NOT NULL,
  `catatan_dokter` text,
  `id_composition_ss` varchar(255) DEFAULT NULL,
  `kode` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ekspertise_duplicate`
--

CREATE TABLE `ekspertise_duplicate` (
  `id` int NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `ekspertise` longtext,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `emr`
--

CREATE TABLE `emr` (
  `id` int UNSIGNED NOT NULL,
  `registrasi_id` int NOT NULL,
  `pasien_id` int DEFAULT NULL,
  `dokter_id` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `poli_id` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `histori_ranap_id` int DEFAULT NULL,
  `unit` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'RAWAT INAP,JALAN,DARURAT',
  `tekanandarah` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bb` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `object` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `assesment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `pemeriksaan_fisik` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `notation` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `planning` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `diagnosis` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `diagnosistambahan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discharge` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `nadi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tekanan_darah` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `frekuensi_nafas` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `suhu` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `saturasi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `berat_badan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `skala_nyeri` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `implementasi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `id_procedure_ss` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_show_resume` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `user_id` int DEFAULT NULL,
  `tte` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `state` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_sesuai` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'N',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `verifikasi_dpjp` timestamp NULL DEFAULT NULL,
  `deleted_at` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_observation_ss` json DEFAULT NULL,
  `kesadaran` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `edukasi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `diet` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prognosis` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `situation` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `recomendation` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `background` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `ekstra` longtext COLLATE utf8mb4_unicode_ci,
  `hasil_usg` longtext COLLATE utf8mb4_unicode_ci,
  `hasil_echo` longtext COLLATE utf8mb4_unicode_ci,
  `hasil_ekg` longtext COLLATE utf8mb4_unicode_ci,
  `hasil_eeg` longtext COLLATE utf8mb4_unicode_ci,
  `hasil_ctg` longtext COLLATE utf8mb4_unicode_ci,
  `hasil_spirometri` longtext COLLATE utf8mb4_unicode_ci,
  `hasil_lainnya` longtext COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `emr_ews`
--

CREATE TABLE `emr_ews` (
  `id` int NOT NULL,
  `pasien_id` int NOT NULL,
  `registrasi_id` int NOT NULL,
  `user_id` int NOT NULL,
  `dokter_id` int DEFAULT NULL,
  `type` varchar(100) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `id_observation_ss` varchar(255) DEFAULT NULL,
  `diagnosis` longtext,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` varchar(200) DEFAULT NULL,
  `waktu` time DEFAULT NULL,
  `tte` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `emr_farmasi`
--

CREATE TABLE `emr_farmasi` (
  `id` int NOT NULL,
  `registrasi_id` int NOT NULL,
  `pasien_id` int NOT NULL,
  `subjective` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `objective` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `asesmen` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `planning` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `edukasi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `user_id` int NOT NULL,
  `tte` longtext,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `emr_gizi`
--

CREATE TABLE `emr_gizi` (
  `id` int NOT NULL,
  `registrasi_id` int NOT NULL,
  `pasien_id` int NOT NULL,
  `kamar_id` int NOT NULL,
  `assesment` text,
  `diagnosis` text,
  `intervensi` text,
  `monitoring` text,
  `evaluasi` text,
  `user_id` int NOT NULL,
  `tte` longtext,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `emr_inap_icds`
--

CREATE TABLE `emr_inap_icds` (
  `id` int NOT NULL,
  `pasien_id` int NOT NULL,
  `registrasi_id` int NOT NULL,
  `user_id` int NOT NULL,
  `type` varchar(100) NOT NULL,
  `icd10` varchar(255) DEFAULT NULL,
  `icd9` varchar(255) DEFAULT NULL,
  `diagnosis` longtext,
  `kategori` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `emr_inap_kondisi_khususes`
--

CREATE TABLE `emr_inap_kondisi_khususes` (
  `id` int NOT NULL,
  `pasien_id` int NOT NULL,
  `registrasi_id` int NOT NULL,
  `user_id` int NOT NULL,
  `type` varchar(100) NOT NULL,
  `penggunaan_alat_bantu` longtext,
  `cacat_tubuh` longtext,
  `kondisi_sosial` longtext,
  `permasalahan_gizi` longtext,
  `edukasi_pasien` longtext,
  `edukasi_emergency` longtext,
  `kondisi_mukosa_oral` longtext,
  `obgyn` longtext,
  `rencana` longtext,
  `generalis` longtext,
  `saraf_otak` longtext,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `emr_inap_medical_records`
--

CREATE TABLE `emr_inap_medical_records` (
  `id` int NOT NULL,
  `keterangan` text NOT NULL,
  `type` varchar(255) NOT NULL,
  `pasien_id` int NOT NULL,
  `registrasi_id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` int DEFAULT NULL,
  `deleted_at` varchar(200) DEFAULT NULL,
  `konsul_rajal` text,
  `konsul_ranap` text,
  `menstruasi` longtext,
  `riwayat` longtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `emr_inap_pemeriksaans`
--

CREATE TABLE `emr_inap_pemeriksaans` (
  `id` int NOT NULL,
  `nomor` varchar(255) DEFAULT NULL,
  `pasien_id` int NOT NULL,
  `registrasi_id` int NOT NULL,
  `user_id` int NOT NULL,
  `userdokter_id` int DEFAULT NULL,
  `type` varchar(100) NOT NULL,
  `tanda_vital` longtext,
  `nutrisi` longtext,
  `fungsional` longtext,
  `fisik` longtext,
  `keterangan` longtext,
  `file_planning` text,
  `file_diagnosis` text,
  `pemeriksaandalam` longtext,
  `evaluasi` text,
  `obgyn` longtext,
  `rekonsiliasi` text,
  `obatAlergi` text,
  `diagnosis` longtext,
  `id_observation_ss` varchar(255) DEFAULT NULL,
  `id_sarana_transportasi_ss` varchar(255) DEFAULT NULL,
  `id_surat_pengantar_rujukan_ss` varchar(255) DEFAULT NULL,
  `id_kondisi_pasien_tiba_ss` varchar(255) DEFAULT NULL,
  `id_condition_keluhan_utama_ss` varchar(255) DEFAULT NULL,
  `id_allergy_intolerance_ss` varchar(255) DEFAULT NULL,
  `observation_satu_sehat` text,
  `tte` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `is_done_input` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `emr_inap_penilaians`
--

CREATE TABLE `emr_inap_penilaians` (
  `id` int NOT NULL,
  `pasien_id` int NOT NULL,
  `registrasi_id` int NOT NULL,
  `user_id` int NOT NULL,
  `type` varchar(100) NOT NULL,
  `nyeri` longtext,
  `padiatric` longtext,
  `gizi` longtext,
  `imunisasi` longtext,
  `tumbuh` longtext,
  `diagnosis` longtext,
  `fisik` longtext,
  `image` varchar(255) DEFAULT NULL,
  `cppt_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `emr_inap_perencanaans`
--

CREATE TABLE `emr_inap_perencanaans` (
  `id` int NOT NULL,
  `nomor` varchar(255) DEFAULT NULL,
  `no_referensi` varchar(255) DEFAULT NULL,
  `poli_id` int DEFAULT NULL,
  `dokter_id` int DEFAULT NULL,
  `pasien_id` int NOT NULL,
  `registrasi_id` int NOT NULL,
  `user_id` int NOT NULL,
  `type` varchar(100) NOT NULL,
  `keterangan` text,
  `ket_anamnesa` text,
  `ket_fisik` text,
  `tgl_kontrol` date DEFAULT NULL,
  `tgl_selesai` date DEFAULT NULL,
  `jam_kontrol` varchar(10) DEFAULT NULL,
  `lama_istirahat` varchar(10) DEFAULT NULL,
  `staf_pelaku_nama` varchar(255) DEFAULT NULL,
  `staf_pelaku_unit` varchar(255) DEFAULT NULL,
  `staf_penerima_nama` varchar(255) DEFAULT NULL,
  `staf_penerima_unit` varchar(255) DEFAULT NULL,
  `staf_penerima_noTelp` varchar(255) DEFAULT NULL,
  `pengantar_nama` varchar(255) DEFAULT NULL,
  `pengantar_noTelp` varchar(255) DEFAULT NULL,
  `riwayat_alergi` varchar(255) DEFAULT NULL,
  `pemeriksaan_penunjang` varchar(255) DEFAULT NULL,
  `diagnosis` varchar(255) DEFAULT NULL,
  `terapi` varchar(255) DEFAULT NULL,
  `sbar` longtext,
  `kebutuhan_ruangan` varchar(200) DEFAULT NULL,
  `rencana_terapi` varchar(200) DEFAULT NULL,
  `dokter_igd_id` int DEFAULT NULL,
  `dokter_dpjp_id` int DEFAULT NULL,
  `tte` longtext,
  `rujukan_rs` longtext,
  `is_draft` tinyint DEFAULT NULL,
  `tubuh_manusia` varchar(255) DEFAULT NULL,
  `kepala_manusia` varchar(255) DEFAULT NULL,
  `lokalis_manusia_lainnya` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `emr_keadaan_umums`
--

CREATE TABLE `emr_keadaan_umums` (
  `id` int NOT NULL,
  `registrasi_id` int NOT NULL,
  `pasien_id` int NOT NULL,
  `keterangan` text,
  `master_keadaan_umum_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `emr_konsuls`
--

CREATE TABLE `emr_konsuls` (
  `id` int UNSIGNED NOT NULL,
  `konsul_dokter_id` int DEFAULT NULL,
  `registrasi_id` int NOT NULL,
  `dokter_pengirim` int DEFAULT NULL,
  `dokter_penjawab` int DEFAULT NULL,
  `pasien_id` int DEFAULT NULL,
  `poli_id` int DEFAULT NULL,
  `poli_asal_id` int DEFAULT NULL,
  `unit` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'RAWAT INAP,JALAN,DARURAT',
  `jawab_konsul` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `anjuran` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `alasan_konsul` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `user_id` int DEFAULT NULL,
  `keterangan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `waktu` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verifikator` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `emr_master_keadaan_umums`
--

CREATE TABLE `emr_master_keadaan_umums` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `unit` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `emr_mrs`
--

CREATE TABLE `emr_mrs` (
  `id` int UNSIGNED NOT NULL,
  `registrasi_id` int NOT NULL,
  `dokter_id` int DEFAULT NULL,
  `pasien_id` int DEFAULT NULL,
  `unit` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'RAWAT INAP,JALAN,DARURAT',
  `type` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kontrol_poli` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `operasi_belakang` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `operasi_depan` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `operasi_depan_belakang` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `resume` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `anestesi` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `tanggal` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `emr_pengkajian_harians`
--

CREATE TABLE `emr_pengkajian_harians` (
  `id` int UNSIGNED NOT NULL,
  `registrasi_id` int NOT NULL,
  `pasien_id` int DEFAULT NULL,
  `dokter_id` int DEFAULT NULL,
  `poli_id` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unit` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'RAWAT INAP,JALAN,DARURAT',
  `tekanandarah` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nadi` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `frekuensi_nafas` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `suhu` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `berat_badan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `skala_nyeri` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `keterangan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `emr_resume`
--

CREATE TABLE `emr_resume` (
  `id` int NOT NULL,
  `pasien_id` int NOT NULL,
  `registrasi_id` int NOT NULL,
  `user_id` int NOT NULL,
  `type` varchar(100) NOT NULL,
  `content` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` varchar(200) DEFAULT NULL,
  `tte` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `emr_riwayats`
--

CREATE TABLE `emr_riwayats` (
  `id` int NOT NULL,
  `registrasi_id` int DEFAULT NULL,
  `pasien_id` int DEFAULT NULL,
  `unit` varchar(10) DEFAULT NULL,
  `type` longtext,
  `tipe_anamnesis` varchar(100) DEFAULT NULL,
  `tipe_anamnesis_keterangan` text,
  `keluhan_utama` text,
  `riwayat_penyakit_sekarang` text,
  `riwayat_pengobatan` text,
  `riwayat_medis_sebelumnya` int DEFAULT '0',
  `riwayat_medis_sebelumnya_keterangan` text,
  `sejarah_bedah` text,
  `tanda_vital` text,
  `tekanan_darah` text,
  `suhu_tubuh` double DEFAULT NULL,
  `nadi` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `id_observation_ss` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `emr_riwayat_kesehatans`
--

CREATE TABLE `emr_riwayat_kesehatans` (
  `id` int NOT NULL,
  `registrasi_id` int DEFAULT NULL,
  `pasien_id` int DEFAULT NULL,
  `riwayat_id` int DEFAULT NULL,
  `riwayat_kesehatan_id` int DEFAULT NULL,
  `keterangan` text,
  `tipe` enum('A','K','I','CM','AM') DEFAULT NULL COMMENT '''A''=Alergi, K= Kesehatan, I = Informasi dari, CM=cara masuk, AM=asal masuk',
  `checked` int NOT NULL DEFAULT '0',
  `user_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `esign_logs`
--

CREATE TABLE `esign_logs` (
  `id` int NOT NULL,
  `registrasi_id` int DEFAULT NULL,
  `response` json DEFAULT NULL,
  `request` json DEFAULT NULL,
  `type` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `status` enum('success','fail') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `extra` json DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `farmasi_faktur`
--

CREATE TABLE `farmasi_faktur` (
  `id` int NOT NULL,
  `no_faktur` varchar(45) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `supplier_id` varchar(45) DEFAULT NULL,
  `keterangan` varchar(200) DEFAULT NULL,
  `no_transaksi` varchar(45) DEFAULT NULL,
  `sumber_dana` varchar(45) DEFAULT NULL,
  `user_create` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `farmasi_faktur_detail`
--

CREATE TABLE `farmasi_faktur_detail` (
  `id` int NOT NULL,
  `faktur_id` varchar(45) DEFAULT NULL,
  `kode_barang` varchar(45) DEFAULT NULL,
  `nama_barang` varchar(100) DEFAULT NULL,
  `jumlah` int DEFAULT NULL,
  `satuan` varchar(45) DEFAULT NULL,
  `harga_ppn` int DEFAULT NULL,
  `total` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `farmasi_po`
--

CREATE TABLE `farmasi_po` (
  `id` int NOT NULL,
  `no_po` varchar(45) DEFAULT NULL,
  `supplier_id` int DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `tgl_penerimaan` date DEFAULT NULL,
  `user_create` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `farmasi_po_detail`
--

CREATE TABLE `farmasi_po_detail` (
  `id` int NOT NULL,
  `po_id` int DEFAULT NULL,
  `no_po` varchar(45) DEFAULT NULL,
  `kode_item` varchar(45) DEFAULT NULL,
  `nama_item` varchar(100) DEFAULT NULL,
  `jumlah` int DEFAULT NULL,
  `satuan` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fasilitas`
--

CREATE TABLE `fasilitas` (
  `id` int UNSIGNED NOT NULL,
  `fasilitas` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faskes_lanjutans`
--

CREATE TABLE `faskes_lanjutans` (
  `id` int UNSIGNED NOT NULL,
  `kode_ppk` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_ppk` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kab_kota` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faskes_rujukan_rs`
--

CREATE TABLE `faskes_rujukan_rs` (
  `id` int NOT NULL,
  `jenis_faskes` varchar(50) NOT NULL,
  `nama_rs` varchar(255) NOT NULL,
  `alamat_rs` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `foliopelak`
--

CREATE TABLE `foliopelak` (
  `id` int UNSIGNED NOT NULL,
  `folio_id` int DEFAULT NULL,
  `dpjp` int DEFAULT NULL,
  `dokter_pelaksana` int DEFAULT NULL,
  `dokter_anestesi` int DEFAULT NULL,
  `perawat_anestesi1` int DEFAULT NULL,
  `perawat_anestesi2` int DEFAULT NULL,
  `perawat_anestesi3` int DEFAULT NULL,
  `dokter_operator` int DEFAULT NULL,
  `dokter_lab` int DEFAULT NULL,
  `analis_lab` int DEFAULT NULL,
  `dokter_radiologi` int DEFAULT NULL,
  `radiografer` int DEFAULT NULL,
  `perawat` int DEFAULT NULL,
  `dokter_bedah` int DEFAULT NULL,
  `perawat_ibs1` int DEFAULT NULL,
  `perawat_ibs2` int DEFAULT NULL,
  `perawat_ibs3` int DEFAULT NULL,
  `perawat_ibs4` int DEFAULT NULL,
  `perawat_ibs5` int DEFAULT NULL,
  `bidan` int DEFAULT NULL,
  `pelaksana_tipe` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `foliopelaksanas`
--

CREATE TABLE `foliopelaksanas` (
  `id` int UNSIGNED NOT NULL,
  `folio_id` int DEFAULT NULL,
  `dpjp` int DEFAULT NULL,
  `dokter_pelaksana` int DEFAULT NULL,
  `dokter_anestesi` int DEFAULT NULL,
  `perawat_anestesi1` int DEFAULT NULL,
  `perawat_anestesi2` int DEFAULT NULL,
  `perawat_anestesi3` int DEFAULT NULL,
  `dokter_operator` int DEFAULT NULL,
  `dokter_lab` int DEFAULT NULL,
  `analis_lab` int DEFAULT NULL,
  `dokter_radiologi` int DEFAULT NULL,
  `radiografer` int DEFAULT NULL,
  `perawat` int DEFAULT NULL,
  `dokter_bedah` int DEFAULT NULL,
  `perawat_ibs1` int DEFAULT NULL,
  `perawat_ibs2` int DEFAULT NULL,
  `perawat_ibs3` int DEFAULT NULL,
  `perawat_ibs4` int DEFAULT NULL,
  `perawat_ibs5` int DEFAULT NULL,
  `bidan` int DEFAULT NULL,
  `pelaksana_tipe` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `folios`
--

CREATE TABLE `folios` (
  `id` int UNSIGNED NOT NULL,
  `registrasi_id` int UNSIGNED DEFAULT NULL,
  `namatarif` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cara_bayar_id` int NOT NULL DEFAULT '0',
  `total` int DEFAULT NULL,
  `tarif_id` int DEFAULT NULL,
  `jenis` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lunas` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dibayar` int DEFAULT NULL,
  `jasa_racik` int DEFAULT NULL,
  `waktu_dibayar` timestamp NULL DEFAULT NULL,
  `sinkron_inhealth` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis_pasien` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_kuitansi` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `diskon` int DEFAULT '0',
  `pembulatan_penjualan` int DEFAULT NULL,
  `total_harga` int DEFAULT NULL,
  `pasien_id` int UNSIGNED DEFAULT NULL,
  `dokter_id` int UNSIGNED DEFAULT NULL,
  `user_id` int UNSIGNED DEFAULT NULL,
  `poli_id` int DEFAULT NULL,
  `gudang_id` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `poli_tipe` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tagihan_id` int UNSIGNED DEFAULT NULL,
  `dijamin` int DEFAULT '0',
  `subsidi` int DEFAULT NULL,
  `iur_bayar` int DEFAULT NULL,
  `harus_bayar` int DEFAULT NULL,
  `dijamin1` int DEFAULT NULL,
  `dijamin2` int DEFAULT NULL,
  `pembatal` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `waktu_batal` datetime DEFAULT NULL,
  `is_batal` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verif_rj` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'N',
  `verif_rj_user` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verif_kasa` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'N',
  `verif_kasa_user` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kelompokkelas_id` int DEFAULT NULL,
  `kamar_id` int DEFAULT NULL,
  `mapping_biaya_id` int DEFAULT NULL,
  `dpjp` int DEFAULT NULL,
  `dokter_pelaksana` int DEFAULT NULL,
  `catatan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tercetak` enum('N','Y') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'N',
  `dokter_anestesi` int DEFAULT NULL,
  `dokter_anak` int DEFAULT NULL,
  `perawat_anestesi1` int DEFAULT NULL,
  `perawat_anestesi2` int DEFAULT NULL,
  `perawat_anestesi3` int DEFAULT NULL,
  `dokter_operator` int DEFAULT NULL,
  `dokter_lab` int DEFAULT NULL,
  `dokter_radiologi` int DEFAULT NULL,
  `perawat` int DEFAULT NULL,
  `dokter_bedah` int DEFAULT NULL,
  `perawat_ibs1` int DEFAULT NULL,
  `perawat_ibs2` int DEFAULT NULL,
  `perawat_ibs3` int DEFAULT NULL,
  `perawat_ibs4` int DEFAULT NULL,
  `perawat_ibs5` int DEFAULT NULL,
  `bidan` int DEFAULT NULL,
  `penanggung_jawab` int DEFAULT NULL,
  `analis_lab` int DEFAULT NULL,
  `radiografer` int DEFAULT NULL,
  `cyto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cyto_biasa` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kelas_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `waktu_periksa` datetime DEFAULT NULL,
  `diagnosa` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_sediaan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pelaksana_tipe` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `embalase` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status_puasa` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mulai_puasa` datetime DEFAULT NULL,
  `selesai_puasa` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  `jam_masuk` time DEFAULT NULL,
  `jam_penanganan` time DEFAULT NULL,
  `order_lab_id` int DEFAULT NULL,
  `waktu_visit` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gizis`
--

CREATE TABLE `gizis` (
  `id` int UNSIGNED NOT NULL,
  `registrasi_id` int NOT NULL,
  `dokter` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kelas_id` int DEFAULT NULL,
  `kamar_id` int DEFAULT NULL,
  `bed_id` int DEFAULT NULL,
  `pagi` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `siang` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `malam` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `catatan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `who_update` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hasillabs`
--

CREATE TABLE `hasillabs` (
  `id` int UNSIGNED NOT NULL,
  `no_lab` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `json` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `registrasi_id` int UNSIGNED NOT NULL,
  `pasien_id` int UNSIGNED NOT NULL,
  `dokter_id` int UNSIGNED NOT NULL,
  `penanggungjawab` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tgl_pemeriksaan` date NOT NULL,
  `tgl_bahanditerima` date NOT NULL,
  `tgl_hasilselesai` date NOT NULL,
  `tgl_cetak` date NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `jam` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jamkeluar` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sample` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pesan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `kesan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `saran` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `no_sediaan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tte` json DEFAULT NULL,
  `order_lab_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hasilradiologis`
--

CREATE TABLE `hasilradiologis` (
  `id` int UNSIGNED NOT NULL,
  `registrasi_id` int NOT NULL,
  `dokter` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kelas_id` int DEFAULT NULL,
  `kamar_id` int DEFAULT NULL,
  `bed_id` int DEFAULT NULL,
  `pemeriksaan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `who_update` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hasil_pemeriksaan`
--

CREATE TABLE `hasil_pemeriksaan` (
  `id` int UNSIGNED NOT NULL,
  `no_hasil_pemeriksaan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `registrasi_id` int UNSIGNED NOT NULL,
  `pasien_id` int UNSIGNED NOT NULL,
  `dokter_id` int UNSIGNED NOT NULL,
  `penanggungjawab` int NOT NULL DEFAULT '0',
  `filename` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgl_pemeriksaan` datetime NOT NULL,
  `tgl_hasilselesai` datetime NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `keterangan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `hfis_dokters`
--

CREATE TABLE `hfis_dokters` (
  `id` int NOT NULL,
  `kodesubspesialis` varchar(50) DEFAULT NULL,
  `hari` varchar(50) DEFAULT NULL,
  `kapasitaspasien` int DEFAULT NULL,
  `libur` int DEFAULT NULL,
  `namahari` varchar(20) DEFAULT NULL,
  `jadwal` varchar(20) DEFAULT NULL,
  `jadwal_start` varchar(10) DEFAULT NULL,
  `jadwal_end` varchar(10) DEFAULT NULL,
  `namasubspesialis` varchar(100) DEFAULT NULL,
  `namadokter` varchar(100) DEFAULT NULL,
  `kodepoli` varchar(50) DEFAULT NULL,
  `namapoli` varchar(100) DEFAULT NULL,
  `kodedokter` int DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `histori_hapus_fakturs`
--

CREATE TABLE `histori_hapus_fakturs` (
  `id` int UNSIGNED NOT NULL,
  `penjualandetail` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `penjualan` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `folio` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `total_faktur` int NOT NULL,
  `total_folio` int DEFAULT NULL,
  `total_uang_racik` int DEFAULT NULL,
  `no_faktur` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `histori_kasirs`
--

CREATE TABLE `histori_kasirs` (
  `id` int UNSIGNED NOT NULL,
  `registrasi_id` int NOT NULL,
  `pasien_id` int NOT NULL,
  `id_tarif` int NOT NULL,
  `alasan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `folio_record` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `user_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `histori_kunjungan_igd`
--

CREATE TABLE `histori_kunjungan_igd` (
  `id` int NOT NULL,
  `registrasi_id` int NOT NULL,
  `pasien_id` int NOT NULL,
  `dokter_id` int DEFAULT NULL,
  `triage_nama` varchar(45) NOT NULL,
  `doa` enum('Y','N') DEFAULT 'N',
  `user` varchar(45) NOT NULL,
  `pengirim_rujukan` char(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `histori_kunjungan_irj`
--

CREATE TABLE `histori_kunjungan_irj` (
  `id` int NOT NULL,
  `registrasi_id` int NOT NULL,
  `pasien_id` int NOT NULL,
  `poli_id` int NOT NULL,
  `dokter_id` int DEFAULT NULL,
  `user` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `pengirim_rujukan` char(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `histori_kunjungan_jnzs`
--

CREATE TABLE `histori_kunjungan_jnzs` (
  `id` int NOT NULL,
  `registrasi_id` int NOT NULL,
  `pasien_id` int NOT NULL,
  `poli_tipe` varchar(11) NOT NULL,
  `pasien_asal` varchar(10) NOT NULL,
  `user` varchar(45) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `histori_kunjungan_lab`
--

CREATE TABLE `histori_kunjungan_lab` (
  `id` int NOT NULL,
  `registrasi_id` int NOT NULL,
  `pasien_id` int NOT NULL,
  `poli_id` int NOT NULL,
  `pasien_asal` enum('TA','TI','TG') DEFAULT NULL,
  `user` varchar(45) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `histori_kunjungan_prts`
--

CREATE TABLE `histori_kunjungan_prts` (
  `id` int NOT NULL,
  `registrasi_id` int NOT NULL,
  `pasien_id` int NOT NULL,
  `poli_tipe` varchar(11) NOT NULL,
  `pasien_asal` varchar(10) NOT NULL,
  `user` varchar(45) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `histori_kunjungan_rad`
--

CREATE TABLE `histori_kunjungan_rad` (
  `id` int NOT NULL,
  `registrasi_id` int NOT NULL,
  `pasien_id` int NOT NULL,
  `poli_id` int NOT NULL,
  `pasien_asal` enum('TA','TI','TG') DEFAULT NULL,
  `user` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `histori_kunjungan_rm`
--

CREATE TABLE `histori_kunjungan_rm` (
  `id` int NOT NULL,
  `registrasi_id` int NOT NULL,
  `pasien_id` int NOT NULL,
  `poli_id` int NOT NULL,
  `pasien_asal` varchar(10) NOT NULL,
  `user` varchar(45) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `histori_order_lab`
--

CREATE TABLE `histori_order_lab` (
  `id` int UNSIGNED NOT NULL,
  `registrasi_id` int UNSIGNED NOT NULL,
  `catatan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tarif_id` text COLLATE utf8mb4_unicode_ci,
  `unit` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int UNSIGNED DEFAULT NULL,
  `is_done` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `histori_pengunjung`
--

CREATE TABLE `histori_pengunjung` (
  `id` int NOT NULL,
  `registrasi_id` int NOT NULL,
  `pasien_id` int DEFAULT NULL,
  `politipe` enum('J','G','I') NOT NULL,
  `status_pasien` enum('LAMA','BARU') DEFAULT NULL,
  `user` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `pengirim_rujukan` char(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `histori_rawatinap`
--

CREATE TABLE `histori_rawatinap` (
  `id` int UNSIGNED NOT NULL,
  `rawatinap_id` int NOT NULL,
  `registrasi_id` int NOT NULL,
  `pasien_id` int NOT NULL,
  `no_rm` char(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kelompokkelas_id` int DEFAULT NULL,
  `kelas_id` int NOT NULL,
  `kamar_id` int NOT NULL,
  `bed_id` int NOT NULL,
  `dokter_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `pengirim` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgl_masuk` datetime DEFAULT NULL,
  `tgl_keluar` datetime DEFAULT NULL,
  `carabayar_id` int NOT NULL,
  `rencana_pulang` date DEFAULT NULL,
  `dirujuk` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `lari` enum('YN','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `mati` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `histori_seps`
--

CREATE TABLE `histori_seps` (
  `id` int UNSIGNED NOT NULL,
  `nik` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `registrasi_id` int DEFAULT NULL,
  `namapasien` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_kartu` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_ppk_perujuk` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kode_ppk_perujuk` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_rm` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_bpjs` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_tlp` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgl_rujukan` date DEFAULT NULL,
  `no_rujukan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ppk_rujukan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_perujuk` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `diagnosa_awal` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis_layanan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `asalRujukan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hak_kelas_inap` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `katarak` int DEFAULT NULL,
  `tglSep` date DEFAULT NULL,
  `tipe_jkn` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `poli_bpjs` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `noSurat` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kodeDPJP` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `laka_lantas` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `penjamin` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_lp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tglKejadian` date DEFAULT NULL,
  `kll` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `suplesi` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `noSepSuplesi` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kdPropinsi` int DEFAULT NULL,
  `kdKabupaten` int DEFAULT NULL,
  `kdKecamatan` int DEFAULT NULL,
  `no_sep` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `carabayar_id` int DEFAULT NULL,
  `catatan_bpjs` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cob` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dokter_id` int DEFAULT NULL,
  `​kodeDPJP` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `histori_statuses`
--

CREATE TABLE `histori_statuses` (
  `id` int UNSIGNED NOT NULL,
  `registrasi_id` int UNSIGNED NOT NULL,
  `status` char(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `poli_id` int DEFAULT NULL,
  `bed_id` int UNSIGNED DEFAULT NULL,
  `user_id` int UNSIGNED DEFAULT NULL,
  `pengirim_rujukan` char(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `journal_id` bigint DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `histori_userlogins`
--

CREATE TABLE `histori_userlogins` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int NOT NULL,
  `ip_address` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hrd_administrasis`
--

CREATE TABLE `hrd_administrasis` (
  `id` int UNSIGNED NOT NULL,
  `nama` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `nomor` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `format` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `path` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `filename` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `extension` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `tanggal` date DEFAULT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hrd_anaks`
--

CREATE TABLE `hrd_anaks` (
  `id` int UNSIGNED NOT NULL,
  `biodata_id` int UNSIGNED NOT NULL,
  `nama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tmplahir` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgllahir` date DEFAULT NULL,
  `kelamin` enum('L','P') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `anakke` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pendidikan_id` int UNSIGNED NOT NULL,
  `pekerjaan_id` int UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hrd_biodatas`
--

CREATE TABLE `hrd_biodatas` (
  `id` int UNSIGNED NOT NULL,
  `namalengkap` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tmplahir` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgllahir` date DEFAULT NULL,
  `kelamin` enum('L','P') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `goldarah` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `suku` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `agama_id` int UNSIGNED NOT NULL,
  `warganegara` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `statuskawin` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `province_id` char(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `regency_id` char(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `district_id` char(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `village_id` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `notlp` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nohp` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kdpos` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gelar_dpn` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gelar_blk` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tmtcpns` date DEFAULT NULL,
  `dupeg` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nokartupegawai` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `noktp` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `noaskes` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notaspen` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `npwp` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nokarsu` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenisfungsional` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fungsional` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fungsionaltertentu` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hrd_cutis`
--

CREATE TABLE `hrd_cutis` (
  `id` int UNSIGNED NOT NULL,
  `biodata_id` int UNSIGNED NOT NULL,
  `tglmulai` date DEFAULT NULL,
  `tglselesai` date DEFAULT NULL,
  `nosk` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tglsk` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hrd_disiplin_pegawais`
--

CREATE TABLE `hrd_disiplin_pegawais` (
  `id` int UNSIGNED NOT NULL,
  `biodata_id` int UNSIGNED NOT NULL,
  `unitorganisasi` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unitkerja` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jabatan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `namadisiplin` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nosk` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tglsk` date DEFAULT NULL,
  `tmtdisiplin` date DEFAULT NULL,
  `tmtdaluarsa` date DEFAULT NULL,
  `pelanggaran` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hrd_gaji_berkalas`
--

CREATE TABLE `hrd_gaji_berkalas` (
  `id` int UNSIGNED NOT NULL,
  `biodata_id` int UNSIGNED NOT NULL,
  `noskkgb` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tglskkgb` date DEFAULT NULL,
  `pangkat` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `golongan` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gajipokok` int DEFAULT NULL,
  `tmtkgb` date DEFAULT NULL,
  `tmtyad` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hrd_ijin_belajars`
--

CREATE TABLE `hrd_ijin_belajars` (
  `id` int UNSIGNED NOT NULL,
  `biodata_id` int UNSIGNED NOT NULL,
  `jenis` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nosk` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tglsk` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hrd_jabatans`
--

CREATE TABLE `hrd_jabatans` (
  `id` int UNSIGNED NOT NULL,
  `biodata_id` int UNSIGNED NOT NULL,
  `namajabatan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fungsionaltertentu` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unitorganisasi` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unitkerja` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `eselon` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pangkat` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `golongan` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tglsk` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hrd_jenis_cuti`
--

CREATE TABLE `hrd_jenis_cuti` (
  `id` int NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `kuota` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hrd_keluargas`
--

CREATE TABLE `hrd_keluargas` (
  `id` int UNSIGNED NOT NULL,
  `biodata_id` int UNSIGNED NOT NULL,
  `namaayah` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tmplahirayah` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgllahirayah` date DEFAULT NULL,
  `alamatayah` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nohpayah` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pekerjaanayah_id` int UNSIGNED NOT NULL,
  `namaibu` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tmplahiribu` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgllahiribu` date DEFAULT NULL,
  `alamatibu` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nohpibu` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pekerjaanibu_id` int UNSIGNED NOT NULL,
  `namapasangan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tmplahirpasangan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgllahirpasangan` date DEFAULT NULL,
  `tglnikah` date DEFAULT NULL,
  `pendidikan_id` int UNSIGNED NOT NULL,
  `pekerjaanpasangan_id` int UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hrd_kepangkatans`
--

CREATE TABLE `hrd_kepangkatans` (
  `id` int UNSIGNED NOT NULL,
  `biodata_id` int UNSIGNED NOT NULL,
  `jenis` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pangkat` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `golongan` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nosk` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tglsk` date DEFAULT NULL,
  `tmtpangkat` date DEFAULT NULL,
  `mkgtahun` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mkgbulan` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gajipokok` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hrd_pendidikan_formals`
--

CREATE TABLE `hrd_pendidikan_formals` (
  `id` int UNSIGNED NOT NULL,
  `biodata_id` int UNSIGNED NOT NULL,
  `pendidikan_id` int UNSIGNED NOT NULL,
  `jurusan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sekolah` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `akreditasi` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamatsekolah` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tglsttb` date DEFAULT NULL,
  `tahunmasuk` char(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tahunlulus` char(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hrd_penghargaans`
--

CREATE TABLE `hrd_penghargaans` (
  `id` int UNSIGNED NOT NULL,
  `biodata_id` int UNSIGNED NOT NULL,
  `namapenghargaan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nosk` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tglsk` date DEFAULT NULL,
  `asalpenghargaan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pemberipenghargaan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hrd_perubahan_gapoks`
--

CREATE TABLE `hrd_perubahan_gapoks` (
  `id` int UNSIGNED NOT NULL,
  `biodata_id` int UNSIGNED NOT NULL,
  `jenis` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nosk` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tglsk` date DEFAULT NULL,
  `tmt` date DEFAULT NULL,
  `gajipokok` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `icd9s`
--

CREATE TABLE `icd9s` (
  `id` int UNSIGNED NOT NULL,
  `nomor` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `icd9_im`
--

CREATE TABLE `icd9_im` (
  `id` int NOT NULL,
  `code` varchar(100) DEFAULT NULL,
  `code2` varchar(100) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `system` varchar(100) DEFAULT NULL,
  `validcode` int DEFAULT NULL,
  `accpdx` varchar(2) DEFAULT NULL,
  `asterisk` int DEFAULT NULL,
  `im` int DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `icd9_im_old`
--

CREATE TABLE `icd9_im_old` (
  `id` int NOT NULL,
  `code` varchar(100) DEFAULT NULL,
  `code2` varchar(100) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `system` varchar(100) DEFAULT NULL,
  `validcode` int DEFAULT NULL,
  `accpdx` varchar(2) DEFAULT NULL,
  `asterisk` int DEFAULT NULL,
  `im` int DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `icd10s`
--

CREATE TABLE `icd10s` (
  `id` int UNSIGNED NOT NULL,
  `nomor` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `icd10_im`
--

CREATE TABLE `icd10_im` (
  `id` int NOT NULL,
  `code` varchar(100) DEFAULT NULL,
  `code2` varchar(100) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `system` varchar(100) DEFAULT NULL,
  `validcode` int DEFAULT NULL,
  `accpdx` varchar(2) DEFAULT NULL,
  `asterisk` int DEFAULT NULL,
  `im` int DEFAULT NULL,
  `icd10_id` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `icd10_inacbg`
--

CREATE TABLE `icd10_inacbg` (
  `id` int NOT NULL,
  `code` varchar(100) DEFAULT NULL,
  `code2` varchar(100) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `system` varchar(100) DEFAULT NULL,
  `validcode` int DEFAULT NULL,
  `accpdx` varchar(2) DEFAULT NULL,
  `asterisk` int DEFAULT NULL,
  `im` int DEFAULT NULL,
  `icd10_id` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `icdo_im`
--

CREATE TABLE `icdo_im` (
  `id` int NOT NULL,
  `code` varchar(100) DEFAULT NULL,
  `code2` varchar(100) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `system` varchar(100) DEFAULT NULL,
  `validcode` int DEFAULT NULL,
  `accpdx` varchar(2) DEFAULT NULL,
  `asterisk` int DEFAULT NULL,
  `im` int DEFAULT NULL,
  `icd10_id` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `implementasi_keperawatans`
--

CREATE TABLE `implementasi_keperawatans` (
  `id` int NOT NULL,
  `nama_implementasi` text NOT NULL,
  `diagnosa_keperawatan_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inacbgs`
--

CREATE TABLE `inacbgs` (
  `id` int UNSIGNED NOT NULL,
  `pasien_nama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pasien_kelamin` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pasien_tgllahir` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis_pembayaran` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_kartu` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_sep` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_pasien` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kelas_perawatan` int NOT NULL,
  `los` int DEFAULT NULL,
  `cara_keluar` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dokter` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `berat` int NOT NULL,
  `total_rs` int NOT NULL,
  `surat_rujukan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bhp` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `severity` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adl` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sp` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `drugs` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_rm` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pembayaran_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `idrg_grouper` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `final_grouper` int DEFAULT NULL,
  `final_idrg` enum('0','1') COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `diagnosa_inagrouper` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icd9_inacbg` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icd10_inacbg` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icd1` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icd2` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icd3` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icd4` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icd5` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icd6` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icd7` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icd8` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icd9` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icd10` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `urun_bayar_rupiah` int DEFAULT NULL,
  `urun_bayar_persen` int DEFAULT NULL,
  `prosedur_inagrouper` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prosedur1` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prosedur2` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prosedur3` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prosedur4` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prosedur5` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prosedur6` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prosedur7` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prosedur8` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prosedur9` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prosedur10` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_hp` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `poli_id` int DEFAULT NULL,
  `registrasi_id` int NOT NULL,
  `dijamin` int DEFAULT NULL,
  `kode` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_step` enum('grouping_idrg','final_idrg','import_idrg','grouping_inacbg','final_claim','done') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `final_klaim` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `who_update` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `who_final_klaim` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `special_cmg` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `topup` int DEFAULT NULL,
  `tgl_masuk` datetime DEFAULT NULL,
  `tgl_keluar` datetime DEFAULT NULL,
  `kirim_dc` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deskripsi_grouper` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mdc_number_1` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `mdc_description_1` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `drg_code_1` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `drg_description_1` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `mdc_number_2` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `mdc_description_2` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `drg_code_2` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `drg_description_2` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `grouping_stage1` text COLLATE utf8mb4_unicode_ci,
  `grouping_stage2` text COLLATE utf8mb4_unicode_ci,
  `upgrade_class_class` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icu_indikator` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adl_chronic` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adl_sub_acute` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `versi_eklaim` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inacbgs_bc`
--

CREATE TABLE `inacbgs_bc` (
  `id` int UNSIGNED NOT NULL,
  `pasien_nama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pasien_kelamin` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pasien_tgllahir` date NOT NULL,
  `jenis_pembayaran` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_kartu` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_sep` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_pasien` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kelas_perawatan` int NOT NULL,
  `los` int DEFAULT NULL,
  `cara_keluar` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dokter` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `berat` int NOT NULL,
  `total_rs` int NOT NULL,
  `surat_rujukan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bhp` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `severity` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adl` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sp` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `drugs` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_rm` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pembayaran_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icd1` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icd2` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icd3` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icd4` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icd5` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icd6` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icd7` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icd8` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icd9` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icd10` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icd11` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icd12` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icd13` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icd14` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icd15` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icd16` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icd17` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icd18` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icd19` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icd20` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icd21` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icd22` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icd23` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icd24` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icd25` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icd26` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icd27` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icd28` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `urun_bayar_rupiah` int DEFAULT NULL,
  `urun_bayar_persen` int DEFAULT NULL,
  `prosedur1` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prosedur2` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prosedur3` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prosedur4` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prosedur5` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prosedur6` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prosedur7` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prosedur8` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prosedur9` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prosedur10` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prosedur11` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prosedur12` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prosedur13` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prosedur14` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prosedur15` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prosedur16` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prosedur17` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prosedur18` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prosedur19` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prosedur20` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prosedur21` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prosedur22` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prosedur23` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prosedur24` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prosedur25` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prosedur26` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prosedur27` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prosedur28` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prosedur29` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prosedur30` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_hp` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `poli_id` int DEFAULT NULL,
  `registrasi_id` int NOT NULL,
  `dijamin` int DEFAULT NULL,
  `kode` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `final_klaim` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `who_update` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `who_final_klaim` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `topup` int DEFAULT NULL,
  `tgl_masuk` datetime DEFAULT NULL,
  `tgl_keluar` datetime DEFAULT NULL,
  `kirim_dc` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deskripsi_grouper` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `versi_eklaim` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inacbgs_sementara`
--

CREATE TABLE `inacbgs_sementara` (
  `id` int NOT NULL,
  `registrasi_id` int NOT NULL,
  `inacbgs2` int NOT NULL,
  `inacbgs1` int NOT NULL,
  `user_id` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `inacbg_logs`
--

CREATE TABLE `inacbg_logs` (
  `id` int NOT NULL,
  `response` text,
  `request` text,
  `status` int DEFAULT NULL,
  `no_sep` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `url` varchar(200) DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `penginput` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inhealth_sjp`
--

CREATE TABLE `inhealth_sjp` (
  `id` int NOT NULL,
  `reg_id` int DEFAULT NULL,
  `no_sjp` varchar(255) DEFAULT NULL,
  `tgl_sjp` date DEFAULT NULL,
  `nama_poli` varchar(255) DEFAULT NULL,
  `noka_peserta` varchar(255) DEFAULT NULL,
  `plan_desc` varchar(255) DEFAULT NULL,
  `kelas` varchar(255) DEFAULT NULL,
  `nomor_rm` varchar(255) DEFAULT NULL,
  `jenis_kelamin` varchar(255) DEFAULT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `tgl_rujukan` date DEFAULT NULL,
  `jenis_pelayanan` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `instalasis`
--

CREATE TABLE `instalasis` (
  `id` int UNSIGNED NOT NULL,
  `nama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `intervensi_keperawatans`
--

CREATE TABLE `intervensi_keperawatans` (
  `id` int NOT NULL,
  `nama_intervensi` text NOT NULL,
  `diagnosa_keperawatan_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jadwaldokters`
--

CREATE TABLE `jadwaldokters` (
  `id` int UNSIGNED NOT NULL,
  `poli` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dokter` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `hari` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jam_mulai` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jam_berakhir` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jamkesdas`
--

CREATE TABLE `jamkesdas` (
  `id` int UNSIGNED NOT NULL,
  `registrasi_id` int NOT NULL,
  `dijamin` int NOT NULL,
  `user_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jam_laporans`
--

CREATE TABLE `jam_laporans` (
  `id` int NOT NULL,
  `nama` varchar(200) DEFAULT NULL,
  `jam_buka` varchar(100) DEFAULT NULL,
  `jam_tutup` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jenisjkns`
--

CREATE TABLE `jenisjkns` (
  `id` int UNSIGNED NOT NULL,
  `nama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jenis_pengeluarans`
--

CREATE TABLE `jenis_pengeluarans` (
  `id` int NOT NULL,
  `name` varchar(255) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `akutansi_akun_coa_id` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `jkn_icd9s`
--

CREATE TABLE `jkn_icd9s` (
  `id` int UNSIGNED NOT NULL,
  `icd9` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `registrasi_id` int UNSIGNED NOT NULL,
  `carabayar_id` int UNSIGNED NOT NULL,
  `jenis` char(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kategori` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `diagnosis` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `kasus` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_at` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_procedure_ss` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jkn_icd10s`
--

CREATE TABLE `jkn_icd10s` (
  `id` int UNSIGNED NOT NULL,
  `icd10` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `registrasi_id` int UNSIGNED NOT NULL,
  `carabayar_id` int UNSIGNED NOT NULL,
  `jenis` char(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kategori` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `diagnosis` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `kasus` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_condition_ss` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_at` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kamars`
--

CREATE TABLE `kamars` (
  `id` int UNSIGNED NOT NULL,
  `nama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_location_ss` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kelas_id` int UNSIGNED NOT NULL,
  `kelompokkelas_id` int DEFAULT NULL,
  `conf_rl31_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `hidden` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kategoriheaders`
--

CREATE TABLE `kategoriheaders` (
  `id` int UNSIGNED NOT NULL,
  `nama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kategoriobats`
--

CREATE TABLE `kategoriobats` (
  `id` int UNSIGNED NOT NULL,
  `nama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kategoritarifs`
--

CREATE TABLE `kategoritarifs` (
  `id` int UNSIGNED NOT NULL,
  `namatarif` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategoriheader_id` int UNSIGNED NOT NULL,
  `jenis` enum('TA','TG','TI') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kategori_pegawai`
--

CREATE TABLE `kategori_pegawai` (
  `id` int NOT NULL,
  `kategori` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id` int UNSIGNED NOT NULL,
  `nama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_location_ss` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kelompoktarifs`
--

CREATE TABLE `kelompoktarifs` (
  `id` int UNSIGNED NOT NULL,
  `kelompok` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kelompok_kelas`
--

CREATE TABLE `kelompok_kelas` (
  `id` int NOT NULL,
  `kelompok` varchar(45) DEFAULT NULL,
  `general_code` varchar(200) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kesadarans`
--

CREATE TABLE `kesadarans` (
  `id` int NOT NULL,
  `keterangan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `display` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `translate` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='sumber: satusehat';

-- --------------------------------------------------------

--
-- Table structure for table `klasifikasi_pengeluarans`
--

CREATE TABLE `klasifikasi_pengeluarans` (
  `id` int NOT NULL,
  `name` varchar(255) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kondisi_akhir_pasiens`
--

CREATE TABLE `kondisi_akhir_pasiens` (
  `id` int UNSIGNED NOT NULL,
  `namakondisi` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `urutan` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `jenis` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kondisi_akhir_pasien_ss`
--

CREATE TABLE `kondisi_akhir_pasien_ss` (
  `id` int UNSIGNED NOT NULL,
  `namakondisi` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `urutan` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `kondisi_code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kondisi_display` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pulang_code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pulang_display` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `service_request_code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `service_request_display` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kondisi_pasien_tiba`
--

CREATE TABLE `kondisi_pasien_tiba` (
  `id` int NOT NULL,
  `keterangan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `display` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `system` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='sumber: satusehat';

-- --------------------------------------------------------

--
-- Table structure for table `kuota_dokter`
--

CREATE TABLE `kuota_dokter` (
  `id` int NOT NULL,
  `pegawai_id` int DEFAULT NULL,
  `kuota` int DEFAULT '20',
  `kuota_online` int DEFAULT NULL,
  `terisi` int DEFAULT '0',
  `loket` int DEFAULT NULL,
  `kode_loket` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `buka` time DEFAULT NULL,
  `tutup` time DEFAULT NULL,
  `praktik` enum('Y','T') COLLATE utf8mb4_general_ci DEFAULT 'Y',
  `sunday` int DEFAULT '20',
  `monday` int DEFAULT '20',
  `tuesday` int DEFAULT '20',
  `wednesday` int DEFAULT '20',
  `thursday` int DEFAULT '20',
  `friday` int DEFAULT '20',
  `saturday` int DEFAULT '20',
  `jkn_sunday` int DEFAULT '20',
  `jkn_monday` int DEFAULT '20',
  `jkn_tuesday` int DEFAULT '20',
  `jkn_wednesday` int DEFAULT '20',
  `jkn_thursday` int DEFAULT '20',
  `jkn_friday` int DEFAULT '20',
  `jkn_saturday` int DEFAULT '20',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` date DEFAULT NULL,
  `id_location_ss` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `labkategoris`
--

CREATE TABLE `labkategoris` (
  `id` int UNSIGNED NOT NULL,
  `labsection_id` int UNSIGNED NOT NULL,
  `nama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `laboratoria`
--

CREATE TABLE `laboratoria` (
  `id` int UNSIGNED NOT NULL,
  `labkategori_id` int UNSIGNED NOT NULL,
  `nama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `rujukan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nilairujukanbawah` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nilairujukanatas` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `satuan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `labsections`
--

CREATE TABLE `labsections` (
  `id` int UNSIGNED NOT NULL,
  `nama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lica_results`
--

CREATE TABLE `lica_results` (
  `id` int UNSIGNED NOT NULL,
  `no_lab` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `json` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `pemeriksa` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `tgl_pemeriksaan` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` int UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lis_logs`
--

CREATE TABLE `lis_logs` (
  `id` int NOT NULL,
  `response` text,
  `response_taskid` text,
  `request` text,
  `registrasi_id` int DEFAULT NULL,
  `nomorantrian` varchar(200) DEFAULT NULL,
  `url` varchar(200) DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `penginput` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lis_results`
--

CREATE TABLE `lis_results` (
  `id` int NOT NULL,
  `no_ref` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `json` longtext,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logistik_bapbs`
--

CREATE TABLE `logistik_bapbs` (
  `id` int UNSIGNED NOT NULL,
  `saplier` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_jatuh_tempo` date DEFAULT NULL,
  `no_po` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_faktur` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_faktur` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_bapb` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `satuan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah_dipesan` int DEFAULT NULL,
  `jumlah_diterima` int DEFAULT NULL,
  `keterangan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int NOT NULL,
  `tanggal` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logistik_batches`
--

CREATE TABLE `logistik_batches` (
  `id` int UNSIGNED NOT NULL,
  `masterobat_id` int NOT NULL,
  `bapb_id` int DEFAULT NULL,
  `nama_obat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `stok` int DEFAULT NULL,
  `jumlah_item_diterima` int DEFAULT NULL,
  `satuanbeli_id` int NOT NULL,
  `satuanjual_id` int NOT NULL,
  `gudang_id` int DEFAULT NULL,
  `supplier_id` int DEFAULT '0',
  `user_id` int NOT NULL,
  `nomorbatch` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expireddate` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hargabeli` decimal(10,2) DEFAULT NULL,
  `hargajual_jkn` decimal(10,2) DEFAULT NULL,
  `hargajual_umum` decimal(10,2) DEFAULT NULL,
  `hargajual_dinas` decimal(10,2) DEFAULT NULL,
  `id_medication_ss` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `import` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logistik_batches_BC`
--

CREATE TABLE `logistik_batches_BC` (
  `id` int UNSIGNED NOT NULL,
  `masterobat_id` int NOT NULL,
  `bapb_id` int DEFAULT NULL,
  `nama_obat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `stok` int DEFAULT NULL,
  `jumlah_item_diterima` int DEFAULT NULL,
  `satuanbeli_id` int NOT NULL,
  `satuanjual_id` int NOT NULL,
  `gudang_id` int DEFAULT NULL,
  `supplier_id` int DEFAULT '0',
  `user_id` int NOT NULL,
  `nomorbatch` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expireddate` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hargabeli` decimal(10,2) DEFAULT NULL,
  `hargajual_jkn` decimal(10,2) DEFAULT NULL,
  `hargajual_umum` decimal(10,2) DEFAULT NULL,
  `hargajual_dinas` decimal(10,2) DEFAULT NULL,
  `id_medication_ss` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `import` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logistik_fakturs`
--

CREATE TABLE `logistik_fakturs` (
  `id` int NOT NULL,
  `supplier` text,
  `nama_barang` text,
  `po_id` int DEFAULT NULL,
  `masterobat_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `jenis_pembayaran` enum('1','2') DEFAULT NULL COMMENT '1 = Cash, 2 = Credit',
  `jenis_obat` enum('1','2') DEFAULT NULL COMMENT '1 = JKN, 2= Umum',
  `no_faktur` varchar(255) DEFAULT NULL,
  `tgl_faktur` date DEFAULT NULL,
  `tgl_jatuh_tempo` date DEFAULT NULL,
  `jumlah_box` int DEFAULT '0',
  `jumlah_isi` int DEFAULT '0',
  `jumlah_satuan` int DEFAULT '0',
  `total_tagihan` int DEFAULT '0',
  `total_desimal` decimal(12,2) DEFAULT NULL,
  `tgl_dibayar` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `logistik_gudangs`
--

CREATE TABLE `logistik_gudangs` (
  `id` int UNSIGNED NOT NULL,
  `kode` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bagian` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tlp` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kepala` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nip_kepala` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipe` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `penanggungjawab` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logistik_non_medik_barangs`
--

CREATE TABLE `logistik_non_medik_barangs` (
  `id` int UNSIGNED NOT NULL,
  `nama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `golongan_id` bigint DEFAULT NULL,
  `bidang_id` bigint DEFAULT NULL,
  `kelompok_id` bigint DEFAULT NULL,
  `sub_kelompok_id` bigint DEFAULT NULL,
  `supplier_id` bigint DEFAULT NULL,
  `kategori_id` bigint DEFAULT NULL,
  `harga_beli` bigint DEFAULT NULL,
  `harga_jual` bigint DEFAULT NULL,
  `satuan_beli` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `satuan_jual` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logistik_non_medik_barang_per_gudangs`
--

CREATE TABLE `logistik_non_medik_barang_per_gudangs` (
  `id` int UNSIGNED NOT NULL,
  `nama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `golongan_id` bigint DEFAULT NULL,
  `bidang_id` bigint DEFAULT NULL,
  `kelompok_id` bigint DEFAULT NULL,
  `sub_kelompok_id` bigint DEFAULT NULL,
  `supplier_id` bigint DEFAULT NULL,
  `kategori_id` bigint DEFAULT NULL,
  `harga_beli` bigint DEFAULT NULL,
  `harga_jual` bigint DEFAULT NULL,
  `satuan_beli` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `satuan_jual` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `gudang_id` bigint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logistik_non_medik_bidangs`
--

CREATE TABLE `logistik_non_medik_bidangs` (
  `id` int UNSIGNED NOT NULL,
  `golongan_id` bigint DEFAULT NULL,
  `nama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logistik_non_medik_distribusis`
--

CREATE TABLE `logistik_non_medik_distribusis` (
  `id` int UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logistik_non_medik_golongans`
--

CREATE TABLE `logistik_non_medik_golongans` (
  `id` int UNSIGNED NOT NULL,
  `nama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logistik_non_medik_gudangs`
--

CREATE TABLE `logistik_non_medik_gudangs` (
  `id` int UNSIGNED NOT NULL,
  `set_gudang_pusat` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_gudang` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kepala_gudang` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `gudang_pj` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bagian` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logistik_non_medik_kategoris`
--

CREATE TABLE `logistik_non_medik_kategoris` (
  `id` int UNSIGNED NOT NULL,
  `nama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logistik_non_medik_kelompoks`
--

CREATE TABLE `logistik_non_medik_kelompoks` (
  `id` int UNSIGNED NOT NULL,
  `golongan_id` bigint DEFAULT NULL,
  `bidang_id` bigint DEFAULT NULL,
  `nama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logistik_non_medik_no_pos`
--

CREATE TABLE `logistik_non_medik_no_pos` (
  `id` int UNSIGNED NOT NULL,
  `no_po` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logistik_non_medik_penerimaans`
--

CREATE TABLE `logistik_non_medik_penerimaans` (
  `id` int UNSIGNED NOT NULL,
  `no_po` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_po` date NOT NULL,
  `supplier` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_faktur` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_penerimaan` date NOT NULL,
  `masterbarang_id` int NOT NULL,
  `jumlah` int NOT NULL,
  `terima` int NOT NULL,
  `hna` int NOT NULL,
  `hna_lama` int NOT NULL,
  `total_hna` int NOT NULL,
  `diskon_persen` int NOT NULL,
  `diskon_rupiah` int NOT NULL,
  `ppn` int NOT NULL,
  `hpp` int NOT NULL,
  `harga_jual` int NOT NULL,
  `expired` date NOT NULL,
  `user_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logistik_non_medik_periodes`
--

CREATE TABLE `logistik_non_medik_periodes` (
  `id` int UNSIGNED NOT NULL,
  `nama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `periodeAwal` date NOT NULL,
  `periodeAkhir` date NOT NULL,
  `transaksiAwal` date NOT NULL,
  `transaksiAkhir` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logistik_non_medik_permintaans`
--

CREATE TABLE `logistik_non_medik_permintaans` (
  `id` int UNSIGNED NOT NULL,
  `nomor` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_permintaan` date NOT NULL,
  `gudang_asal` int NOT NULL,
  `gudang_tujuan` int NOT NULL,
  `masterbarang_id` int NOT NULL,
  `jumlah_permintaan` int NOT NULL,
  `sisa_stock` int NOT NULL,
  `keterangan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logistik_non_medik_pos`
--

CREATE TABLE `logistik_non_medik_pos` (
  `id` int UNSIGNED NOT NULL,
  `no_po` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_pengadaan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` date NOT NULL,
  `supplier` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_barang` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `masterbarang_id` int NOT NULL,
  `jumlah` int NOT NULL,
  `sisa` int NOT NULL,
  `satuan` int NOT NULL,
  `hna` int NOT NULL,
  `total_hna` int NOT NULL,
  `diskon_persen` int NOT NULL,
  `diskon_rupiah` int NOT NULL,
  `ppn` int NOT NULL,
  `keterangan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user` int NOT NULL,
  `kode_rekening` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori_barang` int NOT NULL,
  `level` enum('close','open') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logistik_non_medik_saldo_awals`
--

CREATE TABLE `logistik_non_medik_saldo_awals` (
  `id` int UNSIGNED NOT NULL,
  `masterbarang_id` int NOT NULL,
  `batch_no` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expired_date` date NOT NULL,
  `supplier_id` int NOT NULL,
  `total_batch` int NOT NULL,
  `total_stok_awal` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logistik_non_medik_satuans`
--

CREATE TABLE `logistik_non_medik_satuans` (
  `id` int UNSIGNED NOT NULL,
  `nama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` int UNSIGNED DEFAULT NULL,
  `tipe` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logistik_non_medik_sub_kelompoks`
--

CREATE TABLE `logistik_non_medik_sub_kelompoks` (
  `id` int UNSIGNED NOT NULL,
  `golongan_id` bigint DEFAULT NULL,
  `bidang_id` bigint DEFAULT NULL,
  `kelompok_id` bigint DEFAULT NULL,
  `nama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logistik_non_medik_sub_sub_kelompoks`
--

CREATE TABLE `logistik_non_medik_sub_sub_kelompoks` (
  `id` int UNSIGNED NOT NULL,
  `golongan_id` bigint DEFAULT NULL,
  `bidang_id` bigint DEFAULT NULL,
  `kelompok_id` bigint DEFAULT NULL,
  `sub_kelompok_id` bigint DEFAULT NULL,
  `nama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logistik_non_medik_supliers`
--

CREATE TABLE `logistik_non_medik_supliers` (
  `id` int UNSIGNED NOT NULL,
  `kode` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_spk` int UNSIGNED DEFAULT NULL,
  `nama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_kelamin` enum('l','p') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `telepon` char(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logistik_no_batches`
--

CREATE TABLE `logistik_no_batches` (
  `id` int UNSIGNED NOT NULL,
  `gudang_id` int NOT NULL,
  `supplier_id` int DEFAULT NULL,
  `masterobat_id` int NOT NULL,
  `saldo` int NOT NULL,
  `batch_no` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expired_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logistik_opnames`
--

CREATE TABLE `logistik_opnames` (
  `id` int UNSIGNED NOT NULL,
  `logistik_batch_id` int DEFAULT NULL,
  `kategori` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `obat_id` int NOT NULL,
  `nama_item` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggalopname` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `gudang` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `stok_tercatat` int DEFAULT NULL,
  `stok_sebenarnya` int DEFAULT NULL,
  `keterangan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `periode` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logistik_opnames_BC`
--

CREATE TABLE `logistik_opnames_BC` (
  `id` int UNSIGNED NOT NULL,
  `logistik_batch_id` int DEFAULT NULL,
  `kategori` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `obat_id` int NOT NULL,
  `nama_item` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggalopname` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `gudang` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `stok_tercatat` int DEFAULT NULL,
  `stok_sebenarnya` int DEFAULT NULL,
  `keterangan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `periode` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logistik_pejabat_bendaharas`
--

CREATE TABLE `logistik_pejabat_bendaharas` (
  `id` int UNSIGNED NOT NULL,
  `nip` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sk` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jabatan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logistik_pejabat_pemeriksa`
--

CREATE TABLE `logistik_pejabat_pemeriksa` (
  `id` int UNSIGNED NOT NULL,
  `nip` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jabatan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logistik_pejabat_pengadaans`
--

CREATE TABLE `logistik_pejabat_pengadaans` (
  `id` int UNSIGNED NOT NULL,
  `nip` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jabatan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logistik_pemakaians`
--

CREATE TABLE `logistik_pemakaians` (
  `id` int UNSIGNED NOT NULL,
  `masterobat_id` int NOT NULL,
  `batch_no` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gudang_id` int NOT NULL,
  `jumlah` int NOT NULL,
  `keterangan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logistik_penerimaans`
--

CREATE TABLE `logistik_penerimaans` (
  `id` int UNSIGNED NOT NULL,
  `no_po` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_po` date NOT NULL,
  `supplier_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_faktur` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_penerimaan` date NOT NULL,
  `masterobat_id` int NOT NULL,
  `jumlah` int NOT NULL,
  `terima` int NOT NULL,
  `hna` int NOT NULL,
  `hna_lama` int NOT NULL,
  `total_hna` int NOT NULL,
  `diskon_rupiah` int NOT NULL,
  `diskon_persen` int NOT NULL,
  `ppn` int NOT NULL,
  `hpp` int NOT NULL,
  `harga_jual` int NOT NULL,
  `batch` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expired` date NOT NULL,
  `user_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logistik_pengirim_penerimas`
--

CREATE TABLE `logistik_pengirim_penerimas` (
  `id` int UNSIGNED NOT NULL,
  `kode` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nip` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `departemen` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logistik_periodes`
--

CREATE TABLE `logistik_periodes` (
  `id` int UNSIGNED NOT NULL,
  `nama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `periodeAwal` date NOT NULL,
  `periodeAkhir` date NOT NULL,
  `transaksiAwal` date NOT NULL,
  `transaksiAkhir` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logistik_permintaans`
--

CREATE TABLE `logistik_permintaans` (
  `id` int UNSIGNED NOT NULL,
  `nomor` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_permintaan` date NOT NULL,
  `gudang_asal` int NOT NULL,
  `gudang_tujuan` int DEFAULT NULL,
  `masterobat_id` int NOT NULL,
  `jumlah_permintaan` int NOT NULL,
  `sisa_stock` int NOT NULL,
  `terkirim` int DEFAULT NULL,
  `keterangan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `proses_gudang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logistik_pinjam_obats`
--

CREATE TABLE `logistik_pinjam_obats` (
  `id` int UNSIGNED NOT NULL,
  `pinjam_dari` int NOT NULL,
  `nomorberitaacara` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tgl_pinjam` date NOT NULL,
  `pengembalian_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logistik_po`
--

CREATE TABLE `logistik_po` (
  `id` int UNSIGNED NOT NULL,
  `no_po` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_pengadaan` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `gudang_id` int NOT NULL,
  `tanggal` date NOT NULL,
  `supplier` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_barang` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `masterobat_id` int NOT NULL,
  `jumlah` int NOT NULL,
  `sisa_supplier` int NOT NULL DEFAULT '0',
  `satuan` int NOT NULL DEFAULT '0',
  `hna` int DEFAULT '0',
  `total_hna` int DEFAULT '0',
  `diskon_persen` int DEFAULT '0',
  `diskon_rupiah` int DEFAULT '0',
  `ppn` int DEFAULT '0',
  `hpp` int DEFAULT '0',
  `keterangan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_rekening` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kategori_obat` int DEFAULT NULL,
  `status` enum('open','close') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `verifikasi` enum('Y','N','B') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jumlah_verif` int DEFAULT NULL,
  `verif_pphp` enum('Y','T') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'T',
  `verif_ppk` enum('Y','T') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'T',
  `status_po` enum('terima','cencel') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `harga` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_sp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_usulan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `totalHarga` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lampiran` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `perihal` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `merk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jml_ppn` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logistik_saldo_awals`
--

CREATE TABLE `logistik_saldo_awals` (
  `id` int UNSIGNED NOT NULL,
  `masterobat_id` int NOT NULL,
  `batch_no` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expired_date` date NOT NULL,
  `supplier_id` int NOT NULL,
  `total_batch` int NOT NULL,
  `total_stok_awal` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logistik_satkers`
--

CREATE TABLE `logistik_satkers` (
  `id` int UNSIGNED NOT NULL,
  `namasatker` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logistik_spks`
--

CREATE TABLE `logistik_spks` (
  `id` int UNSIGNED NOT NULL,
  `no_po` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomor` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_jabatan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jabatan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mengerjakan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `terbilang` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `waktu_pelaksanaan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `waktu_hari` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mulai_tanggal` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sampai_tanggal` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `anggaran` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kode_rekening` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tahun_anggaran` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pembayarana_pertama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pembayarana_kedua` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pembayarana_ketiga` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pembayarana_keempat` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_pembayarana` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logistik_stocks`
--

CREATE TABLE `logistik_stocks` (
  `id` int UNSIGNED NOT NULL,
  `opname_id` int DEFAULT NULL,
  `gudang_id` int DEFAULT NULL,
  `supplier_id` int DEFAULT NULL,
  `periode_id` int DEFAULT NULL,
  `masterobat_id` int NOT NULL,
  `batch_no` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logistik_batch_id` int DEFAULT NULL,
  `expired_date` date DEFAULT NULL,
  `masuk` int NOT NULL DEFAULT '0',
  `keluar` int NOT NULL DEFAULT '0',
  `total` int NOT NULL DEFAULT '0',
  `user_id` int DEFAULT NULL,
  `keterangan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rincianpinjam_id` int DEFAULT NULL,
  `rincianpengembalian_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logistik_stocks_BC`
--

CREATE TABLE `logistik_stocks_BC` (
  `id` int UNSIGNED NOT NULL,
  `opname_id` int DEFAULT NULL,
  `gudang_id` int DEFAULT NULL,
  `supplier_id` int DEFAULT NULL,
  `periode_id` int DEFAULT NULL,
  `masterobat_id` int NOT NULL,
  `batch_no` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logistik_batch_id` int DEFAULT NULL,
  `expired_date` date DEFAULT NULL,
  `masuk` int NOT NULL DEFAULT '0',
  `keluar` int NOT NULL DEFAULT '0',
  `total` int NOT NULL DEFAULT '0',
  `user_id` int DEFAULT NULL,
  `keterangan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rincianpinjam_id` int DEFAULT NULL,
  `rincianpengembalian_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logistik_suppliers`
--

CREATE TABLE `logistik_suppliers` (
  `id` int UNSIGNED NOT NULL,
  `nama` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `telepon` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('1','0') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `nama_pejabat` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jabatan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nohp` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `log_bridging`
--

CREATE TABLE `log_bridging` (
  `id` int NOT NULL,
  `registrasi_id` int DEFAULT NULL,
  `no_sep` varchar(255) DEFAULT NULL,
  `no_surat` varchar(255) DEFAULT NULL,
  `no_rujukan` varchar(100) DEFAULT NULL,
  `tgl_rujukan` date DEFAULT NULL,
  `poli_tujuan` varchar(255) DEFAULT NULL,
  `kode_dpjp` varchar(50) DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `user` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `log_delete_folio`
--

CREATE TABLE `log_delete_folio` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int DEFAULT NULL,
  `text` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `folio_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `log_users`
--

CREATE TABLE `log_users` (
  `id` int UNSIGNED NOT NULL,
  `registrasi_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `text` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `param` text COLLATE utf8mb4_unicode_ci,
  `output` text COLLATE utf8mb4_unicode_ci,
  `ip_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mastergizis`
--

CREATE TABLE `mastergizis` (
  `id` int UNSIGNED NOT NULL,
  `gizi` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `masteridrg`
--

CREATE TABLE `masteridrg` (
  `id` int NOT NULL,
  `idrg` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `masteridrg_biaya`
--

CREATE TABLE `masteridrg_biaya` (
  `id` int NOT NULL,
  `kelompok` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mastermapping`
--

CREATE TABLE `mastermapping` (
  `id` int NOT NULL,
  `mapping` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mastermapping_biaya`
--

CREATE TABLE `mastermapping_biaya` (
  `id` int NOT NULL,
  `kelompok` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `masterobats`
--

CREATE TABLE `masterobats` (
  `id` int UNSIGNED NOT NULL,
  `nama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alias` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis_obat` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kode` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `satuanjual_id` int UNSIGNED NOT NULL,
  `satuanbeli_id` int UNSIGNED NOT NULL,
  `kategoriobat_id` int UNSIGNED NOT NULL,
  `hargajual` int NOT NULL,
  `hargajual_jkn` int DEFAULT NULL,
  `hargajual_kesda` int NOT NULL DEFAULT '0',
  `hargabeli` int NOT NULL,
  `aktif` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Y',
  `narkotik` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `high_alert` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `generik` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `non_generik` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fornas` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `formularium` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `non_formularium` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `psikotoprik` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bebas` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `e_katalog` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lasa` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `antibiotik` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tablet` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `injeksi` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `infus` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `obat_luar` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `BHP` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sirup` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paten` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bebas_terbatas` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keras` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prekusor` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `saldo` int DEFAULT NULL,
  `isi_satuan_obat` decimal(10,2) DEFAULT '0.00',
  `satuan_obat` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kodekfa` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_medication` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `updated_at` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `deleted_at` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `akutansi_akun_coa_id` bigint DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mastersplits`
--

CREATE TABLE `mastersplits` (
  `id` int UNSIGNED NOT NULL,
  `tahuntarif_id` int UNSIGNED NOT NULL,
  `kategoriheader_id` int UNSIGNED NOT NULL,
  `nama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `master_cara_minums`
--

CREATE TABLE `master_cara_minums` (
  `id` int UNSIGNED NOT NULL,
  `nama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `master_diets`
--

CREATE TABLE `master_diets` (
  `id` int NOT NULL,
  `kode` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `master_dokter_perujuk`
--

CREATE TABLE `master_dokter_perujuk` (
  `id` int NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `alamat` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `master_etikets`
--

CREATE TABLE `master_etikets` (
  `id` int UNSIGNED NOT NULL,
  `nama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `master_licas`
--

CREATE TABLE `master_licas` (
  `id` int NOT NULL,
  `name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `prices` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `general_code` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mt_id` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lab_tind_id` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_at` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `master_licas_BCC`
--

CREATE TABLE `master_licas_BCC` (
  `id` int NOT NULL,
  `name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `prices` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `general_code` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mt_id` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lab_tind_id` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_at` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `master_licas_pakets`
--

CREATE TABLE `master_licas_pakets` (
  `id` int NOT NULL,
  `name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `prices` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `general_code` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mt_id` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lab_tind_id` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `master_ppis`
--

CREATE TABLE `master_ppis` (
  `id` int UNSIGNED NOT NULL,
  `nama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `master_puskesmas`
--

CREATE TABLE `master_puskesmas` (
  `id` int NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `alamat` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `master_riwayat_kesehatans`
--

CREATE TABLE `master_riwayat_kesehatans` (
  `id` int NOT NULL,
  `nama` text,
  `tipe` enum('A','K','I','CM','AM') NOT NULL COMMENT '"A"= ALergi, "K"=Kesehatan , "I" =Informasi di dapat dari , "CM"= Cara Masuk , "AM" = Asal Masuk,'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `metode_bayars`
--

CREATE TABLE `metode_bayars` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `modalities`
--

CREATE TABLE `modalities` (
  `id` int NOT NULL,
  `modalityid` varchar(100) DEFAULT NULL,
  `modalityname` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nomorrms`
--

CREATE TABLE `nomorrms` (
  `id` int UNSIGNED NOT NULL,
  `pasien_id` int NOT NULL,
  `no_rm` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `no_pos`
--

CREATE TABLE `no_pos` (
  `id` int UNSIGNED NOT NULL,
  `no_po` varchar(22) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `obat_antibiotik`
--

CREATE TABLE `obat_antibiotik` (
  `id` int UNSIGNED NOT NULL,
  `masterobat_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `operasis`
--

CREATE TABLE `operasis` (
  `id` int UNSIGNED NOT NULL,
  `registrasi_id` int NOT NULL,
  `kodebooking` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_jkn` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kodepoli` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `namapoli` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `terlaksana` int DEFAULT NULL,
  `rawatinap_id` int DEFAULT NULL,
  `no_rm` int NOT NULL,
  `rencana_operasi` date NOT NULL,
  `suspect` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_lab`
--

CREATE TABLE `order_lab` (
  `id` int NOT NULL,
  `registrasi_id` int DEFAULT NULL,
  `pemeriksaan` text,
  `user_id` int DEFAULT NULL,
  `jenis` enum('TA','TI','TG') DEFAULT NULL,
  `poli_id` int DEFAULT NULL,
  `kamar_id` int DEFAULT NULL,
  `tipe_lab` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `diagnosa` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_odontograms`
--

CREATE TABLE `order_odontograms` (
  `id` int NOT NULL,
  `registrasi_id` int NOT NULL,
  `jenis` char(10) DEFAULT NULL,
  `occlusi` varchar(255) DEFAULT NULL,
  `torus_palatinus` varchar(255) DEFAULT NULL,
  `torus_mandibularis` varchar(255) DEFAULT NULL,
  `palatanum` varchar(255) DEFAULT NULL,
  `diastema` varchar(255) DEFAULT NULL,
  `gigi_anomali` varchar(255) DEFAULT NULL,
  `lain_lain` text,
  `gigi11` text,
  `gigi12` text,
  `gigi13` text,
  `gigi14` text,
  `gigi15` text,
  `gigi16` text,
  `gigi17` text,
  `gigi18` text,
  `gigi21` text,
  `gigi22` text,
  `gigi23` text,
  `gigi24` text,
  `gigi25` text,
  `gigi26` text,
  `gigi27` text,
  `gigi28` text,
  `gigi31` text,
  `gigi32` text,
  `gigi33` text,
  `gigi34` text,
  `gigi35` text,
  `gigi36` text,
  `gigi37` text,
  `gigi38` text,
  `gigi41` text,
  `gigi42` text,
  `gigi43` text,
  `gigi44` text,
  `gigi45` text,
  `gigi46` text,
  `gigi47` text,
  `gigi48` text,
  `gigi51` text,
  `gigi52` text,
  `gigi53` text,
  `gigi54` text,
  `gigi55` text,
  `gigi61` text,
  `gigi62` text,
  `gigi63` text,
  `gigi64` text,
  `gigi65` text,
  `gigi71` text,
  `gigi72` text,
  `gigi73` text,
  `gigi74` text,
  `gigi75` text,
  `gigi81` text,
  `gigi82` text,
  `gigi83` text,
  `gigi84` text,
  `gigi85` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `order_radiologi`
--

CREATE TABLE `order_radiologi` (
  `id` int NOT NULL,
  `registrasi_id` int DEFAULT NULL,
  `pemeriksaan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `user_id` int DEFAULT NULL,
  `jenis` enum('TA','TI','TG') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Y','N','D') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `source` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `response` text,
  `poli_id` int DEFAULT NULL,
  `kamar_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pacs_expertise`
--

CREATE TABLE `pacs_expertise` (
  `id` int NOT NULL,
  `acc_number` varchar(200) DEFAULT NULL,
  `no_rm` varchar(200) DEFAULT NULL,
  `expertise` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pacs_order`
--

CREATE TABLE `pacs_order` (
  `id` int NOT NULL,
  `nama` varchar(200) DEFAULT NULL,
  `no_rm` varchar(200) DEFAULT NULL,
  `insurance` varchar(200) DEFAULT NULL,
  `urgensi` varchar(200) DEFAULT NULL,
  `room` varchar(200) DEFAULT NULL,
  `dokter` varchar(200) DEFAULT NULL,
  `klinis` varchar(200) DEFAULT NULL,
  `radiografer` varchar(200) DEFAULT NULL,
  `tindakan` varchar(200) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pagu_perawatans`
--

CREATE TABLE `pagu_perawatans` (
  `id` int NOT NULL,
  `biaya` int DEFAULT NULL,
  `diagnosa_awal` varchar(254) DEFAULT NULL,
  `kelas_id` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pasiens`
--

CREATE TABLE `pasiens` (
  `id` int UNSIGNED NOT NULL,
  `no_rm` char(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_rm_lama` varchar(9) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tmplahir` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgllahir` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kelamin` enum('L','P') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `golda` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgldaftar` date DEFAULT NULL,
  `hub_keluarga` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_keluarga` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rt` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rw` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kode` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `province_id` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `regency_id` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `district_id` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `village_id` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nohp` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notlp` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `negara` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pekerjaan` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pekerjaan_id` varchar(220) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pendidikan` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `agama_id` varchar(220) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `agama` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `perusahaan_id` int UNSIGNED DEFAULT NULL,
  `pendidikan_id` varchar(220) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_kk` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_sktm` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_jkn` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_jaminan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_sep` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jkn` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nik` varchar(220) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jkn_asal` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipe_paket` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ibu_kandung` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_ayah` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_marital` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nodarurat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanda_tangan` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `api_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `suku_bangsa` int DEFAULT NULL,
  `bhs_pasien` int DEFAULT NULL,
  `cacat_fisik` int DEFAULT NULL,
  `id_patient_ss` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mr_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_create` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_update` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nik_penanggung_jawab` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat_penanggung_jawab` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `remember_token` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pasien_android`
--

CREATE TABLE `pasien_android` (
  `id` int NOT NULL,
  `no_identitas` varchar(50) NOT NULL COMMENT 'No identitas KK/KTP',
  `no_rm` varchar(255) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `tmplahir` varchar(100) DEFAULT NULL,
  `tgllahir` date NOT NULL,
  `kelamin` enum('L','P') NOT NULL,
  `alamat` text,
  `no_hp` varchar(50) DEFAULT NULL,
  `jkn` varchar(100) DEFAULT NULL,
  `api_token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pasien_langsung`
--

CREATE TABLE `pasien_langsung` (
  `id` int NOT NULL,
  `registrasi_id` int DEFAULT NULL,
  `nama` varchar(199) DEFAULT NULL,
  `no_rm` varchar(200) DEFAULT NULL,
  `no_hp` varchar(200) DEFAULT NULL,
  `nik` varchar(200) DEFAULT NULL,
  `no_jkn` varchar(200) DEFAULT NULL,
  `alamat` varchar(199) DEFAULT NULL,
  `kelamin` enum('L','P') DEFAULT NULL,
  `tgllahir` date DEFAULT NULL,
  `politype` char(1) DEFAULT NULL,
  `pemeriksaan` varchar(199) DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pegawais`
--

CREATE TABLE `pegawais` (
  `id` int UNSIGNED NOT NULL,
  `nama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nik` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kuota_poli` int DEFAULT '0',
  `kategori_pegawai` int DEFAULT NULL,
  `kelompok_pegawai` int DEFAULT NULL,
  `poli_id` int DEFAULT NULL,
  `poli_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kode_bpjs` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kode_antrian` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kode_dokter_inhealth` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `general_code` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgllahir` date DEFAULT NULL,
  `tmplahir` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kelamin` enum('L','P') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `agama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sip` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `str` varchar(161) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kompetensi` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_reg` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tupoksi` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sip_awal` date DEFAULT NULL,
  `sip_akhir` date DEFAULT NULL,
  `user_id` int UNSIGNED DEFAULT NULL,
  `id_dokterss` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanda_tangan` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto_profile` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nip` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `golongan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `golongan_tmt` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jabatan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jabatan_tmt` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_tte` tinyint(1) NOT NULL DEFAULT '0',
  `smf` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `created_at` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_at` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pekerjaans`
--

CREATE TABLE `pekerjaans` (
  `id` int UNSIGNED NOT NULL,
  `nama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pembayarans`
--

CREATE TABLE `pembayarans` (
  `id` int UNSIGNED NOT NULL,
  `jenis` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pembayaran` enum('tindakan','obat','semua') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'semua',
  `user_id` int UNSIGNED NOT NULL,
  `journal_id` bigint DEFAULT NULL,
  `total` int NOT NULL,
  `dibayar` int NOT NULL,
  `flag` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `registrasi_id` int UNSIGNED NOT NULL,
  `dokter_id` int UNSIGNED NOT NULL,
  `metode_bayar_id` int DEFAULT NULL,
  `diskon_persen` double(8,2) DEFAULT NULL,
  `diskon_rupiah` int DEFAULT NULL,
  `no_kwitansi` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pasien_id` int UNSIGNED NOT NULL,
  `service_cash` int DEFAULT NULL,
  `titipan` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `appv` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hrs_bayar` int DEFAULT NULL,
  `subsidi` int DEFAULT NULL,
  `iur` int DEFAULT NULL,
  `selisih_positif` int DEFAULT NULL,
  `selisih_negatif` int DEFAULT NULL,
  `tgl_apprv` date DEFAULT NULL,
  `user_apprv` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reminder` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pembulatan` int DEFAULT NULL,
  `id_condition_ss` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pendapatans`
--

CREATE TABLE `pendapatans` (
  `id` int UNSIGNED NOT NULL,
  `registrasi_id` int DEFAULT NULL,
  `folio_id` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total` int NOT NULL,
  `user_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pendapatan_diklats`
--

CREATE TABLE `pendapatan_diklats` (
  `id` int UNSIGNED NOT NULL,
  `nama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tarif_id` int NOT NULL,
  `namatarif` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total` int NOT NULL,
  `keterangan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pendapatan_parkirs`
--

CREATE TABLE `pendapatan_parkirs` (
  `id` int UNSIGNED NOT NULL,
  `jenis` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jml_kendaraan` int NOT NULL,
  `tarif` int NOT NULL,
  `total` int NOT NULL,
  `user_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pendidikans`
--

CREATE TABLE `pendidikans` (
  `id` int UNSIGNED NOT NULL,
  `pendidikan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `penerimaan_produks`
--

CREATE TABLE `penerimaan_produks` (
  `id` int NOT NULL,
  `kode_penerimaan` varchar(20) DEFAULT NULL,
  `tanggal_penerimaan` date DEFAULT NULL,
  `nomor_faktur` varchar(20) DEFAULT NULL,
  `tanggal_faktur` date DEFAULT NULL,
  `sumber_dana` varchar(300) DEFAULT NULL,
  `nama_supplier` varchar(200) DEFAULT NULL,
  `keterangan_penerimaan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `penerimaan_produk_detil`
--

CREATE TABLE `penerimaan_produk_detil` (
  `id` bigint NOT NULL,
  `kode_penerimaan_detil` varchar(100) DEFAULT NULL,
  `kode_penerimaan` varchar(30) DEFAULT NULL,
  `kode_produk` varchar(100) NOT NULL DEFAULT '',
  `nama_produk` varchar(300) DEFAULT NULL,
  `jenis_produk` varchar(300) DEFAULT NULL,
  `jumlah` int NOT NULL DEFAULT '0',
  `satuan` varchar(100) DEFAULT NULL,
  `harga` int NOT NULL DEFAULT '0',
  `no_batch` varchar(100) DEFAULT NULL,
  `ed` date DEFAULT '0000-00-00',
  `posisi` varchar(100) DEFAULT NULL,
  `status` int DEFAULT '1',
  `keterangan` varchar(500) DEFAULT NULL,
  `distribusi` int NOT NULL DEFAULT '0',
  `return_penerimaan` int NOT NULL DEFAULT '0',
  `return_distribusi` int NOT NULL DEFAULT '0',
  `return_ed` int NOT NULL DEFAULT '0',
  `return_rusak` int NOT NULL DEFAULT '0',
  `stok` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pengembalian_obats`
--

CREATE TABLE `pengembalian_obats` (
  `id` int UNSIGNED NOT NULL,
  `logistikpinjamobat_id` int NOT NULL,
  `rspinjam_id` int NOT NULL,
  `nomorberitaacara` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tgl_pengembalian` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengirim_rujukan`
--

CREATE TABLE `pengirim_rujukan` (
  `id` int NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `penjualanbebas`
--

CREATE TABLE `penjualanbebas` (
  `id` int UNSIGNED NOT NULL,
  `registrasi_id` int NOT NULL,
  `nama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dokter_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dokter` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `penjualandetails`
--

CREATE TABLE `penjualandetails` (
  `id` int UNSIGNED NOT NULL,
  `no_resep` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `penjualan_id` int UNSIGNED NOT NULL,
  `masterobat_id` int UNSIGNED NOT NULL,
  `is_kronis` enum('N','Y') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'N',
  `jumlah` int NOT NULL,
  `retur_inacbg` int DEFAULT NULL,
  `jml_kronis` int DEFAULT NULL,
  `retur_kronis` int DEFAULT NULL,
  `hargajual` int NOT NULL,
  `catatan` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `hargajual_kronis` int DEFAULT NULL,
  `diskon` int DEFAULT NULL,
  `etiket` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cetak` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'Y',
  `tipe_rawat` enum('TA','TI','TG') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `informasi1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cara_minum_id` int DEFAULT NULL,
  `cara_minum` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `takaran` varchar(190) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `informasi2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `obat_racikan` enum('N','Y') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'N',
  `expired` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bud` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uang_racik` int DEFAULT NULL,
  `uang_racik_id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cara_bayar_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `logistik_batch_id` int DEFAULT NULL,
  `id_medication_dep` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `penjualans`
--

CREATE TABLE `penjualans` (
  `id` int UNSIGNED NOT NULL,
  `no_resep` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kamar_id` int DEFAULT NULL,
  `pembuat_resep` int DEFAULT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `registrasi_id` int DEFAULT NULL,
  `dokter_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `response_time` int DEFAULT NULL COMMENT 'Lama Pemrosesan obat dalam menit',
  `catatan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tte` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `tte_dokter` int DEFAULT NULL,
  `tte_apotik` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `perawatan_icd9s`
--

CREATE TABLE `perawatan_icd9s` (
  `id` int UNSIGNED NOT NULL,
  `icd9` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `registrasi_id` int UNSIGNED NOT NULL,
  `carabayar_id` int UNSIGNED NOT NULL,
  `jenis` char(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kategori` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `diagnosis` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `kasus` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_at` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_procedure_ss` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `perawatan_icd9_idrgs`
--

CREATE TABLE `perawatan_icd9_idrgs` (
  `id` int UNSIGNED NOT NULL,
  `icd9` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `registrasi_id` int UNSIGNED NOT NULL,
  `carabayar_id` int UNSIGNED NOT NULL,
  `jenis` char(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `perawatan_icd10s`
--

CREATE TABLE `perawatan_icd10s` (
  `id` int UNSIGNED NOT NULL,
  `icd10` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `registrasi_id` int UNSIGNED NOT NULL,
  `carabayar_id` int UNSIGNED NOT NULL,
  `jenis` char(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kategori` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `diagnosis` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `kasus` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_condition_ss` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_at` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `perawatan_icd10_idrgs`
--

CREATE TABLE `perawatan_icd10_idrgs` (
  `id` int UNSIGNED NOT NULL,
  `icd10` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `registrasi_id` int UNSIGNED NOT NULL,
  `carabayar_id` int UNSIGNED NOT NULL,
  `jenis` char(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_condition_ss` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `permission_id` int UNSIGNED NOT NULL,
  `role_id` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permission_user`
--

CREATE TABLE `permission_user` (
  `permission_id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `user_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `perusahaans`
--

CREATE TABLE `perusahaans` (
  `id` int UNSIGNED NOT NULL,
  `nama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_prk` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `diskon` int NOT NULL,
  `plafon` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `phone_books`
--

CREATE TABLE `phone_books` (
  `id` int UNSIGNED NOT NULL,
  `nama` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `piutangs`
--

CREATE TABLE `piutangs` (
  `id` int UNSIGNED NOT NULL,
  `kwitansi_pembayaran` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `registrasi_id` int NOT NULL,
  `pasien_id` int DEFAULT NULL,
  `pembayaran_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `nama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total` int NOT NULL,
  `dibayar` int DEFAULT NULL,
  `total_piutang` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tglbayar` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `journal_id` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `polis`
--

CREATE TABLE `polis` (
  `id` int UNSIGNED NOT NULL,
  `nama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `audio` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kelompok` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kelas` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '2',
  `kode_ruangan` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `general_code` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `urutan` int DEFAULT '99',
  `politype` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `flag` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bpjs` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `inhealth` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instalasi_id` int NOT NULL,
  `kamar_id` int NOT NULL,
  `dokter_id` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `perawat_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kuota` int DEFAULT '20',
  `kuota_online` int DEFAULT NULL,
  `terisi` int DEFAULT '0',
  `loket` int DEFAULT NULL,
  `kode_loket` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `buka` time DEFAULT NULL,
  `tutup` time DEFAULT NULL,
  `praktik` enum('Y','T') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sunday` int DEFAULT '20',
  `monday` int DEFAULT '20',
  `tuesday` int DEFAULT '20',
  `wednesday` int DEFAULT '20',
  `thursday` int DEFAULT '20',
  `friday` int DEFAULT '20',
  `saturday` int DEFAULT '20',
  `jkn_sunday` int DEFAULT '20',
  `jkn_monday` int DEFAULT '20',
  `jkn_tuesday` int DEFAULT '20',
  `jkn_wednesday` int DEFAULT '20',
  `jkn_thursday` int DEFAULT '20',
  `jkn_friday` int DEFAULT '20',
  `jkn_saturday` int DEFAULT '20',
  `layar_lcd` int DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_location_ss` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `satusehat_room` enum('Y','N') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `politypes`
--

CREATE TABLE `politypes` (
  `id` int UNSIGNED NOT NULL,
  `kode` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_ranap_ss` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posisiberkas`
--

CREATE TABLE `posisiberkas` (
  `id` int UNSIGNED NOT NULL,
  `keterangan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `potensi_prb1`
--

CREATE TABLE `potensi_prb1` (
  `id` int NOT NULL,
  `no_kartu` varchar(100) DEFAULT NULL,
  `nama_pasien` varchar(500) DEFAULT NULL,
  `nama_dpjp` varchar(500) DEFAULT NULL,
  `poliklinik` varchar(10) DEFAULT NULL,
  `diagprimer` text,
  `diagsekunder` text,
  `poli_id` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ppis`
--

CREATE TABLE `ppis` (
  `id` int UNSIGNED NOT NULL,
  `registrasi_id` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pasien_id` int NOT NULL,
  `tindakan_id` int NOT NULL,
  `jumlah_tindakan` int NOT NULL,
  `unit` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `radiologi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `laboratorium` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `komplikasi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `kultur` json DEFAULT NULL,
  `specimen` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `tindakan_operasi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_umur` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `is_gizi` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `is_obesitas` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `is_diabetes` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `is_hiv` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `is_hbv` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `is_hcv` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `user_id` int NOT NULL,
  `type` enum('hais','ppi') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ppi',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ppi_antibiotiks`
--

CREATE TABLE `ppi_antibiotiks` (
  `id` int NOT NULL,
  `ppi_id` int NOT NULL,
  `pasien_id` int NOT NULL,
  `antibiotik` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `tgl_pakai` date DEFAULT NULL,
  `tgl_berhenti` date DEFAULT NULL,
  `total_hari` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `ppi_faktor_pemakaians`
--

CREATE TABLE `ppi_faktor_pemakaians` (
  `id` int NOT NULL,
  `ppi_id` int NOT NULL,
  `pasien_id` int NOT NULL,
  `master_ppi_id` int NOT NULL,
  `tgl_terpasang` date DEFAULT NULL,
  `tgl_lepas` date DEFAULT NULL,
  `total_hari` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `predictive`
--

CREATE TABLE `predictive` (
  `id` int UNSIGNED NOT NULL,
  `text` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id` int NOT NULL,
  `kode_produk` varchar(255) DEFAULT NULL,
  `nama_produk` varchar(200) DEFAULT NULL,
  `jenis_produk` varchar(200) DEFAULT NULL,
  `satuan_produk` varchar(50) DEFAULT NULL,
  `napza` enum('napza','bukan') DEFAULT NULL,
  `status` int DEFAULT '1',
  `keterangan_produk` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prognosis`
--

CREATE TABLE `prognosis` (
  `id` int NOT NULL,
  `keterangan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `display` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='sumber: satusehat';

-- --------------------------------------------------------

--
-- Table structure for table `provinces`
--

CREATE TABLE `provinces` (
  `id` char(2) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `provinces2`
--

CREATE TABLE `provinces2` (
  `id` char(2) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `radiologi_ekspertises`
--

CREATE TABLE `radiologi_ekspertises` (
  `id` int UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `registrasi_id` int DEFAULT NULL,
  `pasien_id` int DEFAULT NULL,
  `no_dokument` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ekspertise` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `dokter_id` int DEFAULT NULL,
  `dokter_pengirim` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `klinis` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `poli_id` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '1',
  `folio_id` int DEFAULT NULL,
  `tanggal_eksp` date DEFAULT NULL,
  `tte` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `tglPeriksa` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rawatinaps`
--

CREATE TABLE `rawatinaps` (
  `id` int UNSIGNED NOT NULL,
  `registrasi_id` int NOT NULL,
  `kelompokkelas_id` int DEFAULT NULL,
  `kelas_id` int NOT NULL,
  `kamar_id` int NOT NULL,
  `bed_id` int NOT NULL,
  `dokter_id` int DEFAULT NULL,
  `pagu_perawatan_id` int DEFAULT NULL,
  `tgl_masuk` datetime DEFAULT NULL,
  `tgl_keluar` datetime DEFAULT NULL,
  `carabayar_id` int NOT NULL,
  `is_bayi` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'N',
  `perinatologi_hidup` int DEFAULT NULL,
  `perinatologi_mati` int DEFAULT NULL,
  `pengirim` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `perinatologi_sebab_mati` int DEFAULT NULL,
  `pagu_diagnosa_awal` int DEFAULT NULL,
  `selesai_billing` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_encounter_ss` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `record_satusehat`
--

CREATE TABLE `record_satusehat` (
  `id` int NOT NULL,
  `registrasi_id` varchar(255) DEFAULT NULL,
  `response` longtext,
  `request` text,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `service_name` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `status_reg` varchar(255) DEFAULT NULL,
  `input_from` varchar(200) DEFAULT NULL,
  `extra` json DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `regencies`
--

CREATE TABLE `regencies` (
  `id` char(4) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `province_id` char(2) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `regencies2`
--

CREATE TABLE `regencies2` (
  `id` char(4) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `province_id` char(2) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `registrasis`
--

CREATE TABLE `registrasis` (
  `id` int UNSIGNED NOT NULL,
  `pasien_id` int UNSIGNED NOT NULL,
  `reg_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomorantrian` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomorantrian_jkn` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `antrian_poli_id` int DEFAULT NULL,
  `jenis_pasien` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('baru','lama') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kasus` enum('1','2') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `keterangan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rujukan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pengirim_rujukan` char(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_reg` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_ugd` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `apotik_rawatinap` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipe_rawat` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_loket` int DEFAULT NULL,
  `batal` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_cetak_kartu` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `periksa_gratis` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `masuk_apotik` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `info` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `obat` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dokter_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `poli_id` int DEFAULT NULL,
  `kartu` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `program` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `umur` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icd` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bayar` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `utama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shift` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipe_layanan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sebabsakit_id` int UNSIGNED DEFAULT NULL,
  `tingkat_kegawatan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kelas_id` int UNSIGNED DEFAULT NULL,
  `keluar_inap` date DEFAULT NULL,
  `diagnosa_inap` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_sep` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipe_jkn` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hak_kelas_inap` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgl_rujukan` date DEFAULT NULL,
  `no_rujukan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ppk_rujukan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `diagnosa_awal` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgl_sep` date DEFAULT NULL,
  `poli_bpjs` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verifikasi_tindakan` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jkn_mandiri` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jkn_update` date DEFAULT NULL,
  `id_klinik_waktu_tunggu` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `operasi` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lab` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kondisi_akhir_pasien` char(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `surat_meninggal` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instalasi_id` int UNSIGNED DEFAULT NULL,
  `pulang` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `radiologi` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jkn_bersyarat` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_koding` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgl_pulang` datetime DEFAULT NULL,
  `cara_keluar_inap` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keadaan_keluar_inap` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `perusahaan_id` int UNSIGNED DEFAULT NULL,
  `user_create` int UNSIGNED DEFAULT NULL,
  `antrian_id` int UNSIGNED DEFAULT NULL,
  `rjtl` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kepesertaan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hakkelas` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomorrujukan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tglrujukan` date DEFAULT NULL,
  `kodeasal` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `catatan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kecelakaan` char(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jkn` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_jkn` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lunas` enum('Y','N','P') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `posisiberkas_id` int DEFAULT NULL,
  `antrian_poli` int DEFAULT NULL,
  `tracer` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `posisi_tracer` enum('0','-1','1','2','3') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '"0" = belum diproses, "1" = Berkas Keluar , "-1" = Berkas Dikembalikan, ''2'' = berkas kembali dari poli',
  `tracer_kembali_tanggal` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verif_rj` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'N',
  `lab_start` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lab_finish` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verif_kasa` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'N',
  `cetak_sep` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `ubah_dpjp` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis_kunjungan` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cetak_barcode` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `puskesmas_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dokter_perujuk_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan_klinis` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan_sip` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tte_hasillab_lis` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tgl_order` date DEFAULT NULL,
  `user_deleted` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `tgl_verif` timestamp NULL DEFAULT NULL,
  `input_from` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tarif_idrg` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `journal_id` bigint DEFAULT NULL,
  `id_encounter_ss` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_pulang_ss` json DEFAULT NULL,
  `tte_resume_pasien` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `tte_bundling_resep` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `tte_resume_pasien_status` enum('0','1') COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `catatan_order_lab` longtext COLLATE utf8mb4_unicode_ci,
  `is_order_lab` tinyint(1) DEFAULT NULL,
  `waktu_order_lab` timestamp NULL DEFAULT NULL,
  `dokter_order_lab` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `general_consent` json DEFAULT NULL,
  `tte_general_consent` longtext COLLATE utf8mb4_unicode_ci,
  `is_visum` varchar(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `registrasis_dummy`
--

CREATE TABLE `registrasis_dummy` (
  `id` int NOT NULL,
  `registrasi_id` int DEFAULT NULL,
  `jenis_registrasi` enum('pasien_baru','antrian') DEFAULT NULL,
  `nomorkartu` varchar(50) DEFAULT NULL,
  `nomorantrian` varchar(190) DEFAULT NULL,
  `kodebooking` varchar(255) DEFAULT NULL,
  `angkaantrian` int DEFAULT NULL,
  `nik` varchar(50) DEFAULT NULL,
  `no_rm` char(8) DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `tglperiksa` varchar(250) DEFAULT NULL,
  `kode_poli` varchar(100) DEFAULT NULL,
  `no_rujukan` varchar(20) DEFAULT NULL,
  `jenisreferensi` int DEFAULT NULL,
  `jenisrequest` int DEFAULT NULL,
  `polieksekutif` int DEFAULT NULL,
  `jenisdaftar` enum('reguler','fkrtl','android') NOT NULL DEFAULT 'reguler',
  `estimasidilayani` datetime DEFAULT NULL,
  `kelamin` enum('L','P') DEFAULT NULL,
  `tmplahir` text,
  `tgllahir` varchar(200) DEFAULT NULL,
  `kode_cara_bayar` int DEFAULT NULL,
  `kode_dokter` varchar(50) DEFAULT NULL,
  `dokter_id` int DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `alamat` varchar(150) DEFAULT NULL,
  `status` enum('pending','terdaftar','dilayani','checkin','dibatalkan') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL DEFAULT 'pending',
  `jampraktek` varchar(255) DEFAULT NULL,
  `jeniskunjungan` varchar(25) DEFAULT '1',
  `cekin` enum('N','Y') DEFAULT 'N',
  `keterangan` text,
  `waktu` varchar(200) DEFAULT NULL,
  `nomorkk` varchar(100) DEFAULT NULL,
  `jeniskelamin` enum('L','P') DEFAULT NULL,
  `kodeprop` int DEFAULT NULL,
  `namaprop` varchar(100) DEFAULT NULL,
  `kodedati2` varchar(100) DEFAULT NULL,
  `namadati2` varchar(100) DEFAULT NULL,
  `kodekec` varchar(100) DEFAULT NULL,
  `namakec` varchar(255) DEFAULT NULL,
  `kodekel` varchar(255) DEFAULT NULL,
  `namakel` varchar(100) DEFAULT NULL,
  `rw` varchar(100) DEFAULT NULL,
  `rt` varchar(100) DEFAULT NULL,
  `api_token` varchar(255) DEFAULT NULL,
  `request` text,
  `taskid` varchar(10) DEFAULT NULL,
  `flag` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `resep_note`
--

CREATE TABLE `resep_note` (
  `id` int NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_racikan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `signa_peracikan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `source` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `registrasi_id` int DEFAULT NULL,
  `penjualan_id` int DEFAULT NULL,
  `pasien_id` int DEFAULT NULL,
  `comment` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_resep` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `poli_id` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_umum` enum('N','Y') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'N',
  `proses` enum('belum_diproses','diproses','terkirim','dibatalkan','tervalidasi','selesai') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'belum_diproses',
  `notif_play` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '"0" artinya notif belum play',
  `jenis_resep` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'tunggal',
  `is_validate` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `is_done_input` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `kelompok` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomor` int DEFAULT NULL,
  `panggil` tinyint(1) NOT NULL DEFAULT '0' COMMENT '"1" artinya sedang dipanggil',
  `panggil_play` tinyint(1) NOT NULL DEFAULT '0' COMMENT '"1" artinya sudah di play',
  `tte` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `input_from` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `antrian_dipanggil` datetime DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `resep_note_detail`
--

CREATE TABLE `resep_note_detail` (
  `id` int NOT NULL,
  `resep_note_id` int DEFAULT NULL,
  `logistik_batch_id` int DEFAULT NULL,
  `obat_id` int DEFAULT NULL,
  `cara_bayar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `obat_racikan` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `tiket` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cara_minum` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `takaran` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `informasi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qty` int DEFAULT NULL,
  `kronis` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_empty` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `id_medication_request` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `updated_at` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `resep_note_duplicate`
--

CREATE TABLE `resep_note_duplicate` (
  `id` int NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_racikan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `source` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `registrasi_id` int DEFAULT NULL,
  `pasien_id` int DEFAULT NULL,
  `comment` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_resep` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `poli_id` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_umum` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'N',
  `created_by` int DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `resume_pasiens`
--

CREATE TABLE `resume_pasiens` (
  `id` int UNSIGNED NOT NULL,
  `registrasi_id` int NOT NULL,
  `tekanandarah` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bb` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `diagnosa` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tindakan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `retur_obat_rusaks`
--

CREATE TABLE `retur_obat_rusaks` (
  `id` int UNSIGNED NOT NULL,
  `masterobat_id` int NOT NULL,
  `logistik_batch_id` int NOT NULL,
  `supplier_id` int DEFAULT NULL,
  `gudang_id` int NOT NULL,
  `jumlahretur` int NOT NULL,
  `hargabeli` int DEFAULT NULL,
  `keterangan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('diterima','ditolak','belum') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'belum',
  `tgl_diterima` date DEFAULT NULL,
  `nama_penerima` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_gudang_pusat` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rincian_hasillabs`
--

CREATE TABLE `rincian_hasillabs` (
  `id` int UNSIGNED NOT NULL,
  `labsection_id` int UNSIGNED DEFAULT NULL,
  `hasillab_id` int UNSIGNED DEFAULT NULL,
  `labkategori_id` int UNSIGNED DEFAULT NULL,
  `laboratoria_id` int UNSIGNED DEFAULT NULL,
  `hasiltext` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `hasil` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `user_id` int UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rincian_pengembalian_obats`
--

CREATE TABLE `rincian_pengembalian_obats` (
  `id` int UNSIGNED NOT NULL,
  `masterobat_id` int NOT NULL,
  `logistik_batch_id` int NOT NULL,
  `pengembalian_id` int NOT NULL,
  `jumlah` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rincian_pinjam_obats`
--

CREATE TABLE `rincian_pinjam_obats` (
  `id` int UNSIGNED NOT NULL,
  `masterobat_id` int NOT NULL,
  `logistik_batch_id` int NOT NULL,
  `jumlah` int NOT NULL,
  `logistik_pinjam_obat_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ris_logs`
--

CREATE TABLE `ris_logs` (
  `id` int NOT NULL,
  `response` text,
  `response_taskid` text,
  `request` text,
  `no_rm` int DEFAULT NULL,
  `assid` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `url` varchar(200) DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `penginput` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ris_tindakans`
--

CREATE TABLE `ris_tindakans` (
  `id` int NOT NULL,
  `mt_id` int DEFAULT NULL,
  `mt_kode` varchar(200) DEFAULT NULL,
  `mt_desc` text,
  `mt_kode_pk` varchar(200) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rl_keluarga_berencana`
--

CREATE TABLE `rl_keluarga_berencana` (
  `id` int NOT NULL,
  `conf_rl312_id` int DEFAULT NULL,
  `reg_id` int DEFAULT NULL,
  `konseling` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cara_masuk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kondisi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kunjungan_ulang` enum('Y','T') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `role_id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `user_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rstujuanpinjams`
--

CREATE TABLE `rstujuanpinjams` (
  `id` int UNSIGNED NOT NULL,
  `nama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rs_mr`
--

CREATE TABLE `rs_mr` (
  `mr_id` int UNSIGNED NOT NULL,
  `mr_no` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `kode_pasien` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `no_pegawai` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `mr_name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `mr_jk` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `mr_gol_darah` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `rhesus` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `mr_tempat_lahir` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `mr_tgl_lahir` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `agama` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `warga_negara` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `mr_status` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `pendidikan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `nama_istri` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `anak_ke` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `jml_sdr` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `mr_alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `kelurahan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `kecamatan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `kabupaten` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `propinsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `mr_kode_pos` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `telpon` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `pekerjaan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `jabatan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `bagian` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status_pasien` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `id_penanggung` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `no_asuransi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `suku` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `golongan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `tgl_wafat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `nama_penanggung` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `hub_penanggung` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `alamat_penanggung` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `telp_penanggung` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `masa_berlaku` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `lokasi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status_keluarga` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `no_kbpp` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `pos_penanggung` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `kerja_penanggung` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `nopeg_penanggung` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `gol_penanggung` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `idem` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `old_mr` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `mr_khusus` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `mr_poli` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `tgl_daftar` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `rt` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `rw` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `eselon_2` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `eselon_3` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cr_2` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cr_3` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `kode_perusahaan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `rec_editor` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `rec_edited` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `rec_creator` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `rec_created` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `mr_status_old` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status_server` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `nama_penjamin` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `mr_kunjungan_terakhir` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_deleted` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `mr_no_old` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `kontr_id` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `golongan_eselon_id` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `mr_gelar_depan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `mr_gelar_belakang` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `telpon2` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `nama_suami_istri` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `nama_ayah` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `nama_ibu` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_reg_id` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_tracer_id` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `total_jaminan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `no_penjamin` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `nik` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `no_rumah` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `alamat_domisili` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `no_rumah_domisili` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `rt_domisili` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `rw_domisili` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `kel_domisili` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `kec_domisili` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `kab_domisili` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `prop_domisili` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `no_hp` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `bahasa` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `tempat_bekerja_id` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `umur_penanggung` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `jk_penanggung` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `suku_penanggung` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `agama_penanggung` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `pendidikan_penanggung` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `umur_ibu` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `agama_ibu` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `pendidikan_ibu` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `pekerjaan_ibu` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `hpht_ibu` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `umur_kehamilan_ibu` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `umur_ayah` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `agama_ayah` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `pendidikan_ayah` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `pekerjaan_ayah` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `jenis_bpjs` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `kelompok_bpjs` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `nik_penanggung` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rujukans`
--

CREATE TABLE `rujukans` (
  `id` int UNSIGNED NOT NULL,
  `nama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rujukan_obat`
--

CREATE TABLE `rujukan_obat` (
  `id` int NOT NULL,
  `registrasi_id` int DEFAULT NULL,
  `pasien_id` int DEFAULT NULL,
  `diagnosa` varchar(255) DEFAULT NULL,
  `nama_obat` varchar(255) DEFAULT NULL,
  `keterangan` longtext,
  `rumah_sakit` varchar(255) DEFAULT NULL,
  `riwayat` json DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `saderek_master_screening`
--

CREATE TABLE `saderek_master_screening` (
  `id` int NOT NULL,
  `urut` int DEFAULT NULL,
  `pertanyaan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `skor` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `with_detail` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `saderek_operasi`
--

CREATE TABLE `saderek_operasi` (
  `id` int NOT NULL,
  `kode_booking` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_jkn` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kode_poli` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_poli` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `terlaksana` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N' COMMENT 'Y: sudah, N: belum',
  `no_peserta` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis_tindakan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `rencana_operasi` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `saderek_poli`
--

CREATE TABLE `saderek_poli` (
  `id` int NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kode_bpjs` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kuota` int DEFAULT NULL,
  `kuota_online` int DEFAULT NULL,
  `status` int NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `saderek_registrasis_dummy`
--

CREATE TABLE `saderek_registrasis_dummy` (
  `id` int NOT NULL,
  `uuid` varchar(255) DEFAULT NULL,
  `nomorkartu` varchar(50) DEFAULT NULL,
  `nomorantrian` varchar(190) DEFAULT NULL,
  `nik` varchar(50) NOT NULL,
  `no_rm` char(8) DEFAULT NULL,
  `no_hp` varchar(20) NOT NULL,
  `tglperiksa` date NOT NULL,
  `kode_poli` varchar(100) DEFAULT NULL,
  `no_rujukan` varchar(20) DEFAULT NULL,
  `jenisreferensi` int DEFAULT NULL,
  `jenisrequest` int DEFAULT NULL,
  `polieksekutif` int DEFAULT NULL,
  `jenisdaftar` enum('reguler','fkrtl','android') NOT NULL DEFAULT 'reguler',
  `estimasidilayani` datetime DEFAULT NULL,
  `kelamin` enum('L','P') DEFAULT NULL,
  `tgllahir` date DEFAULT NULL,
  `kode_cara_bayar` int DEFAULT NULL,
  `kode_dokter` int DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `alamat` varchar(150) DEFAULT NULL,
  `terinfeksi_covid` int NOT NULL DEFAULT '0',
  `status` enum('pending','terdaftar','dilayani') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `saderek_screening_pasien`
--

CREATE TABLE `saderek_screening_pasien` (
  `id` int NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reg_id` int DEFAULT NULL,
  `nik` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `umur` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `jenis` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `suhu_tubuh` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `check_in` int NOT NULL DEFAULT '0',
  `infeksi_covid` int NOT NULL DEFAULT '0',
  `hasil` int DEFAULT NULL,
  `status` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `saderek_screening_pasien_detail`
--

CREATE TABLE `saderek_screening_pasien_detail` (
  `id` int NOT NULL,
  `screening_pasien_id` int DEFAULT NULL,
  `screening_id` int DEFAULT NULL,
  `jawab` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `detail` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `saderek_user_dummy`
--

CREATE TABLE `saderek_user_dummy` (
  `id` int NOT NULL,
  `nik` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgllahir` date DEFAULT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `hp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kelamin` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `satuanbelis`
--

CREATE TABLE `satuanbelis` (
  `id` int UNSIGNED NOT NULL,
  `nama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `satuanjuals`
--

CREATE TABLE `satuanjuals` (
  `id` int UNSIGNED NOT NULL,
  `nama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kodesatuanjual` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'BS019',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `satu_sehat`
--

CREATE TABLE `satu_sehat` (
  `id` int NOT NULL,
  `satu_sehat` varchar(255) DEFAULT NULL,
  `aktif` enum('0','1') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sebabsakits`
--

CREATE TABLE `sebabsakits` (
  `id` int UNSIGNED NOT NULL,
  `nama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sep_logs`
--

CREATE TABLE `sep_logs` (
  `id` int NOT NULL,
  `response` text,
  `registrasi_id` int DEFAULT NULL,
  `request` text,
  `status` int DEFAULT NULL,
  `nomorantrian` varchar(200) DEFAULT NULL,
  `url` varchar(200) DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `penginput` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sep_pengajuans`
--

CREATE TABLE `sep_pengajuans` (
  `id` int UNSIGNED NOT NULL,
  `no_kartu` varchar(13) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_sep` date NOT NULL,
  `jenis_pelayanan` enum('1','2') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `jenis_pengajuan` enum('1','2') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sep_poli_lanjutans`
--

CREATE TABLE `sep_poli_lanjutans` (
  `id` int UNSIGNED NOT NULL,
  `kode_poli` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_poli` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sep_rujukan_keluars`
--

CREATE TABLE `sep_rujukan_keluars` (
  `id` int UNSIGNED NOT NULL,
  `no_sep` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_rujukan` date NOT NULL,
  `tglRencanaKunjungan` date DEFAULT NULL,
  `ppk_dirujuk` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_pelayanan` enum('1','2') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `catatan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `diagnosa` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipe_rujukan` enum('0','1','2') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `poli` char(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `noRujukan` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jnsPeserta` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kelamin` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `noKartu` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `noMR` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tglLahir` date NOT NULL,
  `poliTujuan_code` char(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `poliTujuan_nama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tglRujukan` date DEFAULT NULL,
  `tujuanRujukan_code` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tujuanRujukan_nama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `service_notifs`
--

CREATE TABLE `service_notifs` (
  `id` int NOT NULL,
  `registrasi_id` int NOT NULL,
  `service` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `is_muted` enum('Y','N') COLLATE utf8mb4_general_ci DEFAULT 'N',
  `is_done` enum('Y','N') COLLATE utf8mb4_general_ci DEFAULT 'N',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sipeka`
--

CREATE TABLE `sipeka` (
  `id` int NOT NULL,
  `nik` varchar(255) DEFAULT NULL,
  `no_hp` varchar(255) DEFAULT NULL,
  `perihal` varchar(255) DEFAULT NULL,
  `judul_pesan` varchar(255) DEFAULT NULL,
  `pesan` varchar(255) DEFAULT NULL,
  `tanggal` varchar(255) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `slideshows`
--

CREATE TABLE `slideshows` (
  `id` int UNSIGNED NOT NULL,
  `image` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `publish` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Y',
  `user_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `snomed-ct`
--

CREATE TABLE `snomed-ct` (
  `id` int NOT NULL,
  `concept_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `version` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `fsn_term` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `fsn_lang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pt_term` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pt_lang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `moduleId` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='sumber: satusehat';

-- --------------------------------------------------------

--
-- Table structure for table `snomed-ct-children`
--

CREATE TABLE `snomed-ct-children` (
  `id` int NOT NULL,
  `concept_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `version` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `fsn_term` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `fsn_lang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pt_term` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pt_lang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `moduleId` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `definitionStatus` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `snomed_ct_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='sumber: satusehat';

-- --------------------------------------------------------

--
-- Table structure for table `splits`
--

CREATE TABLE `splits` (
  `id` int UNSIGNED NOT NULL,
  `tahuntarif_id` int UNSIGNED NOT NULL,
  `kategoriheader_id` int UNSIGNED NOT NULL,
  `tarif_id` int UNSIGNED NOT NULL,
  `nama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nominal` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `statuses`
--

CREATE TABLE `statuses` (
  `id` int UNSIGNED NOT NULL,
  `status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `supliyers`
--

CREATE TABLE `supliyers` (
  `id` int UNSIGNED NOT NULL,
  `nama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kode` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tlp` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pimpinan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aktif` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Y',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `surat_inaps`
--

CREATE TABLE `surat_inaps` (
  `id` int UNSIGNED NOT NULL,
  `registrasi_id` int NOT NULL,
  `no_spri` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgl_rencana_kontrol` date DEFAULT NULL,
  `diagnosa` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `dokter_rawat` int NOT NULL,
  `dokter_pengirim` int NOT NULL,
  `poli_id` int DEFAULT NULL,
  `jenis_kamar` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `carabayar` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `surat_izin_pulang`
--

CREATE TABLE `surat_izin_pulang` (
  `id` int NOT NULL,
  `registrasi_id` int NOT NULL,
  `status` varchar(100) DEFAULT NULL,
  `pembayaran` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tagihans`
--

CREATE TABLE `tagihans` (
  `id` int UNSIGNED NOT NULL,
  `registrasi_id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `dokter_id` int UNSIGNED NOT NULL,
  `diskon` int NOT NULL,
  `pasien_id` int UNSIGNED NOT NULL,
  `harus_dibayar` int NOT NULL,
  `total` int DEFAULT '0',
  `subsidi` int NOT NULL,
  `dijamin` int NOT NULL,
  `selisih_positif` int NOT NULL,
  `selisih_negatif` int NOT NULL,
  `approval_tanggal` date NOT NULL,
  `user_approval` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pembulatan` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tahuntarifs`
--

CREATE TABLE `tahuntarifs` (
  `id` int UNSIGNED NOT NULL,
  `tahun` char(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `takaranobat_etikets`
--

CREATE TABLE `takaranobat_etikets` (
  `id` int UNSIGNED NOT NULL,
  `nama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tanda_tangan_dokumen`
--

CREATE TABLE `tanda_tangan_dokumen` (
  `id` int NOT NULL,
  `jenis_dokumen` varchar(255) DEFAULT NULL,
  `registrasi_id` int DEFAULT NULL,
  `nama_penanggung_jawab` varchar(255) DEFAULT NULL,
  `tanda_tangan` longtext,
  `emr_inap_perencanaan_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tarifs`
--

CREATE TABLE `tarifs` (
  `id` int UNSIGNED NOT NULL,
  `id_tindakan` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis` char(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_akreditasi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kelas_id` int DEFAULT NULL,
  `lica_id` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kodeloinc` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ris_id` int DEFAULT NULL,
  `modality_id` int DEFAULT NULL,
  `visite` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bedah` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `anestesi` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_show_dokter` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kategoriheader_id` int DEFAULT NULL,
  `kategoritarif_id` int UNSIGNED DEFAULT NULL,
  `keterangan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tahuntarif_id` int UNSIGNED NOT NULL,
  `kelompoktarif_id` int UNSIGNED NOT NULL,
  `kelompok` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jasa_rs` int NOT NULL,
  `jasa_pelayanan` int NOT NULL,
  `total` int NOT NULL,
  `cyto` int DEFAULT NULL,
  `carabayar` int DEFAULT NULL,
  `mastermapping_id` int DEFAULT NULL,
  `mapping_biaya_id` int DEFAULT NULL,
  `mapping_pemeriksaan` enum('KS','PM','TN','') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `masteridrg_id` int DEFAULT NULL,
  `idrg_biaya_id` int DEFAULT NULL,
  `kategori_tagihan` int DEFAULT NULL COMMENT 'untuk tagihan IRJ, ambil dari kategoritarifs',
  `conf_rl33_id` int DEFAULT NULL,
  `conf_rl34_id` int DEFAULT NULL,
  `conf_rl36_id` int DEFAULT NULL,
  `conf_rl37_id` int DEFAULT NULL,
  `conf_rl38_id` int DEFAULT NULL,
  `conf_rl39_id` int DEFAULT NULL,
  `conf_rl310_id` int DEFAULT NULL,
  `conf_rl311_id` int DEFAULT NULL,
  `conf_rl312_id` int DEFAULT NULL,
  `rl33_id` int DEFAULT NULL,
  `rl36_id` int DEFAULT NULL,
  `inhealth_jenpel` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `urutan_lab` int DEFAULT NULL,
  `is_aktif` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'Y',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `akutansi_akun_coa_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tarif_new_backup`
--

CREATE TABLE `tarif_new_backup` (
  `id` int UNSIGNED NOT NULL,
  `id_tindakan` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis` char(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_akreditasi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kelas_id` int DEFAULT NULL,
  `lica_id` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ris_id` int DEFAULT NULL,
  `visite` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bedah` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `anestesi` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_show_dokter` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kategoriheader_id` int DEFAULT NULL,
  `kategoritarif_id` int UNSIGNED DEFAULT NULL,
  `keterangan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tahuntarif_id` int UNSIGNED NOT NULL,
  `kelompok` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jasa_rs` int NOT NULL,
  `jasa_pelayanan` int NOT NULL,
  `total` int NOT NULL,
  `cyto` int DEFAULT NULL,
  `carabayar` int DEFAULT NULL,
  `mastermapping_id` int DEFAULT NULL,
  `mapping_biaya_id` int DEFAULT NULL,
  `mapping_pemeriksaan` enum('KS','PM','TN','') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `conf_rl33_id` int DEFAULT NULL,
  `conf_rl34_id` int DEFAULT NULL,
  `conf_rl36_id` int DEFAULT NULL,
  `conf_rl37_id` int DEFAULT NULL,
  `conf_rl38_id` int DEFAULT NULL,
  `conf_rl39_id` int DEFAULT NULL,
  `conf_rl310_id` int DEFAULT NULL,
  `conf_rl311_id` int DEFAULT NULL,
  `conf_rl312_id` int DEFAULT NULL,
  `rl33_id` int DEFAULT NULL,
  `rl36_id` int DEFAULT NULL,
  `inhealth_jenpel` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_aktif` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'Y',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `akutansi_akun_coa_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tarif_old`
--

CREATE TABLE `tarif_old` (
  `id` int UNSIGNED NOT NULL,
  `id_tindakan` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis` char(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_akreditasi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kelas_id` int DEFAULT NULL,
  `lica_id` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ris_id` int DEFAULT NULL,
  `visite` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bedah` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `anestesi` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_show_dokter` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kategoriheader_id` int DEFAULT NULL,
  `kategoritarif_id` int UNSIGNED DEFAULT NULL,
  `keterangan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tahuntarif_id` int UNSIGNED NOT NULL,
  `kelompok` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jasa_rs` int NOT NULL,
  `jasa_pelayanan` int NOT NULL,
  `total` int NOT NULL,
  `cyto` int DEFAULT NULL,
  `carabayar` int DEFAULT NULL,
  `mastermapping_id` int DEFAULT NULL,
  `mapping_biaya_id` int DEFAULT NULL,
  `mapping_pemeriksaan` enum('KS','PM','TN','') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `masteridrg_id` int DEFAULT NULL,
  `idrg_biaya_id` int DEFAULT NULL,
  `conf_rl33_id` int DEFAULT NULL,
  `conf_rl34_id` int DEFAULT NULL,
  `conf_rl36_id` int DEFAULT NULL,
  `conf_rl37_id` int DEFAULT NULL,
  `conf_rl38_id` int DEFAULT NULL,
  `conf_rl39_id` int DEFAULT NULL,
  `conf_rl310_id` int DEFAULT NULL,
  `conf_rl311_id` int DEFAULT NULL,
  `conf_rl312_id` int DEFAULT NULL,
  `rl33_id` int DEFAULT NULL,
  `rl36_id` int DEFAULT NULL,
  `inhealth_jenpel` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `akutansi_akun_coa_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `taskid_logs`
--

CREATE TABLE `taskid_logs` (
  `id` int NOT NULL,
  `response` text,
  `taskid` text,
  `request` text,
  `status` int DEFAULT NULL,
  `nomorantrian` varchar(200) DEFAULT NULL,
  `url` varchar(200) DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `penginput` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tipelayanans`
--

CREATE TABLE `tipelayanans` (
  `id` int UNSIGNED NOT NULL,
  `tipelayanan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_keluars`
--

CREATE TABLE `transaksi_keluars` (
  `id` int UNSIGNED NOT NULL,
  `nama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_bkk` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `klasifikasi_pengeluaran_id` int DEFAULT NULL,
  `jenis_pengeluaran_id` int DEFAULT NULL,
  `total` int DEFAULT NULL,
  `harga_satuan` int DEFAULT NULL,
  `jumlah` int DEFAULT NULL,
  `satuanbeli_id` int DEFAULT NULL,
  `bukti_transaksi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `tanggal` date DEFAULT NULL,
  `keterangan` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `transportasi`
--

CREATE TABLE `transportasi` (
  `id` int NOT NULL,
  `keterangan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `display` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `system` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='sumber: satusehat';

-- --------------------------------------------------------

--
-- Table structure for table `uang_raciks`
--

CREATE TABLE `uang_raciks` (
  `id` int UNSIGNED NOT NULL,
  `nama` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nominal` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `coder_nik` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kelompokkelas_id` int DEFAULT NULL,
  `gudang_id` int DEFAULT NULL,
  `poli_id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_edit` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_sipeka`
--

CREATE TABLE `user_sipeka` (
  `id` int NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `no_hp` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tanggal_kejadian` date DEFAULT NULL,
  `lokasi_kejadian` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `bagian_permasalahan` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `jenis_permasalahan_petugas` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `bidang_petugas_karyawan` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nama_petugas_karyawan` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `masalah_fasilitas` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `jenis_masalah_fasilitas` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `jenis_permasalahan_administrasi` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `komplain` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `balasan_bidang` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `disposisi` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `bidang` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `user_bidang_id` int DEFAULT NULL,
  `dokumen` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ;

-- --------------------------------------------------------

--
-- Table structure for table `user_sipeka_old`
--

CREATE TABLE `user_sipeka_old` (
  `id` int NOT NULL,
  `nik` varchar(255) DEFAULT NULL,
  `tempat_tinggal` varchar(255) DEFAULT NULL,
  `jenis_kelamin` varchar(255) DEFAULT NULL,
  `pekerjaan` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `tanggal_lahir` varchar(255) DEFAULT NULL,
  `no_hp` varchar(255) DEFAULT NULL,
  `perihal` varchar(255) DEFAULT NULL,
  `judul_pesan` varchar(255) DEFAULT NULL,
  `pesan` varchar(255) DEFAULT NULL,
  `balasan_admin` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `balasan_bidang` varchar(255) DEFAULT NULL,
  `disabilitas` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `disposisi` varchar(255) DEFAULT NULL,
  `bidang` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `villages`
--

CREATE TABLE `villages` (
  `id` char(10) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `district_id` char(7) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `villages2`
--

CREATE TABLE `villages2` (
  `id` char(10) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `district_id` char(7) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `waktutunggus`
--

CREATE TABLE `waktutunggus` (
  `id` int UNSIGNED NOT NULL,
  `registrasi_id` int UNSIGNED NOT NULL,
  `antrian_id` int UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `agamas`
--
ALTER TABLE `agamas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`,`agama`);

--
-- Indexes for table `akutansi_akun_coas`
--
ALTER TABLE `akutansi_akun_coas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `akutansi_journals`
--
ALTER TABLE `akutansi_journals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `akutansi_journal_details`
--
ALTER TABLE `akutansi_journal_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `akutansi_kas_dan_banks`
--
ALTER TABLE `akutansi_kas_dan_banks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `akutansi_lap_ekuitases`
--
ALTER TABLE `akutansi_lap_ekuitases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `akutansi_lap_sal`
--
ALTER TABLE `akutansi_lap_sal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `akutansi_pengurangan_piutang`
--
ALTER TABLE `akutansi_pengurangan_piutang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `akutansi_penyisihan_piutang`
--
ALTER TABLE `akutansi_penyisihan_piutang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `akutansi_penyusutan_piutang`
--
ALTER TABLE `akutansi_penyusutan_piutang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `allergy`
--
ALTER TABLE `allergy`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`,`code`);

--
-- Indexes for table `android_content`
--
ALTER TABLE `android_content`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `type_id` (`type_id`);

--
-- Indexes for table `android_content_type`
--
ALTER TABLE `android_content_type`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `type_nama` (`type_nama`);

--
-- Indexes for table `android_direksi`
--
ALTER TABLE `android_direksi`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `android_images`
--
ALTER TABLE `android_images`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `android_jabatan`
--
ALTER TABLE `android_jabatan`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `android_manajemen`
--
ALTER TABLE `android_manajemen`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `android_slider`
--
ALTER TABLE `android_slider`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `slider_path` (`slider_path`);

--
-- Indexes for table `antrian2`
--
ALTER TABLE `antrian2`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `antrian3`
--
ALTER TABLE `antrian3`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `antrian4`
--
ALTER TABLE `antrian4`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `antrian5`
--
ALTER TABLE `antrian5`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `antrian6`
--
ALTER TABLE `antrian6`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `antrians`
--
ALTER TABLE `antrians`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tanggal` (`tanggal`),
  ADD KEY `status` (`status`),
  ADD KEY `kelompok` (`kelompok`),
  ADD KEY `bagian` (`bagian`);

--
-- Indexes for table `antrian_farmasis`
--
ALTER TABLE `antrian_farmasis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `antrian_laboratorium`
--
ALTER TABLE `antrian_laboratorium`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `antrian_logs`
--
ALTER TABLE `antrian_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `antrian_poli`
--
ALTER TABLE `antrian_poli`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `antrian_poli_BC`
--
ALTER TABLE `antrian_poli_BC`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `antrian_radiologis`
--
ALTER TABLE `antrian_radiologis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `antrian_rawatinaps`
--
ALTER TABLE `antrian_rawatinaps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `apotekers`
--
ALTER TABLE `apotekers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `apotekers_bc`
--
ALTER TABLE `apotekers_bc`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `aturanetikets`
--
ALTER TABLE `aturanetikets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`,`aturan`);

--
-- Indexes for table `bdrs`
--
ALTER TABLE `bdrs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bdrs_detail`
--
ALTER TABLE `bdrs_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `beds`
--
ALTER TABLE `beds`
  ADD PRIMARY KEY (`id`),
  ADD KEY `beds_kamar_id_foreign` (`kamar_id`);

--
-- Indexes for table `bed_logs`
--
ALTER TABLE `bed_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `biayaregistrasis`
--
ALTER TABLE `biayaregistrasis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `biayaregistrasis_tarif_id_foreign` (`tarif_id`),
  ADD KEY `biayaregistrasis_tahuntarif_id_foreign` (`tahuntarif_id`),
  ADD KEY `id` (`id`,`tipe`);

--
-- Indexes for table `biaya_farmasi`
--
ALTER TABLE `biaya_farmasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `biaya_farmasi_detail`
--
ALTER TABLE `biaya_farmasi_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `biaya_infus`
--
ALTER TABLE `biaya_infus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `biaya_infus_detail`
--
ALTER TABLE `biaya_infus_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `biaya_mcu`
--
ALTER TABLE `biaya_mcu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `biaya_mcu_detail`
--
ALTER TABLE `biaya_mcu_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `biaya_pemeriksaans`
--
ALTER TABLE `biaya_pemeriksaans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `biayaregistrasis_tarif_id_foreign` (`tarif_id`);

--
-- Indexes for table `bpjs_kabs`
--
ALTER TABLE `bpjs_kabs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`,`prov_kode`,`kode`);

--
-- Indexes for table `bpjs_kecs`
--
ALTER TABLE `bpjs_kecs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`,`prov_kode`,`kab_kode`,`kode`);

--
-- Indexes for table `bpjs_logs`
--
ALTER TABLE `bpjs_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bpjs_master_obat_prb`
--
ALTER TABLE `bpjs_master_obat_prb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bpjs_master_program_prb`
--
ALTER TABLE `bpjs_master_program_prb`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`,`kode`);

--
-- Indexes for table `bpjs_prb`
--
ALTER TABLE `bpjs_prb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bpjs_prb_detail_obat`
--
ALTER TABLE `bpjs_prb_detail_obat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bpjs_prb_response`
--
ALTER TABLE `bpjs_prb_response`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bpjs_provs`
--
ALTER TABLE `bpjs_provs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`,`kode`);

--
-- Indexes for table `bpjs_rencana_kontrol`
--
ALTER TABLE `bpjs_rencana_kontrol`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `carabayars`
--
ALTER TABLE `carabayars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`,`carabayar`,`general_code`);

--
-- Indexes for table `configs`
--
ALTER TABLE `configs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`,`nama`);

--
-- Indexes for table `conf_consid`
--
ALTER TABLE `conf_consid`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`,`consid`);

--
-- Indexes for table `conf_rl31`
--
ALTER TABLE `conf_rl31`
  ADD PRIMARY KEY (`id_conf_rl31`) USING BTREE,
  ADD KEY `id_conf_rl31` (`id_conf_rl31`,`kegiatan`,`nomer`);

--
-- Indexes for table `conf_rl33`
--
ALTER TABLE `conf_rl33`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `id` (`id`,`nama`);

--
-- Indexes for table `conf_rl33_new`
--
ALTER TABLE `conf_rl33_new`
  ADD PRIMARY KEY (`id_conf_rl33`) USING BTREE,
  ADD KEY `id_conf_rl33` (`id_conf_rl33`,`kegiatan`,`nomer`);

--
-- Indexes for table `conf_rl34`
--
ALTER TABLE `conf_rl34`
  ADD PRIMARY KEY (`id_conf_rl34`),
  ADD KEY `id_conf_rl34` (`id_conf_rl34`,`nomer`);

--
-- Indexes for table `conf_rl35`
--
ALTER TABLE `conf_rl35`
  ADD PRIMARY KEY (`id_conf_rl35`),
  ADD KEY `id_conf_rl35` (`id_conf_rl35`,`nama`,`parent_id`);

--
-- Indexes for table `conf_rl36`
--
ALTER TABLE `conf_rl36`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `id` (`id`);

--
-- Indexes for table `conf_rl36_new`
--
ALTER TABLE `conf_rl36_new`
  ADD PRIMARY KEY (`id_conf_rl36`) USING BTREE,
  ADD KEY `id_conf_rl36` (`id_conf_rl36`,`kegiatan`);

--
-- Indexes for table `conf_rl37`
--
ALTER TABLE `conf_rl37`
  ADD PRIMARY KEY (`id_conf_rl37`) USING BTREE,
  ADD KEY `id_conf_rl37` (`id_conf_rl37`,`kegiatan`);

--
-- Indexes for table `conf_rl38`
--
ALTER TABLE `conf_rl38`
  ADD PRIMARY KEY (`id_conf_rl38`) USING BTREE,
  ADD KEY `id_conf_rl38` (`id_conf_rl38`,`kegiatan`,`nomer`);

--
-- Indexes for table `conf_rl39`
--
ALTER TABLE `conf_rl39`
  ADD PRIMARY KEY (`id_conf_rl39`) USING BTREE,
  ADD KEY `id_conf_rl39` (`id_conf_rl39`,`kegiatan`);

--
-- Indexes for table `conf_rl310`
--
ALTER TABLE `conf_rl310`
  ADD PRIMARY KEY (`id_conf_rl310`) USING BTREE,
  ADD KEY `id_conf_rl310` (`id_conf_rl310`,`kegiatan`,`nomer`);

--
-- Indexes for table `conf_rl311`
--
ALTER TABLE `conf_rl311`
  ADD PRIMARY KEY (`id_conf_rl311`) USING BTREE,
  ADD KEY `id_conf_rl311` (`id_conf_rl311`,`kegiatan`);

--
-- Indexes for table `conf_rl312`
--
ALTER TABLE `conf_rl312`
  ADD PRIMARY KEY (`id_conf_rl312`),
  ADD KEY `id_conf_rl312` (`id_conf_rl312`,`kegiatan`,`nomer`);

--
-- Indexes for table `copy_reseps`
--
ALTER TABLE `copy_reseps`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `copy_reseps_no_resep_unique` (`no_resep`);

--
-- Indexes for table `copy_resep_details`
--
ALTER TABLE `copy_resep_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_seps`
--
ALTER TABLE `data_seps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deposits`
--
ALTER TABLE `deposits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `detailradiologis`
--
ALTER TABLE `detailradiologis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `diagnosa_keperawatans`
--
ALTER TABLE `diagnosa_keperawatans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`,`nama`);

--
-- Indexes for table `districts`
--
ALTER TABLE `districts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `districts_id_index` (`regency_id`);

--
-- Indexes for table `districts2`
--
ALTER TABLE `districts2`
  ADD PRIMARY KEY (`id`),
  ADD KEY `districts_id_index` (`regency_id`);

--
-- Indexes for table `dokumen_rekam_medis`
--
ALTER TABLE `dokumen_rekam_medis`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dokumen_rekam_medis_registrasi_id_unique` (`registrasi_id`),
  ADD KEY `pasien_id` (`pasien_id`);

--
-- Indexes for table `echocardiograms`
--
ALTER TABLE `echocardiograms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `edukasis`
--
ALTER TABLE `edukasis`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `id` (`id`,`code`);

--
-- Indexes for table `edukasi_diets`
--
ALTER TABLE `edukasi_diets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ekspertise_duplicate`
--
ALTER TABLE `ekspertise_duplicate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emr`
--
ALTER TABLE `emr`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `emr_id_idx` (`id`),
  ADD KEY `emr_registrasi_id_idx` (`registrasi_id`),
  ADD KEY `emr_pasien_id_idx` (`pasien_id`),
  ADD KEY `emr_dokter_id_idx` (`dokter_id`),
  ADD KEY `emr_poli_id_idx` (`poli_id`),
  ADD KEY `emr_unit_idx` (`unit`),
  ADD KEY `emr_user_id_idx` (`user_id`);

--
-- Indexes for table `emr_ews`
--
ALTER TABLE `emr_ews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pasien_id` (`pasien_id`,`registrasi_id`,`user_id`,`dokter_id`,`id_observation_ss`);

--
-- Indexes for table `emr_farmasi`
--
ALTER TABLE `emr_farmasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `registrasi_id` (`registrasi_id`),
  ADD KEY `pasien_id` (`pasien_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `emr_gizi`
--
ALTER TABLE `emr_gizi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `registrasi_id` (`registrasi_id`,`kamar_id`),
  ADD KEY `pasien_id` (`pasien_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `emr_inap_icds`
--
ALTER TABLE `emr_inap_icds`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pasien_id` (`pasien_id`,`registrasi_id`,`user_id`,`icd10`,`icd9`);

--
-- Indexes for table `emr_inap_kondisi_khususes`
--
ALTER TABLE `emr_inap_kondisi_khususes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pasien_id` (`pasien_id`,`registrasi_id`,`user_id`);

--
-- Indexes for table `emr_inap_medical_records`
--
ALTER TABLE `emr_inap_medical_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pasien_id` (`pasien_id`,`registrasi_id`,`user_id`);

--
-- Indexes for table `emr_inap_pemeriksaans`
--
ALTER TABLE `emr_inap_pemeriksaans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `emr_inap_pemeriksaans_id_idx` (`id`),
  ADD KEY `emr_inap_pemeriksaans_registrasi_id_idx` (`registrasi_id`),
  ADD KEY `emr_inap_pemeriksaans_pasien_id_idx` (`pasien_id`),
  ADD KEY `emr_inap_pemeriksaans_user_id_idx` (`user_id`),
  ADD KEY `emr_inap_pemeriksaans_type_idx` (`type`);

--
-- Indexes for table `emr_inap_penilaians`
--
ALTER TABLE `emr_inap_penilaians`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pasien_id` (`pasien_id`,`registrasi_id`,`user_id`,`cppt_id`);

--
-- Indexes for table `emr_inap_perencanaans`
--
ALTER TABLE `emr_inap_perencanaans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nomor` (`nomor`,`no_referensi`,`poli_id`,`dokter_id`,`pasien_id`,`registrasi_id`,`user_id`,`type`,`dokter_igd_id`,`dokter_dpjp_id`);

--
-- Indexes for table `emr_keadaan_umums`
--
ALTER TABLE `emr_keadaan_umums`
  ADD PRIMARY KEY (`id`),
  ADD KEY `registrasi_id` (`registrasi_id`,`pasien_id`);

--
-- Indexes for table `emr_konsuls`
--
ALTER TABLE `emr_konsuls`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `konsul_dokter_id` (`konsul_dokter_id`,`registrasi_id`,`pasien_id`,`poli_id`,`poli_asal_id`,`unit`,`user_id`,`type`);

--
-- Indexes for table `emr_master_keadaan_umums`
--
ALTER TABLE `emr_master_keadaan_umums`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`,`unit`);

--
-- Indexes for table `emr_mrs`
--
ALTER TABLE `emr_mrs`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `registrasi_id` (`registrasi_id`,`dokter_id`,`pasien_id`,`unit`,`type`,`user_id`);

--
-- Indexes for table `emr_pengkajian_harians`
--
ALTER TABLE `emr_pengkajian_harians`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `registrasi_id` (`registrasi_id`,`pasien_id`,`dokter_id`,`poli_id`);

--
-- Indexes for table `emr_resume`
--
ALTER TABLE `emr_resume`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pasien_id` (`pasien_id`,`registrasi_id`,`user_id`);

--
-- Indexes for table `emr_riwayats`
--
ALTER TABLE `emr_riwayats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `registrasi_id` (`registrasi_id`,`pasien_id`,`user_id`);

--
-- Indexes for table `emr_riwayat_kesehatans`
--
ALTER TABLE `emr_riwayat_kesehatans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `registrasi_id` (`registrasi_id`,`pasien_id`,`riwayat_id`,`riwayat_kesehatan_id`,`user_id`);

--
-- Indexes for table `esign_logs`
--
ALTER TABLE `esign_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `esign_logs_id_idx` (`id`),
  ADD KEY `esign_logs_registrasi_id_idx` (`registrasi_id`);

--
-- Indexes for table `farmasi_faktur`
--
ALTER TABLE `farmasi_faktur`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `farmasi_faktur_detail`
--
ALTER TABLE `farmasi_faktur_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `farmasi_po`
--
ALTER TABLE `farmasi_po`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `farmasi_po_detail`
--
ALTER TABLE `farmasi_po_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fasilitas`
--
ALTER TABLE `fasilitas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faskes_lanjutans`
--
ALTER TABLE `faskes_lanjutans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `faskes_lanjutans_kode_ppk_unique` (`kode_ppk`);

--
-- Indexes for table `faskes_rujukan_rs`
--
ALTER TABLE `faskes_rujukan_rs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `foliopelak`
--
ALTER TABLE `foliopelak`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `foliopelaksanas`
--
ALTER TABLE `foliopelaksanas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `folios`
--
ALTER TABLE `folios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `folios_registrasi_id_foreign` (`registrasi_id`),
  ADD KEY `folios_pasien_id_foreign` (`pasien_id`),
  ADD KEY `folios_user_id_foreign` (`user_id`),
  ADD KEY `folios_tagihan_id_foreign` (`tagihan_id`),
  ADD KEY `folios_id_idx` (`id`),
  ADD KEY `folios_dokter_id_idx` (`dokter_id`),
  ADD KEY `folios_tarif_id_idx` (`tarif_id`),
  ADD KEY `folios_poli_id_idx` (`poli_id`),
  ADD KEY `folios_poli_tipe_idx` (`poli_tipe`),
  ADD KEY `order_lab_id` (`order_lab_id`);

--
-- Indexes for table `gizis`
--
ALTER TABLE `gizis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hasillabs`
--
ALTER TABLE `hasillabs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hasillabs_user_id_foreign` (`user_id`),
  ADD KEY `idx_registrasi_id` (`registrasi_id`),
  ADD KEY `idx_no_lab` (`no_lab`);

--
-- Indexes for table `hasilradiologis`
--
ALTER TABLE `hasilradiologis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hasil_pemeriksaan`
--
ALTER TABLE `hasil_pemeriksaan`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `hasillabs_user_id_foreign` (`user_id`) USING BTREE;

--
-- Indexes for table `hfis_dokters`
--
ALTER TABLE `hfis_dokters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kodedokter` (`kodedokter`);

--
-- Indexes for table `histori_hapus_fakturs`
--
ALTER TABLE `histori_hapus_fakturs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `histori_kasirs`
--
ALTER TABLE `histori_kasirs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `histori_kunjungan_igd`
--
ALTER TABLE `histori_kunjungan_igd`
  ADD PRIMARY KEY (`id`),
  ADD KEY `registrasi_id` (`registrasi_id`);

--
-- Indexes for table `histori_kunjungan_irj`
--
ALTER TABLE `histori_kunjungan_irj`
  ADD PRIMARY KEY (`id`),
  ADD KEY `histori_kunjungan_irj_idx` (`id`),
  ADD KEY `histori_kunjungan_irj_registrasi_id_idx` (`registrasi_id`),
  ADD KEY `histori_kunjungan_irj_poli_id_idx` (`poli_id`);

--
-- Indexes for table `histori_kunjungan_jnzs`
--
ALTER TABLE `histori_kunjungan_jnzs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `histori_kunjungan_lab`
--
ALTER TABLE `histori_kunjungan_lab`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `histori_kunjungan_prts`
--
ALTER TABLE `histori_kunjungan_prts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `histori_kunjungan_rad`
--
ALTER TABLE `histori_kunjungan_rad`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `histori_kunjungan_rm`
--
ALTER TABLE `histori_kunjungan_rm`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `histori_order_lab`
--
ALTER TABLE `histori_order_lab`
  ADD PRIMARY KEY (`id`),
  ADD KEY `histori_statuses_registrasi_id_foreign` (`registrasi_id`),
  ADD KEY `histori_statuses_user_id_foreign` (`user_id`);

--
-- Indexes for table `histori_pengunjung`
--
ALTER TABLE `histori_pengunjung`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `histori_rawatinap`
--
ALTER TABLE `histori_rawatinap`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `histori_seps`
--
ALTER TABLE `histori_seps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `registrasi_id` (`registrasi_id`);

--
-- Indexes for table `histori_statuses`
--
ALTER TABLE `histori_statuses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `histori_statuses_registrasi_id_foreign` (`registrasi_id`),
  ADD KEY `histori_statuses_user_id_foreign` (`user_id`),
  ADD KEY `histori_statuses_id_idx` (`id`),
  ADD KEY `histori_statuses_poli_id_idx` (`poli_id`),
  ADD KEY `histori_statuses_bed_id_idx` (`bed_id`),
  ADD KEY `histori_statuses_status_idx` (`status`);

--
-- Indexes for table `histori_userlogins`
--
ALTER TABLE `histori_userlogins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hrd_administrasis`
--
ALTER TABLE `hrd_administrasis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hrd_anaks`
--
ALTER TABLE `hrd_anaks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hrd_anaks_biodata_id_foreign` (`biodata_id`),
  ADD KEY `hrd_anaks_pendidikan_id_foreign` (`pendidikan_id`),
  ADD KEY `hrd_anaks_pekerjaan_id_foreign` (`pekerjaan_id`);

--
-- Indexes for table `hrd_biodatas`
--
ALTER TABLE `hrd_biodatas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hrd_biodatas_agama_id_foreign` (`agama_id`);

--
-- Indexes for table `hrd_cutis`
--
ALTER TABLE `hrd_cutis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hrd_cutis_biodata_id_foreign` (`biodata_id`);

--
-- Indexes for table `hrd_disiplin_pegawais`
--
ALTER TABLE `hrd_disiplin_pegawais`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hrd_disiplin_pegawais_biodata_id_foreign` (`biodata_id`);

--
-- Indexes for table `hrd_gaji_berkalas`
--
ALTER TABLE `hrd_gaji_berkalas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hrd_gaji_berkalas_biodata_id_foreign` (`biodata_id`);

--
-- Indexes for table `hrd_ijin_belajars`
--
ALTER TABLE `hrd_ijin_belajars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hrd_ijin_belajars_biodata_id_foreign` (`biodata_id`);

--
-- Indexes for table `hrd_jabatans`
--
ALTER TABLE `hrd_jabatans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hrd_jabatans_biodata_id_foreign` (`biodata_id`);

--
-- Indexes for table `hrd_jenis_cuti`
--
ALTER TABLE `hrd_jenis_cuti`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hrd_keluargas`
--
ALTER TABLE `hrd_keluargas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hrd_keluargas_biodata_id_foreign` (`biodata_id`),
  ADD KEY `hrd_keluargas_pekerjaanayah_id_foreign` (`pekerjaanayah_id`),
  ADD KEY `hrd_keluargas_pendidikan_id_foreign` (`pendidikan_id`),
  ADD KEY `hrd_keluargas_pekerjaanpasangan_id_foreign` (`pekerjaanpasangan_id`);

--
-- Indexes for table `hrd_kepangkatans`
--
ALTER TABLE `hrd_kepangkatans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hrd_kepangkatans_biodata_id_foreign` (`biodata_id`);

--
-- Indexes for table `hrd_pendidikan_formals`
--
ALTER TABLE `hrd_pendidikan_formals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hrd_pendidikan_formals_biodata_id_foreign` (`biodata_id`),
  ADD KEY `hrd_pendidikan_formals_pendidikan_id_foreign` (`pendidikan_id`);

--
-- Indexes for table `hrd_penghargaans`
--
ALTER TABLE `hrd_penghargaans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hrd_penghargaans_biodata_id_foreign` (`biodata_id`);

--
-- Indexes for table `hrd_perubahan_gapoks`
--
ALTER TABLE `hrd_perubahan_gapoks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hrd_perubahan_gapoks_biodata_id_foreign` (`biodata_id`);

--
-- Indexes for table `icd9s`
--
ALTER TABLE `icd9s`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `icd9_im`
--
ALTER TABLE `icd9_im`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `icd9_im_old`
--
ALTER TABLE `icd9_im_old`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `icd10s`
--
ALTER TABLE `icd10s`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nomor` (`nomor`),
  ADD KEY `nama` (`nama`);

--
-- Indexes for table `icd10_im`
--
ALTER TABLE `icd10_im`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `icd10_inacbg`
--
ALTER TABLE `icd10_inacbg`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `icdo_im`
--
ALTER TABLE `icdo_im`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `implementasi_keperawatans`
--
ALTER TABLE `implementasi_keperawatans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inacbgs`
--
ALTER TABLE `inacbgs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `registrasi_id` (`registrasi_id`);

--
-- Indexes for table `inacbgs_bc`
--
ALTER TABLE `inacbgs_bc`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inacbgs_sementara`
--
ALTER TABLE `inacbgs_sementara`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inacbg_logs`
--
ALTER TABLE `inacbg_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inhealth_sjp`
--
ALTER TABLE `inhealth_sjp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `instalasis`
--
ALTER TABLE `instalasis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `intervensi_keperawatans`
--
ALTER TABLE `intervensi_keperawatans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jadwaldokters`
--
ALTER TABLE `jadwaldokters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jamkesdas`
--
ALTER TABLE `jamkesdas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jam_laporans`
--
ALTER TABLE `jam_laporans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jenisjkns`
--
ALTER TABLE `jenisjkns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jenis_pengeluarans`
--
ALTER TABLE `jenis_pengeluarans`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `jkn_icd9s`
--
ALTER TABLE `jkn_icd9s`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jkn_icd9s_registrasi_id_foreign` (`registrasi_id`),
  ADD KEY `jkn_icd9s_carabayar_id_foreign` (`carabayar_id`);

--
-- Indexes for table `jkn_icd10s`
--
ALTER TABLE `jkn_icd10s`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jkn_icd10s_registrasi_id_foreign` (`registrasi_id`),
  ADD KEY `jkn_carabayar_id_foreign` (`carabayar_id`);

--
-- Indexes for table `kamars`
--
ALTER TABLE `kamars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kamars_kelas_id_foreign` (`kelas_id`);

--
-- Indexes for table `kategoriheaders`
--
ALTER TABLE `kategoriheaders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategoriobats`
--
ALTER TABLE `kategoriobats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategoritarifs`
--
ALTER TABLE `kategoritarifs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kategoritarifs_kategoriheader_id_foreign` (`kategoriheader_id`);

--
-- Indexes for table `kategori_pegawai`
--
ALTER TABLE `kategori_pegawai`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kelompoktarifs`
--
ALTER TABLE `kelompoktarifs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kelompok_kelas`
--
ALTER TABLE `kelompok_kelas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kesadarans`
--
ALTER TABLE `kesadarans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `klasifikasi_pengeluarans`
--
ALTER TABLE `klasifikasi_pengeluarans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kondisi_akhir_pasiens`
--
ALTER TABLE `kondisi_akhir_pasiens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kondisi_akhir_pasien_ss`
--
ALTER TABLE `kondisi_akhir_pasien_ss`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kondisi_pasien_tiba`
--
ALTER TABLE `kondisi_pasien_tiba`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `kuota_dokter`
--
ALTER TABLE `kuota_dokter`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pegawai_id` (`pegawai_id`);

--
-- Indexes for table `labkategoris`
--
ALTER TABLE `labkategoris`
  ADD PRIMARY KEY (`id`),
  ADD KEY `labkategoris_labsection_id_foreign` (`labsection_id`);

--
-- Indexes for table `laboratoria`
--
ALTER TABLE `laboratoria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `laboratoria_labkategori_id_foreign` (`labkategori_id`);

--
-- Indexes for table `labsections`
--
ALTER TABLE `labsections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lica_results`
--
ALTER TABLE `lica_results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hasillabs_user_id_foreign` (`user_id`),
  ADD KEY `id` (`id`,`no_lab`);

--
-- Indexes for table `lis_logs`
--
ALTER TABLE `lis_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lis_results`
--
ALTER TABLE `lis_results`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logistik_bapbs`
--
ALTER TABLE `logistik_bapbs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logistik_batches`
--
ALTER TABLE `logistik_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logistik_batches_BC`
--
ALTER TABLE `logistik_batches_BC`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logistik_fakturs`
--
ALTER TABLE `logistik_fakturs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logistik_gudangs`
--
ALTER TABLE `logistik_gudangs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `logistik_gudangs_kode_unique` (`kode`),
  ADD UNIQUE KEY `logistik_gudangs_nama_unique` (`nama`);

--
-- Indexes for table `logistik_non_medik_barangs`
--
ALTER TABLE `logistik_non_medik_barangs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logistik_non_medik_barang_per_gudangs`
--
ALTER TABLE `logistik_non_medik_barang_per_gudangs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logistik_non_medik_bidangs`
--
ALTER TABLE `logistik_non_medik_bidangs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logistik_non_medik_distribusis`
--
ALTER TABLE `logistik_non_medik_distribusis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logistik_non_medik_golongans`
--
ALTER TABLE `logistik_non_medik_golongans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logistik_non_medik_gudangs`
--
ALTER TABLE `logistik_non_medik_gudangs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logistik_non_medik_kategoris`
--
ALTER TABLE `logistik_non_medik_kategoris`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logistik_non_medik_kelompoks`
--
ALTER TABLE `logistik_non_medik_kelompoks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logistik_non_medik_no_pos`
--
ALTER TABLE `logistik_non_medik_no_pos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logistik_non_medik_penerimaans`
--
ALTER TABLE `logistik_non_medik_penerimaans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logistik_non_medik_periodes`
--
ALTER TABLE `logistik_non_medik_periodes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logistik_non_medik_permintaans`
--
ALTER TABLE `logistik_non_medik_permintaans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logistik_non_medik_pos`
--
ALTER TABLE `logistik_non_medik_pos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logistik_non_medik_saldo_awals`
--
ALTER TABLE `logistik_non_medik_saldo_awals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logistik_non_medik_satuans`
--
ALTER TABLE `logistik_non_medik_satuans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logistik_non_medik_sub_kelompoks`
--
ALTER TABLE `logistik_non_medik_sub_kelompoks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logistik_non_medik_sub_sub_kelompoks`
--
ALTER TABLE `logistik_non_medik_sub_sub_kelompoks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logistik_non_medik_supliers`
--
ALTER TABLE `logistik_non_medik_supliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logistik_no_batches`
--
ALTER TABLE `logistik_no_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logistik_opnames`
--
ALTER TABLE `logistik_opnames`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logistik_opnames_BC`
--
ALTER TABLE `logistik_opnames_BC`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logistik_pejabat_bendaharas`
--
ALTER TABLE `logistik_pejabat_bendaharas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logistik_pejabat_pemeriksa`
--
ALTER TABLE `logistik_pejabat_pemeriksa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logistik_pejabat_pengadaans`
--
ALTER TABLE `logistik_pejabat_pengadaans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logistik_pemakaians`
--
ALTER TABLE `logistik_pemakaians`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logistik_penerimaans`
--
ALTER TABLE `logistik_penerimaans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logistik_pengirim_penerimas`
--
ALTER TABLE `logistik_pengirim_penerimas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logistik_periodes`
--
ALTER TABLE `logistik_periodes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logistik_permintaans`
--
ALTER TABLE `logistik_permintaans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logistik_pinjam_obats`
--
ALTER TABLE `logistik_pinjam_obats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logistik_po`
--
ALTER TABLE `logistik_po`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logistik_saldo_awals`
--
ALTER TABLE `logistik_saldo_awals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logistik_satkers`
--
ALTER TABLE `logistik_satkers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logistik_spks`
--
ALTER TABLE `logistik_spks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logistik_stocks`
--
ALTER TABLE `logistik_stocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `logistik_stocks_id_idx` (`id`),
  ADD KEY `logistik_stocks_gudang_id_idx` (`gudang_id`),
  ADD KEY `logistik_stocks_masterobat_id_idx` (`masterobat_id`),
  ADD KEY `logistik_stocks_supplier_id_idx` (`supplier_id`);

--
-- Indexes for table `logistik_stocks_BC`
--
ALTER TABLE `logistik_stocks_BC`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logistik_suppliers`
--
ALTER TABLE `logistik_suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log_bridging`
--
ALTER TABLE `log_bridging`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log_delete_folio`
--
ALTER TABLE `log_delete_folio`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log_users`
--
ALTER TABLE `log_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `registrasi_id` (`registrasi_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `mastergizis`
--
ALTER TABLE `mastergizis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `masteridrg`
--
ALTER TABLE `masteridrg`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `masteridrg_biaya`
--
ALTER TABLE `masteridrg_biaya`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mastermapping`
--
ALTER TABLE `mastermapping`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mastermapping_biaya`
--
ALTER TABLE `mastermapping_biaya`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `masterobats`
--
ALTER TABLE `masterobats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mastersplits`
--
ALTER TABLE `mastersplits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mastersplits_tahuntarif_id_foreign` (`tahuntarif_id`),
  ADD KEY `mastersplits_kategoriheader_id_foreign` (`kategoriheader_id`);

--
-- Indexes for table `master_cara_minums`
--
ALTER TABLE `master_cara_minums`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_diets`
--
ALTER TABLE `master_diets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_dokter_perujuk`
--
ALTER TABLE `master_dokter_perujuk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_etikets`
--
ALTER TABLE `master_etikets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_licas`
--
ALTER TABLE `master_licas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_licas_BCC`
--
ALTER TABLE `master_licas_BCC`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_licas_pakets`
--
ALTER TABLE `master_licas_pakets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_ppis`
--
ALTER TABLE `master_ppis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_puskesmas`
--
ALTER TABLE `master_puskesmas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_riwayat_kesehatans`
--
ALTER TABLE `master_riwayat_kesehatans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `metode_bayars`
--
ALTER TABLE `metode_bayars`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `modalities`
--
ALTER TABLE `modalities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nomorrms`
--
ALTER TABLE `nomorrms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `no_pos`
--
ALTER TABLE `no_pos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `no_pos_no_po_unique` (`no_po`);

--
-- Indexes for table `obat_antibiotik`
--
ALTER TABLE `obat_antibiotik`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `operasis`
--
ALTER TABLE `operasis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `registrasi_id` (`registrasi_id`);

--
-- Indexes for table `order_lab`
--
ALTER TABLE `order_lab`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_odontograms`
--
ALTER TABLE `order_odontograms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_radiologi`
--
ALTER TABLE `order_radiologi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pacs_expertise`
--
ALTER TABLE `pacs_expertise`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pacs_order`
--
ALTER TABLE `pacs_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pagu_perawatans`
--
ALTER TABLE `pagu_perawatans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pasiens`
--
ALTER TABLE `pasiens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pasiens_perusahaan_id_foreign` (`perusahaan_id`),
  ADD KEY `pasiens_agama_id_foreign` (`agama_id`(191)),
  ADD KEY `pasiens_pekerjaan_id_foreign` (`pekerjaan_id`(191)),
  ADD KEY `pasiens_pendidikan_id_foreign` (`pendidikan_id`(191)),
  ADD KEY `pasiens_id_idx` (`id`),
  ADD KEY `pasiens_no_rm_idx` (`no_rm`);

--
-- Indexes for table `pasien_android`
--
ALTER TABLE `pasien_android`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pasien_langsung`
--
ALTER TABLE `pasien_langsung`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `pegawais`
--
ALTER TABLE `pegawais`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pegawais_user_id_foreign` (`user_id`),
  ADD KEY `pegawais_id_idx` (`id`),
  ADD KEY `pegawais_nama_idx` (`nama`),
  ADD KEY `pegawais_kategori_pegawai_idx` (`kategori_pegawai`),
  ADD KEY `pegawais_general_code_idx` (`general_code`),
  ADD KEY `pegawais_nik_idx` (`nik`),
  ADD KEY `pegawais_nip_idx` (`nip`),
  ADD KEY `pegawais_kode_bpjs_idx` (`kode_bpjs`),
  ADD KEY `pegawais_id_dokterss_idx` (`id_dokterss`);

--
-- Indexes for table `pekerjaans`
--
ALTER TABLE `pekerjaans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pembayarans`
--
ALTER TABLE `pembayarans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pembayarans_user_id_foreign` (`user_id`),
  ADD KEY `pembayarans_registrasi_id_foreign` (`registrasi_id`);

--
-- Indexes for table `pendapatans`
--
ALTER TABLE `pendapatans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pendapatan_diklats`
--
ALTER TABLE `pendapatan_diklats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pendapatan_parkirs`
--
ALTER TABLE `pendapatan_parkirs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pendidikans`
--
ALTER TABLE `pendidikans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `penerimaan_produks`
--
ALTER TABLE `penerimaan_produks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `penerimaan` (`kode_penerimaan`,`tanggal_penerimaan`,`sumber_dana`);

--
-- Indexes for table `penerimaan_produk_detil`
--
ALTER TABLE `penerimaan_produk_detil`
  ADD PRIMARY KEY (`id`),
  ADD KEY `penerimaan` (`kode_penerimaan_detil`,`kode_penerimaan`,`kode_produk`,`nama_produk`,`jenis_produk`);

--
-- Indexes for table `pengembalian_obats`
--
ALTER TABLE `pengembalian_obats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengirim_rujukan`
--
ALTER TABLE `pengirim_rujukan`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `penjualanbebas`
--
ALTER TABLE `penjualanbebas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `penjualandetails`
--
ALTER TABLE `penjualandetails`
  ADD PRIMARY KEY (`id`),
  ADD KEY `penjualandetails_penjualan_id_foreign` (`penjualan_id`),
  ADD KEY `penjualandetails_masterobat_id_foreign` (`masterobat_id`),
  ADD KEY `penjualandetails_id_idx` (`id`),
  ADD KEY `penjualandetails_no_resep_idx` (`no_resep`),
  ADD KEY `penjualandetails_logistik_batch_id_idx` (`logistik_batch_id`);

--
-- Indexes for table `penjualans`
--
ALTER TABLE `penjualans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `penjualans_no_resep_unique` (`no_resep`),
  ADD KEY `penjualans_user_id_foreign` (`user_id`),
  ADD KEY `penjualans_id_idx` (`id`),
  ADD KEY `penjualans_registrasi_id_idx` (`registrasi_id`),
  ADD KEY `penjualans_pembuat_resep_idx` (`pembuat_resep`),
  ADD KEY `penjualans_dokter_id_idx` (`dokter_id`);

--
-- Indexes for table `perawatan_icd9s`
--
ALTER TABLE `perawatan_icd9s`
  ADD PRIMARY KEY (`id`),
  ADD KEY `perawatan_icd9s_registrasi_id_foreign` (`registrasi_id`),
  ADD KEY `perawatan_icd9s_carabayar_id_foreign` (`carabayar_id`);

--
-- Indexes for table `perawatan_icd9_idrgs`
--
ALTER TABLE `perawatan_icd9_idrgs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `perawatan_icd9s_registrasi_id_foreign` (`registrasi_id`),
  ADD KEY `perawatan_icd9s_carabayar_id_foreign` (`carabayar_id`);

--
-- Indexes for table `perawatan_icd10s`
--
ALTER TABLE `perawatan_icd10s`
  ADD PRIMARY KEY (`id`),
  ADD KEY `perawatan_icd10s_registrasi_id_foreign` (`registrasi_id`),
  ADD KEY `perawatan_icd10s_carabayar_id_foreign` (`carabayar_id`),
  ADD KEY `icd10` (`icd10`,`jenis`);

--
-- Indexes for table `perawatan_icd10_idrgs`
--
ALTER TABLE `perawatan_icd10_idrgs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `perawatan_icd10s_registrasi_id_foreign` (`registrasi_id`),
  ADD KEY `perawatan_icd10s_carabayar_id_foreign` (`carabayar_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_unique` (`name`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `permission_role_role_id_foreign` (`role_id`);

--
-- Indexes for table `permission_user`
--
ALTER TABLE `permission_user`
  ADD PRIMARY KEY (`user_id`,`permission_id`,`user_type`),
  ADD KEY `permission_user_permission_id_foreign` (`permission_id`);

--
-- Indexes for table `perusahaans`
--
ALTER TABLE `perusahaans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `phone_books`
--
ALTER TABLE `phone_books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `piutangs`
--
ALTER TABLE `piutangs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `polis`
--
ALTER TABLE `polis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `politypes`
--
ALTER TABLE `politypes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posisiberkas`
--
ALTER TABLE `posisiberkas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `potensi_prb1`
--
ALTER TABLE `potensi_prb1`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ppis`
--
ALTER TABLE `ppis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ppi_antibiotiks`
--
ALTER TABLE `ppi_antibiotiks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ppi_faktor_pemakaians`
--
ALTER TABLE `ppi_faktor_pemakaians`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `predictive`
--
ALTER TABLE `predictive`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prognosis`
--
ALTER TABLE `prognosis`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `provinces`
--
ALTER TABLE `provinces`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `provinces2`
--
ALTER TABLE `provinces2`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `radiologi_ekspertises`
--
ALTER TABLE `radiologi_ekspertises`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rawatinaps`
--
ALTER TABLE `rawatinaps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `registrasi_id` (`registrasi_id`);

--
-- Indexes for table `record_satusehat`
--
ALTER TABLE `record_satusehat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `regencies`
--
ALTER TABLE `regencies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `regencies_province_id_index` (`province_id`);

--
-- Indexes for table `regencies2`
--
ALTER TABLE `regencies2`
  ADD PRIMARY KEY (`id`),
  ADD KEY `regencies_province_id_index` (`province_id`);

--
-- Indexes for table `registrasis`
--
ALTER TABLE `registrasis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `registrasis_sebabsakit_id_foreign` (`sebabsakit_id`),
  ADD KEY `registrasis_kelas_id_foreign` (`kelas_id`),
  ADD KEY `registrasis_instalasi_id_foreign` (`instalasi_id`),
  ADD KEY `registrasis_user_create_foreign` (`user_create`),
  ADD KEY `registrasis_posisiberkas_id_foreign` (`posisiberkas_id`),
  ADD KEY `registrasis_perusahaan_id_foreign` (`perusahaan_id`),
  ADD KEY `registrasis_id_idx` (`id`),
  ADD KEY `registrasis_pasien_id_idx` (`pasien_id`),
  ADD KEY `registrasis_reg_id_idx` (`reg_id`),
  ADD KEY `registrasis_dokter_id_idx` (`dokter_id`),
  ADD KEY `registrasis_poli_id_idx` (`poli_id`),
  ADD KEY `registrasis_bayar_idx` (`bayar`),
  ADD KEY `registrasis_antrian_poli_id_idx` (`antrian_poli_id`);

--
-- Indexes for table `registrasis_dummy`
--
ALTER TABLE `registrasis_dummy`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `resep_note`
--
ALTER TABLE `resep_note`
  ADD PRIMARY KEY (`id`),
  ADD KEY `registrasi_id` (`registrasi_id`);

--
-- Indexes for table `resep_note_detail`
--
ALTER TABLE `resep_note_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `resep_note_id` (`resep_note_id`);

--
-- Indexes for table `resep_note_duplicate`
--
ALTER TABLE `resep_note_duplicate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `resume_pasiens`
--
ALTER TABLE `resume_pasiens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `retur_obat_rusaks`
--
ALTER TABLE `retur_obat_rusaks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rincian_hasillabs`
--
ALTER TABLE `rincian_hasillabs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rincian_hasillabs_labkategori_id_foreign` (`labkategori_id`),
  ADD KEY `rincian_hasillabs_laboratoria_id_foreign` (`laboratoria_id`),
  ADD KEY `rincian_hasillabs_user_id_foreign` (`user_id`),
  ADD KEY `rincian_hasillabs_hasillab_id_foreign` (`hasillab_id`),
  ADD KEY `rincian_hasillabs_labsection_id_foreign` (`labsection_id`);

--
-- Indexes for table `rincian_pengembalian_obats`
--
ALTER TABLE `rincian_pengembalian_obats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rincian_pinjam_obats`
--
ALTER TABLE `rincian_pinjam_obats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ris_logs`
--
ALTER TABLE `ris_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ris_tindakans`
--
ALTER TABLE `ris_tindakans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rl_keluarga_berencana`
--
ALTER TABLE `rl_keluarga_berencana`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`user_id`,`role_id`,`user_type`),
  ADD KEY `role_user_role_id_foreign` (`role_id`);

--
-- Indexes for table `rstujuanpinjams`
--
ALTER TABLE `rstujuanpinjams`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rs_mr`
--
ALTER TABLE `rs_mr`
  ADD PRIMARY KEY (`mr_id`);

--
-- Indexes for table `rujukans`
--
ALTER TABLE `rujukans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rujukan_obat`
--
ALTER TABLE `rujukan_obat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `saderek_master_screening`
--
ALTER TABLE `saderek_master_screening`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `saderek_operasi`
--
ALTER TABLE `saderek_operasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `saderek_poli`
--
ALTER TABLE `saderek_poli`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `saderek_registrasis_dummy`
--
ALTER TABLE `saderek_registrasis_dummy`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `saderek_screening_pasien`
--
ALTER TABLE `saderek_screening_pasien`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `saderek_screening_pasien_detail`
--
ALTER TABLE `saderek_screening_pasien_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `saderek_user_dummy`
--
ALTER TABLE `saderek_user_dummy`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `satuanbelis`
--
ALTER TABLE `satuanbelis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `satuanjuals`
--
ALTER TABLE `satuanjuals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `satu_sehat`
--
ALTER TABLE `satu_sehat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sebabsakits`
--
ALTER TABLE `sebabsakits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sep_logs`
--
ALTER TABLE `sep_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sep_pengajuans`
--
ALTER TABLE `sep_pengajuans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sep_poli_lanjutans`
--
ALTER TABLE `sep_poli_lanjutans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sep_rujukan_keluars`
--
ALTER TABLE `sep_rujukan_keluars`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_notifs`
--
ALTER TABLE `service_notifs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sipeka`
--
ALTER TABLE `sipeka`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slideshows`
--
ALTER TABLE `slideshows`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `snomed-ct`
--
ALTER TABLE `snomed-ct`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `snomed-ct-children`
--
ALTER TABLE `snomed-ct-children`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `splits`
--
ALTER TABLE `splits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `splits_tahuntarif_id_foreign` (`tahuntarif_id`),
  ADD KEY `splits_kategoriheader_id_foreign` (`kategoriheader_id`),
  ADD KEY `splits_tarif_id_foreign` (`tarif_id`);

--
-- Indexes for table `statuses`
--
ALTER TABLE `statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supliyers`
--
ALTER TABLE `supliyers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `surat_inaps`
--
ALTER TABLE `surat_inaps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `registrasi_id` (`registrasi_id`);

--
-- Indexes for table `surat_izin_pulang`
--
ALTER TABLE `surat_izin_pulang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tagihans`
--
ALTER TABLE `tagihans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tagihans_user_id_foreign` (`user_id`),
  ADD KEY `tagihans_dokter_id_foreign` (`dokter_id`,`pasien_id`),
  ADD KEY `tagihans_id_idx` (`id`),
  ADD KEY `tagihans_registrasi_id_idx` (`registrasi_id`);

--
-- Indexes for table `tahuntarifs`
--
ALTER TABLE `tahuntarifs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `takaranobat_etikets`
--
ALTER TABLE `takaranobat_etikets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tanda_tangan_dokumen`
--
ALTER TABLE `tanda_tangan_dokumen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `registrasi_id` (`registrasi_id`);

--
-- Indexes for table `tarifs`
--
ALTER TABLE `tarifs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tarifs_kategoritarif_id_foreign` (`kategoritarif_id`),
  ADD KEY `tarifs_tahuntarif_id_foreign` (`tahuntarif_id`),
  ADD KEY `tarifs_id_idx` (`id`),
  ADD KEY `tarifs_nama_idx` (`nama`),
  ADD KEY `tarifs_kelas_id_idx` (`kelas_id`),
  ADD KEY `tarifs_jenis_idx` (`jenis`);

--
-- Indexes for table `tarif_new_backup`
--
ALTER TABLE `tarif_new_backup`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tarifs_kategoritarif_id_foreign` (`kategoritarif_id`),
  ADD KEY `tarifs_tahuntarif_id_foreign` (`tahuntarif_id`);

--
-- Indexes for table `tarif_old`
--
ALTER TABLE `tarif_old`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tarifs_kategoritarif_id_foreign` (`kategoritarif_id`),
  ADD KEY `tarifs_tahuntarif_id_foreign` (`tahuntarif_id`);

--
-- Indexes for table `taskid_logs`
--
ALTER TABLE `taskid_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tipelayanans`
--
ALTER TABLE `tipelayanans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi_keluars`
--
ALTER TABLE `transaksi_keluars`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `transportasi`
--
ALTER TABLE `transportasi`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `uang_raciks`
--
ALTER TABLE `uang_raciks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_id_idx` (`id`);

--
-- Indexes for table `user_sipeka`
--
ALTER TABLE `user_sipeka`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_sipeka_old`
--
ALTER TABLE `user_sipeka_old`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `villages`
--
ALTER TABLE `villages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `villages_district_id_index` (`district_id`);

--
-- Indexes for table `villages2`
--
ALTER TABLE `villages2`
  ADD PRIMARY KEY (`id`),
  ADD KEY `villages_district_id_index` (`district_id`);

--
-- Indexes for table `waktutunggus`
--
ALTER TABLE `waktutunggus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `waktutunggus_registrasi_id_foreign` (`registrasi_id`),
  ADD KEY `waktutunggus_antrian_id_foreign` (`antrian_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `agamas`
--
ALTER TABLE `agamas`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akutansi_akun_coas`
--
ALTER TABLE `akutansi_akun_coas`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akutansi_journals`
--
ALTER TABLE `akutansi_journals`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akutansi_journal_details`
--
ALTER TABLE `akutansi_journal_details`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akutansi_kas_dan_banks`
--
ALTER TABLE `akutansi_kas_dan_banks`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akutansi_lap_ekuitases`
--
ALTER TABLE `akutansi_lap_ekuitases`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akutansi_lap_sal`
--
ALTER TABLE `akutansi_lap_sal`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akutansi_pengurangan_piutang`
--
ALTER TABLE `akutansi_pengurangan_piutang`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akutansi_penyisihan_piutang`
--
ALTER TABLE `akutansi_penyisihan_piutang`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `akutansi_penyusutan_piutang`
--
ALTER TABLE `akutansi_penyusutan_piutang`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `allergy`
--
ALTER TABLE `allergy`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `android_content`
--
ALTER TABLE `android_content`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `android_content_type`
--
ALTER TABLE `android_content_type`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `android_direksi`
--
ALTER TABLE `android_direksi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `android_images`
--
ALTER TABLE `android_images`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `android_jabatan`
--
ALTER TABLE `android_jabatan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `android_manajemen`
--
ALTER TABLE `android_manajemen`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `android_slider`
--
ALTER TABLE `android_slider`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `antrian2`
--
ALTER TABLE `antrian2`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `antrian3`
--
ALTER TABLE `antrian3`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `antrian4`
--
ALTER TABLE `antrian4`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `antrian5`
--
ALTER TABLE `antrian5`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `antrian6`
--
ALTER TABLE `antrian6`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `antrians`
--
ALTER TABLE `antrians`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `antrian_farmasis`
--
ALTER TABLE `antrian_farmasis`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `antrian_laboratorium`
--
ALTER TABLE `antrian_laboratorium`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `antrian_logs`
--
ALTER TABLE `antrian_logs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `antrian_poli`
--
ALTER TABLE `antrian_poli`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `antrian_poli_BC`
--
ALTER TABLE `antrian_poli_BC`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `antrian_radiologis`
--
ALTER TABLE `antrian_radiologis`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `antrian_rawatinaps`
--
ALTER TABLE `antrian_rawatinaps`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `apotekers`
--
ALTER TABLE `apotekers`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `apotekers_bc`
--
ALTER TABLE `apotekers_bc`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `aturanetikets`
--
ALTER TABLE `aturanetikets`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bdrs`
--
ALTER TABLE `bdrs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bdrs_detail`
--
ALTER TABLE `bdrs_detail`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `beds`
--
ALTER TABLE `beds`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bed_logs`
--
ALTER TABLE `bed_logs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `biayaregistrasis`
--
ALTER TABLE `biayaregistrasis`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `biaya_farmasi`
--
ALTER TABLE `biaya_farmasi`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `biaya_farmasi_detail`
--
ALTER TABLE `biaya_farmasi_detail`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `biaya_infus`
--
ALTER TABLE `biaya_infus`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `biaya_infus_detail`
--
ALTER TABLE `biaya_infus_detail`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `biaya_mcu`
--
ALTER TABLE `biaya_mcu`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `biaya_mcu_detail`
--
ALTER TABLE `biaya_mcu_detail`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `biaya_pemeriksaans`
--
ALTER TABLE `biaya_pemeriksaans`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bpjs_kabs`
--
ALTER TABLE `bpjs_kabs`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bpjs_kecs`
--
ALTER TABLE `bpjs_kecs`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bpjs_logs`
--
ALTER TABLE `bpjs_logs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bpjs_master_obat_prb`
--
ALTER TABLE `bpjs_master_obat_prb`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bpjs_master_program_prb`
--
ALTER TABLE `bpjs_master_program_prb`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bpjs_prb`
--
ALTER TABLE `bpjs_prb`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bpjs_prb_detail_obat`
--
ALTER TABLE `bpjs_prb_detail_obat`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bpjs_prb_response`
--
ALTER TABLE `bpjs_prb_response`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bpjs_provs`
--
ALTER TABLE `bpjs_provs`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bpjs_rencana_kontrol`
--
ALTER TABLE `bpjs_rencana_kontrol`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `carabayars`
--
ALTER TABLE `carabayars`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `configs`
--
ALTER TABLE `configs`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `conf_consid`
--
ALTER TABLE `conf_consid`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `conf_rl31`
--
ALTER TABLE `conf_rl31`
  MODIFY `id_conf_rl31` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `conf_rl33`
--
ALTER TABLE `conf_rl33`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `conf_rl33_new`
--
ALTER TABLE `conf_rl33_new`
  MODIFY `id_conf_rl33` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `conf_rl34`
--
ALTER TABLE `conf_rl34`
  MODIFY `id_conf_rl34` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `conf_rl35`
--
ALTER TABLE `conf_rl35`
  MODIFY `id_conf_rl35` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `conf_rl36`
--
ALTER TABLE `conf_rl36`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `conf_rl36_new`
--
ALTER TABLE `conf_rl36_new`
  MODIFY `id_conf_rl36` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `conf_rl37`
--
ALTER TABLE `conf_rl37`
  MODIFY `id_conf_rl37` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `conf_rl38`
--
ALTER TABLE `conf_rl38`
  MODIFY `id_conf_rl38` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `conf_rl39`
--
ALTER TABLE `conf_rl39`
  MODIFY `id_conf_rl39` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `conf_rl310`
--
ALTER TABLE `conf_rl310`
  MODIFY `id_conf_rl310` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `conf_rl311`
--
ALTER TABLE `conf_rl311`
  MODIFY `id_conf_rl311` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `conf_rl312`
--
ALTER TABLE `conf_rl312`
  MODIFY `id_conf_rl312` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `copy_reseps`
--
ALTER TABLE `copy_reseps`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `copy_resep_details`
--
ALTER TABLE `copy_resep_details`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_seps`
--
ALTER TABLE `data_seps`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `deposits`
--
ALTER TABLE `deposits`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `detailradiologis`
--
ALTER TABLE `detailradiologis`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `diagnosa_keperawatans`
--
ALTER TABLE `diagnosa_keperawatans`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dokumen_rekam_medis`
--
ALTER TABLE `dokumen_rekam_medis`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `echocardiograms`
--
ALTER TABLE `echocardiograms`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `edukasis`
--
ALTER TABLE `edukasis`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `edukasi_diets`
--
ALTER TABLE `edukasi_diets`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ekspertise_duplicate`
--
ALTER TABLE `ekspertise_duplicate`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emr`
--
ALTER TABLE `emr`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emr_ews`
--
ALTER TABLE `emr_ews`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emr_farmasi`
--
ALTER TABLE `emr_farmasi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emr_gizi`
--
ALTER TABLE `emr_gizi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emr_inap_icds`
--
ALTER TABLE `emr_inap_icds`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emr_inap_kondisi_khususes`
--
ALTER TABLE `emr_inap_kondisi_khususes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emr_inap_medical_records`
--
ALTER TABLE `emr_inap_medical_records`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emr_inap_pemeriksaans`
--
ALTER TABLE `emr_inap_pemeriksaans`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emr_inap_penilaians`
--
ALTER TABLE `emr_inap_penilaians`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emr_inap_perencanaans`
--
ALTER TABLE `emr_inap_perencanaans`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emr_keadaan_umums`
--
ALTER TABLE `emr_keadaan_umums`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emr_konsuls`
--
ALTER TABLE `emr_konsuls`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emr_master_keadaan_umums`
--
ALTER TABLE `emr_master_keadaan_umums`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emr_mrs`
--
ALTER TABLE `emr_mrs`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emr_pengkajian_harians`
--
ALTER TABLE `emr_pengkajian_harians`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emr_resume`
--
ALTER TABLE `emr_resume`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emr_riwayats`
--
ALTER TABLE `emr_riwayats`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emr_riwayat_kesehatans`
--
ALTER TABLE `emr_riwayat_kesehatans`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `esign_logs`
--
ALTER TABLE `esign_logs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `farmasi_faktur`
--
ALTER TABLE `farmasi_faktur`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `farmasi_faktur_detail`
--
ALTER TABLE `farmasi_faktur_detail`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `farmasi_po`
--
ALTER TABLE `farmasi_po`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `farmasi_po_detail`
--
ALTER TABLE `farmasi_po_detail`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fasilitas`
--
ALTER TABLE `fasilitas`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faskes_lanjutans`
--
ALTER TABLE `faskes_lanjutans`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faskes_rujukan_rs`
--
ALTER TABLE `faskes_rujukan_rs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `foliopelak`
--
ALTER TABLE `foliopelak`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `foliopelaksanas`
--
ALTER TABLE `foliopelaksanas`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `folios`
--
ALTER TABLE `folios`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gizis`
--
ALTER TABLE `gizis`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hasillabs`
--
ALTER TABLE `hasillabs`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hasilradiologis`
--
ALTER TABLE `hasilradiologis`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hasil_pemeriksaan`
--
ALTER TABLE `hasil_pemeriksaan`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hfis_dokters`
--
ALTER TABLE `hfis_dokters`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `histori_hapus_fakturs`
--
ALTER TABLE `histori_hapus_fakturs`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `histori_kasirs`
--
ALTER TABLE `histori_kasirs`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `histori_kunjungan_igd`
--
ALTER TABLE `histori_kunjungan_igd`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `histori_kunjungan_irj`
--
ALTER TABLE `histori_kunjungan_irj`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `histori_kunjungan_jnzs`
--
ALTER TABLE `histori_kunjungan_jnzs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `histori_kunjungan_lab`
--
ALTER TABLE `histori_kunjungan_lab`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `histori_kunjungan_prts`
--
ALTER TABLE `histori_kunjungan_prts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `histori_kunjungan_rad`
--
ALTER TABLE `histori_kunjungan_rad`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `histori_kunjungan_rm`
--
ALTER TABLE `histori_kunjungan_rm`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `histori_order_lab`
--
ALTER TABLE `histori_order_lab`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `histori_pengunjung`
--
ALTER TABLE `histori_pengunjung`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `histori_rawatinap`
--
ALTER TABLE `histori_rawatinap`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `histori_seps`
--
ALTER TABLE `histori_seps`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `histori_statuses`
--
ALTER TABLE `histori_statuses`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `histori_userlogins`
--
ALTER TABLE `histori_userlogins`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hrd_administrasis`
--
ALTER TABLE `hrd_administrasis`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hrd_anaks`
--
ALTER TABLE `hrd_anaks`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hrd_biodatas`
--
ALTER TABLE `hrd_biodatas`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hrd_cutis`
--
ALTER TABLE `hrd_cutis`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hrd_disiplin_pegawais`
--
ALTER TABLE `hrd_disiplin_pegawais`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hrd_gaji_berkalas`
--
ALTER TABLE `hrd_gaji_berkalas`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hrd_ijin_belajars`
--
ALTER TABLE `hrd_ijin_belajars`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hrd_jabatans`
--
ALTER TABLE `hrd_jabatans`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hrd_jenis_cuti`
--
ALTER TABLE `hrd_jenis_cuti`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hrd_keluargas`
--
ALTER TABLE `hrd_keluargas`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hrd_kepangkatans`
--
ALTER TABLE `hrd_kepangkatans`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hrd_pendidikan_formals`
--
ALTER TABLE `hrd_pendidikan_formals`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hrd_penghargaans`
--
ALTER TABLE `hrd_penghargaans`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hrd_perubahan_gapoks`
--
ALTER TABLE `hrd_perubahan_gapoks`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `icd9s`
--
ALTER TABLE `icd9s`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `icd9_im`
--
ALTER TABLE `icd9_im`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `icd9_im_old`
--
ALTER TABLE `icd9_im_old`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `icd10s`
--
ALTER TABLE `icd10s`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `icd10_im`
--
ALTER TABLE `icd10_im`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `icd10_inacbg`
--
ALTER TABLE `icd10_inacbg`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `icdo_im`
--
ALTER TABLE `icdo_im`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `implementasi_keperawatans`
--
ALTER TABLE `implementasi_keperawatans`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inacbgs`
--
ALTER TABLE `inacbgs`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inacbgs_bc`
--
ALTER TABLE `inacbgs_bc`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inacbgs_sementara`
--
ALTER TABLE `inacbgs_sementara`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inacbg_logs`
--
ALTER TABLE `inacbg_logs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inhealth_sjp`
--
ALTER TABLE `inhealth_sjp`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `instalasis`
--
ALTER TABLE `instalasis`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `intervensi_keperawatans`
--
ALTER TABLE `intervensi_keperawatans`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jadwaldokters`
--
ALTER TABLE `jadwaldokters`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jamkesdas`
--
ALTER TABLE `jamkesdas`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jam_laporans`
--
ALTER TABLE `jam_laporans`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jenisjkns`
--
ALTER TABLE `jenisjkns`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jenis_pengeluarans`
--
ALTER TABLE `jenis_pengeluarans`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jkn_icd9s`
--
ALTER TABLE `jkn_icd9s`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jkn_icd10s`
--
ALTER TABLE `jkn_icd10s`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kamars`
--
ALTER TABLE `kamars`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategoriheaders`
--
ALTER TABLE `kategoriheaders`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategoriobats`
--
ALTER TABLE `kategoriobats`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategoritarifs`
--
ALTER TABLE `kategoritarifs`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategori_pegawai`
--
ALTER TABLE `kategori_pegawai`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kelompoktarifs`
--
ALTER TABLE `kelompoktarifs`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kelompok_kelas`
--
ALTER TABLE `kelompok_kelas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kesadarans`
--
ALTER TABLE `kesadarans`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `klasifikasi_pengeluarans`
--
ALTER TABLE `klasifikasi_pengeluarans`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kondisi_akhir_pasiens`
--
ALTER TABLE `kondisi_akhir_pasiens`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kondisi_akhir_pasien_ss`
--
ALTER TABLE `kondisi_akhir_pasien_ss`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kondisi_pasien_tiba`
--
ALTER TABLE `kondisi_pasien_tiba`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kuota_dokter`
--
ALTER TABLE `kuota_dokter`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `labkategoris`
--
ALTER TABLE `labkategoris`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `laboratoria`
--
ALTER TABLE `laboratoria`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `labsections`
--
ALTER TABLE `labsections`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lica_results`
--
ALTER TABLE `lica_results`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lis_logs`
--
ALTER TABLE `lis_logs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lis_results`
--
ALTER TABLE `lis_results`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logistik_bapbs`
--
ALTER TABLE `logistik_bapbs`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logistik_batches`
--
ALTER TABLE `logistik_batches`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logistik_batches_BC`
--
ALTER TABLE `logistik_batches_BC`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logistik_fakturs`
--
ALTER TABLE `logistik_fakturs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logistik_gudangs`
--
ALTER TABLE `logistik_gudangs`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logistik_non_medik_barangs`
--
ALTER TABLE `logistik_non_medik_barangs`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logistik_non_medik_barang_per_gudangs`
--
ALTER TABLE `logistik_non_medik_barang_per_gudangs`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logistik_non_medik_bidangs`
--
ALTER TABLE `logistik_non_medik_bidangs`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logistik_non_medik_distribusis`
--
ALTER TABLE `logistik_non_medik_distribusis`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logistik_non_medik_golongans`
--
ALTER TABLE `logistik_non_medik_golongans`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logistik_non_medik_gudangs`
--
ALTER TABLE `logistik_non_medik_gudangs`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logistik_non_medik_kategoris`
--
ALTER TABLE `logistik_non_medik_kategoris`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logistik_non_medik_kelompoks`
--
ALTER TABLE `logistik_non_medik_kelompoks`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logistik_non_medik_no_pos`
--
ALTER TABLE `logistik_non_medik_no_pos`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logistik_non_medik_penerimaans`
--
ALTER TABLE `logistik_non_medik_penerimaans`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logistik_non_medik_periodes`
--
ALTER TABLE `logistik_non_medik_periodes`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logistik_non_medik_permintaans`
--
ALTER TABLE `logistik_non_medik_permintaans`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logistik_non_medik_pos`
--
ALTER TABLE `logistik_non_medik_pos`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logistik_non_medik_saldo_awals`
--
ALTER TABLE `logistik_non_medik_saldo_awals`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logistik_non_medik_satuans`
--
ALTER TABLE `logistik_non_medik_satuans`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logistik_non_medik_sub_kelompoks`
--
ALTER TABLE `logistik_non_medik_sub_kelompoks`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logistik_non_medik_sub_sub_kelompoks`
--
ALTER TABLE `logistik_non_medik_sub_sub_kelompoks`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logistik_non_medik_supliers`
--
ALTER TABLE `logistik_non_medik_supliers`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logistik_no_batches`
--
ALTER TABLE `logistik_no_batches`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logistik_opnames`
--
ALTER TABLE `logistik_opnames`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logistik_opnames_BC`
--
ALTER TABLE `logistik_opnames_BC`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logistik_pejabat_bendaharas`
--
ALTER TABLE `logistik_pejabat_bendaharas`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logistik_pejabat_pemeriksa`
--
ALTER TABLE `logistik_pejabat_pemeriksa`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logistik_pejabat_pengadaans`
--
ALTER TABLE `logistik_pejabat_pengadaans`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logistik_pemakaians`
--
ALTER TABLE `logistik_pemakaians`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logistik_penerimaans`
--
ALTER TABLE `logistik_penerimaans`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logistik_pengirim_penerimas`
--
ALTER TABLE `logistik_pengirim_penerimas`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logistik_periodes`
--
ALTER TABLE `logistik_periodes`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logistik_permintaans`
--
ALTER TABLE `logistik_permintaans`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logistik_pinjam_obats`
--
ALTER TABLE `logistik_pinjam_obats`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logistik_po`
--
ALTER TABLE `logistik_po`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logistik_saldo_awals`
--
ALTER TABLE `logistik_saldo_awals`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logistik_satkers`
--
ALTER TABLE `logistik_satkers`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logistik_spks`
--
ALTER TABLE `logistik_spks`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logistik_stocks`
--
ALTER TABLE `logistik_stocks`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logistik_stocks_BC`
--
ALTER TABLE `logistik_stocks_BC`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logistik_suppliers`
--
ALTER TABLE `logistik_suppliers`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `log_bridging`
--
ALTER TABLE `log_bridging`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `log_delete_folio`
--
ALTER TABLE `log_delete_folio`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `log_users`
--
ALTER TABLE `log_users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mastergizis`
--
ALTER TABLE `mastergizis`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `masteridrg`
--
ALTER TABLE `masteridrg`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `masteridrg_biaya`
--
ALTER TABLE `masteridrg_biaya`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mastermapping`
--
ALTER TABLE `mastermapping`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mastermapping_biaya`
--
ALTER TABLE `mastermapping_biaya`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `masterobats`
--
ALTER TABLE `masterobats`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mastersplits`
--
ALTER TABLE `mastersplits`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `master_cara_minums`
--
ALTER TABLE `master_cara_minums`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `master_diets`
--
ALTER TABLE `master_diets`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `master_dokter_perujuk`
--
ALTER TABLE `master_dokter_perujuk`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `master_etikets`
--
ALTER TABLE `master_etikets`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `master_licas`
--
ALTER TABLE `master_licas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `master_licas_BCC`
--
ALTER TABLE `master_licas_BCC`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `master_licas_pakets`
--
ALTER TABLE `master_licas_pakets`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `master_ppis`
--
ALTER TABLE `master_ppis`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `master_puskesmas`
--
ALTER TABLE `master_puskesmas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `master_riwayat_kesehatans`
--
ALTER TABLE `master_riwayat_kesehatans`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `metode_bayars`
--
ALTER TABLE `metode_bayars`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `modalities`
--
ALTER TABLE `modalities`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nomorrms`
--
ALTER TABLE `nomorrms`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `no_pos`
--
ALTER TABLE `no_pos`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `obat_antibiotik`
--
ALTER TABLE `obat_antibiotik`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `operasis`
--
ALTER TABLE `operasis`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_lab`
--
ALTER TABLE `order_lab`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_odontograms`
--
ALTER TABLE `order_odontograms`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_radiologi`
--
ALTER TABLE `order_radiologi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pacs_expertise`
--
ALTER TABLE `pacs_expertise`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pacs_order`
--
ALTER TABLE `pacs_order`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pagu_perawatans`
--
ALTER TABLE `pagu_perawatans`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pasiens`
--
ALTER TABLE `pasiens`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pasien_android`
--
ALTER TABLE `pasien_android`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pasien_langsung`
--
ALTER TABLE `pasien_langsung`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pegawais`
--
ALTER TABLE `pegawais`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pekerjaans`
--
ALTER TABLE `pekerjaans`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pembayarans`
--
ALTER TABLE `pembayarans`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pendapatans`
--
ALTER TABLE `pendapatans`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pendapatan_diklats`
--
ALTER TABLE `pendapatan_diklats`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pendapatan_parkirs`
--
ALTER TABLE `pendapatan_parkirs`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pendidikans`
--
ALTER TABLE `pendidikans`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `penerimaan_produks`
--
ALTER TABLE `penerimaan_produks`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `penerimaan_produk_detil`
--
ALTER TABLE `penerimaan_produk_detil`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pengembalian_obats`
--
ALTER TABLE `pengembalian_obats`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pengirim_rujukan`
--
ALTER TABLE `pengirim_rujukan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `penjualanbebas`
--
ALTER TABLE `penjualanbebas`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `penjualandetails`
--
ALTER TABLE `penjualandetails`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `penjualans`
--
ALTER TABLE `penjualans`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `perawatan_icd9s`
--
ALTER TABLE `perawatan_icd9s`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `perawatan_icd9_idrgs`
--
ALTER TABLE `perawatan_icd9_idrgs`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `perawatan_icd10s`
--
ALTER TABLE `perawatan_icd10s`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `perawatan_icd10_idrgs`
--
ALTER TABLE `perawatan_icd10_idrgs`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `perusahaans`
--
ALTER TABLE `perusahaans`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phone_books`
--
ALTER TABLE `phone_books`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `piutangs`
--
ALTER TABLE `piutangs`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `polis`
--
ALTER TABLE `polis`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `politypes`
--
ALTER TABLE `politypes`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posisiberkas`
--
ALTER TABLE `posisiberkas`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `potensi_prb1`
--
ALTER TABLE `potensi_prb1`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ppis`
--
ALTER TABLE `ppis`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ppi_antibiotiks`
--
ALTER TABLE `ppi_antibiotiks`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ppi_faktor_pemakaians`
--
ALTER TABLE `ppi_faktor_pemakaians`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `predictive`
--
ALTER TABLE `predictive`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prognosis`
--
ALTER TABLE `prognosis`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `radiologi_ekspertises`
--
ALTER TABLE `radiologi_ekspertises`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rawatinaps`
--
ALTER TABLE `rawatinaps`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `record_satusehat`
--
ALTER TABLE `record_satusehat`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `registrasis`
--
ALTER TABLE `registrasis`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `registrasis_dummy`
--
ALTER TABLE `registrasis_dummy`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `resep_note`
--
ALTER TABLE `resep_note`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `resep_note_detail`
--
ALTER TABLE `resep_note_detail`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `resume_pasiens`
--
ALTER TABLE `resume_pasiens`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `retur_obat_rusaks`
--
ALTER TABLE `retur_obat_rusaks`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rincian_hasillabs`
--
ALTER TABLE `rincian_hasillabs`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rincian_pengembalian_obats`
--
ALTER TABLE `rincian_pengembalian_obats`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rincian_pinjam_obats`
--
ALTER TABLE `rincian_pinjam_obats`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ris_logs`
--
ALTER TABLE `ris_logs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ris_tindakans`
--
ALTER TABLE `ris_tindakans`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rl_keluarga_berencana`
--
ALTER TABLE `rl_keluarga_berencana`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rstujuanpinjams`
--
ALTER TABLE `rstujuanpinjams`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rujukans`
--
ALTER TABLE `rujukans`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rujukan_obat`
--
ALTER TABLE `rujukan_obat`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `saderek_master_screening`
--
ALTER TABLE `saderek_master_screening`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `saderek_operasi`
--
ALTER TABLE `saderek_operasi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `saderek_poli`
--
ALTER TABLE `saderek_poli`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `saderek_registrasis_dummy`
--
ALTER TABLE `saderek_registrasis_dummy`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `saderek_screening_pasien`
--
ALTER TABLE `saderek_screening_pasien`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `saderek_screening_pasien_detail`
--
ALTER TABLE `saderek_screening_pasien_detail`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `saderek_user_dummy`
--
ALTER TABLE `saderek_user_dummy`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `satuanbelis`
--
ALTER TABLE `satuanbelis`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `satuanjuals`
--
ALTER TABLE `satuanjuals`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `satu_sehat`
--
ALTER TABLE `satu_sehat`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sebabsakits`
--
ALTER TABLE `sebabsakits`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sep_logs`
--
ALTER TABLE `sep_logs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sep_pengajuans`
--
ALTER TABLE `sep_pengajuans`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sep_poli_lanjutans`
--
ALTER TABLE `sep_poli_lanjutans`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sep_rujukan_keluars`
--
ALTER TABLE `sep_rujukan_keluars`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `service_notifs`
--
ALTER TABLE `service_notifs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sipeka`
--
ALTER TABLE `sipeka`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `slideshows`
--
ALTER TABLE `slideshows`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `snomed-ct`
--
ALTER TABLE `snomed-ct`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `snomed-ct-children`
--
ALTER TABLE `snomed-ct-children`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `splits`
--
ALTER TABLE `splits`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `statuses`
--
ALTER TABLE `statuses`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `supliyers`
--
ALTER TABLE `supliyers`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `surat_inaps`
--
ALTER TABLE `surat_inaps`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `surat_izin_pulang`
--
ALTER TABLE `surat_izin_pulang`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tagihans`
--
ALTER TABLE `tagihans`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tahuntarifs`
--
ALTER TABLE `tahuntarifs`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `takaranobat_etikets`
--
ALTER TABLE `takaranobat_etikets`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tanda_tangan_dokumen`
--
ALTER TABLE `tanda_tangan_dokumen`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tarifs`
--
ALTER TABLE `tarifs`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tarif_new_backup`
--
ALTER TABLE `tarif_new_backup`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tarif_old`
--
ALTER TABLE `tarif_old`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `taskid_logs`
--
ALTER TABLE `taskid_logs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tipelayanans`
--
ALTER TABLE `tipelayanans`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaksi_keluars`
--
ALTER TABLE `transaksi_keluars`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transportasi`
--
ALTER TABLE `transportasi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `uang_raciks`
--
ALTER TABLE `uang_raciks`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_sipeka`
--
ALTER TABLE `user_sipeka`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_sipeka_old`
--
ALTER TABLE `user_sipeka_old`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `waktutunggus`
--
ALTER TABLE `waktutunggus`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `beds`
--
ALTER TABLE `beds`
  ADD CONSTRAINT `beds_kamar_id_foreign` FOREIGN KEY (`kamar_id`) REFERENCES `kamars` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `districts`
--
ALTER TABLE `districts`
  ADD CONSTRAINT `districts_regency_id_foreign` FOREIGN KEY (`regency_id`) REFERENCES `regencies` (`id`);

--
-- Constraints for table `folios`
--
ALTER TABLE `folios`
  ADD CONSTRAINT `folios_registrasi_id_foreign` FOREIGN KEY (`registrasi_id`) REFERENCES `registrasis` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `folios_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `hasillabs`
--
ALTER TABLE `hasillabs`
  ADD CONSTRAINT `hasillabs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `histori_statuses`
--
ALTER TABLE `histori_statuses`
  ADD CONSTRAINT `histori_statuses_registrasi_id_foreign` FOREIGN KEY (`registrasi_id`) REFERENCES `registrasis` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `histori_statuses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `hrd_anaks`
--
ALTER TABLE `hrd_anaks`
  ADD CONSTRAINT `hrd_anaks_biodata_id_foreign` FOREIGN KEY (`biodata_id`) REFERENCES `hrd_biodatas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `hrd_anaks_pekerjaan_id_foreign` FOREIGN KEY (`pekerjaan_id`) REFERENCES `pekerjaans` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `hrd_anaks_pendidikan_id_foreign` FOREIGN KEY (`pendidikan_id`) REFERENCES `pendidikans` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `hrd_biodatas`
--
ALTER TABLE `hrd_biodatas`
  ADD CONSTRAINT `hrd_biodatas_agama_id_foreign` FOREIGN KEY (`agama_id`) REFERENCES `agamas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `hrd_cutis`
--
ALTER TABLE `hrd_cutis`
  ADD CONSTRAINT `hrd_cutis_biodata_id_foreign` FOREIGN KEY (`biodata_id`) REFERENCES `hrd_biodatas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `hrd_disiplin_pegawais`
--
ALTER TABLE `hrd_disiplin_pegawais`
  ADD CONSTRAINT `hrd_disiplin_pegawais_biodata_id_foreign` FOREIGN KEY (`biodata_id`) REFERENCES `hrd_biodatas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `hrd_gaji_berkalas`
--
ALTER TABLE `hrd_gaji_berkalas`
  ADD CONSTRAINT `hrd_gaji_berkalas_biodata_id_foreign` FOREIGN KEY (`biodata_id`) REFERENCES `hrd_biodatas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `hrd_ijin_belajars`
--
ALTER TABLE `hrd_ijin_belajars`
  ADD CONSTRAINT `hrd_ijin_belajars_biodata_id_foreign` FOREIGN KEY (`biodata_id`) REFERENCES `hrd_biodatas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `hrd_jabatans`
--
ALTER TABLE `hrd_jabatans`
  ADD CONSTRAINT `hrd_jabatans_biodata_id_foreign` FOREIGN KEY (`biodata_id`) REFERENCES `hrd_biodatas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `hrd_keluargas`
--
ALTER TABLE `hrd_keluargas`
  ADD CONSTRAINT `hrd_keluargas_biodata_id_foreign` FOREIGN KEY (`biodata_id`) REFERENCES `hrd_biodatas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `hrd_keluargas_pekerjaanayah_id_foreign` FOREIGN KEY (`pekerjaanayah_id`) REFERENCES `pekerjaans` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `hrd_keluargas_pekerjaanpasangan_id_foreign` FOREIGN KEY (`pekerjaanpasangan_id`) REFERENCES `pekerjaans` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `hrd_keluargas_pendidikan_id_foreign` FOREIGN KEY (`pendidikan_id`) REFERENCES `pendidikans` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `hrd_kepangkatans`
--
ALTER TABLE `hrd_kepangkatans`
  ADD CONSTRAINT `hrd_kepangkatans_biodata_id_foreign` FOREIGN KEY (`biodata_id`) REFERENCES `hrd_biodatas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `hrd_pendidikan_formals`
--
ALTER TABLE `hrd_pendidikan_formals`
  ADD CONSTRAINT `hrd_pendidikan_formals_biodata_id_foreign` FOREIGN KEY (`biodata_id`) REFERENCES `hrd_biodatas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `hrd_pendidikan_formals_pendidikan_id_foreign` FOREIGN KEY (`pendidikan_id`) REFERENCES `pendidikans` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `hrd_penghargaans`
--
ALTER TABLE `hrd_penghargaans`
  ADD CONSTRAINT `hrd_penghargaans_biodata_id_foreign` FOREIGN KEY (`biodata_id`) REFERENCES `hrd_biodatas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `hrd_perubahan_gapoks`
--
ALTER TABLE `hrd_perubahan_gapoks`
  ADD CONSTRAINT `hrd_perubahan_gapoks_biodata_id_foreign` FOREIGN KEY (`biodata_id`) REFERENCES `hrd_biodatas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kamars`
--
ALTER TABLE `kamars`
  ADD CONSTRAINT `kamars_kelas_id_foreign` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `kategoritarifs`
--
ALTER TABLE `kategoritarifs`
  ADD CONSTRAINT `kategoritarifs_kategoriheader_id_foreign` FOREIGN KEY (`kategoriheader_id`) REFERENCES `kategoriheaders` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `labkategoris`
--
ALTER TABLE `labkategoris`
  ADD CONSTRAINT `labkategoris_labsection_id_foreign` FOREIGN KEY (`labsection_id`) REFERENCES `labsections` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `laboratoria`
--
ALTER TABLE `laboratoria`
  ADD CONSTRAINT `laboratoria_labkategori_id_foreign` FOREIGN KEY (`labkategori_id`) REFERENCES `labkategoris` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mastersplits`
--
ALTER TABLE `mastersplits`
  ADD CONSTRAINT `mastersplits_kategoriheader_id_foreign` FOREIGN KEY (`kategoriheader_id`) REFERENCES `kategoriheaders` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `mastersplits_tahuntarif_id_foreign` FOREIGN KEY (`tahuntarif_id`) REFERENCES `tahuntarifs` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `pembayarans`
--
ALTER TABLE `pembayarans`
  ADD CONSTRAINT `pembayarans_registrasi_id_foreign` FOREIGN KEY (`registrasi_id`) REFERENCES `registrasis` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pembayarans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `penjualandetails`
--
ALTER TABLE `penjualandetails`
  ADD CONSTRAINT `penjualandetails_masterobat_id_foreign` FOREIGN KEY (`masterobat_id`) REFERENCES `masterobats` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `penjualandetails_penjualan_id_foreign` FOREIGN KEY (`penjualan_id`) REFERENCES `penjualans` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `penjualans`
--
ALTER TABLE `penjualans`
  ADD CONSTRAINT `penjualans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `permission_user`
--
ALTER TABLE `permission_user`
  ADD CONSTRAINT `permission_user_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `regencies`
--
ALTER TABLE `regencies`
  ADD CONSTRAINT `regencies_province_id_foreign` FOREIGN KEY (`province_id`) REFERENCES `provinces` (`id`);

--
-- Constraints for table `registrasis`
--
ALTER TABLE `registrasis`
  ADD CONSTRAINT `registrasis_instalasi_id_foreign` FOREIGN KEY (`instalasi_id`) REFERENCES `instalasis` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `registrasis_kelas_id_foreign` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `registrasis_perusahaan_id_foreign` FOREIGN KEY (`perusahaan_id`) REFERENCES `perusahaans` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `registrasis_sebabsakit_id_foreign` FOREIGN KEY (`sebabsakit_id`) REFERENCES `sebabsakits` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `registrasis_user_create_foreign` FOREIGN KEY (`user_create`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `rincian_hasillabs`
--
ALTER TABLE `rincian_hasillabs`
  ADD CONSTRAINT `rincian_hasillabs_hasillab_id_foreign` FOREIGN KEY (`hasillab_id`) REFERENCES `hasillabs` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `rincian_hasillabs_labkategori_id_foreign` FOREIGN KEY (`labkategori_id`) REFERENCES `labkategoris` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `rincian_hasillabs_laboratoria_id_foreign` FOREIGN KEY (`laboratoria_id`) REFERENCES `laboratoria` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `rincian_hasillabs_labsection_id_foreign` FOREIGN KEY (`labsection_id`) REFERENCES `labsections` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `rincian_hasillabs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `splits`
--
ALTER TABLE `splits`
  ADD CONSTRAINT `splits_kategoriheader_id_foreign` FOREIGN KEY (`kategoriheader_id`) REFERENCES `kategoriheaders` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `splits_tahuntarif_id_foreign` FOREIGN KEY (`tahuntarif_id`) REFERENCES `tahuntarifs` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `splits_tarif_id_foreign` FOREIGN KEY (`tarif_id`) REFERENCES `tarif_old` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `tagihans`
--
ALTER TABLE `tagihans`
  ADD CONSTRAINT `tagihans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `villages`
--
ALTER TABLE `villages`
  ADD CONSTRAINT `villages_district_id_foreign` FOREIGN KEY (`district_id`) REFERENCES `districts` (`id`);

--
-- Constraints for table `waktutunggus`
--
ALTER TABLE `waktutunggus`
  ADD CONSTRAINT `waktutunggus_registrasi_id_foreign` FOREIGN KEY (`registrasi_id`) REFERENCES `registrasis` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

