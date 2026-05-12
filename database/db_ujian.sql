-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Waktu pembuatan: 11 Jul 2023 pada 06.05
-- Versi server: 5.7.34
-- Versi PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_ujian`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `bukti_dukung`
--

CREATE TABLE `bukti_dukung` (
  `id` int(11) NOT NULL,
  `nama_lampiran` varchar(200) DEFAULT NULL,
  `file` varchar(200) DEFAULT NULL,
  `ujian_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `bukti_dukung`
--

INSERT INTO `bukti_dukung` (`id`, `nama_lampiran`, `file`, `ujian_id`) VALUES
(2, 'Ijazah SMA', 'Ijazah_SMA-20230710210121-9562.docx', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `dosen`
--

CREATE TABLE `dosen` (
  `id` int(11) NOT NULL,
  `nip` varchar(100) DEFAULT NULL,
  `nidn` varchar(20) DEFAULT NULL,
  `nama_dosen` varchar(255) DEFAULT NULL,
  `jabatan_akademik` varchar(300) DEFAULT NULL,
  `tmt_akademik` date DEFAULT NULL,
  `homebase` varchar(100) DEFAULT NULL,
  `status` enum('aktif','tidak aktif','tugas belajar') DEFAULT NULL,
  `pangkat` varchar(255) DEFAULT NULL,
  `pangkat_tmt` date DEFAULT NULL,
  `pendidikan_terakhir` varchar(200) DEFAULT NULL,
  `tbl_user_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `dosen`
--

INSERT INTO `dosen` (`id`, `nip`, `nidn`, `nama_dosen`, `jabatan_akademik`, `tmt_akademik`, `homebase`, `status`, `pangkat`, `pangkat_tmt`, `pendidikan_terakhir`, `tbl_user_id`) VALUES
(3, '196012311986022001', '', 'Prof. Dr. Ir. Hj. Husna Faad, MP', 'Guru Besar', '2016-06-01', '1', 'aktif', 'Pembina Utama, IV/e', '2023-07-04', 'Doctor', 14),
(4, '196512311990031016', '', 'Prof Dr. Ir. Aminuddin Mane Kandari, M.Si', 'Guru Besar', '2023-06-28', '1', 'aktif', 'Pembina Utama Madya, IV/d', '2023-07-04', 'Doktor', 15),
(5, '196303201989021001', '', 'Dr. Ir. Kahirun, M.Si', 'Lektor Kepala', '2023-06-30', '1', 'aktif', 'Pembina Utama Muda, IV/c', '2023-06-28', 'Doktor', 16),
(6, '', '0001108503', 'Abdul Sakti, S.Hut.,M.Sc', '', '0000-00-00', '1', 'tugas belajar', '', '0000-00-00', '', 17),
(7, '', '0921068204', 'Mariana Zainun, SP .,M.Si', '', '0000-00-00', '1', 'aktif', '', '0000-00-00', '', 18),
(8, '', '0017038709', 'Wiwin Rahmawati Nurdin, S.Hut.,MP', '', '0000-00-00', '1', 'aktif', '', '0000-00-00', '', 19);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jurusan`
--

CREATE TABLE `jurusan` (
  `id` int(11) NOT NULL,
  `nama_jurusan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `jurusan`
--

INSERT INTO `jurusan` (`id`, `nama_jurusan`) VALUES
(1, 'Ilmu Lingkungan'),
(2, 'Kehutanan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `id` int(11) NOT NULL,
  `nama_mahasiswa` varchar(255) DEFAULT NULL,
  `nim` varchar(16) DEFAULT NULL,
  `status` enum('aktif','tidak aktif') DEFAULT NULL,
  `jurusan_id` int(11) NOT NULL,
  `tbl_user_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `mahasiswa`
--

INSERT INTO `mahasiswa` (`id`, `nama_mahasiswa`, `nim`, `status`, `jurusan_id`, `tbl_user_id`) VALUES
(2, 'Muhamad Danil', 'E1E117040', 'aktif', 2, 9);

-- --------------------------------------------------------

--
-- Struktur dari tabel `sk_dekan_b`
--

CREATE TABLE `sk_dekan_b` (
  `id` int(11) NOT NULL,
  `no_sk` varchar(200) DEFAULT NULL,
  `nama_ttd` varchar(200) DEFAULT NULL,
  `create_at` datetime DEFAULT NULL,
  `tgl_sk` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `sk_dekan_ujian`
--

CREATE TABLE `sk_dekan_ujian` (
  `id` int(11) NOT NULL,
  `no_sk` varchar(200) DEFAULT NULL,
  `nama_ttd` varchar(200) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `tgl_sk` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `sk_dekan_ujian_has_ujian`
--

CREATE TABLE `sk_dekan_ujian_has_ujian` (
  `id` int(11) NOT NULL,
  `sk_dekan_ujian_id` int(11) NOT NULL,
  `ujian_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_hak_akses`
--

CREATE TABLE `tbl_hak_akses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tbl_menu_id` bigint(20) UNSIGNED NOT NULL,
  `tbl_user_level_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tbl_hak_akses`
--

INSERT INTO `tbl_hak_akses` (`id`, `created_at`, `updated_at`, `tbl_menu_id`, `tbl_user_level_id`) VALUES
(1, NULL, NULL, 1, 1),
(3, NULL, NULL, 3, 1),
(7, NULL, NULL, 2, 2),
(11, NULL, NULL, 5, 1),
(12, NULL, NULL, 7, 2),
(13, NULL, NULL, 8, 2),
(15, NULL, NULL, 10, 2),
(18, NULL, NULL, 2, 3),
(22, NULL, NULL, 10, 3),
(25, NULL, NULL, 2, 4),
(26, NULL, NULL, 10, 4),
(36, NULL, NULL, 2, 5),
(37, NULL, NULL, 9, 5),
(38, NULL, NULL, 10, 5),
(41, NULL, NULL, 8, 3),
(42, NULL, NULL, 7, 3),
(43, NULL, NULL, 6, 3),
(44, NULL, NULL, 13, 2),
(45, NULL, NULL, 14, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_menu`
--

CREATE TABLE `tbl_menu` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_main_menu` int(11) NOT NULL DEFAULT '0',
  `is_aktif` enum('y','n') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tbl_menu`
--

INSERT INTO `tbl_menu` (`id`, `title`, `url`, `icon`, `is_main_menu`, `is_aktif`, `created_at`, `updated_at`) VALUES
(1, 'Manajemen Menu', 'C_menu', 'menu-icon fa fa-th-large', 0, 'y', NULL, NULL),
(2, 'Dashboard', 'C_home', 'menu-icon fa fa-dashboard', 0, 'y', NULL, NULL),
(3, 'Hak Akses', 'C_userlevel', 'menu-icon fa fa-unlock-alt', 0, 'y', NULL, NULL),
(5, 'Manajemen User', 'C_user', 'menu-icon fa fa-users', 0, 'y', NULL, NULL),
(6, 'Jurusan', 'C_jurusan', 'menu-icon fas fa-user-tie', 0, 'y', NULL, NULL),
(7, 'Mahasiswa', 'C_mahasiswa', 'menu-icon fas fa-chalkboard-teacher', 0, 'y', NULL, NULL),
(8, 'Dosen', 'C_dosen', 'menu-icon fa fa-user', 0, 'y', NULL, NULL),
(9, 'Pengajuan Ujian', 'C_ujian', 'menu-icon fas fa-file-pdf', 0, 'y', NULL, NULL),
(10, 'Monitoring Ujian', 'C_ujian/monitoring', 'menu-icon fas fa-user-clock', 0, 'y', NULL, NULL),
(11, 'Laporan Data Rapat', 'C_report/rapat', 'menu-icon fa fa-bars', 0, 'y', NULL, NULL),
(12, 'Laporan', 'C_report', 'menu-icon fas fa-tasks', 0, 'y', NULL, NULL),
(13, 'Verifikasi Ujian', 'C_verifikasi_ujian', 'menu-icon fa fa-file', 0, 'y', NULL, NULL),
(14, 'Monitoring Dosen', 'C_verifikasi_ujian/monitoring_dosen', 'menu-icon fa fa-bars', 0, 'y', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_setting`
--

CREATE TABLE `tbl_setting` (
  `id_setting` int(11) NOT NULL,
  `nama_setting` varchar(100) NOT NULL,
  `value` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `tbl_setting`
--

INSERT INTO `tbl_setting` (`id_setting`, `nama_setting`, `value`) VALUES
(1, 'Tampil Menu', 'ya');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_pengguna` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'New User',
  `no_hp` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `picture_profile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default.png',
  `jurusan_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_aktif` enum('y','n') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tbl_user_level_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `username`, `password`, `nama_pengguna`, `no_hp`, `email`, `picture_profile`, `jurusan_id`, `is_aktif`, `created_at`, `updated_at`, `tbl_user_level_id`) VALUES
(1, 'administrator', '$2y$10$Jm5N6UX.TZ3.t5PHX35F.eVhILGJmqy4Em4MNj4y36zVZi5UpZHUe', 'administrator', '12545', NULL, '', 'administrator', 'y', NULL, NULL, 1),
(4, 'pegawai', '$2y$04$ytPAC./OBj7s.aDF8wzDf.DzhGq6eLnrZBQCwkgv26NNbqspiwBl.', 'Pegawai A', '086565656565', NULL, '0x.jpg', '178327198739821321', 'y', NULL, NULL, 4),
(6, 'arni', '$2y$04$SviGVoWXg/kXIivsM3/iEOFU1sO.KCATUDu.QpC9rKCxivc77wCN6', 'arinti', '0874893698464', NULL, '78622a3f47fd34632f6693397cdf8ac2.png', '71947298174891', 'y', NULL, NULL, 3),
(7, 'ilmu_lingkungan', '$2y$04$NemYNkAhAbJbX2MW9mhi9eA6x7bdbe0F.cAW0zKTMYCYekfkhOVWO', 'Staf ilmu lingkungan', '0845475456736', '', '3580aed177a3faad83302295fd1b3c55.png', '1', 'y', NULL, NULL, 2),
(9, 'E1E117040', '$2y$04$smBYlWo8eTN2XvPL3xvILeewdluYQjzZAbvKUl98Uc/3Pkc.UVxCO', 'Muhamad Danil', '085398698898', 'muhammaddanil790@gmail.com', 'f4ac3040beeef2a960c08d3ccd725512.png', '1', 'y', NULL, NULL, 5),
(14, '196012311986022001', '$2y$04$GLtPIg9WBZjxn8dB38XMM.Mg9AHDIDpGW/udxJUqPxhcIdzz1uyCq', 'Prof. Dr. Ir. Hj. Husna Faad, MP', '', '', '', '1', 'y', NULL, NULL, 4),
(15, '196512311990031016', '$2y$04$pb4rjEnKXRGoInxEJjRMXemAJEagASTJOtqHujCHTs9gfTKIMeEPC', 'Prof Dr. Ir. Aminuddin Mane Kandari, M.Si', '', '', '', '1', 'y', NULL, NULL, 4),
(16, '196303201989021001', '$2y$04$XxKt9gyy8dk..Z8IgXINz.0Gp6w9aFDea75YdOPmmpI8lcTsWkPfu', 'Dr. Ir. Kahirun, M.Si', '', '', '', '1', 'y', NULL, NULL, 4),
(17, '0001108503', '$2y$04$ADMjHEv60O5Qt.1RgnL0w.D/CbIk20HEBHpRrpW2n4EENIrB7zclm', 'Abdul Sakti, S.Hut.,M.Sc', '', '', '', '1', 'y', NULL, NULL, 4),
(18, '0921068204', '$2y$04$qAJb6ygUAUUSCOsWKJnyM.DpqvbJEj78TTVy84PSQ3.t.WA8vPUqO', 'Mariana Zainun, SP .,M.Si', '', '', '', '1', 'y', NULL, NULL, 4),
(19, '0017038709', '$2y$04$8bqZ963ZnBCQam8jJ3tZhO/lC1FB47LToBA6PXIWrWk6Rvzxl44R2', 'Wiwin Rahmawati Nurdin, S.Hut.,MP', '', '', '', '1', 'y', NULL, NULL, 4),
(22, 'staf_akademik', '$2y$04$8WCaNpj5RD7ISLE93UWzdOUIDURKUholGxrlx0xxRBsv2nf9.fxvS', 'Staf Akademik', '0', 'staf_akademik@gmail.com', '', '', 'y', NULL, NULL, 3),
(23, 'kehutanan', '$2y$04$uPXJPuZIxxxhlu0S/UiR.uegu3f3RkGrUnaFhGxhqLIwjYMwfcZBC', 'Staf Kehutanan', '0', 'kehutanan@gmail.com', '', '2', 'y', NULL, NULL, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_user_level`
--

CREATE TABLE `tbl_user_level` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tbl_user_level`
--

INSERT INTO `tbl_user_level` (`id`, `nama`, `created_at`, `updated_at`) VALUES
(1, 'administrator', NULL, NULL),
(2, 'Staf Jurusan', NULL, NULL),
(3, 'Staf Akademik', NULL, NULL),
(4, 'Dosen', NULL, NULL),
(5, 'Mahasiswa', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `ujian`
--

CREATE TABLE `ujian` (
  `id` int(11) NOT NULL,
  `jenis_ujian` enum('proposal','hasil','skripsi') DEFAULT NULL,
  `judul` text,
  `ipk_sementara` varchar(45) DEFAULT NULL,
  `nilai_ujian` varchar(45) DEFAULT NULL,
  `ketua` varchar(45) DEFAULT NULL,
  `sekretaris` varchar(45) DEFAULT NULL,
  `anggota_1` varchar(45) DEFAULT NULL,
  `anggota_2` varchar(45) DEFAULT NULL,
  `anggota_3` varchar(45) DEFAULT NULL,
  `upload_ba` varchar(45) DEFAULT NULL,
  `no_surat` varchar(45) DEFAULT NULL,
  `pembimbing_1` int(11) DEFAULT NULL,
  `pembimbing_2` int(11) DEFAULT NULL,
  `uji1` int(11) DEFAULT NULL,
  `uji2` int(11) DEFAULT NULL,
  `uji3` int(11) DEFAULT NULL,
  `hari_ujian` varchar(200) DEFAULT NULL,
  `jam_ujian` varchar(100) DEFAULT NULL,
  `tempat_ujian` varchar(200) DEFAULT NULL,
  `upload_st` text,
  `upload_sp` varchar(200) DEFAULT NULL,
  `no_st` varchar(200) DEFAULT NULL,
  `no_sp` varchar(100) DEFAULT NULL,
  `nama_ttd` varchar(200) DEFAULT NULL,
  `mahasiswa_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `ujian`
--

INSERT INTO `ujian` (`id`, `jenis_ujian`, `judul`, `ipk_sementara`, `nilai_ujian`, `ketua`, `sekretaris`, `anggota_1`, `anggota_2`, `anggota_3`, `upload_ba`, `no_surat`, `pembimbing_1`, `pembimbing_2`, `uji1`, `uji2`, `uji3`, `hari_ujian`, `jam_ujian`, `tempat_ujian`, `upload_st`, `upload_sp`, `no_st`, `no_sp`, `nama_ttd`, `mahasiswa_id`) VALUES
(1, 'proposal', 'Implementasi Data Mining dengan Algoritma C4. 5 untuk Memprediksi Tingkat Kelulusan Mahasiswa', '3', '75', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 7, 3, 6, 7, 8, '2023-07-15', '09:00:00', NULL, NULL, NULL, NULL, NULL, NULL, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `ujian_has_sk_dekan_b`
--

CREATE TABLE `ujian_has_sk_dekan_b` (
  `id` int(11) NOT NULL,
  `ujian_id` int(11) NOT NULL,
  `sk_dekan_b_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `bukti_dukung`
--
ALTER TABLE `bukti_dukung`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_bukti_dukung_ujian1_idx` (`ujian_id`);

--
-- Indeks untuk tabel `dosen`
--
ALTER TABLE `dosen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_dosen_tbl_user1_idx` (`tbl_user_id`);

--
-- Indeks untuk tabel `jurusan`
--
ALTER TABLE `jurusan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`id`,`jurusan_id`),
  ADD KEY `fk_mahasiswa_jurusan1_idx` (`jurusan_id`),
  ADD KEY `fk_mahasiswa_tbl_user1_idx` (`tbl_user_id`);

--
-- Indeks untuk tabel `sk_dekan_b`
--
ALTER TABLE `sk_dekan_b`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `sk_dekan_ujian`
--
ALTER TABLE `sk_dekan_ujian`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `sk_dekan_ujian_has_ujian`
--
ALTER TABLE `sk_dekan_ujian_has_ujian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sk_dekan_ujian_has_ujian_ujian1_idx` (`ujian_id`),
  ADD KEY `fk_sk_dekan_ujian_has_ujian_sk_dekan_ujian_idx` (`sk_dekan_ujian_id`);

--
-- Indeks untuk tabel `tbl_hak_akses`
--
ALTER TABLE `tbl_hak_akses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tbl_hak_akses_tbl_menu1_idx` (`tbl_menu_id`),
  ADD KEY `fk_tbl_hak_akses_tbl_user_level1_idx` (`tbl_user_level_id`);

--
-- Indeks untuk tabel `tbl_menu`
--
ALTER TABLE `tbl_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_setting`
--
ALTER TABLE `tbl_setting`
  ADD PRIMARY KEY (`id_setting`);

--
-- Indeks untuk tabel `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tbl_user_username_unique` (`username`),
  ADD KEY `fk_tbl_user_tbl_user_level_idx` (`tbl_user_level_id`);

--
-- Indeks untuk tabel `tbl_user_level`
--
ALTER TABLE `tbl_user_level`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `ujian`
--
ALTER TABLE `ujian`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `ujian_has_sk_dekan_b`
--
ALTER TABLE `ujian_has_sk_dekan_b`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ujian_has_sk_dekan_b_sk_dekan_b1_idx` (`sk_dekan_b_id`),
  ADD KEY `fk_ujian_has_sk_dekan_b_ujian1_idx` (`ujian_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `bukti_dukung`
--
ALTER TABLE `bukti_dukung`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `dosen`
--
ALTER TABLE `dosen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `jurusan`
--
ALTER TABLE `jurusan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `mahasiswa`
--
ALTER TABLE `mahasiswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `sk_dekan_b`
--
ALTER TABLE `sk_dekan_b`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `sk_dekan_ujian`
--
ALTER TABLE `sk_dekan_ujian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `sk_dekan_ujian_has_ujian`
--
ALTER TABLE `sk_dekan_ujian_has_ujian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_hak_akses`
--
ALTER TABLE `tbl_hak_akses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT untuk tabel `tbl_menu`
--
ALTER TABLE `tbl_menu`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `tbl_setting`
--
ALTER TABLE `tbl_setting`
  MODIFY `id_setting` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT untuk tabel `tbl_user_level`
--
ALTER TABLE `tbl_user_level`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `ujian`
--
ALTER TABLE `ujian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `ujian_has_sk_dekan_b`
--
ALTER TABLE `ujian_has_sk_dekan_b`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `bukti_dukung`
--
ALTER TABLE `bukti_dukung`
  ADD CONSTRAINT `fk_bukti_dukung_ujian1` FOREIGN KEY (`ujian_id`) REFERENCES `ujian` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ketidakleluasaan untuk tabel `dosen`
--
ALTER TABLE `dosen`
  ADD CONSTRAINT `fk_dosen_tbl_user1` FOREIGN KEY (`tbl_user_id`) REFERENCES `tbl_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ketidakleluasaan untuk tabel `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD CONSTRAINT `fk_mahasiswa_jurusan1` FOREIGN KEY (`jurusan_id`) REFERENCES `jurusan` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_mahasiswa_tbl_user1` FOREIGN KEY (`tbl_user_id`) REFERENCES `tbl_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ketidakleluasaan untuk tabel `sk_dekan_ujian_has_ujian`
--
ALTER TABLE `sk_dekan_ujian_has_ujian`
  ADD CONSTRAINT `fk_sk_dekan_ujian_has_ujian_sk_dekan_ujian` FOREIGN KEY (`sk_dekan_ujian_id`) REFERENCES `sk_dekan_ujian` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_sk_dekan_ujian_has_ujian_ujian1` FOREIGN KEY (`ujian_id`) REFERENCES `ujian` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ketidakleluasaan untuk tabel `tbl_hak_akses`
--
ALTER TABLE `tbl_hak_akses`
  ADD CONSTRAINT `fk_tbl_hak_akses_tbl_menu1` FOREIGN KEY (`tbl_menu_id`) REFERENCES `tbl_menu` (`id`),
  ADD CONSTRAINT `fk_tbl_hak_akses_tbl_user_level1` FOREIGN KEY (`tbl_user_level_id`) REFERENCES `tbl_user_level` (`id`);

--
-- Ketidakleluasaan untuk tabel `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD CONSTRAINT `fk_tbl_user_tbl_user_level` FOREIGN KEY (`tbl_user_level_id`) REFERENCES `tbl_user_level` (`id`);

--
-- Ketidakleluasaan untuk tabel `ujian_has_sk_dekan_b`
--
ALTER TABLE `ujian_has_sk_dekan_b`
  ADD CONSTRAINT `fk_ujian_has_sk_dekan_b_sk_dekan_b1` FOREIGN KEY (`sk_dekan_b_id`) REFERENCES `sk_dekan_b` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ujian_has_sk_dekan_b_ujian1` FOREIGN KEY (`ujian_id`) REFERENCES `ujian` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
