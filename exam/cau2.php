<?php
header('Content-Type: text/html; charset=utf-8');

// Khai báo mảng chứa giá của 5 sản phẩm (đơn vị: đồng).
$prices = [120000, 85000, 250000, 99000, 175000];

// Tính tổng giá trị của tất cả sản phẩm.
function calculateTotal($prices)
{
    $total = 0;

    foreach ($prices as $price) {
        $total += $price;
    }

    return $total;
}

// Tìm giá cao nhất; trả về null nếu mảng không có sản phẩm.
function findMaxPrice($prices)
{
    $maxPrice = null;

    foreach ($prices as $price) {
        if ($maxPrice === null || $price > $maxPrice) {
            $maxPrice = $price;
        }
    }

    return $maxPrice;
}

// Gọi hai hàm và lưu kết quả trả về.
$total = calculateTotal($prices);
$maxPrice = findMaxPrice($prices);

echo '<h1>Danh sách giá sản phẩm</h1>';
foreach ($prices as $index => $price) {
    $productNumber = $index + 1;
    echo 'Sản phẩm ' . $productNumber . ': ' . number_format($price, 0, ',', '.') . ' đồng<br>';
}

echo '<hr>';
echo 'Tổng giá trị sản phẩm: ' . number_format($total, 0, ',', '.') . ' đồng<br>';
if ($maxPrice !== null) {
    echo 'Giá sản phẩm cao nhất: ' . number_format($maxPrice, 0, ',', '.') . ' đồng';
} else {
    echo 'Chưa có sản phẩm để tìm giá cao nhất.';
}
