<?php
class Student {
    public $name;
    public $age;
    public $score;

    public function __construct($name, $age, $score) {
        $this->name = $name;
        $this->age = $age;
        $this->score = $score;
    }

    public function getRank() {
        if ($this->score >= 8.0) {
            return "Giỏi";
        } elseif ($this->score >= 6.5) {
            return "Khá";
        } elseif ($this->score >= 5.0) {
            return "Trung bình";
        } else {
            return "Yếu";
        }
    }

    public function isPassed() {
        return $this->score >= 5.0;
    }

    public function display() {
        echo "Họ tên: " . $this->name 
           . " | Tuổi: " . $this->age 
           . " | Điểm: " . $this->score 
           . " | Xếp loại: " . $this->getRank()
           . " | Trạng thái: " . ($this->isPassed() ? "Đạt" : "Không đạt") . "\n";
    }
}

function findBestStudent($students) {
    if (empty($students)) return null;

    $best = $students[0];
    foreach ($students as $student) {
        if ($student->score > $best->score) {
            $best = $student;
        }
    }
    return $best;
}

function countPassedStudents($students) {
    $count = 0;
    foreach ($students as $student) {
        if ($student->isPassed()) {
            $count++;
        }
    }
    return $count;
}

function calculateClassAverage($students) {
    $count = count($students);
    if ($count === 0) return 0;

    $sum = 0;
    foreach ($students as $student) {
        $sum += $student->score;
    }
    return $sum / $count;
}

$student1 = new Student("Nguyen Van An", 20, 8.5);
$student2 = new Student("Tran Thi Binh", 21, 6.5);
$student3 = new Student("Le Van Cuong", 19, 4.5);
$student4 = new Student("Pham Thi Dung", 20, 7.5);

$students = [$student1, $student2, $student3, $student4];

echo "=== DANH SÁCH SINH VIÊN (OOP) ===\n";
foreach ($students as $student) {
    $student->display();
}

echo "------------------------------------------------------------\n";
echo "=== THỐNG KÊ LỚP HỌC ===\n";

$bestStudent = findBestStudent($students);
if ($bestStudent) {
    echo "1. Sinh viên có điểm cao nhất: " . $bestStudent->name . " (" . $bestStudent->score . " điểm)\n";
}

$passedCount = countPassedStudents($students);
echo "2. Số sinh viên đạt: " . $passedCount . "/" . count($students) . " sinh viên\n";

$classAverage = calculateClassAverage($students);
echo "3. Điểm trung bình của lớp: " . round($classAverage, 2) . " điểm\n";

?>
