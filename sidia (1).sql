-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 11, 2025 at 06:30 PM
-- Server version: 11.7.2-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sidia`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_bias`
--

CREATE TABLE `admin_bias` (
  `id_admin_bias` char(100) NOT NULL,
  `tahun` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `id_dusun` int(11) NOT NULL,
  `create_date` date NOT NULL,
  `pimpinan` varchar(100) DEFAULT NULL,
  `nip_pimpinan` varchar(100) DEFAULT NULL,
  `pengelola` varchar(100) DEFAULT NULL,
  `nip_pengelola` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `admin_bias`
--

INSERT INTO `admin_bias` (`id_admin_bias`, `tahun`, `username`, `id_dusun`, `create_date`, `pimpinan`, `nip_pimpinan`, `pengelola`, `nip_pengelola`) VALUES
('92574a4374c31377b184135f3bf6a791_8', 2020, 'dusunMALILI', 8, '2020-12-07', 'Hasnah,S.Kep.Ns', '197703202000502004', 'Yulianus Padanun,S.Kep,Ns', '196911111992031017'),
('d629fcf15edca6ce34aef4a57053cf23_4', 2020, 'TOMONITIMUR', 4, '2020-12-04', 'ALFRIDA LANTANG, SKM', '19611210198403 2 012', 'Ni Made Eli Sulistiawati,S.Kep.Ns', '19840417200902 2 007'),
('f09eb0237ab7d102cc92f95f73da3153_17', 2020, 'dusunMAHALONA', 17, '2020-12-16', 'HARDIAN WALY, S.KEP.NS', '19820920 200902 1 005', 'IBNU HAJAR MAS UD, AMK', '19850404 201001 1 027'),
('8885a27ce7ddbf7e31b58a569414f1e0_1', 2020, 'dusunBURAU', 1, '2020-12-03', 'NURHAPIAH HAFID.S.kep Ns', '197510212003122002', 'RUPINUS,A md.Kep', '197205241993031002'),
('db07a4caad894ea944dfd4cbb9483789_14', 2020, 'dusunWAWONDULA', 14, '2020-12-03', 'H.SAHMUDDIN,SKM', '197205031992021007', 'JENI MANURUNG,AMD.KEP', '197911152006042010'),
('3da4c42d75ad3d7173c8e61f50e52e04_13', 2020, 'dusunNUHA', 13, '2020-12-03', 'CHANDRA, SKM', '197602182003122009', 'FARIDA TANGKESARI,S.Tr.Keb', '197504242006042027'),
('e83b8a91be94f324f6cdc13a7d2bdb14_9', 2020, 'dusunLAMPIA', 9, '2020-12-04', 'Samriani, S.Kep', '197205281994102001', 'Leni Erniawati, A.Md.Keb', '198708192010012015'),
('73f2f3641f5123e875d2a1f9385ac3ef_2', 2020, 'dusunWOTU', 2, '2020-12-07', 'Suharto, SKM, M. Kes. ', '196708161989011002', 'Muhammad Isya Fairuh', '197110041994031004'),
('46b6272a37cd0c4f4ec74ad3a5f294af_5', 2020, 'MANGKUTANA', 5, '2020-12-03', 'wa ode ferliani.M.SKM', '19691101 1999103 2 018', 'KORIM', '19710114 199103 1 006'),
('cde3248b6cbfc840f910161cf3214a97_15', 2020, 'dusunTIMAMPU', 15, '2020-12-03', 'Asir', '19720101 199403 1 014', 'Devi Nurianti', '-'),
('18faab3ea952dfaf7288135b68fcdeca_7', 2020, 'dusunANGKONA', 7, '2020-12-05', 'JUMARDI,SKM', '198407272009011004', 'DEWA MADE SUARTIKA,SKep.NS', '19780724200641013'),
('d01dcc589449ba050ab34be955c2f8e3_10', 2020, 'dusunLAKAWALI', 10, '2020-12-05', 'Mahfud Burhami, S.Kep.,Ns', '198704192014041001', 'Heriadi, A.Md.Kep', '198711092015041002'),
('c07bb4c952181343fce38b78a2b1db9a_6', 2020, 'dusunKALAENA', 6, '2020-12-11', 'drg.Ernawati', '19761106 200604 2 007', 'Nurdin,S.Kep.Ns', '19791029 200604 1 011'),
('f0012f4c52c2be74df4205ae874d5f0e_11', 2020, 'WASUPONDA', 11, '2020-12-14', 'Kasmuddin, SKM', '19750609 199503 1 004', 'Judith Kala', '19690108 198910 2 001'),
('76f8efe3a068483791919191bb784955_16', 2020, 'dusunBANTILANG', 16, '2020-12-21', 'Mohammad Rum', '198511252009021002', 'Zainul battung', '198803032010011003'),
('221bfb4154f2d788facc9844af4f90e6_8', 2021, 'dusunMALILI', 8, '2021-03-03', 'Hasnah,S.Kep.Ns', '19770320 200050 2  004', 'Safaruddin,S.Kep,Ns', '19761001 199503 1 002');

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `file_tokens`
--

CREATE TABLE `file_tokens` (
  `id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expires_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `file_tokens`
--

INSERT INTO `file_tokens` (`id`, `file_name`, `token`, `expires_at`) VALUES
(1, 'paket_a_kkbaru_721282017_20250414174105_77453307-bec3-4436-903c-3428bbad59f_1744644734.jpg', '44795f16eb13116259ceeefa60ac2dba', '2025-04-15 00:32:22'),
(2, 'paket_a_kkbaru_721282017_20250414174105_77453307-bec3-4436-903c-3428bbad59f_1744644734.jpg', 'ad3685c0d2e6bb13ec5723c277f335af', '2025-04-15 00:37:08'),
(3, 'paket_a_aktalahirbaru_721282017_20250414174105_77453307-bec3-4436-903c-3428bbad59f_1744644736.jpg', '5f6cb20109c9c34e1241ec4ed006d086', '2025-04-15 00:37:08'),
(4, 'paket_a_kiabaru_721282017_20250414174105_77453307-bec3-4436-903c-3428bbad59f_1744644738.jpg', 'c27f94e359e88cb328b131838254273b', '2025-04-15 00:37:08'),
(6, 'paket_a_aktalahirbaru_721282017_20250414174105_77453307-bec3-4436-903c-3428bbad59f_1744644736.jpg', 'f1d7711132d43ee4346e572de10683dd', '2025-04-15 00:40:50'),
(7, 'paket_a_kiabaru_721282017_20250414174105_77453307-bec3-4436-903c-3428bbad59f_1744644738.jpg', 'ecb956047dbfa557daf7986e6cfb7b69', '2025-04-15 00:40:50'),
(8, 'paket_b_kkbaru_721282017_20250415002022_ea1b2a6b-7e22-47a9-9078-175c9544470_1744647741.jpg', '618bef48943fa25f95c8eaea239c181a', '2025-04-15 01:22:27'),
(9, 'paket_b_aktamatibaru_721282017_20250415002022_ea1b2a6b-7e22-47a9-9078-175c9544470_1744647744.jpg', '84fa6455095622a7c4b3bfa81e27486b', '2025-04-15 01:22:27'),
(10, 'paket_b_kkbaru_721282016_20250412130626_f927a4f7-1e92-4d3e-a27a-184b359953a_1744649176.png', '177c48ff0265eb354080eb9d1530db97', '2025-04-15 01:46:28'),
(11, 'paket_b_aktamatibaru_721282016_20250412130626_f927a4f7-1e92-4d3e-a27a-184b359953a_1744649188.pdf', '94220bf55fb77f0876b8fceb1c4c8ec6', '2025-04-15 01:46:28'),
(13, 'paket_b_aktamatibaru_721282016_20250412012001_0d303b4e-d6c8-4a98-8efa-0e5ab30c75b_1744649868.jpg', 'db380c82c9f3e9cb35ba035b6c5d988a', '2025-04-15 01:57:52'),
(14, 'paket_b_laindukcapil_721282016_20250412012001_0d303b4e-d6c8-4a98-8efa-0e5ab30c75b_1744649870.pdf', '1822b9fc49f7bfb2eac0611d81179f2f', '2025-04-15 01:57:52'),
(18, 'paket_e_kia_721272004_20250416193743_6de191c8-a894-4de0-9c77-5bc64ac8acfd_1744803590.png', 'kia_veeya_6749ec17d0a58a9fbd5f1a7f983e646c', '2025-04-16 23:12:33'),
(19, 'paket_e_kia_721272004_20250416193743_6de191c8-a894-4de0-9c77-5bc64ac8acfd_1744803590.png', 'kia_veeya_955584fcf35f3844e3660375ff76df3a', '2025-04-16 23:13:38'),
(20, 'paket_a_kkbaru_721282009_20250416000627_b5f6ffc7-5b1b-459c-b1b9-1bb934e84d1_1744812837.jpg', 'akta_kelahiran_pak_charels_3107256fe63880b377de1445c98fd799', '2025-04-16 23:14:02'),
(21, 'paket_a_aktalahirbaru_721282009_20250416000627_b5f6ffc7-5b1b-459c-b1b9-1bb934e84d1_1744812839.jpg', 'kartu_keluarga_pak_charels_9effdb377c99d277c92fcbc53c057e24', '2025-04-16 23:14:02'),
(22, 'paket_a_kiabaru_721282009_20250416000627_b5f6ffc7-5b1b-459c-b1b9-1bb934e84d1_1744812841.jpg', 'kia_(kartu_identitas_anak)_pak_charels_7aa70e375327d3dde584a4eb06103500', '2025-04-16 23:14:02'),
(23, 'paket_b_kkbaru_721282016_20250410151359_b213c198-1d2a-4d59-a514-03f20c28b9c_1744296983.png', 'kartu_keluarga_oksi_3a284e8713c88683f06439da283b908d', '2025-04-17 22:19:26'),
(24, 'paket_b_aktamatibaru_721282016_20250410151359_b213c198-1d2a-4d59-a514-03f20c28b9c_1744299567.pdf', 'akta_kematian_oksi_d3bf75044d3db0ae57af995c62829b1f', '2025-04-17 22:19:26'),
(25, 'paket_b_laindukcapil_721282016_20250410151359_b213c198-1d2a-4d59-a514-03f20c28b9c_1744299657.png', 'file_lainnya_oksi_9276edf87a48ca04ccbae0e48af0635d', '2025-04-17 22:19:26'),
(26, 'paket_e_kia_721272004_20250416193743_6de191c8-a894-4de0-9c77-5bc64ac8acfd_1744896614.jpg', 'kia_veeya_a3c6fd6fc4247627c970ec4137115871', '2025-04-17 22:30:15'),
(27, 'paket_f_skpwni_721282016_20250418002335_3569b933-17bf-45bf-a6af-f9b589f4f490_1744910512.jpg', 'surat_keterangan_pindah_wni_&_wna_dalam_wilayah_nkri_(skpwni/skpoa)_indrayati_6e3ae2ed66fd4e66c6ea29ba8efaa595', '2025-04-18 02:21:53'),
(28, 'paket_f_skpwni_721282016_20250418002335_3569b933-17bf-45bf-a6af-f9b589f4f490_1744910512.jpg', 'surat_keterangan_pindah_wni_&_wna_dalam_wilayah_nkri_(skpwni/skpoa)_indrayati_7d55d29b6c53bbd19b8ace7838a21e52', '2025-04-18 02:57:54'),
(29, 'paket_f_skpwni_721282016_20250418002335_3569b933-17bf-45bf-a6af-f9b589f4f490_1744910512.jpg', 'surat_keterangan_pindah_wni_&_wna_dalam_wilayah_nkri_(skpwni/skpoa)_indrayati_1f73c7cce94ca28837658e7613e300b0', '2025-04-18 03:10:19'),
(30, 'paket_f_skpwni_721282016_20250418002335_3569b933-17bf-45bf-a6af-f9b589f4f490_1744913944.pdf', 'surat_keterangan_pindah_wni_&_wna_dalam_wilayah_nkri_(skpwni/skpoa)_indrayati_568d073a45e914817661104ded887f15', '2025-04-18 03:19:05'),
(31, 'paket_f_skpwni_721282016_20250418002335_3569b933-17bf-45bf-a6af-f9b589f4f490_1744913944.pdf', 'suratketeranganpindahwniwnadalamwilayahnkriskpwniskpoa_indrayati_aa06c2a78f7141dd06c628d4dd0fa201', '2025-04-18 03:26:49'),
(32, 'paket_g_skpd_721282016_20250419095107_78f39c9d-a149-4e96-ae98-fc020310247b_1745027628.pdf', 'suratketeranganpindahdatangskpd_ruke_755a1949832ea09e330c4c6650356b84', '2025-04-19 10:53:49'),
(34, 'paket_h_skttl_721282003_20250420210745_07adcf1c-c1d1-493d-8262-ae64f289724b_1745155408.png', 'suratketerangantempattinggalwna_imran_5faed8fc028cd3a54e03eb4500f9b958', '2025-04-20 22:23:29'),
(35, 'paket_i_aktalahir_721282003_20250420225018_1c008f3e-b47b-4492-8035-c55690b1cdaa_1745160863.png', 'aktakelahiran_asjayanto_863a28d9e4d5af32a5899ad47c018f25', '2025-04-20 23:54:24'),
(37, 'paket_k_ralatlahir_721222012_20250422233151_925d8a3e-e261-4e31-b9eb-1abea2a63f09_1745336196.pdf', 'dokumenralatduplikataktakelahiran_hasim_04fc4f8a107b8687b4224e66a733c842', '2025-04-23 00:36:59'),
(38, 'paket_b_kkbaru_721282016_20250412012001_0d303b4e-d6c8-4a98-8efa-0e5ab30c75b_1744649866.pdf', 'kartukeluarga_amboangka_485976f17008f3e3b71d829f04e91a4d', '2025-04-23 02:10:03'),
(39, 'paket_b_aktamatibaru_721282016_20250412012001_0d303b4e-d6c8-4a98-8efa-0e5ab30c75b_1744649868.jpg', 'aktakematian_amboangka_4454b35796c46e4559adabdb40c23dab', '2025-04-23 02:10:03'),
(40, 'paket_j_aktamati_721282016_20250423231421_c551014b-93a4-44c1-91f0-ed8db34287e3_1745422177.png', 'aktakematian_ladusin_581df3db85d011d69acbbc03b7b46a59', '2025-04-24 00:29:38'),
(41, 'paket_g_skpd_721282016_20250423233428_b7d71e30-0e1e-4efe-940c-2e72a4390d37_1745423007.png', 'suratketeranganpindahdatangskpd_lutfi_a43c4ac746491bd1b77defcd33b5852d', '2025-04-24 00:43:28'),
(42, 'paket_l_ralatmati_721252002_20250424002736_7d920174-873e-4d99-818a-00defafeb533_1745426884.pdf', 'dokumenralatduplikataktakematian_lakanude_d6c8ca85f9310749d780bad534049c12', '2025-04-24 01:48:08'),
(43, 'paket_l_ralatmati_721252002_20250424002736_7d920174-873e-4d99-818a-00defafeb533_1745426884.pdf', 'dokumenralatduplikataktakematian_lakanude_f78662f03c321ff94902d8844e281326', '2025-04-24 02:00:01'),
(44, 'paket_l_ralatmati_721252002_20250424002736_7d920174-873e-4d99-818a-00defafeb533_1745426884.pdf', 'dokumenralatduplikataktakematian_lakanude_ced5ccfb2619c551ef5072819d10132f', '2025-04-24 02:04:05'),
(45, 'paket_l_ralatmati_721252002_20250424002736_7d920174-873e-4d99-818a-00defafeb533_1745426884.pdf', 'dokumenralatduplikataktakematian_lakanude_13ba8e810b1c7e9c21e2636d973ca8ab', '2025-04-24 02:09:28'),
(46, 'paket_l_ralatmati_721252002_20250424002736_7d920174-873e-4d99-818a-00defafeb533_1745426884.pdf', 'dokumenralatduplikataktakematian_lakanude_7db492d863cead11d5b1d92cc3d59aef', '2025-04-24 02:15:17'),
(47, 'paket_l_ralatmati_721252002_20250424002736_7d920174-873e-4d99-818a-00defafeb533_1745426884.pdf', 'dokumenralatduplikataktakematian_lakanude_899bc38ec5e47032aca836e57d43ac91', '2025-04-24 02:15:41'),
(48, 'paket_l_ralatmati_721252002_20250424002736_7d920174-873e-4d99-818a-00defafeb533_1745426884.pdf', 'dokumenralatduplikataktakematian_lakanude_1b6e8671a8133375d575835aba452a85', '2025-04-24 02:23:24'),
(49, 'paket_m_aktakawin_721252002_20250429180102_9fe5497f-63c7-43cf-ab3e-51686d350f09_1745920942.pdf', 'aktaperkawinan_albertperes_0540cfd1bfd3ee01783ec9e4d1afb130', '2025-04-29 19:02:29'),
(50, 'paket_n_kawino_721252002_20250429193036_89567dc0-227a-4338-9b57-57eb0a89ef57_1745926318.pdf', 'perkawinanperceraiandiluarnegeri_rachel_b2a0abf82a7c409007de5be41fa628b9', '2025-04-29 20:32:00'),
(51, 'paket_o_aktacerai_721252002_20250429194220_02346ce2-8544-46bf-9726-4765679f260f_1745927013.pdf', 'aktaperceraian_settingan_a4ef472937ff9fc181137a6a7e61e78a', '2025-04-29 20:44:13'),
(52, 'paket_p_kkbaru_721252002_20250430012903_d85fce0f-35bb-44c1-86ac-cf6d612cd9d6_1745948284.pdf', 'kartukeluarga_megawati_1d402ac99602901b79f279686ac7da0f', '2025-04-30 02:38:13'),
(53, 'paket_b_kkbaru_721252002_20250430145738_6b91c788-d3d4-4755-8cbe-ef2772cfed62_1745996340.jpg', 'kartukeluarga_tes_667303469b123c2c1c466192dbacf787', '2025-04-30 15:59:33'),
(54, 'paket_b_aktamatibaru_721252002_20250430145738_6b91c788-d3d4-4755-8cbe-ef2772cfed62_1745996367.jpg', 'aktakematian_tes_9de693fbd9e394961c3091177a676865', '2025-04-30 15:59:33'),
(55, 'paket_b_laindukcapil_721252002_20250430145738_6b91c788-d3d4-4755-8cbe-ef2772cfed62_1745996355.png', 'filelainnya_tes_49c748e71ac5bf3538b08f0658a7c702', '2025-04-30 15:59:33'),
(56, 'paket_q_kkbaru_721252002_20250430193522_9d0b1a67-bb92-4c99-bd22-31cbe265f480_1746013085.pdf', 'kartukeluarga_irwan_6bca67236317b1f1446d312414fa72fa', '2025-04-30 20:38:08'),
(57, 'paket_r_kkbaru_721252002_20250430232123_c1b94c2b-9ece-4681-913b-fc5a97c75500_1746026539.pdf', 'kartukeluarga_alrbet_02b003e14857d66bb566fad915c41e2d', '2025-05-01 00:22:20'),
(58, 'paket_a_kkbaru_721211003_20250501191133_6f6b7582-88f9-45eb-b394-62ab3a30ac5f_1746104570.png', 'aktakelahiran_samudra_8c32316ba39f8216cb65bcae80cbae08', '2025-05-01 22:03:09'),
(59, 'paket_a_aktalahirbaru_721211003_20250501191133_6f6b7582-88f9-45eb-b394-62ab3a30ac5f_1746104573.pdf', 'kartukeluarga_samudra_589e6df1852076e96d8278d02f0b18ba', '2025-05-01 22:03:09'),
(60, 'paket_a_kiabaru_721211003_20250501191133_6f6b7582-88f9-45eb-b394-62ab3a30ac5f_1746104575.png', 'kiakartuidentitasanak_samudra_7cfa42126a3152ad31e01d0942dd43ab', '2025-05-01 22:03:09'),
(61, 'paket_b_kkbaru_721211003_20250502000526_9298f5ce-7dc7-417e-b9f9-ba5cb2665936_1746117258.pdf', 'kartukeluarga_yudi_0930f02e16c82263ab1bba1f34780e38', '2025-05-02 01:34:25'),
(62, 'paket_b_aktamatibaru_721211003_20250502000526_9298f5ce-7dc7-417e-b9f9-ba5cb2665936_1746117251.pdf', 'aktakematian_yudi_07d2ff756bc571f0cc4c327427e464c4', '2025-05-02 01:34:25'),
(63, 'paket_b_laindukcapil_721211003_20250502000526_9298f5ce-7dc7-417e-b9f9-ba5cb2665936_1746117254.pdf', 'filelainnya_yudi_ad85660fdcc3095d0445a242390b5408', '2025-05-02 01:34:25'),
(64, 'paket_t_skpln_721211003_20250503002112_9361b717-87e6-4104-9e22-df0cee18fa4c_1746206244.pdf', 'suratketeranganpindahwnikeluarwilayahnkriskpln_iwan_87d5a69be26a83405681dc58a9a99c4a', '2025-05-03 02:17:25'),
(65, 'paket_i_aktalahir_721272007_20250504205315_d64fb5fa-9c4c-42fb-b360-8505986ad268_1746363363.jpg', 'aktakelahiran_tika_ae223a21beb486da9040e23532014473', '2025-05-04 21:56:05'),
(66, 'paket_i_aktalahir_721242001_20250509014246_5f65b85d-fa13-40f7-8d30-11a44f02d3d8_1746726358.png', 'aktakelahiran_jsnsns_f2ca56d7c94870da48fb3e8bfe078849', '2025-05-09 02:46:02'),
(67, 'paket_i_aktalahir_721242001_20250509014246_5f65b85d-fa13-40f7-8d30-11a44f02d3d8_1746726358.png', 'aktakelahiran_jsnsns_c942abbf240989dc7b5cdfcde88fc08e', '2025-05-09 02:52:12'),
(68, 'paket_a_aktalahirbaru_721272007_20250511210422_394346fb-20fd-49e2-a28a-205adfb43cc8_1746980927.png', 'aktakelahiran_basoirwansakti_7e76c6b84ead0c4dc12530eb1be70a0d', '2025-05-12 01:29:02'),
(69, 'paket_a_kkbaru_721272007_20250511210422_394346fb-20fd-49e2-a28a-205adfb43cc8_1746980929.png', 'kartukeluarga_basoirwansakti_d16b1ab56652064cc425366df1c8f63c', '2025-05-12 01:29:02'),
(70, 'paket_a_kiabaru_721272007_20250511210422_394346fb-20fd-49e2-a28a-205adfb43cc8_1746980937.png', 'kiakartuidentitasanak_basoirwansakti_96f53d75aca590fefb68a60217684cae', '2025-05-12 01:29:02'),
(71, 'paket_a_aktalahirbaru_721272007_20250511210422_394346fb-20fd-49e2-a28a-205adfb43cc8_1746980927.png', 'aktakelahiran_basoirwansakti_eb525d5c2e9076edbf59a817feef5f49', '2025-05-12 02:11:46'),
(72, 'paket_a_kkbaru_721272007_20250511210422_394346fb-20fd-49e2-a28a-205adfb43cc8_1746980929.png', 'kartukeluarga_basoirwansakti_ed61c812aa3cc40c05d86bb07808500d', '2025-05-12 02:11:46'),
(73, 'paket_a_aktalahirbaru_721272007_20250511210422_394346fb-20fd-49e2-a28a-205adfb43cc8_1746980927.png', 'aktakelahiran_basoirwansakti_6d91fe0e175a9700327596ff3cdfeef2', '2025-05-12 02:13:28'),
(74, 'paket_a_kkbaru_721272007_20250511210422_394346fb-20fd-49e2-a28a-205adfb43cc8_1746980929.png', 'kartukeluarga_basoirwansakti_5aea70ac04c347505c99384d8a17b6c8', '2025-05-12 02:13:28'),
(75, 'paket_a_aktalahirbaru_721272007_20250511210422_394346fb-20fd-49e2-a28a-205adfb43cc8_1746980927.png', 'aktakelahiran_basoirwansakti_8f5cf6a527bdfea059e338473ce99f0a', '2025-05-12 02:17:07'),
(76, 'paket_a_kkbaru_721272007_20250511210422_394346fb-20fd-49e2-a28a-205adfb43cc8_1746980929.png', 'kartukeluarga_basoirwansakti_90149f6e47a84ee2018bb1f050764b10', '2025-05-12 02:17:07');

-- --------------------------------------------------------

--
-- Table structure for table `identitas`
--

CREATE TABLE `identitas` (
  `id_identitas` int(11) NOT NULL,
  `nama_website` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `url` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `facebook` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `twitter` varchar(255) NOT NULL,
  `instagram` varchar(255) NOT NULL,
  `youtube` varchar(255) NOT NULL,
  `rekening` varchar(100) NOT NULL,
  `no_telp` varchar(20) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `telp` varchar(50) NOT NULL,
  `meta_deskripsi` varchar(250) NOT NULL,
  `meta_keyword` varchar(250) NOT NULL,
  `favicon` varchar(50) NOT NULL,
  `maps` text NOT NULL,
  `waktu` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `type` varchar(100) NOT NULL,
  `credits` varchar(100) NOT NULL,
  `kabupaten` varchar(100) NOT NULL,
  `propinsi` varchar(100) NOT NULL,
  `kadis` varchar(100) NOT NULL,
  `nip_kadis` varchar(100) NOT NULL,
  `kepala_seksi` varchar(100) NOT NULL,
  `nip_kepala_seksi` varchar(100) NOT NULL,
  `kabid` varchar(100) DEFAULT NULL,
  `nip_kabid` varchar(100) DEFAULT NULL,
  `tahun_awal` int(11) DEFAULT NULL,
  `tahun_akhir` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `identitas`
--

INSERT INTO `identitas` (`id_identitas`, `nama_website`, `email`, `url`, `facebook`, `twitter`, `instagram`, `youtube`, `rekening`, `no_telp`, `telp`, `meta_deskripsi`, `meta_keyword`, `favicon`, `maps`, `waktu`, `alamat`, `type`, `credits`, `kabupaten`, `propinsi`, `kadis`, `nip_kadis`, `kepala_seksi`, `nip_kepala_seksi`, `kabid`, `nip_kabid`, `tahun_awal`, `tahun_akhir`) VALUES
(1, 'SiDia', 'onh4cker@gmail.com', 'http://localhost/sidia/', '', 'https://twitter.com/KotaPpdb', 'https://www.instagram.com/ppdb_makassar/', 'https://www.youtube.com/channel/UCDIbtyXMczhrTj4pG01kBHQ', 'SULAWESI SELATAN', '081241158909', '(0411) 458233', '', 'Sistem Informasi Digitalisasi Adminduk', 'favicon.png', '', 'Asia/Makassar', 'Kolonodale', 'Dinas', 'Onhacker,https://root.net/', 'Morowali Utara', 'SULAWESI SELATAN', 'dr.Hj.ROSMINI PANDIN,MARS', '196909092001122001', '', '', 'ALFRIDA LEMBANG, SKM', '196912101991032016', 2019, 0);

-- --------------------------------------------------------

--
-- Table structure for table `im_ibu`
--

CREATE TABLE `im_ibu` (
  `id_ibu` int(11) NOT NULL,
  `no_kia` varchar(16) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jk` enum('L','P') NOT NULL DEFAULT 'P',
  `tempat_lahir` varchar(100) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `golda` varchar(2) NOT NULL,
  `id_agama` int(11) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `tempat_pelayanan` varchar(100) NOT NULL,
  `id_pekerjaan_ibu` int(11) DEFAULT NULL,
  `id_desa` varchar(50) NOT NULL,
  `create_date` date NOT NULL,
  `create_time` varchar(20) NOT NULL,
  `username` varchar(100) NOT NULL,
  `id_dusun` int(11) NOT NULL,
  `tahun` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_uca1400_ai_ci;

--
-- Dumping data for table `im_ibu`
--

INSERT INTO `im_ibu` (`id_ibu`, `no_kia`, `nama`, `jk`, `tempat_lahir`, `tgl_lahir`, `golda`, `id_agama`, `alamat`, `tempat_pelayanan`, `id_pekerjaan_ibu`, `id_desa`, `create_date`, `create_time`, `username`, `id_dusun`, `tahun`) VALUES
(10, '0032', 'ina', 'P', 'malili', '1984-06-05', 'A', 1, 'SPT2', '', 2, '73_24_3_2002', '2020-10-23', '21:08:23', 'dusunMAHALONA', 17, 2020),
(11, '7324038108860001', 'Devi', 'P', 'Tampang', '1990-08-21', 'A', 1, 'jJl.Pattimura No.9', '', 2, '73_24_3_2003', '2020-12-03', '14:50:43', 'dusunTIMAMPU', 15, 2020),
(12, '7324044101800008', 'NURHAEDA', 'P', 'KAREBBE', '1980-01-01', 'O', 1, 'DESA LASKAP', '', 2, '73_24_4_2002', '2020-12-12', '12:08:44', 'dusunLAMPIA', 9, 2020),
(13, '7324044107830028', 'HASLINDA', 'P', 'PASI-PASI', '1983-07-01', 'AB', 1, 'DESA PASI-PASI', '', 2, '73_24_4_2014', '2020-12-12', '12:11:33', 'dusunLAMPIA', 9, 2020),
(14, '7308274107910066', 'IRMA DAMAYANI', 'P', 'UJUNG PANDANG', '1991-01-17', 'O', 1, 'DSN PASI-PASI', '', 2, '73_24_4_2014', '2020-12-14', '20:06:16', 'dusunLAMPIA', 9, 2020),
(15, '7324045804860001', 'SULAEHA', 'P', 'MALILI', '1986-04-18', 'O', 1, 'DSN HULUPADANG', '', 2, '73_24_4_2012', '2020-12-14', '20:09:00', 'dusunLAMPIA', 9, 2020),
(16, '7324044605880001', 'EVA DAMAYANTI', 'P', 'LAMPIA', '1988-05-06', 'O', 1, 'JLN  POROS SULAWESI TENGGARA', '', 2, '73_24_7_2018', '2020-12-14', '20:13:17', 'dusunLAMPIA', 9, 2020),
(17, '7324045305880001', 'SAHERIYAH', 'P', 'BURIKO', '1988-05-13', 'O', 1, 'DSN PASI-PASI', '', 2, '73_24_4_2014', '2020-12-14', '20:15:33', 'dusunLAMPIA', 9, 2020),
(18, '7408145102000001', 'LINDA ARISKA', 'P', 'PASI-PASI', '2000-07-01', 'O', 1, 'DSN PASI-PASI', '', 2, '73_24_4_2014', '2020-12-14', '20:18:29', 'dusunLAMPIA', 9, 2020),
(19, '7324045508930005', 'ELVI WIJAYA', 'P', 'TATOR', '1993-08-15', 'O', 1, 'DSN LABOSE', '', 2, '73_24_4_2002', '2020-12-14', '20:22:33', 'dusunLAMPIA', 9, 2020),
(20, '7324045009940002', 'YANI JULAEHA', 'P', 'LAMPIA', '1994-09-10', 'O', 1, 'DSN MAKARTI', '', 2, '73_24_7_2018', '2020-12-14', '20:25:59', 'dusunLAMPIA', 9, 2020),
(21, '7324046505950006', 'NURHIKMA', 'P', 'KAREBBE', '1995-05-25', 'AB', 1, 'DSN KAREBBE', '', 15, '73_24_4_2002', '2020-12-14', '20:29:00', 'dusunLAMPIA', 9, 2020),
(22, '7313074803940001', 'SYAMSINAR', 'P', 'PONGKERU', '1994-03-18', 'A', 1, 'DSN SALOSIKAMBAR', '', 85, '73_24_4_2012', '2020-12-14', '20:33:48', 'dusunLAMPIA', 9, 2020),
(23, '7324044312990002', 'ASRIANI', 'P', 'PASI-PASI', '1999-12-13', 'AB', 1, 'DSN. PASI-PASI', '', 1, '73_24_4_2014', '2020-12-20', '19:57:11', 'dusunLAMPIA', 9, 2020),
(24, '7324044107780053', 'UMI SALMA HORNAI', 'P', 'TRANS', '1978-07-11', 'O', 1, 'TRANS', '', 1, '73_24_7_2018', '2020-12-20', '19:59:47', 'dusunLAMPIA', 9, 2020),
(25, '7324045003940002', 'HASNAWATI', 'P', 'LUWU TIMUR', '1994-03-10', 'O', 1, 'DSN LABOSE', '', 2, '73_24_4_2002', '2020-12-20', '20:01:58', 'dusunLAMPIA', 9, 2020),
(26, '7324047112780008', 'DARMAWATI', 'P', 'LUWU TIMUR', '1978-12-17', 'O', 1, 'DSN.PASI-PASI', '', 2, '73_24_4_2014', '2020-12-20', '20:03:48', 'dusunLAMPIA', 9, 2020),
(27, '7324024405900001', 'WAKIANG', 'P', 'LUWU TIMUR', '1990-05-14', 'O', 1, 'DSN LAMPIA', '', 2, '73_24_7_2018', '2020-12-20', '20:05:51', 'dusunLAMPIA', 9, 2020),
(28, '7324114504770002', 'DARMAWATI', 'P', 'LUWU TIMUR', '1977-04-15', 'B', 1, 'DSN. HULUPADANG', '', 2, '73_24_4_2012', '2020-12-20', '20:08:01', 'dusunLAMPIA', 9, 2020),
(29, '7324064107860036', 'MAHIRAWATI', 'P', 'LUWU TIMUR', '1986-12-20', 'O', 1, 'DSN. SALOSIKAMBAR', '', 1, '73_24_4_2012', '2020-12-20', '20:10:06', 'dusunLAMPIA', 9, 2020),
(30, '7324045612820001', 'YERNI', 'P', 'LUWU TIMUR', '1982-12-26', 'B', 1, 'DSN KAREBBE', '', 2, '73_24_4_2002', '2020-12-20', '20:11:45', 'dusunLAMPIA', 9, 2020),
(31, '7317057008920001', 'SARTIKA', 'P', 'TENGGARA', '1992-08-27', 'O', 1, 'DSN. HULUPADANG', '', 2, '73_24_4_2012', '2020-12-20', '20:13:37', 'dusunLAMPIA', 9, 2020),
(32, '7324055008900002', 'SANTI', 'P', 'KAREBBE', '1990-08-10', 'O', 1, 'DSN KAREBBE', '', 2, '73_24_4_2002', '2020-12-20', '20:15:16', 'dusunLAMPIA', 9, 2020),
(33, '7308234908960001', 'HILDA', 'P', 'BONE', '1996-08-19', 'O', 1, 'JLN POROS SULAWESI TENGGARA', '', 74, '73_24_7_2018', '2020-12-20', '20:17:48', 'dusunLAMPIA', 9, 2020),
(34, '7324045601000001', 'KARMILA', 'P', 'LUWU TIMUR', '2000-10-01', 'O', 1, 'DSN KAREBBE', '', 2, '73_24_4_2002', '2020-12-20', '20:20:43', 'dusunLAMPIA', 9, 2020),
(35, '5307084107800055', 'MARIA YASINTA', 'P', 'TORAJA', '1980-07-11', 'O', 2, 'DSN KAREBBE', '', 2, '73_24_4_2002', '2020-12-20', '20:25:24', 'dusunLAMPIA', 9, 2020),
(36, '7324045508910002', 'SARTIKA', 'P', 'LUWU TIMUR', '1991-08-25', 'A', 1, 'DSN LAMPIA', '', 2, '73_24_7_2018', '2020-12-20', '20:27:20', 'dusunLAMPIA', 9, 2020),
(37, '7324044102850001', 'HAMDANA', 'P', 'LUWU TIMUR', '1985-02-14', 'O', 1, 'DSN TRANS', '', 0, '73_24_7_2018', '2020-12-20', '20:29:05', 'dusunLAMPIA', 9, 2020),
(38, '7324044204950001', 'AYU LESTARI', 'P', 'LAMPIA', '1995-04-12', 'O', 1, 'JLN POROS SULAWESI TENGGARA', '', 2, '73_24_7_2018', '2020-12-20', '20:30:51', 'dusunLAMPIA', 9, 2020),
(39, '7373045509000002', 'PIRDA', 'P', 'LUWU TIMUR', '2000-09-25', 'O', 1, 'DSN PASI-PASI', '', 2, '73_24_4_2014', '2020-12-20', '20:32:34', 'dusunLAMPIA', 9, 2020),
(40, '3208154205750004', 'ROSMALA DEWI', 'P', 'TENGGARA', '1975-05-12', 'B', 1, 'DSN HULUPADANG', '', 2, '73_24_4_2012', '2020-12-20', '20:34:44', 'dusunLAMPIA', 9, 2020),
(41, '7324044505970001', 'WANDA SARI', 'P', 'LAMPIA', '1997-05-15', 'A', 1, 'LAMPIA', '', 2, '73_24_7_2018', '2020-12-20', '20:36:33', 'dusunLAMPIA', 9, 2020),
(42, '7324045601970001', 'SALMA RAMADANI', 'P', 'LABOSE', '1997-01-26', 'O', 1, 'DSN LABOSE', '', 2, '73_24_4_2002', '2020-12-20', '20:38:20', 'dusunLAMPIA', 9, 2020),
(43, '7324044306920001', 'SINAR SURIANI', 'P', 'PONGKERU', '1992-06-13', 'AB', 1, 'DSN SALOSIKAMBAR', '', 85, '73_24_4_2012', '2020-12-20', '20:40:51', 'dusunLAMPIA', 9, 2020),
(44, '7324045212850002', 'DARMAWATI', 'P', 'LAMPIA', '1985-12-22', 'A', 1, 'LAMPIA', '', 2, '73_24_7_2018', '2020-12-20', '20:42:51', 'dusunLAMPIA', 9, 2020),
(45, '7324045809850002', 'ARPIATI ARSYAD', 'P', 'PASI-PASI', '1985-09-28', 'A', 1, 'DSN PASI-PASI', '', 85, '73_24_4_2014', '2020-12-20', '20:44:57', 'dusunLAMPIA', 9, 2020),
(46, '7324044101960014', 'NUR FAIDAH CINDHI', 'P', 'LAMPIA', '1996-01-11', 'A', 1, 'DSN SALOMABOMBONG', '', 18, '73_24_4_2014', '2020-12-20', '20:47:06', 'dusunLAMPIA', 9, 2020),
(47, '7324044106870003', 'ANITA', 'P', 'LAMPIA', '1987-06-04', 'AB', 1, 'LAMPIA', '', 49, '73_24_7_2018', '2020-12-20', '20:49:01', 'dusunLAMPIA', 9, 2020),
(48, '7324046506990001', 'SRI UTAMI', 'P', 'LAMPIA', '1999-06-15', 'A', 1, 'LAMPIA', '', 1, '73_24_7_2018', '2020-12-20', '20:50:29', 'dusunLAMPIA', 9, 2020),
(49, '7324044406840001', 'SURIANI', 'P', 'KAREBBE', '1984-06-24', 'O', 1, 'KAREBBE', '', 2, '73_24_4_2002', '2020-12-20', '20:52:03', 'dusunLAMPIA', 9, 2020),
(50, '7324045407890001', 'DEWI SARTIKA', 'P', 'LABOSE', '1989-07-20', 'B', 1, 'LABOSE', '', 2, '73_24_4_2002', '2020-12-20', '20:53:37', 'dusunLAMPIA', 9, 2020),
(51, '7324046008000003', 'RAMDANA MOGA', 'P', 'LAMPIA', '2000-08-16', 'B', 1, 'TRANS', '', 2, '73_24_7_2018', '2020-12-20', '20:55:26', 'dusunLAMPIA', 9, 2020),
(52, '7324046104990002', 'IDA LAILA MORERA', 'P', 'LAMPIA', '1999-04-10', 'O', 1, 'LAMPIA', '', 1, '73_24_7_2018', '2020-12-20', '20:58:52', 'dusunLAMPIA', 9, 2020),
(53, '7324045708920003', 'NURLELA', 'P', 'LAMPIA', '1992-08-17', 'O', 1, 'LAMPIA', '', 2, '73_24_7_2018', '2020-12-20', '21:06:45', 'dusunLAMPIA', 9, 2020),
(54, '732404421000003', 'IKA HASTUTI', 'P', 'LAMPIA', '2000-10-22', 'O', 1, 'LAMPIA', '', 1, '73_24_7_2018', '2020-12-20', '21:08:47', 'dusunLAMPIA', 9, 2020),
(55, '7324046812940003', 'NURUL IKHWANA', 'P', 'PONGKERU', '1994-12-28', 'O', 1, 'DSN SALOSIKAMBAR', '', 2, '73_24_4_2012', '2020-12-20', '21:10:46', 'dusunLAMPIA', 9, 2020),
(56, '7324044102850002', 'HIJRA', 'P', 'PONGKERU', '1985-02-11', 'A', 1, 'DSN HULUPADANG', '', 2, '73_24_4_2012', '2020-12-20', '21:12:28', 'dusunLAMPIA', 9, 2020),
(57, '731007430682001', 'RAMLAWATI', 'P', 'MAKASSAR', '1982-06-23', 'AB', 1, 'DSN PASI-PASI', '', 2, '73_24_4_2014', '2021-01-02', '07:11:10', 'dusunLAMPIA', 9, 2020),
(58, '7324045907920002', 'FITRI', 'P', 'HARAPAN', '1992-07-19', 'A', 1, 'DSN LAOLI', '', 2, '73_24_7_2018', '2021-01-02', '07:15:25', 'dusunLAMPIA', 9, 2020),
(59, '7324065611950001', 'RISKA MARE', 'P', 'PONGKERU', '1995-11-16', 'AB', 1, 'DSN KAWASULE', '', 2, '73_24_4_2012', '2021-01-02', '07:17:10', 'dusunLAMPIA', 9, 2020),
(60, '7324045708990001', 'FATMAWATI', 'P', 'LUWU TIMUR', '1999-08-17', 'A', 1, 'LAMPIA', '', 2, '73_24_7_2018', '2021-01-02', '07:18:41', 'dusunLAMPIA', 9, 2020),
(61, '7324045504900002', 'ANDI NASRIPA', 'P', 'PASI-PASI', '1990-04-25', 'O', 1, 'DSN PASI-PASI', '', 2, '73_24_4_2014', '2021-01-02', '07:21:00', 'dusunLAMPIA', 9, 2020),
(62, '7302096007940005', 'NINIS YULIANTI', 'P', 'JAWA', '1994-07-20', 'O', 1, 'DSN LAMPIA', '', 2, '73_24_7_2018', '2021-01-02', '07:23:05', 'dusunLAMPIA', 9, 2020),
(63, '7324046704940001', 'NAGA ULENG', 'P', 'LAMPIA', '1994-04-27', 'A', 1, 'DSN LAMPIA', '', 2, '73_24_7_2018', '2021-01-02', '07:25:02', 'dusunLAMPIA', 9, 2020),
(64, '7324046606960007', 'SITTI SAKIA JAMAL', 'P', 'KAREBBE', '1996-06-26', 'O', 1, 'DSN KAREBBE', '', 2, '73_24_4_2002', '2021-01-02', '07:28:38', 'dusunLAMPIA', 9, 2020),
(66, '7324044504870003', 'ESTER', 'P', 'PONGKERU', '1987-04-25', 'O', 2, 'DSN HULUPADANG', '', 2, '73_24_4_2012', '2021-01-02', '07:32:34', 'dusunLAMPIA', 9, 2020),
(67, '7317144510890001', 'DEWI SARTIKA', 'P', 'LUWU TIMUR', '1989-10-25', '-', 1, 'DSN KAREBBE', '', 0, '73_24_4_2002', '2021-01-02', '07:34:10', 'dusunLAMPIA', 9, 2020),
(68, '7317215703980001', 'PISMAWATI', 'P', 'LAMPIA', '1998-03-27', 'A', 1, 'DSN LAMPIA', '', 2, '73_24_7_2018', '2021-01-02', '07:36:28', 'dusunLAMPIA', 9, 2020),
(69, '7324044107990016', 'HARMAWATI', 'P', 'LUWU TIMUR', '1999-07-21', 'A', 1, 'DSN LAMPIA', '', 2, '73_24_7_2018', '2021-01-03', '08:22:29', 'dusunLAMPIA', 9, 2020),
(70, '7324046701990002', 'DESY RATNASARI', 'P', 'LUWU TIMUR', '1999-01-27', 'O', 1, 'DSN PASI-PASI', '', 1, '73_24_7_2018', '2021-01-03', '08:24:09', 'dusunLAMPIA', 9, 2020),
(71, '7324046501990004', 'FADHILLAH ISLAMIYATI', 'P', 'LUWU TIMUR', '1999-01-25', 'O', 1, 'DSN PASI-PASI', '', 1, '73_24_4_2014', '2021-01-03', '08:25:54', 'dusunLAMPIA', 9, 2020),
(72, '7324045407860001', 'IRDAYANTI', 'P', 'LUWU TIMUR', '1984-07-24', 'O', 1, 'DSN LAMPIA', '', 1, '73_24_7_2018', '2021-01-03', '08:27:24', 'dusunLAMPIA', 9, 2020),
(73, '7324044107010004', 'MARDIA', 'P', 'LUWU TIMUR', '2001-07-14', 'B', 1, 'DSN HULUPADANG', '', 2, '73_24_4_2012', '2021-01-03', '08:29:25', 'dusunLAMPIA', 9, 2020),
(74, '7324115003880001', 'HARTINI', 'P', 'LUWU TIMUR', '1988-03-10', 'A', 1, 'DSN LAMPIA', '', 5, '73_24_7_2018', '2021-01-03', '08:32:22', 'dusunLAMPIA', 9, 2020),
(75, '7324046012950001', 'BARLIAN', 'P', 'LUWU TIMUR', '1995-12-20', 'O', 1, 'DSN LAMPIA', '', 2, '73_24_7_2018', '2021-01-03', '08:34:10', 'dusunLAMPIA', 9, 2020),
(76, '7324045704790001', 'DIANA', 'P', 'LUWU TIMUR', '1979-04-17', 'A', 1, 'DSN HULUPADANG', '', 2, '73_24_4_2012', '2021-01-03', '08:36:37', 'dusunLAMPIA', 9, 2020),
(77, '7324044811890001', 'FATMAWATI', 'P', 'LUWU TIMUR', '1989-11-08', 'AB', 1, 'DSN LAMPIA', '', 2, '73_24_7_2018', '2021-01-03', '08:38:09', 'dusunLAMPIA', 9, 2020),
(78, '7324044902900001', 'SALMIA', 'P', 'LUWU TIMUR', '1990-02-09', 'O', 1, 'DSN KAREBBE', '', 2, '73_24_4_2002', '2021-01-03', '08:40:27', 'dusunLAMPIA', 9, 2020),
(79, '7324074107930502', 'MUSPIRA', 'P', 'LUWU TIMUR', '1993-07-01', 'A', 1, 'DSN HULUPADANG', '', 2, '73_24_4_2012', '2021-01-03', '08:42:57', 'dusunLAMPIA', 9, 2020),
(80, '7324045206010001', 'LALA', 'P', 'LUWU TIMUR', '2001-06-12', 'B', 1, 'DSN LAMPIA', '', 2, '73_24_7_2018', '2021-01-03', '08:50:25', 'dusunLAMPIA', 9, 2020),
(81, '6303094706010003', 'LUTFI ATURRUSIDAH', 'P', 'KALIMANTAN', '2001-06-07', 'O', 1, 'DSN KAREBBE', '', 2, '73_24_4_2002', '2021-01-03', '08:52:29', 'dusunLAMPIA', 9, 2020),
(82, '7324045707660002', 'ROSMA', 'P', 'LUWU TIMUR', '1986-07-17', 'A', 1, 'DSN LABOSE', '', 2, '73_24_4_2002', '2021-01-03', '08:54:15', 'dusunLAMPIA', 9, 2020),
(83, '7324045407870001', 'NUR AFNI', 'P', 'LUWU TIMUR', '1987-07-14', 'O', 1, 'DSN LAMPIA', '', 85, '73_24_7_2018', '2021-01-03', '08:56:04', 'dusunLAMPIA', 9, 2020),
(84, '7324044206890002', 'MELI HERMAWATI', 'P', 'LUWU TIMUR', '1989-06-02', 'B', 1, 'DSN SALOMABOMBONG', '', 2, '73_24_4_2014', '2021-01-03', '08:57:57', 'dusunLAMPIA', 9, 2020),
(85, '7324044507960002', 'NURHAYATI', 'P', 'LUWU TIMUR', '1996-07-05', 'B', 1, 'DSN SALOSIKAMBAR', '', 1, '73_24_4_2012', '2021-01-03', '08:59:24', 'dusunLAMPIA', 9, 2020),
(86, '7324041405910001', 'ANDI SULFIATI', 'P', 'LUWU TIMUR', '1991-05-14', 'O', 1, 'DSN PASI-PASI', '', 2, '73_24_4_2014', '2021-01-03', '09:01:18', 'dusunLAMPIA', 9, 2020),
(87, '7324044307930001', 'MELISA', 'P', 'LUWU TIMUR', '1993-07-13', 'O', 1, 'DSN HARAPAN', '', 2, '73_24_7_2018', '2021-01-03', '09:04:06', 'dusunLAMPIA', 9, 2020),
(88, '7324040510030002', 'ANUGRAH FADILA', 'P', 'LUWU TIMUR', '2003-10-05', 'O', 1, 'DSN KAREBBE', '', 2, '73_24_4_2002', '2021-01-03', '09:05:44', 'dusunLAMPIA', 9, 2020),
(89, '7324055708980002', 'ROSMIATI', 'P', 'LUWU TIMUR', '1998-08-17', 'O', 1, 'DSN PASI-PASI', '', 2, '73_24_4_2014', '2021-01-03', '09:07:08', 'dusunLAMPIA', 9, 2020),
(90, '7408155809950001', 'NELAWATI', 'P', 'LUWU TIMUR', '1995-04-18', 'A', 1, 'DSN LAMPIA', '', 1, '73_24_7_2018', '2021-01-03', '09:08:51', 'dusunLAMPIA', 9, 2020),
(91, '7324046304050002', 'DELA MANSUR', 'P', 'LUWU TIMUR', '2005-04-23', 'B', 1, 'DSN PASIPASI', '', 2, '73_24_4_2014', '2021-01-03', '09:10:17', 'dusunLAMPIA', 9, 2020),
(92, '7324045708910003', 'MUTMAINNA', 'P', 'LUWU TIMUR', '1991-08-17', 'O', 1, 'DSN LAMPIA', '', 2, '73_24_7_2018', '2021-01-03', '09:11:36', 'dusunLAMPIA', 9, 2020),
(93, '7317216707870006', 'ROSITA TAHIR', 'P', 'LUWU TIMUR', '1987-07-17', 'O', 1, 'DSN KAREBBE', '', 2, '73_24_4_2002', '2021-01-05', '15:48:59', 'dusunLAMPIA', 9, 2020),
(94, '7324045903880004', 'HASRIANI', 'P', 'LUWU TIMUR', '1988-03-19', 'A', 1, 'DSN KAREBBE', '', 2, '73_24_4_2002', '2021-01-05', '15:51:08', 'dusunLAMPIA', 9, 2020),
(95, '7324044101010007', 'RUSNI', 'P', 'LUWU TIMUR', '2001-01-11', 'O', 1, 'DSN LAMPIA', '', 1, '73_24_7_2018', '2021-01-05', '15:53:45', 'dusunLAMPIA', 9, 2020),
(96, '7324046109940001', 'MUTMAINNA', 'P', 'LUWU TIMUR', '1994-09-11', 'A', 1, 'DSN LAMPIA', '', 2, '73_24_7_2018', '2021-01-05', '15:55:48', 'dusunLAMPIA', 9, 2020),
(97, '7324044702850002', 'SALMA', 'P', 'LUWU TIMUR', '1985-02-27', 'B', 1, 'DSN LAOLI', '', 2, '73_24_7_2018', '2021-01-05', '15:57:54', 'dusunLAMPIA', 9, 2020),
(98, '7324046709850001', 'MARLA', 'P', 'LUWU TIMUR', '1985-09-07', 'B', 1, 'JLN POROS SULTENG', '', 5, '73_24_7_2018', '2021-01-05', '15:59:38', 'dusunLAMPIA', 9, 2020),
(99, '7324044404940001', 'RISDAYANTI', 'P', 'LUWU TIMUR', '1994-04-14', 'B', 1, 'DSN LAMPIA', '', 1, '73_24_7_2018', '2021-01-05', '16:00:59', 'dusunLAMPIA', 9, 2020),
(100, '7324045707990003', 'ARINI', 'P', 'LUWU TIMUR', '1999-07-17', 'AB', 1, 'DSN LAMPIA', '', 1, '73_24_7_2018', '2021-01-05', '16:05:03', 'dusunLAMPIA', 9, 2020),
(101, '7324074708900002', 'SARTIKA', 'P', 'LUWU TIMUR', '1990-08-17', 'B', 1, 'MALILI', '', 2, '73_24_4_2002', '2021-01-05', '16:08:01', 'dusunLAMPIA', 9, 2020),
(102, '7324045212900003', 'HELMI RUSLI', 'P', 'LUWU TIMUR', '1990-12-12', 'O', 1, 'DSN KAREBBE', '', 2, '73_24_4_2002', '2021-01-05', '16:10:05', 'dusunLAMPIA', 9, 2020),
(103, '7322015905000004', 'JUMAIRA', 'P', 'LUWU TIMUR', '2000-05-19', 'O', 1, 'DSN LABOSE', '', 2, '73_24_4_2002', '2021-01-05', '16:12:48', 'dusunLAMPIA', 9, 2020),
(104, '7324046111910001', 'RIRIN YUMNA', 'P', 'LUWU TIMUR', '1991-11-11', 'O', 1, 'DSN LAMPIA', '', 2, '73_24_7_2018', '2021-01-05', '16:14:21', 'dusunLAMPIA', 9, 2020),
(105, '7324086911920001', 'RIKA', 'P', 'LUWU TIMUR', '1992-11-29', 'O', 1, 'DSN HULUPADANG', '', 2, '73_24_4_2012', '2021-01-05', '16:16:54', 'dusunLAMPIA', 9, 2020),
(106, '7322025512900004', 'YULIANTI', 'P', 'BONE-BONE', '1990-12-25', 'B', 1, 'DSN MAKARTI', '', 73, '73_24_7_2018', '2021-01-05', '16:18:50', 'dusunLAMPIA', 9, 2020),
(107, '9203016501870001', 'HESNI', 'P', 'MAKASSAR', '1987-01-05', 'O', 1, 'DSN SALOSIKAMBAR', '', 2, '73_24_4_2012', '2021-01-05', '16:21:17', 'dusunLAMPIA', 9, 2020),
(108, '7324044107000018', 'TETY', 'P', 'LUWU TIMUR', '2000-07-10', 'B', 1, 'DSN HULUPADANG', '', 2, '73_24_4_2012', '2021-01-05', '16:24:18', 'dusunLAMPIA', 9, 2020),
(109, '5271045603030002', 'EKI FATMASARI', 'P', 'LUWU TIMUR', '2003-03-26', 'O', 1, 'DSN LAMPIA', '', 1, '73_24_7_2018', '2021-01-05', '16:26:34', 'dusunLAMPIA', 9, 2020),
(110, '7324044212860001', 'HADI', 'P', 'LUWU TIMUR', '1986-12-22', 'B', 1, 'DSN HULUPADANG', '', 2, '73_24_4_2012', '2021-01-05', '16:28:31', 'dusunLAMPIA', 9, 2020),
(111, '7313303711287001', 'SARMAWIDAYA', 'P', 'LUWU TIMUR', '1987-12-11', 'B', 1, 'DSN PASI-PASI', '', 2, '73_24_4_2014', '2021-01-05', '16:29:51', 'dusunLAMPIA', 9, 2020),
(112, '7324045803870001', 'RAHMI', 'P', 'LUWU TIMUR', '1987-03-08', 'O', 1, 'DSN LAMPIA', '', 2, '73_24_7_2018', '2021-01-05', '16:31:28', 'dusunLAMPIA', 9, 2020),
(113, '7204075303950002', 'ASTRI ULFA', 'P', 'TOLITOLI', '1995-03-13', 'O', 1, 'DSN HULUPADANG', '', 2, '73_24_4_2012', '2021-01-05', '16:33:04', 'dusunLAMPIA', 9, 2020),
(114, '7324045105940001', 'NUR ALIYAH BIN FAUZIAH', 'P', 'KAREBBE', '1994-05-11', 'A', 1, 'KAREBBE', '', 2, '73_24_4_2002', '2021-01-29', '11:54:53', 'dusunLAMPIA', 9, 2021),
(115, '7324045904970003', 'NURAENI J', 'P', 'MALILI', '1997-04-19', 'O', 1, 'DSN PASI-PASI', '', 2, '73_24_4_2014', '2021-01-29', '11:56:31', 'dusunLAMPIA', 9, 2021),
(116, '7324046707970001', 'RISKA', 'P', 'LABOSE', '1997-07-27', 'O', 1, 'DSN LABOSE', '', 1, '73_24_4_2002', '2021-01-29', '11:58:00', 'dusunLAMPIA', 9, 2021),
(117, '7324045707940003', 'SARTIKA DEWI', 'P', 'LAMPIA', '1994-07-01', 'O', 1, 'DSN LAMPIA', '', 2, '73_24_7_2018', '2021-01-29', '11:59:23', 'dusunLAMPIA', 9, 2021),
(118, '7471095708920001', 'NURLELA WIYANSARI', 'P', 'AMBON', '1992-08-17', 'O', 1, 'UPT SP II LAMPIA', '', 88, '73_24_7_2018', '2021-01-29', '12:01:17', 'dusunLAMPIA', 9, 2021),
(119, '7408156908980001', 'ISTIANI', 'P', 'TOLALA', '1999-04-27', 'O', 1, 'DSN LABOSE', '', 2, '73_24_4_2002', '2021-01-29', '12:02:37', 'dusunLAMPIA', 9, 2021),
(120, '7324046404870002', 'KARMILI', 'P', 'LAMPIA', '1987-04-24', 'B', 1, 'JL. POROS SULTRA', '', 2, '73_24_7_2018', '2021-01-29', '12:04:21', 'dusunLAMPIA', 9, 2021),
(121, '7324044611930001', 'RINA LESTARI', 'P', 'PONGKERU', '1993-11-06', 'O', 2, 'DSN HULUPADANG', '', 2, '73_24_4_2012', '2021-01-29', '12:05:41', 'dusunLAMPIA', 9, 2021),
(122, '7324064107860032', 'MAHIRAWATI', 'P', 'MALILI', '1989-10-07', 'A', 1, 'DSN KAWASULE', '', 88, '73_24_4_2012', '2021-01-29', '12:07:30', 'dusunLAMPIA', 9, 2021),
(123, '7373056804990002', 'NURHAERAH', 'P', 'BALABATU', '1999-04-28', 'O', 1, 'DSN KAREBBE', '', 2, '73_24_4_2002', '2021-01-29', '12:10:41', 'dusunLAMPIA', 9, 2021),
(124, '7324046511960002', 'DIANA', 'P', 'MASAMBA', '1996-11-25', 'O', 1, 'DSN HULUPADANG', '', 2, '73_24_4_2012', '2021-01-29', '12:11:54', 'dusunLAMPIA', 9, 2021),
(125, '7324075606010001', 'ASTIKA', 'P', 'LUWU TIMUR', '2001-06-17', 'O', 1, 'BURAU', '', 2, '73_24_4_2012', '2021-02-22', '09:30:23', 'dusunLAMPIA', 9, 2021),
(126, '7324040107840032', 'INDRA INDRI', 'P', 'PONGKERU', '1984-07-01', 'B', 1, 'DSN. HULUPADANG', '', 2, '73_24_4_2012', '2021-02-22', '09:31:56', 'dusunLAMPIA', 9, 2021),
(127, '7310084603980003', 'MEGA MUSTIKA', 'P', 'LUWU TIMUR', '1998-03-16', 'A', 1, 'DSN PASI-PASI', '', 2, '73_24_4_2014', '2021-02-22', '09:33:56', 'dusunLAMPIA', 9, 2021),
(128, '7324047105850001', 'HASNAWATI', 'P', 'LUWU TIMUR', '1985-05-11', 'O', 1, 'DSN KAREBBE', '', 2, '73_24_4_2002', '2021-02-22', '09:35:15', 'dusunLAMPIA', 9, 2021),
(129, '7324045512900002', 'YUNI', 'P', 'LUWU TIMUR', '1990-12-25', 'O', 1, 'DSN LAMPIA', '', 2, '73_24_7_2018', '2021-02-22', '09:36:43', 'dusunLAMPIA', 9, 2021),
(130, '7206116501940001', 'ANISAH', 'P', 'LUWU TIMUR', '1994-01-15', 'A', 1, 'DSN LAMPIA', '', 2, '73_24_7_2018', '2021-02-22', '09:38:12', 'dusunLAMPIA', 9, 2021),
(131, '7324046505030002', 'ASTRID YULIANTI ASKAR', 'P', 'LUWU TIMUR', '2003-05-25', 'O', 1, 'DSN MAKARTI', '', 1, '73_24_7_2018', '2021-02-22', '09:39:54', 'dusunLAMPIA', 9, 2021),
(132, '7324045105830001', 'HASRIA', 'P', 'KAREBBE', '1983-05-11', 'O', 1, 'DSN KAREBBE', '', 2, '73_24_4_2002', '2021-03-13', '14:05:20', 'dusunLAMPIA', 9, 2021),
(133, '7324044501940002', 'SELVI', 'P', 'MALILI', '1994-01-05', 'O', 1, 'JL. POROS SULTRA', '', 2, '73_24_7_2018', '2021-03-13', '14:07:27', 'dusunLAMPIA', 9, 2021),
(134, '7324045408930001', 'ASMAWATY', 'P', 'MUARA BADAK', '1993-08-14', 'O', 1, 'JL. POROS SULTRA', '', 85, '73_24_7_2018', '2021-03-13', '14:10:20', 'dusunLAMPIA', 9, 2021),
(135, '7324045502990002', 'RASMAWATI', 'P', 'SALOSIKAMBAR', '1999-02-15', 'O', 1, 'DSN. SALOSIKAMBAR', '', 2, '73_24_4_2012', '2021-03-23', '12:15:40', 'dusunLAMPIA', 9, 2021),
(136, '7401194107990082', 'ST.SALMAWATI', 'P', 'ALADADIO', '1999-07-01', 'O', 1, 'DSN PASI-PASI', '', 2, '73_24_4_2014', '2021-03-23', '12:21:53', 'dusunLAMPIA', 9, 2021),
(137, '7324044101880009', 'ST. RUKAYAH', 'P', 'TIMOR-TIMUR', '1988-01-01', 'O', 1, 'UPT SP II LAMPIA', '', 2, '73_24_7_2018', '2021-04-12', '11:32:48', 'dusunLAMPIA', 9, 2021),
(138, '7324042808970002', 'FARDA FRADANA', 'P', 'LAMPIA', '1997-08-28', 'O', 1, 'JL. POROS SULTRA', '', 2, '73_24_7_2018', '2021-04-16', '11:02:57', 'dusunLAMPIA', 9, 2021),
(139, '7324046710890001', 'WINARTI', 'P', 'LABOSE', '1989-10-27', 'B', 1, 'DUSUN LABOSE', '', 5, '73_24_4_2002', '2021-04-16', '11:04:19', 'dusunLAMPIA', 9, 2021),
(140, '7324046601970002', 'INDAH AYU LESTARI', 'P', 'LASKAP', '1997-10-27', 'O', 1, 'DUSUN KAREBBE', '', 88, '73_24_4_2002', '2021-04-16', '11:05:42', 'dusunLAMPIA', 9, 2021),
(141, '7324044612010001', 'ST.RAHMAH', 'P', 'MALILI', '2001-12-06', 'A', 1, 'DUSUN PASI-PASI', '', 2, '73_24_4_2014', '2021-04-26', '07:19:03', 'dusunLAMPIA', 9, 2021),
(142, '7324054904040003', 'SIZY HANDAYANI', 'P', 'LUWU TIMUR', '2004-04-09', 'O', 1, 'DUSUN KAREBBE', '', 1, '73_24_4_2002', '2021-04-26', '07:20:45', 'dusunLAMPIA', 9, 2021),
(143, '7317034711000002', 'SRI NILAMTIKA NINGSIH', 'P', 'ALEUTI', '2000-11-07', 'O', 1, 'JLN POROS SULTRA', '', 2, '73_24_7_2018', '2021-04-29', '11:30:38', 'dusunLAMPIA', 9, 2021),
(144, '7324085010810002', 'PONINGSIH', 'P', 'MULYASARI', '1981-10-10', 'O', 1, 'JLN POROS SULTRA', '', 2, '73_24_7_2018', '2021-04-29', '11:31:53', 'dusunLAMPIA', 9, 2021),
(145, '7317074701940005', 'ISLAMIAH', 'P', 'MALILI', '1994-01-07', 'A', 1, 'DUSUN HULUPADANG', '', 2, '73_24_4_2012', '2021-04-29', '11:33:53', 'dusunLAMPIA', 9, 2021),
(146, '123456', 'Uya Kuya', 'P', 'ress', '2009-11-27', 'B', 3, 'dsadad', '', 2, '73_24_11_2003', '2021-06-17', '20:38:33', 'WASUPONDA', 11, 2021);

-- --------------------------------------------------------

--
-- Table structure for table `im_pekerjaan`
--

CREATE TABLE `im_pekerjaan` (
  `id_pekerjaan` int(11) NOT NULL,
  `pekerjaan` varchar(255) DEFAULT NULL,
  `deleted` int(11) DEFAULT 0,
  `id_sektor` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `im_pekerjaan`
--

INSERT INTO `im_pekerjaan` (`id_pekerjaan`, `pekerjaan`, `deleted`, `id_sektor`) VALUES
(84, 'PEDAGANG', 0, 8),
(2, 'MENGURUS RUMAH TANGGA', 0, 10),
(4, 'PENSIUNAN', 0, 0),
(88, 'WIRASWASTA', 0, 8),
(3, 'Pelajar', 0, 0),
(5, 'PEGAWAI NEGERI SIPIL', 0, 12),
(65, 'GURU', 0, 13),
(15, 'KARYAWAN SWASTA', 0, 10),
(9, 'PETANI/PEKEBUN', 0, 1),
(1, 'BELUM/TIDAK BEKERJA', 0, 0),
(8, 'PERDAGANGAN', 0, 8),
(16, 'KARYAWAN BUMN', 0, 10),
(18, 'KARYAWAN HONORER', 0, 12),
(45, 'USTADZ/MUBALIGH', 0, 13),
(20, 'Buruh Tani', 0, 2),
(73, 'BIDAN', 0, 11),
(19, 'BURUH HARIAN LEPAS', 0, 10),
(75, 'APOTEKER', 0, 10),
(23, 'PEMBANTU RUMAH TANGGA', 0, NULL),
(81, 'SOPIR', 0, 10),
(72, 'DOKTER', 0, 11),
(26, 'TUKANG BATU', 0, 10),
(35, 'MEKANIK', 0, 10),
(27, 'TUKANG KAYU', 0, 10),
(29, 'TUKANG LAS/PANDAI BESI', 0, 7),
(17, 'KARYAWAN BUMD', 0, 8),
(71, 'KONSULTAN', 0, 8),
(22, 'BURUH PETERNAKAN', 0, 3),
(14, 'TRANSPORTASI', 0, 10),
(85, 'PERANGKAT DESA', 0, 12),
(86, 'KEPALA DESA', 0, 12),
(89, 'LAINNYA', 0, 0),
(34, 'PENATA RAMBUT', 0, 10),
(11, 'NELAYAN/PERIKANAN', 0, 4),
(24, 'TUKANG CUKUR', 0, 10),
(74, 'PERAWAT', 0, 11),
(31, 'TUKANG GIGI', 0, 11),
(37, 'TABIB', 0, 11),
(30, 'TUKANG JAHIT', 0, 10),
(42, 'PENDETA', 0, 13),
(50, 'ANGGOTA BPK', 0, 12),
(10, 'PETERNAK', 0, 3),
(82, 'PIALANG', 0, 10),
(80, 'PENELITI', 0, 13),
(13, 'KONSTRUKSI', 0, 8),
(32, 'PENATA RIAS', 0, 10),
(12, 'INDUSTRI', 0, 8),
(21, 'BURUH NELAYAN/PERIKANAN', 0, 4),
(36, 'SENIMAN', 0, 10),
(25, 'TUKANG LISTRIK', 0, 10),
(64, 'DOSEN', 0, 13),
(28, 'TUKANG SOL SEPATU', 0, 10),
(63, 'ANGGOTA DPRD KABUPATEN/KOTA', 0, 10),
(83, 'PARANORMAL', 0, 10),
(41, 'IMAM MESJID', 0, 10),
(40, 'PENTERJEMAH', 0, 10),
(46, 'JURU MASAK', 0, 10),
(58, 'BUPATI', 0, 12),
(59, 'WAKIL BUPATI', 0, 12),
(49, 'ANGGOTA DPD', 0, 12),
(68, 'NOTARIS', 0, 10),
(79, 'PELAUT', 0, 10),
(48, 'ANGGOTA DPR-RI', 0, 12),
(87, 'BIARAWATI', 0, 10),
(33, 'PENATA BUSANA', 0, 10),
(38, 'PARAJI', 0, 10),
(131158, 'KEPOLISIAN RI', 0, NULL),
(131159, 'PELAJAR/MAHASISWA', 0, 13),
(131160, 'TENTARA NASIONAL INDONESIA (TNI)', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `im_reg`
--

CREATE TABLE `im_reg` (
  `id_reg` char(60) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `no_wa` varchar(12) NOT NULL,
  `id_desa` varchar(50) NOT NULL,
  `username` varchar(100) NOT NULL,
  `id_dusun` int(11) NOT NULL,
  `id_permohonan` int(11) DEFAULT NULL,
  `create_date` date NOT NULL,
  `create_time` varchar(20) NOT NULL,
  `update_time` datetime DEFAULT NULL,
  `no_registrasi` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `im_reg`
--

INSERT INTO `im_reg` (`id_reg`, `nama`, `no_wa`, `id_desa`, `username`, `id_dusun`, `id_permohonan`, `create_date`, `create_time`, `update_time`, `no_registrasi`) VALUES
('721252002_20250415122614_4a3b26e1-6c57-43e0-b3b7-ca77058e140', 'Jalil', '082333265888', '72_12_5_2002', 'LONDI', 53, 3, '2025-04-15', '12:26:14', NULL, 'REG-2025-000019'),
('721252002_20250415154356_b0030ae4-5647-47a0-9b8e-091340dcb95', 'Irwan', '082333265888', '72_12_5_2002', 'LONDI', 53, 4, '2025-04-15', '15:43:56', NULL, 'REG-2025-000020'),
('721282001_20250413185457_ab94622f-01fa-442f-98b7-8faadb6e2af', 'Besse Veeya Shanum', '082333265888', '72_12_8_2001', 'BATURUBE', 49, 1, '2025-04-13', '18:54:57', NULL, 'REG-2025-000012'),
('721282001_20250413190104_bd580525-2a7e-4be8-bcdc-beeb841a053', 'Hafiz', '082333265888', '72_12_8_2001', 'BATURUBE', 47, 1, '2025-04-13', '19:01:04', NULL, 'REG-2025-000013'),
('721282001_20250413204152_9d474c7d-b2a1-4551-af8c-05a195a3f3b', 'Marda', '082333265888', '72_12_8_2001', 'BATURUBE', 48, 2, '2025-04-13', '20:41:52', NULL, 'REG-2025-000014'),
('721282001_20250414003006_1d2b8cde-15f6-4d4e-a2d1-6531a7de9d1', 'Marlin', '082333265888', '72_12_8_2001', 'BATURUBE', 47, 2, '2025-04-14', '00:30:06', NULL, 'REG-2025-000015'),
('721282001_20250414005301_6b05b606-b559-4230-8883-3c718c55dd0', 'Onlin', '082333265888', '72_12_8_2001', 'BATURUBE', 49, 3, '2025-04-14', '00:53:01', NULL, 'REG-2025-000016'),
('721282009_20250415213536_0cda2f50-3ef2-4034-92f5-fb87a4d24a2', 'Sakti', '082333265888', '72_12_8_2009', 'LEMO', 56, 4, '2025-04-15', '21:35:36', NULL, 'REG-2025-000021'),
('721282016_20250406031934_53eedc4e-f832-4918-8d2b-e1dd952bd02', 'Watiu', '082333265888', '72_12_8_2016', 'BOBA', 39, 1, '2025-04-06', '03:19:34', NULL, NULL),
('721282016_20250406033132_d1070380-e555-4d57-85b2-25c579cc1a3', 'blgedes', '082333265888', '72_12_8_2016', 'BOBA', 41, 1, '2025-04-06', '03:31:32', NULL, NULL),
('721282016_20250406033314_c76618ef-6b73-4a47-a9b0-0a8375a12b1', 'ddd', '082333265888', '72_12_8_2016', 'BOBA', 39, 1, '2025-04-06', '03:33:14', NULL, NULL),
('721282016_20250406033435_045d7998-5419-47fa-a002-6f0d4e55e6b', 'sss', '082333265888', '72_12_8_2016', 'BOBA', 39, 1, '2025-04-06', '03:34:35', NULL, NULL),
('721282016_20250406034339_2cdc9a93-165a-42d7-9caa-4efeb2daa1c', 'asda', '082333265888', '72_12_8_2016', 'BOBA', 39, 1, '2025-04-06', '03:43:39', NULL, NULL),
('721282016_20250406035623_42abbbb7-77ab-4395-b7e1-1773cefb09e', 'asdsada', '082333265888', '72_12_8_2016', 'BOBA', 39, 1, '2025-04-06', '03:56:23', NULL, NULL),
('721282016_20250406035836_3337fc5f-72ec-49d3-a428-467b4efe07d', 'asdad', '082333265888', '72_12_8_2016', 'BOBA', 41, 1, '2025-04-06', '03:58:36', NULL, NULL),
('721282016_20250406040027_6f161750-a244-4d2d-b023-ec3f531c619', 'Lakanude', '082333265888', '72_12_8_2016', 'BOBA', 39, 1, '2025-04-06', '04:00:27', '2025-04-06 19:04:28', NULL),
('721282016_20250406040153_c5f1e09f-0897-4f8a-9752-e79bd9f7354', 'Besse Veeya Shanum', '082333265888', '72_12_8_2016', 'BOBA', 33, 1, '2025-04-06', '04:01:53', '2025-04-06 19:03:50', NULL),
('721282016_20250406190109_b96aabf6-4951-45a7-96e1-5e80c571faf', 'Ani', '082333265888', '72_12_8_2016', 'BOBA', 39, 1, '2025-04-06', '19:01:09', NULL, NULL),
('721282016_20250406190535_4da275a8-8388-457e-a1e5-656edda0f12', 'Mega', '082333265888', '72_12_8_2016', 'BOBA', 33, 2, '2025-04-06', '19:05:35', NULL, NULL),
('721282016_20250406190725_52ceda75-6e70-4d51-99b0-5faa6be176a', 'Felisha', '082333265888', '72_12_8_2016', 'BOBA', 41, 1, '2025-04-06', '19:07:25', NULL, NULL),
('721282016_20250406190758_0154c364-da3e-4d60-b904-d016a4aa40d', 'Alisha', '082333265888', '72_12_8_2016', 'BOBA', 35, 1, '2025-04-06', '19:07:58', NULL, NULL),
('721282016_20250406190835_c4f93ab4-5fd9-4b9c-9ba1-78a9ebc0329', 'Maiza', '082333265888', '72_12_8_2016', 'BOBA', 35, 1, '2025-04-06', '19:08:35', NULL, NULL),
('721282016_20250406193437_f116d5c5-cbe6-497c-ab7f-29d9ad2634b', 'lalalala', '082333265888', '72_12_8_2016', 'BOBA', 41, 1, '2025-04-06', '19:34:37', '2025-04-06 19:55:30', NULL),
('721282016_20250406195609_f8975e6c-5196-45e4-909b-97926cfed13', 'sisaa', '082333265888', '72_12_8_2016', 'BOBA', 39, 1, '2025-04-06', '19:56:09', '2025-04-06 20:44:25', NULL),
('721282016_20250406204612_d51b36c3-0edd-442d-9dfe-1487ac86f65', 'Dodiy', '082333265888', '72_12_8_2016', 'BOBA', 39, 1, '2025-04-06', '20:46:12', NULL, NULL),
('721282016_20250406204755_845318b0-2f29-4e31-9ddb-936e4c173ee', 'ihaaaa', '082333265888', '72_12_8_2016', 'BOBA', 41, 1, '2025-04-06', '20:47:55', NULL, NULL),
('721282016_20250406210328_f62eb2c6-eebf-482f-930f-2a8a8898bde', 'Ytha', '082333265888', '72_12_8_2016', 'BOBA', 33, 1, '2025-04-06', '21:03:28', '2025-04-07 19:06:56', NULL),
('721282016_20250407225203_1707e170-f142-4e60-9b96-d8959b318e8', 'Besse Veeya Shanum', '082333265888', '72_12_8_2016', 'BOBA', 35, 1, '2025-04-07', '22:52:03', NULL, 'REG-2025-000001'),
('721282016_20250410021409_dbf1a404-c4f1-477b-b75d-2c7f5429803', 'adsa', '098222111222', '72_12_8_2016', 'BOBA', 41, 1, '2025-04-10', '02:14:09', NULL, 'REG-2025-000002'),
('721282016_20250410150801_4573897e-42f8-4134-86d0-826bbe0233c', 'Irwan', '082333265888', '72_12_8_2016', 'BOBA', 39, 1, '2025-04-10', '15:08:01', NULL, 'REG-2025-000003'),
('721282016_20250410151359_a3fa56ea-5047-4625-bff1-9fe3065d3e7', 'Indra', '082333265888', '72_12_8_2016', 'BOBA', 33, 2, '2025-04-10', '15:13:59', NULL, 'REG-2025-000004'),
('721282016_20250410170218_0a5ae185-1fd1-44c1-a1af-aa187cd8bf4', 'Atika', '082333265888', '72_12_8_2016', 'BOBA', 35, 2, '2025-04-10', '17:02:18', NULL, 'REG-2025-000005'),
('721282016_20250411003735_39116b33-efd6-4cf7-bf18-feb139cfce7', 'Baso Irwan Sakti', '082333265888', '72_12_8_2016', 'BOBA', 40, 2, '2025-04-11', '00:37:35', NULL, 'REG-2025-000006'),
('721282016_20250412000149_af02be48-e60e-4350-97c3-461b76a1eed', 'Andi Wawan', '082333265888', '72_12_8_2016', 'BOBA', 39, 2, '2025-04-12', '00:01:49', NULL, 'REG-2025-000007'),
('721282016_20250412011357_c923fac8-a6d9-4c0f-baf0-cd36f9a278a', 'Indo Alang', '082333265888', '72_12_8_2016', 'BOBA', 33, 2, '2025-04-12', '01:13:57', NULL, 'REG-2025-000008'),
('721282016_20250412011605_27a72040-46e1-4693-9fba-28cc319f3c0', 'Indo Alang', '082333265888', '72_12_8_2016', 'BOBA', 33, 2, '2025-04-12', '01:16:05', NULL, 'REG-2025-000009'),
('721282016_20250412012001_b683b60e-193b-4a53-afc6-327d043fb73', 'Ambo Angka', '082333265888', '72_12_8_2016', 'BOBA', 40, 2, '2025-04-12', '01:20:01', NULL, 'REG-2025-000010'),
('721282016_20250412130626_6cee1343-e804-48b4-9a07-f7019314c18', 'Asdar Alfarizy', '082191111188', '72_12_8_2016', 'BOBA', 33, 2, '2025-04-12', '13:06:26', NULL, 'REG-2025-000011'),
('721282016_2bb6360c-00c3-4df7-a657-1a', 'Ilhama', '082333265888', '72_12_8_2016', 'BOBA', 33, 1, '2025-04-05', '02:25:05', NULL, NULL),
('721282016_569ad888-631b-417d-b4fd-fa', 'Saki', '082333265888', '72_12_8_2016', 'BOBA', 40, 3, '2025-04-06', '02:42:04', NULL, NULL),
('721282016_761ab684-7fb0-4ec3-a1e9-38', 'Cemma', '082333265888', '72_12_8_2016', 'BOBA', 41, 1, '2025-04-06', '03:03:51', NULL, NULL),
('721282016_9746ef93-5b0e-400e-9b2f-10', 'Ira', '082333265888', '72_12_8_2016', 'BOBA', 41, 1, '2025-04-06', '03:05:27', NULL, NULL),
('721282016_99f9d5d5-c4a5-48c3-9a7e-d7', 'Nurhikmah', '082333265888', '72_12_8_2016', 'BOBA', 33, 1, '2025-04-06', '02:13:50', NULL, NULL),
('721282016_b552ca4c-8a81-4091-9170-e1', 'Gibran', '082333265888', '72_12_8_2016', 'BOBA', 41, 2, '2025-04-04', '02:38:57', NULL, NULL),
('721282016_dab47a73-01fc-470e-bedd-83', 'Imran', '082333265777', '72_12_8_2016', 'BOBA', 33, 1, '2025-04-06', '02:53:22', NULL, NULL),
('721282016_e171f186-66ea-490d-b82d-b9', 'Dilla', '082333265888', '72_12_8_2016', 'BOBA', 39, 1, '2025-04-06', '02:38:24', NULL, NULL),
('721282017_20250414174105_d28d00c0-9c80-45ea-9e24-be8bc97ba10', 'Naimang', '082333265888', '72_12_8_2017', 'KALOMBANG', 52, 1, '2025-04-14', '17:41:05', NULL, 'REG-2025-000017'),
('721282017_20250415002022_c626e029-6953-4d8a-9eae-e32a7a5e10e', 'Ani', '082333265888', '72_12_8_2017', 'KALOMBANG', 52, 2, '2025-04-15', '00:20:22', NULL, 'REG-2025-000018'),
('721292007_20250412200108_f738bc2f-34cb-4d36-a035-b126f058fbd', 'Joe Sandi', '082333265888', '72_12_9_2007', 'LIJO', 45, 2, '2025-04-12', '20:01:08', NULL, 'REG-2025-000001'),
('721292007_20250412201303_6a84f304-1e60-4716-a025-65332e6ca45', 'Limbad', '082333265888', '72_12_9_2007', 'LIJO', 46, 2, '2025-04-12', '20:13:03', NULL, 'REG-2025-000002'),
('721292007_20250412203803_9fc46d81-2319-4dab-955b-c1cc040831c', 'Mr. Rachel', '082333265888', '72_12_9_2007', 'LIJO', 43, 2, '2025-04-12', '20:38:03', NULL, 'REG-2025-000003'),
('721292007_20250412204011_18b397a6-839d-4a39-a381-9c0d57308f2', 'Darwis', '082333265888', '72_12_9_2007', 'LIJO', 44, 2, '2025-04-12', '20:40:11', NULL, 'REG-2025-000004'),
('721292007_20250412204333_c65a18dd-4cdd-47d1-8e52-408457eab3c', 'Ilham', '082333265888', '72_12_9_2007', 'LIJO', 42, 2, '2025-04-12', '20:43:33', NULL, 'REG-2025-000005'),
('721292007_20250412205237_c5a20c40-4c85-4263-bdcc-62b0945f176', 'Muh. Nurul Ilham', '628219519563', '72_12_9_2007', 'LIJO', 45, 2, '2025-04-12', '20:52:37', NULL, 'REG-2025-000006');

-- --------------------------------------------------------

--
-- Table structure for table `kalender`
--

CREATE TABLE `kalender` (
  `id_kalender` int(11) NOT NULL,
  `minggu_ke` int(11) NOT NULL,
  `username` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `periode_awal` date NOT NULL,
  `periode_akhir` date NOT NULL,
  `bulan` int(11) NOT NULL,
  `tahun` int(11) NOT NULL,
  `tahap_survey` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `kalender`
--

INSERT INTO `kalender` (`id_kalender`, `minggu_ke`, `username`, `periode_awal`, `periode_akhir`, `bulan`, `tahun`, `tahap_survey`) VALUES
(61, 1, 'admin', '2020-08-01', '2020-08-15', 8, 2020, 0),
(62, 2, 'admin', '2020-08-15', '2020-08-21', 8, 2020, 0),
(63, 3, 'admin', '2020-08-15', '2020-08-22', 8, 2020, 20192020),
(64, 4, 'admin', '2019-12-29', '2020-01-04', 12, 2019, 0),
(65, 12, 'admin', '2020-08-14', '2020-08-28', 8, 2020, 20192020),
(66, 4, 'admin', '2020-08-04', '2020-08-21', 8, 2020, 20192020);

-- --------------------------------------------------------

--
-- Table structure for table `logo`
--

CREATE TABLE `logo` (
  `id_logo` int(11) NOT NULL,
  `gambar` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `logo`
--

INSERT INTO `logo` (`id_logo`, `gambar`) VALUES
(1, 'logo.png');

-- --------------------------------------------------------

--
-- Stand-in structure for view `lokasi`
-- (See below for the actual view)
--
CREATE TABLE `lokasi` (
`id_desa` char(13)
,`desa` varchar(100)
,`id_kecamatan` char(13)
,`kecamatan` varchar(300)
,`id_kota` char(13)
,`kota` varchar(100)
,`id_provinsi` char(13)
,`provinsi` varchar(100)
);

-- --------------------------------------------------------

--
-- Table structure for table `master_desa`
--

CREATE TABLE `master_desa` (
  `id_desa` char(39) NOT NULL,
  `desa` varchar(300) DEFAULT NULL,
  `id_kecamatan` char(39) DEFAULT NULL,
  `id_kota` char(39) DEFAULT NULL,
  `id_provinsi` char(39) DEFAULT NULL,
  `id_dusun` int(11) NOT NULL,
  `username` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_uca1400_ai_ci;

--
-- Dumping data for table `master_desa`
--

INSERT INTO `master_desa` (`id_desa`, `desa`, `id_kecamatan`, `id_kota`, `id_provinsi`, `id_dusun`, `username`) VALUES
('73_24_1_2001', 'MALEKU', '73_24_1', '73_24', '73', 5, 'admin'),
('73_24_1_2002', 'WONOREJO', '73_24_1', '73_24', '73', 5, 'admin'),
('73_24_1_2003', 'MARGOLEMBO', '73_24_1', '73_24', '73', 5, 'admin'),
('73_24_1_2004', 'TEROMU', '73_24_1', '73_24', '73', 5, 'admin'),
('73_24_1_2007', 'MANGGALA', '73_24_1', '73_24', '73', 5, 'admin'),
('73_24_1_2009', 'KASINTUWU', '73_24_1', '73_24', '73', 5, 'admin'),
('73_24_1_2011', 'BALAI KEMBANG', '73_24_1', '73_24', '73', 5, 'admin'),
('73_24_1_2013', 'PANCA KARSA', '73_24_1', '73_24', '73', 5, 'admin'),
('73_24_1_2014', 'SINDU AGUNG', '73_24_1', '73_24', '73', 5, 'admin'),
('73_24_1_2015', 'WONOREJO TIMUR', '73_24_1', '73_24', '73', 5, 'admin'),
('73_24_1_2016', 'KORONCIA', '73_24_1', '73_24', '73', 5, 'admin'),
('73_24_10_2001', 'KALAENA KIRI', '73_24_10', '73_24', '73', 6, 'admin'),
('73_24_10_2002', 'SUMBER AGUNG', '73_24_10', '73_24', '73', 6, 'admin'),
('73_24_10_2003', 'PERTASI KENCANA', '73_24_10', '73_24', '73', 6, 'admin'),
('73_24_10_2004', 'NON BLOK', '73_24_10', '73_24', '73', 6, 'admin'),
('73_24_10_2005', 'ARGOMULYO', '73_24_10', '73_24', '73', 6, 'admin'),
('73_24_10_2006', 'SUMBER MAKMUR', '73_24_10', '73_24', '73', 6, 'admin'),
('73_24_10_2007', 'MEKAR SARI', '73_24_10', '73_24', '73', 6, 'admin'),
('73_24_11_2001', 'LEDU LEDU', '73_24_11', '73_24', '73', 11, 'admin'),
('73_24_11_2002', 'KAWATA', '73_24_11', '73_24', '73', 12, 'admin'),
('73_24_11_2003', 'TABARANO', '73_24_11', '73_24', '73', 11, 'admin'),
('73_24_11_2004', 'WASUPONDA', '73_24_11', '73_24', '73', 11, 'admin'),
('73_24_11_2005', 'PARUMPANAI', '73_24_11', '73_24', '73', 12, 'admin'),
('73_24_11_2006', 'BALAMBANO', '73_24_11', '73_24', '73', 11, 'admin'),
('73_24_2_1007', 'MAGANI', '73_24_2', '73_24', '73', 13, 'admin'),
('73_24_2_2001', 'NUHA', '73_24_2', '73_24', '73', 13, 'admin'),
('73_24_2_2003', 'NIKKEL', '73_24_2', '73_24', '73', 13, 'admin'),
('73_24_2_2005', 'MATANO', '73_24_2', '73_24', '73', 13, 'admin'),
('73_24_2_2009', 'SOROWAKO', '73_24_2', '73_24', '73', 13, 'admin'),
('73_24_3_2001', 'LOEHA', '73_24_3', '73_24', '73', 16, 'admin'),
('73_24_3_2002', 'MAHALONA', '73_24_3', '73_24', '73', 17, 'admin'),
('73_24_3_2003', 'TIMAMPU', '73_24_3', '73_24', '73', 15, 'admin'),
('73_24_3_2004', 'WAWONDULA', '73_24_3', '73_24', '73', 14, 'admin'),
('73_24_3_2005', 'LANGKAE ARAYA', '73_24_3', '73_24', '73', 14, 'admin'),
('73_24_3_2006', 'TOKALIMBO', '73_24_3', '73_24', '73', 16, 'admin'),
('73_24_3_2007', 'BARUGA', '73_24_3', '73_24', '73', 14, 'admin'),
('73_24_3_2008', 'PEKALOA', '73_24_3', '73_24', '73', 15, 'admin'),
('73_24_3_2009', 'LIOKA', '73_24_3', '73_24', '73', 14, 'admin'),
('73_24_3_2010', 'ASULI', '73_24_3', '73_24', '73', 14, 'admin'),
('73_24_3_2011', 'BANTILANG', '73_24_3', '73_24', '73', 16, 'admin'),
('73_24_3_2012', 'MASIKU', '73_24_3', '73_24', '73', 16, 'admin'),
('73_24_3_2013', 'RANTE ANGIN', '73_24_3', '73_24', '73', 16, 'admin'),
('73_24_3_2014', 'MATOMPI', '73_24_3', '73_24', '73', 15, 'admin'),
('73_24_3_2015', 'TOLE', '73_24_3', '73_24', '73', 17, 'admin'),
('73_24_3_2016', 'LIBUKAN MANDIRI', '73_24_3', '73_24', '73', 17, 'admin'),
('73_24_3_2017', 'KALOSI', '73_24_3', '73_24', '73', 17, 'admin'),
('73_24_3_2018', 'BUANGIN', '73_24_3', '73_24', '73', 17, 'admin'),
('73_24_4_1003', 'MALILI', '73_24_4', '73_24', '73', 8, 'admin'),
('73_24_4_2002', 'LASKAP', '73_24_4', '73_24', '73', 9, 'admin'),
('73_24_4_2004', 'MANURUNG', '73_24_4', '73_24', '73', 10, 'admin'),
('73_24_4_2005', 'WEWANG RIU', '73_24_4', '73_24', '73', 8, 'admin'),
('73_24_4_2006', 'BARUGA', '73_24_4', '73_24', '73', 8, 'admin'),
('73_24_4_2007', 'LAKAWALI', '73_24_4', '73_24', '73', 10, 'admin'),
('73_24_4_2008', 'USSU', '73_24_4', '73_24', '73', 8, 'admin'),
('73_24_4_2009', 'TARABBI', '73_24_4', '73_24', '73', 10, 'admin'),
('73_24_4_2010', 'BALANTANG', '73_24_4', '73_24', '73', 8, 'admin'),
('73_24_4_2011', 'ATUE', '73_24_4', '73_24', '73', 8, 'admin'),
('73_24_4_2012', 'PONGKERU', '73_24_4', '73_24', '73', 9, 'admin'),
('73_24_4_2013', 'PUNCAK INDAH', '73_24_4', '73_24', '73', 8, 'admin'),
('73_24_4_2014', 'PASIPASI', '73_24_4', '73_24', '73', 9, 'admin'),
('73_24_4_2015', 'LAKAWALI PANTAI', '73_24_4', '73_24', '73', 10, 'admin'),
('73_24_5_2001', 'TAWAKUA', '73_24_5', '73_24', '73', 7, 'admin'),
('73_24_5_2002', 'TAMPINNA', '73_24_5', '73_24', '73', 7, 'admin'),
('73_24_5_2003', 'SOLO', '73_24_5', '73_24', '73', 7, 'admin'),
('73_24_5_2004', 'TARIPA', '73_24_5', '73_24', '73', 7, 'admin'),
('73_24_5_2005', 'MANTADULU', '73_24_5', '73_24', '73', 7, 'admin'),
('73_24_5_2006', 'BALIREJO', '73_24_5', '73_24', '73', 7, 'admin'),
('73_24_5_2007', 'MALIWOWO', '73_24_5', '73_24', '73', 7, 'admin'),
('73_24_5_2008', 'LAMAETO', '73_24_5', '73_24', '73', 7, 'admin'),
('73_24_5_2009', 'WATANGPANUA', '73_24_5', '73_24', '73', 7, 'admin'),
('73_24_5_2010', 'WANASARI', '73_24_5', '73_24', '73', 7, 'admin'),
('73_24_6_2001', 'LAMPENAI', '73_24_6', '73_24', '73', 2, 'admin'),
('73_24_6_2002', 'TARENGGE', '73_24_6', '73_24', '73', 2, 'admin'),
('73_24_6_2003', 'MARAMBA', '73_24_6', '73_24', '73', 2, 'admin'),
('73_24_6_2004', 'CENDANA HIJAU', '73_24_6', '73_24', '73', 2, 'admin'),
('73_24_6_2005', 'BAWALIPU', '73_24_6', '73_24', '73', 2, 'admin'),
('73_24_6_2006', 'KALAENA', '73_24_6', '73_24', '73', 2, 'admin'),
('73_24_6_2007', 'LERA', '73_24_6', '73_24', '73', 2, 'admin'),
('73_24_6_2008', 'KANAWATU', '73_24_6', '73_24', '73', 2, 'admin'),
('73_24_6_2009', 'BAHARI', '73_24_6', '73_24', '73', 2, 'admin'),
('73_24_6_2010', 'KARAMBUA', '73_24_6', '73_24', '73', 2, 'admin'),
('73_24_6_2011', 'PEPURO BARAT', '73_24_6', '73_24', '73', 2, 'admin'),
('73_24_6_2012', 'BALOBALO', '73_24_6', '73_24', '73', 2, 'admin'),
('73_24_6_2013', 'RINJANI', '73_24_6', '73_24', '73', 2, 'admin'),
('73_24_6_2014', 'TARENGGE TIMUR', '73_24_6', '73_24', '73', 2, 'admin'),
('73_24_6_2015', 'MADANI', '73_24_6', '73_24', '73', 2, 'admin'),
('73_24_6_2016', 'TABAROGE', '73_24_6', '73_24', '73', 2, 'admin'),
('73_24_7_2001', 'BURAU', '73_24_7', '73_24', '73', 1, 'admin'),
('73_24_7_2002', 'JALAJJA', '73_24_7', '73_24', '73', 1, 'admin'),
('73_24_7_2003', 'LEWONU', '73_24_7', '73_24', '73', 1, 'admin'),
('73_24_7_2004', 'LAMBARESE', '73_24_7', '73_24', '73', 1, 'admin'),
('73_24_7_2005', 'LAUWO', '73_24_7', '73_24', '73', 1, 'admin'),
('73_24_7_2006', 'BONEPUTE', '73_24_7', '73_24', '73', 1, 'admin'),
('73_24_7_2007', 'LUMBEWE', '73_24_7', '73_24', '73', 1, 'admin'),
('73_24_7_2008', 'MABONTA', '73_24_7', '73_24', '73', 1, 'admin'),
('73_24_7_2009', 'LARO', '73_24_7', '73_24', '73', 1, 'admin'),
('73_24_7_2010', 'BENTENG', '73_24_7', '73_24', '73', 1, 'admin'),
('73_24_7_2011', 'BATU PUTIH', '73_24_7', '73_24', '73', 1, 'admin'),
('73_24_7_2012', 'LANOSI', '73_24_7', '73_24', '73', 1, 'admin'),
('73_24_7_2013', 'LAGEGO', '73_24_7', '73_24', '73', 1, 'admin'),
('73_24_7_2014', 'CENDANA', '73_24_7', '73_24', '73', 1, 'admin'),
('73_24_7_2015', 'BURAU PANTAI', '73_24_7', '73_24', '73', 1, 'admin'),
('73_24_7_2016', 'ASANA', '73_24_7', '73_24', '73', 1, 'admin'),
('73_24_7_2017', 'KALATIRI', '73_24_7', '73_24', '73', 1, 'admin'),
('73_24_7_2018', 'HARAPAN', '73_24_7', '73_24', '73', 9, 'admin'),
('73_24_7_2019', 'LAMBARA HARAPAN', '73_24_7', '73_24', '73', 1, 'admin'),
('73_24_8_1003', 'TOMONI', '73_24_8', '73_24', '73', 3, 'admin'),
('73_24_8_2001', 'BAYONDO', '73_24_8', '73_24', '73', 3, 'admin'),
('73_24_8_2002', 'MULYA SARI', '73_24_8', '73_24', '73', 3, 'admin'),
('73_24_8_2007', 'LESTARI', '73_24_8', '73_24', '73', 3, 'admin'),
('73_24_8_2008', 'KALPATARU', '73_24_8', '73_24', '73', 3, 'admin'),
('73_24_8_2011', 'TADULAKO', '73_24_8', '73_24', '73', 3, 'admin'),
('73_24_8_2012', 'BERINGIN JAYA', '73_24_8', '73_24', '73', 3, 'admin'),
('73_24_8_2015', 'BANGUN JAYA', '73_24_8', '73_24', '73', 3, 'admin'),
('73_24_8_2016', 'MANDIRI', '73_24_8', '73_24', '73', 3, 'admin'),
('73_24_8_2017', 'SUMBER ALAM', '73_24_8', '73_24', '73', 3, 'admin'),
('73_24_8_2018', 'UJUNG BARU', '73_24_8', '73_24', '73', 3, 'admin'),
('73_24_8_2019', 'BANGUN KARYA', '73_24_8', '73_24', '73', 3, 'admin'),
('73_24_8_2020', 'RANTE MARIO', '73_24_8', '73_24', '73', 3, 'admin'),
('73_24_9_2001', 'KERTORAHARJO', '73_24_9', '73_24', '73', 4, 'admin'),
('73_24_9_2002', 'CENDANA HITAM', '73_24_9', '73_24', '73', 4, 'admin'),
('73_24_9_2003', 'PURWOSARI', '73_24_9', '73_24', '73', 4, 'admin'),
('73_24_9_2004', 'PATTENGKO', '73_24_9', '73_24', '73', 4, 'admin'),
('73_24_9_2005', 'MANUNGGAL', '73_24_9', '73_24', '73', 4, 'admin'),
('73_24_9_2006', 'MARGOMULYO', '73_24_9', '73_24', '73', 4, 'admin'),
('73_24_9_2007', 'ALAM BUANA', '73_24_9', '73_24', '73', 4, 'admin'),
('73_24_9_2008', 'CENDANA HITAM TIMUR', '73_24_9', '73_24', '73', 4, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `master_dusun`
--

CREATE TABLE `master_dusun` (
  `id_dusun` int(11) NOT NULL,
  `nama_dusun` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `username` varchar(50) NOT NULL,
  `nama_petugas_dusun` varchar(255) NOT NULL,
  `no_hp` varchar(255) NOT NULL,
  `id_desa` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_uca1400_ai_ci;

--
-- Dumping data for table `master_dusun`
--

INSERT INTO `master_dusun` (`id_dusun`, `nama_dusun`, `username`, `nama_petugas_dusun`, `no_hp`, `id_desa`) VALUES
(33, 'Mawar', 'BOBA', 'Askari', '085255541755', '72_12_8_2016'),
(35, 'Melati', 'BOBA', '', '', '72_12_8_2016'),
(36, 'Cengkeh', 'LEMOWALIA', '', '', '72_12_8_2020'),
(37, 'Coklat', 'LEMOWALIA', '', '', '72_12_8_2020'),
(38, 'Rambutan', 'LEMOWALIA', '', '', '72_12_8_2020'),
(39, 'Janda Bolong', 'BOBA', '', '', '72_12_8_2016'),
(40, 'Mekar', 'BOBA', '', '', '72_12_8_2016'),
(41, 'Matahari', 'BOBA', '', '', '72_12_8_2016'),
(42, 'Kambing', 'LIJO', '', '', '72_12_9_2007'),
(43, 'Ayam', 'LIJO', '', '', '72_12_9_2007'),
(44, 'Ular', 'LIJO', '', '', '72_12_9_2007'),
(45, 'Kepiting', 'LIJO', '', '', '72_12_9_2007'),
(46, 'Ikan', 'LIJO', '', '', '72_12_9_2007'),
(47, 'Matahari', 'BATURUBE', '', '', '72_12_8_2001'),
(48, 'Bulan', 'BATURUBE', '', '', '72_12_8_2001'),
(49, 'Bintang', 'BATURUBE', '', '', '72_12_8_2001'),
(50, 'Planet', 'BATURUBE', '', '', '72_12_8_2001'),
(51, 'Mars', 'KALOMBANG', '', '', '72_12_8_2017'),
(52, 'Pluto', 'KALOMBANG', '', '', '72_12_8_2017'),
(53, 'Piring', 'LONDI', '', '', '72_12_5_2002'),
(54, 'Sendok', 'LONDI', '', '', '72_12_5_2002'),
(55, 'Garpu', 'LONDI', '', '', '72_12_5_2002'),
(56, 'Bolu', 'LEMO', '', '', '72_12_8_2009'),
(57, 'Nastar', 'LEMO', '', '', '72_12_8_2009'),
(58, 'Roti Maros', 'LEMO', '', '', '72_12_8_2009'),
(59, 'Bika Ambon', 'LEMO', '', '', '72_12_8_2009'),
(60, 'Meja', 'MALINO', '', '', '72_12_7_2004'),
(61, 'Kursi', 'MALINO', '', '', '72_12_7_2004'),
(62, 'A', 'TARONGGO', '', '', '72_12_8_2003'),
(63, 'B', 'TARONGGO', '', '', '72_12_8_2003'),
(64, 'C', 'TARONGGO', '', '', '72_12_8_2003'),
(65, 'Siwa', 'PEBOA', '', '', '72_12_2_2012'),
(66, 'Buriko', 'PEBOA', '', '', '72_12_2_2012'),
(67, 'Mangkok', 'LONDI', '', '', '72_12_5_2002'),
(68, 'Lisptik', 'LEE', '', '', '72_12_5_2009'),
(69, 'Bedak', 'LEE', '', '', '72_12_5_2009'),
(70, 'Iphone 15', 'BAHOUE', '', '', '72_12_1_1003'),
(71, 'Oppo', 'BAHOUE', '', '', '72_12_1_1003'),
(72, 'Xiomi', 'BAHOUE', '', '', '72_12_1_1003'),
(75, 'Jawi', 'BAU', '', '', '72_12_7_2007'),
(76, 'Sony', 'BAHONTULA', '', '', '72_12_1_1002'),
(77, 'Toshiba', 'BAHONTULA', '', '', '72_12_1_1002'),
(78, 'Bulete', 'BAU', 'Hasim', '092333222333', '72_12_7_2007'),
(79, 'Atopiclair', 'BETELEME', 'Lafusin', '088833888222', '72_12_4_2001');

-- --------------------------------------------------------

--
-- Table structure for table `master_kecamatan`
--

CREATE TABLE `master_kecamatan` (
  `id_kecamatan` char(39) NOT NULL,
  `kecamatan` varchar(900) DEFAULT NULL,
  `id_kota` char(39) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_uca1400_ai_ci;

--
-- Dumping data for table `master_kecamatan`
--

INSERT INTO `master_kecamatan` (`id_kecamatan`, `kecamatan`, `id_kota`) VALUES
('73_24_1', 'MANGKUTANA', '73_24'),
('73_24_10', 'KALAENA', '73_24'),
('73_24_11', 'WASUPONDA', '73_24'),
('73_24_2', 'NUHA', '73_24'),
('73_24_3', 'TOWUTI', '73_24'),
('73_24_4', 'MALILI', '73_24'),
('73_24_5', 'ANGKONA', '73_24'),
('73_24_6', 'WOTU', '73_24'),
('73_24_7', 'BURAU', '73_24'),
('73_24_8', 'TOMONI', '73_24'),
('73_24_9', 'TOMONI TIMUR', '73_24');

-- --------------------------------------------------------

--
-- Table structure for table `master_penyakit`
--

CREATE TABLE `master_penyakit` (
  `id_penyakit` int(11) NOT NULL,
  `nama_penyakit` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `penyakit_seo` varchar(100) NOT NULL,
  `urutan` int(11) DEFAULT NULL,
  `bentuk` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `master_penyakit`
--

INSERT INTO `master_penyakit` (`id_penyakit`, `nama_penyakit`, `username`, `penyakit_seo`, `urutan`, `bentuk`) VALUES
(120, 'Campak Lanjutan', 'admin', 'hepatitis_hbs_ag_', 15, 1),
(121, 'IPV', 'admin', 'difteri', 11, 1),
(117, 'BCG', 'admin', 'diare_berdarah', 3, 1),
(119, 'Pentavalen (1)', 'admin', 'tifus_perut_widal_kultur_', 5, 1),
(122, 'Polio (3)', 'admin', 'kusta_pb', 8, 1),
(128, 'Pentavalen (2)', 'admin', 'tersangka_tbc_paru', 7, 1),
(124, 'MR', 'admin', 'batuk_rejan', 12, 1),
(125, 'Pentavalen (3)', 'admin', 'kusta_mb', 9, 1),
(126, 'Polio (2)', 'admin', 'tbc_paru_bta_', 6, 1),
(127, 'Polio (1)', 'admin', 'tifus_perut_klinis', 4, 1),
(129, 'Pentavalen Lanjutan', 'admin', 'hepatitis_klinis', 14, 1),
(130, 'Polio (4)', 'admin', 'campak', 10, 1),
(137, 'HB0 (1>7 Hari)', 'admin', 'diare', 2, 1),
(138, 'MR Lanjutan', 'admin', 'malaria_klinis', 16, 1),
(154, 'HB0 (< 24 Jam)', 'admin', 'kolera', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `master_permohonan`
--

CREATE TABLE `master_permohonan` (
  `id_permohonan` int(11) NOT NULL,
  `nama_permohonan` varchar(255) NOT NULL,
  `nama_tabel` varchar(50) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `nama_file_balasan` varchar(255) DEFAULT NULL,
  `file_balasan` varchar(255) DEFAULT NULL,
  `peringatan` varchar(255) DEFAULT NULL,
  `ket` text NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `penjelasan` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `master_permohonan`
--

INSERT INTO `master_permohonan` (`id_permohonan`, `nama_permohonan`, `nama_tabel`, `deskripsi`, `nama_file_balasan`, `file_balasan`, `peringatan`, `ket`, `icon`, `penjelasan`) VALUES
(1, 'Akta Kelahiran, Kartu Keluarga, KIA', 'paket_a', 'Akta Kelahiran, Kartu Keluarga, KIA (Kartu Identitas Anak) untuk bayi baru lahir', 'Akta Kelahiran, Kartu Keluarga, KIA (Kartu Identitas Anak)', 'aktalahirbaru,kkbaru,kiabaru', '1,1,0', 'KIA (Kartu Identitas Anak) fisik akan dikirimkan ke alamat pemohon. Biaya pengiriman akan ditanggung oleh pemohon/penerima melalui metode COD', 'icon_1746207598.jpg', '<p>Paket ini disediakan bagi warga yang baru saja mendapatkan anggota keluarga baru (bayi baru lahir). Dalam satu pengajuan, Anda bisa langsung mengurus tiga dokumen kependudukan penting sekaligus, yaitu:</p><strong>Dokumen Yang Dihasilkan :</strong><br><ol><li><strong>Akta Kelahiran</strong><br> Dokumen resmi yang mencatat kelahiran anak. Dibutuhkan untuk keperluan pendidikan, kesehatan, dan administrasi lainnya.</li><li><strong>Perubahan Kartu Keluarga (KK)</strong><br> Untuk Kartu Keluarga perlu diperbarui untuk mencantumkan anggota keluarga baru (bayi).</li><li><strong>KIA (Kartu Identitas Anak)</strong><br> KIA adalah identitas resmi untuk anak usia 0–17 tahun. Berguna untuk layanan pendidikan, kesehatan, dan identifikasi anak.</li></ol>'),
(2, 'Akta Kematian, Kartu Keluarga, KTP-El', 'paket_b', 'Akta Kematian, Kartu Keluarga, KTP Elektronik', 'Kartu Keluarga, Akta Kematian, KTP Elektornik', 'kkbaru,aktamatibaru,laindukcapil', '1,1,0', 'KTP Elektronik fisik akan dikirimkan ke alamat pemohon. Biaya pengiriman akan ditanggung oleh pemohon/penerima melalui metode COD', 'icon_1746207207.jpg', '<p>Permohonan ini mencakup tiga dokumen kependudukan penting yang perlu diperbarui atau diterbitkan setelah seseorang meninggal dunia:</p><strong>Dokumen Yang Dihasilkan :</strong><br>  <ul>  <li>    <strong>Akta Kematian</strong><br>    Dokumen resmi yang menerangkan peristiwa kematian seseorang. Dibutuhkan untuk keperluan hukum, administrasi, dan pewarisan.  </li>  <li>    <strong>Perubahan Kartu Keluarga (KK)</strong><br>    Kartu Keluarga perlu diperbarui untuk menghapus anggota keluarga yang telah meninggal dari data kependudukan.  </li>  <li>    <strong>KTP Elektronik (KTP-el)</strong><br>    Diperlukan untuk mencetak ulang atau memperbarui KTP anggota keluarga lain apabila ada perubahan data akibat kematian (misalnya status hubungan keluarga).  </li></ul>'),
(3, 'Pisah Kartu Keluarga', 'paket_c', 'Kartu Keluarga, KTP Elektronik', 'Kartu Keluarga, KTP Elektronik', 'kkbaru,laindukca', '1,0', 'KTP Elektronik fisik akan dikirimkan ke alamat pemohon. Biaya pengiriman akan ditanggung oleh pemohon/penerima melalui metode COD', 'icon_1745996655.jpg', '<p>Permohonan ini diajukan oleh warga yang ingin memisahkan diri dari Kartu Keluarga (KK) lama dan membuat KK baru, biasanya karena pernikahan, perceraian, numpang KK atau alasan lain yang sah menurut hukum.</p><strong>Dokumen Yang Dihasilkan :</strong><br><ul>  <li>    <strong>Kartu Keluarga (KK)</strong><br>    Dokumen yang diterbitkan untuk kepala keluarga baru setelah dilakukan pemisahan dari KK sebelumnya.  </li>  <li>    <strong>KTP Elektronik (KTP-el)</strong><br>    Diperlukan untuk mencetak ulang KTP anggota keluarga yang berubah status atau alamat sebagai akibat dari pemisahan KK.  </li></ul>'),
(4, 'Perubahan Data Kartu Keluarga', 'paket_d', 'Perubahan Kartu Keluarga', 'Kartu Keluarga', 'kkbaru', '1', '', 'icon_1746208398.jpg', '<p>Pembaharuan data pada Kartu Keluarga (KK) diperlukan apabila terdapat perubahan informasi yang relevan tentang anggota keluarga, seperti penambahan, pengurangan, atau perubahan status anggota keluarga. Proses ini bertujuan untuk memastikan bahwa data kependudukan Anda selalu terupdate dan akurat sesuai dengan kondisi terkini.</p><p>Permohonan ini mencakup berbagai perubahan yang dapat dilakukan, di antaranya:</p><ul>  <li>    <strong>Penambahan Anggota Keluarga</strong><br>    Penambahan anggota keluarga baru, seperti bayi yang baru lahir atau anggota keluarga yang baru saja pindah atau menikah. Proses ini memerlukan dokumen pendukung seperti Akta Lahir atau Surat Lahir.  </li>  <li>    <strong>Penghapusan Anggota Keluarga</strong><br>    Penghapusan anggota keluarga yang sudah meninggal atau anggota yang tidak lagi menjadi bagian dari keluarga. Dokumen yang diperlukan antara lain Akta Kematian atau Surat Kematian dari Desa/Kelurahan.  </li>  <li>    <strong>Perubahan Status Perkawinan</strong><br>    Jika ada perubahan status perkawinan, seperti menikah atau bercerai, Anda perlu memperbarui status tersebut di Kartu Keluarga. Dokumen seperti Buku Nikah, Akta Kawin, atau Akta Cerai akan diperlukan untuk proses ini.  </li>  <li>    <strong>Perubahan Data Pribadi</strong><br>    Pembaruan data pribadi anggota keluarga, seperti nama, tempat dan tanggal lahir, atau alamat. Dokumen yang diperlukan seperti Ijazah atau dokumen identitas lainnya.  </li></ul><p>Proses perubahan data ini penting untuk memastikan bahwa semua informasi dalam Kartu Keluarga tetap akurat dan dapat digunakan untuk berbagai keperluan administrasi dan hukum.</p>'),
(6, 'Perpindahan Keluar WNI/WNA (SKPWNI/SKPOA)', 'paket_f', 'Surat Keterangan Pindah WNI & WNA dalam Wilayah NKRI (SKPWNI/SKPOA)', 'Surat Keterangan Pindah WNI & WNA dalam Wilayah NKRI (SKPWNI/SKPOA)', 'skpwni', '1', '', 'icon_1746201523.jpg', '<p>Permohonan <strong>Perpindahan Keluar WNI/WNA</strong> dilakukan apabila seorang Warga Negara Indonesia (WNI) atau Warga Negara Asing (WNA) pindah tempat tinggal ke luar wilayah administrasi desa/kelurahan saat ini, baik antar kabupaten, atau provinsi, dalam wilayah NKRI. Permohonan ini membutuhkan beberapa dokumen pendukung untuk memastikan keabsahan dan kelengkapan data kependudukan yang bersangkutan:</p>'),
(7, 'Kedatangan', 'paket_g', 'Surat Keterangan Pindah Datang (SKPD)', 'Surat Keterangan Pindah Datang (SKPD)', 'skpd', '1', '', 'icon_1745996703.png', 'Surat Keterangan Pindah Datang (SKPD) adalah dokumen resmi yang diterbitkan oleh Dinas Kependudukan dan Pencatatan Sipil (Disdukcapil) wilayah tujuan untuk mencatat dan mengesahkan kepindahan seseorang dari daerah asal ke daerah baru.'),
(8, 'SKTT WNA', 'paket_h', 'Surat Keterangan Tempat Tinggal Bagi WNA', 'Surat Keterangan Tempat Tinggal WNA', 'skttl', '1', '', 'icon_1745996746.jpg', 'Surat Keterangan Tempat Tinggal (SKTT) adalah dokumen resmi yang wajib dimiliki oleh Warga Negara Asing (WNA) yang tinggal di Indonesia dalam jangka waktu tertentu. Dokumen ini diterbitkan berlaku sebagai bukti bahwa WNA tersebut telah terdata secara sah di wilayah domisili mereka'),
(9, 'Akta Kelahiran Orang Dewasa', 'paket_i', 'Pembuatan Akta Kelahiran untuk Orang Dewasa yang Sudah Memiliki NIK', 'Akta Kelahiran', 'aktalahir', '1', '', 'icon_1745996865.png', 'Akta Kelahiran untuk orang dewasa adalah dokumen resmi yang diterbitkan oleh Dinas Kependudukan dan Pencatatan Sipil (Disdukcapil) untuk warga yang belum memiliki akta kelahiran meskipun sudah memiliki NIK dan masuk dalam Kartu Keluarga (KK)'),
(10, 'Akta Kematian', 'paket_j', 'Akta Kematian', 'Akta Kematian', 'aktamati', '1', '', 'icon_1745996905.png', 'Akta Kematian adalah dokumen resmi yang diterbitkan menyatakan bahwa seseorang telah meninggal dunia. Akta ini merupakan bukti sah kematian seseorang dan digunakan untuk keperluan administratif dan hukum, seperti mengurus warisan, klaim asuransi, dan pembaruan status di Kartu Keluarga (KK).'),
(11, 'Ralat/Duplikat Akta Kelahiran', 'paket_k', 'Ralat/Duplikat Akta Kelahiran', 'Dokumen Ralat/Duplikat Akta Kelahiran', 'ralatlahir', '1', '', 'dup_akta_lahir.png', '<strong>Permohonan Ralat atau Duplikat Akta Kelahiran</strong> diajukan ketika terdapat kesalahan data dalam akta kelahiran yang telah diterbitkan, atau jika akta tersebut hilang dan perlu diterbitkan kembali. Proses ini bertujuan untuk memastikan bahwa informasi dalam akta kelahiran sesuai dengan data yang benar dan sah menurut hukum.<br><strong>Ralat Akta Kelahiran</strong> dilakukan jika terdapat kesalahan penulisan atau informasi dalam akta, seperti nama, tempat/tanggal lahir, nama orang tua, atau data lainnya. Ralat dilakukan melalui permohonan resmi dengan melampirkan dokumen pembanding yang valid.<br><strong>Duplikat Akta Kelahiran</strong> diajukan apabila akta asli hilang atau rusak. Proses ini memerlukan bukti kehilangan dari kepolisian dan dokumen pendukung lainnya agar instansi dapat menerbitkan kembali salinan sah akta kelahiran.'),
(12, 'Ralat/Duplikat Akta Kematian', 'paket_l', 'Ralat/Duplikat Akta Kematian', 'Dokumen Ralat/Duplikat Akta Kematian', 'ralatmati', '1', '', 'dup_mati.png', '<strong>Permohonan Ralat atau Duplikat Akta Kematian</strong> adalah proses administratif yang diajukan oleh ahli waris, keluarga, atau pihak yang berwenang untuk:<br><strong>Ralat Akta Kematian: </strong>Mengoreksi kesalahan penulisan atau informasi yang tercantum dalam akta kematian, seperti nama, tanggal lahir, tempat kematian, atau informasi lain yang tidak sesuai dengan dokumen pendukung resmi.<br><strong>Duplikat Akta Kematian: </strong>Mengajukan penerbitan ulang akta kematian yang hilang, rusak, atau tidak terbaca. Duplikat akan berisi data yang sama seperti dokumen asli yang sah.'),
(13, 'Akta Perkawinan WNI Non-Muslim', 'paket_m', 'Akta Perkawinan Warga Negara Indonesia Non-Muslim', 'Akta Perkawinan', 'aktakawin', '1', '', 'akta_no.png', 'Permohonan Akta Perkawinan Warga Negara Indonesia Non-Muslim adalah proses pencatatan resmi perkawinan yang dilakukan oleh pasangan WNI yang beragama non-Muslim, seperti Kristen, Katolik, Hindu, Buddha, atau Konghucu.<br>Pencatatan ini penting agar pasangan diakui secara hukum untuk berbagai keperluan, seperti pengurusan dokumen keluarga (KK, KTP), hak waris, tunjangan, dan perlindungan hukum lainnya'),
(14, 'Perkawinan / Perceraian di Luar Negeri', 'paket_n', 'Perkawinan / Perceraian di Luar Negeri', 'Perkawinan / Perceraian di Luar Negeri', 'kawino', '1', '', 'icon_1745997016.png', 'Permohonan pencatatan Perkawinan atau Perceraian di Luar Negeri adalah proses administrasi yang dilakukan oleh Warga Negara Indonesia (WNI) untuk mendaftarkan secara resmi peristiwa perkawinan atau perceraian yang terjadi di luar negeri agar diakui secara hukum di Indonesia'),
(15, 'Akta Perceraian', 'paket_o', 'Akta Perceraian bagi Non Muslim', 'Akta Perceraian', 'aktacerai', '1', '', 'icon_1745997024.png', 'Akta Perceraian bagi Non-Muslim adalah proses pencatatan resmi atas perceraian yang telah diputuskan oleh pengadilan bagi warga negara Indonesia beragama Non-Muslim. Karena perkawinan dan perceraian Non-Muslim dicatat oleh Dinas Kependudukan dan Pencatatan Sipil (Dukcapil), maka akta perceraian menjadi bukti hukum sah atas berakhirnya hubungan perkawinan'),
(5, 'KIA (Kartu Identitas Anak)', 'paket_e', 'KIA (Kartu Identitas Anak)', 'KIA', 'kianya', '0', 'KIA (Kartu Identitas Anak) fisik akan dikirimkan ke alamat pemohon. Biaya pengiriman akan ditanggung oleh pemohon/penerima melalui metode COD', 'kia_ori.png', '<p>Permohonan untuk Kartu Identitas Anak (KIA) diperlukan untuk memberikan identitas resmi kepada anak usia 0-17 tahun. KIA sangat penting untuk berbagai keperluan administratif dan pendidikan. Proses pengajuan KIA melibatkan beberapa syarat yang harus dipenuhi, yaitu:</p>'),
(16, 'Kartu Keluarga Baru untuk Penduduk Tanpa NIK (Rentan)', 'paket_p', 'Kartu Keluarga (KK) Baru Bagi Penduduk yang Belum Memiliki NIK (Rentan)', 'Kartu Keluarga', 'kkbaru', '1', '', 'icon_1745993625.jpg', 'Permohonan Kartu Keluarga (KK) Baru Bagi Penduduk yang Belum Memiliki NIK (Rentan) biasanya diajukan untuk mereka yang belum terdaftar dalam sistem administrasi kependudukan, terutama bagi penduduk yang belum memiliki Nomor Induk Kependudukan (NIK), yang termasuk dalam kelompok rentan. Ini sering kali berlaku untuk orang-orang yang lahir di daerah terpencil atau memiliki kendala administratif dalam memperoleh dokumen kependudukan.<br>Permohonan ini sangat krusial untuk memastikan penduduk rentan terdaftar dalam sistem administrasi negara dan dapat memperoleh hak-hak sosial dan administratif yang sesuai'),
(17, 'Kartu Keluarga Hilang/rusak Belum TTE', 'paket_q', 'Penerbitan Kartu Keluarga (KK) Karena Hilang Atau Rusak Yang Belum TTE', 'Kartu Keluarga', 'kkbaru', '1', '', 'fd4e496e6614e306d91b98fddb19e858.jpg', 'Permohonan Penerbitan Kartu Keluarga (KK) karena Hilang atau Rusak yang Belum TTE (Tanda Tangan Elektronik) ditujukan untuk penduduk yang kehilangan dokumen KK fisik atau memiliki KK yang rusak, dan dokumen tersebut belum menggunakan sistem Tanda Tangan Elektronik (TTE) dari Dinas Dukcapil. KK versi lama ini masih berupa cetakan manual dengan tanda tangan dan stempel basah'),
(18, 'Kartu Keluarga Penghayat Kepercayaan (Data Sudah Terekam)', 'paket_r', 'Kartu Keluarga (KK) untuk Penghayat Kepercayaan dengan Data Sudah Terekam di Database Kependudukan', 'Kartu Keluarga', 'kkbaru', '1', '', 'icon_1746025473.png', 'Permohonan Kartu Keluarga (KK) untuk Penghayat Kepercayaan dengan Data Sudah Terekam di Database Kependudukan merupakan layanan administrasi kependudukan bagi warga negara Indonesia yang menganut aliran kepercayaan terhadap Tuhan Yang Maha Esa dan telah memiliki data kependudukan (seperti NIK, KTP-el, dan lainnya) dalam sistem Dukcapil.<br>Permohonan ini bertujuan untuk mencetak atau memperbarui Kartu Keluarga yang mencantumkan <strong>status Penghayat Kepercayaan pada kolom agama</strong>. Hal ini sesuai dengan amanat konstitusi dan putusan Mahkamah Konstitusi, yang menjamin pengakuan dan hak administrasi kependudukan bagi seluruh warga negara, termasuk penghayat kepercayaan'),
(19, 'Perubahan Kartu Keluarga : Agama ke Kepercayaan', 'paket_s', 'Perubahan Data Kartu Keluarga (KK) Terkait Agama Menjadi Kepercayaan terhadap Tuhan YME', 'Kartu Keluarga', 'kkbaru', '1', '', '089cc7428ab80fdc80a805bc0d7b5c8b.png', 'Merupakan layanan administrasi kependudukan yang diberikan kepada warga negara Indonesia yang menganut Penghayat Kepercayaan terhadap Tuhan Yang Maha Esa, untuk mengubah kolom \\\"Agama\\\" dalam Kartu Keluarga (KK) menjadi \\\"Kepercayaan terhadap Tuhan YME\\\" sesuai keyakinan yang dianut'),
(20, 'Pindah WNI Keluar Wilayah NKRI', 'paket_t', 'Surat Keterangan Pindah WNI Keluar Wilayah NKRI (SKPLN)', 'Surat Keterangan Pindah WNI Keluar Wilayah NKRI (SKPLN)', 'skpln', '1', '', 'ed60e8593a278a9114946485abd92114.jpg', 'Surat Keterangan Pindah WNI Keluar Wilayah NKRI (SKPLN) adalah dokumen resmi yang diterbitkan oleh Dinas Kependudukan dan Pencatatan Sipil (Disdukcapil) sebagai bukti bahwa seorang Warga Negara Indonesia (WNI) akan pindah tempat tinggal ke luar negeri untuk jangka waktu tertentu maupun menetap');

-- --------------------------------------------------------

--
-- Table structure for table `master_sekolah`
--

CREATE TABLE `master_sekolah` (
  `id_sekolah` int(11) NOT NULL,
  `sekolah` varchar(100) NOT NULL,
  `id_desa` varchar(100) NOT NULL,
  `desa` varchar(300) DEFAULT NULL,
  `id_kecamatan` char(39) DEFAULT NULL,
  `kecamatan` varchar(100) NOT NULL,
  `id_dusun` int(11) NOT NULL,
  `username` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_uca1400_ai_ci;

--
-- Dumping data for table `master_sekolah`
--

INSERT INTO `master_sekolah` (`id_sekolah`, `sekolah`, `id_desa`, `desa`, `id_kecamatan`, `kecamatan`, `id_dusun`, `username`) VALUES
(4, 'SDN No. 225 KAREBBE', '73_24_4_2002', 'LASKAP', '73_24_4', 'MALILI', 9, 'dusunLAMPIA'),
(5, 'SDN NO. 241 LABOSE', '73_24_4_2002', 'LASKAP', '73_24_4', 'MALILI', 9, 'dusunLAMPIA'),
(6, 'SDN NO. 235 PONGKERU', '73_24_4_2012', 'PONGKERU', '73_24_4', 'MALILI', 9, 'dusunLAMPIA'),
(8, 'SDN  240 PODOMORO', '73_24_4_2007', 'LAKAWALI', '73_24_4', 'MALILI', 10, 'dusunLAKAWALI'),
(9, 'SDN 239 SALUMINANGA', '73_24_4_2015', 'LAKAWALI PANTAI', '73_24_4', 'MALILI', 10, 'dusunLAKAWALI'),
(10, 'SDN NO 102 BURAU', '73_24_7_2001', 'BURAU', '73_24_7', 'BURAU', 1, 'dusunBURAU'),
(11, 'SDN 264 WAWONDULA', '73_24_3_2004', 'WAWONDULA', '73_24_3', 'TOWUTI', 14, 'dusunWAWONDULA'),
(12, 'SDN 152 Kalaena Kiri II', '73_24_10_2001', 'KALAENA KIRI', '73_24_10', 'KALAENA', 6, 'dusunKALAENA'),
(13, 'SDN NO.224 LAMPIA', '73_24_7_2018', 'HARAPAN', '73_24_7', 'BURAU', 9, 'dusunLAMPIA'),
(14, 'SDN 156 Kalaena', '73_24_10_2001', 'KALAENA KIRI', '73_24_10', 'KALAENA', 6, 'dusunKALAENA'),
(15, 'SDN NO.224 LAMPIA KELAS JAUH', '73_24_4_2014', 'PASIPASI', '73_24_4', 'MALILI', 9, 'dusunLAMPIA'),
(16, 'SDN NO.236 LAOLI', '73_24_7_2018', 'HARAPAN', '73_24_7', 'BURAU', 9, 'dusunLAMPIA'),
(17, 'SDN 164 Pertasi Kencana', '73_24_10_2003', 'PERTASI KENCANA', '73_24_10', 'KALAENA', 6, 'dusunKALAENA'),
(18, 'SDN 256 DONGI', '73_24_2_2009', 'SOROWAKO', '73_24_2', 'NUHA', 13, 'dusunNUHA'),
(19, 'SDN 247 SOROWAKO', '73_24_2_2009', 'SOROWAKO', '73_24_2', 'NUHA', 13, 'dusunNUHA'),
(20, 'SDN 151 Kalaena Kiri I', '73_24_10_2002', 'SUMBER AGUNG', '73_24_10', 'KALAENA', 6, 'dusunKALAENA'),
(21, 'SDN 169 BAYONDO', '73_24_8_2001', 'BAYONDO', '73_24_8', 'TOMONI', 3, 'dusunTOMONI'),
(22, 'SDN 252 NIKKEL', '73_24_2_2009', 'SOROWAKO', '73_24_2', 'NUHA', 13, 'dusunNUHA'),
(23, 'SDN 248 NUHA', '73_24_2_2001', 'NUHA', '73_24_2', 'NUHA', 13, 'dusunNUHA'),
(24, 'SDN 158 Balai kembang', '73_24_1_2011', 'BALAI KEMBANG', '73_24_1', 'MANGKUTANA', 5, 'MANGKUTANA'),
(25, 'SDN 146 Maleku', '73_24_1_2001', 'MALEKU', '73_24_1', 'MANGKUTANA', 5, 'MANGKUTANA'),
(26, 'SDN 147 Pakatan', '73_24_1_2001', 'MALEKU', '73_24_1', 'MANGKUTANA', 5, 'MANGKUTANA'),
(27, 'SDN  231 LAKAWALI', '73_24_4_2007', 'LAKAWALI', '73_24_4', 'MALILI', 10, 'dusunLAKAWALI'),
(28, 'SDN NO.171 PURWOSARI', '73_24_9_2003', 'PURWOSARI', '73_24_9', 'TOMONI TIMUR', 4, 'TOMONITIMUR'),
(29, 'SDN 267 Lampesue', '73_24_3_2002', 'MAHALONA', '73_24_3', 'TOWUTI', 17, 'dusunMAHALONA'),
(30, 'SDN 267 Kelas Jauh Garkim', '73_24_3_2018', 'BUANGIN', '73_24_3', 'TOWUTI', 17, 'dusunMAHALONA'),
(31, 'SDN 267 Kelas Jauh Koromalai', '73_24_3_2002', 'MAHALONA', '73_24_3', 'TOWUTI', 17, 'dusunMAHALONA'),
(32, 'SDN 280 SP1 Mahalona', '73_24_3_2016', 'LIBUKAN MANDIRI', '73_24_3', 'TOWUTI', 17, 'dusunMAHALONA'),
(34, 'SDN 220 CEREKANG', '73_24_4_2004', 'MANURUNG', '73_24_4', 'MALILI', 10, 'dusunLAKAWALI'),
(35, 'SDN 232 WULASI', '73_24_4_2004', 'MANURUNG', '73_24_4', 'MALILI', 10, 'dusunLAKAWALI'),
(36, 'SDN 230 TARABBI', '73_24_4_2009', 'TARABBI', '73_24_4', 'MALILI', 10, 'dusunLAKAWALI'),
(37, 'SDN 274 Pekaloa', '73_24_3_2008', 'PEKALOA', '73_24_3', 'TOWUTI', 15, 'dusunTIMAMPU'),
(38, 'SDN 265 Timampu', '73_24_3_2003', 'TIMAMPU', '73_24_3', 'TOWUTI', 15, 'dusunTIMAMPU'),
(39, 'SDN 268 Towuti', '73_24_3_2003', 'TIMAMPU', '73_24_3', 'TOWUTI', 15, 'dusunTIMAMPU'),
(40, 'MI Muhammadiyah Matompi', '73_24_3_2014', 'MATOMPI', '73_24_3', 'TOWUTI', 15, 'dusunTIMAMPU'),
(42, 'SDN 266 BANTILANG', '73_24_3_2011', 'BANTILANG', '73_24_3', 'TOWUTI', 16, 'dusunBANTILANG'),
(44, 'SD 227 puncak indah', '73_24_4_2013', 'PUNCAK INDAH', '73_24_4', 'MALILI', 8, 'dusunMALILI'),
(45, 'SDI Wasuponda', '73_24_11_2004', 'WASUPONDA', '73_24_11', 'WASUPONDA', 11, 'WASUPONDA'),
(46, 'SDN 250 Wasuponda', '73_24_11_2004', 'WASUPONDA', '73_24_11', 'WASUPONDA', 11, 'WASUPONDA'),
(47, 'SD MIS AS\\\'ADIYYAH NO.232 PONGKERU', '73_24_4_2012', 'PONGKERU', '73_24_4', 'MALILI', 9, 'dusunLAMPIA'),
(48, 'SDN No.173 Kertoraharjo', '73_24_9_2001', 'KERTORAHARJO', '73_24_9', 'TOMONI TIMUR', 4, 'TOMONITIMUR'),
(49, 'SDN No.184.Gianyar', '73_24_9_2001', 'KERTORAHARJO', '73_24_9', 'TOMONI TIMUR', 4, 'TOMONITIMUR'),
(50, 'MI Sabili Taqwa', '73_24_9_2006', 'MARGOMULYO', '73_24_9', 'TOMONI TIMUR', 4, 'TOMONITIMUR'),
(51, 'SDN Noi.180 Tampak Siring', '73_24_9_2006', 'MARGOMULYO', '73_24_9', 'TOMONI TIMUR', 4, 'TOMONITIMUR'),
(52, 'SDN No.188 Manunggal', '73_24_9_2005', 'MANUNGGAL', '73_24_9', 'TOMONI TIMUR', 4, 'TOMONITIMUR'),
(53, 'SDN No.181 Welira', '73_24_9_2007', 'ALAM BUANA', '73_24_9', 'TOMONI TIMUR', 4, 'TOMONITIMUR'),
(54, 'SDN No.174 Gunung Sari', '73_24_9_2002', 'CENDANA HITAM', '73_24_9', 'TOMONI TIMUR', 4, 'TOMONITIMUR'),
(55, 'SDN No.177 Cendana Hitam', '73_24_9_2002', 'CENDANA HITAM', '73_24_9', 'TOMONI TIMUR', 4, 'TOMONITIMUR'),
(56, 'SDN No.182 Bakti Nusa', '73_24_9_2008', 'CENDANA HITAM TIMUR', '73_24_9', 'TOMONI TIMUR', 4, 'TOMONITIMUR'),
(57, 'MI Cendana Hitam', '73_24_9_2004', 'PATTENGKO', '73_24_9', 'TOMONI TIMUR', 4, 'TOMONITIMUR'),
(58, 'SDN No.179 Baku', '73_24_9_2004', 'PATTENGKO', '73_24_9', 'TOMONI TIMUR', 4, 'TOMONITIMUR'),
(59, 'SDN 206 MANTADULU', '73_24_5_2005', 'MANTADULU', '73_24_5', 'ANGKONA', 7, 'dusunANGKONA'),
(60, 'SDS ALMUJAHIDIN MANTADULU', '73_24_5_2005', 'MANTADULU', '73_24_5', 'ANGKONA', 7, 'dusunANGKONA'),
(61, 'SDN 207 TARIPA', '73_24_5_2004', 'TARIPA', '73_24_5', 'ANGKONA', 7, 'dusunANGKONA'),
(62, 'SDN 213 RINJANI', '73_24_5_2004', 'TARIPA', '73_24_5', 'ANGKONA', 7, 'dusunANGKONA'),
(63, 'SDS DDI AL-FALAH ANGKONA', '73_24_5_2002', 'TAMPINNA', '73_24_5', 'ANGKONA', 7, 'dusunANGKONA'),
(64, 'SDS MUH. DARUL ARQAM', '73_24_5_2002', 'TAMPINNA', '73_24_5', 'ANGKONA', 7, 'dusunANGKONA'),
(65, 'SDN 202 ANGKONA', '73_24_5_2002', 'TAMPINNA', '73_24_5', 'ANGKONA', 7, 'dusunANGKONA'),
(66, 'SDN 208 LAMBARU', '73_24_5_2002', 'TAMPINNA', '73_24_5', 'ANGKONA', 7, 'dusunANGKONA'),
(67, 'SDN 210 MALIWOWO', '73_24_5_2007', 'MALIWOWO', '73_24_5', 'ANGKONA', 7, 'dusunANGKONA'),
(68, 'SDN 212 BUBU', '73_24_5_2007', 'MALIWOWO', '73_24_5', 'ANGKONA', 7, 'dusunANGKONA'),
(69, 'SDN 205 KAL KIRI IV', '73_24_5_2008', 'LAMAETO', '73_24_5', 'ANGKONA', 7, 'dusunANGKONA'),
(70, 'SDN 209 MANTAIPI', '73_24_5_2001', 'TAWAKUA', '73_24_5', 'ANGKONA', 7, 'dusunANGKONA'),
(71, 'SDS MI NAHDATUL WATHAN', '73_24_5_2001', 'TAWAKUA', '73_24_5', 'ANGKONA', 7, 'dusunANGKONA'),
(72, 'SDN 211 TAWAKUA', '73_24_5_2001', 'TAWAKUA', '73_24_5', 'ANGKONA', 7, 'dusunANGKONA'),
(73, 'SDN 203 BONGKAMANU', '73_24_5_2003', 'SOLO', '73_24_5', 'ANGKONA', 7, 'dusunANGKONA'),
(74, 'SDN 204 KAL KIRI III', '73_24_5_2006', 'BALIREJO', '73_24_5', 'ANGKONA', 7, 'dusunANGKONA'),
(75, 'SDN 214 KAL KIRI III', '73_24_5_2006', 'BALIREJO', '73_24_5', 'ANGKONA', 7, 'dusunANGKONA'),
(80, 'SDN 120 CAMPAE', '73_24_6_2005', 'BAWALIPU', '73_24_6', 'WOTU', 2, 'dusunWOTU'),
(81, 'SDN 127 BUANIPA', '73_24_6_2005', 'BAWALIPU', '73_24_6', 'WOTU', 2, 'dusunWOTU'),
(82, 'SDN 133 BANALARA', '73_24_6_2005', 'BAWALIPU', '73_24_6', 'WOTU', 2, 'dusunWOTU'),
(83, 'SDN 121 LAMPENAI', '73_24_6_2001', 'LAMPENAI', '73_24_6', 'WOTU', 2, 'dusunWOTU'),
(84, 'SDN 122 DAULOLOE', '73_24_6_2001', 'LAMPENAI', '73_24_6', 'WOTU', 2, 'dusunWOTU'),
(85, 'SDN 131 KAMPUNG ALAU', '73_24_6_2001', 'LAMPENAI', '73_24_6', 'WOTU', 2, 'dusunWOTU'),
(86, 'SDN 135 BINANO', '73_24_6_2001', 'LAMPENAI', '73_24_6', 'WOTU', 2, 'dusunWOTU'),
(89, 'SDN 125 MARAMBA', '73_24_6_2015', 'MADANI', '73_24_6', 'WOTU', 2, 'dusunWOTU'),
(90, 'SDN 137 MOLELENGKU', '73_24_6_2003', 'MARAMBA', '73_24_6', 'WOTU', 2, 'dusunWOTU'),
(91, 'SDN 129 MARAMBA', '73_24_6_2008', 'KANAWATU', '73_24_6', 'WOTU', 2, 'dusunWOTU'),
(92, 'SDN 123 TARENGGE', '73_24_6_2002', 'TARENGGE', '73_24_6', 'WOTU', 2, 'dusunWOTU'),
(93, 'SDN 124 RANTE TIKU', '73_24_6_2014', 'TARENGGE TIMUR', '73_24_6', 'WOTU', 2, 'dusunWOTU'),
(95, 'SDN 134 KALAENA', '73_24_6_2006', 'KALAENA', '73_24_6', 'WOTU', 2, 'dusunWOTU'),
(98, 'SDN 130 KARAMBUA', '73_24_6_2013', 'RINJANI', '73_24_6', 'WOTU', 2, 'dusunWOTU'),
(99, 'SDN 138 KARAMBUA', '73_24_6_2010', 'KARAMBUA', '73_24_6', 'WOTU', 2, 'dusunWOTU'),
(100, 'SDN 126 LEMBAH BAHAGIA', '73_24_6_2004', 'CENDANA HIJAU', '73_24_6', 'WOTU', 2, 'dusunWOTU'),
(101, 'MIS DDI CENDANA HIJAU', '73_24_6_2004', 'CENDANA HIJAU', '73_24_6', 'WOTU', 2, 'dusunWOTU'),
(102, 'SDN 128 PEPURO', '73_24_6_2007', 'LERA', '73_24_6', 'WOTU', 2, 'dusunWOTU'),
(103, 'SDN 136 CENDANA HIJAU', '73_24_6_2007', 'LERA', '73_24_6', 'WOTU', 2, 'dusunWOTU'),
(104, 'SDN 131 LAMBU-LAMBU', '73_24_6_2012', 'BALOBALO', '73_24_6', 'WOTU', 2, 'dusunWOTU'),
(106, 'SDN 139 BUANA INDAH', '73_24_6_2009', 'BAHARI', '73_24_6', 'WOTU', 2, 'dusunWOTU'),
(107, 'SDN 140 TAREBBI INDAH', '73_24_6_2016', 'TABAROGE', '73_24_6', 'WOTU', 2, 'dusunWOTU'),
(108, 'SDN 249 MATANO', '73_24_2_2005', 'MATANO', '73_24_2', 'NUHA', 13, 'dusunNUHA'),
(109, 'SDN 255 BONE PUTE', '73_24_2_2005', 'MATANO', '73_24_2', 'NUHA', 13, 'dusunNUHA'),
(110, 'MI.NURUT TAQWA', '73_24_2_2003', 'NIKKEL', '73_24_2', 'NUHA', 13, 'dusunNUHA'),
(111, 'SDIT BUDI UTOMO', '73_24_2_1007', 'MAGANI', '73_24_2', 'NUHA', 13, 'dusunNUHA'),
(112, 'SDIT ULINNUHA', '73_24_2_2009', 'SOROWAKO', '73_24_2', 'NUHA', 13, 'dusunNUHA'),
(113, 'SDIT QURANI WAHDA ISLAMIYAH', '73_24_2_1007', 'MAGANI', '73_24_2', 'NUHA', 13, 'dusunNUHA'),
(114, 'SD YPS LAWEWU', '73_24_2_1007', 'MAGANI', '73_24_2', 'NUHA', 13, 'dusunNUHA'),
(115, 'SD YPS SINGKOLE', '73_24_2_1007', 'MAGANI', '73_24_2', 'NUHA', 13, 'dusunNUHA'),
(116, 'SD 221 Malili', '73_24_4_1003', 'MALILI', '73_24_4', 'MALILI', 8, 'dusunMALILI'),
(117, 'SD 222 Batu Merah', '73_24_4_1003', 'MALILI', '73_24_4', 'MALILI', 8, 'dusunMALILI'),
(118, 'SD Lagaroang', '73_24_4_2006', 'BARUGA', '73_24_4', 'MALILI', 8, 'dusunMALILI'),
(119, 'SD 223 Balantang', '73_24_4_2010', 'BALANTANG', '73_24_4', 'MALILI', 8, 'dusunMALILI'),
(120, 'SD 226 Patande', '73_24_4_2005', 'WEWANG RIU', '73_24_4', 'MALILI', 8, 'dusunMALILI'),
(121, 'SD 229 Waru', '73_24_4_1003', 'MALILI', '73_24_4', 'MALILI', 8, 'dusunMALILI'),
(122, 'SD 228 Mallaulu', '73_24_4_2013', 'PUNCAK INDAH', '73_24_4', 'MALILI', 8, 'dusunMALILI'),
(123, 'SD 233 Ussu', '73_24_4_2008', 'USSU', '73_24_4', 'MALILI', 8, 'dusunMALILI'),
(124, 'SD 234 Kore-Korea', '73_24_4_2005', 'WEWANG RIU', '73_24_4', 'MALILI', 8, 'dusunMALILI'),
(125, 'SD 237 Atue', '73_24_4_2011', 'ATUE', '73_24_4', 'MALILI', 8, 'dusunMALILI'),
(126, 'SD Insan Rabbani', '73_24_4_2013', 'PUNCAK INDAH', '73_24_4', 'MALILI', 8, 'dusunMALILI'),
(127, 'SD Al Muhajirin', '73_24_4_2013', 'PUNCAK INDAH', '73_24_4', 'MALILI', 8, 'dusunMALILI'),
(128, 'MI Nurul Iman', '73_24_10_2007', 'MEKAR SARI', '73_24_10', 'KALAENA', 6, 'dusunKALAENA'),
(129, 'SDN 153 Taripa', '73_24_10_2004', 'NON BLOK', '73_24_10', 'KALAENA', 6, 'dusunKALAENA'),
(130, 'SDN 162 Limbomampongo', '73_24_10_2006', 'SUMBER MAKMUR', '73_24_10', 'KALAENA', 6, 'dusunKALAENA'),
(131, 'MI Miftahul Ulum', '73_24_10_2006', 'SUMBER MAKMUR', '73_24_10', 'KALAENA', 6, 'dusunKALAENA'),
(132, 'SDN 155 Karya Mukti', '73_24_10_2005', 'ARGOMULYO', '73_24_10', 'KALAENA', 6, 'dusunKALAENA'),
(133, 'SDN 258 Sinongko', '73_24_11_2004', 'WASUPONDA', '73_24_11', 'WASUPONDA', 11, 'WASUPONDA'),
(134, 'SDN 251 Pae-Pae', '73_24_11_2001', 'LEDU LEDU', '73_24_11', 'WASUPONDA', 11, 'WASUPONDA'),
(135, 'SDN 253 Amasi', '73_24_11_2006', 'BALAMBANO', '73_24_11', 'WASUPONDA', 11, 'WASUPONDA'),
(136, 'SDN 253 Amasi Kls Jauh', '73_24_11_2006', 'BALAMBANO', '73_24_11', 'WASUPONDA', 11, 'WASUPONDA'),
(137, 'SDN 259 Balambano', '73_24_11_2006', 'BALAMBANO', '73_24_11', 'WASUPONDA', 11, 'WASUPONDA'),
(138, 'SDN 246 Tabarano', '73_24_11_2003', 'TABARANO', '73_24_11', 'WASUPONDA', 11, 'WASUPONDA'),
(139, 'SDN 246 Tabarano Kls Jauh', '73_24_11_2003', 'TABARANO', '73_24_11', 'WASUPONDA', 11, 'WASUPONDA'),
(140, 'SDN 278 Mahalona', '73_24_3_2015', 'TOLE', '73_24_3', 'TOWUTI', 17, 'dusunMAHALONA'),
(141, 'SDN 281 SP2 Mahalona', '73_24_3_2017', 'KALOSI', '73_24_3', 'TOWUTI', 17, 'dusunMAHALONA'),
(142, 'SDN 284 SP3 Mahalona', '73_24_3_2018', 'BUANGIN', '73_24_3', 'TOWUTI', 17, 'dusunMAHALONA'),
(143, 'SDN 284 Sp4 Mahalona', '73_24_3_2002', 'MAHALONA', '73_24_3', 'TOWUTI', 17, 'dusunMAHALONA'),
(144, 'SDN 273 MASIKU', '73_24_3_2012', 'MASIKU', '73_24_3', 'TOWUTI', 16, 'dusunBANTILANG'),
(145, 'SDN 276 TOKALIMBO', '73_24_3_2006', 'TOKALIMBO', '73_24_3', 'TOWUTI', 16, 'dusunBANTILANG'),
(146, 'SDN 279 RANTEANGIN', '73_24_3_2013', 'RANTE ANGIN', '73_24_3', 'TOWUTI', 16, 'dusunBANTILANG'),
(147, 'SDN 269 LAMBATU', '73_24_3_2001', 'LOEHA', '73_24_3', 'TOWUTI', 16, 'dusunBANTILANG');

-- --------------------------------------------------------

--
-- Table structure for table `master_syarat`
--

CREATE TABLE `master_syarat` (
  `id` int(11) NOT NULL,
  `syarat` text DEFAULT NULL,
  `id_permohonan` int(11) DEFAULT 0,
  `kode_file` varchar(255) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `peringatan` int(11) DEFAULT NULL,
  `download` varchar(255) DEFAULT NULL,
  `penjelasan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `master_syarat`
--

INSERT INTO `master_syarat` (`id`, `syarat`, `id_permohonan`, `kode_file`, `label`, `peringatan`, `download`, `penjelasan`) VALUES
(1, 'Kartu Keluarga atau surat kehilangan dari kepolisian', 2, 'kk', 'Kartu Keluarga', 1, '', 'Digunakan sebagai data dasar keluarga. Jika KK hilang, wajib melampirkan surat kehilangan dari kepolisian.'),
(2, 'Surat Keterangan Kematian dari Rumah Sakit / Desa / RT-RW', 2, 'mati', 'Surat Keterangan Kematian', 1, NULL, 'Bukti resmi kematian dari fasilitas medis atau lembaga pemerintahan (desa/RT-RW) untuk mencatatkan kematian secara sah.'),
(3, 'KTP elektronik pelapor', 2, 'ktppelapor', 'KTP-el Pelapor', 1, NULL, 'KTP orang yang melaporkan kejadian kematian (biasanya anggota keluarga terdekat).'),
(4, 'KTP elektronik dua orang saksi', 2, 'ktpsaksi', 'KTP-el 2 Saksi', 1, NULL, 'Diperlukan untuk pengesahan laporan kematian, menunjukkan bahwa peristiwa tersebut disaksikan oleh pihak lain.'),
(5, 'Formulir F-1.01 Draf Kartu Keluarga', 2, 'f101', 'Formulir F-1.01', 1, '71b5ee2f547ecebe522823155ad0a79b.pdf', 'Formulir biodata keluarga untuk memperbarui susunan anggota KK setelah penghapusan anggota yang telah meninggal.'),
(6, 'Formulir F-2.01 Pelaporan Pencatatan Sipil', 2, 'f201', 'Formulir F-2.01', 1, '8c62eb87c268c216bed09f7491b07f12.pdf', 'Formulir yang digunakan untuk melaporkan kejadian kematian ke dinas pencatatan sipil.'),
(10, 'Kartu Keluarga atau surat kehilangan dari Kepolisian', 1, 'kk', 'Kartu Keluarga', 1, NULL, 'Bukti keanggotaan keluarga yang akan diperbarui. Jika hilang, wajib lampirkan surat kehilangan.'),
(11, 'Asli Surat Keterangan Kelahiran dari Rumah Sakit/Puskesmas/Klinik Bersalin', 1, 'skl', 'Surat Keterangan Kelahiran', 1, NULL, 'Dokumen resmi dari fasilitas kesehatan sebagai bukti kelahiran bayi.'),
(12, 'KTP Elektronik pelapor', 1, 'ktppelapor', 'KTP-el Pelapor', 1, NULL, 'Identitas orang tua atau wali yang melaporkan kelahiran.'),
(13, 'KTP Elektronik dari 2 (dua) orang saksi', 1, 'ktpsaksi', 'KTP-el 2 Saksi', 1, NULL, 'Dua orang saksi diperlukan dalam proses pelaporan kelahiran sebagai bentuk legalitas tambahan.'),
(14, 'Asli Buku Nikah / Akta Perkawinan / Akta Cerai', 1, 'bukunikah', 'Buku Nikah', 1, NULL, 'Dibutuhkan untuk membuktikan status perkawinan orang tua bayi.'),
(15, 'Formulir F-1.01: Draf Kartu Keluarga', 1, 'f101', 'Formulir F-1.01', 1, 'a60e542e35e4ab2c3f1ad8003c605e0d.pdf', 'Formulir standar biodata seluruh anggota keluarga yang akan disertakan dalam KK.'),
(16, 'Formulir F-1.06: Perubahan Elemen Data (bagi yang mengalami perubahan data)', 1, 'f106', 'Formulir F-1.06', 0, 'f106.pdf', 'Diisi jika terdapat perubahan data dalam KK (misalnya nama atau alamat).'),
(17, 'Formulir F-1.03: Pernyataan Perubahan Data (bagi yang pindah)', 1, 'f103', 'Formulir F-1.03', 0, 'f103.pdf', 'Diperlukan jika perubahan data disebabkan oleh perpindahan tempat tinggal.'),
(18, 'Formulir F-2.01 Pelaporan Pencatatan Sipil', 1, 'f201', 'Formulir F-2.01', 1, '7fcfaf617a72ba7d75eac577b43087a0.pdf', 'Formulir khusus untuk pelaporan kelahiran dalam pencatatan sipil.'),
(19, 'Kartu Keluarga atau surat kehilangan dari kepolisian', 3, 'kkkhilang', 'Kartu Keluarga / Surat Kehilangan', 1, NULL, 'Digunakan sebagai dasar pengajuan. Bila hilang, wajib menyertakan surat kehilangan.'),
(20, 'KTP elektronik atau surat kehilangan dari kepolisian', 3, 'ktpkhilang', 'KTP / Surat Kehilangan', 1, NULL, 'Identitas pemohon. Jika hilang, wajib ada surat kehilangan.'),
(21, 'Surat keterangan pindah WNI', 3, 'suratpindahwni', 'Surat Pindah WNI', 0, NULL, 'Wajib jika pindah domisili antar RT/RW/Kelurahan/Kecamatan/Kota.'),
(22, 'Formulir pindah (F-1.03)', 3, 'formulirpindahf103', 'Formulir Pindah (F-1.03)', 0, 'f103.pdf', 'Formulir permohonan pindah bagi pemohon dan anggota keluarganya.'),
(23, 'Formulir biodata penduduk WNI F-1.01', 3, 'biodataf101', 'Formulir Biodata F-1.01', 1, '5012f4280b79d3827edea0af0eb58eb5.pdf', 'Formulir resmi berisi data individu pemohon.'),
(24, 'Surat pernyataan perubahan biodata (F-1.06)', 3, 'suratpernyataanf106', 'Surat Perubahan Biodata (F-1.06)', 0, 'f106.pdf', 'Jika terdapat perubahan dalam data pribadi (nama, pekerjaan, pendidikan, dll).'),
(25, 'Buku nikah/Akta cerai', 3, 'bukunikahcerai', 'Buku Nikah / Akta Cerai', 0, NULL, 'Untuk menunjukkan status pernikahan (menikah atau bercerai).'),
(26, 'Surat pernyataan bila alamat dipakai oleh pendatang', 3, 'suratalamatpendatang', 'Surat Alamat Pendatang', 0, NULL, 'Jika tinggal di alamat milik orang lain.'),
(27, 'Surat pernyataan bila pendatang menggunakan alamat rumah sendiri', 3, 'suratpendatangalamatrumah', 'Surat Pendatang Rumah Sendiri', 0, NULL, 'Jika tinggal di rumah milik sendiri.'),
(28, 'Surat pernyataan bila pendatang tidak keberatan numpang KK', 3, 'suratpendatangnumpangkk', 'Surat Pendatang Numpang KK', 0, NULL, 'Jika akan menumpang KK milik orang lain dan harus ada persetujuan dari pemilik KK.'),
(29, 'Kartu Keluarga atau surat kehilangan dari kepolisian', 4, 'kartukeluarga', 'Kartu Keluarga', 1, NULL, 'Digunakan sebagai dokumen utama untuk menunjukkan data keluarga yang akan diperbarui. Jika KK hilang, surat kehilangan dari kepolisian menjadi pengganti resmi.'),
(30, 'Akta Lahir atau Surat Lahir dari Desa/Kelurahan untuk menambah anggota baru', 4, 'aktalahir', 'Akta Lahir / Surat Lahir', 0, NULL, 'Dibutuhkan untuk menambahkan anggota keluarga baru, seperti bayi yang baru lahir, ke dalam KK.'),
(31, 'Ijazah terakhir sebagai pendukung identitas atau perubahan data', 4, 'ijazah', 'Ijazah Terakhir', 0, NULL, 'Digunakan sebagai bukti tambahan jika terjadi perubahan data seperti nama atau tempat/tanggal lahir yang perlu disesuaikan dengan dokumen resmi lainnya.'),
(32, 'Buku Nikah, Akta Kawin, atau Akta Cerai sebagai bukti status pernikahan', 4, 'bukunikah', 'Buku Nikah / Akta Kawin / Cerai', 0, NULL, 'Dibutuhkan untuk memperbarui status perkawinan anggota keluarga, baik karena pernikahan maupun perceraian.'),
(33, 'Akta Kematian atau Surat Kematian dari Desa/Kelurahan untuk mencatat kematian anggota keluarga', 4, 'aktakematian', 'Akta / Surat Kematian', 0, NULL, 'Diperlukan untuk menghapus anggota keluarga yang telah meninggal dari Kartu Keluarga.'),
(34, 'Formulir Perubahan Data (F-1.06)', 4, 'formf106', 'Formulir F-1.06', 1, 'f106.pdf', 'Formulir resmi yang digunakan untuk mengajukan perubahan elemen data dalam dokumen kependudukan.'),
(35, 'Formulir Biodata WNI (F-1.01)', 4, 'formf101', 'Formulir F-1.01', 1, '6a0cbafd48f9315e64a4360b0bd57ab7.pdf', 'Digunakan untuk mencatat biodata lengkap warga negara Indonesia, terutama jika ada anggota baru atau perubahan detail pribadi.'),
(36, 'Akta kelahiran', 5, 'aktakelahiran', 'Akta', 1, NULL, 'Dokumen resmi yang membuktikan kelahiran anak. Ini menjadi dasar utama penerbitan KIA karena berisi informasi identitas anak seperti nama lengkap, tanggal lahir, dan nama orang tua.'),
(37, 'Kartu Keluarga (KK)', 5, 'kartukeluarga', 'KK', 1, NULL, 'Digunakan untuk memverifikasi bahwa anak terdaftar sebagai anggota keluarga dalam sistem kependudukan. KK juga memuat data orang tua atau wali yang sah.'),
(38, 'Pas Foto 3x4 berwarna (untuk anak usia > 5 tahun)', 5, 'pasfoto3x4', 'Pas Foto', 0, NULL, 'Foto diperlukan untuk mencetak KIA dengan tampilan visual yang sesuai, namun hanya diwajibkan bagi anak yang berusia lebih dari 5 tahun. Untuk anak usia 0–5 tahun, KIA biasanya dicetak tanpa foto.'),
(39, 'Kartu Keluarga / surat kehilangan dari kepolisian', 6, 'kk', 'Kartu Keluarga / Surat Kehilangan', 1, NULL, 'KK menunjukkan data keluarga secara lengkap. Jika hilang, harus diganti dengan surat kehilangan resmi dari kepolisian.'),
(40, 'KTP-el', 6, 'ktp', 'KTP-el', 1, NULL, 'Kartu Tanda Penduduk Elektronik dibutuhkan sebagai bukti identitas dan status kependudukan pemohon.'),
(41, 'Surat Keterangan Tempat Tinggal orang asing', 6, 'sktt', 'SKTT Orang Asing', 0, NULL, 'Wajib bagi WNA sebagai bukti alamat tinggal selama berada di Indonesia.'),
(42, 'Formulir Permohonan Pindah Penduduk (F-1.03)', 6, 'f103', 'Formulir F-1.03', 1, 'f103.pdf', 'Formulir ini berisi informasi perpindahan yang akan diproses oleh petugas Disdukcapil.'),
(43, 'Formulir Biodata WNI (F-1.01), Jika ada anggota Kartu Keluarga (KK) yang ditinggal', 6, 'f101', 'Formulir  F-1.01', 1, '0bad9562efa9d5c7f05457fe1a6e43c6.pdf', 'Digunakan jika ada anggota keluarga yang tidak ikut pindah, untuk mencatat ulang data yang ditinggal.'),
(44, 'Formulir Perubahan Data (F-1.06)', 6, 'f106', 'Formulir  F-1.06', 0, 'f106.pdf', 'Dibutuhkan jika ada perubahan data yang terjadi bersamaan dengan proses perpindahan.'),
(45, 'Surat Pernyataan Persetujuan dari Pemilik Alamat (jika menumpang alamat)', 6, 'pernyataan_alamat_dipakai', 'Pernyataan Alamat Dipakai', 0, NULL, 'Jika alamat tujuan adalah milik orang lain, surat ini dibutuhkan sebagai persetujuan pemilik untuk ditumpangi.'),
(46, 'Surat Pernyataan Pemakaian Alamat oleh Pendatang (jika menggunakan rumah pribadi)', 6, 'pernyataan_rumah_sendiri', 'Pernyataan Rumah Sendiri', 0, NULL, 'Diperlukan jika alamat tujuan adalah milik pribadi pemohon sebagai pernyataan penggunaan tempat tinggal baru.'),
(47, 'Surat Pernyataan Tidak Keberatan dari Pemilik KK (jika pendatang menumpang KK)', 6, 'pernyataan_numpang_kk', 'Pernyataan Numpang KK', 0, NULL, 'Jika pemohon akan menumpang pada KK yang sudah ada, surat ini dibutuhkan untuk menyatakan persetujuan pemilik KK.'),
(48, 'Surat Pindah Asli', 7, 'f0107', 'Surat Pindah', 1, NULL, 'Dokumen resmi dari daerah asal yang menyatakan bahwa penduduk telah pindah. Diperlukan untuk proses mutasi ke daerah tujuan'),
(49, 'Formulir Pindah (F-1.03)', 7, 'f0207', 'Formulir F-1.03', 1, 'f103.pdf', 'Formulir ini digunakan untuk mencatat dan memproses perpindahan penduduk antar daerah.'),
(50, 'Formulir F-1.01', 7, 'f0307', 'Formulir  F-1.01', 1, '1dcbeec939e4b88a13dc30aac029ae1c.pdf', 'Berisi biodata lengkap penduduk yang pindah, termasuk informasi keluarga dan identitas diri.'),
(51, 'Kartu Keluarga (jika bergabung dalam KK tujuan)', 7, 'f0407', 'Kartu Keluarga Tujuan', 0, NULL, 'KK dari keluarga tujuan dibutuhkan jika penduduk yang datang akan bergabung dalam KK yang sudah ada.'),
(52, 'Formulir Pernyataan F-1.06 (bila terdapat perubahan data)', 7, 'f0507', 'Formulir F-1.06', 0, 'f106.pdf', 'Diisi jika terdapat perubahan data penduduk, seperti nama, tempat tanggal lahir, pendidikan, pekerjaan, dll.'),
(53, 'Akta Kelahiran atau Surat Keterangan Lahir dari Desa/Kelurahan', 7, 'f0607', 'Akta Lahir', 0, NULL, 'Diperlukan untuk mencocokkan data kelahiran penduduk, terutama bila membawa anak.'),
(54, 'Ijazah Terakhir', 7, 'f0707', 'Ijazah', 0, NULL, 'Sebagai bukti pendidikan terakhir dan mendukung keakuratan data pekerjaan atau pendidikan.'),
(55, 'Surat Nikah, Akta Perkawinan, atau Akta Cerai', 7, 'f0807', 'Surat Nikah/Cerai', 0, NULL, 'Digunakan untuk membuktikan status perkawinan yang bersangkutan.'),
(56, 'Surat Pernyataan Persetujuan dari Pemilik Alamat (jika menumpang alamat)', 7, 'f0907', 'Persetujuan Alamat', 0, NULL, 'Jika penduduk yang pindah akan tinggal di rumah milik orang lain, surat ini dibutuhkan sebagai bukti izin dari pemilik rumah.'),
(57, 'Surat Pernyataan Pemakaian Alamat oleh Pendatang (jika menggunakan rumah pribadi)', 7, 'f1007', 'Pemakaian Alamat', 0, NULL, 'Diperlukan bila pendatang menggunakan rumah pribadi tetapi belum terdaftar atas namanya secara administratif.'),
(58, 'Surat Pernyataan Tidak Keberatan dari Pemilik KK (jika pendatang menumpang KK)', 7, 'f1107', 'Tidak Keberatan', 0, NULL, 'Jika pendatang ikut dalam KK orang lain, surat ini diperlukan sebagai bentuk persetujuan dari kepala keluarga tersebut.'),
(59, 'Surat pengantar dari sponsor (Perusahaan/WNI yang bertanggung jawab)', 8, 'suratpengantarsponsor', 'Surat Pengantar Sponsor', 0, NULL, 'Surat ini berasal dari pihak yang menjamin keberadaan dan tanggung jawab terhadap WNA tersebut, bisa dari perusahaan tempat bekerja atau pasangan WNI jika dalam pernikahan campuran.'),
(60, 'Formulir Biodata Warga Negara Asing (WNA)', 8, 'formulirbiodatawna', 'Formulir Biodata WNA', 1, 'c025c07054fb77a05b0c1d0a820153c6.pdf', 'Formulir berisi identitas pribadi WNA, termasuk nama, kewarganegaraan, alamat domisili di Indonesia, dan status tinggal. Diisi dan ditandatangani sebagai data dasar pencatatan kependudukan.'),
(61, 'Formulir pindah (F1.03)', 8, 'formulirpindahf103', 'Formulir F-1.03', 0, 'f103.pdf', 'Diperlukan jika WNA tersebut sebelumnya sudah terdaftar di wilayah lain dan kini pindah ke domisili baru. Menyatakan mutasi tempat tinggal antar wilayah di Indonesia.'),
(62, 'Paspor yang masih berlaku', 8, 'paspor', 'Paspor', 1, NULL, 'Dokumen perjalanan resmi dari negara asal yang mencantumkan identitas dan kewarganegaraan WNA. Wajib dalam kondisi masih aktif.'),
(63, 'KITAS atau KITAP dari Imigrasi', 8, 'kitasataukitap', 'KITAS/KITAP', 1, NULL, 'KITAS (izin tinggal terbatas) atau KITAP (izin tinggal tetap) adalah dokumen utama dari Imigrasi yang mengatur lama dan status tinggal WNA di Indonesia.'),
(64, 'Surat Nikah/Akta Kawin dan Surat Keterangan Perkawinan Campuran dari Dukcapil (jika menikah dengan WNI)', 8, 'perkawinancampuran', 'Nikah Campuran', 0, NULL, 'Jika WNA menikah dengan WNI, dokumen ini dibutuhkan untuk mencatat status pernikahan campuran. Harus diterbitkan atau diakui oleh Dinas Dukcapil setempat.'),
(65, 'Kartu Keluarga (jika bergabung), hanya WNA pemegang KITAP yang dapat masuk KK dan mendapatkan KTP-El', 8, 'kartukeluargawnakitap', 'KK WNA', 0, NULL, 'Khusus untuk pemegang KITAP, WNA bisa bergabung dalam KK milik pasangan WNI atau keluarganya. Hanya pemegang KITAP yang bisa masuk KK dan memiliki NIK serta berhak mendapatkan KTP-el.'),
(66, 'SKTL (Surat Keterangan Tanda Lapor) dari Kesbangpol', 8, 'sktlkesbangpol', 'SKTL', 1, NULL, 'Surat ini membuktikan bahwa WNA sudah melapor ke Badan Kesatuan Bangsa dan Politik (Kesbangpol). Biasanya sebagai bagian dari pengawasan keberadaan WNA oleh pemerintah daerah.'),
(67, 'Buku Nikah/Akta Kawin/Akta Cerai / SPTJM perkawinan', 9, 'bukunikahsptjm', 'Buku Nikah / SPTJM', 1, NULL, '<strong>Buku Nikah/Akta Kawin</strong>: Diperlukan apabila salah satu orang tua pelapor sudah menikah dan ingin menunjukkan bukti perkawinan yang sah.<br>\r\n<strong>Akta Cerai</strong>: Digunakan jika salah satu orang tua pelapor sudah bercerai, sehingga perlu menunjukkan status perkawinan yang telah berakhir.<br>\r\n<strong>SPTJM (Surat Pernyataan Tanggung Jawab Mutlak)</strong>: Digunakan jika dokumen resmi perkawinan atau perceraian tidak tersedia, dan pelapor membuat pernyataan tertulis yang bertanggung jawab atas kebenaran informasi tersebut.'),
(68, 'Asli Surat Lahir dari Bidan/Klinik Bersalin/RS/SPTJM Lahir', 9, 'suratlahirsptjm', 'Surat Lahir / SPTJM', 1, NULL, 'Surat Lahir Asli yang dikeluarkan oleh Bidan, Klinik Bersalin, Rumah Sakit (RS), atau instansi yang memberikan layanan kelahiran. Jika surat lahir asli tidak ada, maka SPTJM Lahir (Surat Pernyataan Tanggung Jawab Mutlak) dapat digunakan sebagai pengganti, yang menyatakan kebenaran atas kelahiran tersebut berdasarkan informasi pelapor.'),
(69, 'KTP-el  pelapor', 9, 'ktppelapor', 'KTP Pelapor', 1, NULL, 'KTP Elektronik Pelapor diperlukan untuk memverifikasi identitas pelapor yang mengajukan permohonan pembuatan akta kelahiran orang dewasa. KTP ini berfungsi sebagai bukti sah identitas diri.'),
(70, 'KTP-el 2 (dua) Orang Saksi', 9, 'ktpsaksi', 'KTP Saksi', 1, NULL, 'KTP Elektronik dari dua orang saksi yang mengetahui atau hadir saat kelahiran orang dewasa tersebut. Mereka akan memberi keterangan sebagai saksi bahwa pelapor memang benar-benar ada dan sesuai dengan peristiwa kelahiran yang dilaporkan.'),
(71, 'Kartu Keluarga / surat kehilangan dari kepolisian', 9, 'kkkehilangan', 'KK / Surat Kehilangan', 1, NULL, 'Kartu Keluarga (KK) digunakan untuk memverifikasi bahwa orang yang bersangkutan memang terdaftar dalam keluarga yang bersangkutan. Surat Kehilangan dari Kepolisian dibutuhkan jika dokumen KK hilang, yang menggantikan KK untuk memastikan status pelapor dalam keluarga.'),
(72, 'Formulir F-2.01 Pelaporan Pencatatan Sipil', 9, 'formulirf201', 'Formulir F-2.01', 1, '79d9ecf4acab4b8abc987b915c0a5255.pdf', 'Formulir resmi yang digunakan untuk pelaporan pencatatan sipil kelahiran orang dewasa. Formulir ini berisi data diri pelapor dan informasi terkait kelahiran yang dilaporkan.'),
(73, 'Surat Kematian dari dokter / RS / Surat Kematian dari Desa / Kelurahan / laporan kematian dari RT/RW mengetahui kepala desa', 10, 'suratkematiandokterrsdesakelurahanrtrw', 'Surat Kematian', 1, NULL, 'Surat Kematian menjadi syarat utama, yang bisa dikeluarkan oleh dokter, rumah sakit (RS), desa/kelurahan, atau laporan kematian dari RT/RW yang diketahui oleh Kepala Desa. Dokumen ini adalah bukti sah bahwa seseorang telah meninggal dunia dan menjadi dasar untuk pembuatan Akta Kematian'),
(74, 'KTP-el Pelepor', 10, 'ktppelapor', 'KTP Pelapor', 1, NULL, 'Diperlukan untuk mengidentifikasi siapa yang melaporkan kematian tersebut. Pelapor harus memiliki KTP-el yang sah'),
(75, 'KTP-el 2 (dua) orang Saksi', 10, 'ktpsaksi', 'KTP Saksi', 1, NULL, 'Kedua saksi ini harus memberikan keterangan dan membuktikan bahwa mereka benar-benar mengetahui peristiwa kematian tersebut. KTP saksi ini digunakan sebagai bukti tambahan untuk validitas laporan'),
(76, 'Kartu Keluarga / surat kehilangan dari kepolisian', 10, 'kkkehilangan', 'KK / Kehilangan', 1, NULL, 'Kartu Keluarga menjadi bukti bahwa orang yang meninggal memang terdaftar dalam Kartu Keluarga pelapor. Jika Kartu Keluarga hilang, surat kehilangan dari kepolisian dapat digunakan sebagai pengganti.'),
(77, 'Formulir F-2.01 Pelaporan Pencatatan Sipil', 10, 'formulirf201', 'Formulir F-2.01', 1, '88c4686846f5134ad1ed20c69a5089f4.pdf', 'Wajib diisi dan diserahkan oleh pelapor. Formulir ini berisi data tentang kematian dan identitas orang yang meninggal'),
(78, 'SPTJM Kebenaran Data Kematian', 10, 'sptjmkematian', 'SPTJM', 1, NULL, 'SPTJM (Surat Pernyataan Tanggung Jawab Mutlak) Kebenaran Data Kematian adalah pernyataan tertulis yang menyatakan bahwa data kematian yang diberikan adalah benar adanya. Surat ini ditandatangani oleh pelapor dan saksi'),
(79, 'Kartu Keluarga atau surat kehilangan dari kepolisian', 11, 'kkkehilangan', 'KK / Kehilangan', 1, NULL, 'Untuk memverifikasi keberadaan dan identitas keluarga pemohon. Jika Kartu Keluarga hilang, diperlukan surat kehilangan resmi dari kepolisian.'),
(80, 'KTP-el pelapor', 11, 'ktppelapor', 'KTP Pelapor', 1, NULL, 'Merupakan identitas resmi dari orang yang mengajukan permohonan, digunakan untuk memastikan kewenangan pelapor atas perubahan data atau permintaan duplikat'),
(81, 'KTP-el dua orang saksi', 11, 'ktpsaksi', 'KTP Saksi', 1, NULL, 'Diperlukan sebagai pendukung legalitas dan kebenaran informasi dalam permohonan'),
(82, 'Surat nikah atau akta perkawinan orang tua', 11, 'suratnikahortu', 'Surat Nikah Orang Tua', 1, NULL, 'Dibutuhkan untuk memastikan keabsahan hubungan orang tua dengan anak dalam akta kelahiran yang akan diralat atau diduplikasi'),
(83, 'Akta kelahiran asli yang akan diralat atau diduplikat', 11, 'aktalahirasaliralat', 'Akta Lahir Asli', 0, NULL, 'Dibutuhkan untuk melihat data yang tercantum sebelumnya dan menjadi dasar proses ralat atau penerbitan ulang'),
(84, 'Surat kehilangan dari kepolisian untuk akta yang hilang (khusus bagi akta yang belum berbarcode)', 11, 'kehilanganaktatidakbarcode', 'Surat Kehilangan Akta', 0, NULL, 'Surat ini wajib jika akta kelahiran yang hilang belum memiliki barcode, sebagai bukti bahwa dokumen benar-benar hilang dan bukan disalahgunakan.'),
(85, 'Formulir permohonan ralat atau duplikat akta kelahiran', 11, 'formralatakta', 'Form Ralat Akta', 1, NULL, 'Merupakan dokumen resmi yang diisi oleh pemohon, berisi data yang dimohonkan untuk diperbaiki atau permintaan pencetakan ulang akta'),
(86, 'Fotokopi KTP-el pelapor', 12, 'ktpelpelapor', 'KTP Pelapor', 1, NULL, 'Identitas resmi orang yang mengajukan permohonan. Pelapor harus memiliki hubungan keluarga atau wewenang hukum untuk mengurus dokumen kematian'),
(87, 'Surat kehilangan dari kepolisian untuk akta yang belum memiliki barcode', 12, 'suratkehilanganpolisi', 'Surat Kehilangan', 0, NULL, 'Jika akta kematian yang akan diduplikasi belum memiliki sistem pengamanan seperti barcode dan dinyatakan hilang, maka surat kehilangan dari kepolisian menjadi syarat wajib sebagai bukti hilangnya dokumen tersebut'),
(88, 'Fotokopi KTP-el dua orang saksi', 12, 'ktpelsaksi', 'KTP Saksi', 1, NULL, 'Digunakan untuk menguatkan pernyataan pelapor dan memastikan bahwa permohonan ralat atau duplikat dilakukan secara sah dan benar. Para saksi akan menyatakan kebenaran informasi dalam permohonan'),
(89, 'Formulir permohonan duplikat akta kematian.', 12, 'formduplikataktakematian', 'Form Duplikat', 1, NULL, 'Dokumen resmi yang diisi oleh pemohon. Formulir ini memuat data yang ingin diralat atau menjadi dasar penerbitan ulang akta kematian yang hilang atau rusak'),
(90, 'Fotokopi surat nikah atau surat pemberkatan (dilegalisir, untuk pencatatan terlambat)', 13, 'suratnikahlegalisir', 'Surat Nikah', 0, NULL, 'Diperlukan bila pencatatan dilakukan secara terlambat (lebih dari 60 hari setelah pernikahan agama), untuk membuktikan bahwa perkawinan telah sah secara agama'),
(91, 'Kartu Keluarga calon pengantin', 13, 'kkcalonpengantin', 'KK Catin', 1, NULL, 'Digunakan sebagai dasar identitas keluarga dan mencocokkan data kependudukan masing-masing calon'),
(92, 'Akta kelahiran calon pengantin', 13, 'aktalahircalonpengantin', 'Akta Lahir Catin', 1, NULL, 'Membuktikan tempat dan tanggal lahir yang sah dari masing-masing calon pengantin'),
(93, 'KTP-el calon pengantin', 13, 'ktpcalonpengantin', 'KTP Catin', 1, NULL, 'Identitas resmi dan validasi data di sistem kependudukan'),
(94, 'KTP-el saksi', 13, 'ktpsaksi', 'KTP Saksi', 1, NULL, 'Diperlukan untuk mencatat identitas dua orang saksi yang menyaksikan pernikahan, sesuai aturan pencatatan sipil'),
(95, 'Pas foto berdampingan ukuran 4x6 cm, warna, sebanyak 3 lembar', 13, 'pasfotobersama', 'Foto Catin', 1, NULL, 'Digunakan untuk keperluan administrasi pencatatan dan penerbitan dokumen'),
(96, 'Surat baptis / sudi vadhani / sidhi', 13, 'suratbaptissidhi', 'Baptis/Sidhi', 1, NULL, 'Merupakan bukti bahwa calon pengantin telah menjalani tahapan keagamaan yang diwajibkan oleh agamanya masing-masing'),
(97, 'Asli akta cerai atau surat kematian (bagi duda/janda)', 13, 'aktaceraiataukematian', 'Cerai/Kematian', 0, NULL, 'Dibutuhkan bagi calon pengantin yang sebelumnya pernah menikah, sebagai bukti bahwa status sebelumnya sudah berakhir secara hukum'),
(98, 'Surat izin dari kesatuan (bagi TNI/POLRI)', 13, 'suratizinkesatuan', 'Izin Kesatuan', 0, NULL, 'Persyaratan khusus bagi anggota TNI atau POLRI yang ingin menikah, sesuai aturan institusi mereka'),
(99, 'Formulir F-2.01 Pelaporan Pencatatan Sipil', 13, 'formulirf201', 'F-2.01', 1, '79371890deb07f6faaa7c2ff281b7569.pdf', 'Formulir resmi dari Dukcapil untuk mengajukan pencatatan peristiwa perkawinan'),
(100, 'Surat Pengantar dari Desa', 14, 'suratpengantardesa', 'Surat Pengantar Desa', 1, NULL, 'Digunakan sebagai bukti bahwa pemohon memang berdomisili di wilayah tersebut dan mendapatkan pengesahan administratif dari desa tempat tinggal'),
(101, 'Kartu Keluarga atau Surat Kehilangan dari Kepolisian', 14, 'kartukeluargakehilangan', 'Kartu Keluarga', 1, NULL, 'Diperlukan untuk memastikan data kependudukan pemohon. Jika KK hilang, surat kehilangan menjadi pengganti sementara'),
(102, 'KTP-el', 14, 'ktpel', 'KTP', 1, NULL, 'Identitas resmi pemohon sebagai WNI yang harus dicocokkan dengan data pada dokumen lainnya'),
(103, 'Dokumen Keterangan Perkawinan atau Perceraian dari Negara Asal', 14, 'keteranganperkawinanasing', 'Keterangan Perkawinan', 1, NULL, 'Dokumen utama yang membuktikan bahwa peristiwa perkawinan atau perceraian benar-benar terjadi dan sah secara hukum di negara tempat peristiwa itu berlangsung'),
(104, 'Surat Keterangan Pelaporan Pencatatan Sipil dari Perwakilan RI', 14, 'suratketeranganri', 'Surat Keterangan Pelaporan Pencatatan Sipil', 0, NULL, 'Dikeluarkan oleh Kedutaan Besar/Konsulat RI sebagai tanda bahwa WNI telah melaporkan peristiwa tersebut saat berada di luar negeri. Ini memperkuat validitas peristiwa untuk dicatat di Indonesia'),
(105, 'Bukti Pencatatan Sipil dari Negara Setempat (jika berlaku)', 14, 'buktipencatatansetempat', 'Bukti Pencatatan Sipil ', 0, NULL, 'Dokumen tambahan (seperti akta resmi) dari negara setempat yang menunjukkan bahwa peristiwa telah dicatat dalam sistem kependudukan negara tersebut. Diperlukan untuk memperkuat keabsahan'),
(106, 'Formulir F-2.01 Pelaporan Pencatatan Sipil', 14, 'formulf201', 'F-2.01', 1, 'd1c51e96cf126ada82e121a345bcee0a.pdf', 'Formulir resmi dari Disdukcapil yang wajib diisi untuk proses pelaporan pencatatan peristiwa perkawinan/perceraian'),
(107, 'KTP-el Pelapor atau Kuasa', 15, 'ktppelapor', 'KTP Pelapor', 1, NULL, 'Bukti identitas orang yang mengurus pencatatan perceraian, baik pihak yang bercerai maupun kuasa hukumnya'),
(108, 'Kartu Keluarga atau Surat Kehilangan dari Kepolisian', 15, 'kartukeluargakehilangan', 'Kartu Keluarga', 1, NULL, 'Digunakan untuk mencocokkan data keluarga dan status hubungan dalam dokumen kependudukan'),
(109, 'KTP-el yang Bersangkutan', 15, 'ktpbersangkutan', 'KTP - El', 1, NULL, 'Identitas pribadi kedua pihak yang bercerai'),
(110, 'Akta Perkawinan Asli', 15, 'aktaperkawinan', 'Akta Perkawinan', 1, NULL, 'Bukti bahwa sebelumnya telah terjadi perkawinan yang sah dan tercatat'),
(111, 'Putusan Pengadilan Negeri', 15, 'putusanpengadilan', 'Putusan Pengadilan Negeri', 1, NULL, 'Merupakan salinan resmi keputusan pengadilan mengenai perceraian'),
(112, 'Surat Keterangan dari Panitera Pengadilan Negeri', 15, 'suratpanitera', 'Surat Keterangan Panitera Pengadilan Negeri', 1, NULL, 'Diperlukan sebagai bukti bahwa putusan tersebut telah memiliki kekuatan hukum tetap (inkracht)'),
(113, 'Formulir F-2.01 Pelaporan Pencatatan Sipil', 15, 'formulf201', 'F-2.01', 1, '93d830a3447b2d8f6f5b44a14bdb3ee8.pdf', 'Formulir resmi dari Dukcapil untuk proses pencatatan perubahan status sipil'),
(114, 'Akta Lahir/Surat Lahir dari Desa/Kelurahan', 16, 'aktalahrursuratlahirfromdesakelurahan', 'Akta Lahir', 1, NULL, 'Dokumen ini diperlukan untuk membuktikan bahwa penduduk yang bersangkutan telah lahir dan ada dalam catatan kependudukan, meskipun belum memiliki NIK atau KK. Akta kelahiran ini dapat dikeluarkan oleh pihak desa atau kelurahan sebagai bukti kelahiran resmi.'),
(115, 'Ijazah terakhir', 16, 'ijazahterakhir', 'Ijazah', 0, NULL, 'Ijazah digunakan sebagai dokumen pendukung yang mengonfirmasi identitas dan status pendidikan penduduk. Ijazah ini juga dapat menunjukkan usia dan sejarah pendidikan yang relevan'),
(116, 'Buku Nikah/Akta Kawin/Akta Cerai', 16, 'bukunikahaktakawinaktacerei', 'Buku Nikah', 0, NULL, 'Buku nikah atau akta perkawinan digunakan untuk membuktikan status perkawinan. Sementara akta cerai diperlukan jika ada perubahan status perkawinan yang perlu dicatat dalam dokumen kependudukan'),
(117, 'Akta Kematian/Surat Kematian dari Desa/Kelurahan', 16, 'aktakematianrursuratkematiandaridesakelurahan', 'Akta Kematian', 0, NULL, 'Jika ada anggota keluarga yang sudah meninggal dan perlu dicatat dalam Kartu Keluarga, maka akta kematian atau surat kematian diperlukan sebagai bukti sah untuk mengupdate status kependudukan'),
(118, 'Surat Pernyataan Tidak Memiliki Dokumen Kependudukan', 16, 'suratpernyataantidakmemilikidokumenkependudukan', 'Surat Pernyataan', 1, NULL, 'Surat ini diperlukan jika penduduk yang bersangkutan tidak memiliki dokumen kependudukan lain seperti KK atau KTP-el. Surat ini umumnya disertakan untuk menjelaskan mengapa dokumen tersebut tidak ada, misalnya karena hilang atau belum pernah terdaftar'),
(119, 'Formulir F-1.01', 16, 'formulirf101', 'Formulir F-1.01', 1, '18a3dde10fdb7f066e7bd5b127b19ee3.pdf', 'Formulir ini adalah dokumen yang harus diisi oleh pemohon sebagai bagian dari proses pengajuan permohonan untuk penerbitan KK baru. Formulir ini berisi informasi pribadi dan data terkait status kependudukan'),
(120, 'Surat Kehilangan Kartu Keluarga dari Kepolisian atau Kartu Keluarga Asli yang Rusak', 17, 'kkhilangrusak', 'Surat Kehilangan Kartu Keluarga/ KK Rusak', 1, NULL, 'Jika KK hilang, pelapor harus melampirkan surat kehilangan yang diterbitkan oleh pihak kepolisian sebagai bukti sah kehilangan dokumen negara. Sedangkan jika KK rusak, pelapor cukup melampirkan KK yang rusak (misalnya sobek, pudar, atau tidak terbaca) sebagai bukti permohonan cetak ulang'),
(121, 'KTP-El', 17, 'ktp', 'KTP', 1, '', 'Kartu Tanda Penduduk Elektronik milik salah satu anggota keluarga (biasanya kepala keluarga atau pelapor) diperlukan untuk mencocokkan data dan memastikan bahwa permohonan dilakukan oleh pihak yang berwenang atau memiliki hubungan keluarga'),
(122, 'Surat Permohonan Pencetakan Kartu Keluarga bagi Penghayat Kepercayaan kepada Tuhan YME', 18, 'suratpermohonan', 'Surat Permohonan', 1, 'd7d0af3873bd89a1580a9a71480b1a14.pdf', 'Dokumen ini merupakan surat resmi dari pemohon yang menyatakan permintaan pencetakan ulang atau pembaruan KK. Surat ini penting sebagai dasar administrasi agar petugas dapat memproses perubahan atau penerbitan KK sesuai identitas kepercayaan yang dianut'),
(123, 'Kartu Keluarga / surat kehilangan dari kepolisian', 18, 'kartukeluarga', 'Kartu Keluarga', 1, NULL, 'Jika pemohon sudah memiliki KK sebelumnya, maka cukup melampirkan salinan KK. Namun, apabila KK hilang, maka harus disertakan Surat Kehilangan dari Kepolisian sebagai bukti resmi kehilangan dokumen'),
(124, 'KTP-El', 18, 'ktp', 'KTP', 1, NULL, 'Diperlukan untuk mencocokkan data identitas dan NIK pemohon, memastikan bahwa data tersebut memang sudah terekam dalam database kependudukan. KTP juga menjadi referensi utama untuk validasi saat pencetakan KK baru'),
(125, 'Kartu Keluarga / surat kehilangan dari kepolisian', 19, 'kartukeluarga', 'Kartu Keluarga', 1, NULL, 'Digunakan sebagai dokumen dasar untuk proses perubahan. Jika KK lama hilang, maka wajib melampirkan Surat Kehilangan dari Kepolisian sebagai bukti yang sah.'),
(126, 'Surat Pernyataan Perubahan Agama Menjadi Kepercayaan Terhadap Tuhan YME (F.1-69)', 19, 'f169', 'F-1.6.9', 1, '7371e96ecbdd03f32627de11684b01c6.pdf', 'Formulir ini merupakan pernyataan resmi dari pemohon yang menyatakan bahwa dirinya beralih dari agama sebelumnya menjadi penghayat Kepercayaan terhadap Tuhan Yang Maha Esa. Surat ini menunjukkan adanya perubahan yang bersifat pribadi dan bersumber dari keinginan sendiri'),
(127, 'Surat Pernyataan Tanggung Jawab Mutlak sebagai Penghayat Kepercayaan Terhadap Tuhan YME (F.1-71)', 19, 'f171', 'F-1.7.1', 1, 'c6691dc95e8116cde716ae148a56d89d.pdf', 'Digunakan untuk menegaskan tanggung jawab penuh pemohon atas keputusannya menjadi penghayat kepercayaan. Surat ini juga menjamin bahwa data yang diajukan adalah benar dan tidak digunakan untuk tujuan menyimpang'),
(128, 'Formulir permohonan SKPLN (F-1.03)', 20, 'formulirskplnf103', 'Formulir SKPLN (F-1.03)', 1, 'f1241714bb8f517bec872f5059e3775f.pdf', 'Merupakan formulir resmi dari Disdukcapil yang diisi oleh pemohon sebagai bukti pengajuan permohonan pindah ke luar negeri. Formulir ini memuat data pribadi, tujuan negara, alasan pindah, dan data keluarga yang ikut pindah (jika ada)'),
(129, 'Kartu Keluarga / surat kehilangan dari kepolisian', 20, 'kartukeluarga', 'Kartu Keluarga', 1, NULL, 'Digunakan sebagai bukti identitas dan susunan anggota keluarga pemohon. Jika KK hilang, wajib menyertakan surat kehilangan dari kepolisian'),
(130, 'KTP-elektronik', 20, 'ktpel', 'KTP-el', 1, NULL, 'Digunakan untuk mencocokkan data kependudukan dan sebagai identitas resmi pemohon yang sah menurut hukum Indonesia.'),
(131, 'Akta Kelahiran', 20, 'aktakelahiran', 'Akta Kelahiran', 0, NULL, 'Sebagai dokumen pelengkap yang menunjukkan identitas asli dan tempat tanggal lahir pemohon secara resmi.'),
(132, 'Surat nikah atau akta cerai', 20, 'suratnikahatauaktacerai', 'Surat nikah atau akta cerai', 0, NULL, 'Diperlukan untuk membuktikan status perkawinan. Ini penting jika pemohon pindah bersama pasangan atau ingin mengubah status kependudukan di luar negeri'),
(133, 'Surat izin orang tua/suami/istri', 20, 'suratizin', 'Surat izin', 0, NULL, 'Sebagai bentuk persetujuan tertulis dari pihak terkait yang masih berstatus keluarga inti, terutama jika pemohon belum menikah (izin dari orang tua), atau sudah menikah (izin dari suami/istri)');

-- --------------------------------------------------------

--
-- Table structure for table `master_tt`
--

CREATE TABLE `master_tt` (
  `id_penyakit` int(11) NOT NULL,
  `nama_penyakit` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `penyakit_seo` varchar(100) NOT NULL,
  `urutan` int(11) DEFAULT NULL,
  `bentuk` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `master_tt`
--

INSERT INTO `master_tt` (`id_penyakit`, `nama_penyakit`, `username`, `penyakit_seo`, `urutan`, `bentuk`) VALUES
(120, 'Tetanus toxoid Bumil 1', 'admin', 'hepatitis_hbs_ag_', 15, 1),
(121, 'TT Bumil 2', 'admin', 'difteri', 11, 1),
(117, 'TT Bumil 3', 'admin', 'diare_berdarah', 3, 1),
(118, 'TT Bumil 4', 'admin', 'tetanus', 13, 1),
(119, 'TT Bumil 5', 'admin', 'tifus_perut_widal_kultur_', 5, 1),
(122, 'TT WUS Tidak Hamil 1', 'admin', 'kusta_pb', 8, 1),
(128, 'TT WUS Tidak Hamil 2', 'admin', 'tersangka_tbc_paru', 7, 1),
(124, 'TT WUS Tidak Hamil 3', 'admin', 'batuk_rejan', 12, 1),
(125, 'TT WUS Tidak Hamil 4', 'admin', 'kusta_mb', 9, 1),
(126, 'TT WUS Tidak Hamil 5', 'admin', 'tbc_paru_bta_', 6, 1),
(127, 'Polio (1)', 'admin', 'tifus_perut_klinis', 4, 1),
(129, 'Pentavalen Lanjutan', 'admin', 'hepatitis_klinis', 14, 1),
(130, 'Polio (4)', 'admin', 'campak', 10, 1),
(137, 'HB0 (1>7 Hari)', 'admin', 'diare', 2, 1),
(138, 'MR Lanjutan', 'admin', 'malaria_klinis', 16, 1),
(154, 'HB0 (24 Jam)', 'admin', 'kolera', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `modul`
--

CREATE TABLE `modul` (
  `id_modul` int(11) NOT NULL,
  `nama_modul` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `username` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `link` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `static_content` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `gambar` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `publish` enum('Y','N') CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT 'Y',
  `status` enum('user','admin') CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `aktif` enum('Y','N') CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT 'Y',
  `urutan` int(11) NOT NULL,
  `link_seo` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `modul`
--

INSERT INTO `modul` (`id_modul`, `nama_modul`, `username`, `link`, `static_content`, `gambar`, `publish`, `status`, `aktif`, `urutan`, `link_seo`) VALUES
(2, 'Manajemen User', 'admin', 'Admin_user', '', '', 'Y', 'user', 'Y', 0, ''),
(10, 'Manajemen Modul', 'admin', 'manajemenmodul', '', '', 'Y', 'admin', 'Y', 2, ''),
(31, 'Bulan Imunisasi Anak Sekolah (BIAS) ', 'admin', 'Admin_bias', 'kategori', '', 'Y', 'user', 'Y', 0, 'kategori'),
(33, 'Data Registrasi', 'admin', 'Admin_reg', '', '', 'Y', 'user', 'Y', 0, ''),
(34, 'Master Permohonan', 'admin', 'Master_permohonan', '', '', 'Y', 'admin', 'Y', 0, ''),
(41, 'Data Demografi', 'admin', 'Admin_tahun_vaksin', '', '', 'Y', 'user', 'Y', 0, 'agenda'),
(46, 'Data Desa', 'admin', 'Admin_desa', '', '', 'Y', 'admin', 'Y', 0, 'desa_jabatan'),
(61, 'Pengaturan System', 'admin', 'Admin_setting_web', '', '', 'Y', 'admin', 'Y', 0, 'identitas'),
(66, 'Logo', 'admin', 'Admin_logo', '', '', 'Y', 'admin', 'Y', 0, 'logo'),
(67, 'Kalender Epidemiologi', 'admin', 'Admin_kalender', '', '', 'Y', 'admin', 'Y', 0, ''),
(69, 'Pelayanan', 'admin', 'Admin_imunisasi', '', '', 'Y', 'user', 'Y', 0, ''),
(70, 'Pesan Masuk', 'admin', 'Admin_pesan', '', '', 'Y', 'admin', 'Y', 0, 'hubungi'),
(72, 'Pengumuman', 'admin', 'Admin_pengumuman', '', '', 'Y', 'admin', 'Y', 0, 'sekilasinfo'),
(73, 'Data Ibu', 'admin', 'Admin_ibu', '', '', 'Y', 'user', 'Y', 0, 'pengurus'),
(76, 'Log', 'admin', 'Admin_log', '', '', 'Y', 'admin', 'Y', 0, 'aktifitas'),
(140, 'Persyaratan', 'admin', 'master_syarat', '', '', 'Y', 'admin', 'Y', 0, ''),
(146, 'Data Dusun', 'admin', 'Admin_dusun', '', '', 'Y', 'user', 'Y', 0, ''),
(147, 'Permohonan', 'admin', 'Admin_permohonan', '', '', 'Y', 'user', 'Y', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `operator`
--

CREATE TABLE `operator` (
  `id_operator` int(11) NOT NULL,
  `username` varchar(99) DEFAULT NULL,
  `password` char(255) DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `level` varchar(100) DEFAULT NULL,
  `staff` varchar(100) DEFAULT NULL,
  `user_akses` varchar(255) DEFAULT NULL,
  `no_hp` varchar(50) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `id_desa` char(255) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `rah` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `operator`
--

INSERT INTO `operator` (`id_operator`, `username`, `password`, `nama`, `level`, `staff`, `user_akses`, `no_hp`, `email`, `id_desa`, `foto`, `rah`) VALUES
(5260, 'BAHONTULA', 'dfa1ac17c701235b275536a85fc5ef1d9ea0178ef4acd7b283ae9b023d284fc219d5edf12b6ce8563ab9b1564f57e4b5535315c5b662b1b5211317bcea44ac36', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_1_1002', 'admin1.jpg', 'B49910'),
(5261, 'BAHOUE', 'ca665fde4e43d25cb1dfe76f799db080d830638e33c8c46591e41defb406a21f601f9329f6a88d22974cdc8aaa8ea2a47afd3feabb25c640ae77f3b6fd36ee64', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_1_1003', 'admin1.jpg', '2104BE'),
(5262, 'BATURUBE', '1e70ebb5b50d868535d95b49f7bf9e3a025381856c837f9fcf17a83d63420a6b195e88548bfd2047fed3d5bf60fac39bc5521d4eb81dee0b390f5f0339d68acf', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_8_2001', 'admin1.jpg', '851FD2'),
(5263, 'BAU', 'e53babd84a6ed734afcf1d1a12576a119ccc8bb659204622e06930870f05d0e8bf149f95568c867f0b1277438a4fcc4e9833708f63c4eb66138439fd5ca83754', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_7_2007', 'admin1.jpg', '814E12'),
(5264, 'BETELEME', '6397400f4fcdec4c8d768fc8b6f654d19a9d37c5c90bd50301f9f38822366fb6524b7e15a1dcc0e00a6c6c2a4ebc2154c5f9e4dd1990008b21efdda1939fa1a6', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_4_2001', 'admin1.jpg', 'EB22D4'),
(5265, 'BIMORJAYA', 'd053e14836d1d2723a578d0c04201368e1f74765985fd98e5955dbef9fd06de9a4c2d6ffaddd920412b2ec5cde80111fd2bdae0d0cb312a45e5b123ab6cd0c19', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_2_2008', 'admin1.jpg', 'DE4114'),
(5266, 'BINTANGORMUKTI', 'e5943b315e8438f1decbc66b39e244d14a3b89f0d78ed4c9b23a932166d3644d7e9d2ef4a32b3db8a1200155ca08bcea0a5727d497994a742699a30dfd5680a0', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_3_2009', 'admin1.jpg', '8025F2'),
(5267, 'BOBA', '92e1047affc65fd2382bacdecbb5a2b0603e30aca2c26029f3aab501d0546aa7638b16ac0338ad81fe63606271084f5af15f79ea888542ed6814e9c7343b7ae5', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_8_2016', 'admin1.jpg', '2292C3'),
(5268, 'BUNGINTIMBE', '5fd7cbd5d744fb9747d662cf2ef67c77fc90c8fb5ec46d254cd797de6588e88c3d51066e0bec7f94354fe107de68c221049b3a3ce23f75c9170be21bc29b8cbc', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_2_2003', 'admin1.jpg', 'E8CD21'),
(5269, 'BUNTA', '41989cd891927ef851eaa124178e0bd1ae45aa41e60b7c0a841b7cbc46fe7013ac2539a51de15beb382e9983216a704eca15f4d756b79958fb5d573bec119166', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_2_2001', 'admin1.jpg', 'D9FB5E'),
(5270, 'DOLUPOKARYA', 'ad4f349f41aff646446f6770b8596351cbd3078cfc3c734d0b1349fb3600dd17e27cd44f449d27946dec498e3838dfab091de718a0a53f4d29619faf959a4860', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_3_2001', 'admin1.jpg', '44EB4B'),
(5271, 'ENSA', 'e41aed9c649549abb23e89bfc3e5a3c36426dddfa1e958a496de0c9215269980717e2bc43139b3436958da302944974a549113c9d0bf93552af7829f2854dfcd', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_5_2004', 'admin1.jpg', 'A07C8C'),
(5272, 'ERA', '353e5e58939d447db777f2c57b4caf0b30613adede2b342f1ba91002076574661369ff9a36ed99b92e432563de07c1a133289fc9053ccb9be23bae4f55a572b2', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_6_2001', 'admin1.jpg', '655C6B'),
(5273, 'GANDAGANDA', '3941c5ac34cb44d879257f08a40e46da84c9f2e0e4679f29fd88fd149b71f69edad49a1ede3472f7d643aa54f9b0786f8552d261f74a325c638039682dc0d2e8', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_1_2004', 'admin1.jpg', 'A58607'),
(5274, 'GILILANA', 'a7d1551fbfc10430af726d7cb0480ce4faf4bb45d9c4778f4bd5a7b317d95dd9e4a2bddfb29df4b6e8679d9b99583232520f6dd9724c34e72fc204d42f8accef', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_1_2006', 'admin1.jpg', '45955A'),
(5275, 'GIRIMULYA', '9dd9df9d86c092d4e98f7cf58d268cb5cd4c1de34da7c0504f233b8f0bed7b2bdc41ea9c6e542103ce96b8f93f6761d614449d7320542584d8a9695cb7534e79', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_9_2010', 'admin1.jpg', 'E41735'),
(5276, 'GONTARA', 'a26bbb684daf9524051bdb5aedc221b35b8655b552457e242338f00bf900a30b7596401e6f639674c16d9709b3bc4a7bb8bf00801dc9ec05ea366e400a25c815', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_5_2008', 'admin1.jpg', 'F046D1'),
(5277, 'JAMORJAYA', '4390f9c68d2a91455886a01c56b9b0d43778d95bfdc6a7647b9867327297e19fafe3f6e4fd1285a92e4e6bf5bde42cb571ca324659afe1f97e6305de9254c152', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_3_2006', 'admin1.jpg', 'D6F56A'),
(5278, 'KALOMBANG', '35ed6e445580207e1ecd0dec74942c351d36ace482dd2e81aca69345407b86788d9cdcd72fa8cb4b265b58bc4925c23d098dde67a5ec9a7cc78ca2822b0c1eee', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_8_2017', 'admin1.jpg', 'B03943'),
(5279, 'KASINGOLI', 'ea3a77fc44970364dcfce51b778353082a51ddb06465117e3c40f6a0fbea5250a3f10bcadda055d29378925187149e959ab3dc072624e995faab5c938442c1c6', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_5_2011', 'admin1.jpg', 'C5D890'),
(5280, 'KEUNO', '74f09ced322cdee39760cd95d5af341e6b34e3ba282cd3854fe6fb5b82bdc3e74f438a09d6c1e091a9cc8be7846388bae20cc3105988f39f77dd1d50a7e5ae01', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_2_2010', 'admin1.jpg', 'E0E4BE'),
(5281, 'KOLAKA', '2f3fbcc14497ba3a1ba6d3be87b67d007e844d335a8cf51713633edfefaf47c93887b2bd9af73bd3ebb712ac0b2b2a7ddab476c708c6462861d67d37610411e4', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_5_2005', 'admin1.jpg', '3F713F'),
(5282, 'KOLOATAS', 'bbbd35579a1a0b7824448b55284ea63963cfdf2b8bc748803069b6cb43455677e36e23463e0bd44e391494aaffe7333e316a138b14c00cecfb21fd6206635a40', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_9_2003', 'admin1.jpg', 'F8AD59'),
(5283, 'KOLOBAWAH', '950bcc05e3382e04b62ef2b59cd268658866c4fd3f4aae8492231535ddf9067b5a2f8f78fdf67ce059a0d9d279a23947a35d4b6b51dd0ab920e2fb60e58d9b59', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_9_2002', 'admin1.jpg', '6D73C6'),
(5284, 'KOLONODALE', 'b89d4387677e25cd39d8783bb4c224e67113e2da193edab7c1a6d08b9f40cb29d14246d22862200a5a063827d98b671adb6ed4ca99651cd7381897170f8b9bb1', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_1_1001', 'admin1.jpg', '26DE6F'),
(5285, 'KOROBONDE', 'df11223cadd57c430d1c4c64b6fcb5cb9bbdb8c81a04f3c57ed56c21cfbf3eaf121acf0de73a30d061cf60095d9bcd123059b6f7e887b1a5925c7c9ca0f0c0c1', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_4_2014', 'admin1.jpg', '2954E4'),
(5286, 'KOROLOLAKI', 'a1c4bb42de0577b73c0f246c0388e3cb40767e64ac9ac514e271504ca06959db55fcfa161f107f20a1df9c5825000f111414779ef1af7c5073d58f53f92553c8', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_1_2008', 'admin1.jpg', '7947F2'),
(5287, 'KOROLOLAMA', '7e140766fc9b814c3b64e4932c8280eda102805a42dcebcad4acc86a0bdff4acf245cd72a43ddfc5ea049a9f1b0e61b3b7115deaf022613039f9af18b2999d8e', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_1_2009', 'admin1.jpg', 'B16B9A'),
(5288, 'KOROMATANTU', 'da5e3334ee9d0d4c058c61d299b865dc3898caf36762d83279ed37e20f9a428aca30ab0a14b4967330c9b93cd218cd563349cffc8dfb8dd633372a0949a57309', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_1_2010', 'admin1.jpg', 'F850F1'),
(5289, 'KOROMPEELI', '4c522db157fe76f8c68bc967e2db0a7b73a9b41f3d4a1755ef26d4dd87074c5f27a363f710158607b57ad142175b314411ba4a6618e06e4e0d36c38c9bab2378', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_4_2010', 'admin1.jpg', '4350E2'),
(5290, 'KOROWALELO', '0bb7b2c53a3a0c613bf9c68a466fdb186c532786ee62480316df59c88ff4fd2c1df21eeee68dec60d7c3dcb80c7831b619a9e27ea80e80f5573fbef68c6a52fb', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_4_2007', 'admin1.jpg', '699C2D'),
(5291, 'KOROWOU', 'd980d51592f5add12e391f77568612d310f893569cf8a19ce25e2b074bdcbf2dc5ccadecc6331a391c56a13641b5d63eb8392266f7bdd4b46ca19bcff789aea5', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_4_2012', 'admin1.jpg', '582D1B'),
(5292, 'KOYA', '464360bfb94b0a59af802f5c628dbf1a6472c704225bdf2f6b40c9304474907b4f40ca6fc7b9bc2edfff018db8a9bb5ab4f5000f1e9bf0a4750e2baee36fbc61', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_1_2005', 'admin1.jpg', '9EAF82'),
(5293, 'KUMPI', 'f67d03789bcf82c9f4ec617cc1f47511a6fb1cdc0e628183ab370ef902f632929e9a4f92887735cfe9c754e59ddedff5f03d140074f458b93fba4fc265255fce', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_4_2009', 'admin1.jpg', '5031F2'),
(5294, 'LANUMOR', 'ab37048ca27f6d0a9aa3986c78bcf2addfc3ebdb9fa50fde508e3e31c2ed1682de754b22d49c4f95d71957133ecae4a72eba3dc5d72d96683c8c9de302d12f28', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_5_2007', 'admin1.jpg', 'F79E8F'),
(5295, 'LEE', 'cf6d8aaeac9106405ea888fe2dfc249087741ac90fb42a8222f009c5b3e16f408df78f2030d7f1df7da777097b8c1f8ade4fb3b6338065122ef62bd42713c7af', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_5_2009', 'admin1.jpg', '761B08'),
(5296, 'LEMBAHSUMARA', '181d8b4aec93e06b4eeb8feff0075da397c16edcf75f3e30c5f6a7846082ecaeddc8c85b20c0f6dea513334e795ec998be0a9addf3ba409196e9c06ee26d5165', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_7_2001', 'admin1.jpg', 'EDBCD4'),
(5297, 'LEMBOBARU', '2d8743875fc35066e75b798512519fcead1d03303e1b56f06bf379398fb866a14b82bec18d4a24be6821c018dfca4b9954cc03aff042a593121d796684854c1a', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_4_2013', 'admin1.jpg', '5BE326'),
(5298, 'LEMBOBELALA', '33948c511b10a8baaf789c1d2e6fd55a678e14823f63e99f732bc4d68f5aee231914e5e7469b4b8c537915fac2a81c86acbcec8e0964c0eb7f0c4b05f53c4f91', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_3_2008', 'admin1.jpg', '3F4378'),
(5299, 'LEMBONTONARA', '3a3cfa2fb74b088703e66060bf3393ef803af8038223603bc40b61086915cc29cfe1392a911a39e233136a46c3c86a55e311ad1d35c32abefff1a95237d7960e', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_6_2006', 'admin1.jpg', 'FCDBAA'),
(5300, 'LEMBOROMA', 'e7de3a4cde2033e8d707276f7b0596832a1474dda17df7c7838e967c97c87519b444a10133ae11599f79146d8d0ccf9dc37366ade808c50cb6d969252eac3d31', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_4_2011', 'admin1.jpg', '704FF6'),
(5301, 'LEMO', 'ae78f491f7bec93f703f88b28b18935ed171a2f86e4b457506fc74a83e7fe6b768323c6437d89b759009c99d2e4bb6eba7b77e8e9280ae5eae78483e8a2a542e', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_8_2009', 'admin1.jpg', '7300E9'),
(5302, 'LEMOWALIA', '5a48cd4cc0d3113c4ffd9a4c07f6d480416b6f5e61025a58390598d0b339bbcfeb9dfcf7b0bb679b292fb6d50f4a5fdadd4b282a28c73b5b82bf1dc51922456a', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_8_2020', 'admin1.jpg', 'F7111B'),
(5303, 'LIJO', 'bfc0f8d154479bb6eac303371b189d3cbf9169a5d39feed23defe63b25bbe2d05c2bd852cd443c0a548beac05ded191a43d83e52898a4656a0eec86f0414d024', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_9_2007', 'admin1.jpg', 'F7583F'),
(5304, 'LONDI', '3c9457cb1c2cdef2e898259801e634ac55d4a7de59bcae8a662537755a062c0288c33044f5b7a1d6b301307762b927a5a354f3283580ca313cc44831f86aaa81', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_5_2002', 'admin1.jpg', '925C1D'),
(5305, 'MALINO', '7804bc683b100136ee2c08aa3214fc6dba1a5149835d652ebae21debe698381a3f4b33b1809e7d424724e3f37aca137f5881530f970e5edd183e7f036cdc22b0', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_7_2004', 'admin1.jpg', '5BB052'),
(5306, 'MALINOJAYA', 'becbff4a90e67b8df545fbcb7696ab740467c30e91f1184bff7e91f43560065dfc3f5724b1a215d6d86f315c93ce67227d310e1e041e68c0ba9d812af6354439', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_7_2008', 'admin1.jpg', 'FAC4B2'),
(5307, 'MANDULA', '7d369331a7c734585d8ba9f3fcc6faa205f7dddd2d60fe924c6755f3a861863af6440bcf37c69fcb945feb91292141e12f6194343a9d08ab4e0ba26ddd598f44', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_3_2010', 'admin1.jpg', '1703E0'),
(5308, 'MARALEE', '0217284e11e87d516e1ddcb9c28e231c8a8213638867b20ac4020263c539b42e88d6e2ce3ee64731c4fc8a0b578f5125280e8bb057b7fa9e2282ae3dea9c3127', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_10_2021', 'admin1.jpg', 'FAB72C'),
(5309, 'MATUBE', 'b031ffe32ec6bd862466673bf15a9ccca2d649cd279dd55bff01dc6e60791f977bc04435a9f342aaf7b0c9f4808a35eab3cebffe94dbcb38a27a827d74ce8b82', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_8_2019', 'admin1.jpg', '32CE83'),
(5310, 'MAYUMBA', '5520c53740c413709116524a5ead45e7a374f63b8e0a7c127fea46300720135a7f82fb29a8e738f75ed040a0bf84adf20102628364b4526e14f1cf7456223cef', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_6_2004', 'admin1.jpg', '5C28CE'),
(5311, 'MENYOE', '8f034dcd1c88aaf9d043ef43729a6e613e7a3da1b94952811bc07c2d61611d866031aa11f7c51c54fdee1578e96fbe4611a6ffcb66323e3590a7487a4950a406', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_9_2014', 'admin1.jpg', '179A6D'),
(5312, 'MOHONI', '0095cd99d8cf08bf19b16b9ddd1cc921742b98ff31b0b012f40b21d03c4f5aa759eca3c50ec01c140903cd184d82fdbbbc11ff1f6333785b020a4956f0d3aef8', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_2_2006', 'admin1.jpg', 'D2D460'),
(5313, 'MOLEONO', '1f2ebc77303734ccd5da3c8da20f44326e61e21b7b05161c970afaedca2e7236a9f120fa9844a71d7255d3b69490d0fd1cdfbef612ee629a69497df0b6e02ff1', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_10_2017', 'admin1.jpg', '4F06FD'),
(5314, 'MOLINO', 'dd633b1127492e65d5ae64e2483fcdc68fdd7229d0e38a5bb871f499efc0cc07afad5ef90fb7f60268b948c45d6c50d136cb314640cdfa89223f5bf0f2047588', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_2_2005', 'admin1.jpg', 'C73D11'),
(5315, 'MOLORES', '3d5b4efbd4c782ebd9d205da10cb0e3aaa95e48c597d6ff0b1740089ca553cb628db811cb975f656fce86d9dfafe0283b209a2dbf6d96170e263338733d83072', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_2_2009', 'admin1.jpg', '47B33F'),
(5316, 'MOMO', 'abd837ad75ced9b944b57aba8e949d3c494c8185e70be11ffd716c2d4a69c2eb825110799b69d13dd8d1f24e7563905e471739d8331954d00670b0e6339eb4ae', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_9_2004', 'admin1.jpg', '8198DA'),
(5317, 'MONDOWE', '049fdcbe05ef012ebda8af507e1dd71f8f12a90d7f8c79c1e5041e46e7f49377c689a2b6a13aaba1ae7b67e88697d7d59092377f8bd84da03d69dc61534e0379', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_10_2024', 'admin1.jpg', '2A8A6E'),
(5318, 'MORA', 'e81fe226e387be7f5c0d7d29d7c88040bb715170e955b2b1e50b8bcefe9dca870b7a2eb29057e0dc4261fb503c3fd399a174f83cfd8ca0d6cfa9b69ebe807138', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_4_2003', 'admin1.jpg', 'BF76C2'),
(5319, 'ONEPUTE', '161246e950baed6ea40ca466cbe32ba54f1b0823d700587127ae84d60d6b199428a5e4df7565a0a9bffb01e79b8028d531cce404e9e11dcd46e51123dc3eeefd', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_10_2019', 'admin1.jpg', '5D5FE7'),
(5320, 'OPO', '28c18db3488bd10b46b50d62f5c1863ffa9000b10b5ddf588939ef395d08c5d0b7eb226b3723df2b7daed8ac54671cd7a7882645ffc1cd50546618631fe096ba', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_8_2012', 'admin1.jpg', 'E74529'),
(5321, 'PAAWARU', '8f1f9b33abdee6da4044a4cf14e81bc54fa73b767f37adb5ddebafabca084288f100dd23bff6fd2c1214308b3bac2e00ff7de97491a390ea5f06d647434d945e', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_3_2007', 'admin1.jpg', '31474C'),
(5322, 'PAMBAREA', '3a442caff48a6e5316682502c7364d497a0274ad70798b4812b21036d4fae1cb966fd5bad3c2fbb43d2f0c8eae336cc71667375dcfe9ddac0ac72e90115e117d', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_5_2014', 'admin1.jpg', 'D462C8'),
(5323, 'PANCAMAKMUR', '74e3912757c6cb6249682cdc524029be6660ffa3eb447230475b700ce5d354c93dd491caf39ba19e3cdd52b68637085c295bf2b72b3dc8f3cfd46c4baaff82b2', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_7_2005', 'admin1.jpg', '373839'),
(5324, 'PANDAUKE', '8264b29b7a3144104859c7946f81567153e092a73a858f4235c0f7916a22131a54492cbb56e7256352cfa0913f4758d7c8ce5c24d78e69094c3f24a510cc78cd', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_9_2001', 'admin1.jpg', '8A6D85'),
(5325, 'PARANGISI', 'b8da6d3c71d650fa7fef5ac405b45bded92cf6d0c24605eda025e87d497ade4551e7679510acfd80bd986bb54158344b7a65e77ac2ff3079018b2f578f181e2a', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_9_2009', 'admin1.jpg', 'F6E6DF'),
(5326, 'PEBOA', '0b6c637ff564c0db70fd8a6aa74ba7cea0828a364ecc4dc7a617a72b36c0afa23e65160347ce5618fbdf974a43f56a5e47cdabd4e04a0093fdcc22fb18bc7236', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_2_2012', 'admin1.jpg', '87DA33'),
(5327, 'PELERU', 'f17ec30151d682b1a860b892c57dccbf9deb3fc67fa34def261895ea1b08c67bc829c4fe1a13a8b8623455fb74ecd5d0e000156e47c46bb0a4c906b24b689cd5', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_6_2002', 'admin1.jpg', '0A8B58'),
(5328, 'PEONEA', 'c1c98397552fa495468b0809f6a86e9cf536c65dad496925f6cf22e1b69c66dd7c88a49f78e92b8a04d840036ddbbfcc69693f5af7418085921977e1b1d3231e', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_5_2006', 'admin1.jpg', '7DF330'),
(5329, 'PETUMBEA', 'f027053f7166734d7d78c777af1c54d1c83c07258aca201106bc897c5ed64e87fd05d4d096fd7b65527f10dc4711e991f8108589a8d542370c7d41dd36403694', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_3_2003', 'admin1.jpg', '68F385'),
(5330, 'POONA', 'cc18db4bfe93be340370ef670be64ae0da521f52e82f766eb3fe80916a1c5a12aaf2f16c89e5480966707e05d7ab7105a1877d25f792dad1ebad725b2c823c14', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_3_2002', 'admin1.jpg', '7F4503'),
(5331, 'POKEANG', '61c5edde29284a863258f02a9cffd0ec61994c134db5e631fe5a8628fe3851060fee63486757a3a4d4da79ed3f14d0003fde765f5a8440ee65e6c1147edc47c6', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_8_2023', 'admin1.jpg', '2C167E'),
(5332, 'PONTANGOA', 'cc21392a63b1b6972895e0c23a76274e70e79b0b92f84df91495fc3be17903b481e13eb0a04f7be45ae6e284511172ab67116f81618f6c7dae117d2c9b2e3ecf', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_3_2005', 'admin1.jpg', '1818B0'),
(5333, 'POSANGKE', 'ff953fdfef7aa0b46ba66f38008ff45a775f2fc878878c96e867b59c801603eea7e8b18e6bad2e5fb3bcca694ce2dbf83d17e3978d9d70b5f037b0ee2abf7efa', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_8_2002', 'admin1.jpg', '6E2543'),
(5334, 'RONTA', 'e79a4014b8fbf302f1690d5edb649d1de11b489e7154a7814db300d92cab1895432748eed38c11cfa772dc26309aa58e7ea18d179e6c658fad71ed4e1f620543', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_3_2004', 'admin1.jpg', '462344'),
(5335, 'SAEMBA', '75b8ffbe20d0f1a4e63ea7a23098f00d883d263c5551920050687e228c73e9607b437b0a68ec33664040fc5869a978a2fbdc88d56f394aa02c49a67a26c6dfc5', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_5_2010', 'admin1.jpg', '244842'),
(5336, 'SAEMBAWALATI', '3dcf6f1ffe1104fadaf2512bdc51cc06022599a10633183dfbd255e9b9b3ef286fbb325bee422df4d23140f59d95f4d0b1b7f0084a79f0a80898aa0f5a73afd5', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_5_2013', 'admin1.jpg', 'F62A66'),
(5337, 'SALUBIRO', '4842908d948ddf6d1fd9beba66b0a3edad1af9b5936b9dd91da5adfb042ebed40811f8eb40fb3c4738a52b92a2a3680b615f0bf300baeb099a9a53ac6567203a', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_8_2010', 'admin1.jpg', '200C50'),
(5338, 'SAMPALOWO', 'b62ad1cdd1c029d35188382ff637a9a8f00d6a2fc5e1d293c9a113aedb7686b2088500b781b5faad1e005da84d74140a0cb185a8940c4420aef4dc83810fdcfb', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_10_2022', 'admin1.jpg', '076FCA'),
(5339, 'SEA', '48da9684f768489b946d0f01e3f62bbe0afd2647465dee656a1979be602c5cb695eabf6401573d1cd00d5ea21f8af7e027de840538a59e2df6e34099c47945d9', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_9_2013', 'admin1.jpg', '22CD31'),
(5340, 'SILITI', '8f82d497434b458c920f201fad93a9da6211993e2abd7568ecea7f7cf50d3dda1d2309f7527baba10b52a6ee25f167c09d237474458704937098ac98ad072331', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_8_2008', 'admin1.jpg', 'AF7693'),
(5341, 'SUMARAJAYA', '8818182ebf2abff93d324033cc6a2f19789dcb03b2e0538a86475ccb2be48a1c45b38bd82b908bfe9ec9f19775023bf5c59774cabd1f573a4932837284ac97d8', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_7_2002', 'admin1.jpg', 'B012CC'),
(5342, 'TABARANO', '2c33f6c68f547686352f69bc0f7cb97bbc258ab29fdc87440d9e0d28fbd259dbb42b4ff392dedcc43608711feca43e97cb15bcb3e325a1f4967cc3b31f738683', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_6_2007', 'admin1.jpg', 'BCCC85'),
(5343, 'TADAKUJAYA', '31fee9bf83404e181dda1da4d8e87b75962d504e5d59d7834d2a74ab315837d0dcd432551824f44e9476a924b2ba2275b1f740bf09d620216775d015a5f12170', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_10_2026', 'admin1.jpg', 'BF5C2D'),
(5344, 'TAENDE', 'ef79f273bcc5d7abb43e544b0f22b2f3c8b594a07ce5e0006c923bd4ae5f5a862cbaa7c5133a6feba4242211dd1508dfcc676c6aa3fb162707b2d161d3f79b6e', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_5_2003', 'admin1.jpg', 'C6AD90'),
(5345, 'TAMAINUSI', 'e6f8de556bfcd6d4a38bb061c9d5427e4493cd893b71fe0463aae230e2db41b121c8a0ceebe31157fd988f8a82edd8ac2a60c8ac8af262b5d9a370d96e94c88d', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_7_2006', 'admin1.jpg', '9876B9'),
(5346, 'TAMBALE', '9a3ea6b038d8adbdb53686bb992f9697cf1f7be9f42dccf64bf060aaf4aeb545d52d98f8bdf734126d51cd2c4e38f5d4497749c2221f58655b9242d2bd0f15c2', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_9_2012', 'admin1.jpg', '8E5E10'),
(5347, 'TAMBAROBONE', '1e007fa114ce1b35663e5932a57339754b06ccdff980ab467c7bd535b611bd4ab195427aaf05b5be46733c2def084723d24209c7625874b20885764133e089db', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_8_2014', 'admin1.jpg', 'B70C2A'),
(5348, 'TAMBAYOLI', '3081bfa9c52344f86a72bc3ec29f266ebcf212bb49b4bc474a75a37f16eb204462b7e524bb99ea4dfc29a6388deca58668292e782be8d23fc191d6d0378fd981', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_7_2003', 'admin1.jpg', 'D0050B'),
(5349, 'TAMONJENGI', 'e0e8bd81043361a1e6b87a3598af36ace3648622d96c1d7d7bc8e5dfd72494820130be8f153ccaba9273d95774b832c16519b59d94fe3e8a21ec8322775bb062', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_6_2003', 'admin1.jpg', '0969AB'),
(5350, 'TANAKURAYA', 'd7161619ad48d07dbba41ed2128c83f3d2ab33502e9d0379752e0a9d409e3444d53b82930d248d81aef4268cfcb168cf6541140d7a64f5f7e1e50feec6763256', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_8_2013', 'admin1.jpg', '274533'),
(5351, 'TANANAGAYA', '4fcaa95741ca6de75a2187fc88d131e2328b00bd1a89af7059ebdb5daab6fd949921ad89544455eef80c3497803089502cea7a8657f664be6aa01d4471cbf4a5', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_9_2005', 'admin1.jpg', 'A528E0'),
(5352, 'TANASUMPU', '7af2fb9041bfa096de2228f760718c80ae23c162f715ee8aeba020671c2e8196eeacb602fe7500d37a80a8793cef0597f94d022bf1f6c39782f07a465f5cf510', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_9_2008', 'admin1.jpg', 'DF66F2'),
(5353, 'TANAUGE', 'bfde43168b38e355487915dbcc4c78a5573b2787ad0923ca9bc6548a453eb81cef2711780fee64c1df947631b7567f13a40231058418de8b16cf7dab57ef4049', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_1_2007', 'admin1.jpg', '3AFDCD'),
(5354, 'TANDOYONDO', '642e070fa129219790cc24238f3cb2769d677a4aa4358f4ee4ffc9c9ca661413a685d53896edc3b6699b98d21bec8e40af325fa0ad0db0af3cfc1b5fbad595c6', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_7_2010', 'admin1.jpg', '2EF46F'),
(5355, 'TARONGGO', '47d1aff8b5733704fb2b745d7e80c05d9db128369faab2bb138fced02156375e936b020f7fc725e9791be2ed74c3ac357f3ad9a45a8a44047fd373b988f6b47f', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_8_2003', 'admin1.jpg', 'E39BBA'),
(5356, 'TINGKEAO', 'd8079fa91e22597cca6b734575cd8ce30a4ffb3399132b41fdcc56b54abfd5c640e86ddf023dbc3cbca288e94ebcbf63fa536521f51e1804a7857a36b86cdcc8', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_4_2005', 'admin1.jpg', '3D6370'),
(5357, 'TINOMPO', '374e3688f91ba810e28fadd5ef087f2e2129d571659c1afc16eb4938a3619d52e76a8a3f93d30dbce46e09db0c44279efbcb07d895ca883767e5fbbb6fa8d9ac', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_4_2008', 'admin1.jpg', '8F47F6'),
(5358, 'TIRONGANATAS', '5341bfe6e6fe51fa995ff21853e2b086fb6de3d73a36a057452f05c24607c3cecfabeddd0fb574f0cf5695a8524b89a95432a013f382a2fb2020e2c832e22963', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_8_2007', 'admin1.jpg', '69E2E2'),
(5359, 'TIRONGANBAWAH', 'da57389b157b40f8c884b5f3c6450ad54fdcb8ebaf21f8b266e392d706006b95839444547cd48c78566b6a398c83becee9ccf6b0b433d123ad40fc527f72bf07', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_8_2006', 'admin1.jpg', 'C68120'),
(5360, 'TIU', '15941b6afd1829ab708d4d0d0a218a18f6cdb3e3265b046f47d2573a1ad6b46d44ec64831d1bebc7828f32b8a7ea9b7c98576e4f8228ecc52659473543e234cf', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_10_2025', 'admin1.jpg', '615FD7'),
(5361, 'TIWAA', '233c7e61bad6f7af8f8bfdb15cc12045809c9ad1a1df239da7481736d29f81d11ca0b73d3cb9574255f56251d9cb2a6385808f0cf9e1d9fa2ac0e88e65f80711', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_6_2005', 'admin1.jpg', '0AD2AC'),
(5362, 'TODDOPOLIUEBANGKE', '70bbd373471a0cb094944b5360a1fad4cde6efd495ee7590ee6df4a2c6bd918e3930f3e84e595221fcf86a08804afe6f90be4ecf770ac2edc27cba5bfb8d4334', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_7_2009', 'admin1.jpg', '7E82EC'),
(5363, 'TOGOMULYO', 'ccd8869d643282994700b200430a5c1908aa89338eb9f102db1a42200c99dc153f4ad25e343a00fbc55a2da655eda702de2d8c65b25bd50e989bc76ffe441f1b', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_10_2020', 'admin1.jpg', '7707B2'),
(5364, 'TOKALAATAS', 'aff22542303003733b6e9734522f2875f57849daffd1a13650c5bc272c3ba368ad2bd859e88df174fe131bdaacf68fd05ce86bcda99b51196b92f629a6705ae0', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_8_2022', 'admin1.jpg', '3EDD4B'),
(5365, 'TOKONANAKA', 'd0fdd7c902555c520502374bbf50beb5a676f79aa28daa85bb78ca539b8012c408a7e2b1969b1887d196bf02d3edbd68185e0083b7d2bfefa9bb7127a3700c2b', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_8_2018', 'admin1.jpg', '2B2B88'),
(5366, 'TOMATA', '91e081831f312fd5106650058b50c98358ff6a744462234dc55ea437c5532f1e938542e80ccda4ea1f215d0bbe5f8faff6fedd6781320da9ddfbaa45d4d65563', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_5_2001', 'admin1.jpg', 'E14AAB'),
(5367, 'TOMPIRA', 'b586ec8d1670b45981f851c0ac49af9eed757c74ae6acef113f25876d86bfeef63e7550506f1a77ed210e5b776f43baf82ce6a7c47fa9a1a16428438b2259768', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_2_2002', 'admin1.jpg', '0F2D34'),
(5368, 'TOMUIKARYA', 'a6e470b7579c1979b95e62bf20d658d884685918463cc19d81c30bb8506fd895e06d0eebdf146386f3a835c57b1d67fddba48128c887fbab955f016cee95fbfb', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_5_2012', 'admin1.jpg', '32F6E1'),
(5369, 'TONTOWEA', '8087aaa69ca30b442cee8e26081a772f591b922539e064acb0e3b251fce92872fb035ae34c37fcdfd4efe82a9e75ebf4cc2d5b1d43300cf704399049d17b3d26', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_10_2018', 'admin1.jpg', '158BF7'),
(5370, 'TOWARA', '777b748e6a7fde050dcd0a749d373c8d11d21a6a929a992c0abc6daf0e124cd1365e39e98dedd653e33f31b10c4c4c719970897fe626a25a3bc9fb25bcf826b8', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_2_2004', 'admin1.jpg', '3729A8'),
(5371, 'TOWARAPANTAI', 'f0d29d73a6b933b217aaa8130b4c6d7dfd0daa3767687dc148a13e805b25d08582a4e12386b8a1c1788a18895388b6ca674422aab54469765140cc371ea16a22', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_2_2011', 'admin1.jpg', '5B887D'),
(5372, 'UEMASI', '8ef66490ca14006c49ab83e61c7e6da3c06a297158c21bc0b351c089676463eeca93610f92c4f04ebc7cb5bc0406e0f83e2b20134dbc965977e63733ac240a1b', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_8_2011', 'admin1.jpg', '664183'),
(5373, 'UEMPANAPA', 'ebe780c964c7734fe345333f486055ef52c2d7e905a23198e024cc74816e911d50207eb6808e3a866364aae3d5d0af1161c860ec7c8dec97fc274d0e9033cf3b', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_8_2021', 'admin1.jpg', 'F7C664'),
(5374, 'UEPAKATU', '50459990448bb16f8a8786f341f6103e7607b529ff68067c6244e5c42c332924abf9826fe2a69b3f8747851b0ba0291e9114d6dfa7ccb05b594655a8d218ebe9', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_9_2006', 'admin1.jpg', 'F94EB6'),
(5375, 'UERURU', 'f0166f9ab2205f54e3ce65169b9d6c8532d192318a0237c5ccc0460ea713a7adbfbb0a8d276f90221de69a6cfd88668b9a0efef22fa25947fa021dbf3ab57537', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_8_2004', 'admin1.jpg', 'D5A6CA'),
(5376, 'UEWAJO', '3f6f4df3678c3150846f7bed7e254c0e8e520e9c5f6674687077cd9b5ce3b82509d053fb28a280f01ddd3decc389f7c20d4d4eed5a7018c7ff5558a4e9631e8a', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_8_2005', 'admin1.jpg', 'ABA734'),
(5377, 'ULULAA', 'c0818afdfd7d70e5041a5d0ecfaf98604800b3aec1de5f79c60e05fe8568e229e11a148916ffe9eada298ddb4bb886cb2b543d2e0f47d61b2610ae280546aeec', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_10_2023', 'admin1.jpg', '003028'),
(5378, 'ULUANSO', '8dfbd10fb4cae1e09ca2b0998df7dd054a5337934d1798c8a797f375191e9a1b2e806bf1890097db45d55dbe45a56b36a21bd9e1f9f85cefae2a8ecedf656bc9', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_4_2002', 'admin1.jpg', '4FEECD'),
(5379, 'UNGKEA', '864c552c66094f6b19eb844f4e3c41c9102dc0c475ad26a5c74727f515a9b988d0e9aabfdb6ad86abe4a4927da12fd36043ffccaf74d75651403b7c61d664e72', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_2_2007', 'admin1.jpg', 'AA9B87'),
(5380, 'WARAA', '82937965e6111f4f0c355431fb60223211b4293ca76a2c516cf778011844319648bfb3ee03fa69f9fde8ab5084c06f1db9f309bd998bc08fa152441a10835639', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_4_2004', 'admin1.jpg', '46B723'),
(5381, 'WAWONDULA', '6f0fa04cbe15048d54f8c122ca7c2256f801bf32a9a282d6fda8296af3750ad4d4d9c2243a1485f3953b781dd279db0ebf83ded411180f6f52f71e6d8176861c', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_6_2008', 'admin1.jpg', '7A51C9'),
(5382, 'WAWOPADA', '6b9080d3e979aab7f1e62b9780f10a0e90fa78e915b3d57fd224b84cc55ab316f92e5d99865eceb4a55ac382b5d5fcce900a234548fe2198eb7088253e669d66', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_4_2006', 'admin1.jpg', 'FCAE04'),
(5383, 'WINANGOBINO', '98e5b15a173c50b3d822142a1b7b61ef55dc5f9fdf0235482961c8f8e446951d8117406bc22a07d12fb3f6fcdcf8d3933fe7d3621c374ec4210ca7767592aff5', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_9_2011', 'admin1.jpg', 'C01A34'),
(5384, 'WOOMPARIGI', '3bb8baaeccd5e6dd7a46781a32becc74cde034a285b780019ee32ee9afb9365d6cf8c7bff1297cd6bab9c5379ac31c7904ed4518c4d4048ced02f67ec5522d17', 'Dilla', 'admin', 'admin', 'Admin', NULL, NULL, '72_12_8_2015', 'admin1.jpg', 'CDFC36');

-- --------------------------------------------------------

--
-- Table structure for table `paket_a`
--

CREATE TABLE `paket_a` (
  `id_paket` varchar(100) NOT NULL,
  `id_pemohon` char(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `no_registrasi_pemohon` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `nama_pemohon` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `no_wa_pemohon` varchar(255) DEFAULT NULL,
  `nama` varchar(100) NOT NULL,
  `nik` varchar(16) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `no_kk` varchar(16) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `file_ktpsaksi` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `file_kk` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `file_skl` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `file_ktppelapor` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `file_bukunikah` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `file_f101` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `file_f106` varchar(255) DEFAULT NULL,
  `file_f103` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `file_f201` varbinary(255) DEFAULT NULL,
  `id_desa` varchar(50) NOT NULL,
  `create_date` date NOT NULL,
  `create_time` varchar(20) NOT NULL,
  `id_dusun` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `file_kkbaru` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `file_aktalahirbaru` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `file_kiabaru` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `update_time` datetime NOT NULL,
  `alasan_penolakan` text NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `status_baca` int(11) DEFAULT 0,
  `alasan_permohonan` text DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_uca1400_ai_ci;

--
-- Dumping data for table `paket_a`
--

INSERT INTO `paket_a` (`id_paket`, `id_pemohon`, `no_registrasi_pemohon`, `nama_pemohon`, `no_wa_pemohon`, `nama`, `nik`, `no_kk`, `file_ktpsaksi`, `file_kk`, `file_skl`, `file_ktppelapor`, `file_bukunikah`, `file_f101`, `file_f106`, `file_f103`, `file_f201`, `id_desa`, `create_date`, `create_time`, `id_dusun`, `status`, `file_kkbaru`, `file_aktalahirbaru`, `file_kiabaru`, `update_time`, `alasan_penolakan`, `username`, `status_baca`, `alasan_permohonan`, `alamat`) VALUES
('721211003_20250501191133_6f6b7582-88f9-45eb-b394-62ab3a30ac5f', '', 'REG-A-2025-000001', 'Samudra', '082333265888', 'Samudra', '1234567812345678', '1234567812345678', 'paket_a_ktpsaksi_721211003_20250501191133_6f6b7582-88f9-45eb-b394-62ab3a30ac5f_1746103693.png', 'paket_a_kk_721211003_20250501191133_6f6b7582-88f9-45eb-b394-62ab3a30ac5f_1746101285.pdf', 'paket_a_skl_721211003_20250501191133_6f6b7582-88f9-45eb-b394-62ab3a30ac5f_1746103688.png', 'paket_a_ktppelapor_721211003_20250501191133_6f6b7582-88f9-45eb-b394-62ab3a30ac5f_1746103690.png', 'paket_a_bukunikah_721211003_20250501191133_6f6b7582-88f9-45eb-b394-62ab3a30ac5f_1746103698.png', 'paket_a_f101_721211003_20250501191133_6f6b7582-88f9-45eb-b394-62ab3a30ac5f_1746103700.pdf', 'paket_a_f106_721211003_20250501191133_6f6b7582-88f9-45eb-b394-62ab3a30ac5f_1746103704.pdf', 'paket_a_f103_721211003_20250501191133_6f6b7582-88f9-45eb-b394-62ab3a30ac5f_1746103709.pdf', 0x70616b65745f615f663230315f3732313231313030335f32303235303530313139313133335f36663662373538322d383866392d343565622d623339342d3632616233613330616335665f313734363130333730322e706e67, '72_12_1_1003', '2025-05-01', '19:11:33', 71, 3, 'paket_a_kkbaru_721211003_20250501191133_6f6b7582-88f9-45eb-b394-62ab3a30ac5f_1746104570.png', 'paket_a_aktalahirbaru_721211003_20250501191133_6f6b7582-88f9-45eb-b394-62ab3a30ac5f_1746104573.pdf', 'paket_a_kiabaru_721211003_20250501191133_6f6b7582-88f9-45eb-b394-62ab3a30ac5f_1746104575.png', '2025-05-01 21:03:08', '', 'BAHOUE', 1, 'Urus semua itu', 'Jalan Bunga Mawar, RT.001/RW.002'),
('721272007_20250508161554_580bbd94-95dc-4274-b935-1bcce213bb47', '', 'REG-A-2025-000001', 'Jumiati', '098344333444', 'Jumiati', '1234567812345678', '1234567812345678', 'paket_a_ktpsaksi_721272007_20250508161554_580bbd94-95dc-4274-b935-1bcce213bb47_1746706461.pdf', 'paket_a_kk_721272007_20250508161554_580bbd94-95dc-4274-b935-1bcce213bb47_1746706447.pdf', 'paket_a_skl_721272007_20250508161554_580bbd94-95dc-4274-b935-1bcce213bb47_1746706444.pdf', 'paket_a_ktppelapor_721272007_20250508161554_580bbd94-95dc-4274-b935-1bcce213bb47_1746817705.pdf', 'paket_a_bukunikah_721272007_20250508161554_580bbd94-95dc-4274-b935-1bcce213bb47_1746706465.pdf', 'paket_a_f101_721272007_20250508161554_580bbd94-95dc-4274-b935-1bcce213bb47_1746816647.pdf', 'paket_a_f106_721272007_20250508161554_580bbd94-95dc-4274-b935-1bcce213bb47_1746706473.pdf', 'paket_a_f103_721272007_20250508161554_580bbd94-95dc-4274-b935-1bcce213bb47_1746893684.pdf', 0x70616b65745f615f663230315f3732313237323030375f32303235303530383136313535345f35383062626439342d393564632d343237342d623933352d3162636365323133626234375f313734363839333638382e706466, '72_12_7_2007', '2025-05-08', '16:15:54', 75, 2, '', '', '', '2025-05-11 00:23:02', 'sda', 'BAU', 1, 'Harap jelaskan sendiri', 'Jalan Rusa'),
('721272007_20250511210422_394346fb-20fd-49e2-a28a-205adfb43cc8', 'FKP3WP4A', 'REG-A-2025-000002', 'Baso Irwan Sakti', '082333265888', 'Baso Irwan Sakti', '1234567812345678', '1234567812345678', 'paket_a_ktpsaksi_721272007_20250511210422_394346fb-20fd-49e2-a28a-205adfb43cc8_1746978712.pdf', 'paket_a_kk_721272007_20250511210422_394346fb-20fd-49e2-a28a-205adfb43cc8_1746978706.pdf', 'paket_a_skl_721272007_20250511210422_394346fb-20fd-49e2-a28a-205adfb43cc8_1746978710.pdf', 'paket_a_ktppelapor_721272007_20250511210422_394346fb-20fd-49e2-a28a-205adfb43cc8_1746978708.pdf', 'paket_a_bukunikah_721272007_20250511210422_394346fb-20fd-49e2-a28a-205adfb43cc8_1746978717.pdf', 'paket_a_f101_721272007_20250511210422_394346fb-20fd-49e2-a28a-205adfb43cc8_1746978719.pdf', NULL, NULL, 0x70616b65745f615f663230315f3732313237323030375f32303235303531313231303432325f33393433343666622d323066642d343965322d613238612d3230356164666234336363385f313734363937383731352e706466, '72_12_7_2007', '2025-05-11', '21:04:22', 78, 3, 'paket_a_kkbaru_721272007_20250511210422_394346fb-20fd-49e2-a28a-205adfb43cc8_1746980929.png', 'paket_a_aktalahirbaru_721272007_20250511210422_394346fb-20fd-49e2-a28a-205adfb43cc8_1746980927.png', '', '2025-05-12 01:17:06', '', 'BAU', 1, 'Apa yag', 'jalan jalan'),
('721282016_20250509220447_9410faf2-de82-4c12-8f7f-7f0079bbd912', '', 'REG-A-2025-000001', 'Nigatulah', '082333276222', 'Nigatu', '1234567812345678', '1234567812345678', '', '', '', '', '', NULL, NULL, NULL, NULL, '72_12_8_2016', '2025-05-09', '22:04:47', 33, 1, '', '', '', '2025-05-09 23:11:04', '', 'BOBA', 0, 'adsad', 'jLan');

-- --------------------------------------------------------

--
-- Table structure for table `paket_b`
--

CREATE TABLE `paket_b` (
  `id_paket` varchar(100) NOT NULL,
  `id_pemohon` char(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `nik` varchar(255) DEFAULT NULL,
  `no_kk` varchar(255) DEFAULT NULL,
  `no_registrasi_pemohon` varchar(255) DEFAULT NULL,
  `nama_pemohon` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `no_wa_pemohon` varchar(255) DEFAULT NULL,
  `id_desa` varchar(50) NOT NULL,
  `create_date` date NOT NULL,
  `create_time` varchar(20) NOT NULL,
  `username` varchar(100) NOT NULL,
  `id_dusun` int(11) NOT NULL,
  `update_time` datetime NOT NULL,
  `status` int(11) DEFAULT 0,
  `alasan_penolakan` text DEFAULT NULL,
  `status_baca` int(11) DEFAULT 0,
  `alasan_permohonan` text DEFAULT NULL,
  `file_kkbaru` varchar(255) DEFAULT NULL,
  `file_aktamatibaru` varchar(255) DEFAULT NULL,
  `file_laindukcapil` varchar(255) DEFAULT NULL,
  `file_kk` varchar(255) DEFAULT NULL,
  `file_mati` varchar(255) DEFAULT NULL,
  `file_ktppelapor` varchar(255) DEFAULT NULL,
  `file_ktpsaksi` varchar(255) DEFAULT NULL,
  `file_f101` varchar(255) DEFAULT NULL,
  `file_f201` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `paket_b`
--

INSERT INTO `paket_b` (`id_paket`, `id_pemohon`, `nama`, `nik`, `no_kk`, `no_registrasi_pemohon`, `nama_pemohon`, `no_wa_pemohon`, `id_desa`, `create_date`, `create_time`, `username`, `id_dusun`, `update_time`, `status`, `alasan_penolakan`, `status_baca`, `alasan_permohonan`, `file_kkbaru`, `file_aktamatibaru`, `file_laindukcapil`, `file_kk`, `file_mati`, `file_ktppelapor`, `file_ktpsaksi`, `file_f101`, `file_f201`, `alamat`) VALUES
('721211003_20250502000526_9298f5ce-7dc7-417e-b9f9-ba5cb2665936', '', 'Yudi', '1234567812345678', '1234567812345678', 'REG-B-2025-000001', 'Yudi', '082333265888', '72_12_1_1003', '2025-05-02', '00:05:26', 'BAHOUE', 71, '2025-05-02 00:35:03', 3, '', 1, 'Matilah\r\n', 'paket_b_kkbaru_721211003_20250502000526_9298f5ce-7dc7-417e-b9f9-ba5cb2665936_1746117258.pdf', 'paket_b_aktamatibaru_721211003_20250502000526_9298f5ce-7dc7-417e-b9f9-ba5cb2665936_1746117251.pdf', 'paket_b_laindukcapil_721211003_20250502000526_9298f5ce-7dc7-417e-b9f9-ba5cb2665936_1746117254.pdf', 'paket_b_kk_721211003_20250502000526_9298f5ce-7dc7-417e-b9f9-ba5cb2665936_1746115558.pdf', 'paket_b_mati_721211003_20250502000526_9298f5ce-7dc7-417e-b9f9-ba5cb2665936_1746117233.pdf', 'paket_b_ktppelapor_721211003_20250502000526_9298f5ce-7dc7-417e-b9f9-ba5cb2665936_1746115563.png', 'paket_b_ktpsaksi_721211003_20250502000526_9298f5ce-7dc7-417e-b9f9-ba5cb2665936_1746117182.pdf', 'paket_b_f101_721211003_20250502000526_9298f5ce-7dc7-417e-b9f9-ba5cb2665936_1746115571.png', 'paket_b_f201_721211003_20250502000526_9298f5ce-7dc7-417e-b9f9-ba5cb2665936_1746117170.pdf', '1234567812345678');

-- --------------------------------------------------------

--
-- Table structure for table `paket_c`
--

CREATE TABLE `paket_c` (
  `id_paket` varchar(100) NOT NULL,
  `id_pemohon` char(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `nik` varchar(255) DEFAULT NULL,
  `no_kk` varchar(255) DEFAULT NULL,
  `no_registrasi_pemohon` varchar(255) DEFAULT NULL,
  `nama_pemohon` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `no_wa_pemohon` varchar(255) DEFAULT NULL,
  `id_desa` varchar(50) NOT NULL,
  `create_date` date NOT NULL,
  `create_time` varchar(20) NOT NULL,
  `username` varchar(100) NOT NULL,
  `id_dusun` int(11) NOT NULL,
  `update_time` datetime NOT NULL,
  `status` int(11) DEFAULT 0,
  `alasan_penolakan` text DEFAULT NULL,
  `status_baca` int(11) DEFAULT 0,
  `alasan_permohonan` text DEFAULT NULL,
  `file_kkkhilang` varchar(255) DEFAULT NULL,
  `file_ktpkhilang` varchar(255) DEFAULT NULL,
  `file_suratpindahwni` varchar(255) DEFAULT NULL,
  `file_formulirpindahf103` varchar(255) DEFAULT NULL,
  `file_biodataf101` varchar(255) DEFAULT NULL,
  `file_suratpernyataanf106` varchar(255) DEFAULT NULL,
  `file_bukunikahcerai` varchar(255) DEFAULT NULL,
  `file_suratalamatpendatang` varchar(255) DEFAULT NULL,
  `file_suratpendatangalamatrumah` varchar(255) DEFAULT NULL,
  `file_suratpendatangnumpangkk` varchar(255) DEFAULT NULL,
  `file_kkbaru` varchar(255) DEFAULT NULL,
  `file_laindukca` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `paket_d`
--

CREATE TABLE `paket_d` (
  `id_paket` varchar(100) NOT NULL,
  `id_pemohon` char(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `nik` varchar(255) DEFAULT NULL,
  `no_kk` varchar(255) DEFAULT NULL,
  `no_registrasi_pemohon` varchar(255) DEFAULT NULL,
  `nama_pemohon` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `no_wa_pemohon` varchar(255) DEFAULT NULL,
  `id_desa` varchar(50) NOT NULL,
  `create_date` date NOT NULL,
  `create_time` varchar(20) NOT NULL,
  `username` varchar(100) NOT NULL,
  `id_dusun` int(11) NOT NULL,
  `update_time` datetime NOT NULL,
  `status` int(11) DEFAULT 0,
  `alasan_penolakan` text DEFAULT NULL,
  `status_baca` int(11) DEFAULT 0,
  `alasan_permohonan` text DEFAULT NULL,
  `file_kartukeluarga` varchar(255) DEFAULT NULL,
  `file_aktalahir` varchar(255) DEFAULT NULL,
  `file_ijazah` varchar(255) DEFAULT NULL,
  `file_bukunikah` varchar(255) DEFAULT NULL,
  `file_aktakematian` varchar(255) DEFAULT NULL,
  `file_formf106` varchar(255) DEFAULT NULL,
  `file_formf101` varchar(255) DEFAULT NULL,
  `file_kkbaru` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `paket_e`
--

CREATE TABLE `paket_e` (
  `id_paket` varchar(100) NOT NULL,
  `id_pemohon` char(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `nik` varchar(255) DEFAULT NULL,
  `no_kk` varchar(255) DEFAULT NULL,
  `no_registrasi_pemohon` varchar(255) DEFAULT NULL,
  `nama_pemohon` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `no_wa_pemohon` varchar(255) DEFAULT NULL,
  `id_desa` varchar(50) NOT NULL,
  `create_date` date NOT NULL,
  `create_time` varchar(20) NOT NULL,
  `username` varchar(100) NOT NULL,
  `id_dusun` int(11) NOT NULL,
  `update_time` datetime NOT NULL,
  `status` int(11) DEFAULT 0,
  `alasan_penolakan` text DEFAULT NULL,
  `status_baca` int(11) DEFAULT 0,
  `alasan_permohonan` text DEFAULT NULL,
  `file_aktakelahiran` varchar(255) DEFAULT NULL,
  `file_kartukeluarga` varchar(255) DEFAULT NULL,
  `file_pasfoto3x4` varchar(255) DEFAULT NULL,
  `file_kianya` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `paket_e`
--

INSERT INTO `paket_e` (`id_paket`, `id_pemohon`, `nama`, `nik`, `no_kk`, `no_registrasi_pemohon`, `nama_pemohon`, `no_wa_pemohon`, `id_desa`, `create_date`, `create_time`, `username`, `id_dusun`, `update_time`, `status`, `alasan_penolakan`, `status_baca`, `alasan_permohonan`, `file_aktakelahiran`, `file_kartukeluarga`, `file_pasfoto3x4`, `file_kianya`, `alamat`) VALUES
('721211002_20250505223109_acaea152-ccd8-48ea-b6a4-727061b6c943', '', 'Nunung', '1234567812345678', '1234567812345678', 'REG-E-2025-000001', 'Nunung', '082333265888', '72_12_1_1002', '2025-05-05', '22:31:09', 'BAHONTULA', 77, '2025-05-05 22:42:30', 2, NULL, 1, 'dsaad', 'paket_e_aktakelahiran_721211002_20250505223109_acaea152-ccd8-48ea-b6a4-727061b6c943_1746456145.pdf', 'paket_e_kartukeluarga_721211002_20250505223109_acaea152-ccd8-48ea-b6a4-727061b6c943_1746456147.pdf', 'paket_e_pasfoto3x4_721211002_20250505223109_acaea152-ccd8-48ea-b6a4-727061b6c943_1746456149.pdf', NULL, 'Jalan Cempaka');

-- --------------------------------------------------------

--
-- Table structure for table `paket_f`
--

CREATE TABLE `paket_f` (
  `id_paket` varchar(100) NOT NULL,
  `id_pemohon` char(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `nik` varchar(255) DEFAULT NULL,
  `no_kk` varchar(255) DEFAULT NULL,
  `no_registrasi_pemohon` varchar(255) DEFAULT NULL,
  `nama_pemohon` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `no_wa_pemohon` varchar(255) DEFAULT NULL,
  `id_desa` varchar(50) NOT NULL,
  `create_date` date NOT NULL,
  `create_time` varchar(20) NOT NULL,
  `username` varchar(100) NOT NULL,
  `id_dusun` int(11) NOT NULL,
  `update_time` datetime NOT NULL,
  `status` int(11) DEFAULT 0,
  `alasan_penolakan` text DEFAULT NULL,
  `status_baca` int(11) DEFAULT 0,
  `alasan_permohonan` text DEFAULT NULL,
  `file_kk` varchar(255) DEFAULT NULL,
  `file_ktp` varchar(255) DEFAULT NULL,
  `file_sktt` varchar(255) DEFAULT NULL,
  `file_f103` varchar(255) DEFAULT NULL,
  `file_f101` varchar(255) DEFAULT NULL,
  `file_f106` varchar(255) DEFAULT NULL,
  `file_pernyataan_alamat_dipakai` varchar(255) DEFAULT NULL,
  `file_pernyataan_rumah_sendiri` varchar(255) DEFAULT NULL,
  `file_pernyataan_numpang_kk` varchar(255) DEFAULT NULL,
  `file_skpwni` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `paket_g`
--

CREATE TABLE `paket_g` (
  `id_paket` varchar(100) NOT NULL,
  `id_pemohon` char(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `nik` varchar(255) DEFAULT NULL,
  `no_kk` varchar(255) DEFAULT NULL,
  `no_registrasi_pemohon` varchar(255) DEFAULT NULL,
  `nama_pemohon` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `no_wa_pemohon` varchar(255) DEFAULT NULL,
  `id_desa` varchar(50) NOT NULL,
  `create_date` date NOT NULL,
  `create_time` varchar(20) NOT NULL,
  `username` varchar(100) NOT NULL,
  `id_dusun` int(11) NOT NULL,
  `update_time` datetime NOT NULL,
  `status` int(11) DEFAULT 0,
  `alasan_penolakan` text DEFAULT NULL,
  `status_baca` int(11) DEFAULT 0,
  `alasan_permohonan` text DEFAULT NULL,
  `file_f0107` varchar(255) DEFAULT NULL,
  `file_f0207` varchar(255) DEFAULT NULL,
  `file_f0307` varchar(255) DEFAULT NULL,
  `file_f0407` varchar(255) DEFAULT NULL,
  `file_f0507` varchar(255) DEFAULT NULL,
  `file_f0607` varchar(255) DEFAULT NULL,
  `file_f0707` varchar(255) DEFAULT NULL,
  `file_f0807` varchar(255) DEFAULT NULL,
  `file_f0907` varchar(255) DEFAULT NULL,
  `file_f1007` varchar(255) DEFAULT NULL,
  `file_f1107` varchar(255) DEFAULT NULL,
  `file_skpd` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `paket_h`
--

CREATE TABLE `paket_h` (
  `id_paket` varchar(100) NOT NULL,
  `id_pemohon` char(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `nik` varchar(255) DEFAULT NULL,
  `no_kk` varchar(255) DEFAULT NULL,
  `no_registrasi_pemohon` varchar(255) DEFAULT NULL,
  `nama_pemohon` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `no_wa_pemohon` varchar(255) DEFAULT NULL,
  `id_desa` varchar(50) NOT NULL,
  `create_date` date NOT NULL,
  `create_time` varchar(20) NOT NULL,
  `username` varchar(100) NOT NULL,
  `id_dusun` int(11) NOT NULL,
  `update_time` datetime NOT NULL,
  `status` int(11) DEFAULT 0,
  `alasan_penolakan` text DEFAULT NULL,
  `status_baca` int(11) DEFAULT 0,
  `alasan_permohonan` text DEFAULT NULL,
  `file_suratpengantarsponsor` varchar(255) DEFAULT NULL,
  `file_formulirbiodatawna` varchar(255) DEFAULT NULL,
  `file_formulirpindahf103` varchar(255) DEFAULT NULL,
  `file_paspor` varchar(255) DEFAULT NULL,
  `file_kitasataukitap` varchar(255) DEFAULT NULL,
  `file_perkawinancampuran` varchar(255) DEFAULT NULL,
  `file_kartukeluargawnakitap` varchar(255) DEFAULT NULL,
  `file_sktlkesbangpol` varchar(255) DEFAULT NULL,
  `file_skttl` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `paket_i`
--

CREATE TABLE `paket_i` (
  `id_paket` varchar(100) NOT NULL,
  `id_pemohon` char(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `nik` varchar(255) DEFAULT NULL,
  `no_kk` varchar(255) DEFAULT NULL,
  `no_registrasi_pemohon` varchar(255) DEFAULT NULL,
  `nama_pemohon` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `no_wa_pemohon` varchar(255) DEFAULT NULL,
  `id_desa` varchar(50) NOT NULL,
  `create_date` date NOT NULL,
  `create_time` varchar(20) NOT NULL,
  `username` varchar(100) NOT NULL,
  `id_dusun` int(11) NOT NULL,
  `update_time` datetime NOT NULL,
  `status` int(11) DEFAULT 0,
  `alasan_penolakan` text DEFAULT NULL,
  `status_baca` int(11) DEFAULT 0,
  `alasan_permohonan` text DEFAULT NULL,
  `file_bukunikahsptjm` varchar(255) DEFAULT NULL,
  `file_suratlahirsptjm` varchar(255) DEFAULT NULL,
  `file_ktppelapor` varchar(255) DEFAULT NULL,
  `file_ktpsaksi` varchar(255) DEFAULT NULL,
  `file_kkkehilangan` varchar(255) DEFAULT NULL,
  `file_formulirf201` varchar(255) DEFAULT NULL,
  `file_aktalahir` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `paket_i`
--

INSERT INTO `paket_i` (`id_paket`, `id_pemohon`, `nama`, `nik`, `no_kk`, `no_registrasi_pemohon`, `nama_pemohon`, `no_wa_pemohon`, `id_desa`, `create_date`, `create_time`, `username`, `id_dusun`, `update_time`, `status`, `alasan_penolakan`, `status_baca`, `alasan_permohonan`, `file_bukunikahsptjm`, `file_suratlahirsptjm`, `file_ktppelapor`, `file_ktpsaksi`, `file_kkkehilangan`, `file_formulirf201`, `file_aktalahir`, `alamat`) VALUES
('721242001_20250509014246_5f65b85d-fa13-40f7-8d30-11a44f02d3d8', '', 'Jsnsns', '1234567812345678', '1234567812345678', 'REG-I-2025-000001', 'Jsnsns', '0823332228', '72_12_4_2001', '2025-05-09', '01:42:46', 'BETELEME', 79, '2025-05-09 01:52:11', 4, 'asd', 0, 'Bahahah', 'paket_i_bukunikahsptjm_721242001_20250509014246_5f65b85d-fa13-40f7-8d30-11a44f02d3d8_1746726205.jpg', 'paket_i_suratlahirsptjm_721242001_20250509014246_5f65b85d-fa13-40f7-8d30-11a44f02d3d8_1746726228.pdf', 'paket_i_ktppelapor_721242001_20250509014246_5f65b85d-fa13-40f7-8d30-11a44f02d3d8_1746726252.PDF', 'paket_i_ktpsaksi_721242001_20250509014246_5f65b85d-fa13-40f7-8d30-11a44f02d3d8_1746726273.jpg', 'paket_i_kkkehilangan_721242001_20250509014246_5f65b85d-fa13-40f7-8d30-11a44f02d3d8_1746726292.jpg', 'paket_i_formulirf201_721242001_20250509014246_5f65b85d-fa13-40f7-8d30-11a44f02d3d8_1746726299.jpg', NULL, 'Hsjaja'),
('721272007_20250504205315_d64fb5fa-9c4c-42fb-b360-8505986ad268', '', 'Tika', '1234567812345678', '1234567812345678', 'REG-I-2025-000001', 'Tika', '082333265888', '72_12_7_2007', '2025-05-04', '20:53:15', 'BAU', 73, '2025-05-04 20:56:04', 3, '', 1, 'asdad', 'paket_i_bukunikahsptjm_721272007_20250504205315_d64fb5fa-9c4c-42fb-b360-8505986ad268_1746363238.jpg', 'paket_i_suratlahirsptjm_721272007_20250504205315_d64fb5fa-9c4c-42fb-b360-8505986ad268_1746363235.jpg', 'paket_i_ktppelapor_721272007_20250504205315_d64fb5fa-9c4c-42fb-b360-8505986ad268_1746363242.pdf', 'paket_i_ktpsaksi_721272007_20250504205315_d64fb5fa-9c4c-42fb-b360-8505986ad268_1746363256.pdf', 'paket_i_kkkehilangan_721272007_20250504205315_d64fb5fa-9c4c-42fb-b360-8505986ad268_1746363269.png', 'paket_i_formulirf201_721272007_20250504205315_d64fb5fa-9c4c-42fb-b360-8505986ad268_1746363271.jpg', 'paket_i_aktalahir_721272007_20250504205315_d64fb5fa-9c4c-42fb-b360-8505986ad268_1746363363.jpg', 'Atakkae'),
('721272007_20250511020405_ce57bb33-ff8b-4b8d-b831-588d4dda2c75', 'KAH0IOH4', 'Irwan', '1234567812345678', '1234567812345678', 'REG-I-2025-000002', 'Irwan', '082333456777', '72_12_7_2007', '2025-05-11', '02:04:05', 'BAU', 75, '2025-05-11 02:04:48', 2, NULL, 1, 'asdasd', 'paket_i_bukunikahsptjm_721272007_20250511020405_ce57bb33-ff8b-4b8d-b831-588d4dda2c75_1746900266.pdf', 'paket_i_suratlahirsptjm_721272007_20250511020405_ce57bb33-ff8b-4b8d-b831-588d4dda2c75_1746900268.pdf', 'paket_i_ktppelapor_721272007_20250511020405_ce57bb33-ff8b-4b8d-b831-588d4dda2c75_1746900275.pdf', 'paket_i_ktpsaksi_721272007_20250511020405_ce57bb33-ff8b-4b8d-b831-588d4dda2c75_1746900279.pdf', 'paket_i_kkkehilangan_721272007_20250511020405_ce57bb33-ff8b-4b8d-b831-588d4dda2c75_1746900286.pdf', 'paket_i_formulirf201_721272007_20250511020405_ce57bb33-ff8b-4b8d-b831-588d4dda2c75_1746900283.pdf', NULL, 'Jalan PA ayah');

-- --------------------------------------------------------

--
-- Table structure for table `paket_j`
--

CREATE TABLE `paket_j` (
  `id_paket` varchar(100) NOT NULL,
  `id_pemohon` char(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `nik` varchar(255) DEFAULT NULL,
  `no_kk` varchar(255) DEFAULT NULL,
  `no_registrasi_pemohon` varchar(255) DEFAULT NULL,
  `nama_pemohon` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `no_wa_pemohon` varchar(255) DEFAULT NULL,
  `id_desa` varchar(50) NOT NULL,
  `create_date` date NOT NULL,
  `create_time` varchar(20) NOT NULL,
  `username` varchar(100) NOT NULL,
  `id_dusun` int(11) NOT NULL,
  `update_time` datetime NOT NULL,
  `status` int(11) DEFAULT 0,
  `alasan_penolakan` text DEFAULT NULL,
  `status_baca` int(11) DEFAULT 0,
  `alasan_permohonan` text DEFAULT NULL,
  `file_suratkematiandokterrsdesakelurahanrtrw` varchar(255) DEFAULT NULL,
  `file_ktppelapor` varchar(255) DEFAULT NULL,
  `file_ktpsaksi` varchar(255) DEFAULT NULL,
  `file_kkkehilangan` varchar(255) DEFAULT NULL,
  `file_formulirf201` varchar(255) DEFAULT NULL,
  `file_sptjmkematian` varchar(255) DEFAULT NULL,
  `file_aktamati` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `paket_k`
--

CREATE TABLE `paket_k` (
  `id_paket` varchar(100) NOT NULL,
  `id_pemohon` char(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `nik` varchar(255) DEFAULT NULL,
  `no_kk` varchar(255) DEFAULT NULL,
  `no_registrasi_pemohon` varchar(255) DEFAULT NULL,
  `nama_pemohon` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `no_wa_pemohon` varchar(255) DEFAULT NULL,
  `id_desa` varchar(50) NOT NULL,
  `create_date` date NOT NULL,
  `create_time` varchar(20) NOT NULL,
  `username` varchar(100) NOT NULL,
  `id_dusun` int(11) NOT NULL,
  `update_time` datetime NOT NULL,
  `status` int(11) DEFAULT 0,
  `alasan_penolakan` text DEFAULT NULL,
  `status_baca` int(11) DEFAULT 0,
  `alasan_permohonan` text DEFAULT NULL,
  `file_kkkehilangan` varchar(255) DEFAULT NULL,
  `file_ktppelapor` varchar(255) DEFAULT NULL,
  `file_ktpsaksi` varchar(255) DEFAULT NULL,
  `file_suratnikahortu` varchar(255) DEFAULT NULL,
  `file_aktalahirasaliralat` varchar(255) DEFAULT NULL,
  `file_kehilanganaktatidakbarcode` varchar(255) DEFAULT NULL,
  `file_formralatakta` varchar(255) DEFAULT NULL,
  `file_ralatlahir` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `paket_l`
--

CREATE TABLE `paket_l` (
  `id_paket` varchar(100) NOT NULL,
  `id_pemohon` char(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `nik` varchar(255) DEFAULT NULL,
  `no_kk` varchar(255) DEFAULT NULL,
  `no_registrasi_pemohon` varchar(255) DEFAULT NULL,
  `nama_pemohon` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `no_wa_pemohon` varchar(255) DEFAULT NULL,
  `id_desa` varchar(50) NOT NULL,
  `create_date` date NOT NULL,
  `create_time` varchar(20) NOT NULL,
  `username` varchar(100) NOT NULL,
  `id_dusun` int(11) NOT NULL,
  `update_time` datetime NOT NULL,
  `status` int(11) DEFAULT 0,
  `alasan_penolakan` text DEFAULT NULL,
  `status_baca` int(11) DEFAULT 0,
  `alasan_permohonan` text DEFAULT NULL,
  `file_ktpelpelapor` varchar(255) DEFAULT NULL,
  `file_suratkehilanganpolisi` varchar(255) DEFAULT NULL,
  `file_ktpelsaksi` varchar(255) DEFAULT NULL,
  `file_formduplikataktakematian` varchar(255) DEFAULT NULL,
  `file_ralatmati` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `paket_m`
--

CREATE TABLE `paket_m` (
  `id_paket` varchar(100) NOT NULL,
  `id_pemohon` char(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `nik` varchar(255) DEFAULT NULL,
  `no_kk` varchar(255) DEFAULT NULL,
  `no_registrasi_pemohon` varchar(255) DEFAULT NULL,
  `nama_pemohon` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `no_wa_pemohon` varchar(255) DEFAULT NULL,
  `id_desa` varchar(50) NOT NULL,
  `create_date` date NOT NULL,
  `create_time` varchar(20) NOT NULL,
  `username` varchar(100) NOT NULL,
  `id_dusun` int(11) NOT NULL,
  `update_time` datetime NOT NULL,
  `status` int(11) DEFAULT 0,
  `alasan_penolakan` text DEFAULT NULL,
  `status_baca` int(11) DEFAULT 0,
  `alasan_permohonan` text DEFAULT NULL,
  `file_suratnikahlegalisir` varchar(255) DEFAULT NULL,
  `file_kkcalonpengantin` varchar(255) DEFAULT NULL,
  `file_aktalahircalonpengantin` varchar(255) DEFAULT NULL,
  `file_ktpcalonpengantin` varchar(255) DEFAULT NULL,
  `file_ktpsaksi` varchar(255) DEFAULT NULL,
  `file_pasfotobersama` varchar(255) DEFAULT NULL,
  `file_suratbaptissidhi` varchar(255) DEFAULT NULL,
  `file_aktaceraiataukematian` varchar(255) DEFAULT NULL,
  `file_suratizinkesatuan` varchar(255) DEFAULT NULL,
  `file_formulirf201` varchar(255) DEFAULT NULL,
  `file_aktakawin` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `paket_n`
--

CREATE TABLE `paket_n` (
  `id_paket` varchar(100) NOT NULL,
  `id_pemohon` char(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `nik` varchar(255) DEFAULT NULL,
  `no_kk` varchar(255) DEFAULT NULL,
  `no_registrasi_pemohon` varchar(255) DEFAULT NULL,
  `nama_pemohon` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `no_wa_pemohon` varchar(255) DEFAULT NULL,
  `id_desa` varchar(50) NOT NULL,
  `create_date` date NOT NULL,
  `create_time` varchar(20) NOT NULL,
  `username` varchar(100) NOT NULL,
  `id_dusun` int(11) NOT NULL,
  `update_time` datetime NOT NULL,
  `status` int(11) DEFAULT 0,
  `alasan_penolakan` text DEFAULT NULL,
  `status_baca` int(11) DEFAULT 0,
  `alasan_permohonan` text DEFAULT NULL,
  `file_suratpengantardesa` varchar(255) DEFAULT NULL,
  `file_kartukeluargakehilangan` varchar(255) DEFAULT NULL,
  `file_ktpel` varchar(255) DEFAULT NULL,
  `file_keteranganperkawinanasing` varchar(255) DEFAULT NULL,
  `file_suratketeranganri` varchar(255) DEFAULT NULL,
  `file_buktipencatatansetempat` varchar(255) DEFAULT NULL,
  `file_formulf201` varchar(255) DEFAULT NULL,
  `file_kawino` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `paket_o`
--

CREATE TABLE `paket_o` (
  `id_paket` varchar(100) NOT NULL,
  `id_pemohon` char(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `nik` varchar(255) DEFAULT NULL,
  `no_kk` varchar(255) DEFAULT NULL,
  `no_registrasi_pemohon` varchar(255) DEFAULT NULL,
  `nama_pemohon` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `no_wa_pemohon` varchar(255) DEFAULT NULL,
  `id_desa` varchar(50) NOT NULL,
  `create_date` date NOT NULL,
  `create_time` varchar(20) NOT NULL,
  `username` varchar(100) NOT NULL,
  `id_dusun` int(11) NOT NULL,
  `update_time` datetime NOT NULL,
  `status` int(11) DEFAULT 0,
  `alasan_penolakan` text DEFAULT NULL,
  `status_baca` int(11) DEFAULT 0,
  `alasan_permohonan` text DEFAULT NULL,
  `file_ktppelapor` varchar(255) DEFAULT NULL,
  `file_kartukeluargakehilangan` varchar(255) DEFAULT NULL,
  `file_ktpbersangkutan` varchar(255) DEFAULT NULL,
  `file_aktaperkawinan` varchar(255) DEFAULT NULL,
  `file_putusanpengadilan` varchar(255) DEFAULT NULL,
  `file_suratpanitera` varchar(255) DEFAULT NULL,
  `file_formulf201` varchar(255) DEFAULT NULL,
  `file_aktacerai` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `paket_p`
--

CREATE TABLE `paket_p` (
  `id_paket` varchar(100) NOT NULL,
  `id_pemohon` char(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `nik` varchar(255) DEFAULT NULL,
  `no_kk` varchar(255) DEFAULT NULL,
  `no_registrasi_pemohon` varchar(255) DEFAULT NULL,
  `nama_pemohon` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `no_wa_pemohon` varchar(255) DEFAULT NULL,
  `id_desa` varchar(50) NOT NULL,
  `create_date` date NOT NULL,
  `create_time` varchar(20) NOT NULL,
  `username` varchar(100) NOT NULL,
  `id_dusun` int(11) NOT NULL,
  `update_time` datetime NOT NULL,
  `status` int(11) DEFAULT 0,
  `alasan_penolakan` text DEFAULT NULL,
  `status_baca` int(11) DEFAULT 0,
  `alasan_permohonan` text DEFAULT NULL,
  `file_aktalahrursuratlahirfromdesakelurahan` varchar(255) DEFAULT NULL,
  `file_ijazahterakhir` varchar(255) DEFAULT NULL,
  `file_bukunikahaktakawinaktacerei` varchar(255) DEFAULT NULL,
  `file_aktakematianrursuratkematiandaridesakelurahan` varchar(255) DEFAULT NULL,
  `file_suratpernyataantidakmemilikidokumenkependudukan` varchar(255) DEFAULT NULL,
  `file_formulirf101` varchar(255) DEFAULT NULL,
  `file_kkbaru` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `paket_q`
--

CREATE TABLE `paket_q` (
  `id_paket` varchar(100) NOT NULL,
  `id_pemohon` char(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `nik` varchar(255) DEFAULT NULL,
  `no_kk` varchar(255) DEFAULT NULL,
  `no_registrasi_pemohon` varchar(255) DEFAULT NULL,
  `nama_pemohon` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `no_wa_pemohon` varchar(255) DEFAULT NULL,
  `id_desa` varchar(50) NOT NULL,
  `create_date` date NOT NULL,
  `create_time` varchar(20) NOT NULL,
  `username` varchar(100) NOT NULL,
  `id_dusun` int(11) NOT NULL,
  `update_time` datetime NOT NULL,
  `status` int(11) DEFAULT 0,
  `alasan_penolakan` text DEFAULT NULL,
  `status_baca` int(11) DEFAULT 0,
  `alasan_permohonan` text DEFAULT NULL,
  `file_kkbaru` varchar(255) DEFAULT NULL,
  `file_kkhilangrusak` varchar(255) DEFAULT NULL,
  `file_ktp` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `paket_q`
--

INSERT INTO `paket_q` (`id_paket`, `id_pemohon`, `nama`, `nik`, `no_kk`, `no_registrasi_pemohon`, `nama_pemohon`, `no_wa_pemohon`, `id_desa`, `create_date`, `create_time`, `username`, `id_dusun`, `update_time`, `status`, `alasan_penolakan`, `status_baca`, `alasan_permohonan`, `file_kkbaru`, `file_kkhilangrusak`, `file_ktp`, `alamat`) VALUES
('721252002_20250430193522_9d0b1a67-bb92-4c99-bd22-31cbe265f480', 'KAH0IOH5', 'irwan', '1234567812345678', '1234567812345678', 'REG-Q-2025-000001', 'irwan', '082333265888', '72_12_5_2002', '2025-04-30', '19:35:22', 'LONDI', 67, '2025-04-30 19:38:07', 3, '', 1, 'asd', 'paket_q_kkbaru_721252002_20250430193522_9d0b1a67-bb92-4c99-bd22-31cbe265f480_1746013085.pdf', 'paket_q_kkhilangrusak_721252002_20250430193522_9d0b1a67-bb92-4c99-bd22-31cbe265f480_1746012947.pdf', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `paket_r`
--

CREATE TABLE `paket_r` (
  `id_paket` varchar(100) NOT NULL,
  `id_pemohon` char(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `nik` varchar(255) DEFAULT NULL,
  `no_kk` varchar(255) DEFAULT NULL,
  `no_registrasi_pemohon` varchar(255) DEFAULT NULL,
  `nama_pemohon` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `no_wa_pemohon` varchar(255) DEFAULT NULL,
  `id_desa` varchar(50) NOT NULL,
  `create_date` date NOT NULL,
  `create_time` varchar(20) NOT NULL,
  `username` varchar(100) NOT NULL,
  `id_dusun` int(11) NOT NULL,
  `update_time` datetime NOT NULL,
  `status` int(11) DEFAULT 0,
  `alasan_penolakan` text DEFAULT NULL,
  `status_baca` int(11) DEFAULT 0,
  `alasan_permohonan` text DEFAULT NULL,
  `file_kkbaru` varchar(255) DEFAULT NULL,
  `file_suratpermohonan` varchar(255) DEFAULT NULL,
  `file_kartukeluarga` varchar(255) DEFAULT NULL,
  `file_ktp` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `paket_r`
--

INSERT INTO `paket_r` (`id_paket`, `id_pemohon`, `nama`, `nik`, `no_kk`, `no_registrasi_pemohon`, `nama_pemohon`, `no_wa_pemohon`, `id_desa`, `create_date`, `create_time`, `username`, `id_dusun`, `update_time`, `status`, `alasan_penolakan`, `status_baca`, `alasan_permohonan`, `file_kkbaru`, `file_suratpermohonan`, `file_kartukeluarga`, `file_ktp`, `alamat`) VALUES
('721252002_20250430232123_c1b94c2b-9ece-4681-913b-fc5a97c75500', '', 'Alrbet', '1234567812345678', '1234567812345678', 'REG-R-2025-000001', 'Alrbet', '092333222333', '72_12_5_2002', '2025-04-30', '23:21:23', 'LONDI', 53, '2025-04-30 23:22:19', 3, '', 1, 'apalah', 'paket_r_kkbaru_721252002_20250430232123_c1b94c2b-9ece-4681-913b-fc5a97c75500_1746026539.pdf', 'paket_r_suratpermohonan_721252002_20250430232123_c1b94c2b-9ece-4681-913b-fc5a97c75500_1746026497.png', 'paket_r_kartukeluarga_721252002_20250430232123_c1b94c2b-9ece-4681-913b-fc5a97c75500_1746026499.png', 'paket_r_ktp_721252002_20250430232123_c1b94c2b-9ece-4681-913b-fc5a97c75500_1746026501.pdf', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `paket_s`
--

CREATE TABLE `paket_s` (
  `id_paket` varchar(100) NOT NULL,
  `id_pemohon` char(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `nik` varchar(255) DEFAULT NULL,
  `no_kk` varchar(255) DEFAULT NULL,
  `no_registrasi_pemohon` varchar(255) DEFAULT NULL,
  `nama_pemohon` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `no_wa_pemohon` varchar(255) DEFAULT NULL,
  `id_desa` varchar(50) NOT NULL,
  `create_date` date NOT NULL,
  `create_time` varchar(20) NOT NULL,
  `username` varchar(100) NOT NULL,
  `id_dusun` int(11) NOT NULL,
  `update_time` datetime NOT NULL,
  `status` int(11) DEFAULT 0,
  `alasan_penolakan` text DEFAULT NULL,
  `status_baca` int(11) DEFAULT 0,
  `alasan_permohonan` text DEFAULT NULL,
  `file_kkbaru` varchar(255) DEFAULT NULL,
  `file_kartukeluarga` varchar(255) DEFAULT NULL,
  `file_f169` varchar(255) DEFAULT NULL,
  `file_f171` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `paket_t`
--

CREATE TABLE `paket_t` (
  `id_paket` varchar(100) NOT NULL,
  `id_pemohon` char(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `nik` varchar(255) DEFAULT NULL,
  `no_kk` varchar(255) DEFAULT NULL,
  `no_registrasi_pemohon` varchar(255) DEFAULT NULL,
  `nama_pemohon` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `no_wa_pemohon` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `id_desa` varchar(50) NOT NULL,
  `create_date` date NOT NULL,
  `create_time` varchar(20) NOT NULL,
  `username` varchar(100) NOT NULL,
  `id_dusun` int(11) NOT NULL,
  `update_time` datetime NOT NULL,
  `status` int(11) DEFAULT 0,
  `alasan_penolakan` text DEFAULT NULL,
  `status_baca` int(11) DEFAULT 0,
  `alasan_permohonan` text DEFAULT NULL,
  `file_skpln` varchar(255) DEFAULT NULL,
  `file_formulirskplnf103` varchar(255) DEFAULT NULL,
  `file_kartukeluarga` varchar(255) DEFAULT NULL,
  `file_ktpel` varchar(255) DEFAULT NULL,
  `file_aktakelahiran` varchar(255) DEFAULT NULL,
  `file_suratnikahatauaktacerai` varchar(255) DEFAULT NULL,
  `file_suratizin` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `paket_t`
--

INSERT INTO `paket_t` (`id_paket`, `id_pemohon`, `nama`, `nik`, `no_kk`, `no_registrasi_pemohon`, `nama_pemohon`, `no_wa_pemohon`, `alamat`, `id_desa`, `create_date`, `create_time`, `username`, `id_dusun`, `update_time`, `status`, `alasan_penolakan`, `status_baca`, `alasan_permohonan`, `file_skpln`, `file_formulirskplnf103`, `file_kartukeluarga`, `file_ktpel`, `file_aktakelahiran`, `file_suratnikahatauaktacerai`, `file_suratizin`) VALUES
('721211003_20250503002112_9361b717-87e6-4104-9e22-df0cee18fa4c', '', 'Iwan', '1234567812345678', '1234567812345678', 'REG-T-2025-000001', 'Iwan', '082333265777', 'Jalan Bunga Mawar, RT.001/RW.002', '72_12_1_1003', '2025-05-03', '00:21:12', 'BAHOUE', 72, '2025-05-03 01:17:25', 3, '', 1, 'Mau pindah kerja', 'paket_t_skpln_721211003_20250503002112_9361b717-87e6-4104-9e22-df0cee18fa4c_1746206244.pdf', 'paket_t_formulirskplnf103_721211003_20250503002112_9361b717-87e6-4104-9e22-df0cee18fa4c_1746203332.png', 'paket_t_kartukeluarga_721211003_20250503002112_9361b717-87e6-4104-9e22-df0cee18fa4c_1746204901.pdf', 'paket_t_ktpel_721211003_20250503002112_9361b717-87e6-4104-9e22-df0cee18fa4c_1746205935.png', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `templates`
--

CREATE TABLE `templates` (
  `id_templates` int(11) NOT NULL,
  `judul` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `pembuat` varchar(50) NOT NULL,
  `folder` varchar(50) NOT NULL,
  `aktif` enum('Y','N') NOT NULL DEFAULT 'N'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `templates`
--

INSERT INTO `templates` (`id_templates`, `judul`, `username`, `pembuat`, `folder`, `aktif`) VALUES
(24, 'Template Web Desa', 'admin', 'Rio', 'stp', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `tiger_desa`
--

CREATE TABLE `tiger_desa` (
  `id` char(13) NOT NULL,
  `desa` varchar(100) NOT NULL,
  `kode_desa` varchar(10) DEFAULT NULL,
  `id_kecamatan` char(13) NOT NULL,
  `kelompok` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tiger_desa`
--

INSERT INTO `tiger_desa` (`id`, `desa`, `kode_desa`, `id_kecamatan`, `kelompok`) VALUES
('72_12_10_2017', 'MOLEONO', NULL, '72_12_10', 1),
('72_12_10_2018', 'TONTOWEA', NULL, '72_12_10', 1),
('72_12_10_2019', 'ONEPUTE', NULL, '72_12_10', 1),
('72_12_10_2020', 'TOGO MULYO', NULL, '72_12_10', 1),
('72_12_10_2021', 'MARALEE', NULL, '72_12_10', 1),
('72_12_10_2022', 'SAMPALOWO', NULL, '72_12_10', 1),
('72_12_10_2023', 'ULU LAA', NULL, '72_12_10', 1),
('72_12_10_2024', 'MONDOWE', NULL, '72_12_10', 1),
('72_12_10_2025', 'TIU', NULL, '72_12_10', 1),
('72_12_10_2026', 'TADAKU JAYA', NULL, '72_12_10', 1),
('72_12_1_1001', 'KOLONODALE', NULL, '72_12_1', 1),
('72_12_1_1002', 'BAHONTULA', NULL, '72_12_1', 1),
('72_12_1_1003', 'BAHOUE', NULL, '72_12_1', 1),
('72_12_1_2004', 'GANDA-GANDA', NULL, '72_12_1', 1),
('72_12_1_2005', 'KOYA', NULL, '72_12_1', 1),
('72_12_1_2006', 'GILILANA', NULL, '72_12_1', 1),
('72_12_1_2007', 'TANAUGE', NULL, '72_12_1', 1),
('72_12_1_2008', 'KOROLOLAKI', NULL, '72_12_1', 1),
('72_12_1_2009', 'KOROLOLAMA', NULL, '72_12_1', 1),
('72_12_1_2010', 'KOROMATANTU', NULL, '72_12_1', 1),
('72_12_2_2001', 'BUNTA', NULL, '72_12_2', 1),
('72_12_2_2002', 'TOMPIRA', NULL, '72_12_2', 1),
('72_12_2_2003', 'BUNGINTIMBE', NULL, '72_12_2', 1),
('72_12_2_2004', 'TOWARA', NULL, '72_12_2', 1),
('72_12_2_2005', 'MOLINO', NULL, '72_12_2', 1),
('72_12_2_2006', 'MOHONI', NULL, '72_12_2', 1),
('72_12_2_2007', 'UNGKEA', NULL, '72_12_2', 1),
('72_12_2_2008', 'BIMOR JAYA', NULL, '72_12_2', 1),
('72_12_2_2009', 'MOLORES', NULL, '72_12_2', 1),
('72_12_2_2010', 'KEUNO', NULL, '72_12_2', 1),
('72_12_2_2011', 'TOWARA PANTAI', NULL, '72_12_2', 1),
('72_12_2_2012', 'PEBOA', NULL, '72_12_2', 1),
('72_12_3_2001', 'DOLUPO KARYA', NULL, '72_12_3', 1),
('72_12_3_2002', 'PO\'ONA', NULL, '72_12_3', 1),
('72_12_3_2003', 'PETUMBEA', NULL, '72_12_3', 1),
('72_12_3_2004', 'RONTA', NULL, '72_12_3', 1),
('72_12_3_2005', 'PONTANGOA', NULL, '72_12_3', 1),
('72_12_3_2006', 'JAMOR JAYA', NULL, '72_12_3', 1),
('72_12_3_2007', 'PA\'AWARU', NULL, '72_12_3', 1),
('72_12_3_2008', 'LEMBOBELALA', NULL, '72_12_3', 1),
('72_12_3_2009', 'BINTANGOR MUKTI', NULL, '72_12_3', 1),
('72_12_3_2010', 'MANDULA', NULL, '72_12_3', 1),
('72_12_4_2001', 'BETELEME', NULL, '72_12_4', 1),
('72_12_4_2002', 'ULUANSO', NULL, '72_12_4', 1),
('72_12_4_2003', 'MORA', NULL, '72_12_4', 1),
('72_12_4_2004', 'WARAA', NULL, '72_12_4', 1),
('72_12_4_2005', 'TINGKEA\'O', NULL, '72_12_4', 1),
('72_12_4_2006', 'WAWOPADA', NULL, '72_12_4', 1),
('72_12_4_2007', 'KOROWALELO', NULL, '72_12_4', 1),
('72_12_4_2008', 'TINOMPO', NULL, '72_12_4', 1),
('72_12_4_2009', 'KUMPI', NULL, '72_12_4', 1),
('72_12_4_2010', 'KOROMPEELI', NULL, '72_12_4', 1),
('72_12_4_2011', 'LEMBOROMA', NULL, '72_12_4', 1),
('72_12_4_2012', 'KOROWOU', NULL, '72_12_4', 1),
('72_12_4_2013', 'LEMBOBARU', NULL, '72_12_4', 1),
('72_12_4_2014', 'KOROBONDE', NULL, '72_12_4', 1),
('72_12_5_2001', 'TOMATA', NULL, '72_12_5', 1),
('72_12_5_2002', 'LONDI', NULL, '72_12_5', 1),
('72_12_5_2003', 'TAENDE', NULL, '72_12_5', 1),
('72_12_5_2004', 'ENSA', NULL, '72_12_5', 1),
('72_12_5_2005', 'KOLAKA', NULL, '72_12_5', 1),
('72_12_5_2006', 'PEONEA', NULL, '72_12_5', 1),
('72_12_5_2007', 'LANUMOR', NULL, '72_12_5', 1),
('72_12_5_2008', 'GONTARA', NULL, '72_12_5', 1),
('72_12_5_2009', 'LEE', NULL, '72_12_5', 1),
('72_12_5_2010', 'SAEMBA', NULL, '72_12_5', 1),
('72_12_5_2011', 'KASINGOLI', NULL, '72_12_5', 1),
('72_12_5_2012', 'TOMUI KARYA', NULL, '72_12_5', 1),
('72_12_5_2013', 'SAEMBA WALATI', NULL, '72_12_5', 1),
('72_12_5_2014', 'PAMBAREA', NULL, '72_12_5', 1),
('72_12_6_2001', 'ERA', NULL, '72_12_6', 1),
('72_12_6_2002', 'PELERU', NULL, '72_12_6', 1),
('72_12_6_2003', 'TAMONJENGI', NULL, '72_12_6', 1),
('72_12_6_2004', 'MAYUMBA', NULL, '72_12_6', 1),
('72_12_6_2005', 'TIWA\'A', NULL, '72_12_6', 1),
('72_12_6_2006', 'LEMBONTONARA', NULL, '72_12_6', 1),
('72_12_6_2007', 'TABARANO', NULL, '72_12_6', 1),
('72_12_6_2008', 'WAWONDULA', NULL, '72_12_6', 1),
('72_12_7_2001', 'LEMBAH SUMARA', NULL, '72_12_7', 1),
('72_12_7_2002', 'SUMARA JAYA', NULL, '72_12_7', 1),
('72_12_7_2003', 'TAMBAYOLI', NULL, '72_12_7', 1),
('72_12_7_2004', 'MALINO', NULL, '72_12_7', 1),
('72_12_7_2005', 'PANCA MAKMUR', NULL, '72_12_7', 1),
('72_12_7_2006', 'TAMAINUSI', NULL, '72_12_7', 1),
('72_12_7_2007', 'BAU', NULL, '72_12_7', 1),
('72_12_7_2008', 'MALINO JAYA', NULL, '72_12_7', 1),
('72_12_7_2009', 'TODDOPOLI UEBANGKE', NULL, '72_12_7', 1),
('72_12_7_2010', 'TANDOYONDO', NULL, '72_12_7', 1),
('72_12_8_2001', 'BATURUBE', NULL, '72_12_8', 1),
('72_12_8_2002', 'POSANGKE', NULL, '72_12_8', 1),
('72_12_8_2003', 'TARONGGO', NULL, '72_12_8', 1),
('72_12_8_2004', 'UERURU', NULL, '72_12_8', 1),
('72_12_8_2005', 'UEWAJO', NULL, '72_12_8', 1),
('72_12_8_2006', 'TIRONGAN BAWAH', NULL, '72_12_8', 1),
('72_12_8_2007', 'TIRONGAN ATAS', NULL, '72_12_8', 1),
('72_12_8_2008', 'SILITI', NULL, '72_12_8', 1),
('72_12_8_2009', 'LEMO', NULL, '72_12_8', 1),
('72_12_8_2010', 'SALUBIRO', NULL, '72_12_8', 1),
('72_12_8_2011', 'UEMASI', NULL, '72_12_8', 1),
('72_12_8_2012', 'OPO', NULL, '72_12_8', 1),
('72_12_8_2013', 'TANAKURAYA', NULL, '72_12_8', 1),
('72_12_8_2014', 'TAMBAROBONE', NULL, '72_12_8', 1),
('72_12_8_2015', 'WOOMPARIGI', NULL, '72_12_8', 1),
('72_12_8_2016', 'BOBA', NULL, '72_12_8', 1),
('72_12_8_2017', 'KALOMBANG', NULL, '72_12_8', 1),
('72_12_8_2018', 'TOKONANAKA', NULL, '72_12_8', 1),
('72_12_8_2019', 'MATUBE', NULL, '72_12_8', 1),
('72_12_8_2020', 'LEMOWALIA', NULL, '72_12_8', 1),
('72_12_8_2021', 'UEMPANAPA', NULL, '72_12_8', 1),
('72_12_8_2022', 'TOKALA ATAS', NULL, '72_12_8', 1),
('72_12_8_2023', 'POKEANG', NULL, '72_12_8', 1),
('72_12_9_2001', 'PANDAUKE', NULL, '72_12_9', 1),
('72_12_9_2002', 'KOLO BAWAH', NULL, '72_12_9', 1),
('72_12_9_2003', 'KOLO ATAS', NULL, '72_12_9', 1),
('72_12_9_2004', 'MOMO', NULL, '72_12_9', 1),
('72_12_9_2005', 'TANANAGAYA', NULL, '72_12_9', 1),
('72_12_9_2006', 'UEPAKATU', NULL, '72_12_9', 1),
('72_12_9_2007', 'LIJO', NULL, '72_12_9', 1),
('72_12_9_2008', 'TANASUMPU', NULL, '72_12_9', 1),
('72_12_9_2009', 'PARANGISI', NULL, '72_12_9', 1),
('72_12_9_2010', 'GIRIMULYA', NULL, '72_12_9', 1),
('72_12_9_2011', 'WINANGOBINO', NULL, '72_12_9', 1),
('72_12_9_2012', 'TAMBALE', NULL, '72_12_9', 1),
('72_12_9_2013', 'SEA', NULL, '72_12_9', 1),
('72_12_9_2014', 'MENYO\'E', NULL, '72_12_9', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tiger_desa2`
--

CREATE TABLE `tiger_desa2` (
  `id` varchar(20) NOT NULL,
  `desa` varchar(100) NOT NULL,
  `kode_desa` varchar(10) DEFAULT NULL,
  `id_kecamatan` varchar(20) NOT NULL,
  `kelompok` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tiger_desa2`
--

INSERT INTO `tiger_desa2` (`id`, `desa`, `kode_desa`, `id_kecamatan`, `kelompok`) VALUES
('72_12_1_1002', 'BAHONTULA', '721211002', '72_12_1', 1),
('72_12_1_1003', 'BAHOUE', '721211003', '72_12_1', 1),
('72_12_8_2001', 'BATURUBE', '721282001', '72_12_8', 1),
('72_12_7_2007', 'BAU', '721272007', '72_12_7', 1),
('72_12_4_2001', 'BETELEME', '721242001', '72_12_4', 1),
('72_12_2_2008', 'BIMOR JAYA', '721222008', '72_12_2', 1),
('72_12_3_2009', 'BINTANGOR MUKTI', '721232009', '72_12_3', 1),
('72_12_8_2016', 'BOBA', '721282016', '72_12_8', 1),
('72_12_2_2003', 'BUNGINTIMBE', '721222003', '72_12_2', 1),
('72_12_2_2001', 'BUNTA', '721222001', '72_12_2', 1),
('72_12_3_2001', 'DOLUPO KARYA', '721232001', '72_12_3', 1),
('72_12_5_2004', 'ENSA', '721252004', '72_12_5', 1),
('72_12_6_2001', 'ERA', '721262001', '72_12_6', 1),
('72_12_1_2004', 'GANDA-GANDA', '721212004', '72_12_1', 1),
('72_12_1_2006', 'GILILANA', '721212006', '72_12_1', 1),
('72_12_9_2010', 'GIRIMULYA', '721292010', '72_12_9', 1),
('72_12_5_2008', 'GONTARA', '721252008', '72_12_5', 1),
('72_12_3_2006', 'JAMOR JAYA', '721232006', '72_12_3', 1),
('72_12_8_2017', 'KALOMBANG', '721282017', '72_12_8', 1),
('72_12_5_2011', 'KASINGOLI', '721252011', '72_12_5', 1),
('72_12_2_2010', 'KEUNO', '721222010', '72_12_2', 1),
('72_12_5_2005', 'KOLAKA', '721252005', '72_12_5', 1),
('72_12_9_2003', 'KOLO ATAS', '721292003', '72_12_9', 1),
('72_12_9_2002', 'KOLO BAWAH', '721292002', '72_12_9', 1),
('72_12_1_1001', 'KOLONODALE', '721211001', '72_12_1', 1),
('72_12_4_2014', 'KOROBONDE', '721242014', '72_12_4', 1),
('72_12_1_2008', 'KOROLOLAKI', '721212008', '72_12_1', 1),
('72_12_1_2009', 'KOROLOLAMA', '721212009', '72_12_1', 1),
('72_12_1_2010', 'KOROMATANTU', '721212010', '72_12_1', 1),
('72_12_4_2010', 'KOROMPEELI', '721242010', '72_12_4', 1),
('72_12_4_2007', 'KOROWALELO', '721242007', '72_12_4', 1),
('72_12_4_2012', 'KOROWOU', '721242012', '72_12_4', 1),
('72_12_1_2005', 'KOYA', '721212005', '72_12_1', 1),
('72_12_4_2009', 'KUMPI', '721242009', '72_12_4', 1),
('72_12_5_2007', 'LANUMOR', '721252007', '72_12_5', 1),
('72_12_5_2009', 'LEE', '721252009', '72_12_5', 1),
('72_12_7_2001', 'LEMBAH SUMARA', '721272001', '72_12_7', 1),
('72_12_4_2013', 'LEMBOBARU', '721242013', '72_12_4', 1),
('72_12_3_2008', 'LEMBOBELALA', '721232008', '72_12_3', 1),
('72_12_6_2006', 'LEMBONTONARA', '721262006', '72_12_6', 1),
('72_12_4_2011', 'LEMBOROMA', '721242011', '72_12_4', 1),
('72_12_8_2009', 'LEMO', '721282009', '72_12_8', 1),
('72_12_8_2020', 'LEMOWALIA', '721282020', '72_12_8', 1),
('72_12_9_2007', 'LIJO', '721292007', '72_12_9', 1),
('72_12_5_2002', 'LONDI', '721252002', '72_12_5', 1),
('72_12_7_2004', 'MALINO', '721272004', '72_12_7', 1),
('72_12_7_2008', 'MALINO JAYA', '721272008', '72_12_7', 1),
('72_12_3_2010', 'MANDULA', '721232010', '72_12_3', 1),
('72_12_10_2021', 'MARALEE', '7212102021', '72_12_10', 1),
('72_12_8_2019', 'MATUBE', '721282019', '72_12_8', 1),
('72_12_6_2004', 'MAYUMBA', '721262004', '72_12_6', 1),
('72_12_9_2014', 'MENYO\'E', '721292014', '72_12_9', 1),
('72_12_2_2006', 'MOHONI', '721222006', '72_12_2', 1),
('72_12_10_2017', 'MOLEONO', '7212102017', '72_12_10', 1),
('72_12_2_2005', 'MOLINO', '721222005', '72_12_2', 1),
('72_12_2_2009', 'MOLORES', '721222009', '72_12_2', 1),
('72_12_9_2004', 'MOMO', '721292004', '72_12_9', 1),
('72_12_10_2024', 'MONDOWE', '7212102024', '72_12_10', 1),
('72_12_4_2003', 'MORA', '721242003', '72_12_4', 1),
('72_12_10_2019', 'ONEPUTE', '7212102019', '72_12_10', 1),
('72_12_8_2012', 'OPO', '721282012', '72_12_8', 1),
('72_12_3_2007', 'PA\'AWARU', '721232007', '72_12_3', 1),
('72_12_5_2014', 'PAMBAREA', '721252014', '72_12_5', 1),
('72_12_7_2005', 'PANCA MAKMUR', '721272005', '72_12_7', 1),
('72_12_9_2001', 'PANDAUKE', '721292001', '72_12_9', 1),
('72_12_9_2009', 'PARANGISI', '721292009', '72_12_9', 1),
('72_12_2_2012', 'PEBOA', '721222012', '72_12_2', 1),
('72_12_6_2002', 'PELERU', '721262002', '72_12_6', 1),
('72_12_5_2006', 'PEONEA', '721252006', '72_12_5', 1),
('72_12_3_2003', 'PETUMBEA', '721232003', '72_12_3', 1),
('72_12_3_2002', 'PO\'ONA', '721232002', '72_12_3', 1),
('72_12_8_2023', 'POKEANG', '721282023', '72_12_8', 1),
('72_12_3_2005', 'PONTANGOA', '721232005', '72_12_3', 1),
('72_12_8_2002', 'POSANGKE', '721282002', '72_12_8', 1),
('72_12_3_2004', 'RONTA', '721232004', '72_12_3', 1),
('72_12_5_2010', 'SAEMBA', '721252010', '72_12_5', 1),
('72_12_5_2013', 'SAEMBA WALATI', '721252013', '72_12_5', 1),
('72_12_8_2010', 'SALUBIRO', '721282010', '72_12_8', 1),
('72_12_10_2022', 'SAMPALOWO', '7212102022', '72_12_10', 1),
('72_12_9_2013', 'SEA', '721292013', '72_12_9', 1),
('72_12_8_2008', 'SILITI', '721282008', '72_12_8', 1),
('72_12_7_2002', 'SUMARA JAYA', '721272002', '72_12_7', 1),
('72_12_6_2007', 'TABARANO', '721262007', '72_12_6', 1),
('72_12_10_2026', 'TADAKU JAYA', '7212102026', '72_12_10', 1),
('72_12_5_2003', 'TAENDE', '721252003', '72_12_5', 1),
('72_12_7_2006', 'TAMAINUSI', '721272006', '72_12_7', 1),
('72_12_9_2012', 'TAMBALE', '721292012', '72_12_9', 1),
('72_12_8_2014', 'TAMBAROBONE', '721282014', '72_12_8', 1),
('72_12_7_2003', 'TAMBAYOLI', '721272003', '72_12_7', 1),
('72_12_6_2003', 'TAMONJENGI', '721262003', '72_12_6', 1),
('72_12_8_2013', 'TANAKURAYA', '721282013', '72_12_8', 1),
('72_12_9_2005', 'TANANAGAYA', '721292005', '72_12_9', 1),
('72_12_9_2008', 'TANASUMPU', '721292008', '72_12_9', 1),
('72_12_1_2007', 'TANAUGE', '721212007', '72_12_1', 1),
('72_12_7_2010', 'TANDOYONDO', '721272010', '72_12_7', 1),
('72_12_8_2003', 'TARONGGO', '721282003', '72_12_8', 1),
('72_12_4_2005', 'TINGKEA\'O', '721242005', '72_12_4', 1),
('72_12_4_2008', 'TINOMPO', '721242008', '72_12_4', 1),
('72_12_8_2007', 'TIRONGAN ATAS', '721282007', '72_12_8', 1),
('72_12_8_2006', 'TIRONGAN BAWAH', '721282006', '72_12_8', 1),
('72_12_10_2025', 'TIU', '7212102025', '72_12_10', 1),
('72_12_6_2005', 'TIWA\'A', '721262005', '72_12_6', 1),
('72_12_7_2009', 'TODDOPOLI UEBANGKE', '721272009', '72_12_7', 1),
('72_12_10_2020', 'TOGO MULYO', '7212102020', '72_12_10', 1),
('72_12_8_2022', 'TOKALA ATAS', '721282022', '72_12_8', 1),
('72_12_8_2018', 'TOKONANAKA', '721282018', '72_12_8', 1),
('72_12_5_2001', 'TOMATA', '721252001', '72_12_5', 1),
('72_12_2_2002', 'TOMPIRA', '721222002', '72_12_2', 1),
('72_12_5_2012', 'TOMUI KARYA', '721252012', '72_12_5', 1),
('72_12_10_2018', 'TONTOWEA', '7212102018', '72_12_10', 1),
('72_12_2_2004', 'TOWARA', '721222004', '72_12_2', 1),
('72_12_2_2011', 'TOWARA PANTAI', '721222011', '72_12_2', 1),
('72_12_8_2011', 'UEMASI', '721282011', '72_12_8', 1),
('72_12_8_2021', 'UEMPANAPA', '721282021', '72_12_8', 1),
('72_12_9_2006', 'UEPAKATU', '721292006', '72_12_9', 1),
('72_12_8_2004', 'UERURU', '721282004', '72_12_8', 1),
('72_12_8_2005', 'UEWAJO', '721282005', '72_12_8', 1),
('72_12_10_2023', 'ULU LAA', '7212102023', '72_12_10', 1),
('72_12_4_2002', 'ULUANSO', '721242002', '72_12_4', 1),
('72_12_2_2007', 'UNGKEA', '721222007', '72_12_2', 1),
('72_12_4_2004', 'WARAA', '721242004', '72_12_4', 1),
('72_12_6_2008', 'WAWONDULA', '721262008', '72_12_6', 1),
('72_12_4_2006', 'WAWOPADA', '721242006', '72_12_4', 1),
('72_12_9_2011', 'WINANGOBINO', '721292011', '72_12_9', 1),
('72_12_8_2015', 'WOOMPARIGI', '721282015', '72_12_8', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tiger_desax`
--

CREATE TABLE `tiger_desax` (
  `id` char(13) NOT NULL,
  `desa` varchar(100) NOT NULL,
  `kode_desa` varchar(10) DEFAULT NULL,
  `id_kecamatan` char(13) NOT NULL,
  `kelompok` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tiger_kecamatan`
--

CREATE TABLE `tiger_kecamatan` (
  `id` char(13) NOT NULL,
  `kecamatan` varchar(300) NOT NULL DEFAULT '',
  `kode_kecamatan` varchar(10) DEFAULT NULL,
  `id_kota` char(13) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tiger_kecamatan`
--

INSERT INTO `tiger_kecamatan` (`id`, `kecamatan`, `kode_kecamatan`, `id_kota`) VALUES
('72_12_1', 'PETASIA', '72_12_1', '72_12'),
('72_12_10', 'PETASIA BARAT', '72_12_10', '72_12'),
('72_12_2', 'PETASIA TIMUR', '72_12_2', '72_12'),
('72_12_3', 'LEMBO RAYA', '72_12_3', '72_12'),
('72_12_4', 'LEMBO', '72_12_4', '72_12'),
('72_12_5', 'MORI ATAS', '72_12_5', '72_12'),
('72_12_6', 'MORI UTARA', '72_12_6', '72_12'),
('72_12_7', 'SOYO JAYA', '72_12_7', '72_12'),
('72_12_8', 'BUNGKU UTARA', '72_12_8', '72_12'),
('72_12_9', 'MAMOSALATO', '72_12_9', '72_12');

-- --------------------------------------------------------

--
-- Table structure for table `tiger_kota`
--

CREATE TABLE `tiger_kota` (
  `id` char(13) NOT NULL,
  `kota` varchar(100) NOT NULL,
  `kode_kota` varchar(10) DEFAULT NULL,
  `id_provinsi` char(13) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tiger_kota`
--

INSERT INTO `tiger_kota` (`id`, `kota`, `kode_kota`, `id_provinsi`) VALUES
('72_12', 'KABUPATEN MOROWALI UTARA', '72_12', '72');

-- --------------------------------------------------------

--
-- Table structure for table `tiger_provinsi`
--

CREATE TABLE `tiger_provinsi` (
  `id` char(13) NOT NULL,
  `provinsi` varchar(100) DEFAULT NULL,
  `kode_prov` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tiger_provinsi`
--

INSERT INTO `tiger_provinsi` (`id`, `provinsi`, `kode_prov`) VALUES
('11', 'ACEH', '11'),
('12', 'SUMATERA UTARA', '12'),
('13', 'SUMATERA BARAT', '13'),
('14', 'RIAU', '14'),
('15', 'JAMBI', '15'),
('16', 'SUMATERA SELATAN', '16'),
('17', 'BENGKULU', '17'),
('18', 'LAMPUNG', '18'),
('19', 'KEPULAUAN BANGKA BELITUNG', '19'),
('21', 'KEPULAUAN RIAU', '21'),
('31', 'DKI JAKARTA', '31'),
('32', 'JAWA BARAT', '32'),
('33', 'JAWA TENGAH', '33'),
('34', 'DAERAH ISTIMEWA YOGYAKARTA', '34'),
('35', 'JAWA TIMUR', '35'),
('36', 'BANTEN', '36'),
('51', 'BALI', '51'),
('52', 'NUSA TENGGARA BARAT', '52'),
('53', 'NUSA TENGGARA TIMUR', '53'),
('61', 'KALIMANTAN BARAT', '61'),
('62', 'KALIMANTAN TENGAH', '62'),
('63', 'KALIMANTAN SELATAN', '63'),
('64', 'KALIMANTAN TIMUR', '64'),
('65', 'KALIMANTAN UTARA', '65'),
('71', 'SULAWESI UTARA', '71'),
('72', 'SULAWESI TENGAH', '72'),
('73', 'SULAWESI SELATAN', '73'),
('74', 'SULAWESI TENGGARA', '74'),
('75', 'GORONTALO', '75'),
('76', 'SULAWESI BARAT', '76'),
('81', 'MALUKU', '81'),
('82', 'MALUKU UTARA', '82'),
('91', 'PAPUA', '91'),
('92', 'PAPUA BARAT DAYA', '92');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `nama_lengkap` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `email` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `no_telp` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `foto` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `level` varchar(20) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT 'user',
  `blokir` enum('Y','N','P') CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT 'N',
  `id_session` bigint(20) UNSIGNED NOT NULL,
  `permission_publish` enum('Y','N') NOT NULL DEFAULT 'N',
  `attack` varchar(255) NOT NULL,
  `tanggal_reg` date NOT NULL,
  `deleted` enum('Y','N') NOT NULL DEFAULT 'N',
  `valid_reset` date NOT NULL,
  `id_reset` varchar(255) NOT NULL,
  `id_dusun` int(11) NOT NULL,
  `pimpinan` varchar(100) NOT NULL,
  `nip_pimpinan` varchar(100) NOT NULL,
  `nip_operator_dinas` varchar(100) NOT NULL,
  `id_desa` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `password`, `nama_lengkap`, `email`, `no_telp`, `foto`, `level`, `blokir`, `id_session`, `permission_publish`, `attack`, `tanggal_reg`, `deleted`, `valid_reset`, `id_reset`, `id_dusun`, `pimpinan`, `nip_pimpinan`, `nip_operator_dinas`, `id_desa`) VALUES
('admin', '1946de7d7b54ff27c18d0313a70161ce3fac423c1368b9a9f72a371d9381c7487e0d6fe54ab367d735f37266a9e2891f3abef7e0226223e520a1ca954a2390e0', 'Andi Pratama', 'lutfijaya@rocketmail.com', '080084985361', 'irwan_57219447.jpg', 'admin', 'N', 4130299894, 'Y', '859b42d1561f3617766f6ff2508d37ea', '2025-03-29', 'N', '0000-00-00', 'f6d280e98c7dfe6921063817947ec150fb5ca750a35621b88615102d2e9fa84017f036f6c792761cc689ea5f8f71cb517753e7b2ca4a264ad38ca53685cbe42b', 0, '', '0', '198104052005022003', ''),
('LEMOWALIA', '5a48cd4cc0d3113c4ffd9a4c07f6d480416b6f5e61025a58390598d0b339bbcfeb9dfcf7b0bb679b292fb6d50f4a5fdadd4b282a28c73b5b82bf1dc51922456a', 'Budi Santoso', '', '080048793820', '', 'user', 'N', 9307550511, 'N', '500bcc016610a4c1b05766f1281e6183', '2025-03-29', 'N', '2025-04-02', 'c9e603a1b3d793da5ebe5025c81e338344a32e7979222e495e9fbb390f7d9eda017c01d3b632a178d2ac451e5a17b13b8712c93358d90dce04e50aa9b9b635d8', 0, '', '', '', '72_12_8_2020'),
('LIJO', 'bfc0f8d154479bb6eac303371b189d3cbf9169a5d39feed23defe63b25bbe2d05c2bd852cd443c0a548beac05ded191a43d83e52898a4656a0eec86f0414d024', 'Citra Dewi', '', '080089013022', '', 'user', 'N', 7893425743, 'N', '9f95e0a1e4b5adcdbdc587503488ce26', '2025-03-29', 'N', '0000-00-00', 'b0a1bb600b9a537932663b3b51ac785319ac12dbc126e61f86de4e0022dc47e7d961aac31062badecd789d8e1ea513723fc794aade8ff7b813dc9f742035a2a4', 0, '', '', '', '72_12_9_2007'),
('LONDI', '3c9457cb1c2cdef2e898259801e634ac55d4a7de59bcae8a662537755a062c0288c33044f5b7a1d6b301307762b927a5a354f3283580ca313cc44831f86aaa81', 'Dewi Anggraini', '', '080098683653', '', 'user', 'N', 9637349833, 'N', '8d51b94a87ac9bdf18c840d54725f54e', '2025-03-29', 'N', '0000-00-00', '4cc6c64d623cd94bc6570b7fa2170fc95b29f467668de39dbb66bff15982839de459cc986b52917982de835bd6b06babd11e089abd00d99777f9b5dda5085317', 0, '', '', '', '72_12_5_2002'),
('MALINO', '7804bc683b100136ee2c08aa3214fc6dba1a5149835d652ebae21debe698381a3f4b33b1809e7d424724e3f37aca137f5881530f970e5edd183e7f036cdc22b0', 'Eka Putri', '', '080026379203', '', 'user', 'N', 6669686948, 'N', '230df713b50cbe1476359bc594a55059', '2025-03-29', 'N', '0000-00-00', 'ecb3322b1a006f61ead907004f320224688f6edce8c9e349b6745ae4bde05b18e9ed17c7f4903f70d4028628fac5d79d02cebf63cb383a73987bd08590fbfa5d', 0, '', '', '', '72_12_7_2004'),
('MALINOJAYA', 'becbff4a90e67b8df545fbcb7696ab740467c30e91f1184bff7e91f43560065dfc3f5724b1a215d6d86f315c93ce67227d310e1e041e68c0ba9d812af6354439', 'Fajar Nugraha', '', '080035845058', '', 'user', 'N', 4541034764, 'N', '7be844a72818d3e58ad6b4daf8cd6cf8', '2025-03-29', 'N', '0000-00-00', '3ac41e48423330100a9ffbcf8b69570065fd71184dc187379febab23d9a36f01cd58e92f1fcc70a7566affab655b3b84573a61576bd07535df3ca55defe6734e', 0, '', '', '', '72_12_7_2008'),
('MANDULA', '7d369331a7c734585d8ba9f3fcc6faa205f7dddd2d60fe924c6755f3a861863af6440bcf37c69fcb945feb91292141e12f6194343a9d08ab4e0ba26ddd598f44', 'Gina Sari', '', '080000087685', '', 'user', 'N', 6119105669, 'N', 'c531b63ccb36b3065cd57649caaa227e', '2025-03-29', 'N', '0000-00-00', 'eca4d84bb3828063e290fd855f8661bbe5c7b16b24a6792654c0fe54bfd56723b9bd6d7d3af1149685cab8bf90ad372f8fa46e13604a388a2d371b0f996eac2b', 0, '', '', '', '72_12_3_2010'),
('MARALEE', '0217284e11e87d516e1ddcb9c28e231c8a8213638867b20ac4020263c539b42e88d6e2ce3ee64731c4fc8a0b578f5125280e8bb057b7fa9e2282ae3dea9c3127', 'Hendra Wijaya', '', '080092903256', '', 'user', 'N', 1658085973, 'N', 'e5a8db228f25330ced51af59d4659fbf', '2025-03-29', 'N', '0000-00-00', '528293dff67381b54bd9bd35a3335d57322271f2c696606ccb73fb9e88c5614cf14ae5c940b541389033a3745c2552c8d5bf2e67e650e8576fa2c6343fcc11ef', 0, '', '', '', '72_12_10_2021'),
('PEBOA', '0b6c637ff564c0db70fd8a6aa74ba7cea0828a364ecc4dc7a617a72b36c0afa23e65160347ce5618fbdf974a43f56a5e47cdabd4e04a0093fdcc22fb18bc7236', 'Indra Kusuma', '', '080064253229', '', 'user', 'N', 2138424665, 'N', '282e5472ee770e81f4b67d6718b3cd7c', '2025-03-29', 'N', '0000-00-00', '4c45da22556bf3c3829047e7d06b935b5bc54d8566522bc63ebfdf3c29e789c025f1451acf84053cf1977db71997a130fd73c50f83a3cd256dd6d15d0f4706bc', 0, '', '', '', '72_12_2_2012'),
('LEMBOBARU', '2d8743875fc35066e75b798512519fcead1d03303e1b56f06bf379398fb866a14b82bec18d4a24be6821c018dfca4b9954cc03aff042a593121d796684854c1a', 'Joko Widodo', '', '080042556378', '', 'user', 'N', 7748754849, 'N', '762ba41a457e04aa2c9fc6c90c4cf3b9', '2025-03-29', 'N', '0000-00-00', '714f17e417d2682761d1bb026ef9bfd2ca343ec6c2ccbe9d4f7559080c8ff719f62a57882ce9c3dd0e8c27b8db923f19533235dd21ac96ee17a565b623537bb4', 0, '', '', '', '72_12_4_2013'),
('LEMBOBELALA', '33948c511b10a8baaf789c1d2e6fd55a678e14823f63e99f732bc4d68f5aee231914e5e7469b4b8c537915fac2a81c86acbcec8e0964c0eb7f0c4b05f53c4f91', 'Anisa Rahmawati', '', '080020022209', '', 'user', 'N', 3423863393, 'N', '911ee544b0d6dee41d13e1b68a3394bb', '2025-03-29', 'N', '0000-00-00', 'f47ef9a57dcc373687d6fb3a4d15f5106c0989333d51a13bedcaea8dee42219d7022cf8df8d17b5d1a7dde51eb4591087a76d7f257c9541ac88c97875f2e325b', 0, '', '', '', '72_12_3_2008'),
('LEMBONTONARA', '3a3cfa2fb74b088703e66060bf3393ef803af8038223603bc40b61086915cc29cfe1392a911a39e233136a46c3c86a55e311ad1d35c32abefff1a95237d7960e', 'Bambang Hartono', '', '080072441913', '', 'user', 'N', 6963812454, 'N', 'ad6c68e51c4c614009c3bc162efed58c', '2025-03-29', 'N', '0000-00-00', '22c85a64bf35cd82882276788f7f99509110dc9ff761543514e570b21003133f79d97b3c72bbdd4b7737c0dacfcd077b034cabbc69e23448d10347b611a7230e', 0, '', '', '', '72_12_6_2006'),
('LEMBOROMA', 'e7de3a4cde2033e8d707276f7b0596832a1474dda17df7c7838e967c97c87519b444a10133ae11599f79146d8d0ccf9dc37366ade808c50cb6d969252eac3d31', 'Clara Yuliana', '', '080002142943', '', 'user', 'N', 8331454184, 'N', '999bc0c41c56d6928ecc51a7aba2b9a7', '2025-03-29', 'N', '0000-00-00', '48823c4f38b904bd28c9189264e7b3af1b510920236887297d9cfe943b1de0cc8e25f82e8d4cef7e3e3eb27ef7a605169c569b53a4869303343260347d625537', 0, '', '', '', '72_12_4_2011'),
('LEE', 'cf6d8aaeac9106405ea888fe2dfc249087741ac90fb42a8222f009c5b3e16f408df78f2030d7f1df7da777097b8c1f8ade4fb3b6338065122ef62bd42713c7af', 'Dedi Kurniawan', '', '080093388979', '', 'user', 'N', 8718996740, 'N', 'cd25721276303967e2fb7edfdb3363df', '2025-03-29', 'N', '0000-00-00', '43a6ebfb6fa3deb61b7d1eeca25a00bc9b1316deb21de99eee7392fd6ac14e018534f1c5f166618bda8056af4204203ccafed9d2ed9b427620ec08955f2c8724', 0, '', '', '', '72_12_5_2009'),
('ONEPUTE', '161246e950baed6ea40ca466cbe32ba54f1b0823d700587127ae84d60d6b199428a5e4df7565a0a9bffb01e79b8028d531cce404e9e11dcd46e51123dc3eeefd', 'Elisa Natalia', '', '080060516070', '', 'user', 'N', 4871805221, 'N', '4968b3fea6b8b8412db8bd254a360597', '2025-03-29', 'N', '0000-00-00', '9ccb6bbfdd5ead0875cbd4de26d19a48ddff28d78649ca43a5f1adf84119f93f7276551952743df16f74d4f7f092a7dd92f18258855d29820eeb2ec1d77937b7', 0, '', '', '', '72_12_10_2019'),
('OPO', '28c18db3488bd10b46b50d62f5c1863ffa9000b10b5ddf588939ef395d08c5d0b7eb226b3723df2b7daed8ac54671cd7a7882645ffc1cd50546618631fe096ba', 'Fahmi Rizki', '', '080022413416', '', 'user', 'N', 4530239973, 'N', 'ccf3d496e78ed1bf5cdc72aeed9e5962', '2025-03-29', 'N', '0000-00-00', '18e92a17ba994047e53ba85afd0a91f4769d2938ee2ff46be7cd37d7731a696c030f8363545d01cea6911598fd6e3764d10c160d267ef700a559275a63a9948a', 0, '', '', '', '72_12_8_2012'),
('PAAWARU', '8f1f9b33abdee6da4044a4cf14e81bc54fa73b767f37adb5ddebafabca084288f100dd23bff6fd2c1214308b3bac2e00ff7de97491a390ea5f06d647434d945e', 'Gita Yulia', '', '080030518874', '', 'user', 'N', 8149110650, 'N', '9c319337df2ee655199ecd5bd361a9d9', '2025-03-29', 'N', '0000-00-00', '221c5827126761ada27d0577a0fa1ad230296848f271ab448ca49d926c5c9c2eacdcf341ce3155b99d0cd63d93cd08b386340099b59e75839ff0322e7ce72e99', 0, '', '', '', '72_12_3_2007'),
('PAMBAREA', '3a442caff48a6e5316682502c7364d497a0274ad70798b4812b21036d4fae1cb966fd5bad3c2fbb43d2f0c8eae336cc71667375dcfe9ddac0ac72e90115e117d', 'Heru Santosa', '', '080085354124', '', 'user', 'N', 8971424931, 'N', 'f54047ffb83ba34ccaad4c0288bc2fe6', '2025-03-29', 'N', '0000-00-00', 'b5c02314c37caad4afab2b8fcf2a85588c3bc40d0174cadab90c8417ad9d68cda3f2a2847728cc9874dabdc8d23423bbec46024bcf38dbf0b8cc861835f3d102', 0, '', '', '', '72_12_5_2014'),
('MONDOWE', '049fdcbe05ef012ebda8af507e1dd71f8f12a90d7f8c79c1e5041e46e7f49377c689a2b6a13aaba1ae7b67e88697d7d59092377f8bd84da03d69dc61534e0379', 'Irma Septiani', '', '080035214004', '', 'user', 'N', 7403574540, 'N', 'd22bcb34d35f2a2d0eaa036d187bdafc', '2025-03-29', 'N', '0000-00-00', 'b860f4dbdcf92074bcd02a33bcaf6b5e922cc2e7b1d97139f49594fd909ed5e6a662aa4f01d7f831d4b339a2aab8b3bf0ee4568b498e307744de5ce22571e948', 0, '', '', '', '72_12_10_2024'),
('MOLEONO', '1f2ebc77303734ccd5da3c8da20f44326e61e21b7b05161c970afaedca2e7236a9f120fa9844a71d7255d3b69490d0fd1cdfbef612ee629a69497df0b6e02ff1', 'Joni Pranata', '', '080020007652', '', 'user', 'N', 9691599104, 'N', '7f537e349b0b57f984e10f679e146f48', '2025-03-29', 'N', '0000-00-00', 'b480dd0867eaccf3c68cb1a577298c378a3cbe5b8ee799302752f2e0284bd60e9e44d5385070118e05f13fab77497b1466bf5ef1d966ce6597186a1c40dec2a1', 0, '', '', '', '72_12_10_2017'),
('PARANGISI', 'b8da6d3c71d650fa7fef5ac405b45bded92cf6d0c24605eda025e87d497ade4551e7679510acfd80bd986bb54158344b7a65e77ac2ff3079018b2f578f181e2a', 'Kamila Ayu', '', '080094396251', '', 'user', 'N', 8964778994, 'N', '32cd01cff48a28ae76a113839c07dda1', '2025-03-29', 'N', '0000-00-00', 'a03c50fe4464c490b9ac229841d4b008c687c4024ae2dcaa8b6cbc27a52a072bf75105a9befa6e53840ceacfa1162d3c285e4d3e709f66dcaa8fc916a94541b4', 0, '', '', '', '72_12_9_2009'),
('MOLORES', '3d5b4efbd4c782ebd9d205da10cb0e3aaa95e48c597d6ff0b1740089ca553cb628db811cb975f656fce86d9dfafe0283b209a2dbf6d96170e263338733d83072', 'Lilis Sulastri', '', '080011958304', '', 'user', 'N', 4585419531, 'N', 'ad6b2b91c41992ff77933bdf9c2019d1', '2025-03-29', 'N', '0000-00-00', 'c6b4370645328e78df7d34dd4a5984bf2be3221d7c6ac44d15ef7e6ae081db07028f8f7c903920d3209d80ab7a081f696d3337d19087ab7701b9ce63ed7a9070', 0, '', '', '', '72_12_2_2009'),
('MOMO', 'abd837ad75ced9b944b57aba8e949d3c494c8185e70be11ffd716c2d4a69c2eb825110799b69d13dd8d1f24e7563905e471739d8331954d00670b0e6339eb4ae', 'Marwan Mahmud', '', '080076602771', '', 'user', 'N', 9021917854, 'N', 'a8b598d0bd64c9db18946c1adddf8e2e', '2025-03-29', 'N', '0000-00-00', '69eb18e31dfef368a9e364f10766bd24ff5fe47345fe8a4784d8a592d17250c4073d0c4c5c9e8850301e5e4942a1474e906de9f90a9b38075a4e2efc30a5992b', 0, '', '', '', '72_12_9_2004'),
('BAHONTULA', 'dfa1ac17c701235b275536a85fc5ef1d9ea0178ef4acd7b283ae9b023d284fc219d5edf12b6ce8563ab9b1564f57e4b5535315c5b662b1b5211317bcea44ac36', 'Nabila Ramadhani', '', '080047138946', '', 'user', 'N', 1485743375, 'N', '667e59570c78974d0cb2524a5fe31ba5', '2025-03-29', 'N', '0000-00-00', '2d22f4d83af1979d173a11e5be349c120e9d4d23b6f4fb8668e3baceb25e52837d8d204f864e7fd2beea9aa76fc81f1e48787e22aae72a315b29085e5ac44a20', 0, '', '', '', '72_12_1_1002'),
('BAHOUE', 'ca665fde4e43d25cb1dfe76f799db080d830638e33c8c46591e41defb406a21f601f9329f6a88d22974cdc8aaa8ea2a47afd3feabb25c640ae77f3b6fd36ee64', 'Oktaviani Putri', '', '080005886419', '', 'user', 'N', 2079962176, 'N', '4551cc4632ea5d17782c71af15b2f394', '2025-03-29', 'N', '0000-00-00', '9c83dea8e821d231d6cf83048420f6d98819aa2491a6b070188f072f4ac0dd4f09ca879f23f6c3dc8f9cea3b731f86892c41561eefdf9eae44771614fd5f0b92', 0, '', '', '', '72_12_1_1003'),
('BATURUBE', '1e70ebb5b50d868535d95b49f7bf9e3a025381856c837f9fcf17a83d63420a6b195e88548bfd2047fed3d5bf60fac39bc5521d4eb81dee0b390f5f0339d68acf', 'Putra Aditya', '', '080088015262', '', 'user', 'N', 4171929134, 'N', 'cb5e0c8faad62176b57ebd37700023bc', '2025-03-29', 'N', '0000-00-00', '561f3410106c817bc1098ea2c29c0d408033554f95a5029c33dd9c4150e69576bb40473eec3202542b66b79d54132293314a0cc3ec47d5cf22fb9b63d08d5db2', 0, '', '', '', '72_12_8_2001'),
('BAU', 'e53babd84a6ed734afcf1d1a12576a119ccc8bb659204622e06930870f05d0e8bf149f95568c867f0b1277438a4fcc4e9833708f63c4eb66138439fd5ca83754', 'Rina Puspitasari', '', '080022417057', '', 'user', 'N', 3316196049, 'N', '118c936dfb0ec3cfcd2981447671ab6c', '2025-03-29', 'N', '0000-00-00', '0715755022a9a507582a139596e5167014e39c7c6c3499823f964202835720c8276209cb5c3d2720ad028be5008b6a033eda396e66d699887efe18b433abf71a', 0, '', '', '', '72_12_7_2007'),
('BETELEME', '6397400f4fcdec4c8d768fc8b6f654d19a9d37c5c90bd50301f9f38822366fb6524b7e15a1dcc0e00a6c6c2a4ebc2154c5f9e4dd1990008b21efdda1939fa1a6', 'Siti Nurhayati', '', '080048039502', '', 'user', 'N', 6027904846, 'N', 'da75f11db262e84688260431dbc297d4', '2025-03-29', 'N', '0000-00-00', '68481655500641dfcc116155f2e77c95a51dec1c1672ed53e976b8667acc40022cffebb9f873649270766dc652e66fd7bdb8d168b7003643e746bde84bec8dc6', 0, '', '', '', '72_12_4_2001'),
('BIMORJAYA', 'd053e14836d1d2723a578d0c04201368e1f74765985fd98e5955dbef9fd06de9a4c2d6ffaddd920412b2ec5cde80111fd2bdae0d0cb312a45e5b123ab6cd0c19', 'Taufik Hidayat', '', '080072946341', '', 'user', 'N', 5664139880, 'N', '4b6dc1d59b353c811a9d9d8d95e0993f', '2025-03-29', 'N', '0000-00-00', '70e04276217319ff3983104261708adbbe708a56fad4e4cabe32283888ad3fe98773e40172c14e7e67d89571d9ac7ab99745349f05c07e357fedc3bd78638819', 0, '', '', '', '72_12_2_2008'),
('BINTANGORMUKTI', 'e5943b315e8438f1decbc66b39e244d14a3b89f0d78ed4c9b23a932166d3644d7e9d2ef4a32b3db8a1200155ca08bcea0a5727d497994a742699a30dfd5680a0', 'Umi Sholihah', '', '080020613204', '', 'user', 'N', 1235687053, 'N', '54b525d2d1eec5cc03c0b293e4f41da6', '2025-03-29', 'N', '0000-00-00', '96b44ab01cea6ed7e77ee04a3489ad70ff4bda7abc4375420e54ac1f97b5c37789580d9f4186c1c97f0bb13d755e58a4745ca1ddeca522d0ae24ae534411374d', 0, '', '', '', '72_12_3_2009'),
('BOBA', '92e1047affc65fd2382bacdecbb5a2b0603e30aca2c26029f3aab501d0546aa7638b16ac0338ad81fe63606271084f5af15f79ea888542ed6814e9c7343b7ae5', 'Vera Oktaviani', 'asda@dadsa.com', '080084226999', 'asdar_e2f995aa.jpg', 'user', 'N', 1456623873, 'N', '50bde1d237064b30a890511b33ff20d8', '2025-03-29', 'N', '2025-04-04', '022e00a277a66e1c6610012070ac1b11432e09b0252eafe20ea8ae43929b7a5e6c59817adbc3aaffd225e23b6bb5d6d6770c2a70bb4f06c51c513269a09ed1d6', 0, '', '', '', '72_12_8_2016'),
('BUNGINTIMBE', '5fd7cbd5d744fb9747d662cf2ef67c77fc90c8fb5ec46d254cd797de6588e88c3d51066e0bec7f94354fe107de68c221049b3a3ce23f75c9170be21bc29b8cbc', 'Windy Sari', '', '080059295387', '', 'user', 'N', 7742865211, 'N', 'f4c665a8eacaa3b7728339bb4c11e827', '2025-03-29', 'N', '0000-00-00', '911b5354532e03f10b4025a19702fef24d49ac238c9eed0214950c451ce3738e089c4887b2bf704fa06aac0257912ac4858264ba4cec1df23111232b7723fb0e', 0, '', '', '', '72_12_2_2003'),
('BUNTA', '41989cd891927ef851eaa124178e0bd1ae45aa41e60b7c0a841b7cbc46fe7013ac2539a51de15beb382e9983216a704eca15f4d756b79958fb5d573bec119166', 'Xander Mahendra', '', '080043795941', '', 'user', 'N', 5943504218, 'N', '85474b9d6cb47aaa13b1b996cbdaea13', '2025-03-29', 'N', '0000-00-00', '8ca2985492a2c6adf7d1a30c1232390920a264c9b4691b78eef6362ad6c13baf1edf13fba86c73bb274e94c72cb0aa88e72020aeed11b38fa02f4f4b83eeac78', 0, '', '', '', '72_12_2_2001'),
('DOLUPOKARYA', 'ad4f349f41aff646446f6770b8596351cbd3078cfc3c734d0b1349fb3600dd17e27cd44f449d27946dec498e3838dfab091de718a0a53f4d29619faf959a4860', 'Yudi Prasetyo', '', '080041093548', '', 'user', 'N', 7547518107, 'N', '52730bd116b88692c0693a814d82f7f0', '2025-03-29', 'N', '0000-00-00', 'd95c42be8266876ed662da0bba9fcb6aea8bb1e528e753ea7cd48990997241cc46db0411b72bf64fc394bdb37721033a5667b1bbf82629c1341cc56c185b889e', 0, '', '', '', '72_12_3_2001'),
('ENSA', 'e41aed9c649549abb23e89bfc3e5a3c36426dddfa1e958a496de0c9215269980717e2bc43139b3436958da302944974a549113c9d0bf93552af7829f2854dfcd', 'Zulaikha Azhari', '', '080074079919', '', 'user', 'N', 3721688240, 'N', 'c2144d116d6fcd2b6de1794d400db0a4', '2025-03-29', 'N', '0000-00-00', 'c4332a066ce519ae29ebbbafb07d7646a349e16dbf8f7cfda011dc756b0a313f5592b0743519051757457d6ab92dda4da4f1d47548d283685fa64f72d17d1541', 0, '', '', '', '72_12_5_2004'),
('ERA', '353e5e58939d447db777f2c57b4caf0b30613adede2b342f1ba91002076574661369ff9a36ed99b92e432563de07c1a133289fc9053ccb9be23bae4f55a572b2', 'Arief Gunawan', '', '080047118955', '', 'user', 'N', 8889391781, 'N', '9b1ae6cce48723ca7126ae4348523fc9', '2025-03-29', 'N', '0000-00-00', '220a1d87046f2a74da02751e9c29aa6b2b87dd3c40f87e1001c2861a1ff63894e2e4543c2a8a38825d30abb88812d8bfe7af289a5a8b5276bd2181017b678c2e', 0, '', '', '', '72_12_6_2001'),
('GANDAGANDA', '3941c5ac34cb44d879257f08a40e46da84c9f2e0e4679f29fd88fd149b71f69edad49a1ede3472f7d643aa54f9b0786f8552d261f74a325c638039682dc0d2e8', 'Bella Desy', '', '080013355022', '', 'user', 'N', 9671648089, 'N', '1a578c2a0b8017f819341a507e39710c', '2025-03-29', 'N', '0000-00-00', '1eb8492210ffa36258112e36ae30cbfe1a5675e104cef0afde19bf0cd2b455a180c7463d87bde5f73de7ae4fa6a8dabf7cb48f6c92d0b52e4e45e15e79e4b0cb', 0, '', '', '', '72_12_1_2004'),
('GILILANA', 'a7d1551fbfc10430af726d7cb0480ce4faf4bb45d9c4778f4bd5a7b317d95dd9e4a2bddfb29df4b6e8679d9b99583232520f6dd9724c34e72fc204d42f8accef', 'Carlos Subagyo', '', '080025418248', '', 'user', 'N', 8590850963, 'N', 'e78e0a47436dc5dcc43c232a764b801d', '2025-03-29', 'N', '0000-00-00', '376f5907f45e26814285bed60e7942a17248f97e91948eb985ba10c72e67f5325736c9cd05e976e82515e648ef880f27675682a441e1ff4f46322e413d449cd6', 0, '', '', '', '72_12_1_2006'),
('GIRIMULYA', '9dd9df9d86c092d4e98f7cf58d268cb5cd4c1de34da7c0504f233b8f0bed7b2bdc41ea9c6e542103ce96b8f93f6761d614449d7320542584d8a9695cb7534e79', 'Dimas Sudarsono', '', '080087026177', '', 'user', 'N', 9207091828, 'N', 'dd2642330b4aa66d65c6c20aa453d1d8', '2025-03-29', 'N', '0000-00-00', 'ac482941a4871a3870a8bfaa362c5728b6cde68e21f52f52f8d8a58f57f54159995b4ebb206044aa19e09f48656b33f5af014c467b6e12df474faf9e0e3dbc96', 0, '', '', '', '72_12_9_2010'),
('GONTARA', 'a26bbb684daf9524051bdb5aedc221b35b8655b552457e242338f00bf900a30b7596401e6f639674c16d9709b3bc4a7bb8bf00801dc9ec05ea366e400a25c815', 'Erlina Rachmawati', '', '080058876147', '', 'user', 'N', 3260395923, 'N', '779679a09b3c8840b7caf3aca854a8e8', '2025-03-29', 'N', '0000-00-00', 'f273c159f3559a78683848171ae876fb66ff3761d04270ed82727c9cb829a3464ddbf1bffe8ad5eec3260d088dd82f38887ba492d9966d1d37f79bf05b115e2a', 0, '', '', '', '72_12_5_2008'),
('JAMORJAYA', '4390f9c68d2a91455886a01c56b9b0d43778d95bfdc6a7647b9867327297e19fafe3f6e4fd1285a92e4e6bf5bde42cb571ca324659afe1f97e6305de9254c152', 'Fadil Fitri', '', '080033302205', '', 'user', 'N', 1475976658, 'N', 'f7f84ef5d073b9280afa7c14200afec5', '2025-03-29', 'N', '0000-00-00', '95195c298fa44f51b0cef722ba60adbfc7e8a1d8f11d8e026bb7048b20487fef8ae7d3fe882488e1b0dab6930e6e195ad9befafa7a403921719e2243e2b24915', 0, '', '', '', '72_12_3_2006'),
('KALOMBANG', '35ed6e445580207e1ecd0dec74942c351d36ace482dd2e81aca69345407b86788d9cdcd72fa8cb4b265b58bc4925c23d098dde67a5ec9a7cc78ca2822b0c1eee', 'Ginanjar Mulyana', '', '080089882587', '', 'user', 'N', 1465036775, 'N', '39f9286a1cee3fe280aa7425c2339fe3', '2025-03-29', 'N', '0000-00-00', '422cf53bdb9b33fc706d391eaae39a0ab5885ffd9dc2b673e3ce5c5ea385662bf26beb1999bc7f39fcbe6c1a960ff2ad92dd3bd6c97849b10314c67f55bd8a19', 0, '', '', '', '72_12_8_2017'),
('KASINGOLI', 'ea3a77fc44970364dcfce51b778353082a51ddb06465117e3c40f6a0fbea5250a3f10bcadda055d29378925187149e959ab3dc072624e995faab5c938442c1c6', 'Hani Zulkarnain', '', '080049506324', '', 'user', 'N', 9994137602, 'N', 'c12e801ba5f720839754d5b2f1a78550', '2025-03-29', 'N', '0000-00-00', '739faa018b022bcea10bd68d8946b8c8cdde580f6e53665fee4687a34905f600654bfee6df2b6d283d449b06729f3134d0fb27044f4203f4e797f3ec8dc10646', 0, '', '', '', '72_12_5_2011'),
('KEUNO', '74f09ced322cdee39760cd95d5af341e6b34e3ba282cd3854fe6fb5b82bdc3e74f438a09d6c1e091a9cc8be7846388bae20cc3105988f39f77dd1d50a7e5ae01', 'Ingrid Suprapto', '', '080077883861', '', 'user', 'N', 1299414809, 'N', 'e81ee737d78337ad97fb194ff813ab56', '2025-03-29', 'N', '0000-00-00', '52eec76e22e31771dff436df3d372a9883c872e4189e34b1a409cf04818cac247fb90663fe8623e2b901946e594221ddcf76fc11c7b55374c12c269165546254', 0, '', '', '', '72_12_2_2010'),
('KOLAKA', '2f3fbcc14497ba3a1ba6d3be87b67d007e844d335a8cf51713633edfefaf47c93887b2bd9af73bd3ebb712ac0b2b2a7ddab476c708c6462861d67d37610411e4', 'Joko Santoso', '', '080040900339', '', 'user', 'N', 5944772253, 'N', 'd9aa0557e07e7fb93816537113c0ce08', '2025-03-29', 'N', '0000-00-00', '284dcd1a84f0e75163ea19178704b7d0c88bd3d909738018f0c4e5435f2b7a306d70fddfd436e486d2a45752abcf7d25b4a13a5805903e984bdd203e59eb302f', 0, '', '', '', '72_12_5_2005'),
('KOLOATAS', 'bbbd35579a1a0b7824448b55284ea63963cfdf2b8bc748803069b6cb43455677e36e23463e0bd44e391494aaffe7333e316a138b14c00cecfb21fd6206635a40', 'Kiki Anjani', '', '080070850117', '', 'user', 'N', 3158747562, 'N', '756d33dd5750dc9bb36c16eb66b7b923', '2025-03-29', 'N', '0000-00-00', '30b95f04a66a36a4170ea49c32d60cd15c94d8e9ddfe48b0ef55889cc4d68f784e165b6413dd80d91fca08f6e51b4c58d76e29b95e00b7f05a6726c4e47f6d8a', 0, '', '', '', '72_12_9_2003'),
('KOLOBAWAH', '950bcc05e3382e04b62ef2b59cd268658866c4fd3f4aae8492231535ddf9067b5a2f8f78fdf67ce059a0d9d279a23947a35d4b6b51dd0ab920e2fb60e58d9b59', 'Lia Maharani', '', '080031549570', '', 'user', 'N', 6172931855, 'N', '89f97b4ab65c5f7f6031ab6c1430244b', '2025-03-29', 'N', '0000-00-00', 'e388792554c250b46420ac8690ddd7c7484115f282d7fb8da6a1cea5ba5b5ef4c7e08fd83c24fb1818dad776c61f3b380e7690812808e50a83612499ed28b306', 0, '', '', '', '72_12_9_2002'),
('KOLONODALE', 'b89d4387677e25cd39d8783bb4c224e67113e2da193edab7c1a6d08b9f40cb29d14246d22862200a5a063827d98b671adb6ed4ca99651cd7381897170f8b9bb1', 'Mario Edward', '', '080045197501', '', 'user', 'N', 5396629652, 'N', '84c1e8de221360cfc005bdcb75dbb96e', '2025-03-29', 'N', '0000-00-00', 'd68bf6a58df2a22d53d72c6374dbcb391e5870b1e0f61e0f14d498563bb89458d9d9fae2c90bf25601d5eab6f5e776772688933e18f699d3acd80155fb6812d0', 0, '', '', '', '72_12_1_1001'),
('KOROBONDE', 'df11223cadd57c430d1c4c64b6fcb5cb9bbdb8c81a04f3c57ed56c21cfbf3eaf121acf0de73a30d061cf60095d9bcd123059b6f7e887b1a5925c7c9ca0f0c0c1', 'Nurul Aini', '', '080031338799', '', 'user', 'N', 7301274638, 'N', '7ba2d91c9fef8184018fbb28706b47eb', '2025-03-29', 'N', '0000-00-00', 'cb5a536b62fb7b2c7304b2c43863689c064069441bfe35be83e63e47a19c0cb366baac65f41b1cb5bf8f77ede982985a00dd4be2a9bf0ac0e742e36a6e21b942', 0, '', '', '', '72_12_4_2014'),
('KOROLOLAKI', 'a1c4bb42de0577b73c0f246c0388e3cb40767e64ac9ac514e271504ca06959db55fcfa161f107f20a1df9c5825000f111414779ef1af7c5073d58f53f92553c8', 'Oka Kartika', '', '080021101496', '', 'user', 'N', 5123684562, 'N', '66f234cd6bd80f67bb0a74b3f73eeab1', '2025-03-29', 'N', '0000-00-00', '8678a432f6553d9ee10b2336435406827e002ea7ff8a6ad28872e2bb6340886bea5f200b7171b704986408355f5084bc6af312b17e1802967537d514369d1282', 0, '', '', '', '72_12_1_2008'),
('KOROLOLAMA', '7e140766fc9b814c3b64e4932c8280eda102805a42dcebcad4acc86a0bdff4acf245cd72a43ddfc5ea049a9f1b0e61b3b7115deaf022613039f9af18b2999d8e', 'Priyadi Mustofa', '', '080011491089', '', 'user', 'N', 4548846988, 'N', 'd967266a5d8720465cdaa4f1623e3c5c', '2025-03-29', 'N', '0000-00-00', '3e0f01d71ce29083e2db7d715c7190ee23793aff0d268ee9cfe09562b20f0d95c5dd46c396fefd0f2bb8fea1649b8207e117ebc9baef50afec336e8ea1b7f4dc', 0, '', '', '', '72_12_1_2009'),
('KOROMATANTU', 'da5e3334ee9d0d4c058c61d299b865dc3898caf36762d83279ed37e20f9a428aca30ab0a14b4967330c9b93cd218cd563349cffc8dfb8dd633372a0949a57309', 'Rieke Anggraeni', '', '080094150957', '', 'user', 'N', 4406411027, 'N', 'a541228edeea715200564387b9e54ec6', '2025-03-29', 'N', '0000-00-00', 'd545f2a35c56e2110d2675f8ee6ae148beff572f9a3d60a229598ceff32dcb2818f487ffa9a2747addfd594d757cd6e04e1eac933d2d9771d9e7ee584df02dd7', 0, '', '', '', '72_12_1_2010'),
('KOROMPEELI', '4c522db157fe76f8c68bc967e2db0a7b73a9b41f3d4a1755ef26d4dd87074c5f27a363f710158607b57ad142175b314411ba4a6618e06e4e0d36c38c9bab2378', 'Selvi Maulani', '', '080036281523', '', 'user', 'N', 8660025606, 'N', 'c3d31ecf73efad4f49cc119f1742e95f', '2025-03-29', 'N', '0000-00-00', '7f4e9e59cf377b18cb24d58e97795a48f41e5d504f46472bcd76923f055b9210fc380c36bb89121772067aaf606ea1fb1918939dfd79df85290dd1d7efcc7394', 0, '', '', '', '72_12_4_2010'),
('KOROWALELO', '0bb7b2c53a3a0c613bf9c68a466fdb186c532786ee62480316df59c88ff4fd2c1df21eeee68dec60d7c3dcb80c7831b619a9e27ea80e80f5573fbef68c6a52fb', 'Tio Sigit', '', '080098954746', '', 'user', 'N', 9612884909, 'N', 'd851bfce6bc16f0cdda2b27beaf38964', '2025-03-29', 'N', '0000-00-00', '18ada67d59f45b111dc8de7569ff41ed146a738cd691eb7d1b241f650cd5aa650d3f6060145248e046ca65a9fd77fbc34b1395ceb606db29152ac7941894e9c9', 0, '', '', '', '72_12_4_2007'),
('KOROWOU', 'd980d51592f5add12e391f77568612d310f893569cf8a19ce25e2b074bdcbf2dc5ccadecc6331a391c56a13641b5d63eb8392266f7bdd4b46ca19bcff789aea5', 'Ujang Pratama', '', '080085929167', '', 'user', 'N', 8937115483, 'N', 'c40d64171346a02cb5a326b76b231774', '2025-03-29', 'N', '0000-00-00', 'b4ce79966f3afcc9122614aac61e812d8c081716ff31fea3d5ba40bb642c134a4092f2d4e5b4d68f91ce3a0c0d3ef1f2e51c29bdd02d04cbc675857f98e4cc9c', 0, '', '', '', '72_12_4_2012'),
('KOYA', '464360bfb94b0a59af802f5c628dbf1a6472c704225bdf2f6b40c9304474907b4f40ca6fc7b9bc2edfff018db8a9bb5ab4f5000f1e9bf0a4750e2baee36fbc61', 'Vanny Arya', '', '080032781601', '', 'user', 'N', 8618668331, 'N', 'e73c9e5691eca6dd71fc71f6b6ae59da', '2025-03-29', 'N', '0000-00-00', '217aad9e97055b948ebdc20edb14beaf174380258c9dd7c297d23f00584c309a6243ea05d3bcb427e4f844af24e28f21945a1c0f794d999b7dbadab033e7df42', 0, '', '', '', '72_12_1_2005'),
('KUMPI', 'f67d03789bcf82c9f4ec617cc1f47511a6fb1cdc0e628183ab370ef902f632929e9a4f92887735cfe9c754e59ddedff5f03d140074f458b93fba4fc265255fce', 'Wahyu Saputra', '', '080006120505', '', 'user', 'N', 1265969362, 'N', 'b7c7b079909d2dd9596e7256fbedebbb', '2025-03-29', 'N', '0000-00-00', '4551abca44aaad89c5ec8d43ae6719cbc3b9244cd6c9025f19d7dad547df0963334683807200f9b547a17a178f72f741d0305686870a1eeff9df529367084b78', 0, '', '', '', '72_12_4_2009'),
('POONA', 'cc18db4bfe93be340370ef670be64ae0da521f52e82f766eb3fe80916a1c5a12aaf2f16c89e5480966707e05d7ab7105a1877d25f792dad1ebad725b2c823c14', 'Xena Purnama', '', '080032257726', '', 'user', 'N', 3897458369, 'N', 'cf53c241614d611f2f055a8ce3099691', '2025-03-29', 'N', '0000-00-00', '75d6ad77260be0f5567695852f83a091d6fbe35f6774935b3d9d13a98873092e809d4ae91f1697104f3ec2ce3bcb7d21c4a0d3637cdb773d4c2487c600cb755a', 0, '', '', '', '72_12_3_2002'),
('PONTANGOA', 'cc21392a63b1b6972895e0c23a76274e70e79b0b92f84df91495fc3be17903b481e13eb0a04f7be45ae6e284511172ab67116f81618f6c7dae117d2c9b2e3ecf', 'Yani Susanti', '', '080042927118', '', 'user', 'N', 4322202773, 'N', '15da76dc0262303643c6823da9f8dd2c', '2025-03-29', 'N', '0000-00-00', 'd3f001f69c6966d229f6c8ffc285ddc99b2e546e90066cce36678206c51182a47aaffd761c8b0457b3c1c00d718ecdb9324e6db6144ea7814fd575d3daf46350', 0, '', '', '', '72_12_3_2005'),
('MENYOE', '8f034dcd1c88aaf9d043ef43729a6e613e7a3da1b94952811bc07c2d61611d866031aa11f7c51c54fdee1578e96fbe4611a6ffcb66323e3590a7487a4950a406', 'Zulkifli Ahmad', '', '080017862416', '', 'user', 'N', 2833415258, 'N', 'aa92406579ed1d06903e81b2bb62d2da', '2025-03-29', 'N', '0000-00-00', '15eb94a057a4b1e72106b2fbe88f77b70d8830c067b89fa0bb6bb782fd73302e1f708c17eb532c7b89f004bbee59558d73ce771040315e85e1d7722aa56e32f6', 0, '', '', '', '72_12_9_2014'),
('PEONEA', 'c1c98397552fa495468b0809f6a86e9cf536c65dad496925f6cf22e1b69c66dd7c88a49f78e92b8a04d840036ddbbfcc69693f5af7418085921977e1b1d3231e', 'Amira Lestari', '', '080060530732', '', 'user', 'N', 4158890011, 'N', '676e378321609490865662d7d0f3dc0f', '2025-03-29', 'N', '0000-00-00', 'c26dbf6a760db64a8994a0e82c1a3c19ea496f6be345751280229d8fced6ecc6d500a8d9f979947aeb875d94293280925cee03c7c5dc87993cdcfa3a0ca661d0', 0, '', '', '', '72_12_5_2006'),
('MATUBE', 'b031ffe32ec6bd862466673bf15a9ccca2d649cd279dd55bff01dc6e60791f977bc04435a9f342aaf7b0c9f4808a35eab3cebffe94dbcb38a27a827d74ce8b82', 'Bayu Setiawan', '', '080049066412', '', 'user', 'N', 2754701576, 'N', '014c7d7583d2b371d71055901ec0a365', '2025-03-29', 'N', '0000-00-00', '134556adbb74216ca61959fbd2b61d792fbd5d014727873777400165780f77a8080ba4740f276ede947cc7d1d2df7b32526b141583812ed8df79f2532d67213a', 0, '', '', '', '72_12_8_2019'),
('PETUMBEA', 'f027053f7166734d7d78c777af1c54d1c83c07258aca201106bc897c5ed64e87fd05d4d096fd7b65527f10dc4711e991f8108589a8d542370c7d41dd36403694', 'Candra Widyanto', '', '080063739870', '', 'user', 'N', 5162014815, 'N', '0b178484e8a0f68568566768f63cc079', '2025-03-29', 'N', '0000-00-00', '23f016d78ef3cf0b93250835cb5d47b3aa9e8121cf28261f2a9cb078fc9bbecc26b8856cca7d1698327b6db24b7039aab1ecd967f6eda5687fa97943bcc56247', 0, '', '', '', '72_12_3_2003'),
('POKEANG', '61c5edde29284a863258f02a9cffd0ec61994c134db5e631fe5a8628fe3851060fee63486757a3a4d4da79ed3f14d0003fde765f5a8440ee65e6c1147edc47c6', 'Dina Maheswari', '', '080071500116', '', 'user', 'N', 9962686280, 'N', '36091bcbc5e84fe9f0b687e0ff37cf84', '2025-03-29', 'N', '0000-00-00', '56274f96ec6fbbd2f67cab9b23949b33e011fbbe2299b2aa40abe41c38ed2198043c00876e0a0be3834281432e48bd5f7beec3aa5c2ae33dfc679196fec0faf4', 0, '', '', '', '72_12_8_2023'),
('PANCAMAKMUR', '74e3912757c6cb6249682cdc524029be6660ffa3eb447230475b700ce5d354c93dd491caf39ba19e3cdd52b68637085c295bf2b72b3dc8f3cfd46c4baaff82b2', 'Eka Yuliana', '', '080066280974', '', 'user', 'N', 2727371407, 'N', 'd3f27990fd0dcdfd8a385a2f176ae388', '2025-03-29', 'N', '0000-00-00', '3c22ac8b9f74b47967c43fd1d3412c8b04cece5c6d9b4162045881f40281cb6bc2552ac8423d1e59136e7434116ada8d0733f9af99494e8fe84e0facb87281e3', 0, '', '', '', '72_12_7_2005'),
('POSANGKE', 'ff953fdfef7aa0b46ba66f38008ff45a775f2fc878878c96e867b59c801603eea7e8b18e6bad2e5fb3bcca694ce2dbf83d17e3978d9d70b5f037b0ee2abf7efa', 'Farhan Subagio', '', '080016904524', '', 'user', 'N', 4612863821, 'N', '9c4b02e300aa4b269c1fa4e93225df90', '2025-03-29', 'N', '0000-00-00', 'e97002cafaea11b443710062559f19db1fe9c50753a958ab94bf8d9f3b7c9b6f4ea1bdaf70024824a9f4668ed75f5764af44a8b1ed38c5f724765523af35d842', 0, '', '', '', '72_12_8_2002'),
('MAYUMBA', '5520c53740c413709116524a5ead45e7a374f63b8e0a7c127fea46300720135a7f82fb29a8e738f75ed040a0bf84adf20102628364b4526e14f1cf7456223cef', 'Gali Wijaya', '', '080085679703', '', 'user', 'N', 8607271869, 'N', '1355d4effccc0f340cc79e57a2d3f0a2', '2025-03-29', 'N', '0000-00-00', '475693fc2224e97a94df234208b651ddf6773127e4fb7fbfa1757e5b163a243bd37be2c082f3a957a563fdb4439e20aed1d7eb79e00f3222b32b68f20b2cc6be', 0, '', '', '', '72_12_6_2004'),
('LEMO', 'ae78f491f7bec93f703f88b28b18935ed171a2f86e4b457506fc74a83e7fe6b768323c6437d89b759009c99d2e4bb6eba7b77e8e9280ae5eae78483e8a2a542e', 'Hilda Pramesti', '', '080077684948', '', 'user', 'N', 2035266275, 'N', '3d2ee1e9958077e85215f33729786505', '2025-03-29', 'N', '0000-00-00', '78bf1eac9223649b9ded6f1e7999a7b6fac9c1c3031eb4ba2d01e98aa25378692f344b5f6320adbdff3e68924a129bbba4cc853fbcfdd8f51551550eca5ace2f', 0, '', '', '', '72_12_8_2009'),
('MORA', 'e81fe226e387be7f5c0d7d29d7c88040bb715170e955b2b1e50b8bcefe9dca870b7a2eb29057e0dc4261fb503c3fd399a174f83cfd8ca0d6cfa9b69ebe807138', 'Ignatius Soewandi', '', '080031385633', '', 'user', 'N', 6866822606, 'N', '5cc3213a7e69acc46690d79ff8c8523d', '2025-03-29', 'N', '0000-00-00', '680afa09511b71ce266e66f69afd2e382ca368ce6902e8681cef4d9f15e8baaf5b5c9a78cb87f8980d23cc108f75a0f5a0e793354d7e2699f9e36925c8d673ce', 0, '', '', '', '72_12_4_2003'),
('MOLINO', 'dd633b1127492e65d5ae64e2483fcdc68fdd7229d0e38a5bb871f499efc0cc07afad5ef90fb7f60268b948c45d6c50d136cb314640cdfa89223f5bf0f2047588', 'Jengki Alamsyah', '', '080023873325', '', 'user', 'N', 2538870069, 'N', '924b98e0d8ec416ca5590548adf97857', '2025-03-29', 'N', '0000-00-00', 'a9ada09b6aed776aa1b6c27cb950424c10ba82f9fc66213d078607c85b6f97d805cb68c3c359e35ad7c95a02484dd94a491d27dd333d4f094b85832556439941', 0, '', '', '', '72_12_2_2005'),
('LANUMOR', 'ab37048ca27f6d0a9aa3986c78bcf2addfc3ebdb9fa50fde508e3e31c2ed1682de754b22d49c4f95d71957133ecae4a72eba3dc5d72d96683c8c9de302d12f28', 'Karina Salsabila', '', '080025209729', '', 'user', 'N', 4315543964, 'N', '4a74dfcc259620b2540fa91d3882d232', '2025-03-29', 'N', '0000-00-00', '9218fd6a0b11433dfa0a6fa0fa1558dd9cfce5a98be71f4859586d142259d414a21b9b3656981f1e0b1b5eb599ae287a4e3cf4abb9184ed1879467359cb3690d', 0, '', '', '', '72_12_5_2007'),
('MOHONI', '0095cd99d8cf08bf19b16b9ddd1cc921742b98ff31b0b012f40b21d03c4f5aa759eca3c50ec01c140903cd184d82fdbbbc11ff1f6333785b020a4956f0d3aef8', 'Livia Wijaya', '', '080054428672', '', 'user', 'N', 7548856864, 'N', '70f399d086f7ea795fd8f51d91196d73', '2025-03-29', 'N', '0000-00-00', '048959c2bdd553aa9589ea2622448fce3b06d15cd1f7e96ab68531948f69705e40f7d3c8505d1f3321439eb7622d6305b720d3f70ef70080d67bbb6920a826d6', 0, '', '', '', '72_12_2_2006'),
('PELERU', 'f17ec30151d682b1a860b892c57dccbf9deb3fc67fa34def261895ea1b08c67bc829c4fe1a13a8b8623455fb74ecd5d0e000156e47c46bb0a4c906b24b689cd5', 'Maliki Prabowo', '', '080096514177', '', 'user', 'N', 8243262563, 'N', '9757ccbbddaba8832dd437c2ef5c5a8e', '2025-03-29', 'N', '0000-00-00', '049feff86d2fd853ee9c5434d3acd6a4e3130c33163123f96708d06c2c7e9711cc0879e11d35a604d32904e20d8f3e082f3af6568f7ef2e6f68cdcc2539069b2', 0, '', '', '', '72_12_6_2002'),
('PANDAUKE', '8264b29b7a3144104859c7946f81567153e092a73a858f4235c0f7916a22131a54492cbb56e7256352cfa0913f4758d7c8ce5c24d78e69094c3f24a510cc78cd', 'Nadya Karina', '', '080019284875', '', 'user', 'N', 6771546285, 'N', 'd3cd66829f33042db35890dff5d3aacb', '2025-03-29', 'N', '0000-00-00', '5c656921d129279d7142be1607f3574f879646ad1c3df5febd5519c8e77fa1878f2323d7ee2fadbbcb88a7ec90af599389d8f525966a60b542ed705caecf7663', 0, '', '', '', '72_12_9_2001'),
('LEMBAHSUMARA', '181d8b4aec93e06b4eeb8feff0075da397c16edcf75f3e30c5f6a7846082ecaeddc8c85b20c0f6dea513334e795ec998be0a9addf3ba409196e9c06ee26d5165', 'Oktavianus Surya', '', '080006881846', '', 'user', 'N', 8177033326, 'N', 'b4005db18d001d722fa7a67f2d0e4250', '2025-03-29', 'N', '0000-00-00', '931c1a07f927ab4e8b22f963861584647589e37e34a55a7a147cd845e8e0216b9e09efae98243b0701c38eadf7aeb880d2e27341643fc526da5a4745d5b5b448', 0, '', '', '', '72_12_7_2001'),
('RONTA', 'e79a4014b8fbf302f1690d5edb649d1de11b489e7154a7814db300d92cab1895432748eed38c11cfa772dc26309aa58e7ea18d179e6c658fad71ed4e1f620543', 'Putra Bagas', '', '080076554607', '', 'user', 'N', 7465138888, 'N', '6a9e57124d54f9b5c06650866cc379f3', '2025-03-29', 'N', '0000-00-00', '3f63c58368863a496689f6674bffb2ec83bd62cd08b72b0b1ff28a68b224b5ed24a697e01ac613acf6a4c7cb74a978cb10266b8c324a332b27d0587aeb5a644f', 0, '', '', '', '72_12_3_2004'),
('SAEMBA', '75b8ffbe20d0f1a4e63ea7a23098f00d883d263c5551920050687e228c73e9607b437b0a68ec33664040fc5869a978a2fbdc88d56f394aa02c49a67a26c6dfc5', 'Rizky Fauzi', '', '080062127503', '', 'user', 'N', 6630229176, 'N', 'a601febe3660e1822f116a612ff834db', '2025-03-29', 'N', '0000-00-00', '25dab1dc936069c1046cb2a52ff939c0526bcdfa8dbbe828069130d1cc283a3f8903928fda930aeac262c0f9a86b58b33f0ceac34de35ca254543a8dbb4fcfa5', 0, '', '', '', '72_12_5_2010'),
('SAEMBAWALATI', '3dcf6f1ffe1104fadaf2512bdc51cc06022599a10633183dfbd255e9b9b3ef286fbb325bee422df4d23140f59d95f4d0b1b7f0084a79f0a80898aa0f5a73afd5', 'Shinta Wulandari', '', '080080973695', '', 'user', 'N', 5754333370, 'N', '0d9411b35cc97b2413fa6a3c85171967', '2025-03-29', 'N', '0000-00-00', '200ebb1f4c0e50031c0c018adfd0e978cbfa94f213cad0d32cd3a58826b96f2fc43aae51cf36f79118e6851c1ee66bd3318d1fc700803f8e50493b06012e1188', 0, '', '', '', '72_12_5_2013'),
('SALUBIRO', '4842908d948ddf6d1fd9beba66b0a3edad1af9b5936b9dd91da5adfb042ebed40811f8eb40fb3c4738a52b92a2a3680b615f0bf300baeb099a9a53ac6567203a', 'Tri Lestari', '', '080018485970', '', 'user', 'N', 8313037367, 'N', 'a14d02653350e4997b3440a58d096f1d', '2025-03-29', 'N', '0000-00-00', 'b857ee4b2c951e6a8fae58a35fc1090a25128162759d706aabfc122e6082178c1688c6797834bda7dab1cc4a99808d4d17e1490a519752d9ab57ff71d8571585', 0, '', '', '', '72_12_8_2010'),
('SAMPALOWO', 'b62ad1cdd1c029d35188382ff637a9a8f00d6a2fc5e1d293c9a113aedb7686b2088500b781b5faad1e005da84d74140a0cb185a8940c4420aef4dc83810fdcfb', 'Udin Mulyana', '', '080049508770', '', 'user', 'N', 5409115198, 'N', 'c93e18c5d107fab26be71d4b3b1668f7', '2025-03-29', 'N', '0000-00-00', 'e4d1a52d5ce6384ca4ed05863ab38b2cd0901d193cb03a4a52a604e7f1b030a6cb3d09e39d6fb21440b2fea4120f9e788ad112f1be28e3e4635953e7fc1c817b', 0, '', '', '', '72_12_10_2022'),
('SEA', '48da9684f768489b946d0f01e3f62bbe0afd2647465dee656a1979be602c5cb695eabf6401573d1cd00d5ea21f8af7e027de840538a59e2df6e34099c47945d9', 'Venny Prasetyanti', '', '080092085945', '', 'user', 'N', 9435099258, 'N', 'b1d5c38cc4d9bb0f14b56006a5b20236', '2025-03-29', 'N', '0000-00-00', 'a131c023ccf0d705cbfa809e04f6413585eb2df73c866970ecb365e7929fba4464039a4fef8be27dd445cecb31a342131adafd538d463e769bc626339450573d', 0, '', '', '', '72_12_9_2013'),
('SILITI', '8f82d497434b458c920f201fad93a9da6211993e2abd7568ecea7f7cf50d3dda1d2309f7527baba10b52a6ee25f167c09d237474458704937098ac98ad072331', 'Willy Hartono', '', '080011903417', '', 'user', 'N', 4407626429, 'N', '72448abd5db18d8220eaaf91d5f3d786', '2025-03-29', 'N', '0000-00-00', 'ec80450f7b658a6e08b21fbb012f773f420bffd2e054d5993b6f38c868873e53fcb0011f77edb30a9037e16e2e12a3b2ab91ed35db1f7d156d73b074c31b26cc', 0, '', '', '', '72_12_8_2008'),
('SUMARAJAYA', '8818182ebf2abff93d324033cc6a2f19789dcb03b2e0538a86475ccb2be48a1c45b38bd82b908bfe9ec9f19775023bf5c59774cabd1f573a4932837284ac97d8', 'Zainul Abidin', '', '080083259254', '', 'user', 'N', 5190028330, 'N', 'cb94b777881609feafe592cbe9186580', '2025-03-29', 'N', '0000-00-00', 'f73c6efe98632245b9c56ec871701d6722a618848c13bca35f9c01b4a695fe44a9d24e683981f41e982e94710874f571b7accc67514f6ff105bc5d959824ee28', 0, '', '', '', '72_12_7_2002'),
('TABARANO', '2c33f6c68f547686352f69bc0f7cb97bbc258ab29fdc87440d9e0d28fbd259dbb42b4ff392dedcc43608711feca43e97cb15bcb3e325a1f4967cc3b31f738683', 'Anton Junaedi', '', '080080586024', '', 'user', 'N', 9426923442, 'N', '878f32f39e6a3c2b2a99d9848e58516c', '2025-03-29', 'N', '0000-00-00', '585ced40c22a3d4cecb0d1ffcf1c63d07600feca0fa30e33b76e7a43b59d530497f71f2134bab28f9963e8deb9ad8c84ddc19ace545d9a3d76f4214b3491672e', 0, '', '', '', '72_12_6_2007'),
('TADAKUJAYA', '31fee9bf83404e181dda1da4d8e87b75962d504e5d59d7834d2a74ab315837d0dcd432551824f44e9476a924b2ba2275b1f740bf09d620216775d015a5f12170', 'Bening Ayu', '', '080053152362', '', 'user', 'N', 9391807683, 'N', '5b52cb532286f12daa7bd8feca00cb74', '2025-03-29', 'N', '0000-00-00', '22de3b5d12bb12c7710dfa3877d4315493effa9ed81e4a70c1585d75ebd58b01a4e677e834fc8b276543dd7a462dcb5490c847b82e084332b3c5d98b31e6cd2f', 0, '', '', '', '72_12_10_2026'),
('TAENDE', 'ef79f273bcc5d7abb43e544b0f22b2f3c8b594a07ce5e0006c923bd4ae5f5a862cbaa7c5133a6feba4242211dd1508dfcc676c6aa3fb162707b2d161d3f79b6e', 'Chandra Darmawan', '', '080024003740', '', 'user', 'N', 2833864910, 'N', '14ae6f673f991aee6a3488f0fd421059', '2025-03-29', 'N', '0000-00-00', '53e7dc276968af821572e802b820ac89885d9d10e07b1b0a4c0a6b687bcba0d470b6fe69495849a13e540e28a647b7c08972a68e058da10943d8c69f92d0e8c5', 0, '', '', '', '72_12_5_2003'),
('TAMAINUSI', 'e6f8de556bfcd6d4a38bb061c9d5427e4493cd893b71fe0463aae230e2db41b121c8a0ceebe31157fd988f8a82edd8ac2a60c8ac8af262b5d9a370d96e94c88d', 'Dina Mustika', '', '080060561616', '', 'user', 'N', 3998553178, 'N', '57555ab1a9c3c2c5094f9bd3f90e7c4c', '2025-03-29', 'N', '0000-00-00', 'f10c76437dee62fbc9360e64888a086ac12be40443e0d8ef8bf237aad0df8bb62e8822af02a83f5cdd018aaa6cc20325d1196c92cb278a763bdde6abfecbf046', 0, '', '', '', '72_12_7_2006'),
('TAMBALE', '9a3ea6b038d8adbdb53686bb992f9697cf1f7be9f42dccf64bf060aaf4aeb545d52d98f8bdf734126d51cd2c4e38f5d4497749c2221f58655b9242d2bd0f15c2', 'Elang Saputra', '', '080030796866', '', 'user', 'N', 4640346689, 'N', '92402cd29496c27c667e7e69a9833c7b', '2025-03-29', 'N', '0000-00-00', '542612ccc053057a1c6207aef53da78bf2cd59b1964e415eaa8805bae006458d0a503916fcc0a3efd3cdb3b7affd390ed0e87f26443894df9e7cea7d93772f41', 0, '', '', '', '72_12_9_2012'),
('TAMBAROBONE', '1e007fa114ce1b35663e5932a57339754b06ccdff980ab467c7bd535b611bd4ab195427aaf05b5be46733c2def084723d24209c7625874b20885764133e089db', 'Farida Sari', '', '080072299487', '', 'user', 'N', 9474892901, 'N', '10fe947a62105c64dca5f63fe6ebacb4', '2025-03-29', 'N', '0000-00-00', '7fb7eb87baa50d5f3417c3d5d32eac9772d8f5f9bb938f209a395ebc3a40243011d5a32b9bbaf486e1eafd0dabcd3be4d71a4a0e1da845e02047f84c7a75044b', 0, '', '', '', '72_12_8_2014'),
('TAMBAYOLI', '3081bfa9c52344f86a72bc3ec29f266ebcf212bb49b4bc474a75a37f16eb204462b7e524bb99ea4dfc29a6388deca58668292e782be8d23fc191d6d0378fd981', 'Gita Anggraeni', '', '080069106839', '', 'user', 'N', 9443862852, 'N', '2e34bbd4283589e94f5a41a15724f4a8', '2025-03-29', 'N', '0000-00-00', '298ac4b78852e4853131ed9ca00ca7066fb4b42101a7e937d25feee188d2105879f08b7bf00ea5fa2dc0df494b4ad0816ce00a167bb6cd819c0f621fb857edbe', 0, '', '', '', '72_12_7_2003'),
('TAMONJENGI', 'e0e8bd81043361a1e6b87a3598af36ace3648622d96c1d7d7bc8e5dfd72494820130be8f153ccaba9273d95774b832c16519b59d94fe3e8a21ec8322775bb062', 'Hanif Sholeh', '', '080028635736', '', 'user', 'N', 5030645745, 'N', '020b4239cb3a7656d801cf36222d8aaf', '2025-03-29', 'N', '0000-00-00', '7c4c144d2380fa797dd14b233f46072a5b603448c4938193aabc93ad7e51aee44dcbf42fc34b7a4f2eb138a381d9dc28701156b935592f9dc4b9c73c3e6c61dc', 0, '', '', '', '72_12_6_2003'),
('TANAKURAYA', 'd7161619ad48d07dbba41ed2128c83f3d2ab33502e9d0379752e0a9d409e3444d53b82930d248d81aef4268cfcb168cf6541140d7a64f5f7e1e50feec6763256', 'Indah Sari', '', '080035858167', '', 'user', 'N', 9485492945, 'N', 'f05dd9226ce072d4acd9df2916afd87d', '2025-03-29', 'N', '0000-00-00', 'f15b320541da142f381fed12e56ee7ebd46b60474de5d22389f21e02a244f5dcbba08885c620f6fdc9c094bbf760daa74f70e6fbf54bcc68927d19b5127dbf99', 0, '', '', '', '72_12_8_2013'),
('TANANAGAYA', '4fcaa95741ca6de75a2187fc88d131e2328b00bd1a89af7059ebdb5daab6fd949921ad89544455eef80c3497803089502cea7a8657f664be6aa01d4471cbf4a5', 'Jericho Putra', '', '080093383632', '', 'user', 'N', 8387913729, 'N', 'c570b3622610ebb68f7d3fb2904b3140', '2025-03-29', 'N', '0000-00-00', '3d0bf5d0c306e2ee06fb25d166932069dc41cbdc316be549104fbb08f3ab225b72c178bd89a534da664a2bd039f031d16455420e2e46cfc24fea81f996deeeb6', 0, '', '', '', '72_12_9_2005'),
('TANASUMPU', '7af2fb9041bfa096de2228f760718c80ae23c162f715ee8aeba020671c2e8196eeacb602fe7500d37a80a8793cef0597f94d022bf1f6c39782f07a465f5cf510', 'Khairul Anwar', '', '080059343662', '', 'user', 'N', 3086378788, 'N', 'cb57cb135c095748fa44527bf0312c3d', '2025-03-29', 'N', '0000-00-00', '4834f57978805e5a232a311d97a6192faebddf31dd9ded1da4717937d7897317430fd8829f702476097f3e282b06a51181e52639f7919f17f7e0cbd496fdabe6', 0, '', '', '', '72_12_9_2008'),
('TANAUGE', 'bfde43168b38e355487915dbcc4c78a5573b2787ad0923ca9bc6548a453eb81cef2711780fee64c1df947631b7567f13a40231058418de8b16cf7dab57ef4049', 'Liana Wulandari', '', '080016567419', '', 'user', 'N', 7808231194, 'N', 'bda8ac1e63e87b377c4dfb9a4e8b65f4', '2025-03-29', 'N', '0000-00-00', 'ef313db6324eab475293d3c3ea66b092e7d4237f6c5eb138796a66d8f7a56e59b6cb0db00112cd78bb81a31546a2ce5aba518f6937cef14b76586bb4613b80b4', 0, '', '', '', '72_12_1_2007'),
('TANDOYONDO', '642e070fa129219790cc24238f3cb2769d677a4aa4358f4ee4ffc9c9ca661413a685d53896edc3b6699b98d21bec8e40af325fa0ad0db0af3cfc1b5fbad595c6', 'Marisa Fatmawati', '', '080004806111', '', 'user', 'N', 9002603451, 'N', '20b50e602f83799a5168bcf92d63fed7', '2025-03-29', 'N', '0000-00-00', '7d9b2e88291c63351324c255084d4418d4578bc14b4c054bd908ee1fd5777650e82cd0da783c883ad68e3853bdab2090eea412ab97997b211b173d10f5daf965', 0, '', '', '', '72_12_7_2010'),
('TARONGGO', '47d1aff8b5733704fb2b745d7e80c05d9db128369faab2bb138fced02156375e936b020f7fc725e9791be2ed74c3ac357f3ad9a45a8a44047fd373b988f6b47f', 'Niko Sugianto', '', '080074328302', '', 'user', 'N', 2673387894, 'N', '8f4bf61101b44a962a22d0fb5212d7de', '2025-03-29', 'N', '0000-00-00', '285badb556369c1534ec182c2f06b1bbe9773932940439d2c8912d1e8c16f3a13f6787ced5888f583b7d2fa16e04ff5c212de3014826ea59d308f6ad86a8354b', 0, '', '', '', '72_12_8_2003'),
('TINGKEAO', 'd8079fa91e22597cca6b734575cd8ce30a4ffb3399132b41fdcc56b54abfd5c640e86ddf023dbc3cbca288e94ebcbf63fa536521f51e1804a7857a36b86cdcc8', 'Oky Prabowo', '', '080057223182', '', 'user', 'N', 3916854730, 'N', 'c48a87de2b1f3485f8f0d5a4c615ef6a', '2025-03-29', 'N', '0000-00-00', 'a28eb5bf9def4d960292da3a5de33df42dfd78f8200e38ded4feb4b22dd220dcec05b73ee0db490159e807fe2839e8af925afba56ab670bee546d978674e3334', 0, '', '', '', '72_12_4_2005'),
('TINOMPO', '374e3688f91ba810e28fadd5ef087f2e2129d571659c1afc16eb4938a3619d52e76a8a3f93d30dbce46e09db0c44279efbcb07d895ca883767e5fbbb6fa8d9ac', 'Putri Siti', '', '080063131005', '', 'user', 'N', 3220573573, 'N', 'c90040af3a213622212788092dac3fc0', '2025-03-29', 'N', '0000-00-00', '869a8b2b3bb0df235e8b8030f2066a102f80b78477c41813cb1064cf45c8209fe21a2c84f45de40f5891a2674d014cc4ed3ae2c84f530e4599ee02453c468f1c', 0, '', '', '', '72_12_4_2008'),
('TIRONGANATAS', '5341bfe6e6fe51fa995ff21853e2b086fb6de3d73a36a057452f05c24607c3cecfabeddd0fb574f0cf5695a8524b89a95432a013f382a2fb2020e2c832e22963', 'Risma Widiastuti', '', '080043985484', '', 'user', 'N', 5561982397, 'N', 'c556c54fd09609da1973690de3e44f5d', '2025-03-29', 'N', '0000-00-00', '8f354e4661a80f056b2048e543e35621fa6a2d4852336a76175a446e176366d2603032634d555dcaf791fc3a4aaf6839007263966645e68b218f41bfc6a869a8', 0, '', '', '', '72_12_8_2007'),
('TIRONGANBAWAH', 'da57389b157b40f8c884b5f3c6450ad54fdcb8ebaf21f8b266e392d706006b95839444547cd48c78566b6a398c83becee9ccf6b0b433d123ad40fc527f72bf07', 'Satria Kurniawan', '', '080030534406', '', 'user', 'N', 4983721851, 'N', 'ccfe59755600f8a58a7278aa4b56d470', '2025-03-29', 'N', '0000-00-00', 'e30724aca5e88e789f361c116ab9d6a77d60f9affb0319316086f97f8b043745c7d2254ea66e0f4611b750aa8445b4a70ec55ba684f808357cd2b584337bfe94', 0, '', '', '', '72_12_8_2006'),
('TIU', '15941b6afd1829ab708d4d0d0a218a18f6cdb3e3265b046f47d2573a1ad6b46d44ec64831d1bebc7828f32b8a7ea9b7c98576e4f8228ecc52659473543e234cf', 'Tika Prasetyo', '', '080020715584', '', 'user', 'N', 9469381061, 'N', 'c4cecb696c276b557e6fa5894f46fff3', '2025-03-29', 'N', '0000-00-00', '1d323900fc2d5ada516b7eadde16aadf98597e436a9345e589d9eecd644bb21da8afb21964e9069930da5da56087c150c349a2dd7d734a7fca63c5be287c1eaa', 0, '', '', '', '72_12_10_2025'),
('TIWAA', '233c7e61bad6f7af8f8bfdb15cc12045809c9ad1a1df239da7481736d29f81d11ca0b73d3cb9574255f56251d9cb2a6385808f0cf9e1d9fa2ac0e88e65f80711', 'Umar Hidayat', '', '080011974707', '', 'user', 'N', 9550753467, 'N', '255c97433e011c7ef4ae49b181c9cd84', '2025-03-29', 'N', '0000-00-00', '70c30c14e99510c702ee295c37dac0c9a0d98e44411658534563ca27507d9e1f37eb5c8b5f83391c67f2fade7a946f50adecdd2dd94302f02be30f67d390bd44', 0, '', '', '', '72_12_6_2005'),
('TODDOPOLIUEBANGKE', '70bbd373471a0cb094944b5360a1fad4cde6efd495ee7590ee6df4a2c6bd918e3930f3e84e595221fcf86a08804afe6f90be4ecf770ac2edc27cba5bfb8d4334', 'Vina Sari', '', '080097726784', '', 'user', 'N', 4927712469, 'N', 'd94e7765e07b15c5993427b2a97bbddc', '2025-03-29', 'N', '0000-00-00', 'e70eea27a41d8162da2fb8d58f590b61bed5bf5a00dba18bda9c50293a681747aa3dc6a7f19fe85b5e9f367945a5872b02dbdaf43ba38d26db70f853e5eda211', 0, '', '', '', '72_12_7_2009'),
('TOGOMULYO', 'ccd8869d643282994700b200430a5c1908aa89338eb9f102db1a42200c99dc153f4ad25e343a00fbc55a2da655eda702de2d8c65b25bd50e989bc76ffe441f1b', 'Widi Pratama', '', '080052709804', '', 'user', 'N', 3480103808, 'N', '19e66102d3fcbfcb8284338b7f9f8dc3', '2025-03-29', 'N', '0000-00-00', 'e1cf5051f7d2072b77342a1bab174544bb8ee1342942ea4b621f0d59451bcbf63be78bf6b3f58144943ea33e34540e102377e3824f68f0a9a92a833694b5f5a0', 0, '', '', '', '72_12_10_2020'),
('TOKALAATAS', 'aff22542303003733b6e9734522f2875f57849daffd1a13650c5bc272c3ba368ad2bd859e88df174fe131bdaacf68fd05ce86bcda99b51196b92f629a6705ae0', 'Xandi Surya', '', '080070368671', '', 'user', 'N', 4901649890, 'N', '70781f28595ab14ee161985befc0bb32', '2025-03-29', 'N', '0000-00-00', '5d7787ac978e4718ffe52af5af6a9cbc3c9ebba5ec74794b0dc1250db46db8466db7b8273a20020701174040a9579a5f03baa2984788db36032a39138dbae0ce', 0, '', '', '', '72_12_8_2022'),
('TOKONANAKA', 'd0fdd7c902555c520502374bbf50beb5a676f79aa28daa85bb78ca539b8012c408a7e2b1969b1887d196bf02d3edbd68185e0083b7d2bfefa9bb7127a3700c2b', 'Yessy Sari', '', '080093713948', '', 'user', 'N', 6441672281, 'N', '76622ab0ecc7b3a38e7e041a120e362e', '2025-03-29', 'N', '0000-00-00', '371ac026bc068fc35d01af788fbd459ae4fb6a919be6fa9f9cbda9e71643a6d8f6f1e88097c81d7cec1f800c9d39fd3233e5fd7cd3330e1e682ee082d29106c2', 0, '', '', '', '72_12_8_2018'),
('TOMATA', '91e081831f312fd5106650058b50c98358ff6a744462234dc55ea437c5532f1e938542e80ccda4ea1f215d0bbe5f8faff6fedd6781320da9ddfbaa45d4d65563', 'Zainab Hidayah', '', '080057463729', '', 'user', 'N', 8356559375, 'N', 'e42dd1332a23b5be9e80c8d8e258ab44', '2025-03-29', 'N', '0000-00-00', 'aa495a712e0349b04b8e9d34941220260d4912e2901f62998a67ba35dc05a44fa3777dab791be3dceaac6a4022b39134305cf7f1a848ca27b75226b5e93cf0b8', 0, '', '', '', '72_12_5_2001'),
('TOMPIRA', 'b586ec8d1670b45981f851c0ac49af9eed757c74ae6acef113f25876d86bfeef63e7550506f1a77ed210e5b776f43baf82ce6a7c47fa9a1a16428438b2259768', 'Zainab Hidayah', '', '080006176804', '', 'user', 'N', 4045040050, 'N', '3493c2f6957b9921b07852a1fe375bd2', '2025-03-29', 'N', '0000-00-00', '89bd06f1c82d051ac8455477e3d84bf094cfa4ef11a6ac9b13a531e0856198895a80fddfa1919bd6c76e974cf59f7d24c797a63abf522e8577c413dd2ee62437', 0, '', '', '', '72_12_2_2002'),
('TOMUIKARYA', 'a6e470b7579c1979b95e62bf20d658d884685918463cc19d81c30bb8506fd895e06d0eebdf146386f3a835c57b1d67fddba48128c887fbab955f016cee95fbfb', 'Zainab Hidayah', '', '080058492839', '', 'user', 'N', 5964776121, 'N', '4ba23d905baff5e5f5b9f6797a2f34f0', '2025-03-29', 'N', '0000-00-00', 'd4a1a543b70ffc63d0ad327e8355d799350dd0a0fe2542f690fb6644ce04318078d13e15f17e30f4c58799db911a330a2d830baaf134a675c36ca2a363f50ee0', 0, '', '', '', '72_12_5_2012'),
('TONTOWEA', '8087aaa69ca30b442cee8e26081a772f591b922539e064acb0e3b251fce92872fb035ae34c37fcdfd4efe82a9e75ebf4cc2d5b1d43300cf704399049d17b3d26', 'Zainab Hidayah', '', '080073933785', '', 'user', 'N', 6431034439, 'N', '830ebda04349953f5ce1af82d4866644', '2025-03-29', 'N', '0000-00-00', '144e3616b759a1242eb3d76dd462fa76fc3a5e5652a592a6bcd58cf00b3750fc124acd67b7dcd5ed097334f9fb0a0208fe14ad2ca14c91faafa6fbdf3ea924ca', 0, '', '', '', '72_12_10_2018');
INSERT INTO `users` (`username`, `password`, `nama_lengkap`, `email`, `no_telp`, `foto`, `level`, `blokir`, `id_session`, `permission_publish`, `attack`, `tanggal_reg`, `deleted`, `valid_reset`, `id_reset`, `id_dusun`, `pimpinan`, `nip_pimpinan`, `nip_operator_dinas`, `id_desa`) VALUES
('TOWARA', '777b748e6a7fde050dcd0a749d373c8d11d21a6a929a992c0abc6daf0e124cd1365e39e98dedd653e33f31b10c4c4c719970897fe626a25a3bc9fb25bcf826b8', 'Zainab Hidayah', '', '080094190410', '', 'user', 'N', 7665942614, 'N', '0f63dfff1abf1bd3430fc4b4f00f87de', '2025-03-29', 'N', '0000-00-00', 'c5b4a5dbc6a8a18e6290bb17c080aee513ec2bbe908a8b477a59c01a66c51f9b6f6de8ae5d2543a22464106b531978646ad4ec7715bf70edf336ac1a57d4c6e8', 0, '', '', '', '72_12_2_2004'),
('TOWARAPANTAI', 'f0d29d73a6b933b217aaa8130b4c6d7dfd0daa3767687dc148a13e805b25d08582a4e12386b8a1c1788a18895388b6ca674422aab54469765140cc371ea16a22', 'Zainab Hidayah', '', '080049150699', '', 'user', 'N', 9354709445, 'N', '040554c3e53869b98a942e5142db449f', '2025-03-29', 'N', '0000-00-00', 'f0a85b3d490ce39372f695bfff11ca8b17e77ebb785510034ba3b7755a47d79d2ea9a61ba4891c9f5d0a50456f473223355f0b1cbbb4dcabbbf2aa4d02ca27a5', 0, '', '', '', '72_12_2_2011'),
('UEMASI', '8ef66490ca14006c49ab83e61c7e6da3c06a297158c21bc0b351c089676463eeca93610f92c4f04ebc7cb5bc0406e0f83e2b20134dbc965977e63733ac240a1b', 'Zainab Hidayah', '', '080063182268', '', 'user', 'N', 7418650214, 'N', '3720825bd83e12817b0d14e387216df2', '2025-03-29', 'N', '0000-00-00', 'fb91890f45a8444bb76ea42d926353d47441dac21608509aa5d61a2170b90acb9bc781f20ef551f6453383fab26305b612d758702df2fc9ef900a1659338a3d4', 0, '', '', '', '72_12_8_2011'),
('UEMPANAPA', 'ebe780c964c7734fe345333f486055ef52c2d7e905a23198e024cc74816e911d50207eb6808e3a866364aae3d5d0af1161c860ec7c8dec97fc274d0e9033cf3b', 'Zainab Hidayah', '', '080068459248', '', 'user', 'N', 5183680111, 'N', '225ca5f889cace4403a96a4d13a810ed', '2025-03-29', 'N', '0000-00-00', '3547cab9d69cc7b261f06b08ac86974f945778dc16c6677f426a6a5e1cde3c33a3480559856b3b55b2e98218f4f3731945cfc0b435c4cfcf04323c006dfc4a38', 0, '', '', '', '72_12_8_2021'),
('UEPAKATU', '50459990448bb16f8a8786f341f6103e7607b529ff68067c6244e5c42c332924abf9826fe2a69b3f8747851b0ba0291e9114d6dfa7ccb05b594655a8d218ebe9', 'Zainab Hidayah', '', '080052749437', '', 'user', 'N', 1015702084, 'N', '1230f0549a58a964dcc99813df13c8ca', '2025-03-29', 'N', '0000-00-00', 'b1ca517a0e008189a31d3617140ed57dfb0f9fcdaeac2aac5a72f2ceda29fcb17c44094ec4c2245083397856b470d41e7dd1512fa16bf3bc415bf731e638495c', 0, '', '', '', '72_12_9_2006'),
('UERURU', 'f0166f9ab2205f54e3ce65169b9d6c8532d192318a0237c5ccc0460ea713a7adbfbb0a8d276f90221de69a6cfd88668b9a0efef22fa25947fa021dbf3ab57537', 'Zainab Hidayah', '', '080058369447', '', 'user', 'N', 9296855133, 'N', '598074da49f7a4f6b2352c5722c0c25e', '2025-03-29', 'N', '0000-00-00', '66901ea849418965bfa1d5ebe02ae7664696066f5986e6f531d84c762413d14b0f82f1f665f1f1391e118a19e84bda625b50fd75f8b3208fe50a0f5c9c4ab813', 0, '', '', '', '72_12_8_2004'),
('UEWAJO', '3f6f4df3678c3150846f7bed7e254c0e8e520e9c5f6674687077cd9b5ce3b82509d053fb28a280f01ddd3decc389f7c20d4d4eed5a7018c7ff5558a4e9631e8a', 'Zainab Hidayah', '', '080033598927', '', 'user', 'N', 6204870585, 'N', '4b0bbe5ba2677ed89c183d5dfcb17516', '2025-03-29', 'N', '0000-00-00', '65cfa3bfc235ff0b8f798e233b8a1b780364c5df87ba48972f66414571a1e1f71cb2631d58d0e846969e267e241dcc8cf844ab35c7ed830c0b16568dd06d2322', 0, '', '', '', '72_12_8_2005'),
('ULULAA', 'c0818afdfd7d70e5041a5d0ecfaf98604800b3aec1de5f79c60e05fe8568e229e11a148916ffe9eada298ddb4bb886cb2b543d2e0f47d61b2610ae280546aeec', 'Zainab Hidayah', '', '080092886296', '', 'user', 'N', 7557954006, 'N', 'f47aba6a0817d004283c81185670e150', '2025-03-29', 'N', '0000-00-00', '7180d5503e0f3a913c19707a54473f77110f4b2f7eb48671793498e6b11aaeee35aa278bdca59e49d394b2b1b5c05490fcb4c625f1259c6d4d92dd45cfb0b0b8', 0, '', '', '', '72_12_10_2023'),
('ULUANSO', '8dfbd10fb4cae1e09ca2b0998df7dd054a5337934d1798c8a797f375191e9a1b2e806bf1890097db45d55dbe45a56b36a21bd9e1f9f85cefae2a8ecedf656bc9', 'Zainab Hidayah', '', '080063634704', '', 'user', 'N', 4990231542, 'N', '5fad54901cd9d7487bd54ecdd8308c0d', '2025-03-29', 'N', '0000-00-00', 'cdfaded25492071e39efca4e6ddf58f5a20b63ff1e0a673def078f9ee4f747f01dfcfe5e7fd633f6763314a853d58ab87fc72672f4be374cbe131b21076bd3bb', 0, '', '', '', '72_12_4_2002'),
('UNGKEA', '864c552c66094f6b19eb844f4e3c41c9102dc0c475ad26a5c74727f515a9b988d0e9aabfdb6ad86abe4a4927da12fd36043ffccaf74d75651403b7c61d664e72', 'Zainab Hidayah', '', '080039514635', '', 'user', 'N', 6061414494, 'N', 'c65fef3d0e3b73f1d6b875f0227abc44', '2025-03-29', 'N', '0000-00-00', 'fad8551b96ef5002fe6d75cbf0d3e1c0fda7b8314ed7034a06616610bec53f47c4602130a07fec82b5fbcef76fd92c9f1d13fcaa5c836eb6e3dcf796131e6a2d', 0, '', '', '', '72_12_2_2007'),
('WARAA', '82937965e6111f4f0c355431fb60223211b4293ca76a2c516cf778011844319648bfb3ee03fa69f9fde8ab5084c06f1db9f309bd998bc08fa152441a10835639', 'Zainab Hidayah', '', '080006669066', '', 'user', 'N', 5402793568, 'N', '54bd602698505a7763de4adff8b245e1', '2025-03-29', 'N', '0000-00-00', '6b7fa29a1747ef077f651e99e481defcd2c24323fc6a7e409b3a46f6f37ed08035269a1f71d750ee230cc1bac1f6ab75924b919ecffbe887bb54483e13d5376d', 0, '', '', '', '72_12_4_2004'),
('WAWONDULA', '6f0fa04cbe15048d54f8c122ca7c2256f801bf32a9a282d6fda8296af3750ad4d4d9c2243a1485f3953b781dd279db0ebf83ded411180f6f52f71e6d8176861c', 'Zainab Hidayah', '', '080014801430', '', 'user', 'N', 4350523135, 'N', 'bbbe2c4400c19d6f1c02edd8abd5dd9b', '2025-03-29', 'N', '0000-00-00', 'd45e6e1e8bca628efa1dd210efe9ae2aa2107e2fbf2b65c366b0a62398c15ad7972e6b77121aa98900c260464cebf3508e8b6442b21ef3ed957af04456da7ade', 0, '', '', '', '72_12_6_2008'),
('WAWOPADA', '6b9080d3e979aab7f1e62b9780f10a0e90fa78e915b3d57fd224b84cc55ab316f92e5d99865eceb4a55ac382b5d5fcce900a234548fe2198eb7088253e669d66', 'Zainab Hidayah', '', '080053999954', '', 'user', 'N', 7199686537, 'N', '2c622b23f0bf75f02eb8f93b9471e802', '2025-03-29', 'N', '0000-00-00', 'bee14cadda9694f01f95d7ef628e60203a980e0605f07f1055a9d9dfa317927a8046faca4281ea3a2dc88871c2ccb0933e07b7004f2c47fc4e4c5a87012a0185', 0, '', '', '', '72_12_4_2006'),
('WINANGOBINO', '98e5b15a173c50b3d822142a1b7b61ef55dc5f9fdf0235482961c8f8e446951d8117406bc22a07d12fb3f6fcdcf8d3933fe7d3621c374ec4210ca7767592aff5', 'Zainab Hidayah', '', '080025595486', '', 'user', 'N', 7590409249, 'N', '25f8f05d0a55e4b0f0cbdd09d7ab70a1', '2025-03-29', 'N', '0000-00-00', '2b13af1b50bc375bbb735500db315d86eeb513da775fc090b9165bc925cc992c988ad5372306d1ec71afc71bef4c9aa7a441e58844a7a8af96af876cbae296ad', 0, '', '', '', '72_12_9_2011'),
('WOOMPARIGI', '3bb8baaeccd5e6dd7a46781a32becc74cde034a285b780019ee32ee9afb9365d6cf8c7bff1297cd6bab9c5379ac31c7904ed4518c4d4048ced02f67ec5522d17', 'Zainab Hidayah', '', '080065977568', '', 'user', 'N', 3408960265, 'N', 'f46ccc2c6352408700669b10a7167fe0', '2025-03-29', 'N', '0000-00-00', 'e78933c06a29c1ce9595447a4f7c0e66a7b94f58e2202c21a0401c39e2966d7d578ab498e9fc85c613475462bae67da381117c688e2b7bbac6f38e5827810ef5', 0, '', '', '', '72_12_8_2015'),
('nurhikmah', '528dc7d0ce7b03d7bd9b239007c3b2e929fd443945324c5b7271babf323aa8ad68c2a88527774685ae410795b9640be446d7a01eac3f4cacc21e51fd5628808c', 'Zainab Hidayah', '', '080053101388', '', 'user', 'N', 6569990186, 'N', 'b258b4c750719dfeaaae1e489288e661', '2025-03-29', 'N', '0000-00-00', '4df7b6dff68f5bf9cc27ca09b81b5b3f1199d2eb8b031886520592fff842eb179d0753c557f56028d6c9056b0e67ed972f80f0ab2e0a3fc406829787a5f08f62', 33, '', '', '', '72_12_8_2016'),
('onhacker', '1946de7d7b54ff27c18d0313a70161ce3fac423c1368b9a9f72a371d9381c7487e0d6fe54ab367d735f37266a9e2891f3abef7e0226223e520a1ca954a2390e0', 'Zainab Hidayah', '', '080067574239', '', 'user', 'N', 6667548675, 'N', '57aae67d56db39044cfdb8fda35f2e55', '2025-03-29', 'N', '0000-00-00', 'feaa1ab13abe3e57de1f80eb85a8198914dc179ef33a1345ba633652c0fc9e61a33507376e6c8eba877f7fe90990e9c926e11288b4aea8f46f615516ba26c35b', 39, '', '', '', '72_12_8_2016'),
('apaajalaj', 'd61d6359eacef95f0fd72a7cce5aa24a77eec5d60df461122fa1218743f2c336766c0a1e16240ee27f7286aeeb6b5c44af562c79dbc86d98c103e27be7adac0b', 'Zainab Hidayah', '', '080078567037', '', 'user', 'N', 1626649354, 'N', '303bad846c3740b42951b833b9565c4d', '2025-03-29', 'N', '0000-00-00', 'a4dc8e0da00b7bc1004ba15c58e74aa7be2a0b2ada88d75564227e43e24e30401494efe4c10172ebb1de332058c862a5718434fa96b8ac4630e498f615e94725', 36, '', '', '', '72_12_8_2020'),
('mekarrrrr', '1d9ae098db5474f559e271774080f8effbc3c1a72291d46a8a1683baa647fae76ea2221a58f1af15e9222c7f082ea3b5a28243f0eca0e2f1f0f2ba98002089c0', 'Zainab Hidayah', '', '080090112468', '', 'user', 'N', 1047251863, 'N', 'f9d710ccb76aa737277431a378d806fc', '2025-03-30', 'N', '0000-00-00', 'db8ac08ccbf47f6665cef44022dbe81faaf4e064540f21b1ebde30a015d407d7681bd1ab2696789c9187f3e8ec4b1b259e66a3f012d2353ce8631be61ab80ea5', 40, '', '', '', '72_12_8_2016'),
('pernekel', 'bff0cc42103de1b4721370e84dc24f635a7afeca41198c9b3e03946a1b6b7191d14356408a5e57ce6daf77e6e800c66fac7ab0482d57d48d23e6808e4b562daa', 'Zainab Hidayah', '', '080014861234', '', 'user', 'N', 3977887026, 'N', 'bafbf74658a874fa8ca2d4e21a869d72', '2025-03-30', 'N', '2025-04-25', 'ae5ce223d0e6d3dfc1619c0600dae4c6ea7fb17b3c71123deb0e4f34de02cc1a4b2774d5629175c483bff2cfaad7610f723846e29e0351ed83711b07444c738b', 41, '', '', '', '72_12_8_2016'),
('irwanx', 'f27c3fd25fd87604d157bfc9422bdeb2223a1df45ecff26b31b47db59b46ebb251215e1ffcec83a1cb45ede64832b79a96778610c14034f225efc6bab224cbc4', 'Zainab Hidayah', '', '082333265888', '', 'admin', 'N', 9561324894, 'N', '98bf89bf26d3585d830cd16c621bb0d6', '2025-04-23', 'N', '0000-00-00', '892e15014fa928206df64590d6602e2dcf1b141d1e561ef80765aba2764191c7733b1a032c7c7115d380042a78a334f24f4a8fc12ac32ae491891a8e92742075', 0, '', '', '', NULL),
('nurilx', 'eba7bed18ad141fc4fcacc39cfc5d4d2559456c5265b53d42fae7456ff7ec4f2ac3e94393dbcf6297e681735e48afb9a7060987f1eae9b13ab26956d3a3679b2', 'Askari', '', '080075260147', '', 'admin', 'N', 5308567255, 'N', 'a6222996aa4e125365de3744f1c8d53c', '2025-04-23', 'N', '0000-00-00', '859eb432739766faf9295d80fbd8f347ed76f7b6973730024bbb8878afdc1d322d9a524e5aa750fbf9c4a493c57c6da33f62a1d97bddd8bbfd9e26ebfca71f54', 0, '', '', '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users_capil`
--

CREATE TABLE `users_capil` (
  `id` int(11) NOT NULL,
  `id_session` varchar(255) NOT NULL,
  `id_permohonan` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users_capil`
--

INSERT INTO `users_capil` (`id`, `id_session`, `id_permohonan`) VALUES
(22, '5308567255', 11),
(12, '9561324894', 9),
(13, '9561324894', 1),
(23, '5308567255', 3),
(11, '5308567255', 12),
(14, '9561324894', 10),
(15, '9561324894', 2),
(16, '9561324894', 15),
(17, '9561324894', 13),
(18, '9561324894', 16),
(19, '9561324894', 17),
(20, '9561324894', 18),
(21, '9561324894', 7),
(24, '5308567255', 19),
(25, '5308567255', 4),
(26, '5308567255', 6),
(27, '5308567255', 14),
(28, '5308567255', 5),
(29, '5308567255', 20),
(30, '5308567255', 8);

-- --------------------------------------------------------

--
-- Table structure for table `users_modul`
--

CREATE TABLE `users_modul` (
  `id_umod` int(11) NOT NULL,
  `id_session` varchar(255) NOT NULL,
  `id_modul` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users_modul`
--

INSERT INTO `users_modul` (`id_umod`, `id_session`, `id_modul`) VALUES
(225, '2138424665', 146),
(224, '2138424665', 33),
(223, '2138424665', 2),
(222, '2138424665', 147),
(221, '2673387894', 33),
(220, '2673387894', 146),
(218, '2673387894', 2),
(217, '2673387894', 147),
(216, '9307550511', 147),
(214, '6669686948', 146),
(213, '6669686948', 33),
(212, '6669686948', 2),
(211, '6669686948', 147),
(210, '2035266275', 33),
(208, '2035266275', 2),
(209, '2035266275', 146),
(206, '2035266275', 147),
(200, '1465036775', 2),
(199, '1465036775', 147),
(197, '1465036775', 33),
(196, '1465036775', 146),
(195, '4171929134', 146),
(194, '4171929134', 147),
(192, '4171929134', 2),
(191, '4171929134', 33),
(190, '7893425743', 33),
(189, '7893425743', 146),
(188, '7893425743', 2),
(187, '7893425743', 69),
(186, '7893425743', 147),
(185, '1456623873', 147),
(184, '1456623873', 69),
(183, '9307550511', 33),
(182, '9307550511', 146),
(181, '9307550511', 2),
(180, '1456623873', 33),
(174, '1456623873', 146),
(173, '1456623873', 2);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_semua_paket`
-- (See below for the actual view)
--
CREATE TABLE `view_semua_paket` (
`asal_tabel` varchar(7)
,`id_paket` varchar(100)
,`id_pemohon` char(60)
,`nama` varchar(255)
,`nik` varchar(255)
,`no_kk` varchar(255)
,`no_registrasi_pemohon` varchar(255)
,`nama_pemohon` varchar(100)
,`no_wa_pemohon` varchar(255)
,`id_desa` varchar(50)
,`create_date` date
,`create_time` varchar(20)
,`username` varchar(100)
,`id_dusun` int(11)
,`update_time` datetime /* mariadb-5.3 */
,`status` int(11)
,`alamat` varchar(255)
,`alasan_penolakan` mediumtext
,`status_baca` int(11)
,`nama_permohonan` varchar(255)
,`deskripsi` text
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_users_capil`
-- (See below for the actual view)
--
CREATE TABLE `view_users_capil` (
`id` int(11)
,`id_session` varchar(255)
,`id_permohonan` int(11)
,`nama_permohonan` varchar(255)
,`nama_tabel` varchar(50)
,`master_id_permohonan` int(11)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_users`
-- (See below for the actual view)
--
CREATE TABLE `v_users` (
`username` varchar(50)
,`nama_lengkap` varchar(100)
,`email` varchar(100)
,`no_telp` varchar(255)
,`foto` varchar(100)
,`tanggal_reg` date
,`id_desa` varchar(255)
,`id_dusun` int(11)
,`id_session` bigint(20) unsigned
,`permission_publish` enum('Y','N')
,`blokir` enum('Y','N','P')
,`nama_dusun` varchar(100)
,`username_dusun` varchar(50)
);

-- --------------------------------------------------------

--
-- Table structure for table `w_dua`
--

CREATE TABLE `w_dua` (
  `id_w_dua` char(100) NOT NULL,
  `periode_awal` date NOT NULL,
  `periode_akhir` date NOT NULL,
  `minggu_ke` int(11) NOT NULL,
  `id_minggu_ke` int(11) NOT NULL,
  `bulan` int(11) NOT NULL,
  `tahun` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `total_kunjungan` int(11) NOT NULL,
  `id_dusun` int(11) NOT NULL,
  `create_date` date NOT NULL,
  `nama_pengelola` varchar(100) DEFAULT NULL,
  `nip_pengelola` varchar(100) DEFAULT NULL,
  `pimpinan` varchar(100) DEFAULT NULL,
  `nip_pimpinan` varchar(100) DEFAULT NULL,
  `tanda` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `w_dua`
--

INSERT INTO `w_dua` (`id_w_dua`, `periode_awal`, `periode_akhir`, `minggu_ke`, `id_minggu_ke`, `bulan`, `tahun`, `username`, `total_kunjungan`, `id_dusun`, `create_date`, `nama_pengelola`, `nip_pengelola`, `pimpinan`, `nip_pimpinan`, `tanda`) VALUES
('e4e7c4977ddac9519d082cd4b85c8495_8', '2020-07-19', '2020-07-25', 30, 0, 7, 2020, 'dusunMALILI', 612, 8, '2020-08-10', 'MASNIATI', '', '', '', 'pengelola'),
('0bb909e81ea6ad074abb0a352e837597_8', '2020-07-12', '2020-07-18', 29, 0, 7, 2020, 'dusunMALILI', 496, 8, '2020-08-10', 'MASNIATI', '', '', '', 'pengelola'),
('fd2de64ed7d7c7b09d51a4f4ebc5e755_8', '2020-07-05', '2020-07-11', 28, 0, 7, 2020, 'dusunMALILI', 687, 8, '2020-08-09', 'MASNIATI', '', '', '', 'pengelola'),
('baf6745a5951e8e1cbab060b3c3a91a8_8', '2020-07-26', '2020-08-29', 31, 0, 7, 2020, 'dusunMALILI', 470, 8, '2020-08-10', 'MASNIATI', '', '', '', 'pengelola'),
('91985409eb900bc3706c227bebbf86f2_3', '2020-06-28', '2020-07-04', 27, 0, 6, 2020, 'dusunTOMONI', 0, 3, '2020-08-13', 'ARIS', '', '', '', 'pengelola'),
('c91211d35a774c85bdc4b71107dba22c_3', '2020-07-05', '2020-07-11', 28, 0, 7, 2020, 'dusunTOMONI', 0, 3, '2020-08-13', 'ARIS', '', '', '', 'pengelola'),
('711295bc7f46f6fdc447948b1acea78f_3', '2020-07-12', '2020-07-18', 29, 0, 7, 2020, 'dusunTOMONI', 0, 3, '2020-08-13', 'ARIS', '', '', '', 'pengelola'),
('460ab0e04b019f1626c0a290b12f981c_3', '2020-07-19', '2020-07-25', 30, 0, 7, 2020, 'dusunTOMONI', 0, 3, '2020-08-13', 'ARIS', '', '', '', 'pengelola'),
('b6513ea8fcf2256189fcc26fa2707dc7_3', '2020-07-26', '2020-08-01', 31, 0, 7, 2020, 'dusunTOMONI', 0, 3, '2020-08-13', 'ARIS', '', '', '', 'pengelola'),
('1764feb0263970f6c50d1dded58dcfe0_3', '2019-12-29', '2020-01-04', 1, 0, 12, 2019, 'dusunTOMONI', 0, 3, '2020-08-13', 'ARIS', '', '', '', 'pengelola'),
('519b89e487f77cd98670c08e357eb534_2', '2020-07-19', '2020-07-25', 30, 91, 7, 2020, 'dusunWOTU', 0, 2, '2020-08-14', 'ISMAWATI.T,SKM', '', 'SUHARTO,SKM.M.Kes', '196708161989111002', 'pengelola'),
('cd1378fc9fe09b0bba4d4298c9ec68a3_2', '2020-07-12', '2020-07-18', 29, 90, 7, 2020, 'dusunWOTU', 0, 2, '2020-08-14', 'ISMAWATI.T,SKM', '', 'SUHARTO,SKM.M.Kes', '196708161989111002', 'pengelola'),
('e86ff3ff74e22a96e37afd36043ce920_2', '2020-07-05', '2020-07-11', 28, 89, 7, 2020, 'dusunWOTU', 0, 2, '2020-08-14', 'ISMAWATI.T,SKM', '', 'SUHARTO,SKM.M.Kes', '196708161989111002', 'pengelola'),
('7a898e5d3f90831f9c426db90e8214be_2', '2020-06-28', '2020-07-04', 27, 88, 6, 2020, 'dusunWOTU', 0, 2, '2020-08-14', 'ISMAWATI.T,SKM', '', 'SUHARTO,SKM.M.Kes', '196708161989111002', 'pengelola'),
('14de5e133980dc941b41c9bb8dac2ec5_8', '2019-12-29', '2020-01-04', 1, 62, 12, 2019, 'dusunMALILI', 0, 8, '2020-08-15', 'Masniati Muis S.Kep.,Ns', '', 'Hasnah S.Kep.,Ns', '197703302005022004', 'pengelola'),
('c11e4db1a78cd7e9cdc12c2ad63944d5_8', '2020-06-28', '2020-07-04', 27, 88, 6, 2020, 'dusunMALILI', 0, 8, '2020-08-15', 'Masniati Muis S.Kep.,Ns', '', 'Hasnah S.Kep.,Ns', '197703302005022004', 'pengelola');

-- --------------------------------------------------------

--
-- Table structure for table `w_dua_isi`
--

CREATE TABLE `w_dua_isi` (
  `id_w_dua_isi` int(11) NOT NULL,
  `id_dusun` int(11) NOT NULL,
  `id_w_dua` char(100) NOT NULL,
  `desa` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `id_desa` varchar(100) NOT NULL,
  `bentuk` int(11) NOT NULL,
  `bulan` int(11) NOT NULL,
  `tahun` int(11) NOT NULL,
  `periode_awal` date NOT NULL,
  `periode_akhir` date NOT NULL,
  `minggu_ke` int(11) DEFAULT NULL,
  `diare_k_lima_p` int(11) NOT NULL,
  `diare_k_lima_m` int(11) NOT NULL,
  `diare_l_lima_p` int(11) NOT NULL,
  `diare_l_lima_m` int(11) NOT NULL,
  `kholera_p` int(11) NOT NULL,
  `kholera_m` int(11) NOT NULL,
  `dbd_min_p` int(11) NOT NULL,
  `dbd_min_m` int(11) NOT NULL,
  `dbd_plus_p` int(11) NOT NULL,
  `dbd_plus_m` int(11) NOT NULL,
  `pes_p` int(11) NOT NULL,
  `pes_m` int(11) NOT NULL,
  `polio_p` int(11) NOT NULL,
  `polio_m` int(11) NOT NULL,
  `diferi_min_p` int(11) NOT NULL,
  `diferi_min_m` int(11) NOT NULL,
  `diferi_plus_p` int(11) NOT NULL,
  `diferi_plus_m` int(11) NOT NULL,
  `campak_k_lima_p` int(11) NOT NULL,
  `campak_k_lima_m` int(11) NOT NULL,
  `campak_l_lima_p` int(11) NOT NULL,
  `campak_l_lima_m` int(11) NOT NULL,
  `pneumonia_p` int(11) NOT NULL,
  `pneumonia_m` int(11) NOT NULL,
  `tetanus_p` int(11) NOT NULL,
  `tetanus_m` int(11) NOT NULL,
  `maramus_p` int(11) NOT NULL,
  `maramus_m` int(11) NOT NULL,
  `hepatitis_klinis_p` int(11) NOT NULL,
  `hepatitis_klinis_m` int(11) NOT NULL,
  `hepatitis_hbs_p` int(11) NOT NULL,
  `hepatitis_hbs_m` int(11) NOT NULL,
  `lahir_mati_m` int(11) NOT NULL,
  `kematian_bayi_m` int(11) NOT NULL,
  `kematian_neo_m` int(11) NOT NULL,
  `kematian_ibu_m` int(11) NOT NULL,
  `bblr_p` int(11) NOT NULL,
  `bblr_m` int(11) NOT NULL,
  `tb_min_p` int(11) NOT NULL,
  `tb_min_m` int(11) NOT NULL,
  `tb_plus_p` int(11) NOT NULL,
  `tb_plus_m` int(11) NOT NULL,
  `bgm_p` int(11) NOT NULL,
  `bgm_m` int(11) NOT NULL,
  `typhoid_min_p` int(11) NOT NULL,
  `typhoid_min_m` int(11) NOT NULL,
  `thypoid_plus_p` int(11) NOT NULL,
  `thypoid_plus_m` int(11) NOT NULL,
  `malaria_klinis_p` int(11) NOT NULL,
  `malaria_klinis_m` int(11) NOT NULL,
  `jumlah_persalinan_p` int(11) NOT NULL,
  `jumlah_kelahiran_hidup_p` int(11) NOT NULL,
  `kasus_gigitan_p` int(11) NOT NULL,
  `kasus_gigitan_m` int(11) NOT NULL,
  `infulensa_p` int(11) NOT NULL,
  `infulensa_m` int(11) NOT NULL,
  `marasmus_p` int(11) NOT NULL,
  `marasmus_m` int(11) NOT NULL,
  `varicella_p` int(11) NOT NULL,
  `varicella_m` int(11) NOT NULL,
  `lepospirosi_p` int(11) NOT NULL,
  `lepospirosi_m` int(11) NOT NULL,
  `dysentry_p` int(11) NOT NULL,
  `dysentry_m` int(11) NOT NULL,
  `ili_p` int(11) NOT NULL,
  `ili_m` int(11) NOT NULL,
  `suspek_ai_p` int(11) NOT NULL,
  `suspek_ai_m` int(11) NOT NULL,
  `demam_tdk_tau_p` int(11) NOT NULL,
  `demam_tdk_tau_m` int(11) NOT NULL,
  `jumlah_kunjungan_p` int(11) NOT NULL,
  `jumlah_kunjungan_m` int(11) NOT NULL,
  `pustu_l` int(11) NOT NULL,
  `pustu_t` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_uca1400_ai_ci;

--
-- Dumping data for table `w_dua_isi`
--

INSERT INTO `w_dua_isi` (`id_w_dua_isi`, `id_dusun`, `id_w_dua`, `desa`, `id_desa`, `bentuk`, `bulan`, `tahun`, `periode_awal`, `periode_akhir`, `minggu_ke`, `diare_k_lima_p`, `diare_k_lima_m`, `diare_l_lima_p`, `diare_l_lima_m`, `kholera_p`, `kholera_m`, `dbd_min_p`, `dbd_min_m`, `dbd_plus_p`, `dbd_plus_m`, `pes_p`, `pes_m`, `polio_p`, `polio_m`, `diferi_min_p`, `diferi_min_m`, `diferi_plus_p`, `diferi_plus_m`, `campak_k_lima_p`, `campak_k_lima_m`, `campak_l_lima_p`, `campak_l_lima_m`, `pneumonia_p`, `pneumonia_m`, `tetanus_p`, `tetanus_m`, `maramus_p`, `maramus_m`, `hepatitis_klinis_p`, `hepatitis_klinis_m`, `hepatitis_hbs_p`, `hepatitis_hbs_m`, `lahir_mati_m`, `kematian_bayi_m`, `kematian_neo_m`, `kematian_ibu_m`, `bblr_p`, `bblr_m`, `tb_min_p`, `tb_min_m`, `tb_plus_p`, `tb_plus_m`, `bgm_p`, `bgm_m`, `typhoid_min_p`, `typhoid_min_m`, `thypoid_plus_p`, `thypoid_plus_m`, `malaria_klinis_p`, `malaria_klinis_m`, `jumlah_persalinan_p`, `jumlah_kelahiran_hidup_p`, `kasus_gigitan_p`, `kasus_gigitan_m`, `infulensa_p`, `infulensa_m`, `marasmus_p`, `marasmus_m`, `varicella_p`, `varicella_m`, `lepospirosi_p`, `lepospirosi_m`, `dysentry_p`, `dysentry_m`, `ili_p`, `ili_m`, `suspek_ai_p`, `suspek_ai_m`, `demam_tdk_tau_p`, `demam_tdk_tau_m`, `jumlah_kunjungan_p`, `jumlah_kunjungan_m`, `pustu_l`, `pustu_t`) VALUES
(21, 8, 'fd2de64ed7d7c7b09d51a4f4ebc5e755_8', 'MALILI', '73_24_4_1003', 1, 7, 2020, '2020-07-05', '2020-07-11', 28, 0, 0, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 121, 0, 0, 0),
(22, 8, 'fd2de64ed7d7c7b09d51a4f4ebc5e755_8', 'HARAPAN', '73_24_4_2001', 1, 7, 2020, '2020-07-05', '2020-07-11', 28, 0, 0, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 59, 0, 0, 0),
(23, 8, 'fd2de64ed7d7c7b09d51a4f4ebc5e755_8', 'WEWANG RIU', '73_24_4_2005', 1, 7, 2020, '2020-07-05', '2020-07-11', 28, 2, 0, 4, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 101, 0, 0, 0),
(24, 8, 'fd2de64ed7d7c7b09d51a4f4ebc5e755_8', 'BARUGA', '73_24_4_2006', 1, 7, 2020, '2020-07-05', '2020-07-11', 28, 0, 0, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 87, 0, 0, 0),
(25, 8, 'fd2de64ed7d7c7b09d51a4f4ebc5e755_8', 'USSU', '73_24_4_2008', 1, 7, 2020, '2020-07-05', '2020-07-11', 28, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 47, 0, 0, 0),
(26, 8, 'fd2de64ed7d7c7b09d51a4f4ebc5e755_8', 'BALANTANG', '73_24_4_2010', 1, 7, 2020, '2020-07-05', '2020-07-11', 28, 0, 0, 4, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 62, 0, 0, 0),
(27, 8, 'fd2de64ed7d7c7b09d51a4f4ebc5e755_8', 'ATUE', '73_24_4_2011', 1, 7, 2020, '2020-07-05', '2020-07-11', 28, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 29, 0, 0, 0),
(28, 8, 'fd2de64ed7d7c7b09d51a4f4ebc5e755_8', 'PUNCAK INDAH', '73_24_4_2013', 1, 7, 2020, '2020-07-05', '2020-07-11', 28, 2, 0, 5, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 181, 0, 0, 0),
(29, 8, '0bb909e81ea6ad074abb0a352e837597_8', 'LUAR WILAYAH', '888', 1, 7, 2020, '2020-07-12', '2020-07-18', 29, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 3, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2, 0, 0, 0, 0, 0, 36, 0, 0, 0),
(30, 8, '0bb909e81ea6ad074abb0a352e837597_8', 'MALILI', '73_24_4_1003', 1, 7, 2020, '2020-07-12', '2020-07-18', 29, 0, 0, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 3, 0, 0, 0, 1, 0, 100, 0, 0, 0),
(31, 8, '0bb909e81ea6ad074abb0a352e837597_8', 'HARAPAN', '73_24_4_2001', 1, 7, 2020, '2020-07-12', '2020-07-18', 29, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(32, 8, '0bb909e81ea6ad074abb0a352e837597_8', 'WEWANG RIU', '73_24_4_2005', 1, 7, 2020, '2020-07-12', '2020-07-18', 29, 0, 0, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2, 0, 0, 0, 0, 0, 66, 0, 0, 0),
(33, 8, '0bb909e81ea6ad074abb0a352e837597_8', 'BARUGA', '73_24_4_2006', 1, 7, 2020, '2020-07-12', '2020-07-18', 29, 0, 0, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 3, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 1, 0, 68, 0, 0, 0),
(34, 8, '0bb909e81ea6ad074abb0a352e837597_8', 'USSU', '73_24_4_2008', 1, 7, 2020, '2020-07-12', '2020-07-18', 29, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 27, 0, 0, 0),
(35, 8, '0bb909e81ea6ad074abb0a352e837597_8', 'BALANTANG', '73_24_4_2010', 1, 7, 2020, '2020-07-12', '2020-07-18', 29, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 46, 0, 0, 0),
(36, 8, '0bb909e81ea6ad074abb0a352e837597_8', 'ATUE', '73_24_4_2011', 1, 7, 2020, '2020-07-12', '2020-07-18', 29, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 34, 0, 0, 0),
(37, 8, '0bb909e81ea6ad074abb0a352e837597_8', 'PUNCAK INDAH', '73_24_4_2013', 1, 7, 2020, '2020-07-12', '2020-07-18', 29, 0, 0, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2, 0, 0, 0, 1, 0, 119, 0, 0, 0),
(38, 8, 'e4e7c4977ddac9519d082cd4b85c8495_8', 'LUAR WILAYAH', '888', 1, 7, 2020, '2020-07-19', '2020-07-25', 30, 0, 0, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 63, 0, 0, 0),
(39, 8, 'e4e7c4977ddac9519d082cd4b85c8495_8', 'MALILI', '73_24_4_1003', 1, 7, 2020, '2020-07-19', '2020-07-25', 30, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 2, 0, 114, 0, 0, 0),
(40, 8, 'e4e7c4977ddac9519d082cd4b85c8495_8', 'HARAPAN', '73_24_4_2001', 1, 7, 2020, '2020-07-19', '2020-07-25', 30, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(41, 8, 'e4e7c4977ddac9519d082cd4b85c8495_8', 'WEWANG RIU', '73_24_4_2005', 1, 7, 2020, '2020-07-19', '2020-07-25', 30, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2, 0, 0, 0, 0, 0, 103, 0, 0, 0),
(42, 8, 'e4e7c4977ddac9519d082cd4b85c8495_8', 'BARUGA', '73_24_4_2006', 1, 7, 2020, '2020-07-19', '2020-07-25', 30, 0, 0, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 3, 0, 0, 0, 0, 0, 58, 0, 0, 0),
(43, 8, 'e4e7c4977ddac9519d082cd4b85c8495_8', 'USSU', '73_24_4_2008', 1, 7, 2020, '2020-07-19', '2020-07-25', 30, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 54, 0, 0, 0),
(44, 8, 'e4e7c4977ddac9519d082cd4b85c8495_8', 'BALANTANG', '73_24_4_2010', 1, 7, 2020, '2020-07-19', '2020-07-25', 30, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2, 0, 0, 0, 0, 0, 47, 0, 0, 0),
(45, 8, 'e4e7c4977ddac9519d082cd4b85c8495_8', 'ATUE', '73_24_4_2011', 1, 7, 2020, '2020-07-19', '2020-07-25', 30, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 20, 0, 0, 0),
(46, 8, 'e4e7c4977ddac9519d082cd4b85c8495_8', 'PUNCAK INDAH', '73_24_4_2013', 1, 7, 2020, '2020-07-19', '2020-07-25', 30, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 4, 0, 0, 0, 0, 0, 153, 0, 0, 0),
(47, 8, 'baf6745a5951e8e1cbab060b3c3a91a8_8', 'LUAR WILAYAH', '888', 1, 7, 2020, '2020-07-26', '2020-08-29', 31, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 20, 0, 0, 0),
(48, 8, 'baf6745a5951e8e1cbab060b3c3a91a8_8', 'MALILI', '73_24_4_1003', 1, 7, 2020, '2020-07-26', '2020-08-29', 31, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 88, 0, 0, 0),
(49, 8, 'baf6745a5951e8e1cbab060b3c3a91a8_8', 'WEWANG RIU', '73_24_4_2005', 1, 7, 2020, '2020-07-26', '2020-08-29', 31, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 7, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2, 0, 0, 0, 0, 0, 78, 0, 0, 0),
(50, 8, 'baf6745a5951e8e1cbab060b3c3a91a8_8', 'BARUGA', '73_24_4_2006', 1, 7, 2020, '2020-07-26', '2020-08-29', 31, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 64, 0, 0, 0),
(51, 8, 'baf6745a5951e8e1cbab060b3c3a91a8_8', 'USSU', '73_24_4_2008', 1, 7, 2020, '2020-07-26', '2020-08-29', 31, 4, 0, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 41, 0, 0, 0),
(52, 8, 'baf6745a5951e8e1cbab060b3c3a91a8_8', 'BALANTANG', '73_24_4_2010', 1, 7, 2020, '2020-07-26', '2020-08-29', 31, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 28, 0, 0, 0),
(53, 8, 'baf6745a5951e8e1cbab060b3c3a91a8_8', 'ATUE', '73_24_4_2011', 1, 7, 2020, '2020-07-26', '2020-08-29', 31, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 26, 0, 0, 0),
(54, 8, 'baf6745a5951e8e1cbab060b3c3a91a8_8', 'PUNCAK INDAH', '73_24_4_2013', 1, 7, 2020, '2020-07-26', '2020-08-29', 31, 0, 0, 4, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 1, 0, 0, 0, 4, 4, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 125, 0, 0, 0),
(55, 3, '91985409eb900bc3706c227bebbf86f2_3', 'LUAR WILAYAH', '888', 1, 6, 2020, '2020-06-28', '2020-07-04', 27, 2, 0, 4, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2, 0, 12, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(56, 3, '91985409eb900bc3706c227bebbf86f2_3', 'TOMONI', '73_24_8_1003', 1, 6, 2020, '2020-06-28', '2020-07-04', 27, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(57, 3, '91985409eb900bc3706c227bebbf86f2_3', 'BAYONDO', '73_24_8_2001', 1, 6, 2020, '2020-06-28', '2020-07-04', 27, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(58, 3, '91985409eb900bc3706c227bebbf86f2_3', 'MULYA SARI', '73_24_8_2002', 1, 6, 2020, '2020-06-28', '2020-07-04', 27, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(59, 3, '91985409eb900bc3706c227bebbf86f2_3', 'LESTARI', '73_24_8_2007', 1, 6, 2020, '2020-06-28', '2020-07-04', 27, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(60, 3, '91985409eb900bc3706c227bebbf86f2_3', 'KALPATARU', '73_24_8_2008', 1, 6, 2020, '2020-06-28', '2020-07-04', 27, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(61, 3, '91985409eb900bc3706c227bebbf86f2_3', 'TADULAKO', '73_24_8_2011', 1, 6, 2020, '2020-06-28', '2020-07-04', 27, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(62, 3, '91985409eb900bc3706c227bebbf86f2_3', 'BERINGIN JAYA', '73_24_8_2012', 1, 6, 2020, '2020-06-28', '2020-07-04', 27, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(63, 3, '91985409eb900bc3706c227bebbf86f2_3', 'BANGUN JAYA', '73_24_8_2015', 1, 6, 2020, '2020-06-28', '2020-07-04', 27, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(64, 3, '91985409eb900bc3706c227bebbf86f2_3', 'MANDIRI', '73_24_8_2016', 1, 6, 2020, '2020-06-28', '2020-07-04', 27, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(65, 3, '91985409eb900bc3706c227bebbf86f2_3', 'SUMBER ALAM', '73_24_8_2017', 1, 6, 2020, '2020-06-28', '2020-07-04', 27, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(66, 3, '91985409eb900bc3706c227bebbf86f2_3', 'UJUNG BARU', '73_24_8_2018', 1, 6, 2020, '2020-06-28', '2020-07-04', 27, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(67, 3, '91985409eb900bc3706c227bebbf86f2_3', 'BANGUN KARYA', '73_24_8_2019', 1, 6, 2020, '2020-06-28', '2020-07-04', 27, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(68, 3, '91985409eb900bc3706c227bebbf86f2_3', 'RANTE MARIO', '73_24_8_2020', 1, 6, 2020, '2020-06-28', '2020-07-04', 27, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(69, 3, 'c91211d35a774c85bdc4b71107dba22c_3', 'LUAR WILAYAH', '888', 1, 7, 2020, '2020-07-05', '2020-07-11', 28, 3, 0, 5, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 23, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(70, 3, 'c91211d35a774c85bdc4b71107dba22c_3', 'TOMONI', '73_24_8_1003', 1, 7, 2020, '2020-07-05', '2020-07-11', 28, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(71, 3, 'c91211d35a774c85bdc4b71107dba22c_3', 'BAYONDO', '73_24_8_2001', 1, 7, 2020, '2020-07-05', '2020-07-11', 28, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(72, 3, 'c91211d35a774c85bdc4b71107dba22c_3', 'MULYA SARI', '73_24_8_2002', 1, 7, 2020, '2020-07-05', '2020-07-11', 28, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(73, 3, 'c91211d35a774c85bdc4b71107dba22c_3', 'LESTARI', '73_24_8_2007', 1, 7, 2020, '2020-07-05', '2020-07-11', 28, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(74, 3, 'c91211d35a774c85bdc4b71107dba22c_3', 'KALPATARU', '73_24_8_2008', 1, 7, 2020, '2020-07-05', '2020-07-11', 28, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(75, 3, 'c91211d35a774c85bdc4b71107dba22c_3', 'TADULAKO', '73_24_8_2011', 1, 7, 2020, '2020-07-05', '2020-07-11', 28, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(76, 3, 'c91211d35a774c85bdc4b71107dba22c_3', 'BERINGIN JAYA', '73_24_8_2012', 1, 7, 2020, '2020-07-05', '2020-07-11', 28, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(77, 3, 'c91211d35a774c85bdc4b71107dba22c_3', 'BANGUN JAYA', '73_24_8_2015', 1, 7, 2020, '2020-07-05', '2020-07-11', 28, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(78, 3, 'c91211d35a774c85bdc4b71107dba22c_3', 'MANDIRI', '73_24_8_2016', 1, 7, 2020, '2020-07-05', '2020-07-11', 28, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(79, 3, 'c91211d35a774c85bdc4b71107dba22c_3', 'SUMBER ALAM', '73_24_8_2017', 1, 7, 2020, '2020-07-05', '2020-07-11', 28, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(80, 3, 'c91211d35a774c85bdc4b71107dba22c_3', 'UJUNG BARU', '73_24_8_2018', 1, 7, 2020, '2020-07-05', '2020-07-11', 28, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(81, 3, 'c91211d35a774c85bdc4b71107dba22c_3', 'BANGUN KARYA', '73_24_8_2019', 1, 7, 2020, '2020-07-05', '2020-07-11', 28, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(82, 3, 'c91211d35a774c85bdc4b71107dba22c_3', 'RANTE MARIO', '73_24_8_2020', 1, 7, 2020, '2020-07-05', '2020-07-11', 28, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(83, 3, '711295bc7f46f6fdc447948b1acea78f_3', 'LUAR WILAYAH', '888', 1, 7, 2020, '2020-07-12', '2020-07-18', 29, 1, 0, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2, 0, 24, 0, 0, 0, 0, 0, 235, 0, 0, 0),
(84, 3, '711295bc7f46f6fdc447948b1acea78f_3', 'TOMONI', '73_24_8_1003', 1, 7, 2020, '2020-07-12', '2020-07-18', 29, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(85, 3, '711295bc7f46f6fdc447948b1acea78f_3', 'BAYONDO', '73_24_8_2001', 1, 7, 2020, '2020-07-12', '2020-07-18', 29, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(86, 3, '711295bc7f46f6fdc447948b1acea78f_3', 'MULYA SARI', '73_24_8_2002', 1, 7, 2020, '2020-07-12', '2020-07-18', 29, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(87, 3, '711295bc7f46f6fdc447948b1acea78f_3', 'LESTARI', '73_24_8_2007', 1, 7, 2020, '2020-07-12', '2020-07-18', 29, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(88, 3, '711295bc7f46f6fdc447948b1acea78f_3', 'KALPATARU', '73_24_8_2008', 1, 7, 2020, '2020-07-12', '2020-07-18', 29, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(89, 3, '711295bc7f46f6fdc447948b1acea78f_3', 'TADULAKO', '73_24_8_2011', 1, 7, 2020, '2020-07-12', '2020-07-18', 29, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(90, 3, '711295bc7f46f6fdc447948b1acea78f_3', 'BERINGIN JAYA', '73_24_8_2012', 1, 7, 2020, '2020-07-12', '2020-07-18', 29, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(91, 3, '711295bc7f46f6fdc447948b1acea78f_3', 'BANGUN JAYA', '73_24_8_2015', 1, 7, 2020, '2020-07-12', '2020-07-18', 29, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(92, 3, '711295bc7f46f6fdc447948b1acea78f_3', 'MANDIRI', '73_24_8_2016', 1, 7, 2020, '2020-07-12', '2020-07-18', 29, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(93, 3, '711295bc7f46f6fdc447948b1acea78f_3', 'SUMBER ALAM', '73_24_8_2017', 1, 7, 2020, '2020-07-12', '2020-07-18', 29, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(94, 3, '711295bc7f46f6fdc447948b1acea78f_3', 'UJUNG BARU', '73_24_8_2018', 1, 7, 2020, '2020-07-12', '2020-07-18', 29, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(95, 3, '711295bc7f46f6fdc447948b1acea78f_3', 'BANGUN KARYA', '73_24_8_2019', 1, 7, 2020, '2020-07-12', '2020-07-18', 29, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(96, 3, '711295bc7f46f6fdc447948b1acea78f_3', 'RANTE MARIO', '73_24_8_2020', 1, 7, 2020, '2020-07-12', '2020-07-18', 29, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(97, 3, '460ab0e04b019f1626c0a290b12f981c_3', 'LUAR WILAYAH', '888', 1, 7, 2020, '2020-07-19', '2020-07-25', 30, 1, 0, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 28, 0, 0, 0, 0, 0, 345, 0, 0, 0),
(98, 3, '460ab0e04b019f1626c0a290b12f981c_3', 'TOMONI', '73_24_8_1003', 1, 7, 2020, '2020-07-19', '2020-07-25', 30, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(99, 3, '460ab0e04b019f1626c0a290b12f981c_3', 'BAYONDO', '73_24_8_2001', 1, 7, 2020, '2020-07-19', '2020-07-25', 30, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(100, 3, '460ab0e04b019f1626c0a290b12f981c_3', 'MULYA SARI', '73_24_8_2002', 1, 7, 2020, '2020-07-19', '2020-07-25', 30, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(101, 3, '460ab0e04b019f1626c0a290b12f981c_3', 'LESTARI', '73_24_8_2007', 1, 7, 2020, '2020-07-19', '2020-07-25', 30, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(102, 3, '460ab0e04b019f1626c0a290b12f981c_3', 'KALPATARU', '73_24_8_2008', 1, 7, 2020, '2020-07-19', '2020-07-25', 30, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(103, 3, '460ab0e04b019f1626c0a290b12f981c_3', 'TADULAKO', '73_24_8_2011', 1, 7, 2020, '2020-07-19', '2020-07-25', 30, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(104, 3, '460ab0e04b019f1626c0a290b12f981c_3', 'BERINGIN JAYA', '73_24_8_2012', 1, 7, 2020, '2020-07-19', '2020-07-25', 30, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(105, 3, '460ab0e04b019f1626c0a290b12f981c_3', 'BANGUN JAYA', '73_24_8_2015', 1, 7, 2020, '2020-07-19', '2020-07-25', 30, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(106, 3, '460ab0e04b019f1626c0a290b12f981c_3', 'MANDIRI', '73_24_8_2016', 1, 7, 2020, '2020-07-19', '2020-07-25', 30, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(107, 3, '460ab0e04b019f1626c0a290b12f981c_3', 'SUMBER ALAM', '73_24_8_2017', 1, 7, 2020, '2020-07-19', '2020-07-25', 30, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(108, 3, '460ab0e04b019f1626c0a290b12f981c_3', 'UJUNG BARU', '73_24_8_2018', 1, 7, 2020, '2020-07-19', '2020-07-25', 30, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(109, 3, '460ab0e04b019f1626c0a290b12f981c_3', 'BANGUN KARYA', '73_24_8_2019', 1, 7, 2020, '2020-07-19', '2020-07-25', 30, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(110, 3, '460ab0e04b019f1626c0a290b12f981c_3', 'RANTE MARIO', '73_24_8_2020', 1, 7, 2020, '2020-07-19', '2020-07-25', 30, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(111, 3, 'b6513ea8fcf2256189fcc26fa2707dc7_3', 'LUAR WILAYAH', '888', 1, 7, 2020, '2020-07-26', '2020-08-01', 31, 1, 0, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 12, 0, 0, 0, 0, 0, 456, 0, 0, 0),
(112, 3, 'b6513ea8fcf2256189fcc26fa2707dc7_3', 'TOMONI', '73_24_8_1003', 1, 7, 2020, '2020-07-26', '2020-08-01', 31, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(113, 3, 'b6513ea8fcf2256189fcc26fa2707dc7_3', 'BAYONDO', '73_24_8_2001', 1, 7, 2020, '2020-07-26', '2020-08-01', 31, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(114, 3, 'b6513ea8fcf2256189fcc26fa2707dc7_3', 'MULYA SARI', '73_24_8_2002', 1, 7, 2020, '2020-07-26', '2020-08-01', 31, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(115, 3, 'b6513ea8fcf2256189fcc26fa2707dc7_3', 'LESTARI', '73_24_8_2007', 1, 7, 2020, '2020-07-26', '2020-08-01', 31, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(116, 3, 'b6513ea8fcf2256189fcc26fa2707dc7_3', 'KALPATARU', '73_24_8_2008', 1, 7, 2020, '2020-07-26', '2020-08-01', 31, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(117, 3, 'b6513ea8fcf2256189fcc26fa2707dc7_3', 'TADULAKO', '73_24_8_2011', 1, 7, 2020, '2020-07-26', '2020-08-01', 31, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(118, 3, 'b6513ea8fcf2256189fcc26fa2707dc7_3', 'BERINGIN JAYA', '73_24_8_2012', 1, 7, 2020, '2020-07-26', '2020-08-01', 31, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(119, 3, 'b6513ea8fcf2256189fcc26fa2707dc7_3', 'BANGUN JAYA', '73_24_8_2015', 1, 7, 2020, '2020-07-26', '2020-08-01', 31, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(120, 3, 'b6513ea8fcf2256189fcc26fa2707dc7_3', 'MANDIRI', '73_24_8_2016', 1, 7, 2020, '2020-07-26', '2020-08-01', 31, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(121, 3, 'b6513ea8fcf2256189fcc26fa2707dc7_3', 'SUMBER ALAM', '73_24_8_2017', 1, 7, 2020, '2020-07-26', '2020-08-01', 31, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(122, 3, 'b6513ea8fcf2256189fcc26fa2707dc7_3', 'UJUNG BARU', '73_24_8_2018', 1, 7, 2020, '2020-07-26', '2020-08-01', 31, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(123, 3, 'b6513ea8fcf2256189fcc26fa2707dc7_3', 'BANGUN KARYA', '73_24_8_2019', 1, 7, 2020, '2020-07-26', '2020-08-01', 31, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(124, 3, 'b6513ea8fcf2256189fcc26fa2707dc7_3', 'RANTE MARIO', '73_24_8_2020', 1, 7, 2020, '2020-07-26', '2020-08-01', 31, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(133, 3, '1764feb0263970f6c50d1dded58dcfe0_3', 'LUAR WILAYAH', '888', 1, 12, 2019, '2019-12-29', '2020-01-04', 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(134, 3, '1764feb0263970f6c50d1dded58dcfe0_3', 'TOMONI', '73_24_8_1003', 1, 12, 2019, '2019-12-29', '2020-01-04', 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(135, 3, '1764feb0263970f6c50d1dded58dcfe0_3', 'BAYONDO', '73_24_8_2001', 1, 12, 2019, '2019-12-29', '2020-01-04', 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(136, 3, '1764feb0263970f6c50d1dded58dcfe0_3', 'MULYA SARI', '73_24_8_2002', 1, 12, 2019, '2019-12-29', '2020-01-04', 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(137, 3, '1764feb0263970f6c50d1dded58dcfe0_3', 'LESTARI', '73_24_8_2007', 1, 12, 2019, '2019-12-29', '2020-01-04', 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(138, 3, '1764feb0263970f6c50d1dded58dcfe0_3', 'KALPATARU', '73_24_8_2008', 1, 12, 2019, '2019-12-29', '2020-01-04', 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(139, 3, '1764feb0263970f6c50d1dded58dcfe0_3', 'TADULAKO', '73_24_8_2011', 1, 12, 2019, '2019-12-29', '2020-01-04', 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(140, 3, '1764feb0263970f6c50d1dded58dcfe0_3', 'BERINGIN JAYA', '73_24_8_2012', 1, 12, 2019, '2019-12-29', '2020-01-04', 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(141, 3, '1764feb0263970f6c50d1dded58dcfe0_3', 'BANGUN JAYA', '73_24_8_2015', 1, 12, 2019, '2019-12-29', '2020-01-04', 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(142, 3, '1764feb0263970f6c50d1dded58dcfe0_3', 'MANDIRI', '73_24_8_2016', 1, 12, 2019, '2019-12-29', '2020-01-04', 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(143, 3, '1764feb0263970f6c50d1dded58dcfe0_3', 'SUMBER ALAM', '73_24_8_2017', 1, 12, 2019, '2019-12-29', '2020-01-04', 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(144, 3, '1764feb0263970f6c50d1dded58dcfe0_3', 'UJUNG BARU', '73_24_8_2018', 1, 12, 2019, '2019-12-29', '2020-01-04', 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(145, 3, '1764feb0263970f6c50d1dded58dcfe0_3', 'BANGUN KARYA', '73_24_8_2019', 1, 12, 2019, '2019-12-29', '2020-01-04', 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(146, 3, '1764feb0263970f6c50d1dded58dcfe0_3', 'RANTE MARIO', '73_24_8_2020', 1, 12, 2019, '2019-12-29', '2020-01-04', 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(195, 2, '519b89e487f77cd98670c08e357eb534_2', 'LUAR WILAYAH', '888', 1, 7, 2020, '2020-07-19', '2020-07-25', 30, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(196, 2, '519b89e487f77cd98670c08e357eb534_2', 'LAMPENAI', '73_24_6_2001', 1, 7, 2020, '2020-07-19', '2020-07-25', 30, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 25, 0, 0, 0),
(197, 2, '519b89e487f77cd98670c08e357eb534_2', 'TARENGGE', '73_24_6_2002', 1, 7, 2020, '2020-07-19', '2020-07-25', 30, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(198, 2, '519b89e487f77cd98670c08e357eb534_2', 'MARAMBA', '73_24_6_2003', 1, 7, 2020, '2020-07-19', '2020-07-25', 30, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 28, 0, 0, 0),
(199, 2, '519b89e487f77cd98670c08e357eb534_2', 'CENDANA HIJAU', '73_24_6_2004', 1, 7, 2020, '2020-07-19', '2020-07-25', 30, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 40, 0, 0, 0),
(200, 2, '519b89e487f77cd98670c08e357eb534_2', 'BAWALIPU', '73_24_6_2005', 1, 7, 2020, '2020-07-19', '2020-07-25', 30, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 9, 0, 0, 0),
(201, 2, '519b89e487f77cd98670c08e357eb534_2', 'KALAENA', '73_24_6_2006', 1, 7, 2020, '2020-07-19', '2020-07-25', 30, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(202, 2, '519b89e487f77cd98670c08e357eb534_2', 'LERA', '73_24_6_2007', 1, 7, 2020, '2020-07-19', '2020-07-25', 30, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 18, 0, 0, 0),
(203, 2, '519b89e487f77cd98670c08e357eb534_2', 'KANAWATU', '73_24_6_2008', 1, 7, 2020, '2020-07-19', '2020-07-25', 30, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 14, 0, 0, 0),
(204, 2, '519b89e487f77cd98670c08e357eb534_2', 'BAHARI', '73_24_6_2009', 1, 7, 2020, '2020-07-19', '2020-07-25', 30, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 9, 0, 0, 0),
(205, 2, '519b89e487f77cd98670c08e357eb534_2', 'KARAMBUA', '73_24_6_2010', 1, 7, 2020, '2020-07-19', '2020-07-25', 30, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 14, 0, 0, 0),
(206, 2, '519b89e487f77cd98670c08e357eb534_2', 'PEPURO BARAT', '73_24_6_2011', 1, 7, 2020, '2020-07-19', '2020-07-25', 30, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 21, 0, 0, 0),
(207, 2, '519b89e487f77cd98670c08e357eb534_2', 'BALOBALO', '73_24_6_2012', 1, 7, 2020, '2020-07-19', '2020-07-25', 30, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 8, 0, 0, 0),
(208, 2, '519b89e487f77cd98670c08e357eb534_2', 'RINJANI', '73_24_6_2013', 1, 7, 2020, '2020-07-19', '2020-07-25', 30, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 22, 0, 0, 0),
(209, 2, '519b89e487f77cd98670c08e357eb534_2', 'TARENGGE TIMUR', '73_24_6_2014', 1, 7, 2020, '2020-07-19', '2020-07-25', 30, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 9, 0, 0, 0),
(210, 2, '519b89e487f77cd98670c08e357eb534_2', 'MADANI', '73_24_6_2015', 1, 7, 2020, '2020-07-19', '2020-07-25', 30, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 6, 0, 0, 0, 0, 0, 21, 0, 0, 0),
(211, 2, '519b89e487f77cd98670c08e357eb534_2', 'TABAROGE', '73_24_6_2016', 1, 7, 2020, '2020-07-19', '2020-07-25', 30, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 18, 0, 0, 0),
(212, 2, 'cd1378fc9fe09b0bba4d4298c9ec68a3_2', 'LUAR WILAYAH', '888', 1, 7, 2020, '2020-07-12', '2020-07-18', 29, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(213, 2, 'cd1378fc9fe09b0bba4d4298c9ec68a3_2', 'LAMPENAI', '73_24_6_2001', 1, 7, 2020, '2020-07-12', '2020-07-18', 29, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 6, 0, 0, 0, 0, 0, 22, 0, 0, 0),
(214, 2, 'cd1378fc9fe09b0bba4d4298c9ec68a3_2', 'TARENGGE', '73_24_6_2002', 1, 7, 2020, '2020-07-12', '2020-07-18', 29, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 13, 0, 0, 0),
(215, 2, 'cd1378fc9fe09b0bba4d4298c9ec68a3_2', 'MARAMBA', '73_24_6_2003', 1, 7, 2020, '2020-07-12', '2020-07-18', 29, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 23, 0, 0, 0),
(216, 2, 'cd1378fc9fe09b0bba4d4298c9ec68a3_2', 'CENDANA HIJAU', '73_24_6_2004', 1, 7, 2020, '2020-07-12', '2020-07-18', 29, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 23, 0, 0, 0),
(217, 2, 'cd1378fc9fe09b0bba4d4298c9ec68a3_2', 'BAWALIPU', '73_24_6_2005', 1, 7, 2020, '2020-07-12', '2020-07-18', 29, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(218, 2, 'cd1378fc9fe09b0bba4d4298c9ec68a3_2', 'KALAENA', '73_24_6_2006', 1, 7, 2020, '2020-07-12', '2020-07-18', 29, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(219, 2, 'cd1378fc9fe09b0bba4d4298c9ec68a3_2', 'LERA', '73_24_6_2007', 1, 7, 2020, '2020-07-12', '2020-07-18', 29, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 12, 0, 0, 0);
INSERT INTO `w_dua_isi` (`id_w_dua_isi`, `id_dusun`, `id_w_dua`, `desa`, `id_desa`, `bentuk`, `bulan`, `tahun`, `periode_awal`, `periode_akhir`, `minggu_ke`, `diare_k_lima_p`, `diare_k_lima_m`, `diare_l_lima_p`, `diare_l_lima_m`, `kholera_p`, `kholera_m`, `dbd_min_p`, `dbd_min_m`, `dbd_plus_p`, `dbd_plus_m`, `pes_p`, `pes_m`, `polio_p`, `polio_m`, `diferi_min_p`, `diferi_min_m`, `diferi_plus_p`, `diferi_plus_m`, `campak_k_lima_p`, `campak_k_lima_m`, `campak_l_lima_p`, `campak_l_lima_m`, `pneumonia_p`, `pneumonia_m`, `tetanus_p`, `tetanus_m`, `maramus_p`, `maramus_m`, `hepatitis_klinis_p`, `hepatitis_klinis_m`, `hepatitis_hbs_p`, `hepatitis_hbs_m`, `lahir_mati_m`, `kematian_bayi_m`, `kematian_neo_m`, `kematian_ibu_m`, `bblr_p`, `bblr_m`, `tb_min_p`, `tb_min_m`, `tb_plus_p`, `tb_plus_m`, `bgm_p`, `bgm_m`, `typhoid_min_p`, `typhoid_min_m`, `thypoid_plus_p`, `thypoid_plus_m`, `malaria_klinis_p`, `malaria_klinis_m`, `jumlah_persalinan_p`, `jumlah_kelahiran_hidup_p`, `kasus_gigitan_p`, `kasus_gigitan_m`, `infulensa_p`, `infulensa_m`, `marasmus_p`, `marasmus_m`, `varicella_p`, `varicella_m`, `lepospirosi_p`, `lepospirosi_m`, `dysentry_p`, `dysentry_m`, `ili_p`, `ili_m`, `suspek_ai_p`, `suspek_ai_m`, `demam_tdk_tau_p`, `demam_tdk_tau_m`, `jumlah_kunjungan_p`, `jumlah_kunjungan_m`, `pustu_l`, `pustu_t`) VALUES
(220, 2, 'cd1378fc9fe09b0bba4d4298c9ec68a3_2', 'KANAWATU', '73_24_6_2008', 1, 7, 2020, '2020-07-12', '2020-07-18', 29, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(221, 2, 'cd1378fc9fe09b0bba4d4298c9ec68a3_2', 'BAHARI', '73_24_6_2009', 1, 7, 2020, '2020-07-12', '2020-07-18', 29, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 5, 0, 0, 0),
(222, 2, 'cd1378fc9fe09b0bba4d4298c9ec68a3_2', 'KARAMBUA', '73_24_6_2010', 1, 7, 2020, '2020-07-12', '2020-07-18', 29, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0),
(223, 2, 'cd1378fc9fe09b0bba4d4298c9ec68a3_2', 'PEPURO BARAT', '73_24_6_2011', 1, 7, 2020, '2020-07-12', '2020-07-18', 29, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(224, 2, 'cd1378fc9fe09b0bba4d4298c9ec68a3_2', 'BALOBALO', '73_24_6_2012', 1, 7, 2020, '2020-07-12', '2020-07-18', 29, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 21, 0, 0, 0),
(225, 2, 'cd1378fc9fe09b0bba4d4298c9ec68a3_2', 'RINJANI', '73_24_6_2013', 1, 7, 2020, '2020-07-12', '2020-07-18', 29, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 10, 0, 0, 0),
(226, 2, 'cd1378fc9fe09b0bba4d4298c9ec68a3_2', 'TARENGGE TIMUR', '73_24_6_2014', 1, 7, 2020, '2020-07-12', '2020-07-18', 29, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(227, 2, 'cd1378fc9fe09b0bba4d4298c9ec68a3_2', 'MADANI', '73_24_6_2015', 1, 7, 2020, '2020-07-12', '2020-07-18', 29, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 3, 0, 0, 0, 0, 0, 24, 0, 0, 0),
(228, 2, 'cd1378fc9fe09b0bba4d4298c9ec68a3_2', 'TABAROGE', '73_24_6_2016', 1, 7, 2020, '2020-07-12', '2020-07-18', 29, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 7, 0, 0, 0),
(229, 2, 'e86ff3ff74e22a96e37afd36043ce920_2', 'LUAR WILAYAH', '888', 1, 7, 2020, '2020-07-05', '2020-07-11', 28, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(230, 2, 'e86ff3ff74e22a96e37afd36043ce920_2', 'LAMPENAI', '73_24_6_2001', 1, 7, 2020, '2020-07-05', '2020-07-11', 28, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 4, 0, 0, 0, 0, 0, 19, 0, 0, 0),
(231, 2, 'e86ff3ff74e22a96e37afd36043ce920_2', 'TARENGGE', '73_24_6_2002', 1, 7, 2020, '2020-07-05', '2020-07-11', 28, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 14, 0, 0, 0),
(232, 2, 'e86ff3ff74e22a96e37afd36043ce920_2', 'MARAMBA', '73_24_6_2003', 1, 7, 2020, '2020-07-05', '2020-07-11', 28, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 8, 0, 0, 0),
(233, 2, 'e86ff3ff74e22a96e37afd36043ce920_2', 'CENDANA HIJAU', '73_24_6_2004', 1, 7, 2020, '2020-07-05', '2020-07-11', 28, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 18, 0, 0, 0),
(234, 2, 'e86ff3ff74e22a96e37afd36043ce920_2', 'BAWALIPU', '73_24_6_2005', 1, 7, 2020, '2020-07-05', '2020-07-11', 28, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(235, 2, 'e86ff3ff74e22a96e37afd36043ce920_2', 'KALAENA', '73_24_6_2006', 1, 7, 2020, '2020-07-05', '2020-07-11', 28, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2, 0, 0, 0, 0, 0, 21, 0, 0, 0),
(236, 2, 'e86ff3ff74e22a96e37afd36043ce920_2', 'LERA', '73_24_6_2007', 1, 7, 2020, '2020-07-05', '2020-07-11', 28, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 20, 0, 0, 0),
(237, 2, 'e86ff3ff74e22a96e37afd36043ce920_2', 'KANAWATU', '73_24_6_2008', 1, 7, 2020, '2020-07-05', '2020-07-11', 28, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2, 0, 0, 0, 0, 0, 25, 0, 0, 0),
(238, 2, 'e86ff3ff74e22a96e37afd36043ce920_2', 'BAHARI', '73_24_6_2009', 1, 7, 2020, '2020-07-05', '2020-07-11', 28, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 6, 0, 0, 0),
(239, 2, 'e86ff3ff74e22a96e37afd36043ce920_2', 'KARAMBUA', '73_24_6_2010', 1, 7, 2020, '2020-07-05', '2020-07-11', 28, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 16, 0, 0, 0),
(240, 2, 'e86ff3ff74e22a96e37afd36043ce920_2', 'PEPURO BARAT', '73_24_6_2011', 1, 7, 2020, '2020-07-05', '2020-07-11', 28, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 6, 0, 0, 0),
(241, 2, 'e86ff3ff74e22a96e37afd36043ce920_2', 'BALOBALO', '73_24_6_2012', 1, 7, 2020, '2020-07-05', '2020-07-11', 28, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(242, 2, 'e86ff3ff74e22a96e37afd36043ce920_2', 'RINJANI', '73_24_6_2013', 1, 7, 2020, '2020-07-05', '2020-07-11', 28, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 4, 0, 0, 0, 0, 0, 21, 0, 0, 0),
(243, 2, 'e86ff3ff74e22a96e37afd36043ce920_2', 'TARENGGE TIMUR', '73_24_6_2014', 1, 7, 2020, '2020-07-05', '2020-07-11', 28, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(244, 2, 'e86ff3ff74e22a96e37afd36043ce920_2', 'MADANI', '73_24_6_2015', 1, 7, 2020, '2020-07-05', '2020-07-11', 28, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 35, 0, 0, 0),
(245, 2, 'e86ff3ff74e22a96e37afd36043ce920_2', 'TABAROGE', '73_24_6_2016', 1, 7, 2020, '2020-07-05', '2020-07-11', 28, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(246, 2, '7a898e5d3f90831f9c426db90e8214be_2', 'LUAR WILAYAH', '888', 1, 6, 2020, '2020-06-28', '2020-07-04', 27, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(247, 2, '7a898e5d3f90831f9c426db90e8214be_2', 'LAMPENAI', '73_24_6_2001', 1, 6, 2020, '2020-06-28', '2020-07-04', 27, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 23, 0, 0, 0, 0, 0, 26, 0, 0, 0),
(248, 2, '7a898e5d3f90831f9c426db90e8214be_2', 'TARENGGE', '73_24_6_2002', 1, 6, 2020, '2020-06-28', '2020-07-04', 27, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(249, 2, '7a898e5d3f90831f9c426db90e8214be_2', 'MARAMBA', '73_24_6_2003', 1, 6, 2020, '2020-06-28', '2020-07-04', 27, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 18, 0, 0, 0),
(250, 2, '7a898e5d3f90831f9c426db90e8214be_2', 'CENDANA HIJAU', '73_24_6_2004', 1, 6, 2020, '2020-06-28', '2020-07-04', 27, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 25, 0, 0, 0),
(251, 2, '7a898e5d3f90831f9c426db90e8214be_2', 'BAWALIPU', '73_24_6_2005', 1, 6, 2020, '2020-06-28', '2020-07-04', 27, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(252, 2, '7a898e5d3f90831f9c426db90e8214be_2', 'KALAENA', '73_24_6_2006', 1, 6, 2020, '2020-06-28', '2020-07-04', 27, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 7, 0, 0, 0, 0, 0, 23, 0, 0, 0),
(253, 2, '7a898e5d3f90831f9c426db90e8214be_2', 'LERA', '73_24_6_2007', 1, 6, 2020, '2020-06-28', '2020-07-04', 27, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 30, 0, 0, 0),
(254, 2, '7a898e5d3f90831f9c426db90e8214be_2', 'KANAWATU', '73_24_6_2008', 1, 6, 2020, '2020-06-28', '2020-07-04', 27, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 3, 0, 0, 0, 0, 0, 34, 0, 0, 0),
(255, 2, '7a898e5d3f90831f9c426db90e8214be_2', 'BAHARI', '73_24_6_2009', 1, 6, 2020, '2020-06-28', '2020-07-04', 27, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 9, 0, 0, 0),
(256, 2, '7a898e5d3f90831f9c426db90e8214be_2', 'KARAMBUA', '73_24_6_2010', 1, 6, 2020, '2020-06-28', '2020-07-04', 27, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 16, 0, 0, 0),
(257, 2, '7a898e5d3f90831f9c426db90e8214be_2', 'PEPURO BARAT', '73_24_6_2011', 1, 6, 2020, '2020-06-28', '2020-07-04', 27, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 14, 0, 0, 0),
(258, 2, '7a898e5d3f90831f9c426db90e8214be_2', 'BALOBALO', '73_24_6_2012', 1, 6, 2020, '2020-06-28', '2020-07-04', 27, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 10, 0, 0, 0),
(259, 2, '7a898e5d3f90831f9c426db90e8214be_2', 'RINJANI', '73_24_6_2013', 1, 6, 2020, '2020-06-28', '2020-07-04', 27, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2, 0, 0, 0, 0, 0, 14, 0, 0, 0),
(260, 2, '7a898e5d3f90831f9c426db90e8214be_2', 'TARENGGE TIMUR', '73_24_6_2014', 1, 6, 2020, '2020-06-28', '2020-07-04', 27, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(261, 2, '7a898e5d3f90831f9c426db90e8214be_2', 'MADANI', '73_24_6_2015', 1, 6, 2020, '2020-06-28', '2020-07-04', 27, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 24, 0, 0, 0),
(262, 2, '7a898e5d3f90831f9c426db90e8214be_2', 'TABAROGE', '73_24_6_2016', 1, 6, 2020, '2020-06-28', '2020-07-04', 27, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 8, 0, 0, 0),
(263, 8, '', 'LUAR WILAYAH', '888', 1, 12, 2019, '2019-12-29', '2020-01-04', 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(271, 8, '', 'LUAR WILAYAH', '888', 1, 4, 2020, '2020-04-05', '2020-04-11', 15, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(279, 8, '', 'LUAR WILAYAH', '888', 1, 6, 2020, '2020-06-28', '2020-07-04', 27, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(280, 8, 'c11e4db1a78cd7e9cdc12c2ad63944d5_8', 'MALILI', '73_24_4_1003', 1, 6, 2020, '2020-06-28', '2020-07-04', 27, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(281, 8, 'c11e4db1a78cd7e9cdc12c2ad63944d5_8', 'WEWANG RIU', '73_24_4_2005', 1, 6, 2020, '2020-06-28', '2020-07-04', 27, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(282, 8, 'c11e4db1a78cd7e9cdc12c2ad63944d5_8', 'BARUGA', '73_24_4_2006', 1, 6, 2020, '2020-06-28', '2020-07-04', 27, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(283, 8, 'c11e4db1a78cd7e9cdc12c2ad63944d5_8', 'USSU', '73_24_4_2008', 1, 6, 2020, '2020-06-28', '2020-07-04', 27, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(284, 8, 'c11e4db1a78cd7e9cdc12c2ad63944d5_8', 'BALANTANG', '73_24_4_2010', 1, 6, 2020, '2020-06-28', '2020-07-04', 27, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(285, 8, 'c11e4db1a78cd7e9cdc12c2ad63944d5_8', 'ATUE', '73_24_4_2011', 1, 6, 2020, '2020-06-28', '2020-07-04', 27, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(286, 8, 'c11e4db1a78cd7e9cdc12c2ad63944d5_8', 'PUNCAK INDAH', '73_24_4_2013', 1, 6, 2020, '2020-06-28', '2020-07-04', 27, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(287, 8, '', 'LUAR WILAYAH', '888', 1, 12, 2019, '2019-12-29', '2020-01-04', 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(295, 8, '', 'LUAR WILAYAH', '888', 1, 1, 2020, '2020-01-05', '2020-01-11', 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(303, 8, '', 'LUAR WILAYAH', '888', 1, 1, 2020, '2020-01-05', '2020-01-11', 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(311, 8, '', 'LUAR WILAYAH', '888', 1, 5, 2020, '2020-05-17', '2020-05-23', 21, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(319, 8, '', 'LUAR WILAYAH', '888', 1, 9, 2020, '2020-09-06', '2020-09-12', 37, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(327, 8, '', 'LUAR WILAYAH', '888', 1, 6, 2020, '2020-06-21', '2020-06-27', 26, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(343, 8, '14de5e133980dc941b41c9bb8dac2ec5_8', 'LUAR WILAYAH', '888', 1, 12, 2019, '2019-12-29', '2020-01-04', 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(344, 8, '14de5e133980dc941b41c9bb8dac2ec5_8', 'MALILI', '73_24_4_1003', 1, 12, 2019, '2019-12-29', '2020-01-04', 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(345, 8, '14de5e133980dc941b41c9bb8dac2ec5_8', 'WEWANG RIU', '73_24_4_2005', 1, 12, 2019, '2019-12-29', '2020-01-04', 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(346, 8, '14de5e133980dc941b41c9bb8dac2ec5_8', 'BARUGA', '73_24_4_2006', 1, 12, 2019, '2019-12-29', '2020-01-04', 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(347, 8, '14de5e133980dc941b41c9bb8dac2ec5_8', 'USSU', '73_24_4_2008', 1, 12, 2019, '2019-12-29', '2020-01-04', 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(348, 8, '14de5e133980dc941b41c9bb8dac2ec5_8', 'BALANTANG', '73_24_4_2010', 1, 12, 2019, '2019-12-29', '2020-01-04', 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(349, 8, '14de5e133980dc941b41c9bb8dac2ec5_8', 'ATUE', '73_24_4_2011', 1, 12, 2019, '2019-12-29', '2020-01-04', 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(350, 8, '14de5e133980dc941b41c9bb8dac2ec5_8', 'PUNCAK INDAH', '73_24_4_2013', 1, 12, 2019, '2019-12-29', '2020-01-04', 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Structure for view `lokasi`
--
DROP TABLE IF EXISTS `lokasi`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `lokasi`  AS SELECT `desa`.`id` AS `id_desa`, `desa`.`desa` AS `desa`, `kec`.`id` AS `id_kecamatan`, `kec`.`kecamatan` AS `kecamatan`, `kota`.`id` AS `id_kota`, `kota`.`kota` AS `kota`, `prov`.`id` AS `id_provinsi`, `prov`.`provinsi` AS `provinsi` FROM (((`tiger_desa` `desa` join `tiger_kecamatan` `kec` on(`desa`.`id_kecamatan` = `kec`.`id`)) join `tiger_kota` `kota` on(`kec`.`id_kota` = `kota`.`id`)) join `tiger_provinsi` `prov` on(`kota`.`id_provinsi` = `prov`.`id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `view_semua_paket`
--
DROP TABLE IF EXISTS `view_semua_paket`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_semua_paket`  AS SELECT `vp`.`asal_tabel` AS `asal_tabel`, `vp`.`id_paket` AS `id_paket`, `vp`.`id_pemohon` AS `id_pemohon`, `vp`.`nama` AS `nama`, `vp`.`nik` AS `nik`, `vp`.`no_kk` AS `no_kk`, `vp`.`no_registrasi_pemohon` AS `no_registrasi_pemohon`, `vp`.`nama_pemohon` AS `nama_pemohon`, `vp`.`no_wa_pemohon` AS `no_wa_pemohon`, `vp`.`id_desa` AS `id_desa`, `vp`.`create_date` AS `create_date`, `vp`.`create_time` AS `create_time`, `vp`.`username` AS `username`, `vp`.`id_dusun` AS `id_dusun`, `vp`.`update_time` AS `update_time`, `vp`.`status` AS `status`, `vp`.`alamat` AS `alamat`, `vp`.`alasan_penolakan` AS `alasan_penolakan`, `vp`.`status_baca` AS `status_baca`, `mp`.`nama_permohonan` AS `nama_permohonan`, `mp`.`deskripsi` AS `deskripsi` FROM ((select 'paket_a' AS `asal_tabel`,`paket_a`.`id_paket` AS `id_paket`,`paket_a`.`id_pemohon` AS `id_pemohon`,`paket_a`.`nama` AS `nama`,`paket_a`.`nik` AS `nik`,`paket_a`.`no_kk` AS `no_kk`,`paket_a`.`no_registrasi_pemohon` AS `no_registrasi_pemohon`,`paket_a`.`nama_pemohon` AS `nama_pemohon`,`paket_a`.`no_wa_pemohon` AS `no_wa_pemohon`,`paket_a`.`id_desa` AS `id_desa`,`paket_a`.`create_date` AS `create_date`,`paket_a`.`create_time` AS `create_time`,`paket_a`.`username` AS `username`,`paket_a`.`id_dusun` AS `id_dusun`,`paket_a`.`update_time` AS `update_time`,`paket_a`.`alamat` AS `alamat`,`paket_a`.`status` AS `status`,`paket_a`.`status_baca` AS `status_baca`,`paket_a`.`alasan_penolakan` AS `alasan_penolakan` from `paket_a` union all select 'paket_b' AS `paket_b`,`paket_b`.`id_paket` AS `id_paket`,`paket_b`.`id_pemohon` AS `id_pemohon`,`paket_b`.`nama` AS `nama`,`paket_b`.`nik` AS `nik`,`paket_b`.`no_kk` AS `no_kk`,`paket_b`.`no_registrasi_pemohon` AS `no_registrasi_pemohon`,`paket_b`.`nama_pemohon` AS `nama_pemohon`,`paket_b`.`no_wa_pemohon` AS `no_wa_pemohon`,`paket_b`.`id_desa` AS `id_desa`,`paket_b`.`create_date` AS `create_date`,`paket_b`.`create_time` AS `create_time`,`paket_b`.`username` AS `username`,`paket_b`.`id_dusun` AS `id_dusun`,`paket_b`.`update_time` AS `update_time`,`paket_b`.`alamat` AS `alamat`,`paket_b`.`status` AS `status`,`paket_b`.`status_baca` AS `status_baca`,`paket_b`.`alasan_penolakan` AS `alasan_penolakan` from `paket_b` union all select 'paket_c' AS `paket_c`,`paket_c`.`id_paket` AS `id_paket`,`paket_c`.`id_pemohon` AS `id_pemohon`,`paket_c`.`nama` AS `nama`,`paket_c`.`nik` AS `nik`,`paket_c`.`no_kk` AS `no_kk`,`paket_c`.`no_registrasi_pemohon` AS `no_registrasi_pemohon`,`paket_c`.`nama_pemohon` AS `nama_pemohon`,`paket_c`.`no_wa_pemohon` AS `no_wa_pemohon`,`paket_c`.`id_desa` AS `id_desa`,`paket_c`.`create_date` AS `create_date`,`paket_c`.`create_time` AS `create_time`,`paket_c`.`username` AS `username`,`paket_c`.`id_dusun` AS `id_dusun`,`paket_c`.`update_time` AS `update_time`,`paket_c`.`alamat` AS `alamat`,`paket_c`.`status` AS `status`,`paket_c`.`status_baca` AS `status_baca`,`paket_c`.`alasan_penolakan` AS `alasan_penolakan` from `paket_c` union all select 'paket_d' AS `paket_d`,`paket_d`.`id_paket` AS `id_paket`,`paket_d`.`id_pemohon` AS `id_pemohon`,`paket_d`.`nama` AS `nama`,`paket_d`.`nik` AS `nik`,`paket_d`.`no_kk` AS `no_kk`,`paket_d`.`no_registrasi_pemohon` AS `no_registrasi_pemohon`,`paket_d`.`nama_pemohon` AS `nama_pemohon`,`paket_d`.`no_wa_pemohon` AS `no_wa_pemohon`,`paket_d`.`id_desa` AS `id_desa`,`paket_d`.`create_date` AS `create_date`,`paket_d`.`create_time` AS `create_time`,`paket_d`.`username` AS `username`,`paket_d`.`id_dusun` AS `id_dusun`,`paket_d`.`update_time` AS `update_time`,`paket_d`.`alamat` AS `alamat`,`paket_d`.`status` AS `status`,`paket_d`.`status_baca` AS `status_baca`,`paket_d`.`alasan_penolakan` AS `alasan_penolakan` from `paket_d` union all select 'paket_e' AS `paket_e`,`paket_e`.`id_paket` AS `id_paket`,`paket_e`.`id_pemohon` AS `id_pemohon`,`paket_e`.`nama` AS `nama`,`paket_e`.`nik` AS `nik`,`paket_e`.`no_kk` AS `no_kk`,`paket_e`.`no_registrasi_pemohon` AS `no_registrasi_pemohon`,`paket_e`.`nama_pemohon` AS `nama_pemohon`,`paket_e`.`no_wa_pemohon` AS `no_wa_pemohon`,`paket_e`.`id_desa` AS `id_desa`,`paket_e`.`create_date` AS `create_date`,`paket_e`.`create_time` AS `create_time`,`paket_e`.`username` AS `username`,`paket_e`.`id_dusun` AS `id_dusun`,`paket_e`.`update_time` AS `update_time`,`paket_e`.`alamat` AS `alamat`,`paket_e`.`status` AS `status`,`paket_e`.`status_baca` AS `status_baca`,`paket_e`.`alasan_penolakan` AS `alasan_penolakan` from `paket_e` union all select 'paket_f' AS `paket_f`,`paket_f`.`id_paket` AS `id_paket`,`paket_f`.`id_pemohon` AS `id_pemohon`,`paket_f`.`nama` AS `nama`,`paket_f`.`nik` AS `nik`,`paket_f`.`no_kk` AS `no_kk`,`paket_f`.`no_registrasi_pemohon` AS `no_registrasi_pemohon`,`paket_f`.`nama_pemohon` AS `nama_pemohon`,`paket_f`.`no_wa_pemohon` AS `no_wa_pemohon`,`paket_f`.`id_desa` AS `id_desa`,`paket_f`.`create_date` AS `create_date`,`paket_f`.`create_time` AS `create_time`,`paket_f`.`username` AS `username`,`paket_f`.`id_dusun` AS `id_dusun`,`paket_f`.`update_time` AS `update_time`,`paket_f`.`alamat` AS `alamat`,`paket_f`.`status` AS `status`,`paket_f`.`status_baca` AS `status_baca`,`paket_f`.`alasan_penolakan` AS `alasan_penolakan` from `paket_f` union all select 'paket_g' AS `paket_g`,`paket_g`.`id_paket` AS `id_paket`,`paket_g`.`id_pemohon` AS `id_pemohon`,`paket_g`.`nama` AS `nama`,`paket_g`.`nik` AS `nik`,`paket_g`.`no_kk` AS `no_kk`,`paket_g`.`no_registrasi_pemohon` AS `no_registrasi_pemohon`,`paket_g`.`nama_pemohon` AS `nama_pemohon`,`paket_g`.`no_wa_pemohon` AS `no_wa_pemohon`,`paket_g`.`id_desa` AS `id_desa`,`paket_g`.`create_date` AS `create_date`,`paket_g`.`create_time` AS `create_time`,`paket_g`.`username` AS `username`,`paket_g`.`id_dusun` AS `id_dusun`,`paket_g`.`update_time` AS `update_time`,`paket_g`.`alamat` AS `alamat`,`paket_g`.`status` AS `status`,`paket_g`.`status_baca` AS `status_baca`,`paket_g`.`alasan_penolakan` AS `alasan_penolakan` from `paket_g` union all select 'paket_h' AS `paket_h`,`paket_h`.`id_paket` AS `id_paket`,`paket_h`.`id_pemohon` AS `id_pemohon`,`paket_h`.`nama` AS `nama`,`paket_h`.`nik` AS `nik`,`paket_h`.`no_kk` AS `no_kk`,`paket_h`.`no_registrasi_pemohon` AS `no_registrasi_pemohon`,`paket_h`.`nama_pemohon` AS `nama_pemohon`,`paket_h`.`no_wa_pemohon` AS `no_wa_pemohon`,`paket_h`.`id_desa` AS `id_desa`,`paket_h`.`create_date` AS `create_date`,`paket_h`.`create_time` AS `create_time`,`paket_h`.`username` AS `username`,`paket_h`.`id_dusun` AS `id_dusun`,`paket_h`.`update_time` AS `update_time`,`paket_h`.`alamat` AS `alamat`,`paket_h`.`status` AS `status`,`paket_h`.`status_baca` AS `status_baca`,`paket_h`.`alasan_penolakan` AS `alasan_penolakan` from `paket_h` union all select 'paket_i' AS `paket_i`,`paket_i`.`id_paket` AS `id_paket`,`paket_i`.`id_pemohon` AS `id_pemohon`,`paket_i`.`nama` AS `nama`,`paket_i`.`nik` AS `nik`,`paket_i`.`no_kk` AS `no_kk`,`paket_i`.`no_registrasi_pemohon` AS `no_registrasi_pemohon`,`paket_i`.`nama_pemohon` AS `nama_pemohon`,`paket_i`.`no_wa_pemohon` AS `no_wa_pemohon`,`paket_i`.`id_desa` AS `id_desa`,`paket_i`.`create_date` AS `create_date`,`paket_i`.`create_time` AS `create_time`,`paket_i`.`username` AS `username`,`paket_i`.`id_dusun` AS `id_dusun`,`paket_i`.`update_time` AS `update_time`,`paket_i`.`alamat` AS `alamat`,`paket_i`.`status` AS `status`,`paket_i`.`status_baca` AS `status_baca`,`paket_i`.`alasan_penolakan` AS `alasan_penolakan` from `paket_i` union all select 'paket_j' AS `paket_j`,`paket_j`.`id_paket` AS `id_paket`,`paket_j`.`id_pemohon` AS `id_pemohon`,`paket_j`.`nama` AS `nama`,`paket_j`.`nik` AS `nik`,`paket_j`.`no_kk` AS `no_kk`,`paket_j`.`no_registrasi_pemohon` AS `no_registrasi_pemohon`,`paket_j`.`nama_pemohon` AS `nama_pemohon`,`paket_j`.`no_wa_pemohon` AS `no_wa_pemohon`,`paket_j`.`id_desa` AS `id_desa`,`paket_j`.`create_date` AS `create_date`,`paket_j`.`create_time` AS `create_time`,`paket_j`.`username` AS `username`,`paket_j`.`id_dusun` AS `id_dusun`,`paket_j`.`update_time` AS `update_time`,`paket_j`.`alamat` AS `alamat`,`paket_j`.`status` AS `status`,`paket_j`.`status_baca` AS `status_baca`,`paket_j`.`alasan_penolakan` AS `alasan_penolakan` from `paket_j` union all select 'paket_k' AS `paket_k`,`paket_k`.`id_paket` AS `id_paket`,`paket_k`.`id_pemohon` AS `id_pemohon`,`paket_k`.`nama` AS `nama`,`paket_k`.`nik` AS `nik`,`paket_k`.`no_kk` AS `no_kk`,`paket_k`.`no_registrasi_pemohon` AS `no_registrasi_pemohon`,`paket_k`.`nama_pemohon` AS `nama_pemohon`,`paket_k`.`no_wa_pemohon` AS `no_wa_pemohon`,`paket_k`.`id_desa` AS `id_desa`,`paket_k`.`create_date` AS `create_date`,`paket_k`.`create_time` AS `create_time`,`paket_k`.`username` AS `username`,`paket_k`.`id_dusun` AS `id_dusun`,`paket_k`.`update_time` AS `update_time`,`paket_k`.`alamat` AS `alamat`,`paket_k`.`status` AS `status`,`paket_k`.`status_baca` AS `status_baca`,`paket_k`.`alasan_penolakan` AS `alasan_penolakan` from `paket_k` union all select 'paket_l' AS `paket_l`,`paket_l`.`id_paket` AS `id_paket`,`paket_l`.`id_pemohon` AS `id_pemohon`,`paket_l`.`nama` AS `nama`,`paket_l`.`nik` AS `nik`,`paket_l`.`no_kk` AS `no_kk`,`paket_l`.`no_registrasi_pemohon` AS `no_registrasi_pemohon`,`paket_l`.`nama_pemohon` AS `nama_pemohon`,`paket_l`.`no_wa_pemohon` AS `no_wa_pemohon`,`paket_l`.`id_desa` AS `id_desa`,`paket_l`.`create_date` AS `create_date`,`paket_l`.`create_time` AS `create_time`,`paket_l`.`username` AS `username`,`paket_l`.`id_dusun` AS `id_dusun`,`paket_l`.`update_time` AS `update_time`,`paket_l`.`alamat` AS `alamat`,`paket_l`.`status` AS `status`,`paket_l`.`status_baca` AS `status_baca`,`paket_l`.`alasan_penolakan` AS `alasan_penolakan` from `paket_l` union all select 'paket_m' AS `paket_m`,`paket_m`.`id_paket` AS `id_paket`,`paket_m`.`id_pemohon` AS `id_pemohon`,`paket_m`.`nama` AS `nama`,`paket_m`.`nik` AS `nik`,`paket_m`.`no_kk` AS `no_kk`,`paket_m`.`no_registrasi_pemohon` AS `no_registrasi_pemohon`,`paket_m`.`nama_pemohon` AS `nama_pemohon`,`paket_m`.`no_wa_pemohon` AS `no_wa_pemohon`,`paket_m`.`id_desa` AS `id_desa`,`paket_m`.`create_date` AS `create_date`,`paket_m`.`create_time` AS `create_time`,`paket_m`.`username` AS `username`,`paket_m`.`id_dusun` AS `id_dusun`,`paket_m`.`update_time` AS `update_time`,`paket_m`.`alamat` AS `alamat`,`paket_m`.`status` AS `status`,`paket_m`.`status_baca` AS `status_baca`,`paket_m`.`alasan_penolakan` AS `alasan_penolakan` from `paket_m` union all select 'paket_n' AS `paket_n`,`paket_n`.`id_paket` AS `id_paket`,`paket_n`.`id_pemohon` AS `id_pemohon`,`paket_n`.`nama` AS `nama`,`paket_n`.`nik` AS `nik`,`paket_n`.`no_kk` AS `no_kk`,`paket_n`.`no_registrasi_pemohon` AS `no_registrasi_pemohon`,`paket_n`.`nama_pemohon` AS `nama_pemohon`,`paket_n`.`no_wa_pemohon` AS `no_wa_pemohon`,`paket_n`.`id_desa` AS `id_desa`,`paket_n`.`create_date` AS `create_date`,`paket_n`.`create_time` AS `create_time`,`paket_n`.`username` AS `username`,`paket_n`.`id_dusun` AS `id_dusun`,`paket_n`.`update_time` AS `update_time`,`paket_n`.`alamat` AS `alamat`,`paket_n`.`status` AS `status`,`paket_n`.`status_baca` AS `status_baca`,`paket_n`.`alasan_penolakan` AS `alasan_penolakan` from `paket_n` union all select 'paket_p' AS `paket_p`,`paket_p`.`id_paket` AS `id_paket`,`paket_p`.`id_pemohon` AS `id_pemohon`,`paket_p`.`nama` AS `nama`,`paket_p`.`nik` AS `nik`,`paket_p`.`no_kk` AS `no_kk`,`paket_p`.`no_registrasi_pemohon` AS `no_registrasi_pemohon`,`paket_p`.`nama_pemohon` AS `nama_pemohon`,`paket_p`.`no_wa_pemohon` AS `no_wa_pemohon`,`paket_p`.`id_desa` AS `id_desa`,`paket_p`.`create_date` AS `create_date`,`paket_p`.`create_time` AS `create_time`,`paket_p`.`username` AS `username`,`paket_p`.`id_dusun` AS `id_dusun`,`paket_p`.`update_time` AS `update_time`,`paket_p`.`alamat` AS `alamat`,`paket_p`.`status` AS `status`,`paket_p`.`status_baca` AS `status_baca`,`paket_p`.`alasan_penolakan` AS `alasan_penolakan` from `paket_p` union all select 'paket_q' AS `paket_q`,`paket_q`.`id_paket` AS `id_paket`,`paket_q`.`id_pemohon` AS `id_pemohon`,`paket_q`.`nama` AS `nama`,`paket_q`.`nik` AS `nik`,`paket_q`.`no_kk` AS `no_kk`,`paket_q`.`no_registrasi_pemohon` AS `no_registrasi_pemohon`,`paket_q`.`nama_pemohon` AS `nama_pemohon`,`paket_q`.`no_wa_pemohon` AS `no_wa_pemohon`,`paket_q`.`id_desa` AS `id_desa`,`paket_q`.`create_date` AS `create_date`,`paket_q`.`create_time` AS `create_time`,`paket_q`.`username` AS `username`,`paket_q`.`id_dusun` AS `id_dusun`,`paket_q`.`update_time` AS `update_time`,`paket_q`.`alamat` AS `alamat`,`paket_q`.`status` AS `status`,`paket_q`.`status_baca` AS `status_baca`,`paket_q`.`alasan_penolakan` AS `alasan_penolakan` from `paket_q` union all select 'paket_r' AS `paket_r`,`paket_r`.`id_paket` AS `id_paket`,`paket_r`.`id_pemohon` AS `id_pemohon`,`paket_r`.`nama` AS `nama`,`paket_r`.`nik` AS `nik`,`paket_r`.`no_kk` AS `no_kk`,`paket_r`.`no_registrasi_pemohon` AS `no_registrasi_pemohon`,`paket_r`.`nama_pemohon` AS `nama_pemohon`,`paket_r`.`no_wa_pemohon` AS `no_wa_pemohon`,`paket_r`.`id_desa` AS `id_desa`,`paket_r`.`create_date` AS `create_date`,`paket_r`.`create_time` AS `create_time`,`paket_r`.`username` AS `username`,`paket_r`.`id_dusun` AS `id_dusun`,`paket_r`.`update_time` AS `update_time`,`paket_r`.`alamat` AS `alamat`,`paket_r`.`status` AS `status`,`paket_r`.`status_baca` AS `status_baca`,`paket_r`.`alasan_penolakan` AS `alasan_penolakan` from `paket_r` union all select 'paket_t' AS `paket_t`,`paket_t`.`id_paket` AS `id_paket`,`paket_t`.`id_pemohon` AS `id_pemohon`,`paket_t`.`nama` AS `nama`,`paket_t`.`nik` AS `nik`,`paket_t`.`no_kk` AS `no_kk`,`paket_t`.`no_registrasi_pemohon` AS `no_registrasi_pemohon`,`paket_t`.`nama_pemohon` AS `nama_pemohon`,`paket_t`.`no_wa_pemohon` AS `no_wa_pemohon`,`paket_t`.`id_desa` AS `id_desa`,`paket_t`.`create_date` AS `create_date`,`paket_t`.`create_time` AS `create_time`,`paket_t`.`username` AS `username`,`paket_t`.`id_dusun` AS `id_dusun`,`paket_t`.`update_time` AS `update_time`,`paket_t`.`alamat` AS `alamat`,`paket_t`.`status` AS `status`,`paket_t`.`status_baca` AS `status_baca`,`paket_t`.`alasan_penolakan` AS `alasan_penolakan` from `paket_t` union all select 'paket_o' AS `paket_o`,`paket_o`.`id_paket` AS `id_paket`,`paket_o`.`id_pemohon` AS `id_pemohon`,`paket_o`.`nama` AS `nama`,`paket_o`.`nik` AS `nik`,`paket_o`.`no_kk` AS `no_kk`,`paket_o`.`no_registrasi_pemohon` AS `no_registrasi_pemohon`,`paket_o`.`nama_pemohon` AS `nama_pemohon`,`paket_o`.`no_wa_pemohon` AS `no_wa_pemohon`,`paket_o`.`id_desa` AS `id_desa`,`paket_o`.`create_date` AS `create_date`,`paket_o`.`create_time` AS `create_time`,`paket_o`.`username` AS `username`,`paket_o`.`id_dusun` AS `id_dusun`,`paket_o`.`update_time` AS `update_time`,`paket_o`.`alamat` AS `alamat`,`paket_o`.`status` AS `status`,`paket_o`.`status_baca` AS `status_baca`,`paket_o`.`alasan_penolakan` AS `alasan_penolakan` from `paket_o`) `vp` left join `master_permohonan` `mp` on(`mp`.`nama_tabel` = `vp`.`asal_tabel`)) ;

-- --------------------------------------------------------

--
-- Structure for view `view_users_capil`
--
DROP TABLE IF EXISTS `view_users_capil`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_users_capil`  AS SELECT `users_capil`.`id` AS `id`, `users_capil`.`id_session` AS `id_session`, `users_capil`.`id_permohonan` AS `id_permohonan`, `master_permohonan`.`nama_permohonan` AS `nama_permohonan`, `master_permohonan`.`nama_tabel` AS `nama_tabel`, `master_permohonan`.`id_permohonan` AS `master_id_permohonan` FROM (`master_permohonan` join `users_capil` on(`master_permohonan`.`id_permohonan` = `users_capil`.`id_permohonan`)) ;

-- --------------------------------------------------------

--
-- Structure for view `v_users`
--
DROP TABLE IF EXISTS `v_users`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_users`  AS SELECT `users`.`username` AS `username`, `users`.`nama_lengkap` AS `nama_lengkap`, `users`.`email` AS `email`, `users`.`no_telp` AS `no_telp`, `users`.`foto` AS `foto`, `users`.`tanggal_reg` AS `tanggal_reg`, `users`.`id_desa` AS `id_desa`, `users`.`id_dusun` AS `id_dusun`, `users`.`id_session` AS `id_session`, `users`.`permission_publish` AS `permission_publish`, `users`.`blokir` AS `blokir`, `master_dusun`.`nama_dusun` AS `nama_dusun`, `master_dusun`.`username` AS `username_dusun` FROM (`users` join `master_dusun` on(`users`.`id_dusun` = `master_dusun`.`id_dusun`)) WHERE `users`.`id_dusun` <> 0 AND `users`.`id_dusun` = `master_dusun`.`id_dusun` AND `users`.`level` = 'user' AND `users`.`deleted` = 'N' GROUP BY `users`.`username` ORDER BY `users`.`username` ASC ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_bias`
--
ALTER TABLE `admin_bias`
  ADD PRIMARY KEY (`id_admin_bias`);

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `file_tokens`
--
ALTER TABLE `file_tokens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `identitas`
--
ALTER TABLE `identitas`
  ADD PRIMARY KEY (`id_identitas`);

--
-- Indexes for table `im_ibu`
--
ALTER TABLE `im_ibu`
  ADD PRIMARY KEY (`id_ibu`);

--
-- Indexes for table `im_pekerjaan`
--
ALTER TABLE `im_pekerjaan`
  ADD PRIMARY KEY (`id_pekerjaan`);

--
-- Indexes for table `im_reg`
--
ALTER TABLE `im_reg`
  ADD PRIMARY KEY (`id_reg`);

--
-- Indexes for table `kalender`
--
ALTER TABLE `kalender`
  ADD PRIMARY KEY (`id_kalender`);

--
-- Indexes for table `logo`
--
ALTER TABLE `logo`
  ADD PRIMARY KEY (`id_logo`);

--
-- Indexes for table `master_desa`
--
ALTER TABLE `master_desa`
  ADD PRIMARY KEY (`id_desa`),
  ADD UNIQUE KEY `id_desa` (`id_desa`);

--
-- Indexes for table `master_dusun`
--
ALTER TABLE `master_dusun`
  ADD PRIMARY KEY (`id_dusun`) USING BTREE;

--
-- Indexes for table `master_kecamatan`
--
ALTER TABLE `master_kecamatan`
  ADD PRIMARY KEY (`id_kecamatan`),
  ADD UNIQUE KEY `id` (`id_kecamatan`),
  ADD UNIQUE KEY `id_kecamatan` (`id_kecamatan`),
  ADD UNIQUE KEY `id_kecamatan_2` (`id_kecamatan`);

--
-- Indexes for table `master_penyakit`
--
ALTER TABLE `master_penyakit`
  ADD PRIMARY KEY (`id_penyakit`);

--
-- Indexes for table `master_permohonan`
--
ALTER TABLE `master_permohonan`
  ADD PRIMARY KEY (`id_permohonan`) USING BTREE;

--
-- Indexes for table `master_sekolah`
--
ALTER TABLE `master_sekolah`
  ADD PRIMARY KEY (`id_sekolah`);

--
-- Indexes for table `master_syarat`
--
ALTER TABLE `master_syarat`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `master_tt`
--
ALTER TABLE `master_tt`
  ADD PRIMARY KEY (`id_penyakit`);

--
-- Indexes for table `modul`
--
ALTER TABLE `modul`
  ADD PRIMARY KEY (`id_modul`);

--
-- Indexes for table `operator`
--
ALTER TABLE `operator`
  ADD PRIMARY KEY (`id_operator`),
  ADD KEY `lokasi_id_desa` (`id_desa`);

--
-- Indexes for table `paket_a`
--
ALTER TABLE `paket_a`
  ADD PRIMARY KEY (`id_paket`) USING BTREE;

--
-- Indexes for table `paket_b`
--
ALTER TABLE `paket_b`
  ADD PRIMARY KEY (`id_paket`) USING BTREE;

--
-- Indexes for table `paket_c`
--
ALTER TABLE `paket_c`
  ADD PRIMARY KEY (`id_paket`) USING BTREE;

--
-- Indexes for table `paket_d`
--
ALTER TABLE `paket_d`
  ADD PRIMARY KEY (`id_paket`) USING BTREE;

--
-- Indexes for table `paket_e`
--
ALTER TABLE `paket_e`
  ADD PRIMARY KEY (`id_paket`) USING BTREE;

--
-- Indexes for table `paket_f`
--
ALTER TABLE `paket_f`
  ADD PRIMARY KEY (`id_paket`) USING BTREE;

--
-- Indexes for table `paket_g`
--
ALTER TABLE `paket_g`
  ADD PRIMARY KEY (`id_paket`) USING BTREE;

--
-- Indexes for table `paket_h`
--
ALTER TABLE `paket_h`
  ADD PRIMARY KEY (`id_paket`) USING BTREE;

--
-- Indexes for table `paket_i`
--
ALTER TABLE `paket_i`
  ADD PRIMARY KEY (`id_paket`) USING BTREE;

--
-- Indexes for table `paket_j`
--
ALTER TABLE `paket_j`
  ADD PRIMARY KEY (`id_paket`) USING BTREE;

--
-- Indexes for table `paket_k`
--
ALTER TABLE `paket_k`
  ADD PRIMARY KEY (`id_paket`) USING BTREE;

--
-- Indexes for table `paket_l`
--
ALTER TABLE `paket_l`
  ADD PRIMARY KEY (`id_paket`) USING BTREE;

--
-- Indexes for table `paket_m`
--
ALTER TABLE `paket_m`
  ADD PRIMARY KEY (`id_paket`) USING BTREE;

--
-- Indexes for table `paket_n`
--
ALTER TABLE `paket_n`
  ADD PRIMARY KEY (`id_paket`) USING BTREE;

--
-- Indexes for table `paket_o`
--
ALTER TABLE `paket_o`
  ADD PRIMARY KEY (`id_paket`) USING BTREE;

--
-- Indexes for table `paket_p`
--
ALTER TABLE `paket_p`
  ADD PRIMARY KEY (`id_paket`) USING BTREE;

--
-- Indexes for table `paket_q`
--
ALTER TABLE `paket_q`
  ADD PRIMARY KEY (`id_paket`) USING BTREE;

--
-- Indexes for table `paket_r`
--
ALTER TABLE `paket_r`
  ADD PRIMARY KEY (`id_paket`) USING BTREE;

--
-- Indexes for table `paket_s`
--
ALTER TABLE `paket_s`
  ADD PRIMARY KEY (`id_paket`) USING BTREE;

--
-- Indexes for table `paket_t`
--
ALTER TABLE `paket_t`
  ADD PRIMARY KEY (`id_paket`) USING BTREE;

--
-- Indexes for table `templates`
--
ALTER TABLE `templates`
  ADD PRIMARY KEY (`id_templates`);

--
-- Indexes for table `tiger_desa`
--
ALTER TABLE `tiger_desa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_kecamatan` (`id_kecamatan`);

--
-- Indexes for table `tiger_desax`
--
ALTER TABLE `tiger_desax`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_kecamatan` (`id_kecamatan`);

--
-- Indexes for table `tiger_kecamatan`
--
ALTER TABLE `tiger_kecamatan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_kotaidx` (`id_kota`);

--
-- Indexes for table `tiger_kota`
--
ALTER TABLE `tiger_kota`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kota` (`kota`,`id_provinsi`),
  ADD KEY `idx_id_provinsi` (`id_provinsi`);

--
-- Indexes for table `tiger_provinsi`
--
ALTER TABLE `tiger_provinsi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `prov` (`provinsi`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`) USING BTREE;

--
-- Indexes for table `users_capil`
--
ALTER TABLE `users_capil`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `users_modul`
--
ALTER TABLE `users_modul`
  ADD PRIMARY KEY (`id_umod`);

--
-- Indexes for table `w_dua`
--
ALTER TABLE `w_dua`
  ADD PRIMARY KEY (`id_w_dua`);

--
-- Indexes for table `w_dua_isi`
--
ALTER TABLE `w_dua_isi`
  ADD PRIMARY KEY (`id_w_dua_isi`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `file_tokens`
--
ALTER TABLE `file_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `identitas`
--
ALTER TABLE `identitas`
  MODIFY `id_identitas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `im_ibu`
--
ALTER TABLE `im_ibu`
  MODIFY `id_ibu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=147;

--
-- AUTO_INCREMENT for table `im_pekerjaan`
--
ALTER TABLE `im_pekerjaan`
  MODIFY `id_pekerjaan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131161;

--
-- AUTO_INCREMENT for table `kalender`
--
ALTER TABLE `kalender`
  MODIFY `id_kalender` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `logo`
--
ALTER TABLE `logo`
  MODIFY `id_logo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `master_dusun`
--
ALTER TABLE `master_dusun`
  MODIFY `id_dusun` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `master_penyakit`
--
ALTER TABLE `master_penyakit`
  MODIFY `id_penyakit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=156;

--
-- AUTO_INCREMENT for table `master_permohonan`
--
ALTER TABLE `master_permohonan`
  MODIFY `id_permohonan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `master_sekolah`
--
ALTER TABLE `master_sekolah`
  MODIFY `id_sekolah` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=148;

--
-- AUTO_INCREMENT for table `master_syarat`
--
ALTER TABLE `master_syarat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- AUTO_INCREMENT for table `master_tt`
--
ALTER TABLE `master_tt`
  MODIFY `id_penyakit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=155;

--
-- AUTO_INCREMENT for table `modul`
--
ALTER TABLE `modul`
  MODIFY `id_modul` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=149;

--
-- AUTO_INCREMENT for table `operator`
--
ALTER TABLE `operator`
  MODIFY `id_operator` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5385;

--
-- AUTO_INCREMENT for table `templates`
--
ALTER TABLE `templates`
  MODIFY `id_templates` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `users_capil`
--
ALTER TABLE `users_capil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `users_modul`
--
ALTER TABLE `users_modul`
  MODIFY `id_umod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=227;

--
-- AUTO_INCREMENT for table `w_dua_isi`
--
ALTER TABLE `w_dua_isi`
  MODIFY `id_w_dua_isi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=359;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
