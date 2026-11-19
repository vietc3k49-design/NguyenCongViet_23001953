<?php

declare(strict_types=1);

// Tắt in lỗi HTML ra output để phản hồi luôn là JSON hợp lệ.
ini_set('display_errors', '0');

require_once __DIR__ . '/../common/dbConnect.php';
require_once __DIR__ . '/../model/product.php';

const MAX_UPLOAD_SIZE_BYTES = 2097152; // 2 MB = 2 * 1024 * 1024 bytes.

/**
 * Gửi phản hồi JSON kèm mã trạng thái HTTP và kết thúc script.
 */
function sendJson(int $statusCode, array $payload): never
{
    http_response_code($statusCode);
    header('Content-Type: application/json; charset=utf-8');
    header('Cache-Control: no-store');

    echo json_encode($payload, JSON_UNESCAPED_UNICODE);
    exit;
}

/**
 * Kiểm tra và chuyển giá trị sang số nguyên nằm trong khoảng [min, max].
 */
function parseValidInt(mixed $value, int $min, int $max): ?int
{
    if (!is_int($value) && !is_string($value)) {
        return null;
    }

    if (is_string($value)) {
        $value = trim($value);
        if ($value === '') {
            return null;
        }
    }

    $parsed = filter_var($value, FILTER_VALIDATE_INT, [
        'options' => [
            'min_range' => $min,
            'max_range' => $max,
        ],
    ]);

    return $parsed === false ? null : $parsed;
}

/**
 * Kiểm tra tệp ảnh tải lên có hợp lệ (JPG/JPEG/PNG, <= 2 MB) và trả về đuôi tệp chuẩn.
 *
 * @return array{ok: bool, message?: string, tmp_name?: string, extension?: string}
 */
function validateUploadedImage(mixed $file): array
{
    if (
        !is_array($file) ||
        !isset($file['error'], $file['tmp_name'], $file['name'], $file['size']) ||
        !is_int($file['error'])
    ) {
        return [
            'ok' => false,
            'message' => 'Vui lòng chọn tệp ảnh để tải lên.',
        ];
    }

    $error = $file['error'];
    if ($error === UPLOAD_ERR_NO_FILE) {
        return [
            'ok' => false,
            'message' => 'Vui lòng chọn tệp ảnh để tải lên.',
        ];
    }

    if ($error === UPLOAD_ERR_INI_SIZE || $error === UPLOAD_ERR_FORM_SIZE) {
        return [
            'ok' => false,
            'message' => 'Dung lượng ảnh vượt quá giới hạn tối đa 2 MB.',
        ];
    }

    if ($error !== UPLOAD_ERR_OK) {
        return [
            'ok' => false,
            'message' => 'Tải tệp ảnh lên không thành công. Vui lòng thử lại.',
        ];
    }

    $tmpName = $file['tmp_name'];
    if (!is_string($tmpName) || $tmpName === '' || !is_uploaded_file($tmpName)) {
        return [
            'ok' => false,
            'message' => 'Tệp tải lên không hợp lệ.',
        ];
    }

    $fileSize = $file['size'];
    $actualSize = filesize($tmpName);
    if (!is_int($fileSize) || $fileSize <= 0 || $actualSize === false || $actualSize <= 0) {
        return [
            'ok' => false,
            'message' => 'Tệp ảnh không hợp lệ hoặc bị rỗng.',
        ];
    }

    if ($fileSize > MAX_UPLOAD_SIZE_BYTES || $actualSize > MAX_UPLOAD_SIZE_BYTES) {
        return [
            'ok' => false,
            'message' => 'Dung lượng ảnh vượt quá giới hạn tối đa 2 MB.',
        ];
    }

    $origName = is_string($file['name']) ? $file['name'] : '';
    $origExt = strtolower(pathinfo($origName, PATHINFO_EXTENSION));
    if (!in_array($origExt, ['jpg', 'jpeg', 'png'], true)) {
        return [
            'ok' => false,
            'message' => 'Chỉ chấp nhận tệp ảnh JPG, JPEG hoặc PNG hợp lệ dưới 2 MB.',
        ];
    }

    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = $finfo !== false ? finfo_file($finfo, $tmpName) : false;
    if ($finfo !== false) {
        finfo_close($finfo);
    }

    if (!is_string($mime) || !in_array($mime, ['image/jpeg', 'image/png'], true)) {
        return [
            'ok' => false,
            'message' => 'Chỉ chấp nhận tệp ảnh JPG, JPEG hoặc PNG hợp lệ dưới 2 MB.',
        ];
    }

    $info = @getimagesize($tmpName);
    if (
        $info === false ||
        !in_array($info[2], [IMAGETYPE_JPEG, IMAGETYPE_PNG], true) ||
        $info[0] <= 0 ||
        $info[1] <= 0
    ) {
        return [
            'ok' => false,
            'message' => 'Chỉ chấp nhận tệp ảnh JPG, JPEG hoặc PNG hợp lệ dưới 2 MB.',
        ];
    }

    $canonicalExt = $info[2] === IMAGETYPE_PNG ? 'png' : 'jpg';

    return [
        'ok' => true,
        'tmp_name' => $tmpName,
        'extension' => $canonicalExt,
    ];
}

/**
 * Xóa tệp ảnh cũ trong thư mục uploads nếu nằm hợp lệ bên trong thư mục đó.
 */
function deleteOldProductImage(mixed $oldImage, string $uploadsDir, string $currentRelativePath): void
{
    if (
        !is_string($oldImage) ||
        $oldImage === '' ||
        !str_starts_with($oldImage, 'uploads/') ||
        $oldImage === $currentRelativePath
    ) {
        return;
    }

    $uploadsRealPath = realpath($uploadsDir);
    $oldRealPath = realpath(__DIR__ . '/../' . $oldImage);
    if ($uploadsRealPath === false || $oldRealPath === false || !is_file($oldRealPath)) {
        return;
    }

    $uploadsPrefix = rtrim($uploadsRealPath, '/\\') . DIRECTORY_SEPARATOR;
    if (str_starts_with($oldRealPath, $uploadsPrefix)) {
        @unlink($oldRealPath);
    }
}

$method = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
if ($method !== 'POST') {
    header('Allow: POST');
    sendJson(405, [
        'success' => false,
        'message' => 'Phương thức HTTP không được hỗ trợ.',
    ]);
}

$rawProductId = $_POST['product_id'] ?? $_POST['id'] ?? null;
$productId = parseValidInt($rawProductId, 1, 2147483647);
if ($productId === null) {
    sendJson(400, [
        'success' => false,
        'message' => 'Mã sản phẩm (product_id) không hợp lệ.',
    ]);
}

try {
    $con = getDbConnection();
    $existingProduct = getProductById($con, $productId);
    if ($existingProduct === null) {
        sendJson(404, [
            'success' => false,
            'message' => 'Không tìm thấy sản phẩm để cập nhật ảnh.',
        ]);
    }

    $uploadedFile = $_FILES['image'] ?? $_FILES['file'] ?? null;
    $validatedImage = validateUploadedImage($uploadedFile);
    if (!$validatedImage['ok']) {
        sendJson(400, [
            'success' => false,
            'message' => $validatedImage['message'],
        ]);
    }

    $uploadsDir = __DIR__ . '/../uploads';
    if (!is_dir($uploadsDir) && !mkdir($uploadsDir, 0755, true) && !is_dir($uploadsDir)) {
        sendJson(500, [
            'success' => false,
            'message' => 'Không thể tạo thư mục lưu trữ ảnh.',
        ]);
    }

    $filename = 'product_' . $productId . '_' . bin2hex(random_bytes(8)) . '.' . $validatedImage['extension'];
    $relativePath = 'uploads/' . $filename;
    $destPath = $uploadsDir . DIRECTORY_SEPARATOR . $filename;

    if (!move_uploaded_file($validatedImage['tmp_name'], $destPath)) {
        sendJson(500, [
            'success' => false,
            'message' => 'Không thể lưu tệp ảnh đã tải lên.',
        ]);
    }

    try {
        $updatedProduct = updateProductImage($con, $productId, $relativePath);
    } catch (Throwable $dbException) {
        @unlink($destPath);
        error_log('Lỗi cập nhật ảnh sản phẩm trong upload.php: ' . $dbException->getMessage());
        sendJson(500, [
            'success' => false,
            'message' => 'Không thể cập nhật đường dẫn ảnh sản phẩm.',
        ]);
    }

    if ($updatedProduct === null) {
        @unlink($destPath);
        sendJson(404, [
            'success' => false,
            'message' => 'Không tìm thấy sản phẩm để cập nhật ảnh.',
        ]);
    }

    deleteOldProductImage($existingProduct['image'] ?? null, $uploadsDir, $relativePath);

    sendJson(200, [
        'success' => true,
        'message' => 'Upload ảnh sản phẩm thành công.',
        'data' => $updatedProduct,
    ]);
} catch (Throwable $e) {
    error_log('Lỗi API upload.php: ' . $e->getMessage());
    sendJson(500, [
        'success' => false,
        'message' => 'Đã xảy ra lỗi hệ thống. Vui lòng thử lại sau.',
    ]);
}
