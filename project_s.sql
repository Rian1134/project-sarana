-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 02 Sep 2026 pada 03.56
-- Versi server: 8.0.30
-- Versi PHP: 8.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHAc:\Users\USER\Downloads\project_s.sqlRACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Basis data: `project_s`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `air_bersihs`
--

CREATE TABLE `air_bersihs` (
  `id` bigint UNSIGNED NOT NULL,
  `ada/tidak_ada` enum('ada','tidak_ada') COLLATE utf8mb4_unicode_ci NOT NULL,
  `kodisi` enum('baik','rusak','nihil') COLLATE utf8mb4_unicode_ci NOT NULL,
  `sarana_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jumlah_rombels`
--

CREATE TABLE `jumlah_rombels` (
  `id` bigint UNSIGNED NOT NULL,
  `vii` int NOT NULL DEFAULT '0',
  `viii` int NOT NULL DEFAULT '0',
  `ix` int NOT NULL DEFAULT '0',
  `sarana_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jumlah_siswas`
--

CREATE TABLE `jumlah_siswas` (
  `id` bigint UNSIGNED NOT NULL,
  `vii` int NOT NULL DEFAULT '0',
  `viii` int NOT NULL DEFAULT '0',
  `ix` int NOT NULL DEFAULT '0',
  `sarana_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `komputers`
--

CREATE TABLE `komputers` (
  `id` bigint UNSIGNED NOT NULL,
  `baik` int NOT NULL DEFAULT '0',
  `rusak` int NOT NULL DEFAULT '0',
  `sarana_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kursi_gurus`
--

CREATE TABLE `kursi_gurus` (
  `id` bigint UNSIGNED NOT NULL,
  `baik` int NOT NULL DEFAULT '0',
  `rusak` int NOT NULL DEFAULT '0',
  `sarana_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kursi_siswas`
--

CREATE TABLE `kursi_siswas` (
  `id` bigint UNSIGNED NOT NULL,
  `baik` int NOT NULL DEFAULT '0',
  `rusak` int NOT NULL DEFAULT '0',
  `sarana_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `lab_ipas`
--

CREATE TABLE `lab_ipas` (
  `id` bigint UNSIGNED NOT NULL,
  `ada/tidak_ada` enum('ada','tidak_ada') COLLATE utf8mb4_unicode_ci NOT NULL,
  `kodisi` enum('baik','rusak','nihil') COLLATE utf8mb4_unicode_ci NOT NULL,
  `sarana_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `lab_komputers`
--

CREATE TABLE `lab_komputers` (
  `id` bigint UNSIGNED NOT NULL,
  `ada/tidak_ada` enum('ada','tidak_ada') COLLATE utf8mb4_unicode_ci NOT NULL,
  `kodisi` enum('baik','rusak','nihil') COLLATE utf8mb4_unicode_ci NOT NULL,
  `sarana_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `lapangan_sekolahs`
--

CREATE TABLE `lapangan_sekolahs` (
  `id` bigint UNSIGNED NOT NULL,
  `ada/tidak_ada` enum('ada','tidak_ada') COLLATE utf8mb4_unicode_ci NOT NULL,
  `kodisi` enum('baik','rusak','nihil') COLLATE utf8mb4_unicode_ci NOT NULL,
  `sarana_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `laptops`
--

CREATE TABLE `laptops` (
  `id` bigint UNSIGNED NOT NULL,
  `baik` int NOT NULL DEFAULT '0',
  `rusak` int NOT NULL DEFAULT '0',
  `sarana_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `meja_gurus`
--

CREATE TABLE `meja_gurus` (
  `id` bigint UNSIGNED NOT NULL,
  `baik` int NOT NULL DEFAULT '0',
  `rusak` int NOT NULL DEFAULT '0',
  `sarana_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `meja_siswas`
--

CREATE TABLE `meja_siswas` (
  `id` bigint UNSIGNED NOT NULL,
  `baik` int NOT NULL DEFAULT '0',
  `rusak` int NOT NULL DEFAULT '0',
  `sarana_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_07_28_040000_create_all_sarana_tables', 1),
(5, '2026_07_28_050400_add_tahun_to_rkb_rehabilitasi_tables', 1),
(6, '2026_07_28_050500_create_periode_laporans_table', 1),
(7, '2026_07_28_050501_drop_tahun_from_rkb_rehabilitasi_tables', 1),
(8, '2026_08_02_080445_create_permission_tables', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pagar_sekolahs`
--

CREATE TABLE `pagar_sekolahs` (
  `id` bigint UNSIGNED NOT NULL,
  `ada/tidak_ada` enum('ada','tidak_ada') COLLATE utf8mb4_unicode_ci NOT NULL,
  `kodisi` enum('baik','rusak','nihil') COLLATE utf8mb4_unicode_ci NOT NULL,
  `sarana_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `periode_laporans`
--

CREATE TABLE `periode_laporans` (
  `id` bigint UNSIGNED NOT NULL,
  `kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahun_awal` int NOT NULL,
  `tahun_akhir` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `periode_laporans`
--

INSERT INTO `periode_laporans` (`id`, `kategori`, `tahun_awal`, `tahun_akhir`, `created_at`, `updated_at`) VALUES
(1, 'rkb', 2026, 2030, '2026-09-01 20:54:32', '2026-09-01 20:54:32'),
(2, 'rehabilitasi', 2026, 2030, '2026-09-01 20:54:32', '2026-09-01 20:54:32');

-- --------------------------------------------------------

--
-- Struktur dari tabel `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'view-sarana', 'web', '2026-09-01 20:54:32', '2026-09-01 20:54:32'),
(2, 'create-sarana', 'web', '2026-09-01 20:54:32', '2026-09-01 20:54:32'),
(3, 'show-sarana', 'web', '2026-09-01 20:54:32', '2026-09-01 20:54:32'),
(4, 'edit-sarana', 'web', '2026-09-01 20:54:32', '2026-09-01 20:54:32'),
(5, 'delete-sarana', 'web', '2026-09-01 20:54:32', '2026-09-01 20:54:32'),
(6, 'view-user', 'web', '2026-09-01 20:54:32', '2026-09-01 20:54:32'),
(7, 'create-user', 'web', '2026-09-01 20:54:32', '2026-09-01 20:54:32'),
(8, 'show-user', 'web', '2026-09-01 20:54:32', '2026-09-01 20:54:32'),
(9, 'edit-user', 'web', '2026-09-01 20:54:32', '2026-09-01 20:54:32'),
(10, 'delete-user', 'web', '2026-09-01 20:54:32', '2026-09-01 20:54:32');

-- --------------------------------------------------------

--
-- Struktur dari tabel `rehabilitasi_ruang_kelas`
--

CREATE TABLE `rehabilitasi_ruang_kelas` (
  `id` bigint UNSIGNED NOT NULL,
  `jumlah` int NOT NULL DEFAULT '0',
  `sarana_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'web', '2026-09-01 20:54:32', '2026-09-01 20:54:32'),
(2, 'user', 'web', '2026-09-01 20:54:32', '2026-09-01 20:54:32');

-- --------------------------------------------------------

--
-- Struktur dari tabel `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(9, 1),
(10, 1),
(2, 2),
(3, 2),
(4, 2),
(5, 2),
(7, 2),
(8, 2),
(9, 2),
(10, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `ruang_gurus`
--

CREATE TABLE `ruang_gurus` (
  `id` bigint UNSIGNED NOT NULL,
  `ada/tidak_ada` enum('ada','tidak_ada') COLLATE utf8mb4_unicode_ci NOT NULL,
  `kodisi` enum('baik','rusak','nihil') COLLATE utf8mb4_unicode_ci NOT NULL,
  `sarana_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `ruang_kantor_tus`
--

CREATE TABLE `ruang_kantor_tus` (
  `id` bigint UNSIGNED NOT NULL,
  `ada/tidak_ada` enum('ada','tidak_ada') COLLATE utf8mb4_unicode_ci NOT NULL,
  `kodisi` enum('baik','rusak','nihil') COLLATE utf8mb4_unicode_ci NOT NULL,
  `sarana_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `ruang_kelas`
--

CREATE TABLE `ruang_kelas` (
  `id` bigint UNSIGNED NOT NULL,
  `baik` int NOT NULL DEFAULT '0',
  `rusak` int NOT NULL DEFAULT '0',
  `sarana_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `ruang_kelas_barus`
--

CREATE TABLE `ruang_kelas_barus` (
  `id` bigint UNSIGNED NOT NULL,
  `jumlah` int NOT NULL DEFAULT '0',
  `sarana_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `ruang_kepala_sekolahs`
--

CREATE TABLE `ruang_kepala_sekolahs` (
  `id` bigint UNSIGNED NOT NULL,
  `ada/tidak_ada` enum('ada','tidak_ada') COLLATE utf8mb4_unicode_ci NOT NULL,
  `kodisi` enum('baik','rusak','nihil') COLLATE utf8mb4_unicode_ci NOT NULL,
  `sarana_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `ruang_perpustakaans`
--

CREATE TABLE `ruang_perpustakaans` (
  `id` bigint UNSIGNED NOT NULL,
  `ada/tidak_ada` enum('ada','tidak_ada') COLLATE utf8mb4_unicode_ci NOT NULL,
  `kodisi` enum('baik','rusak','nihil') COLLATE utf8mb4_unicode_ci NOT NULL,
  `sarana_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `rumah_dinas`
--

CREATE TABLE `rumah_dinas` (
  `id` bigint UNSIGNED NOT NULL,
  `ada/tidak_ada` enum('ada','tidak_ada') COLLATE utf8mb4_unicode_ci NOT NULL,
  `kodisi` enum('baik','rusak','nihil') COLLATE utf8mb4_unicode_ci NOT NULL,
  `sarana_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `rumah_ibadahs`
--

CREATE TABLE `rumah_ibadahs` (
  `id` bigint UNSIGNED NOT NULL,
  `ada/tidak_ada` enum('ada','tidak_ada') COLLATE utf8mb4_unicode_ci NOT NULL,
  `kodisi` enum('baik','rusak','nihil') COLLATE utf8mb4_unicode_ci NOT NULL,
  `sarana_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `saranas`
--

CREATE TABLE `saranas` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_sekolah` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `NPSN` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat_sekolah` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_kepala_sekolah` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `NIP` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_hp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `toilet_gurus`
--

CREATE TABLE `toilet_gurus` (
  `id` bigint UNSIGNED NOT NULL,
  `baik` int NOT NULL DEFAULT '0',
  `rusak` int NOT NULL DEFAULT '0',
  `sarana_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `toilet_siswas`
--

CREATE TABLE `toilet_siswas` (
  `id` bigint UNSIGNED NOT NULL,
  `baik` int NOT NULL DEFAULT '0',
  `rusak` int NOT NULL DEFAULT '0',
  `sarana_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `unit_kesehatan_sekolahs`
--

CREATE TABLE `unit_kesehatan_sekolahs` (
  `id` bigint UNSIGNED NOT NULL,
  `ada/tidak_ada` enum('ada','tidak_ada') COLLATE utf8mb4_unicode_ci NOT NULL,
  `kodisi` enum('baik','rusak','nihil') COLLATE utf8mb4_unicode_ci NOT NULL,
  `sarana_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
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
-- Indeks untuk tabel yang dibuang
--

--
-- Indeks untuk tabel `air_bersihs`
--
ALTER TABLE `air_bersihs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `air_bersihs_sarana_id_foreign` (`sarana_id`);

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  ADD KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jumlah_rombels`
--
ALTER TABLE `jumlah_rombels`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jumlah_rombels_sarana_id_foreign` (`sarana_id`);

--
-- Indeks untuk tabel `jumlah_siswas`
--
ALTER TABLE `jumlah_siswas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jumlah_siswas_sarana_id_foreign` (`sarana_id`);

--
-- Indeks untuk tabel `komputers`
--
ALTER TABLE `komputers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `komputers_sarana_id_foreign` (`sarana_id`);

--
-- Indeks untuk tabel `kursi_gurus`
--
ALTER TABLE `kursi_gurus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kursi_gurus_sarana_id_foreign` (`sarana_id`);

--
-- Indeks untuk tabel `kursi_siswas`
--
ALTER TABLE `kursi_siswas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kursi_siswas_sarana_id_foreign` (`sarana_id`);

--
-- Indeks untuk tabel `lab_ipas`
--
ALTER TABLE `lab_ipas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lab_ipas_sarana_id_foreign` (`sarana_id`);

--
-- Indeks untuk tabel `lab_komputers`
--
ALTER TABLE `lab_komputers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lab_komputers_sarana_id_foreign` (`sarana_id`);

--
-- Indeks untuk tabel `lapangan_sekolahs`
--
ALTER TABLE `lapangan_sekolahs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lapangan_sekolahs_sarana_id_foreign` (`sarana_id`);

--
-- Indeks untuk tabel `laptops`
--
ALTER TABLE `laptops`
  ADD PRIMARY KEY (`id`),
  ADD KEY `laptops_sarana_id_foreign` (`sarana_id`);

--
-- Indeks untuk tabel `meja_gurus`
--
ALTER TABLE `meja_gurus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `meja_gurus_sarana_id_foreign` (`sarana_id`);

--
-- Indeks untuk tabel `meja_siswas`
--
ALTER TABLE `meja_siswas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `meja_siswas_sarana_id_foreign` (`sarana_id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indeks untuk tabel `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indeks untuk tabel `pagar_sekolahs`
--
ALTER TABLE `pagar_sekolahs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pagar_sekolahs_sarana_id_foreign` (`sarana_id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `periode_laporans`
--
ALTER TABLE `periode_laporans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `periode_laporans_kategori_unique` (`kategori`);

--
-- Indeks untuk tabel `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indeks untuk tabel `rehabilitasi_ruang_kelas`
--
ALTER TABLE `rehabilitasi_ruang_kelas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rehabilitasi_ruang_kelas_sarana_id_foreign` (`sarana_id`);

--
-- Indeks untuk tabel `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indeks untuk tabel `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indeks untuk tabel `ruang_gurus`
--
ALTER TABLE `ruang_gurus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ruang_gurus_sarana_id_foreign` (`sarana_id`);

--
-- Indeks untuk tabel `ruang_kantor_tus`
--
ALTER TABLE `ruang_kantor_tus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ruang_kantor_tus_sarana_id_foreign` (`sarana_id`);

--
-- Indeks untuk tabel `ruang_kelas`
--
ALTER TABLE `ruang_kelas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ruang_kelas_sarana_id_foreign` (`sarana_id`);

--
-- Indeks untuk tabel `ruang_kelas_barus`
--
ALTER TABLE `ruang_kelas_barus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ruang_kelas_barus_sarana_id_foreign` (`sarana_id`);

--
-- Indeks untuk tabel `ruang_kepala_sekolahs`
--
ALTER TABLE `ruang_kepala_sekolahs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ruang_kepala_sekolahs_sarana_id_foreign` (`sarana_id`);

--
-- Indeks untuk tabel `ruang_perpustakaans`
--
ALTER TABLE `ruang_perpustakaans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ruang_perpustakaans_sarana_id_foreign` (`sarana_id`);

--
-- Indeks untuk tabel `rumah_dinas`
--
ALTER TABLE `rumah_dinas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rumah_dinas_sarana_id_foreign` (`sarana_id`);

--
-- Indeks untuk tabel `rumah_ibadahs`
--
ALTER TABLE `rumah_ibadahs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rumah_ibadahs_sarana_id_foreign` (`sarana_id`);

--
-- Indeks untuk tabel `saranas`
--
ALTER TABLE `saranas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `saranas_npsn_unique` (`NPSN`),
  ADD UNIQUE KEY `saranas_nip_unique` (`NIP`),
  ADD UNIQUE KEY `saranas_nomor_hp_unique` (`nomor_hp`),
  ADD KEY `saranas_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `toilet_gurus`
--
ALTER TABLE `toilet_gurus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `toilet_gurus_sarana_id_foreign` (`sarana_id`);

--
-- Indeks untuk tabel `toilet_siswas`
--
ALTER TABLE `toilet_siswas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `toilet_siswas_sarana_id_foreign` (`sarana_id`);

--
-- Indeks untuk tabel `unit_kesehatan_sekolahs`
--
ALTER TABLE `unit_kesehatan_sekolahs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `unit_kesehatan_sekolahs_sarana_id_foreign` (`sarana_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `air_bersihs`
--
ALTER TABLE `air_bersihs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jumlah_rombels`
--
ALTER TABLE `jumlah_rombels`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jumlah_siswas`
--
ALTER TABLE `jumlah_siswas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `komputers`
--
ALTER TABLE `komputers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `kursi_gurus`
--
ALTER TABLE `kursi_gurus`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `kursi_siswas`
--
ALTER TABLE `kursi_siswas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `lab_ipas`
--
ALTER TABLE `lab_ipas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `lab_komputers`
--
ALTER TABLE `lab_komputers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `lapangan_sekolahs`
--
ALTER TABLE `lapangan_sekolahs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `laptops`
--
ALTER TABLE `laptops`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `meja_gurus`
--
ALTER TABLE `meja_gurus`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `meja_siswas`
--
ALTER TABLE `meja_siswas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `pagar_sekolahs`
--
ALTER TABLE `pagar_sekolahs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `periode_laporans`
--
ALTER TABLE `periode_laporans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `rehabilitasi_ruang_kelas`
--
ALTER TABLE `rehabilitasi_ruang_kelas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `ruang_gurus`
--
ALTER TABLE `ruang_gurus`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `ruang_kantor_tus`
--
ALTER TABLE `ruang_kantor_tus`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `ruang_kelas`
--
ALTER TABLE `ruang_kelas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `ruang_kelas_barus`
--
ALTER TABLE `ruang_kelas_barus`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `ruang_kepala_sekolahs`
--
ALTER TABLE `ruang_kepala_sekolahs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `ruang_perpustakaans`
--
ALTER TABLE `ruang_perpustakaans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `rumah_dinas`
--
ALTER TABLE `rumah_dinas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `rumah_ibadahs`
--
ALTER TABLE `rumah_ibadahs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `saranas`
--
ALTER TABLE `saranas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `toilet_gurus`
--
ALTER TABLE `toilet_gurus`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `toilet_siswas`
--
ALTER TABLE `toilet_siswas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `unit_kesehatan_sekolahs`
--
ALTER TABLE `unit_kesehatan_sekolahs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `air_bersihs`
--
ALTER TABLE `air_bersihs`
  ADD CONSTRAINT `air_bersihs_sarana_id_foreign` FOREIGN KEY (`sarana_id`) REFERENCES `saranas` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `jumlah_rombels`
--
ALTER TABLE `jumlah_rombels`
  ADD CONSTRAINT `jumlah_rombels_sarana_id_foreign` FOREIGN KEY (`sarana_id`) REFERENCES `saranas` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `jumlah_siswas`
--
ALTER TABLE `jumlah_siswas`
  ADD CONSTRAINT `jumlah_siswas_sarana_id_foreign` FOREIGN KEY (`sarana_id`) REFERENCES `saranas` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `komputers`
--
ALTER TABLE `komputers`
  ADD CONSTRAINT `komputers_sarana_id_foreign` FOREIGN KEY (`sarana_id`) REFERENCES `saranas` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `kursi_gurus`
--
ALTER TABLE `kursi_gurus`
  ADD CONSTRAINT `kursi_gurus_sarana_id_foreign` FOREIGN KEY (`sarana_id`) REFERENCES `saranas` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `kursi_siswas`
--
ALTER TABLE `kursi_siswas`
  ADD CONSTRAINT `kursi_siswas_sarana_id_foreign` FOREIGN KEY (`sarana_id`) REFERENCES `saranas` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `lab_ipas`
--
ALTER TABLE `lab_ipas`
  ADD CONSTRAINT `lab_ipas_sarana_id_foreign` FOREIGN KEY (`sarana_id`) REFERENCES `saranas` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `lab_komputers`
--
ALTER TABLE `lab_komputers`
  ADD CONSTRAINT `lab_komputers_sarana_id_foreign` FOREIGN KEY (`sarana_id`) REFERENCES `saranas` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `lapangan_sekolahs`
--
ALTER TABLE `lapangan_sekolahs`
  ADD CONSTRAINT `lapangan_sekolahs_sarana_id_foreign` FOREIGN KEY (`sarana_id`) REFERENCES `saranas` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `laptops`
--
ALTER TABLE `laptops`
  ADD CONSTRAINT `laptops_sarana_id_foreign` FOREIGN KEY (`sarana_id`) REFERENCES `saranas` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `meja_gurus`
--
ALTER TABLE `meja_gurus`
  ADD CONSTRAINT `meja_gurus_sarana_id_foreign` FOREIGN KEY (`sarana_id`) REFERENCES `saranas` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `meja_siswas`
--
ALTER TABLE `meja_siswas`
  ADD CONSTRAINT `meja_siswas_sarana_id_foreign` FOREIGN KEY (`sarana_id`) REFERENCES `saranas` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pagar_sekolahs`
--
ALTER TABLE `pagar_sekolahs`
  ADD CONSTRAINT `pagar_sekolahs_sarana_id_foreign` FOREIGN KEY (`sarana_id`) REFERENCES `saranas` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `rehabilitasi_ruang_kelas`
--
ALTER TABLE `rehabilitasi_ruang_kelas`
  ADD CONSTRAINT `rehabilitasi_ruang_kelas_sarana_id_foreign` FOREIGN KEY (`sarana_id`) REFERENCES `saranas` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `ruang_gurus`
--
ALTER TABLE `ruang_gurus`
  ADD CONSTRAINT `ruang_gurus_sarana_id_foreign` FOREIGN KEY (`sarana_id`) REFERENCES `saranas` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `ruang_kantor_tus`
--
ALTER TABLE `ruang_kantor_tus`
  ADD CONSTRAINT `ruang_kantor_tus_sarana_id_foreign` FOREIGN KEY (`sarana_id`) REFERENCES `saranas` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `ruang_kelas`
--
ALTER TABLE `ruang_kelas`
  ADD CONSTRAINT `ruang_kelas_sarana_id_foreign` FOREIGN KEY (`sarana_id`) REFERENCES `saranas` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `ruang_kelas_barus`
--
ALTER TABLE `ruang_kelas_barus`
  ADD CONSTRAINT `ruang_kelas_barus_sarana_id_foreign` FOREIGN KEY (`sarana_id`) REFERENCES `saranas` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `ruang_kepala_sekolahs`
--
ALTER TABLE `ruang_kepala_sekolahs`
  ADD CONSTRAINT `ruang_kepala_sekolahs_sarana_id_foreign` FOREIGN KEY (`sarana_id`) REFERENCES `saranas` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `ruang_perpustakaans`
--
ALTER TABLE `ruang_perpustakaans`
  ADD CONSTRAINT `ruang_perpustakaans_sarana_id_foreign` FOREIGN KEY (`sarana_id`) REFERENCES `saranas` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `rumah_dinas`
--
ALTER TABLE `rumah_dinas`
  ADD CONSTRAINT `rumah_dinas_sarana_id_foreign` FOREIGN KEY (`sarana_id`) REFERENCES `saranas` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `rumah_ibadahs`
--
ALTER TABLE `rumah_ibadahs`
  ADD CONSTRAINT `rumah_ibadahs_sarana_id_foreign` FOREIGN KEY (`sarana_id`) REFERENCES `saranas` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `saranas`
--
ALTER TABLE `saranas`
  ADD CONSTRAINT `saranas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `toilet_gurus`
--
ALTER TABLE `toilet_gurus`
  ADD CONSTRAINT `toilet_gurus_sarana_id_foreign` FOREIGN KEY (`sarana_id`) REFERENCES `saranas` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `toilet_siswas`
--
ALTER TABLE `toilet_siswas`
  ADD CONSTRAINT `toilet_siswas_sarana_id_foreign` FOREIGN KEY (`sarana_id`) REFERENCES `saranas` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `unit_kesehatan_sekolahs`
--
ALTER TABLE `unit_kesehatan_sekolahs`
  ADD CONSTRAINT `unit_kesehatan_sekolahs_sarana_id_foreign` FOREIGN KEY (`sarana_id`) REFERENCES `saranas` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
