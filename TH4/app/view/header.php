<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'Quản lý sản phẩm', ENT_QUOTES, 'UTF-8') ?></title>
</head>
<body>
    <header>
        <h1>Quản lý sản phẩm</h1>
        <nav>
            <a href="product_list.php">Danh sách sản phẩm</a> |
            <a href="product_add.php">Thêm sản phẩm</a>
        </nav>
        <?php if (!empty($_SESSION['user_id'])): ?>
            <p>
                Tài khoản: <?= htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8') ?> |
                <a href="logout.php">Đăng xuất</a>
            </p>
        <?php else: ?>
            <p><a href="login.php">Đăng nhập</a> | <a href="register.php">Đăng ký</a></p>
        <?php endif; ?>
    </header>
    <hr>
    <main>
