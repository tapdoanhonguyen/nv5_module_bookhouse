-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost
-- Thời gian đã tạo: Th12 28, 2021 lúc 07:52 AM
-- Phiên bản máy phục vụ: 10.5.11-MariaDB
-- Phiên bản PHP: 7.4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `autoweb_hcm`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nv4_vi_bookhouse_province`
--

CREATE TABLE `nv4_vi_bookhouse_province` (
  `provinceid` mediumint(4) UNSIGNED NOT NULL,
  `code` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `countryid` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alias` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `weight` smallint(4) UNSIGNED NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `nv4_vi_bookhouse_province`
--

INSERT INTO `nv4_vi_bookhouse_province` (`provinceid`, `code`, `countryid`, `title`, `alias`, `type`, `weight`, `status`) VALUES
(1, '01', '1', 'Hà Nội', 'Ha-Noi', 'Thành Phố', 1, 1),
(2, '02', '1', 'Hà Giang', 'Ha-Giang', 'Tỉnh', 2, 1),
(3, '04', '1', 'Cao Bằng', 'Cao-Bang', 'Tỉnh', 3, 1),
(4, '06', '1', 'Bắc Kạn', 'Bac-Kan', 'Tỉnh', 4, 1),
(5, '08', '1', 'Tuyên Quang', 'Tuyen-Quang', 'Tỉnh', 5, 1),
(6, '10', '1', 'Lào Cai', 'Lao-Cai', 'Tỉnh', 6, 1),
(7, '11', '1', 'Điện Biên', 'Dien-Bien', 'Tỉnh', 7, 1),
(8, '12', '1', 'Lai Châu', 'Lai-Chau', 'Tỉnh', 8, 1),
(9, '14', '1', 'Sơn La', 'Son-La', 'Tỉnh', 9, 1),
(10, '15', '1', 'Yên Bái', 'Yen-Bai', 'Tỉnh', 10, 1),
(11, '17', '1', 'Hòa Bình', 'Hoa-Binh', 'Tỉnh', 11, 1),
(12, '19', '1', 'Thái Nguyên', 'Thai-Nguyen', 'Tỉnh', 12, 1),
(13, '20', '1', 'Lạng Sơn', 'Lang-Son', 'Tỉnh', 13, 1),
(14, '22', '1', 'Quảng Ninh', 'Quang-Ninh', 'Tỉnh', 14, 1),
(15, '24', '1', 'Bắc Giang', 'Bac-Giang', 'Tỉnh', 15, 1),
(16, '25', '1', 'Phú Thọ', 'Phu-Tho', 'Tỉnh', 16, 1),
(17, '26', '1', 'Vĩnh Phúc', 'Vinh-Phuc', 'Tỉnh', 17, 1),
(18, '27', '1', 'Bắc Ninh', 'Bac-Ninh', 'Tỉnh', 18, 1),
(19, '30', '1', 'Hải Dương', 'Hai-Duong', 'Tỉnh', 19, 1),
(20, '31', '1', 'Hải Phòng', 'Hai-Phong', 'Thành Phố', 20, 1),
(21, '33', '1', 'Hưng Yên', 'Hung-Yen', 'Tỉnh', 21, 1),
(22, '34', '1', 'Thái Bình', 'Thai-Binh', 'Tỉnh', 22, 1),
(23, '35', '1', 'Hà Nam', 'Ha-Nam', 'Tỉnh', 23, 1),
(24, '36', '1', 'Nam Định', 'Nam-Dinh', 'Tỉnh', 24, 1),
(25, '37', '1', 'Ninh Bình', 'Ninh-Binh', 'Tỉnh', 25, 1),
(26, '38', '1', 'Thanh Hóa', 'Thanh-Hoa', 'Tỉnh', 26, 1),
(27, '40', '1', 'Nghệ An', 'Nghe-An', 'Tỉnh', 27, 1),
(28, '42', '1', 'Hà Tĩnh', 'Ha-Tinh', 'Tỉnh', 28, 1),
(29, '44', '1', 'Quảng Bình', 'Quang-Binh', 'Tỉnh', 29, 1),
(30, '45', '1', 'Quảng Trị', 'Quang-Tri', 'Tỉnh', 30, 1),
(31, '46', '1', 'Thừa Thiên Huế', 'Thua-Thien-Hue', 'Tỉnh', 31, 1),
(32, '48', '1', 'Đà Nẵng', 'Da-Nang', 'Thành Phố', 32, 1),
(33, '49', '1', 'Quảng Nam', 'Quang-Nam', 'Tỉnh', 33, 1),
(34, '51', '1', 'Quảng Ngãi', 'Quang-Ngai', 'Tỉnh', 34, 1),
(35, '52', '1', 'Bình Định', 'Binh-Dinh', 'Tỉnh', 35, 1),
(36, '54', '1', 'Phú Yên', 'Phu-Yen', 'Tỉnh', 36, 1),
(37, '56', '1', 'Khánh Hòa', 'Khanh-Hoa', 'Tỉnh', 37, 1),
(38, '58', '1', 'Ninh Thuận', 'Ninh-Thuan', 'Tỉnh', 38, 1),
(39, '60', '1', 'Bình Thuận', 'Binh-Thuan', 'Tỉnh', 39, 1),
(40, '62', '1', 'Kon Tum', 'Kon-Tum', 'Tỉnh', 40, 1),
(41, '64', '1', 'Gia Lai', 'Gia-Lai', 'Tỉnh', 41, 1),
(42, '66', '1', 'Đắk Lắk', 'Dak-Lak', 'Tỉnh', 42, 1),
(43, '67', '1', 'Đắk Nông', 'Dak-Nong', 'Tỉnh', 43, 1),
(44, '68', '1', 'Lâm Đồng', 'Lam-Dong', 'Tỉnh', 44, 1),
(45, '70', '1', 'Bình Phước', 'Binh-Phuoc', 'Tỉnh', 45, 1),
(46, '72', '1', 'Tây Ninh', 'Tay-Ninh', 'Tỉnh', 46, 1),
(47, '74', '1', 'Bình Dương', 'Binh-Duong', 'Tỉnh', 47, 1),
(48, '75', '1', 'Đồng Nai', 'Dong-Nai', 'Tỉnh', 48, 1),
(49, '77', '1', 'Bà Rịa - Vũng Tàu', 'Ba-Ria-Vung-Tau', 'Tỉnh', 49, 1),
(50, '79', '1', 'Hồ Chí Minh', 'Ho-Chi-Minh', 'Thành Phố', 50, 1),
(51, '80', '1', 'Long An', 'Long-An', 'Tỉnh', 51, 1),
(52, '82', '1', 'Tiền Giang', 'Tien-Giang', 'Tỉnh', 52, 1),
(53, '83', '1', 'Bến Tre', 'Ben-Tre', 'Tỉnh', 53, 1),
(54, '84', '1', 'Trà Vinh', 'Tra-Vinh', 'Tỉnh', 54, 1),
(55, '86', '1', 'Vĩnh Long', 'Vinh-Long', 'Tỉnh', 55, 1),
(56, '87', '1', 'Đồng Tháp', 'Dong-Thap', 'Tỉnh', 56, 1),
(57, '89', '1', 'An Giang', 'An-Giang', 'Tỉnh', 57, 1),
(58, '91', '1', 'Kiên Giang', 'Kien-Giang', 'Tỉnh', 58, 1),
(59, '92', '1', 'Cần Thơ', 'Can-Tho', 'Thành Phố', 59, 1),
(60, '93', '1', 'Hậu Giang', 'Hau-Giang', 'Tỉnh', 60, 1),
(61, '94', '1', 'Sóc Trăng', 'Soc-Trang', 'Tỉnh', 61, 1),
(62, '95', '1', 'Bạc Liêu', 'Bac-Lieu', 'Tỉnh', 62, 1),
(63, '96', '1', 'Cà Mau', 'Ca-Mau', 'Tỉnh', 63, 1);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `nv4_vi_bookhouse_province`
--
ALTER TABLE `nv4_vi_bookhouse_province`
  ADD PRIMARY KEY (`provinceid`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `nv4_vi_bookhouse_province`
--
ALTER TABLE `nv4_vi_bookhouse_province`
  MODIFY `provinceid` mediumint(4) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
