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

### 🔹 Thực Hành 3 (TH3): Cơ Sở Dữ Liệu MySQL
Thư mục: [`TH3/`](./TH3/)

- **[`bai1.sql`](./TH3/bai1.sql)**: Quản lý giỏ hàng (`shopping_cart`, bảng `cart_items`), thực hiện các thao tác tạo bảng, thêm 6 sản phẩm, lọc theo giá/số lượng, sắp xếp, cập nhật giá/số lượng, xóa sản phẩm, tính thành tiền và tổng giá trị giỏ hàng (`SUM`).
- **[`bai2.sql`](./TH3/bai2.sql)**: Quản lý vé xem phim (bảng `movies`), tính số lượng vé đã bán, tính doanh thu của từng phim, tổng doanh thu toàn rạp (`SUM`) và tìm phim có số vé bán ra nhiều nhất (`MAX`).

### 🔹 Thực Hành 4 (TH4): Ứng Dụng Quản Lý Sản Phẩm (PHP + MySQL + MVC cơ bản)
Thư mục: [`TH4/`](./TH4/)

- **[`common/dbConnect.php`](./TH4/common/dbConnect.php)**: Kết nối CSDL MySQL bằng PDO, hỗ trợ charset `utf8mb4`, xử lý ngoại lệ `PDOException`.
- **[`model/product.php`](./TH4/model/product.php)**: Tách lớp nghiệp vụ dữ liệu (`getAllProducts`, `getProductById`, `addProduct`, `updateProduct`, `deleteProduct`) sử dụng Prepared Statements an toàn.
- **[`product_list.php`](./TH4/product_list.php)**: Hiển thị danh sách sản phẩm dạng bảng (ID, Tên, Giá VNĐ, Số lượng, Chức năng [Sửa], [Xóa] kèm xác nhận `confirm`).
- **[`product_add.php`](./TH4/product_add.php)**: Form thêm sản phẩm mới kèm kiểm tra dữ liệu đầu vào (Tên không rỗng, Giá > 0, Số lượng >= 0).
- **[`product_edit.php`](./TH4/product_edit.php)**: Form chỉnh sửa sản phẩm, lấy dữ liệu hiện tại theo ID và cập nhật vào CSDL.
- **[`product_delete.php`](./TH4/product_delete.php)**: Xử lý xóa sản phẩm theo ID, kiểm tra sự tồn tại của sản phẩm trước khi xóa.
- **[`index.php`](./TH4/index.php)**: Điều hướng mặc định vào trang danh sách sản phẩm.
- **[`view/header.php`](./TH4/view/header.php)** & **[`view/footer.php`](./TH4/view/footer.php)**: Template HTML cơ bản dùng chung cho toàn bộ ứng dụng.

---

## 🚀 Hướng Dẫn Chạy Bài Tập Chi Tiết

### 1️⃣ Thực Hành 1 (TH1) & Thực Hành 2 (TH2): PHP Cơ Bản & OOP

Bạn có thể chạy bằng 1 trong 2 cách:

* **Cách 1: Chạy trực tiếp qua dòng lệnh CLI (Nhanh nhất)**
  Mở Terminal tại thư mục gốc `d:\web` và chạy:
  ```bash
  # Chạy bài tập TH1
  php TH1/bai1.php
  php TH1/bai2.php
  php TH1/bai3.php
  php TH1/bai4.php

  # Chạy bài tập TH2
  php TH2/bai1.php
  php TH2/bai2.php
  ```

* **Cách 2: Chạy trên Trình duyệt Web**
  * Dùng PHP Server: Chạy `php -S localhost:8000` rồi truy cập `http://localhost:8000/TH1/bai1.php` hoặc `http://localhost:8000/TH2/bai1.php`
  * Dùng XAMPP: Khởi động Apache rồi truy cập `http://localhost/web/TH1/bai1.php` hoặc `http://localhost/web/TH2/bai1.php`

---

### 2️⃣ Thực Hành 3 (TH3): Cơ Sở Dữ Liệu MySQL

Các bài tập TH3 là file mã nguồn SQL (`.sql`). Để chạy và kiểm tra kết quả truy vấn:

* **Cách 1: Sử dụng phpMyAdmin (Giao diện trực quan)**
  1. Khởi động module **MySQL** và **Apache** trong XAMPP Control Panel.
  2. Mở trình duyệt vào địa chỉ: `http://localhost/phpmyadmin/`.
  3. Chọn tab **SQL** (hoặc tab **Import**).
  4. Sao chép và dán nội dung từ file [`TH3/bai1.sql`](./TH3/bai1.sql) hoặc [`TH3/bai2.sql`](./TH3/bai2.sql) rồi nhấn nút **Go (Thực hiện)**.

* **Cách 2: Chạy trực tiếp qua MySQL CLI**
  ```bash
  mysql -u root -p < TH3/bai1.sql
  mysql -u root -p < TH3/bai2.sql
  ```

---

### 3️⃣ Thực Hành 4 (TH4): Ứng Dụng Quản Lý Giỏ Hàng (PHP + MySQL)

Đây là ứng dụng Web CRUD hoàn chỉnh kết hợp PHP và MySQL:

* **Bước 1: Khởi động Dịch vụ**
  * Mở **XAMPP Control Panel**, nhấn **Start** ở cả 2 module: **Apache** và **MySQL**.

* **Bước 2: Chuẩn bị Cơ sở dữ liệu**
  * Đảm bảo Database `shopping_cart` và bảng `products` đã được khởi tạo trong MySQL (qua phpMyAdmin hoặc chạy lệnh SQL tạo bảng kèm 5 sản phẩm mẫu).

* **Bước 3: Truy cập vào ứng dụng trên Trình duyệt**
  * **Cách Khuyên dùng (qua XAMPP)**:
    👉 Mở trình duyệt vào link: **`http://localhost/web/TH4/`** (hoặc `http://localhost/web/TH4/product_list.php`)
  * **Cách thay thế (qua PHP Built-in Server)**:
    Mở Terminal tại `d:\web`, gõ:
    ```bash
    php -S localhost:8000
    ```
    Sau đó truy cập: **`http://localhost:8000/TH4/`**


