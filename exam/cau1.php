<?php
header('Content-Type: text/html; charset=utf-8');

// Dữ liệu mẫu bao phủ cả bốn mức xếp loại và các mốc chuyển mức.
$students = [
    ['name' => 'An', 'score' => 10],
    ['name' => 'Bình', 'score' => 8],
    ['name' => 'Chi', 'score' => 7.9],
    ['name' => 'Dũng', 'score' => 6.5],
    ['name' => 'Hà', 'score' => 6.4],
    ['name' => 'Linh', 'score' => 5],
    ['name' => 'Minh', 'score' => 4.9],
    ['name' => 'Nam', 'score' => 0],
];

echo '<h1>Xếp loại học sinh</h1>';

foreach ($students as $student) {
    // Khai báo biến tên và điểm cho từng học sinh.
    $name = $student['name'];
    $score = $student['score'];

    // Xét từ cao xuống thấp: nhánh sau chỉ chạy khi nhánh trước sai.
    if ($score >= 8) {
        $rank = 'Giỏi';
    } elseif ($score >= 6.5) {
        $rank = 'Khá';
    } elseif ($score >= 5) {
        $rank = 'Trung bình';
    } else {
        $rank = 'Yếu';
    }

    // Hiển thị đầy đủ thông tin của từng học sinh.
    echo "Tên học sinh: $name<br>";
    echo "Điểm: $score<br>";
    echo "Xếp loại: $rank<hr>";
}
