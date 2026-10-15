<?php
require_once __DIR__ . '/../common/dbConnect.php';

// Lấy tất cả sản phẩm, sản phẩm mới nhất hiển thị trước.
function getAllProducts()
{
    global $con;
    $stmt = $con->query('SELECT * FROM products ORDER BY id DESC');
    return $stmt->fetchAll();
}

// Trả về thông tin sản phẩm hoặc false nếu không tìm thấy.
function getProductById($id)
{
    global $con;
    $stmt = $con->prepare('SELECT * FROM products WHERE id = :id');
    $stmt->execute([':id' => $id]);
    return $stmt->fetch();
}

// Thêm sản phẩm sau khi dữ liệu đã được kiểm tra ở trang xử lý form.
function addProduct($name, $price, $quantity)
{
    global $con;
    $stmt = $con->prepare(
        'INSERT INTO products (name, price, quantity) VALUES (:name, :price, :quantity)'
    );
    return $stmt->execute([
        ':name' => $name,
        ':price' => $price,
        ':quantity' => $quantity,
    ]);
}

// Cập nhật tên, giá và số lượng của sản phẩm theo ID.
function updateProduct($id, $name, $price, $quantity)
{
    global $con;
    $stmt = $con->prepare(
        'UPDATE products SET name = :name, price = :price, quantity = :quantity WHERE id = :id'
    );
    return $stmt->execute([
        ':id' => $id,
        ':name' => $name,
        ':price' => $price,
        ':quantity' => $quantity,
    ]);
}

// Xóa sản phẩm theo ID; trang xử lý cần kiểm tra tồn tại và xác nhận trước.
function deleteProduct($id)
{
    global $con;
    $stmt = $con->prepare('DELETE FROM products WHERE id = :id');
    return $stmt->execute([':id' => $id]);
}
