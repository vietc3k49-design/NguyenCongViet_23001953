<?php
ob_start();

// 1. Nhúng Model
require_once __DIR__ . '/model/product.php';

// 2. Lấy ID sản phẩm từ URL ($_GET) hoặc form ($_POST)
$id = $_GET['id'] ?? $_POST['id'] ?? null;

if (!$id || !is_numeric($id)) {
    die("ID sản phẩm không hợp lệ! <a href='product_list.php'>Quay lại</a>");
}

// 3. Lấy thông tin hiện tại của sản phẩm trong CSDL
$product = getProductById((int)$id);

if (!$product) {
    die("Không tìm thấy sản phẩm có ID = $id! <a href='product_list.php'>Quay lại</a>");
}

$errors = [];
$name = $product['name'];
$price = $product['price'];
$quantity = $product['quantity'];

// 4. Xử lý khi nhấn nút "Cập nhật sản phẩm" (Gửi POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $price = trim($_POST['price'] ?? '');
    $quantity = trim($_POST['quantity'] ?? '');

    // Kiểm tra tính hợp lệ của dữ liệu
    if (empty($name)) {
        $errors[] = "Tên sản phẩm không được để rỗng.";
    }

    if (!is_numeric($price) || (float)$price <= 0) {
        $errors[] = "Giá sản phẩm phải là số lớn hơn 0.";
    }

    if (!is_numeric($quantity) || (int)$quantity < 0) {
        $errors[] = "Số lượng sản phẩm phải là số nguyên lớn hơn hoặc bằng 0.";
    }

    // Nếu không có lỗi, cập nhật vào CSDL
    if (empty($errors)) {
        $isUpdated = updateProduct((int)$id, $name, (float)$price, (int)$quantity);
        if ($isUpdated) {
            header("Location: product_list.php");
            exit();
        } else {
            $errors[] = "Cập nhật sản phẩm thất bại.";
        }
    }
}

$pageTitle = "Chỉnh sửa sản phẩm";
// 5. Nhúng phần đầu trang
require_once __DIR__ . '/view/header.php';
?>

<h2>Chỉnh sửa sản phẩm (ID: <?php echo $product['id']; ?>)</h2>
<p><a href="product_list.php">⬅ Quay lại danh sách</a></p>

<!-- Hiển thị lỗi nếu có -->
<?php if (!empty($errors)): ?>
    <div style="color: red; border: 1px solid red; padding: 10px; margin-bottom: 15px;">
        <ul>
            <?php foreach ($errors as $err): ?>
                <li><?php echo $err; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<!-- Form sửa thông tin sản phẩm -->
<form method="POST" action="product_edit.php">
    <!-- Trường ẩn lưu ID sản phẩm -->
    <input type="hidden" name="id" value="<?php echo $product['id']; ?>">

    <table cellpadding="6" cellspacing="0">
        <tr>
            <td><label for="name"><strong>Tên sản phẩm:</strong></label></td>
            <td><input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required size="40"></td>
        </tr>
        <tr>
            <td><label for="price"><strong>Giá (VNĐ):</strong></label></td>
            <td><input type="number" id="price" name="price" step="0.01" value="<?php echo htmlspecialchars($price); ?>" required size="40"></td>
        </tr>
        <tr>
            <td><label for="quantity"><strong>Số lượng:</strong></label></td>
            <td><input type="number" id="quantity" name="quantity" value="<?php echo htmlspecialchars($quantity); ?>" required size="40"></td>
        </tr>
        <tr>
            <td></td>
            <td>
                <button type="submit">Cập nhật sản phẩm</button>
                <a href="product_list.php"><button type="button">Hủy</button></a>
            </td>
        </tr>
    </table>
</form>

<?php
// 6. Nhúng phần chân trang
require_once __DIR__ . '/view/footer.php';
?>
