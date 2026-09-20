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

function findBestStudent($students) {
    if (empty($students)) return null;

    $best = $students[0];
    foreach ($students as $student) {
        if ($student['score'] > $best['score']) {
            $best = $student;
        }
    }
    return $best;
}

function  findWorstStudent($students) {
    if (empty($students)) return null;

    $worst = $students[0];
    foreach ($students as $student) {
        if ($student['score'] < $worst['score']) {
            $worst = $student;
        }
    }
    return $worst;
}

function countPassedStudents($students) {
    $count = 0;
    foreach ($students as $student) {
        if ($student['score'] >= 5) {
            $count++;
        }
    }
    return $count;
}

function findStudentByName($students, $name) {
    foreach ($students as $student) {
        if ($student['name'] == $name) {
            return $student;
        }
    }
    return null;
}

echo " KẾT QUẢ XỬ LÝ DANH SÁCH SINH VIÊN: " . "\n";

$bestStudent = findBestStudent($students);
if ($bestStudent) {
    echo "1. Sinh viên có điểm cao nhất: " . $bestStudent['name'] 
       . " (" . $bestStudent['score'] . " điểm)" . "\n";
}


$worstStudent = findWorstStudent($students);
if ($worstStudent) {
    echo "2. Sinh viên có điểm thấp nhất: " . $worstStudent['name'] 
       . " (" . $worstStudent['score'] . " điểm)" . "\n";
}

$passedCount = countPassedStudents($students);
echo "3. Số sinh viên đạt (điểm >= 5): " . $passedCount . "/" . count($students) . " sinh viên" . "\n";

$searchName = "Tran Thi Binh";
$foundStudent = findStudentByName($students, $searchName);
echo "4. Tìm kiếm sinh viên theo tên '" . $searchName . "':" . "\n";
if ($foundStudent) {
    echo "   -> Tìm thấy: " . $foundStudent['name'] 
       . " | Tuổi: " . $foundStudent['age'] 
       . " | Điểm: " . $foundStudent['score'] . "\n";
} else {
    echo "   -> Không tìm thấy sinh viên có tên '" . $searchName . "'" . "\n";
}

?>


