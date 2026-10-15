# Thực hành PHP + MySQL: quản lý sản phẩm và tài khoản

Sinh viên: Nguyễn Công Việt — 23001953.

## Cài đặt và chạy

1. Khởi động Apache và MySQL trong XAMPP.
2. Mở `http://localhost/phpmyadmin/`, chọn **Import / Nhập** và nhập file `shopping_cart.sql` cùng thư mục với README này.
3. Kiểm tra cấu hình trong `app/common/dbConnect.php`: host `localhost`, database `shopping_cart`, tài khoản MySQL `root`, mật khẩu rỗng theo cấu hình XAMPP hiện tại.
4. Với dự án đang được Apache phục vụ ở `/web/`, mở `http://localhost/web/TH4/app/`.
   Có thể chạy `php -S localhost:8000 -t TH4/app` từ thư mục gốc dự án rồi mở `http://localhost:8000/` (MySQL vẫn phải chạy).

## Tài khoản mẫu

| Tên đăng nhập | Mật khẩu |
|---|---|
| viet | Viet@123456 |
| user01 | User@123456 |

File SQL tạo bảng `products` với 5 sản phẩm và bảng `users` với 2 tài khoản mẫu. Mật khẩu trong SQL là chuỗi băm tạo bằng PHP `password_hash()`, được kiểm tra khi đăng nhập bằng `password_verify()`.

Có thể nhập lại SQL: bản ghi trùng ID sản phẩm hoặc tên đăng nhập sẽ được giữ nguyên, không bị ghi đè. Vì vậy mật khẩu của tài khoản đã có cũng không bị đặt lại. File không xóa database, bảng hoặc dữ liệu hiện tại; không sửa cấu trúc bảng đã tồn tại.

## Chức năng

- Đăng ký, đăng nhập, đăng xuất và hiển thị tên tài khoản.
- Chỉ tài khoản đã đăng nhập được xem, thêm, sửa, xóa sản phẩm.
- Kiểm tra dữ liệu phía server; số lượng phải là số nguyên không âm.
- Xóa qua form POST có xác nhận và token; GET chỉ mở trang xác nhận.
- Các trang dùng chung `view/header.php` và `view/footer.php`.

## Bài nộp

Nộp toàn bộ thư mục này, gồm `app/`, `shopping_cart.sql` và README này. `app/assets/.gitkeep` giúp giữ thư mục tài nguyên khi đưa lên Git.
