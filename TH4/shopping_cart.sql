-- Import bằng phpMyAdmin hoặc MySQL CLI (UTF-8).
-- Giữ nguyên bản ghi đã có nếu trùng khóa chính hoặc tên đăng nhập.
CREATE DATABASE IF NOT EXISTS shopping_cart
    CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE shopping_cart;
SET NAMES utf8mb4;

CREATE TABLE IF NOT EXISTS products (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    quantity INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS users (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO products (id, name, price, quantity) VALUES
(1, 'Chuột không dây Logitech G304', 690000.00, 15),
(2, 'Bàn phím cơ DareU EK87', 550000.00, 20),
(3, 'Tai nghe Gaming chụp tai Havit', 350000.00, 8),
(4, 'Lót chuột Gaming cỡ lớn 80x30cm', 85000.00, 30),
(5, 'Cáp sạc nhanh Type-C Ugreen 65W', 120000.00, 25)
ON DUPLICATE KEY UPDATE id = id;

-- Hai chuỗi băm được tạo bằng PHP password_hash(..., PASSWORD_DEFAULT).
-- Thông tin đăng nhập mẫu được ghi trong README.md đi kèm.
INSERT INTO users (username, password) VALUES
('viet', '$2y$10$IkqHlI6r7Q.MV8h/QoqBTuo5PqweKQoDdFuOJ.xzS8ntbUGaNP3pa'),
('user01', '$2y$10$4iHC92Lm/oC/5nERJDt8T.5IE0oirdP/wl4GTc3FA8MUq0VsO3V5C')
ON DUPLICATE KEY UPDATE id = id;
