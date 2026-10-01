-- BÀI 1 – QUẢN LÝ GIỎ HÀNG

-- 1. Tạo bảng cart_items
CREATE TABLE cart_items (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    quantity INT NOT NULL
);


-- 1. Thêm ít nhất 5 sản phẩm vào bảng
INSERT INTO cart_items (name, price, quantity) VALUES
('Chuột không dây Logitech', 250000.00, 3),
('Bàn phím cơ DareU', 650000.00, 2),
('Lót chuột Gaming cỡ lớn', 50000.00, 10),
('Cáp sạc nhanh Type-C', 80000.00, 8),
('Tai nghe Gaming chụp tai', 450000.00, 1),
('USB 64GB Kingston 3.2', 120000.00, 6);

-- 2. Hiển thị toàn bộ sản phẩm
SELECT * FROM cart_items;

-- 3. Hiển thị sản phẩm có giá lớn hơn 100000
SELECT * FROM cart_items 
WHERE price > 100000;

-- 4. Hiển thị sản phẩm có số lượng lớn hơn 5
SELECT * FROM cart_items 
WHERE quantity > 5;

-- 5. Sắp xếp sản phẩm theo giá giảm dần
SELECT * FROM cart_items 
ORDER BY price DESC;

-- 6. Cập nhật giá của một sản phẩm
UPDATE cart_items 
SET price = 280000.00 
WHERE id = 1;

-- 7. Cập nhật số lượng của một sản phẩm
UPDATE cart_items 
SET quantity = 5 
WHERE id = 2;

-- 8. Xóa một sản phẩm
DELETE FROM cart_items 
WHERE id = 5;

-- 9. Hiển thị tên sản phẩm, giá, số lượng và thành tiền (price × quantity)
SELECT 
    name, 
    price, 
    quantity, 
    (price * quantity) AS total_price
FROM cart_items;

-- 10. Tính tổng tiền của toàn bộ giỏ hàng
SELECT 
    SUM(price * quantity) AS grand_total
FROM cart_items;