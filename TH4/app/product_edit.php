<?php
require_once __DIR__ . '/common/auth.php';
require_once __DIR__ . '/model/product.php';

// Chỉ chấp nhận ID là số nguyên dương.
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

$name = $product['name'];
$price = $product['price'];
$quantity = (string) $product['quantity'];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Chỉ nhận giá trị chuỗi từ form, tránh dữ liệu mảng không hợp lệ.
    $name = is_string($_POST['name'] ?? null) ? trim($_POST['name']) : '';
    $price = is_string($_POST['price'] ?? null) ? trim($_POST['price']) : '';
    $quantity = is_string($_POST['quantity'] ?? null) ? trim($_POST['quantity']) : '';

    if ($name === '') {
        $errors[] = 'Tên sản phẩm không được để trống.';
    } elseif (mb_strlen($name, 'UTF-8') > 100) {
        $errors[] = 'Tên sản phẩm không được vượt quá 100 ký tự.';
    }

    // Bảng products lưu giá theo DECIMAL(10,2).
    if (!preg_match('/^[0-9]+(?:\.[0-9]{1,2})?$/D', $price)
        || (float) $price <= 0 || (float) $price > 99999999.99) {
        $errors[] = 'Giá phải lớn hơn 0, không vượt quá 99999999.99 và có tối đa 2 chữ số thập phân.';
    }

    $validQuantity = filter_var($quantity, FILTER_VALIDATE_INT, [
        'options' => ['min_range' => 0, 'max_range' => 2147483647],
    ]);
    if ($validQuantity === false) {
        $errors[] = 'Số lượng phải là số nguyên từ 0 đến 2147483647.';
    }

    if (empty($errors)) {
        try {
            if (updateProduct($id, $name, $price, $validQuantity)) {
                header('Location: product_list.php');
                exit;
            }
            $errors[] = 'Không thể cập nhật sản phẩm. Vui lòng thử lại.';
        } catch (PDOException $e) {
            error_log('Lỗi cập nhật sản phẩm: ' . $e->getMessage());
            $errors[] = 'Không thể cập nhật sản phẩm. Vui lòng thử lại.';
        }
    }
}

$pageTitle = 'Sửa sản phẩm';
require __DIR__ . '/view/header.php';
?>

<h2>Sửa sản phẩm</h2>

<?php if (!empty($errors)): ?>
    <ul role="alert">
        <?php foreach ($errors as $error): ?>
            <li><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form method="post" action="product_edit.php?id=<?= (int) $id ?>">
    <p>
        <label for="name">Tên sản phẩm:</label><br>
        <input type="text" id="name" name="name" maxlength="100" required
               value="<?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?>">
    </p>
    <p>
        <label for="price">Giá (VNĐ):</label><br>
        <input type="number" id="price" name="price" min="0.01" max="99999999.99" step="0.01" required
               value="<?= htmlspecialchars($price, ENT_QUOTES, 'UTF-8') ?>">
    </p>
    <p>
        <label for="quantity">Số lượng:</label><br>
        <input type="number" id="quantity" name="quantity" min="0" max="2147483647" step="1" required
               value="<?= htmlspecialchars($quantity, ENT_QUOTES, 'UTF-8') ?>">
    </p>
    <button type="submit">Lưu thay đổi</button>
    <a href="product_list.php">Quay lại danh sách</a>
</form>

<?php require __DIR__ . '/view/footer.php'; ?>
