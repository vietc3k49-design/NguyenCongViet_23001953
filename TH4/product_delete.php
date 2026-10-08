<?php
ob_start();

// 1. Nhúng Model
require_once __DIR__ . '/model/product.php';

// 2. Lấy ID sản phẩm cần xóa từ URL
$id = $_GET['id'] ?? null;

// Kiểm tra ID có hợp lệ không
if (!$id || !is_numeric($id)) {
    die("ID sản phẩm không hợp lệ! <a href='product_list.php'>Quay lại danh sách</a>");
}

// 3. Kiểm tra sản phẩm có tồn tại trong CSDL hay không theo yêu cầu đề bài
$product = getProductById((int)$id);

if (!$product) {
    // Nếu sản phẩm không tồn tại, hiển thị thông báo phù hợp
    die("Lỗi: Sản phẩm không tồn tại hoặc đã bị xóa trước đó! <br><br><a href='product_list.php'>Quay lại danh sách</a>");
}

// 4. Thực hiện xóa sản phẩm
$isDeleted = deleteProduct((int)$id);

if ($isDeleted) {
    // Xóa xong chuyển hướng ngay về trang danh sách
    header("Location: product_list.php");
    exit();
} else {
    echo "Xóa sản phẩm thất bại! <a href='product_list.php'>Quay lại danh sách</a>";
}
?>
