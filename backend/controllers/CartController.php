<?php
session_start();

require_once __DIR__ . '/../models/Product.php';

class CartController {
    public function __construct() {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['product_id'])) {
            header('Location: /index.php');
            exit();
        }

        $productId = (int)$_POST['product_id'];
        $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

        if ($quantity < 1) {
            $quantity = 1;
        }

        // Check if product exists
        $productModel = new Product();
        $product = $productModel->findById($productId);

        if (!$product) {
            header('Location: /index.php?error=product_not_found');
            exit();
        }

        // Add or update quantity in cart
        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId] += $quantity;
        } else {
            $_SESSION['cart'][$productId] = $quantity;
        }

        header('Location: /cart.php');
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['product_id'])) {
            exit('Invalid request.');
        }

        $productId = (int)$_POST['product_id'];
        $quantity = (int)$_POST['quantity'];

        if ($quantity > 0) {
            $_SESSION['cart'][$productId] = $quantity;
        } else {
            // Remove item if quantity is 0 or less
            unset($_SESSION['cart'][$productId]);
        }

        header('Location: /cart.php');
    }

    public function remove() {
        if (!isset($_GET['product_id'])) {
            exit('Invalid request.');
        }
        $productId = (int)$_GET['product_id'];
        unset($_SESSION['cart'][$productId]);
        header('Location: /cart.php');
    }
}

if (isset($_GET['action'])) {
    $controller = new CartController();
    $action = $_GET['action'];

    if (method_exists($controller, $action)) {
        $controller->$action();
    } else {
        http_response_code(404);
        echo "Action not found.";
    }
}
