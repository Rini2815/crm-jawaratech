-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 15, 2026 at 05:17 PM
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
-- Database: `crm-jawaratechh`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `set_fk` (IN `p_tabel` VARCHAR(64), IN `p_kolom` VARCHAR(64), IN `p_ref_tabel` VARCHAR(64), IN `p_ref_kolom` VARCHAR(64), IN `p_update` VARCHAR(20), IN `p_delete` VARCHAR(20), IN `p_boleh_null` TINYINT)   BEGIN
  DECLARE v_fk   VARCHAR(64) DEFAULT NULL;
  DECLARE v_tipe VARCHAR(100) DEFAULT NULL;

  -- 1) hapus FK lama pada kolom ini (jika ada)
  SELECT CONSTRAINT_NAME INTO v_fk
    FROM information_schema.KEY_COLUMN_USAGE
   WHERE TABLE_SCHEMA = DATABASE()
     AND TABLE_NAME = p_tabel
     AND COLUMN_NAME = p_kolom
     AND REFERENCED_TABLE_NAME = p_ref_tabel
   LIMIT 1;

  IF v_fk IS NOT NULL THEN
    SET @q = CONCAT('ALTER TABLE `', p_tabel, '` DROP FOREIGN KEY `', v_fk, '`');
    PREPARE s FROM @q; EXECUTE s; DEALLOCATE PREPARE s;
  END IF;

  -- 2) jika kolom harus boleh kosong, ubah jadi NULL (tipe tetap sama)
  IF p_boleh_null = 1 THEN
    SELECT COLUMN_TYPE INTO v_tipe
      FROM information_schema.COLUMNS
     WHERE TABLE_SCHEMA = DATABASE()
       AND TABLE_NAME = p_tabel
       AND COLUMN_NAME = p_kolom;
    SET @q = CONCAT('ALTER TABLE `', p_tabel, '` MODIFY `', p_kolom, '` ', v_tipe, ' NULL');
    PREPARE s FROM @q; EXECUTE s; DEALLOCATE PREPARE s;
  END IF;

  -- 3) buat FK baru dengan aturan yang diminta
  SET @q = CONCAT('ALTER TABLE `', p_tabel, '` ADD CONSTRAINT `fk_', p_tabel, '_', p_kolom,
                  '` FOREIGN KEY (`', p_kolom, '`) REFERENCES `', p_ref_tabel, '` (`', p_ref_kolom,
                  '`) ON UPDATE ', p_update, ' ON DELETE ', p_delete);
  PREPARE s FROM @q; EXECUTE s; DEALLOCATE PREPARE s;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `log_audit`
--

CREATE TABLE `log_audit` (
  `id_log` int(10) UNSIGNED NOT NULL,
  `id_pengguna` int(10) UNSIGNED NOT NULL,
  `aksi` enum('Login','Logout','Create','Update','Delete','Impersonate','Reset_Password','Export') NOT NULL,
  `tabel` varchar(64) DEFAULT NULL,
  `id_record` varchar(40) DEFAULT NULL,
  `data_lama` text DEFAULT NULL,
  `data_baru` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ms_hak_akses`
--

CREATE TABLE `ms_hak_akses` (
  `id_hak_akses` int(10) UNSIGNED NOT NULL,
  `id_role` int(10) UNSIGNED NOT NULL,
  `modul` varchar(40) NOT NULL,
  `aksi` enum('lihat','tambah','ubah','hapus') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ms_konsumen`
--

CREATE TABLE `ms_konsumen` (
  `id_konsumen` int(10) UNSIGNED NOT NULL,
  `nama` varchar(45) NOT NULL,
  `no_whatsapp` varchar(15) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ms_pengguna`
--

CREATE TABLE `ms_pengguna` (
  `id_pengguna` int(10) UNSIGNED NOT NULL,
  `id_role` int(10) UNSIGNED NOT NULL,
  `google_id` varchar(50) DEFAULT NULL,
  `nama` varchar(45) NOT NULL,
  `email` varchar(45) DEFAULT NULL,
  `no_whatsapp` varchar(15) DEFAULT NULL,
  `password` varchar(64) DEFAULT NULL,
  `remember_token` varchar(60) DEFAULT NULL,
  `status` enum('Aktif','Tidak Aktif') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ms_role`
--

CREATE TABLE `ms_role` (
  `id_role` int(10) UNSIGNED NOT NULL,
  `nama_role` varchar(45) NOT NULL,
  `deskripsi` varchar(60) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ms_teknisi`
--

CREATE TABLE `ms_teknisi` (
  `id_teknisi` int(10) UNSIGNED NOT NULL,
  `nama_teknisi` varchar(45) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ms_unit`
--

CREATE TABLE `ms_unit` (
  `id_unit` int(10) UNSIGNED NOT NULL,
  `id_konsumen` int(10) UNSIGNED NOT NULL,
  `jenis_unit` enum('AC','Dispenser','Water Heater','Mesin Cuci') NOT NULL,
  `merek` varchar(20) NOT NULL,
  `tipe_model` varchar(45) DEFAULT NULL,
  `tanggal_masuk` date NOT NULL,
  `interval_bulan` smallint(5) UNSIGNED NOT NULL,
  `status_garansi` enum('Aktif','Tidak Bergaransi') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tr_follow_up`
--

CREATE TABLE `tr_follow_up` (
  `id_follow_up` int(10) UNSIGNED NOT NULL,
  `id_unit` int(10) UNSIGNED NOT NULL,
  `id_servis` int(10) UNSIGNED DEFAULT NULL,
  `id_pengguna` int(10) UNSIGNED DEFAULT NULL,
  `kategori` enum('Happy Call','Pengingat Perawatan') NOT NULL,
  `tanggal_jadwal` date NOT NULL,
  `waktu_kontak` datetime DEFAULT NULL,
  `status` enum('Belum Dihubungi','Sudah Dihubungi','Perlu Jadwal Ulang') NOT NULL,
  `catatan_hasil` text DEFAULT NULL,
  `tanggal_jadwal_ulang` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tr_riwayat_status`
--

CREATE TABLE `tr_riwayat_status` (
  `id_riwayat` int(10) UNSIGNED NOT NULL,
  `id_servis` int(10) UNSIGNED NOT NULL,
  `id_pengguna` int(10) UNSIGNED DEFAULT NULL,
  `status_lama` enum('Menunggu Konfirmasi','Sedang Dicek','Proses Servis','Selesai') DEFAULT NULL,
  `status_baru` enum('Menunggu Konfirmasi','Sedang Dicek','Proses Servis','Selesai') NOT NULL,
  `catatan` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tr_servis`
--

CREATE TABLE `tr_servis` (
  `id_servis` int(10) UNSIGNED NOT NULL,
  `id_unit` int(10) UNSIGNED NOT NULL,
  `id_teknisi` int(10) UNSIGNED NOT NULL,
  `no_tiket` varchar(30) NOT NULL,
  `tanggal_masuk` date NOT NULL,
  `tanggal_estimasi_selesai` date DEFAULT NULL,
  `keluhan` text NOT NULL,
  `kelengkapan` varchar(50) DEFAULT NULL,
  `status` enum('Menunggu Konfirmasi','Sedang Dicek','Proses Servis','Selesai') NOT NULL DEFAULT 'Menunggu Konfirmasi',
  `no_invoice` varchar(30) DEFAULT NULL,
  `tanggal_closing` date DEFAULT NULL,
  `biaya_jasa` int(11) NOT NULL DEFAULT 0,
  `jumlah_dp` int(11) NOT NULL DEFAULT 0,
  `biaya_sparepart` int(11) NOT NULL DEFAULT 0,
  `diskon` int(11) NOT NULL DEFAULT 0,
  `total_bayar` int(11) NOT NULL DEFAULT 0,
  `masa_garansi_hari` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  `garansi_berakhir` date DEFAULT NULL,
  `status_pembayaran` enum('Belum Lunas','DP','Lunas') NOT NULL DEFAULT 'Belum Lunas',
  `tanggal_dp` date DEFAULT NULL,
  `tanggal_pelunasan` date DEFAULT NULL,
  `jumlah_pelunasan` int(10) UNSIGNED DEFAULT NULL,
  `metode_pembayaran` enum('Tunai','QRIS/Transfer') DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tr_servis_detail`
--

CREATE TABLE `tr_servis_detail` (
  `id_detail` int(10) UNSIGNED NOT NULL,
  `id_servis` int(10) UNSIGNED NOT NULL,
  `jenis` enum('Tindakan','Sparepart') NOT NULL,
  `uraian` varchar(60) NOT NULL,
  `qty` smallint(5) UNSIGNED NOT NULL DEFAULT 1,
  `harga_satuan` int(11) NOT NULL DEFAULT 0,
  `subtotal` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `log_audit`
--
ALTER TABLE `log_audit`
  ADD PRIMARY KEY (`id_log`),
  ADD KEY `fk_log_audit_ms_pengguna1_idx` (`id_pengguna`);

--
-- Indexes for table `ms_hak_akses`
--
ALTER TABLE `ms_hak_akses`
  ADD PRIMARY KEY (`id_hak_akses`),
  ADD KEY `fk_ms_hak_akses_ms_role1_idx` (`id_role`);

--
-- Indexes for table `ms_konsumen`
--
ALTER TABLE `ms_konsumen`
  ADD PRIMARY KEY (`id_konsumen`),
  ADD UNIQUE KEY `no_whatsapp_UNIQUE` (`no_whatsapp`);

--
-- Indexes for table `ms_pengguna`
--
ALTER TABLE `ms_pengguna`
  ADD PRIMARY KEY (`id_pengguna`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`),
  ADD UNIQUE KEY `id_google_UNIQUE` (`google_id`),
  ADD KEY `fk_ms_pengguna_ms_role_idx` (`id_role`);

--
-- Indexes for table `ms_role`
--
ALTER TABLE `ms_role`
  ADD PRIMARY KEY (`id_role`),
  ADD UNIQUE KEY `nama_role_UNIQUE` (`nama_role`);

--
-- Indexes for table `ms_teknisi`
--
ALTER TABLE `ms_teknisi`
  ADD PRIMARY KEY (`id_teknisi`);

--
-- Indexes for table `ms_unit`
--
ALTER TABLE `ms_unit`
  ADD PRIMARY KEY (`id_unit`),
  ADD KEY `fk_ms_unit_ms_konsumen1_idx` (`id_konsumen`);

--
-- Indexes for table `tr_follow_up`
--
ALTER TABLE `tr_follow_up`
  ADD PRIMARY KEY (`id_follow_up`),
  ADD KEY `fk_tr_follow_up_ms_unit1_idx` (`id_unit`),
  ADD KEY `fk_tr_follow_up_tr_servis1_idx` (`id_servis`),
  ADD KEY `fk_tr_follow_up_ms_pengguna1_idx` (`id_pengguna`);

--
-- Indexes for table `tr_riwayat_status`
--
ALTER TABLE `tr_riwayat_status`
  ADD PRIMARY KEY (`id_riwayat`),
  ADD KEY `fk_tr_riwayat_status_tr_servis1_idx` (`id_servis`),
  ADD KEY `fk_tr_riwayat_status_ms_pengguna1_idx` (`id_pengguna`);

--
-- Indexes for table `tr_servis`
--
ALTER TABLE `tr_servis`
  ADD PRIMARY KEY (`id_servis`),
  ADD UNIQUE KEY `no_tiket_UNIQUE` (`no_tiket`),
  ADD UNIQUE KEY `no_invoice_UNIQUE` (`no_invoice`),
  ADD KEY `fk_tr_servis_ms_unit1_idx` (`id_unit`),
  ADD KEY `fk_tr_servis_ms_teknisi1_idx` (`id_teknisi`);

--
-- Indexes for table `tr_servis_detail`
--
ALTER TABLE `tr_servis_detail`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `fk_tr_servis_detail_tr_servis1_idx` (`id_servis`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `log_audit`
--
ALTER TABLE `log_audit`
  MODIFY `id_log` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ms_hak_akses`
--
ALTER TABLE `ms_hak_akses`
  MODIFY `id_hak_akses` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ms_konsumen`
--
ALTER TABLE `ms_konsumen`
  MODIFY `id_konsumen` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ms_pengguna`
--
ALTER TABLE `ms_pengguna`
  MODIFY `id_pengguna` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ms_role`
--
ALTER TABLE `ms_role`
  MODIFY `id_role` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ms_teknisi`
--
ALTER TABLE `ms_teknisi`
  MODIFY `id_teknisi` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ms_unit`
--
ALTER TABLE `ms_unit`
  MODIFY `id_unit` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tr_follow_up`
--
ALTER TABLE `tr_follow_up`
  MODIFY `id_follow_up` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tr_riwayat_status`
--
ALTER TABLE `tr_riwayat_status`
  MODIFY `id_riwayat` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tr_servis`
--
ALTER TABLE `tr_servis`
  MODIFY `id_servis` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tr_servis_detail`
--
ALTER TABLE `tr_servis_detail`
  MODIFY `id_detail` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `log_audit`
--
ALTER TABLE `log_audit`
  ADD CONSTRAINT `fk_log_audit_ms_pengguna1` FOREIGN KEY (`id_pengguna`) REFERENCES `ms_pengguna` (`id_pengguna`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `ms_hak_akses`
--
ALTER TABLE `ms_hak_akses`
  ADD CONSTRAINT `fk_ms_hak_akses_ms_role1` FOREIGN KEY (`id_role`) REFERENCES `ms_role` (`id_role`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `ms_pengguna`
--
ALTER TABLE `ms_pengguna`
  ADD CONSTRAINT `fk_ms_pengguna_ms_role` FOREIGN KEY (`id_role`) REFERENCES `ms_role` (`id_role`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `ms_unit`
--
ALTER TABLE `ms_unit`
  ADD CONSTRAINT `fk_ms_unit_ms_konsumen1` FOREIGN KEY (`id_konsumen`) REFERENCES `ms_konsumen` (`id_konsumen`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `tr_follow_up`
--
ALTER TABLE `tr_follow_up`
  ADD CONSTRAINT `fk_tr_follow_up_ms_pengguna1` FOREIGN KEY (`id_pengguna`) REFERENCES `ms_pengguna` (`id_pengguna`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tr_follow_up_ms_unit1` FOREIGN KEY (`id_unit`) REFERENCES `ms_unit` (`id_unit`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tr_follow_up_tr_servis1` FOREIGN KEY (`id_servis`) REFERENCES `tr_servis` (`id_servis`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `tr_riwayat_status`
--
ALTER TABLE `tr_riwayat_status`
  ADD CONSTRAINT `fk_tr_riwayat_status_ms_pengguna1` FOREIGN KEY (`id_pengguna`) REFERENCES `ms_pengguna` (`id_pengguna`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tr_riwayat_status_tr_servis1` FOREIGN KEY (`id_servis`) REFERENCES `tr_servis` (`id_servis`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `tr_servis`
--
ALTER TABLE `tr_servis`
  ADD CONSTRAINT `fk_tr_servis_ms_teknisi1` FOREIGN KEY (`id_teknisi`) REFERENCES `ms_teknisi` (`id_teknisi`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tr_servis_ms_unit1` FOREIGN KEY (`id_unit`) REFERENCES `ms_unit` (`id_unit`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `tr_servis_detail`
--
ALTER TABLE `tr_servis_detail`
  ADD CONSTRAINT `fk_tr_servis_detail_tr_servis1` FOREIGN KEY (`id_servis`) REFERENCES `tr_servis` (`id_servis`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
