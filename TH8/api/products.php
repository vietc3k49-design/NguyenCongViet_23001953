<?php

declare(strict_types=1);

// Tắt in lỗi HTML ra output để phản hồi luôn là JSON hợp lệ.
ini_set('display_errors', '0');

require_once __DIR__ . '/../common/dbConnect.php';
require_once __DIR__ . '/../model/product.php';

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
 * Đọc và giải mã dữ liệu JSON dạng object từ phần thân yêu cầu HTTP.
 */
function readJsonBody(): ?array
{
    $rawBody = file_get_contents('php://input');
    if ($rawBody === false || trim($rawBody) === '') {
        return null;
    }

    $decoded = json_decode($rawBody, true);
    if (json_last_error() !== JSON_ERROR_NONE || !is_array($decoded)) {
        return null;
    }

    // Từ chối mảng tuần tự như [1, 2, 3]; chỉ nhận JSON object có khóa tên trường.
    if ($decoded !== [] && array_is_list($decoded)) {
        return null;
    }

    return $decoded;
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
 * Kiểm tra tham số id trên query string (?id=...) là số nguyên dương hợp lệ.
 */
function parseQueryId(): ?int
{
    if (!array_key_exists('id', $_GET)) {
        return null;
    }

    return parseValidInt($_GET['id'], 1, 2147483647);
}

/**
 * Kiểm tra dữ liệu đầu vào (name, price, stock) cho thao tác thêm/cập nhật sản phẩm.
 *
 * @return array{ok: bool, message?: string, name?: string, price?: int, stock?: int}
 */
function validateProductInput(array $payload): array
{
    if (
        !array_key_exists('name', $payload) ||
        !array_key_exists('price', $payload) ||
        !array_key_exists('stock', $payload)
    ) {
        return [
            'ok' => false,
            'message' => 'Thiếu thông tin sản phẩm bắt buộc (name, price, stock).',
        ];
    }

    $rawName = $payload['name'];
    if (!is_string($rawName)) {
        return [
            'ok' => false,
            'message' => 'Tên sản phẩm phải là chuỗi ký tự hợp lệ.',
        ];
    }

    // Loại bỏ mọi khoảng trắng hai đầu (bao gồm khoảng trắng Unicode).
    $trimmedName = preg_replace('/^\s+|\s+$/u', '', $rawName);
    if ($trimmedName === null) {
        $trimmedName = trim($rawName);
    }

    $nameLength = mb_strlen($trimmedName, 'UTF-8');
    if ($nameLength < 1 || $nameLength > 100) {
        return [
            'ok' => false,
            'message' => 'Tên sản phẩm sau khi bỏ khoảng trắng hai đầu phải có từ 1 đến 100 ký tự.',
        ];
    }

    $price = parseValidInt($payload['price'], 1, 2147483647);
    if ($price === null) {
        return [
            'ok' => false,
            'message' => 'Đơn giá phải là số nguyên lớn hơn 0 (tối đa 2.147.483.647).',
        ];
    }

    $stock = parseValidInt($payload['stock'], 0, 2147483647);
    if ($stock === null) {
        return [
            'ok' => false,
            'message' => 'Số lượng tồn phải là số nguyên không âm (tối đa 2.147.483.647).',
        ];
    }

    return [
        'ok' => true,
        'name' => $trimmedName,
        'price' => $price,
        'stock' => $stock,
    ];
}

$method = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');

try {
    $con = getDbConnection();

    switch ($method) {
        case 'GET':
            $products = getAllProducts($con);
            sendJson(200, [
                'success' => true,
                'data' => $products,
            ]);

        case 'POST':
            $payload = readJsonBody();
            if ($payload === null) {
                sendJson(400, [
                    'success' => false,
                    'message' => 'Dữ liệu JSON không hợp lệ hoặc bị trống.',
                ]);
            }

            $validated = validateProductInput($payload);
            if (!$validated['ok']) {
                sendJson(400, [
                    'success' => false,
                    'message' => $validated['message'],
                ]);
            }

            $created = addProduct($con, $validated['name'], $validated['price'], $validated['stock']);
            sendJson(201, [
                'success' => true,
                'message' => 'Thêm sản phẩm thành công.',
                'data' => $created,
            ]);

        case 'PUT':
            $id = parseQueryId();
            if ($id === null) {
                sendJson(400, [
                    'success' => false,
                    'message' => 'Mã sản phẩm (id) trên URL không hợp lệ.',
                ]);
            }

            $payload = readJsonBody();
            if ($payload === null) {
                sendJson(400, [
                    'success' => false,
                    'message' => 'Dữ liệu JSON không hợp lệ hoặc bị trống.',
                ]);
            }

            $validated = validateProductInput($payload);
            if (!$validated['ok']) {
                sendJson(400, [
                    'success' => false,
                    'message' => $validated['message'],
                ]);
            }

            // Kiểm tra tồn tại trước khi cập nhật để không nhầm với trường hợp dữ liệu không đổi.
            if (getProductById($con, $id) === null) {
                sendJson(404, [
                    'success' => false,
                    'message' => 'Không tìm thấy sản phẩm cần cập nhật.',
                ]);
            }

            $updated = updateProduct($con, $id, $validated['name'], $validated['price'], $validated['stock']);
            sendJson(200, [
                'success' => true,
                'message' => 'Cập nhật sản phẩm thành công.',
                'data' => $updated,
            ]);

        case 'DELETE':
            $id = parseQueryId();
            if ($id === null) {
                sendJson(400, [
                    'success' => false,
                    'message' => 'Mã sản phẩm (id) trên URL không hợp lệ.',
                ]);
            }

            if (getProductById($con, $id) === null) {
                sendJson(404, [
                    'success' => false,
                    'message' => 'Không tìm thấy sản phẩm cần xóa.',
                ]);
            }

            deleteProduct($con, $id);
            sendJson(200, [
                'success' => true,
                'message' => 'Xóa sản phẩm thành công.',
            ]);

        default:
            header('Allow: GET, POST, PUT, DELETE');
            sendJson(405, [
                'success' => false,
                'message' => 'Phương thức HTTP không được hỗ trợ.',
            ]);
    }
} catch (Throwable $e) {
    error_log('Lỗi API products.php: ' . $e->getMessage());
    sendJson(500, [
        'success' => false,
        'message' => 'Đã xảy ra lỗi hệ thống. Vui lòng thử lại sau.',
    ]);
}
