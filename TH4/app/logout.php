<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Xóa toàn bộ thông tin của phiên đăng nhập.
$_SESSION = [];

// Xóa cookie phiên trên trình duyệt.
if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', [
        'expires' => time() - 42000,
        'path' => $params['path'],
        'domain' => $params['domain'],
        'secure' => $params['secure'],
        'httponly' => $params['httponly'],
        'samesite' => $params['samesite'],
    ]);
}

session_destroy();
header('Location: login.php', true, 303);
exit;
