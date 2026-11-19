-- Import bằng phpMyAdmin hoặc MySQL/MariaDB CLI (UTF-8).
-- Dùng database riêng để giữ nguyên dữ liệu TH4 (shopping_cart) và TH8 (th8_products).
-- Giữ nguyên bản ghi đã có nếu trùng khóa chính.
CREATE DATABASE IF NOT EXISTS th9_products
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE th9_products;
SET NAMES utf8mb4;

CREATE TABLE IF NOT EXISTS products (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price INT NOT NULL,
    stock INT NOT NULL,
    image VARCHAR(255) NULL DEFAULT NULL,
    CONSTRAINT chk_products_name CHECK (CHAR_LENGTH(TRIM(name)) BETWEEN 1 AND 100 AND name REGEXP '[^[:space:]]'),
    CONSTRAINT chk_products_price CHECK (price > 0),
    CONSTRAINT chk_products_stock CHECK (stock >= 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO products (id, name, price, stock, image) VALUES
(1, 'Bút bi xanh Thiên Long', 5000, 20, NULL),
(2, 'Vở ô ly 96 trang', 12000, 15, NULL),
(3, 'Thước kẻ nhựa 20cm', 8000, 0, NULL),
(4, 'Bút chì gỗ 2B', 4000, 35, NULL),
(5, 'Tẩy gôm học sinh', 6000, 28, NULL),
(6, 'Kéo cắt giấy văn phòng', 22000, 12, NULL),
(7, 'Bấm kim số 10', 25000, 10, NULL),
(8, 'Hộp kim bấm số 10', 7000, 40, NULL),
(9, 'Giấy note dán 3x3 inch', 15000, 18, NULL),
(10, 'Bìa hồ sơ nút A4', 9000, 30, NULL),
(11, 'Bút dạ quang vàng', 14000, 22, NULL),
(12, 'Sổ tay bìa da A5', 45000, 8, NULL)
ON DUPLICATE KEY UPDATE id = id;
