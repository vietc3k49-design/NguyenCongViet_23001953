<?php

/**
 * Chuẩn hóa kiểu dữ liệu cho một bản ghi sản phẩm trước khi trả JSON.
 */
function formatProductRow(array $row): array
{
    $image = $row['image'] ?? null;

    return [
        'id' => (int) $row['id'],
        'name' => (string) $row['name'],
        'price' => (int) $row['price'],
        'stock' => (int) $row['stock'],
        'image' => ($image !== null && $image !== '') ? (string) $image : null,
    ];
}

/**
 * Đếm tổng số sản phẩm hiện có trong bảng products.
 */
function countProducts(PDO $con): int
{
    $stmt = $con->query('SELECT COUNT(*) FROM products');

    return (int) $stmt->fetchColumn();
}

/**
 * Lấy danh sách sản phẩm phân trang theo thứ tự id giảm dần.
 *
 * @return array{items: array<int, array>, pagination: array{page: int, limit: int, total: int, total_pages: int}}
 */
function getPaginatedProducts(PDO $con, int $page, int $limit): array
{
    $total = countProducts($con);
    $totalPages = max(1, (int) ceil($total / $limit));
    $actualPage = max(1, min($page, $totalPages));
    $offset = ($actualPage - 1) * $limit;

    $stmt = $con->prepare(
        'SELECT id, name, price, stock, image FROM products ORDER BY id DESC LIMIT :limit OFFSET :offset'
    );
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $rows = $stmt->fetchAll();

    return [
        'items' => array_map('formatProductRow', $rows),
        'pagination' => [
            'page' => $actualPage,
            'limit' => $limit,
            'total' => $total,
            'total_pages' => $totalPages,
        ],
    ];
}

/**
 * Tìm một sản phẩm theo ID, trả về null nếu không tồn tại.
 */
function getProductById(PDO $con, int $id): ?array
{
    $stmt = $con->prepare('SELECT id, name, price, stock, image FROM products WHERE id = :id');
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
        'image' => null,
    ];
}

/**
 * Cập nhật thông tin sản phẩm (giữ nguyên cột image) và trả về bản ghi sau cập nhật.
 */
function updateProduct(PDO $con, int $id, string $name, int $price, int $stock): ?array
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

    return getProductById($con, $id);
}

/**
 * Cập nhật đường dẫn ảnh đại diện cho sản phẩm theo ID và trả về bản ghi sau cập nhật.
 */
function updateProductImage(PDO $con, int $id, string $imagePath): ?array
{
    $stmt = $con->prepare(
        'UPDATE products SET image = :image WHERE id = :id'
    );
    $stmt->execute([
        ':id' => $id,
        ':image' => $imagePath,
    ]);

    return getProductById($con, $id);
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
