-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th9 15, 2024 lúc 12:22 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `gongcha`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `danhmuc`
--

CREATE TABLE `danhmuc` (
  `id_danhmuc` varchar(10) NOT NULL,
  `tenLoai` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `danhmuc`
--

INSERT INTO `danhmuc` (`id_danhmuc`, `tenLoai`) VALUES
('lsp01', 'Kem'),
('lsp02', 'Trà trái cây'),
('lsp03', 'Okinawa'),
('lsp04', 'Latte'),
('lsp05', 'GongCha'),
('lsp06', 'Trà sữa'),
('lsp07', 'Trà nguyên chất'),
('lsp08', 'Thức uống sáng tạo'),
('lsp09', 'Thức uống đá xay'),
('lsp10', 'Topping');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `giohang`
--

CREATE TABLE `giohang` (
  `gio_id` int(11) NOT NULL,
  `sp_id` varchar(10) NOT NULL,
  `soLuong` int(11) NOT NULL DEFAULT 1,
  `gia` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khohang`
--

CREATE TABLE `khohang` (
  `kho_id` int(11) NOT NULL,
  `ten_NL` text NOT NULL,
  `hinhAnh` longblob DEFAULT NULL,
  `soLuong` int(11) NOT NULL,
  `giaNhap` float DEFAULT NULL,
  `ngayNhap` date DEFAULT NULL,
  `HSD` date DEFAULT NULL,
  `tinhTrang` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `menu`
--

CREATE TABLE `menu` (
  `id_sanpham` varchar(10) NOT NULL,
  `id_danhmuc` varchar(10) NOT NULL,
  `tenSP` text NOT NULL,
  `hinh_anh` text DEFAULT NULL,
  `congthuc` text DEFAULT NULL,
  `gia_S` int(11) DEFAULT NULL,
  `gia_M` int(11) DEFAULT NULL,
  `gia_L` int(11) DEFAULT NULL,
  `gia_nong` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `menu`
--

INSERT INTO `menu` (`id_sanpham`, `id_danhmuc`, `tenSP`, `hinh_anh`, `congthuc`, `gia_S`, `gia_M`, `gia_L`, `gia_nong`) VALUES
('sp01', 'lsp01', 'Kem Trà Sữa & Trân Châu Đen', 'Kem/kem-tra-sua-tran-chau.png', '', NULL, 35000, NULL, NULL),
('sp02', 'lsp01', 'Kem Trà Sữa', 'Kem/kem-tra-sua.png', '', NULL, 30000, NULL, NULL),
('sp03', 'lsp02', 'Trà Quýt Yakult', 'Tra-trai-cay/TRA-QUYT-YAKULT.png', '', NULL, 65000, 73000, NULL),
('sp04', 'lsp02', 'Trà Sữa Quýt Yuzu', 'Tra-trai-cay/TRA-SUA-QUYT_YUZU.png', '', NULL, 65000, 73000, NULL),
('sp05', 'lsp02', 'Trà Quýt Yuzu', 'Tra-trai-cay/TRA-QUYT_YUZU.png', '', NULL, 62000, 70000, NULL),
('sp06', 'lsp02', 'Grape Green Tea', 'Tra-trai-cay/TRA-NHO.png', '', NULL, 56000, 64000, NULL),
('sp07', 'lsp02', 'Trà Alisan Trái Cây', 'Tra-trai-cay/ALISAN-TRÁI-CÂY.png', '', NULL, 54000, 62000, NULL),
('sp08', 'lsp02', 'Chanh Ai-yu và Trân Châu Trắng', 'Tra-trai-cay/Chanh-Aiyu-trân-châu-trắng.png', '', NULL, 52000, 60000, NULL),
('sp09', 'lsp02', 'Đào Hồng Mận Hạt É', 'Tra-trai-cay/Đào-hồng-mận-hột-é.png', '', NULL, 52000, 60000, NULL),
('sp10', 'lsp02', 'Trà Oolong Vải', 'Tra-trai-cay/Oolong-vải.png', '', NULL, 52000, 60000, NULL),
('sp11', 'lsp02', 'Trà Alisan Vải', 'Tra-trai-cay/Alisan-vải.png', '', NULL, 52000, 60000, 52000),
('sp12', 'lsp02', 'Trà Đen Đào', 'Tra-trai-cay/Đen-đào.png', '', NULL, 54000, 62000, 54000),
('sp13', 'lsp02', 'Trà Xanh Đào', 'Tra-trai-cay/Xanh-đào.png', '', NULL, 54000, 62000, 54000),
('sp14', 'lsp03', 'Okinawa Oreo Cream Milk Tea', 'Okinawa/Okinawa-Oreo-Cream-Milk-Tea.png', '', 57000, 65000, 73000, NULL),
('sp15', 'lsp03', 'Okinawa Milk Foam Smoothie', 'Okinawa/Okinawa-Milk-Foam-Smoothie.png', '', NULL, 68000, NULL, NULL),
('sp16', 'lsp03', 'Trà Sữa Okinawa', 'Okinawa/OKINAWA-TRÀ-SỮA.png', '', 57000, 65000, 73000, 57000),
('sp17', 'lsp03', 'Sữa Tươi Okinawa', 'Okinawa/OKINAWA-SUA-TUOI.png', '', 51000, 59000, 67000, NULL),
('sp18', 'lsp03', 'Okinawa Latte', 'Okinawa/OKINAWA-LATTE.png\r\n', '', 57000, 65000, 73000, 57000),
('sp19', 'lsp04', 'Dâu Latte', 'Latte/Strawberry-Earl-grey-latte.png', '', NULL, 62000, 70000, NULL),
('sp20', 'lsp05', 'MILO Kem Chanh', 'Gongcha/milo-kem-chanh.png', '', NULL, 60000, NULL, NULL),
('sp21', 'lsp05', 'Trà Xanh Kem Sữa MILO', 'Gongcha/tra-xanh-kem-sua-Milo.png', '', NULL, 56000, 0, NULL),
('sp22', 'lsp05', 'Crunchie MILO Toffee', 'Gongcha/Crunchie-Toffee-MILO.png', '', NULL, 60000, NULL, NULL),
('sp23', 'lsp05', 'Trà Bí Đao Gong Cha', 'Gongcha/Trà-Bí-Đao-Milkfoam.png', '', NULL, 56000, 64000, NULL),
('sp24', 'lsp05', 'Trà Oolong Gong Cha', 'Gongcha/Trà-Oolong-Milkfoam.png', '', NULL, 56000, 64000, 56000),
('sp25', 'lsp05', 'Trà Alisan Gong Cha', 'Gongcha/Trà-Alisan-Milkfoam.png', '', NULL, 56000, 64000, 56000),
('sp26', 'lsp05', 'Trà Đen Gong Cha', 'Gongcha/Trà-Đen-Milkfoam.png', '', NULL, 52000, 60000, 52000),
('sp27', 'lsp05', 'Trà Xanh Gong Cha', 'Gongcha/Trà-xanh-GC.png', '', NULL, 52000, 60000, 52000),
('sp28', 'lsp06', 'Trà Sữa Ra Dẻ', 'Tra-sua/Mont-Blanc-Milk-Tea.png', '', NULL, 65000, NULL, NULL),
('sp29', 'lsp06', 'Trà Sữa Caviar Cream Earl Grey', 'Tra-sua/Tra-sua-Banh-Quy-Gung.png', '', NULL, 65000, 73000, NULL),
('sp30', 'lsp06', 'Grape Milk Tea\r\n', 'Tra-sua/TRA-SUA-NHO.png', '', NULL, 59000, 67000, NULL),
('sp31', 'lsp06', 'Đào Sữa Hoàng Kim', 'Tra-sua/Tra-sua-Thach-Dao.png', '', NULL, 63000, 71000, NULL),
('sp32', 'lsp06', 'Strawberry Milk Tea', 'Tra-sua/Tra-Xanh-Sua-Dau.png', '', NULL, 60000, 68000, NULL),
('sp33', 'lsp06', 'Strawberry Cookie Milk Tea', 'Tra-sua/Tra-Sua-Dau-Cookie.png', '', NULL, 70000, 78000, NULL),
('sp34', 'lsp06', 'Mint Choco Milk Tea', 'Tra-sua/Mint-Chocolate-Milk-Tea-w-Pearl-Iced.png', '', NULL, 59000, 67000, NULL),
('sp35', 'lsp06', 'Trà Sữa Trân Châu Hoàng Kim', 'Tra-sua/Tra-sua-tran-chau-HK.png', '', 53000, 61000, 69000, NULL),
('sp36', 'lsp06', 'Trà Sữa Đào', 'Tra-sua/Tra-Sua-Dao.png', '', NULL, 58000, 66000, NULL),
('sp37', 'lsp06', 'Trà Sữa Xoài', 'Tra-sua/Tra-Sua-Xoai.png', '', NULL, 62000, 70000, 62000),
('sp38', 'lsp06', 'Trà sữa Oolong 3J', 'Tra-sua/Trà-sữa-Oolong-3J.png', '', NULL, 62000, 70000, NULL),
('sp39', 'lsp06', 'Trà Sữa Pudding Đậu Đỏ', 'Tra-sua/Trà-sữa-Pudding-đậu-đỏ.png', '', NULL, 56000, 64000, NULL),
('sp40', 'lsp06', 'Trà Sữa Chocolate', 'Tra-sua/Trà-sữa-Chocolate.png', '', 51000, 59000, 67000, 59000),
('sp41', 'lsp06', 'Trà Sữa Trân Châu Đen', 'Tra-sua/Trà-sữa-Trân-châu-đen.png', '', 47000, 55000, 63000, NULL),
('sp42', 'lsp06', 'Trà Sữa Hokkaido', 'Tra-sua/Trà-sữa-Hokkaido.png', '', 47000, 55000, 63000, NULL),
('sp43', 'lsp06', 'Trà Sữa Sương Sáo', 'Tra-sua/Trà-sữa-sương-sáo.png', '', NULL, 52000, 60000, NULL),
('sp44', 'lsp06', 'Trà Sữa Oolong', 'Tra-sua/Trà-sữa-Oolong.png', '', 47000, 55000, 63000, 55000),
('sp45', 'lsp06', 'Trà Sữa Trà Đen', 'Tra-sua/Trà-sữa-trà-đen.png', '', 44000, 52000, 60000, 52000),
('sp46', 'lsp06', 'Trà Sữa Trà Xanh', 'Tra-sua/Trà-sữa-trà-xanh.png', '', 44000, 52000, 60000, 52000),
('sp47', 'lsp06', 'Trà Sữa Khoai Môn', 'Tra-sua/Trà-sữa-Khoai-môn.png', '', 51000, 59000, 67000, 59000),
('sp48', 'lsp07', 'Trà Bí Đao', 'Tra-nguyen-chat/Trà-Bí-Đao.png', '', NULL, 45000, 53000, NULL),
('sp49', 'lsp07', 'Trà Alisan', 'Tra-nguyen-chat/Trà-Alisan.png', '', NULL, 45000, 53000, 45000),
('sp50', 'lsp07', 'Trà Oolong', 'Tra-nguyen-chat/Trà-Oolong.png', '', NULL, 45000, 53000, 45000),
('sp51', 'lsp07', 'Trà Đen', 'Tra-nguyen-chat/Trà-Đen.png', '', NULL, 42000, 50000, 42000),
('sp52', 'lsp07', 'Trà Xanh', 'Tra-nguyen-chat/Trà-Xanh.png', '', NULL, 42000, 50000, 42000),
('sp53', 'lsp08', 'Trà Sữa Matcha', 'sang-tao/Tra-sua-Matcha.png', '', NULL, 61000, 69000, NULL),
('sp54', 'lsp08', 'Trà Sữa Bạc Hà', 'sang-tao/Tra-sua-Mint.png', '', NULL, 61000, 69000, NULL),
('sp55', 'lsp08', 'Trà Sữa Dâu', 'sang-tao/Tra-sua-dau.png', '', NULL, 61000, 69000, NULL),
('sp56', 'lsp08', 'Trà Sữa Bánh Quy Gừng', 'sang-tao/Tra-sua-Earl-Grey-Carvia.png', '', NULL, 61000, 69000, NULL),
('sp57', 'lsp08', 'Grape Green Tea', 'sang-tao/TRA-XANH-NHO.png', '', NULL, 56000, 64000, NULL),
('sp58', 'lsp08', 'Grape Smoothie', 'sang-tao/DA-XAY-NHO.png', '', NULL, 69000, NULL, NULL),
('sp59', 'lsp08', 'Crunchie MILO Toffee', 'sang-tao/Crunchie-Toffee-Latte.png', '', NULL, 60000, NULL, NULL),
('sp60', 'lsp08', 'Cotton Candy Milk Tea', 'sang-tao/cotton-candy-now.png', '', NULL, 65000, 73000, NULL),
('sp61', 'lsp08', 'Rainbow Crush', 'sang-tao/rainbow-now.png', '', NULL, 70000, 78000, NULL),
('sp62', 'lsp08', 'Sunrise Milk Tea', 'sang-tao/sunrise-milk-tea-now.png', '', NULL, 70000, 78000, NULL),
('sp63', 'lsp08', 'Trà Xanh Đào', 'sang-tao/Tra-Xanh-Dao.png', '', NULL, 54000, 62000, NULL),
('sp64', 'lsp09', 'Ra Dẻ Đá Tuyết', 'da-xay/Mont-Blanc-Smoothie.png', '', NULL, 70000, NULL, NULL),
('sp65', 'lsp09', 'Đào Sữa Hoàng Kim Đá Tuyết', 'da-xay/dao-da-xay.png', '', NULL, 70000, NULL, NULL),
('sp66', 'lsp09', 'Đào Hồng Đá Tuyết\r\n', 'da-xay/dao-hong-man-da-tuyet.png', '', NULL, 70000, NULL, NULL),
('sp67', 'lsp09', 'Strawberry Choco Cookie Smoothie', 'da-xay/dau-socola-da-xay.png', '', NULL, 70000, NULL, NULL),
('sp68', 'lsp09', 'Mint Cookie Smoothie', 'da-xay/MINT-DA-XAY.png', '', NULL, 67000, NULL, NULL),
('sp69', 'lsp09', 'Mint Choco Smoothie', 'da-xay/MINT-CHOCO-DA-XAY.png', '', NULL, 67000, NULL, NULL),
('sp70', 'lsp09', 'Yakult Đào Đá Xay', 'da-xay/Yakult-Dao-Da-Xay.png', '', NULL, 68000, NULL, NULL),
('sp71', 'lsp09', 'Strawberry Oreo Smoothie', 'da-xay/Strawberry-Oreo-Smoothie.png', '', NULL, 68000, NULL, NULL),
('sp72', 'lsp09', 'Khoai Môn Đá Xay', 'da-xay/Khoai-môn-đá-xay.png', '', NULL, 68000, NULL, NULL),
('sp73', 'lsp09', 'Matcha Đá Xay', 'da-xay/Matcha-đá-xay.png', '', NULL, 68000, NULL, NULL),
('sp74', 'lsp10', 'Thạch Nâu', 'Topping/THACH-NAU.png', '', NULL, 11000, NULL, NULL),
('sp75', 'lsp10', 'Thạch Cà Phê', 'Topping/THACH-CA-PHE.png', '', NULL, 11000, NULL, NULL),
('sp76', 'lsp10', 'Trân Châu Vải', 'Topping/TRAN-CHAU-VAI.png', '', NULL, 11000, NULL, NULL),
('sp77', 'lsp10', 'Trân Châu Xoài', 'Topping/TRAN-CHAU-XOAI.png', '', NULL, 11000, NULL, NULL),
('sp78', 'lsp10', 'Kem Sữa', 'Topping/Kem-Sữa.png', '', NULL, 17000, NULL, NULL),
('sp79', 'lsp10', 'Nha Đam', 'Topping/Nha-Đam.png', '', NULL, 11000, NULL, NULL),
('sp80', 'lsp10', 'Trân Châu Đen', 'Topping/Trân-Châu-Đen.png', '', NULL, 11000, NULL, NULL),
('sp81', 'lsp10', 'Trân Châu Trắng', 'Topping/Trân-Châu-Trắng.png', '', NULL, 11000, NULL, NULL),
('sp82', 'lsp10', 'Đậu Đỏ', 'Topping/Đậu-Đỏ.png', '', NULL, 11000, NULL, NULL),
('sp83', 'lsp10', 'Sương Sáo', 'Topping/Sương-sáo.png', '', NULL, 11000, NULL, NULL),
('sp84', 'lsp10', 'Thạch Trái Cây', 'Topping/Thạch-trái-cây.png', '', NULL, 11000, NULL, NULL),
('sp85', 'lsp10', 'Thạch Dừa', 'Topping/Thạch-Dừa.png', '', NULL, 11000, NULL, NULL),
('sp86', 'lsp10', 'Pudding', 'Topping/pudding.png', '', NULL, 11000, NULL, NULL),
('sp87', 'lsp10', 'Combo 2 Loại Hạt', 'Topping/Combo2loaihat.png', '', NULL, 19000, NULL, NULL),
('sp88', 'lsp10', 'Combo 3 Loại Hạt', 'Topping/Combo-3-loại-hạt.png', '', NULL, 28000, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ncc`
--

CREATE TABLE `ncc` (
  `NCC_id` int(11) NOT NULL,
  `ten_NCC` text DEFAULT NULL,
  `diachi` text DEFAULT NULL,
  `sdt` int(11) DEFAULT NULL,
  `masothue` varchar(128) DEFAULT NULL,
  `ghichu` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhanvien`
--

CREATE TABLE `nhanvien` (
  `id_nhanvien` varchar(10) NOT NULL,
  `tenNV` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `sdt` text DEFAULT NULL,
  `ngayvaolam` date DEFAULT NULL,
  `luong` float DEFAULT NULL,
  `taikhoan` varchar(20) NOT NULL,
  `matkhau` varchar(20) NOT NULL,
  `quyen` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `nhanvien`
--

INSERT INTO `nhanvien` (`id_nhanvien`, `tenNV`, `email`, `sdt`, `ngayvaolam`, `luong`, `taikhoan`, `matkhau`, `quyen`) VALUES
('admin', 'admin ', 'dahliaa1906@gmail.com', '0367104154', '2023-08-01', 10000000, 'admin', 'admin', 0),
('dieu', 'Lê Hoàng Diệu', 'hdieu12706@gmail.com', '0376390962', '2024-08-01', NULL, 'dieu196', '1', 1),
('liem', 'Nguyễn Ngọc Liem', 'liemnguyenngocliem@gmail.com', '0394259674', '2024-08-01', NULL, 'liem', '1', 1),
('thao', 'Nguyễn Thị Phương Thảo', 'thao01654@gmail.com\r\n', '0985824745', '2024-08-01', NULL, 'thao', '1', 1),
('tram', 'Trịnh Ngọc Trâm', 'tram@gmail.com', '0353662271', '2024-08-01', NULL, 'tram', '1', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_ctdathang`
--

CREATE TABLE `tbl_ctdathang` (
  `id_DatHang` varchar(10) NOT NULL,
  `id_sanpham` varchar(10) NOT NULL,
  `soLuong` int(11) NOT NULL,
  `donGia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_dathang`
--

CREATE TABLE `tbl_dathang` (
  `id_DatHang` varchar(10) NOT NULL,
  `tenKH` text NOT NULL,
  `sdt` text NOT NULL,
  `diaChi` text NOT NULL,
  `tongTien` float NOT NULL,
  `ngayDat` date DEFAULT NULL,
  `tinhTrang` text NOT NULL,
  `ghiChu` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_dathang`
--

INSERT INTO `tbl_dathang` (`id_DatHang`, `tenKH`, `sdt`, `diaChi`, `tongTien`, `ngayDat`, `tinhTrang`, `ghiChu`) VALUES
('HD1', 'Nguyen Van A', '0123456789', 'Hà Nội', 100000, '2024-09-01', 'đang giao', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_tintuc`
--

CREATE TABLE `tbl_tintuc` (
  `id_tintuc` int(11) NOT NULL,
  `tieude` text NOT NULL,
  `mota` text DEFAULT NULL,
  `anh` varchar(255) DEFAULT NULL,
  `trang_thai` enum('Xuất bản','Bản nháp') DEFAULT 'Xuất bản',
  `noidung` text NOT NULL,
  `luotxem` int(11) DEFAULT 0,
  `nguoi_dang` text NOT NULL,
  `ngay_sd` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ngaydang` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `danhmuc`
--
ALTER TABLE `danhmuc`
  ADD PRIMARY KEY (`id_danhmuc`);

--
-- Chỉ mục cho bảng `giohang`
--
ALTER TABLE `giohang`
  ADD PRIMARY KEY (`gio_id`),
  ADD KEY `sp_id` (`sp_id`);

--
-- Chỉ mục cho bảng `khohang`
--
ALTER TABLE `khohang`
  ADD PRIMARY KEY (`kho_id`);

--
-- Chỉ mục cho bảng `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id_sanpham`),
  ADD KEY `id_loaisp` (`id_danhmuc`);

--
-- Chỉ mục cho bảng `ncc`
--
ALTER TABLE `ncc`
  ADD PRIMARY KEY (`NCC_id`);

--
-- Chỉ mục cho bảng `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD PRIMARY KEY (`id_nhanvien`);

--
-- Chỉ mục cho bảng `tbl_ctdathang`
--
ALTER TABLE `tbl_ctdathang`
  ADD KEY `fk_madh` (`id_DatHang`),
  ADD KEY `fk_masp` (`id_sanpham`);

--
-- Chỉ mục cho bảng `tbl_dathang`
--
ALTER TABLE `tbl_dathang`
  ADD PRIMARY KEY (`id_DatHang`);

--
-- Chỉ mục cho bảng `tbl_tintuc`
--
ALTER TABLE `tbl_tintuc`
  ADD PRIMARY KEY (`id_tintuc`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `giohang`
--
ALTER TABLE `giohang`
  MODIFY `gio_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `khohang`
--
ALTER TABLE `khohang`
  MODIFY `kho_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `ncc`
--
ALTER TABLE `ncc`
  MODIFY `NCC_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `tbl_tintuc`
--
ALTER TABLE `tbl_tintuc`
  MODIFY `id_tintuc` int(11) NOT NULL AUTO_INCREMENT;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `giohang`
--
ALTER TABLE `giohang`
  ADD CONSTRAINT `giohang_ibfk_1` FOREIGN KEY (`sp_id`) REFERENCES `menu` (`id_sanpham`);

--
-- Các ràng buộc cho bảng `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `id_loaisp` FOREIGN KEY (`id_danhmuc`) REFERENCES `danhmuc` (`id_danhmuc`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `tbl_ctdathang`
--
ALTER TABLE `tbl_ctdathang`
  ADD CONSTRAINT `fk_madh` FOREIGN KEY (`id_DatHang`) REFERENCES `tbl_dathang` (`id_DatHang`),
  ADD CONSTRAINT `fk_masp` FOREIGN KEY (`id_sanpham`) REFERENCES `menu` (`id_sanpham`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
