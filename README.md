# BÀI TẬP THỰC HÀNH MÔN PHÁT TRIỂN ỨNG DỤNG WEB

- **Sinh viên thực hiện**: Nguyễn Công Việt
- **Mã sinh viên**: 23001953
- **Môn học**: Phát triển ứng dụng Web

---

## 📚 Danh Mục Các Buổi Thực Hành

### 🔹 Thực Hành 1 (TH1): PHP Cơ Bản & Lập Trình Hướng Đối Tượng (OOP)
Thư mục: [`TH1/`](./TH1/)

- **[`bai1.php`](./TH1/bai1.php)**: Làm quen với biến, mảng kết hợp lồng nhau và vòng lặp `foreach`, tính điểm trung bình.
- **[`bai2.php`](./TH1/bai2.php)**: Tách các hàm xử lý độc lập (`calculateAverageScore`, `getRank`, `displayStudent`).
- **[`bai3.php`](./TH1/bai3.php)**: Xử lý và tìm kiếm danh sách sinh viên (`findBestStudent`, `findWorstStudent`, `countPassedStudents`, `findStudentByName`).
- **[`bai4.php`](./TH1/bai4.php)**: Chuyển đổi sang Lập trình hướng đối tượng OOP (`class Student`, constructor, methods `getRank`, `isPassed`, `display`, xử lý mảng đối tượng).

### 🔹 Thực Hành 2 (TH2): PHP – Function & OOP Nâng Cao
Thư mục: [`TH2/`](./TH2/)

- **[`bai1.php`](./TH2/bai1.php)**: Xây dựng hệ thống giỏ hàng mua sắm (`class CartItem`, `class ShoppingCart`), xử lý thêm/xóa sản phẩm, tính tổng tiền, bắt lỗi dữ liệu đầu vào (giá/số lượng $\le 0$, xóa sản phẩm không tồn tại, giỏ hàng rỗng).
- **[`bai2.php`](./TH2/bai2.php)**: Quản lý vé xem phim (`class Movie`), xử lý đặt vé, hủy vé, tính doanh thu phim, tìm phim theo ID, tính tổng doanh thu toàn rạp và tìm phim bán chạy nhất (hỗ trợ hiển thị nhiều phim đồng hạng cao nhất). Bắt các trường hợp ngoại lệ theo đề bài.

---

## 🚀 Hướng Dẫn Chạy Bài Tập

### 1. Chạy trực tiếp qua dòng lệnh (CLI)
Mở Terminal tại thư mục gốc `d:\web` và chạy file tương ứng:
```bash
# Thực hành 1
php TH1/bai1.php
php TH1/bai2.php
php TH1/bai3.php
php TH1/bai4.php

# Thực hành 2
php TH2/bai1.php
php TH2/bai2.php
```

### 2. Chạy trên Trình duyệt Web

#### Cách 1: Sử dụng PHP Built-in Server (Khuyên dùng - Nhanh nhất)
1. Mở Terminal tại thư mục `d:\web` và chạy:
   ```bash
   php -S localhost:8000
   ```
2. Truy cập vào trình duyệt:
   - `http://localhost:8000/TH2/bai1.php`
   - `http://localhost:8000/TH2/bai2.php`

#### Cách 2: Sử dụng XAMPP
1. Mở **XAMPP Control Panel** và bấm **Start** ở module **Apache**.
2. Mở trình duyệt và truy cập:
   - `http://localhost/web/TH1/bai1.php`
   - `http://localhost/web/TH2/bai1.php`
   - `http://localhost/web/TH2/bai2.php`

