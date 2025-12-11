CREATE DATABASE IF NOT EXISTS `mengroom`
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE `mengroom`;

CREATE TABLE IF NOT EXISTS `User` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `hoten` VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `sdt` VARCHAR(12) UNIQUE NOT NULL,
    `email` VARCHAR(255) UNIQUE NOT NULL,
    `pass_hash` VARCHAR(255) NOT NULL,
    `vaitro` ENUM('admin', 'user') NOT NULL DEFAULT 'user',
    `thoigiantao` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `thoigiancapnhat` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `Thuonghieu` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `tenthuonghieu` VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `logo_url` VARCHAR(255) NULL,
    `mota_thuonghieu` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `Loaisp` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `tenloai` VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `slug` VARCHAR(120) UNIQUE NOT NULL,
    `parent_id` INT NULL,
    `mota_loaisp` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
    FOREIGN KEY (`parent_id`) REFERENCES `Loaisp`(`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `Sanpham` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `tensp` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `slug` VARCHAR(120) UNIQUE NOT NULL,
    `sku` VARCHAR(50) UNIQUE NULL COMMENT 'Mã quản lý kho',
    `image_url` VARCHAR(255) NULL, 
    `gia` DECIMAL(12, 2) NOT NULL DEFAULT 0,
    `giakhuyenmai` DECIMAL(12, 2) NULL,
    `soluongtonkho` INT NOT NULL DEFAULT 0,
    `chitietsp` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
    `hdsd` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
    `thanhphansp` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
    `id_loaisp` INT NOT NULL,
    `id_thuonghieu` INT NOT NULL,
    `trangthaihienthi` TINYINT(1) NOT NULL DEFAULT 0,
    `thoigiantao` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `thoigiancapnhat` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`id_loaisp`) REFERENCES `Loaisp`(`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY (`id_thuonghieu`) REFERENCES `Thuonghieu`(`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `Giohang` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT NOT NULL,
    `sanpham_id` INT NOT NULL,
    `soluong` INT NOT NULL DEFAULT 1,
    `ngaytao` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `ngaycapnhat` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (`user_id`) REFERENCES `User`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (`sanpham_id`) REFERENCES `Sanpham`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    
    UNIQUE KEY `uk_giohang_user_sanpham` (`user_id`, `sanpham_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `Diachi` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT NOT NULL,
    `tennguoinhan` VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `sodienthoai` VARCHAR(15) NOT NULL,
    `diachichitiet` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `phuong_xa` VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `quan_huyen` VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `tinh_thanhpho` VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `diachimacdinh` BOOLEAN NOT NULL DEFAULT 0,
    FOREIGN KEY (`user_id`) REFERENCES `User`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `Donhang` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT NOT NULL,
    `ngaydathang` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `trangthai` ENUM('Đang chờ xử lý', 'Đang giao hàng', 'Đã hoàn thành', 'Đã hủy') NOT NULL DEFAULT 'Đang chờ xử lý',
    `tongtien` DECIMAL(12, 2) NOT NULL,
    `diachi_id` INT NOT NULL,
    `phuongthucthanhtoan` VARCHAR(50) NOT NULL,
    `ghichu` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
    FOREIGN KEY (`user_id`) REFERENCES `User`(`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY (`diachi_id`) REFERENCES `Diachi`(`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `Chitietdonhang` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `donhang_id` INT NOT NULL,
    `sanpham_id` INT NOT NULL,
    `soluong` INT NOT NULL,
    `giagoc` DECIMAL(12, 2) NOT NULL,
    FOREIGN KEY (`donhang_id`) REFERENCES `Donhang`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (`sanpham_id`) REFERENCES `Sanpham`(`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
    UNIQUE KEY `uk_donhang_sanpham` (`donhang_id`, `sanpham_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `Danhgia` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT NOT NULL,
    `sanpham_id` INT NOT NULL,
    `danhgia` TINYINT NOT NULL COMMENT 'Từ 1 đến 5 sao',
    `binhluan` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
    `thoigiandanhgia` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`user_id`) REFERENCES `User`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (`sanpham_id`) REFERENCES `Sanpham`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    UNIQUE KEY `uk_user_sanpham` (`user_id`, `sanpham_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




