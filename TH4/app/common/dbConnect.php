<?php
// Thông số kết nối MySQL trên XAMPP.
$host = 'localhost';
$dbname = 'shopping_cart';
$username = 'root';
$password = '';

try {
    // Các file khác dùng lại biến $con để truy vấn database.
    $con = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );
} catch (PDOException $e) {
    error_log('Lỗi kết nối database: ' . $e->getMessage());
    http_response_code(500);
    exit('Không thể kết nối cơ sở dữ liệu. Vui lòng kiểm tra MySQL và cấu hình kết nối.');
}
