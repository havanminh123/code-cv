-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 16, 2025 lúc 05:51 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `quanly_nhansu`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `adjusted_times`
--

CREATE TABLE `adjusted_times` (
  `id` int(11) NOT NULL,
  `check_in_time` time NOT NULL,
  `check_out_time` time NOT NULL,
  `adjusted_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `adjusted_times`
--

INSERT INTO `adjusted_times` (`id`, `check_in_time`, `check_out_time`, `adjusted_time`, `last_modified`) VALUES
(19, '03:30:00', '02:10:00', '2025-04-13 20:02:52', '2025-04-13 20:02:52'),
(38, '08:16:00', '17:00:00', '2025-04-14 01:11:15', '2025-04-14 01:11:15'),
(39, '08:11:00', '17:00:00', '2025-04-14 01:14:15', '2025-04-14 01:14:15'),
(40, '08:16:00', '17:00:00', '2025-04-14 01:15:31', '2025-04-14 01:15:31'),
(41, '08:16:00', '08:19:00', '2025-04-14 01:20:54', '2025-04-14 01:20:54'),
(42, '01:00:00', '08:19:00', '2025-04-14 01:24:18', '2025-04-14 01:24:18'),
(43, '09:00:00', '05:30:00', '2025-04-14 01:25:10', '2025-04-14 01:25:10');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `timestamp` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `attendance_history`
--

CREATE TABLE `attendance_history` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `work_date` date NOT NULL,
  `check_in` time DEFAULT NULL,
  `check_out` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `attendance_history`
--

INSERT INTO `attendance_history` (`id`, `employee_id`, `work_date`, `check_in`, `check_out`) VALUES
(1, 26, '2025-04-13', '22:11:40', '22:12:07');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `attendance_logs`
--

CREATE TABLE `attendance_logs` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `check_in` datetime NOT NULL,
  `check_out` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bang_cap`
--

CREATE TABLE `bang_cap` (
  `id` int(11) NOT NULL,
  `ma_bang_cap` varchar(50) NOT NULL,
  `ten_bang_cap` varchar(255) NOT NULL,
  `ghi_chu` varchar(255) NOT NULL,
  `nguoi_tao` varchar(50) NOT NULL,
  `ngay_tao` datetime NOT NULL,
  `nguoi_sua` varchar(50) NOT NULL,
  `ngay_sua` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `bang_cap`
--

INSERT INTO `bang_cap` (`id`, `ma_bang_cap`, `ten_bang_cap`, `ghi_chu`, `nguoi_tao`, `ngay_tao`, `nguoi_sua`, `ngay_sua`) VALUES
(22, 'MBC1740716765', 'Chứng Chỉ Nghề', '', 'Hà Minh', '2025-02-28 11:26:05', 'Hà Minh', '2025-02-28 11:26:05'),
(23, 'MBC1740716771', 'Bằng Tiến Sĩ (PhD)', '', 'Hà Minh', '2025-02-28 11:26:11', 'Hà Minh', '2025-02-28 11:26:11'),
(24, 'MBC1740716776', 'Bằng Thạc Sĩ', '', 'Hà Minh', '2025-02-28 11:26:16', 'Hà Minh', '2025-02-28 11:26:16'),
(25, 'MBC1740716786', 'Bằng Cử Nhân (Đại học)', '', 'Hà Minh', '2025-02-28 11:26:26', 'Hà Minh', '2025-02-28 11:26:26'),
(26, 'MBC1740716792', 'Bằng Cao Đẳng', '', 'Hà Minh', '2025-02-28 11:26:32', 'Hà Minh', '2025-02-28 11:26:32');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chan_cong`
--

CREATE TABLE `chan_cong` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `check_in` datetime DEFAULT NULL,
  `check_out` datetime DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `hours_worked` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `chan_cong`
--

INSERT INTO `chan_cong` (`id`, `employee_id`, `check_in`, `check_out`, `status`, `hours_worked`) VALUES
(107, 26, '2025-04-14 09:25:19', NULL, NULL, 0),
(108, 30, '2025-04-14 09:26:09', NULL, NULL, 0),
(109, 32, '2025-04-14 09:37:49', NULL, NULL, 0),
(110, 29, '2025-04-16 10:47:09', '2025-04-16 10:47:11', NULL, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chinh_luong`
--

CREATE TABLE `chinh_luong` (
  `id` int(11) NOT NULL,
  `nhanvien_id` int(11) NOT NULL,
  `so_qd` varchar(50) NOT NULL,
  `ngay_ky_ket` datetime NOT NULL,
  `ngay_dieu_chinh` datetime NOT NULL,
  `heso_luong_cu` double NOT NULL,
  `heso_luong_moi` double NOT NULL,
  `nguoi_tao_id` int(11) NOT NULL,
  `ngay_tao` datetime NOT NULL,
  `nguoi_sua_id` int(11) NOT NULL,
  `ngay_sua` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chi_tiet_nhom`
--

CREATE TABLE `chi_tiet_nhom` (
  `id` int(11) NOT NULL,
  `ma_nhom` varchar(50) NOT NULL,
  `nhan_vien_id` int(11) NOT NULL,
  `nguoi_tao` varchar(50) NOT NULL,
  `ngay_tao` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chuc_vu`
--

CREATE TABLE `chuc_vu` (
  `id` int(11) NOT NULL,
  `ma_chuc_vu` varchar(50) NOT NULL,
  `ten_chuc_vu` varchar(255) NOT NULL,
  `luong_ngay` double NOT NULL,
  `ghi_chu` varchar(255) NOT NULL,
  `nguoi_tao` varchar(50) NOT NULL,
  `ngay_tao` datetime NOT NULL,
  `nguoi_sua` varchar(50) NOT NULL,
  `ngay_sua` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `chuc_vu`
--

INSERT INTO `chuc_vu` (`id`, `ma_chuc_vu`, `ten_chuc_vu`, `luong_ngay`, `ghi_chu`, `nguoi_tao`, `ngay_tao`, `nguoi_sua`, `ngay_sua`) VALUES
(42, 'MCV1740716482', 'Giám đốc Công Nghệ Thông Tin ', 500000, '', 'Hà Minh', '2025-02-28 11:21:22', 'MINH HÀ', '2025-03-02 16:07:21'),
(43, 'MCV1740716494', 'Giám đốc Kinh Doanh', 400000, '', 'Hà Minh', '2025-02-28 11:21:34', 'MINH HÀ', '2025-03-02 16:04:12'),
(44, 'MCV1740716503', 'Giám đốc Marketing', 400000, '', 'Hà Minh', '2025-02-28 11:21:43', 'Hà Minh', '2025-02-28 11:21:43'),
(45, 'MCV1740716514', 'Kế toán trưởng', 400000, '', 'Hà Minh', '2025-02-28 11:21:54', 'Hà Minh', '2025-02-28 11:21:54'),
(46, 'MCV1740716525', 'Giám đốc nhân sự', 400000, '', 'Hà Minh', '2025-02-28 11:22:05', 'Hà Minh', '2025-02-28 11:22:05');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chuyen_mon`
--

CREATE TABLE `chuyen_mon` (
  `id` int(11) NOT NULL,
  `ma_chuyen_mon` varchar(50) NOT NULL,
  `ten_chuyen_mon` varchar(255) NOT NULL,
  `ghi_chu` varchar(255) NOT NULL,
  `nguoi_tao` varchar(50) NOT NULL,
  `ngay_tao` datetime NOT NULL,
  `nguoi_sua` varchar(50) NOT NULL,
  `ngay_sua` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `chuyen_mon`
--

INSERT INTO `chuyen_mon` (`id`, `ma_chuyen_mon`, `ten_chuyen_mon`, `ghi_chu`, `nguoi_tao`, `ngay_tao`, `nguoi_sua`, `ngay_sua`) VALUES
(23, 'MCM1740716660', 'Chuyên môn Kỹ thuật:', '', 'Hà Minh', '2025-02-28 11:24:20', 'Hà Minh', '2025-02-28 11:24:20'),
(24, 'MCM1740716666', 'Chuyên môn Quản trị nhân sự:', '', 'Hà Minh', '2025-02-28 11:24:26', 'Hà Minh', '2025-02-28 11:24:26'),
(25, 'MCM1740716673', 'Chuyên môn Marketing:', '', 'Hà Minh', '2025-02-28 11:24:33', 'Hà Minh', '2025-02-28 11:24:33'),
(26, 'MCM1740716680', 'Chuyên môn Công nghệ thông tin', '', 'Hà Minh', '2025-02-28 11:24:40', 'Hà Minh', '2025-02-28 11:24:40'),
(27, 'MCM1740716692', 'Chuyên môn Kế toán:', '', 'Hà Minh', '2025-02-28 11:24:52', 'Hà Minh', '2025-02-28 11:24:52');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cong_tac`
--

CREATE TABLE `cong_tac` (
  `id` int(11) NOT NULL,
  `ma_cong_tac` varchar(255) NOT NULL,
  `nhanvien_id` int(11) NOT NULL,
  `ngay_bat_dau` date NOT NULL,
  `ngay_ket_thuc` date NOT NULL,
  `dia_diem` varchar(255) NOT NULL,
  `muc_dich` varchar(500) NOT NULL,
  `ghi_chu` varchar(500) NOT NULL,
  `nguoi_tao` varchar(255) NOT NULL,
  `ngay_tao` datetime NOT NULL,
  `nguoi_sua` varchar(255) NOT NULL,
  `ngay_sua` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `daily_working_hours`
--

CREATE TABLE `daily_working_hours` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `work_date` date NOT NULL,
  `total_hours` time NOT NULL,
  `hours_worked` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `daily_working_hours`
--

INSERT INTO `daily_working_hours` (`id`, `employee_id`, `work_date`, `total_hours`, `hours_worked`) VALUES
(6, 26, '2025-04-13', '00:00:27', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dan_toc`
--

CREATE TABLE `dan_toc` (
  `id` int(11) NOT NULL,
  `ten_dan_toc` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `dan_toc`
--

INSERT INTO `dan_toc` (`id`, `ten_dan_toc`) VALUES
(1, 'Kinh'),
(2, 'Khơ-me'),
(3, 'Mường'),
(4, 'Thổ'),
(5, 'H\'Mông'),
(6, 'Ê-đê'),
(7, 'Bố Y'),
(8, 'Lào'),
(9, 'Tày'),
(10, 'Thái'),
(11, 'Nùng'),
(12, 'Khơ-mú'),
(13, 'M\'Nông'),
(14, 'Xơ Đăng'),
(15, 'Chăm'),
(16, 'Gia Rai'),
(17, 'Hoa'),
(18, 'Lô Lô'),
(19, 'Phù Lá');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `file_name` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `images`
--

INSERT INTO `images` (`id`, `employee_id`, `file_name`) VALUES
(161, 30, 'uploads/images/z6391097974055_702c86ad031b6c65de96374212bf3931.jpg'),
(162, 29, 'uploads/images/z6374788420027_808ddb2bb0d526d29cd01cdab4ded9cf.jpg'),
(163, 26, 'uploads/images/z6374790270523_de532f5e358d709a60acc7d0d0712b46 - Sao chép.jpg'),
(166, 26, 'uploads/images/z6398624095236_2b312ca9bc17ae8069c234649972b934.jpg'),
(167, 26, 'uploads/images/z6398624118666_f88aba2a82b81145830cf667489e12b7.jpg'),
(168, 26, 'uploads/images/z6398624165198_6ce2127fd536790633eea0c7dc5010e9.jpg'),
(169, 26, 'uploads/images/z6398624197631_5c9d616b6b76e705c7b7b0678c931f8c.jpg'),
(170, 26, 'uploads/images/z6374790277649_b6bfb6641d28df5e0a0053e658fa64ae.jpg'),
(171, 26, 'uploads/images/z6374790307027_abd731e6fc8b9dea8619f6b6fd4bd591.jpg'),
(172, 26, 'uploads/images/z6374790309699_e7c7c8da6c183c1855549813034cb84b.jpg'),
(173, 26, 'uploads/images/z6374790358951_9766e250c091217d5114149422156c32.jpg'),
(174, 26, 'uploads/images/z6374790360514_5608a4dbce3705491e426968fe1887dd.jpg'),
(175, 26, 'uploads/images/z6374790365520_d2ec1408a178bebfeee6a65ad9d3a262.jpg'),
(177, 30, 'uploads/images/z6391097929967_a2ec42003870e31225f3931d6c6fa425.jpg'),
(178, 30, 'uploads/images/z6391097941168_db4f3d089e18d1e5fe1977b72e3875d7.jpg'),
(179, 30, 'uploads/images/z6391097951026_8968e9a05b01b57c9a608e69da087e5c.jpg'),
(180, 30, 'uploads/images/z6391097974055_702c86ad031b6c65de96374212bf3931.jpg'),
(181, 30, 'uploads/images/z6391098001344_ce476ba530e1fdcbf58c286b4e88a86b.jpg'),
(182, 29, 'uploads/images/z6374788420027_808ddb2bb0d526d29cd01cdab4ded9cf.jpg'),
(183, 29, 'uploads/images/z6374788427417_47c2f202ef3a9c6734dd27db2711c203.jpg'),
(192, 29, 'uploads/images/z6374788427417_47c2f202ef3a9c6734dd27db2711c203.jpg'),
(193, 29, 'uploads/images/z6374788420027_808ddb2bb0d526d29cd01cdab4ded9cf.jpg'),
(194, 29, 'uploads/images/z6374788427417_47c2f202ef3a9c6734dd27db2711c203.jpg'),
(195, 26, 'uploads/images/z6374790277649_b6bfb6641d28df5e0a0053e658fa64ae.jpg'),
(196, 26, 'uploads/images/z6374790307027_abd731e6fc8b9dea8619f6b6fd4bd591.jpg'),
(197, 26, 'uploads/images/z6374790309699_e7c7c8da6c183c1855549813034cb84b.jpg'),
(198, 26, 'uploads/images/z6374790313191_69a1ff371310c4d1d63ebe0d1de74218.jpg'),
(199, 26, 'uploads/images/z6374790329847_efa613f2a1ae396abad9b2f13765880f.jpg'),
(200, 26, 'uploads/images/z6398624095236_2b312ca9bc17ae8069c234649972b934.jpg'),
(201, 26, 'uploads/images/z6398624118666_f88aba2a82b81145830cf667489e12b7.jpg'),
(202, 26, 'uploads/images/z6398624165198_6ce2127fd536790633eea0c7dc5010e9.jpg'),
(203, 26, 'uploads/images/z6398624197631_5c9d616b6b76e705c7b7b0678c931f8c.jpg'),
(204, 30, 'uploads/images/z6391097929967_a2ec42003870e31225f3931d6c6fa425.jpg'),
(205, 30, 'uploads/images/z6391097941168_db4f3d089e18d1e5fe1977b72e3875d7.jpg'),
(206, 30, 'uploads/images/z6391097951026_8968e9a05b01b57c9a608e69da087e5c.jpg'),
(207, 30, 'uploads/images/z6391097974055_702c86ad031b6c65de96374212bf3931.jpg'),
(208, 30, 'uploads/images/z6391098001344_ce476ba530e1fdcbf58c286b4e88a86b.jpg'),
(209, 29, 'uploads/images/z6374788420027_808ddb2bb0d526d29cd01cdab4ded9cf.jpg'),
(210, 29, 'uploads/images/z6374788427417_47c2f202ef3a9c6734dd27db2711c203.jpg'),
(211, 29, 'uploads/images/z6374789927048_a7c55c785c9f0a79c7574e71f4275964.jpg'),
(217, 32, 'uploads/images/z6502820509311_e78ac5e81d4cb76b822ad21957063130 - Copy.jpg'),
(218, 32, 'uploads/images/z6502820390869_4f9eccc343abc6dd2faca305cfe81581 - Copy.jpg'),
(219, 32, 'uploads/images/z6502820405207_c04d36b8c2fbcdeacd40428e384ad0ec - Copy.jpg'),
(220, 32, 'uploads/images/z6502820415161_363e089bf4112e26dad4c44b55e58199 - Copy.jpg'),
(221, 32, 'uploads/images/z6502820466559_6ec45be07830d98cb7c1a4b1c1c77995 - Copy.jpg'),
(222, 32, 'uploads/images/z6502820466559_6ec45be07830d98cb7c1a4b1c1c77995 - Copy.jpg'),
(223, 32, 'uploads/images/z6502820466559_6ec45be07830d98cb7c1a4b1c1c77995.jpg'),
(224, 32, 'uploads/images/z6502820509311_e78ac5e81d4cb76b822ad21957063130 - Copy.jpg'),
(225, 32, 'uploads/images/z6502820509311_e78ac5e81d4cb76b822ad21957063130.jpg'),
(226, 32, 'uploads/images/z6502820526467_3db2c7b3d4a093e0915ed8924b6d5c61.jpg');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khen_thuong_ky_luat`
--

CREATE TABLE `khen_thuong_ky_luat` (
  `id` int(11) NOT NULL,
  `ma_kt` varchar(50) NOT NULL,
  `so_qd` varchar(50) NOT NULL,
  `ngay_qd` date NOT NULL,
  `nhanvien_id` int(11) NOT NULL,
  `ten_khen_thuong` varchar(255) NOT NULL,
  `loai_kt_id` int(11) NOT NULL,
  `hinh_thuc` tinyint(1) NOT NULL,
  `so_tien` double NOT NULL,
  `flag` tinyint(1) NOT NULL,
  `ghi_chu` varchar(500) NOT NULL,
  `nguoi_tao` varchar(50) NOT NULL,
  `ngay_tao` datetime NOT NULL,
  `nguoi_sua` varchar(50) NOT NULL,
  `ngay_sua` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `loai_khen_thuong_ky_luat`
--

CREATE TABLE `loai_khen_thuong_ky_luat` (
  `id` int(11) NOT NULL,
  `ma_loai` varchar(50) NOT NULL,
  `ten_loai` varchar(255) NOT NULL,
  `ghi_chu` varchar(255) NOT NULL,
  `flag` tinyint(1) NOT NULL,
  `nguoi_tao` varchar(50) NOT NULL,
  `ngay_tao` datetime NOT NULL,
  `nguoi_sua` varchar(50) NOT NULL,
  `ngay_sua` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `loai_nv`
--

CREATE TABLE `loai_nv` (
  `id` int(11) NOT NULL,
  `ma_loai_nv` varchar(50) NOT NULL,
  `ten_loai_nv` varchar(50) NOT NULL,
  `ghi_chu` varchar(255) NOT NULL,
  `nguoi_tao` varchar(50) NOT NULL,
  `ngay_tao` datetime NOT NULL,
  `nguoi_sua` varchar(50) NOT NULL,
  `ngay_sua` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `loai_nv`
--

INSERT INTO `loai_nv` (`id`, `ma_loai_nv`, `ten_loai_nv`, `ghi_chu`, `nguoi_tao`, `ngay_tao`, `nguoi_sua`, `ngay_sua`) VALUES
(8, 'LNV1740666971', 'ưu tú', '', 'Hà Minh', '2025-02-27 21:36:11', 'Hà Minh', '2025-02-27 21:36:11'),
(9, 'LNV1740716846', 'Nhân viên chính thức', '', 'Hà Minh', '2025-02-28 11:27:26', 'Hà Minh', '2025-02-28 11:27:26'),
(10, 'LNV1740716851', 'Nhân viên hợp đồng', '', 'Hà Minh', '2025-02-28 11:27:31', 'Hà Minh', '2025-02-28 11:27:31'),
(11, 'LNV1740716856', 'Nhân viên bán thời gian', '', 'Hà Minh', '2025-02-28 11:27:36', 'Hà Minh', '2025-02-28 11:27:36'),
(12, 'LNV1740716862', 'Nhân viên tạm thời', '', 'Hà Minh', '2025-02-28 11:27:42', 'Hà Minh', '2025-02-28 11:27:42'),
(13, 'LNV1740716869', 'Nhân viên thực tập', '', 'Hà Minh', '2025-02-28 11:27:49', 'Hà Minh', '2025-02-28 11:27:49');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `luong`
--

CREATE TABLE `luong` (
  `ma_luong` varchar(50) NOT NULL,
  `nhanvien_id` int(11) NOT NULL,
  `luong_thang` decimal(15,2) NOT NULL,
  `ngay_cong` int(11) NOT NULL,
  `thuc_lanh` decimal(15,2) NOT NULL,
  `ngay_cham` datetime NOT NULL,
  `nguoi_tao_id` int(11) NOT NULL,
  `ngay_tao` datetime NOT NULL,
  `tam_ung` decimal(10,2) DEFAULT 0.00,
  `phu_cap` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhanvien`
--

CREATE TABLE `nhanvien` (
  `id` int(11) NOT NULL,
  `ma_nv` varchar(50) NOT NULL,
  `hinh_anh` varchar(255) NOT NULL,
  `ten_nv` varchar(255) NOT NULL,
  `biet_danh` varchar(255) NOT NULL,
  `gioi_tinh` tinyint(1) NOT NULL,
  `ngay_sinh` date NOT NULL,
  `noi_sinh` varchar(255) NOT NULL,
  `hon_nhan_id` int(11) NOT NULL,
  `so_cmnd` varchar(50) NOT NULL,
  `noi_cap_cmnd` varchar(255) NOT NULL,
  `ngay_cap_cmnd` date NOT NULL,
  `nguyen_quan` varchar(255) NOT NULL,
  `quoc_tich_id` int(11) NOT NULL,
  `ton_giao_id` int(11) NOT NULL,
  `dan_toc_id` int(11) NOT NULL,
  `ho_khau` varchar(255) NOT NULL,
  `tam_tru` varchar(255) NOT NULL,
  `loai_nv_id` int(11) NOT NULL,
  `trinh_do_id` int(11) NOT NULL,
  `chuyen_mon_id` int(11) NOT NULL,
  `bang_cap_id` int(11) NOT NULL,
  `phong_ban_id` int(11) NOT NULL,
  `chuc_vu_id` int(11) NOT NULL,
  `trang_thai` tinyint(1) NOT NULL,
  `nguoi_tao_id` int(11) NOT NULL,
  `ngay_tao` datetime NOT NULL,
  `nguoi_sua_id` int(11) NOT NULL,
  `ngay_sua` datetime NOT NULL,
  `face_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `nhanvien`
--

INSERT INTO `nhanvien` (`id`, `ma_nv`, `hinh_anh`, `ten_nv`, `biet_danh`, `gioi_tinh`, `ngay_sinh`, `noi_sinh`, `hon_nhan_id`, `so_cmnd`, `noi_cap_cmnd`, `ngay_cap_cmnd`, `nguyen_quan`, `quoc_tich_id`, `ton_giao_id`, `dan_toc_id`, `ho_khau`, `tam_tru`, `loai_nv_id`, `trinh_do_id`, `chuyen_mon_id`, `bang_cap_id`, `phong_ban_id`, `chuc_vu_id`, `trang_thai`, `nguoi_tao_id`, `ngay_tao`, `nguoi_sua_id`, `ngay_sua`, `face_id`) VALUES
(22, 'MNV1740967208', '1742171681.jpg', 'Nguyễn Minh Thông', '', 1, '2025-03-03', 'thanh hóa', 1, '098765432345', 'thanh hóa', '2025-03-03', 'thanh hóa', 24, 1, 1, 'thanh hóa', 'hà nội', 9, 25, 26, 23, 30, 42, 1, 1, '2025-03-03 09:00:08', 1, '2025-03-20 08:41:00', NULL),
(26, 'MNV1741541925', '1742100079.jpg', 'Hà Văn Minh', '', 1, '2025-03-10', 'thanh hoas', 1, '098765432345', 'thanh hóa', '2025-03-10', 'thanh hoa', 17, 1, 19, 'minh ha', 'thanh hoa', 12, 26, 24, 25, 30, 45, 1, 1, '2025-03-10 00:38:45', 1, '2025-03-20 08:40:03', NULL),
(29, 'MNV1741565970', '1742171660.jpg', 'hoang phúc lâm', '', 1, '2025-03-10', 'thanh hóa', 1, '0123546744', 'nam định', '2025-03-10', 'thanh hóa', 17, 1, 19, 'thanh hóa', 'thanh hóa', 11, 23, 24, 22, 30, 42, 1, 1, '2025-03-10 07:19:30', 1, '2025-03-20 08:40:35', NULL),
(30, 'MNV1741567308', '1742171607.jpg', 'Nguyên đức lộc', '', 1, '2025-03-10', 'thanh hóa', 1, '098765432345', 'thanh hóa', '2025-03-10', 'thanh hóa', 17, 2, 17, 'thanh hóa', 'thanh hóa', 12, 26, 24, 23, 30, 45, 1, 1, '2025-03-10 07:41:48', 1, '2025-03-20 08:40:18', NULL),
(32, 'MNV1744597869', '1744597869.jpg', 'linh', 'nguyễn', 1, '2025-04-14', 'nam định', 2, '098765432345', 'thanh hóa', '2025-04-14', 'nam định', 12, 0, 17, 'nam định', 'nam định', 8, 26, 24, 24, 30, 42, 1, 1, '2025-04-14 09:31:09', 1, '2025-04-14 09:32:58', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhom`
--

CREATE TABLE `nhom` (
  `id` int(11) NOT NULL,
  `ma_nhom` varchar(50) NOT NULL,
  `ten_nhom` varchar(255) NOT NULL,
  `mo_ta` varchar(255) NOT NULL,
  `nguoi_tao` varchar(255) NOT NULL,
  `ngay_tao` datetime NOT NULL,
  `nguoi_sua` varchar(255) NOT NULL,
  `ngay_sua` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `nhom`
--

INSERT INTO `nhom` (`id`, `ma_nhom`, `ten_nhom`, `mo_ta`, `nguoi_tao`, `ngay_tao`, `nguoi_sua`, `ngay_sua`) VALUES
(9, 'GRP1740660302', 'Nhóm công tác', '', 'HàMinh', '2025-02-27 19:45:21', '', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `people`
--

CREATE TABLE `people` (
  `ID` int(11) NOT NULL,
  `MaNV` varchar(20) NOT NULL,
  `HinhAnh` varchar(255) DEFAULT NULL,
  `TenNV` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `people`
--

INSERT INTO `people` (`ID`, `MaNV`, `HinhAnh`, `TenNV`) VALUES
(22, 'MNV1740967208', 'E:/dataSet/22/22.147.jpg', 'nguyen van minh');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phong_ban`
--

CREATE TABLE `phong_ban` (
  `id` int(11) NOT NULL,
  `ma_phong_ban` varchar(255) NOT NULL,
  `ten_phong_ban` varchar(255) NOT NULL,
  `ghi_chu` varchar(255) NOT NULL,
  `nguoi_tao` varchar(50) NOT NULL,
  `ngay_tao` datetime NOT NULL,
  `nguoi_sua` varchar(50) DEFAULT NULL,
  `ngay_sua` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `phong_ban`
--

INSERT INTO `phong_ban` (`id`, `ma_phong_ban`, `ten_phong_ban`, `ghi_chu`, `nguoi_tao`, `ngay_tao`, `nguoi_sua`, `ngay_sua`) VALUES
(30, 'MBP1740716385', 'Phòng Công Nghệ Thông Tin', '', 'Hà Minh', '2025-02-28 11:19:45', 'Hà Minh', '2025-02-28 11:19:45'),
(31, 'MBP1740716392', 'Phòng Kinh Doanh', '', 'Hà Minh', '2025-02-28 11:19:52', 'Hà Minh', '2025-02-28 11:19:52'),
(32, 'MBP1740716402', 'Phòng Marketing', '', 'Hà Minh', '2025-02-28 11:20:02', 'Hà Minh', '2025-02-28 11:20:02'),
(33, 'MBP1740716409', 'Phòng Tài Chính', '', 'Hà Minh', '2025-02-28 11:20:09', 'Hà Minh', '2025-02-28 11:20:09');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `quoc_tich`
--

CREATE TABLE `quoc_tich` (
  `id` int(11) NOT NULL,
  `ten_quoc_tich` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `quoc_tich`
--

INSERT INTO `quoc_tich` (`id`, `ten_quoc_tich`) VALUES
(1, 'Danish'),
(2, 'Đan Mạch'),
(3, 'British / English'),
(4, 'Anh'),
(5, 'Estonian'),
(6, 'Estonia'),
(7, 'Finnish'),
(8, 'Phần Lan'),
(9, 'Icelandic'),
(10, 'Irish'),
(11, 'Ireland'),
(12, 'Latvian'),
(13, 'Latvia'),
(14, 'Lithuanian'),
(15, 'Norwegian'),
(16, 'Na Uy'),
(17, 'Canada'),
(18, 'Scotland'),
(19, 'Thụy Điển'),
(20, 'Tây Ban Nha'),
(21, 'Séc'),
(22, 'Ba Lan'),
(23, 'Mỹ'),
(24, 'Việt Nam'),
(25, 'Ấn Độ'),
(26, 'Trung Quốc'),
(27, 'Mông Cổ'),
(28, 'Triều Tiên'),
(29, 'Đài Loan'),
(30, 'Campuchia'),
(31, 'Indonesia'),
(32, 'Lào'),
(33, 'Philipin'),
(34, 'Thái Lan');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `check_in_time` time NOT NULL,
  `check_out_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `settings`
--

INSERT INTO `settings` (`id`, `check_in_time`, `check_out_time`) VALUES
(1, '09:00:00', '05:30:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tai_khoan`
--

CREATE TABLE `tai_khoan` (
  `id` int(11) NOT NULL,
  `ho` varchar(50) NOT NULL,
  `ten` varchar(50) NOT NULL,
  `hinh_anh` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `mat_khau` varchar(50) NOT NULL,
  `so_dt` varchar(50) NOT NULL,
  `quyen` tinyint(1) NOT NULL,
  `trang_thai` tinyint(1) NOT NULL,
  `truy_cap` int(11) NOT NULL,
  `ngay_tao` datetime NOT NULL,
  `ngay_sua` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tai_khoan`
--

INSERT INTO `tai_khoan` (`id`, `ho`, `ten`, `hinh_anh`, `email`, `mat_khau`, `so_dt`, `quyen`, `trang_thai`, `truy_cap`, `ngay_tao`, `ngay_sua`) VALUES
(1, 'MINH', 'HÀ', '1742100060.jpg', 'admin@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '099999999999', 1, 1, 89, '2025-02-25 00:00:00', '2025-03-16 11:41:00'),
(15, 'Hà', 'Minh', 'admin.png', 'minhhvbh00494@fpt.edu.vn', '827ccb0eea8a706c4c34a16891f84e7b', '0842318208', 0, 1, 1, '2025-02-28 21:59:00', '2025-02-28 21:59:00'),
(17, 'lâm', 'ha', 'admin.png', 'minhhvbh004944@fpt.edu.vn', 'e10adc3949ba59abbe56e057f20f883e', '0842318208', 0, 1, 1, '2025-03-12 08:05:47', '2025-03-12 08:06:19'),
(18, 'nguyễn ', 'lộc', '1744590255.jpg', 'loc@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '0343814376', 0, 1, 2, '2025-04-14 07:24:15', '2025-04-14 07:24:15');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tinh_trang_hon_nhan`
--

CREATE TABLE `tinh_trang_hon_nhan` (
  `id` int(11) NOT NULL,
  `ten_tinh_trang` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tinh_trang_hon_nhan`
--

INSERT INTO `tinh_trang_hon_nhan` (`id`, `ten_tinh_trang`) VALUES
(1, 'Độc thân'),
(2, 'Đính hôn'),
(3, 'Có gia đình'),
(4, 'Ly thân'),
(5, 'Ly hôn');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ton_giao`
--

CREATE TABLE `ton_giao` (
  `id` int(11) NOT NULL,
  `ten_ton_giao` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `ton_giao`
--

INSERT INTO `ton_giao` (`id`, `ten_ton_giao`) VALUES
(0, 'Không'),
(1, 'Phật giáo'),
(2, 'Thiên chúa giáo'),
(3, 'Đạo tin lành'),
(4, 'Hồi giáo'),
(5, 'Do Thái giáo');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `trinh_do`
--

CREATE TABLE `trinh_do` (
  `id` int(11) NOT NULL,
  `ma_trinh_do` varchar(50) NOT NULL,
  `ten_trinh_do` varchar(255) NOT NULL,
  `ghi_chu` varchar(255) NOT NULL,
  `nguoi_tao` varchar(50) NOT NULL,
  `ngay_tao` datetime NOT NULL,
  `nguoi_sua` varchar(50) NOT NULL,
  `ngay_sua` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `trinh_do`
--

INSERT INTO `trinh_do` (`id`, `ma_trinh_do`, `ten_trinh_do`, `ghi_chu`, `nguoi_tao`, `ngay_tao`, `nguoi_sua`, `ngay_sua`) VALUES
(23, 'MTD1740716583', 'Trình độ Tiến Sĩ:', '', 'Hà Minh', '2025-02-28 11:23:03', 'Hà Minh', '2025-02-28 11:23:03'),
(24, 'MTD1740716589', 'Trình độ Thạc Sĩ:', '', 'Hà Minh', '2025-02-28 11:23:09', 'Hà Minh', '2025-02-28 11:23:09'),
(25, 'MTD1740716595', 'Trình độ Đại Học:', '', 'Hà Minh', '2025-02-28 11:23:15', 'Hà Minh', '2025-02-28 11:23:15'),
(26, 'MTD1740716602', 'Trình độ Cao Đẳng:', '', 'Hà Minh', '2025-02-28 11:23:22', 'Hà Minh', '2025-02-28 11:23:22'),
(27, 'MTD1740716608', 'Trình độ Trung Cấp:', '', 'Hà Minh', '2025-02-28 11:23:28', 'Hà Minh', '2025-02-28 11:23:28');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `adjusted_times`
--
ALTER TABLE `adjusted_times`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Chỉ mục cho bảng `attendance_history`
--
ALTER TABLE `attendance_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Chỉ mục cho bảng `attendance_logs`
--
ALTER TABLE `attendance_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Chỉ mục cho bảng `bang_cap`
--
ALTER TABLE `bang_cap`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `chan_cong`
--
ALTER TABLE `chan_cong`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `chinh_luong`
--
ALTER TABLE `chinh_luong`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nhanvien_id` (`nhanvien_id`);

--
-- Chỉ mục cho bảng `chi_tiet_nhom`
--
ALTER TABLE `chi_tiet_nhom`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `chuc_vu`
--
ALTER TABLE `chuc_vu`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `chuyen_mon`
--
ALTER TABLE `chuyen_mon`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `cong_tac`
--
ALTER TABLE `cong_tac`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nhanvien_id` (`nhanvien_id`);

--
-- Chỉ mục cho bảng `daily_working_hours`
--
ALTER TABLE `daily_working_hours`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Chỉ mục cho bảng `dan_toc`
--
ALTER TABLE `dan_toc`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Chỉ mục cho bảng `khen_thuong_ky_luat`
--
ALTER TABLE `khen_thuong_ky_luat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `loai_kt_id` (`loai_kt_id`),
  ADD KEY `nhanvien_id` (`nhanvien_id`);

--
-- Chỉ mục cho bảng `loai_khen_thuong_ky_luat`
--
ALTER TABLE `loai_khen_thuong_ky_luat`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `loai_nv`
--
ALTER TABLE `loai_nv`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `luong`
--
ALTER TABLE `luong`
  ADD PRIMARY KEY (`ma_luong`),
  ADD KEY `nhanvien_id` (`nhanvien_id`);

--
-- Chỉ mục cho bảng `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `face_id` (`face_id`),
  ADD KEY `quoc_tich_id` (`quoc_tich_id`),
  ADD KEY `ton_giao_id` (`ton_giao_id`),
  ADD KEY `dan_toc_id` (`dan_toc_id`),
  ADD KEY `loai_nv_id` (`loai_nv_id`),
  ADD KEY `chuyen_mon_id` (`chuyen_mon_id`),
  ADD KEY `trinh_do_id` (`trinh_do_id`),
  ADD KEY `bang_cap_id` (`bang_cap_id`),
  ADD KEY `phong_ban_id` (`phong_ban_id`),
  ADD KEY `chuc_vu_id` (`chuc_vu_id`),
  ADD KEY `nguoi_tao_id` (`nguoi_tao_id`),
  ADD KEY `nguoi_sua_id` (`nguoi_sua_id`),
  ADD KEY `ma_nv` (`ma_nv`);

--
-- Chỉ mục cho bảng `nhom`
--
ALTER TABLE `nhom`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `people`
--
ALTER TABLE `people`
  ADD PRIMARY KEY (`ID`);

--
-- Chỉ mục cho bảng `phong_ban`
--
ALTER TABLE `phong_ban`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `quoc_tich`
--
ALTER TABLE `quoc_tich`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `tai_khoan`
--
ALTER TABLE `tai_khoan`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `tinh_trang_hon_nhan`
--
ALTER TABLE `tinh_trang_hon_nhan`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `ton_giao`
--
ALTER TABLE `ton_giao`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `trinh_do`
--
ALTER TABLE `trinh_do`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `adjusted_times`
--
ALTER TABLE `adjusted_times`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT cho bảng `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `attendance_history`
--
ALTER TABLE `attendance_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `attendance_logs`
--
ALTER TABLE `attendance_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `bang_cap`
--
ALTER TABLE `bang_cap`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT cho bảng `chan_cong`
--
ALTER TABLE `chan_cong`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT cho bảng `chinh_luong`
--
ALTER TABLE `chinh_luong`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `chi_tiet_nhom`
--
ALTER TABLE `chi_tiet_nhom`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT cho bảng `chuc_vu`
--
ALTER TABLE `chuc_vu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT cho bảng `chuyen_mon`
--
ALTER TABLE `chuyen_mon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT cho bảng `cong_tac`
--
ALTER TABLE `cong_tac`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `daily_working_hours`
--
ALTER TABLE `daily_working_hours`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `dan_toc`
--
ALTER TABLE `dan_toc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT cho bảng `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=227;

--
-- AUTO_INCREMENT cho bảng `khen_thuong_ky_luat`
--
ALTER TABLE `khen_thuong_ky_luat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `loai_khen_thuong_ky_luat`
--
ALTER TABLE `loai_khen_thuong_ky_luat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT cho bảng `loai_nv`
--
ALTER TABLE `loai_nv`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `nhanvien`
--
ALTER TABLE `nhanvien`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT cho bảng `nhom`
--
ALTER TABLE `nhom`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `phong_ban`
--
ALTER TABLE `phong_ban`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT cho bảng `quoc_tich`
--
ALTER TABLE `quoc_tich`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT cho bảng `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `tai_khoan`
--
ALTER TABLE `tai_khoan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `tinh_trang_hon_nhan`
--
ALTER TABLE `tinh_trang_hon_nhan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `ton_giao`
--
ALTER TABLE `ton_giao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `trinh_do`
--
ALTER TABLE `trinh_do`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `nhanvien` (`id`);

--
-- Các ràng buộc cho bảng `attendance_history`
--
ALTER TABLE `attendance_history`
  ADD CONSTRAINT `attendance_history_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `nhanvien` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `attendance_logs`
--
ALTER TABLE `attendance_logs`
  ADD CONSTRAINT `attendance_logs_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `nhanvien` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `chinh_luong`
--
ALTER TABLE `chinh_luong`
  ADD CONSTRAINT `chinh_luong_ibfk_1` FOREIGN KEY (`nhanvien_id`) REFERENCES `nhanvien` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `cong_tac`
--
ALTER TABLE `cong_tac`
  ADD CONSTRAINT `cong_tac_ibfk_1` FOREIGN KEY (`nhanvien_id`) REFERENCES `nhanvien` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `daily_working_hours`
--
ALTER TABLE `daily_working_hours`
  ADD CONSTRAINT `daily_working_hours_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `nhanvien` (`id`);

--
-- Các ràng buộc cho bảng `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `images_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `nhanvien` (`id`);

--
-- Các ràng buộc cho bảng `khen_thuong_ky_luat`
--
ALTER TABLE `khen_thuong_ky_luat`
  ADD CONSTRAINT `khen_thuong_ky_luat_ibfk_1` FOREIGN KEY (`nhanvien_id`) REFERENCES `nhanvien` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `khen_thuong_ky_luat_ibfk_2` FOREIGN KEY (`loai_kt_id`) REFERENCES `loai_khen_thuong_ky_luat` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `luong`
--
ALTER TABLE `luong`
  ADD CONSTRAINT `luong_ibfk_1` FOREIGN KEY (`nhanvien_id`) REFERENCES `nhanvien` (`id`);

--
-- Các ràng buộc cho bảng `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD CONSTRAINT `nhanvien_ibfk_1` FOREIGN KEY (`quoc_tich_id`) REFERENCES `quoc_tich` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `nhanvien_ibfk_2` FOREIGN KEY (`ton_giao_id`) REFERENCES `ton_giao` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `nhanvien_ibfk_3` FOREIGN KEY (`dan_toc_id`) REFERENCES `dan_toc` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `nhanvien_ibfk_4` FOREIGN KEY (`loai_nv_id`) REFERENCES `loai_nv` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `nhanvien_ibfk_5` FOREIGN KEY (`trinh_do_id`) REFERENCES `trinh_do` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `nhanvien_ibfk_6` FOREIGN KEY (`chuyen_mon_id`) REFERENCES `chuyen_mon` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `nhanvien_ibfk_7` FOREIGN KEY (`bang_cap_id`) REFERENCES `bang_cap` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `nhanvien_ibfk_8` FOREIGN KEY (`phong_ban_id`) REFERENCES `phong_ban` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `nhanvien_ibfk_9` FOREIGN KEY (`chuc_vu_id`) REFERENCES `chuc_vu` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Các ràng buộc cho bảng `people`
--
ALTER TABLE `people`
  ADD CONSTRAINT `people_ibfk_1` FOREIGN KEY (`ID`) REFERENCES `nhanvien` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
