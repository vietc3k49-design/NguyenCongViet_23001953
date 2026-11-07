# Thực hành tuần 7 — Vue 3

Sinh viên: Nguyễn Công Việt — 23001953.

- [Bài 1: Danh sách sản phẩm](bai1.html).
- [Bài 2: Danh mục sản phẩm bằng component](bai2.html).
- [Bài 3: Giỏ hàng với props và $emit](bai3.html).

## Rà soát tổng thể theo đề — 07/11/2026

Đã đọc lại cả 3 trang PDF và đối chiếu từng yêu cầu với mã nguồn, sau đó kiểm tra lại trên trình duyệt.

| Bài | Yêu cầu trong đề | Kết quả đối chiếu |
|---|---:|---|
| Bài 1 — Tìm kiếm, lọc và thống kê | 10 | Đủ 10/10; dữ liệu mẫu có 6 sản phẩm thuộc 3 danh mục. |
| Bài 2 — Component sản phẩm | 8 | Đủ 8/8; 4 sản phẩm, đủ 5 props có kiểu, required/default, trạng thái độc lập, đúng file component. |
| Bài 3 — Giỏ hàng và sự kiện | 8 | Đủ 8/8; đúng luồng props xuống, sự kiện lên; số lượng 1–99; tổng mẫu 5 và 46.000đ. |
| **Tổng** | **26** | **Không phát hiện yêu cầu bị thiếu.** |

Lượt rà soát tổng thể: **465/465 kiểm tra đạt** trên Chromium 151.0.7922.34, gồm 258 kiểm tra bài 1, 39 bài 2, 137 bài 3 và 31 kiểm tra chung. Đây là một lượt kiểm tra riêng; các số 164/156/368 bên dưới là kết quả lúc triển khai từng bài.

Đã kiểm tra 72 tổ hợp tìm kiếm–danh mục–sắp xếp, bảo toàn mảng gốc, thống kê khi rỗng, validation và xác nhận xóa; props/default/trạng thái độc lập; payload sự kiện chính xác, con không tự sửa props, toàn bộ 99 giá trị số lượng hợp lệ và các payload sai. Cả ba bài trả HTTP 200 qua XAMPP, chạy offline bằng `file://`, không tràn ngang trang ở 320/390/768/1440 px, không có lỗi/cảnh báo trình duyệt hoặc request ngoài.

Không cần sửa logic sau lần rà soát này. Phạm vi trình duyệt đã kiểm tra là Chromium; chưa kiểm tra Firefox/Safari. Kết quả đối chiếu đáp ứng đề đã cung cấp, không thay thế điểm chấm chính thức của giảng viên.

Khi nộp, giữ đủ **`bai1.html`, `bai2.html`, `bai3.html`, `components/` và `assets/`** trong cùng thư mục TH7. Chi tiết đối chiếu và hướng dẫn kiểm tra từng bài nằm bên dưới.

## Bài 1 — Danh sách sản phẩm

### Mở bài bằng XAMPP

Bật Apache, mở **http://localhost/web/TH7/bai1.html**. Bài này không cần MySQL, npm hoặc build. Cũng có thể mở trực tiếp `bai1.html` bằng trình duyệt khi không có mạng.

Nộp `bai1.html` và toàn bộ `assets/` cùng nhau. Vue 3.5.22 và giấy phép MIT được lưu tại `assets/vue.global.prod.js`, `assets/VUE-LICENSE.txt`; không phụ thuộc thư mục TH6 hoặc CDN.

Dữ liệu chỉ nằm trong bộ nhớ khi mở trang. Nhấn F5 để trở lại sáu sản phẩm mẫu trước mỗi nhóm kiểm tra độc lập. Đề không yêu cầu lưu dữ liệu sau khi tải lại trang.

### Đối chiếu đầy đủ 10 yêu cầu của đề

| Yêu cầu | Cách thực hiện trong `bai1.html` |
|---|---|
| Dữ liệu ban đầu | `data().products`: 6 sản phẩm, 3 danh mục; mỗi sản phẩm có `id`, `name`, `price`, `category`, `stock`. |
| 1. Bảng, nhãn còn/hết hàng | `v-for`, `:key="product.id"`, nội suy, `:class`; tồn > 0 có nhãn xanh, tồn = 0 có nhãn đỏ. |
| 2. Tìm tên không phân biệt hoa/thường | `v-model="keyword"`, `trim()`, `toLocaleLowerCase('vi-VN')`, `includes()`. Tìm theo chuỗi con, có phân biệt dấu tiếng Việt. |
| 3. Lọc danh mục | `v-model="selectedCategory"`, tùy chọn tất cả và 3 danh mục. |
| 4. Sắp xếp giá, giữ mảng gốc | `filter()` tạo mảng mới; chỉ `sort()` trên mảng mới. Giá bằng nhau thì ID nhỏ đứng trước. Chọn “Thứ tự ban đầu” để kiểm chứng. |
| 5. Kết hợp tìm/lọc/sắp xếp | `computed.displayedProducts` áp dụng cả ba điều kiện; thêm và xóa không tự xóa bộ lọc. |
| 6. Thêm và kiểm tra dữ liệu | `@submit.prevent`, `methods.addProduct`: trim tên, giá hữu hạn > 0, tồn kho nguyên không âm, danh mục hợp lệ. Không ép số thập phân thành số nguyên. Giữ dữ liệu nếu lỗi. |
| 7. Xóa có xác nhận | `methods.deleteProduct(id)` gọi `window.confirm()` trước khi xóa đúng ID; Cancel không đổi dữ liệu. |
| 8. Thống kê bằng computed | `displayedCount`, `totalCount`, `inventoryValue`; tổng bằng `price * stock` của các sản phẩm đang hiển thị. Không có kết quả thì số hiển thị và tổng bằng 0. |
| 9. Thông báo bằng watch | `watch.keyword`: từ khóa sau trim có đúng 1 ký tự thì hiện thông báo; rỗng hoặc >= 2 ký tự thì xóa thông báo. Cảnh báo không chặn tìm kiếm. |
| 10. Trạng thái bằng mounted | Ban đầu “Đang khởi tạo”; `mounted()` đặt `pageStatus = 'Sẵn sàng'`. |

### Dữ liệu mẫu và tổng đối chiếu

| ID | Sản phẩm | Giá (đồng) | Danh mục | Tồn | Giá trị tồn (đồng) |
|---|---|---:|---|---:|---:|
| 1 | Bút bi Thiên Long | 5.000 | Văn phòng phẩm | 20 | 100.000 |
| 2 | Vở ô ly 200 trang | 12.000 | Văn phòng phẩm | 15 | 180.000 |
| 3 | Chuột không dây | 150.000 | Điện tử | 8 | 1.200.000 |
| 4 | Bàn phím cơ | 450.000 | Điện tử | 0 | 0 |
| 5 | Bình giữ nhiệt | 180.000 | Gia dụng | 5 | 900.000 |
| 6 | Đèn bàn học | 120.000 | Gia dụng | 0 | 0 |

Ban đầu: **6 / 6 sản phẩm**, **2.380.000 đồng**, 4 nhãn Còn hàng và 2 nhãn Hết hàng.

### Hướng dẫn test thủ công

#### 1. Hiển thị, tìm kiếm, watch và bộ lọc

| Thao tác | Kết quả mong đợi |
|---|---|
| Mở trang | Trạng thái “Sẵn sàng”; bảng và tổng đúng dữ liệu mẫu phía trên. |
| Tìm `BÚT`, `bút`, hoặc `  BÚT  ` | Chỉ ID 1, 1 / 6 sản phẩm, 100.000 đồng. |
| Tìm `b` | Hiện cảnh báo 1 ký tự, bảng vẫn được tìm bình thường. |
| Đổi thành `bú` | Cảnh báo biến mất. |
| Tìm ` đ ` | Cảnh báo xuất hiện vì từ khóa sau trim có 1 ký tự. |
| Xóa từ khóa hoặc chỉ nhập khoảng trắng | Không có cảnh báo; tìm kiếm không loại sản phẩm. Danh mục/sắp xếp vẫn có hiệu lực nếu đang chọn. |
| Đặt lại bộ lọc, chọn Văn phòng phẩm | ID 1, 2; 2 / 6 sản phẩm; 280.000 đồng. |
| Chọn Điện tử | ID 3, 4; 2 / 6; 1.200.000 đồng; sản phẩm hết hàng vẫn hiển thị. |
| Chọn Gia dụng | ID 5, 6; 2 / 6; 900.000 đồng. |
| Đặt lại bộ lọc, chọn Giá tăng dần | ID theo thứ tự 1, 2, 6, 3, 5, 4; tổng vẫn 2.380.000 đồng. |
| Chọn Giá giảm dần | ID theo thứ tự 4, 5, 3, 6, 2, 1. |
| Chọn Thứ tự ban đầu | ID trở lại 1, 2, 3, 4, 5, 6: dữ liệu gốc không bị sort. |
| Tìm `N`, chọn Gia dụng, Giá tăng dần | Đồng thời áp dụng cả 3 điều kiện: ID 6, 5; 2 / 6; 900.000 đồng. |
| Giữ điều kiện trên, đổi sang Giá giảm dần | ID 5, 6; thống kê không đổi. |
| Tìm `không có sản phẩm này` | Không có dòng sản phẩm, thông báo không phù hợp, 0 / 6; tổng 0 đồng. |
| Nhấn Đặt lại bộ lọc | Xóa từ khóa/cảnh báo, tất cả danh mục, thứ tự ban đầu, thống kê ban đầu. |

#### 2. Thêm sản phẩm và kiểm tra dữ liệu

Nhấn F5. Với mỗi ca lỗi, giữ các trường còn lại hợp lệ, ví dụ tên `Sản phẩm test`, giá `10000`, tồn `2`.

| Dữ liệu/thao tác | Kết quả mong đợi |
|---|---|
| Bỏ trống cả tên, giá và tồn rồi nhấn Thêm | Báo lỗi ở cả 3 trường; không thêm, không đổi thống kê. |
| Tên rỗng hoặc toàn khoảng trắng | Báo lỗi tên, không thêm. |
| Giá rỗng, `0`, `-1`, `-0.5` | Báo lỗi giá, không thêm. |
| Tồn rỗng, `-1`, `1.5`, `-0.5` | Báo lỗi tồn, không thêm; tuyệt đối không tự cắt phần thập phân. |
| Nhập giá hoặc tồn `9007199254740992` | Báo lỗi vượt giới hạn số an toàn, không thêm. |
| Giá `9007199254740991`, tồn `2` | Báo lỗi giá trị tồn vượt giới hạn tính toán an toàn. |
| Tên `  Sản phẩm test  `, giá `10000`, tồn `2`, Gia dụng | Thêm ID 7 với tên đã trim; 7 / 7; tổng 2.400.000 đồng; có thông báo thành công; form được xóa. |
| Với dữ liệu hợp lệ, nhấn Enter trong trường tồn | Thêm đúng một lần, không tải lại trang. |
| Sau F5, thêm giá `12.5`, tồn `0` | Hợp lệ: nhãn Hết hàng, giá 12,5 đồng; 7 / 7; tổng vẫn 2.380.000 đồng. |
| Thêm tên trùng tên có sẵn | Hợp lệ, có ID riêng; đề không cấm trùng tên. Xóa một dòng không làm mất dòng trùng tên còn lại. |
| Thêm giá trùng một sản phẩm mẫu rồi sắp xếp | Các sản phẩm cùng giá sắp theo ID tăng; chọn Thứ tự ban đầu vẫn giữ thứ tự mảng gốc. |
| Tên `<img src=x onerror=alert(1)>`, giá/tồn hợp lệ | Hiển thị nguyên tên dưới dạng văn bản; không tạo ảnh hoặc thực thi mã. |
| Gửi form lỗi rồi sửa đúng và gửi lại | Lần lỗi giữ nội dung nhập; lần đúng thêm một sản phẩm và xóa lỗi cũ. |
| Nhấn Xóa nội dung nhập | Chỉ xóa form, lỗi và thông báo; không xóa sản phẩm hoặc thay bộ lọc. |
| Đang tìm `xyz-no-match`, thêm sản phẩm tên `Sản phẩm mới` | Sản phẩm được thêm vào tổng số; bảng vẫn rỗng và tổng đang hiển thị vẫn 0. Có thông báo sản phẩm bị ẩn bởi bộ lọc. |
| Sau ca trên, nhấn Đặt lại bộ lọc | Sản phẩm mới xuất hiện, thống kê tính lại đầy đủ. |

Giá chấp nhận số thập phân dương. Đơn vị là đồng; giao diện định dạng tiền tối đa 2 chữ số thập phân, giá dương dưới 0,01 dùng dạng khoa học để không hiển thị thành 0. Tồn kho phải là số nguyên an toàn. Giá, tồn kho và tổng giá trị tồn được giới hạn theo khả năng biểu diễn số của JavaScript (`Number.MAX_SAFE_INTEGER`); không nhận `NaN` hoặc vô cực.

#### 3. Xóa, dữ liệu rỗng và tính lại thống kê

Nhấn F5 trước nhóm này.

| Thao tác | Kết quả mong đợi |
|---|---|
| Nhấn Xóa ở Chuột không dây | Hộp xác nhận chứa đúng tên và ID 3. |
| Chọn Cancel/Hủy | Giữ cả 6 sản phẩm; tổng vẫn 2.380.000 đồng. |
| Tìm `CHUỘT`, chọn Điện tử, Giá giảm dần; xóa và OK | Xóa đúng ID 3; không có kết quả phù hợp; 0 / 5; tổng hiển thị 0 đồng. |
| Nhấn Đặt lại bộ lọc | Còn ID 1, 2, 4, 5, 6; 5 / 5; tổng 1.180.000 đồng. |
| Xóa một sản phẩm hết hàng | Tổng số sản phẩm giảm 1; tổng giá trị tồn không đổi. |
| Xóa lần lượt tất cả sản phẩm, đều chọn OK | Thông báo chưa có sản phẩm; 0 / 0; tổng 0 đồng; form vẫn dùng được. |
| Thêm lại sau khi xóa hết | Thêm thành công, ID tiếp tục tăng, không tái sử dụng ID đã cấp trong phiên. Bảng và tổng cập nhật. |
| Nhấn F5 | Khôi phục đúng 6 sản phẩm mẫu và tổng 2.380.000 đồng. |

#### 4. Kiểm tra giao diện và offline

- Mở DevTools → Console: không có lỗi JavaScript.
- Kiểm tra chiều rộng 320, 390, 768 và 1440 px: trang không tràn ngang; trên điện thoại cuộn ngang bên trong bảng để xem cột bên phải.
- Dùng Tab để chuyển giữa ô nhập, select và nút; Enter gửi form thêm.
- Mở trực tiếp `bai1.html`, bật chế độ Offline trong DevTools rồi tải lại: Vue vẫn chạy; thử tìm tên và thêm sản phẩm. Khi mở qua HTTP, cần Apache hoạt động để tải trang.

### Kết quả kiểm tra tự động

Ngày 07/11/2026: **164/164 kiểm tra đạt** trên Chromium 151.0.7922.34, dùng Playwright Core có sẵn trên máy. Đã kiểm tra qua Apache/XAMPP trả HTTP 200 và mở `file://` khi offline.

Phạm vi: dữ liệu mẫu, nhãn/màu, tìm kiếm và watch, từng danh mục, sắp xếp/giữ mảng gốc, kết hợp bộ lọc, thống kê/không có kết quả, validation, số không hữu hạn/vượt giới hạn, thêm/Enter, tên trùng/giá trùng, escape HTML, giữ form khi lỗi, thêm khi bị lọc, hủy/xác nhận xóa, xóa hết/thêm lại/ID, tải lại trang, bố cục 320–1440 px và offline.

Không ghi nhận lỗi console/JavaScript hoặc request tới tài nguyên ngoài. Đã xem ảnh desktop và mobile. Chưa kiểm tra Firefox/Safari. Công cụ kiểm tra và ảnh tạm đã được dọn khỏi bài nộp.

## Bài 2 — Danh mục sản phẩm bằng component

### Mở bài và các file cần nộp

Bật Apache trong XAMPP rồi mở **http://localhost/web/TH7/bai2.html**. Không cần MySQL, npm hoặc build. Cũng mở được `bai2.html` trực tiếp, không có mạng.

Các file của bài 2:

- `bai2.html`: component cha, danh sách mẫu, binding props, CSS và đăng ký component.
- `components/TheSanPham.js`: định nghĩa component dùng lại `<the-san-pham>`.
- `assets/vue.global.prod.js`, `assets/VUE-LICENSE.txt`: Vue và giấy phép dùng chung với bài 1.
- `assets/product-pen.svg`, `product-notebook.svg`, `product-mouse.svg`, `product-keyboard.svg`: ảnh minh họa cục bộ.
- `assets/product-placeholder.svg`: ảnh thay thế khi không truyền ảnh hoặc ảnh bị lỗi.

Giữ nguyên cấu trúc thư mục khi nộp để đường dẫn script và ảnh hoạt động. Các file bài 1 không bị sửa. Nút Mua ghi nhận lựa chọn trên từng thẻ; không trừ tồn kho hoặc tạo giỏ hàng vì bài 2 chưa yêu cầu các thao tác này.

### Đối chiếu đủ 8 yêu cầu của đề

| Yêu cầu | Cách thực hiện |
|---|---|
| 1. Cha quản lý ít nhất 4 sản phẩm | `data().products` trong `bai2.html` có 4 sản phẩm, ID 1–4, `v-for` với `:key="product.id"`. |
| 2. Con nhận tên, giá, ảnh, mô tả, tồn kho | Component khai báo 5 props `ten`, `gia`, `anh`, `moTa`, `soLuongTon`. Nội dung thẻ lấy từ props. |
| 3. Kiểu, bắt buộc, mặc định | Tên/ảnh/mô tả là `String`; giá/tồn là `Number`. Tên và giá `required: true`. Ảnh/mô tả/tồn có giá trị mặc định. Có validator kiểm tra tên không trắng, giá dương hữu hạn, tồn nguyên không âm. |
| 4. Binding dữ liệu cha xuống con | Cha dùng `:ten`, `:gia`, `:anh`, `:mo-ta`, `:so-luong-ton`; giá và tồn giữ kiểu Number. |
| 5. Nút bật/tắt mô tả và data riêng | Mỗi instance trả về `hienMoTa: false` trong `data()`. Nút Xem mô tả/Ẩn mô tả đổi trạng thái, `v-show` điều khiển nội dung. |
| 6. Các thẻ độc lập | Không dùng biến trạng thái dùng chung; mở nhiều thẻ được, đóng một thẻ không ảnh hưởng thẻ khác. ID làm key giữ đúng instance khi đổi thứ tự. |
| 7. Hết hàng có nhãn và khóa Mua | `conHang` kiểm tra tồn > 0; nhãn Còn hàng xanh/Hết hàng đỏ, `:disabled` khóa Mua. Method cũng kiểm tra trước khi ghi nhận lựa chọn. |
| 8. Tách file, nạp/đăng ký trước mount | Thứ tự: `vue.global.prod.js` → `components/TheSanPham.js` → `catalogApp.component('the-san-pham', TheSanPham)` → `catalogApp.mount('#app')`. |

### Dữ liệu mẫu

| ID | Tên | Giá (đồng) | Tồn | Nút Mua |
|---|---|---:|---:|---|
| 1 | Bút bi Thiên Long | 5.000 | 20 | Bật |
| 2 | Vở ô ly 200 trang | 12.000 | 0 | Khóa |
| 3 | Chuột không dây | 150.000 | 8 | Bật |
| 4 | Bàn phím cơ | 450.000 | 0 | Khóa |

### Hướng dẫn test thủ công

Nhấn F5 để đưa dữ liệu và trạng thái về ban đầu.

| Thao tác | Kết quả mong đợi |
|---|---|
| Mở bài | Đủ 4 thẻ, mỗi thẻ đúng tên/giá/ảnh/tồn; chưa có mô tả nào mở. |
| Nhấn Xem mô tả ở Bút | Chỉ mô tả Bút xuất hiện, nút đổi thành Ẩn mô tả. |
| Giữ Bút đang mở, mở thêm Chuột | Cả hai cùng mở; Vở và Bàn phím vẫn đóng. |
| Ẩn mô tả của Bút | Chỉ Bút đóng; Chuột vẫn mở. |
| Mở/ẩn nhiều lần cùng một thẻ | Nội dung và nhãn nút đổi đúng sau mỗi lần nhấn; không ảnh hưởng thẻ khác. |
| Mở mô tả Vở/Bàn phím | Vẫn xem được mô tả dù hết hàng. |
| Nhấn Mua ở Bút | Hiện `Đã chọn “Bút bi Thiên Long”.` ngay trên thẻ Bút. |
| Sau đó nhấn Mua ở Chuột | Hiện thông báo riêng trên Chuột; thông báo Bút vẫn giữ nguyên. |
| Thử nút Mua của Vở/Bàn phím | Nút mờ và có thuộc tính disabled, không thể chọn mua; không có thông báo mua. |
| Mua sản phẩm còn hàng rồi xem số lượng tồn | Tồn kho giữ nguyên; bài 2 chỉ minh họa lựa chọn sản phẩm. |
| F5 sau khi đã mở mô tả/chọn mua | Tất cả mô tả đóng, thông báo lựa chọn biến mất, dữ liệu mẫu trở lại. |
| Dùng Tab đến Xem mô tả, nhấn Enter hoặc Space | Bật/tắt được bằng bàn phím, trạng thái `aria-expanded` cập nhật. |
| Xem ở 320, 390, 768, 1440 px | Trang không tràn ngang; bố cục lần lượt 1, 1, 2, 4 cột. Mở mô tả không làm tràn trang. |
| Mở trực tiếp `bai2.html`, chuyển Offline rồi tải lại | Đủ component và ảnh; mô tả và nút Mua vẫn hoạt động. |
| DevTools → Console/Network | Không có lỗi JS, không thiếu script/ảnh, không tải tài nguyên từ CDN. |

### Kiểm tra nâng cao về props

Các thay đổi thử nghiệm dưới đây có thể làm trên bản sao, hoặc hoàn tác sau khi kiểm tra. Các props tùy chọn chỉ dùng default khi không truyền/giá trị là `undefined`; chuỗi ảnh/mô tả rỗng được xử lý bằng fallback bổ sung.

| Tình huống | Cách thử và kết quả mong đợi |
|---|---|
| Thiếu props tùy chọn | Tạm thêm `<the-san-pham ten="Mẫu mặc định" :gia="10000"></the-san-pham>` vào vùng `#app`: có ảnh thay thế, nhãn Hết hàng, Mua khóa; mở mô tả thấy “Sản phẩm chưa có mô tả.” |
| Ảnh rỗng hoặc đường dẫn sai | Thay `image` của một sản phẩm: hiện ảnh thay thế; các thẻ khác không đổi. Đường dẫn sai có thể tạo lỗi 404 trong Network do chính thao tác thử này. |
| Mô tả chỉ có khoảng trắng | Đổi `description` thành `'   '`: mở mô tả thấy nội dung mặc định. |
| Cha cập nhật dữ liệu | Trong mảng `products`, đổi tên/giá/ảnh/mô tả và tải lại: thẻ dùng đúng dữ liệu mới, không cần sửa template component. |
| Tồn kho 0 → 1 hoặc 1 → 0 | Đổi `stock` của một sản phẩm trong cha: nhãn và trạng thái Mua tương ứng còn/hết hàng. |
| Tên/mô tả có chuỗi HTML | Đặt tên `<b>Sản phẩm</b>` hoặc mô tả `<script>alert(1)</script>`: hiển thị nguyên văn, không thực thi HTML/script. |

`props` là hợp đồng dữ liệu, không phải form nhập liệu. Bản Vue production không in cảnh báo validator như bản development; khi chấm có thể đọc trực tiếp `type`, `required`, `default`, `validator` trong `components/TheSanPham.js`. Component không gán lại hoặc sửa props.

### Kết quả kiểm tra bài 2

Ngày 07/11/2026: **156/156 kiểm tra tự động đạt** trên Chromium 151.0.7922.34 qua Playwright Core có sẵn. Đã kiểm tra Apache/XAMPP HTTP 200 và mở trực tiếp khi offline.

Phạm vi: đủ 4 sản phẩm/5 props, kiểu/bắt buộc/mặc định/validator biên, ảnh và alt, mô tả độc lập, nút Mua/guard khi hết hàng, dữ liệu cha không bị sửa, cập nhật props theo thời gian chạy, key giữ trạng thái khi đảo thứ tự, fallback ảnh/mô tả, escape HTML, tải lại, bàn phím, kích thước 320–1440 px, thứ tự nạp/đăng ký/mount và offline. Đã xem ảnh desktop và mobile.

Không có lỗi/cảnh báo console, lỗi JavaScript hoặc request ngoài. Chưa kiểm tra Firefox/Safari. Script và ảnh kiểm tra tạm đã được dọn khỏi bài nộp.

## Bài 3 — Giỏ hàng với props và $emit

### Mở bài và các file cần nộp

Bật Apache trong XAMPP rồi mở **http://localhost/web/TH7/bai3.html**. Không cần MySQL hoặc build. Cũng có thể mở trực tiếp `bai3.html` khi offline.

Giữ cùng cấu trúc thư mục:

- `bai3.html`: component cha quản lý giỏ, nhận sự kiện, kiểm tra dữ liệu, tính tổng bằng computed.
- `components/DongGioHang.js`: component con `<dong-gio-hang>`, props, sự kiện và giao diện mỗi dòng.
- `assets/vue.global.prod.js`, `assets/VUE-LICENSE.txt`: Vue và giấy phép dùng chung.

Nhấn F5 để khôi phục giỏ mẫu. Dữ liệu không lưu sau khi tải lại trang vì đề không yêu cầu lưu trữ. Xóa thực hiện ngay khi nhấn nút Xóa; bài 3 không yêu cầu hộp xác nhận.

### Đối chiếu đủ 8 yêu cầu

| Yêu cầu | Cách thực hiện |
|---|---|
| 1. Mỗi mục có ID, tên, đơn giá, số lượng | `data().cartItems` ở cha gồm `id`, `name`, `price`, `quantity`. |
| 2. Con nhận props, hiện thành tiền và tăng/giảm/xóa | 4 props có kiểu và bắt buộc: `id`, `ten`, `donGia`, `soLuong`. `computed.thanhTien = donGia * soLuong`; có đủ 3 nút. |
| 3. Khai báo và phát đúng sự kiện/payload | `emits` khai báo `doi-so-luong` và `yeu-cau-xoa`. `$emit('doi-so-luong', this.id, soLuongMoi)` gửi 2 đối số; `$emit('yeu-cau-xoa', this.id)` gửi ID. |
| 4. Cha nhận và kiểm tra rồi cập nhật | `@doi-so-luong="doiSoLuong"`, `@yeu-cau-xoa="xoaSanPham"`; cha kiểm tra ID nguyên dương, ID tồn tại, số lượng hợp lệ rồi mới `map()`/`filter()` đúng ID. |
| 5. Số lượng nguyên 1–99 | Nút giảm khóa tại 1, nút tăng khóa tại 99. Ô nhập, method ở con, validator props/emits và method ở cha đều kiểm tra `Number.isInteger()` và giới hạn. Không dùng `parseInt()`. |
| 6. Con không sửa props/đối tượng từ props | Dùng props vô hướng; con chỉ emit. `v-model` gắn vào `data().soLuongNhap` riêng để nhập tạm; không gắn vào prop `soLuong`. Sau yêu cầu, ô nhập đồng bộ lại giá trị cha chấp nhận. |
| 7. Cha dùng computed tính hai tổng | `totalQuantity` cộng `quantity`; `totalMoney` cộng `price * quantity`; đều tự cập nhật khi tăng/giảm/nhập/xóa. |
| 8. Xóa hết hiện thông báo | `v-if`/`v-else` hiển thị chính xác “Giỏ hàng trống”; hai tổng đều bằng 0. |

### Dữ liệu mẫu đúng tình huống của đề

| ID | Sản phẩm | Đơn giá | Số lượng | Thành tiền |
|---|---|---:|---:|---:|
| 1 | Bút bi Thiên Long | 5.000đ | 2 | 10.000đ |
| 2 | Vở ô ly 200 trang | 12.000đ | 3 | 36.000đ |

**Tổng số lượng: 5. Tổng tiền: 46.000đ.**

### Hướng dẫn test bằng giao diện

Nhấn F5 trước mỗi nhóm để có lại dữ liệu mẫu. Khi nhập trực tiếp, nhấn Enter hoặc rời ô để áp dụng số mới.

#### 1. Tăng, giảm và hai biên

| Thao tác | Kết quả mong đợi |
|---|---|
| Mở bài | Có 2 dòng sản phẩm; tổng 5, tiền 46.000đ; thành tiền từng dòng như bảng trên. |
| Tăng Bút một lần | Bút = 3, thành tiền 15.000đ; tổng 6, tiền 51.000đ. Vở không đổi. |
| Giảm Bút một lần | Trở lại Bút = 2; tổng 5, tiền 46.000đ. |
| Giảm Bút từ 2 xuống 1 | Tổng 4, tiền 41.000đ; nút giảm của Bút bị khóa, không xuống 0. |
| Nhập Bút = 99 | Thành tiền Bút 495.000đ; tổng 102, tiền 531.000đ. Nút tăng của Bút bị khóa. |
| Giảm Bút từ 99 xuống 98 | Nút tăng hoạt động lại; tổng 101, tiền 526.000đ. |
| Nhập cả Bút và Vở = 99 | Tổng 198, tiền 1.683.000đ. Cả hai nút tăng bị khóa. |
| Nhập cả Bút và Vở = 1 | Tổng 2, tiền 17.000đ. Cả hai nút giảm bị khóa. |

#### 2. Nhập trực tiếp và dữ liệu sai

Nhấn F5. Nhập lần lượt các giá trị vào ô số lượng Bút.

| Giá trị/thao tác | Kết quả mong đợi |
|---|---|
| Rỗng, `0`, `-1`, `-0.5`, `1.5`, `100`, `999999999999` | Khi Enter/rời ô: báo “Số lượng phải là số nguyên từ 1 đến 99.”; trả ô nhập về số trước đó; dữ liệu và hai tổng không đổi. |
| Nhập liên tiếp nhiều giá trị sai khác nhau | Mỗi lần đều báo lỗi; không tự nhận số thập phân, không thay tổng và vẫn cho sửa nội dung ô bình thường. |
| Sau ca lỗi, nhập `4` rồi Enter | Lỗi biến mất; Bút = 4, thành tiền 20.000đ; tổng 7, tiền 56.000đ. |
| Nhấn F5, nhập `4` rồi dùng Tab rời ô | Kết quả giống Enter. |
| Nhập `1.0` | Nhận số nguyên 1; ô hiển thị 1. |
| Nhập `2e0` trên trình duyệt cho phép ký hiệu số mũ | Nhận số 2, ô hiển thị 2; chuỗi này biểu diễn số nguyên hợp lệ. |
| Nhấn F5, đang sửa Vở thành `6`, nhấn nút tăng của Vở | Nhận nội dung 6 khi rời ô rồi tăng thành 7; Bút vẫn 2; tổng 9, tiền 94.000đ. |
| Nhấn Tab tới nút tăng/giảm rồi Enter hoặc Space | Nút hoạt động như khi bấm chuột; giới hạn vẫn được giữ. |

#### 3. Xóa và giỏ trống

Nhấn F5 trước nhóm này.

| Thao tác | Kết quả mong đợi |
|---|---|
| Xóa Bút | Chỉ còn Vở = 3; tổng 3, tiền 36.000đ; có thông báo xóa đúng tên. |
| Xóa tiếp Vở | Hiện “Giỏ hàng trống”; không còn dòng/nút số lượng; tổng 0, tiền 0đ. |
| F5, xóa Vở trước | Chỉ còn Bút = 2; tổng 2, tiền 10.000đ. |
| Sau đó tăng Bút | Bút = 3; tổng 3, tiền 15.000đ. |
| Tải lại trang sau khi xóa hết | Khôi phục đúng 2 Bút + 3 Vở; tổng 5, tiền 46.000đ. |

### Kiểm tra nâng cao phía cha

Có thể dùng Console của DevTools để kiểm chứng method cha vẫn kiểm tra dữ liệu ngay cả khi nhận yêu cầu sai. Đoạn này chỉ dành cho kiểm thử, không phải thao tác sử dụng thông thường:

```javascript
const gio = document.querySelector('#app')._vnode.component.proxy;
gio.doiSoLuong(1, 1.5);  // Từ chối số lẻ, giữ dữ liệu và tổng.
gio.doiSoLuong(1, 0);    // Từ chối số nhỏ hơn 1.
gio.doiSoLuong(1, 100);  // Từ chối số lớn hơn 99.
gio.doiSoLuong(1, '2');  // Từ chối chuỗi; payload phải là số.
gio.doiSoLuong(1, NaN);  // Từ chối số không hợp lệ.
gio.doiSoLuong(1, Infinity); // Từ chối vô cực.
gio.doiSoLuong(999, 2);  // Từ chối ID không tồn tại.
gio.xoaSanPham(-1);     // Từ chối ID không hợp lệ.
gio.xoaSanPham(999);    // Từ chối ID không tồn tại.
gio.doiSoLuong(1, 99);  // Hợp lệ; cập nhật đúng Bút và xóa lỗi cũ.
```

Sau mỗi dòng bị từ chối, thông báo lỗi của cha xuất hiện nhưng giỏ không đổi. Cũng từ chối các payload số lượng `null`, `undefined`, boolean, object, array; ID sai kiểu hoặc ID đã bị xóa. Xóa lại ID cũ không xóa nhầm sản phẩm khác. Component con không được phép tự cập nhật props để bỏ qua kiểm tra này.

### Giao diện, offline và kết quả kiểm tra

- Kiểm tra ở 320, 390, 768 và 1440 px: không tràn ngang, đầy đủ ô nhập/nút và hai tổng. Trạng thái báo lỗi cũng không làm tràn trang.
- Mở trực tiếp `bai3.html`, chuyển trình duyệt sang Offline rồi tải lại: tăng/giảm/nhập/xóa và thông báo giỏ trống vẫn chạy.
- Console/Network không có lỗi JavaScript, lỗi tải tài nguyên hoặc request ngoài.

Ngày 07/11/2026: **368/368 kiểm tra tự động đạt** trên Chromium 151.0.7922.34, qua Apache/XAMPP HTTP 200 và mở file khi offline.

Đã kiểm tra đủ 99 giá trị số nguyên hợp lệ từ 1 đến 99; giá trị rỗng, âm, lẻ, vượt biên, sai kiểu, `NaN`/vô cực; nhập lỗi liên tiếp và sửa lại; Enter/Tab, thay đổi số đang nhập rồi nhấn nút; payload sự kiện chính xác; component độc lập chỉ emit và giữ nguyên props khi cha không cập nhật; cha tính tổng/kiểm tra ID; đảo thứ tự vẫn thao tác đúng ID; ID cũ/xóa lặp; giỏ trống; dữ liệu mẫu sau reload; escape tên HTML; bàn phím, mobile và offline.

Không có lỗi/cảnh báo console hoặc JavaScript; không có tài nguyên ngoài. Đã xem ảnh desktop/mobile. Chưa kiểm tra Firefox/Safari. Script và ảnh kiểm tra tạm đã được dọn khỏi bài nộp.
