<?php
require_once __DIR__ . '/../models/CartModel.php';
require_once __DIR__ . '/../models/OrderModel.php';

class CartController
{
    public function index()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: " . base_url('login'));
            exit;
        }

        $cartModel = new CartModel();
        $userId = $_SESSION['user']['UserID'];
        $cartItems = $cartModel->getCartItems($userId);

        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item['Price'] * $item['Quantity'];
        }

        include(__DIR__ . '/../views/cart/index.php');
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: " . base_url('cart'));
            exit;
        }

        if (!isset($_SESSION['user'])) {
            header("Location: " . base_url('login'));
            exit;
        }

        $productId = $_POST['id'] ?? null;
        $quantity = $_POST['quantity'] ?? 1;

        if ($productId) {
            $productModel = new ProductModel();
            $product = $productModel->getProductById($productId);

            if (!$product || $product['Stock'] <= 0) {
                $_SESSION['error'] = 'Цей товар недоступний';
                header("Location: " . base_url('cart'));
                exit;
            }

            $maxPerItem = 5;
            $cartModel = new CartModel();
            $userId = $_SESSION['user']['UserID'];

            $currentItem = $cartModel->getCartItemByUserAndProduct($userId, $productId);
            $currentQuantity = $currentItem ? (int)$currentItem['Quantity'] : 0;

            $quantity = max(1, min($quantity, $product['Stock'], $maxPerItem - $currentQuantity));

            if ($quantity > 0) {
                $cartModel->addToCart($userId, $productId, $quantity);
                $_SESSION['message'] = 'Товар додано до кошика!';
            } else {
                $_SESSION['error'] = 'Неможливо додати більше цього товару (макс. ' . $maxPerItem . ')';
            }
        } else {
            $_SESSION['error'] = 'Неправильний ID товару';
        }

        header("Location: " . base_url('cart'));
        exit;
    }

    public function update()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: " . base_url('login'));
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['quantity'])) {
            $cartModel = new CartModel();
            $productModel = new ProductModel();
            $userId = $_SESSION['user']['UserID'];

            foreach ($_POST['quantity'] as $cartId => $quantity) {
                $quantity = max(1, (int)$quantity);

                $item = $cartModel->getCartItemById($cartId);
                if ($item) {
                    $product = $productModel->getProductById($item['ProductID']);
                    $maxQuantity = min(5, $product['Stock']);

                    $quantity = min($quantity, $maxQuantity);
                    $cartModel->updateCartItem($cartId, $quantity);
                }
            }

            $_SESSION['message'] = 'Кошик оновлено!';
        }

        header("Location: " . base_url('cart'));
        exit;
    }

    public function remove($id)
    {
        if (!isset($_SESSION['user'])) {
            header("Location: " . base_url('login'));
            exit;
        }

        $cartModel = new CartModel();
        $cartModel->removeFromCart($id);

        $_SESSION['message'] = 'Товар видалено з кошика!';
        header("Location: " . base_url('cart'));
        exit;
    }

    public function clear()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: " . base_url('login'));
            exit;
        }

        $cartModel = new CartModel();
        $userId = $_SESSION['user']['UserID'];
        $cartModel->clearCart($userId);

        $_SESSION['message'] = 'Кошик очищено!';
        header("Location: " . base_url('cart'));
        exit;
    }

    public function checkout()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: " . base_url('login'));
            exit;
        }

        $cartModel = new CartModel();
        $orderModel = new OrderModel();
        $userId = $_SESSION['user']['UserID'];

        $cartItems = $cartModel->getCartItems($userId);

        if (empty($cartItems)) {
            $_SESSION['error'] = 'Кошик порожній, додайте товари!';
            header("Location: " . base_url('cart'));
            exit;
        }

        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item['Price'] * $item['Quantity'];
        }

        $orderId = $orderModel->createOrder($userId, $total, $cartItems);

        if ($orderId) {
            $cartModel->clearCart($userId);
            $_SESSION['message'] = 'Замовлення оформлено! Номер замовлення: ' . $orderId;
            header("Location: " . base_url('order/detail/' . $orderId));
            exit;
        } else {
            $_SESSION['error'] = 'Помилка при оформленні замовлення!';
            header("Location: " . base_url('cart'));
            exit;
        }
    }
}
