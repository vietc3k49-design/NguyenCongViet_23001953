# BÀI TẬP THỰC HÀNH MÔN PHÁT TRIỂN ỨNG DỤNG WEB

- **Sinh viên:** Nguyễn Công Việt
- **Mã sinh viên:** 23001953
- **Công nghệ:** PHP 8.2+, MySQL/MariaDB, PDO, HTML/CSS và JavaScript cơ bản.

## Danh mục bài thực hành

### TH1 — PHP cơ bản, mảng, hàm và OOP

- [bai1.php](./TH1/bai1.php): biến, mảng sinh viên, vòng lặp và tính điểm trung bình.
- [bai2.php](./TH1/bai2.php): tách hàm tính điểm, xếp loại và hiển thị sinh viên.
- [bai3.php](./TH1/bai3.php): tìm sinh viên tốt nhất/kém nhất, đếm sinh viên đạt và tìm theo tên.
- [bai4.php](./TH1/bai4.php): lớp Student, constructor, phương thức và mảng đối tượng.

### TH2 — Function và OOP nâng cao

- [bai1.php](./TH2/bai1.php): CartItem, ShoppingCart; thêm/xóa sản phẩm, tính tổng tiền và kiểm tra dữ liệu.
- [bai2.php](./TH2/bai2.php): Movie; đặt/hủy vé, doanh thu, tìm phim và phim bán chạy nhất, xử lý ngoại lệ.

### TH3 — MySQL

- [bai1.sql](./TH3/bai1.sql): database shopping_cart, bảng cart_items; tạo dữ liệu, lọc, sắp xếp, cập nhật, xóa và tính tổng giá trị giỏ hàng.
- [bai2.sql](./TH3/bai2.sql): bảng movies; số vé bán, doanh thu từng phim/toàn rạp và tìm phim bán nhiều vé nhất.

### TH4 — Quản lý sản phẩm và tài khoản (tiếp nối trong tuần 5)

**Bài tuần 5 tiếp tục trong TH4.** Mã nguồn hiện tại nằm trong [TH4/app/](./TH4/app/), không có bài TH5 riêng. Ứng dụng quản lý sản phẩm của hệ thống giỏ hàng, có đăng ký, đăng nhập, đăng xuất và kiểm soát truy cập.

| Thành phần | Vai trò |
|---|---|
| [common/dbConnect.php](./TH4/app/common/dbConnect.php) | Kết nối PDO dùng chung, utf8mb4, xử lý lỗi kết nối |
| [common/auth.php](./TH4/app/common/auth.php) | Kiểm tra session trước khi truy cập trang quản lý |
| [model/product.php](./TH4/app/model/product.php) | Năm hàm lấy danh sách, lấy theo ID, thêm, sửa và xóa |
| [product_list.php](./TH4/app/product_list.php) | Bảng ID, tên, giá, số lượng, liên kết Sửa/Xóa |
| [product_add.php](./TH4/app/product_add.php) | Form thêm sản phẩm, kiểm tra dữ liệu phía server |
| [product_edit.php](./TH4/app/product_edit.php) | Điền dữ liệu hiện tại, kiểm tra và cập nhật theo ID |
| [product_delete.php](./TH4/app/product_delete.php) | Trang xác nhận; xóa qua POST có token |
| [register.php](./TH4/app/register.php) | Kiểm tra trường trống/tên trùng, băm mật khẩu và đăng ký |
| [login.php](./TH4/app/login.php) | Xác minh mật khẩu, lưu session, hiển thị thông báo đăng ký |
| [logout.php](./TH4/app/logout.php) | Xóa session/cookie phiên và về trang đăng nhập |
| [index.php](./TH4/app/index.php) | Chuyển đến login hoặc danh sách theo trạng thái đăng nhập |
| [view/header.php](./TH4/app/view/header.php), [view/footer.php](./TH4/app/view/footer.php) | Giao diện chung; hiển thị tài khoản và Đăng xuất |
| [shopping_cart.sql](./TH4/shopping_cart.sql) | Tạo database, bảng products/users và dữ liệu mẫu |
| [README riêng](./TH4/README.md) | Hướng dẫn cài đặt và bài nộp |

```text
TH4/
├── README.md
├── shopping_cart.sql
└── app/
    ├── common/
    │   ├── dbConnect.php
    │   └── auth.php
    ├── model/product.php
    ├── view/
    │   ├── header.php
    │   └── footer.php
    ├── assets/.gitkeep
    ├── index.php
    ├── product_list.php
    ├── product_add.php
    ├── product_edit.php
    ├── product_delete.php
    ├── register.php
    ├── login.php
    └── logout.php
```

Các điểm kiểm tra dữ liệu và truy cập:

- Tên sản phẩm không rỗng, tối đa 100 ký tự; giá dương, tối đa 2 chữ số thập phân; số lượng là số nguyên không âm. Các giá trị số lượng như `1.5` hoặc `-0.5` bị từ chối.
- Form giữ dữ liệu khi lỗi. Trang sửa/xóa báo ID sai hoặc sản phẩm không tồn tại có đầy đủ header/footer.
- GET không xóa dữ liệu; người dùng phải xác nhận bằng form POST có token hợp lệ.
- Bốn trang sản phẩm đều yêu cầu đăng nhập, kể cả khi gửi POST trực tiếp. Người chưa đăng nhập được chuyển về login.
- Truy vấn có dữ liệu đầu vào dùng prepared statements; nội dung hiển thị được escape; mật khẩu dùng password_hash/password_verify.

### TH6 — VueJS

- [Mục lục](./TH6/index.html): chọn một trong ba bài thực hành.
- [bai1.html](./TH6/bai1.html): thẻ sinh viên, xếp loại, trạng thái và ẩn/hiện giới thiệu.
- [bai2.html](./TH6/bai2.html): đặt vé, kiểm tra dữ liệu, computed tổng tiền và xác nhận ngay trên trang.
- [bai3.html](./TH6/bai3.html): thêm/xóa công việc, checkbox hoàn thành, bộ lọc và thống kê.

Đã đối chiếu đủ 26 yêu cầu đề. Bản nộp cuối được kiểm tra lại ngày 29/10/2026: 74/74 kiểm tra đạt trên Chromium, gồm các chức năng chính, liên kết/tài nguyên offline và bố cục 320–1440 px. Thư mục TH6 giữ bản nộp gọn gồm 4 file HTML và `assets/`.

Mở `TH6/index.html` trực tiếp bằng trình duyệt hoặc **http://localhost/web/TH6/** khi chạy Apache. Vue 3 và ảnh được lưu trong `TH6/assets/`, hoạt động offline; không cần MySQL hoặc bước build.

## Hướng dẫn chạy

### TH1 và TH2

Từ thư mục gốc dự án, chạy bằng PHP CLI, ví dụ:

```bash
php TH1/bai1.php
php TH2/bai1.php
```

Hoặc chạy `php -S localhost:8000` tại thư mục gốc rồi mở `http://localhost:8000/TH1/bai1.php` hay `http://localhost:8000/TH2/bai1.php`.

### TH3

Bật Apache và MySQL trong XAMPP, mở `http://localhost/phpmyadmin/`, nhập file SQL tương ứng trong TH3 qua tab **Import / Nhập** hoặc chạy nội dung trong tab **SQL**.

### TH4 và phần tiếp nối tuần 5

1. Bật **Apache** và **MySQL** trong XAMPP.
2. Mở `http://localhost/phpmyadmin/`, nhập [TH4/shopping_cart.sql](./TH4/shopping_cart.sql).
3. Kiểm tra [dbConnect.php](./TH4/app/common/dbConnect.php): host `localhost`, database `shopping_cart`, user MySQL `root`, mật khẩu rỗng theo XAMPP hiện tại. Điều chỉnh nếu máy chạy dùng cấu hình khác.
4. Với Apache đang phục vụ dự án tại `/web/`, mở **http://localhost/web/TH4/app/**.
5. Đăng nhập bằng tài khoản mẫu hoặc đăng ký tài khoản mới.

Có thể dùng PHP server thay Apache: từ thư mục gốc dự án chạy:

```bash
php -S localhost:8000 -t TH4/app
```

Sau đó mở **http://localhost:8000/**. MySQL vẫn cần chạy.

### Database và tài khoản mẫu

SQL cung cấp bảng `products` với 5 sản phẩm và bảng `users` với 2 tài khoản:

| Tên đăng nhập | Mật khẩu mẫu |
|---|---|
| viet | Viet@123456 |
| user01 | User@123456 |

Mật khẩu trong cột `users.password` là chuỗi băm tạo bằng PHP `password_hash()`. File SQL có thể nhập lại: bản ghi trùng ID sản phẩm hoặc tên đăng nhập được giữ nguyên, không đặt lại mật khẩu đã có. File không xóa dữ liệu và không tự sửa cấu trúc bảng đã tồn tại. Các bảng `cart_items`, `movies` của TH3 không bị thay đổi.

## Kiểm tra và bài nộp

Đã kiểm tra cú pháp PHP, validation, thao tác CRUD, đăng ký/đăng nhập/đăng xuất, session và kiểm soát truy cập. Các phép thử ghi dữ liệu tự động dùng transaction rồi rollback. SQL đã được thử nhập hai lần trên bảng tạm, xác nhận đủ 5 sản phẩm, 2 tài khoản và hai mật khẩu hợp lệ.

Ngày **15/10/2026**, sau khi chuyển bài vào `TH4/app/`, sinh viên xác nhận đã test xong.

Bài nộp TH4 gồm **toàn bộ thư mục TH4/**: source trong `app/`, file `shopping_cart.sql` và README hướng dẫn. `app/assets/.gitkeep` giữ thư mục tài nguyên khi nộp qua Git.
