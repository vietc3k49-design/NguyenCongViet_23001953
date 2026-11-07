const DongGioHang = {
    name: 'DongGioHang',
    props: {
        id: {
            type: Number,
            required: true,
            validator: value => Number.isSafeInteger(value) && value > 0
        },
        ten: {
            type: String,
            required: true,
            validator: value => value.trim().length > 0
        },
        donGia: {
            type: Number,
            required: true,
            validator: value => Number.isFinite(value) && value > 0
        },
        soLuong: {
            type: Number,
            required: true,
            validator: value => Number.isInteger(value) && value >= 1 && value <= 99
        }
    },
    // Khai báo rõ tên sự kiện và payload. Cha vẫn phải kiểm tra lại dữ liệu.
    emits: {
        'doi-so-luong': (id, soLuongMoi) => Number.isSafeInteger(id) && id > 0 &&
            Number.isInteger(soLuongMoi) && soLuongMoi >= 1 && soLuongMoi <= 99,
        'yeu-cau-xoa': id => Number.isSafeInteger(id) && id > 0
    },
    data() {
        // Bản nhập tạm thuộc con; số lượng chính thức luôn lấy từ prop của cha.
        return { soLuongNhap: String(this.soLuong), loiSoLuong: '' };
    },
    computed: {
        thanhTien() {
            return this.donGia * this.soLuong;
        }
    },
    watch: {
        soLuong() {
            this.soLuongNhap = String(this.soLuong);
            this.loiSoLuong = '';
        }
    },
    methods: {
        formatMoney(value) {
            return value.toLocaleString('vi-VN', { maximumFractionDigits: 2 }) + ' ₫';
        },
        yeuCauDoiSoLuong(soLuongMoi) {
            if (!Number.isInteger(soLuongMoi) || soLuongMoi < 1 || soLuongMoi > 99) {
                this.loiSoLuong = 'Số lượng phải là số nguyên từ 1 đến 99.';
                return;
            }
            this.loiSoLuong = '';
            // Không gán this.soLuong hoặc dùng v-model trực tiếp trên prop.
            this.$emit('doi-so-luong', this.id, soLuongMoi);
        },
        async nhapSoLuong(event) {
            // valueAsNumber trả NaN khi rỗng; không dùng parseInt làm mất phần lẻ.
            this.yeuCauDoiSoLuong(event.target.valueAsNumber);
            await this.$nextTick();
            // Đồng bộ ô nhập về số cha chấp nhận, cả khi giá trị nhập bị từ chối.
            this.soLuongNhap = String(this.soLuong);
        },
        yeuCauXoa() {
            this.$emit('yeu-cau-xoa', this.id);
        }
    },
    template: `
        <li class="cart-item">
            <div class="product-info">
                <h2>{{ ten }}</h2>
                <p class="unit-price">Đơn giá: {{ formatMoney(donGia) }}</p>
                <p class="product-id">Mã sản phẩm: {{ id }}</p>
            </div>
            <div class="quantity-field">
                <label :for="'quantity-' + id">Số lượng</label>
                <div class="quantity-controls">
                    <button type="button" class="secondary decrease" :disabled="soLuong <= 1"
                        :aria-label="'Giảm số lượng ' + ten" @click="yeuCauDoiSoLuong(soLuong - 1)">−</button>
                    <input :id="'quantity-' + id" class="quantity-input" type="number" v-model="soLuongNhap"
                        min="1" max="99" step="1" required :aria-label="'Số lượng ' + ten"
                        :aria-invalid="!!loiSoLuong" :aria-describedby="loiSoLuong ? 'quantity-error-' + id : 'quantity-help'"
                        @input="loiSoLuong = ''" @change="nhapSoLuong($event)"
                        @keydown.enter.prevent="$event.target.blur()">
                    <button type="button" class="secondary increase" :disabled="soLuong >= 99"
                        :aria-label="'Tăng số lượng ' + ten" @click="yeuCauDoiSoLuong(soLuong + 1)">+</button>
                </div>
                <p v-if="loiSoLuong" :id="'quantity-error-' + id" class="error" role="alert">{{ loiSoLuong }}</p>
            </div>
            <div class="subtotal-field">
                <span>Thành tiền</span>
                <strong class="subtotal">{{ formatMoney(thanhTien) }}</strong>
            </div>
            <button type="button" class="danger remove" :aria-label="'Xóa ' + ten" @click="yeuCauXoa">Xóa</button>
        </li>
    `
};
