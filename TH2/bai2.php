<?php
# Bài 2: Quản lý vé xem phim 

class Movie {
    public $id;
    public $title;
    public $price;
    public $totalSeats;
    public $availableSeats;

    public function __construct($id, $title, $price, $totalSeats) {
        $this->id = $id;
        $this->title = $title;
        $this->price = $price;
        $this->totalSeats = $totalSeats;
        $this->availableSeats = $totalSeats;
    }

    public function bookTickets($quantity) {
        if($quantity > $this->availableSeats || $quantity <= 0) {
            echo "Số lượng vé không hợp lệ" . "\n";
            return false;
        }
        $this->availableSeats -= $quantity;
        echo "Đã đặt $quantity vé thành công" . "\n";
        return true;
    }

    public function cancelTiket($quantity) {
        if($quantity <= 0 || $quantity > ($this->totalSeats - $this->availableSeats)) {
            echo "Số lượng vé không hợp lệ" . "\n";
            return false;
        }
        $this->availableSeats += $quantity;
        echo "Đã hủy $quantity vé thành công" . "\n";
        return true;
    }
    
    public function getSoldSeats() {
        return $this->totalSeats - $this->availableSeats;
    }

    public function getRevenue() {
        return $this->getSoldSeats() * $this->price;
    }
    
    public function displayMovie() {
        echo "Tên phim: " . $this->title . "\n";
        echo "Giá vé: " . $this->price . "\n";
        echo "Tổng số ghế: " . $this->totalSeats . "\n";
        echo "Số ghế còn trống: " . $this->availableSeats . "\n";
        echo "Số ghế đã bán: " . $this->getSoldSeats() . "\n";
        echo "Tổng doanh thu: " . $this->getRevenue() . "\n";
        echo "\n";
    }
}

function findMovieById($movies, $id) {
    foreach($movies as $movie) {
        if($movie->id == $id) {
            return $movie;
        }
    }
    return null;
}

function getTotalRevenue($movies) {
    $total = 0;
    foreach($movies as $movie) {
        $total += $movie->getRevenue();
    }
    return $total;
}

function getBestSellingMovie($movies) {
    $max_seat = 0;
    $best_movies = [];
    
    foreach($movies as $movie) {
        $sold = $movie->getSoldSeats();
        if ($sold > $max_seat) {
            $max_seat = $sold;
            $best_movies = [$movie]; // Tìm thấy kỷ lục mới, tạo lại mảng
        } elseif ($sold === $max_seat && $max_seat > 0) {
            $best_movies[] = $movie; // Bằng số vé cao nhất, thêm vào danh sách đồng hạng
        }
    }
    return $best_movies;
}

$movie1 = new Movie(1, "Avengers", 100000, 100);
$movie2 = new Movie(2, "Avatar", 120000, 80);
$movie3 = new Movie(3, "Batman", 90000, 120);

$movies = [$movie1, $movie2, $movie3];

// 5. YÊU CẦU THỰC HIỆN

echo "=== 5. CHẠY KỊCH BẢN CHÍNH ===\n\n";

// 2. Đặt vé cho phim Avengers (ví dụ đặt 30 vé)
echo "--- 2. Đặt vé cho phim Avengers ---\n";
$movie1->bookTickets(30);

// 3. Đặt vé cho phim Avatar (ví dụ đặt 25 vé)
echo "\n--- 3. Đặt vé cho phim Avatar ---\n";
$movie2->bookTickets(25);

// 4. Hủy một số vé đã đặt của phim Avengers (ví dụ hủy 5 vé)
echo "\n--- 4. Hủy vé của phim Avengers ---\n";
$movie1->cancelTiket(5);

// 5. Hiển thị thông tin của tất cả các phim
echo "\n--- 5. Thông tin tất cả các phim ---\n";
foreach ($movies as $movie) {
    $movie->displayMovie();
}

// 6. Tính tổng doanh thu của tất cả các phim
echo "--- 6. Tổng doanh thu tất cả các phim ---\n";
echo "Tổng doanh thu: " . number_format(getTotalRevenue($movies)) . " VNĐ\n\n";

// 7. Tìm và hiển thị phim có số vé bán ra nhiều nhất
echo "--- 7. Phim có số vé bán ra nhiều nhất ---\n";
$bestSelling = getBestSellingMovie($movies);
if (!empty($bestSelling)) {
    echo "Các phim có số vé bán ra nhiều nhất (" . $bestSelling[0]->getSoldSeats() . " vé):\n";
    foreach ($bestSelling as $m) {
        echo "- {$m->title} (Doanh thu: " . number_format($m->getRevenue()) . " VNĐ)\n";
    }
    echo "\n";
} else {
    echo "Chưa có phim nào bán được vé.\n\n";
}


// 6. TRƯỜNG HỢP BẮT BUỘC PHẢI XỬ LÝ (EDGE CASES)

echo "=== 6. KIỂM THỬ CÁC TRƯỜNG HỢP NGOẠI LỆ ===\n\n";

// Case 1: Đặt số vé nhỏ hơn hoặc bằng 0
echo "1. Thử đặt vé <= 0:\n";
$movie1->bookTickets(0);
$movie1->bookTickets(-5);

// Case 2: Đặt số vé lớn hơn số ghế còn lại
echo "\n2. Thử đặt vé vượt quá số ghế trống:\n";
$movie2->bookTickets(100); // Avatar chỉ còn 55 ghế

// Case 3: Hủy số vé nhỏ hơn hoặc bằng 0
echo "\n3. Thử hủy vé <= 0:\n";
$movie1->cancelTiket(0);
$movie1->cancelTiket(-3);

// Case 4: Hủy số vé lớn hơn số vé đã bán
echo "\n4. Thử hủy nhiều hơn số vé đã bán:\n";
$movie1->cancelTiket(50); // Avengers hiện chỉ mới bán 25 vé

// Case 5: Tìm phim không tồn tại
echo "\n5. Thử tìm phim không tồn tại (ID: 999):\n";
$searchId = 999;
$foundMovie = findMovieById($movies, $searchId);
if ($foundMovie) {
    echo "Tìm thấy phim: {$foundMovie->title}\n";
} else {
    echo "Thông báo: Không tìm thấy bộ phim có mã ID = $searchId!\n";
}

// Case 6: Danh sách phim rỗng khi gọi các function xử lý danh sách
echo "\n6. Gọi các function với danh sách rỗng []:\n";
$emptyList = [];
echo "- Doanh thu danh sách rỗng: " . getTotalRevenue($emptyList) . " VNĐ\n";

$bestInEmpty = getBestSellingMovie($emptyList);
if (!empty($bestInEmpty)) {
    echo "- Phim bán chạy nhất: " . implode(", ", array_map(function($m) { return $m->title; }, $bestInEmpty)) . "\n";
} else {
    echo "- Phim bán chạy nhất: Không có dữ liệu (null/rỗng)\n";
}



?>