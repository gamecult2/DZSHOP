<?php
session_start();
require_once 'backend/models/Product.php';

$cart_items = [];
$total_price = 0;
$productModel = new Product();

if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $productId => $quantity) {
        $product = $productModel->findById($productId);
        if ($product) {
            $product['quantity'] = $quantity;
            $cart_items[] = $product;
            $total_price += $product['price'] * $quantity;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="frontend/css/style.css">
    <link rel="stylesheet" href="frontend/css/cart.css">
</head>
<body>
    <header>
        <!-- Consistent header -->
    </header>

    <main class="cart-main">
        <h1>Your Shopping Cart</h1>
        <?php if (empty($cart_items)): ?>
            <p>Your cart is empty.</p>
        <?php else: ?>
            <div class="cart-container">
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cart_items as $item): ?>
                            <tr>
                                <td><?= htmlspecialchars($item['name_en']) ?></td>
                                <td><?= number_format($item['price'], 2) ?> DZD</td>
                                <td>
                                    <form action="backend/controllers/CartController.php?action=update" method="POST">
                                        <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
                                        <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="1" class="quantity-input">
                                        <button type="submit">Update</button>
                                    </form>
                                </td>
                                <td><?= number_format($item['price'] * $item['quantity'], 2) ?> DZD</td>
                                <td>
                                    <a href="backend/controllers/CartController.php?action=remove&product_id=<?= $item['id'] ?>">Remove</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="cart-summary">
                    <h3>Total: <?= number_format($total_price, 2) ?> DZD</h3>
                    <a href="checkout.php" class="checkout-btn">Proceed to Checkout</a>
                </div>
            </div>
        <?php endif; ?>
    </main>

    <footer>
        <!-- Consistent footer -->
    </footer>
</body>
</html>
