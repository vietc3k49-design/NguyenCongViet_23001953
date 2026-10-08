<?php
// 1. Nhúng file kết nối CSDL (lấy biến $con)
require_once __DIR__ . '/../common/dbConnect.php';

/**
 * 2. Lấy danh sách toàn bộ sản phẩm
 * @return array Danh sách các sản phẩm (mới nhất xếp lên trước)
 */
function getAllProducts() {
    global $con;
    $sql = "SELECT * FROM products ORDER BY id DESC";
    $stmt = $con->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
}

/**
 * 3. Lấy thông tin chi tiết một sản phẩm theo ID
 * @param int $id ID của sản phẩm cần tìm
 * @return array|false Mảng dữ liệu sản phẩm hoặc false nếu không tìm thấy
 */
function getProductById($id) {
    global $con;
    $sql = "SELECT * FROM products WHERE id = :id";
    $stmt = $con->prepare($sql);
    $stmt->execute([':id' => $id]);
    return $stmt->fetch();
}

/**
 * 4. Thêm sản phẩm mới vào CSDL
 * @param string $name Tên sản phẩm
 * @param float $price Giá sản phẩm
 * @param int $quantity Số lượng
 * @return bool True nếu thêm thành công, ngược lại False
 */
function addProduct($name, $price, $quantity) {
    global $con;
    $sql = "INSERT INTO products (name, price, quantity) VALUES (:name, :price, :quantity)";
    $stmt = $con->prepare($sql);
    return $stmt->execute([
        ':name'     => $name,
        ':price'    => $price,
        ':quantity' => $quantity
    ]);
}

/**
 * 5. Cập nhật thông tin sản phẩm
 * @param int $id ID sản phẩm cần cập nhật
 * @param string $name Tên mới
 * @param float $price Giá mới
 * @param int $quantity Số lượng mới
 * @return bool True nếu cập nhật thành công, ngược lại False
 */
function updateProduct($id, $name, $price, $quantity) {
    global $con;
    $sql = "UPDATE products SET name = :name, price = :price, quantity = :quantity WHERE id = :id";
    $stmt = $con->prepare($sql);
    return $stmt->execute([
        ':id'       => $id,
        ':name'     => $name,
        ':price'    => $price,
        ':quantity' => $quantity
    ]);
}

/**
 * 6. Xóa sản phẩm theo ID
 * @param int $id ID sản phẩm cần xóa
 * @return bool True nếu xóa thành công, ngược lại False
 */
function deleteProduct($id) {
    global $con;
    $sql = "DELETE FROM products WHERE id = :id";
    $stmt = $con->prepare($sql);
    return $stmt->execute([':id' => $id]);
}
?>
