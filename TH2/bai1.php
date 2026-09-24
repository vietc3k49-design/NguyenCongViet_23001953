<?php
# 1. tạo class CartItem

class CartItem {
    public $name;
    public $price;
    public $quantity;

    public function __construct($name, $price, $quantity) {
        $this->name = $name;
        $this->price = $price;
        $this->quantity = $quantity;
    }

    public function getTotal() {
        return $this->price * $this->quantity;
    }
}

# 2. tạo class ShoppingCart

class ShoppingCart {
    private $items = [];

    public function addItem(CartItem $item) {
        if ($item->price <= 0) {
            echo "Lỗi: Giá của sản phẩm " . $item->name . " không hợp lệ\n";
            return false;
        }
        if ($item->quantity <= 0) {
            echo "Lỗi: Số lượng của sản phẩm " . $item->name . " không hợp lệ\n";
            return false;
        }
        $this->items[] = $item;
        return true;
    }

    public function removeItem($itemName) {
        foreach ($this->items as $key => $item) {
            if ($item->name === $itemName) {
                unset($this->items[$key]);
                return true;
            }
        }
        echo "Không tìm thấy sản phẩm " . $itemName . " trong giỏ hàng\n";
        return false;
    }

    public function calculateTotal() {
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item->getTotal();
        }
        return $total;
    }

    public function displayCart() {
        echo "Giỏ hàng" . "\n";
        foreach ($this->items as $item) {
            echo "sản phẩm: " . $item->name . "\n";
            echo "giá tiền: " . $item->price . "\n";
            echo "số lượng: " . $item->quantity . "\n";
            echo "tổng tiền: " . $item->getTotal() . "\n";
        }
        echo "tổng tiền giỏ hàng: " . $this->calculateTotal() . "\n" . "\n";
    }
}

#3. tạo đối tượng và hiển thị

$cart = new ShoppingCart();

$item1 = new CartItem("cam", 18000, 5);
$item2 = new CartItem("tao", 32000, 10);
$item3 = new CartItem("oi", 15000, 20);
$item4 = new CartItem("le", 20000, 15);

$cart->addItem($item1);
$cart->addItem($item2);
$cart->addItem($item3);
$cart->addItem($item4);

$cart->displayCart();


$cart->removeItem("tao");

$cart->displayCart();

$cart->removeItem("sau_rieng");

$cart->addItem(new CartItem("chuoi", -10000, 5));
$cart->addItem(new CartItem("dua_hau", 25000, 0));

$emptyCart = new ShoppingCart();
echo "Tổng tiền giỏ hàng rỗng: " . $emptyCart->calculateTotal() . "\n";

?>