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
(1, 'Bút bi xanh Thiên Long', 5000, 20, 'uploads/product_1_ae621d6a6157ee49.jpg'),
(2, 'Vở ô ly 96 trang', 12000, 15, 'uploads/product_2_d1762c5cfaf14526.jpg'),
(3, 'Thước kẻ nhựa 20cm', 8000, 0, 'uploads/product_3_a8658699c511fc9e.jpg'),
(4, 'Bút chì gỗ 2B', 4000, 35, 'uploads/product_4_50953e743c6ea51f.jpg'),
(5, 'Tẩy gôm học sinh', 6000, 28, 'uploads/product_5_792827294936463c.jpg'),
(6, 'Kéo cắt giấy văn phòng', 22000, 12, 'uploads/product_6_e932902358258278.jpg'),
(7, 'Bấm kim số 10', 25000, 10, 'uploads/product_7_4277536f4610fa90.jpg'),
(8, 'Hộp kim bấm số 10', 7000, 40, 'uploads/product_8_45233c3bc8a3b18f.jpg'),
(9, 'Giấy note dán 3x3 inch', 15000, 18, 'uploads/product_9_71fff9d0a6698e72.jpg'),
(10, 'Bìa hồ sơ nút A4', 9000, 30, 'uploads/product_10_ad8f8a6a6c0a2839.jpg'),
(11, 'Bút dạ quang vàng', 14000, 22, 'uploads/product_11_d71cbde0c9c8d084.jpg'),
(12, 'Sổ tay bìa da A5', 45000, 8, 'uploads/product_12_431e3cdecfd24a74.jpg')
ON DUPLICATE KEY UPDATE id = id;
