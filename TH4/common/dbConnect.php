<?php
//1. Cấu hình thông số kết nối Database
$host = 'localhost';
$dbname = 'shopping_cart';
$username = 'root';
$password = '';

try {
    // 2. Tạo kết nối bảng PDO với charset utf8mb4 (hỗ trợ tiếng Việt đầy đủ)
    $con = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

    // 3. Thiết lập chế độ báo lỗi PDO để bắt lỗi SQL 
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 4. Thiết lập chế độ fetch mặc định dạng mảng kết hợp (Associative Array)
    $con->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // 5. Thông báo kết nối thành công (Có thể bỏ qua trong thực tế)
    // echo "Kết nối đến database thành công!";

} catch (PDOException $e) {
    // 6. Xử lý lỗi khi kết nối thất bại 
    die("Lỗi kết nối database: " . $e->getMessage()); 
}

?>