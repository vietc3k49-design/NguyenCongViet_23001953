<?php
require_once __DIR__ . '/common/auth.php';
require_once __DIR__ . '/model/product.php';

$id = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT, [
    'options' => ['min_range' => 1],
]);
$product = $id !== false ? getProductById($id) : false;

if ($product === false) {
    http_response_code(404);
    $pageTitle = 'Không tìm thấy sản phẩm';
    require __DIR__ . '/view/header.php';
    echo '<p role="alert">Sản phẩm không tồn tại hoặc ID không hợp lệ.</p>';
    echo '<p><a href="product_list.php">Quay lại danh sách</a></p>';
    require __DIR__ . '/view/footer.php';
    return;
}

// Token xác nhận gắn với phiên trình duyệt để bảo vệ thao tác xóa.
if (empty($_SESSION['delete_token'])) {
    $_SESSION['delete_token'] = bin2hex(random_bytes(32));
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'] ?? null;
    if (!is_string($token) || !hash_equals($_SESSION['delete_token'], $token)
        || ($_POST['confirm'] ?? null) !== 'yes') {
        http_response_code(403);
        $error = 'Xác nhận không hợp lệ. Vui lòng thử lại từ form bên dưới.';
    } else {
        try {
            if (deleteProduct($id)) {
                unset($_SESSION['delete_token']);
                header('Location: product_list.php');
                exit;
            }
            $error = 'Không thể xóa sản phẩm. Vui lòng thử lại.';
        } catch (PDOException $e) {
            error_log('Lỗi xóa sản phẩm: ' . $e->getMessage());
            $error = 'Không thể xóa sản phẩm. Vui lòng thử lại.';
        }
    }
}

$pageTitle = 'Xóa sản phẩm';
require __DIR__ . '/view/header.php';
?>

<h2>Xác nhận xóa sản phẩm</h2>
<?php if ($error !== ''): ?>
    <p role="alert"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
<?php endif; ?>

<p>Bạn có chắc chắn muốn xóa sản phẩm sau không?</p>
<ul>
    <li>ID: <?= (int) $product['id'] ?></li>
    <li>Tên: <?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?></li>
    <li>Giá: <?= number_format((float) $product['price'], 2, ',', '.') ?> VNĐ</li>
    <li>Số lượng: <?= (int) $product['quantity'] ?></li>
</ul>

<form method="post" action="product_delete.php?id=<?= (int) $id ?>">
    <input type="hidden" name="token" value="<?= htmlspecialchars($_SESSION['delete_token'], ENT_QUOTES, 'UTF-8') ?>">
    <button type="submit" name="confirm" value="yes">Xác nhận xóa</button>
    <a href="product_list.php">Hủy, quay lại danh sách</a>
</form>

<?php require __DIR__ . '/view/footer.php'; ?>
