-- BÀI 2 – QUẢN LÝ VÉ XEM PHIM

-- 1. Tạo bảng movies
CREATE TABLE movies (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    total_seats INT NOT NULL,
    available_seats INT NOT NULL
);

-- 1. Thêm ít nhất 5 bộ phim
INSERT INTO movies (title, price, total_seats, available_seats) VALUES
('Mai', 110000.00, 100, 20),
('Đào, Phở và Piano', 80000.00, 120, 30),
('Lật Mặt 7: Một Điều Ước', 120000.00, 150, 10),
('Dune: Hành Tinh Cát 2', 150000.00, 100, 65),
('Kung Fu Panda 4', 90000.00, 80, 55),
('Godzilla x Kong', 130000.00, 100, 40);

-- 2. Hiển thị toàn bộ danh sách phim
SELECT * FROM movies;

-- 3. Hiển thị phim có giá vé lớn hơn 100000
SELECT * FROM movies 
WHERE price > 100000;

-- 4. Hiển thị phim còn nhiều hơn 50 ghế
SELECT * FROM movies 
WHERE available_seats > 50;

-- 5. Sắp xếp phim theo giá vé giảm dần
SELECT * FROM movies 
ORDER BY price DESC;

-- 6. Cập nhật số ghế còn lại của một phim
UPDATE movies 
SET available_seats = 15 
WHERE id = 1;

-- 7. Xóa một phim
DELETE FROM movies 
WHERE id = 5;

-- 8. Hiển thị số vé đã bán của từng phim: total_seats - available_seats
SELECT 
    title, 
    (total_seats - available_seats) AS sold_seats
FROM movies;

-- 9. Tính doanh thu của từng phim: (total_seats - available_seats) x price
SELECT 
    title, 
    (total_seats - available_seats) * price AS revenue
FROM movies;

-- 10. Tính tổng doanh thu của tất cả các phim
SELECT 
    SUM((total_seats - available_seats) * price) AS total_revenue
FROM movies;

-- 11. Tìm phim có số vé bán ra nhiều nhất
SELECT 
    title, 
    (total_seats - available_seats) AS sold_seats
FROM movies
WHERE (total_seats - available_seats) = (
    SELECT MAX(total_seats - available_seats) FROM movies
);
