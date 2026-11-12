-- Import bằng phpMyAdmin hoặc MySQL/MariaDB CLI (UTF-8).
-- Dùng database riêng để giữ nguyên bảng products của TH4 trong shopping_cart.
-- Giữ nguyên bản ghi đã có nếu trùng khóa chính.
CREATE DATABASE IF NOT EXISTS th8_products
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE th8_products;
SET NAMES utf8mb4;

CREATE TABLE IF NOT EXISTS products (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price INT NOT NULL,
    stock INT NOT NULL,
    CONSTRAINT chk_products_name CHECK (CHAR_LENGTH(TRIM(name)) BETWEEN 1 AND 100 AND name REGEXP '[^[:space:]]'),
    CONSTRAINT chk_products_price CHECK (price > 0),
    CONSTRAINT chk_products_stock CHECK (stock >= 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO products (id, name, price, stock) VALUES
(1, 'Bút bi', 5000, 20),
(2, 'Vở ô ly', 12000, 15),
(3, 'Thước kẻ', 8000, 0)
ON DUPLICATE KEY UPDATE id = id;
