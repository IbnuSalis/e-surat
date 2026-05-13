-- ============================================================
-- E-Surat — Sistem Informasi Manajemen Surat Desa
-- Database Schema + Seed Data
-- Laravel 12 | PHP 8.2 | MySQL 8.0
-- ============================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;
SET time_zone = '+07:00';

-- Create database
CREATE DATABASE IF NOT EXISTS `e_surat`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `e_surat`;

-- ============================================================
-- TABLE: migrations
-- ============================================================
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- TABLE: users
-- ============================================================
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id`                bigint unsigned NOT NULL AUTO_INCREMENT,
  `name`              varchar(255) NOT NULL,
  `email`             varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password`          varchar(255) NOT NULL,
  `role`              enum('admin','staff') NOT NULL DEFAULT 'staff',
  `status`            enum('active','inactive') NOT NULL DEFAULT 'active',
  `phone`             varchar(20) DEFAULT NULL,
  `jabatan`           varchar(100) DEFAULT NULL,
  `foto`              varchar(255) DEFAULT NULL,
  `last_login_at`     timestamp NULL DEFAULT NULL,
  `remember_token`    varchar(100) DEFAULT NULL,
  `created_at`        timestamp NULL DEFAULT NULL,
  `updated_at`        timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- TABLE: password_reset_tokens
-- ============================================================
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email`      varchar(255) NOT NULL,
  `token`      varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- TABLE: sessions
-- ============================================================
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id`            varchar(255) NOT NULL,
  `user_id`       bigint unsigned DEFAULT NULL,
  `ip_address`    varchar(45) DEFAULT NULL,
  `user_agent`    text,
  `payload`       longtext NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- TABLE: cache
-- ============================================================
DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key`        varchar(255) NOT NULL,
  `value`      mediumtext NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- TABLE: jobs (queue)
-- ============================================================
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id`           bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue`        varchar(255) NOT NULL,
  `payload`      longtext NOT NULL,
  `attempts`     tinyint unsigned NOT NULL,
  `reserved_at`  int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at`   int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- TABLE: surats
-- ============================================================
DROP TABLE IF EXISTS `surats`;
CREATE TABLE `surats` (
  `id`            bigint unsigned NOT NULL AUTO_INCREMENT,
  `kode_surat`    varchar(50) NOT NULL,
  `nama_surat`    varchar(255) NOT NULL,
  `jenis_surat`   enum('masuk','keluar') NOT NULL,
  `kategori`      enum('umum','penting','rahasia') NOT NULL DEFAULT 'umum',
  `tanggal_surat` date NOT NULL,
  `file_path`     varchar(255) DEFAULT NULL,
  `file_name`     varchar(255) DEFAULT NULL,
  `file_size`     bigint unsigned DEFAULT NULL,
  `file_type`     varchar(100) DEFAULT NULL,
  `keterangan`    text DEFAULT NULL,
  `status`        enum('aktif','arsip') NOT NULL DEFAULT 'aktif',
  `created_by`    bigint unsigned NOT NULL,
  `deleted_at`    timestamp NULL DEFAULT NULL,
  `created_at`    timestamp NULL DEFAULT NULL,
  `updated_at`    timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `surats_kode_surat_unique` (`kode_surat`),
  KEY `surats_created_by_foreign` (`created_by`),
  KEY `surats_jenis_surat_index` (`jenis_surat`),
  KEY `surats_kategori_index` (`kategori`),
  CONSTRAINT `surats_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- TABLE: agenda
-- ============================================================
DROP TABLE IF EXISTS `agenda`;
CREATE TABLE `agenda` (
  `id`                bigint unsigned NOT NULL AUTO_INCREMENT,
  `judul`             varchar(255) NOT NULL,
  `deskripsi`         text DEFAULT NULL,
  `tanggal_mulai`     datetime NOT NULL,
  `tanggal_selesai`   datetime DEFAULT NULL,
  `lokasi`            varchar(255) DEFAULT NULL,
  `penanggung_jawab`  varchar(100) DEFAULT NULL,
  `status`            enum('upcoming','ongoing','completed','cancelled') NOT NULL DEFAULT 'upcoming',
  `warna`             varchar(20) NOT NULL DEFAULT '#002147',
  `created_by`        bigint unsigned NOT NULL,
  `created_at`        timestamp NULL DEFAULT NULL,
  `updated_at`        timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `agenda_created_by_foreign` (`created_by`),
  KEY `agenda_tanggal_mulai_index` (`tanggal_mulai`),
  CONSTRAINT `agenda_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- TABLE: berita_acara
-- ============================================================
DROP TABLE IF EXISTS `berita_acara`;
CREATE TABLE `berita_acara` (
  `id`         bigint unsigned NOT NULL AUTO_INCREMENT,
  `nomor`      varchar(100) NOT NULL,
  `judul`      varchar(255) NOT NULL,
  `tanggal`    date NOT NULL,
  `lokasi`     varchar(255) DEFAULT NULL,
  `isi`        text NOT NULL,
  `peserta`    text DEFAULT NULL,
  `status`     enum('draft','final','approved') NOT NULL DEFAULT 'draft',
  `file_path`  varchar(255) DEFAULT NULL,
  `created_by` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `berita_acara_nomor_unique` (`nomor`),
  KEY `berita_acara_created_by_foreign` (`created_by`),
  CONSTRAINT `berita_acara_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- TABLE: log_aktivitas
-- ============================================================
DROP TABLE IF EXISTS `log_aktivitas`;
CREATE TABLE `log_aktivitas` (
  `id`         bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id`    bigint unsigned NOT NULL,
  `aksi`       varchar(50) NOT NULL,
  `deskripsi`  text NOT NULL,
  `model_type` varchar(100) DEFAULT NULL,
  `model_id`   bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `data_lama`  json DEFAULT NULL,
  `data_baru`  json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `log_aktivitas_user_id_created_at_index` (`user_id`, `created_at`),
  KEY `log_aktivitas_aksi_index` (`aksi`),
  CONSTRAINT `log_aktivitas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- SEED DATA
-- ============================================================

-- Users (passwords = "password" hashed with bcrypt)
INSERT INTO `users` (`id`,`name`,`email`,`password`,`role`,`status`,`phone`,`jabatan`,`created_at`,`updated_at`) VALUES
(1,'Administrator','admin@kediri.go.id','$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','admin','active','081234567890','Kepala Desa',NOW(),NOW()),
(2,'Budi Santoso','budi@kediri.go.id','$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','staff','active','081234567891','Sekretaris Desa',NOW(),NOW()),
(3,'Siti Rahayu','siti@kediri.go.id','$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','staff','active','081234567892','Staff Administrasi',NOW(),NOW());

-- Surats
INSERT INTO `surats` (`kode_surat`,`nama_surat`,`jenis_surat`,`kategori`,`tanggal_surat`,`status`,`created_by`,`created_at`,`updated_at`) VALUES
('SM/2024/001','Surat Undangan Rapat Koordinasi Desa','masuk','penting','2024-11-01','aktif',2,NOW(),NOW()),
('SM/2024/002','Surat Permohonan Bantuan Dana BLT','masuk','umum','2024-11-05','aktif',2,NOW(),NOW()),
('SM/2024/003','Surat Pemberitahuan Program Posyandu','masuk','umum','2024-11-10','aktif',3,NOW(),NOW()),
('SM/2024/004','Dokumen Laporan Anggaran Rahasia','masuk','rahasia','2024-11-12','aktif',1,NOW(),NOW()),
('SK/2024/001','Surat Balasan Undangan Kecamatan','keluar','umum','2024-11-03','aktif',1,NOW(),NOW()),
('SK/2024/002','Surat Rekomendasi Warga Berprestasi','keluar','penting','2024-11-07','aktif',2,NOW(),NOW()),
('SK/2024/003','Surat Pengumuman Gotong Royong','keluar','umum','2024-11-15','aktif',3,NOW(),NOW()),
('SR/2024/001','Dokumen Perjanjian Investasi Desa','masuk','rahasia','2024-11-18','aktif',1,NOW(),NOW());

-- Agenda
INSERT INTO `agenda` (`judul`,`deskripsi`,`tanggal_mulai`,`tanggal_selesai`,`lokasi`,`penanggung_jawab`,`status`,`warna`,`created_by`,`created_at`,`updated_at`) VALUES
('Rapat Koordinasi Pembangunan Jalan Desa','Rapat koordinasi pembangunan jalan desa yang perlu dihadiri seluruh perangkat.',DATE_ADD(NOW(), INTERVAL 2 DAY),DATE_ADD(NOW(), INTERVAL 2 DAY),'Balai Desa','Kepala Desa','upcoming','#002147',1,NOW(),NOW()),
('Posyandu Bulanan RT 01-05','Kegiatan posyandu bulanan untuk warga RT 01 sampai RT 05.',DATE_ADD(NOW(), INTERVAL 5 DAY),DATE_ADD(NOW(), INTERVAL 5 DAY),'Puskesmas Desa','Bidan Desa','upcoming','#16a34a',1,NOW(),NOW()),
('Musyawarah Desa Penetapan APBDesa 2025','Musyawarah desa untuk menetapkan APBDesa tahun anggaran 2025.',DATE_ADD(NOW(), INTERVAL 10 DAY),DATE_ADD(NOW(), INTERVAL 10 DAY),'Balai Desa','Sekretaris Desa','upcoming','#d97706',1,NOW(),NOW()),
('Pelatihan Administrasi Digital Desa','Pelatihan penggunaan sistem digital administrasi desa.',DATE_SUB(NOW(), INTERVAL 5 DAY),DATE_SUB(NOW(), INTERVAL 3 DAY),'Aula Kecamatan','Budi Santoso','completed','#6366f1',1,NOW(),NOW()),
('Gotong Royong Kebersihan Lingkungan','Kegiatan gotong royong kebersihan seluruh wilayah desa.',DATE_ADD(NOW(), INTERVAL 15 DAY),DATE_ADD(NOW(), INTERVAL 15 DAY),'Seluruh Wilayah Desa','Kaur Umum','upcoming','#0891b2',1,NOW(),NOW());

-- Berita Acara
INSERT INTO `berita_acara` (`nomor`,`judul`,`tanggal`,`lokasi`,`isi`,`peserta`,`status`,`created_by`,`created_at`,`updated_at`) VALUES
('BA/2024/001','Berita Acara Rapat Pembahasan APBDes 2024','2024-10-15','Balai Desa','Pada hari ini Selasa tanggal 15 Oktober 2024 bertempat di Balai Desa telah dilaksanakan Rapat Pembahasan APBDes Tahun Anggaran 2024 yang dihadiri oleh seluruh perangkat desa dan Badan Permusyawaratan Desa (BPD). Rapat dipimpin oleh Kepala Desa dan berjalan dengan lancar. Hasil rapat: APBDes 2024 disetujui dengan total anggaran Rp 850.000.000.','Kepala Desa, BPD, Kaur Keuangan, Kaur Umum','approved',1,NOW(),NOW()),
('BA/2024/002','Berita Acara Serah Terima Bantuan Sosial','2024-10-28','Balai Desa','Telah dilaksanakan serah terima bantuan sosial kepada 45 Kepala Keluarga yang berhak menerima bantuan. Penyerahan berlangsung tertib dan lancar dengan total bantuan senilai Rp 2.250.000.000.','Kepala Desa, Tim Verifikasi, Penerima Manfaat','final',1,NOW(),NOW()),
('BA/2024/003','Berita Acara Musyawarah Perencanaan Desa','2024-11-01','Balai Desa','Musyawarah perencanaan pembangunan desa tahun 2025 telah dilaksanakan dengan dihadiri 85 peserta. Hasil musyawarah menetapkan 12 program prioritas pembangunan untuk tahun anggaran 2025.','Seluruh perangkat desa dan tokoh masyarakat','draft',1,NOW(),NOW());

-- Log Aktivitas
INSERT INTO `log_aktivitas` (`user_id`,`aksi`,`deskripsi`,`ip_address`,`created_at`,`updated_at`) VALUES
(1,'login','User Administrator berhasil login ke sistem.','127.0.0.1',NOW(),NOW()),
(2,'login','User Budi Santoso berhasil login ke sistem.','127.0.0.1',DATE_SUB(NOW(), INTERVAL 1 HOUR),DATE_SUB(NOW(), INTERVAL 1 HOUR)),
(2,'create_surat','Upload surat: Surat Undangan Rapat Koordinasi Desa (SM/2024/001)','127.0.0.1',DATE_SUB(NOW(), INTERVAL 2 HOUR),DATE_SUB(NOW(), INTERVAL 2 HOUR)),
(3,'create_surat','Upload surat: Surat Pemberitahuan Program Posyandu (SM/2024/003)','127.0.0.1',DATE_SUB(NOW(), INTERVAL 3 HOUR),DATE_SUB(NOW(), INTERVAL 3 HOUR)),
(1,'create_agenda','Buat agenda: Rapat Koordinasi Pembangunan Jalan Desa','127.0.0.1',DATE_SUB(NOW(), INTERVAL 4 HOUR),DATE_SUB(NOW(), INTERVAL 4 HOUR)),
(1,'create_user','Buat user baru: Siti Rahayu (staff)','127.0.0.1',DATE_SUB(NOW(), INTERVAL 5 HOUR),DATE_SUB(NOW(), INTERVAL 5 HOUR));

SET FOREIGN_KEY_CHECKS = 1;

-- ============================================================
-- E-Surat Database Setup Complete!
-- Login: admin@kediri.go.id / password
-- ============================================================
