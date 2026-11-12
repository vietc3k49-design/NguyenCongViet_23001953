<?php

/**
 * Tạo kết nối PDO tới database TH8 và ném ngoại lệ nếu lỗi để API trả về JSON.
 */
function getDbConnection(): PDO
{
    $host = 'localhost';
    $dbname = 'th8_products';
    $username = 'root';
    $password = '';

    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    $con = new PDO($dsn, $username, $password, $options);
    // Bật strict mode cho phiên làm việc để MySQL không tự cắt dữ liệu nếu vượt giới hạn cột.
    $con->exec("SET NAMES utf8mb4, SESSION sql_mode = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION'");

    return $con;
}
