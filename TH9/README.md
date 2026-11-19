# Thực hành 9 — Upload ảnh sản phẩm và Phân trang (PHP API & Vue.js)

Sinh viên: Nguyễn Công Việt — 23001953.

## Cấu trúc thư mục

- `database.sql`: khởi tạo database `th9_products` (`utf8mb4_unicode_ci`), bảng `products` (`id`, `name`, `price`, `stock`, `image`) và dữ liệu mẫu.
- `common/dbConnect.php`: hàm `getDbConnection()` kết nối PDO tới `th9_products` (strict `sql_mode`, exception mode, tắt emulate prepares).
- `model/product.php`: các hàm truy vấn `products` có phân trang (`page`, `limit`), tổng số bản ghi, lấy theo ID, thêm, sửa, cập nhật cột `image` và xóa sản phẩm bằng PDO prepared statements.
- `api/products.php`: REST API JSON hỗ trợ `GET ?page=&limit=`, `POST`, `PUT ?id=...`, `DELETE ?id=...` và trả metadata `pagination` (`page`, `limit`, `total`, `total_pages`).
- `api/upload.php`: endpoint `POST` nhận `FormData` (`product_id`, `image`), kiểm tra định dạng JPG/JPEG/PNG và dung lượng tối đa 2 MB, lưu ảnh vào `uploads/` và cập nhật cột `image`.
- `uploads/`: chứa `.gitkeep` và 12 ảnh sản phẩm mẫu (`product_1_*.jpg`..`product_12_*.jpg`) khớp với `database.sql`.
- `index.html`: giao diện Vue 3 (Options API) dùng offline, hỗ trợ thêm/sửa/xóa, chọn và xem trước ảnh (`URL.createObjectURL`), giữ ảnh hiện tại khi sửa, xử lý lỗi upload kèm nút `Thử lại upload`, và điều hướng phân trang không tải lại trang.
- `assets/vue.global.prod.js`, `assets/VUE-LICENSE.txt`: Vue 3.5.22 dùng nội bộ offline (không phụ thuộc CDN).

## Cài đặt và chạy

1. Khởi động **Apache** và **MySQL** trong XAMPP.
2. Mở `http://localhost/phpmyadmin/`, chọn **Import / Nhập** và nhập file `database.sql` (dùng database riêng `th9_products`, không ảnh hưởng tới `shopping_cart` của TH4 hoặc `th8_products` của TH8).
3. Kiểm tra cấu hình trong `common/dbConnect.php`: host `localhost`, database `th9_products`, user `root`, mật khẩu rỗng theo XAMPP mặc định.
4. Đảm bảo thư mục `uploads/` có quyền ghi cho PHP/Apache.
5. Mở `http://localhost/web/TH9/` (hoặc chạy `php -S localhost:8000 -t TH9` từ thư mục gốc dự án rồi mở `http://localhost:8000/`, vẫn cần MySQL đang chạy).

## Đối chiếu yêu cầu

| Phần | Nội dung chính | Chi tiết triển khai |
|---|---|---|
| Câu 1 — Upload ảnh sản phẩm | Bổ sung cột `image` trong `products`; API `POST api/upload.php` kiểm tra `.jpg`/`.jpeg`/`.png`, MIME thực tế và dung lượng `<= 2 MB`; giao diện cho phép chọn ảnh, xem trước, hiển thị thumbnail trong bảng (hoặc `Chưa có ảnh`), giữ ảnh cũ khi sửa không chọn ảnh mới và xử lý lỗi upload | `index.html` kiểm tra trước đuôi tệp, MIME và dung lượng `0 < size <= 2 MB`; xem trước qua `URL.createObjectURL` và thu hồi URL cũ khi đổi/hủy; giữ thông tin sản phẩm đã lưu ở chế độ sửa và cung cấp `#retry-upload-btn` (`Thử lại upload`) nếu bước upload ảnh gặp lỗi |
| Câu 2 — Phân trang danh sách | `GET api/products.php?page=1&limit=5` trả `data` và `pagination` (`page`, `limit`, `total`, `total_pages`), tự lùi về trang cuối khi `page > total_pages`, trả trạng thái hợp lệ khi rỗng; giao diện hiển thị `Trước`, `Trang X / Y — Tổng Z sản phẩm`, `Sau`, cập nhật danh sách không tải lại trang | `index.html` khóa `Trước` ở trang 1, khóa `Sau` ở trang cuối (hoặc khi danh sách rỗng `1 / 1`), tải trang 1 sau khi thêm mới, tải lại trang hiện tại sau khi sửa, và tự cập nhật về trang cuối hợp lệ khi xóa mục cuối cùng của trang cuối; hiển thị `Chưa có sản phẩm` khi rỗng |

## Kết quả kiểm thử (19/11/2026)

- **Database & Constraints (MariaDB `10.4.32`)**: kiểm thử import idempotent (`12` sản phẩm mẫu, cột `image VARCHAR(255) NULL`), kiểm tra các ràng buộc `CHECK` (tên trống/khoảng trắng, `price <= 0`, `stock < 0`) và giữ nguyên dữ liệu `th8_products` / `shopping_cart`.
- **PHP HTTP API (`php -S`)**: kiểm tra `18/18` tình huống `api/products.php` (phân trang mặc định, các trang `1..3`, vượt trang cuối tự lùi trang `3`, tham số lỗi `400`, CRUD + xóa tệp ảnh kèm theo) và `13/13` tình huống `api/upload.php` (`405`, `400`, `404`, ảnh PNG/JPG hợp lệ, thay ảnh xóa ảnh cũ, từ chối ảnh giả MIME, `.gif`/`.txt`, ảnh `> 2 MB`, tệp `0` byte).
- **E2E Chromium (Playwright Core)**: đạt `10/10` kịch bản gồm phân trang 3 trang không reload, upload PNG + xem trước + reload giữ ảnh, từ chối file sai loại / `> 2 MB`, giữ dữ liệu và thử lại khi upload lỗi (`#retry-upload-btn`), giữ ảnh cũ khi sửa không chọn ảnh mới, xóa sản phẩm duy nhất trên trang cuối tự lùi trang, trạng thái rỗng (`Chưa có sản phẩm`, `Trang 1 / 1 — Tổng 0 sản phẩm`, khóa 2 nút), `0` request ngoài và không tràn ngang `320–1440 px`.
