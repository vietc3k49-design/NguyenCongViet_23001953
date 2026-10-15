<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Không lưu trang quản lý vào bộ nhớ đệm sau khi đăng xuất.
header('Cache-Control: no-store');

if (empty($_SESSION['user_id'])) {
    header('Location: login.php', true, 303);
    exit;
}
