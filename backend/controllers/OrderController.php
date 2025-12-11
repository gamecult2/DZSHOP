<?php
session_start();

require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../models/Product.php';

class OrderController {
    public function placeOrder() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_SESSION['cart'])) {
            header('Location: /checkout.php');
            exit();
        }

        // Basic validation
        $required_fields = ['first_name', 'last_name', 'email', 'phone', 'street_address', 'wilaya', 'commune', 'postal_code', 'payment_method'];
        foreach($required_fields as $field) {
            if (empty($_POST[$field])) {
                header('Location: /checkout.php?error=missing_fields');
                exit();
            }
        }

        $productModel = new Product();
        $cart_items_data = [];
        $total_price = 0;

        foreach ($_SESSION['cart'] as $productId => $quantity) {
            $product = $productModel->findById($productId);
            if ($product) {
                $cart_items_data[] = [
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'price' => $product['price']
                ];
                $total_price += $product['price'] * $quantity;
            }
        }

        if (empty($cart_items_data)) {
            header('Location: /cart.php?error=invalid_cart');
            exit();
        }

        $shipping_address_details = json_encode([
            'first_name' => $_POST['first_name'],
            'last_name' => $_POST['last_name'],
            'email' => $_POST['email'],
            'phone' => $_POST['phone'],
            'street_address' => $_POST['street_address'],
            'wilaya' => $_POST['wilaya'],
            'commune' => $_POST['commune'],
            'postal_code' => $_POST['postal_code']
        ]);

        $orderData = [
            'user_id' => isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null,
            'total_amount' => $total_price,
            'shipping_address_details' => $shipping_address_details,
            'payment_method' => $_POST['payment_method'],
            'items' => $cart_items_data
        ];

        $order = new Order();
        $orderId = $order->create($orderData);

        if ($orderId) {
            // Clear the cart
            unset($_SESSION['cart']);
            // Redirect to a success page
            header("Location: /order_success.php?order_id=" . $orderId);
        } else {
            header('Location: /checkout.php?error=order_failed');
        }
    }
}

if (isset($_GET['action'])) {
    $controller = new OrderController();
    $action = $_GET['action'];

    if (method_exists($controller, $action)) {
        $controller->$action();
    } else {
        http_response_code(404);
        echo "Action not found.";
    }
}
