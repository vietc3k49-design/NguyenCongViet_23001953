<?php
// 1. Nhúng Model để lấy dữ liệu sản phẩm
require_once __DIR__ . '/model/product.php';

// 2. Lấy danh sách sản phẩm
$products = getAllProducts();

$pageTitle = "Danh sách sản phẩm";
// 3. Nhúng phần đầu trang
require_once __DIR__ . '/view/header.php';
?>

<h2>Danh sách sản phẩm</h2>
<p>
    <a href="product_add.php">+ Thêm sản phẩm mới</a>
</p>

<!-- Bảng hiển thị sản phẩm sử dụng table HTML cơ bản -->
<table border="1" cellpadding="8" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên sản phẩm</th>
            <th>Giá</th>
            <th>Số lượng</th>
            <th>Chức năng</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $p): ?>
                <tr>
                    <td><?php echo $p['id']; ?></td>
                    <td><?php echo htmlspecialchars($p['name']); ?></td>
                    <td><?php echo number_format($p['price'], 0, ',', '.'); ?> đ</td>
                    <td><?php echo $p['quantity']; ?></td>
                    <td>
                        <a href="product_edit.php?id=<?php echo $p['id']; ?>">Sửa</a> | 
                        <a href="product_delete.php?id=<?php echo $p['id']; ?>" 
                           onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?');">Xóa</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5" align="center">Chưa có sản phẩm nào.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?php
// 4. Nhúng phần chân trang
require_once __DIR__ . '/view/footer.php';
?>
