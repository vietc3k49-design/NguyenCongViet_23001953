<?php

/**
 * Chuẩn hóa kiểu dữ liệu số nguyên cho một bản ghi sản phẩm trước khi trả JSON.
 */
function formatProductRow(array $row): array
{
    return [
        'id' => (int) $row['id'],
        'name' => (string) $row['name'],
        'price' => (int) $row['price'],
        'stock' => (int) $row['stock'],
    ];
}

/**
 * Lấy toàn bộ danh sách sản phẩm theo thứ tự id tăng dần.
 */
function getAllProducts(PDO $con): array
{
    $stmt = $con->query('SELECT id, name, price, stock FROM products ORDER BY id ASC');
    $rows = $stmt->fetchAll();

    return array_map('formatProductRow', $rows);
}

/**
 * Tìm một sản phẩm theo ID, trả về null nếu không tồn tại.
 */
function getProductById(PDO $con, int $id): ?array
{
    $stmt = $con->prepare('SELECT id, name, price, stock FROM products WHERE id = :id');
    $stmt->execute([':id' => $id]);
    $row = $stmt->fetch();

    return $row === false ? null : formatProductRow($row);
}

/**
 * Thêm sản phẩm mới vào database và trả về bản ghi vừa tạo.
 */
function addProduct(PDO $con, string $name, int $price, int $stock): array
{
    $stmt = $con->prepare(
        'INSERT INTO products (name, price, stock) VALUES (:name, :price, :stock)'
    );
    $stmt->execute([
        ':name' => $name,
        ':price' => $price,
        ':stock' => $stock,
    ]);

    $id = (int) $con->lastInsertId();

    return [
        'id' => $id,
        'name' => $name,
        'price' => $price,
        'stock' => $stock,
    ];
}

/**
 * Cập nhật thông tin sản phẩm theo ID và trả về bản ghi sau cập nhật.
 */
function updateProduct(PDO $con, int $id, string $name, int $price, int $stock): array
{
    $stmt = $con->prepare(
        'UPDATE products SET name = :name, price = :price, stock = :stock WHERE id = :id'
    );
    $stmt->execute([
        ':id' => $id,
        ':name' => $name,
        ':price' => $price,
        ':stock' => $stock,
    ]);

    return [
        'id' => $id,
        'name' => $name,
        'price' => $price,
        'stock' => $stock,
    ];
}

/**
 * Xóa sản phẩm theo ID và trả về true nếu có dòng bị xóa.
 */
function deleteProduct(PDO $con, int $id): bool
{
    $stmt = $con->prepare('DELETE FROM products WHERE id = :id');
    $stmt->execute([':id' => $id]);

    return $stmt->rowCount() > 0;
}
