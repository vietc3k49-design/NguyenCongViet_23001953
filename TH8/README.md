# Thực hành 8 — API PHP và Vue.js

Sinh viên: Nguyễn Công Việt — 23001953.

## Cấu trúc thư mục

- `database.sql`: khởi tạo database `th8_products` (`utf8mb4_unicode_ci`), bảng `products` và 3 bản ghi mẫu.
- `common/dbConnect.php`: hàm `getDbConnection()` kết nối PDO tới `th8_products` (strict `sql_mode`, exception mode, tắt emulate prepares).
- `model/product.php`: các hàm truy vấn `products` (`getAllProducts`, `getProductById`, `addProduct`, `updateProduct`, `deleteProduct`) dùng PDO prepared statements.
- `api/products.php`: REST API JSON hỗ trợ `GET`, `POST`, `PUT ?id=...`, `DELETE ?id=...` và validate dữ liệu đầu vào trước khi ghi MySQL.
- `index.html`: giao diện Vue 3 (Options API) gọi API qua `fetch`, hiển thị bảng `v-for`, biểu mẫu `v-model` cho thêm/sửa, xác nhận trước khi xóa và hiển thị thông báo lỗi từ API.
- `assets/vue.global.prod.js`, `assets/VUE-LICENSE.txt`: Vue 3.5.22 dùng nội bộ offline (không phụ thuộc CDN).

## Cài đặt và chạy

1. Khởi động **Apache** và **MySQL** trong XAMPP.
2. Mở `http://localhost/phpmyadmin/`, chọn **Import / Nhập** và nhập file `database.sql` (dùng database riêng `th8_products`, không ảnh hưởng tới `shopping_cart` của TH4).
3. Kiểm tra cấu hình trong `common/dbConnect.php`: host `localhost`, database `th8_products`, user `root`, mật khẩu rỗng theo XAMPP mặc định.
4. Mở `http://localhost/web/TH8/` (hoặc chạy `php -S localhost:8000 -t TH8` từ thư mục gốc dự án rồi mở `http://localhost:8000/`, vẫn cần MySQL đang chạy).

## Đối chiếu yêu cầu và kiểm thử

| Phần | Nội dung chính | Kết quả |
|---|---|---|
| Câu 1 — Cơ sở dữ liệu | Bảng `products` (`id`, `name`, `price`, `stock`) và 3 dòng mẫu (`Bút bi`, `Vở ô ly`, `Thước kẻ`) | Đã tạo `database.sql`, kiểm thử import/idempotency và các ràng buộc DB |
| Câu 2 — API PHP | `GET`, `POST`, `PUT ?id=...`, `DELETE ?id=...` trả JSON (`success`, `data`, `message`), validate `name` (trim 1–100), `price` (>0), `stock` (>=0), PDO prepared statements | Đã kiểm thử HTTP thực tế toàn bộ endpoint, kiểu dữ liệu, biên, lỗi `400/404/405` và chống SQL injection |
| Câu 3 — Giao diện Vue.js | Bảng `v-for`, form `v-model`, chế độ thêm (`POST`) và sửa (`PUT`), xác nhận xóa (`DELETE`), cập nhật bảng không tải lại trang, hiển thị lỗi API | Đã kiểm thử E2E trên Chromium qua Playwright Core (không tràn ngang `320–1440 px`, `0` request ngoài, chống XSS) |
| Câu 4 — 4 tình huống kiểm tra | Thêm hợp lệ + reload; sửa đơn giá; `POST` trực tiếp `stock = -1` bị từ chối và không ghi DB; xóa + reload | Đạt đủ `4/4` tình huống trên Chromium và kiểm chứng trực tiếp MySQL |
