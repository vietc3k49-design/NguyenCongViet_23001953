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

function calculateAverageScore($students) {
    $sum = 0;
    $count = count($students);
    foreach ($students as $student) {
        $sum += $student['score'];
    }
    return $count > 0 ? $sum / $count : 0;
}


function getRank ($score) {
    if ($score >= 8) {
        return "Giỏi";
    }
    elseif ($score >= 6.5) {
        return "Khá";
    }
    elseif ($score >= 5) {
        return "Trung Bình";
    }
    else {
        return "Yếu";
    }
}



function displayStudent($student) {
    foreach ($student as $key => $value) {
        echo $key . " : " . $value . "\n";

    }
    echo "rank: " . getRank($student['score']) . "\n";
}

echo "DANH SÁCH SINH VIÊN: " . "\n";
foreach ($students as $student) {
    displayStudent($student);
    echo "-------------------------\n";
}

echo "Điểm trung bình của cả lớp: " . calculateAverageScore($students) . "\n";


?>


