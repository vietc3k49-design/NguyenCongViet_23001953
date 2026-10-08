<?php
// Bật bộ đệm đầu ra để header chuyển trang mượt mà
ob_start();

// 1. Nhúng Model
require_once __DIR__ . '/model/product.php';

$errors = [];
$name = '';
$price = '';
$quantity = '';

// 2. Xử lý khi người dùng nhấn nút "Lưu sản phẩm" (Gửi POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $price = trim($_POST['price'] ?? '');
    $quantity = trim($_POST['quantity'] ?? '');

    // Kiểm tra dữ liệu theo đúng yêu cầu đề bài
    if (empty($name)) {
        $errors[] = "Tên sản phẩm không được để rỗng.";
    }

    if (!is_numeric($price) || (float)$price <= 0) {
        $errors[] = "Giá sản phẩm phải là số lớn hơn 0.";
    }

    if (!is_numeric($quantity) || (int)$quantity < 0) {
        $errors[] = "Số lượng sản phẩm phải là số nguyên lớn hơn hoặc bằng 0.";
    }

    // Nếu không có lỗi nào, thực hiện thêm vào CSDL
    if (empty($errors)) {
        $isAdded = addProduct($name, (float)$price, (int)$quantity);
        if ($isAdded) {
            // Chuyển hướng về trang danh sách
            header("Location: product_list.php");
            exit();
        } else {
            $errors[] = "Có lỗi xảy ra khi lưu vào cơ sở dữ liệu.";
        }
    }
}

$pageTitle = "Thêm sản phẩm mới";
// 3. Nhúng phần đầu trang
require_once __DIR__ . '/view/header.php';
?>

<h2>Thêm sản phẩm mới</h2>
<p><a href="product_list.php">⬅ Quay lại danh sách</a></p>

<!-- Hiển thị thông báo lỗi nếu có -->
<?php if (!empty($errors)): ?>
    <div style="color: red; border: 1px solid red; padding: 10px; margin-bottom: 15px;">
        <ul>
            <?php foreach ($errors as $err): ?>
                <li><?php echo $err; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<!-- Form nhập dữ liệu HTML cơ bản -->
<form method="POST" action="product_add.php">
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
                <button type="submit">Lưu sản phẩm</button>
                <a href="product_list.php"><button type="button">Hủy</button></a>
            </td>
        </tr>
    </table>
</form>

<?php
// 4. Nhúng phần chân trang
require_once __DIR__ . '/view/footer.php';
?>
