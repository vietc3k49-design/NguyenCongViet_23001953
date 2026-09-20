<?php
$students = [
    [
        "name" => "Nguyen Van An",
        "age" => 20,
        "score" => 8.5
    ],
    [
        "name" => "Tran Thi Binh",
        "age" => 21,
        "score" => 6.5
    ],
    [
        "name" => "Le Van Cuong",
        "age" => 19,
        "score" => 4.5
    ],
    [
        "name" => "Pham Thi Dung",
        "age" => 20,
        "score" => 7.5
    ]
];

$newline = (php_sapi_name() === 'cli') ? "\n" : "<br>";

echo "Danh sách sinh viên" . $newline;

$sum = 0;
$count = 0;

foreach ($students as $student) {

    echo "Họ tên: " . $student['name'] 
       . " | Tuổi: " . $student['age'] 
       . " | Điểm: " . $student['score'] 
       . $newline;

    $sum += $student['score'];
    $count++;
}

echo "" . $newline;
if ($count > 0) {
    $average = $sum / $count;
    echo "Tổng số sinh viên: " . $count . $newline;
    echo "Điểm trung bình của cả lớp: " . $average . $newline;

}
?>


