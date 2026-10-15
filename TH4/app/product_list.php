<?php
require_once __DIR__ . '/common/auth.php';
require_once __DIR__ . '/model/product.php';

$products = getAllProducts();
$pageTitle = 'Danh sách sản phẩm';
require __DIR__ . '/view/header.php';
?>

<h2>Danh sách sản phẩm</h2>
<p><a href="product_add.php">Thêm sản phẩm mới</a></p>

<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên sản phẩm</th>
            <th>Giá (VNĐ)</th>
            <th>Số lượng</th>
            <th>Chức năng</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($products)): ?>
            <tr>
                <td colspan="5">Chưa có sản phẩm nào.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= (int) $product['id'] ?></td>
                    <td><?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= number_format((float) $product['price'], 2, ',', '.') ?></td>
                    <td><?= (int) $product['quantity'] ?></td>
                    <td>
                        <a href="product_edit.php?id=<?= (int) $product['id'] ?>">Sửa</a> |
                        <a href="product_delete.php?id=<?= (int) $product['id'] ?>">Xóa</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<?php require __DIR__ . '/view/footer.php'; ?>
