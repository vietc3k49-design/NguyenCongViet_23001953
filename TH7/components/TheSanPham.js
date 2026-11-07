// Component dùng lại được; dữ liệu sản phẩm nhận từ cha qua props.
const TheSanPham = {
    name: 'TheSanPham',
    props: {
        ten: {
            type: String,
            required: true,
            validator: value => value.trim().length > 0
        },
        gia: {
            type: Number,
            required: true,
            validator: value => Number.isFinite(value) && value > 0 && value <= Number.MAX_SAFE_INTEGER
        },
        anh: {
            type: String,
            default: 'assets/product-placeholder.svg'
        },
        moTa: {
            type: String,
            default: 'Sản phẩm chưa có mô tả.'
        },
        soLuongTon: {
            type: Number,
            default: 0,
            validator: value => Number.isSafeInteger(value) && value >= 0
        }
    },
    data() {
        // Mỗi instance có trạng thái riêng, không dùng biến chung hay sửa props.
        return {
            hienMoTa: false,
            thongBaoMua: '',
            loiAnh: false
        };
    },
    computed: {
        conHang() {
            return Number.isSafeInteger(this.soLuongTon) && this.soLuongTon > 0;
        },
        giaHopLe() {
            return Number.isFinite(this.gia) && this.gia > 0 && this.gia <= Number.MAX_SAFE_INTEGER;
        },
        giaHienThi() {
            if (!this.giaHopLe) return 'Giá chưa hợp lệ';
            const options = this.gia < 0.01
                ? { notation: 'scientific', maximumFractionDigits: 6 }
                : { maximumFractionDigits: 2 };
            return this.gia.toLocaleString('vi-VN', options) + ' ₫';
        },
        nguonAnh() {
            return this.loiAnh || !this.anh.trim() ? 'assets/product-placeholder.svg' : this.anh;
        },
        noiDungMoTa() {
            return this.moTa.trim() || 'Sản phẩm chưa có mô tả.';
        }
    },
    watch: {
        anh() {
            // Cho phép cha thay ảnh mới sau khi ảnh trước đó bị lỗi.
            this.loiAnh = false;
        }
    },
    methods: {
        muaSanPham() {
            // Guard bổ sung: gọi trực tiếp method cũng không mua được hàng hết.
            if (!this.conHang || !this.giaHopLe) return;
            this.thongBaoMua = 'Đã chọn “' + this.ten + '”.';
        }
    },
    template: `
        <article class="product-card">
            <div class="product-image">
                <img :src="nguonAnh" :alt="'Hình minh họa ' + ten" width="480" height="300"
                    @error="loiAnh = true">
                <span class="badge" :class="conHang ? 'in-stock' : 'out-of-stock'">
                    {{ conHang ? 'Còn hàng' : 'Hết hàng' }}
                </span>
            </div>
            <div class="product-content">
                <h2>{{ ten }}</h2>
                <p class="price">{{ giaHienThi }}</p>
                <p class="stock">{{ conHang ? 'Số lượng tồn: ' + soLuongTon : 'Sản phẩm hiện đã hết hàng.' }}</p>
                <div class="card-actions">
                    <button type="button" class="secondary description-toggle" :aria-expanded="hienMoTa"
                        @click="hienMoTa = !hienMoTa">{{ hienMoTa ? 'Ẩn mô tả' : 'Xem mô tả' }}</button>
                    <button type="button" class="buy-button" :disabled="!conHang || !giaHopLe"
                        :aria-label="'Mua ' + ten" @click="muaSanPham">Mua</button>
                </div>
                <p v-show="hienMoTa" class="description">{{ noiDungMoTa }}</p>
                <p v-if="thongBaoMua" class="purchase-notice" role="status">{{ thongBaoMua }}</p>
            </div>
        </article>
    `
};
